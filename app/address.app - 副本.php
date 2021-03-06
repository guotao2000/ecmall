<?php

/**
 *    订单确认时显示地址
 *    @author    Summer
 *    @time    2014-12-19
 */
class AddressApp extends MemberbaseApp
{
    function index(){
        
    }
    //添加地址
    function add_address(){
		if (!IS_POST)
        {
			$db=&db();
			$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
			$this->assign('store_id', $store_id);
			$this->_get_regions();
			$string_sql="select cod_regions from ecm_shipping where store_id=".$store_id;
			$row=unserialize($db->getOne($string_sql));
			$rows1=$db->getALL($string_sql);
			if($row)
			{
				
				foreach($row as $key => $value)
				{
					$this->assign('sregion_id',$key);
				}
				$count_row=count($row);
				$nostores=getConf('malls');
               if(!empty($nostores)&&strlen(trim($nostores))>1)
				{
					$ids=array_filter(explode(",",$nostores));
					foreach($ids as $v)
					{
						if($v==$store_id)
						{
		                  
							$count_row=0;	
							break;	
						}
					}
				}
				$this->assign('countrows',$count_row);
				foreach($rows1 as $key => $value)
				{
					foreach(unserialize($value['cod_regions']) as $k => $v)
					{
						
						$codes=explode("\t",$v);
						
						$row2[$k]=$codes[count($codes)-1];
					} 
					//$row2[$key]=unserialize($value['cod_regions']);
				}
				
			
				$this->assign('rows',$row2);
			}else{
				$this->assign('sregion_id',2211);
					}
			
			$this->display('address.add.html');
		} else {
			$store_id = isset($_POST['store_id'])? intval($_POST['store_id']):0;
			$data = array(
                'user_id'       => $this->visitor->get('user_id'),
                'consignee'     => $_POST['consignee'],
                'region_id'     => $_POST['region_id'],
                'region_name'   => $_POST['region_name'],
                'address'       => $_POST['address_detail'],
                'phone_mob'     => $_POST['phone_mob']
            );
            $model_address =& m('address');
            if (!($address_id = $model_address->add($data)))
            {
                $this->pop_warning($model_address->get_error());

                return;
            }
            //地址跳转
			//header('Location: index.php?app=address&act=list_address&store_id=' . $store_id);
			$this->show_message('地址添加成功！',
				'back_before_register', 'index.php?app=address&act=list_address&store_id=' . $store_id
					);
			exit;
		}
    }
	function _get_regions()
    {
        $model_region =& m('region');
        $regions = $model_region->get_list(0);
        if ($regions)
        {
            $tmp  = array();
            foreach ($regions as $key => $value)
            {
                $tmp[$key] = $value['region_name'];
            }
            $regions = $tmp;
        }
        $this->assign('regions', $regions);
    }
	//列出地址
	function list_address(){
		$db = &db();
		$store_id = $store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
		$user_id = $this->visitor->get('user_id');
		$sql = "select * from ecm_address where user_id=" . $user_id . " order by addr_id desc";
		$result = $db->getAll($sql);
		$this->assign('store_id', $store_id);
		$this->assign('address', $result);
		$this->display('address.list.html');	
	}
	//删除地址
	function del_address(){
		$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
		$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;
		$db = &db();
		$sql = "delete from ecm_address where addr_id=" . $addr_id;
		$result = $db->query($sql);
		
		if($result){
			//地址跳转
			//header('Location: index.php?app=address&act=list_address&store_id=' . $store_id);
			//exit;
			$this->show_message('地址删除成功！',
				'back_before_register', 'index.php?app=address&act=list_address&store_id=' . $store_id
					);
			exit;
		}
		
	}
	//编辑地址
	function edit_address(){
		if(!IS_POST){
			$this->_get_regions();
			$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
			$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;	
			$db = &db();
			$sql = "select * from ecm_address where addr_id=" . $addr_id;
			$result = $db->getAll($sql);
			foreach($result as $v){
				$res = $v;	
			}
			$this->assign('address', $res);
			$this->display('address.edit.html');
		} else {
			//更新地址
			$addr_id = isset($_POST['addr_id'])? intval($_POST['addr_id']):0;
			$db = &db();
			$sql = "update ecm_address set user_id=" . $this->visitor->get('user_id') . ", consignee='" . $_POST['consignee'] . "', region_id=" . $_POST['region_id'] . ", region_name='" . $_POST['region_name'] . "', address='" . $_POST['address_detail'] . "', phone_mob='" . $_POST['phone_mob'] . "' where addr_id=" . $addr_id;
			
			//地址跳转
			if ($db->query($sql))
			{
				//header('Location: index.php?app=address&act=list_address&store_id=' . $_GET['store_id']);
				//exit;
				$this->show_message('地址修改成功！',
				'back_before_register', 'index.php?app=address&act=list_address&store_id=' . $_GET['store_id']
					);
				exit;
			}
			
		}
			
	}
	//设为默认地址
	function enable_address(){
		$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
		$addr_id = isset($_GET['addr_id'])? intval($_GET['addr_id']):0;	
		$user_id = $this->visitor->get('user_id');
		$db = &db();
		//将该地址设为默认
		$sql = "update ecm_address set enable=1 where user_id=" . $user_id . " and addr_id=" . $addr_id;
		$db->query($sql);
		
		//获取该用户所有地址
		$sql = "select * from ecm_address where user_id=" . $user_id;
		$result = $db->getAll($sql);
		
		for($i=0; $i<count($result); $i++){
			if($result[$i]['addr_id'] != $addr_id){
				$db->query("update ecm_address set enable=0 where addr_id=" . $result[$i]['addr_id']);
			}	
		}
		//地址跳转
		header('Location: index.php?app=order&goods=cart&store_id=' . $_GET['store_id']);
		exit;
	}
}

?>