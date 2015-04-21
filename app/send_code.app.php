<?php

/**
 *    获得短信验证码
 *
 *    @author    Summer
 *    @usage    none
 */
class Send_codeApp extends FrontendApp
{
	//获取手机验证码begin
	function index(){
		$userphone = isset($_GET['tel']) ? trim($_GET['tel']) : '';
		$tempArray = array();
		$tempArray =$this->_sendSms($userphone);
		//echo $tempArray['file_content'] . '----' . $tempArray['verify_code'];
		$verifyCode = trim($tempArray['verify_code']);
		//$verifyCode = md5($verifyCode);
		$xmlString = trim($tempArray['file_content']);
		$xmlString = $xmlString;
		$xmlObj = simplexml_load_string($xmlString);
		header("Content-Type: text/html; charset=UTF-8");
		$status = $xmlObj -> returnstatus;
		$status = trim($status);
		$returnString = $status . '-' . $verifyCode;
		echo $returnString;
	}
	
	//发送函数
	function _sendSms($mobileNo){
		$mobileNo = isset($mobileNo)?trim($mobileNo):'';
		$file_content = '';
		$resultArray = array('file_content' => '', 'verify_code' => 0);
		//定义传递变量
		$url ='http://www.lcqxt.com/sms.aspx' ;
		$userid = '4297';          //企业ID
		$account = 'jnbqdzsw';     //发送用户账号
		$password = 'jnbqdzsw';    //发送用户密码
		//$password = md5($password);
		$mobile = '';
		if(!empty($mobileNo)){  
			$mobile = $mobileNo;   //发送目的号码	
		}else{
			return ;	
		}
		$verifyCode = $this->_generateCode(6);               //获取随机6位验证码
		$verifyCode = trim($verifyCode);
		$verifyCode = intval($verifyCode);
		//$content = '【倍全订货宝】验证码为' . $verifyCode . '（倍全客服绝不会索取此验证码，切勿告诉他人），请在页面中输入以完成验证。';             //发送短信内容
		$content = '倍全提醒您：您本次获取的手机验证码为' . $verifyCode . '，请正确填写此验证码完成操作。【倍全商城】';        //发送短信内容
		
		$content = urlencode($content);
		$sendTime = '';                    //定时发送
		$action = 'send';                  //发送命令
		$checkcontent = 1;                 //检查内容是否包含非法关键字 0：不检查，1：检查
		
		$urlString = $url . '?action=' . $action . '&userid=' . $userid . '&account=' . $account . '&password=' . $password . '&mobile=' . $mobile . '&content=' . $content . '&sendTime=' . '&checkcontent=' . $checkcontent;
		
		if(function_exists('file_get_contents')){
			$file_content = file_get_contents($urlString);
		}else{
			$ch = curl_init();
			$timeOut = 5;
			curl_setopt($ch, CURLOPT_URL, $urlString);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut);
			$file_content = curl_exec($ch);
			curl_close($ch);
		}
		
		$resultArray['file_content'] = $file_content;
		$resultArray['verify_code'] = $verifyCode;
		
		return $resultArray;             
		
	} 

	//产生随机6位
	function _generateCode($bit){
		$randString = '';   
		$str = '1234567890';
		$len = strlen($str)-1;   
		for($i = 0;$i < $bit;$i ++){   
			$num = mt_rand(0, $len);   
			$randString .= $str[$num];   
		}   
		return $randString ;   	
	}
	
	//end
	
	//检查用户名是否唯一
	function validate_user(){
		$user_name = isset($_GET['name'])? trim($_GET['name']):'';
		$conditions = "user_name='" . $user_name . "'";
		$mod_member = &m('member');
		$res = $mod_member->get(array('conditions' => $conditions));
		$res = trim($res);
		if($res){
			echo 1;	
		}else{
			echo 2;	
		}
	}


}

?>
