<!doctype html>
<html>
    <head>
        <title>倍全商城-编辑个人资料</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/cart/jquery.inputbox.js'; ?>"></script>
        
    </head>
    <body>
    <div class="com-content" style="box-shadow:none;">
       
        <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">编辑个人资料</span>

		  <div class="clear"></div>
        </div>
      
      
<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   <div class="page-role good-page">
     <div class="pxui-area">
        <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
        
        <form method="post" action="index.php?app=member&act=change_profile" id="form_profile">
        <div class="user_edtiadate-nicheng">
          <p><span>用户名 ：</span><?php if ($this->_var['user']['from_weixin'] == 1): ?><?php echo $this->_var['user']['wx_nickname']; ?><?php else: ?><?php echo htmlspecialchars($this->_var['user']['user_name']); ?><?php endif; ?></p>
        </div>
        <div class="user_edtiadate-nicheng">
          <p><span>手机号：</span><input name="phone_mob" type="text" style="border-width:1px; height:18px;" value="<?php echo htmlspecialchars($this->_var['user']['phone_mob']); ?>" id="phone_mob"></p>
        </div>
        <div class="user_edtiadate-nicheng">
          <p><span>真实姓名 ：</span><input name="real_name" type="text" style="border-width:1px; height:18px;" value="<?php echo htmlspecialchars($this->_var['user']['real_name']); ?>" id="real_name"></p>
        </div>
        <div class="user_edtiadate-xingbie">
          <p><span>性别 ：</span>
              <input type="radio" name="gender" value="0" <?php if ($this->_var['user']['gender'] == 0): ?> checked <?php endif; ?> /> 保密
              <input type="radio" name="gender" value="1" <?php if ($this->_var['user']['gender'] == 1): ?> checked <?php endif; ?> /> 男
              <input type="radio" name="gender"  value="2" <?php if ($this->_var['user']['gender'] == 2): ?> checked <?php endif; ?> /> 女
          </p>
        </div>
        <div class="user_edtiadate-nicheng">
          <p><span>生日 ：</span><input name="birthday" type="text" style="border-width:1px; height:18px;" value="<?php echo $this->_var['user']['birthday']; ?>" id="birthday" placeholder="格式：2014-12-12"></p>
        </div>
        <div class="user_edtiadate-nicheng">
          <p><span>QQ ：</span><input name="im_qq" type="text" style="border-width:1px; height:18px;" value="<?php echo $this->_var['user']['im_qq']; ?>" id="im_qq"></p>
        </div>
        <div class="user_edtiadate" style="text-align:center;">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($this->_var['user']['user_id']); ?>" />
          <input type="submit" name="submit1" style=" background: #f71f1f;border-radius: 6px;color: #fff;font-family: 微软雅黑;font-size: 16px;padding: 8px 30%;text-align: center; border:none;" value="保 存" />
        </div>
        </form>

        
    
    <!-- 猜你喜欢产品循环列表开始
	    <div class="content-box">
		   <div class="content-box-category" style="padding:10px 0px 5px 25px;; background:#EDEBE9;">
			<span><strong>猜你喜欢.....</strong></span>
		    </div>
		    <div class="content-box-list" id="slider-id">
				<ul>
					<?php $_from = $this->_var['rgoods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
					<div class="slider-item">
                        <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');if (count($_from)):
    foreach ($_from AS $this->_var['good']):
?>
						<li>
							<div style="width:99%;">
							   <a href="index.php?app=goods&id=<?php echo htmlspecialchars($this->_var['good']['goods_id']); ?>" class="product-image-link"><img src="<?php echo $this->_var['good']['default_image']; ?>" /></a>
						    </div>
							<div style="width:99%; overflow: hidden; position:relative;">
							    <a href="" class="product-title-link"><?php echo htmlspecialchars($this->_var['good']['goods_name']); ?></a>
							    <p>售价：<?php echo price_format($this->_var['good']['price']); ?></p>
                                <a href="<?php echo url('app=goods&id=' . $this->_var['good']['goods_id']. ''); ?>" class="bq_qianggou_anniu" style=" color:#FFF;">抢购</a>
							</div>
						</li>	
				           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
	                 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>	
		</div>
            <div class="bq_zuoyou_mnue">
               <span class="bq_qg_prev"></span>
               <span class="bq_qg_next"></span>
             </div>
		</div>
	猜你喜欢产品循环列表结束
       <script type="text/javascript">
           window.mySwipe = new Swipe(document.getElementById('slider-id'), {
               startSlide: 0,
               speed: 400,
               auto: 3000,
               continuous: true,
               disableScroll: false,
               stopPropagation: false,
               callback: function (index, elem) {},
               transitionEnd: function (index, elem) {}
           });           
       </script>
   猜你喜欢模块结束  Eed Wei 2012.12.09-->			
         
    </div>
</div>
		</div>
        
 

</div>

<script type="text/javascript">
    $(function () {
        //提交验证
        $('#form_profile').submit(function () {
            var phone_mob = $('#phone_mob').val();
            phone_mob = $.trim(phone_mob);
            var real_name = $('#real_name').val();
            real_name = $.trim(real_name);
            var birthday = $('#birthday').val();
            birthday = $.trim(birthday);
            regBirth = /^\d{4}-\d{1,2}-\d{1,2}/;
            var im_qq = $('#im_qq').val();
            im_qq = $.trim(im_qq);
            regQQ = /[1-9][0-9]{4,}/;
            //验证邮箱
            if (phone_mob.length == 0) {
                alert('手机号不能为空！');
                return false;
            } else {
                if (!checkMobile(phone_mob)) {
                    alert('手机号码格式不正确！');
                    return false;
                }
            }
            //验证真实姓名
            if (real_name.length == 0) {
                alert('真实姓名不能为空！');
                return false;
            }
            //验证生日
            if (birthday.length == 0) {
                alert('生日不能为空！');
                return false;
            } else {
                if (!regBirth.test(birthday)) {
                    alert('日期格式不正确！');
                    return false;
                }
            }
            //验证QQ
            if (im_qq.length == 0) {
                alert('QQ不能为空！');
                return false;
            } else {
                if (!regQQ.test(im_qq)) {
                    alert('QQ号码格式不正确！');
                    return false;
                }
            }

            return true;


        });
    });

    //验证手机号函数
    function checkMobile(tel) {
        var reg = /^[1][3-9]\d{9}$/;
        if (reg.test(tel)) {
            return true;
        } else {
            return false;
        }
    }
		
        </script>


</body>

<script type="text/javascript">
    $(function () {

        $('div[name="city"]').inputbox({
            height: 24,
            width: 100
        });

        $('.cbt').inputbox();

        $('[name="rbt"], [name="rbt2"]').inputbox();

    });
</script>

</html>
