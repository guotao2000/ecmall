<?php

class ZhuantiApp extends StorebaseApp
{
	function index()
	{
		$id=intval($_GET['id']);
		$store_id=intval($_GET['store_id']);
		$db=&db();
		$sql="select * from t_zhuanti where zt_id=".$id;
		$row_zt=$db->getRow($sql);
		//print_r($row_zt);
		$content=$row_zt['zt_content'];
		//var_dump($content); 
		$pattern = '/<AREA_CODE>(.+?)<\/AREA_CODE>/';
		$matches = array();
		//根据店铺 统计购物车价格数量
		$cart = $db->getAll('select * from ecm_cart where store_id='.$store_id);
		$price = $cart['price']*$cart['quantity'];
		$count =  $cart['quantity'];
		//dump($amount);
		if(preg_match_all($pattern, $content, $matches)){
			$matches=$matches[1];
		}
		
		foreach($matches as $v)
		{
			$sql_area="select * from t_qukuai where qk_code='".$v."'";
			$row_area=$db->getRow($sql_area);//qk_id  qk_code qk_name qk_yes qk_sql qk_xhtop qk_xhbody qk_xhbottom
			
			if($row_area['qk_yes'])//parameter
			{
				$content_a="";
				$content_a.=$row_area['qk_xhtop'];
				$sql_a=preg_replace("/<parameter>/", $store_id, $row_area['qk_sql']); 
				$rows_a=$db->getAll($sql_a);//
				foreach($rows_a as $row_a)
				{
					$li=$row_area['qk_xhbody'];
					$pattern_li = '/<FIELD>(.+?)<\/FIELD>/';
					///价格数量
					$matches_li = array();
					
					if(preg_match_all($pattern_li, $li, $matches_li)){
						$matches_li=$matches_li[1];
					}
					foreach($matches_li as $f_li)
					{
						$pattern_a='/<FIELD>'.$f_li.'<\/FIELD>/';
						$li=preg_replace($pattern_a, $row_a[$f_li], $li);  
					}
					$content_a.=$li;
				}
				$content_a.=$row_area['qk_xhbottom'];
				$pattern_a = "/<AREA_CODE>".trim($row_area['qk_code'])."<\/AREA_CODE>/";
				$content= preg_replace($pattern_a, $content_a, $content); 
				
			}else{
				$pattern_a = "/<AREA_CODE>".trim($row_area['qk_code'])."<\/AREA_CODE>/";
				$replacement = $row_area['qk_xhbody'];  
				$content= preg_replace($pattern_a, $replacement, $content); 
			}
			
		}
		header("Content-Type: text/html;charset=utf-8");
		
		echo $content;
		
		
	}
	
	 function to_carts(){
		
		$store_id = $_REQUEST['store_id'];
	
	 	if($store_id>0)
		{
			 $db=&db();
			 $sql_cart1="SELECT * from ecm_cart where  store_id=".$store_id." and session_id='".SESS_ID."'";
			 $rows=$db->getAll($sql_cart1);
			
			 
			 $arr['count']=0;//数量
			 $arr['amount']=0;//总价
			 foreach($rows as $row)
			 {
				 $arr['count']=$arr['count']+$row['quantity'];// price 
			
				 $arr['amount']= $arr['amount']+$row['price']*$row['quantity'];
				 
			 }
			// $arr['amount'] = number_format($arr['amount'],2,'.','');
		 
			 $sql_shipping="select first_price from ecm_shipping where enabled=1 and store_id= ".$store_id." order by sort_order desc limit 0,1 ";
			 $arr['shipping']=$db->getOne($sql_shipping);
		}
		echo json_encode($arr);
		//echo json_encode($arr['shipping']);
		 
	 }
	
}