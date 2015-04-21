<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
include($_SERVER['DOCUMENT_ROOT'] . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define($_SERVER['DOCUMENT_ROOT'] . '/data/config.inc.php');

include($_SERVER['DOCUMENT_ROOT'] . '/eccore/controller/app.base.php');
require_once($_SERVER['DOCUMENT_ROOT']. "/bqalipaywap/alipay.config.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/bqalipaywap/lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$result = $_GET['result'];


	//判断该笔订单是否在商户网站中已经做过处理
	//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
	//如果有做过处理，不执行商户的业务程序
	if($_GET['result'] == 'TRADE_FINISHED' || $_GET['result'] == 'TRADE_SUCCESS'|| $_GET['result'] == 'success') {
		//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//如果有做过处理，不执行商户的业务程序
		
		/*$db=&db();
		$sql_update="update ecm_order set payment_id=6,payment_name='手机支付宝即时到账',out_trade_sn='".
	$trade_no."',pay_time=unix_timestamp(),`status`=20 where order_sn='".$out_trade_no."'";
		$db->query($sql_update);
		$sql_sel="select order_id from ecm_order where order_sn='".$out_trade_no."'";
		$order_id=$db->getOne($sql_sel);*/
		
		/*$db_host='localhost';
		$db_database='ecmall';
		$db_username='root';
		$db_password='root';*/
		include(ROOT_PATH . '/data/conf.php');
		$connection=mysql_connect($db_host,$db_username,$db_password);//连接到数据库
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER_SET_CLIENT=utf8");
		mysql_query("SET CHARACTER_SET_RESULTS=utf8");
		if(!$connection){
			die("could not connect to the database:</br>".mysql_error());//诊断连接错误

		}
		$db_selecct=mysql_select_db($db_database);//选择数据库
		if(!$db_selecct)
		{
			die("could not to the database</br>".mysql_error());	
		}
		$sql_update="update ecm_order set payment_id=6,payment_name='手机支付宝即时到账',out_trade_sn='".
			$trade_no."',pay_time=unix_timestamp(),`status`=20 where order_sn='".$out_trade_no."'";
		mysql_query($sql_update);//执行查询
		$sql_sel="select order_id from ecm_order where order_sn='".$out_trade_no."'";
		$result=mysql_query($sql_sel);//执行查询
		
		while($result_row=mysql_fetch_row(($result)))//取出结果并显示
		{
			$order_id = $result_row['order_id'];
		}	
		
		header('Location:index.php?app=cashier&act=jiesheng&order_id='.$order_id);
		//header('Location:/index.php?app=buyer_order&act=index&type=all');
		//header('Location:index.php?app=share');
	}
	else {
		echo "trade_status=".$_GET['result'];
		echo "验证成功<br />";
	}
	}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
        <title>支付宝即时到账交易接口</title>
	</head>
    <body>
    </body>
</html>