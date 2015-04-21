<!doctype html>
<html>
    <head>
        <title>倍全商城-确认订单信息页</title>
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
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/cart/jquery.inputbox.js'; ?>"></script>
        
         <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
         
         <link href="/themes/bqmart/style/zq_order.css" type="text/css" rel="stylesheet"/>
         <script src="/themes/bqmart/js/zq_order.js" type="text/javascript"></script>
</head>
<body>
<div class="com-content">

  <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="/index.php?app=cart" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">结算付款</span>
        
		  <div class="clear"></div>
        </div>


  <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
      
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />
       
        <script>
         /*是否下线*/
         var isDown = false;
        </script>
        
	<script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.touchslider.min.js'; ?>"></script>
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/good/index.js'; ?>"></script>
<script>
    jQuery(document).ready(function ($) {
        $(".touchslider").touchSlider({mouseTouch: true, autoplay: true});
 
       qidongd();

    });

    function qidongd() {

       // alert(1);
            that = $(".yxwspan").get(0);
            $(that).children("input:first").attr("checked", true);
           
             shipid= $(that).children("input:first").val();
	   $("#shipping_id").val(shipid);
			 var totalcount=<?php echo $this->_var['goods_info']['amount']; ?>;
		var url="/index.php?app=order&act=shipping&store_id=<?php echo $_GET['store_id']; ?>&shipping_id="+shipid;
		 $.getJSON(url,'',function(data){
				  if(data.done)
				 {
					 if(data.retval.result==0)
					 {
						 alert("请陛下填写并选择收货地址！！");
						 window.location.href="/index.php?app=address&act=list_address&store_id=<?php echo $_GET['store_id']; ?>";
					 }else
					 {
						//totalcount=totalcount-data.retval.amount;
						//alert(totalcount);
						 $("#gxzf").html(price_format(data.retval.total))
						 $("#yunfei").html(price_format(data.retval.amount))
						  $("#yfje").html(price_format(data.retval.total))
						  $("#hongbao").html(price_format(data.retval.coupon))
					 }
					 
				 }else
				 {
					 alert("此红包不符合使用条件！！");
				 }
		 });
    }
</script>	
<form method="post" id="order_form"  onSubmit="return checkForm( )">
    <div class="pxui-area">
        <div class="bq_makeorder-box" id="js-attrs-title">
           

           <?php if ($this->_var['address_info'] > 0): ?>
           <div class="makeorder_shdz-info">
		      <a onclick="return false;">
                <span class="text"><?php echo htmlspecialchars($this->_var['address_info']['consignee']); ?> 
                   <span style="margin-left:5px;" class="phone-num">
                     <?php echo $this->_var['address_info']['phone_mob']; ?>
                   </span>
                </span>
                <span class="text2">
                <?php echo htmlspecialchars($this->_var['address_info']['region_name']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($this->_var['address_info']['address']); ?>
                </span>              </a>
            </div>
           <?php else: ?>
           
           <div class="makeorder_shdz-add">
		      <a class="makeorder_btn-addr" style="color:#e4393c;" href="index.php?app=address&act=add_address&store_id=<?php echo $_GET['store_id']; ?>">+添加收货地址</a>
           </div>
           
           <?php endif; ?>
           
           
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid;"></div> 
            
            
           <div class="makeorder_spqd-title" style="display:none;">
            <p>本次所购商品清单</p>
            <!-- <span class="makeorder_spqd-anniu"><a href="index.php?app=store&id=<?php echo $_GET['store_id']; ?>">去 凑 单</a></span> -->
           </div>
           <div class="makeorder_spqd-info">
              <div class="bq_goods_cx pxui-list" data-model="radio">
              <a style="border-top:none; display:none;"> 
              <i class="goods_sx_icon"></i>
                <div class="goods_spqd-number">
                   共计 <b><?php echo $this->_var['totalcount']; ?></b> 件商品
                 </div>
               <span class="makeorder_chakan">点击查看</span>
               <i class="goods_anjian"></i></a>
               
               <div class="pxui-list-con" style="display:block; background:none; border:none;">
                 <ul>
                   <?php $_from = $this->_var['goods_info']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                   <li>
                       <span class="makeorder_goods-list" style="position:relative;">
                      		<div style="float:left;">
                       			<img src="<?php echo $this->_var['goods']['goods_image']; ?>" width="90" height="90"/>
                            </div>
                            <div style="float:left; ">
                       			<a  href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style="overflow:hidden;text-overflow: ellipsis;white-space: nowrap;width: 200px;">
                                  <?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a> 
                                <div style="margin-top:15px; ">
                            			&nbsp;&nbsp;单价：<?php echo price_format($this->_var['goods']['price']); ?>&nbsp;&nbsp;&nbsp;&nbsp;数量：<?php echo $this->_var['goods']['quantity']; ?>件			                               
                          
                             			<span style="position:absolute; right:10px; top:80px;" > &nbsp;&nbsp;&nbsp;小计：<strong><?php echo price_format($this->_var['goods']['subtotal']); ?></strong></span>       
                           		 </div>
                            </div>
                       </span>
                   </li>
                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                 </ul>
                  
               </div>  
        	 </div>   
           </div>
            
           
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid; margin-top:-13px;"></div> 
            
           <div class="makeorder_spqd-title" style="display:none;">
            <p>是否使用红包？</p>
           </div>
           <div class="makeorder_spqd-info">
              <div class="bq_goods_cx pxui-list" data-model="radio"><a class="link" style="border-top:none;  height: 34px;"> 
              <i class="goods_hb_icon" style="background-image:none;"><img src="<?php if ($this->_var['coupon_count'] > 0): ?>themes/bqmart/images/icon2.png<?php else: ?>themes/bqmart/images/icon.png <?php endif; ?>" width="45"/></i>
                <div class="goods_spqd-number" style="border:none; margin-left:50px;">
                   您有 <?php echo $this->_var['coupon_count']; ?> 个红包
                 </div>
               <span class="makeorder_chakan" id="coupon_yxw" val="" style="display:none;">立即使用</span>
               
               <i class="goods_anjian down" style="display:block; background-position:0px 0px;background-size:12px 12px;background-repeat:no-repeat;position:absolute; top:27px;height: 40px;"></i>
               </a>
               
               <div class="pxui-list-con makeorder_hb-box" style="display:none; background-color:#fff;height:auto; padding-left:0px; width:100%; ">
               	  <div class="zq_input" style="width:100%; margin-top:10px;  height: 65px;
  border-bottom: 1px solid #cfcfcf;">
                    	<input class="zq_input"  id="hongbaosn" type="text" value="请输入红包编号" style="width:75%; height:30px; border-radius:7px 7px 7x 7px;margin-right:10px; border:thin solid #999; float:left"/>
                        <input type="button" value="激活" id="jihuo1"  onclick="jihuoyxw();" style="width:13%; height:40px; margin-right:3%; margin-left:0px; background-color:#FB8C08; float:right; border-radius:10px 10px 10px 10px; color:#FFF;background-image: none;"/>
                    </div>
				   <div class="nav" id="nav" style="width:97%;margin:10px 0px 10px ; height:auto; " >
	                  <p class="set" style="width:97%; color:#666; border:thin solid #F00; border-width:0px 0px 0px 0px;   display: none;">请选择您本次要使用的红包</p>
                          <ul class="new" style="width:100%; display:block; border-width:0px 0px 0px 0px;  position:relative;" >  
                            <?php $_from = $this->_var['coupon_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');if (count($_from)):
    foreach ($_from AS $this->_var['coupon']):
?> 
                            <li style="display:block; margin-top:8px; background-color:#fff; color:black; border-width:1px 0px 1px 0px;  border-bottom: 1px solid #cfcfcf; " val="<?php echo $this->_var['coupon']['coupon_sn']; ?>">
							<span style="">￥<?php echo $this->_var['coupon']['coupon_value']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style=""><?php echo $this->_var['coupon']['coupon_name']; ?>--满<?php echo $this->_var['coupon']['min_amount']; ?>可使用<?php echo $this->_var['coupon']['coupon_value']; ?></span>
                            	 <span style="width:15px; height:15px; border:thin solid #CCC;float:right; margin-top:8px; margin-right:6px;display: none;">
                            		<img class="zq_img"  src="themes/bqmart/images/duihao2.jpg" width="13px" height="13px" style="display:none;">
                           		 </span>
                            </li>                                              
                            <?php endforeach; else: ?>                              
                              <li style="display:block; margin-top:8px; background-color:#fff; color:black; border-width:1px 0px 1px 0px;  border-bottom: 1px solid #cfcfcf;">暂无可用红包</li>
                             <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          </ul>                      
                   </div>
               
               </div>  
        	 </div>   
           </div>
           

		   
                    
         </div> 
         
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid; "></div>
           
           
            <div class="makeorder_psfs-title" style="display:none;">
            <p>请选择配送方式</p>
           </div>
           <div class="makeorder_psfs-info">
              <div class="psfs_box">
               <?php $_from = $this->_var['shipping_methods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
    
                <span class="text yxwspan" style="margin-top:5px;" onclick=" payclick(this)">
                    <input type="radio" name="shipping" class="psfs_btn"  value="<?php echo $this->_var['shipping']['shipping_id']; ?>" />
                   <span style="margin-left:20px;" class="phone-num">
                     <?php echo $this->_var['shipping']['shipping_name']; ?>
                    </span>
                    <span class="makeorder_yfsm" style="display:none;"><b>配送区域：</b> <?php echo $this->_var['shipping']['cod_regions']; ?></span>
                </span><br/>
                   <?php endforeach; else: ?>
                   <span class="text" style="margin-top:5px;"><span style="margin-left:20px;" class="phone-num">
                   抱歉，您所填写的收货地址不在配送区域！！ </span>  </span>
              <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>            
              </div>
            </div>
           
		     
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid; "></div>
            
			
            <div  class="order_money-info" style="position:relative; left:-60px; ">
             	<div class="order_money-left" style=" font-size:16px; margin-left:10px;  width:300px; height:90px;">
                   <dl>
                       <dt>商品金额：</dt>
                        <span class="order_total_view price"><?php echo price_format($this->_var['goods_info']['amount']); ?></span>
                   </dl>
                   <dl style="position:relative; top:10px;">
                      <dt>- 红&#12288;包：</dt>
                       <span class="order_total_view price" id="hongbao">￥0.0</span>
                   </dl>                     
                  <!--  <dt>- 积&#12288;分：</dt>
                   <span class="order_total_view price">￥0.0</span>
                   </dl>-->
                   <dl style="position:relative; top:19px;">
                      <dt>+ 运&#12288;费：</dt>
                        <span class="order_total_view price" id="yunfei">￥0.0</span>
                   </dl>
                    <span style="font-size:16px; float:right; position:absolute; right:-4%; top:70px;">共需支付
                   <span class="order_amount_view price" id="gxzf"><?php echo price_format($this->_var['goods_info']['amount']); ?></span>
				   <span  style="font-size:12px; font-weight:100; line-height: 18px;display: block; position:relative; top:5px;">代收快递免运费</span>
				   </span>                  
                </div>              
             </div>
            
            
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid; "></div> 
            
            <div class="zq_beizhu" style="width:99%;; height:60px;  margin-top:5px;padding-right:10px;  ">
             	<span style=" margin-top:10px; margin-left:10px;font-size:14px; float:left; width:9%">备注:</span>
                <input  class="zq_input" type="text" name="remark" value="请填写备注信息" style="width:80%; height:30px;border:thin solid #CCC; border-radius:7px 7px 7px 7px; float:left; color:#ccc;"/>
            </div>
             
            
           <div style="width:100%; height:4px; background-color:#ECEDF1; border-top:#D0CCCB thin solid;border-bottom:#D0CCCB thin solid; "></div> 
        	     
           	
             <div class="zq_zhifu" style="width:100%; height:100px; margin-bottom:15px; margin-top:10px; ">
             	<ul>
				<?php $_from = $this->_var['wappayments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
				   <?php if ($this->_var['payment']['payment_code'] == 100): ?>
                	
                	<li class="zq_payment" style="position:relative; margin-left: 8px;">
                    	<input name="payment" type="radio" value="<?php echo $this->_var['payment']['payment_code']; ?>" id="pid_<?php echo $this->_var['payment']['payment_code']; ?>" style="display:none;">
                        <div style=" left:21px; width:93%; height:34px; border-bottom:dotted thin #999;" >
                        	<img src="themes/bqmart/images/3.png" width="30" height="30"/>&nbsp;&nbsp;
                            <span style="position:relative; top:-8px; font-size:16px;"><?php echo $this->_var['payment']['payment_name']; ?></span>
                            <span style="width:15px; height:15px; border:thin solid #CCC;float:right; margin-top:8px;">
                            	<img class="zq_img" src="themes/bqmart/images/duihao2.jpg" width="13px" height="13px" style="display:none;">
                            </span> 
                        </div>
                    </li>
					<?php elseif ($this->_var['payment']['payment_code'] == 6): ?>
                    
                    <li class="zq_payment"  style="position:relative; margin-left: 8px;">
                    	<input name="payment" type="radio" value="<?php echo $this->_var['payment']['payment_code']; ?>" id="pid_<?php echo $this->_var['payment']['payment_code']; ?>"  style="display:none;">
                        <div  style=" left:21px;  width:93%;height:34px; border-bottom:dotted thin #999;">
                        	<img src="themes/bqmart/images/zhi1.png" width="32" height="29"/>
                            &nbsp;&nbsp;
                            <span style="position:relative; top:-8px;  font-size:16px;"><?php echo $this->_var['payment']['payment_name']; ?></span>
                            <span style="width:15px; height:15px; border:thin solid #CCC;float:right; margin-top:8px;">
                            	<img class="zq_img" src="themes/bqmart/images/duihao2.jpg" width="13px" height="13px" style="display:none;">
                            </span> 
                        </div>
                    </li>
					<?php elseif ($this->_var['payment']['payment_code'] == 5): ?>
                    
                    <li class="zq_payment"  style="position:relative; margin-left: 8px;">
                    	<input name="payment" type="radio" value="<?php echo $this->_var['payment']['payment_code']; ?>" id="pid_<?php echo $this->_var['payment']['payment_code']; ?>"  style="display:none;">
                        <div style=" left:21px;width:93%;height:34px;border-bottom:dotted thin #999;">
                        	<img src="themes/bqmart/images/2.png" width="33" height="30"/>&nbsp;&nbsp;
                            <span style="position:relative; top:-8px;  font-size:16px;"><?php echo $this->_var['payment']['payment_name']; ?></span>
                            <span style="width:15px; height:15px; border:thin solid #CCC;float:right; margin-top:8px;">
                            	<img class="zq_img"  src="themes/bqmart/images/duihao2.jpg" width="13px" height="13px" style="display:none;">
                            </span> 
                        </div>
                    </li>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
             	
             </div>
             
              
           <div class="make_order-moneybox">
             <span class="order_money-ht"></span>          
             <span class="make_order-bgborder"><span class="make_order-bgicon"></span></span>
             <div class="make_order-submit" style="margin-top:60px;">
                 <input type="submit"  class="make_order-sbbtn" style="border:none;background: #FB8C08;text-shadow: none;" value="提交订单">
             </div>
           </div>
                      
         </div>        
    </div>
    <input type="hidden" id="addressid" value="<?php echo $this->_var['address_info']['addr_id']; ?>" name="addressid"/>
     <input type="hidden" id="coupon_sn" value="" name="coupon_sn"/>
     <input type="hidden" id="shipping_id" value="" name="shipping_id"/>
    </form>
 <script language="javascript">
     function payclick(that) {
      // alert($(that).html());
         $(that).children("input:first").attr("checked", true);
         $(that).children("input:first").get(0).click();
    }
           </script>                   
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
	//$(".nav p").click(function(){
//		var ul=$(".new");
//		if(ul.css("display")=="none"){
//			ul.slideDown();
//		}else{
//			ul.slideUp();
//		}
//	});	
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
	$("input[name='shipping']").click(function(e) {
       shipid= $(this).val();
	   $("#shipping_id").val(shipid);
			 var totalcount=<?php echo $this->_var['goods_info']['amount']; ?>;
		var url="/index.php?app=order&act=shipping&store_id=<?php echo $_GET['store_id']; ?>&shipping_id="+shipid;
		 $.getJSON(url,'',function(data){
				  if(data.done)
				 {
					 if(data.retval.result==0)
					 {
						 alert("此配送方式不符合使用条件！！");
					 }else
					 {
						//totalcount=totalcount-data.retval.amount;
						//alert(totalcount);
						 $("#gxzf").html(price_format(data.retval.total))
						 $("#yunfei").html(price_format(data.retval.amount))
						  $("#yfje").html(price_format(data.retval.total))
						  $("#hongbao").html(price_format(data.retval.coupon))
					 }
					 
				 }else
				 {
					 alert("此配送方式不符合使用条件！！");
				 }
		 });
    });
	
	$(".nav li").click(function(){
		var li=$(this).text();
		   $("#coupon_yxw").attr("val",$(this).attr("val"));
           jiaqian();
		$(".nav p").html(li);
		
		/*$(".set").css({background:'none'});*/
		$("p").removeClass("select") ;   
		$(".nav li").css("background","#fff");
		$(this).css("background","#cfcfcf");
	});
})
    function jihuoyxw()
	{
	 
	   $("#coupon_yxw").attr("val",$("#hongbaosn").val());
	   jiaqian();
	}
	function  jiaqian(){
	    
		 var couponid=$("#coupon_yxw").attr("val");
		
		 if(couponid.length==0)
		 {
			 if($(".nav li").length==0)
			 {
				 alert("没有可以使用的红包！");
			 }else{
				 alert("请选择红包！");
				 }
			 
		 }else{
			 var totalcount=<?php echo $this->_var['goods_info']['amount']; ?>;
		var url="/index.php?app=order&act=coupon&store_id=<?php echo $_GET['store_id']; ?>&coupon_id="+couponid;
		 $.getJSON(url,'',function(data){
				 if(data.done)
				 {
					 if(data.retval.result==0)
					 {
                     if(data.retval.status=3){
						 alert(data.msg);}
                         else{
                         alert("此红包不符合使用限制条件");
                         }
					 }else
					 {
						//totalcount=totalcount-data.retval.amount;
						//alert(totalcount);
						 $("#gxzf").html(price_format(data.retval.total))
						 $("#hongbao").html(price_format(data.retval.amount))
						  $("#yfje").html(price_format(data.retval.total))
						   $("#yunfei").html(price_format(data.retval.shipping))
						   $("#coupon_sn").val(data.retval.coupon_sn);
						   alert("恭喜陛下，已使用"+data.retval.amount+" 元红包");
					 }
					 
				 }else
				 {
					 alert("此红包不符合使用条件！！");
				 }			 
			});
		 }		 
		 }
</script>


</html>
