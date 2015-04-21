<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
*/
	define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
	include($_SERVER['DOCUMENT_ROOT'] . '/eccore/ecmall.php');

	/* 定义配置信息 */
	ecm_define($_SERVER['DOCUMENT_ROOT'] . '/data/config.inc.php');

	include($_SERVER['DOCUMENT_ROOT'] . '/eccore/controller/app.base.php');
	include_once("../WxPayPubHelper/WxPayPubHelper.php");
	
	//使用jsapi接口
	$jsApi = new JsApi_pub();

	//=========步骤1：网页授权获取用户openid============
	//通过code获得openid
	if (!isset($_GET['code']))
	{
		//触发微信返回code码
		$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
		Header("Location: $url"); 
	}else
	{
		//获取code码，以获取openid
	    $code = $_GET['code'];
		
		$jsApi->setCode($code);
	
		$openid = $jsApi->getOpenId();
		
	}
	
	//=========步骤2：使用统一支付接口，获取prepay_id============
	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();
	//yangxiuwei begin
	$int_sn=isset($_COOKIE['order_sn'])?$_COOKIE['order_sn']:0;//商户网站订单系统中唯一订单号，必填
  
	$sql="select * from ecm_order where order_sn=".$int_sn;
	
	$db=&db();
	$rows=$db->getAll($sql);
	if(count($rows)<1)
	{
	
		echo "友情提示，非法输入交易编号";
		exit();
	}
	
	$keys=array_keys($rows);
	$row_order=$rows[$keys[0]];
   // print_r($rows[$keys[0]]);
	//$this->assign('amount', $row_order['order_amount']);
	//$this->assign('order_sn', $row_order['order_sn']);
	
	//yangxiuwei end
	//设置统一支付接口参数
	//设置必填参数
	//appid已填,商户无需重复填写
	//mch_id已填,商户无需重复填写
	//noncestr已填,商户无需重复填写
	//spbill_create_ip已填,商户无需重复填写
	//sign已填,商户无需重复填写
	$unifiedOrder->setParameter("openid","$openid");//商品描述
	$unifiedOrder->setParameter("body","倍全商城订单支付");//商品描述
	//自定义订单号，此处仅作举例
	$timeStamp = time();
	$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
	$unifiedOrder->setParameter("out_trade_no","".$row_order['order_sn']."");//"$out_trade_no");//商户订单号 
$unifiedOrder->setParameter("total_fee","".floor($row_order['order_amount']*100)."");//总金额
	$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
	$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型


	$prepay_id = $unifiedOrder->getPrepayId();
	//=========步骤3：使用jsapi调起支付============
	$jsApi->setPrepayId($prepay_id);

	$jsApiParameters = $jsApi->getParameters();
	//echo $jsApiParameters;/**/
?>

<!doctype html>
<html>
    <head>
        <title>微信支付-倍全商城</title>
        <meta charset="utf-8">
        <meta name="keywords" content="倍全,倍全商城,倍全订货,社区O2O,社区便利店,网上超市,济南社区020,便利店O2O,济南社区便利店" />
        <meta name="description" content="倍全商城-倍全旗下品牌，济南同城最快速的便利店商品订购派送网站" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" />
        <!--离线应用的另一个技巧-->
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <!--指定的iphone中safari顶端的状态条的样式-->
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <!--告诉设备忽略将页面中的数字识别为电话号码-->
        <meta content="telephone=no" name="format-detection" />
        <!--设置开始页面图片-->
        <!--<link rel="/touch/apple-touch-startup-image" href="startup.png" />-->
        <!--在设置书签的时候可以显示好看的图标-->
	    <link type="text/css" rel="stylesheet" href="http://wap.bqmart.cn/themes/bqmart/template/css/com/com.css"/> 
        <link type="text/css" rel="stylesheet" href="http://wap.bqmart.cn/themes/bqmart/template/css/home/index.css"/>
        <script src="http://wap.bqmart.cn/themes/bqmart/js/jquery.js"></script>
        <!-- 控制整体标签宽度的js -->
        <script src="http://wap.bqmart.cn/themes/bqmart/template/js/com/com.js"></script>
        <!-- 控制整体标签宽度的js end -->
        <!-- 控制图片缩放比例的js -->
        <script src="http://wap.bqmart.cn/themes/bqmart/template/js/com/template.js"></script>
        <!-- 控制图片缩放比例的js end -->
	    <script type="text/javascript">

		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					//alert(res.err_code+res.err_desc+"|444"+res.err_msg);
				 re=res.err_msg.substr( res.err_msg.lastIndexOf(':')+1, 2);
                   if(re=="ok")
				   {
				   window.location.href="/index.php?app=cashier&act=jiesheng";
				   }
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}
	</script>
</head>
<body>
<div class="com-content">
       <!-- 头部区域开始 by-wei 2014.12.08  
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">微信支付</span>
          <a href="{url app=default}" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      <!-- 头部区域结束 end -->
	  <div align="center">
	     <div style="background:#E0E1DC;padding:15px 0px;">
	     <p style="padding:10px; font-size:18px;">订单编号：<?php echo $row_order['order_sn']; ?></p>
	     <p style="padding:10px 10px 15px;font-family: 微软雅黑;font-size:48px; font-weight: bold;">￥：<?php echo $row_order['order_amount']; ?></p>
		 </div>
		 <div style="padding:20px 0px; background:#FFF;font-size:16px; border-top:1px solid #ccc; margin-bottom:15px;">
		 收款方：倍全商城
		 </div>
		 <div style="text-align: center;">
		 <button align="center" style="background:#05A50F;border: medium none;border-radius: 8px;
box-shadow: 0 1px 20px #03C60F inset;color: #fff;cursor: pointer;display: block;font-family: 微软雅黑;font-size: 16px;margin: 20px auto 40px; width:230px ;padding: 10px 5px;text-align: center;" type="button" onclick="callpay()" >下一步</button>
         </div>
	  </div>
	  <!--底部区域开始 By Wei 2014.12.08-->
       <div class="com-footer-area" id="js-com-footer-area" style="margin-bottom:90px;">
			<div class="com-footer-nav">
				<a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201387981&idx=1&sn=3c5ae4f90632a4da200e588e8d5c382c#rd">商家入驻</a><a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201235911&idx=1&sn=78e95d8c36a85a8725873016a317739f#rd">关于倍全</a><a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201359815&idx=3&sn=0dfad18c4ca1877d1e6e1dfda06471d6#rd">20分钟送货</a>
			</div>
			<div class="com-footer">
				<p>
					<strong style="line-height:28px;">
						© 2014-2015 wap.bqmart.cn<br />
                        京ICP备14026542号-1
                        
					</strong>
				</p>
                <br /> 
                <p style="border-bottom:none;">
                <a href='http://wap.bqmart.cn'>倍全商城 </a>
                 - -有倍全的地方就有家！
                </p>
             </div>
		</div>
     <!--底部区域结束 End Wei 2014.12.08-->
</div>

</body>
</html>