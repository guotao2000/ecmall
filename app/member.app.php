<?php

/**
 *    Desc
 *
 *    @author    Garbin
 *    @usage    none
 */
class MemberApp extends MemberbaseApp
{
    var $_feed_enabled = false;
    function __construct()
    {
        $this->MemberApp();
    }
    function MemberApp()
    {
        parent::__construct();
        $ms =& ms();
        $this->_feed_enabled = $ms->feed->feed_enabled();
        $this->assign('feed_enabled', $this->_feed_enabled);
    }
    function index()
    {
		if(!$this->visitor->has_login)
		{
			header('Location:/index.php?app=member&act=login');
			exit;
		}
		$user_id = $this->visitor->get('user_id');
		$str_sql="SELECT * from ecm_address a where a.user_id=".$user_id;
		$db=&db();
		$rows=$db->getALL($str_sql);
		if(!count($rows))
		{
			header('Location:/index.php?app=address&act=add_address');
			exit;
		}
		
        /* 清除新短消息缓存 */
        $cache_server =& cache_server();
        $cache_server->delete('new_pm_of_user_' . $this->visitor->get('user_id'));

        //$user = $this->visitor->get();
		$temp = $this->visitor->get();
	
        $user_mod =& m('member');
		$user = $user_mod->db->getRow("select * from ecm_member where user_id=" . $temp['user_id']);
        
		$info = $user_mod->get_info($user['user_id']);
        $user['portrait'] = portrait($user['user_id'], $info['portrait'], 'middle');
        $this->assign('user', $user);
		
        /* 店铺信用和好评率 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($store['credit_value'], $step);
            $this->assign('store', $store);
            $this->assign('store_closed', STORE_CLOSED);
        }
        $goodsqa_mod = & m('goodsqa');
        $groupbuy_mod = & m('groupbuy');
        /* 买家提醒：待付款、待确认、待评价订单数 */
        $order_mod =& m('order');
        $sql1 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_PENDING . "'";
        $sql2 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_SHIPPED . "'";
        $sql3 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_FINISHED . "' AND evaluation_status = 0";
        $sql4 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE user_id = '{$user['user_id']}' AND reply_content !='' AND if_new = '1' ";
        $sql5 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_CANCELED;
        $sql6 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_FINISHED;
        $buyer_stat = array(
            'pending'  => $order_mod->getOne($sql1),
            'shipped'  => $order_mod->getOne($sql2),
            'finished' => $order_mod->getOne($sql3),
            'my_question' => $goodsqa_mod->getOne($sql4),
            'groupbuy_canceled' => $groupbuy_mod->getOne($sql5),
            'groupbuy_finished' => $groupbuy_mod->getOne($sql6),
        );
        $sum = array_sum($buyer_stat);
        $buyer_stat['sum'] = $sum;
        $this->assign('buyer_stat', $buyer_stat);

        /* 卖家提醒：待处理订单和待发货订单 */
        if ($user['has_store'])
        {
			

            $sql7 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_SUBMITTED . "'";
            $sql8 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_ACCEPTED . "'";
            $sql9 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE store_id = '{$user['user_id']}' AND reply_content ='' ";
            $sql10 = "SELECT COUNT(*) FROM {$groupbuy_mod->table} WHERE store_id='{$user['user_id']}' AND state = " .GROUP_END;
            $seller_stat = array(
                'submitted' => $order_mod->getOne($sql7),
                'accepted'  => $order_mod->getOne($sql8),
                'replied'   => $goodsqa_mod->getOne($sql9),
                'groupbuy_end'   => $goodsqa_mod->getOne($sql10),
            );

            $this->assign('seller_stat', $seller_stat);
        }
        /* 卖家提醒： 店铺等级、有效期、商品数、空间 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);

            $grade_mod = & m('sgrade');
            $grade = $grade_mod->get_info($store['sgrade']);

            $goods_mod = &m('goods');
            $goods_num = $goods_mod->get_count_of_store($user['has_store']);
            $uploadedfile_mod = &m('uploadedfile');
            $space_num = $uploadedfile_mod->get_file_size($user['has_store']);
            $sgrade = array(
                'grade_name' => $grade['grade_name'],
                'add_time' => empty($store['end_time']) ? 0 : sprintf('%.2f', ($store['end_time'] - gmtime())/86400),
                'goods' => array(
                    'used' => $goods_num,
                    'total' => $grade['goods_limit']),
                'space' => array(
                    'used' => sprintf("%.2f", floatval($space_num)/(1024 * 1024)),
                    'total' => $grade['space_limit']),
                    );
            $this->assign('sgrade', $sgrade);

        }

        /* 待审核提醒 */
        if ($user['state'] != '' && $user['state'] == STORE_APPLYING)
        {
            $this->assign('applying', 1);
        }
		
		$this->assign('system_notice', $this->_get_system_notice($_SESSION['member_role']));
		
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    url('app=member'),
                         LANG::get('overview'));
		
		$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
		$this->assign('rgoods',$rgoods);

        /* 当前用户中心菜单 */
        $this->_curitem('overview');
        $this->_config_seo('title', Lang::get('member_center'));
        $this->display('member.index.html');
    }
	
	/* 取得推荐商品 */
    function _get_recommended_goods( $num = 4)
    {
        $goods_mod =& m('goods');

		$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0 AND g.recommended = 1 ' ,
            	'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => $num,
        	));
		
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }
	
	function _get_system_notice($member_role='buyer_admin')
	{
		// 根据不同的用户角色（卖家或买家），在用户中心首页显示不同的文章
		if($member_role=='seller_admin'){
			$article_cate_id = 2;
		} else {
			$article_cate_id = 1;
		}
		$article_mod = &m('article');
		$acategory_mod = &m('acategory');
		
		$cate_ids = $acategory_mod->get_descendant($article_cate_id);
		if($cate_ids){
			$conditions = ' AND cate_id ' . db_create_in($cate_ids);
		} else {
			$conditions = '';
		}
		
		$data = $article_mod->find(array(
			'conditions'=>'code = "" AND if_show=1 AND store_id=0 ' . $conditions,
			'fields'=>'article_id, title',
			'limit'=> 5,
			'order'=>'sort_order ASC, article_id DESC'
		));
		return $data;
	}

    /**
     *    注册一个新用户
     *
     *    @author    Garbin
     *    @return    void
     */
    function register()
    {
        if ($this->visitor->has_login)
        {
            $this->show_message('您已经登录了',
				'back_before_register', 'index.php?app=default'
				);
            return;
        }
        if (!IS_POST)
        {
            // by yangxiuwei  设置uin  cookie
            /*if (preg_match('/[0-9]\d+/',$_GET['uin'])==1) {
             setcookie("uin",$_GET['uin'],time()+31622400);
             }*/
			 if (isset($_GET['uin'])) {
				if(intval($_GET['uin'])>0){
				setcookie("uin",$_GET['uin'],time()+31622400);
				}
			}
            // end yangxiuwei
            if (!empty($_GET['ret_url']))
            {
                $ret_url = trim($_GET['ret_url']);
            }
            else
            {
                if (isset($_SERVER['HTTP_REFERER']))
                {
                    $ret_url = $_SERVER['HTTP_REFERER'];
                }
                else
                {
                    $ret_url = SITE_URL . '/index.php';
                }
            }
            $this->assign('ret_url', rawurlencode($ret_url));
            $this->_curlocal(LANG::get('user_register'));
            $this->_config_seo('title', Lang::get('user_register') . ' - ' . Conf::get('site_title'));

            if (Conf::get('captcha_status.register'))
            {
                $this->assign('captcha', 1);
            }

            /* 导入jQuery的表单验证插件  tyioocom */
            $this->import_resource(array(
            	'script' => 'jquery.plugins/jquery.validate.js,jquery.plugins/poshy_tip/jquery.poshytip.js',
            	'style'  => 'jquery.plugins/poshy_tip/tip-yellowsimple/tip-yellowsimple.css')
			);
            $this->display('member.register.html');
        }
        else
        {
            /*if (!$_POST['agree'])
            {
                $this->show_warning('agree_first');

                return;
            }
            if (Conf::get('captcha_status.register') && base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }*/
			
			/* 注册并登陆 */
			$ms =& ms(); //连接用户中心
            $user_name = trim($_POST['user_name']);
            $password  = trim($_POST['password']);
			
            if ($_POST['password'] != $_POST['password_confirm'])
            {
                /* 两次输入的密码不一致 */
                $this->show_message('inconsistent_password');
                return;
            }
            
            //$email     = trim($_POST['email']);
            $passlen = strlen($password);
            $user_name_len = strlen($user_name);
            if ($user_name_len < 3 || $user_name_len > 25)
            {
                $this->show_message('user_name_length_error');

                return;
            }
            if ($passlen < 6 || $passlen > 20)
            {
                $this->show_message('password_length_error');

                return;
            }
			
            /*if (!is_email($email))
            {
                $this->show_warning('email_error');

                return;
            }*/
            //by yangxiuwei 20141208  获取cookie 推荐人号
         
            $data = array(
                'parentid' => $_COOKIE["uin"],
                );
           
            //end yangxiuwei

            $user_id = $ms->user->register_sec($user_name, $password,$data);

            if (!$user_id)
            {
                $this->show_message($ms->user->get_error());

                return;
            }
            $this->_hook('after_register', array('user_id' => $user_id));
            $this->_do_wxloginrelation($user_id);
            //登录
            $this->_do_login($user_id);
            
            /* 同步登陆外部系统 */
            $synlogin = $ms->user->synlogin($user_id);

            #TODO 可能还会发送欢迎邮件
			
			//注册发红包操作   begin
			$db = &db();
			$results = $db->getAll("SELECT a.*,b.start_time,b.end_time from ecm_coupon_sn a left join ecm_coupon b on a.coupon_id=b.coupon_id where b.end_time>unix_timestamp() and b.if_issue=1 and b.coupon_name='注册专用红包' and a.remain_times>0 and a.coupon_sn not IN(select c.coupon_sn from ecm_user_coupon c) order by a.coupon_sn desc");
			
                if(count($results) > 0){
                
                foreach($results as $val){
                    $coupon_sn = $val['coupon_sn'];
                }
                $db->query("insert into ecm_user_coupon(user_id,coupon_sn) VALUES(" . $user_id . ",'" . $coupon_sn . "')");
            }
			
			//end

            /*$this->show_message(Lang::get('register_successed') . $synlogin,
                'back_before_register', rawurldecode($_POST['ret_url']),
                'enter_member_center', 'index.php?app=member',
                'apply_store', 'index.php?app=apply'
            );*/
			
			$this->show_message('恭喜，注册成功！',
                'back_before_register', 'index.php?app=default'
            );
			
			
        }
    }
	
    /**
     *    检查用户是否存在
     *
     *    @author    Garbin
     *    @return    void
     */
    function check_user()
    {
        $user_name = empty($_GET['user_name']) ? null : trim($_GET['user_name']);
        if (!$user_name)
        {
            echo ecm_json_encode(false);

            return;
        }
        $ms =& ms();

        echo ecm_json_encode($ms->user->check_username($user_name));
    }

    /**
     *    修改基本信息
     *
     *    @author    Hyber
     *    @usage    none
     */
    function profile(){

        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('basic_information'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('basic_information');

            $ms =& ms();    //连接用户系统
            $edit_avatar = $ms->user->set_avatar($this->visitor->get('user_id')); //获取头像设置方式

            $model_user =& m('member');
            $profile    = $model_user->get_info(intval($user_id));
            $profile['portrait'] = portrait($profile['user_id'], $profile['portrait'], 'middle');
            $this->assign('profile',$profile);
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->assign('edit_avatar', $edit_avatar);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_profile'));
            $this->display('member.profile.html');
        }
        else
        {
            $data = array(
                'real_name' => $_POST['real_name'],
                'gender'    => $_POST['gender'],
                'birthday'  => $_POST['birthday'],
                'im_msn'    => $_POST['im_msn'],
                'im_qq'     => $_POST['im_qq'],
            );

            if (!empty($_FILES['portrait']))
            {
                $portrait = $this->_upload_portrait($user_id);
                if ($portrait === false)
                {
                    return;
                }
                $data['portrait'] = $portrait;
            }

            $model_user =& m('member');
            $model_user->edit($user_id , $data);
            if ($model_user->has_error())
            {
                $this->show_warning($model_user->get_error());

                return;
            }

            $this->show_message('edit_profile_successed');
        }
    }
    /**
     *    修改密码
     *
     *    @author    Hyber
     *    @usage    none
     */
    function password(){
        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('edit_password'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_password');
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('edit_password'));
            $this->display('member.password.html');
        }
        else
        {
            /* 两次密码输入必须相同 */
            $orig_password      = $_POST['orig_password'];
            $new_password       = $_POST['new_password'];
            $confirm_password   = $_POST['confirm_password'];
            if ($new_password != $confirm_password)
            {
                $this->show_warning('twice_pass_not_match');

                return;
            }
            if (!$new_password)
            {
                $this->show_warning('no_new_pass');

                return;
            }
            $passlen = strlen($new_password);
            if ($passlen < 6 || $passlen > 20)
            {
                $this->show_warning('password_length_error');

                return;
            }

            /* 修改密码 */
            $ms =& ms();    //连接用户系统
            $result = $ms->user->edit($this->visitor->get('user_id'), $orig_password, array(
                'password'  => $new_password
            ));
            if (!$result)
            {
                /* 修改不成功，显示原因 */
                $this->show_warning($ms->user->get_error());

                return;
            }

            $this->show_message('edit_password_successed');
        }
    }
    /**
     *    修改电子邮箱
     *
     *    @author    Hyber
     *    @usage    none
     */
    function email(){
        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('edit_email'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_email');
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('edit_email'));
            $this->display('member.email.html');
        }
        else
        {
            $orig_password  = $_POST['orig_password'];
            $email          = isset($_POST['email']) ? trim($_POST['email']) : '';
            if (!$email)
            {
                $this->show_warning('email_required');

                return;
            }
            if (!is_email($email))
            {
                $this->show_warning('email_error');

                return;
            }

            $ms =& ms();    //连接用户系统
            $result = $ms->user->edit($this->visitor->get('user_id'), $orig_password, array(
                'email' => $email
            ));
            if (!$result)
            {
                $this->show_warning($ms->user->get_error());

                return;
            }

            $this->show_message('edit_email_successed');
        }
    }

    /**
     * Feed设置
     *
     * @author Garbin
     * @param
     * @return void
     **/
    function feed_settings()
    {
        if (!$this->_feed_enabled)
        {
            $this->show_warning('feed_disabled');
            return;
        }
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('feed_settings'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('feed_settings');
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('feed_settings'));

            $user_feed_config = $this->visitor->get('feed_config');
            $default_feed_config = Conf::get('default_feed_config');
            $feed_config = !$user_feed_config ? $default_feed_config : unserialize($user_feed_config);

            $buyer_feed_items = array(
                'store_created' => Lang::get('feed_store_created.name'),
                'order_created' => Lang::get('feed_order_created.name'),
                'goods_collected' => Lang::get('feed_goods_collected.name'),
                'store_collected' => Lang::get('feed_store_collected.name'),
                'goods_evaluated' => Lang::get('feed_goods_evaluated.name'),
                'groupbuy_joined' => Lang::get('feed_groupbuy_joined.name')
            );
            $seller_feed_items = array(
                'goods_created' => Lang::get('feed_goods_created.name'),
                'groupbuy_created' => Lang::get('feed_groupbuy_created.name'),
            );
            $feed_items = $buyer_feed_items;
            if ($this->visitor->get('manage_store'))
            {
                $feed_items = array_merge($feed_items, $seller_feed_items);
            }
            $this->assign('feed_items', $feed_items);
            $this->assign('feed_config', $feed_config);
            $this->display('member.feed_settings.html');
        }
        else
        {
            $feed_settings = serialize($_POST['feed_config']);
            $m_member = &m('member');
            $m_member->edit($this->visitor->get('user_id'), array(
                'feed_config' => $feed_settings,
            ));
            $this->show_message('feed_settings_successfully');
        }
    }

     /**
     *    三级菜单
     *
     *    @author    Hyber
     *    @return    void
     */
    function _get_member_submenu()
    {
        $submenus =  array(
            array(
                'name'  => 'basic_information',
                'url'   => 'index.php?app=member&amp;act=profile',
            ),
            array(
                'name'  => 'edit_password',
                'url'   => 'index.php?app=member&amp;act=password',
            ),
            array(
                'name'  => 'edit_email',
                'url'   => 'index.php?app=member&amp;act=email',
            ),
        );
        if ($this->_feed_enabled)
        {
            $submenus[] = array(
                'name'  => 'feed_settings',
                'url'   => 'index.php?app=member&amp;act=feed_settings',
            );
        }

        return $submenus;
    }

    /**
     * 上传头像
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_portrait($user_id)
    {
        $file = $_FILES['portrait'];
        if ($file['error'] != UPLOAD_ERR_OK)
        {
            return '';
        }
        import('uploader.lib');
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->addFile($file);
        if ($uploader->file_info() === false)
        {
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=member&amp;act=profile');
            return false;
        }
        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/portrait/' . ceil($user_id / 500), $user_id);
    }
	//加载登录成功页面
	function login_ok(){
		$this->display('login.success.html');	
	}
	//修改个人资料
	function change_profile(){
		if(!IS_POST){
			/* 清除新短消息缓存 */
			$cache_server =& cache_server();
			$cache_server->delete('new_pm_of_user_' . $this->visitor->get('user_id'));
			
			$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
			$this->assign('rgoods',$rgoods);

			$user = $this->visitor->get();
			$user_mod =& m('member');
			$info = $user_mod->get_info($user['user_id']);
			$user['portrait'] = portrait($user['user_id'], $info['portrait'], 'middle');
			
			$this->assign('user', $info);
			$this->display('user_editData.html');
		} else {
			$db = &db();
			$user_id = isset($_POST['user_id'])? intval($_POST['user_id']):0;
			//$email = isset($_POST['email'])? trim($_POST['email']):'';
			$phone_mob = isset($_POST['phone_mob'])? trim($_POST['phone_mob']):'';	
			$real_name = isset($_POST['real_name'])? trim($_POST['real_name']):'';
			$gender = isset($_POST['gender'])? intval($_POST['gender']):0;
			$birthday = isset($_POST['birthday'])? trim($_POST['birthday']):'';
			$im_qq = isset($_POST['im_qq'])? trim($_POST['im_qq']):'';
			
			$sql = "update ecm_member set phone_mob='" . $phone_mob . "', real_name='" . $real_name . "', gender=" . $gender . ", birthday='" . $birthday . "', im_qq='" . $im_qq . "' where user_id=" . $user_id;
			
			if($db->query($sql)){
				$this->show_message('个人资料修改成功！',
                'back_before_register', 'index.php?app=member&act=user_data');
			}
			
		}
			
	}
	
	//加载修改个人资料页面
	function user_data(){
		
		$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
		$this->assign('rgoods',$rgoods);

		$this->display('user_profile.html');
	}
	
	//修改登录密码
	function change_user_password(){
		$db = &db();
		if(!IS_POST){
			$this->display('change_user_password.html');
		} else {
			//获取用户提交的值
			$yuan_password = isset($_POST['yuan_password'])? trim($_POST['yuan_password']):'';
			$new_password = isset($_POST['new_password'])? trim($_POST['new_password']):'';
			$sure_password = isset($_POST['sure_password'])? trim($_POST['sure_password']):'';
			
			//验证用户提交数据
			if(empty($yuan_password) && empty($new_password) && empty($sure_password)){
				$this->show_message('操作成功！');	
				return;
			}
			
			//根据用户id获取用户登录密码
			$user_id = $this->visitor->get('user_id');
			$sql = "select password from ecm_member where user_id=" . $user_id;
			$password = $db->getOne($sql);
			
			//修改操作
			if(!empty($yuan_password)){
				$yuan_password = md5($yuan_password);
				if($yuan_password != $password){
					$this->show_message('旧密码输入错误！');	
					return;
				}
			}
			
			if(empty($new_password) || empty($sure_password)){
				$this->show_message('新密码和确认密码不能为空！');	
				return;
			}
			
			if(!empty($new_password) && !empty($sure_password)){
				if(strlen($new_password) < 6 || strlen($sure_password) < 6){
					$this->show_message('新密码或者确认密码长度至少为6个字符！');	
					return;
				}
				if($new_password != $sure_password){
					$this->show_message('新密码和确认密码不相同！');	
					return;
				}	
			}
			
			if(!empty($new_password) && !empty($sure_password)){
				if($new_password == $sure_password){
					$new_password = md5($new_password);
					$sure_password = md5($sure_password);
					$sql = "update ecm_member set password='" . $new_password . "' where user_id=" . $user_id;
					if($db->query($sql)){
						$this->show_message('密码修改成功！',
                'back_before_register', 'index.php?app=member&act=user_data');	
						return;		
					}
				}	
			}

			
			
			
			
			
		}
	}
	
	
}

?>
