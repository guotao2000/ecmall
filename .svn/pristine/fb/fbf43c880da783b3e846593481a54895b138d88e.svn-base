<!doctype html>
<html>
  <head>
    <title>倍全商城-首页</title>
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
    
  </head>
  <body>
    <div class="com-content">
       
        <div class="com-header-area" id="js-com-header-area">
          <a href="<?php echo url('app=default'); ?>" class="com-header-logo"></a>
		  <dfn></dfn>
          <span class="bq_header_title"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></span>
          <a href="index.php?app=store&act=select_store" class="com-header-shop "><del></del></a>
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
              <li class="tbl-cell route1 route">
                <a href="<?php echo url('app=buyer_order'); ?>" class="menu1" onclick="clickResponse(this)" res="1">
                    <span class="menu1-icon"><span></span></span>
                      <span class="cate-name">我的订单</span>
                  </a>
              </li>
              <li class="tbl-cell route2 route">
                <a href="<?php echo url('app=coupon'); ?>" id="html5_cart" class="menu2" >
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
              <li class="tbl-cell route4 route">
                      <a href="index.php?app=my_money&act=paylist" class="menu4" onclick="clickResponse(this)" res="1">
                        <span class="menu4-icon"><span></span></span>
                      <span class="cate-name">充值</span>
                  </a>
              </li>
              <li class="tbl-cell route5 route">
                <a href="<?php echo url('app=my_favorite'); ?>" class="menu6" onclick="clickResponse(this)" res="1">
                    <span class="menu6-icon"><span></span></span>
                      <span class="cate-name">收藏夹</span>
                  </a>
              </li>
              </ul>
        </div>
      
      
          <div class="bq_bkad">
              <div class="bq_bk_slide">
                <a href="#"><img src="/themes/bqmart/images/bq_tonglan_ad_1.jpg"  width="100%" ></a>
              </div>
          </div>
      
      
      	
	    <div class="content-box">
		   <div class="content-box-category">
			<span><strong>天天折扣抢购</strong></span>
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
							   <a href="" class="product-image-link"><img src="<?php echo $this->_var['good']['default_image']; ?>" /></a>
						    </div>
							<div style="width:99%; overflow: hidden; position:relative;">
							    <a href="" class="product-title-link"><?php echo htmlspecialchars($this->_var['good']['goods_name']); ?></a>
							    <p>折扣价：<?php echo price_format($this->_var['good']['price']); ?></p>
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
      
      
      
      <div class="bq_bkad" >
        <div class="bq_bk_slide">
          <a href="#"><img src="/themes/bqmart/images/bqadl_1.jpg"  width="50%"></a><a href="#"><img src="/themes/bqmart/images/bqadr_1.jpg"  width="50%"></a>
        </div>
      </div>
      
      
      
        <div data-role="page" id="mypage"> 
           <div class="content-box-category" style="background:#F0F0F2;">
			<span><strong>天天折扣秒杀</strong></span>
		    </div>
         	<div role="main" class="ui-content">
        		<ul class="sliderlist">
        	  
        	  <?php $_from = $this->_var['seckill_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sec_good');if (count($_from)):
    foreach ($_from AS $this->_var['sec_good']):
?>
              <li>
                 <div class="miaosha_list">
                 <div class="img"><img src="<?php echo htmlspecialchars($this->_var['sec_good']['default_image']); ?>"><div class="dw"><img src="/themes/bqmart/images/miaosha_position.png"></div></div>
                 <div class="zhuangtai"><a href="index.php?app=goods&id=<?php echo htmlspecialchars($this->_var['sec_good']['goods_id']); ?>"><?php echo htmlspecialchars($this->_var['sec_good']['goods_name']); ?></a>&nbsp;&nbsp;已售<font color="#da1a19"><?php echo htmlspecialchars($this->_var['sec_good']['sales']); ?></font> <span><a class="anniu" href="javascript:add_to_shop(<?php echo htmlspecialchars($this->_var['sec_good']['spec_id']); ?>, 1, <?php echo htmlspecialchars($this->_var['sec_good']['store_id']); ?>);">马上抢</a></span></div>
                 <div class="money">
                     <div class="left">
                          <h2><?php echo price_format($this->_var['sec_good']['sec_price']); ?>&nbsp&nbsp<span><?php echo price_format($this->_var['sec_good']['price']); ?></span></h2>
                     </div>
                     <div class="right">
                          <ul class="time">
                          <li class="hours"></li>
                          <li class="none">:</li>
                          <li class="second"></li>
                          <li class="none">:</li>
                          <li class="miao"></li>
                          <div class="clear"></div>
                     </ul>
                     </div>
                     <div class="clear"></div>
                 </div>
              </div>
              </li>
              <?php endforeach; else: ?>
              <li>暂时没有秒杀商品</li>
              <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
            </ul>    
          </div>
        </div>
      
      
      
      <div class="bq_bkad" style="margin-top:10px;">
          <div class="bq_bk_slide">
            <a href="#"><img src="/themes/bqmart/images/bqad_4.jpg"  width="100%" ></a>
          </div>
      </div>
      
          <div class="pxui-area">
          <div class="bq_cplb_bg"></div>
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

var startTime = new Date();
startTime.setFullYear(2015, 1, 1);
startTime.setHours(23);
startTime.setMinutes(59);
startTime.setSeconds(59);
startTime.setMilliseconds(999);
var EndTime=startTime.getTime();
function GetRTime(){
	var NowTime = new Date();
	var nMS = EndTime - NowTime.getTime();
	var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
	var nH = Math.floor(nMS/(1000*60*60)) % 24;
	var nM = Math.floor(nMS/(1000*60)) % 60;
	var nS = Math.floor(nMS/1000) % 60;
	if (nMS < 0){
		$("#dao").hide();
		$(".banner_box .time").show();
	}else{
	   $(".banner_box .time").show();
	   $("#daoend").hide();
	   $("#RemainD").text(nD);
	   $(".hours").text(nH);
	   $(".second").text(nM);
	   $(".miao").text(nS); 
	}
}

$(document).ready(function () {
	var timer_rt = window.setInterval("GetRTime()", 1000);
});
</script>


<script type="text/javascript">
$('.spinnerExample').spinner({
	value:0,
	min:0
});
</script>



</html>
