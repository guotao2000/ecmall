<?php

/**
 *    买家的订单管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class Buyer_orderApp extends MemberbaseApp
{
	 function __construct()
    {
        $this->Buyer_orderApp();
    }

    function Buyer_orderApp()
    {
        parent::__construct();
		$this->mod_msg =& m('msg');
		$this->mod_msglog =& m('msglog');
    }
    function index()
    {
        /* 获取订单列表 */
        $this->_get_orders();

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


        /* 显示订单列表 */
        $this->display('buyer_order.index.html');
    }
    /**
     *    查看订单详情
     *
     *    @author    Garbin
     *    @return    void
     */
    function view()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $model_order =& m('order');
        //$order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        $order_info = $model_order->get(array(
            'fields'        => "*, order.add_time as order_add_time",
            'conditions'    => "order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'),
            'join'          => 'belongs_to_store',
            ));
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 团购信息 */
        if ($order_info['extension'] == 'groupbuy')
        {
            $groupbuy_mod = &m('groupbuy');
            $group = $groupbuy_mod->get(array(
                'join' => 'be_join',
                'conditions' => 'order_id=' . $order_id,
                'fields' => 'gb.group_id',
            ));
            $this->assign('group_id',$group['group_id']);
        }

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('view_order'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');

        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('order_detail'));

        /* 调用相应的订单类型，获取整个订单详情数据 */
        $order_type =& ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
        }
		
		//获取订单中商品数量
		$goods_quantity = 0;
		foreach($order_detail['data']['goods_list'] as $key => $val){
			if(is_array($val)){
				$goods_quantity += $val['quantity'];	
			}
		}
		$this->assign('goods_quantity', $goods_quantity);
		
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('buyer_order.view.html');
    }

    /**
     *    取消订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function cancel_order()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        /* 只有待付款的订单可以取消 */
        $order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status in(11,12,20) ");
        if (empty($order_info))
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('buyer_order.cancel.html');
        }
        else
        {
            $model_order->edit($order_id, array('status' => ORDER_CANCELED));

            if ($model_order->has_error())
            {
                $this->pop_warning($model_order->get_error());

                return;
            }
              

            /* 加回商品库存 */
            $model_order->change_stock('+', $order_id);
            $cancel_reason = (!empty($_POST['remark'])) ? $_POST['remark'] : $_POST['cancel_reason'];
            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_CANCELED),
                'remark'    => $cancel_reason,
                'log_time'  => gmtime(),
            ));

            /* 发送给卖家订单取消通知 */
            $model_member =& m('member');
            $seller_info   = $model_member->get($order_info['seller_id']);
            $mail = get_mail('toseller_cancel_order_notify', array('order' => $order_info, 'reason' => $_POST['remark']));
            $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_canceled'),
                'actions'   => array(), //取消订单后就不能做任何操作了
            );

            $this->pop_warning('ok');
        }

    }
	

	//取消订单操作开始  begin
	function cancel_order_new(){
		//获取传过来的值
		$order_id = isset($_GET['order_id'])? intval($_GET['order_id']):0;
		$reason = isset($_GET['reason'])? trim($_GET['reason']):'';
		$remark = isset($_GET['remark'])? trim($_GET['remark']):'';	
		
		if (!$order_id)
        {
            $this->json_error(Lang::get('no_such_order'));
            return;
        }
        $model_order    =&  m('order');
        /* 只有待付款的订单可以取消 */
		$order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status in(11,12,10) ");
        if (empty($order_info))
        {
            //$this->json_error(Lang::get('no_such_order'));
			$this->json_error('订单状态不对,无法取消订单!');
            return;
        }
		
		$model_order->edit($order_id, array('status' => ORDER_CANCELED));
        if ($model_order->has_error())
        {
            $this->json_error($model_order->get_error());
            return;
        }

        /* 加回商品库存 */
        $model_order->change_stock('+', $order_id);
        $cancel_reason = ($remark != 'null_data') ? $remark : $reason;
        /* 记录订单操作日志 */
        $order_log =& m('orderlog');
        $order_log->add(array(
            'order_id'  => $order_id,
            'operator'  => addslashes($this->visitor->get('user_name')),
            'order_status' => order_status($order_info['status']),
            'changed_status' => order_status(ORDER_CANCELED),
            'remark'    => $cancel_reason,
            'log_time'  => gmtime(),
        ));

        /* 发送给卖家订单取消通知 */
        $model_member =& m('member');
        $seller_info   = $model_member->get($order_info['seller_id']);
        $mail = get_mail('toseller_cancel_order_notify', array('order' => $order_info, 'reason' => $remark));
        $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

        $new_data = array(
        	'status'    => Lang::get('order_canceled'),
            'actions'   => array(), //取消订单后就不能做任何操作了
        );

        $this->json_result(array('result' => 'ok'));
	}
	//end


    /**
     *    确认订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function confirm_order()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        /* 只有已发货的订单可以确认 */
        $order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status in(13,30)");
        if (empty($order_info))
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('buyer_order.confirm.html');
        }
        else
        {
            $model_order->edit($order_id, array('status' => 40, 'finished_time' => gmtime()));
            if ($model_order->has_error())
            {
                $this->pop_warning($model_order->get_error());

                return;
            }

            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_FINISHED),
                'remark'    => Lang::get('buyer_confirm'),
                'log_time'  => gmtime(),
            ));

	/*商付通v2.2.1  更新商付通定单状态 确认收货 开始*/
	$my_money_mod =& m('my_money');
	$my_moneylog_mod =& m('my_moneylog');
	$my_moneylog_row=$my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog where order_id='$order_id' and s_and_z=2 and caozuo=20");
	//$money=$my_moneylog_row['money'];//定单价格
	$money = $order_info['goods_amount'];
	$sell_user_id=$my_moneylog_row['seller_id'];//卖家ID
	if($my_moneylog_row['order_id']==$order_id)
	{
		$buy_user_id = $this->visitor->get('user_id');
		$sell_money_row=$my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$sell_user_id'");
		$buy_money_row=$my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$buy_user_id'");
		$buy_money = $buy_money_row['money'];  //买家资金
		$sell_money=$sell_money_row['money'];//卖家的资金
		$sell_money_dj=$sell_money_row['money_dj'];//卖家的冻结资金
		$new_money = $sell_money+$money;
		$new_money_dj = $sell_money_dj-$money;
		$new_buy_money = $buy_money;
		//更新数据
		$new_money_array=array(
			'money'=>$new_money,
			'money_dj'=>$new_money_dj,
		);
		$new_buy_money_array = array(
			'money'=>$new_buy_money,
		);
		$my_money_mod->edit('user_id='.$sell_user_id,$new_money_array);
		$my_money_mod->edit('user_id='.$this->visitor->get('user_id'),$new_buy_money_array);
		//更新商付通log为 定单已完成
		$my_moneylog_mod->edit('order_id='.$order_id,array('caozuo'=>40));
	}
	else{
		$buy_user_id = $this->visitor->get('user_id');
		$buy_money_row=$my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$buy_user_id'");
		$buy_money = $buy_money_row['money'];  //买家资金
		$new_buy_money = $buy_money;
		$new_buy_money_array = array(
			'money'=>$new_buy_money,
		);
		$my_money_mod->edit('user_id='.$this->visitor->get('user_id'),$new_buy_money_array);
	}
	/*商付通v2.2.1  更新商付通定单状态 确认收货 结束*/
            
            /* 发送给卖家买家确认收货邮件，交易完成 */
            $model_member =& m('member');
            $seller_info   = $model_member->get($order_info['seller_id']);
            $mail = get_mail('toseller_finish_notify', array('order' => $order_info));
            $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_finished'),
                'actions'   => array('evaluate'),
            );

            /* 更新累计销售件数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $model_ordergoods =& m('ordergoods');
            $order_goods = $model_ordergoods->find("order_id={$order_id}");
            foreach ($order_goods as $goods)
            {
                $model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
            }

           //发送短信给买家 by ailimo.taobao.com
			$user_id = $order_info['seller_id'];
			$user_name = $order_info['seller_name'];
			$row_msg = $this->mod_msg->getrow("select * from ".DB_PREFIX."msg where user_id=".$user_id);
			$mobile = $row_msg['mobile']; //手机号
			$smsText = "您的订单：".$order_info['order_sn']."，买家".$order_info['buyer_name']."已经确定！";//内容
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
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
			if($checked_functions['check'] != 1)
			{
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
			if($row_msg['num']<=0)
			{
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
			if($mobile == '')
			{
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
			if($smsText == '')
			{
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
			$url='http://utf8.sms.webchinese.cn/?Uid='.SMS_UID.'&Key='.SMS_KEY.'&smsMob='.$mobile.'&smsText='.$smsText; 
			$res = $this->Sms_Get($url);
			if($res == '')
			{
            	$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
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
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
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
				$this->pop_warning('ok','','index.php?app=buyer_order&act=evaluate&order_id='.$order_id);;
				return;
			}
        }

    }
	
	//确认收货操作开始   begin
	function confirm_order_new($order_id=0)
    {
			$order_id = $order_id;
			if (!$order_id)
			{
				 $this->show_warning('no_such_order');
				return;
			}
			$model_order    =&  m('order');

			/* 只有已发货的订单可以确认 */
			$order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
			//$order_info = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status in(13,30)");

			/*$order_info = $model_order->db->getRow("select * from ecm_order where order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status in(13,30)");
		
			if (empty($order_info))
			{
				 $this->show_warning('no_such_order');
				return;
			}*/
			
		$model_order->edit($order_id, array('status' => 40, 'finished_time' => gmtime()));
			
			if ($model_order->has_error())
			{
				$this->show_warning($model_order->get_error());
				return;
			}

			/* 记录订单操作日志 */
			$order_log =& m('orderlog');
			$order_log->add(array(
				'order_id'  => $order_id,
				'operator'  => addslashes($this->visitor->get('user_name')),
				'order_status' => $this->order_status($order_info['status']),
				'changed_status' => order_status(ORDER_FINISHED),
				'remark'    => Lang::get('buyer_confirm'),
				'log_time'  => gmtime(),
			));
            
            /* 发送给卖家买家确认收货邮件，交易完成 */
            $model_member =& m('member');
            $seller_info   = $model_member->get($order_info['seller_id']);
            $mail = get_mail('toseller_finish_notify', array('order' => $order_info));
            $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_finished'),
                'actions'   => array('evaluate'),
            );

            /* 更新累计销售件数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $model_ordergoods =& m('ordergoods');
            $order_goods = $model_ordergoods->find("order_id={$order_id}");
            foreach ($order_goods as $goods)
            {
                $model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
            }
			
			//$this->json_result(array('result' => 'ok'));
			
    }
	//end

    /**
     *    给卖家评价
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function evaluatebeifen()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 验证订单有效性 */
        $model_order =& m('order');
        $order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }
        if ($order_info['status'] != ORDER_FINISHED)
        {
            /* 不是已完成的订单，无法评价 */
            $this->show_warning('cant_evaluate');

            return;
        }
        if ($order_info['evaluation_status'] != 0)
        {
            /* 已评价的订单 */
            $this->show_warning('already_evaluate');

            return;
        }
        $model_ordergoods =& m('ordergoods');

        if (!IS_POST)
        {
            /* 显示评价表单 */
            /* 获取订单商品 */
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($goods_list as $key => $goods)
            {
                empty($goods['goods_image']) && $goods_list[$key]['goods_image'] = Conf::get('default_goods_image');
            }
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                             LANG::get('my_order'), 'index.php?app=buyer_order',
                             LANG::get('evaluate'));
            $this->assign('goods_list', $goods_list);
            $this->assign('order', $order_info);

            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('credit_evaluate'));
            $this->display('buyer_order.evaluate.html');
        }
        else
        {
            $evaluations = array();
            /* 写入评价 */
            foreach ($_POST['evaluations'] as $rec_id => $evaluation)
            {
                if ($evaluation['evaluation'] <= 0 || $evaluation['evaluation'] > 3)
                {
                    $this->show_warning('evaluation_error');

                    return;
                }
                switch ($evaluation['evaluation'])
                {
                    case 3:
                        $credit_value = 1;
                    break;
                    case 1:
                        $credit_value = -1;
                    break;
                    default:
                        $credit_value = 0;
                    break;
                }
                $evaluations[intval($rec_id)] = array(
                    'evaluation'    => $evaluation['evaluation'],
                    'comment'       => $evaluation['comment'],
                    'credit_value'  => $credit_value
                );
            }
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($evaluations as $rec_id => $evaluation)
            {
                $model_ordergoods->edit("rec_id={$rec_id} AND order_id={$order_id}", $evaluation);
                $goods_url = SITE_URL . '/' . url('app=goods&id=' . $goods_list[$rec_id]['goods_id']);
                $goods_name = $goods_list[$rec_id]['goods_name'];
                $this->send_feed('goods_evaluated', array(
                    'user_id'   => $this->visitor->get('user_id'),
                    'user_name'   => $this->visitor->get('user_name'),
                    'goods_url'   => $goods_url,
                    'goods_name'   => $goods_name,
                    'evaluation'   => Lang::get('order_eval.' . $evaluation['evaluation']),
                    'comment'   => $evaluation['comment'],
                    'images'    => array(
                        array(
                            'url' => SITE_URL . '/' . $goods_list[$rec_id]['goods_image'],
                            'link' => $goods_url,
                        ),
                    ),
                ));
            }

            /* 更新订单评价状态 */
            $model_order->edit($order_id, array(
                'evaluation_status' => 1,
                'evaluation_time'   => gmtime()
            ));

            /* 更新卖家信用度及好评率 */
            $model_store =& m('store');
            $model_store->edit($order_info['seller_id'], array(
                'credit_value'  =>  $model_store->recount_credit_value($order_info['seller_id']),
                'praise_rate'   =>  $model_store->recount_praise_rate($order_info['seller_id'])
            ));

            /* 更新商品评价数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $goods_ids = array();
            foreach ($goods_list as $goods)
            {
                $goods_ids[] = $goods['goods_id'];
            }
            $model_goodsstatistics->edit($goods_ids, 'comments=comments+1');


            $this->show_message('evaluate_successed',
                'back_list', 'index.php?app=buyer_order');
        }
    }

    
	
	
    /**
     *    给卖家评价
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function evaluate()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 验证订单有效性 */
        $model_order =& m('order');
        $order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        
        //哪个曹操配送的订单
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }
        if ($order_info['evaluation_status'] != 0)
        {
            /* 已评价的订单 */
            $this->show_warning('already_evaluate');

            return;
        }
        $model_ordergoods =& m('ordergoods');

        if (!IS_POST)
        {
            //显示曹操
            if(!empty($order_info['pen_id'])){
                $db = &db();
                $pensongs  = $db->getRow("select * from ecm_member where user_id=".$order_info['pen_id']);
                $this->assign('pensongs',$pensongs);
            }
            /* 显示评价表单 */
            /* 获取订单商品 */
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($goods_list as $key => $goods)
            {
                empty($goods['goods_image']) && $goods_list[$key]['goods_image'] = Conf::get('default_goods_image');
            }
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                             LANG::get('my_order'), 'index.php?app=buyer_order',
                             LANG::get('evaluate'));
            $this->assign('goods_list', $goods_list);
            $this->assign('order', $order_info);

            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('credit_evaluate'));
            $this->display('buyer_order.evaluate.html');
        }
        else
        {
            if(!empty($order_info['pen_id'])){
				
                if(empty($_POST['pen_service'])){
					//dump('1111111');
                    $this->show_warning('你还没有评分哟！');
                    return;
                }
				
                $pensong = array(
                    'pen_id'        => trim($_POST['pen_id']),
                    'service_score' => trim($_POST['pen_service']),
                    'remark'        => trim($_POST['pen_remark']), 
                    'create_time'   => time(), 
                    'order_id'      => $order_info['order_id'],   
                    'order_sn'      => $order_info['order_sn'], 
                    'store_id'      => $order_info['seller_id'],
                    'store_name'    => $order_info['seller_name']    
                );
                $model_evaluate =& m('evaluate');
                $model_evaluate->add($pensong);
            }
            //dump($_POST); 
            $evaluations = array();
            /* 写入评价 */
            foreach ($_POST['evaluations'] as $rec_id => $evaluation)
            {
                if ($evaluation['evaluation'] <= 0 || $evaluation['evaluation'] > 3)
                {
                    $this->show_warning('evaluation_error');

                    return;
                }
                switch ($evaluation['evaluation'])
                {
                    case 3:
                        $credit_value = 1;
                    break;
                    case 1:
                        $credit_value = -1;
                    break;
                    default:
                        $credit_value = 0;
                    break;
                }
                $evaluations[intval($rec_id)] = array(
                    'evaluation'    => $evaluation['evaluation'],
                    'comment'       => $evaluation['comment'],
                    'credit_value'  => $credit_value
                );
            }
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            //dump($evaluations);
            foreach ($evaluations as $rec_id => $evaluation)
            {
                $model_ordergoods->edit("rec_id={$rec_id} AND order_id={$order_id}", $evaluation);
                $goods_url = SITE_URL . '/' . url('app=goods&id=' . $goods_list[$rec_id]['goods_id']);
                $goods_name = $goods_list[$rec_id]['goods_name'];
                $this->send_feed('goods_evaluated', array(
                    'user_id'   => $this->visitor->get('user_id'),
                    'user_name'   => $this->visitor->get('user_name'),
                    'goods_url'   => $goods_url,
                    'goods_name'   => $goods_name,
                    'evaluation'   => Lang::get('order_eval.' . $evaluation['evaluation']),
                    'comment'   => $evaluation['comment'],
                    'images'    => array(
                        array(
                            'url' => SITE_URL . '/' . $goods_list[$rec_id]['goods_image'],
                            'link' => $goods_url,
                        ),
                    ),
                ));
            }

            /* 更新订单评价状态 */
            $model_order->edit($order_id, array(
                'evaluation_status' => 1,
                'evaluation_time'   => time()
            ));

            /* 更新卖家信用度及好评率 */
            $model_store =& m('store');
            $model_store->edit($order_info['seller_id'], array(
                'credit_value'  =>  $model_store->recount_credit_value($order_info['seller_id']),
                'praise_rate'   =>  $model_store->recount_praise_rate($order_info['seller_id'])
            ));

            /* 更新商品评价数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $goods_ids = array();
            foreach ($goods_list as $goods)
            {
                $goods_ids[] = $goods['goods_id'];
            }
            $model_goodsstatistics->edit($goods_ids, 'comments=comments+1');
            //确认收货
            $this->confirm_order_new($order_id);
            $this->show_message('evaluate_successed',
                'back_list', 'index.php?app=buyer_order');
        }
    }

   
	/**
     *    获取订单列表
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_orders()
    {
        $page = $this->_get_page(10);
        $model_order =& m('order');
        !$_GET['type'] && $_GET['type'] = 'all_orders';
        $con = array(
            /*array(      //按订单状态搜索
                'field' => 'status',
                'name'  => 'type',
                'handler' => 'order_status_translator',
            ),*/
            array(      //按店铺名称搜索
                'field' => 'seller_name',
                'equal' => 'LIKE',
            ),
            array(      //按下单时间搜索,起始时间
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),
            array(      //按下单时间搜索,结束时间
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'=> 'gmstr2time_end',
            ),
            array(      //按订单号
                'field' => 'order_sn',
            ),
        );
        $conditions = $this->_get_query_conditions($con);
		
		if($_GET['type'] == 'all'){
			$conditions .= "";
		}
		
		if($_GET['type'] == 'pending'){
			$conditions .= " AND (status = 11 OR status=12) ";
		}
		
		if($_GET['type'] == 'accepted'){
			$conditions .= " AND status = 20 ";
		}
		
		if($_GET['type'] == 'shipped'){
			$conditions .= " AND (status = 21 OR status=30) ";
		}
		
		if($_GET['type'] == 'finished'){
			$conditions .= " AND status = 40 ";
		}
		
        /* 查找订单 */
        $orders = $model_order->findAll(array(
            'conditions'    => "buyer_id=" . $this->visitor->get('user_id') . "{$conditions}",
            'fields'        => 'this.*',
            'count'         => true,
            'limit'         => $page['limit'],
            'order'         => 'add_time DESC',
            'include'       =>  array(
                'has_ordergoods',       //取出商品
            ),
        ));
		
		// tyioocom
		$member_mod =& m('member');
		
        foreach ($orders as $key1 => $order)
        {
            foreach ($order['order_goods'] as $key2 => $goods)
            {
                empty($goods['goods_image']) && $orders[$key1]['order_goods'][$key2]['goods_image'] = Conf::get('default_goods_image');
            }
			// psmb
			$orders[$key1]['goods_quantities'] = count($order['order_goods']);
			$orders[$key1]['seller_info'] = $member_mod->get(array('conditions'=>'user_id='.$order['seller_id'],'fields'=>'real_name,im_qq,im_aliww,im_msn'));
            $sql_store="select * from ecm_store where store_id=".$order['seller_id'];
			$orders[$key1]['store_info']=$member_mod->getRow($sql_store);
	
	 }

        $page['item_count'] = $model_order->getCount();
        $this->assign('types', array('all'     => Lang::get('all_orders'),
                                     'pending' => Lang::get('pending_orders'),
                                     'submitted' => Lang::get('submitted_orders'),
                                     'accepted' => Lang::get('accepted_orders'),
                                     'shipped' => Lang::get('shipped_orders'),
                                     'finished' => Lang::get('finished_orders'),
                                     'canceled' => Lang::get('canceled_orders')));
        $this->assign('type', $_GET['type']);
        $this->assign('orders', $orders);
		//print_r($orders);
		//exit;
        $this->_format_page($page);
        $this->assign('page_info', $page);
    }

    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'order_list',
                'url'   => 'index.php?app=buyer_order',
            ),
        );
        return $menus;
    }

    //购买退货
    function thsq(){
        $order_id=isset($_GET['oid'])?intval($_GET['oid']):0;
       // $reason = isset($_GET['reason'])? trim($_GET['reason']):'';
        $remark = isset($_GET['remark'])? trim($_GET['remark']):''; 
        $sql_str="select * from ecm_order where `status` in(13,21,20,30) and order_id=".$order_id." and buyer_id=".$this->visitor->get('user_id');
       
        $db=&db();
        $rows= $db->getAll($sql_str);
        if(!count($rows))
        {
            echo '0';
            exit();
        }
        $order_info=$rows[0];

        $sql_str="select * from ecm_order where `status` in(13,21,20,30) and order_id=".$order_id." and buyer_id=".$this->visitor->get('user_id');
        if(!strlen($remark))
        {
            echo '1';
          // $this->pop_warning('ok', 'seller_order_cancel_order');
           exit;
        }       
        $rows= $db->getAll($sql_str);
        if(count($rows))
        {
            $sql_up="update ecm_order set `status`=51 where order_id=".$order_id."";
            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => $this->order_status($rows[0]['status']),
                'changed_status' => '退货申请中',
                'remark'    => $remark,
                'log_time'  => gmtime(),
            ));
            $db->query($sql_up);
            echo "3";
          

        }else
        {
            echo '2';
        }
    }
     
function order_status($order_status_text)
    {
            switch ($order_status_text)
            {
                case 10:    
                    return '订单提交';
                break;
                case 11:        
                    return '等待买家付款';
                break;
                case 12:     
                    return '等待买家收货付款';
                break;
                case 21:  
                    return '货到付款已发货';
                break;
                case 13:   
                    return '买家已付款';
                break;
                case 40:    
                    return '交易完成';
                break;
                case 20:   
                    return '等待卖家发货';
                break;
                case 30:    
                    return '卖家已发货';
                break;
                default:          
                    return '交易关闭';
                break;
            }
    }
}

?>
