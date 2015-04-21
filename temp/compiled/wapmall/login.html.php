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
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">用户登录</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area bq_login-box">
        
        <div class="bq_login">
	    <form method="post">
           <p><a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">快速注册</a></p>
		   <label>用户名:</label>
		   <input type="text" name="user_name" required />
		
		   <label>密码:<a href="<?php echo url('app=reset_password'); ?>"><b>忘记密码?</b></a></label>
		   <input type="password" name="password" required />
		
		   <span></span>
		
		    <input type="checkbox" name="save" id="save" />
	     	<label for="save">记住登录</label>
		
		    <input type="submit" value="登录" class="bq_login-anniu" style="background:#f71f1f;"/>
	    </form>
        </div>
        
        
        <div class="bq_bkad">
           <div class="bq_bk_slide">
             <a href="#"><img src="themes/bqmart/images/bq_tonglan_ad_1.jpg"  width="100%" ></a>
            </div>
        </div>
        	
         
    </div>
</div>
		</div>
        
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div>

 <?php echo $this->fetch('store.menu.html'); ?>

</body>
</html>
