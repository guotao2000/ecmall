<!doctype html>
<html>
    <head>
        <title>倍全商城-订单详情</title>
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
        
</head>
<body>
<div class="com-content" style="box-shadow:none;">

  <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">订单详情</span>

		  <div class="clear"></div>
        </div>


  <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
      
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />

    <div class="pxui-area">
        <div class="bq_makeorder-box" id="js-attrs-title">
           
            <div class="makeorder_spqd-title">
            <p>商品信息</p>
            <span class="usereorder_spqd-anniu"><a href="index.php?app=storeyxw&id=<?php echo htmlspecialchars($this->_var['order']['store_id']); ?>&status=1" style="color:#6C6C6C;">继续购物</a></span>
           </div>
           <div class="makeorder_spqd-info userorder_spqd-info">
              <div class="bq_goods_cx pxui-list" data-model="radio">
              <a style="border-top:none;"> 
              <i class="goods_sx_icon"></i>
                <div class="goods_spqd-number">
                   共计 <?php echo htmlspecialchars($this->_var['goods_quantity']); ?> 件商品
                 </div>
               <span class="makeorder_chakan">点击查看</span>
               <i class="goods_anjian"></i></a>
               <div class="user_orderlist-info" style="display:none;">
                 <ul>
                 <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                 <li>
                   <img src="<?php echo $this->_var['goods']['goods_image']; ?>">
                   <div class="orderlist_Pre-info">
                     <p class="orderlist_Pre-name" style=" max-height:40px;">
                       <?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>
                     </p>
                     <span class="orderlist_Pre-price">价格：&nbsp;&nbsp;<?php echo price_format($this->_var['goods']['price']); ?></span>
                     <span class="orderlist_Pre-number">数量：&nbsp;&nbsp;X&nbsp;&nbsp;  <?php echo $this->_var['goods']['quantity']; ?></span>
                   </div>
                 </li>
                 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                 </ul>
                  
               </div>  
         </div>   
           </div>
           
           

           <div class="userorder_ddzt-info">
              <p><span>订单状态：</span><b><?php if ($this->_var['order']['status'] == 11): ?>等待买家付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 12): ?>等待买家收货付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 13): ?>买家已付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 20): ?>等待卖家发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 21): ?>货到付款已发货<?php endif; ?>
						<?php if ($this->_var['order']['status'] == 25): ?>订单已确认<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 30): ?>卖家已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 40): ?>交易完成<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 0): ?>交易关闭<?php endif; ?> 
                        <?php if ($this->_var['order']['status'] == 51): ?>退货申请中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 52): ?>退货审核中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 53): ?>退货失败<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 54): ?>退货成功<?php endif; ?>  
                        </b></p>
              <p><span>订单号：</span><?php echo $this->_var['order']['order_sn']; ?></p>
              <p><span>下单时间：</span><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['order_add_time']); ?></p>
           </div>
           
           

           <div class="userorder_seller-info">
              <p><span>店铺名称：</span><b><?php echo htmlspecialchars($this->_var['order']['store_name']); ?></b></p>
              <p><span>店铺地址：</span><?php echo htmlspecialchars($this->_var['order']['region_name']); ?> </p>
              <p><span>店长电话：</span><a href=""><?php echo htmlspecialchars($this->_var['order']['tel']); ?></a></p>
           </div>
           
           
           <div class="userorder_buyer-title">
             <p>收货人信息</p>
           </div>
           <div class="userorder_buyer-info">
              <p><span>收货人：</span><b><?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?></b></p>
              <p><span>收货地址：</span><?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['address']); ?> </p>
              <p><span>手机号：</span><a href=""><?php echo $this->_var['order_extm']['phone_mob']; ?></a></p>
           </div>
           
           
           <div class="make_order-moneybox">
             <span class="order_money-ht"></span>
             <div  class="order_money-info">
             	<div class="order_money-left">
                   <dl>
                       <dt>商品金额：</dt>
                        <span class="order_total_view price"><?php echo price_format($this->_var['order']['goods_amount']); ?></span>
                   </dl>
                   <dl>
                   <dt>- 红&#12288;包：</dt>
                   <span class="order_total_view price"><?php echo price_format($this->_var['order']['discount']); ?></span>
                   </dl>
                   <!--<dl>
                   <dt>- 积&#12288;分：</dt>
                   <span class="order_total_view price">￥0.0</span>
                   </dl>-->
                   <dl>
                    <dt>+ 运&#12288;费：</dt>
                    <span class="order_total_view price"><?php echo price_format($this->_var['order_extm']['shipping_fee']); ?></span>
                    </dl>
                </div>
                <div class="order_money-left right">
                   <span style="font-size:16px;">实付金额<br>
                   <span class="order_amount_view price"><?php echo price_format($this->_var['order']['order_amount']); ?></span></span>
                </div>
             </div>
             <span class="make_order-bgborder"><span class="make_order-bgicon"></span></span>
             <div class="make_order-submit">
                 <a type="button"  class="make_order-sbbtn" href="index.php?app=storeyxw&id=<?php echo htmlspecialchars($this->_var['order']['store_id']); ?>&status=1"  style="color:#FFF;
background: #FB8C08;text-shadow:none;">继续购物</a>
             </div>
           </div>
                      
         </div>
    </div>
</div>
      


</div> 

</div>

</body>

<script type="text/javascript">
$(function(){

	$('div[name="city"]').inputbox({
		height:24,
		width:100
	});
	
	$('.cbt').inputbox();
	
	$('[name="rbt"], [name="rbt2"]').inputbox();

});
</script>


<script type="text/javascript">
$(function(){

	$(".nav p").click(function(){
		var ul=$(".new");
		if(ul.css("display")=="none"){
			ul.slideDown();
		}else{
			ul.slideUp();
		}
	});
	
	$(".set").click(function(){
		var _name = $(this).attr("name");
		if( $("[name="+_name+"]").length > 1 ){
			$("[name="+_name+"]").removeClass("select");
			$(this).addClass("select");
		} else {
			if( $(this).hasClass("select") ){
				$(this).removeClass("select");
			} else {
				$(this).addClass("select");
			}
		}
	});
	
	$(".nav li").click(function(){
		var li=$(this).text();
		$(".nav p").html(li);
		$(".new").hide();
		/*$(".set").css({background:'none'});*/
		$("p").removeClass("select") ;   
	});
})
</script>


</html>
