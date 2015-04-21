<!doctype html>
<html>
    <head>
        <title>倍全商城-用户注册</title>
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
        
        <script type="text/javascript" src="index.php?act=jslang"></script>
    </head>
    <body>
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">用户注册</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area bq_register-box">
        
        <div class="bq_register">
         <form id="register_form" method="post">
         <div class="user_register-shouji">
            <p>
            <span>手机号：</span>
            <input type='text' name="user_name" id="user_name" value="" onBlur="check_mob()" />
            </p>
         </div>
	     <div class="user_register-yzmbtn">
            <p>
            <span></span>
            <input class="yzm_btn"  type="button" onClick="getYZM()" name="yzm_btn"  value="获取验证码" >
            <input type="hidden" name="tempVer" id="tempVer" />
            <span id="tempTime" class="daojishi" style="display:none"></span>
            </p>
         </div>
         <div class="user_register-tishi">
          <span id="message" style="font-size:14px; font-family:微软雅黑;"></span>
         </div>
         <div class="user_register-shouji">
            <p>
            <span>验证码：</span>
            <input type='text' name="yzm" id="yzm" value="" />
            
            </p>
         </div>
          <div class="user_register-shouji">
            <p>
            <span>输入密码：</span>
            <input  type="password" name="password" id="password" value="" />
            </p>
         </div>
         <div class="user_register-shouji">
            <p>
            <span>确认密码：</span>
            <input class="stext" type='password' name="password_confirm" id="password_confirm" value="" />
            </p>
         </div>
         
         <div style="text-align:center;">
         <input name="submit1" type="submit" value="同意服务条款并注册" style="background: none repeat scroll 0 0 #ec0000;border: medium none;border-radius: 8px;box-shadow: 0 1px 20px #ed7676 inset;color: #fff;cursor: pointer;font-family: 微软雅黑;font-size: 16px;margin: 0 auto;padding: 3% 14%;" />
         </div>
         </form>
         <div class="user_register-dl">
            <p>
            <span></span>
            <a href="<?php echo url('app=member'); ?>"><i>已有账号?&nbsp;&nbsp;</i>去登录</a>
            </p>
         </div>
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

	    $('#register_form').submit(function () {
	        //验证输入
	        var user_name = $('#user_name').val();
	        user_name = $.trim(user_name);
	        var yzm = $('#yzm').val();
	        yzm = $.trim(yzm);
	        var password = $('#password').val();
	        password = $.trim(password);
	        var password_confirm = $('#password_confirm').val();
	        password_confirm = $.trim(password_confirm);
	        var temp = $('#tempVer').val();
	        temp = $.trim(temp);

	        if (user_name.length == 0) {
	            alert('用户名不能为空！');
	            return false;
	        }

	        //检测用户名是否被注册过
	        if (user_name.length > 0) {
	            if (!check_user(user_name)) {
	                alert('该用户名已被注册过！');
	                return false;
	            }
	        }

	        if (user_name.length > 0) {
	            if (!checkMobile(user_name)) {
	                alert('请输入正确的手机号码！');
	                return false;
	            }
	        }

	        if (yzm.length == 0) {
	            alert('验证码不能为空！');
	            return false;
	        }

	        if (temp.length == 0) {
	            alert('请获取验证码！');
	            return false;
	        }

	        //对获得的验证码进行验证
	        if (yzm.length > 0 && temp.length > 0) {
	            if (yzm != temp) {
	                alert('验证码输入错误！');
	                return false;
	            }
	        }

	        if (password.length == 0) {
	            alert('密码不能为空！');
	            return false;
	        }

	        if (password_confirm.length == 0) {
	            alert('确认密码不能为空！');
	            return false;
	        }

	        document.getElementsByName('tempVer').item(0).value = '';
	        return true;

	    });

	    //获取验证码函数
	    function getYZM() {
	        var phone = $('#user_name').val();
	        phone = $.trim(phone);
	        if (!checkMobile(phone)) {
	            alert('请输入正确的手机号！');
	            return;
	        }
	        if (!check_user(user_name)) {
	            alert('该用户名已被注册过！');
	            return;
	        }
	        result = $.ajax({ url: "index.php?app=send_code&tel=" + phone, async: false, dataType: "text",
	            cache: false
	        });
	        var code = result.responseText;
	        code = $.trim(code);
	        var tempArr = code.split('-');
	        document.getElementById('tempVer').value = tempArr[1];
	        if ($.trim(tempArr[0]) == 'Success') {
	            document.getElementById('message').innerHTML = '短信已经发送到您的手机如在60秒之内还没有收到请重新获取验证码';
	            $('#tempTime').html(60);
	            $('#tempTime').show();
	            document.getElementsByName('yzm_btn').item(0).disabled = true;
	            setInterval('getFree()', 1000);
	        } else {
	            if (Utils.trim(tempArr[0]) == 'Faild') {
	                document.getElementById('message').innerHTML = '验证码发送错误！';
	            }
	        }

	    }

	    //验证手机号函数
	    function checkMobile(tel) {
	        var reg = /^[1][3-9]\d{9}$/;
	        if (reg.test(tel)) {
	            return true;
	        } else {
	            return false;
	        }
	    }

	    //释放发送按钮
	    function getFree() {
	        var s = document.getElementById("tempTime");
	        if (s.innerHTML == 0) {
	            //document.getElementsByName('tempVer').item(0).value = '';
	            document.getElementById('message').innerHTML = '';
	            document.getElementsByName('yzm_btn').item(0).disabled = false;
	            $('#tempTime').hide();
	            return false;
	        }
	        s.innerHTML = s.innerHTML * 1 - 1;
	    }

	    //检查用户名是否已被注册过
	    function check_user(user_name) {
	        result = $.ajax({ url: "index.php?app=send_code&act=validate_user&name=" + user_name, async: false, dataType: "text",
	            cache: false
	        });
	        var unique = result.responseText;
	        unique = $.trim(unique);
	        if (unique == 1) {
	            return false;
	        }
	        if (unique == 2) {
	            return true;
	        }

	    }

	    //失去焦点时检测用户名
	    function check_mob() {
	        var user_name = $('#user_name').val();
	        user_name = $.trim(user_name);
	        if (user_name.length == 0) {
	            alert('用户名不能为空！');
	            return;
	        }
	        if (user_name.length > 0) {
	            if (!checkMobile(user_name)) {
	                alert('请输入正确的手机号！');
	                return;
	            }

	            if (!check_user(user_name)) {
	                alert('该用户名已被注册过！');
	                return;
	            }
	        }
	    }
	
    </script>

        
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div>

 <?php echo $this->fetch('store.menu.html'); ?>

</body>
</html>
