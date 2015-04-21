<?php

/**
 *    订单打印控制器
 *
 */
define('ROOT_PATH', dirname(__FILE__));
include(ROOT_PATH . '/eccore/phpqrcode.php');

class Order_printApp extends FrontendApp
{
    var $_order_mod;

    function __construct()
    {
        $this->FrontendApp();
    }

    function FrontendApp()
    {
        parent::FrontendApp();

        $this->_order_mod =& m('order');
    }
	
	function index(){
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 获取订单信息 */
        $model_order =& m('order');
        $order_info = $model_order->get(array(
            'conditions'    => $order_id,
            'join'          => 'has_orderextm',
            'include'       => array(
                'has_ordergoods',   //取出订单商品
            ),
        ));

        if (!$order_info)
        {
            $this->show_warning('no_such_order');
            return;
        }
		
		//判断该订单是否来自微信，若是的话则显示该用户的微信昵称
		$res_arr = $model_order->db->getRow("select from_weixin,wx_nickname from ecm_member where user_id=" . $order_info['buyer_id']);
		$order_info['from_weixin'] = $res_arr['from_weixin'];
		$order_info['wx_nickname'] = $res_arr['wx_nickname'];

        $order_type =& ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        $order_info['group_id'] = 0;
        if ($order_info['extension'] == 'groupbuy')
        {
            $groupbuy_mod =& m('groupbuy');
            $groupbuy = $groupbuy_mod->get(array(
                'fields' => 'groupbuy.group_id',
                'join' => 'be_join',
                'conditions' => "order_id = {$order_info['order_id']} ",
                )
            );
            $order_info['group_id'] = $groupbuy['group_id'];
        }
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            if (substr($goods['goods_image'], 0, 7) != 'http://')
            {
                $order_detail['data']['goods_list'][$key]['goods_image'] = SITE_URL . '/' . $goods['goods_image'];
            }
        }
		
		//获取操作人名称
		$user_id = $this->visitor->get('user_id');
		$member_mod = &m('member');
		$conditions = "user_id = " . $user_id;
		$result = $member_mod->get(array('conditions' => $conditions));
		$user_name = $result['user_name'];
		
		$goodsspec_mod = &m('goodsspec');
		
		//计算每个商品的单价乘以数量
		foreach($order_detail['data']['goods_list'] as $key => $val){
			$temp_amount = $order_detail['data']['goods_list'][$key]['quantity'] * $order_detail['data']['goods_list'][$key]['price'];
			$temp_amount = doubleval($temp_amount);
			$order_detail['data']['goods_list'][$key]['per_amount'] = $temp_amount;
			$sql_condition = "spec_id =" . $order_detail['data']['goods_list'][$key]['spec_id'];
			$res_arr = $goodsspec_mod->get(array('conditions' => $sql_condition));
			$order_detail['data']['goods_list'][$key]['goods_sn'] = $res_arr['sku'];
		}
		
		//生成带参数二维码
		QRcode::png('http://www.bqmart.cn', ROOT_PATH . '/data/qrcode/qrcode_bqmart.jpg', $level = QR_ECLEVEL_L, $size = 8, $margin = 2, $saveandprint=false);
		
		//获得生成的参数二维码图片路径
		$qrcode_src = '/data/qrcode/qrcode_bqmart.jpg';
		
		//获得现在操作时间
		$now = gmtime();
		
		$this->assign('otime', $now);
		$this->assign('qrcode_src', $qrcode_src);
		$this->assign('user_name', $user_name);
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('mall/taocz/order.print.html');	
	}

}

?>