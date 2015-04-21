<?php

/**
 *    文章管理控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class _ms_promotionApp extends BackendApp
{
	var $_discount_mod;
	var $_schedule_mod;
	var $_promotion_mod;
	var $_promotion_goods_mod;
	
	function __construct()
	{
		$this->_ms_promotionApp();
	}
	function _ms_promotionApp()
	{
		parent::BackendApp();
		$this->_discount_mod =& m('discount');
		$this->_schedule_mod =& m('schedule');
		$this->_pattern_mod =& m('pattern');		
		//秒杀
		$this->_promotion_mod =& m('promotion');
		$this->_promotion_goods_mod =& m('promotion_goods');
	}

	/**
     *    文章索引
     *
     *    @author    Hyber
     *    @return    void
     */
	function index()
	{
		$db = &db();
		
		//dump(date('Y-m-d H:i:s',time()));
		$sql='';
		
		$page   =   $this->_get_page(10);   //获取分页信息

		if(!empty($_GET['s_p_type']) && $_GET['s_p_type']!=0)
        {
			$page['item_count']=$db->getOne('select count(p_id) from ecm_promotion where p_type='.$_GET['s_p_type']);   //获取统计数据
		}
		else
		{
			$page['item_count']=$db->getOne('select count(p_id) from ecm_promotion ');   //获取统计数据
            
		}
        
		
		$this->_format_page($page);
		if(!empty($_GET['s_p_name'])){	
			if(!empty($_GET['s_p_type']) && $_GET['s_p_type']!=0)
			{
				$sql="select * from ecm_promotion where p_type=".$_GET['s_p_type']." and  p_name like '%{$_GET['s_p_name']}%' limit {$page['limit']}";
            }else{
				$sql="select * from ecm_promotion where  p_name like '%{$_GET['s_p_name']}%' limit {$page['limit']}";
            }
            
		}else{		
			if(!empty($_GET['s_p_type']) && $_GET['s_p_type']!=0)
			{
				$sql="select * from ecm_promotion where p_type=".$_GET['s_p_type']." order by p_id desc limit {$page['limit']}";
			}else{
				$sql="select * from ecm_promotion order by p_id desc limit {$page['limit']}";
            }			
            
		}
		
		$discounts = $db->getall($sql);		
		$this->assign('s_p_name',$_GET['s_p_name']);  
		$this->assign('s_p_type',$_GET['s_p_type']);  
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('discounts',$discounts);		
		$this->display('_ms.index.html');
	}
	
	/**
     *    组合列表
     *
     *    @author    Hyber
     *    @return    void
     */
	function list_zhuhe()
	{
		$db = &db();

		
		//获取商品
		
		$sql_pg='select  c.p_name,a.id,a.p_id,a.goods_id,a.goods_sn,a.goods_name,a.price as newprice,a.quantity,a.store_id,a.store_name,b.price as oldprice,b.store_id from ecm_promotion_goods as a ,ecm_promotion as c,ecmall.ecm_goods as b  where a.goods_id=b.goods_id  and c.p_id=a.p_id and a.p_id='.$_GET['id'].' and a.goods_name like \'%'.trim($_GET['title']).'%\'';
		//select  c.p_name,a.id,a.p_id,a.goods_id,a.goods_sn,a.goods_name,a.price as newprice,a.quantity,a.store_id,a.store_name,b.price as oldprice  from ecm_promotion_goods as a ,ecm_promotion as c,ecmall.ecm_goods as b 
		//where a.goods_id=b.goods_id  and c.p_id=a.p_id and a.p_id=1 and a.goods_name like '%%'
		
		$zhuhes = $db->getall($sql_pg);
		$this->assign('title',$_GET['title']);
		$this->assign('id',$_GET['id']);
		$this->assign('zhuhes',$zhuhes);
		$this->display('_ms.list.html');
		
	}
	
	//组合A/组合B
	function zhuhe() {
		$db = &db();
		$id = $_GET['id'];
		$type = $_GET['p_type'];
		$sql="select * from ecm_pattern_a where cuxiao_id=$id and p_type=$type ";
		$zhuhes = $db->getall($sql);
		$list = $db->getRow("select * from ecm_discount_promotion where discount_id=$id");
		//dump($list);
		$this->assign('zhuhes',$zhuhes);
		$this->assign('type',$type);
		$this->assign('list',$list);
		$this->display('discount.zhuheAB.html');
	}		
	
	/**
     *    新增折扣名称
     *
     *    @author    Hyber
     *    @return    void
     */
	function add()
	{
		//获取档期状态
		if (!IS_POST)
		{
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$sql1='SELECT cate_id,cate_name FROM ecm_gcategory where parent_id=0';
			
			$_gtype=$db->getall($sql1);
			$list = $db->getall($sql);
			//dump($list);
			$this->assign('_gtype',$_gtype);
			$this->assign('list',$list);
			$this->display('_ms.form.html');
		}
		else
		{
			$_p_type=-1;
			$data = array();
			$data['start_time']      =   gmstr2time($_POST['start_time']);//开始时间
			$data['end_time']    =   gmstr2time($_POST['end_time']);//结束时间
			if($data['start_time']=="" ||$data['end_time']=="")
			{
				$this->show_warning("开始/结束时间不能为空！");

				return;
				
			}	
			
			$data['p_name']    =   $_POST['p_name'];//活动名称
			if(trim( $data['p_name'])=="")
			{				
				$this->show_warning("促销活动名称不能为空！");
				return;
			}			
			
			$data['state'] = 1;				//活动状态
			$data['weight'] =   $_POST['weight'];//活动权重			
			$data['xunhuan'] =   $_POST['xunhuan'];//活动权重	
				$data['stores'] =   $_POST['stores'];	
			$data['operate_person'] =   $_POST['operate_person'];//操作人
			
			
			$data['add_time']   =   gmtime();//更新时间
			
			$data['p_type']=$_POST['_promotion_type'];//活动类型
			$_p_type=	$data['p_type'];
			
			$data['p_type_name']='秒杀';	
			if($data['p_type']== -1)
			{
				$this->show_warning("请选择促销活动类型！");
				return;
			}
			if($_p_type==1)
			{
				$data['p_type_name']='秒杀';
			}else if($_p_type==2)
			{
				$data['p_type_name']='组合';
			}else	if($_p_type==3)
			{
				$data['p_type_name']='满减';				
				$data['allow_cates']=trim( $_POST['GType_']);
				if($data['allow_cates']=='')
				{
					$this->show_warning("请选择参加活动的商品类型！");
					return;
				}
				
                
                
				$data['g_amount'] =  floatval( $_POST['g_amount']);//满额
				$data['discount'] =  floatval( $_POST['discount']);//减免
				
				if(trim( $data['g_amount'])==0 ||trim( $data['discount'])==0)
				{				
					$this->show_warning("满额/减免金额格式错误，（请确认已经填写且金额格式正确）！");
					return;
				}	
				
			} else if($_p_type==4)
			{
				$data['p_type_name']='满赠';
				$data['g_amount'] =  intval( $_POST['g_amount']);//满额		
				$data['allow_cates']=trim( $_POST['GType_']);
				if($data['allow_cates']=='')
				{
					$this->show_warning("请选择参加活动的商品类型！");
					return;
				}	
				if(trim( $data['g_amount'])==0 )
				{				
					$this->show_warning("满额金额格式错误，（请确认已经填写且金额格式正确）！");
					return;
				}		
			} 
			
			//写入数据库
			if (!$promotion_id = $this->_promotion_mod ->add($data))  //获取discount_id
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}			
			//根据分类修改信息
			if($_p_type==1)
			{
				$this->show_message('添加秒杀促销成功!',
					'开始添加秒杀促销产品', 'index.php?app=_ms_promotion&amp;act=add_zhuhe&amp;_p_type=1&amp;id='.$promotion_id
					);
			} else					if($_p_type==2)
            {
                $this->show_message('添加组合促销成功!',
                    '开始添加组合促销产品', 'index.php?app=_ms_promotion&amp;act=add_zhuhe&amp;_p_type=2&amp;id='.$promotion_id
                    );
            }
            else		
                if($_p_type==3)
                {
                    $this->show_message('添加满减促销成功!',
                        '返回促销活动列表', 'index.php?app=_ms_promotion'
                        );
                }else		
					if($_p_type==4)
					{
						$this->show_message('添加满赠促销成功!',
							'开始添加满赠促销的产品类型', 'index.php?app=_ms_promotion&amp;act=add_zhuhe&amp;_p_type=4&amp;id='.$promotion_id
							);
					}
		}
	}
	
	/**
     *    新增组合名称
     *
     *    @author    Hyber
     *    @return    void
     */
	function add_ajax(){
		$stores=$_POST['stores'];
		$pid=$_POST['cuxiao_id'];//促销id
		$price=$_POST['p_price'];//促销价格
		$quantity= $_POST['p_num'];//促销商品数量
		$goodid=$_POST['goods_id'];
        $stores=explode(",",$stores);
        $stores=array_unique($stores);
        $stores=array_filter($stores);
        //print_r($stores);
       // exit;
		$sql="select sku from ecm_goods_spec where goods_id=".$_POST['goods_id'];
		$db = &db();
		$sku = $db->getOne($sql);//获取商品信息
        $chengggong="成功店铺列表：（";
        $shibai="失败店铺列表：（";
        foreach ($stores as $key => $value) {
        	$sql_sel="SELECT a.goods_id,a.sku goods_sn,b.goods_name,b.store_id,c.store_name from ecm_goods_spec a left JOIN ecm_goods b on a.goods_id =b.goods_id 
LEFT JOIN ecm_store c on c.store_id=b.store_id
where a.sku='".$sku."' and b.store_id='".$value."'";
            $rows = $db->getAll($sql_sel);//获取商品信息
            if(count($rows)<1)
            {
            	$shibai.=$value.',';
				continue;
            }
            $goods=$rows[0];
            $goods['p_id'] = $pid;
		    $goods['price'] = $price;
		    $goods['quantity'] =$quantity;
		    $data = $goods;
		   if (!$_promotion_goods_id = $this->_promotion_goods_mod->add($data))  //添加到促销商品表获取pattern_id
			{
				$shibai.=$goods['store_id'].',';
				continue;
			}else{
		     $chengggong.=$goods['store_id'].',';
		     continue;
				
			}
			
        }

           echo $chengggong.");".$shibai.")。";

		/*$sql = 'select goods_name,store_id,goods_id from ecm_goods where goods_id='.$_POST['goods_id'];
		$sql1 = 'select price,sku,stock from ecm_goods_spec where goods_id='.$_POST['goods_id'];
		
		$goods = $db->getRow($sql);//获取商品信息
		$spec = $db->getRow($sql1);//获取商品信息
		
		//商家属性		
		$_base_price = $spec['price'];//原价
		$goods['goods_sn'] = $spec['sku'];			//商品条形码
		
		//绑定商店名称
		$sql2 = 'select store_name  from ecm_store where store_id='.$goods['store_id'];
		$_store = $db->getRow($sql2);		
		//$goods['store_name'] = $_store['store_name'];	//商店名称	
		
		//$goods['p_type'] = $_POST['p_type'];
		//$goods['pa_name'] = $_POST['pa_name'];
		//$goods['p_id'] = 
		//$goods['price'] = 
		//$goods['quantity'] =
		//$data = $goods;*/
		
	
		
	}
	
	//修改商品信息
	
	function edit_sp()
	{
		if($_GET['state']!=3)
		{
			$this->add_zhuhe();
		}else{
			$this->show_warning('不能修改正在【启动】中的促销活动！');
			return;
        }
		
	}
	
	
	//开始添加组合
	function add_zhuhe()
	{
		
        
		
		
		if (!IS_POST)
		{
			
			$db = &db();
			//获取促销信息	
			$list=$this->_promotion_mod->find($_GET['id']);
			$list=$list[$_GET['id']];
			
			//$goods = $db->getall('select goods_id,goods_name,price from ecm_goods');
			if(isset($_GET['id']))
			{
				//获取已经参加活动的商品
				$sql_pg='SELECT a.id,a.p_id,a.goods_id,a.goods_sn,a.goods_name,a.price  newprice,a.quantity,a.store_id,a.store_name,b.price oldprice from ecm_promotion_goods a LEFT JOIN ecm_goods_spec b 
on a.goods_id=b.goods_id where a.p_id='.$_GET['id'];				
				$_p_goods = $db->getall($sql_pg);				
				$content = '';
				
				foreach ($_p_goods as $_row)
				{
					$content .="<tr id='_pg_".$_row['id']."'><th class='v_pg_".$_row['goods_id']."'>".$_row['goods_id']."</th><th>".$_row['goods_sn']."</th><th>".$_row['store_name']."-".$_row['store_id']."</th><th>".$_row['goods_name']."</th><th>".$_row['oldprice']."</th>";
					
					$content .="<th>".$_row['newprice']."</th><th>".$_row['quantity']."</th>";
					$content .="<th><a href='javascript:void(0);' onclick='drop(this,".$_row['id'].")'>删除</a></th></tr>";
					
				}
				
				$this->assign('_content',$content);
				
				
			}				
			//dump($list);
			$this->assign('list',$list);
			$this->assign('goods',$goods);
			$this->assign('id',$_GET['id']);
			$this->display('_ms_sp.html');
		}
		else
		{
			//dump($_POST);
			//$arr = explode('_',$_POST['cuxiao']);
			$brr = explode('_',$_POST['gname']);
			$data = array(
				'cuxiao_id' => $_POST['discount_id'],
				'pa_name' => $_POST['discount_name'],
				'goods_id' => $brr[0],
				'goods_name' => $brr[1],
				'original_price' => $brr[2],
				'promotion_price'=>$_POST['promotion_price'],
				'promotion_num'=>$_POST['promotion_num'],
				'p_type'=>$_POST['p_type']
				);
			
			//dump($this->_discount_mod ->find(1));
			if (!$pattern_id = $this->_pattern_mod->add($data))  //获取discount_id
			{
				$this->show_warning($this->_pattern_mod->get_error());

				return;
			}else{
				//把促销id写到goods中
				$db = &db();
				$sql = 'select cuxiao_ids from ecm_goods where goods_id='.$data['goods_id'];
				$ids = $db->getOne($sql);
				if(!in_array($data['cuxiao_id'],explode(',',$ids))){
					$map['cuxiao_ids'] = $ids.$data['cuxiao_id'].',';
					$goods = & m('goods');
					$goods->edit($data['goods_id'],$map);
				}
				
			}
			
			$this->show_message('添加组合成功!',
				'back_list',    'index.php?app=_ms_promotion',
				'continue_add', 'index.php?app=_ms_promotion&amp;act=add_zhuhe'
				);
		}
	}
	/**
     *    编辑折扣
     *
     *    @author    Hyber
     *    @return    void
     */
	function edit()
	{
		$discount_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		if (!$discount_id)
		{
			$this->show_warning('参数错误！');
			return;
		}

		if (!IS_POST)
		{			
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$list = $db->getall($sql);
			//dump($list);            
			if(isset($_GET['id']))
			{				
				$sql = 'select * from ecm_promotion where p_id='.$_GET['id'];
				$_promotion_info = $db->getRow($sql);
				
				if($_promotion_info['p_type']==3 ||$_promotion_info['p_type']==4)
				{
					
					$sql1='SELECT cate_id,cate_name FROM ecm_gcategory where parent_id=0';					
					$_gtype=$db->getall($sql1);				
					
					foreach($_gtype as $key=>$value)
					{
						if(strpos($_promotion_info['allow_cates'],$value['cate_id'].',') !== false)
						{						
							$_gtype[$key]['selected']='1';	
						}
						else{
							$_gtype[$key]['selected']='0';	
						}					
					}	
					
					//dump($list);
					$this->assign('_gtype',$_gtype);//商品类型						
				}
				$this->assign('_pr_info',$_promotion_info);
			}		
			
			$this->assign('list',$list);
			$this->assign('_ms_promotion', $discount);
			$this->display('_ms.edit.html');
			
		}
		else
		{
			$data = array();
			$_pro_id=$_POST['id'];
			
			$data['start_time']      =   gmstr2time($_POST['start_time']);
			$data['end_time']    =   gmstr2time($_POST['end_time']);
			if($data['start_time']=="" ||$data['end_time']=="")
			{
				$this->show_warning("开始/结束时间不能为空！");

				return;
				
			}
			
			$data['p_name']    =   $_POST['p_name'];//活动名称
			
			if(trim( $data['p_name'])=="")
			{				
				$this->show_warning("促销活动名称不能为空！");
				return;
			}					
			
			$data['state'] =   $_POST['_ms_promotion_state'];			
			$data['weight'] =   $_POST['weight'];
			$data['xunhuan'] =   $_POST['xunhuan'];
			$data['stores'] =   $_POST['stores'];
			$data['operate_person'] =  $_POST['operate_person'];		
			
			$data['add_time']   =   gmtime();	
			
			/**************************/
			
			
			
            
			
			$data['p_type']=$_POST['_promotion_type'];//活动类型
			$_p_type=	$data['p_type'];			
            
			if($data['p_type']== -1)
			{
				$this->show_warning("请选择促销活动类型！");
				return;
			}
			if($_p_type==3)
			{
                
				$data['allow_cates']=trim( $_POST['GType_']);
				if($data['allow_cates']=='')
				{
					$this->show_warning("请选择参加活动的商品类型！");
					return;
				}
				
				$data['g_amount'] =  floatval( $_POST['g_amount']);//满额
				$data['discount'] =  floatval( $_POST['discount']);//减免
				
				if(trim( $data['g_amount'])==0 ||trim( $data['discount'])==0)
				{				
					$this->show_warning("满额/减免金额格式错误，（请确认已经填写且金额格式正确）！");
					return;
				}	
				
			} else if($_p_type==4)
			{
				
				$data['g_amount'] =  intval( $_POST['g_amount']);//满额		
				$data['allow_cates']=trim( $_POST['GType_']);
				if($data['allow_cates']=='')
				{
					$this->show_warning("请选择参加活动的商品类型！");
					return;
				}	
				if(trim( $data['g_amount'])==0 )
				{				
					$this->show_warning("满额金额格式错误，（请确认已经填写且金额格式正确）！");
					return;
				}		
			} 
			
			
			
			
			
			
			
            
			$rows=$this->_promotion_mod->edit($_pro_id, $data);
			if ($this->_discount_mod->has_error())
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}
			$this->show_message('修改促销信息成功！',
				'back_list',        'index.php?app=_ms_promotion',
				'添加促销信息', 'index.php?app=_ms_promotion&amp;act=add_zhuhe&amp;id='.$_pro_id	
				);
		}
		
	}
	
	/**
     *    编辑组合
     *
     *    @author    Hyber
     *    @return    void
     */
	function edit_zhuhe()
	{
		$discount_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		if (!$discount_id)
		{
			$this->show_warning('没有这个文件');
			return;
		}

		if (!IS_POST)
		{
			
			
			$find_data   = $this->_promotion_goods_mod->find($discount_id);
			
			if (empty($find_data))
			{
				$this->show_warning('no_such_article');

				return;
			}
			
			$zhuhe    =   current($find_data);			

			$this->assign('zhuhe', $zhuhe);
			
			$this->display('_ms_spedit.html');
		}
		else
		{
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			
			$data = array(
				'price'=>$_POST['promotion_price'],
				'quantity'=>$_POST['promotion_num']
				
				);
			$rows=$this->_promotion_goods_mod->edit($id,$data);
			//dump($rows);
			if ($this->_promotion_goods_mod->has_error())
			{
				$this->show_warning($this->_promotion_goods_mod->get_error());

				return;
			}
			$this->show_message('修改成功！',
				'back_list',        'index.php?app=_ms_promotion&act=list_zhuhe&id='.$_POST['p_id']
				);
		}
		
	}

	//异步获取数据
	function ajax_col()
	{
		if($_REQUEST['schedule_id']){
			$id = empty($_REQUEST['schedule_id']) ? 0 : intval($_REQUEST['schedule_id']);
			$db = &db();
			$sql = 'select start_time,end_time from ecm_schedule where schedule_id='.$id;
			$list = $db->getRow($sql);
			$list['start_time'] = date('Y-m-d H:i:s',$list['start_time']);
			$list['end_time'] = date('Y-m-d H:i:s',$list['end_time']);
			echo json_encode($list);
		}

		else if((strlen($_POST['goods_sn'])>1) || (strlen($_POST['goods_name'])>1)){
			$db = &db();
			$sql = "SELECT b.goods_id,b.goods_name,b.store_id,c.store_name,a.price,a.sku from ecm_goods_spec a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id
LEFT JOIN ecm_store c on b.store_id=c.store_id where b.goods_name like '%{$_POST['goods_name']}%' and a.sku like '%{$_POST['goods_sn']}%'";
			$list = $db->getall($sql);
		
			$content = "";
			foreach($list as $key1=>$value1){
				$content .="<tr><th>".$value1['goods_id']."</th><th>".$value1['sku']."</th><th>".$value1['store_name']."-".$value1['store_id']."</th><th>".$value1['goods_name']."</th><th>".$value1['price']."</th>";
				$content .="<th><input	type='text' id=p".$value1['goods_id']." value='".$value1['price']."'></th><th><input type='text' id=".$value1['goods_id']." value='1'></th>";
				$content .="<th><input	type='text' id=sg".$value1['goods_id']." value='".$value1['store_id']."'></th>";
				$content .="<th style='cursor:pointer;' onclick='add(this,".$value1['goods_id'].")'>添加</th></tr>";
			}

			echo $content;
			exit();
		}else{
			$content="";
		    echo $content;
			exit;	
        }
		
	}
	//ajax 删除数据
	function ajax_drop(){
		if($_POST['id']){
			if (!$this->_pattern_mod->drop($_POST['id']))    //删除
			{
				echo '删除错误！';
			}
		}
	}
	//删除秒杀商品
	function  ajax_drop_goods(){
		if($_POST['id']){
			$db = &db();
			$sql = 'select * from ecm_promotion_goods where id='.$_POST['id'];
			$list = $db->getRow($sql);			
			
			if (!$this->_promotion_goods_mod->drop($_POST['id']))    //删除
			{
				echo '删除错误！';
			}else {				
                
				$sql = 'select cuxiao_ids from ecm_goods where goods_id='.$list['goods_id'];
				$ids = $db->getOne($sql);				
				//去除参加活动标识
                $map['cuxiao_ids']=str_replace($list['p_id'].',', '', $ids);               
                
				$goods = & m('goods');                
				$goods->edit($list['goods_id'], $map);			
			}
		}		
	}	
	
	function drop()
	{
		$db = &db();
		
		$p_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$p_ids)
		{
			$this->show_warning('没有促销信息');
			return;
		}
		$p_ids=explode(',', $p_ids);
		

		foreach ($p_ids as $key=>$value){ 
			
			if (!$this->_promotion_mod->drop($value))    //删除
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return ;
			}
			
			//删除秒杀商品关联
			$sql_ ='select * from ecm_promotion_goods  where p_id='.$value;
			$list_ = $db->getall($sql_);
			
			
			if(!empty($list_))
			{
				foreach ($list_ as $_row)
				{				
					$db = &db();
					$sql = 'select cuxiao_ids from ecm_goods where goods_id='.$_row['goods_id'];
					$ids = $db->getOne($sql);
					//去除参加活动标识
					$map['cuxiao_ids']=str_replace($value.',', '', $ids);
					$goods = & m('goods');
					$goods->edit($_row['goods_id'],$map);				
					
				}		
				$_safesql='SET SQL_SAFE_UPDATES = 0';
				$db->query($_safesql);			
				$sql  = 'delete from ecm_promotion_goods where p_id='.$value;
				$db->query($sql);
			}
		}		
		$this->show_message('删除促销信息成功！');
	}	
	
	//修改为  未确认状态
	function unbesure()
	{
		$db = &db();
		
		$p_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		
		
		//dump($file_ids);
		if (!$p_ids)
		{
			$this->show_warning('没有促销信息');
			return;
		}
		$p_ids=explode(',', $p_ids);
		

		

		foreach ($p_ids as $key=>$value){ 
			//vz
            
			$data = array();
			$data['state'] = 1;//修改状态			
			
			//修改状态
			$rows=$this->_promotion_mod->edit($value,$data);
            
			/*if ($this->_promotion_mod->has_error())
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}	*/		
            
		}		
		$this->show_message('修改促销状态->【未确认】成功！');
		
	}
	
	//修改为  确认状态
	function besure()
	{
		$db = &db();
		
		$p_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$p_ids)
		{
			$this->show_warning('没有促销信息');
			return;
		}
		$p_ids=explode(',', $p_ids);
		

		foreach ($p_ids as $key=>$value){ 
			//vz
			
			$data = array();
			$data['state'] = 2;//修改状态			
			
			//修改状态
			$rows=$this->_promotion_mod->edit($value, $data);						
			/*if ($this->_discount_mod->has_error())
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}*/	

			
		}		
		$this->show_message('修改促销状态->【确认】成功！');
		
	}
	//修改为  启动状态
	function executing()
	{
		$db = &db();
		
		$p_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$p_ids)
		{
			$this->show_warning('没有促销信息');
			return;
		}
		$p_ids=explode(',', $p_ids);
		

		foreach ($p_ids as $key=>$value){ 
			//vz
			
			$data = array();
			$data['state'] = 3;//修改状态			
			
			//修改状态
			$rows=$this->_promotion_mod->edit($value, $data);						
			/*if ($this->_discount_mod->has_error())
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}			
			*/
			$sql_sel="SELECT * from ecm_promotion_goods where p_id=".$value;
			$all_goods=$db->getAll($sql_sel);
			foreach ($all_goods as $keyg => $valueg) {
				$sql_g="select cuxiao_ids from ecm_goods where goods_id=".$valueg['goods_id'];
				$cuxiao_ids=$db->getOne($sql_g);
                $arr_ids=explode(",",$cuxiao_ids);
               if(!in_array($value, $arr_ids))
               {
                  $arr_ids[]=$value;
               }
                $sql_u="update ecm_goods set cuxiao_ids='".implode(",",$arr_ids)."' where goods_id=".$valueg['goods_id'];
				$db->query($sql_u);
			}
			

		}		
		$this->show_message('修改促销状态->【启动中.】成功！');
		
	}
	//修改为  结束状态
	function finished()
	{
		$db = &db();
		
		$p_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$p_ids)
		{
			$this->show_warning('没有促销信息');
			return;
		}
		$p_ids=explode(',', $p_ids);
		

		foreach ($p_ids as $key=>$value){ 
			//vz
			
			$data = array();
			$data['state'] = 4;//修改状态			
			
			//修改状态
			$rows=$this->_promotion_mod->edit($value, $data);						
			/*if ($this->_discount_mod->has_error())
			{
				$this->show_warning($this->_promotion_mod->get_error());
				return;
			}*/	
			$sql_sel="SELECT * from ecm_promotion_goods where p_id=".$value;
			$all_goods=$db->getAll($sql_sel);
			foreach ($all_goods as $keyg => $valueg) {
				$sql_g="select cuxiao_ids from ecm_goods where goods_id=".$valueg['goods_id'];
				$cuxiao_ids=$db->getOne($sql_g);
                $arr_ids=explode(",",$cuxiao_ids);

               if(in_array($value, $arr_ids))
               {
               	$arr_keys=array_keys($arr_ids);
               	    foreach ($arr_keys as $key) {
               		if($arr_ids[$key]==$value)
               		{
                      unset($arr_ids[$key]);
               		}
               	}
                
               }
               
               $string_ids=implode(",",$arr_ids);
               if(!strlen($string_ids))
               {
               	$string_ids=" ";
               }
                $sql_u="update ecm_goods set cuxiao_ids='".$string_ids."' where goods_id=".$valueg['goods_id'];
				$db->query($sql_u);
			}		
			
		}		
		$this->show_message('修改促销状态->【结束】成功！');
		
	}
	
	
	
	
	//删除组合
	function drop_zhuhe()
	{
		
		$zhuhe_ids = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
		//dump($file_id);
		if (!$zhuhe_ids)
		{
			$this->show_warning('没有这个商品');

			return;
		}
		$zhuhe_ids=explode(',', $zhuhe_ids);
		foreach ($zhuhe_ids as $key=>$value){ 
			
			$db = &db();
			$sql = 'select * from ecm_promotion_goods where id='.$value;
			$list = $db->getRow($sql);			
			
			if (!$this->_promotion_goods_mod->drop($value))    //删除
			{
				echo '删除错误！';
			}else {				
				$db = &db();
				$sql = 'select cuxiao_ids from ecm_goods where goods_id='.$list['goods_id'];
				$ids = $db->getOne($sql);				
				//去除参加活动标识
				$map['cuxiao_ids']=str_replace($list['p_id'].',', '', $ids);		
				$goods = & m('goods');
				$goods->edit($list['goods_id'],$map);			
			}
		}	
		
		
		
		/*//dump($_GET);
		$zhuhe_ids = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
		//dump($file_id);
		if (!$zhuhe_ids)
		{
        $this->show_warning('没有这个商品');

        return;
		}
		$zhuhe_ids=explode(',', $zhuhe_ids);
		foreach ($zhuhe_ids as $key=>$value){ ;
        if (!$this->_pattern_mod->drop($value))    //删除
        {
        $this->show_warning($this->_pattern_mod->get_error());
        return ;
        }
		}	
         */
		$this->show_message('删除商品成功！');
	}



}

?>