<!doctype html>
<html>
    <head>
        <title>倍全商城-倍全红包</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
</head>
<body>
<div class="com-content">

  <div class="com-header-area" id="js-com-header-area">
          <a href="<?php echo url('app=default'); ?>" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">倍全红包</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>


  <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
      
         <div class="page-role hongbao-get">
	<?php if ($this->_var['coupons']): ?>
    <div class="pxui-area" style="	background:#EDEBE9;">
        
           <div class="cart_empty-top" >
              <p>
               <!-- <span>发行方：</span><?php echo htmlspecialchars($this->_var['store_name']); ?> -->
			   <span>发行方：</span>倍全商城
              </p>
           </div>
             
        <div class="cart_empty-info" >
             <!-- <div class="cart_empty-money">
                <?php echo htmlspecialchars($this->_var['coupons']['coupon_value']); ?>元<span><?php echo htmlspecialchars($this->_var['coupons']['remark']); ?></span>
              </div>
             <p>
             洗衣消费满<?php echo htmlspecialchars($this->_var['coupons']['min_amount']); ?>元立减<?php echo htmlspecialchars($this->_var['coupons']['coupon_value']); ?>元
             </p>
             <p style="color:#F7EAE0; margin-bottom:20px;">
             有效期：<?php echo local_date("Y-m-d",$this->_var['coupons']['start_time']); ?> - <?php echo local_date("Y-m-d",$this->_var['coupons']['end_time']); ?>
             </p>
             <div class="hongbao_get-ht"></div>
             -->
			 <div class="cart_empty-money">
                <span>￥<?php echo htmlspecialchars($this->_var['coupons']['coupon_value']); ?>元</span>
              </div>
             <p>说明：<?php echo htmlspecialchars($this->_var['coupons']['remark']); ?></p>
             <p>
             洗衣消费满<?php echo htmlspecialchars($this->_var['coupons']['min_amount']); ?>元立减<?php echo htmlspecialchars($this->_var['coupons']['coupon_value']); ?>元
             </p>
             <p style="color:#E8E8E8; margin-bottom:20px;">
             有效期：<?php echo local_date("Y-m-d",$this->_var['coupons']['start_time']); ?> - <?php echo local_date("Y-m-d",$this->_var['coupons']['end_time']); ?>
             </p>
             <div class="hongbao_get-ht"></div>
             
        </div>  
        <div class="cart_empty-btn">
                 <a href="javascript:getHongbao();">立 即 领 取</a>
        </div>
		<div class="cart_empty-btn" style="padding:5px 0px 10px;">
            <a type="button" href="<?php echo url('app=hongbao'); ?>" style="background:#F57600;box-shadow: 0 1px 20px #FAA224 inset;">查 看 红 包</a>
        </div>
    </div>
	<?php else: ?>
		很抱歉，您来晚了，红包已经被抢没了！ <br />
	<?php endif; ?>
</div>

<script type="text/javascript">
	function getHongbao(){
		
		var openid = "<?php echo $_GET['openid']; ?>";
		var wx_id = <?php echo $_GET['wx_id']; ?>;
		var wxtw_id = <?php echo $_GET['wxtw_id']; ?>;
		//alert(11111);
		$.getJSON('index.php?app=weixin_view&act=get_hongbao&wx_id='+wx_id+'&wxtw_id='+wxtw_id+'&openid='+openid, function(result){
        if(result.done){
            alert('红包领取成功！');
			window.location.href = 'index.php?app=hongbao';
		} else {
			alert('很抱歉，您已经领过红包了！');
		}
		}
		);
	}


</script>

      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div> 

</div>
</body>
</html>
