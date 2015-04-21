<?php
/*
    方倍工作室
    http://www.cnblogs.com/txw1958/
    CopyRight 2014 All Rights Reserved
*/
$token_val = isset($_GET['id'])? trim($_GET['id']):'';
define("TOKEN", $token_val);

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
             
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
				
				include 'subscribe.php';
				
				//关注之后默认弹出的图文消息
				/*$default_arr = subGetDefault(TOKEN);
				
				if(count($default_arr) > 0){
					$content[] = array("Title"=>$default_arr['title'], "Description"=>"", "PicUrl"=>$default_arr['picurl'], "Url" =>$default_arr['url']);
				} else {
					$content = "亲，倍全商城已经成功升级，更多新服务等您去体验！<a href='http://wap.bqmart.cn/index.php?app=member&act=login&ret_url=&openid=" . $object->FromUserName . "'>点击去逛逛</a>";
				}*/
			    $result_arr = subscribeMsg($object->EventKey, TOKEN);
				if(count($result_arr) > 0){
					foreach($result_arr as $val){
						$content[] = array("Title"=>$val['title'], "Description"=>"", "PicUrl"=>$val['picurl'], "Url" =>$val['url']);
					}
				}
				
				//$content = "亲，倍全商城已经成功升级，更多新服务等您去体验！<a href='http://ceshi.bqmart.cn/index.php?app=member&act=login&ret_url=&openid=" . $object->FromUserName . "'>点击去逛逛</a>";

				//扫推荐人二维码进来的
				if(!empty($object->EventKey)){
					$uin = str_replace("qrscene_","",$object->EventKey);
					$this -> addIntoMemberTable($object->FromUserName, $uin);
				}

				//扫公众号进来的
				if(empty($object->EventKey) || !isset($object->EventKey)){
					//若为-1，则是扫描不带参数公众号进来的
					$this -> addIntoMemberTable($object->FromUserName, -1);
				}
                break;


            case "unsubscribe":
                $content = "取消关注";
                break;
            case "SCAN":
                //$content = "亲，倍全商城已经成功升级，更多新服务等您去体验！<a href='http://ceshi.bqmart.cn/index.php?app=member&act=login&ret_url=&openid=" . $object->FromUserName . "'>点击去逛逛</a>";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "test_url":
                        $content = array();
                        $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958&openid=" . $object->FromUserName);
                        break;
                    default:
                        $content = "点击菜单：".$object->EventKey;
                        break;
                }
                break;
            case "LOCATION":
				$_SESSION['s_long'] = $object->Longitude;
				$_SESSION['s_lat'] = $object->Latitude;
                //$content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "MASSSENDJOBFINISH":
                $content = "消息ID：".$object->MsgID."，结果：".$object->Status."，粉丝数：".$object->TotalCount."，过滤：".$object->FilterCount."，发送成功：".$object->SentCount."，发送失败：".$object->ErrorCount;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

	//**********begin**********//
	//获取微信用户信息，然后将信息插入到用户表
	private function addIntoMemberTable($openid, $uin = -1){
		//连接数据库信息
		$db_host='localhost';
		$db_database='ecmall';
		$db_username='root';
		$db_password='root';
		$connection=mysql_connect($db_host,$db_username,$db_password);//连接到数据库
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER_SET_CLIENT=utf8");
		mysql_query("SET CHARACTER_SET_RESULTS=utf8");
		if(!$connection){
			die("could not connect to the database:</br>".mysql_error());//诊断连接错误
		}
		$db_selecct=mysql_select_db($db_database);//选择数据库
		if(!$db_selecct)
		{
			die("could not to the database</br>".mysql_error());	
		}

		$openid = isset($openid)? trim($openid):'';
		$token = TOKEN;
		$wx_config_arr = array();
		$user_info_arr = array();		
		
		$sql1 = "select * from ecm_wx_pub_config where token='" . $token . "'";
		$wx_config = mysql_query($sql1);
		
		while($result_row=mysql_fetch_array(($wx_config)))//取出结果并显示
		{
			$wx_config_arr = $result_row;
		}

		if($uin > 0){
			//获得用户等级
			$sql2 = "select * from ecm_wx_code where wx_id=" . $wx_config_arr['wx_id'] . " and uin=" . $uin;
			$wxcode = mysql_query($sql2);
			while($result_row2=mysql_fetch_array(($wxcode)))//取出结果并显示
			{
				$user_level = intval($result_row2['user_level']);
			}
		}

		$appid = trim($wx_config_arr['appid']);
		$appsecret = trim($wx_config_arr['appsecret']);
		$wx_id = trim($wx_config_arr['wx_id']);
		
		if(!empty($appid) && !empty($appsecret)){
			//获取accesstoken
			$access_token = $this->get_access_token($appid, $appsecret);
			$access_token = trim($access_token);
			
			if(isset($access_token) && !empty($access_token)){
				//获取包含用户信息的数组
				$user_info_arr = $this->get_user_infomation($access_token, $openid);
				if($uin > 0){
				$sql3 = "insert into ecm_member(user_name, password, gender, reg_time, parentid, user_level, from_weixin, wx_openid, wx_nickname, wx_city, wx_country, wx_province, wx_language, wx_headimgurl, wx_subscribe_time, wx_id) values('" . $user_info_arr['openid'] . "', '" . md5($user_info_arr['openid']) . "', " . intval($user_info_arr['sex']) . ", " . $this->gmtime() . ", " . $uin . ", " . $user_level . ", 1, '" . $user_info_arr['openid'] . "', '" . $user_info_arr['nickname'] . "', '" . $user_info_arr['city'] . "', '" . $user_info_arr['country'] . "', '" . $user_info_arr['province'] . "', '" . $user_info_arr['language'] . "', '" . $user_info_arr['headimgurl'] . "', " . $user_info_arr['subscribe_time'] . ", " . $wx_id . ")";
				
				$sql4 = "select * from ecm_member where user_name='" . $user_info_arr['openid'] . "'";
				$res_array = mysql_query($sql4);
				while ($row = mysql_fetch_array($res_array)) {
					$new_array = $row;
				}

				if(count($new_array) == 0){
					mysql_query($sql3);
					//给该用户发放红包
					$results = mysql_query("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='注册专用红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc");
					while ($row = mysql_fetch_array($results)) {
						$temp_array = $row;
					}
					if(count($temp_array) > 0){
						//根据openid获取该用户的user_id
						$new_arr = mysql_query("select * from ecm_member where user_name='" . $user_info_arr['openid'] . "'");
						while ($row = mysql_fetch_array($new_arr)) {
							$temp = $row;
						}
						mysql_query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $temp['user_id'] . ",'" . $temp_array['coupon_sn'] . "')");	
					}

				}else{
					return;
				}

				} 
				if($uin == -1)
				{
					$sql5 = "insert into ecm_member(user_name, password, gender, reg_time, parentid, from_weixin, wx_openid, wx_nickname, wx_city, wx_country, wx_province, wx_language, wx_headimgurl, wx_subscribe_time, wx_id) values('" . $user_info_arr['openid'] . "', '" . md5($user_info_arr['openid']) . "', " . intval($user_info_arr['sex']) . ", " . $this->gmtime() . ", " . $uin . ", 1, '" . $user_info_arr['openid'] . "', '" . $user_info_arr['nickname'] . "', '" . $user_info_arr['city'] . "', '" . $user_info_arr['country'] . "', '" . $user_info_arr['province'] . "', '" . $user_info_arr['language'] . "', '" . $user_info_arr['headimgurl'] . "', " . $user_info_arr['subscribe_time'] . ", " . $wx_id . ")";
					//检测用户openid的唯一性
					$sql4 = "select * from ecm_member where user_name='" . $user_info_arr['openid'] . "'";
					$res_array = mysql_query($sql4);

					while ($row = mysql_fetch_array($res_array)) {
						$new_array = $row;
					}

					if(count($new_array) == 0){
						mysql_query($sql5);
						//给该用户发放红包
						$results = mysql_query("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='注册专用红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc");
						while ($row = mysql_fetch_array($results)) {
							$temp_array = $row;
						}
						if(count($temp_array) > 0){
							//根据openid获取该用户的user_id
							$new_arr = mysql_query("select * from ecm_member where user_name='" . $user_info_arr['openid'] . "'");
							while ($row = mysql_fetch_array($new_arr)) {
								$temp = $row;
							}
							mysql_query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $temp['user_id'] . ",'" . $temp_array['coupon_sn'] . "')");	
						}
					}else{
						return;
					}
				}
				
				
			}
		}
		
		
	}
	//获取服务器的当前时间
	private function gmtime()
	{
		return (time() - date('Z'));
	}
	//向服务器Post数据，并以json数据格式的形式返回
	private function https_request($url, $data = null){
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
	//根据openid获取用户信息
    private function get_user_infomation($access_token, $openid){
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $tempArr = json_decode($this->https_request($url), true);
        return $tempArr;
    }
	//**********end**********//

    //接收文本消息
    private function receiveText($object)
    {   
        $keyword = trim($object->Content);
		include "keywords.php";
		$content_text = keywordsArray($keyword, TOKEN);
		if(count($content_text) > 0){
			foreach($content_text as $val){
				$content[] = array("Title"=>$val['title'], "Description"=>'', "PicUrl"=>$val['picurl'], "Url" =>$val['url']);
			}
		}/* else {
			$words_def = wordsGetDefault(TOKEN);
			if(count($words_def) > 0){
				$content[] = array("Title"=>$words_def['title'], "Description"=>$words_def['description'], "PicUrl"=>$words_def['picurl'], "Url" =>$words_def['url']);
			}
		}*/
		if(is_array($content)){
            if (isset($content[0])){
				$result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
			$result = $this->transmitText($object, $content);
        }
		return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }

        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}
?>