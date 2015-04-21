<?php

/**
 *    订单确认时显示地址
 *    @author    Summer
 *    @time    2014-12-19
 */
class AddressApp extends MemberbaseApp
{
    function index(){
        if(!$this->visitor->has_login)
		{
			echo -1;
			exit;
		}
		$user_id = $this->visitor->get('user_id');
		$str_sql="SELECT * from ecm_address a where a.user_id=".$user_id;
		$db=&db();
		$rows=$db->getALL($str_sql);
		echo count($rows);
		exit;
		
    }
    //添加地址
    function add_address(){
		if (!IS_POST)
        {
			$db=&db();
			$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
			$this->assign('store_id', $store_id);
			$this->_get_regions();
			/*/*$string_sql="select cod_regions from ecm_shipping where store_id=".$store_id;
			$row=unserialize($db->getOne($string_sql));
			$rows1=$db->getALL($string_sql);
			if($row)
			{
				
				foreach($row as $key => $value)
				{
					$this->assign('sregion_id',$key);
				}
				$count_row=count($row);
				$nostores=getConf('malls');
               if(!empty($nostores)&&strlen(trim($nostores))>1)
				{
					$ids=array_filter(explode(",",$nostores));
					foreach($ids as $v)
					{
						if($v==$store_id)
						{
		                  
							$count_row=0;	
							break;	
						}
					}
				}
				$this->assign('countrows',$count_row);
				foreach($rows1 as $key => $value)
				{
					foreach(unserialize($value['cod_regions']) as $k => $v)
					{
						
						$codes=explode("\t",$v);
						
						$row2[$k]=$codes[count($codes)-1];
					} 
					//$row2[$key]=unserialize($value['cod_regions']);
				}
				
			
				$this->assign('rows',$row2);
			}else{*/
				if(intval($_GET['region_id']))
				{
					//echo intval($_GET['region_id']);
					$this->assign('sregion_id',intval($_GET['region_id']));
					$this->assign('region_name',$_SESSION['region_name']);
					
				}else{
					$this->assign('sregion_id',2211);
				}
				
				//	}

			$this->display('address.add.html');
		} else {
			$store_id = isset($_POST['store_id'])? intval($_POST['store_id']):0;
			if(!$store_id)
			{
				$store_id = isset($_SESSION['store_id'])? intval($_SESSION['store_id']):0;
			}
			$data = array(
                'user_id'       => $this->visitor->get('user_id'),
                'consignee'     => $_POST['consignee'],
                'region_id'     => $_POST['region_id'],
                'region_name'   => $_POST['region_name'],
                'address'       => $_POST['address_detail'],
                'phone_mob'     => $_POST['phone_mob']
            );
            $model_address =& m('address');
			$address_id = $model_address->add($data);
            if (!($address_id ))
            {
                $this->pop_warning($model_address->get_error());

                return;
            }
			if($this->visitor->has_login)
			{
				$user_id = $this->visitor->get('user_id');
				$str1="update  ecm_address set `enable`=0 where user_id=".$user_id;
				$str2="update  ecm_address set `enable`=1 where user_id=".$user_id." and addr_id=".$address_id;
				$model_address->db->query($str1);
				$model_address->db->query($str2);
				
			}
            //地址跳转
			//header('Location: index.php?app=address&act=list_address&store_id=' . $store_id);
			$this->show_message('地址添加成功！',
				'back_before_register', 'index.php?app=storeyxw&status=0&id=' . $store_id
					);
			exit;
		}
    }
	function _get_regions()
    {
        $model_region =& m('region');
        $regions = $model_region->get_list(0);
        if ($regions)
        {
            $tmp  = array();
            foreach ($regions as $key => $value)
            {
                $tmp[$key] = $value['region_name'];
            }
            $regions = $tmp;
        }
        $this->assign('regions', $regions);
    }
	//列出地址
	function list_address(){
		$db = &db();
		$store_id = isset($_SESSION['store_id'])? intval($_SESSION['store_id']):0;
		$user_id = $this->visitor->get('user_id');
		$sql = "select * from ecm_address where user_id=" . $user_id . " order by addr_id desc";
		$result = $db->getAll($sql);
		$this->assign('store_id', $store_id);
		$this->assign('address', $result);
		include 'weixinyxw.php';
	    $jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
        $signPackage = $jssdk->GetSignPackage();
	    $this->assign('signPackage', $signPackage);
		$this->display('addressyxw.list.html');	
	}
	//删除地址
	function del_address(){
		$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
		$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;
		$db = &db();
		$sql = "delete from ecm_address where addr_id=" . $addr_id;
		$result = $db->query($sql);
		
		if($result){
			//地址跳转
			//header('Location: index.php?app=address&act=list_address&store_id=' . $store_id);
			//exit;
			$this->show_message('地址删除成功！',
				'back_before_register', 'index.php?app=address&act=list_address&store_id=' . $store_id
					);
			exit;
		}
		
	}
	//编辑地址
	function edit_address(){
		if(!IS_POST){
			$this->_get_regions();
			$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
			$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;	
			$db = &db();
			$sql = "select * from ecm_address where addr_id=" . $addr_id;
			$result = $db->getAll($sql);
			foreach($result as $v){
				$res = $v;	
			}
			$this->assign('address', $res);
				include 'weixinyxw.php';
	$jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
        $signPackage = $jssdk->GetSignPackage();
	$this->assign('signPackage', $signPackage);
			$this->display('address.edit.html');
		} else {
			//更新地址
			$addr_id = isset($_POST['addr_id'])? intval($_POST['addr_id']):0;
			$db = &db();
			$sql = "update ecm_address set user_id=" . $this->visitor->get('user_id') . ", consignee='" . $_POST['consignee'] . "', region_id=" . $_POST['region_id'] . ", region_name='" . $_POST['region_name'] . "', address='" . $_POST['address_detail'] . "', phone_mob='" . $_POST['phone_mob'] . "' where addr_id=" . $addr_id;
			
			//地址跳转
			if ($db->query($sql))
			{
				//header('Location: index.php?app=address&act=list_address&store_id=' . $_GET['store_id']);
				//exit;
				/*$this->show_message('地址修改成功！',
				'back_before_register', 'index.php?app=address&act=list_address&store_id=' . $_GET['store_id']
					);
				exit;*/
				if($this->visitor->has_login)
				{
					$user_id = $this->visitor->get('user_id');
					$str1="update  ecm_address set `enable`=0 where user_id=".$user_id;
					$str2="update  ecm_address set `enable`=1 where user_id=".$user_id." and addr_id=".$addr_id;
					$db->query($str1);
					$db->query($str2);
					
				}
				$this->show_message('地址修改成功！',
			'back_before_register', 'index.php?app=storeyxw&status=0&id=' . $_GET['store_id']
				);
			    exit;
			}
			
		}
			
	}
	//设为默认地址
	function enable_address(){
		$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
		$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;	
		$user_id = $this->visitor->get('user_id');
		$db = &db();
		//将该地址设为默认
		$sql = "update ecm_address set enable=1 where user_id=" . $user_id . " and addr_id=" . $addr_id;
		$db->query($sql);
		
		//获取该用户所有地址
		$sql = "select * from ecm_address where user_id=" . $user_id;
		$result = $db->getAll($sql);
		
		for($i=0; $i<count($result); $i++){
			if($result[$i]['addr_id'] != $addr_id){
				$db->query("update ecm_address set enable=0 where addr_id=" . $result[$i]['addr_id']);
			}	
		}
		//地址跳转
		header('Location: index.php?app=order&goods=cart&store_id=' . $store_id);
		exit;
	}

	//获取当前位置
	function get_local()
	{
		 
		$slong=isset($_GET['s_long'])?$_GET['s_long']:117.129533;
		$slat=isset($_GET['s_lat'])?$_GET['s_lat']:36.696866;
		//$_SESSION['s_long']=$lng;
		//$_SESSION['s_lat']=$lat;
		if($_GET['type']=='weixin'){
		$url="http://api.map.baidu.com/geoconv/v1/?coords=".$slong.",".$slat."&from=1&to=5&ak=2667f496b45f6c9c4e64e6cd8f0344ed";
		$access_json = $this->https_request($url);
		$access_array = json_decode($access_json, true);
		$slong=$access_array['result'][0]['x'];
		$slat=$access_array['result'][0]['y'];
		//$qu_name=$access_array['result']['addressComponent']['district'];
		}
		
		$url="http://api.map.baidu.com/geocoder/v2/?ak=2667f496b45f6c9c4e64e6cd8f0344ed&location=".$slat.",".$slong."&output=json&pois=0";
		$access_json = $this->https_request($url);
		$access_array = json_decode($access_json, true);
		$sheng_name=$access_array['result']['addressComponent']['province'];
		$sql_sheng="SELECT * from ecm_region where parent_id=1 and LOCATE(region_name, '".$sheng_name."')>0";
		
		$db=&db();
		$rows_sheng=$db->getALL($sql_sheng);
		$region_id=0;
		
		if(count($rows_sheng))
		{
			//echo "yi";
			$region_id=$rows_sheng[0]['region_id'];
			$shi_name=$access_array['result']['addressComponent']['city'];
			$sql_shi="SELECT * from ecm_region where parent_id=".$rows_sheng[0]['region_id']." and LOCATE(region_name, '".$shi_name."')>0";
			$rows_shi=$db->getALL($sql_shi);
			
			if(count($rows_shi))
			{
				//echo "er";
				$region_id=$rows_shi[0]['region_id'];
				$qu_name=$access_array['result']['addressComponent']['district'];
				$sql_qu="SELECT * from ecm_region where parent_id=".$rows_shi[0]['region_id']." and LOCATE(region_name, '".$qu_name."')>0";
			    $rows_qu=$db->getALL($sql_qu);
				//echo $sql_qu;
				if(count($rows_qu))
				{
					//echo "san";
					$region_id=$rows_qu[0]['region_id'];
					
				}
			}
		}
		$_SESSION['region_name']=$access_array['result']['sematic_description'];
		//echo $region_id;
		
		//$street=$access_array['result']['addressComponent']['street'];//street_number
		//$street_number=$access_array['result']['addressComponent']['street_number'];
		//$access_array['result']['sematic_description']
		$this->json_result(array('region_id'=>$region_id,'region_name'=>$_SESSION['region_name']),"获取成功！");
		//print_r($access_json);
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
	}

?>