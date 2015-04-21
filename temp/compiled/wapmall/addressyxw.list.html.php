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
        
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=2667f496b45f6c9c4e64e6cd8f0344ed"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
				  $.get(url, '', function(result){
				   keyile=1;
                   if(result>0)
				    {
                     
					   $("#dingwei").val(result);
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
				   if(result>0)
				   {
				  // alert(result);
				   window.location.href="/index.php?app=storeyxw&id="+result;
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
</head>
<body>
<div class="com-content" style="box-shadow:none;">

  <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">收货地址列表</span>

		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">

  <div class="page-role good-page">
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />	
     
     <div class="pxui-area">
        
         <div class="bq_makeorder-box" id="js-attrs-title">
            
            <div class="makeorder_shdz-add" style="border-bottom:none;display:none;padding: 5px 15px;" id="dingdiv">
		      <a class="makeorder_btn-addr" style="color:#e4393c;" onclick="dingwei1();return false;" >+定位到当前位置</a>
            </div>
            

			
            <div class="makeorder_shdz-add" style="border-bottom:none;padding: 5px 15px;" >
		      <a class="makeorder_btn-addr" style="color:#e4393c;" href="index.php?app=address&act=add_address&store_id=<?php echo $this->_var['store_id']; ?>">+添加收货地址</a>
            </div>
            
            
            <?php $_from = $this->_var['address']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'addr');if (count($_from)):
    foreach ($_from AS $this->_var['addr']):
?>
            <div class="bq_adders-select">
                <span  class="bq_adders-ht"></span>
            	<div class="bq_adders-info"  style="<?php if ($this->_var['addr']['enable'] == 1): ?> background-color: #E5E5E5; <?php endif; ?>">
                	<div class="bq_adders-name">
                        <p><?php echo htmlspecialchars($this->_var['addr']['consignee']); ?> <span>&nbsp; <?php echo htmlspecialchars($this->_var['addr']['phone_mob']); ?></span></p>
                        <p><?php echo htmlspecialchars($this->_var['addr']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['addr']['address']); ?></p>
                    </div>
                    <div class="bq_addersbg-border"></div>
                    <div class="bq_adders-btn">
                    	<span class="adders-tbl-type">
                           <span class="tbl-cell">
                            <a style="width:100%" class="btn-chk" onclick="tiaozhuan(<?php echo htmlspecialchars($this->_var['addr']['addr_id']); ?>);return false;"><span <?php if ($this->_var['addr']['enable'] == 1): ?>  <?php endif; ?>></span><b style="padding:3px 6px; background:#f33837;color: #fff;cursor: pointer;text-align: center;text-shadow: 1px 1px 1px #c64e13; font-weight:normal;">送到这里去</b></a>
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

</div>
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
			
			  $.get("/index.php?app=address&type=baidu&act=get_local&s_long="+ r.point.lng+"&s_lat="+r.point.lat+"", function(result){
			  //alert('baidu'+result);
			  keyile=1;
			     if(result>0)
				    {
                     
					   $("#dingwei").val(result);
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
</body>
</html>
