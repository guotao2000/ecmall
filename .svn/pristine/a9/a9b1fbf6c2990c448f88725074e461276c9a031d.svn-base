<?php

class BqaliwapcallbackApp extends MallbaseApp
{
	function index()
	{
		
		
		require_once("bqalipaywap/alipay.config.php");
		require_once("bqalipaywap/lib/alipay_notify.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
			if($_GET['result'] == 'TRADE_FINISHED' || $_GET['result'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				$db=&db();
				$sql_update="update ecm_order set payment_id=6,payment_name='手机支付宝即时到账',out_trade_sn='".$trade_no."',pay_time=unix_timestamp(),`status`=20 where order_sn='".$out_trade_no."'";
				$db->query($sql_update);
				$sql_sel="select order_id from ecm_order where order_sn='".$out_trade_no."'";
				$order_id=$db->getOne($sql_sel);
				header('Location:index.php?app=buyer_order&act=index&type=all');
			}
			else {
				echo "trade_status=".$_GET['result'];
				echo "验证成功<br />";
			}
			
			

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			echo "验证失败";
		}
	}
}
?>