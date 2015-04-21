<?php

/* 微信公众平台 */

class WxcreatemenuApp extends MallbaseApp {

    function __construct() {
        $this->WxcreatemenuApp();
    }

    function WxcreatemenuApp() {
        parent::__construct();
        //$this->my_wxkeyword_mod = & m('wxkeyword');
    }
	
	//生成微信菜单
    function index() {
		
		$appid = 'wxf98b2962538c0b03';
		$appsecret = '61df91f7c8dd8b05f47a15a23c1915dc';
		//获取access_token
		$access_token = $this->get_access_token($appid, $appsecret);
		
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token; 
		$data = ' {
			 "button":[
			 {	
				  "type":"view",
				  "name":"立即购物",
				  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf98b2962538c0b03&redirect_uri=http://wap.bqmart.cn&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
			  },
			  {
				   "type":"view",
				   "name":"倍全红包",
				   "url":"http://www.baidu.com"
			  },
			  {
				   "name":"服务中心",
				   "sub_button":[
					{
					   "type":"view",
					   "name":"20分钟送货",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201359815&idx=3&sn=0dfad18c4ca1877d1e6e1dfda06471d6#rd"
					},
					{
					   "type":"view",
					   "name":"商家入驻",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201387981&idx=1&sn=3c5ae4f90632a4da200e588e8d5c382c#rd"
					},
					{
					   "type":"view",
					   "name":"关于倍全",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201235911&idx=1&sn=78e95d8c36a85a8725873016a317739f#rd"
					}
					]
			   }]
		 }';
		
		$temp = $this->https_request($url, $data);
		
		$menu = json_decode($temp);

		if($menu->errcode == "0"){
			echo "菜单创建成功";
		}else{
			echo "菜单创建失败";
		}

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