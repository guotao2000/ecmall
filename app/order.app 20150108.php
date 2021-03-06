<?php

/**
 *    售货员控制器，其扮演实际交易中柜台售货员的角色，你可以这么理解她：你告诉我（售货员）要买什么东西，我会询问你你要的收货地址是什么之类的问题
 *  并根据你的回答来生成一张单子，这张单子就是“订单”
 *
 *    @author    Garbin
 *    @param    none
 *    @return    void
 */
class OrderApp extends ShoppingbaseApp
{
    /**
     *    填写收货人信息，选择配送，支付方式。
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
	function __construct()
    {
        $this->OrderApp();
    }

    function OrderApp()
    {
        parent::__construct();
		$this->mod_msg =& m('msg');
		$this->mod_msglog =& m('msglog');
		$this->mod_address =& m('address');
    }
	 
    function index()
    {
	
	
        $goods_info = $this->_get_goods_info();
		
        if ($goods_info === false)
        {
            /* 购物车是空的 */
            $this->show_warning('goods_empty');

            return;
        }

        /*  检查库存 */
        $goods_beyond = $this->_check_beyond_stock($goods_info['items']);
        if ($goods_beyond)
        {
            $str_tmp = '';
            foreach ($goods_beyond as $goods)
            {
                $str_tmp .= '<br /><br />' . $goods['goods_name'] . '&nbsp;&nbsp;' . $goods['specification'] . '&nbsp;&nbsp;' . Lang::get('stock') . ':' . $goods['stock'];
            }
            $this->show_warning(sprintf(Lang::get('quantity_beyond_stock'), $str_tmp));
            return;
        }
        
        if (!IS_POST)
        {
				unset($_SESSION['shipping']);
		       unset($_SESSION['coupon']);
			   if(!empty($_SESSION['store_id']))
			   {
				   //echo $_SESSION['store_id'];
				   $this->assign("store_id",$_SESSION['store_id']);
			   }
			  
            //列出用户的收获地址  by Summer 2014-12-19  begin
            $conditions = 'user_id=' . $this->visitor->get('user_id');
            $address_arr = $this->mod_address->find(array(
                'conditions' => $conditions
            ));
            $address_num = count($address_arr);
			$db = &db();
			if($address_num > 0){
				$sql_str = "select * from ecm_address where user_id=" . $this->visitor->get('user_id') . " and enable=1";
				$res_arr = $db->getAll($sql_str);
				foreach($res_arr as $v){
					$res_info = $v;
				}	
				$this->assign('address_info', $res_info);
			}
			
			
            //end
            /* 根据商品类型获取对应订单类型 */
            $goods_type     =&  gt($goods_info['type']);
            $order_type     =&  ot($goods_info['otype']);
            
            /* 显示订单表单 */
            $form = $order_type->get_order_form($goods_info['store_id']);
			
            if ($form === false)
            {
                $this->show_warning($order_type->get_error());

                return;
            }
            $this->_curlocal(
                LANG::get('create_order')
            );
            $this->_config_seo('title', Lang::get('confirm_order') . ' - ' . Conf::get('site_title'));
			
			import('init.lib');
			$this->assign('coupon_list', Init_OrderApp::get_available_coupon($goods_info['store_id']));

			$this->assign('coupon_count', count(Init_OrderApp::get_available_coupon($goods_info['store_id'])));
			//exit();
            
            $this->assign('goods_info', $goods_info);
		
			$store_id=isset($_GET['store_id'])?intval($_GET['store_id']):0;
			
		  $form['data']['shipping_methods']=$this->_get_shipping($store_id,$res_info['region_id']);
		
		  
		  	$sql_count="select sum(quantity) from ecm_cart where store_id=".$store_id." and session_id='" . SESS_ID ."'";       $form['data']['totalcount']=$db->getOne($sql_count);
			
            $this->assign($form['data']);
            $this->display($form['template']);
        }
        else
        {
			//判断是否来自手机
				$is_mob = confirm_src();
			if(!$is_mob){
				/* 购物车是空的 *////pcindex/index.htm
				//$this->show_warning('请用手机访问网站，谢谢合作！！请关注微信号，倍全商城！');
				header('Location:/pcindex/index.htm');

				return;
			}
            /* 在此获取生成订单的两个基本要素：用户提交的数据（POST），商品信息（包含商品列表，商品总价，商品总数量，类型），所属店铺 */
            $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
            if ($goods_info === false)
            {
                /* 购物车是空的 */
                $this->show_warning('goods_empty');

                return;
            }
            /* 红包数据处理 */
            if ($goods_info['allow_coupon'] && isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn']))
            {
                $coupon_sn = trim($_POST['coupon_sn']);
                $coupon_mod =& m('couponsn');
                $coupon = $coupon_mod->get(array(
                    'fields' => 'coupon.*,couponsn.remain_times',
                    'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' ",//AND coupon.stores_allow = " . $store_id,
                    'join'  => 'belongs_to_coupon'));
                if (empty($coupon))
                {
                    $this->show_warning('involid_couponsn');
                    exit;
                }
				$sids=array_filter(explode(",",$coupon['stores_allow']));
				$boolvid=false;
				foreach($sids as $vid)
				{
					if($vid==$store_id)
					{
						$boolvid=true;
					}
				}
				if(!$boolvid)
				{
					$this->show_warning('此优惠券不适用于此店铺！');
                    exit;
				}
                if ($coupon['remain_times'] < 1)
                {
                    $this->show_warning("times_full");
                    exit;
                }
                $time = gmtime();
                if ($coupon['start_time'] > $time)
                {
                    $this->show_warning("coupon_time");
                    exit;
                }

                if ($coupon['end_time'] < $time)
                {
                    $this->show_warning("coupon_expired");
                    exit;
                }
                if ($coupon['min_amount'] > $goods_info['amount'])
                {
                    $this->show_warning("amount_short");
                    exit;
                }
                unset($time);
                $goods_info['discount'] = $coupon['coupon_value'];
            }
            /* 根据商品类型获取对应的订单类型 */
            $goods_type =& gt($goods_info['type']);
            $order_type =& ot($goods_info['otype']);

            /* 将这些信息传递给订单类型处理类生成订单(你根据我提供的信息生成一张订单) */
            $order_id = $order_type->submit_order(array(
                'goods_info'    =>  $goods_info,      //商品信息（包括列表，总价，总量，所属店铺，类型）,可靠的!
                'post'          =>  $_POST,           //用户填写的订单信息
                'uin'           =>  $_COOKIE["uin"],
            ));


            if (!$order_id)
            {
                $this->show_warning($order_type->get_error());

                return;
            }

            /*  检查是否添加收货人地址  */
            if (isset($_POST['save_address']) && (intval(trim($_POST['save_address'])) == 1))
            {
                 $data = array(
                    'user_id'       => $this->visitor->get('user_id'),
                    'consignee'     => trim($_POST['consignee']),
                    'region_id'     => $_POST['region_id'],
                    'region_name'   => $_POST['region_name'],
                    'address'       => trim($_POST['address']),
                    'zipcode'       => trim($_POST['zipcode']),
                    'phone_tel'     => trim($_POST['phone_tel']),
                    'phone_mob'     => trim($_POST['phone_mob']),
                );
                $model_address =& m('address');
                $model_address->add($data);
            }
            /* 下单完成后清理商品，如清空购物车，或将团购拍卖的状态转为已下单之类的 */
            $this->_clear_goods($order_id);

            /* 发送邮件 */
            $model_order =& m('order');

            /* 减去商品库存 */
            $model_order->change_stock('-', $order_id);
			
			//新增
			$model_order->change_seckill_stock('-', $order_id);

            /* 获取订单信息 */
            $order_info = $model_order->get($order_id);

            /* 发送事件 */
            $feed_images = array();
            foreach ($goods_info['items'] as $_gi)
            {
                $feed_images[] = array(
                    'url'   => SITE_URL . '/' . $_gi['goods_image'],
                    'link'  => SITE_URL . '/' . url('app=goods&id=' . $_gi['goods_id']),
                );
            }
            $this->send_feed('order_created', array(
                'user_id'   => $this->visitor->get('user_id'),
                'user_name' => addslashes($this->visitor->get('user_name')),
                'seller_id' => $order_info['seller_id'],
                'seller_name' => $order_info['seller_name'],
                'store_url' => SITE_URL . '/' . url('app=store&id=' . $order_info['seller_id']),
                'images'    => $feed_images,
            ));

            $buyer_address = $this->visitor->get('email');
            $model_member =& m('member');
            $member_info  = $model_member->get($goods_info['store_id']);
            $seller_address= $member_info['email'];



        //$order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
           /* 查出最新的相应的货号 */
        $model_spec =& m('goodsspec');
        $spec_info = $model_spec->find(array(
            'conditions'    => $spec_ids,
            'fields'        => 'sku',
        ));
        $order_info = $model_order->get(array(

            //'fields'        => "",

            'conditions'    => "order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'),

            'join'          => 'belongs_to_store',

            ));

			$order_detail = $order_type->get_order_detail($order_id, $order_info);

			$str_goods='';

			$str_add='';

			$str_name='';

			$str_phone='';

			$str_shipping='';
		

			$return_str='';

        foreach ($order_detail['data']['goods_list'] as $key => $goods)

        {

            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
			$order_detail['data']['goods_list'][$key]['sku'] = $spec_info[$goods['spec_id']]['sku'];

			$str_goods=$str_goods.'<li id=goods_name>'.$order_detail['data']['goods_list'][$key]['goods_name'].'　数量:'.$order_detail['data']['goods_list'][$key]['quantity'].'　单价:￥'.$order_detail['data']['goods_list'][$key]['price'].'　商品编号:'.$order_detail['data']['goods_list'][$key]['sku'].'</li>';

        }

		/*:'.$order_detail['data']['goods_list'][$key]['quantity'].'单价:'.$order_detail['data']['goods_list'][$key]['price'].'</li>';

		foreach ($order_detail['data']['order_extm'] as $key => $order_extm)

        {}*/

           $str_add='收货地址:'.$order_detail['data']['order_extm']['region_name'].$order_detail['data']['order_extm']['address'] ;

			$str_phone_tel='电话:'.$order_detail['data']['order_extm']['phone_tel'];

			$str_phone_mob='手机:'.$order_detail['data']['order_extm']['phone_mob'];

			$str_name='名字:'.$order_detail['data']['order_extm']['consignee'];

			$str_shipping='配送方式:'.$order_detail['data']['order_extm']['shipping_name'];

		   // $str_content='购物备注:'.$order_info['data']['postscript'];

		$return_str='顾客详细:<br>'.$str_name.'('.$str_phone_mob.$str_phone_tel.')<br>物品清单:'.$str_goods.'<br>'.$str_add.'<br>'.$str_shipping;

		

/*

 

echo $return_str;

$s1 = each($goods); 

print_r($s1);

$this->assign($order_detail['data']);*/
			

            /* 发送给买家下单通知 */
            $buyer_mail = get_mail('tobuyer_new_order_notify', array('order' => $order_info));
            $this->_mailto($buyer_address, addslashes($buyer_mail['subject']), addslashes($buyer_mail['message']));

            /* 发送给卖家新订单通知 */
            $seller_mail = get_mail('toseller_new_order_notify', array('order' => $order_info,'response'=>$return_str));
            $this->_mailto($seller_address, addslashes($seller_mail['subject']), addslashes($seller_mail['message']));
			$this->_mailto($mail_master, addslashes($seller_mail['subject']), addslashes($seller_mail['message']));

            /* 更新下单次数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $goods_ids = array();
            foreach ($goods_info['items'] as $goods)
            {
                $goods_ids[] = $goods['goods_id'];
            }
            $model_goodsstatistics->edit($goods_ids, 'orders=orders+1');
			
			
			//发送短信给买家 by 1hao5 team
			$user_id = $order_info['seller_id'];
			$user_name = $order_info['seller_name'];
			$row_msg = $this->mod_msg->getrow("select * from ".DB_PREFIX."msg where user_id=".$user_id);
			$mobile = $row_msg['mobile']; //手机号
			$smsText = "您收到了来自买家".$order_info['buyer_name']."的订单，订单号为：".$order_info['order_sn']."，请及时处理！";//内容
			$time = time();
			
			$checked_functions = $functions = array();
            $functions = $this->_get_functions();
            $tmp = explode(',', $row_msg['functions']);
            if ($functions)
            {
                foreach ($functions as $func)
                {
                    $checked_functions[$func] = in_array($func, $tmp);
                }
            }
			
			if($row_msg['state']==0)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($checked_functions['buy'] != 1)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($row_msg['num']<=0)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($mobile == '')
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($smsText == '')
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			$url='http://utf8.sms.webchinese.cn/?Uid='.SMS_UID.'&Key='.SMS_KEY.'&smsMob='.$mobile.'&smsText='.$smsText; 
			$res = $this->Sms_Get($url);
			if($res == '')
			{
            	header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			else if($res>0)
			{
				$num = $row_msg['num']-1;
				$edit_msg = array(
					'num' => $num,
				);
				$add_msglog = array(
					'user_id' => $user_id,
					'user_name' => $user_name,
					'to_mobile' => $mobile,
					'content' => $smsText,
					'state' => $res,
					'time' => $time,
				);
				$this->mod_msglog->add($add_msglog);
				$this->mod_msg->edit('user_id='.$user_id,$edit_msg);
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			else
			{
				$add_msglog = array(
					'user_id' => $user_id,
					'user_name' => $user_name,
					'to_mobile' => $mobile,
					'content' => $content,
					'state' => $res,
					'time' => $time,
				);
				$this->mod_msglog->add($add_msglog);
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
        }
    }

    /**
     *    获取外部传递过来的商品
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function _get_goods_info()
    {
        $return = array(
            'items'     =>  array(),    //商品列表
            'quantity'  =>  0,          //商品总量
            'amount'    =>  0,          //商品总价
            'store_id'  =>  0,          //所属店铺
            'store_name'=>  '',         //店铺名称
            'type'      =>  null,       //商品类型
            'otype'     =>  'normal',   //订单类型
            'allow_coupon'  => true,    //是否允许使用红包
        );
        switch ($_GET['goods'])
        {
            case 'groupbuy':
                /* 团购的商品 */
                $group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
                $user_id  = $this->visitor->get('user_id');
                if (!$group_id || !$user_id)
                {
                    return false;
                }
                /* 获取团购记录详细信息 */
                $model_groupbuy =& m('groupbuy');
                $groupbuy_info = $model_groupbuy->get(array(
                    'join'  => 'be_join, belong_store, belong_goods',
                    'conditions'    => $model_groupbuy->getRealFields("groupbuy_log.user_id={$user_id} AND groupbuy_log.group_id={$group_id} AND groupbuy_log.order_id=0 AND this.state=" . GROUP_FINISHED),
                    'fields'    => 'store.store_id, store.store_name, goods.goods_id, goods.goods_name, goods.default_image, groupbuy_log.quantity, groupbuy_log.spec_quantity, this.spec_price',
                ));

                if (empty($groupbuy_info))
                {
                    return false;
                }

                /* 库存信息 */
                $model_goodsspec = &m('goodsspec');
                $goodsspec = $model_goodsspec->find('goods_id='. $groupbuy_info['goods_id']);

                /* 获取商品信息 */
                $spec_quantity = unserialize($groupbuy_info['spec_quantity']);
                $spec_price    = unserialize($groupbuy_info['spec_price']);
                $amount = 0;
                $groupbuy_items = array();
                $goods_image = empty($groupbuy_info['default_image']) ? Conf::get('default_goods_image') : $groupbuy_info['default_image'];
                foreach ($spec_quantity as $spec_id => $spec_info)
                {
                    $the_price = $spec_price[$spec_id]['price'];
                    $subtotal = $spec_info['qty'] * $the_price;
                    $groupbuy_items[] = array(
                        'goods_id'  => $groupbuy_info['goods_id'],
                        'goods_name'  => $groupbuy_info['goods_name'],
                        'spec_id'  => $spec_id,
                        'specification'  => $spec_info['spec'],
                        'price'  => $the_price,
                        'quantity'  => $spec_info['qty'],
                        'goods_image'  => $goods_image,
                        'subtotal'  => $subtotal,
                        'stock' => $goodsspec[$spec_id]['stock'],
                    );
                    $amount += $subtotal;
                }

                $return['items']        =   $groupbuy_items;
                $return['quantity']     =   $groupbuy_info['quantity'];
                $return['amount']       =   $amount;
                $return['store_id']     =   $groupbuy_info['store_id'];
                $return['store_name']   =   $groupbuy_info['store_name'];
                $return['type']         =   'material';
                $return['otype']        =   'groupbuy';
                $return['allow_coupon'] =   false;
            break;
            default:
                /* 从购物车中取商品 */
                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
                $store_id = $_GET['store_id'];
                if (!$store_id)
                {
                    return false;
                }


                $cart_model =& m('cart');

                $cart_items      =  $cart_model->find(array(
                    'conditions' => "user_id = " . $this->visitor->get('user_id') . " AND store_id = {$store_id} AND session_id='" . SESS_ID . "'",
                    'join'       => 'belongs_to_goodsspec',
                ));
				
				$keys = array_keys($cart_items);
				
				for($i=0;$i<count($cart_items);$i++)
				{
					$spec_id=$cart_items[$keys[$i]]['goods_id'];
				
				   if(empty($spec_id))
					{
						continue;
					}
					
					$sql_str = "select a.*, c.price from ecm_kuaixun_promotion a LEFT JOIN ecm_goods b on a.goods_id = b.goods_id LEFT JOIN ecm_goods_spec c on a.goods_id=c.goods_id where b.goods_id=" . $spec_id . " order by a.add_time desc";
					$result = $cart_model->db->getRow($sql_str);
					
					if(count($result) > 0){
						
						$now = gmtime();
					
						if ($now >= $result['start_time'] && $now <= $result['end_time']){
							$cart_items[$keys[$i]]['price']=$result['kuaixun_price'];
						}
						
					}
					
				}
				
                if (empty($cart_items))
                {
                    return false;
                }
               

                $store_model =& m('store');
                $store_info = $store_model->get($store_id);

                foreach ($cart_items as $rec_id => $goods)
                {
                    $return['quantity'] += $goods['quantity'];                      //商品总量
                    $return['amount']   += $goods['quantity'] * $goods['price'];    //商品总价
                    $cart_items[$rec_id]['subtotal']    =   $goods['quantity'] * $goods['price'];   //小计
                    empty($goods['goods_image']) && $cart_items[$rec_id]['goods_image']=Conf::get('default_goods_image');
                }

				$string_cuxiaoids=array();
                 foreach ($cart_items as $rec_id => $goods)
                {
					 $goods_id=$goods['cuxiao_ids'];
					 if(!empty( $goods_id))
				     {
                      $string_cuxiaoids[]= $goods['cuxiao_ids'];  //拼接所有的促销id
					 }
                }
				
				if(count($string_cuxiaoids)>0){
				
                $return['amount']=$this->cuxiao_total($store_id);
				
				}
				$_SESSION['amount']=$return['amount']>0?$return['amount']:0;
				
                $return['items']        =   $cart_items;
                $return['store_id']     =   $store_id;
                $return['store_name']   =   $store_info['store_name'];
				$return['store_im_qq']  =   $store_info['im_qq']; // tyioocom 
                $return['type']         =   'material';
                $return['otype']        =   'normal';
            break;
        }

        return $return;
	}
        //计算促销商品价格
        function cuxiao_total($store_id)
		{
			   $db=&db();
             //1、清空sessionid，store_id对应的促销商品销售表
               $sql_cxspxs="delete from ecm_promotion_sale where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
               $db->query($sql_cxspxs);
			  //2、用购物车商品数量还原购物车的剩余数量，
			   $sql_upcart="update ecm_cart set remains=quantity  where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
               $db->query($sql_upcart);
			 //3、遍历所有满足的促销，分别取判断组合A和组合B是否满足
			   $cart_model =& m('cart');

                $cart_items      =  $cart_model->find(array(
                    'conditions' => " store_id = {$store_id} AND session_id='" . SESS_ID . "'",
                    'join'       => 'belongs_to_goodsspec',
                ));
				if (empty($cart_items))
                {
                    return false;
                }
				$string_cuxiaoids=array();
                 foreach ($cart_items as $rec_id => $goods)
                {
					 $arr_ids=explode(",", $goods['cuxiao_ids']);
					 foreach ($arr_ids as $value) {
						 if(!empty( $value)){
						  $string_cuxiaoids[]= $value;  //拼接所有的促销id
						 }
						}
                 }
				
            
				$arr_cuxiaoids=array_unique($string_cuxiaoids);//array_filter(explode(",",array_unique($string_cuxiaoids)),array($this,"myfunction"));
				
				//按照权重排序
              $arr_cuxiaoids= $this-> weight_order($db,$arr_cuxiaoids);
             
			 //4、在遍历算法内，将满足促销的商品数量从购物车减去插入促销商品表内。
			    for($j=0;$j<count($arr_cuxiaoids);$j++)
				{
					
					$bool_a=0;
                    $bool_b=0;
					$agoods_id=array();//存放符合条件的goods_id
					$anum=array();//存放符合条件的num数量
                    $sql_state="select * from ecm_discount_promotion where discount_id=".$arr_cuxiaoids[$j]." and discount_state=2 and (unix_timestamp() between  start_time and end_time )";
				   $get_state=$db->getRow($sql_state);
				   
					if(empty($get_state))
					{
						continue;
					}
                    $sql_a="select * from ecm_pattern_a where p_type='1' and cuxiao_id=".$arr_cuxiaoids[$j];
                    $que1=$db->getAll($sql_a);
					for($i=0;$i<count($que1);$i++)
					{
					   //判断商品A组单品是否满足促销需求
                        if( $this->cart_num($cart_items,$que1[$i]['goods_id'],$que1[$i]['promotion_num']))
						{
                             $bool_a++;
						}

					}
					$sql_b="select * from ecm_pattern_a where p_type='2' and cuxiao_id=".$arr_cuxiaoids[$j];
					$que2=$db->getAll($sql_b);
					for($i=0;$i<count($que2);$i++)
					{
				        //判断商品A组单品是否满足促销需求
                        if( $this->cart_num($cart_items,$que2[$i]['goods_id'],$que2[$i]['promotion_num']))
						{
                             $bool_b++;
						}

					}
                  
					if($bool_a==count($que1)&&$bool_b==count($que2))
					{
					 //5、遍历此促销的所有商品，更新购物车商品数
                       for($i=0;$i<count($que1);$i++)
						{
				
                          $cart_items=$this->cart_remain($db,$cart_items,$que1[$i]['goods_id'],$que1[$i]['promotion_num'],$que1[$i]['cuxiao_id'],$que1[$i]['promotion_price'],$store_id);
						}
                        for($i=0;$i<count($que2);$i++)
						{
						 $cart_items=$this->cart_remain($db,$cart_items,$que2[$i]['goods_id'],$que2[$i]['promotion_num'],$que2[$i]['cuxiao_id'],$que2[$i]['promotion_price'],$store_id);
						}

			           

					}

				}
			 
			 //7、计算总价

			 return $this-> total($db,$store_id);

		}
		//权重排序
		function weight_order($db,$arr_cuxiaoids)
	    {
			
         $string_in="select discount_id from ecm_discount_promotion where discount_id in (". implode(",",$arr_cuxiaoids).") order by weight_factor desc";
		 $arr_idrows= $db->getAll($string_in);
		     $i=0;
		    foreach($arr_idrows as $key=>$value)
			{
                $arr_ids[$i]=$value['discount_id'];
				$i++;
			}

		 return $arr_ids;
	    }
		//计算总价
		function total($db,$store_id)
        {
			//计算购物车总价
            $total_count=0;
            $string_cart="select * from ecm_cart where store_id = {$store_id} AND session_id='" . SESS_ID . "' and remains>0";
			$arr_cart=$db->getAll($string_cart);
            foreach ($arr_cart as $key=>$value)//$value是购物车单项
			{
              $total_count+=  $value["price"]*$value["remains"];
			}
			//echo $total_count;
			//计算促销商品销售总价
			$string_promotion="select * from ecm_promotion_sale where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
			$arr_promotion=$db->getAll($string_promotion);
            foreach ($arr_promotion as $key=>$value)//$value是购物车单项
			{
              $total_count+=  $value["sale_price"]*$value["sale_num"];
			}
            // echo $total_count;
             //返回总价
			 return $total_count;
			

		 }

		//更新购物车相应商品的remains字段值,$goods_id促销商品里的商品id，$num促销商品里的促销商品数量
		function cart_remain($db,$cart_items,$goods_id,$num,$promotion_id,$promotion_price,$store_id)
		{
			
            foreach ($cart_items as $key=>$value)//$value是购物车单项
			{
				
			    if($value["goods_id"]==$goods_id&&$value["remains"]>=$num)
				{
					$value["remains"]=$value["remains"]-$num;
					$string_update="update ecm_cart set remains=remains-".$num." where  store_id = {$store_id} AND session_id='" . SESS_ID . "' and goods_id={$goods_id};";
                    $db->query($string_update);
					$string_insert="insert into ecm_promotion_sale(promotion_id,goods_id,goods_sn,goods_name,sale_price,sale_num,user_id,session_id,sale_flag,store_id) values( {$promotion_id} ,{$goods_id} ,'{$value['sku']}','{$value['goods_name']}',{$promotion_price},{$num},{$value['user_id']},'" . SESS_ID . "',0,{$store_id})";
                
			//	echo $string_update.$string_insert;
				     $db->query($string_insert);
				  
                    return $cart_items;
				}
			}
			return $cart_items;

		}
       //查找购物车指定商品的数量
	    function cart_num($cart_items,$goods_id,$num)
		{
           foreach ($cart_items as $key=>$value)
			{
			     if($value["goods_id"]==$goods_id&&$value["remains"]>=$num)
				{
                    return true;
				}
			}
			return false;
		}



		
		

    /**
     *    下单完成后清理商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function _clear_goods($order_id)
    {
        switch ($_GET['goods'])
        {
            case 'groupbuy':
                /* 团购的商品 */
                $model_groupbuy =& m('groupbuy');
                $model_groupbuy->updateRelation('be_join', intval($_GET['group_id']), $this->visitor->get('user_id'), array(
                    'order_id'  => $order_id,
                ));
            break;
            default://购物车中的商品
                /* 订单下完后清空指定购物车 */
                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
                $store_id = $_GET['store_id'];
                if (!$store_id)
                {
                    return false;
                }
                $model_cart =& m('cart');
                $model_cart->drop("store_id = {$store_id} AND session_id='" . SESS_ID . "'");
                //红包信息处理
                if (isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn']))
                {
                    $sn = trim($_POST['coupon_sn']);
                    $couponsn_mod =& m('couponsn');
                    $couponsn = $couponsn_mod->get("coupon_sn = '{$sn}'");
                    if ($couponsn['remain_times'] > 0)
                    {
                        $couponsn_mod->edit("coupon_sn = '{$sn}'", "remain_times= remain_times - 1");
                    }
                }
            break;
        }
    }
    /**
     * 检查红包有效性
     */
    function check_coupon()
    {
        $coupon_sn = $_GET['coupon_sn'];
        $store_id = is_numeric($_GET['store_id']) ? $_GET['store_id'] : 0;
        if (empty($coupon_sn))
        {
            $this->js_result(false);
        }
        $coupon_mod =& m('couponsn');
        $coupon = $coupon_mod->get(array(
            'fields' => 'coupon.*,couponsn.remain_times',
            'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' AND coupon.store_id = " . $store_id,
            'join'  => 'belongs_to_coupon'));
        if (empty($coupon))
        {
            $this->json_result(false);
            exit;
        }
        if ($coupon['remain_times'] < 1)
        {
            $this->json_result(false);
            exit;
        }
        $time = gmtime();
        if ($coupon['start_time'] > $time)
        {
            $this->json_result(false);
            exit;
        }


        if ($coupon['end_time'] < $time)
        {
            $this->json_result(false);
            exit;
        }

        // 检查商品价格与红包要求的价格

        $model_cart =& m('cart');
        $item_info  = $model_cart->find("store_id={$store_id} AND session_id='" . SESS_ID . "'");
        $price = 0;
        foreach ($item_info as $val)
        {
            $price = $price + $val['price'] * $val['quantity'];
        }
        if ($price < $coupon['min_amount'])
        {
            $this->json_result(false);
            exit;
        }
        $this->json_result(array('res' => true, 'price' => $coupon['coupon_value']));
        exit;

    }

    function _check_beyond_stock($goods_items)
    {
        $goods_beyond_stock = array();
        foreach ($goods_items as $rec_id => $goods)
        {
            if ($goods['quantity'] > $goods['stock'])
            {
                $goods_beyond_stock[$goods['spec_id']] = $goods;
            }
        }
        return $goods_beyond_stock;
    }
	
	//添加筛选短信筛选函数 by andcpp
	function _get_functions()
    {
        $arr = array();        
        $arr[] = 'buy'; //来自买家下单通知   
        $arr[] = 'send'; //卖家发货通知买家   
		$arr[] = 'check';//来自买家确认通知   
        return $arr;
    }
	//end
	
	//获取配送方式
	function _get_shipping($store_id,$region_id)
	{
		//print_r($region_id);
		
		$db=&db();
		$rool=true;
		$rid=$region_id;
		//echo "--".$rid."--";
		while(isset($rid)){
			$sql_parent="select parent_id from ecm_region where region_id=".$rid;
			$pa[]=$rid;
			$rows_parent=$db->getOne($sql_parent);
			if($rows_parent==null)
			{
				$rool=false;
				break;
				
			}else
			{
				
				$pa[]=$rows_parent;//['parent_id'];
				$rid=$rows_parent;//['parent_id'];
				
			}
		}
		//print_r($pa);
		//exit();
		//$spa=implode(",",$pa);
		$sql="select * from ecm_shipping where enabled=1 and store_id=".$store_id." and  cod_regions <> ''  order by sort_order desc";
		$rows=$db->getAll($sql);
		for($i=0;$i<count($rows);$i++)
		{
			$regions=array_filter(unserialize($rows[$i]['cod_regions']));
					
		    $rows[$i]['cod_regions']=$regions;
			
			$rows[$i]['pa']=$pa;
		}
		
		//print_r($rows);
		$rows =array_filter($rows,array($this,"myfunction"));
		//print_r($rows);
		//exit();
		for($i=0;$i<count($rows);$i++)
		{
			$regions=$rows[$i]['cod_regions'];
					
		    $rows[$i]['cod_regions']=implode(",",$regions);
			
			$rows[$i]['pa']=$pa;
		}
		
		return $rows;
		
	}
	       //排除数组中的空元素
		function myfunction($v) 
		{
			$pa=$v['pa'];

			for($i=0;$i<count($pa);$i++)
			{

			if (in_array($pa[$i],array_keys($v['cod_regions'])))
				{
				return true;
				}
			}
			return false;
		}
	
	
	//获取红包控制器
	function coupon()
	{
		$result=array(
		'result'=>0,//红包校验失败
		'amount'=>0,//红包可用金额
		
		
		);
		$coupon_id=isset($_GET['coupon_id'])?intval($_GET['coupon_id']):0;//$this->json_result
		$store_id=isset($_GET['store_id'])?intval($_GET['store_id']):0;
		if(!$coupon_id) {
			$result['result']=0;
			$this->json_result($result,"校验失败！");
			$result['status']=0;
			exit();
			}
		
		$sql_coupon="select a.*,coupon_sn from ecm_coupon a left join ecm_coupon_sn b on a.coupon_id=b.coupon_id   where coupon_sn=".$coupon_id;//stores_allow
		$db=&db();
		//$this->mod_carts= & m('coupon');
		$row_coupon=$db->getRow($sql_coupon);
		if(!count($row_coupon))
		{
			$result['result']=0;
			$result['status']=1;
			$this->json_result($result,"校验失败！");
			exit();
		}
		else
		{
			//print_r($row_coupon);
			$arr_sids=array_filter(explode(",",$row_coupon['stores_allow']));
			
			for($i=0;$i<count($arr_sids);$i++)
			{
				if($arr_sids[$i]==$store_id)
				{
					break;
				}
				if(trim($arr_sids[$i])=='0')
				{
					break;
				}
				if($i==count($arr_sids)-1)
				{
					$result['result']=0;
					$result['status']=2;
					$this->json_result($result,"校验失败！");
					exit();
				}
			}
		}
		$sql_cart="select b.*,a.price cprice,a.quantity from ecm_cart a left join ecm_goods b on a.goods_id=b.goods_id where a.session_id='". SESS_ID ."' and a.store_id= ".$store_id;
		//$this->cuxiao_total($store_id);
		$rows_goods=$db->getAll($sql_cart);
		//筛选符合红包使用条件的商品
		$rows_goods=array_filter($rows_goods,array($this,"mycart_coupon"));
		if(!count($rows_goods))
		{
			$result['result']=0;
			$result['status']=3;
			$this->json_result($result,"校验失败！");
			exit();
		}else
		{
			foreach($rows_goods as $v)
			{
				$totalcount+=$v['cprice']*$v['quantity'];
			}
			if($totalcount>=$row_coupon['min_amount'])
			{
				$_SESSION["coupon"]=$row_coupon['coupon_value'];
			$result['result']=1;
			$result['amount']=$row_coupon['coupon_value'];
			$shipcount=isset($_SESSION['shipping'])?$_SESSION['shipping']:0;
			$result['total']=$_SESSION['amount']-$result['amount']+$shipcount;
			$result['total']=$result['total']>0?$result['total']:0;
			$result['shipping']=$shipcount;
			$result['coupon_sn']=$row_coupon['coupon_sn'];
			$this->json_result($result,"校验失败！");
			exit();
			}else
			{
			$result['result']=0;
			$result['status']=4;
			$this->json_result($result,"校验失败！");
			exit();
			}
		}
		
	}
	//筛选符合条件的红包
	function mycart_coupon($v)
	{
		$coupon_cids=array_filter(explode(",",$row_coupon['cate_noallow']));
		$cateids[]=$v['cate_id_1'];
		$cateids[]=$v['cate_id_2'];
		$cateids[]=$v['cate_id_3'];
		$cateids[]=$v['cate_id_4'];
		$cateids=array_filter($cateids);
		$arr_insc=array_intersect($cateids,$coupon_cids);
		if(count($arr_insc)>0)
		{
			return false;
		}
		return true;
		
	}
	
	//计算邮费
	function shipping()
	{
		$shipping_id=isset($_GET['shipping_id'])?intval($_GET['shipping_id']):0;//$this->json_result
		$store_id=isset($_GET['store_id'])?intval($_GET['store_id']):0;
		if(!($shipping_id*$store_id))
		{
			$result['result']=0;
			$result['status']=1;
			$this->json_result($result,"校验失败！");
			exit();
		}
		$sql_ship="select * from ecm_shipping where shipping_id=".$shipping_id." and enabled=1 and store_id=".$store_id;
		$db=&db();
		$row_ship=$db->getRow($sql_ship);
		if(!count($row_ship))
		{
			$result['result']=0;
			$result['status']=2;
			$this->json_result($result,"校验失败！");
			exit();
		}
		$sql_cart="select b.*,a.price cprice,a.quantity from ecm_cart a left join ecm_goods b on a.goods_id=b.goods_id where a.session_id='". SESS_ID ."' and a.store_id= ".$store_id;
		//$this->cuxiao_total($store_id);
		$rows_goods=$db->getAll($sql_cart);
		
		foreach($rows_goods as $v)
		{
			$totalcount+=$v['cprice']*$v['quantity'];
		}
		if($totalcount<$row_ship['first_price'])
		{
			$result['result']=1;
			$result['status']=3;
			$result['amount']=$row_ship['step_price'];
			$result['totalcount']=$totalcount;
			$_SESSION['shipping']=$result['amount'];
			
			$coupon=isset($_SESSION['coupon'])?$_SESSION['coupon']:0;
			$result['coupon']=$coupon;
			$result['total']=$_SESSION['amount']-$coupon+$row_ship['step_price'];
			$result['total']=$result['total']>0?$result['total']:0;
			$this->json_result($result,"校验成功！");
			exit();
		}else
		{
			$result['result']=1;
			$result['status']=4;
			$result['amount']=0;
			$result['totalcount']=$totalcount;
				$_SESSION['shipping']=$result['amount'];
			$coupon=isset($_SESSION['coupon'])?$_SESSION['coupon']:0;
			$result['total']=$_SESSION['amount']-$coupon+0;
			$result['total']=$result['total']>0?$result['total']:0;
			$result['coupon']=$coupon;
			$this->json_result($result,"校验成功！");
			exit();
		}
		
	}
	
}
?>
