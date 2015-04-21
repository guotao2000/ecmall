<?php
		//倍全商城
		$appid = 'wx64794ef985549154';
		$appsecret = '5dcdf5cdbc6e9e1ff23c39836df9e236';
		//获取access_token
		$access_token = get_access_token($appid, $appsecret);
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token; 
		/* {
				   "type":"view",
				   "name":"倍全红包",
				   "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx64794ef985549154&redirect_uri=http://wap.bqmart.cn&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect"
			  },*/
		$data = ' {
			 "button":[
			 {	
				  "type":"view",
				  "name":"立即购物",
				  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx64794ef985549154&redirect_uri=http://wap.bqmart.cn&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"
			  },
			  {
				   "type":"view",
				   "name":"码上洗衣",
				   "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx64794ef985549154&redirect_uri=http://wap.bqmart.cn&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"
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
					   "name":"招商加盟",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=204472177&idx=1&sn=27156c1cdc0930301f3aeafd543e0746#rd"
					},
					{
					   "type":"view",
					   "name":"加入倍全",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=204476921&idx=1&sn=d9a5ac3a041c5ed3960facce9f2743a9#rd"
					},
					{
					   "type":"view",
					   "name":"倍全业务",
					   "url":"http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=203917362&idx=1&sn=c657010f28eaf2d3eaf04feedc7cbd91#rd"
					}
					]
			   }]
		 }';
		
		$temp = https_request($url, $data);

		$menu = json_decode($temp);

		if($menu->errcode == "0"){
			echo "菜单创建成功";
		}else{
			echo "菜单创建失败";
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
   function get_access_token($appID, $appSecret){
		$appID = trim($appID);
		$appSecret = trim($appSecret);
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appSecret;
        $tempArr = json_decode(https_request($url), true);
        return $tempArr['access_token'];
    }
	?>