<?php

class CouponyxwApp extends MallbaseApp
{
	var $_coupon_mod;
	var $_store_id;
	var $_couponsn_mod;
	 function CouponyxwApp()
    {
        parent::__construct();
        //$this->_store_id  = intval($this->visitor->get('manage_store'));
        //$this->_store_mod =& m('store');
        //$this->_coupon_mod =& m('coupon');
        $this->_couponsn_mod =& m('couponsn');
    }
	function index()
	{
		if(!IS_POST)
		{
			$int_hbid=isset($_GET['id'])?intval($_GET['id']):0;
			$sql="SELECT * from ecm_coupon where UNIX_TIMESTAMP(NOW()) BETWEEN start_time and end_time and if_issue=1 and coupon_id=".$int_hbid;
			$db=&db();
			$rows=$db->getAll($sql);
			if(count($rows))
			{
				$this->assign("coupon_count",count($rows));
				
			}else{
				$this->assign("coupon_count",count($rows));
			}
			$this->display("qianghongbao.html");
		}else{
			 $user_id =0;
			if($this->visitor->has_login)
		    {
			   $user_id = $this->visitor->get('user_id');
			   
			   
		    }else{

			//dump($_POST);
			$ms =& ms(); //连接用户中心
			$user_name = trim($_POST['mobile']);
			$mobile  = trim($_POST['mobile']);
			$password = $mobile;
			$real_name=trim($_POST['mobile']);
			
			$passlen = strlen($mobile);
			$user_name_len = strlen($user_name);
			if ($user_name_len < 3 || $user_name_len > 25)
			{
				$this->show_message('user_name_length_error');

				return;
			}

			
			$data = array(
				'parentid' => $_COOKIE["uin"],
				'real_name'=>$user_name,
				);
			//先判断用户是否是老用户，若是直接登录，否则注册
			$db = & db();
			$sql_user="SELECT user_id from ecm_member where user_name='".$mobile."'";
			$user_id=$db->getOne($sql_user);
			if(empty($user_id))
			{
				$user_id = $db->getOne("select a.user_id from ecm_member a LEFT JOIN ecm_address b on a.user_id=b.user_id where b.phone_mob='".$mobile."'");
				if(empty($user_id)){
					
					//注册
					$user_id = $ms->user->register_sec($mobile, $password,$data);
				
				}
			}
			$this->_do_login($user_id);
           }
		   if($user_id<1)
		   {
			   $this->show_message('非法输入，用户不存在！');
			   return;
		   }
		   $int_hbid=isset($_GET['id'])?intval($_GET['id']):0;
		   $sql_coupon="SELECT a.*,b.coupon_id from ecm_user_coupon a LEFT JOIN
ecm_coupon_sn b on a.coupon_sn=b.coupon_sn where a.user_id=".$user_id." and b.coupon_id=".$int_hbid;
		   
			$sql="SELECT * from ecm_coupon where UNIX_TIMESTAMP(NOW()) BETWEEN start_time and end_time and if_issue=1 and coupon_id=".$int_hbid;
			$db=&db();
			$rows_yi=$db->getAll($sql_coupon);
			/*if(count($rows_yi))
			{
			   $this->show_message('亲，您已经领取过红包了，可以直接去购买商品使用了！');
			   return;	
			}*/
			if(count($rows_yi))
			{
			   $this->show_message('亲，您已经领取过红包了，可以直接去购买商品使用了！',
			   	'back_list', 'index.php?app=hongbao');
			   return;	
			}
			$rows=$db->getAll($sql);
			if(count($rows))
			{
				$this->_store_id=$rows[0]['store_id'];
				$this->generate(1,$int_hbid);
				//注册发红包操作   begin
		        $results = $db->getAll("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_id=".$int_hbid." and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc");
			     if(count($results) > 0)
				 {
					
					foreach($results as $val){
						$coupon_sn = $val['coupon_sn'];
						break;
					}
					$db->query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $user_id . ",'" . $coupon_sn . "')");
					header('Location:/index.php?app=couponyxw&act=qianghb&sid='.$this->_store_id.'&hbid='.$int_hbid.'');
					exit();
				 }
				 else
				 {
					  $this->show_message('亲，您来晚了，红包抢没了，下次争取早点！');
			          return;
				 }
				
			}else{
			   $this->show_message('红包发放完毕！');
			   return;
			}
			  
		   
		}
	}
   //批量生成红包sn
	function bqcoupon()
	{
		$coupon_id=intval($_GET['coupon_id']);
		$store_id=intval($_GET['store_id']);
		$count=intval($_GET['count']);
		
		if(empty($coupon_id)||empty($store_id)||empty($count))
		{
			echo "有参数输入错误，请确认！";
		}
		$sql_store="select * from ecm_store where power_coupon=1 and store_id=".$store_id;
		$db=&db();
		if(!count($db->getAll($sql_store)))
		{
			echo "没有权限操作！！";
		}
		$sql_qixian="select * from ecm_coupon where store_id=".$store_id." and coupon_id=".$coupon_id." and end_time>unix_timestamp() and if_issue=1";
		$row_qixian=$db->getRow($sql_qixian);
		
		if(!count($db->getAll($sql_qixian)))
		{
			echo "没有指定红包信息！";
		}else{
			$id=$row_qixian['coupon_id'];
			$this->generate($count, $id); 
			echo "生成成功！";
		}
	}
    //生成红包
	function generate($num, $id)
    {
		
		$this->_coupon_mod =& m('coupon');
        $use_times = $this->_coupon_mod->get(array('fields' => 'use_times', 'conditions' => 'store_id = ' . $this->_store_id . ' AND coupon_id = ' . $id));

        if ($num > 1000)
        {
            $num = 1000;
        }
        if ($num < 1)
        {
            $num = 1;
        }
        $times = $use_times['use_times'];
        $add_data = array();
        $str = '';
        $pix = 0;
        if (file_exists(ROOT_PATH . '/data/generate.txt'))
        {
            $s = file_get_contents(ROOT_PATH . '/data/generate.txt');
            $pix = intval($s);
        }
        $max = $pix + 1;
        file_put_contents(ROOT_PATH . '/data/generate.txt', $max);
		//exit();
        $couponsn = '';
        $tmp = '';
        $cpm = '';
        $str = '';
        //for ($i = $pix + 1; $i <= $max; $i++ )
		for ($i = 0; $i < $num; $i++ )
        {
			$k=intval($pix.''.$i);
            $cpm = sprintf("%08d", $k);
            $tmp = mt_rand(1000, 9999);
            $couponsn = $cpm . $tmp;
            $str .= "('{$couponsn}', {$id}, {$times}),";
            $add_data[] = array(
                'coupon_sn' => $couponsn,
                'coupon_id' => $id,
                'remain_times' => $times,
                );
        }
        $string = substr($str,0, strrpos($str, ','));
        $this->_couponsn_mod->db->query("INSERT INTO {$this->_couponsn_mod->table} (coupon_sn, coupon_id, remain_times) VALUES {$string}", 'SILENT');
        return $add_data;
    }
    //分发红包
    function assign_user($id, $users)
    {
        $_user_mod =& m('member');
        $count = count($users);
        $users = array_values($users);
        $arr = $this->generate($count, $id);
        $i = 0;
        foreach ($users as $key => $user)
        {
                $users[$key]['coupon'] = $arr[$i];
                $_user_mod->createRelation('bind_couponsn', $user['user_id'], array($arr[$i]['coupon_sn'] => array('coupon_sn' =>$arr[$i]['coupon_sn'])));
                $i = $i + 1;
        }
        return $users;
    }
    //抢红包  coup_id
    function qianghb()
    {
    	$sid=intval($_GET['sid']);
		$hbid=intval($_GET['hbid']);
		$this->assign("sid",$sid);
		$this->assign("hbid",$hbid);
		$sql="SELECT * from ecm_coupon where coupon_id=".$hbid." and store_id=".$sid." and if_issue=1";
		$db=&db();
		$rows=$db->getAll($sql);
		if(count($rows))
		{
			$this->assign("hongbao",$rows[0]);
		}else{
			$this->show_message('您被程序骗了，这里是招聘信息！');
            return;
		}
		$this->display("qhb.success.html");

    }
    //自动登录
	function atlogin()
	{
	if(!IS_POST)
	{
		if($this->visitor->has_login)
		{
			
		  //跳转到抢红包页面
		  // header('Location:index.php?app=couponyxw&order_id=' . $order_id);
		  //header('Location:' . getConf('qianghongbao'));
		  //exit;
		  header('Location:'. $_SERVER['HTTP_REFERER']);
		  exit;
		}else{
			$gourl = $_SERVER['HTTP_REFERER']; 
			$_SESSION['gourl']=$_SERVER['HTTP_REFERER']; 

			//跳转到快速登录页面
			$this->display("atlogin.html");
			exit;
		}
	}ELSE{
		
		//dump($_POST);
			$ms =& ms(); //连接用户中心
			$user_name = trim($_POST['user_name']);
			$mobile  = trim($_POST['user_name']);
			$password = $mobile;
			$real_name=trim($_POST['password']);
			
			$passlen = strlen($mobile);
			$user_name_len = strlen($user_name);
			if ($user_name_len < 3 || $user_name_len > 25)
			{
				$this->show_message('user_name_length_error');

				return;
			}

			
			$data = array(
				'parentid' => $_COOKIE["uin"],
				'real_name'=>$user_name,
				);
			//先判断用户是否是老用户，若是直接登录，否则注册
			$db = & db();
			$sql_user="SELECT user_id from ecm_member where user_name='".$mobile."'";
			$user_id=$db->getOne($sql_user);
			if(empty($user_id))
			{
				$user_id = $db->getOne("select a.user_id from ecm_member a LEFT JOIN ecm_address b on a.user_id=b.user_id where b.phone_mob='".$mobile."'");
				if(empty($user_id)){
					
					//注册
					$user_id = $ms->user->register_sec($mobile, $password,$data);
				
				}
			}
			$this->_do_login($user_id);
			//var_dump($_SESSION['gourl']);
			//exit;
			if((strpos($_SESSION['gourl'],'index.php?app=couponyxw&act=atlogin')!==false)||!$_SESSION['gourl'])
			{
				header('Location:/index.php');
				exit;
				
			}else{
				header('Location:'. $_SESSION['gourl']);
				exit;
				
			}
			
		
	}
		
		
	}
}

?>