<?php

class StoreyxwApp extends StorebaseApp
{
    function index()
    {
		if(!$this->visitor->has_login)
		{
			header('Location:/index.php?app=member&act=login');
			exit;
		}
		setcookie("diyici",1,time()+31622400);
		$this->assign('diyici', $_COOKIE["diyici"]);
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('请填写正确地址！');
            return;
        }
		$this->dingwei();
		$this->set_store($id);
	    $store = $this->get_store_data();
		$_SESSION['store_id']=$store['store_id'];
		setcookie("sid",$store['store_id'],time()+31622400);
		$this->assign('store', $store);
		$db=&db();
		if($this->visitor->has_login){
			$user_id = $this->visitor->get('user_id');
			$sql_stores="select count(*) from ecm_collect where user_id=".$user_id." and item_id=".$id."  and type='store'";
			
			if(intval($db->getOne($sql_stores))<1)
			{
				$sql_insert="insert into ecm_collect values(".$user_id.",'store',".$id.",'',unix_timestamp())";
				$db->query($sql_insert);
			}
		}
		
		//显示分类
		$this->fenlei();
		if($_SESSION['store_id']>0)
		{
			$sql_cart="DELETE from ecm_cart where  store_id!=".$_SESSION['store_id']." and session_id='".SESS_ID."' ";
             $db->query($sql_cart);
			 $sql_cart1="SELECT * from ecm_cart where  store_id=".$_SESSION['store_id']." and session_id='".SESS_ID."'";
			 $rows=$db->getAll($sql_cart1);
			 $count=0;//数量
			 $amount=0;//总价
			 foreach($rows as $row)
			 {
				 $count=$count+$row['quantity'];// price 
			
				 $amount= $amount+$row['price']*$row['quantity'];
				 
			 }
		 
			 $this->assign("count",$count);
			 $this->assign("amount",$amount);
			 $sql_shipping="select first_price from ecm_shipping where enabled=1 and store_id= ".$_SESSION['store_id']." order by sort_order desc limit 0,1 ";
			 $shipping=$db->getOne($sql_shipping);
			 $this->assign("shipping",$shipping);
		}
		include 'weixinyxw.php';
	    $jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
        $signPackage = $jssdk->GetSignPackage();
	    $this->assign('signPackage', $signPackage);
		$store_id = $_SESSION['store_id'];
		$user_id = $this->visitor->get('user_id');
		$sql = "select * from ecm_address where user_id=" . $user_id . " order by addr_id desc";
		$result = $db->getAll($sql);
		$this->assign('store_id', $store_id);
		$this->assign('address', $result);
		$this->get_content();
		$this->display('zq_goods.html');
    }
	//地图定位
	function dingwei()
	{
		
		$slong=isset($_SESSION['s_long'])?$_SESSION['s_long']:117.129533;
		$slat=isset($_SESSION['s_lat'])?$_SESSION['s_lat']:36.696866;
		$url="http://api.map.baidu.com/geocoder/v2/?ak=2667f496b45f6c9c4e64e6cd8f0344ed&location=".$slat.",".$slong."&output=json&pois=0";
		if(isset($_COOKIE['longlat']))
		{
			$url="http://api.map.baidu.com/geocoder/v2/?ak=2667f496b45f6c9c4e64e6cd8f0344ed&location=".$_COOKIE['longlat']."&output=json&pois=0";
		}
		
		$access_json = $this->https_request($url);
		$access_array = json_decode($access_json, true);
		$qufujin=$access_array['result']['addressComponent']['district'].$access_array['result']['addressComponent']['street'];
		$this->assign('qufujin', $qufujin);
		//print_r($access_array);
		//exit;
	}
	//显示分类
	function fenlei()
	{
		$store_id=isset($_SESSION['store_id'])?$_SESSION['store_id']:0;
		$sql="SELECT cate_id_1,b.cate_name,b.cate_picurl from ecm_goods a
LEFT JOIN ecm_gcategory b on a.cate_id_1=b.cate_id where a.store_id=".$store_id." and a.if_show=1 GROUP BY cate_id_1";
        $db=&db();
		$rows=$db->getAll($sql);
		$this->assign("cates",$rows);
		if(count($rows))
		{
		$this->assign("cate_id_1",$rows[0]['cate_id_1']);	
		}
		
		
	}
	
	 /* 取得商品 */
    function get_goodsyxw()//$num = 4
    {
		include(ROOT_PATH . '/extend/sqlin.php');
		$page=intval($_GET['page'])*10;
		$cate_id=$_GET['cate_id'];
        $goods_mod =& m('goods');
        $store_id=isset($_GET['store_id'])?$_GET['store_id']:0;
		$store_id=intval($store_id);
		$sql="SELECT a.goods_id,a.spec_id,a.price,a.shichang,a.sku,a.stock,b.store_id,b.goods_name,b.default_image from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id
where (b.cate_id_1='".$cate_id."' or b.tags like '%".$cate_id."%'  )and b.store_id=".$store_id." and if_show=1 AND closed=0 ORDER BY b.quanzhong desc limit ".$page.",10";
		$goods_list = $goods_mod->db->getAll($sql);
		

		foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
			$db = &db();
			//检测商品是否显示快讯价格
			$sql="select state kuaixun_state,p_id kuaixun_id,price kuaixun_price from  ecm_kuaixun_promotion_v where (unix_timestamp() between  start_time and end_time ) and  FIND_IN_SET('".$goods_list[$key]['store_id']."',store_id) and  state in (3) and goods_id=".$goods_list[$key]['goods_id'];
			$result = $db->getAll($sql);

			if(count($result) > 0){
				foreach($result as $k => $v){
					$goods_list[$key]['price'] = $result[$k]['kuaixun_price'];
				}
			}
        }
		if(cate_id)
		{
			$this->json_result( $goods_list);
		}else{
			$this->json_result( array());
		}
         
     
    }
	 
	 function get_good()
	 {
		 $spec_id=intval($_GET['spec_id']);
		 $sql="SELECT a.goods_id,a.spec_id,a.price,a.shichang,a.sku,a.stock,b.store_id,b.goods_name,b.default_image,b.description,b.brand,b.cate_name from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id
               where a.spec_id=".$spec_id."  and if_show=1 ";
         $db=&db();
		$rows= $db->getAll($sql);
		if(count($rows))
		{
			$this->json_result( $rows);
		}else
		{
			 $this->json_error('没有数据！');
		}
	 }
	 
	 	 /* 取得商品 */
    function get_bykey()//$num = 4
    {
		include(ROOT_PATH . '/extend/sqlin.php');
		//$page=intval($_GET['page'])*10;
		$cate_id=$_GET['keywords'];
        $goods_mod =& m('goods');
        $store_id=isset($_GET['store_id'])?$_GET['store_id']:0;
		$store_id=intval($store_id);
		$sql="SELECT a.goods_id,a.spec_id,a.price,a.shichang,a.sku,a.stock,b.store_id,b.goods_name,b.default_image from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id
where b.goods_name like '%".$cate_id."%' and b.store_id=".$store_id." and if_show=1 AND closed=0 ORDER BY b.quanzhong desc ";

		$goods_list = $goods_mod->db->getAll($sql);
		

		foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
			$db = &db();
			//检测商品是否显示快讯价格
			$sql="select state kuaixun_state,p_id kuaixun_id,price kuaixun_price from  ecm_kuaixun_promotion_v where (unix_timestamp() between  start_time and end_time ) and  FIND_IN_SET('".$goods_list[$key]['store_id']."',store_id) and  state in (3) and goods_id=".$goods_list[$key]['goods_id'];
			$result = $db->getAll($sql);

			if(count($result) > 0){
				foreach($result as $k => $v){
					$goods_list[$key]['price'] = $result[$k]['kuaixun_price'];
				}
			}
        }
		
         $this->json_result( $goods_list);
     
    }
	 
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
	
	function get_content()
	{
		$store_id=$_SESSION['store_id'];
		$sql_ad="SELECT * from store_ads where store_id=".intval($_SESSION['store_id']);
		$db=&db();
		$rows_ad=$db->getAll($sql_ad);
		if(count($rows_ad))
		{
			$leftmenu=preg_replace("/<parameter>/", $store_id, $rows_ad[0]['menu_value']); 
			$advalue=preg_replace("/<parameter>/", $store_id, $rows_ad[0]['ad_value']); 
			
			$this->assign("menu_content",$leftmenu);
			$this->assign("ad_content",$advalue);
		}
	}
	
}

?>
