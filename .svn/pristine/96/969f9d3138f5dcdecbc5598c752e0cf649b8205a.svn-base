<!doctype html>
<html>
    <head>
        <title>倍全商城-分类搜索</title>
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
    
    </head>
    <body>
    <div class="com-content">
      
      <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">分类搜索页</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>
      
      
      <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
        <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/list/style.css'; ?>" />
       <div class="pxui-area" style="border-bottom:none;">
       
       <div  class="bq_cat-search" id="js-attrs-title" >
        <div class="cat_seach-box">
        
          <div class="search" style="position:relative">
          <span class="input-box">
          <form action="" id="searchForm"  name="searchForm" method="get" >
              <input type="text" name="keyword" id="keyword" class="new-input"  value="" placeholder="请输入关键词" style="background: none repeat scroll 0 0 #fff;border: 0 none;border-radius: 0;color: #bdbdbd;vertical-align: middle;width: 85%; padding:4px 0px;">
          	  <input type="hidden" name="app" value="store" />
              <input type="hidden" name="act" value="search" />
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
          </form>	
          <a href="javascript:void(0)" onclick="$('#searchForm').submit();" class="btn-search"><span>search</span></a>
          </span>
          <div class="new-srch-lst" id="shelper" style="position: absolute; top: 2em; left: 3.28em; z-index: 10; width: 404.2px; display: none;"></div>
          </div>
        
        </div>
       </div>
       
       
        <div class="bq_category-list">
         <ul>
         	
         	<?php $_from = $this->_var['gcategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>
         	<li>
	                <div class="pxui-list" data-model="radio"><a>
	                    <span></span>
		                    <div class="category_name">
		                        <?php echo htmlspecialchars($this->_var['gcategory']['value']); ?>
		                        <!-- <br /> -->
		                        <!-- <span>牛奶乳品 / 坚果炒货 / 酒类 / 糖果 </span> -->
		                    </div>
	                    	<i  class="category_anjian" style=" top:26px;"></i></a>
	                  		<div class="pxui-list-con" style="display:none;">
			                    <ol class="attrs">
			                    <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
			                     <li><a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>&id=<?php echo $_GET['id']; ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></li>
			                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			                     <i class="category_anjian-hover" style=" top:26px;"></i>
			                    </ol>
	                        </div>  
	               </div>
            </li>
         	<?php endforeach; else: ?>
         	<li>
	        	<div class="pxui-list" data-model="radio">暂无分类</div>
	        </li>
         	<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
         	
         </ul>
       </div>
       
    </div>
        </div>
      </div>
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div>
</div>

       <div class="bq_manu  home-page ">
        <div style="position: fixed; bottom:0px; width:100%; z-index:999;"> 
          <div class="pxui-tab pxui-tab-nav pxui-tab-no-top">
           <a  href="/"><i></i>首&nbsp;页<span></span></a>
          <a href="index.php?app=search"  class="selected"><i></i>搜&nbsp;索<span></span></a>
          <a href="<?php echo url('app=cart'); ?>"><i></i><b class="bq_cart-manu_bg" id="yxwcart">2</b>购物车<span></span></a>
          <a href="<?php echo url('app=member'); ?>"><i></i>我&nbsp;的<span></span></a>
          </div>
        </div>
        </div>
       
</body>
</html>