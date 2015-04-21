<?php
/**
 * 我的红包
 */

class HongbaoApp extends MemberbaseApp{

    function index(){
		$user_id = $this->visitor->get('user_id');
		$db = &db();
		$sql ="select FROM_UNIXTIME(a.start_time) start_time,FROM_UNIXTIME(a.end_time) end_time,a.min_amount,a.coupon_value,a.store_id,b.coupon_sn,c.user_id,d.store_name,a.remark,b.remain_times
			   from ecm_coupon a left join ecm_coupon_sn b on a.coupon_id=b.coupon_id
 			   LEFT JOIN ecm_user_coupon c on c.coupon_sn=b.coupon_sn LEFT JOIN ecm_store d 
 			   on a.store_id=d.store_id  where user_id=".$user_id . " and b.remain_times > 0";
		$result = $db->getAll($sql);
		
		
		
		foreach($result as $key => $val){
			$result[$key]['start_time'] = substr($result[$key]['start_time'], 0, 10);
			$result[$key]['end_time'] = substr($result[$key]['end_time'], 0, 10);
		}
		
/*		var_dump($result);
		exit();
*/		
		$this->assign('result', $result);
        $this->display('user_hongbao.html');	
	}
	
	//红包登记绑定
	function bind()
	{
		$coupon_sn = isset($_POST['coupon_sn']) ? trim($_POST['coupon_sn']) : '';
		if (empty($coupon_sn))
		{
			echo 0;
			exit;
		}
		$coupon_sn_mod =&m ('couponsn');
		$coupon = $coupon_sn_mod->get_info($coupon_sn);
		if (empty($coupon))
		{
			echo 0;
			exit;
		}
		$coupon_sn_mod->createRelation('bind_user', $coupon_sn, $this->visitor->get('user_id'));
		echo 1;
		exit;
	}
	
	
	
	//红包发放
	function send()
	{
		
	}
}