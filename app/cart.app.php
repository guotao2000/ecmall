<?php

/**
 *    购物车控制器，负责会员购物车的管理工作，她与下一步售货员的接口是：购物车告诉售货员，我要买的商品是我购物车内的商品
 *
 *    @author    Garbin
 */

class CartApp extends MallbaseApp
{
    /**
     *    列出购物车中的商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function index()
    {
        $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		if($store_id == 0){
			$store_id = $_SESSION['store_id'];	
		}
        $carts = $this->_get_carts($store_id);
        $this->_curlocal(
            LANG::get('cart')
        );
        $this->_config_seo('title', Lang::get('confirm_goods') . ' - ' . Conf::get('site_title'));

        if (empty($carts))
        {
            $this->_cart_empty();

            return;
        }
		
		/*  tyioocom  感兴趣的商品 */
		$goods_mod = &m('goods');
		$gst_mod = &m('goodsstatistics');
		$interest = $goods_mod->find(array(
		   'conditions'=>'',
		   'join'=>'has_goodsstatistics',
		   'order' => 'views desc,collects desc, sales desc',
		   'fields' =>'g.goods_id,goods_name,price,sales,default_image',
		   'limit'=>6
		));
		$like_arr = array_chunk($interest, 2, true);
		$this->assign('interest',$like_arr);
		/* end */		

        $this->assign('carts', $carts);
        $this->assign('store_id', $store_id);
		$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
		$this->assign('rgoods',$rgoods);
		
	 
        $this->display('cart.index.html');
    }
	function index2()
    {
		
        $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		if(isset($_GET['sid']))
		{$_SESSION['store_id']=intval($_GET['sid']);}
		/*if($store_id == 0){
			$store_id = $_SESSION['store_id'];	
		}*/
        $carts = $this->_get_carts($store_id);
        $this->_curlocal(
            LANG::get('cart')
        );
        $this->_config_seo('title', Lang::get('confirm_goods') . ' - ' . Conf::get('site_title'));

       
		
		/*  tyioocom  感兴趣的商品 */
		$goods_mod = &m('goods');
		$gst_mod = &m('goodsstatistics');
		$interest = $goods_mod->find(array(
		   'conditions'=>'',
		   'join'=>'has_goodsstatistics',
		   'order' => 'views desc,collects desc, sales desc',
		   'fields' =>'g.goods_id,goods_name,price,sales,default_image',
		   'limit'=>6
		));
		$like_arr = array_chunk($interest, 2, true);
		$this->assign('interest',$like_arr);
		/* end */		

        $this->assign('carts', $carts);

		$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
		$this->assign('rgoods',$rgoods);
		include 'weixinyxw.php';
	    $jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage', $signPackage);
        $this->display('cart.indexyxw.html');
    }

    /**
     *    放入商品(根据不同的请求方式给出不同的返回结果)
     *
     *    @author    Garbin
     *    @return    void
     */
    function add()
    {
        $spec_id   = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity   = isset($_GET['quantity']) ? intval($_GET['quantity']) : 0;
        if (!$spec_id || !$quantity)
        {
            return;
        }

        /* 是否有商品 */
        $spec_model =& m('goodsspec');
        $spec_info  =  $spec_model->get(array(
            'fields'        => 'g.if_seckill,g.cuxiao_ids,g.store_id, g.goods_id, g.goods_name, g.spec_name_1, g.spec_name_2, g.default_image, gs.spec_1, gs.spec_2, gs.stock, gs.price,gs.sku',
            'conditions'    => $spec_id,
            'join'          => 'belongs_to_goods',
        ));

        if (!$spec_info)
        {
            $this->json_error('no_such_goods');
            /* 商品不存在 */
            return;
        }

        /* 如果是自己店铺的商品，则不能购买 */
        if ($this->visitor->get('manage_store'))
        {
            if ($spec_info['store_id'] == $this->visitor->get('manage_store'))
            {
                $this->json_error('can_not_buy_yourself');

                return;
            }
        }

        /* 是否添加过 */
        $model_cart =& m('cart');
        $item_info  = $model_cart->get("spec_id={$spec_id} AND session_id='" . SESS_ID . "'");
		
        if (!empty($item_info))
        {
            $this->json_error('goods_already_in_cart');
            return;
        }

        if ($quantity > $spec_info['stock'])
        {
            $this->json_error('no_enough_goods');
            return;
        }

       $spec_1 = $spec_info['spec_name_1'] ? $spec_info['spec_name_1'] . ':' . $spec_info['spec_1'] : $spec_info['spec_1'];
        $spec_2 = $spec_info['spec_name_2'] ? $spec_info['spec_name_2'] . ':' . $spec_info['spec_2'] : $spec_info['spec_2'];

        $specification = $spec_1 . ' ' . $spec_2;
		/*//原有秒杀
		if($spec_info['if_seckill'] == 1){
        	$seckill_mod = & m('seckill');
        	$seckill_price = $seckill_mod->get(array(
        	    'conditions' => 'goods_id='.$spec_info['goods_id'].' AND sec_state='.SECKILL_START,
        	    'fields' => 'sec_price'
        	));
        	$seckill_price['sec_price'] = unserialize($seckill_price['sec_price']);
        	$seckill_price['sec_price'] = empty($seckill_price['sec_price']) ? array() : $seckill_price['sec_price'];
        	foreach ($seckill_price['sec_price'] as $sec_key=>$sec_val){
        		$sec_price = $sec_val['price'];
        		break;
        	}
        }
		
		//杨秀伟测试使用开始
		echo '|';
		print_r($spec_info['price']);
		echo '|';
		print_r(serialize($spec_info['price']));
		echo '|';
		print_r(unserialize($spec_info['price']));
		exit();
		//杨秀伟测试使用结束
         */
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
			'cuxiao_ids'    => $spec_info['cuxiao_ids'],
			'remains'       => $quantity,
			'is_sale'       => '0',
        );

        /* 添加并返回购物车统计即可 */
        $cart_model =&  m('cart');
        $cart_model->add($cart_item);
		
        $cart_status = $this->_get_cart_status();

        /* 更新被添加进购物车的次数 */
        $model_goodsstatistics =& m('goodsstatistics');
        $model_goodsstatistics->edit($spec_info['goods_id'], 'carts=carts+1');

        $this->json_result(array(
            'cart'      =>  $cart_status['status'],  //返回购物车状态
        ), 'addto_cart_successed');
    }
	
    
        /**
     *    直接到购物车
     *
     *    @author    Garbin
     *    @return    void
     */
    function to_shop()
    {

        if(!empty($_COOKIE['openid'])&&strlen($_COOKIE['openid'])>20)
        {
           $sql_uid="SELECT user_id from ecm_member where user_name='".$_COOKIE['openid']."' ";
           $db=&db();
           $user_id=$db->getOne($sql_uid);
           if(!empty($user_id))
            {
               
                $this->_do_login($user_id);
            }
        }


        $spec_id   = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity   = isset($_GET['quantity']) ? intval($_GET['quantity']) : 0;
		  $store_id   = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        if (!$spec_id || !$store_id)
        {
            return;
        }
		
        
        /* 是否有商品 */
        $spec_model =& m('goodsspec');
        $spec_info  =  $spec_model->get(array(
            'fields'        => 'g.if_show,g.store_id,g.cuxiao_ids, g.goods_id, g.goods_name, g.spec_name_1, g.spec_name_2, g.default_image, gs.spec_1, gs.spec_2, gs.stock, gs.price,gs.sku',
            'conditions'    => $spec_id,
            'join'          => 'belongs_to_goods',
        ));
        
        //判断该商品库存  begin
        if(count($spec_info) > 0){
            if($spec_info['stock'] < 1){
                $this->json_error('该商品暂时缺货，无法购买！');
                return;
            }
        }
        //end
		//判断该商品库存  begin
        if(count($spec_info) > 0){
            if($spec_info['if_show'] < 1){
                $this->json_error('该商品暂时下架，无法购买！');
                return;
            }
        }
        //end

        if (!$spec_info)
        {
            $this->json_error('no_such_goods');
            /* 商品不存在 */
            return;
        }
       
        /* 如果是自己店铺的商品，则不能购买 */
        if ($this->visitor->get('manage_store'))
        {
            if ($spec_info['store_id'] == $this->visitor->get('manage_store'))
            {
                $this->json_error('can_not_buy_yourself');

                return;
            }
        }

        if ($quantity > $spec_info['stock'])
        {
            $this->json_error('no_enough_goods');
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
		if(!$quantity)
		{
			$sql="DELETE from ecm_cart where spec_id=".$spec_id." and session_id='".SESS_ID."' and store_id=".$store_id."";
			$cart_model->db->query($sql);
		}else{
			$cart_model->add($cart_item);
		}
       
        $cart_status = $this->_get_cart_status($store_id);


        $this->json_result(array(
            'cart'      =>  $cart_status['status'],  //返回购物车状态
        ), 'addto_cart_successed');
        
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

        $this->json_result(array(
            'cart'      =>  $cart_status['status'],  //返回购物车状态
        ), 'addto_cart_successed');
        }
        
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
     *    丢弃商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function drop()
    {
        /* 传入rec_id，删除并返回购物车统计即可 */
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            return;
        }
		//$store_id_cur=isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		//if (!$store_id_cur)
        //{
          //  return;
       // }

        /* 从购物车中删除 */
        $model_cart =& m('cart');
        $droped_rows = $model_cart->drop('rec_id=' . $rec_id . ' AND session_id=\'' . SESS_ID . '\' ', 'store_id');
        if (!$droped_rows)
        {
            return;
        }
		
        /* 返回结果 */
        $dropped_data = $model_cart->getDroppedData();
        $store_id     = $dropped_data[$rec_id]['store_id'];
        $cart_status = $this->_get_cart_status($store_id );
		$sql_count="select sum(quantity) from ecm_cart where session_id='" . SESS_ID ."'";
		$totalcount=$model_cart->db->getOne($sql_count);
		if(empty($totalcount))
		{
			 $this->json_result(array(
		    'totalcount'=>0,
            'cart'  =>  $cart_status['status'],                      //返回总的购物车状态
            'amount'=>  $cart_status['carts'][$store_id]['amount']   //返回指定店铺的购物车状态
              ),'drop_item_successed');
		}
		else{
        $this->json_result(array(
		   'totalcount'=>$totalcount,
            'cart'  =>  $cart_status['status'],                      //返回总的购物车状态
            'amount'=>  $cart_status['carts'][$store_id]['amount']   //返回指定店铺的购物车状态
        ),'drop_item_successed');}
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

    /**
     *    更新购物车中商品的数量，以商品为单位，AJAX更新
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function update()
    {
        $spec_id  = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity = isset($_GET['quantity'])? intval($_GET['quantity']): 0;
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

        /* 小计 */
        $subtotal   =   $quantity * $cart_spec_info['price'];

        /* 返回JSON结果 */
        $cart_status = $this->_get_cart_status();
        $this->json_result(array(
            'cart'      =>  $cart_status['status'],                     //返回总的购物车状态
            'subtotal'  =>  $subtotal,                                  //小计
            'amount'    =>  $cart_status['carts'][$store_id]['amount']  //店铺购物车总计
        ), 'update_item_successed');
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
     *    购物车为空
     *
     *    @author    Garbin
     *    @return    void
     */
    function _cart_empty()
    {
		$goods_mod = &m('goods');
		$gst_mod = &m('goodsstatistics');
		$interest = $goods_mod->find(array(
		   'conditions'=>'',
		   'join'=>'has_goodsstatistics',
		   'order' => 'views desc,collects desc, sales desc',
		   'fields' =>'g.goods_id,goods_name,price,sales,default_image',
		   'limit'=>6
		));
		$this->assign('interest',$interest);
        $this->display('cart.empty.html');
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
            'conditions'    => 'spec_id !=0 and  session_id = \'' . SESS_ID . "'" . $where_store_id ,
            'fields'        => 'this.*,store.store_name',
            'join'          => 'belongs_to_store',
        ));
        if (empty($cart_items))
        {
            return $carts;
        }
        $kinds = array();
		$db = & db();
        foreach ($cart_items as $item)
        {
			
            $shichang = $db->getOne("select shichang from ecm_goods_spec where goods_id=".$item['goods_id']);
            $item['shichang'] = $shichang;
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
	
	 /* 取得推荐商品 */
    function _get_recommended_goods( $num = 4)
    {
        $goods_mod =& m('goods');

		$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0 AND g.recommended = 1 ' ,
            	'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => $num,
        	));
		
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }
	

}

?>
