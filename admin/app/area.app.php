<?php
class AreaApp extends BackendApp
{
	function index()
	{
		$db=&db();
		$page=$this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		
		if(strlen($_GET['t_qk_code'])>0){
			$condition[]=" qk_code like '%".$_GET['t_qk_code']."%'";
		}elseif(strlen($_GET['t_qk_name'])>0){
			$condition[]=" qk_name like '%".$_GET['t_qk_name']."%'";
		}

		
		$conditions=implode(" and ",$condition);

		$sql="select *,FROM_UNIXTIME(qk_time) qk_time1 from t_qukuai  where ".$conditions. " ORDER BY qk_id desc limit ". $page['limit']."";
		$count_sql="select count(*) from t_qukuai where".$conditions;
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$confs=$db->getAll($sql);

		$this->_format_page($page);
		$this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('areas', $confs);
		$this->display('area.index.html');
	}
	function add()
	{
		$db=&db();
		if(!IS_POST){
			$this->assign('qk_yeses', array(
				'1'   =>'是',
				'0' =>'否',
				));
			$this->display('area.form.html');
		}
		else{
			$arr_values[]=$_POST['qk_code'];
			$arr_values[]=$_POST['qk_name'];
			$arr_values[]=$_POST['qk_yes'];
			$arr_values[]=$_POST['qk_sql'];
			$arr_values[]=$_POST['qk_xhtop'];
			$arr_values[]=$_POST['qk_xhbody'];
			$arr_values[]=$_POST['qk_xhbottom'];
			//$arr_values[]=$_POST['remark'];
			
			$arr_fields[]="qk_code";
			$arr_fields[]="qk_name";
			$arr_fields[]="qk_yes";
			$arr_fields[]="qk_sql";
			$arr_fields[]="qk_xhtop";
			$arr_fields[]="qk_xhbody";
			$arr_fields[]="qk_xhbottom";
			$sql="insert into t_qukuai(".implode(",",$arr_fields).",qk_time) values('".implode("','",$arr_values)."',unix_timestamp() )";
			
			if($db->query($sql))
			{
				
				$this->show_message('添加区块成功！',
					'back_list',    'index.php?app=area',
					'continue_add', 'index.php?app=area&amp;act=add'
					);
			}
		}
	}
	
	function edit()
	{
		$db=&db();
		if(!IS_POST)
		{
			$this->assign('qk_yeses', array(
				'1'   =>'是',
				'0' =>'否',
				));
			$sql="select * from t_qukuai where qk_id=".trim($_GET['id']);
			$this->assign("area", $db->getRow($sql));
			$this->display('area.form.html');
			
		}else{
			$update="update t_qukuai set qk_code='".$_POST['qk_code']."',qk_name='".$_POST['qk_name']."',qk_yes='".$_POST['qk_yes']."',qk_sql='".$_POST['qk_sql']."',qk_xhtop='".$_POST['qk_xhtop']."',qk_xhbody='".$_POST['qk_xhbody']."',qk_xhbottom='".$_POST['qk_xhbottom']."' where qk_id=".$_POST['qk_id'];
			
			if($db->query($update)){
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('修改区块项成功！',
					'back_list',    'index.php?app=area',
					'continue_add', 'index.php?app=area&amp;act=add'
					);
			}
			
		}
	}
	
	function drop()
	{
		$db=&db();
		$id=intval($_GET['id']);
		$sql="delete from t_qukuai where qk_id=".$id."";
		if($db->query($sql)){
			$this->show_message('删除区块项成功！',
				'back_list',    'index.php?app=area',
				'continue_add', 'index.php?app=area&amp;act=add'
				);
		}
		
	}
	
	
	
}