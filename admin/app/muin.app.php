<?php

/**
 *    批量修改用户推荐号
 *
 *    @author    Hyber
 *    @usage    none
 */
class MuinApp extends BackendApp
{
    var $_muin_mod;
	
    function __construct()
    {
		$this->MuinApp();
    }

	function MuinApp()
    {
        parent::BackendApp();

		$this->_muin_mod =& m('muin');
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
		//dump($_GET);
		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的活动
		$page['item_count']=$db->getOne('select count(id) from ecm_muin');   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
		if(!empty($_GET['uin'])){
			$sql="select * from ecm_muin where old_uin like '%{$_GET['uin']}%' limit {$page['limit']}";
		}else{
			$sql="select * from ecm_muin order by id desc limit {$page['limit']}";
		}
		$result = $db->getAll($sql);
		$this->assign('muins',$result);
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->display('muin.index.html');
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
			$this->display('muin.form.html');	
		}else{
			$member = & m('member');
			$oldusers = $member->get('uin='.$_POST['old_uin']);
			$newusers = $member->get('uin='.$_POST['new_uin']);
			if(empty($oldusers) || empty($newusers)){
				$this->show_warning('此推荐号的用户不存在！');
			}
			$orders = & m('order');
			$db = & db();
			$member_num = 0;
		    $order_num = 0;
			//记录修改的会员历史
			$memberuin = $member->find('parentid='.$_POST['old_uin']);
			foreach ($memberuin as $k => $v) {
				$userid .= $v['user_id'].',';
				//$sql = "insert into ecm_member_uin (uin,user_id) values('".$_POST['old_uin']."',{$v['user_id']})";
				//$db->query($sql);
				$member_num++;
			}
			//记录修改的推荐订单历史
			$orderuin = $orders->find('uin='.$_POST['old_uin']);
			foreach ($orderuin as $k => $v) {
				$orderid .= $v['order_id'].','; 
				//$sql = "insert into ecm_order_uin (uin,order_id) values('".$_POST['old_uin']."',{$v['order_id']})";
				//$db->query($sql);
				$order_num++;
			}
			//记录操作
			$data = array(
				'old_user_id'  =>$oldusers['user_id'],
				'old_username' =>$oldusers['user_name'],   
				'old_uin' => trim($_POST['old_uin']),
				'new_uin' => trim($_POST['new_uin']),
				'new_user_id'  =>$newusers['user_id'],
				'new_username' =>$newusers['user_name'],
				'member_num'  => $member_num,  
				'order_num'  => $order_num,
				'userid'  => $userid,
				'orderid'  => $orderid,
				'create_time' => time(),
				'operate_person' => trim($_POST['operate_person']),
			);
			//dump($data);
			
			//更改所有会员推荐号和订单推荐号
			$member->edit('parentid='.$data['old_uin'],array('parentid'=>$data['new_uin']));
			$orders->edit('uin='.$data['old_uin'],array('uin'=>$data['new_uin']));
			if (!$muin_id = $this->_muin_mod ->add($data))  //获取discount_id
			{
				$this->show_warning($this->_muin_mod->get_error());

				return;
			}
				$this->show_message('修改成功！',
				'back_list', 'index.php?app=muin'
					);
		}
			
        
    }

     /**
     *    查看修改会员历史
     *    @author    Hyber
     *    @return    void
     */
     public function show_member()
     {
     	$id = isset($_GET['id']) ? $_GET['id'] : 0;
     	$db = &db();
		//dump($_GET);
		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的活动
     	$userid = $db->getOne("select userid from ecm_muin where id=".$id);
     	$userid = rtrim($userid,',');
     	$members = $db->getall("select * from ecm_member where user_id in ($userid)");

     	$page['item_count']=$db->getOne("select count(*) from ecm_member where user_id in ($userid)");   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
     	$this->assign('users',$members);
     	$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
     	$this->display('muin.showmember.html');
     }

     /**
     *    查看修改订单历史
     *    @author    Hyber
     *    @return    void
     */
     public function show_order()
     {
     	$id = isset($_GET['id']) ? $_GET['id'] : 0;
     	$db = &db();
		//dump($_GET);
		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的活动
     	$orderid = $db->getOne("select orderid from ecm_muin where id=".$id);
     	$orderid = rtrim($orderid,',');
     	$orders = $db->getall("select * from ecm_order where order_id in ($orderid)");

     	$page['item_count']=$db->getOne("select count(*) from ecm_order where order_id in ($orderid)");   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
     	$this->assign('orders',$orders);
     	$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
     	$this->display('muin.showorder.html');
     }

}

?>
