<?php
include 'jssdk.php';
/* 一键登录控制器 */
class Buyer_addApp extends StorebaseApp
{
    var $buyer_add_mod;
	var $_goods_mod;
    function __construct()
    {
		$this->Buyer_addApp();
    }
	function Buyer_addApp()
    {
        parent::__construct();
		$this->buyer_add_mod = & m('goodsqa');
		$this->_goods_mod =& m('goods');
		
    }
    function index()
    {
		
		if (isset($_GET['uin'])) {
			if(intval($_GET['uin'])>0){
			setcookie("uin",$_GET['uin'],time()+31622400);
			}
		}
			//$_SESSION = array();	
			//session_destroy();
			/* 参数 id */
			$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if (!$id||$id==0)
			{
			$this->show_warning('输入非法，请确认！');
				return;
			}
			//$sql = "select a.kuaixun_price,b.*,c.stock from ecm_kuaixun_promotion a left join ecm_goods b on a.goods_id=b.goods_id,ecm_goods_spec c where a.goods_id={$id} and a.kuaixun_state=3 and (unix_timestamp() between a.start_time and a.end_time )";
		$sql="select b.goods_id,b.goods_name,b.wxdesc,b.wxtitle, a.price price,b.description,c.stock,b.store_id,c.spec_id,d.store_name,c.shichang  from ecm_kuaixun_promotion_v a 
left join ecm_goods b on a.goods_id=b.goods_id LEFT JOIN ecm_goods_spec c on c.goods_id=a.goods_id LEFT JOIN ecm_store d on b.store_id=d.store_id
where a.goods_id={$id} and a.state=3 and (unix_timestamp() between a.start_time and a.end_time)";
			$db = &db();
			$arr = $db->getRow($sql);
			//dump($arr);
			if(!$arr){
			$specsql = "select b.goods_id,b.goods_name,b.wxdesc,b.wxtitle, c.price,b.description,c.stock,b.store_id,c.spec_id,d.store_name,c.shichang from ecm_goods b
                 LEFT JOIN ecm_goods_spec c on b.goods_id=c.goods_id LEFT JOIN ecm_store d on b.store_id=d.store_id where b.goods_id={$id} and b.if_show=1 ";	
				$arr = $db->getRow($specsql);
			}
		
			if (!$arr['goods_id'])
			{
			$this->show_warning('此商品不存在！');
				return;
			}
			
			$images = $db->getAll('select * from ecm_goods_image where goods_id = '.$id);
			$this->assign('images',$images);
		if(mb_strlen($arr['goods_name'],'utf-8')>11)
		{
			$goods_name1=mb_substr($arr['goods_name'],0,11,'utf-8');
			$goods_name2=mb_substr($arr['goods_name'],11,mb_strlen($arr['goods_name'],'utf-8')-11,'utf-8');
		}else
		{
			$goods_name1=$arr['goods_name'];
			$goods_name2="";
		}
		$this->assign('goods_name1',$goods_name1);
		$this->assign('goods_name2',$goods_name2);
			$this->assign('goods',$arr);
		if(isset($_SESSION['store_id']))
		{
			unset($_SESSION['store_id']);
		}
			$_SESSION['store_id']=$arr['store_id'];
		$jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage', $signPackage);

	
		    $this->assign('store_id',$arr['store_id']);
			$this->display('buyer_add.index.html');
		
    }
	//用户快捷登录
    public function login()
    {
    	if(!IS_POST){
    		if($this->visitor->has_login)
			{
				$store_id=$_SESSION['store_id'];
				$user_id = $this->visitor->get('user_id');
				header("Location:index.php?app=buyer_add&act=buyaddress&store_id={$store_id}");
				exit;
			}
    		$this->display('atlogin.html');
    	}else{
			 $ms =& ms(); //连接用户中心
			$password = trim($_POST['password']);
			$user_name  = trim($_POST['user_name']);
			$user_name_len = strlen($user_name);
			if ($user_name_len < 3 || $user_name_len > 25)
			{
				$this->show_message('user_name_length_error');

				return;
			}

			$data = array(
				'parentid' => $_COOKIE["uin"],
				'real_name'=>$user_name,
				);
			//先判断用户是否是老用户，若是直接登录，否则注册
			$db = & db();
			$user_id=0;
			$store_id=$_SESSION['store_id'];
			if($this->visitor->has_login)
			{
				$user_id = $this->visitor->get('user_id');
				header("Location:index.php?app=buyer_add&act=buyaddress&store_id={$store_id}");
				exit;
			}else{
				$sql_user="SELECT user_id from ecm_member where user_name='".$user_name."'";
				$user_id=$db->getOne($sql_user);
				
				if(empty($user_id))
				{
					$user_id = $db->getOne("select a.user_id from ecm_member a LEFT JOIN ecm_address b on a.user_id=b.user_id where b.phone_mob=".$user_name);
					
					if(empty($user_id)){
						//注册并跳转到新地址页
						$user_id = $ms->user->register_sec($user_name, $password,$data);
                        $this->_hook('after_register', array('user_id' => $user_id));
				        $this->_do_wxloginrelation($user_id);
				        //先登录再保存地址
				        $this->_do_login($user_id);
				        header("Location:index.php?app=buyer_add&act=address&store_id={$store_id}");
				        exit;
					}else{
						$db->query("update ecm_address set enable=0 where phone_mob=".$user_name);	
						$this->_hook('after_register', array('user_id' => $user_id));
				    	$this->_do_wxloginrelation($user_id);
				    	$this->_do_login($user_id);
				    	header("Location:index.php?app=buyer_add&act=buyaddress&store_id={$store_id}");
				    	exit;	
					}
				}else{
                    $db->query("update ecm_address set enable=0 where phone_mob=".$user_name);	
                    $this->_hook('after_register', array('user_id' => $user_id));
				    $this->_do_wxloginrelation($user_id);
				    //先登录再保存地址
				    $this->_do_login($user_id);
				    header("Location:index.php?app=buyer_add&act=buyaddress&store_id={$store_id}");
				    exit;
				}
		    
            }
		}
    }

     //一键购买地址列表页
	function buyaddress(){
		$db = &db();
		$store_id = isset($_SESSION['store_id'])? intval($_SESSION['store_id']):0;
		$user_id = $this->visitor->get('user_id');
		$sql = "select * from ecm_address where user_id=" . $user_id . " order by addr_id desc";
		$result = $db->getAll($sql);
		$this->assign('store_id', $store_id);
		$this->assign('address', $result);
		$this->display('addressliulei.list.html');	
    }
	
	//自动注册 登录 保存地址
	function address(){
		if(IS_POST){
			$user_id = $this->visitor->get('user_id');
			$consignee = trim($_POST['consignee']);
			$mobile  = trim($_POST['phone_mob']);
			$region_id = $_POST['region_id'];
			$region_name = $_POST['region_name'];
			$address = $_POST['address_detail'];
			//dump($user_id);
			//保存地址
			$sql = "insert into ecm_address (user_id,consignee,region_id,region_name,address,phone_mob,enable) values ('{$user_id}','{$consignee}','{$region_id}','{$region_name}','{$address}','{$mobile}',1)";
			$db = &db();
			$db->query($sql);

			$store_id=$_SESSION['store_id'];
			header("Location:index.php?app=order&goods=cart&store_id={$store_id}");
			}else{
				$db=&db();
				$store_id = isset($_GET['store_id'])? intval($_GET['store_id']):0;
				$this->assign('store_id', $store_id);
				$this->_get_regions();
				$string_sql="select cod_regions from ecm_shipping where store_id=".$store_id;
				$row=unserialize($db->getOne($string_sql));
				//dump($row);
				$rows1=$db->getALL($string_sql);
				if($row)
				{
				
					foreach($row as $key => $value)
					{
						$this->assign('sregion_id',$key);
					}
					$this->assign('countrows',count($row));
					foreach($rows1 as $key => $value)
					{
						foreach(unserialize($value['cod_regions']) as $k => $v)
						{
						
							$codes=explode("\t",$v);
						
							$row2[$k]=$codes[count($codes)-1];
						} 
					}
					$this->assign('rows',$row2);
				}else{
					$this->assign('sregion_id',2211);
				}
				$this->assign('cart_id',$cart_id);
				$malls=array_filter(explode(",",getConf('malls')));
				foreach($malls as $val){
					if($store_id==$val){
						//dump('111111');
						$this->display('address.newadd.html');
						exit;
					}
				}
				$this->display('address.newadd.html');
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
    //根据手机
	function shouji()
	{
		$mobile=$_POST['shouji'];
		
		if(preg_match("/^1[34578]\d{9}$/",$mobile))
		{
			$db = & db();
			$sql_user="SELECT user_id from ecm_member where user_name='".$mobile."'";
			$user_id=$db->getOne($sql_user);
			if(empty($user_id))
			{
				$this->show_message("手机号输入错误！");
				return;
			}else{
				$this->_hook('after_register', array('user_id' => $user_id));
				$this->_do_wxloginrelation($user_id);
				//先登录再保存地址
				$this->_do_login($user_id);
				header('Location:/index.php?app=buyer_order&act=index&type=all');
			}

		}else{
			$this->show_message("不是手机号码");
			return;
		}

	}
}

?>
