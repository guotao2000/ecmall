<!doctype html>
<html>
  <head>
    <title>倍全商城-我的收藏</title>
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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/cplb.css'; ?>"  />	
    <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
    <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
    
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
    
    
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
    
    
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.spinner.js'; ?>"></script>
    
    
     <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/index.js'; ?>"></script>
    
    <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'member.js'; ?>" charset="utf-8"></script>
  </head>
  <body>
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">我的收藏</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
       
        <div class="com-content-area" id="js-com-content-area"  style=" margin:12px 2px;">
          <div class="page-role user_collection-page">
           <div class="pxui-area">
          <div class="pxui-tab pxui-tab-style pxui-tab-no-top">
          <a href="<?php echo url('app=my_favorite&type=goods'); ?>" <?php if ($_GET['type'] == 'goods'): ?> class="selected" <?php endif; ?>>收藏的商品</a>
          <a href="<?php echo url('app=my_favorite&type=store'); ?>" <?php if ($_GET['type'] == 'store'): ?> class="selected" <?php endif; ?>>逛过的店铺</a>
          </div>
          <div class="bq_cplb_bg" style=" margin-top:-4px;"></div>
          <div class="pxui-shoes">
          
              <div class="zxList">
               <ul>
               
               
               	 <?php $_from = $this->_var['collect_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['v']['iteration']++;
?>
                 <li class="clearfix">
                   <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px;"><img src="<?php echo $this->_var['goods']['default_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p class="proName" style="line-height:22px; margin-bottom:5px;"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                      <span class="proPrice" style="display:block;">倍全价：<?php echo price_format($this->_var['goods']['price']); ?></span>                 <!--<span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>100</del></span>-->
                      <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" class="goumai" style="border-right:none;">购买</a>
                      <a href="javascript:drop_confirm('您确定要取消收藏吗？', 'index.php?app=my_favorite&amp;act=drop&type=goods&item_id=<?php echo $this->_var['goods']['goods_id']; ?>');" class="quxiao" style="border-right:none;">取消收藏</a>
                  </div>
                 </li>
                <?php endforeach; else: ?>
                <li>没有符合条件的商品</li>
				<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          
               </ul>
              </div>
          
          
          
          <div class="page">
      	  <?php echo $this->fetch('member.page.bottom.html'); ?>
    	  </div>
          
          
          </div>
         
          </div>

          </div>
		</div>
        
       
       <?php echo $this->fetch('member.footer.html'); ?>
       
      
</div>

 <?php echo $this->fetch('store.menu.html'); ?>

</body>

<script type="text/javascript">
$('.spinnerExample').spinner({});
</script>



</html>
