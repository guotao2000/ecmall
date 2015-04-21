<!doctype html>
<html>
    <head>
        <title>倍全商城-信息页面</title>
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
          <span class="bq_header_title" style="padding-left:0px;">倍全商城-信息页面</span>
      
		  <div class="clear"></div>
        </div>


  <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
      
         <div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />

    <div class="pxui-area">
        <div class="bq_ordersuccess-box" id="js-attrs-title">
                      <ul>
                            <br>
                                <li style="text-align:center;"><?php echo $this->_var['message']; ?>
                                    <?php if ($this->_var['err_file']): ?>
                                    <b style="clear: both; float: left; font-size: 15px;">Error File: <strong><?php echo $this->_var['err_file']; ?></strong> at <strong><?php echo $this->_var['err_line']; ?></strong> line.</b>
                                    <?php endif; ?>
                                    <?php if ($this->_var['icon'] != "notice"): ?>
                                    <font style="clear: both; display:block; margin:20px 0 50px 0;">
                                        <?php $_from = $this->_var['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                                        <a style=" padding:3px 10px;border-radius: 6px; font-size: 16px; padding: 3px 20px;text-align: center;background: #FB8C08;text-shadow: 1px 1px 1px #c64e13;color: #fff;cursor: pointer;line-height: 22px;text-decoration: none; " href="/index.php">>>商城首页</a><br />
                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </font>
                                    <?php endif; ?>
                                </li>
                        </ul>
 
            
        </div>
    </div>
</div>

<script type="text/javascript">
//<!CDATA[
<?php if ($this->_var['redirect']): ?>
window.setTimeout("<?php echo $this->_var['redirect']; ?>", 1000);
<?php endif; ?>
//]]>
</script>



</div> 

</div>

</body>
</html>
