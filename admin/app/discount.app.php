<?php

/**
 *    文章管理控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class DiscountApp extends BackendApp
{
    var $_discount_mod;
	var $_schedule_mod;

    function __construct()
    {
		$this->DiscountApp();
    }

	function DiscountApp()
    {
        parent::BackendApp();

		$this->_discount_mod =& m('discount');
		$this->_schedule_mod =& m('schedule');
		$this->_pattern_mod =& m('pattern');
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
		
		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的文章
		$page['item_count']=$db->getOne('select count(discount_id) from ecm_discount_promotion');   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
		if(!empty($_GET['title'])){
			$sql="select * from ecm_discount_promotion where discount_name like '%{$_GET['title']}%' limit {$page['limit']}";
		}else{
			$sql="select * from ecm_discount_promotion order by discount_id desc limit {$page['limit']}";
		}
		$discounts = $db->getall($sql);
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('discounts',$discounts);
		$this->display('discount.index.html');
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
		//$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的文章
		//$page['item_count']=$db->getOne('select count(pa_id) from ecm_pattern_a');   //获取统计数据
		//dump($page['item_count']);
		//$this->_format_page($page);
		
		if($_GET['id']&&!$_GET['p_type']){
			$id = $_GET['id'];
			//dump($id);
			$sql="select * from ecm_pattern_a where cuxiao_id=$id";
		}else if($_GET['p_type']){
			$id = $_GET['id'];
			$type=$_GET['p_type'];
			$sql="select * from ecm_pattern_a where cuxiao_id=$id and p_type=$type";
		}else{
			$sql="select * from ecm_pattern_a";
		}
		$zhuhes = $db->getall($sql);
		//dump($discounts);
		//$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('zhuhes',$zhuhes);
		$this->display('discount.list.html');
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
		
        if (!IS_POST)
        {
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$list = $db->getall($sql);
			//dump($list);
			$this->assign('list',$list);
			$this->display('discount.form.html');
        }
        else
        {
			$data = array();
			$data['start_time']      =   gmstr2time($_POST['start_time']);
			$data['end_time']    =   gmstr2time($_POST['end_time']);
            $data['discount_name']    =   $_POST['discount_name'];
			$data['store_id'] =   $_POST['store_id'];
            $data['loop_num'] =   $_POST['loop_num'];
			
			$data['discount_state'] =   $_POST['discount_state'];
			//$data['condition'] =   $_POST['condition'];
			$data['weight_factor'] =   $_POST['weight_factor'];
			$data['operate_person'] =   $_POST['operate_person'];
			$data['exec_type'] =   $_POST['exec_type'];
			//$data['pattern_a'] =  0;
			//$data['pattern_b'] =  0;
		
			$data['operate_time']   =   gmtime();
			//dump($data);
			//dump($this->_discount_mod ->find(1));
			if (!$discount_id = $this->_discount_mod ->add($data))  //获取discount_id
            {
				$this->show_warning($this->_discount_mod->get_error());

                return;
            }
			
            $this->show_message('添加促销成功!',
                '开始添加组合', 'index.php?app=discount&amp;act=add_zhuhe&amp;id='.$discount_id
            );
        }
    }
	
	/**
	   *    新增组合名称
	   *
	   *    @author    Hyber
	   *    @return    void
	   */
	function add_ajax(){
		$db = &db();
		$sql = 'select goods_name,goods_id from ecm_goods where goods_id='.$_POST['goods_id'];
		$sql1 = 'select price,sku,stock from ecm_goods_spec where goods_id='.$_POST['goods_id'];
		$goods = $db->getRow($sql);
		$spec = $db->getall($sql1);
		foreach ($spec as $value){
			$goods['original_price'] = $value['price'];
			$goods['goods_sn'] = $value['sku'];	
			//$goods['stock'] = $value['stock'];
		}
		$goods['p_type'] = $_POST['p_type'];
		$goods['pa_name'] = $_POST['pa_name'];
		$goods['cuxiao_id'] = $_POST['cuxiao_id'];
		$goods['promotion_price'] = $_POST['p_price'];
		$goods['promotion_num'] = $_POST['p_num'];
		$data = $goods;
		//dump($data);
		if (!$pattern_id = $this->_pattern_mod->add($data))  //获取pattern_id
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
			$content = '';
			//$content = "<tr><th>商品编号</th><th>商品名称</th><th>商品原价</th><th>商品促销价</th><th>促销数量</th><th>选择</th></tr>";
			$content .="<tr id=".$pattern_id."><th>".$data['goods_id']."</th><th>".$data['goods_name']."</th><th>".$data['original_price']."</th>";
			$content .="<th>".$data['promotion_price']."</th><th>".$data['promotion_num']."</th>";
			$content .="<th><a href='#' onclick='drop(this,".$pattern_id.")'>删除</a></th></tr>";
			echo $content;
			
		}
		
	}
	//开始添加组合
	function add_zhuhe()
	{
		
		if (!IS_POST)
		{
			$db = &db();
			$sql = 'select * from ecm_discount_promotion where discount_id='.$_GET['id'];
			$list = $db->getRow($sql);
			$goods = $db->getall('select goods_id,goods_name,price from ecm_goods');
			//dump($list);
			$this->assign('list',$list);
			$this->assign('goods',$goods);
			$this->assign('id',$_GET['id']);
			$this->display('discount.zhuhe.html');
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
				'back_list',    'index.php?app=discount',
				'continue_add', 'index.php?app=discount&amp;act=add_zhuhe'
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
			$this->show_warning('没有这个文件');
			return;
		}

		if (!IS_POST)
		{
			
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$list = $db->getall($sql);
			//dump($list);
			
			$find_data = $this->_discount_mod->find($discount_id);
			if (empty($find_data))
			{
				$this->show_warning('no_such_article');

				return;
			}
			
			$discount    =   current($find_data);
			$this->assign('list',$list);
			$this->assign('discount', $discount);
			$this->display('discount.form.html');
		
		}
		else
		{
			$data = array();
			//将日期转换成UNIX时间戳
			$data['start_time']      =   gmstr2time($_POST['start_time']);
			$data['end_time']    =   gmstr2time($_POST['end_time']);
			//dump(date('Y-m-d H:i:s',$data['start_time']));
			//dump($data['start_time']);
			$data['discount_name']    =   $_POST['discount_name'];
			$data['store_id'] =   $_POST['store_id'];
			$data['loop_num'] =   $_POST['loop_num'];
			
			$data['discount_state'] =   $_POST['discount_state'];
			$data['weight_factor'] =   $_POST['weight_factor'];
			$data['operate_person'] =   $_POST['operate_person'];
			$data['exec_type'] =   $_POST['exec_type'];
			
			$data['operate_time']   =   gmtime();
			//dump(date('Y-m-d H:i:s',$data['start_time']));
			$rows=$this->_discount_mod->edit($discount_id, $data);
			//dump($rows);
			if ($this->_discount_mod->has_error())
			{
				$this->show_warning($this->_discount_mod->get_error());

				return;
			}
			$this->show_message('修改折扣促销成功！',
				'back_list',        'index.php?app=discount',
				'继续添加组合', 'index.php?app=discount&amp;act=add_zhuhe&amp;id='.$discount_id	
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
			$db = &db();
			$sql = 'select * from ecm_discount_promotion';
			$list = $db->getall($sql);
			//$list = $db->getRow($sql);
			
			$find_data     = $this->_pattern_mod->find($discount_id);
			//dump($find_data);
			if (empty($find_data))
			{
				$this->show_warning('no_such_article');

				return;
			}
			
			$zhuhe    =   current($find_data);
			//dump($list);
			$this->assign('list',$list);
			$this->assign('zhuhe', $zhuhe);
			
			$this->display('discount.edit.html');
		}
		else
		{
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			//$arr = explode('_',$_POST['cuxiao']);
			//$brr = explode('_',$_POST['gname']);
			$data = array(
				'promotion_price'=>$_POST['promotion_price'],
				'promotion_num'=>$_POST['promotion_num'],
				'p_type'=>$_POST['p_type']
				);
			$rows=$this->_pattern_mod->edit($id,$data);
			//dump($rows);
			if ($this->_pattern_mod->has_error())
			{
				$this->show_warning($this->_pattern_mod->get_error());

				return;
			}else{
				//把促销id写到goods中
				$db = &db();
				$sql = 'select cuxiao_ids from ecm_goods where goods_id='.$_POST['goods_id'];
				$ids = $db->getOne($sql);
				if(!in_array($data['cuxiao_id'],explode(',',$ids))){
					$map['cuxiao_ids'] = $ids.$data['cuxiao_id'].',';
					$goods = & m('goods');
					$goods->edit($data['goods_id'],$map);
				}
			}
			$this->show_message('修改成功！',
				'back_list',        'index.php?app=discount&act=index'
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
		}else if (!empty($_POST['goods_name']) && !$_POST['goods_sn']){
			$db = &db();
			$sql = "select goods_id,goods_name from ecm_goods where goods_name like '%{$_POST['goods_name']}%'";
			$list = $db->getall($sql);
			foreach($list as $key=>$value){
				$sql = "select price from ecm_goods_spec where goods_id=".$value['goods_id'];
				$price =  $db->getOne($sql);
				$list[$key]['price'] = $price;
			}
			//$content = "<select name='gname'><option>选择商品</option>";
			$content = "";
			foreach($list as $key1=>$value1){
				$content .="<tr><th>".$value1['goods_id']."</th><th>".$value1['goods_name']."</th><th>".$value1['price']."</th>";
				$content .="<th><input	type='text' id=p".$value1['goods_id']." value='".$value1['price']."'></th><th><input type='text' id=".$value1['goods_id']." value='1'></th>";
				$content .="<th style='cursor:pointer;' onclick='add(this,".$value1['goods_id'].")'>添加</th></tr>";
			}
			//$content .="</select>&nbsp;";
			//$content .="<input type='button' class='formbtn' onclick='add()' value='添加' />";
			echo $content;
			exit();
		}else if(!empty($_POST['goods_sn']) && !$_POST['goods_name']){
			$db = &db();
			$sql = "select goods_id,price from ecm_goods_spec where sku like '%{$_POST['goods_sn']}%'";
			$list = $db->getall($sql);
			foreach($list as $key=>$value){
				$sql = "select goods_name from ecm_goods where goods_id=".$value['goods_id'];
				$name =  $db->getOne($sql);
				$list[$key]['goods_name'] = $name;
			}
			//$content = "<select name='gname'><option>选择商品</option>";
			$content = "";
			foreach($list as $key1=>$value1){
				$content .="<tr><th>".$value1['goods_id']."</th><th>".$value1['goods_name']."</th><th>".$value1['price']."</th>";
				$content .="<th><input	type='text' id=p".$value1['goods_id']." value='".$value1['price']."'></th><th><input type='text' id=".$value1['goods_id']." value='1'></th>";
				$content .="<th style='cursor:pointer;' onclick='add(this,".$value1['goods_id'].")'>添加</th></tr>";
			}
			//$content .="</select>&nbsp;";
			//$content .="<input type='button' class='formbtn' onclick='add()' value='添加' />";
			echo $content;
			exit();
		}else{
			if(empty($_POST['goods_sn']) || empty($_POST['goods_sn'])){
				exit;	
			}
			$db = &db();
			$sql = "select a.*,b.sku,b.price from ecm_goods a LEFT JOIN ecm_goods_spec b on a.goods_id=b.goods_id where a.goods_name like '%{$_POST['goods_name']}%' and b.sku like '%{$_POST['goods_sn']}%'";
			$list = $db->getall($sql);
			$content = "";
			foreach($list as $key1=>$value1){
				$content .="<tr><th>".$value1['goods_id']."</th><th>".$value1['goods_name']."</th><th>".$value1['price']."</th>";
				$content .="<th><input	type='text' id=p".$value1['goods_id']." value='".$value1['price']."'></th><th><input type='text' id=".$value1['goods_id']." value='1'></th>";
				$content .="<th style='cursor:pointer;' onclick='add(this,".$value1['goods_id'].")'>添加</th></tr>";
			}
			//$content .="</select>&nbsp;";
			//$content .="<input type='button' class='formbtn' onclick='add()' value='添加' />";
			echo $content;
			exit();
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
		 
    function drop()
    {
		//dump($_GET);
		$discount_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$discount_ids)
        {
			$this->show_warning('没有折扣名');

            return;
        }
		$discount_ids=explode(',', $discount_ids);
		foreach ($discount_ids as $key=>$value){ ;
			if (!$this->_discount_mod->drop($value))    //删除
			{
				$this->show_warning($this->_discount_mod->get_error());
				return ;
			}
			//若折扣删除，则组合也得删除
			$db = &db();
			$sql  = 'delete from ecm_pattern_a where cuxiao_id='.$value;
			$db->query($sql);
			
		}
		
		
		$this->show_message('删除促销名称成功！');
    }
	
	//删除组合
	function drop_zhuhe()
	{
		//dump($_GET);
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
		
		
		$this->show_message('删除组合商品成功！');
	}



}

?>