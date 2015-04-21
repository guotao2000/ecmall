<!doctype html>
<html>
    <head>
        <title>我抢到红包啦</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
</head>
<body>
<div class="com-content">

  <div class="com-header-area" id="js-com-header-area">
        
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">抢红包成功</span>
        
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   
   <div class="page-role cart_empty-page">
      <div class="pxui-area">
            
           <div class="cart_empty-top">
              <p>
               <span class="cart_empty-topicon"></span>今天又赚大发了~~
              </p>
           </div>
             
           <div class="bq_cplb_bg" ></div>
        <div class="cart_empty-info">
             <div class="login_success-img">
                <img src="themes/bqmart/template/images/cart/bq_login_success.png" > </div>
             <p>
             红包金额：<span style="color:red;"><?php echo $this->_var['hongbao']['coupon_value']; ?></span>个大金元宝
             </p>
			 <p>
             使用次数：<span style="color:red;"><?php echo $this->_var['hongbao']['use_times']; ?></span>次
             </p>
			  <p>倍全曹操为你待命中……</p>
             <div class="cart_empty-btn">
                 <a type="button"  href="/index.php?app=store&id=<?php echo $this->_var['sid']; ?>"  >去 逛 逛</a>
             </div>
             <div class="login_success-btn">
                 <a type="button"  href="/index.php?app=hongbao"  >查看红包</a>
             </div>
        </div>        
       </div>
      </div>
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div> 

</div>

 <?php echo $this->fetch('store.menu.html'); ?>

</body>
</html>
