<?php
class StoreadsApp extends BackendApp
{
	//配置项列表页
	function index()
	{
		$db=&db();
		$page=$this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		
		if(strlen($_GET['store_id'])>0){
			$condition[]=" store_id like '%".$_GET['store_id']."%'";
		}elseif(strlen($_GET['store_name'])>0){
			$condition[]=" store_name like '%".$_GET['store_name']."%'";
			}

			//print_r($condition);
			//exit();
		
		$conditions=implode(" and ",$condition);
		//if(!IS_POST){
		$sql="select * from store_ads  where ".$conditions. " limit ". $page['limit']."";
			$count_sql="select count(*) from store_ads where".$conditions;
			$page['item_count']=$db->getOne($count_sql);   //获取统计数据
			$confs=$db->getAll($sql);
		//}else{
	
		//}
		$this->_format_page($page);
		$this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('confs', $confs);
		$this->display('storeads.index.html');
		
	}
	
	//配置项添加
	function add()
	{
		$db=&db();
		if(!IS_POST){
			$this->display('storeads.form.html');
			}
		else{
		$arr_values[]=$_POST['store_id'];
		$arr_values[]=$_POST['store_name'];
		$arr_values[]=$_POST['ad_value'];
		$arr_values[]=$_POST['menu_value'];
		
		$arr_fields[]="store_id";
		$arr_fields[]="store_name";
		$arr_fields[]="ad_value";
		$arr_fields[]="menu_value";
			$sql="insert into store_ads(".implode(",",$arr_fields).") values('".implode("','",$arr_values)."')";
		if($db->query($sql))
		{
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('添加成功！',
					'back_list',    'index.php?app=storeads',
					'continue_add', 'index.php?app=storeads&amp;act=add'
					);
		}
		}
		
	}
	
	function edit()
	{
		$db=&db();
		if(!IS_POST)
		{
			
			$sql="select * from store_ads where store_id=".trim($_GET['id']);
			$this->assign("conf", $db->getRow($sql));
			$this->display('storeads.form.html');
			
		}else{
			$update="update store_ads set store_id='".$_POST['store_id']."',store_name='".$_POST['store_name']."',ad_value='".$_POST['ad_value']."',menu_value='".$_POST['menu_value']."' where store_id=".$_POST['store_id'];
			
			if($db->query($update)){
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('修改成功！',
					'back_list',    'index.php?app=storeads',
					'continue_add', 'index.php?app=storeads&amp;act=add'
					);
			}
			
		}
	}
	
	
	function drop()
	{
		$db=&db();
		$id=intval($_GET['id']);
		$sql="delete from store_ads where store_id=".$id."";
		if($db->query($sql)){
			//header("Location: /admin/index.php?app=conf "); 
			$this->show_message('删除成功！',
				'back_list',    'index.php?app=storeads',
				'continue_add', 'index.php?app=storeads&amp;act=add'
				);
		}
		
	}
	
}


?>