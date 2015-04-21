<?php
class ConfApp extends BackendApp
{
	//配置项列表页
	function index()
	{
		$db=&db();
		$page=$this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		
		if(strlen($_GET['t_conf_code'])>0){
			$condition[]=" conf_code like '%".$_GET['t_conf_code']."%'";
		}elseif(strlen($_GET['t_conf_name'])>0){
			$condition[]=" conf_name like '%".$_GET['t_conf_name']."%'";
			}
		elseif(strlen($_GET['t_conf_value'])>0){
			$condition[]=" conf_value like '%".$_GET['t_conf_value']."%'";
		}
			//print_r($condition);
			//exit();
		
		$conditions=implode(" and ",$condition);
		//if(!IS_POST){
		$sql="select * from ecm_conf  where ".$conditions. " limit ". $page['limit']."";
			$count_sql="select count(*) from ecm_conf where".$conditions;
			$page['item_count']=$db->getOne($count_sql);   //获取统计数据
			$confs=$db->getAll($sql);
		//}else{
	
		//}
		$this->_format_page($page);
		$this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('confs', $confs);
		$this->display('conf.index.html');
		
	}
	
	//配置项添加
	function add()
	{
		$db=&db();
		if(!IS_POST){
			$this->display('conf.form.html');
			}
		else{
		$arr_values[]=$_POST['conf_code'];
		$arr_values[]=$_POST['conf_name'];
		$arr_values[]=$_POST['conf_value'];
		$arr_values[]=$_POST['remark'];
		
		$arr_fields[]="conf_code";
		$arr_fields[]="conf_name";
		$arr_fields[]="conf_value";
		$arr_fields[]="remark";
			$sql="insert into ecm_conf(".implode(",",$arr_fields).") values('".implode("','",$arr_values)."')";
		if($db->query($sql))
		{
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('添加配置项成功！',
					'back_list',    'index.php?app=conf',
					'continue_add', 'index.php?app=conf&amp;act=add'
					);
		}
		}
		
	}
	
	function edit()
	{
		$db=&db();
		if(!IS_POST)
		{
			
			$sql="select * from ecm_conf where conf_id=".trim($_GET['id']);
			$this->assign("conf", $db->getRow($sql));
			$this->display('conf.form.html');
			
		}else{
			$update="update ecm_conf set conf_code='".$_POST['conf_code']."',conf_name='".$_POST['conf_name']."',conf_value='".$_POST['conf_value']."',remark='".$_POST['remark']."' where conf_id=".$_POST['conf_id'];
			
			if($db->query($update)){
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('修改配置项成功！',
					'back_list',    'index.php?app=conf',
					'continue_add', 'index.php?app=conf&amp;act=add'
					);
			}
			
		}
	}
	
	
	function drop()
	{
		$db=&db();
		$id=intval($_GET['id']);
		$sql="delete from ecm_conf where conf_id=".$id."";
		if($db->query($sql)){
			//header("Location: /admin/index.php?app=conf "); 
			$this->show_message('删除配置项成功！',
				'back_list',    'index.php?app=conf',
				'continue_add', 'index.php?app=conf&amp;act=add'
				);
		}
		
	}
	
}


?>