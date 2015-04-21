<?php
function subGetDefault($token){
	$connection=mysql_connect('localhost','root','root');
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");
	$db_selecct=mysql_select_db('ecmall');

	$token = trim($token);
	$sql_r = "select * from ecm_wx_pub_config where token='" . $token . "'";
	$res = mysql_query($sql_r);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		$wx_id = $row['wx_id'];
	}
	
	$sql = "select * from ecm_wxtuwen where is_subscribe=0 and is_pub=1 and is_default=1 and wx_id=" . $wx_id . " order by update_time desc";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC )){
		$sub_arr = $row;
	}
	if(count($sub_arr) == 0){
		return;
	}
	return $sub_arr;
}

function subscribeMsg($qrcodeStr, $token){
	
	$connection=mysql_connect('localhost','root','root');
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");
	$db_selecct=mysql_select_db('ecmall');

	$qrcodeStr = trim($qrcodeStr);
	$token = trim($token);

	$sql_r = "select * from ecm_wx_pub_config where token='" . $token . "'";
	$res = mysql_query($sql_r);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		$wx_id = $row['wx_id'];
	}

	$sql = "select * from ecm_wxtuwen where is_subscribe=0 and is_pub=1 and is_default=0 and wx_id=" . $wx_id . " order by update_time desc";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC )){
		$sub_arr[] = $row;
	}
	if(count($sub_arr) == 0){
		return;
	}
	
	foreach($sub_arr as $key => $val){
		$val['allow_uin'] = trim($val['allow_uin']);
		if(empty($val['allow_uin']) || !isset($val['allow_uin'])){
			$arr_e[] = $val;
		}
		
		if(!empty($val['allow_uin'])){
			if(!empty($qrcodeStr)){
				$uin = str_replace("qrscene_","",$qrcodeStr);
				$allow_arr = explode(',', $val['allow_uin']);
				if(in_array($uin, $allow_arr)){
					$arr_ne[] = $val;
				}
			}
		}
	}

	if(count($arr_e) > 0 && count($arr_ne) == 0){
		return $arr_e;
	}

	if(count($arr_ne) > 0 && count($arr_e) == 0){
		return $arr_ne;
	}

	if(count($arr_e) > 0 && count($arr_ne) > 0){
		$new_array = array_merge($arr_e, $arr_ne);
		return $new_array;
	}
	
}



?>