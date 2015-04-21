<!doctype html>
<html>
    <head>
        <title><?php echo $this->_var['goods']['goods_name']; ?>-倍全商城</title>
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
        <style> 
			.black_overlay{ 
            display: none; 
            position: absolute; 
            top: 0%; 
            left: 0%; 
            width: 100%; 
            height: 100%; 
            background-color:#E5E5E5; 
            z-index:1001; 
            -moz-opacity: 0.6; 
            opacity:.60; 
            filter: alpha(opacity=66); 
            } 
			.white_content { 
				display: none; 
				position: absolute;
				top:180px;
				left: 10%; 
				width: 80%;
				height:180px;
				background-color:#666666; 
				z-index:1002; 
				overflow: auto;
			} 
			.chaxunDiv{
				width:100%;
				height:100%;
				margin:0;
				padding:0;
				position:relative;
				}
			.chaxunDiv p{
				width:100%;
				height:35px;
				background: #363636;
				line-height:35px;
				text-indent:10px;
				color:#F0F0F0;
				}
			.chaxunDiv p span {
				color:#C9CECB;
				font-size:18px;
				display:block;
				width:50px;
				height:35px;
				text-align:center;
				position:absolute;
				top:0px;
				right:0px;
				text-indent:0px;
				}
			.chaxun_info{
				text-align:center;
				padding:13px 10px 15px;
				height:50px;
				line-height:50px;
				}
			.chaxun_info span{
				display:inline-block;
				width:45px;
				height:40px;
				background:url(themes/bqmart/images/ddchaxun_icon.png) center no-repeat;
				background-size:35px 30px;
				padding:2px;
				vertical-align:middle;
				}
			.chaxun_ht{
				margin:0px 16px;
				height:2px;
				background:#555555;
				border-radius:5px;
				}
			.chaxun_btn{
				height:20px;
				width:100%;
				text-align:center;
				}
		</style> 
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
       <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.spinner.js'; ?>"></script>
    
    </head>
    <body>
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-logo"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:33px; font-size:18px;"><?php echo $this->_var['goods']['goods_name']; ?></span>
          <a href="javascript:void(0)" class="com-header-home " onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" style="background-position:0 -42px; margin-top:8px;"><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
        <script type="text/javascript">
            //验证手机号函数
            function checkMobile(tel) {
                var reg = /^[1][3-9]\d{9}$/;
                if (reg.test(tel)) {
                    return true;
                } else {
                    return false;
                }
            }

            function shoujiclick() {
                if (!checkMobile($("#shouji").val())) {
                    alert("请输入正确手机号！");
                    return false;
                } else {
                $("#light").submit();
                }
            }
        
        </script>
       <form id="light" class="white_content" method="post" action="/index.php?app=buyer_once&act=shouji">
             <div class="chaxunDiv">
               <p>
               输入手机号查询订单
               <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><span>X</span></a>
               </p>
               <div class="chaxun_info">
                  <span></span>
                  <input  type="text" placeholder="请输入手机号" value="" name="shouji" id="shouji" style="border-width:0px;width:110px; padding:3px 8px; border-radius:5px;">
               </div>
               <div class="chaxun_ht"></div>
               <div class="chaxun_btn">
                 <input type="submit"  value="查询订单" style="padding:5px 15px; color:#5A5A5A; margin-top:15px;" onclick="return shoujiclick();">
               </div>
             </div>
       </form> 
      <div id="fade" class="black_overlay"></div> 
	 
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/techan.css'; ?>" />
       
        <script>
            /*是否下线*/
            var isDown = false;
        </script>
        
	<script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.touchslider.min.js'; ?>"></script>
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/good/index.js'; ?>"></script>
	<script>
    jQuery(function($) {
        $(".touchslider").touchSlider({mouseTouch: true, autoplay: true});
    });
	function to_shop(){
	    var quantity = $("#quantity").val();
	    if (quantity < 1) {
	        quantity = 1;
	    }
		if (quantity > 1) {
			alert('仅限购买一件!');
	        quantity = 1;
	    }
        var spec_id = <?php echo $this->_var['goods']['spec_id']; ?>;
	    var store_id =<?php echo $this->_var['goods']['store_id']; ?>;
	    var url = '/index.php?app=cart&act=to_shop&spec_id=' + spec_id + '&quantity=' + quantity + '&store_id=' + store_id;
	   $.getJSON(url, '', function (data) {
	        if (data.done) {
            
	       window.location.href = '/index.php?app=buyer_once&act=register&store_id=<?php echo $this->_var['store_id']; ?>';
	        }
	        else {
	            alert(data.msg);
	        }
	    });
	   
	}
    </script>	
   
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
	  'onMenuShareAppMessage'
    ]
  });
  wx.ready(function () {
	
	//分享到朋友圈
    wx.onMenuShareTimeline({
        title: "<?php if (strlen ( $this->_var['goods']['wxtitle'] ) > 1): ?><?php echo $this->_var['goods']['wxtitle']; ?><?php else: ?><?php echo $this->_var['goods']['goods_name']; ?><?php endif; ?>", // 分享标题
        link: "http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER['REQUEST_URI']; ?>", // 分享链接
        imgUrl:$(".yxwimg").eq(0).attr("src"), // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
			alert("分享成功！");
        }
    });

	//分享给朋友
	wx.onMenuShareAppMessage({
		title: '<?php if (strlen ( $this->_var['goods']['wxtitle'] ) > 1): ?><?php echo $this->_var['goods']['wxtitle']; ?><?php else: ?><?php echo $this->_var['goods']['goods_name']; ?><?php endif; ?>', // 分享标题
		desc: '<?php if (strlen ( $this->_var['goods']['wxdesc'] ) > 1): ?><?php echo $this->_var['goods']['wxdesc']; ?><?php else: ?><?php echo $this->_var['goods']['goods_name']; ?><?php endif; ?>', // 分享描述
		link: 'http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER['REQUEST_URI']; ?>', // 分享链接
		imgUrl: $(".yxwimg").eq(0).attr("src"), // 分享图标
		type: 'link', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () { 
			// 用户确认分享后执行的回调函数
			alert("分享成功！");
		}
	});

  });
</script>
    <div class="pxui-area">
        
		<div class="touchslider" id="js-attrs-title">
		   <div class="touchslider-viewport" style="height:240px;overflow:hidden">
            <div>
	            <?php $_from = $this->_var['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_image');$this->_foreach['fe_goods_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods_image']['total'] > 0):
    foreach ($_from AS $this->_var['goods_image']):
        $this->_foreach['fe_goods_image']['iteration']++;
?>
	            <div class="touchslider-item">
                   <a><span class="img320">
                         <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods_image']['thumbnail']; ?>" class="yxwimg"/>
                       </span>
                    </a>
                 </div>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			     
				</div>
             </div>
            <div class="bq_xq_good-title">
                 <h1><?php if (strlen ( $this->_var['goods']['goods_name'] ) > 11): ?><?php echo $this->_var['goods_name1']; ?></h1>
				 <h1><?php echo $this->_var['goods_name2']; ?> <?php else: ?><?php echo $this->_var['goods']['goods_name']; ?><?php endif; ?></h1>
            </div>
            
				<a class="touchslider-prev"></a>
                <a class="touchslider-next"></a>
            
		</div>	
        <div style=" margin:0px 10px;border-bottom:1px solid #EEEEEE;">
           <p id="to_price" class="tc_price" style="width:100%;">￥：<?php echo $this->_var['goods']['price']; ?><span style="display:inline-block;vertical-align: middle;font-size: 18px;margin-left: 20%;font-weight:100; color:#4D4D4D;">原价：<del>￥<?php echo $this->_var['goods']['shichang']; ?></del></span></p>
           <!-- <span style="display:inline-block; width:75px; vertical-align: central;" gid="<?php echo $this->_var['goods']['spec_id']; ?>"   sid="<?php echo $this->_var['goods']['store_id']; ?>"><input type="text" id="quantity" class="spinnerExample"/></span> -->
         </div>
         
       <!-- <div class="tc_number" style="border-bottom: 1px solid #eeeeee;">
        剩余：<span><?php echo $this->_var['goods']['stock']; ?> 件</span>
        </div>
		 <div class="tc_number" >
        运费：<span>山东省内包邮</span>
        </div>-->
        <div  style="height:15px; background:#F9F9F9; clear:both;"></div>

        <!-- <div class="tc_shop">
          <a href="index.php?app=store&act=redirect&id=<?php echo $this->_var['goods']['store_id']; ?>">
            <i class="shop_icon"></i>
            <p><?php echo $this->_var['goods']['store_name']; ?></p>
            <span>进入店铺</span>
           </a>
        </div> -->
        
        <div class="bq_goods-twimg">
            <?php echo $this->_var['goods']['description']; ?>
         </div>
         
         <!-- 底部浮动按钮开始
         <div class="fixed-add-to-cart" style="display:block;">
            <div>
            <input type="button" onclick="to_shop()" class="pxui-light-button addtocart" style="background:#F50000; padding: 3px 12px 5px;  margin: 5px 0px;" value="一键购买"/>
            </div>
        </div>
       底部浮动按钮结束--->
		
            <div  style="background: #E0DEDB;-moz-box-shadow: 0px -2px 5px #999;-webkit-box-shadow: 0px -2px 5px #999;box-shadow: 0px -2px 5px #999;bottom: 0;box-sizing: border-box;display: block;left: 0;position: fixed;text-align: center;z-index: 100;width: 100%;
">
			  <span style="display:inline-block; width:75px;vertical-align: middle;" gid="<?php echo $this->_var['goods']['spec_id']; ?>"   sid="<?php echo $this->_var['goods']['store_id']; ?>"><input type="text" id="quantity" class="spinnerExample"/></span>
             <input type="button" onclick="to_shop()" class="addtocart"   value="一键购买" style="padding:3px 12px 6px; background:#f50000; border-radius:6px; color:#FFF; border:none; margin:8px 10px;"/>
            </div>
        </div>
        
    </div>
</div>
		</div>
        
      
      
	  
      <div class="com-footer-area" id="js-com-footer-area" style="margin:20px 0px 60px;">
			<div class="com-footer-nav">
				<a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201387981&idx=1&sn=3c5ae4f90632a4da200e588e8d5c382c#rd">商家入驻</a><a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201235911&idx=1&sn=78e95d8c36a85a8725873016a317739f#rd">关于倍全</a><a href="http://mp.weixin.qq.com/s?__biz=MzA4ODUwNDkzNg==&mid=201359815&idx=3&sn=0dfad18c4ca1877d1e6e1dfda06471d6#rd">20分钟送货</a>
			</div>
			<div class="com-footer">
				<p>
					<strong style="line-height:28px;">
						© 2014-2015 Bei Quan By Wei<br />
                        京ICP备14026542号-1
                        
					</strong>
				</p>
                <br /> 
                <p style="border-bottom:none;">
                <a href='/mobile/'>倍全商城 </a>
                 - -有倍全的地方就有家！
                </p>
             </div>
		</div>
      

</div>
</body>

<script type="text/javascript">
    $('.spinnerExample').spinner({

        value: 1,
        min: 1

    });

</script>



</html>