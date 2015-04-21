<?php

/**
 *    满赠满减控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class WxgoodsApp extends BackendApp
{
    var $_wxgoods_mod;
	
    function __construct()
    {
		$this->WxgoodsApp();
    }

	function WxgoodsApp()
    {
        parent::BackendApp();

		$this->_wxgoods_mod =& m('wxgoods');
    }

    /**
     *    价格批量管理
     *
     *    @author    Hyber
     *    @return    void
     */
    function index()
	{
		$db=&db();
		$page   =   $this->_get_page(10);   //获取分页信息
			
		$condition[]=" 1=1 ";
		if(strlen($_GET['title']) && strlen($_GET['goods_sn'])>0){
			$condition[]=" a.goods_name like '%".$_GET['title']."%' and b.sku like '%".$_GET['goods_sn']."%'";
		}elseif(strlen($_GET['title'])>0){
			$condition[]=" a.goods_name like '%".$_GET['title']."%'";
		}elseif(strlen($_GET['goods_sn'])>0){
			$condition[]=" b.sku like '%".$_GET['goods_sn']."%'";
		}
		
		$conditions=implode(" and ",$condition);

		$sql="select a.goods_id,a.store_id,a.goods_name,a.wxtitle,a.wxdesc,b.sku from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  where ".$conditions. " limit ". $page['limit']."";
		$count_sql="select count(*) from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id where".$conditions;
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$page11 = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->assign('page11',$page11);
		$wxgoods = $db->getAll($sql);
		$this->_format_page($page);	
		//$query['title'] = $_GET['title'];
		//$query['tag'] = $_GET['goods_sn'];
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		//$this->assign('query',$query);
		$this->assign('wxgoods',$wxgoods);
		
		
		$this->display('wxgoods.index.html');
    }
	
	
	/**
	    *    余额编辑
	    *
	    *
	    *    @author    Hyber
	    *    @return    void
	    */
	function edit()
	{
		$db=&db();
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		if (!IS_POST)
		{
			$good = $db->getRow('select a.*,b.sku from ecm_goods a left join ecm_goods_spec b on a.goods_id=b.goods_id  where a.goods_id ='.$id);
			$this->assign('good',$good);
			$this->display('wxgoods.form.html');
		}else{
			//dump($_POST);
			if(empty($_POST['wxdesc'])){
				$this->show_warning('商品详情不能为空！');
			}
			$data = array(
				'wxtitle'=>trim($_POST['wxtitle']),
				'wxdesc'=>trim($_POST['wxdesc']),
			);
			
			
			$goods = & m('goods');
			if (!$good_id = $goods->edit($id,$data))  //获取article_id
			{
				$this->show_warning($goods->get_error());

				return;
			}
			
			$this->show_message('添加成功！',
				'back_list',        'index.php?app=wxgoods&goods_sn='.$_POST['goods_sn']	
				);
		}
		
		
	}
	
	
     /**
     *    价格批量修改
     *
     *
     *    @author    Hyber
     *    @return    void
     */
    function add()
    {
		$db=&db();
		$id	= isset($_POST['goods_id']) ? intval($_POST['goods_id']) : '';
		$name = $_POST['name'];
		$sn = $_POST['sn'];
		$store_id = trim($_POST['store']);
		$wxgoods = trim($_POST['wxgoods']);
		$stores = array();
		$stores = explode(',',rtrim($store_id,','));
		//dump($stores);
		$content = '';
		for($i=0;$i<count($stores);$i++){
			$sql1 = "select count(goods_id) from ecm_goods where store_id =".$stores[$i];
			if($count = $db->getone($sql1)){
				$sql="update ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  set a.wxgoods={$wxgoods},b.wxgoods={$wxgoods} where b.sku = '{$sn}' and a.store_id = {$stores[$i]}";
				$num = $db->query($sql);
				$storeid .= $stores[$i].",";
				$content .= $stores[$i]."号店铺执行成功\n";
			}else{
				$content .= $stores[$i]."号店铺不存在\n";
			}
							
		}
		
		if($num){
			$data['goods_name']=$_POST['name'];
			$data['goods_sn']=$_POST['sn'];
			$data['store_id']=$storeid;
			$data['wxgoods']=$wxgoods;
			$data['original_wxgoods']=$_POST['owxgoods'];
			$data['operate_person']=$_POST['person'];
			$data['wxgoods']=$wxgoods;
			$data['operate_time'] = gmstr2time(date('Y-m-d',time()));
			
			if (!$this->_wxgoods_mod->add($data))
			{
				$this->show_warning($this->_wxgoods_mod->get_error());

				return;
			}		
		}
		
		echo $content;
		
        
    }
	
	
	
	
	//删除价格添加历史
    function drop()
    {
		$wxgoods_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$wxgoods_ids)
        {
            $this->show_warning('no_such_article');

            return;
        }
		$wxgoods_ids=explode(',',$wxgoods_ids);
		foreach ($wxgoods_ids as $key=>$value){
			if (!$this->_wxgoods_mod->drop($value))    //删除
			{
				$this->show_warning($this->_wxgoods_mod->get_error());
				return ;
			}
		}
		
		$this->show_message('删除成功！');
	}

}

?>