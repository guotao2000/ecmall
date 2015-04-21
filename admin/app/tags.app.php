<?php

/**
 *    标签批量控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class TagsApp extends BackendApp
{
    var $_tag_mod;
	
    function __construct()
    {
		$this->TagsApp();
    }

	function TagsApp()
    {
        parent::BackendApp();

		$this->_tag_mod =& m('tags');
    }

    /**
     *    价格批量管理
     *
     *    @author    Hyber
     *    @return    void
     */
    function index()
	{
		//dump($_GET);
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

		$sql="select a.goods_id,a.store_id,a.goods_name,a.tags,b.sku from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  where ".$conditions. " limit ". $page['limit']."";
		$count_sql="select count(*) from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id where".$conditions;
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$page11 = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->assign('page11',$page11);
		$tag = $db->getAll($sql);
		$this->_format_page($page);	
		$query['title'] = $_GET['title'];
		$query['tag'] = $_GET['goods_sn'];
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('query',$query);
		$this->assign('tags',$tag);
		
		$this->display('tags.index.html');
    }
	
	
	
     /**
     *    标签批量修改
     *
     *
     *    @author    Hyber
     *    @return    void
     */
    function add()
    {
		//dump($_POST);
		$db=&db();
		$id	= isset($_POST['goods_id']) ? intval($_POST['goods_id']) : '';
		$name = $_POST['name'];
		$sn = $_POST['sn'];
		$store_id = trim($_POST['store']);
		if(empty($store_id)){
			echo '请输入店铺名！';
			exit;
		}
		$tag = trim($_POST['tag']);
		$stores = array();
		$stores = explode(',',rtrim($store_id,','));
		//dump($stores);
		$content = '';
		for($i=0;$i<count($stores);$i++){
			$sql1 = "select count(goods_id) from ecm_goods where store_id =".$stores[$i];
			if($count = $db->getone($sql1)){
				$sql="update ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  set a.tags='{$tag}' where b.sku = '{$sn}' and a.store_id = {$stores[$i]}";
				$num = $db->query($sql);
				$storeid .= $stores[$i].",";
				$content .= $stores[$i]."号店铺执行成功\n";
			}else{
				$content .= $stores[$i]."号店铺不存在\n";
			}
							
		}
		
		echo $content;
		
        
    }
	

}

?>