<!doctype html>
<html>
<head>
<title>倍全商城-我的红包</title>
<meta charset="utf-8">
<meta name="keywords"
	content="倍全,倍全商城,倍全订货,社区O2O,社区便利店,网上超市,济南社区020,便利店O2O,济南社区便利店" />
<meta name="description" content="倍全商城-倍全旗下品牌，济南同城最快速的便利店商品订购派送网站" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="bookmark" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta
	content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;"
	id="viewport" name="viewport" />

<meta content="yes" name="apple-mobile-web-app-capable" />

<meta content="black" name="apple-mobile-web-app-status-bar-style" />

<meta content="telephone=no" name="format-detection" />

<!--<link rel="/touch/apple-touch-startup-image" href="startup.png" />-->

<!--<link rel="apple-touch-icon" href="/touch/iphon_tetris_icon.png"/>-->
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>" />
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/index.css'; ?>" />
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
 <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
</head>
<body>
<div class="com-content" style="box-shadow:none;">
<div class="com-header-area" id="js-com-header-area"style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;"><a href="javascript:history.back(-1);"
	class="com-header-retun"></a> <dfn></dfn> <span class="bq_header_title"
	style="padding-left: 0px;">我的红包</span> 
<div class="clear"></div>
</div>


<div class="com-content-area" id="js-com-content-area" style="margin: 0px;">
    
<div class="page-role good-page">
<div class="pxui-area">
<div class="user_hongbao-box" id="js-attrs-title">
<?php if ($this->_var['result']): ?>
<div class="user_hongbao-top"><span class="user_hongbao-topicon"></span>
<p>客官，您有以下红包可以使用</p>
</div>
 <?php $_from = $this->_var['result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'res');if (count($_from)):
    foreach ($_from AS $this->_var['res']):
?>
  <div class="user_hongbao-info">
<ul>
	
	<?php if ($this->_var['res']['coupon_value'] < "10"): ?>
	<li>
	<a href="/index.php?app=store&id=<?php echo $this->_var['res']['store_id']; ?>">
	<div class="user_hongbao-list">
	<div class="hongbao_list-l">
	<!-- <span class="hongbao_shopname">
	<?php echo $this->_var['res']['store_name']; ?> 
	</span> -->
	<span class="hongbao_shopname">
	倍全红包
	</span>
	<p><?php echo $this->_var['res']['coupon_value']; ?></p>
	<span class="hongbao_shuoming"> 满<?php echo $this->_var['res']['min_amount']; ?>元可使用<br /><?php echo $this->_var['res']['remark']; ?>(不含运费) </span></div>
	<div class="hongbao_list-r">
	<p>立即使用</p>
	<span>使用期限：</span> <span><?php echo $this->_var['res']['start_time']; ?>-</span> <span>-<?php echo $this->_var['res']['end_time']; ?></span>
	 <span style=" border-top:1px dashed #ccc;">可用次数：<b style=" color:#F00;"><?php echo $this->_var['res']['remain_times']; ?></b></span>
	</div>
	</div>
	</a>
	</li><?php endif; ?>
	
	<?php if ($this->_var['res']['coupon_value'] >= "10" && $this->_var['res']['coupon_value'] < "30"): ?>
	<li><a href="/index.php?app=store&id=<?php echo $this->_var['res']['store_id']; ?>">
	<div class="user_hongbao-list" style=" border-color:#FF8A00;">
                   <div class="hongbao_list-l" style="background:#FF8A00;">
	<!-- <span class="hongbao_shopname">
	<?php echo $this->_var['res']['store_name']; ?> 
	</span> -->
	<span class="hongbao_shopname">
	倍全红包
	</span>
	<p><?php echo $this->_var['res']['coupon_value']; ?></p>
	<span class="hongbao_shuoming"> 满<?php echo $this->_var['res']['min_amount']; ?>元可使用<br /><?php echo $this->_var['res']['remark']; ?>(不含运费) </span></div>
	<div class="hongbao_list-r">
	<p>立即使用</p>
	<span>使用期限：</span> <span><?php echo $this->_var['res']['start_time']; ?>-</span> <span>-<?php echo $this->_var['res']['end_time']; ?></span>
    <span style=" border-top:1px dashed #ccc;">可用次数：<b style=" color:#F00;"><?php echo $this->_var['res']['remain_times']; ?></b></span>
	</div>
	</div>
	</a>
	</li><?php endif; ?>

	
	<?php if ($this->_var['res']['coupon_value'] >= "30" && $this->_var['res']['coupon_value'] < "50"): ?>
	<li><a href="/index.php?app=store&id=<?php echo $this->_var['res']['store_id']; ?>">
	 <div class="user_hongbao-list" style=" border-color:#6FCE36;">
                   <div class="hongbao_list-l" style="background:#6FCE36;">
	<!-- <span class="hongbao_shopname">
	<?php echo $this->_var['res']['store_name']; ?> 
	</span> -->
	<span class="hongbao_shopname">
	倍全红包
	</span>
	<p><?php echo $this->_var['res']['coupon_value']; ?></p>
	<span class="hongbao_shuoming"> 满<?php echo $this->_var['res']['min_amount']; ?>元可使用<br /><?php echo $this->_var['res']['remark']; ?>(不含运费) </span></div>
	<div class="hongbao_list-r">
	<p>立即使用</p>
	<span>使用期限：</span> <span><?php echo $this->_var['res']['start_time']; ?>-</span> <span>-<?php echo $this->_var['res']['end_time']; ?></span>
    <span>使用次数：</span> <span><?php echo $this->_var['res']['start_time']; ?>-</span> <span>-<?php echo $this->_var['res']['end_time']; ?></span>
	</div>
	</div>
	</a>
	</li><?php endif; ?>
	<?php if ($this->_var['res']['coupon_value'] >= "50"): ?>
	<li><a href="/index.php?app=store&id=<?php echo $this->_var['res']['store_id']; ?>">
	
	
	 <div class="user_hongbao-list" style=" border-color:#03A2D6;">
                   <div class="hongbao_list-l" style="background:#03A2D6;">
	<!-- <span class="hongbao_shopname">
	<?php echo $this->_var['res']['store_name']; ?> 
	</span> -->
	<span class="hongbao_shopname">
	倍全红包
	</span>
	<p><?php echo $this->_var['res']['coupon_value']; ?></p>
	<span class="hongbao_shuoming"> 满<?php echo $this->_var['res']['min_amount']; ?>元可使用<br /><?php echo $this->_var['res']['remark']; ?>(不含运费) </span></div>
	<div class="hongbao_list-r">
	<p>立即使用</p>
	<span>使用期限：</span> <span><?php echo $this->_var['res']['start_time']; ?>-</span> <span>-<?php echo $this->_var['res']['end_time']; ?></span>
	 <span style=" border-top:1px dashed #ccc;">可用次数：<b style=" color:#F00;"><?php echo $this->_var['res']['remain_times']; ?></b></span>
	</div>
	</div>
	</a>
	</li><?php endif; ?>
</ul>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php else: ?>

           <div class="cart_empty-top">
              <p>
               <span class="cart_empty-topicon"></span>客官您暂时没有红包，快去领取~~
              </p>
           </div>
             
           <div class="bq_cplb_bg"  style="margin-top: -4px;"></div>
        <div class="cart_empty-info">
             <div class="cart_empty-img">
                <img src="themes/bqmart/template/images/cart/bq_hongbao_empty.png" > </div>
             <p>
             您暂时没有红包，查看最新活动！
             </p>
             <div class="cart_empty-btn">
                 <a type="button"  href="<?php echo url('app=default'); ?>">去 逛 逛</a>
             </div>
        </div>  
<?php endif; ?>


</div>

</div>
</div>
</div>
</div>

</body>
</html>
