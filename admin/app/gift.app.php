<?php

/**
 *    满赠满减控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class GiftApp extends BackendApp
{
    var $_gift_mod;
	var $_patternb_mod;
	
    function __construct()
    {
		$this->GiftApp();
    }

	function GiftApp()
    {
        parent::BackendApp();

		$this->_gift_mod =& m('gift');
		$this->_patternb_mod =& m('patternb');
    }

    /**
     *    文章索引
     *
     *    @author    Hyber
     *    @return    void
     */
    function index()
	{
		$db=&db();
		
		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的活动
		$page['item_count']=$db->getOne('select count(id) from ecm_mzmj');   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
		if(!empty($_GET['title'])){
			$sql="select * from ecm_mzmj where promotion_name like '%{$_GET['title']}%' limit {$page['limit']}";
		}else{
			$sql="select * from ecm_mzmj order by id desc limit {$page['limit']}";
		}
		$result = $db->getAll($sql);
		$this->assign('gifts',$result);
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->display('gift.index.html');
    }
	
	//查看赠品
	function zp(){
		$name = isset($_GET['name']) ? $_GET['name']: '';
		if(empty($name)){
			$this->show_warning('没有赠品！');
		}
		$db=&db();
		$sql="select * from ecm_pattern_b where pb_name='{$name}' order by pb_id desc";
		$result = $db->getAll($sql);
		$this->assign('gifts',$result);
		$this->display('gift.zp.html');
	}
     /**
     *    新增满赠满减
     *
     *
     *    @author    Hyber
     *    @return    void
     */
    function add()
    {
		//echo ROOT_PATH;
		if(!IS_POST){
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$list = $db->getall($sql);
			//dump($list);
			$this->assign('list',$list);
			$this->display('gift.form.html');	
		}else{
			//dump($_POST);
				
			$data = array(
				'promotion_name' => $_POST['promotion_name'],
				'start_time' => gmstr2time($_POST['start_time']),
				'end_time' => gmstr2time($_POST['end_time']),
				'operate_time' => gmtime(),
				'edu'=>$_POST['edu'],
				'store_id'=>$_POST['store_id'],
				'status'=>$_POST['status'],
				'hubao_sn'=>$_POST['hubao_sn'],
				'jiane'=>$_POST['jiane'],
				'operate_person' => $_POST['operate_person'],
				);
			
			if (!$gift_id = $this->_gift_mod ->add($data))  //获取discount_id
			{
				$this->show_warning($this->_gift_mod->get_error());

				return;
			}
				$this->show_message('添加成功！',
				'开始添加赠品', 'index.php?app=gift&amp;act=add_zp&amp;store_id='.$data['store_id'].'&amp;id='.$gift_id
					);
		}
			
        
    }
	
	//添加赠品
	function add_zp(){
		$zp_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$db = &db();
		$sql = 'select * from ecm_mzmj where id='.$zp_id;
		$list = $db->getRow($sql);
		$goods = $db->getall('select goods_id,goods_name,price from ecm_goods');
			//dump($list);
		$this->assign('list',$list);
		$this->assign('goods',$goods);
		$this->assign('id',$_GET['id']);
		$this->assign('store_id',$_GET['store_id']);
		$this->display('gift.zpform.html');
	}
	
	//编辑跳到添加赠品
	function add_edit() {
		//dump($_GET);
		$db = &db();
		$name = $_GET['name'];
		$sql="select * from ecm_pattern_b where pb_name='{$name}'";
		$gifts = $db->getall($sql);
		$list = $db->getRow("select * from ecm_mzmj where promotion_name='{$name}'");
		//dump($list);
		$this->assign('gifts',$gifts);
		//$this->assign('type',$type);
		$this->assign('list',$list);
		$this->display('gift.zpadd.html');
	}
     /**
	*    编辑满赠满减
     *
     *    @author    Hyber
     *    @return    void
     */
    function edit()
    {
		$gift_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		if (!$gift_id)
        {
			$this->show_warning('没有这个文件');
            return;
        }

         if (!IS_POST)
        {
			$find_data     = $this->_gift_mod->find($gift_id);
            if (empty($find_data))
            {
                $this->show_warning('no_such_article');

                return;
            }
			//dump($find_data);
			$db = &db();
			$sql = 'select * from ecm_schedule where schedule_state=2';
			$list = $db->getall($sql);
			//dump($list);
			$gift    =   current($find_data);
			$this->assign('list',$list);
			$this->assign('gift', $gift);
            
			$this->display('gift.form.html');
        }
        else
        {
			$data = array(
				'promotion_name' => $_POST['promotion_name'],
				'start_time' => gmstr2time($_POST['start_time']),
				'end_time' => gmstr2time($_POST['end_time']),
				'operate_time' => gmtime(),
				'edu'=>$_POST['edu'],
				'store_id'=>$_POST['store_id'],
				'status'=>$_POST['status'],
				'hubao_sn'=>$_POST['hubao_sn'],
				'jiane'=>$_POST['jiane'],
				'operate_person' => $_POST['operate_person'],
				);

			
			//dump($rows);
			if (!$rows=$this->_gift_mod->edit($gift_id, $data))
			{
				$this->show_warning($this->_gift_mod->get_error());

				return;
			}
			$this->show_message('修改成功！',
				'back_list',        'index.php?app=gift'
				);
		}
	}
	
	//编辑赠品
	function edit_gift()
	{
		$gift_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		if (!$gift_id)
		{
			$this->show_warning('没有这个文件');
			return;
		}

		if (!IS_POST)
		{
			$find_data     = $this->_patternb_mod->find($gift_id);
			if (empty($find_data))
			{
				$this->show_warning('no_such_article');

				return;
			}
			//dump($list);
			$gift    =   current($find_data);
			$this->assign('gift', $gift);
			
			$this->display('gift.zpinfo.html');
		}
		else
		{
			//dump($_POST);
			$data = array(
				'promotion_price' => $_POST['promotion_price'],
				'promotion_num' => $_POST['promotion_num'],
				);
	
			//dump($rows);
			if (!$rows=$this->_patternb_mod->edit($gift_id, $data))
			{
				$this->show_warning($this->_patternb_mod->get_error());

				return;
			}
			$this->show_message('修改成功！',
				'back_list',        'index.php?app=gift'
				);
		}
	}

	//删除满赠满减
    function drop()
    {
		//dump($_REQUEST);
		$gift_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$gift_ids)
        {
            $this->show_warning('no_such_article');

            return;
        }
		$gift_ids=explode(',', $gift_ids);
		foreach ($gift_ids as $key=>$value){
			if (!$this->_gift_mod->drop($value))    //删除
			{
				$this->show_warning($this->_gift_mod->get_error());
				return ;
			}else{
				$db = &db();
				$sql = "delete from ecm_pattern_b where pb_name='{$_GET['name']}'";
				$db->query($sql);
			}
		}
		
		$this->show_message('删除成功！');
	}
	
	//删除赠品
	function drop_gift()
	{
		$gift_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($gift_ids);
		if (!$gift_ids)
		{
			$this->show_warning('no_such_article');

			return;
		}
		$gift_ids=explode(',', $gift_ids);
		foreach ($gift_ids as $key=>$value){
			if (!$this->_patternb_mod->drop($value))    //删除
			{
				$this->show_warning($this->_patternb_mod->get_error());
				return ;
			}
		}
		
		$this->show_message('删除成功！');
	}
	
	//ajax异步获取档期时间
	function ajax_time(){
		if($_REQUEST['schedule_id']){
			$id = empty($_REQUEST['schedule_id']) ? 0 : intval($_REQUEST['schedule_id']);
			$db = &db();
			$sql = 'select start_time,end_time from ecm_schedule where schedule_id='.$id;
			$list = $db->getRow($sql);
			$list['start_time'] = date('Y-m-d H:i:s',$list['start_time']);
			$list['end_time'] = date('Y-m-d H:i:s',$list['end_time']);
			echo json_encode($list);
		}
			
	}
	//ajax异步添加商品入库pattern_b
	function ajax_add(){
		$db = &db();
		$sql = 'select a.goods_name,a.goods_id,b.sku,b.price from ecm_goods a left join ecm_goods_spec b on a.goods_id=b.goods_id where a.goods_id='.$_POST['goods_id'];
		$goods = $db->getRow($sql);
		$goods['pb_name'] = $_POST['pa_name'];
		//$goods['cuxiao_id'] = $_POST['cuxiao_id'];
		$goods['promotion_price'] = $_POST['p_price'];
		$goods['promotion_num'] = $_POST['p_num'];
		$data = array(
			'pb_name'=>$_POST['pa_name'],
			'goods_name'=>$goods['goods_name'],
			'goods_id'=>$goods['goods_id'],
			'goods_sn'=>$goods['sku'],
			'original_price'=>$goods['price'],
			'promotion_price'=>$_POST['p_price'],
			'promotion_num'=>$_POST['p_num'],
		);
		//dump($data);
		if (!$pattern_id = $this->_patternb_mod->add($data))  //获取pattern_id
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
	
	//ajax异步删除商品从库pattern_b
	function ajax_drop(){
		if($_POST['id']){
			if (!$this->_patternb_mod->drop($_POST['id']))    //删除
			{
				echo '删除错误！';
			}
		}
	}
	//ajax异步搜索获取商品
	function ajax_search(){
		$db = &db();
		$sid = $_POST['sid'];
		if(empty($_POST['goods_name'])&&empty($_POST['goods_sn'])){
			exit();
		}else if (!empty($_POST['goods_name']) && !$_POST['goods_sn']){
			$sql = "select a.*,b.sku,b.price from ecm_goods a LEFT JOIN ecm_goods_spec b on a.goods_id=b.goods_id where a.goods_name like '%{$_POST['goods_name']}%' and a.store_id=".$sid;	
		}else if(!empty($_POST['goods_sn']) && !$_POST['goods_name']){
			$sql = "select a.*,b.sku,b.price from ecm_goods a LEFT JOIN ecm_goods_spec b on a.goods_id=b.goods_id where b.sku like '%{$_POST['goods_sn']}%' and a.store_id=".$sid;
		}else{
			$sql = "select a.*,b.sku,b.price from ecm_goods a LEFT JOIN ecm_goods_spec b on a.goods_id=b.goods_id where a.goods_name like '%{$_POST['goods_name']}%' and b.sku like '%{$_POST['goods_sn']}%' and a.store_id=".$sid;
		}
		$list = $db->getall($sql);
		$content = "";
		foreach($list as $key1=>$value1){
			$content .="<tr><th>".$value1['goods_id']."</th><th>".$value1['goods_name']."</th><th>".$value1['price']."</th>";
			$content .="<th><input	type='text' id=p".$value1['goods_id']." value='".$value1['price']."'></th><th><input type='text' id=".$value1['goods_id']." value='1'></th>";
			$content .="<th style='cursor:pointer;' onclick='add(this,".$value1['goods_id'].")'>添加</th></tr>";
		}
	
		echo $content;
	}

   

}

?>