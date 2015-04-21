<!doctype html>
<html>
    <head>
        <title>倍全商城-购物车</title>
        <meta charset="utf-8">
        <meta name="keywords" content="倍全,倍全商城,倍全订货,社区O2O,社区便利店,网上超市,济南社区020,便利店O2O,济南社区便利店" />
        <meta name="description" content="倍全商城-倍全旗下品牌，济南同城最快速的便利店商品订购派送网站" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1" id="viewport" name="viewport" />
        
        <meta content="yes" name="apple-mobile-web-app-capable" />
        
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        
        <meta content="telephone=no" name="format-detection" />
        
        <!--<link rel="/touch/apple-touch-startup-image" href="startup.png" />-->
        
        <!--<link rel="apple-touch-icon" href="/touch/iphon_tetris_icon.png"/>-->
		<link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>"/> 
        
		<link href="/themes/bqmart/style/zq_goods.css" type="text/css" rel="stylesheet"/>
		<link href="/themes/bqmart/style/zq_change_location.css" type="text/css" rel="stylesheet"/>
		<link href="/themes/bqmart/style/zq_details.css" type="text/css" rel="stylesheet"/>
		<script src="/themes/bqmart/js/zq_jquery.min.js" type="text/javascript"></script>
		<script src="/themes/bqmart/js/jquery.lazyload.min.js" type="text/javascript"></script>
		<script src="/themes/bqmart/js/tools.js" type="text/javascript"></script>
		<script type="text/javascript" src="/includes/libraries/javascript/ecmall.js" charset="utf-8"></script>
	   <script src="/themes/bqmart/js/zq_fly.js" type="text/javascript"></script>
		<script src="/themes/bqmart/js/zq_index.js" type="text/javascript"></script>
		<script src="/themes/bqmart/js/le_cart.js" type="text/javascript"></script>
     <script src="/themes/bqmart/js/zq_requestAnimationFrame.js" type="text/javascript"></script>


    </head>
    <body>
        <div class="com-content" style="background:none repeat scroll 0 0 rgba(0, 0, 0, 0); box-shadow: none;"> 					
        
        <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="/index.php?app=storeyxw&status=1&id=<?php echo $this->_var['store_id']; ?>" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">购物车</span>

		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
        
        
        <div class="pxui-area">
        
        
        <?php $_from = $this->_var['carts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('store_id', 'cart');if (count($_from)):
    foreach ($_from AS $this->_var['store_id'] => $this->_var['cart']):
?>
        <div class="bq_cat-box" id="js-attrs-title" >
          
           
           <div class="bq_cart-center">

             
             <div class="bq_cart_shop1">
               <!--<div  class="bq_cart_shoptitle">
                 <a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>"><h4>店铺名：<?php echo htmlspecialchars($this->_var['cart']['store_name']); ?></h4></a>
                 <div class="cart_shoptitle_r">
                  <span><php></php>满<?php echo $this->_var['cart']['shipping']; ?>元包邮<b style="color:#E88103">~~</b></span>
                  <i class="bq_cart_icon"></i>
                  </div>
                </div>-->
                
          <!--<div class="bq_cart-top">
            
            <p style="margin-left:6px;" >共计 <b id="p_count_<?php echo $this->_var['store_id']; ?>"> <?php echo $this->_var['cart']['quantity']; ?> </b> 件商品
            <div class="bq_cart_jiesuan"><a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>">继续购物</a></div>
           </div>-->
           
             
              <div class="bq_cart_goodlist">
                <ul>
                <?php $_from = $this->_var['cart']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                  <li class="clearfix yxwshow" id="cart_item_<?php echo $this->_var['goods']['rec_id']; ?>">
                  <img src="<?php echo $this->_var['goods']['goods_image']; ?>"  >
                   <div class="zxProInfo" style="line-height:22px;margin-top: 27px;" >
                      <p style="line-height:22px; margin-bottom:5px;" class="proName"><a style=" border-right:none; float:none; margin-left:0px; border-bottom:none;" onclick="return false;"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span style="display:block;" class="proPrice">商城价：<?php echo price_format($this->_var['goods']['price']); ?></span>                
      <div><span style="text-decoration:line-through; color:#999">市场价<?php echo $this->_var['goods']['shichang']; ?>元</span></div>
                     <div class="s_op">
					 <input type="hidden" class="s1" value="<?php echo $this->_var['goods']['store_id']; ?>" rid="<?php echo $this->_var['goods']['rec_id']; ?>" />
					 <input type="hidden" class="s2" value="<?php echo $this->_var['goods']['spec_id']; ?>" />
					 <div style="float: left; display: block;" class="op1">-</div> <div id="spec_<?php echo $this->_var['goods']['spec_id']; ?>" style="font-size: 18px; float: left; display: block;margin-top: 10px;" class="s_num"><?php echo $this->_var['goods']['quantity']; ?></div><div style="float: right; color: red;" class="op2">+</div>
					 </div>
                  </div>
                 </li>     
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>           
                </ul>
               </div>
               
             </div>

             
             
           </div>
           
           
        </div>	
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
        
    </div>
</div>
		</div>
        
      
      <?php echo $this->fetch('footer.html'); ?>

</div>
</body>

<script type="text/javascript">
peisong(<?php echo $this->_var['cart']['quantity']; ?>);
//加
$(".op2").on('click', cartjia);
//减
 $(".op1").on('click', cartjian);
 
 $(document).ready(function(){

 $(".f_bg").unbind("click").bind("click",dianji);
 $(".yxwshow .op2").on('click', addProduct);
 });
   //点击购物车
	  function dianji()
	  {
	     if($("#f_num").html()>=1){
		 window.location.href="/index.php?app=order&goods=cart&store_id=<?php echo $this->_var['store_id']; ?>";
		 }
		  
	  }
</script>
</html>
