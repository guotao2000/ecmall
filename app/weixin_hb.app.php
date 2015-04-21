<?php

class Weixin_hbApp extends MallbaseApp
{
    var $_wxtuwen_mod;
    function __construct()
    {
        $this->Weixin_viewApp();
    }
    function Weixin_viewApp()
    {
        parent::__construct();
        $this->_wxtuwen_mod = &m('wxtuwen');
    }
    function index()
    {
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$wxtw_id = isset($_GET['wxtw_id'])? intval($_GET['wxtw_id']):0;
		$mod_member = &m('member');
		$mod_store = &m('store');

		$results_coupon = $mod_member->db->getAll("SELECT a.*,b.start_time,b.end_time,b.remark,b.coupon_value,b.min_amount,b.store_id from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='鲜花红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc limit 0,1");
		
		if(count($results_coupon) > 0){
			foreach($results_coupon as $val){
				$coupons = $val;
			}

			$coupons['coupon_value'] = number_format($coupons['coupon_value']);
			$coupons['min_amount'] = number_format($coupons['min_amount']);
			
			$store_name = $mod_store->db->getOne("select store_name from ecm_store where store_id=" . $coupons['store_id']);

		}

		//print_r($coupons);
		//exit;
		
		$this->assign('store_name', $store_name);
		$this->assign('coupons', $coupons);

		$wxtws_arr = $this->_wxtuwen_mod->find(array(
                'conditions' => "wx_id=" . $wx_id . " and wxtw_id=" . $wxtw_id,
                'fields' => '*'
            ));

		foreach($wxtws_arr as $val){
			$wxtws = $val;
		}
		
		$this->assign('wxtws', $wxtws);
		$this->display('user_hongbaoyxw.html');
    }
	
	function get_hongbao(){
		$wx_id = $_GET['wx_id'];
		$wxtw_id = $_GET['wxtw_id'];
		$openid = $_GET['openid'];
		
		$mod_member = &m('member');
		$user_id = $mod_member->db->getOne("select user_id from ecm_member where user_name='" . $openid . "'");

		//给该用户发放红包
		$results_coupon = $mod_member->db->getAll("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='鲜花红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc limit 0,1");
			
		if(count($results_coupon) > 0){
			
			foreach($results_coupon as $val){
				$coupon_sn = $val['coupon_sn'];
			}

			//根据openid获取该用户的user_id
			$user_id = $mod_member->db->getOne("select user_id from ecm_member where user_name='" . $openid . "'");
			
			//检测该用户是否已抢过红包
			$res_arr = $mod_member->db->getAll("select a.coupon_id from ecm_coupon_sn a left join ecm_user_coupon b on a.coupon_sn=b.coupon_sn LEFT JOIN ecm_coupon c on c.coupon_id=a.coupon_id where b.user_id=" . $user_id . " and c.coupon_name='鲜花红包'");
			
			if(count($res_arr) > 0){
				$this->json_error('很抱歉，您已经抢过红包！');
				return;
			}

			$mod_member->db->query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $user_id . ",'" . $coupon_sn . "')");	
		}

		$this->json_result('ok');
		

	}



}

?>
