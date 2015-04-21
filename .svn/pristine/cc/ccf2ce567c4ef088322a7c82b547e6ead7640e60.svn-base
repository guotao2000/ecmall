<?php

/* 微公众平台接口管理控制器 */

class Weixin_pushApp extends MallbaseApp {

    var $wx_code_mod;

    function __construct() {
        $this->Weixin_push();
    }

    function Weixin_push() {
        parent::__construct();
        $_POST = stripslashes_deep($_POST);
        $this->wx_code_mod = & m('wxcode');
		$this->weixin_config_mod = & m('wxpubconfig');
		$this->member_mod = & m('member');
    }
	//向服务器Post数据，并以json数据格式的形式返回
	function https_request($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

    function index() {
          if (!IS_POST) {
             $openid = isset($_GET['openid'])? trim($_GET['openid']):'';
             $conditions = "wx_openid='" . $openid . "'";
			 //获得用户信息
			 $member_info = $this->member_mod->find(array('conditions' => $conditions));
			 foreach($member_info as $v){
				$member_arr = $v;
			 }
			 var_dump($member_arr);
			 //获得微信公众账号配置信息
			 $wx_id = $member_arr['wx_id'];
			 $wx_info = $this->weixin_config_mod->find($wx_id);
			 foreach($wx_info as $v){
				$wx_config = $v;
			 }
			 $appid = trim($wx_config['appid']);
			 $appsecret = trim($wx_config['appsecret']);

			 //获取access_token
			 $access_token =$this->get_access_token($appid, $appsecret);
			 $data = '{
				"touser":"' . $openid . '",
				"msgtype":"text",
				"text":
				{
					"content":"Hello World"
				}
			 }';
			 $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
			 $result = $this->https_request($url, $data);
			 //var_dump($result);

          } 

    }

	//获取access_token值
    private function get_access_token($appID, $appSecret){
		$appID = trim($appID);
		$appSecret = trim($appSecret);
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appSecret;
        $tempArr = json_decode($this->https_request($url), true);
        return $tempArr['access_token'];
    }
	

}

?>