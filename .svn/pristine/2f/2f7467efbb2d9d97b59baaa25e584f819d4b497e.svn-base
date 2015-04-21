<!doctype html>
<html>
    <head>
        <title>倍全商城-找回密码</title>
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
          <span class="bq_header_title" style="padding-left:0px;">找回密码</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area bq_register-box">
        
        <form method="post" action="index.php?app=reset_password" id="thisForm">
        <div class="bq_retrieve_pssword">
          <div class="retrieve_pssword-shouji" style="position:relative;">
            <div class="pssword_shouji-l">
            <input type='text' name="shouji" id="shouji"  placeholder="请输入手机号" value="" onBlur="check_mob()" />
            </div>
            <span>
            <input class="yzm_btn" name="yzm_btn" type="button"  value="获取验证码" onClick="getYZM()" >
            <input type="hidden" name="tempVer" id="tempVer" />
            <span id="tempTime" class="daojishi" style="display:none;"></span>
            </span>
          </div>
          <div class="retrieve_pssword-text ">
            <div class="pssword_text-l">
            <p>输入验证码：</p>
            </div>
            <span>
            </span>
          </div>
          <div class="retrieve_pssword-yzm">
            <div class="pssword_yzm-l">
            	<input type='text' name="yzm" id="yzm"  placeholder="请输入验证码" value="" />
            </div>
            <span>
            </span>
          </div>
          <div class="shuoming">
            <span id="message" style="font-size:14px; font-family:微软雅黑;">
            </span>
          </div>
        </div>
        
        <div class="retrieve_pssword-tijiao">
        	<input type="submit" class="xiayibu_btn" name="submit1" value="下一步" />
        </div>
        </form>
        
        
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
		var shouji = $('#shouji').val();
		shouji = $.trim(shouji);
		var yzm = $('#yzm').val();
		yzm = $.trim(yzm);
		var temp = $('#tempVer').val();
		temp = $.trim(temp);
		
		if(shouji.length == 0){
			alert('手机号码不能为空！');
			return false;	
		}
		
		//检测手机号是否注册过
		if(shouji.length > 0){
			if(check_user(shouji)){
				alert('该手机号没有注册过用户！');
				return false;	
			}
		}
		
		//检测输入的手机格式
		if(shouji.length > 0){
			if(!checkMobile(shouji)){
				alert('请输入正确的手机号码！');
				return false;	
			}	
		}
		
		if(yzm.length == 0){
			alert('验证码不能为空！');
			return false;
		}
		
		if(temp.length == 0){
			alert('请获取验证码！');
			return false;
		}
		
		//对获得的验证码进行验证
		if(yzm.length > 0 && temp.length > 0){
			if(yzm != temp){
				alert('验证码输入错误！');
				return false;	
			}
		}
		
		return true;
		
		
	});
	
	//获取验证码函数
	function getYZM(){
		var phone = $('#shouji').val();
		phone = $.trim(phone);
		if(!checkMobile(phone)){
			alert('请输入正确的手机号！');
			return;	
		}

        //检测用户名是否已被注册过
        if (check_user(phone) == 1) {
            alert('该手机号未注册！');
            return;
        }

		result = $.ajax({ url: "index.php?app=send_code&tel=" + phone, async: false, dataType: "text",
            cache: false
        });
		var code = result.responseText;
		code = $.trim(code);
		var tempArr = code.split('-');
		document.getElementById('tempVer').value = tempArr[1];
		if($.trim(tempArr[0]) == 'Success'){
			document.getElementById('message').innerHTML = '短信已经发送到您的手机如在60秒之内还没有收到请重新获取验证码';
			$('#tempTime').html(60);
			$('#tempTime').show();
			document.getElementsByName('yzm_btn').item(0).disabled = true;
			setInterval('getFree()', 1000);
		}else{
			if(Utils.trim(tempArr[0]) == 'Faild'){
				document.getElementById('message').innerHTML = '验证码发送错误！';
			}	
		}
		
	}
	
	//验证手机号函数
	function checkMobile(tel){
		var reg = /^[1][3-9]\d{9}$/;
		if(reg.test(tel)){
			return true;	
		} else {
			return false;	
		}
	}
	
	//释放发送按钮
	function getFree(){
		var s = document.getElementById("tempTime");
		if(s.innerHTML == 0){
			//document.getElementsByName('tempVer').item(0).value = '';
			document.getElementById('message').innerHTML = '';
			document.getElementsByName('yzm_btn').item(0).disabled = false;
			$('#tempTime').hide();
			return false;
		}
		s.innerHTML = s.innerHTML * 1 - 1;
	}
	
	//检查用户名是否已被注册过
	function check_user(user_name){
		result = $.ajax({ url: "index.php?app=send_code&act=validate_user&name=" + user_name, async: false, dataType: "text",
            cache: false
        });
		var unique = result.responseText;
		unique = $.trim(unique);
		if(unique == 1){
			return false;
		}
		if(unique == 2){
			return true;	
		}
		
	}
	
	//失去焦点时检测用户名
	function check_mob(){
		var user_name = $('#shouji').val();
		user_name = $.trim(user_name);
		if(user_name.length == 0){
			alert('手机号不能为空！');
			return;				
		}
		if(user_name.length > 0){
			if(!checkMobile(user_name)){
				alert('请输入正确的手机号！');
				return;	
			}
			
			if(check_user(user_name)){
				alert('该手机号没有注册过用户！');
				return;		
			}
		}
	}
	
    </script>       

      
      
      <?php echo $this->fetch('bqmart/member.footer.html'); ?>
      

</div>

 <?php echo $this->fetch('bqmart/store.menu.html'); ?>

</body>
</html>
