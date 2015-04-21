<?php

class CouponApp extends StoreadminbaseApp
{
    var $_coupon_mod;
    var $_store_id;
    var $_store_mod;
    var $_couponsn_mod;
    function __construct()
    {
        $this->CouponApp();
    }
    function CouponApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_store_mod =& m('store');
        $this->_coupon_mod =& m('coupon');
        $this->_couponsn_mod =& m('couponsn');
    }
    function index()
    {
        $page = $this->_get_page(10);
        $coupon = $this->_coupon_mod->find(array(
            'conditions' => 'store_id = '.$this->_store_id,
            'limit' => $page['limit'],
            'count' => true,
        ));
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('coupon'), 'index.php?app=coupon',
                         LANG::get('coupons_list'));
        $page['item_count'] = $this->_coupon_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        $this->_curitem('coupon');
        $this->_curmenu('coupons_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('coupon'));
        $this->assign('coupons', $coupon);
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
        $this->assign('time', gmtime());
		$sql="select * from ecm_store where store_id=".$this->_store_id;
		$store=$this->_coupon_mod->getRow($sql);
		$this->assign('power_coupon',intval($store['power_coupon']));
		$this->assign('store_id',intval($store['store_id']));
        $this->display('coupon.index.html');
    }
	
	//红包发放统计
	function history()
	{
		$page = $this->_get_page(10);
  
$count = 'select count(1) from ecm_coupon LEFT JOIN ecm_coupon_sn on ecm_coupon_sn.coupon_id=ecm_coupon.coupon_id where store_id='.$this->_store_id;
		$num = $this->_coupon_mod -> getone($count);

		//$page = $this->_get_page(1);//内置分页方法，将每页显示条数传入分页
		$page['item_count'] = $num;    //这时候$page成为一个数组
		//$this->_format_page($page);    //格式分页
		
		$sql = 'select ecm_coupon.*,ecm_coupon_sn.coupon_sn,ecm_coupon_sn.remain_times from ecm_coupon LEFT JOIN ecm_coupon_sn on ecm_coupon_sn.coupon_id=ecm_coupon.coupon_id and ecm_coupon.store_id='.$this->_store_id.' limit '.$page['limit'];
		$que1 = $this->_coupon_mod  -> getAll($sql);
		//print_r( $que1);
		//exit();
		//$i = 0;
		
			for($i=0;$i<count($que1);$i++)
			{
			$que[$i]['coupon_id']=$que1[$i]['coupon_id'];
			$que[$i]['store_id'] = $que1[$i]['store_id'];
			$que[$i]['coupon_name'] = $que1[$i]['coupon_name'];
			$que[$i]['coupon_value']=$que1[$i]['coupon_value'];
			$que[$i]['use_times'] = $que1[$i]['use_times'];
			$que[$i]['start_time'] = $que1[$i]['start_time'];
			$que[$i]['end_time']=$que1[$i]['end_time'];
			$que[$i]['min_amount'] = $que1[$i]['min_amount'];
			$que[$i]['if_issue'] = $que1[$i]['if_issue'];
			$que[$i]['stores_allow']=$que1[$i]['stores_allow'];
			$que[$i]['cate_noallow'] = $que1[$i]['cate_noallow'];
			$que[$i]['coupon_sn'] = $que1[$i]['coupon_sn'];
			$que[$i]['remain_times'] = $que1[$i]['remain_times'];
			}
		
		$coupon=$que;
		//$this -> assign('page_info',$page);
		$this -> assign('que',$coupon);
	//print_r($coupon);
	//print_r($coupon1);
	//exit();
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('coupon'), 'index.php?app=coupon',
                         LANG::get('coupons_list'));
        //$page['item_count'] = $this->_coupon_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        $this->_curitem('history');
        $this->_curmenu('红包使用统计');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . '红包使用统计');
        $this->assign('coupons', $coupon);
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
        $this->assign('time', gmtime());
        $this->display('coupon_history.index.html');
	}

    function add()
    {
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('today', gmtime());
			 $tmp_info = $this->_store_mod->get(array(
            'conditions' => $this->_store_id,));
			$this->assign('store_id',$this->_store_id);//.'oo'.$tmp_info["power_coupon"]);
			$this->assign('power_coupon',$tmp_info["power_coupon"]);
			 $gcate_mod =& m('gcategory');
            $this->assign('cates', $gcate_mod->get_optionsyxw(0,0,1));
			
			
            $this->display('coupon.form.html');
        }
        else
        {

            $coupon_value = floatval(trim($_POST['coupon_value']));
            $use_times = intval(trim($_POST['use_times']));
            $min_amount = floatval(trim($_POST['min_amount']));
            if (empty($coupon_value) || $coupon_value < 0 )
            {
                $this->pop_warning('coupon_value_not');
                exit;
            }
            if (empty($use_times))
            {
                $this->pop_warning('use_times_not_zero');
                exit;
            }
            if ($min_amount < 0)
            {
                $this->pop_warning("min_amount_gt_zero");
                exit;
            }
            $start_time = gmstr2time(trim($_POST['start_time']));
            $end_time = gmstr2time_end(trim($_POST['end_time'])) - 1 ;
            if ($end_time < $start_time)
            {
                $this->pop_warning('end_gt_start');
                exit;
            }
			//
            $coupon = array(
                'coupon_name' => trim($_POST['coupon_name']),
                'coupon_value' => $coupon_value,
                'store_id' => $this->_store_id,
                'use_times' => $use_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'min_amount' => $min_amount,
                'if_issue'  => trim($_POST['if_issue']) == 1 ? 1 : 0,
				'stores_allow' =>trim($_POST['stores_allow']),
				'cate_noallow' =>trim($_POST['icate_ids']),
				'remark' =>trim($_POST['remark']),
            );
            $this->_coupon_mod->add($coupon);
            if ($this->_coupon_mod->has_error())
            {
                $this->pop_warning($this->_coupon_mod->get_error());
                exit;
            }
            $this->pop_warning('ok', 'coupon_add');
        }
    }

    function edit()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($coupon_id))
        {
            echo Lang::get("no_coupon");
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $coupon = $this->_coupon_mod->get_info($coupon_id);
            $this->assign('coupon', $coupon);
            $this->display('coupon.form.html');
        }
        else
        {
            $coupon_value = floatval(trim($_POST['coupon_value']));
            $use_times = intval(trim($_POST['use_times']));
            $min_amount = floatval(trim($_POST['min_amount']));
            if (empty($coupon_value) || $coupon_value < 0 )
            {
                $this->pop_warning('coupon_value_not');
                exit;
            }
            if (empty($use_times))
            {
                $this->pop_warning('use_times_not_zero');
                exit;
            }
            if ($min_amount < 0)
            {
                $this->pop_warning("min_amount_gt_zero");
                exit;
            }
            $start_time = gmstr2time(trim($_POST['start_time']));
            $end_time = gmstr2time_end(trim($_POST['end_time']))-1;
            //echo gmstr2time_end(trim($_POST['end_time'])) . '-------' .$end_time;exit; 
            if ($end_time < $start_time)
            {
                $this->pop_warning('end_gt_start');
                exit;
            }
            $coupon = array(
                'coupon_name' => trim($_POST['coupon_name']),
                'coupon_value' => $coupon_value,
                'store_id' => $this->_store_id,
                'use_times' => $use_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'min_amount' => $min_amount,
                'if_issue'  => trim($_POST['if_issue']) == 1 ? 1 : 0,
            );
            $this->_coupon_mod->edit($coupon_id, $coupon);
            if ($this->_coupon_mod->has_error())
            {
                $this->pop_warning($this->_coupon_mod->get_error());
                exit;
            }
            $this->pop_warning('ok','coupon_edit');
        }
    }

    function issue()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($coupon_id))
        {
            $this->show_warning("no_coupon");
            exit;
        }
        $this->_coupon_mod->edit($coupon_id, array('if_issue' => 1));
        if ($this->_coupon_mod->has_error())
        {
            $this->show_message($this->_coupon_mod->get_error());
            exit;
        }
        $this->show_message('issue_success',
            'back_list', 'index.php?app=coupon');
    }

    function drop()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if (empty($coupon_id))
        {
            $this->show_warning('no_coupon');
            exit;
        }
        $time = gmtime();
        $coupon_ids = explode(',', $coupon_id);//vdump($this->_coupon_mod->find("((if_issue = 1 AND end_time > {$time})) AND coupon_id ".db_create_in($coupon_ids)));
        $this->_coupon_mod->drop("(if_issue = 0 OR (if_issue = 1 AND end_time < {$time})) AND coupon_id ".db_create_in($coupon_ids));
        if ($this->_coupon_mod->has_error())
        {
            $this->show_warning($this->_coupon_mod->get_error());
        }
        $this->show_message('drop_ok',
            'back_list', 'index.php?app=coupon');
    }

    function export()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if (empty($coupon_id))
        {
            echo Lang::get('no_coupon');
            exit;
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('id', $coupon_id);
            $this->display('coupon_export.html');
        }
        else
        {
            $amount = intval(trim($_POST['amount']));
            if (empty($amount))
            {
                $this->pop_warning('involid_data');
                exit;
            }
            $info = $this->_coupon_mod->get_info($coupon_id);
            $coupon_name = ecm_iconv(CHARSET, 'gbk', $info['coupon_name']);
            header('Content-type: application/txt');
            header('Content-Disposition: attachment; filename="coupon_' .date('Ymd'). '_' .$coupon_name.'.txt"');
            $sn_array = $this->generate($amount, $coupon_id);
            $crlf = get_crlf();
            foreach ($sn_array as $val)
            {
                echo $val['coupon_sn'] . $crlf;
            }
        }
    }

    function extend()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if (empty($coupon_id))
        {
            echo Lang::get('no_coupon');
            exit;
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('id', $coupon_id);
            $this->assign('send_model', Lang::get('send_model'));
            $this->display("coupon_extend.html");
        }
        else
        {
            if (empty($_POST['user_name']))
            {
                $this->pop_warning("involid_data");
                exit;
            }
            $user_name = str_replace(array("\r","\r\n"), "\n", trim($_POST['user_name']));
            $user_name = explode("\n", $user_name);
            $user_mod =&m ('member');
            $users = $user_mod->find(db_create_in($user_name, 'user_name'));
            if (empty($users))
            {
				//$this->pop_warning('杨秀伟');
                $this->pop_warning('involid_data');
                exit;
            }
            if (count($users) > 30)
            {
                $this->pop_warning("amount_gt");
                exit;
            }
            else
            {
                $users = $this->assign_user($coupon_id, $users);
                $store = $this->_store_mod->get_info($this->_store_id);
                $coupon = $this->_coupon_mod->get_info($coupon_id);
                $coupon['store_name'] = $store['store_name'];
                $coupon['store_id'] = $this->_store_id;
			//发送短信 
               // $this->_message_to_user($users, $coupon);
			//发送邮件
               // $this->_mail_to_user($users, $coupon);
				
                $this->pop_warning("ok","",'index.php?app=coupon');//coupon_extend");
            }
        }
    }

    function _message_to_user($users, $coupon)
    {
        $ms =& ms();
        foreach ($users as $key => $val)
        {
            $content = get_msg('touser_send_coupon', array(
            'price' => $coupon['coupon_value'],
            'start_time' =>  local_date('Y-m-d',$coupon['start_time']),
            'end_time' => local_date("Y-m-d", $coupon['end_time']),
            'coupon_sn' => $val['coupon']['coupon_sn'],
            'min_amount' => $coupon['min_amount'],
            'url' => SITE_URL . '/' . url('app=store&id=' . $coupon['store_id']),
            'store_name' => $coupon['store_name'],
            ));
            $msg_id = $ms->pm->send(MSG_SYSTEM, $val['user_id'], '',$content);
        }
    }

    function _mail_to_user($users, $coupon)
    {
        foreach ($users as $val)
        {
            $mail = get_mail('touser_send_coupon', array('user' => $val, 'coupon' => $coupon));
            if (!$mail)
            {
                continue;
            }
            $this->_mailto($val['email'], addslashes($mail['subject']), addslashes($mail['message']));
        }
    }

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

    function generate($num, $id)
    {
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

  /*  function _sql_insert($data)
    {
        $str = '';
        foreach ($data as $val)
        {
            $str .= "('{$val['coupon_sn']}', {$val['coupon_id']}, {$val['remain_times']}),";
        }
        $string = substr($str,0, strrpos($str, ','));
        $res = $this->_couponsn_mod->db->query("INSERT INTO {$this->_couponsn_mod->table} (coupon_sn, coupon_id, remain_times) VALUES {$string}", 'SILENT');
        $error = $this->_couponsn_mod->db->errno();
        return array('res' => $res, 'errno' => $error);
    }

    function _create_random($num, $id, $times)
    {
        $arr = array();
        for ($i = 1; $i <= $num; $i++)
        {
            $arr[$i]['coupon_sn'] =  mt_rand(10000, 99999);
            $arr[$i]['coupon_id'] = $id;
            $arr[$i]['remain_times'] = $times;
        }
        return $arr;
    }
*/
    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  =>'coupons_list',
                'url'   =>'index.php?app=coupon',
            ),
        );
		return $menus;
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
		if(!count($db->getRow($sql_store)))
		{
			echo "没有权限操作！！";
		}
		$sql_qixian="select * from ecm_coupon where store_id=".$store_id." and coupon_id=".$coupon_id." and end_time>unix_timestamp() and if_issue=1";
		$row_qixian=$db->getRow($sql_qixian);
		if(!count($row_qixian))
		{
			echo "没有指定红包信息！";
		}else{
			$id=$row_qixian['coupon_id'];
			$this->generate($count, $id); 
			echo "生成成功！";
		}
		
		
		
		
		
		
	}
}

?>