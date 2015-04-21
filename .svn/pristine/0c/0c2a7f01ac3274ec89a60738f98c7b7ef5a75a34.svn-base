<!doctype html>
<html>
    <head>
        <title>倍全商城-设置新密码</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/register/index.css'; ?>"/>
       
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
    </head>
    <body>
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">设置新密码</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area bq_register-box">
        
        <div class="change_password">
         <form id="thisForm" method="post" action="index.php?app=reset_password&act=change">
          <div class="change_password-text">
            <p>
            <span>设置密码：</span>
           <input  type="password" name="password" id="password" value="" />
            </p>
         </div>
         <div class="change_password-text">
            <p>
            <span>确认密码：</span>
            <input class="stext" type='password' name="confirm_password" id="confirm_password" value="" />
            </p>
         </div>
         
         <div class="change_password-tijiao">
         <input name="Submit" type="submit" class="butn" value="确认并保存" />
         <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($this->_var['user_name']); ?>" />
         </div>
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
<script type="text/javascript">
    //验证提交
	$('#thisForm').submit(function(){
		var password = $('#password').val();
		password = $.trim(password);
		var confirm_password = $('#confirm_password').val();
		confirm_password = $.trim(confirm_password);
		
		if(password.length == 0){
			alert('新密码不能为空！');
			return false;	
		}
		
		if(confirm_password.length == 0){
			alert('确认密码不能为空！');
			return false;	
		}
		
		if(password.length > 0 && confirm_password.length > 0){
			if(password.length < 6 || confirm_password.length < 6){
				alert('密码长度至少为6个字符！');
				return false;
			}	
			if(password != confirm_password){
				alert('两次输入的密码不一致！');
				return false;	
			}
		}
		
		return true;
		
	});
</script>
        
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div>

<?php echo $this->fetch('store.menu.html'); ?>

</body>
</html>
