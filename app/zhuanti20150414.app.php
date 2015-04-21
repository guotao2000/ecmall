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
}