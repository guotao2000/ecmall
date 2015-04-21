﻿<?php
class ZhuantiApp extends BackendApp
{
	//列表页
	function index(){
		$db=&db();
		$page=$this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		
		if(strlen($_GET['t_zt_code'])>0){
			$condition[]=" zt_code like '%".$_GET['t_zt_code']."%'";
		}elseif(strlen($_GET['t_zt_name'])>0){
			$condition[]=" zt_name like '%".$_GET['t_zt_name']."%'";
		}

		
		$conditions=implode(" and ",$condition);

		$sql="select *,FROM_UNIXTIME(zt_createtime) createtime,FROM_UNIXTIME(zt_edittime) edittime from t_zhuanti  where ".$conditions. " ORDER BY zt_id desc limit ". $page['limit']."";
		$count_sql="select count(*) from t_zhuanti where".$conditions;
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$confs=$db->getAll($sql);

		$this->_format_page($page);
		$this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('zhuantis', $confs);
		$this->display('zhuanti.index.html');
	}
	function add()
	{
		$db=&db();
		if(!IS_POST){
			$this->display('zhuanti.form.html');
		}
		else{
			$arr_values[]=$_POST['zt_code'];
			$arr_values[]=$_POST['zt_name'];
			$arr_values[]=$_POST['zt_content'];
			//$arr_values[]=$_POST['remark'];
			
			$arr_fields[]="zt_code";
			$arr_fields[]="zt_name";
			$arr_fields[]="zt_content";
			$arr_fields[]="remark";
			$sql="insert into t_zhuanti(zt_code,zt_name,zt_content,zt_createtime,zt_createuser,zt_edituser,zt_edittime,zt_state,zt_sctime) 
			values('".$arr_values[0]."','".$arr_values[1]."','".$arr_values[2]."',unix_timestamp(NOW()),'".$this->visitor->get('user_name')."','".$this->visitor->get('user_name')."',unix_timestamp(NOW()),'未生成',0)";
			if($db->query($sql))
			{
				
				$this->show_message('添加专题成功！',
					'back_list',    'index.php?app=zhuanti',
					'continue_add', 'index.php?app=zhuanti&amp;act=add'
					);
			}
		}
	}
	
	function edit()
	{
		$db=&db();
		if(!IS_POST)
		{
			
			$sql="select *, FROM_UNIXTIME(zt_createtime) createtime, FROM_UNIXTIME(zt_edittime) edittime, FROM_UNIXTIME(zt_sctime) sctime from t_zhuanti where zt_id=".trim($_GET['id']);
			$this->assign("zhuanti", $db->getRow($sql));
			$this->display('zhuanti.form.html');
			
		}else{
			$update="update t_zhuanti set zt_code='".$_POST['zt_code']."',zt_name='".$_POST['zt_name']."',zt_content='".$_POST['zt_content']."',zt_edittime=unix_timestamp(NOW()),zt_edituser='".$this->visitor->get('user_name')."' where zt_id=".$_POST['zt_id'];
			
			if($db->query($update)){
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('修改专题成功！',
					'back_list',    'index.php?app=zhuanti',
					'continue_add', 'index.php?app=zhuanti&amp;act=add'
					);
			}
			
		}
	}
	
	function drop()
	{
		$db=&db();
		$id=intval($_GET['id']);
		$sql="delete from t_zhuanti where zt_id=".$id."";
		if($db->query($sql)){
			//header("Location: /admin/index.php?app=conf "); 
			$this->show_message('删除专题成功！',
				'back_list',    'index.php?app=zhuanti',
				'continue_add', 'index.php?app=zhuanti&amp;act=add'
				);
		}
		
	}
	
	//生成php文件
	function zhuanti()
	{
		$id=intval($_GET['id']);
		$store_id=intval($_GET['store_id']);
		$db=&db();
		$sql="select * from t_zhuanti where zt_id=5";//.$id;
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
		
		echo $content;
		
		
	}
}










?>