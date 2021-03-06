<?php

/**
 *    满赠满减控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class PriceApp extends BackendApp
{
    var $_price_mod;
	
    function __construct()
    {
		$this->PriceApp();
    }

	function PriceApp()
    {
        parent::BackendApp();

		$this->_price_mod =& m('price');
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

		$sql="select a.goods_id,a.store_id,goods_name,b.sku,b.price,b.shichang from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  where ".$conditions. " limit ". $page['limit']."";
		$count_sql="select count(*) from ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id where".$conditions;
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$page11 = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->assign('page11',$page11);
		$price = $db->getAll($sql);
		$this->_format_page($page);	
		$query['title'] = $_GET['title'];
		$query['tag'] = $_GET['goods_sn'];
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->assign('query',$query);
		$this->assign('prices',$price);
		
		
		$this->display('price.index.html');
    }
	
	
	//查看添加价格历史
	function back(){
		$db=&db();
		$page   =   $this->_get_page(10);   //获取分页信息
		$condition[]=" 1=1 ";
		if(strlen($_GET['title'])>0 && strlen($_GET['start_time'])>0 && strlen($_GET['end_time'])>0){
			$condition[]="operate_person like '%".$_GET['title']."%' and operate_time between ".$_GET['start_time']." and ". $_GET['end_time'];
		}else if(strlen($_GET['title'])>0 && strlen($_GET['start_time'])>0){
			$condition[]="operate_person like '%".$_GET['title']."%' and operate_time >=".$_GET['start_time'];
		}elseif(strlen($_GET['title'])>0 && strlen($_GET['end_time'])>0){
			$condition[]="operate_person like '%".$_GET['title']."%' and operate_time <=".$_GET['end_time'];
		}elseif (strlen($_GET['title'])>0){
			$condition[]=" operate_person like '%".$_GET['title']."%'";
		}elseif(strlen($_GET['start_time'])>0 && strlen($_GET['end_time'])>0){
			$condition[]="operate_time between ".$_GET['start_time']." and ". $_GET['end_time'];
		}elseif(strlen($_GET['start_time'])>0){
			$condition[]="operate_time >=".$_GET['start_time'];
		}elseif(strlen($_GET['end_time'])>0){
			$condition[]="operate_time <=".$_GET['end_time'];
		}elseif(strlen($_GET['goods_sn'])){
			$condition[]=" goods_sn like '%".$_GET['goods_sn']."%'";
		}
		
		$conditions=implode(" and ",$condition);
		
		$count_sql = "select count(*) from ecm_history where ".$conditions;
		$sql = "select * from ecm_history where ".$conditions." order by h_id desc limit ". $page['limit'];
		$page['item_count']=$db->getOne($count_sql);   //获取统计数据
		$result = $db->getAll($sql);
		$start_time = $db->getAll("select distinct operate_time from ecm_history order by operate_time asc");
		$end_time = $db->getAll("select distinct operate_time from ecm_history order by operate_time desc");
		$this->_format_page($page);
		$this->assign('results',$result);
		$this->assign('start_time',$start_time);
		$this->assign('end_time',$end_time);
		$this->assign('page_info',$page); 
		$this->display('price.list.html');
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
		$price = trim($_POST['price']);
		$shichang = trim($_POST['shichang']);
		$stores = array();
		$stores = explode(',',rtrim($store_id,','));
		//dump($stores);
		$content = '';
		for($i=0;$i<count($stores);$i++){
			$sql1 = "select count(goods_id) from ecm_goods where store_id =".$stores[$i];
			if($count = $db->getone($sql1)){
				$sql="update ecm_goods a left join ecm_goods_spec b on a.goods_id = b.goods_id  set a.price={$price},b.price={$price},b.shichang={$shichang} where b.sku = '{$sn}' and a.store_id = {$stores[$i]}";
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
			$data['price']=$price;
			$data['original_price']=$_POST['oprice'];
			$data['shichang']=$shichang;
			$data['oshichang']=$_POST['oshichang'];
			$data['operate_person']=$_POST['person'];
			$data['price']=$price;
			$data['operate_time'] = gmstr2time(date('Y-m-d',time()));
			
			if (!$this->_price_mod->add($data))
			{
				$this->show_warning($this->_price_mod->get_error());

				return;
			}		
		}
		
		echo $content;
		
        
    }
	
	
	
	
	//删除价格添加历史
    function drop()
    {
		$price_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$price_ids)
        {
            $this->show_warning('no_such_article');

            return;
        }
		$price_ids=explode(',',$price_ids);
		foreach ($price_ids as $key=>$value){
			if (!$this->_price_mod->drop($value))    //删除
			{
				$this->show_warning($this->_price_mod->get_error());
				return ;
			}
		}
		
		$this->show_message('删除成功！');
	}

}

?>