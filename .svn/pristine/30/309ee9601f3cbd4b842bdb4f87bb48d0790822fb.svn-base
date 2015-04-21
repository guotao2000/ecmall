<?php

/**
 *    我的积分
 *
 *    @author  Summer  
 *    @usage    none
 */
class My_integralApp extends MemberbaseApp
{
	function index()
	{
		$user_id = $this->visitor->get('user_id');
		$db = &db();
		$sql = "select * from ecm_member where user_id=" . $user_id;
		$result = $db->getAll($sql);
		foreach($result as $v){
			$res = $v;	
		}
		$this->assign('user', $res);
		
		//获取该用户消费的总金额
		$sql = "select sum(a.order_amount) as user_fee from ecm_order as a LEFT JOIN ecm_member as b on a.buyer_id = b.user_id where b.user_id = " . $user_id . " and a.`status` = 40";
		$total = $db->getOne($sql);
		if(empty($total)){
			$total = 0;
		}
		$this->assign('user_fee', $total);
		
		$this->display('user_integral.html');
	}

}

?>