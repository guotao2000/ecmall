<?php

/**
 *    找回登录密码
 *
 *    @author    Summer
 *    @usage    none
 */
class Reset_passwordApp extends FrontendApp
{
	function index(){
		if(!IS_POST){
			$this->display('bqmart/retrieve_password.html');
		} else {
			$user_name = isset($_POST['shouji'])? trim($_POST['shouji']):'';
			$this->assign('user_name', $user_name);
			$this->display('bqmart/change_password.html');
		}
	}
	
	//重置密码
	function change(){
		$user_name = isset($_POST['user_name'])? trim($_POST['user_name']):'';
		$password = isset($_POST['password'])? trim($_POST['password']):'';
		$password = md5($password);
		$member_mod = &m('member');
		$conditions = "user_name='" . $user_name . "'";
		$result = $member_mod->get(array('conditions' => $conditions));
		$user_id = $result['user_id'];
		$data = array('password' => $password);
		if($member_mod->edit($user_id, $data)){
			header('Location: index.php?app=reset_password&act=success');
			exit;
		}
	}
	
	//密码设置成功
	function success(){
		$this->display('bqmart/reset_password_success.html');	
	}

}

?>
