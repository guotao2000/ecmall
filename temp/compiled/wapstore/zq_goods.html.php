<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->_var['store']['store_name']; ?></title>
 <meta content="width=device-width,user-scalable=no" name="viewport">
<link href="/themes/bqmart/style/zq_goods.css" type="text/css" rel="stylesheet"/>
<link href="/themes/bqmart/style/yxw_goods.css" type="text/css" rel="stylesheet"/>
<link href="/themes/bqmart/style/zq_change_location.css" type="text/css" rel="stylesheet"/>
<link href="/themes/bqmart/style/zq_details.css" type="text/css" rel="stylesheet"/>
<script src="/themes/bqmart/js/zq_jquery.min.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/touch-0.2.14.min.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/CommonPerson.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/tools.js" type="text/javascript"></script>
 <script type="text/javascript" src="/includes/libraries/javascript/ecmall.js" charset="utf-8"></script>
 <script src="/themes/bqmart/js/zq_fly.js" type="text/javascript"></script>
 <script src="/themes/bqmart/js/float.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/zq_index.js" type="text/javascript"></script>
<script src="/themes/bqmart/js/zq_requestAnimationFrame.js" type="text/javascript"></script>

<script src="/themes/bqmart/js/jquery.pure.tooltips.js" type="text/javascript"></script>

		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=2667f496b45f6c9c4e64e6cd8f0344ed"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<style type="text/css">
body {
    font-family: "微软雅黑";
}
/*全屏背景遮罩层*/
.loadingPage_bg1 {
	background:none repeat scroll 0 0 #000;
	height:100%;
	left:0; /*:rgba(0,0,0,0.5);*/
	opacity:0.7;
	filter:alpha(opacity=70);
	width:100%;
	position:absolute;
	top:0px;
	z-index:110;
}
/*局部背景遮罩*/
.loadingPage_bg {
	background:none repeat scroll 0 0 #fff;
	height:100%;
	left:0; /*:rgba(0,0,0,0.5);*/
	opacity:1;
	filter:alpha(opacity=100);
	width:100%;
	z-index:110;
}

#loadingPage {
	display:block;
	font-weight:bold;
	font-size:12px;
	color:#595959;
	height:28px;
	left:50%;
	line-height:27px;
	margin-left:-74px;
	margin-top:-14px;
	padding:10px 10px 10px 50px;
	position:absolute;
	text-align:left;
	top:50%;
	width:148px;
	z-index:111;
	background:url(/themes/bqmart/images/loading.gif) no-repeat scroll 12px center #FFFFFF;
	border:2px solid #86A5AD;
}
.s_op .op1, .s_op .op2 {
  width: 30px;
  height: 28px;
  background-color: #FFF;
  border: thin solid #999;
  border-radius: 30px 30px 30px 30px;
  float: right;
  text-align: center;
  font-size: 18px;
  font-weight: 500;
  color: #999;
  margin-top: 3px;
  padding-top: 3px;
  margin-left: 5px;
}

</style>
<script>
			var wxtype=0;
			var xunhuan=0;
			var keyile=0;
			wx.config({
			//debug: true,
			appId: '<?php echo $this->_var['signPackage']['appId']; ?>',
			timestamp: <?php echo $this->_var['signPackage']['timestamp']; ?>,
			nonceStr: '<?php echo $this->_var['signPackage']['nonceStr']; ?>',
			signature: '<?php echo $this->_var['signPackage']['signature']; ?>',
			jsApiList: [
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			 'getLocation'
			]
		 });
			  
		 wx.ready(function () {
			
			 //while(wxtype<1&&xunhuan<4) {
			 //xunhuan=xunhuan+1;
			 wx.getLocation({
			success: function (res) {
				wxtype=1;
				
				var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
				var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
				var speed = res.speed; // 速度，以米/每秒计
				var accuracy = res.accuracy; // 位置精度
				$.ajaxSettings.async = false;  
				url="/index.php?app=address&type=weixin&act=get_local&s_long="+longitude+"&s_lat="+latitude+"";
				  $.getJSON(url, '', function(result){
				   keyile=1;
                   if(result.retval.region_id>0)
				    {
                     
					   $("#dingwei").val(result.retval.region_id);
					   $("#dizhi").html(result.retval.region_name);
					   $("#dingdiv").show();
					}
					else
					  {
						$("#dingwei").val(0);
					   $("#dingdiv").show();
					  }
				
				  });
			}
		});
		//}

			  });
			  
			  
			  function dingwei1()
			  {
			  if(keyile>0){
			  window.location.href="index.php?app=address&act=add_address&store_id=<?php echo $this->_var['store_id']; ?>&region_id="+ $("#dingwei").val()+"";
			  }
			  
			    
			  }
			  
			  function tiaozhuan(id)
			  {
			    url="/index.php?app=default&act=get_store&id="+id;
				 $.get(url, '', function(result){
				 //alert(result);
				   if(result>0)
				   {
				  // alert(result);
				   window.location.href="/index.php?app=storeyxw&status=1&id="+result;
				   }else{
				    alert('陛下，您点击的位置没有合适的店铺，请更换别的地址试试！');
				   }
				 });
				
			  }
			   
	  </script>
	  <style>
	  .makeorder_shdz-add {
			
			padding: 5px 15px;
		}



	  </style>
      <script type="text/javascript">
		    //控制退换货弹出层的js函数开始 
            function showDiv(){
            document.getElementById('popDiv').style.display='block';
            document.getElementById('bg_wn').style.display='block';
            }
            
            function closeDiv(){
            document.getElementById('popDiv').style.display='none';
            document.getElementById('bg_wn').style.display='none';
            }
			
			function showsearch(){
            document.getElementById('searchbox').style.display='block';
            document.getElementById('bg_wn').style.display='block';
            }
            
            function closesearch(){
            document.getElementById('searchbox').style.display='none';
            document.getElementById('bg_wn').style.display='none';
            }
            //控制退换货弹出层的js函数结束
      </script>
</head>

<body style="overflow: hidden">
	<div id="index" style="display:block;">
    	 
        <div class="head" id="tanchu_chuang">
             <a onclick="return false;" id="a_search"><img src="/themes/bqmart/images/ic_search.png" width="30" height="30" style="  position: absolute;  top: 5px;  left: 5px;"></a>
            <div id="ps" style="width:170px;">
                <p class="head_name"><?php echo $this->_var['qufujin']; ?>附近&nbsp;&nbsp;▼</p>
            </div>
            <a href="/index.php?app=member"><img src="/themes/bqmart/images/pc.png" width="30" height="30"></a>
        </div>
		
		<div class="tanchuang" style="margin-top:0px;display:none;background-color:none;" id="popDiv" >
        <div class="tc_head" style="  margin-left: 0px;background-image:url(/themes/bqmart/images/tc_top.png) ;background-size:100% 100%; height: 29px;width: 330px;"></div>
		     
     <div class="pxui-area" style="background-color: #fff;margin-top: -11px;">
        
         <div class="bq_makeorder-box" id="js-attrs-title">
		 
            <div class="makeorder_shdz-add" style="font-weight: bold;border-bottom:none;padding: 5px 15px;font-size:25px;margin: 10px; border-bottom: 1px solid #ddd;" >
		      选择收货地址
            </div>
            
            
            <div class="makeorder_shdz-add" style="border-bottom:none;padding: 5px 15px;" id="dingdiv">
		      <img src="/themes/bqmart/images/tc_location.jpg" style="  width: 152px;
  height: 38px;" onclick="dingwei1();return false;"/>
             <div class="dizhi" id="dizhi">吉晟别墅</div>
            </div>
            
         <script>
		 function qule(url)
		 {
		   window.top.location.href=url;
		 }
		 
		 </script>
          <div class="aalls" style="height:229px;  width: 324px;overflow-y: scroll;">
            
            <?php $_from = $this->_var['address']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'addr');if (count($_from)):
    foreach ($_from AS $this->_var['addr']):
?>
            <div class="bq_adders-select" style="<?php if ($this->_var['addr']['enable'] == 1): ?>   background-color: #E5E5E5; <?php endif; ?>margin-top:12px;margin-left: 24px;width:300px;  height: 60px;  border-bottom: 1px solid #ddd;">
          
            
				<div class="loc_left" style="width:25px;height:25px;float:left;background-image:url(/themes/bqmart/images/tc_select.png);background-size:100% 100%;"></div>
                <div class="bq_adders-name" style="  width: 220px;  float: left;  overflow: hidden;
  text-overflow: ellipsis;white-space: nowrap;" onclick="tiaozhuan(<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>);return false;">
                        <p class="xingdian" style="text-align:left;font-weight: normal;font-size:19px;"><?php echo htmlspecialchars($this->_var['addr']['consignee']); ?> <span>&nbsp; <?php echo htmlspecialchars($this->_var['addr']['phone_mob']); ?></span></p>
                        <p class="address" style="text-align:left;color: #F07C05;"><?php echo htmlspecialchars($this->_var['addr']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['addr']['address']); ?></p>
                </div>
				<span class="tbl-cell text-right" style="margin-left:21px;width: 25px;height:25px;margin-top: 10px; float: left;background-image:url(/themes/bqmart/images/bianji.jpg);background-size:100% 100%;" onclick="qule('index.php?app=address&act=edit_address&store_id=<?php echo $this->_var['store_id']; ?>&addr_id=<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>');">
                      
    			</span>

             
            </div>
            <?php endforeach; else: ?>
            暂时没有地址
            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?></div>
             
		    
            <div class="makeorder_shdz-add" style="font-weight: bold;border-bottom:none;padding: 5px 15px;font-size:25px;margin: 10px;color: #F07C05;" >
		      <a class="makeorder_btn-addr" style="color:#F07C00;text-decoration:none;" onclick="dingwei1();return false;">新建收货地址</a>
            </div>
            
         </div>
          
     </div>
     
		
		
		 <div class="tc_bottom" style="margin-top: -11px;background-image:url(/themes/bqmart/images/tc_bottom.png);height: 10px;background-size:100% 100%;width: 300px;"></div>
		</div>
		<div class="search tanchuang" id="searchbox" style="width:100%;  margin-top: 0px;  display: block;margin-left:0px; ">
		
		<input type="text" id="searchinput" style="width:75%;  height: 35px;"/><input type="button" value="搜索" style="width:25%;  height: 35px;"  onclick="gosearch();"/>
		</div>

       <div id="bg_wn" class="bg_wn" style="display:none;"></div>

        
        <div id="contenter">
        	
           <div class="cont_l">
             
                
                <div id="nav">
                    <div class="expmenu">
                        <div class="zq_nav">
                            <div class="header bqsh">
                                <span >倍全生活</span>                                                               
                            </div>
                        </div>
                         <div class="zq_nav" >
                            <div class="header">
                                <span>特色服务</span>
                                <span class="arrow down"></span>
                            </div>
                            <div class="menu"  style="display:block;">
							    
                              <?php echo $this->_var['menu_content']; ?>					
                            </div>
                        </div>
                        <div class="zq_nav">
                            <div class="header">
                                <span>网络超市</span>
                                <span class="arrow down"></span>
                            </div>
                            <div class="menu"  style="display:block;">
							    <?php $_from = $this->_var['cates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
                                <div id="cate_<?php echo $this->_var['item']['cate_id_1']; ?>"  class="li" value="<?php echo $this->_var['item']['cate_id_1']; ?>"><div class="menu2">
                                    <a href="javascript:void(0)"><span class="point fr"></span><?php echo $this->_var['item']['cate_name']; ?><span class="point fl"></span></a>
                                    </div>
							    </div>
								 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
         
            <div class="cont_r" style="display:block;" >
            	<div id="bqmart01" style="display:block;margin-right: 0;">
			    
					
                </div>
				
				<div id="wangshang" value="cate_a" style="display:block;height:50px;">
				<div class="xinshuju" style="display:block;text-align: center;"><span>向上拖动加载数据</span>
				<span class="xinfenlei"></span>
			
				</div>
				</div>
            </div>

        
    	    <div class="footer">
            <div class="f_show">
                <div class="f_gwc">
                    <img src="/themes/bqmart/images/gwc2hui.png" width="30px">
                </div>
                <i id="end"></i>
                <div id="f_num"><?php echo $this->_var['count']; ?></div>
            </div>
            <div class="f_t1">
                <p>共<span id="amount"><?php echo price_format($this->_var['amount']); ?></span>元 </p>
                <p>满￥<?php echo $this->_var['shipping']; ?>，免运费</p>
            </div>
            <div  class="f_t2">
                <div class="money_no">差<span id="peisong">1</span>件可配送</div>
                <div class="money_yes">选好了</div>
            </div>
            <div class="f_bg"></div>
        
        </div>
        </div>
    </div>
	<div id="details"  style=" display:none;position:absolute;
	z-index:1000;">
    	
    	<div class="detail_bg"></div>
       <div class="d_all">
       			
                
                <div class="d_info">
                    
                    <div class="d_pic">
						 <div class="share" style="width:100%;max-width:640px;height:27px;position:fixed;top:102px;z-index:1000;">
						
							<span class="action" style="background-color: #ee7700;border-radius: 11px;line-height: 20px;
			padding: 1px;position:absolute;text-align: center;	top:5px;left:5px;width: 20px;z-index: 100;">
							   <img alt="分享" src="/themes/bqmart/images/action.png">
							</span>
							<span class="qd" style="font-size: 14px; position:absolute;top:5px;right:10px;z-index: 200;">确定</span>
						  </div>
						  <div class="detail_pic">
							  <a href="javascript:void(0)">
							   <img class="lazy" src="" style="float:left;">
							   </a>
						  </div>
										 
					</div>                
                    
                    <div class="detail_price" value="">
                    	<div class="detail_name" style="padding-left: 23px;border-bottom: 1px solid #ddd;font-size: 16px;height: 20px;padding-bottom: 5px;padding-top: 5px;"></div>
                        <div class="price" style="padding-left: 23px;">￥<span></span></div>
                        <div class="detail_op">
                        	<span class="op1">-</span>
                            <span class="s_num">0</span>
                            <span class="op2">+</span>
                        </div>
                    </div>	
                </div>
                
                <div class="detail_guige">
                	<ul>
                    	<li style="border-bottom:#ddd solid thin;">品牌&nbsp;&nbsp;&nbsp;&nbsp;：<span class="pinpai">千禧</span></li>
                        <li>产品类别：<span class="guige">350g</span></li>
                    </ul>
                </div>
                
                <div class="detalis_ad" style="display:block;margin-top:30px;padding-top:30px; 
	background-color:#ECEDF1;margin-top:10px;border-top:#BBBBBB solid thin;">
	         <img src="/themes/bqmart/images/bqkd.png" alt="倍全快递，随时随递">
                </div>
            </div> 
    </div>
	   
   <div class="bqad"  style="display:none;">
		 	      
					<?php echo $this->_var['ad_content']; ?>
					
					
	</div>
            
        	
	
	<input type="hidden" id="hd_store_id" value="<?php echo $this->_var['store']['store_id']; ?>" />
	<input type="hidden" id="hd_cateid" value="0" />
	<input type="hidden" id="hd_pages" value="0" />
    <input type="hidden" id="hd_status" value="1" />
	<div id="allmap" style="display:none;"></div>
	
	   
	<script type="text/javascript">
	if(!wxtype){
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(116.331398,39.897445);
	map.centerAndZoom(point,12);

	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			var mk = new BMap.Marker(r.point);
			map.addOverlay(mk);
			map.panTo(r.point);
			//alert('百度位置：'+r.point.lng+','+r.point.lat);
			$.ajaxSettings.async = false;  
			
			  $.getJSON("/index.php?app=address&type=baidu&act=get_local&s_long="+ r.point.lng+"&s_lat="+r.point.lat+"", function(result){
			  //alert('baidu'+result);
			  keyile=1;
			     if(result.retval.region_id>0)
				    {
                     
					   $("#dingwei").val(result.retval.region_id);
					   $("#dizhi").html(result.retval.region_name);
					    $("#dingdiv").show();
					}
					else
					  {
						$("#dingwei").val(0);
						   $("#dingdiv").show();
					  }
			  });
			 // alert(1);
		}
		else {
			alert('failed'+this.getStatus());
		}        
	},{enableHighAccuracy: true})
	//关于状态码
	//BMAP_STATUS_SUCCESS	检索成功。对应数值“0”。
	//BMAP_STATUS_CITY_LIST	城市列表。对应数值“1”。
	//BMAP_STATUS_UNKNOWN_LOCATION	位置结果未知。对应数值“2”。
	//BMAP_STATUS_UNKNOWN_ROUTE	导航结果未知。对应数值“3”。
	//BMAP_STATUS_INVALID_KEY	非法密钥。对应数值“4”。
	//BMAP_STATUS_INVALID_REQUEST	非法请求。对应数值“5”。
	//BMAP_STATUS_PERMISSION_DENIED	没有权限。对应数值“6”。(自 1.1 新增)
	//BMAP_STATUS_SERVICE_UNAVAILABLE	服务不可用。对应数值“7”。(自 1.1 新增)
	//BMAP_STATUS_TIMEOUT	超时。对应数值“8”。(自 1.1 新增)
	}
    </script>

			<input type="hidden" value="" id="dingwei" style="height:0px;" />
	</div>
	   
	
<script>
		function bqsh()
		{
		  var content=$(".bqad").html();
		  $(".cont_r #bqmart01").html(content);
		   $("#bqmart01").parent().scrollTop(0);
		   $("#wangshang").attr("value",'cate_a');
		   $("expmenu .zq_nav").find("span").removeClass('selected');
		   $(".xinshuju").html('');
		}

$(document).ready(function(){
          win_width=$(window).width();
		  div_width=$(".tanchuang").width();
		  div_left=(win_width-div_width)/2;
		  $(".tanchuang").css("margin-left",div_left+'px');
		   $(".search").css("margin-left",'0px');
          <?php if ($_GET['status'] == 0): ?>   
		       showDiv();
		       int_i=1;
		  <?php else: ?>
               closeDiv();
		       int_i=0;
		  <?php endif; ?>
		  
		   
		   $("#bg_wn").click(function(){

			closeDiv();
			 int_i=0;
			  closesearch();
		     int_j=0;

			});
       (function(){
	   touch.on('#bqmart01', 'touchmove', function(event) {
	   
			//event.preventDefault;
			if($("#wangshang").offset().top<($(window).height()-10)&&parseInt($("#hd_status").val())==1)
			{
			   $("#hd_status").val(0);
			  // CommonPerson.Base.LoadingPic.FullScreenShow();

	var cate_id=$("#hd_cateid").val();
		var page_num=parseInt($("#hd_pages").val())+1;
		//alert(page_num);
		//$.ajaxSettings.async = false;
		var store_id=GetQueryString("id");
		if(store_id !=null && store_id.toString().length>1)
		{
		  store_id=GetQueryString("id");
		}
		var url = '/index.php?app=storeyxw&act=get_goodsyxw&cate_id='+cate_id+'&page='+page_num+'&store_id='+store_id+'';
	
			$.getJSON(url, '', function(data){
			if (data.done)
			{
			
				 if (data.retval.length > 0)
				 {
				 //alert(data.retval.length);
				 $("#hd_pages").val(parseInt($("#hd_pages").val())+1);
						var data  = data.retval;
						var content='';
						for (i = 0; i < data.length; i++)
						{
						content=content+
						'<div class="show" value="'+data[i].spec_id+'">'+
							 '<div class="show_pic" >'+
								'<a href="javascript:void(0)"> <img class="lazy" style="float:left;" src="/'+data[i].default_image+' "/></a>'+
							 '</div>'+                           
							' <div class="t">'+
								' <div class="tt" style="float:left;" >'+
									  '<div class="text"><span class="n2">'+data[i].goods_name+'</span></div>'+
								 '</div>'+
								 '<div>'+
									  '<div id="aaa"><span class="c price">'+data[i].price+'</span><span class="c">元</span> </div>'+
									  '<div ><span style="text-decoration:line-through; color:#999">原价'+data[i].shichang+'元</span></div>'+
									  '<div class="s_op" >'+
											  '<div class="op1" style="float:left;" value="'+data[i].spec_id+'">-</div> '+
										'<div class="s_num" style="font-size:18px;float:left;margin-top: 10px; " id="spec_'+data[i].spec_id+'"  value="'+data[i].spec_id+'">0</div>'+
										   '<div class="op2" style="float:right;" value="'+data[i].spec_id+'">+</div> '+                                                          
									  '</div>'+
								 '</div>'+
							   
							 '</div>'+
						
						'</div>';
						if(i==data.length-1)
						{
						 $("#hd_status").val(1);
						}
						}
						
						$(".cont_r #bqmart01").append(content);
						content=null;
						//CommonPerson.Base.LoadingPic.FullScreenHide();
						//$("#hd_sumtouch").val("0");
						
						$(".show .op2").unbind("click").on('click', addProduct).on('click', op2jia);
						$("#contenter .op1").unbind("click").on('click', op1jian);
						$('.show_pic').unbind("click").on('click', showpic);
						$('.n2').unbind("click").on('click', showimage);
						$('#details .op2').unbind("click").on('click', op2jia_d);
						$('#details .op1').unbind("click").on('click', op1jian_d);
						$(".show .text").width($(window).width()-200);
						$(".s_num").each(function(){
							if($(this).html()<1) 
							{
								$(this).prev(".op1").hide();
								$(this).hide();
							}
							 
						 });
					 $(".xinshuju").html('向上拖动加载数据');	 
				 }else{
				  $(".xinshuju").html('本分类数据加载完毕');
				 }
				// CommonPerson.Base.LoadingPic.FullScreenHide();
				// $("#hd_sumtouch").val("0");
				
				 
			}
			else
			{ 
				alert(data.msg);
				//CommonPerson.Base.LoadingPic.FullScreenHide();
               //$("#hd_sumtouch").val("0");
				 $(".xinshuju").html('本分类数据加载完毕');
			}
		});	
			}
        });
	   })();
        bqsh();
		$(".bqsh").on("click",bqsh);
        peisong(<?php echo $this->_var['count']; ?>);
		$(".detail_name").width($(window).width()-41);
		
		$('#ps').click(function() {
		   if(int_i)
		   {
		   closeDiv();
		   int_i=0;
		   }else{
		   showDiv();
		   int_i=1;
		   }
			
		});
		 closesearch();
		int_j=0;
			$('#a_search').click(function() {
		   if(int_j)
		   {
		   closesearch();
		   int_j=0;
		   }else{
		    showsearch();
		   int_j=1;
		   }
			
		});
		
            
             
//$(".share").floatdiv({left:"0px",top:"102px"});
});




</script>
	</body>
</html>
