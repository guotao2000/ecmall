<?php
//echo phpinfo();
error_reporting(0);
define('ROOT_PATH', dirname(__FILE__));
//error_reporting(0);
/**
 * 安装判断
 */
if (!file_exists(ROOT_PATH . "/data/install.lock") && is_dir(ROOT_PATH . "/install")){
	@header("location: install");
	exit;
}

include(ROOT_PATH . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define(ROOT_PATH . '/data/config.inc.php');
//define(ROOT_PATH . '/data/config.inc.php');

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|android)/i";

if((preg_match($uachar, $ua)))
{
    define('ECMALL_WAP', 1);
}
//var_dump($_GET);die;
if ($_GET['Debug'] == 'Wap') {
    define('ECMALL_WAP', 1);
	setcookie('Debug','Wap');
}
//var_dump($_GET);die;
if(isset($_COOKIE['Debug']))
{
	define('ECMALL_WAP', 1);
}

if (isset($_GET['uin'])) {
	if(intval($_GET['uin'])>0){
	setcookie('uin',$_GET['uin'],time()+31622400);
	}
}

if(strlen($_GET['openid'])>20)
{
     setcookie('openid',$_GET['openid'],time()+31622400);
}


//define('ECMALL_WAP', 1);
/* 启动ECMall */
ECMall::startup(array(
    'default_app'   =>  'default',
    'default_act'   =>  'index',
    'app_root'      =>  ROOT_PATH . '/app',
    'external_libs' =>  array(
        ROOT_PATH . '/includes/global.lib.php',
        ROOT_PATH . '/includes/libraries/time.lib.php',
        ROOT_PATH . '/includes/ecapp.base.php',
        ROOT_PATH . '/includes/plugin.base.php',
        ROOT_PATH . '/app/frontend.base.php',
        ROOT_PATH . '/includes/subdomain.inc.php',
    ),
));
?>
