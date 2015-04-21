﻿<?php

/* 店铺控制器 */
class StoreApp extends BackendApp
{
    var $_store_mod;

    function __construct()
    {
        $this->StoreApp();
    }

    function StoreApp()
    {
        parent::__construct();
        $this->_store_mod =& m('store');
    }

    function index()
    {
        $conditions = empty($_GET['wait_verify']) ? "state <> '" . STORE_APPLYING . "'" : "state = '" . STORE_APPLYING . "'";
        $filter = $this->_get_query_conditions(array(
            array(
                'field' => 'store_name',
                'equal' => 'like',
            ),
            array(
                'field' => 'sgrade',
            ),
        ));
        $owner_name = trim($_GET['owner_name']);
        if ($owner_name)
        {

            $filter .= " AND (user_name LIKE '%{$owner_name}%' OR owner_name LIKE '%{$owner_name}%') ";
        }
        //更新排序
        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
                $sort  = 'sort_order';
                $order = '';
            }
        }
        else
        {
            $sort  = 'store_id';
            $order = 'desc';
        }

        $this->assign('filter', $filter);
        $conditions .= $filter;
        $page = $this->_get_page();
        $stores = $this->_store_mod->find(array(
            'conditions' => $conditions,
            'join'  => 'belongs_to_user',
            'fields'=> 'this.*,member.user_name',
            'limit' => $page['limit'],
            'count' => true,
            'order' => "$sort $order"
        ));
        $sgrade_mod =& m('sgrade');
        $grades = $sgrade_mod->get_options();
        $this->assign('sgrades', $grades);

        $states = array(
            STORE_APPLYING  => LANG::get('wait_verify'),
            STORE_OPEN      => Lang::get('open'),
            STORE_CLOSED    => Lang::get('close'),
        );
        foreach ($stores as $key => $store)
        {
            $stores[$key]['sgrade'] = $grades[$store['sgrade']];
            $stores[$key]['state'] = $states[$store['state']];
            $certs = empty($store['certification']) ? array() : explode(',', $store['certification']);
            for ($i = 0; $i < count($certs); $i++)
            {
                $certs[$i] = Lang::get($certs[$i]);
            }
            $stores[$key]['certification'] = join('<br />', $certs);
        }
        $this->assign('stores', $stores);

        $page['item_count'] = $this->_store_mod->getCount();
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->_format_page($page);
        $this->assign('filtered', $filter? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);

        $this->display('store.index.html');
    }
    function test()
    {
        if (!IS_POST)
        {
            $sgrade_mod =& m('sgrade');
            $grades = $sgrade_mod->find();
            if (!$grades)
            {
                $this->show_warning('set_grade_first');
                return;
            }
            $this->display('store.test.html');
        }
        else
        {
            $user_name = trim($_POST['user_name']);
            $password  = $_POST['password'];

            /* 连接到用户系统 */
            $ms =& ms();
            $user = $ms->user->get($user_name, true);
            if (empty($user))
            {
                $this->show_warning('user_not_exist');
                return;
            }
            if ($_POST['need_password'] && !$ms->user->auth($user_name, $password))
            {
                $this->show_warning('invalid_password');

                return;
            }

            $store = $this->_store_mod->get_info($user['user_id']);
            if ($store)
            {
                if ($store['state'] == STORE_APPLYING)
                {
                    $this->show_warning('user_has_application');
                    return;
                }
                else
                {
                    $this->show_warning('user_has_store');
                    return;
                }
            }
            else
            {
                header("Location:index.php?app=store&act=add&user_id=" . $user['user_id']);
            }
        }
    }

    function add()
    {
        $user_id = $_GET['user_id'];
        if (!$user_id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        if (!IS_POST)
        {
            /* 取得会员信息 */
            $user_mod =& m('member');
            $user = $user_mod->get_info($user_id);
            $this->assign('user', $user);

            $this->assign('store', array('state' => STORE_OPEN, 'recommended' => 0, 'sort_order' => 65535, 'end_time' => 0));

            $sgrade_mod =& m('sgrade');
            $this->assign('sgrades', $sgrade_mod->get_options());

            $this->assign('states', array(
                STORE_OPEN   => Lang::get('open'),
                STORE_CLOSED => Lang::get('close'),
            ));

	    //修改  2014-12-07 15:15 begin
	    $this->assign('payment_open', array(
                '1'   => Lang::get('open'),
                '0' => Lang::get('close'),
            ));
	    //end
		
		  //修改  2014-12-17 15:15 begin
	    $this->assign('aids', array(
                '1'   => Lang::get('open'),
                '0' => Lang::get('close'),
            ));
	    //end

            $this->assign('recommended_options', array(
                '1' => Lang::get('yes'),
                '0' => Lang::get('no'),
            ));

            $this->assign('scategories', $this->_get_scategory_options());

            $region_mod =& m('region');
            $this->assign('regions', $region_mod->get_options(0));

            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js,mlselection.js'
            ));
            $this->assign('enabled_subdomain', ENABLED_SUBDOMAIN);
            $this->display('store.form.html');
        }
        else
        {
            /* 检查名称是否已存在 */
            if (!$this->_store_mod->unique(trim($_POST['store_name'])))
            {
                $this->show_warning('name_exist');
                return;
            }
            $domain = empty($_POST['domain']) ? '' : trim($_POST['domain']);
            if (!$this->_store_mod->check_domain($domain, Conf::get('subdomain_reserved'), Conf::get('subdomain_length')))
            {
                $this->show_warning($this->_store_mod->get_error());

                return;
            }
            $data = array(
                'store_id'     => $user_id,
                'store_name'   => $_POST['store_name'],
                'owner_name'   => $_POST['owner_name'],
                'owner_card'   => $_POST['owner_card'],
                'region_id'    => $_POST['region_id'],
                'region_name'  => $_POST['region_name'],
                'address'      => $_POST['address'],
                'zipcode'      => $_POST['zipcode'],
                'tel'          => $_POST['tel'],
                'sgrade'       => $_POST['sgrade'],
                'end_time'     => empty($_POST['end_time']) ? 0 : gmstr2time(trim($_POST['end_time'])),
                'state'        => $_POST['state'],
                'recommended'  => $_POST['recommended'],
                'sort_order'   => $_POST['sort_order'],
                'add_time'     => gmtime(),
                'domain'       => $domain,
				'power_coupon'   =>  $_POST['aids'],
				's_long'      => $_POST['s_long'],
				's_lat'      => $_POST['s_lat']
            );
            $certs = array();
            isset($_POST['autonym']) && $certs[] = 'autonym';
            isset($_POST['material']) && $certs[] = 'material';
            $data['certification'] = join(',', $certs);

            if ($this->_store_mod->add($data) === false)
            {
                $this->show_warning($this->_store_mod->get_error());
                return false;
            }

            $this->_store_mod->unlinkRelation('has_scategory', $user_id);
            $cate_id = intval($_POST['cate_id']);
            if ($cate_id > 0)
            {
                $this->_store_mod->createRelation('has_scategory', $user_id, $cate_id);
            }

            $this->show_message('add_ok',
                'back_list',    'index.php?app=store',
                'continue_add', 'index.php?app=store&amp;act=test'
            );
        }
    }

    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $store = $this->_store_mod->get_info($id);
            if (!$store)
            {
                $this->show_warning('store_empty');
                return;
            }
            if ($store['certification'])
            {
                $certs = explode(',', $store['certification']);
                foreach ($certs as $cert)
                {
                    $store['cert_' . $cert] = 1;
                }
            }
            $this->assign('store', $store);

            $sgrade_mod =& m('sgrade');
            $this->assign('sgrades', $sgrade_mod->get_options());

            $this->assign('states', array(
                STORE_OPEN   => Lang::get('open'),
                STORE_CLOSED => Lang::get('close'),
            ));
            $this->assign('open_pay_states', array(
                '1'   => Lang::get('open'),
                '0' => Lang::get('close'),
            ));

            $this->assign('recommended_options', array(
                '1' => Lang::get('yes'),
                '0' => Lang::get('no'),
            ));

            $region_mod =& m('region');
            $this->assign('regions', $region_mod->get_options(0));

            $this->assign('scategories', $this->_get_scategory_options());

            $scates = $this->_store_mod->getRelatedData('has_scategory', $id);
            $this->assign('scates', array_values($scates));

            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js,mlselection.js'
            ));
            $this->assign('enabled_subdomain', ENABLED_SUBDOMAIN);
	   //修改  2014-12-07 15:15 begin
	    $this->assign('aids', array(
                '1'   => Lang::get('open'),
                '0' => Lang::get('close'),
            ));
	    //end
          /*  //下面是获取配送区域
             $aids=split(',',$store["area_peisong"]);
           // $anames=array();
            $keyvalue=array();
            $db = &db();
            unset($aids[0]);
            foreach ($aids as $aid)
            {
             $sqlname="select region_name from ecm_region where region_id=".$aid;
             $keyvalue[$aid]=$db->getOne($sqlname);
            }
            
           // $this->assign('aids', $keyvalue);
            //print_r($keyvalue);
            //exit();
            
            
            */
            $this->display('store.form.html');
        }
        else
        {
            /* 检查名称是否已存在 */
            if (!$this->_store_mod->unique(trim($_POST['store_name']), $id))
            {
                $this->show_warning('name_exist');
                return;
            }
            $store_info = $this->_store_mod->get_info($id);
            $domain = empty($_POST['domain']) ? '' : trim($_POST['domain']);
            if ($domain && $domain != $store_info['domain'])
            {
                if (!$this->_store_mod->check_domain($domain, Conf::get('subdomain_reserved'), Conf::get('subdomain_length')))
                {
                    $this->show_warning($this->_store_mod->get_error());

                    return;
                }
            }

            $data = array(
                'store_name'   => $_POST['store_name'],
                'owner_name'   => $_POST['owner_name'],
                'owner_card'   => $_POST['owner_card'],
                'region_id'    => $_POST['region_id'],
                'region_name'  => $_POST['region_name'],
                'address'      => $_POST['address'],
                'zipcode'      => $_POST['zipcode'],
                'tel'          => $_POST['tel'],
                'sgrade'       => $_POST['sgrade'],
                'end_time'     => empty($_POST['end_time']) ? 0 : gmstr2time(trim($_POST['end_time'])),
                'state'        => $_POST['state'],
                'sort_order'   => $_POST['sort_order'],
                'recommended'  => $_POST['recommended'],
                'domain'       => $domain,
            	'is_open_pay' => $_POST['is_open_pay'],
				'power_coupon'   =>  $_POST['aids'],
				's_long'      => $_POST['s_long'],
				's_lat'      => $_POST['s_lat'],
				'parentid'      => $_POST['parentid']
            );
            $data['state'] == STORE_CLOSED && $data['close_reason'] = $_POST['close_reason'];
            $certs = array();
            isset($_POST['autonym']) && $certs[] = 'autonym';
            isset($_POST['material']) && $certs[] = 'material';
            $data['certification'] = join(',', $certs);

            $old_info = $this->_store_mod->get_info($id); // 修改前的店铺信息
            $this->_store_mod->edit($id, $data);

            $this->_store_mod->unlinkRelation('has_scategory', $id);
            $cate_id = intval($_POST['cate_id']);
            if ($cate_id > 0)
            {
                $this->_store_mod->createRelation('has_scategory', $id, $cate_id);
            }

            /* 如果修改了店铺状态，通知店主 */
            if ($old_info['state'] != $data['state'])
            {
                $ms =& ms();
                if ($data['state'] == STORE_CLOSED)
                {
                    // 关闭店铺
                    $subject = Lang::get('close_store_notice');
                    //$content = sprintf(Lang::get(), $data['close_reason']);
                    $content = get_msg('toseller_store_closed_notify',array('reason' => $data['close_reason']));
                }
                else
                {
                    // 开启店铺
                    $subject = Lang::get('open_store_notice');
                    $content = Lang::get('toseller_store_opened_notify');
                }
                $ms->pm->send(MSG_SYSTEM, $old_info['store_id'], '', $content);
                $this->_mailto($old_info['email'], $subject, $content);
            }

            $ret_page = isset($_GET['ret_page']) ? intval($_GET['ret_page']) : 1;
            $this->show_message('edit_ok',
                'back_list',    'index.php?app=store&page=' . $ret_page,
                'edit_again',   'index.php?app=store&amp;act=edit&amp;id=' . $id
            );
        }
    }

    //异步修改数据
   function ajax_col()
   {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();
       if (in_array($column ,array('recommended','sort_order')))
       {
           $data[$column] = $value;
           $this->_store_mod->edit($id, $data);
           if(!$this->_store_mod->has_error())
           {
               echo ecm_json_encode(true);
           }
       }
       else
       {
           return ;
       }
       return ;
   }

    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_store_to_drop');
            return;
        }

        $ids = explode(',', $id);
		//删除店铺禁止删除图片
       /* foreach ($ids as $id)
        {
            $this->_drop_store_image($id); // 注意这里要先删除图片，再删除店铺，因为删除图片时要查店铺信息
        }*/

        //删除店铺其他信息
        
        
        $db = & db();
        //删除店铺不是订单的商品
        foreach ($ids as $k => $v) {
            $store_sql = "delete t1,t2,t3,t4 from ecm_store t1,ecm_payment t2,ecm_shipping t3,ecm_coupon t4 where t1.store_id=t2.store_id 
                        and t1.store_id=t3.store_id and t1.store_id=t4.store_id and t1.store_id=$v";
            $db->query($store_sql);
            $ordergoods = $db->getall("select a.order_id,b.goods_id from ecm_order a left join ecm_order_goods b on a.order_id=b.order_id where seller_id=".$v);
            foreach ($ordergoods as $key => $value) {
                if($value['goods_id'])
                    $good_ids[] = $value['goods_id'];
            }
           
            if($good_ids){
                //对数组排序
                asort($good_ids);
                //去掉重复数据
                $good_ids = array_unique($good_ids);
                $good_ids = implode(',',$good_ids);
                $db->query("delete a,b from ecm_goods a,ecm_goods_spec b where a.goods_id=b.goods_id and a.store_id=$v and a.goods_id not in ($good_ids)");
            }else{
                 $db->query("delete a,b from ecm_goods a,ecm_goods_spec b where a.goods_id=b.goods_id and a.store_id=$v");
            }
            unset($good_ids);
        }


        /* 通知店主 */
        $user_mod =& m('member');
        $users = $user_mod->find(array(
            'conditions' => "user_id" . db_create_in($ids),
            'fields'     => 'user_id, user_name, email',
        ));
        foreach ($users as $user)
        {
            $ms =& ms();
            $subject = Lang::get('drop_store_notice');
            $content = get_msg('toseller_store_droped_notify');
            $ms->pm->send(MSG_SYSTEM, $user['user_id'], $subject, $content);
            $this->_mailto($user['email'], $subject, $content);
        }

        $this->show_message('drop_ok');
    }

    /* 更新排序 */
    function update_order()
    {
        if (empty($_GET['id']))
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $ids = explode(',', $_GET['id']);
        $sort_orders = explode(',', $_GET['sort_order']);
        foreach ($ids as $key => $id)
        {
            $this->_store_mod->edit($id, array('sort_order' => $sort_orders[$key]));
        }

        $this->show_message('update_order_ok');
    }

    /* 查看并处理店铺申请 */
    function view()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $store = $this->_store_mod->get_info($id);
            if (!$store)
            {
                $this->show_warning('Hacking Attempt');
                return;
            }

            $sgrade_mod =& m('sgrade');
            $sgrades = $sgrade_mod->get_options();
            $store['sgrade'] = $sgrades[$store['sgrade']];
            $this->assign('store', $store);

            $scates = $this->_store_mod->getRelatedData('has_scategory', $id);
            $this->assign('scates', $scates);

            $this->display('store.view.html');
        }
        else
        {
            $ret_page = isset($_GET['ret_page']) ? intval($_GET['ret_page']) : 1;
            /* 批准 */
            if (isset($_POST['agree']))
            {
                $this->_store_mod->edit($id, array(
                    'state'      => STORE_OPEN,
                    'add_time'   => gmtime(),
                    'sort_order' => 65535,
                ));

                $content = get_msg('toseller_store_passed_notify');
                $ms =& ms();
                $ms->pm->send(MSG_SYSTEM, $id, '', $content);
                $store_info = $this->_store_mod->get_info($id);
                $this->send_feed('store_created', array(
                    'user_id'   =>  $store_info['store_id'],
                    'user_name'   => $store_info['user_name'],
                    'store_url'   => SITE_URL . '/' . url('app=store&id=' . $store_info['store_id']),
                    'seller_name'   => $store_info['store_name'],
                ));
                $this->_hook('after_opening', array('user_id' => $id));
                $this->show_message('agree_ok',
                    'edit_the_store', 'index.php?app=store&amp;act=edit&amp;id=' . $id,
                    'back_list', 'index.php?app=store&wait_verify=1&page=' . $ret_page
                );
            }
            /* 拒绝 */
            elseif (isset($_POST['reject']))
            {
                $reject_reason = trim($_POST['reject_reason']);
                if (!$reject_reason)
                {
                    $this->show_warning('input_reason');
                    return;
                }

                $content = get_msg('toseller_store_refused_notify', array('reason' => $reject_reason));
                $ms =& ms();
                $ms->pm->send(MSG_SYSTEM, $id, '', $content);
               //删除店铺不删除图片
                //$this->_drop_store_image($id); // 注意这里要先删除图片，再删除店铺，因为删除图片时要查店铺信息
                $this->_store_mod->drop($id);
                $this->show_message('reject_ok',
                    'back_list', 'index.php?app=store&wait_verify=1&page=' . $ret_page
                );
            }
            else
            {
                $this->show_warning('Hacking Attempt');
                return;
            }
        }
    }

    function batch_edit()
    {
        if (!IS_POST)
        {
            $sgrade_mod =& m('sgrade');
            $this->assign('sgrades', $sgrade_mod->get_options());

            $region_mod =& m('region');
            $this->assign('regions', $region_mod->get_options(0));

            $this->headtag('<script type="text/javascript" src="{lib file=mlselection.js}"></script>');
            $this->display('store.batch.html');
        }
        else
        {
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            if (!$id)
            {
                $this->show_warning('Hacking Attempt');
                return;
            }

            $ids = explode(',', $id);
            $data = array();
            if ($_POST['region_id'] > 0)
            {
                $data['region_id'] = $_POST['region_id'];
                $data['region_name'] = $_POST['region_name'];
            }
            if ($_POST['sgrade'] > 0)
            {
                $data['sgrade'] = $_POST['sgrade'];
            }
            if ($_POST['certification'])
            {
                $certs = array();
                if ($_POST['autonym'])
                {
                    $certs[] = 'autonym';
                }
                if ($_POST['material'])
                {
                    $certs[] = 'material';
                }
                $data['certification'] = join(',', $certs);
            }
            if ($_POST['recommended'] > -1)
            {
                $data['recommended'] = $_POST['recommended'];
            }
            if ($_POST['is_open_pay'] > -1)
            {
                $data['is_open_pay'] = $_POST['is_open_pay'];
            }
            if (trim($_POST['sort_order']))
            {
                $data['sort_order'] = intval(trim($_POST['sort_order']));
            }

            if (empty($data))
            {
                $this->show_warning('no_change_set');
                return;
            }

            $this->_store_mod->edit($ids, $data);
            $ret_page = isset($_GET['ret_page']) ? intval($_GET['ret_page']) : 1;
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=store&page=' . $ret_page);
        }
    }

    function check_name()
    {
        $id         = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $store_name = empty($_GET['store_name']) ? '' : trim($_GET['store_name']);

        if (!$this->_store_mod->unique($store_name, $id))
        {
            echo ecm_json_encode(false);
            return;
        }
        echo ecm_json_encode(true);
    }

    /* 删除店铺相关图片 */
    function _drop_store_image($store_id)
    {
        $files = array();

        /* 申请店铺时上传的图片 */
        $store = $this->_store_mod->get_info($store_id);
        for ($i = 1; $i <= 3; $i++)
        {
            if ($store['image_' . $i])
            {
                $files[] = $store['image_' . $i];
            }
        }

        /* 店铺设置中的图片 */
        if ($store['store_banner'])
        {
            $files[] = $store['store_banner'];
        }
        if ($store['store_logo'])
        {
            $files[] = $store['store_logo'];
        }

        /* 删除 */
        foreach ($files as $file)
        {
            $filename = ROOT_PATH . '/' . $file;
            if (file_exists($filename))
            {
                @unlink($filename);
            }
        }
    }

    /* 取得店铺分类 */
    function _get_scategory_options()
    {
        $mod =& m('scategory');
        $scategories = $mod->get_list();
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($scategories, 'cate_id', 'parent_id', 'cate_name');

        return $tree->getOptions();
    }

	 function copy()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		$num = empty($_GET['num']) ? 1 : intval($_GET['num']);
		$user_mod =& m('member');
		$user = $user_mod->get_info($user_id);
		
		for($i=1;$i<=$num;$i++){
			//复制用户信息
			$sql = "SELECT user_name FROM " . DB_PREFIX ."member where user_id='{$id}'";
			$uname = $user_mod->getOne($sql);
			$uname = 'bq' . rand(1,10000);
			$sql = "INSERT INTO " . DB_PREFIX ."member(user_name,email,password,real_name,gender,birthday,phone_tel,phone_mob,im_qq,im_msn,im_skype,im_yahoo,im_aliww,reg_time,last_login,last_ip,logins,ugrade,portrait,outer_id,activation,feed_config) SELECT '{$uname}',email,password,real_name,gender,birthday,phone_tel,phone_mob,im_qq,im_msn,im_skype,im_yahoo,im_aliww,reg_time,last_login,last_ip,logins,ugrade,portrait,outer_id,activation,feed_config FROM " . DB_PREFIX ."member where user_id='{$id}'";
			$user_mod->db->query($sql);
			$sql = "select @@IDENTITY;";
			$uid = $user_mod->getOne($sql);
			
			//复制店铺信息
			$sql = "INSERT INTO " . DB_PREFIX ."store(store_id,store_name,owner_name,owner_card,region_id,region_name,address,zipcode,tel,sgrade,apply_remark,credit_value,praise_rate,domain,state,close_reason,add_time,end_time,certification,sort_order,recommended,theme,store_banner,store_logo,description,image_1,image_2,image_3,im_qq,im_ww,im_msn,enable_groupbuy,enable_radar) SELECT '{$uid}',store_name,owner_name,owner_card,region_id,region_name,address,zipcode,tel,sgrade,apply_remark,credit_value,praise_rate,domain,state,close_reason,add_time,end_time,certification,sort_order,recommended,theme,store_banner,store_logo,description,image_1,image_2,image_3,im_qq,im_ww,im_msn,enable_groupbuy,enable_radar FROM " . DB_PREFIX ."store where store_id='{$id}'";
			$user_mod->db->query($sql);			
			
			//复制支付方式
			$sql = "INSERT INTO " . DB_PREFIX ."payment(store_id,payment_code,payment_name,payment_desc,config,is_online,enabled,sort_order) SELECT '{$uid}',payment_code,payment_name,payment_desc,config,is_online,enabled,sort_order FROM " . DB_PREFIX ."payment where store_id='{$id}'";
			$user_mod->db->query($sql);			
			
			//复制上传文件
			//$sql = "INSERT INTO " . DB_PREFIX ."uploaded_file(store_id,file_type,file_size,file_name,file_path,add_time,belong,item_id) SELECT '{$uid}',file_type,file_size,file_name,file_path,add_time,belong,item_id FROM " . DB_PREFIX ."uploaded_file where store_id='{$id}'";
			//$user_mod->db->query($sql);
			
			//复制店铺权限
			$sql = "INSERT INTO " . DB_PREFIX ."user_priv(user_id,store_id,privs) SELECT '{$uid}','{$uid}',privs FROM " . DB_PREFIX ."user_priv where store_id='{$id}'";
			$user_mod->db->query($sql);
	
			//复制商品信息
			$sql = "select goods_id from " . DB_PREFIX ."goods where store_id='{$id}'";
			$gid = $user_mod->getAll($sql);
			
			foreach($gid as $ggid){
				$gggid = $ggid['goods_id'];
				$sql = "INSERT INTO " . DB_PREFIX ."goods(store_id,type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags,from_goods_id) SELECT '{$uid}',type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags,goods_id FROM " . DB_PREFIX ."goods where goods_id='{$gggid}'";

				$user_mod->db->query($sql);
				$sql = "select @@IDENTITY;";
				$gnid = $user_mod->getOne($sql);
				
				/*$sql = "INSERT INTO " . DB_PREFIX ."goods_image(goods_id,image_url,thumbnail,sort_order,file_id) SELECT '{$gnid}',image_url,thumbnail,sort_order,file_id FROM " . DB_PREFIX ."goods_image where goods_id in (select goods_id FROM " . DB_PREFIX ."goods where goods_id='{$gggid}')";
				$user_mod->db->query($sql);*/
				$sql = "INSERT INTO " . DB_PREFIX ."goods_spec(goods_id,spec_1,spec_2,color_rgb,price,stock,sku,shichang) SELECT '{$gnid}',spec_1,spec_2,color_rgb,price,stock,sku,shichang FROM " . DB_PREFIX ."goods_spec where goods_id='{$gggid}'";
				$user_mod->db->query($sql);

				$sql = "select @@IDENTITY;";
				$specid = $user_mod->getOne($sql);

				$user_mod->db->query("UPDATE ". DB_PREFIX ."goods SET default_spec={$specid} WHERE goods_id={$gnid}");

				$sql = "INSERT INTO " . DB_PREFIX ."goods_statistics(goods_id,views,collects,carts,orders,sales,comments) SELECT '{$gnid}',views,collects,carts,orders,sales,comments FROM " . DB_PREFIX ."goods_statistics where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
				$sql = "INSERT INTO " . DB_PREFIX ."category_goods(cate_id,goods_id) SELECT cate_id,'{$gnid}' FROM " . DB_PREFIX ."category_goods where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
			}
			
			
			//复制店铺分类
			$sql = "select cate_id from " . DB_PREFIX ."gcategory where store_id='{$id}' and parent_id='0'";
			$cateid = $user_mod->getAll($sql);
			
			foreach($cateid as $ccateid){
				$cccateid = $ccateid['cate_id'];
				$sql = "INSERT INTO " . DB_PREFIX ."gcategory(store_id,cate_name,parent_id,sort_order,if_show) SELECT '{$uid}',cate_name,parent_id,sort_order,if_show FROM " . DB_PREFIX ."gcategory where cate_id='{$cccateid}'";
				$user_mod->db->query($sql);
				$sql = "select @@IDENTITY;";
				$cnid = $user_mod->getOne($sql);
				//更新商品cateid 大类
				$sql = "update " . DB_PREFIX ."category_goods set cate_id='{$cnid}' where cate_id='{$cccateid}' and goods_id in(select goods_id from " . DB_PREFIX ."goods where store_id={$uid})";
				$user_mod->db->query($sql);
				
				//更新商品cateid 小类
				$sql = "select cate_id from " . DB_PREFIX ."gcategory where store_id='{$id}' and parent_id='{$cccateid}'";
				$xcateid = $user_mod->getAll($sql);
				foreach($xcateid as $cxcateid){
					$ccxcateid = $cxcateid['cate_id'];
					$sql = "INSERT INTO " . DB_PREFIX ."gcategory(store_id,cate_name,parent_id,sort_order,if_show) SELECT '{$uid}',cate_name,'{$cnid}',sort_order,if_show FROM " . DB_PREFIX ."gcategory where cate_id='{$ccxcateid}'";
					$user_mod->db->query($sql);
					$sql = "select @@IDENTITY;";
					$cxnid = $user_mod->getOne($sql);
					
					$sql = "update " . DB_PREFIX ."category_goods set cate_id='{$cxnid}' where cate_id='{$ccxcateid}' and goods_id in(select goods_id from " . DB_PREFIX ."goods where store_id={$uid})";
					$user_mod->db->query($sql);
				}
			}
		}
		$this->show_message('copyok');
	}

//清空店铺市场价
 function clearsc()
 {
   $store_id=intval($_GET['id']);
   $sql="update ecm_goods_spec set shichang=0 where goods_id in(SELECT goods_id from ecm_goods where store_id=".$store_id.")";
    $db=&db();
    $db->query($sql);
    $this->show_message($store_id.'号店铺，市场价清零成功！');
 }
//批量生成市场价
 function prosc()
 {
   $store_id=intval($_GET['id']);
   $sql="update ecm_goods_spec set shichang=round(price*1.05,1) where goods_id in(SELECT goods_id from ecm_goods where store_id=".$store_id.")";
    $db=&db();
     $db->query($sql);
   
    $this->show_message($store_id.'号店铺，市场价批量生成成功！');
 }
}

?>