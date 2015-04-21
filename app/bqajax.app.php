<?php
class BqajaxApp extends MallbaseApp
{
	/**
     *    直接到购物车
     *
     *    @author    Garbin
     *    @return    void
     */
    function to_shop()
    {
       $sku=$this->htmldecode($_GET['sku']);
	  
	   $sid= $_SESSION['store_id'];
	   
	   $sid=empty($sid)?0:$sid;
	   if($sid==0)
	   {
		  $this->show_warning('请选择本店！');
	   }
	   $sql="SELECT a.goods_id,a.spec_id,b.store_id,a.sku from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id =b.goods_id
where a.sku='".$sku."' and b.store_id=".$sid;

       $db=&db();
	   $all=$db->getAll($sql);
	   $spec_id =0;
	  
	   if(count($all))
	   {
		 $spec_id=$all[0]['spec_id'];
		
	   }else{
		  
		   $this->show_warning('亲，本店的网店没有此商品，请选择其他同类商品，谢谢！');
		   return;
	   }
	   
        //$spec_id   = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity   = 1;
		  $store_id   =$_SESSION['store_id'];
        if (!$spec_id || !$quantity|| !$store_id)
        {
			$this->show_warning('非法输入');
            return;
        }
        
        /* 是否有商品 */
        $spec_model =& m('goodsspec');
        $spec_info  =  $spec_model->get(array(
            'fields'        => 'g.store_id,g.cuxiao_ids, g.goods_id, g.goods_name, g.spec_name_1, g.spec_name_2, g.default_image, gs.spec_1, gs.spec_2, gs.stock, gs.price,gs.sku',
            'conditions'    => $spec_id,
            'join'          => 'belongs_to_goods',
        ));
        
        //判断该商品库存  begin
        if(count($spec_info) > 0){
            if($spec_info['stock'] < 1){
                $this->show_warning('该商品暂时缺货，无法购买！');
                return;
            }
        }
        //end

        if (!$spec_info)
        {
            $this->show_warning('商品不存在');
            /* 商品不存在 */
            return;
        }
       
        /* 如果是自己店铺的商品，则不能购买 */
        if ($this->visitor->get('manage_store'))
        {
            if ($spec_info['store_id'] == $this->visitor->get('manage_store'))
            {
                $this->show_warning('不能购买自己的商品');

                return;
            }
        }

        if ($quantity > $spec_info['stock'])
        {
            $this->show_warning('库存不足');
            return;
        }
        
        /* 是否添加过 */
        $model_cart =& m('cart');
        $item_info  = $model_cart->get("spec_id={$spec_id} AND session_id='" . SESS_ID . "'");
        if (!empty($item_info))
        {
          $this->yxwupdate($spec_id,$quantity);
        $spec_1 = $spec_info['spec_name_1'] ? $spec_info['spec_name_1'] . ':' . $spec_info['spec_1'] : $spec_info['spec_1'];
        $spec_2 = $spec_info['spec_name_2'] ? $spec_info['spec_name_2'] . ':' . $spec_info['spec_2'] : $spec_info['spec_2'];

        $specification = $spec_1 . ' ' . $spec_2;
		  /* 添加并返回购物车统计即可 */
        $cart_model =&  m('cart');
        $cart_model->add($cart_item);
        $cart_status = $this->_get_cart_status($store_id);


        header('Location:index.php?app=cart&act=index2');
        
        }else 
        {
        	$spec_1 = $spec_info['spec_name_1'] ? $spec_info['spec_name_1'] . ':' . $spec_info['spec_1'] : $spec_info['spec_1'];
        $spec_2 = $spec_info['spec_name_2'] ? $spec_info['spec_name_2'] . ':' . $spec_info['spec_2'] : $spec_info['spec_2'];

        $specification = $spec_1 . ' ' . $spec_2;

        /* 将商品加入购物车 */
        $cart_item = array(
            'user_id'       => $this->visitor->get('user_id'),
            'session_id'    => SESS_ID,
            'store_id'      => $spec_info['store_id'],
            'spec_id'       => $spec_id,
            'goods_id'      => $spec_info['goods_id'],
            'goods_name'    => addslashes($spec_info['goods_name']),
            'specification' => addslashes(trim($specification)),
            'price'         => $this->kx_price($spec_info),
            'quantity'      => $quantity,
            'goods_image'   => addslashes($spec_info['default_image']),
			'sku'           => $spec_info['sku'],
			'cuxiao_ids'           => $spec_info['cuxiao_ids'],
			'remains'       => $quantity,
			'is_sale'       => '0',
        );

        /* 添加并返回购物车统计即可 */
        $cart_model =&  m('cart');
        $cart_model->add($cart_item);
        $cart_status = $this->_get_cart_status($store_id);

        /* 更新被添加进购物车的次数 */
        $model_goodsstatistics =& m('goodsstatistics');
        $model_goodsstatistics->edit($spec_info['goods_id'], 'carts=carts+1');

          header('Location:index.php?app=cart&act=index2');
        }
        
    }
	//如果商品存在更新商品数量
	
	 function yxwupdate($spec_id,$quantity){
		
		// $spec_id  = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        //$quantity = isset($_GET['quantity'])? intval($_GET['quantity']): 0;
        if (!$spec_id || !$quantity)
        {
            /* 不合法的请求 */
            return;
        }

        /* 判断库存是否足够 */
        $model_spec =& m('goodsspec');
        $spec_info  =  $model_spec->get($spec_id);
        if (empty($spec_info))
        {
            /* 没有该规格 */
            $this->json_error('no_such_spec');
            return;
        }

        if ($quantity > $spec_info['stock'])
        {
            /* 数量有限 */
            $this->json_error('no_enough_goods');
            return;
        }

        /* 修改数量 */
        $where = "spec_id={$spec_id} AND session_id='" . SESS_ID . "'";
        $model_cart =& m('cart');
		

        /* 获取购物车中的信息，用于获取价格并计算小计 */
        $cart_spec_info = $model_cart->get($where);
        if (empty($cart_spec_info))
        {
            /* 并没有添加该商品到购物车 */
            return;
        }

        $store_id = $cart_spec_info['store_id'];

        /* 修改数量 */
        $model_cart->edit($where, array(
            'quantity'  =>  $quantity,
			'remains'  =>  $quantity,
			//'quantity'  =>  $quantity,
        )); 
	 }
   //判断商品是否是快讯促销商品，并查看促销状态
	function kx_price($spec_info)
	{
		
		//echo 'hejejejej';
		//exit();
		
		$db=&db();//第一步：赋值数据库类库
            //$db->query(sql);//执行mysql语句
		//$sql="select kuaixun_price from  ecm_kuaixun_promotion where kuaixun_state=2";
		$sql="select state,p_id,price,store_id from  ecm_kuaixun_promotion_v  where (unix_timestamp() between  start_time and end_time ) and  FIND_IN_SET('".$spec_info['store_id']."',store_id) and  state in (3) and goods_id=".$spec_info['goods_id'];
		$kx_state=$db->getAll($sql);
		
		//print_r($kx_state);
		//exit;

		if(count($kx_state) == 0){
			return $spec_info['price'];
		}
		$skeys = array_keys($kx_state);
		$kx_state = $kx_state[$skeys[0]];

		if(!empty($kx_state)){
			if($kx_state['state']==3){
			   return $kx_state['price'];
			}
			else 
			{
				 return $spec_info['price'];
			}
        }
		else
		{
			return $spec_info['price'];
		}
         // exit();
	}
	/**
     *    获取购物车状态
     *
     *    @author    Garbin
     *    @return    array
     */
    function _get_cart_status($store_id_cur=0)
    {
        /* 默认的返回格式 */
        $data = array(
            'status'    =>  array(
                'quantity'  =>  0,      //总数量
                'amount'    =>  0,      //总金额
                'kinds'     =>  0,      //总种类
		        'store_id'  =>  0,      //门店编号
				'totalcount'  =>  0,      //总数量
            ),
            'carts'     =>  array(),    //购物车列表，包含每个购物车的状态
        );

        /* 获取所有购物车 */
        $carts = $this->_get_carts();
        if (empty($carts))
        {
            return $data;
        }
        $data['carts']  =   $carts;
		if($store_id_cur==0){
			foreach ($carts as $store_id => $cart)
			{
				$data['status']['quantity'] += $cart['quantity'];
				$data['status']['amount']   += $cart['amount'];
				$data['status']['kinds']    += $cart['kinds'];
			    $data['status']['totalcount'] += $cart['quantity'];     //总数量
			}
		}else
		{
			foreach ($carts as $store_id => $cart)
			{
				if($store_id==$store_id_cur){
				$data['status']['quantity'] += $cart['quantity'];
				$data['status']['amount']   += $cart['amount'];
				$data['status']['kinds']    += $cart['kinds'];
				$data['status']['store_id']=$store_id_cur;
				}
				$data['status']['totalcount'] += $cart['quantity'];     //总数量
			}
		}
		

        return $data;
    }
	/**
     *    以购物车为单位获取购物车列表及商品项
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_carts($store_id = 0)
    {
        $carts = array();

        /* 获取所有购物车中的内容 */
        $where_store_id = $store_id ? ' AND cart.store_id=' . $store_id : '';

        /* 只有是自己购物车的项目才能购买 */
        $where_user_id = $this->visitor->get('user_id') ? " AND cart.user_id=" . $this->visitor->get('user_id') : '';
        $cart_model =& m('cart');
        $cart_items = $cart_model->find(array(
            'conditions'    => 'spec_id !=0 and  session_id = \'' . SESS_ID . "'" . $where_store_id . $where_user_id,
            'fields'        => 'this.*,store.store_name',
            'join'          => 'belongs_to_store',
        ));
        if (empty($cart_items))
        {
            return $carts;
        }
        $kinds = array();
        foreach ($cart_items as $item)
        {
            /* 小计 */
            $item['subtotal']   = $item['price'] * $item['quantity'];
            $kinds[$item['store_id']][$item['goods_id']] = 1;

            /* 以店铺ID为索引 */
            empty($item['goods_image']) && $item['goods_image'] = Conf::get('default_goods_image');
            $carts[$item['store_id']]['store_name'] = $item['store_name'];
            $carts[$item['store_id']]['amount']     += $item['subtotal'];   //各店铺的总金额
            $carts[$item['store_id']]['quantity']   += $item['quantity'];   //各店铺的总数量
            $carts[$item['store_id']]['goods'][]    = $item;
        }
        //$db=&db();
        foreach ($carts as $_store_id => $cart)
        {
            $carts[$_store_id]['kinds'] =   count(array_keys($kinds[$_store_id]));  //各店铺的商品种类数
			//$sql_shipping="select first_price from ecm_shipping where step_price=0 and enabled=1 and store_id= ".$_store_id." order by sort_order desc limit 0,1 ";
			$sql_shipping="select first_price from ecm_shipping where enabled=1 and store_id= ".$_store_id." order by sort_order desc limit 0,1 ";
			$carts[$_store_id]['shipping']=$cart_model->db->getOne($sql_shipping);
        }

        return $carts;
    }
    function htmldecode($str)  
      {  
      if(empty($str)) return;  
      if($str=="") return $str;  
      $str=str_replace("select","",$str);  
      $str=str_replace("join","",$str);  
      $str=str_replace("union","",$str);  
      $str=str_replace("where","",$str);  
      $str=str_replace("insert","",$str);  
      $str=str_replace("delete","",$str);  
      $str=str_replace("update","",$str);  
      $str=str_replace("like","",$str);  
      $str=str_replace("drop","",$str);  
      $str=str_replace("create","",$str);  
      $str=str_replace("modify","",$str);  
      $str=str_replace("rename","",$str);  
      $str=str_replace("alter","",$str);  
 
      return $str;  
      } 
}

?>