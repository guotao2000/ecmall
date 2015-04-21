<!doctype html>
<html>
    <head>
        <title>倍全商城-收货地址列表</title>
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
          <span class="bq_header_title" style="padding-left:0px;">收货地址列表</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">

  <div class="page-role good-page">
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />	
     
     <div class="pxui-area">
        
         <div class="bq_makeorder-box" id="js-attrs-title">
            
            <div class="makeorder_shdz-add" style="border-bottom:none;" >
		      <a class="makeorder_btn-addr" style="color:#e4393c;" href="index.php?app=address&act=add_address&store_id=<?php echo $this->_var['store_id']; ?>">+添加收货地址</a>
            </div>
            
            
            <?php $_from = $this->_var['address']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'addr');if (count($_from)):
    foreach ($_from AS $this->_var['addr']):
?>
            <div class="bq_adders-select">
                <span  class="bq_adders-ht"></span>
            	<div class="bq_adders-info">
                	<div class="bq_adders-name">
                        <p><?php echo htmlspecialchars($this->_var['addr']['consignee']); ?> <span>&nbsp; <?php echo htmlspecialchars($this->_var['addr']['phone_mob']); ?></span></p>
                        <p><?php echo htmlspecialchars($this->_var['addr']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['addr']['address']); ?></p>
                    </div>
                    <div class="bq_addersbg-border"></div>
                    <div class="bq_adders-btn">
                    	<span class="adders-tbl-type">
                           <span class="tbl-cell">
                            <a style="width:100%" class="btn-chk" href="index.php?app=address&act=enable_address&store_id=<?php echo $this->_var['store_id']; ?>&addr_id=<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>"><span <?php if ($this->_var['addr']['enable'] == 1): ?>  <?php endif; ?>></span><b style="padding:3px 6px; background:#f33837;color: #fff;cursor: pointer;text-align: center;text-shadow: 1px 1px 1px #c64e13; font-weight:normal;">送到这里去</b></a>
                           </span>
                           <span class="tbl-cell text-right">
                            	<a class="btn-update" href="index.php?app=address&act=edit_address&store_id=<?php echo $this->_var['store_id']; ?>&addr_id=<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>"><span></span>修改</a>
    					 <a class="btn-del" href="index.php?app=address&act=del_address&store_id=<?php echo $this->_var['store_id']; ?>&addr_id=<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>"><span></span>删除</a>
                         <a style="display:none" href="#"></a>
    					   </span>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            暂时没有地址
            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
             
         </div>
          
     </div>
     
</div></div>
     <?php echo $this->fetch('member.footer.html'); ?>
</div>

<?php echo $this->fetch('store.menu.html'); ?>
</body>
</html>
