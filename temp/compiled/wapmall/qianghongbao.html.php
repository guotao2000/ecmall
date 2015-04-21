<!doctype html>
<html>
    <head>
        <title>倍全商城-开抢红包啦</title>
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
        <link type="text/css" rel="stylesheet" href="/themes/bqmart/style/zq_index.css"/> 
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>

		<script>
		 
		// JavaScript Document
		$(document).ready(function(e) {
		//改变字体大小
		// 获取div的宽度
			var width=$(".zq_span").width();
			var fontsize=parseFloat(width*0.04);
			$(".zq_span p").css({'font-size':fontsize});
		//输入框
		//鼠标点击
		$(".zq_input1").mousedown(function(){
			
			$(this).val("");
			})
		//鼠标离开
		$(".zq_input1").mouseleave(function(){
			var str=$(this).val();
			if(str==""){
			$(this).val("请输入准确手机号码");}
			else {
			$(this).val(str);}
			})
			if(<?php echo $this->_var['coupon_count']; ?><1)
			{
			  $("#qhb").css("background-color","#C0C0C0");
			  $("#qhb").attr("disabled", true);
			}
			
		});
		   function qhbao()
		   {
		     var isMobile=/^(?:13\d|15\d|17\d|18\d)\d{5}(\d{3}|\*{3})$/; //手机号码验证规则
			 var dianhua = $("#dianhua").val();                   //获得用户填写的号码值 赋值给变量dianhua
				if(!isMobile.test(dianhua)){ //如果用户输入的值不同时满足手机号和座机号的正则
					alert("请正确填写电话号码，例如:13415764179");  //就弹出提示信息
					$("#dianhua").focus();       //输入框获得光标
					return false;         //返回一个错误，不向下执行
				}
				$("#sb").submit();
		   }
		</script>
       
    </head>
    <body>
    <div class="zq_main">
    	<div class="zq_top">
        	<img src="/themes/bqmart/images/zq_top.png"/>
        </div>
        <div class="zq_bottom">
        	<div class="zq_span">
            	<p>送你倍全红包,输入手机号,自动放入倍全账户</p>
            </div>
			<form action="/index.php?app=couponyxw&id=<?php echo $_GET['id']; ?>" method="POST" id="sb">
            <div class="zq_input">
            	<input class="zq_input1" name="mobile" id="dianhua" type="text" value="输入您的手机号"/><br/>
                <input class="zq_input2" id="qhb"  type="button" value="抢红包" onclick="qhbao()"/>
            </div>
			</form>
            <div class="zq_span">
            	<p>红包可在倍全商城直接消费</p>
            </div>
        
        </div>
    
    </div>

</body>
</html>
