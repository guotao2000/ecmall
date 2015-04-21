<?php
class DefaultyxwApp extends MallbaseApp
{
	function index(){
		//$wx_pub_config = &m('wxpubconfig');
		
		//判断是否来自手机
		$is_mob = $this->confirm_src();
		if(!$is_mob)
		{
			$this->display('index.html'); 
			exit();
		}
		
		if($_GET['flag'] == 1){
			if($_COOKIE['sid'])
			{
				header("Location:/index.php?app=storeyxw&status=1&id=".$_COOKIE['sid'].""); 
				exit;
			}
		
		
		include 'weixinyxw.php';
	$jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
        $signPackage = $jssdk->GetSignPackage();
	$this->assign('signPackage', $signPackage);

			$this->display('cover.html');
			exit;
		}
	
		
		$code = isset($_GET['code'])? trim($_GET['code']):'';
		
		//获取店铺列表
		$store_mod = &m('store');
		$slong=isset($_SESSION['s_long'])?$_SESSION['s_long']:117.129533;
		$slat=isset($_SESSION['s_lat'])?$_SESSION['s_lat']:36.696866;
		$sql = "select * from ecm_store where state=1 order by store_id desc";
		$store_arr=$store_mod->db->getAll($sql);

		foreach($store_arr as $key => $val){
			//计算出当前位置距离每一个店铺地址的距离
			$distance = $this->_get_near_distance($slong, $slat, $store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$store_arr[$key]['juli'] = number_format(($distance / 1000), 2, '.', '');
			$array_keys1[$key]=$distance;
		}
		
		asort($array_keys1);
		
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
		}
		$wx_pub_config = &m('wxpubconfig');
		//倍全商城
		if($_GET['state'] == 1 || $_GET['state'] == 2|| $_GET['state'] == 6){
			//根据code获取access_token
			$appid = 'wx64794ef985549154';
			$appsecret = '5dcdf5cdbc6e9e1ff23c39836df9e236';
			$wx_id = $wx_pub_config->db->getOne("select wx_id from ecm_wx_pub_config where appid='" . $appid . "' and appsecret='" . $appsecret . "'");
		}
		//倍全酒急送
		if($_GET['state'] == 3){
			//根据code获取access_token
			$appid = 'wxb57b25c24c4e7fe8';
			$appsecret = '67113c87615c87a3c5245766ce454dfd';
			$wx_id = $wx_pub_config->db->getOne("select wx_id from ecm_wx_pub_config where appid='" . $appid . "' and appsecret='" . $appsecret . "'");
		}
		$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $appsecret . "&code=" . $code . "&grant_type=authorization_code";
		$access_json = $this->https_request($access_token_url);
		$access_array = json_decode($access_json, true);
		$openid = $access_array['openid'];
		$access_token = $access_array['access_token'];
		//begin
		//检查该openid在用户表中是否存在
		$sql_str = "select * from ecm_member where user_name='" . $openid . "'";
		$mod_member = &m('member');
		$result_arr = $mod_member->db->getAll($sql_str);
		
		if(count($result_arr) == 0){
			//根据openid获得该用户的微信资料
			
			$userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=" . $openid;
			$userinfo_json = $this->https_request($userinfo_url);
			$userinfo_array = json_decode($userinfo_json, true);
			$userinfo_array['subscribe_time'] = empty($userinfo_array['subscribe_time'])? 0:intval($userinfo_array['subscribe_time']);

			$sql5 = "insert into ecm_member(user_name, password, gender, reg_time, parentid, from_weixin, wx_openid, wx_nickname, wx_city, wx_country, wx_province, wx_language, wx_headimgurl, wx_subscribe_time, wx_id) values('" . $userinfo_array['openid'] . "', '" . md5($userinfo_array['openid']) . "', " . intval($userinfo_array['sex']) . ", " . gmtime() . ", -1, 1, '" . $userinfo_array['openid'] . "', '" . $userinfo_array['nickname'] . "', '" . $userinfo_array['city'] . "', '" . $userinfo_array['country'] . "', '" . $userinfo_array['province'] . "', '" . $userinfo_array['language'] . "', '" . $userinfo_array['headimgurl'] . "', " . $userinfo_array['subscribe_time'] . ", " . $wx_id . ")";
			
			$mod_member->db->query($sql5);
			foreach ($userinfo_array as $key => $value) {
				$userinfo_array[$key]= addslashes($value);
			}
			//给该用户发放红包
			$results_coupon = $mod_member->db->getAll("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='注册专用红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc limit 0,1");
			//echo '---' . count($results_coupon) . '---';
			//exit;
			
			if(count($results_coupon) > 0){
				
				foreach($results_coupon as $val){
					$coupon_sn = $val['coupon_sn'];
				}
				
				//根据openid获取该用户的user_id
				$user_id = $mod_member->db->getOne("select user_id from ecm_member where user_name='" . $openid . "'");

				$mod_member->db->query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $user_id . ",'" . $coupon_sn . "')");	
			}
		}
		//end

		$state = intval($_GET['state']);
		//判断是否来自手机
		$is_mob = $this->confirm_src();
		if($is_mob){
			header("Location:/index.php?app=member&act=login&ret_url=&openid=".$openid."&state=". $state ." ");
			exit;
		}
		else
		{
			
			header("Location:/index.php" . " ");
			exit;
		}



	}

	function cover()
	{
		/*$nostores=getConf('noshows');
		获取店铺列表
		$store_mod = &m('store');
		$slong=isset($_SESSION['s_long'])?$_SESSION['s_long']:117.129533;
		$slat=isset($_SESSION['s_lat'])?$_SESSION['s_lat']:36.696866;
		$conditon="";
		if(!empty($nostores)&&strlen(trim($nostores))>1)
		{
			$conditon.=" and store_id not in (".implode(",",array_filter(explode(",",$nostores))).")";
		}
		$sql = "select * from ecm_store where state=1 ".$conditon." order by store_id desc";
		$store_arr=$store_mod->db->getAll($sql);
		foreach($store_arr as $key => $val){
			//计算出当前位置距离每一个店铺地址的距离
			$distance = $this->_get_near_distance($slong, $slat, $store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$store_arr[$key]['juli'] = number_format(($distance / 1000), 2, '.', '');
			$array_keys1[$key]=$distance;
		}
		asort($array_keys1);
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
		}
		$this->assign('stores', $array_keys1); */
	    $sql="SELECT * from ecm_region where parent_id=1 ORDER BY sort_order desc";
		$db=&db();
		$rows=$db->getAll($sql);
	    $slong=isset($_SESSION['s_long'])?$_SESSION['s_long']:117.129533;
		$slat=isset($_SESSION['s_lat'])?$_SESSION['s_lat']:36.696866;
		$url="http://api.map.baidu.com/geocoder/v2/?ak=2667f496b45f6c9c4e64e6cd8f0344ed&location=".$slat.",".$slong."&output=json&pois=0";
		$access_json = $this->https_request($url);
		$access_array = json_decode($access_json, true);
		$sheng_name=$access_array['result']['addressComponent']['province'];
		$shi_name=$access_array['result']['addressComponent']['city'];
		$qu_name=$access_array['result']['addressComponent']['district'];
		$qufujin=$access_array['result']['addressComponent']['district'].$access_array['result']['addressComponent']['street'];
        $sheng_id=$rows[0]['region_id'];
		$shengs=array();
		foreach($rows as  $val)
		{
          $shengs[$val['region_id']]=$val['region_name'];
		 // echo $sheng_name."ss".$val['region_name'];
		 // echo strpos($sheng_name,$val['region_name']);
		  if(strpos($sheng_name,$val['region_name'])!==false)
			{
                $sheng_id=$val['region_id'];
			}
		}

        $this->assign('shengs', $shengs);
		$this->assign('qufujin', $qufujin);
         $this->assign('shengs_id', $sheng_id);
        $sql="SELECT * from ecm_region where parent_id=".$sheng_id." ORDER BY sort_order desc";
        $rows=$db->getAll($sql);
		$shis=array();
		$shi_id=$rows[0]['region_id'];
		foreach($rows as  $val)
		{
          $shis[$val['region_id']]=$val['region_name'];
		   if(strpos($shi_name,$val['region_name'])!==false)
			{
                $shi_id=$val['region_id'];
			}
		}
		
        $this->assign('shis', $shis);
         $this->assign('shis_id', $shi_id);

		  $sql="SELECT * from ecm_region where parent_id=".$shi_id." ORDER BY sort_order desc";
        $rows=$db->getAll($sql);
		$qus=array();
		$qu_id=$rows[0]['region_id'];
		foreach($rows as  $val)
		{
          $qus[$val['region_id']]=$val['region_name'];
		   if(strpos($qu_name,$val['region_name'])!==false)
			{
                $qu_id=$val['region_id'];
			}
		}
		
        $this->assign('qus', $qus);
         $this->assign('qus_id', $qu_id);


		$this->display('index.html');
	}
	function getregions($id)
	{
		$db=&db();
        $sql_regions="SELECT * from ecm_region where parent_id=".$id." ORDER BY sort_order desc";
        $row_region=$db->getAll($sql_regions);
		$arr_temp[]=$id;
		
		foreach($row_region as $val)
		{
			$arr_temp[]=$val['region_id'];
           $arr_temp=array_merge($arr_temp,$this->getregions($val['region_id']));
		  //print_r($arr_reg);
		}
        // $arr_reg=array_merge($arr_reg,$arr_temp);
		
		return $arr_temp;
	}
	function getAlls()
	{
	  	$lng=$_COOKIE['s_long'];
		$lat=$_COOKIE['s_lat'];
		$lng=isset($_SESSION['s_long'])?$_SESSION['s_long']:117.129533;
		$lat=isset($_SESSION['s_lat'])?$_SESSION['s_lat']:36.696866;
		$reg_id=intval($_GET['region_id']);
		//获取店铺列表
		$store_mod = &m('store');
		$slong=$lng;
		$slat=$lat;
		$conditon="";
		$ar_region=array();
        $ar_region[]=$reg_id;
       $ar_region= $this->getregions($reg_id,$ar_region);
	    $ar_region=array_unique($ar_region);
		$ar_region=array_filter($ar_region);
       $str_regs= implode(",",$ar_region);
     
        $conditon.=" and region_id in(".$str_regs.")";
		$nostores=getConf('noshows');
		if(!empty($nostores)&&strlen(trim($nostores))>1)
		{
			$conditon.=" and store_id not in (".implode(",",array_filter(explode(",",$nostores))).")";
		}
		$sql = "select * from ecm_store where state=1 ".$conditon." order by store_id desc";
		$store_arr=$store_mod->db->getAll($sql);
	
		foreach($store_arr as $key => $val){
       
			//计算出当前位置距离每一个店铺地址的距离
			//$distance = $this->distanceBetween($lnglat[0], $lnglat[1], $store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$distance = $this->_get_near_distance($slong,$slat,$store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$store_arr[$key]['juli'] = number_format(($distance / 1000), 2, '.', '');
			$array_keys1[$key]=$distance;
		}
		if(count($array_keys1)){
		asort($array_keys1);
		
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
		}

		$arr_keys=array_keys($array_keys1);
		foreach($array_keys1 as $key => $val)
		{
		
			//echo $val['store_name'].",距离:".$val['juli']."，id：".$val['store_id']."<br />";
			echo "<li> <a href=\"index.php?app=storeyxw&id=".$val['store_id']."\">
						<i class=\"shop_icon\"></i>
						<div class=\"shop_name\">
							".$val['store_name']."<br />
							距离约：<span>".$val['juli']." Km</span>
						</div>
						<i class=\"shop_anjian\"></i></a>
                	</li>";
			
		}}else
		{
			echo "<li>
					亲,此地址暂无店铺，请选择其他地址吧！
				</li>";
		}
	
	}
	
	function yxw()
	{
	  	$lng=$_GET['s_long'];
		$lat=$_GET['s_lat'];
		setcookie("s_long",$lng);
		setcookie("s_lat",$lat);
		//判断是否来自微信
		if($_GET['type']=="baidu")
		{
		$_SESSION['s_long']=isset($_GET['s_long'])?$_GET['s_long']:117.129533;
		$_SESSION['s_lat']=isset($_GET['s_lat'])?$_GET['s_lat']:36.696866;
		$lng=$_GET['s_long'];
		$lat=$_GET['s_lat'];
		
			
		}else{
	    $url="http://api.map.baidu.com/geoconv/v1/?coords=".$lng.",".$lat."&from=1&to=5&ak=2667f496b45f6c9c4e64e6cd8f0344ed";
		$access_json = $this->https_request($url);
		$access_array = json_decode($access_json, true);
		$lng=$access_array['result'][0]['x'];
		$lat=$access_array['result'][0]['y'];
		//$qu_name=$access_array['result']['addressComponent']['district'];
		$_SESSION['s_long']=$lng;
		$_SESSION['s_lat']=$lat;
		}
		//获取店铺列表
		$store_mod = &m('store');
		$slong=$lng;
		$slat=$lat;
		$conditon="";
	    $nostores=getConf('noshows');
	    $conditon.=" and store_id not in (".implode(",",array_filter(explode(",",$nostores))).")";
		$sql = "select * from ecm_store where state=1 ".$conditon." order by store_id desc";
		$store_arr=$store_mod->db->getAll($sql);
		foreach($store_arr as $key => $val){
       
			//计算出当前位置距离每一个店铺地址的距离
			//$distance = $this->distanceBetween($lnglat[0], $lnglat[1], $store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$distance = $this->_get_near_distance($slong,$slat,$store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$store_arr[$key]['juli'] = number_format(($distance / 1000), 2, '.', '');
			$array_keys1[$key]=$distance;
		}
		asort($array_keys1);
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
		}
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
			//echo $val['store_name'].",距离:".$val['juli']."<br />";
			//
		}
		$arr_keys=array_keys($array_keys1);
		/*foreach($array_keys1 as $key => $val)
		{
		
			echo $val['store_name'].",距离:".$val['juli']."，id：". $array_keys1[ $key]['store_id']."<br />";
			
		}*/
		if(count($arr_keys))
		{
			$s_key=$arr_keys[0];
			if($array_keys1[$s_key]['juli']>30)
			{
				echo 0;
			}else{
          echo $array_keys1[$s_key]['store_id'];
			}
		}
		else
		{
			echo 0;
		}
		/*echo 555;*/
	}
	function remove_html_tag($str){  //清除HTML代码、空格、回车换行符
        //trim 去掉字串两端的空格
        //strip_tags 删除HTML元素
 
        $str = trim($str);
        $str = @preg_replace('/<script[^>]*?>(.*?)<\/script>/si', '', $str);
        $str = @preg_replace('/<style[^>]*?>(.*?)<\/style>/si', '', $str);
        $str = @strip_tags($str,"");
        $str = @ereg_replace("\t","",$str);
        $str = @ereg_replace("\r\n","",$str);
        $str = @ereg_replace("\r","",$str);
        $str = @ereg_replace("\n","",$str);
        $str = @ereg_replace(" ","",$str);
        $str = @ereg_replace("&nbsp;","",$str);
        return trim($str);
    }

	//根据收货地址匹配店铺
	function get_store()
	{
		$address_id=intval($_GET['id']);
		$aname=$_GET['name'];
		$sql="SELECT region_name,address from ecm_address where addr_id=".$address_id;
		$db=&db();
		$rows=$db->getAll($sql);
		$address_name=$this->remove_html_tag($rows[0]['region_name']);
		$address_name2=$this->remove_html_tag($rows[0]['address']);
		$url="http://api.map.baidu.com/geocoder/v2/?address=".urlencode($aname)."&output=json&ak=2667f496b45f6c9c4e64e6cd8f0344ed";
		    //http://api.map.baidu.com/geocoder/v2/?address=百度大厦&output=json&ak=E4805d16520de693a3fe707cdc962045
			//echo $url;
		$access_json = $this->https_request($url,null);
		print_r($access_json);
		$access_array = json_decode($access_json, true);
		$lng=$access_array['result']['location']['lng'];
		$lat=$access_array['result']['location']['lat'];
	
		
		//获取店铺列表
		$store_mod = &m('store');
		$slong=$lng;
		$slat=$lat;
		$conditon="";
		    $nostores=getConf('noshows');
	    $conditon.=" and store_id not in (".implode(",",array_filter(explode(",",$nostores))).")";
		//$sql = "select * from ecm_store where state=1 ".$conditon." order by store_id desc";
		$sql = "select * from ecm_store where state=1 ".$conditon." order by store_id desc";
		$store_arr=$store_mod->db->getAll($sql);
		foreach($store_arr as $key => $val){
       
			//计算出当前位置距离每一个店铺地址的距离
			//$distance = $this->distanceBetween($lnglat[0], $lnglat[1], $store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$distance = $this->_get_near_distance($slong,$slat,$store_arr[$key]['s_long'], $store_arr[$key]['s_lat']);
			$store_arr[$key]['juli'] = number_format(($distance / 1000), 2, '.', '');
			$array_keys1[$key]=$distance;
		}
		asort($array_keys1);
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
		}
		foreach($array_keys1 as $key => $val)
		{
			$array_keys1[$key]=$store_arr[$key];
			//echo $val['store_name'].",距离:".$val['juli']."<br />";
			//
		}
		$arr_keys=array_keys($array_keys1);
		/*foreach($array_keys1 as $key => $val)
		{
		
			echo $val['store_name'].",距离:".$val['juli']."，id：". $array_keys1[ $key]['store_id']."<br />";
			
		}*/
		if(count($arr_keys))
		{
			$s_key=$arr_keys[0];
			if($array_keys1[$s_key]['juli']>30)
			{
				echo 0;
			}else{
				echo $array_keys1[$s_key]['store_id'];
				if($this->visitor->has_login)
				{
					$user_id = $this->visitor->get('user_id');
					$str1="update  ecm_address set `enable`=0 where user_id=".$user_id;
					$str2="update  ecm_address set `enable`=1 where user_id=".$user_id." and addr_id=".$address_id;
					$db->query($str1);
					$db->query($str2);
					
				}
				setcookie("longlat",$lat.','.$lng,time()+31622400);
			}
		}
		else
		{
			echo 0;
		}
		
		
	}

	/**
 * 计算两个坐标之间的距离(米)
 * @param float $fP1Lat 起点(纬度)
 * @param float $fP1Lon 起点(经度)
 * @param float $fP2Lat 终点(纬度)
 * @param float $fP2Lon 终点(经度)
 * @return int
 */
function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon){
    $fEARTH_RADIUS = 6378137;
    //角度换算成弧度
    $fRadLon1 = deg2rad($fP1Lon);
    $fRadLon2 = deg2rad($fP2Lon);
    $fRadLat1 = deg2rad($fP1Lat);
    $fRadLat2 = deg2rad($fP2Lat);
    //计算经纬度的差值
    $fD1 = abs($fRadLat1 - $fRadLat2);
    $fD2 = abs($fRadLon1 - $fRadLon2);
    //距离计算
    $fP = pow(sin($fD1/2), 2) +
          cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
    return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
}
/**
 * 百度坐标系转换成标准GPS坐系
 * @param float $lnglat 坐标(如:106.426, 29.553404)
 * @return string 转换后的标准GPS值:
 */
function BD09LLtoWGS84($lnglat){ // 经度,纬度
    $lnglat = explode(',', $lnglat);
    list($x,$y) = $lnglat;
    $Baidu_Server = "http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x={$x}&y={$y}";
    $result = @file_get_contents($Baidu_Server);
    $json = json_decode($result);
    if($json->error == 0){
        $bx = base64_decode($json->x);
        $by = base64_decode($json->y);
        $GPS_x = 2 * $x - $bx;
        $GPS_y = 2 * $y - $by;
        return $GPS_x.','.$GPS_y;//经度,纬度
    }else
        return $lnglat;
}
		//向服务器Post数据，并以json数据格式的形式返回
	private function https_request($url, $data = null){

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_REFERER, "http://ceshi.bqmart.cn/index.php");  
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);

		return $output;
	}

	function wapview()
	{
		/* 店铺预览 */
		$this->assign('id', intval($_GET['id']));
		$this->display('index.wapview.html');
	}
	
	function version(){
		echo 'ecmall_140525_687010903011654';
	}
	
	//根据百度地图坐标获得两个地区的位置			
	function _get_near_distance($lon1, $lat1, $lon2, $lat2){
		define('DEF_PI', 3.14159265359); // PI
		define('DEF_2PI', 6.28318530712); // 2*PI
		define('DEF_PI180', 0.01745329252); // PI/180.0
		define('DEF_R', 6370693.5); // radius of earth
		// 角度转换为弧度
		$ew1 = $lon1 * DEF_PI180;
		$ns1 = $lat1 * DEF_PI180;
		$ew2 = $lon2 * DEF_PI180;
		$ns2 = $lat2 * DEF_PI180;
		// 经度差
		$dew = $ew1 - $ew2;
		// 若跨东经和西经180 度，进行调整
		if ($dew > DEF_PI)
		$dew = DEF_2PI - $dew;
		else if ($dew < -DEF_PI)
			$dew = DEF_2PI + $dew;
		$dx = DEF_R * cos($ns1) * $dew; // 东西方向长度(在纬度圈上的投影长度)
		$dy = DEF_R * ($ns1 - $ns2); // 南北方向长度(在经度圈上的投影长度)
		// 勾股定理求斜边长
		$distance = sqrt($dx * $dx + $dy * $dy);
		return $distance;
	}

	function confirm_src(){
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|android)/i";

		if((preg_match($uachar, $ua)))
		{
			return true;
		}
		if ($_GET['Debug'] == 'Wap') {
			return true;
		}
		return false;
	}

	
}

?>