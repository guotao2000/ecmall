<?php
class CouponadminApp extends BackendApp
{
	//配置项列表页
	function index()
	{
		$db=&db();
		$page=$this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		
		if(strlen($_GET['t_coupon_id'])>0){
			$condition[]=" coupon_id like '%".$_GET['t_coupon_id']."%'";
		}elseif(strlen($_GET['t_store_id'])>0){
			$condition[]=" store_id like '%".$_GET['t_store_id']."%'";
			}
		elseif(strlen($_GET['t_coupon_name'])>0){
			$condition[]=" coupon_name like '%".$_GET['t_coupon_name']."%'";
		}
			//print_r($condition);
			//exit();
		
		$conditions=implode(" and ",$condition);
		//if(!IS_POST){
		$sql="SELECT coupon_id,store_id,coupon_name,coupon_value,use_times,FROM_UNIXTIME(start_time) start_time,FROM_UNIXTIME(end_time) end_time,min_amount,if_issue,stores_allow,cate_noallow,remark from ecm_coupon  where ".$conditions. " limit ". $page['limit']."";
			$count_sql="select count(*) from ecm_coupon where".$conditions;
			$page['item_count']=$db->getOne($count_sql);   //获取统计数据
			$confs=$db->getAll($sql);
		//}else{
	
		//}
		$this->_format_page($page);
		$this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('confs', $confs);
		$this->display('couponadmin.index.html');
		
	}
	
	//配置项添加
	function add()
	{
		$db=&db();
		if(!IS_POST){
			 $gcate_mod =& m('gcategory');
            $this->assign('cates', $gcate_mod->get_optionsyxw(0,0,1));
			$this->display('couponadmin.form.html');
			}
		else{
		$arr_values[]=$_POST['store_id'];
		$arr_values[]=$_POST['coupon_name'];
		$arr_values[]=$_POST['coupon_value'];
		$arr_values[]=$_POST['use_times'];
		$arr_values[]=strtotime($_POST['start_time']);
		$arr_values[]=strtotime($_POST['end_time']);
		$arr_values[]=$_POST['min_amount'];
		$arr_values[]=$_POST['if_issue'];
		$arr_values[]=$_POST['stores_allow'];
		$arr_values[]=$_POST['cate_noallow'];
		$arr_values[]=$_POST['remark'];
		
		
		$arr_fields[]='store_id';
		$arr_fields[]='coupon_name';
		$arr_fields[]='coupon_value';
		$arr_fields[]='use_times';
		$arr_fields[]='start_time';
		$arr_fields[]='end_time';
		$arr_fields[]='min_amount';
		$arr_fields[]='if_issue';
		$arr_fields[]='stores_allow';
		$arr_fields[]='cate_noallow';
		$arr_fields[]='remark';
			$sql="insert into ecm_coupon(".implode(",",$arr_fields).") values('".implode("','",$arr_values)."')";
		if($db->query($sql))
		{
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('添加红包成功！',
					'back_list',    'index.php?app=couponadmin',
					'continue_add', 'index.php?app=couponadmin&amp;act=add'
					);
		}
		}
		
	}
	
	function edit()
	{
		$db=&db();
		if(!IS_POST)
		{
			
			$sql="SELECT coupon_id,store_id,coupon_name,coupon_value,use_times,FROM_UNIXTIME(start_time) start_time,FROM_UNIXTIME(end_time) end_time,min_amount,if_issue,stores_allow,cate_noallow,remark from ecm_coupon where coupon_id=".trim($_GET['id']);
			$rows=$db->getAll($sql);
			$this->assign("coupon", $rows[0]);
			 $gcate_mod =& m('gcategory');
            $this->assign('cates', $gcate_mod->get_optionsyxw(0,0,1));
			$cates=explode(",",$rows[0]['cate_noallow']);
			$cates=array_filter($cates);
			$cateids=implode(",",$cates);
			if(count($cates)){
			$sql_cate="SELECT * from ecm_gcategory where cate_id in(".$cateids.")";
			$rows_cate=$db->getAll($sql_cate);
			foreach($rows_cate as $key=>$val)
			{
				$cate[][$val['cate_id']]=$val['cate_name'];
			}
			$this->assign("cateids",$cate);
			}
			//print_r($cate);
			//exit;
			$this->display('couponadmin.form.html');
			
		}else{
			$update="update ecm_coupon set store_id='".$_POST['store_id']."',coupon_name='".$_POST['coupon_name']."',coupon_value='".$_POST['coupon_value']."',use_times='".$_POST['use_times']."'
			,start_time=UNIX_TIMESTAMP('".$_POST['start_time']."'),end_time=UNIX_TIMESTAMP('".$_POST['end_time']."'),min_amount='".$_POST['min_amount']."'
			,if_issue='".$_POST['if_issue']."',stores_allow='".$_POST['stores_allow']."',cate_noallow='".$_POST['cate_noallow']."',remark='".$_POST['remark']."'   where coupon_id=".$_POST['coupon_id'];
			
			if($db->query($update)){
				//header("Location: /admin/index.php?app=conf "); 
				$this->show_message('修改红包成功！',
					'back_list',    'index.php?app=couponadmin',
					'continue_add', 'index.php?app=couponadmin&amp;act=add'
					);
			}
			
		}
	}
	
	
	function drop()
	{
		$db=&db();
		$id=intval($_GET['id']);
		$sql="delete from ecm_coupon where coupon_id=".$id."";
		if($db->query($sql)){
			//header("Location: /admin/index.php?app=conf "); 
			$this->show_message('删除红包成功！',
				'back_list',    'index.php?app=couponadmin',
				'continue_add', 'index.php?app=couponadmin&amp;act=add'
				);
		}
		
	}
	
}


?>