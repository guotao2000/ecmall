<!doctype html>
<html>
    <head>
        <title>倍全商城-购买成功页面</title>
        <meta charset="utf-8">
        <meta name="keywords" content="倍全,倍全商城,倍全订货,社区O2O,社区便利店,网上超市,济南社区020,便利店O2O,济南社区便利店" />
        <meta name="description" content="倍全商城-倍全旗下品牌，济南同城最快速的便利店商品订购派送网站" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" />
        
        <meta content="yes" name="apple-mobile-web-app-capable" />
        
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        
        <meta content="telephone=no" name="format-detection" />
        
        <!--<link rel="/touch/apple-touch-startup-image" href="startup.png" />-->
        
        <!--<link rel="apple-touch-icon" href="/touch/iphon_tetris_icon.png"/>-->
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>"/> 
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/index.css'; ?>"/>
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/cart/jquery.inputbox.js'; ?>"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
			var wxtype=0;
			var xunhuan=0;
			var keyile=0;
			wx.config({
			//debug: true,
			appId: '<?php echo $this->_var['signPackage']['appId']; ?>',
			timestamp: <?php echo $this->_var['signPackage']['timestamp']; ?>,
			nonceStr: '<?php echo $this->_var['signPackage']['nonceStr']; ?>',
			signature: '<?php echo $this->_var['signPackage']['signature']; ?>',
			  jsApiList: [
			  'onMenuShareTimeline',
			  'onMenuShareAppMessage'
			]
		  });
		  wx.ready(function () {
			//分享到朋友圈
			wx.onMenuShareTimeline({
				title: '我在倍全商城买东西节省了大把银子，棒棒哒~', // 分享标题
				link: 'http://wap.bqmart.cn', // 分享链接
				imgUrl: 'http://wap.bqmart.cn/data/files/store_10055/pic_slides_wap/pic_slides_wap_1.jpg', // 分享图标
				success: function () {
					// 用户确认分享后执行的回调函数
					alert('分享成功！');
				}
			});

			//分享给朋友
			wx.onMenuShareAppMessage({
				title: '我在倍全商城买东西节省了大把银子，棒棒哒~', // 分享标题
				desc: '倍全商城打造20分钟生活圈，能让你感受极速收货和购买体验，棒棒哒~~', // 分享描述
				link: 'http://wap.bqmart.cn', // 分享链接
				imgUrl: 'http://wap.bqmart.cn/data/files/store_10055/pic_slides_wap/pic_slides_wap_1.jpg', // 分享图标
				type: 'link', // 分享类型,music、video或link，不填默认为link
				dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
				success: function () { 
					// 用户确认分享后执行的回调函数
					alert('分享成功！');
				}
			});

		  });
		</script>
        
		<script type="text/javascript" >
		function yxwgopay()
		{

		   if($("input[name='payment_id']:checked").val().length>0)
		   {
		     $('#goto_pay').submit();
		   }else{
		   alert('请选择一种支付方式');
		   return false;
		   }
		}
		
		function WeiXinShareBtn() { 
			 /*if (typeof WeixinJSBridge == "undefined") { 
			 alert("请先通过微信搜索 ‘倍全商城’ 添加为好友，通过微信分享文章 "); 
			 } else { 
			 WeixinJSBridge.invoke('shareTimeline', { 
			 "title": "我在倍全商城买东西节省了大把银子，棒棒哒~", 
			 "link": "http://wap.bqmart.cn", 
			 "desc": "关注倍全商城", 
			 "img_url": "http://wap.bqmart.cn/data/files/store_10055/pic_slides_wap/pic_slides_wap_1.jpg" ,
			 "img_width": "640",
             "img_height": "640",
			 },function(res) {
                            alert(res.err_msg) ;
                            }); 
			 } */
			 
			 window.location.href="/index.php?app=storeyxw&status=1&id=<?php echo $this->_var['store_id']; ?>";
			 
			 }
		</script>
		<style>
	
.cart_empty-btn {
    margin: 0 33%;
    padding: 20px 0;
}	
.cart_empty-btn a {
    background: none repeat scroll 0 0 #ec0000;
    border: medium none;
    border-radius: 8px;
    box-shadow: 0 1px 20px #ed7676 inset;
    color: #fff;
    cursor: pointer;
    display: block;
    font-family: 微软雅黑;
    font-size: 16px;
    margin: 0 auto;
    padding: 3% 14%;
    text-align: center;
}
		</style>
		<style type="text/css">
body{padding:0px;margin:0px;font-size:12px;overflow:hidden;}
#container div{padding:10px;position:absolute;border:0px dotted brown;width:0px;cursor:pointer;}
.text{padding:10px;color:#ccc;}

</style>
</head>
<body>

<div class="com-content" style="box-shadow:none;">

<div id="container">
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
<div><img src="/themes/bqmart/images/jinbi.png" width="80px" height="60px"/></div>
</div>


  <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="/index.php?app=storeyxw&status=1&id=<?php echo $this->_var['store_id']; ?>" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">购买成功</span>
        
		  <div class="clear"></div>
        </div>


  <div class="com-content-area" id="js-com-content-area" style=" margin:0px;margin-top: 10px;">
      
      <form action="index.php?app=bqds&act=gopay_yxw&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST" id="goto_pay">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />

    <div class="pxui-area">
        <div class="bq_payorder-box" id="js-attrs-title">
           
            
          
           <div class="payorder-info" style="  height: 45px;">
		      <div style="float:left;width:60%;">
			  <p>市场价值：<span><?php echo price_format($this->_var['sum_shichang']); ?></span></p>
              <p>实付金额：<span><?php echo price_format($this->_var['order_amount']); ?></span></p>
			  
              </div>
			 <div class="cart_empty-btn" style="text-align:center;float:left;width:39%;margin: 0 0;
  padding: 0 0;margin-top: 7px;">
                 <a   class="weining" type="button"  style="color:#FB8C08;background-color:#fff;box-shadow:none; " href="/index.php?app=buyer_order&act=index&type=all">查看订单</a>
             </div>
           </div>
          <div style="width:100%;height:15px;background-color:#F0F0F2;"></div>
		   <div class="payorder_ok-title" style="width:100%;">
             <div style="text-align: center;background-color:#fff;">本次购物省了</div>
              <div style="  color: #FB8C08;  text-align: center;  font-size: 25px;background-color:#fff;"><?php echo price_format($this->_var['sum_price']); ?></div>
			  
             
           </div>	
		     <div style="width:100%;height:25px;background-color:#F0F0F2;"></div>
           
             <div class="cart_empty-btn" style="text-align:center;background-color:#F0F0F2;padding:0 0;margin:0 0;">
                 <a   class="weining" type="button"  style="background: #FB8C08;color:#FFF;width:99px;height: 30px; " onclick="WeiXinShareBtn();return false;">继续购买</a>
             </div>
            
	   
         </div>
    </div>
</div>
<input type="hidden" value="<?php echo $this->_var['order']['order_sn']; ?>" name="trade_sn"/>
</form>


</div> 

</div>

</body>
<script type="text/javascript">
/*
*code by 锋迷全球
*2011/5/24
*/
$(function()
{
$('div','#container').clone().prependTo('#container');//克隆一遍增加数据
$('div','#container').mousemove(function(e)
{
var ex = e.clientX;//鼠标x坐标
var ey = e.clientY;
$(this).css({"left":(ex-20) +"px","top":(ey-20) +"px"});
});
range();
 intv=setInterval(drop,400);
});
//排列
function range()
{
var num = 1;
$('div','#container').each(function(i)
{
var ww = $(window).width();//窗口宽度
var wh = $(window).height();
var ol = $(this).offset().left;//距左边像素
var ot = -20;//$(this).offset().top;//从头部以上开始
i++;
if(i%22==0) num=1; //22个一排
$(this).css({"left":(ol+ num*20) +"px","top":(ot + Math.ceil(i/2)*10)+"px"});//距左距离保持，距上距离变化
num ++;
});
}
var i=0;
//降落
function drop()
{
$('div','#container').each(function(i)
{
var wh = $(window).height();
var ol = $(this).offset().left;
var ot = $(this).offset().top;
var rnd = Math.round(Math.random()*100);
var rnd2 = Math.round(Math.random()*50);
//i = i == 0 ? 0.5 : i;
$(this).css({"top":(ot+rnd+rnd2) +"px"});//降落的速度
if(ot>=wh)//如果掉到窗口以下
{
//$(this).css({"top":wh-20 +"px"});//停在当前位置不让继续从上往下掉
$(this).css({"top":-5*rnd +"px"});//从顶部以上开始
}
});
i++;
if(i>6){
intv=window.clearInterval(intv);
$("#container").hide();
}
}
</script>

<script type="text/javascript" language="javascript">

    function payclick(that) {
        // alert($(that).html());
        $(that).children("input:first").attr("checked", true);
    }
    function qidongd() {

        // alert(1);
        that = $(".yxwspan").get(0);
        $(that).children("input:first").attr("checked", true);
    }
    $(function () {

        $('div[name="city"]').inputbox({
            height: 24,
            width: 100
        });

        $('.cbt').inputbox();

        $('[name="rbt"], [name="rbt2"]').inputbox();
        if ($(".yxwspan").size() > 0) {
            qidongd();
        }
		$(".com-content").height($(window).height());

    });
      
</script>

</html>
