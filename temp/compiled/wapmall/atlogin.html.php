<!doctype html>
<html>
    <head>
        <title>倍全商城-用户登录</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/login/index.css'; ?>"/>
       
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
    </head>
    <body>
    <div class="com-content" style=" box-shadow:none;">
       
        <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">快捷登录</span>
      
		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area bq_login-box">
        
        <div class="bq_login">
	    <form method="post">
		   <label>输入手机号:</label>
		   <input type="text" name="user_name" id="user_name" required onblur="checkphone()"/>
		
		   <label>请输入姓名:</label>
		   <input type="text" name="password" required />
		
		   <span></span>
		

		
		    <input type="submit" value="进入商城" class="bq_login-anniu" style="background:#FB8C08;box-shadow:none;  border: solid #FB8C08 1px;"/>
	    </form>
        </div>
        

         
    </div>
</div>
		</div>
        <script>
		
		function checkphone(){
     var reg = /^(1[3|5|8])[\d]{9}$/;                    //正则3

    var phone=document.getElementById('user_name').value;
    if(!reg.test(phone)){
        alert("电话号码格式错误!");
        document.getElementById('user_name').value="";
        document.getElementById('user_name').focus();
        return false;
    }else{
        
        return true;
    }
}
		</script>


</div>

</body>
</html>
