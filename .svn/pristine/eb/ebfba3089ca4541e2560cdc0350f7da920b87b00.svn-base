<?php
class BqsellerApp extends MallbaseApp
{
   function index()
   {
    $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
	$db=&db();
	if( $store_id >0){
		$sql="select count(*) totalcount from ecm_order where `status` in(12,20,51) and seller_id=".$store_id;
	}else{
		$sql="select count(*) totalcount from ecm_order where `status` in(12,20,51) ";
	}
	
	if(isset($_SESSION["timestamp"]))
	{
		if( $store_id >0){
	
		$sql_time="select * from ecm_order where `status` in(12,20,51) and seller_id=".$store_id." and add_time>".$_SESSION["timestamp"]." order by add_time desc";
	}else{
			$sql_time="select * from ecm_order where `status` in(12,20,51) and add_time>".$_SESSION["timestamp"]." order by add_time desc";
	
	}
	}else
	{
		if( $store_id >0){
	
		$sql_time="select * from ecm_order where `status` in(12,20,51) and seller_id=".$store_id." order by add_time desc";
	}else{
			$sql_time="select * from ecm_order where `status` in(12,20,51)  order by add_time desc";
	
	}
	}
	$row_sql=$db->getRow($sql_time);
	if(count($row_sql)){
		$_SESSION["timestamp"]=$row_sql['add_time'];
		$have=true;
	}else{
		$_SESSION["timestamp"]=time();
		$have=false;
	}
	if($have){
		$totalcount=$db->getOne($sql);
	}else{
		$totalcount=0;
	}
	$sql_orderyxw="update ecm_order set `status`=40,finished_time=unix_timestamp() where TO_DAYS(NOW()) -TO_DAYS(FROM_UNIXTIME(ship_time))>7 and `status` in (30,13)";
		$db->query($sql_orderyxw);
	
	if($store_id > 0){
		$this->json_result(array('totalcount'=>$totalcount,'sql'=>$sql, 'url' => '/index.php?app=seller_order'),"获取成功！");
	} else {
			$this->json_result(array('totalcount'=>$totalcount,'sql'=>$sql, 'url' => '/admin/index.php?app=order'),"获取成功！");
	}
	
	
	 
   }
   
   function cart()
   {
	   $sku=$this->htmldecode($_GET['sku']);
	   $sid= $_SESSION['store_id'];
	   $sql="SELECT a.goods_id,a.spec_id,b.store_id,a.sku from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id =b.goods_id
where a.sku='".$sku."' and b.store_id=".$sid;

       $db=&db();
	   $all=$db->getAll($sql);
	   if(count($all))
	   {
		 $this->json_result(array('spec_id'=>$all[0]['spec_id'],'sid'=>$all[0]['store_id'],'result'=>1),"获取成功！");
		
	   }else{
		  $this->json_result(array('spec_id'=>0,'sid'=>$sid,'result'=>0),"获取失败！");
		
	   }
	   
   }
    function htmldecode($str)  
      {  
      if(empty($str)) return;  
      if($str=="") return $str;  
      $str=str_replace("select","",$str);  
      $str=str_replace("join","",$str);  
      $str=str_replace("union","",$str);  
      $str=str_replace("where","",$str);  
      $str=str_replace("insert","",$str);  
      $str=str_replace("delete","",$str);  
      $str=str_replace("update","",$str);  
      $str=str_replace("like","",$str);  
      $str=str_replace("drop","",$str);  
      $str=str_replace("create","",$str);  
      $str=str_replace("modify","",$str);  
      $str=str_replace("rename","",$str);  
      $str=str_replace("alter","",$str);  
 
      return $str;  
      } 
}

?>