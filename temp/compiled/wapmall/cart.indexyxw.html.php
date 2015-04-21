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
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.spinner.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/cart/jquery.inputbox.js'; ?>"></script>
        
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>
		 <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
		  wx.config({
			//debug: true,
			appId: '<?php echo $this->_var['signPackage']['appId']; ?>',
			timestamp: <?php echo $this->_var['signPackage']['timestamp']; ?>,
			nonceStr: '<?php echo $this->_var['signPackage']['nonceStr']; ?>',
			signature: '<?php echo $this->_var['signPackage']['signature']; ?>',
			jsApiList: [
			  'onMenuShareTimeline',
			  'onMenuShareAppMessage',
			  'scanQRCode',
			  'showAllNonBaseMenuItem'
			]
		  });
		  
		   wx.ready(function () {
		  
		   wx.showAllNonBaseMenuItem();

              document.getElementById('scanQRCode1').onclick = function () {
			 
				wx.scanQRCode({
				needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				success: function (res) {
				var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
				result=result.substr(result.indexOf(",")+1); 
				window.location.href="/index.php?app=bqajax&act=to_shop&sku="+result;
				
			}
			});
			  };
		   });
		   
  </script>
  <style>
  .com-header-sao{
   background-position: 0 -149px;
    height: 28px;
    margin: 6px 40px 10px;
    position: absolute;
    right: 0;
    top: 0;
    width: 35px;}
  </style>
    </head>
    <body>
	  
        <div class="com-content"> 					
        
        <div class="com-header-area" id="js-com-header-area">
          <a href="" class="com-header-retun" style="background:url();"  id="scanQRCode1">
		  <img width="50px" height="36px" src="/static/images/saosao.png" style="margin-left: -17px;"/>
		  </a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;margin-top: 8px;">点击左侧"扫一扫"购物</span>
         
		  <a href="/index.php?app=default&act=cover" class="com-header-shop "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
         
        
        <script>
         /*是否下线*/
         var isDown = false;
        </script>
        
	    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.touchslider.min.js'; ?>"></script>
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/good/index.js'; ?>"></script>	
        <div class="pxui-area">
        
        
        <?php $_from = $this->_var['carts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('store_id', 'cart');if (count($_from)):
    foreach ($_from AS $this->_var['store_id'] => $this->_var['cart']):
?>
        <div class="bq_cat-box" id="js-attrs-title" >
          
           
           <div class="bq_cart-center">

             
             <div class="bq_cart_shop1">
               <div  class="bq_cart_shoptitle">
                 <a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>"><h4>店铺名：<?php echo htmlspecialchars($this->_var['cart']['store_name']); ?></h4></a>
                 <div class="cart_shoptitle_r">
                  <span><php></php>满<?php echo $this->_var['cart']['shipping']; ?>元包邮<b style="color:#E88103">~~</b></span>
                  <i class="bq_cart_icon"></i>
                  </div>
                </div>
                
          <div class="bq_cart-top">
            
            <p style="margin-left:6px;" >共计 <b id="p_count_<?php echo $this->_var['store_id']; ?>"> <?php echo $this->_var['cart']['quantity']; ?> </b> 件商品
            <div class="bq_cart_jiesuan"><a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>">继续购物</a></div>
           </div>
           
             
              <div class="bq_cart_goodlist">
                <ul>
                <?php $_from = $this->_var['cart']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                  <li class="clearfix" id="cart_item_<?php echo $this->_var['goods']['rec_id']; ?>">
                    <a style=" border-right:none; float:none; margin-left:0px;" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['goods']['goods_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p style="line-height:22px; margin-bottom:5px;" class="proName"><a style=" border-right:none; float:none; margin-left:0px; border-bottom:none;" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span style="display:block;" class="proPrice">倍全价：<?php echo price_format($this->_var['goods']['price']); ?></span>                 <!-- <span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>2.5</del></span> -->
                      <span style="position:absolute; right:4%; bottom:10%;" gid="<?php echo $this->_var['goods']['spec_id']; ?>" qa="<?php echo $this->_var['goods']['quantity']; ?>" sid="<?php echo $this->_var['store_id']; ?>" class="yxw">
                       <input type="text" class="spinnerExample"/></span>
                      </span>
                     
                      <div class="bq_cart_del"><a href="javascript:void(0);" onclick="drop_cart_itemyxw(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>);" >&nbsp;</a></div>
                  </div>
                 </li>     
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>           
                </ul>
               </div>
               
               <div class="fixed_add_to_cart" style="display:block;">
		            <div style=" text-align:right; position:relative; box-shadow:0 1px 5px #999;">
		             	<!--<a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>"><input type="button" class="pxui-light-button addtocart" style="background:#FFF; border-color:#D9D6D1; color:#63625D;" value="继续购物"/></a>&nbsp;&nbsp;-->
		             	<a href="<?php echo url('app=order&goods=cart&store_id=' . $this->_var['store_id']. ''); ?>"><input type="button" class="pxui-light-button addtocart" style="background:#F50000;" value="立即结算"/></a>
		             	<p>
		             		合计(不含运费): <strong id='cart<?php echo $this->_var['store_id']; ?>_amount' style="color:#E50303;"><?php echo price_format($this->_var['cart']['amount']); ?></strong>
		             	</p>
		            </div>
        	   </div>
               
               
             </div>

             
             
           </div>
           
           
        </div>	
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
        
        
       	<!--  猜你喜欢产品循环列表开始 
	    <div class="content-box">
		   <div class="content-box-category" style="padding:5px 0px 5px 25px;; background:#E0EAF2;">
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
	    猜你喜欢产品循环列表结束 -->
        <!-- 猜你喜欢模块js控制开始
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
       猜你喜欢模块js控制 end-->
         			
         <!-- <div class="fixed-add-to-cart" id="js-fixed-add-to-cart" style="z-index:9999">
            <div style=" text-align:right; position:relative;">
             <a href="default.htm"><input type="button" class="pxui-light-button addtocart" style="background:#FFF; border-color:#D9D6D1; color:#63625D;" value="继续购物"/></a>&nbsp;&nbsp;
             <a href="make_order.htm"><input type="button" class="pxui-light-button addtocart" style="background:#F50000;" value="立即结算"/></a>
             <p>商品总价:￥999</p>
            </div>
        </div> -->
    </div>
</div>
		</div>
        
      
        <?php echo $this->fetch('member.footer.html'); ?>

</div>

       <div class="bq_manu  home-page ">
        <div style="position: fixed; bottom:0px; width:100%; z-index:999;"> 
          <div class="pxui-tab pxui-tab-nav pxui-tab-no-top">
           <a  href="/"><i></i>首&nbsp;页<span></span></a>
          <a href="index.php?app=search"><i></i>搜&nbsp;索<span></span></a>
          <a href="<?php echo url('app=cart'); ?>" class="selected"><i></i><b class="bq_cart-manu_bg" id="yxwcart">2</b>购物车<span></span></a>
          <a href="<?php echo url('app=member'); ?>"><i></i>我&nbsp;的<span></span></a>
          </div>
        </div>
        </div>
       
</body>

<script type="text/javascript">
$(".yxw").each(function(index, element) {
	var qa=$(this).attr("qa");
    $(this).children('.spinnerExample').spinner({value:qa,min:1});
});


</script>



<script type="text/javascript">
$(function(){

	$('div[name="city"]').inputbox({
		height:24,
		width:100
	});
	
	$('.cbt').inputbox();
	
	$('[name="rbt"], [name="rbt2"]').inputbox();

});

function drop_cart_itemyxw(store_id, rec_id){
    var tr = $('#cart_item_' + rec_id);
    var amount_span = $('#cart' + store_id + '_amount');
    var cart_goods_kinds = $('#p_count_'+ store_id);
    $.getJSON('index.php?app=cart&act=drop&rec_id=' + rec_id, function(result){
        if(result.done){
            //删除成功
            if(result.retval.cart.quantity == 0){
                window.location.reload();    //刷新
            }
            else{
                tr.remove();        //移除
                amount_span.html(price_format(result.retval.amount));  //刷新总费用
                cart_goods_kinds.html(result.retval.cart.quantity);       //刷新商品种类
				if($("#yxwcart").length)
				{
				  $("#yxwcart").text(result.retval.totalcount);
				}
				
				// psmb
				//$(".J_C_T_GoodsKinds").html(result.retval.cart.kinds);
			   // $(".J_C_T_Amount").html(price_format(result.retval.amount));
				//$("#cart_goods"+rec_id).remove();
				// end
            }
        }
    });
}
</script>

</html>
