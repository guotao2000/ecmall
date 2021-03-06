<!doctype html>
<html>
  <head>
    <title>倍全商城-<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>-首页</title>
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
    <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
    
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
    
    
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
    
    
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.spinner.js'; ?>"></script>
    
	<style>
	    .black_overlay{ 
            <?php if ($this->_var['diyici'] == "1"): ?>display:none;<?php endif; ?>
            position: absolute; 
            top: 0%; 
            left: 0%; 
            width: 100%; 
            height: 100%; 
            background-color:#E5E5E5; 
            z-index:1001; 
            -moz-opacity: 0.86; 
            opacity:.86; 
            filter: alpha(opacity=86); 
            } 
			.zhiyin{
			 z-index:1002; 
			
			}

	
	</style>
  </head>
  <body>
   <div id="fade" class="black_overlay" onclick="document.getElementById('fade').style.display='none';">
   <div class="zhiyin" style="display: block; width: 525px; height: 500px; margin-top: 21px; " >
   <image src="/static/images/qhdz.png" width="363" height="500"/></div>
   </div> 

    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="<?php echo url('app=default'); ?>" class="com-header-logo"></a>
		  <dfn></dfn>
          <span class="bq_header_title"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></span>
		  
          <a href="/index.php?app=default&act=cover" class="com-header-shop "><del></del></a>
		  <div class="clear"></div>
        </div>
      
       
        <div class="com-content-area" id="js-com-content-area">
          <div class="page-role home-page">
            <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/index.css'; ?>"/>
          
            <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.touchslider.min.js'; ?>"></script>
            <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/index.js'; ?>"></script>
            <script>
              jQuery(function($) {
              $(window).resize(function(){
                 var width=$('#js-com-header-area').width();
              $('.touchslider-item a').css('width',width);
              $('.touchslider-viewport').css('height',340*(width/640));
                }).resize();	
              $(".touchslider").touchSlider({mouseTouch: true, autoplay: true});
              });
            </script>	
          
            <div class="touchslider">
              <div class="touchslider-viewport">
              <?php $_from = $this->_var['goods_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_image');if (count($_from)):
    foreach ($_from AS $this->_var['goods_image']):
?>
                <div class="touchslider-item">
                    <a href="<?php echo $this->_var['goods_image']['image_link']; ?>">
                      <img src="<?php echo $this->_var['goods_image']['image_url']; ?>" style="vertical-align:top;"/>
                    </a>
                </div>
              <?php endforeach; else: ?>
              	<div class="touchslider-item">
              		暂无图片
              	</div>
              <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </div>
              <div class="touchslider-navtag">
                  <span class="touchslider-nav-item touchslider-nav-item-current"></span>
                  <span class="touchslider-nav-item "></span>
                  <span class="touchslider-nav-item "></span>                  
              </div>
            </div>
          
          
          <div class="search" style="position:relative">
          <span class="input-box">
          
          <form action="" id="searchForm"  name="searchForm" method="get" >
              <input type="text" name="keyword" id="keyword" class="new-input"  value="" placeholder="请输入关键词" style="background: none repeat scroll 0 0 #fff;border: 0 none;border-radius: 0;color: #bdbdbd;vertical-align: middle;width: 85%; padding:4px 0px;">
          	  <input type="hidden" name="app" value="store" />
              <input type="hidden" name="act" value="search" />
              <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />
          </form>	
          
          <a href="javascript:void(0)" onclick="$('#searchForm').submit();" class="btn-search"><span>search</span></a>
          </span>
          <div class="new-srch-lst" id="shelper" style="position: absolute; top: 2em; left: 3.28em; z-index: 10; width: 404.2px; display: none;"></div>
          </div>
          
        
          <div class="category" style="padding:10px 0px;">
            <ul class="cate-menu tbl-type" id="categoryMenu">
			 <li class="tbl-cell route4 route">
                      <a href="index.php?app=category&id=<?php echo $_GET['id']; ?>" class="menu4" res="1">
                        <span class="menu4-icon"><span></span></span>
                      <span class="cate-name">分类</span>
                  </a>
              </li>
              <li class="tbl-cell route2 route">
                <a href="<?php echo url('app=hongbao'); ?>" id="html5_cart" class="menu2" >
                    <span class="menu2-icon"><span></span></span>
                      <span class="cate-name">红包</span>
                  </a>
              </li>
              <li class="tbl-cell route3 route">
                <a href="<?php echo url('app=cart'); ?>" class="menu3">
                    <span class="menu3-icon"><span></span></span>
                      <span class="cate-name">购物车</span>
                  </a>
              </li>
             <li class="tbl-cell route1 route">
                <a href="<?php echo url('app=buyer_order'); ?>" class="menu1" onclick="clickResponse(this)" res="1">
                    <span class="menu1-icon"><span></span></span>
                      <span class="cate-name">我的订单</span>
                  </a>
              </li>
              <li class="tbl-cell route5 route">
                <a href="<?php echo url('app=my_favorite&type=goods'); ?>" class="menu6" onclick="clickResponse(this)" res="1">
                    <span class="menu6-icon"><span></span></span>
                      <span class="cate-name">收藏夹</span>
                  </a>
              </li>
              </ul>
        </div>
      
	  
      <div class="bq_bkad" style="margin-top:0px;">
          <div class="bq_bk_slide">
            <a href="/index.php?app=zhuanti&id=16&store_id=<?php echo $this->_var['store']['store_id']; ?>"><img src="/themes/bqmart/images/bq_mianmoad.jpg"  width="100%" ></a>
          </div>
      </div>
      
      <!-- WAP通栏横条BD_1开始 By Wei 2014.12.08
          <div class="bq_bkad">
              <div class="bq_bk_slide">
                <a href="index.php?app=category&id=<?php echo $_GET['id']; ?>"><img src="/themes/bqmart/images/bq_tonglan_ad_1.jpg"  width="100%" ></a>
              </div>
          </div>
       WAP通栏横条BD_1结束-->
      <!-- 鲜花预售告位开始
      <div class="bq_bkad">
          <div class="bq_bk_slide">
            <?php if ($_GET['id'] == 42): ?><a href="http://wap.bqmart.cn/index.php?app=zhuanti&id=12&uin=168&act=index&state=4&openid="><img src="/themes/bqmart/images/xianhuaad.jpg"  width="100%" ></a><?php endif; ?>
			<?php if ($_GET['id'] == 131): ?><a href="http://wap.bqmart.cn/index.php?app=zhuanti&id=12&uin=169&act=index&state=4&openid="><img src="/themes/bqmart/images/xianhuaad.jpg"  width="100%" ></a><?php endif; ?>
			<?php if ($_GET['id'] == 132): ?><a href="http://wap.bqmart.cn/index.php?app=zhuanti&id=12&uin=170&act=index&state=4&openid="><img src="/themes/bqmart/images/xianhuaad.jpg"  width="100%" ></a><?php endif; ?>
          </div>
      </div>
      鲜花预售广告位结束-->
      <!-- 放假通知广告位开始
      <div class="bq_bkad" style="margin-top:0px;">
          <div class="bq_bk_slide">
            <img src="/themes/bqmart/images/fjtongzhi.jpg"  width="100%" >
          </div>
      </div>-->
      
      
          <div class="pxui-area">
          <!-- <div class="bq_cplb_bg"></div> -->
          <div class="pxui-tab pxui-tab-style pxui-tab-no-top" id="js-tab-style">
          <a>热销商品</a>
          <a class="selected">精品推荐</a>
          <a>最新商品</a>
          </div>
          <div class="pxui-shoes" id="js-home-tab-0" style="display:none;">
          
          <div class="liebiao">
            
              <div class="zxList">
               <ul>
               <?php $_from = $this->_var['hot_sale_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hot_goods');if (count($_from)):
    foreach ($_from AS $this->_var['hot_goods']):
?>
               	 <li class="clearfix">
                   <a href="<?php echo url('app=goods&id=' . $this->_var['hot_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px;"><img src="<?php echo $this->_var['hot_goods']['default_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p class="proName" style="line-height:22px; margin-bottom:5px;"><a href="<?php echo url('app=goods&id=' . $this->_var['hot_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;"><?php echo htmlspecialchars($this->_var['hot_goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span class="proPrice" style="display:block;">倍全价：<?php echo price_format($this->_var['hot_goods']['price']); ?></span>                 <!-- <span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>100</del></span> -->
                      <span style="position:absolute; right:10px; bottom:18px;" gid="<?php echo $this->_var['hot_goods']['spec_id']; ?>"   sid="<?php echo $this->_var['hot_goods']['store_id']; ?>"><input type="text" class="spinnerExample"/></span>
                   </div>
                  </li>
               <?php endforeach; else: ?>
                 <li class="clearfix">暂无热销商品</li>
               <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                        
               </ul>
              </div>
            
          </div>
          
          </div>
          <div class="pxui-show-more" style="display:none;" lastid="1" template="#js-bk-template" srcProperty="goodsrc" container="#js-home-tab-0 > div" url="/home/ajax?act=bk_more">
          <img src="template/images/public/loading.gif" width="24" height="24"/>
         
          </div>
          <div class="pxui-shoes" id="js-home-tab-1" >
          
          <div class="liebiao">
             
             <div class="zxList">
                <ul>
                <?php $_from = $this->_var['recommended_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rec_goods');if (count($_from)):
    foreach ($_from AS $this->_var['rec_goods']):
?>
                <li class="clearfix">
                   <a href="<?php echo url('app=goods&id=' . $this->_var['rec_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px;"><img src="<?php echo $this->_var['rec_goods']['default_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p class="proName" style="line-height:22px; margin-bottom:5px;"><a href="<?php echo url('app=goods&id=' . $this->_var['rec_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;"><?php echo htmlspecialchars($this->_var['rec_goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span class="proPrice" style="display:block;">倍全价：<?php echo price_format($this->_var['rec_goods']['price']); ?></span>                 <!-- <span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>100</del></span> -->
                      <span style="position:absolute; right:10px; bottom:18px;" gid="<?php echo $this->_var['rec_goods']['spec_id']; ?>"  sid="<?php echo $this->_var['rec_goods']['store_id']; ?>"><input type="text" class="spinnerExample"/></span>
                   </div>
                  </li>
                <?php endforeach; else: ?>
                <li class="clearfix">暂无推荐商品</li>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                 
                </ul>
              </div>
             
          </div>
          
          </div>
          <div class="pxui-show-more"  lastid="1" template="#js-bk-template" srcProperty="goodsrc" container="#js-home-tab-1 > div" url="/home/ajax?act=bk_more&sid=94">
          <img src="template/images/public/loading.gif" width="24" height="24"/>

          </div>
          <div class="pxui-shoes" id="js-home-tab-2" style="display:none;">
          
          <div class="liebiao">
             
             <div class="zxList">
                <ul>
                
                  <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'latest_goods');if (count($_from)):
    foreach ($_from AS $this->_var['latest_goods']):
?>
                <li class="clearfix">
                   <a href="<?php echo url('app=goods&id=' . $this->_var['latest_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px;"><img src="<?php echo $this->_var['latest_goods']['default_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p class="proName" style="line-height:22px; margin-bottom:5px;"><a href="<?php echo url('app=goods&id=' . $this->_var['latest_goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;"><?php echo htmlspecialchars($this->_var['latest_goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span class="proPrice" style="display:block;">倍全价：<?php echo price_format($this->_var['latest_goods']['price']); ?></span>                 <!-- <span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>100</del></span> -->
                      <span style="position:absolute; right:10px; bottom:18px;" gid="<?php echo $this->_var['latest_goods']['spec_id']; ?>"  sid="<?php echo $this->_var['latest_goods']['store_id']; ?>"><input type="text" class="spinnerExample"/></span>
                   </div>
                  </li>
                <?php endforeach; else: ?>
                <li class="clearfix">暂无最新商品</li>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                 
                 </ul>
              </div>
             
           </div>
          
          </div>
          <div class="pxui-show-more" style="display:none;" lastid="1" template="#js-bk-template" srcProperty="goodsrc" container="#js-home-tab-2 > div"  url="/home/ajax?act=bk_more&sid=95">
          <img src="template/images/public/loading.gif" width="24" height="24"/>

          </div>
          <div class="pxui-shoes" id="js-home-tab-3" style="display:none;">
          <div>
          </div>
          </div>
          <div class="pxui-show-more" style="display:none;" lastid="1" template="#js-bk-template" srcProperty="goodsrc" container="#js-home-tab-3 > div"  url="/home/ajax?act=bk_more&sid=96">
          <img src="template/images/public/loading.gif" width="24" height="24"/>
        
          </div>
          <div class="pxui-shoes" id="js-home-tab-4" style="display:none;">
          <div>
          </div>
          </div>
          <div class="pxui-show-more" style="display:none;" lastid="1" template="#js-bk-template" srcProperty="goodsrc" container="#js-home-tab-4 > div"  url="/home/ajax?act=bk_more&sid=97">
          <img src="template/images/public/loading.gif" width="24" height="24"/>
     
          </div>
          </div>

          </div>
		  
		  <script type="text/tcl" id="js-good-template">
			<a href="<%=data.link;%>">
				<div class="img160"><dfn></dfn><img src="http://img-cdn2.paixie.net/images/empty.gif" goodsrc="<%=data.img;%>"/></div>
				<span class="name"><%=data.name;%></span>
				<span class="price">￥<%=data.price;%></span>
				<del class="price">￥<%=data.oldprice;%></del>
			</a>
          </script>
		  
		</div>
        
     <?php echo $this->fetch('member.footer.html'); ?>
      
</div>
  <?php echo $this->fetch('store.menu.html'); ?>
</body>

<script type="text/javascript">
//添加到购物车  begin
function add_to_shop(spec_id, quantity,store_id)
{	
	var url = '/index.php?app=cart&act=to_shop&spec_id='+spec_id+'&quantity='+quantity+'&store_id='+store_id;
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
//end

var StartTime = <?php echo $this->_var['sec_start_time']; ?>;
StartTime = StartTime * 1000;
var EndTime= <?php echo $this->_var['sec_end_time']; ?>;
EndTime = EndTime * 1000;
var NowTime = <?php echo $this->_var['sec_now_time']; ?>;
NowTime = NowTime * 1000;
var nMS = StartTime - NowTime;   
var nMSB = EndTime - NowTime;     
function GetRTime(){
	nMS = nMS - 1000;
	var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
	var nH = Math.floor(nMS/(1000*60*60)) % 24;
	var nM = Math.floor(nMS/(1000*60)) % 60;
	var nS = Math.floor(nMS/1000) % 60;
	if (nMS <= 0){
		window.clearInterval(timer_rt);
		$("#sec_tip").html("距离秒杀结束还有：");
		document.getElementsByName('qiang_gou').item(0).disabled = false;
	   var timer_rt_s = window.setInterval("GetRTime_s()", 1000);
	}else{
	   //document.getElementsByName('sec_tip').item(0).value = '距离秒杀开始还有：';
	   
	   $(".hours").text(nH);
	   $(".second").text(nM);
	   $(".miao").text(nS); 
	}
}

function GetRTime_s(){
	nMSB = nMSB - 1000;
	var nD = Math.floor(nMSB/(1000 * 60 * 60 * 24));
	var nH = Math.floor(nMSB/(1000*60*60)) % 24;
	var nM = Math.floor(nMSB/(1000*60)) % 60;
	var nS = Math.floor(nMSB/1000) % 60;
	if (nMSB < 0){
	   document.getElementsByName('qiang_gou').item(0).disabled = true;
	   $('#sec_id').html('秒杀活动已结束');
	}else{
	   //document.getElementsByName('sec_tip').item(0).value = '距离秒杀结束还有：';
	   
	   $(".hours").text(nH);
	   $(".second").text(nM);
	   $(".miao").text(nS); 
	}
}

$(document).ready(function () {
	 timer_rt = window.setInterval("GetRTime()", 1000);
});
</script>


<script type="text/javascript">
$('.spinnerExample').spinner({
	value:0,
	min:0
});
</script>



</html>
