<?php

class StoreApp extends StorebaseApp
{
    function index()
    {
        /* 店铺信息 */
        $_GET['act'] = 'index';
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->set_store($id);
	    $store = $this->get_store_data();
		
		$user_id = $this->visitor->get('user_id');
		$sql_stores="select count(*) from ecm_collect where user_id=".$user_id." and item_id=".$id."  and type='store'";
		$db=&db();
		if(intval($db->getOne($sql_stores))<1)
		{
			$sql_insert="insert into ecm_collect values(".$user_id.",'store',".$id.",'',unix_timestamp())";
			$db->query($sql_insert);
		}
				
		//print_r($store);
		$_SESSION['store_id']=$store['store_id'];
		
		//echo $_SESSION['store_id'];
		//exit();
        $this->assign('store', $store);
        
        if ($store['pic_slides_wap']) {
            $pic_slides_wap_arr = json_decode($store['pic_slides_wap'], true);
            foreach ($pic_slides_wap_arr as $key => $slides) {
                $pic_slides_wap[$key]['image_url'] = $slides['url'];
                $pic_slides_wap[$key]['image_link'] = $slides['link'];
            }
            $this->assign('goods_images', $pic_slides_wap);
        }
        

        /* 取得友情链接 */
        $this->assign('partners', $this->_get_partners($id));
		
		$rgoods=array_chunk($this->_get_recommended_goodsyxw(6),2,true);
		
		$this->assign('rgoods',$rgoods);

        /* 取得推荐商品 */
        $this->assign('recommended_goods', $this->_get_recommended_goods($id));
        $this->assign('new_groupbuy', $this->_get_new_groupbuy($id));
        $this->assign('groupbuy_list', $this->_get_new_groupbuy($id));

        /* 取得最新商品 */
        $this->assign('new_goods', $this->_get_new_goods($id));
		
		/* 取得热卖商品 */
		$this->assign('hot_sale_goods', $this->_get_hot_sale_goods($id));
		
		//取得秒杀商品   begin
		$store_id_val = $store['store_id'];
		
		$if_sec = $this->_get_seckill_goods($store_id_val, 1);
		
		if(empty($if_sec) || $if_sec == 'error'){
			$if_sec = 'off';
			$this->assign('if_sec', $if_sec);
		} else {
			$this->assign('seckill_goods', $this->_get_seckill_goods($store_id_val, 1));	
		}
		//end

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store', $store['store_name']);

        $this->_config_seo('title', $store['store_name'] . ' - ' . Conf::get('site_title'));
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($store));
        $this->display('store.index.html');
    }
	 /* 取得推荐商品 */
    function _get_recommended_goodsyxw( $num = 4)
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

    function search()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if($id == 0){
			$id = $_SESSION['store_id'];	
		}
        if (!$id)
        {
            $this->show_warning('非法请求，请选择店铺！！');
            return;
        }
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);
        //查询参数处理   begin
        $param = $this->_get_query_param();
        if (empty($param))
        {
            header('Location: index.php?app=category&id=' . $store['store_id']);
            exit;
        }        
        //end
        /* 搜索到的商品 */
        $this->_assign_searched_goods($id);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('goods_list')
        );
		
	

        $this->_config_seo('title', Lang::get('goods_list') . ' - ' . $store['store_name']);
		$this->display('search.goods.html');
        //$this->display('store.search.html');
    }

    function groupbuy()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 搜索团购 */
        empty($_GET['state']) &&  $_GET['state'] = 'on';
        $conditions = '1=1';
        if ($_GET['state'] == 'on')
        {
            $conditions .= ' AND gb.state ='. GROUP_ON .' AND gb.end_time>' . gmtime();
            $search_name = array(
                array(
                    'text'  => Lang::get('group_on')
                ),
                array(
                    'text'  => Lang::get('all_groupbuy'),
                    'url'  => url('app=store&act=groupbuy&state=all&id=' . $id)
                ),
            );
        }
        else if ($_GET['state'] == 'all')
        {
            $conditions .= ' AND gb.state '. db_create_in(array(GROUP_ON,GROUP_END,GROUP_FINISHED));
            $search_name = array(
                array(
                    'text'  => Lang::get('all_groupbuy')
                ),
                array(
                    'text'  => Lang::get('group_on'),
                    'url'  => url('app=store&act=groupbuy&state=on&id=' . $id)
                ),
            );
        }

        $page = $this->_get_page(16);
        $groupbuy_mod = &m('groupbuy');
        $groupbuy_list = $groupbuy_mod->find(array(
            'fields'    => 'goods.default_image, gb.group_name, gb.group_id, gb.spec_price, gb.end_time, gb.state',
            'join'      => 'belong_goods',
            'conditions'=> $conditions . ' AND gb.store_id=' . $id ,
            'order'     => 'group_id DESC',
            'limit'     => $page['limit'],
            'count'     => true
        ));
        $page['item_count'] = $groupbuy_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        if (empty($groupbuy_list))
        {
            $groupbuy_list = array();
        }
        foreach ($groupbuy_list as $key => $_g)
        {
            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $tmp = current(unserialize($_g['spec_price']));
            $groupbuy_list[$key]['price'] = $tmp['price'];
            
            if ($_g['end_time'] < gmtime())
            {
                $groupbuy_list[$key]['group_state'] = group_state($_g['state']);
            }
            else
            {
                $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);
            }
        }
        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('groupbuy_list')
        );

        $this->assign('groupbuy_list', $groupbuy_list);
        $this->assign('search_name', $search_name);
        $this->_config_seo('title', $search_name[0]['text'] . ' - ' . $store['store_name']);
        $this->display('store.groupbuy.html');
    }
    
    function article_index()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $article_mod =& m('article');
        $articles = $article_mod->find(
                array(
                    'conditions'=> 'store_id=' . $id ,
                )
        );
        $this->assign('articles', $articles);
        $this->display('store.article_index.html');
    }
    
    function article()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $article = $this->_get_article($id);
        if (!$article)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->assign('article', $article);

        /* 店铺信息 */
        $this->set_store($article['store_id']);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            $article['title']
        );

        $this->_config_seo('title', $article['title'] . ' - ' . $store['store_name']);
        $this->display('store.article.html');
    }

    /* 信用评价 */
    function credit()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);
        /* 取得评价过的商品 */
        if (!empty($_GET['eval']) && in_array($_GET['eval'], array(1,2,3)))
        {
            $conditions = "AND evaluation = '{$_GET['eval']}'";
        }
        else
        {
            $conditions = "";
            $_GET['eval'] = '';
        }
        $page = $this->_get_page(10);
        $order_goods_mod =& m('ordergoods');
        $goods_list = $order_goods_mod->find(array(
            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 " . $conditions,
            'join'       => 'belongs_to_order',
            'fields'     => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment',
            'order'      => 'evaluation_time desc',
            'limit'      => $page['limit'],
            'count'      => true,
        ));
        $this->assign('goods_list', $goods_list);

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 按时间统计 */
        $stats = array();
        for ($i = 0; $i <= 3; $i++)
        {
            $stats[$i]['in_a_week']        = 0;
            $stats[$i]['in_a_month']       = 0;
            $stats[$i]['in_six_month']     = 0;
            $stats[$i]['six_month_before'] = 0;
            $stats[$i]['total']            = 0;
        }

        $goods_list = $order_goods_mod->find(array(
            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 ",
            'join'       => 'belongs_to_order',
            'fields'     => 'evaluation_time, evaluation',
        ));
        foreach ($goods_list as $goods)
        {
            $eval = $goods['evaluation'];
            $stats[$eval]['total']++;
            $stats[0]['total']++;

            $days = (gmtime() - $goods['evaluation_time']) / (24 * 3600);
            if ($days <= 7)
            {
                $stats[$eval]['in_a_week']++;
                $stats[0]['in_a_week']++;
            }
            if ($days <= 30)
            {
                $stats[$eval]['in_a_month']++;
                $stats[0]['in_a_month']++;
            }
            if ($days <= 180)
            {
                $stats[$eval]['in_six_month']++;
                $stats[0]['in_six_month']++;
            }
            if ($days > 180)
            {
                $stats[$eval]['six_month_before']++;
                $stats[0]['six_month_before']++;
            }
        }
        $this->assign('stats', $stats);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('credit_evaluation')
        );

        $this->_config_seo('title', Lang::get('credit_evaluation') . ' - ' . $store['store_name']);
        $this->display('store.credit.html');
    }

    /* 取得友情链接 */
    function _get_partners($id)
    {
        $partner_mod =& m('partner');
        return $partner_mod->find(array(
            'conditions' => "store_id = '$id'",
            'order' => 'sort_order',
        ));
    }

    /* 取得推荐商品 */
    function _get_recommended_goods($id, $num = 12)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
       /* $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1 AND recommended = 1",
            'fields'     => 'goods_name, default_image, price,spec_id',
            'limit'      => $num,
        ));*/
		if(isset($_SESSION['store_id']))
			{
				$sstore_id='AND g.store_id='.$_SESSION['store_id'];
				}
			else{
				$sstore_id='';
			}
		$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0 AND g.recommended = 1 '.$sstore_id ,
            	'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => $num,
        	));
		
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }

    function _get_new_groupbuy($id, $num = 12)
    {
		$model_groupbuy =& m('groupbuy', array('_store_id' => $id));
        $groupbuy_list = $model_groupbuy->find(array(
            'fields'    => 'goods.default_image, this.group_name, this.group_id, this.spec_price, this.end_time',
            'join'      => 'belong_goods',
            'conditions'=> $model_groupbuy->getRealFields('this.state=' . GROUP_ON . ' AND this.store_id=' . $id . ' AND end_time>'. gmtime()),
            'order'     => 'group_id DESC',
            'limit'     => $num
        ));
        if (empty($groupbuy_list))
        {
            $groupbuy_list = array();
        }
        foreach ($groupbuy_list as $key => $_g)
        {
            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $tmp = current(unserialize($_g['spec_price']));
            $groupbuy_list[$key]['price'] = $tmp['price'];
            $groupbuy_list[$key]['group_price'] = $tmp['price'];
            $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);
        }

        return $groupbuy_list;
    }
    
    //取得秒杀商品  begin
    function _get_seckill_goods($store_id, $num = 4){
        $db = & db();
        $sql = "SELECT g.goods_id, g.goods_name, g.default_image, g.price, sk.kuaixun_id, sk.kuaixun_name, sk.goods_sn, sk.kuaixun_price, sk.start_time, sk.end_time, sk.store_ids, sk.add_time, sk.kuaixun_state,sk.operate_person, gs.spec_id, gs.stock, st.sales FROM ecm_kuaixun_promotion sk LEFT JOIN ecm_goods g ON sk.goods_id = g.goods_id LEFT JOIN ecm_goods_spec gs on sk.goods_id=gs.goods_id LEFT JOIN ecm_goods_statistics st ON st.goods_id=sk.goods_id WHERE g.closed=0 AND sk.kuaixun_state IN(2,3,4) ORDER BY sk.add_time DESC " . " limit " . $num ;
        $goods_list = $db->getAll($sql);
		
		/*var_dump($goods_list);
		exit();*/
		
		foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
            //秒杀开始时间
            $start_time = $goods_list[$key]['start_time'];
			//秒杀结束时间
            $end_time = $goods_list[$key]['end_time'];
            //当前服务器时间
            $now = gmtime();
			
			//判断当前店铺是否可执行秒杀
			$store_ids = explode(',', $goods_list[$key]['store_ids']);
			
			$store_id = trim($_SESSION['store_id']);
			if(!empty($store_id) && isset($store_id)){
				if(in_array($store_id, $store_ids)){
					$sec_flag = 0;
					//已经开始但没结束
					if($now >= $start_time && $now <= $end_time && $goods_list[$key]['stock'] > 0){
					   $db->query("update ecm_kuaixun_promotion set kuaixun_state=3 where kuaixun_id=" . $goods_list[$key]['kuaixun_id']);
					   $sec_flag = 1;
					} 
					//未开始
					if($now < $start_time && $goods_list[$key]['stock'] >= 1){
					   $db->query("update ecm_kuaixun_promotion set kuaixun_state=2 where kuaixun_id=" . $goods_list[$key]['kuaixun_id']);
					   $sec_flag = 2;
					}
					//已结束
					if($goods_list[$key]['stock'] < 1 || $now > $end_time){
					   $db->query("update ecm_kuaixun_promotion set kuaixun_state=4 where kuaixun_id=" . $goods_list[$key]['kuaixun_id']);
					   $sec_flag = 3;
					}
				}else{
					return 'error';	
				}
			}else{
				return;	
			}
            
        }
	    
		$this->assign('sec_start_time', $start_time);
		$this->assign('sec_end_time', $end_time);
		$this->assign('sec_now_time', $now);
		$this->assign('sec_flag', $sec_flag);
		$this->assign('store_id', $_SESSION['store_id']);
	   
        return $goods_list;
    }
    //end
    
    /* 取得最新商品 */
    function _get_new_goods($id, $num = 12)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
        /*  $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1",
            'fields'     => 'goods_name, default_image, price,spec_id',
            'order'      => 'add_time desc',
            'limit'      => $num,
        ));*/
		if(isset($_SESSION['store_id']))
			{
				$sstore_id='AND g.store_id='.$_SESSION['store_id'];
				}
			else{
				$sstore_id='';
			}
			$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0  '.$sstore_id,
            	'order'      => 'add_time desc',
				'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => $num,
        	));
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }
	/* 取得热卖商品 */
	function _get_hot_sale_goods($id, $num = 16)
	{
		$goods_mod =& bm('goods', array('_store_id' => $id));
       /* $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1",
			'join'		 => 'has_goodsstatistics',
            'fields'     => 'goods_name, default_image, price,sales,spec_id',
            'order'      => 'sales desc,add_time desc',
            'limit'      => $num,
        ));*/
		if(isset($_SESSION['store_id']))
			{
				$sstore_id='AND g.store_id='.$_SESSION['store_id'];
				}
			else{
				$sstore_id='';
			}
			$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0  '.$sstore_id ,
            	'join'		 => 'has_goodsstatistics',
				'order'      => 'add_time desc',
				'fields'	 =>'g.store_id,g.goods_name, g.default_image, gs.price,sales,',
            	'limit'      => $num,
        	));
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
        return $goods_list;
	}

    /* 搜索到的结果 */
    function _assign_searched_goods($id)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
        $search_name = LANG::get('all_goods');

       /* $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'goods_name',
                'name'  => 'keyword',
                'equal' => 'like',
            ),
        ));*/
		 $conditions="";
        $keywords=$_GET['keyword'];//AND goods_name like '%美女 奶%'
		$arr_keywords=array_filter(explode(' ',$keywords));
		$arr_keys=array_keys($arr_keywords);
		if(count($arr_keywords)){
			$conditions.=" AND (";
		}
		
		for($i=0;$i<count($arr_keywords);$i++)
		{
			if($i==0)
			{
				$conditions.="  (";
			}
			
			if($i==(count($arr_keywords)-1))
			{
				$conditions.=" goods_name like '%".$arr_keywords[$arr_keys[$i]]."%')";
			}else{
				$conditions.="goods_name like '%".$arr_keywords[$arr_keys[$i]]."%' or ";
			}
		}
		
		for($i=0;$i<count($arr_keywords);$i++)
		{
			if($i==0)
			{
				$conditions.=" or (";
			}
			
			if($i==(count($arr_keywords)-1))
			{
				$conditions.=" tags like '%".$arr_keywords[$arr_keys[$i]]."%')";
			}else{
				$conditions.=" tags like '%".$arr_keywords[$arr_keys[$i]]."%' or ";
			}
		}
if(count($arr_keywords)){
			$conditions.=" )";
		}
		//exit();
        if ($conditions)
        {
            $search_name = sprintf(LANG::get('goods_include'), $_GET['keyword']);
            $sgcate_id   = 0;
        }
        else
        {
            $sgcate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
        }

        if ($sgcate_id > 0)
        {
            $gcategory_mod =& bm('gcategory', array('_store_id' => $id));
            $sgcate = $gcategory_mod->get_info($sgcate_id);
            $search_name = $sgcate['cate_name'];

            $sgcate_ids = $gcategory_mod->get_descendant_ids($sgcate_id);
        }
        else
        {
            $sgcate_ids = array();
        }

        /* 排序方式 */
        $orders = array(
            'add_time desc' => LANG::get('add_time_desc'),
            'price asc' => LANG::get('price_asc'),
            'price desc' => LANG::get('price_desc'),
        );
        $this->assign('orders', $orders);
         if(confirm_src())
		 {
			  $page = $this->_get_page(10);
			 
		 }else{
			 $page = $this->_get_page(16); 
		 }

        //$page = $this->_get_page(16);
        $goods_list = $goods_mod->get_list(array(
            'conditions' => 'closed = 0 AND if_show = 1' . $conditions,
            'count' => true,
            'order' => empty($_GET['order']) || !isset($orders[$_GET['order']]) ? 'add_time desc' : $_GET['order'],
            'limit' => $page['limit'],
        ), $sgcate_ids);
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
		if(confirm_src())
		{
			 $this->assign('goods_list', $goods_list);
		}else{
        $this->assign('searched_goods', $goods_list);
		}
         // print_r($goods_list);
		  //exit();
        $page['item_count'] = $goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        $this->assign('search_name', $search_name);
    }

    /**
     * 取得文章信息
     */
    function _get_article($id)
    {
        $article_mod =& m('article');
        return $article_mod->get_info($id);
    }
    
    function _get_seo_info($data)
    {
        $seo_info = $keywords = array();
        $seo_info['title'] = $data['store_name'] . ' - ' . Conf::get('site_title');        
        $keywords = array(
            str_replace("\t", ' ', $data['region_name']),
            $data['store_name'],
        );
        //$seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));
        $seo_info['keywords'] = implode(',', $keywords);
        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);
        return $seo_info;
    }
	//选择店铺
	function select_store(){
		$store_mod = &m('store');
		$store_arr = $store_mod->find(array(
			'fields' => '*',
			'order' => 'store_id DESC'
		));
		$this->assign('stores', $store_arr);
		$this->display('store.select.html');
	}
	//店铺搜索相关  begin
	/**
	 * 取得查询参数（有值才返回）
	 *
	 * @return  array(
	 *              'keyword'   => array('aa', 'bb'),
	 *              'cate_id'   => 2,
	 *              'layer'     => 2, // 分类层级
	 *              'brand'     => 'ibm',
	 *              'region_id' => 23,
	 *              'price'     => array('min' => 10, 'max' => 100),
	 *          )
	 */
	function _get_query_param()
	{
	    static $res = null;
	    if ($res === null)
	    {
	        $res = array();
	
	        // keyword
	        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
	        if ($keyword != '')
	        {
	            //$keyword = preg_split("/[\s," . Lang::get('comma') . Lang::get('whitespace') . "]+/", $keyword);
	            $tmp = str_replace(array(Lang::get('comma'),Lang::get('whitespace'),' '),',', $keyword);
	            $keyword = explode(',',$tmp);
	            sort($keyword);
	            $res['keyword'] = $keyword;
	        }
	
	        // cate_id
	        if (isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0)
	        {
	            $res['cate_id'] = $cate_id = intval($_GET['cate_id']);
	            $gcategory_mod  =& bm('gcategory');
	            $res['layer']   = $gcategory_mod->get_layer($cate_id, true);
	        }
	
	        // brand
	        if (isset($_GET['brand']))
	        {
	            $brand = trim($_GET['brand']);
	            $res['brand'] = $brand;
	        }
	
	        // region_id
	        if (isset($_GET['region_id']) && intval($_GET['region_id']) > 0)
	        {
	            $res['region_id'] = intval($_GET['region_id']);
	        }
	
	        // price
	        if (isset($_GET['price']))
	        {
	            $arr = explode('-', $_GET['price']);
	            $min = abs(floatval($arr[0]));
	            $max = abs(floatval($arr[1]));
	            if ($min * $max > 0 && $min > $max)
	            {
	                list($min, $max) = array($max, $min);
	            }
	
	            $res['price'] = array(
	                'min' => $min,
	                'max' => $max
	            );
	        }
	        // tyioocom 获取属性参数
	        if (isset($_GET['props']))
	        {
	            if($this->_check_query_param_by_props()){
	                $res['props'] = trim($_GET['props']);
	            }
	        }
	    }
	
	    return $res;
	}
	// tyioocom  进行安全过滤
	function _check_query_param_by_props()
	{
	    $pvs = $_GET['props'];
	    if(!empty($pvs)){
	        $pvs_arr = explode(';',$pvs);
	        foreach($pvs_arr as $pv){
	            $pv_arr = explode(':', $pv);
	            if(is_array($pv_arr)){
	                if(!is_numeric($pv_arr[0]) || !is_numeric($pv_arr[1])){
	                    return false;
	                }
	            } else {
	                return false;
	            }
	        }
	    }
	    return true;
	}
	//end
	
}

?>
