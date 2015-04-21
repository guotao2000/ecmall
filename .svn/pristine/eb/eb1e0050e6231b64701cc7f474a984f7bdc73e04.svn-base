<!doctype html>
<html>
    <head>
        <title>倍全商城-商品图文</title>
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
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">商品详细描述</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
       
        <script>
         /*是否下线*/
         var isDown = false;
        </script>
        
	<script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.touchslider.min.js'; ?>"></script>
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/good/index.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'goodsinfo.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script>
jQuery(function($) {
	$(".touchslider").touchSlider({mouseTouch: true, autoplay: true});
});
</script>	

<script type="text/javascript">
//<!CDATA[
var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';
/* buy */
function buy()
{
    add_to_cart(<?php echo $_GET['spec_id']; ?>, 1, <?php echo htmlspecialchars($this->_var['goods']['store_id']); ?>);
}

function add_to_cart(spec_id, quantity, store_id)
{	
    var url = '/index.php?app=cart&act=to_shop&spec_id='+spec_id+'&quantity='+quantity+'&store_id='+store_id;
            //alert(url);

			$.getJSON(url, '', function(data){
				if (data.done)
				{
					window.location.href='index.php?app=cart';
				}
				else
				{ 
					alert(data.msg);
				}
			});
}
</script>

    <div class="pxui-area">
        <div id="js-attrs-title" class="bq_tuwen-box">
           <div class="bq_goods-twtitle">
             <h4><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></h4>
           </div>
           <div class="bq_goods-twimg">
            <?php echo html_filter($this->_var['goods']['description']); ?>  
            </div>
          <div class="fixed-add-to-cart" id="js-fixed-add-to-cart">
            <div>
             <a href="javascript:buy();"><input type="button" class="pxui-light-button addtocart" style="background:#FFF; border-color:#D9D6D1; color:#63625D;" value="加入购物车"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
             <a href="javascript:buy();"><input type="button" class="pxui-light-button addtocart" style="background:#F50000;" value="立即结算"/></a>
            </div>
        </div>
        </div>
    </div>
  </div>
        
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div>
</body>

</html>
