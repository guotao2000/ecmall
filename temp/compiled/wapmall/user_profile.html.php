<!doctype html>
<html>
    <head>
        <title>倍全商城-修改个人资料</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
        
    </head>
    <body>
    <div class="com-content" style="box-shadow:none;">
       
        <div class="com-header-area" id="js-com-header-area"  style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">修改个人资料</span>

		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
    <div class="pxui-area">
         <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
         
         <div class="bq_user_order"><a href="<?php echo url('app=address&act=list_address'); ?>">
              <i class="user_centeradd_icon"></i>
                <div class="user_order_name">
                   修改收货地址
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         
         <div  style="height:10px; background:#EDEBE9; clear:both;"></div>
         
         <div class="bq_user_account"><a href="<?php echo url('app=member&act=change_profile'); ?>">
              <i class="user_data_icon"></i>
                <div class="user_account_name">
                   修改个人资料
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         
         <div  style="height:10px; background:#EDEBE9; clear:both;"></div>
         
         <div class="bq_user_collectio"><a href="<?php echo url('app=member&act=change_user_password'); ?>">
              <i class="user_dlpassword_icon"></i>
                <div class="user_collectio_name">
                   修改登录密码
                </div>
              <i class="goods_anjian"></i></a>
         </div>
         
         <div  style="height:10px; background:#EDEBE9; clear:both;"></div>
         
         <!--<div class="bq_user_collectio"><a href="retrieve_password.htm">
              <i class="user_zfpassword_icon"></i>
                <div class="user_collectio_name">
                   修改支付密码
                 </div>
              <i class="goods_anjian"></i></a>
         </div>-->
         
         <!--<div  style="height:10px; background:#EDEBE9; clear:both;"></div>-->
         
         <!--<div class="bq_user_cart"><a href="<?php echo url('app=default'); ?>">
              <i class="user_card_icon"></i>
                <div class="user_cart_name">
                   会员卡绑定
                 </div>
              <i class="goods_anjian"></i></a>
         </div>-->
         
         <!--<div  style="height:10px; background:#EDEBE9; clear:both;"></div>-->
         
         <div class="bq_user_cart"><a href="<?php echo url('app=default'); ?>">
              <i class="user_shouhou_icon"></i>
                <div class="user_cart_name">
                   售后服务
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         
        
         <div  style="height:15px; background:#EDEBE9; clear:both;"></div>

        
        
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
	callback: function(index, elem) {},
	transitionEnd: function(index, elem) {}
	});           
    </script>
      
     猜你喜欢模块结束  Eed Wei 2012.12.09-->			
         
    </div>
</div>
		</div>
        


</div>

</body>

</html>
