<!doctype html>
<html>
    <head>
        <title>倍全商城</title>
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

  <div class="com-header-area bq_index-header" id="js-com-header-area">
          <a href="/index.php?app=default&act=cover" class="bq-header-libiao"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">倍全商城</span>
          <a href="<?php echo url('app=member'); ?>" class="bq-header-user"><del></del></a>
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">

<div class="page-role good-page">
         <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/index/index.css'; ?>" />
        <div class="bq_index-box" id="js-attrs-title">
           <div class="bq_index-top">
               <img src="/themes/bqmart/images/bq_index-welcom.png">
           </div>
           
           <!--<div class="bq_index-search">
             <div class="search" style="position:relative">
          <span class="input-box">
          <form action="search.php" id="searchForm"  name="searchForm" method="get" >
              <input type="text" name="keywords" id="keyword" class="new-input"  value="" placeholder="请输入关键词" >
          </form>	
          <a href="javascript:void(0)" onclick="$('#searchForm').submit();" class="btn-search"><span>search</span></a>
          </span>
          <div class="new-srch-lst" id="shelper" style="position: absolute; top: 2em; left: 3.28em; z-index: 10; width: 404.2px; display: none;"></div>
          </div>
           </div>-->
           
           
           <div  class="bq_index-info">
              <div class="bq_index-infobox">
                 <ul>
                    <li>
                     <a href="index.php?app=store&id=<?php echo $_GET['id']; ?>" >
                     <div class="indx_box-l one" style="background:#6bb61d">
                        <span class="indx_box-icon1"></span>
                        <p>倍全商城<br/>急速到家</p>
                     </div>
                     </a>
                      <a href="index.php?keyword=洗衣干洗&app=store&act=search&id=<?php echo $_GET['id']; ?>">
                     <div class="indx_box-r one" style="background:#0074E9;">
                         <span class="indx_box-icon7"></span>
                         <p style=" line-height:48px;">洗衣干洗</p>
                     </div>
                     </a>
                 </li>
                 </ul>
               </div>
              <div class="bq_index-infobox">
                 <ul>
                    <li>
                     <a href="index.php?keyword=酒&app=store&act=search&id=<?php echo $_GET['id']; ?>" >
                     <div class="indx_box-l one" style="background:#5134A4">
                        <span class="indx_box-icon2"></span>
                        <p>酒急送<br />20分钟送酒</p>
                     </div>
                     </a>
					  <a href="index.php?keyword=快递&app=store&act=search&id=<?php echo $_GET['id']; ?>" >
                     <div class="indx_box-r one" style="background:#FF8000;">
                         <span class="indx_box-icon8"></span>
                         <p  style=" line-height:48px;">收发快递</p>
                     </div>
                     </a>
                     
                 </li>
                 </ul>
               </div>
              <div class="bq_index-infobox">
                 <ul>
                    <li>
					 <!-- <a href="index.php?app=store&id=128"> -->
                     <a href="#" onClick="dianji()">
                     <div class="indx_box-l" style="background:#E94209">
                        <span class="indx_box-icon5"></span>
                        <p>特产礼品</p>
                     </div>
                     </a>
                      <a href="#" onClick="dianji()">
                     <div class="indx_box-r" style="background:#D0003E;">
                         <span class="indx_box-icon4"></span>
                         <p>蛋糕鲜花</p>
                     </div>
                     </a>
                 </li>
                 </ul>
               </div>
              <div class="bq_index-infobox">
                 <ul>
                    <li>
                     <a href="#" onClick="dianji1()">
                     <div class="indx_box-l" style="background:#0086CD">
                        <span class="indx_box-icon3"></span>
                        <p>缴费充值</p>
                     </div>
                     </a>
                      <a href="#" onClick="dianji()">
                     <div class="indx_box-r" style="background:#FF504D;">
                         <span class="indx_box-icon6"></span>
                         <p>家政服务</p>
                     </div>
                     </a>
                 </li>
                 </ul>
               </div>
           </div>
           
        </div>
</div>

</div> 

</div>
</body>
<script type="text/javascript">
    function dianji() {
        alert('亲，该服务即将上线！敬请期待，您现在可以去购买超市货品，倍全最快20分钟送货上门哦~~');
    }
    function dianji1() {
        alert('倍全门店已开通该服务，请到您所在小区的店铺进行缴费，线上即将开通，敬请期待！');
    }
</script>
</html>
