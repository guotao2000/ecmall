<!doctype html>
<html>
    <head>
        <title>倍全商城-会员中心</title>
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
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
        
    </head>
    <body>
    <div class="com-content" style="box-shadow:none;">
       
        <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="/index.php" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">会员中心</span>

		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
          <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
    <div class="pxui-area">
         
         <div class="bq_user-top">
           <div class="bq_user-photo">
              <?php if ($this->_var['user']['wx_headimgurl']): ?><img src="<?php echo $this->_var['user']['wx_headimgurl']; ?>" /><?php else: ?><img src="themes/bqmart/template/images/user/bq_user-tx.png" /><?php endif; ?>
           </div>
           <p>会员：<?php if ($this->_var['user']['from_weixin'] == 1): ?><?php echo $this->_var['user']['wx_nickname']; ?><?php else: ?><?php echo htmlspecialchars($this->_var['user']['user_name']); ?><?php endif; ?><br />
           等级：
           <?php if ($this->_var['user']['user_level'] == 0): ?>普通会员<?php endif; ?>
           <?php if ($this->_var['user']['user_level'] == 1): ?>高级会员<?php endif; ?>
           <?php if ($this->_var['user']['user_level'] == 2): ?>VIP会员<?php endif; ?>
           </p>
           <span class="bq_user-edit"><a href="index.php?app=member&act=change_profile">修改</a></span>
         </div>
         
         <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
         
         <div class="bq_user_order"><a href="<?php echo url('app=buyer_order&act=index&type=all'); ?>">
              <i class="user_order_icon"></i>
                <div class="user_order_name">
                   我的订单
                 </div>
              <i class="news-icon"></i></a>
              <i class="goods_anjian"></i></a>
         </div>
         
         
        <!--  <div class="bq_user_collectio"><a href="<?php echo url('app=my_favorite&type=store'); ?>">
              <i class="user_collectio_icon"></i>
                <div class="user_collectio_name">
                   我的收藏
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
        我的收藏区块结束-->
         
         <div class="bq_user_cart"><a href="<?php echo url('app=cart'); ?>">
              <i class="user_cart_icon"></i>
                <div class="user_cart_name">
                   我的购物车
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         
         <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
         
         <!--<div class="bq_user_coupons"><a href="tuwen.htm">
              <i class="user_coupons_icon"></i>
                <div class="user_coupons_name">
                   我的订购券
                 </div>
              <i class="news-icon"></i></a>
              <i class="goods_anjian"></i></a>
         </div>-->
         
         
         <div class="bq_user_hongbao"><a href="<?php echo url('app=hongbao'); ?>">
              <i class="user_hongbao_icon"></i>
                <div class="user_hongbao_name">
                   我的红包
                 </div>
              <i class="news-icon"></i></a>
              <i class="goods_anjian"></i></a>
         </div>
         
         
         <!--<div class="bq_user_money"><a href="#">
              <i class="user_money_icon"></i>
                <div class="user_money_name">
                   我的余额
                 </div>
              <i class="goods_anjian"></i></a>
         </div>-->
         
         
          <!-- <div class="bq_user_jifen"><a href="<?php echo url('app=my_integral'); ?>">
              <i class="user_jifen_icon"></i>
                <div class="user_jifen_name">
                   我的积分
                 </div>
              <i class="goods_anjian"></i></a>
         </div> -->
         
         
         <div class="bq_user_account"><a href="/index.php?app=address&act=list_address">
              <i class="user_account_icon"></i>
                <div class="user_account_name">
                   修改收货地址
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         
        <!-- <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
         生活服务区块开始--->
         <!-- <div class="bq_user_life"><a href="<?php echo url('app=default'); ?>">
              <i class="user_life_icon"></i>
                <div class="user_life_name">
                   生活服务
                 </div>
              <i class="news-icon"></i></a>
              <i class="goods_anjian"></i></a>
         </div>
        生活服务区块结束-->
         
         <!-- <div class="bq_user_number"><a href="<?php echo url('app=my_tuijian'); ?>">
              <i class="user_number_icon"></i>
                <div class="user_number_name">
                   我的推荐号
                 </div>
              <i class="goods_anjian"></i></a>
         </div> -->
         
         
        <!-- <div class="bq_user_number"><a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201235911&idx=1&sn=78e95d8c36a85a8725873016a317739f#rd">
              <i class="user_guanyubq_icon"></i>
                <div class="user_number_name">
                   关于倍全
                 </div>
              <i class="goods_anjian"></i></a>
         </div>
         关于倍全区块结束-->
        <!--  <div  style="height:15px; background:#EDEBE9; clear:both;"></div>
         会员中心区域结束-->
        

        
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
    -->
	<!-- 猜你喜欢产品循环列表结束 
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
