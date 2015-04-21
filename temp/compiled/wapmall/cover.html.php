<!doctype html>
<html>
    <head>
        <title>倍全商城-选择店铺</title>
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
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/style/com/com.css'; ?>"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/style/shop/shop.css'; ?>"/>
        
   		<script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
		  <script src="http://ceshi.bqmart.cn/themes/bqmart/js/jquery.js"></script>
	   <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=2667f496b45f6c9c4e64e6cd8f0344ed"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <script>
        var wxtype=0;
		var xunhuan=0;
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
			//alert("微信位置：（"+longitude+","+latitude+"）");
			  $.get("/index.php?app=default&type=weixin&act=yxw&s_long="+longitude+"&s_lat="+latitude+"", function(result){
				//http://wap.bqmart.cn/index.php?app=store&act=redirect&id=42
				if(result>0)
				  {
                    window.top.location.href="/index.php?app=storeyxw&id="+result;
				   
				  }else
				  {
					 // alert("该位置没有合适的店铺，请手动选择店铺!");
					  window.top.location.href="/index.php?app=storeyxw&id=8805&status=0";
				  }
				  // $("#yxw").html(result);
			  });
		}
	});
	//}

	      });
		   
  </script>
	</head>
<body>
        <div class="com-content"  style="position:absolute;z-index:-1;width:100%;height:100%;top:0px;left:0px;">
         <img src="/themes/bqmart/images/bqmart3.gif"  alt="bqmart.cn" style="" width="100%" height="100%" />
        <!-- 店铺列表区域开始
        <div class="dingwei"  style="background-image:url('/themes/bqmart/images/dingwei.gif');background-position: center;
background-repeat: no-repeat; height: 62px; margin-top: 87px;">
        </div> -->
        
	<div id="allmap" style="display:none;"></div>
	</div>
	   
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
			
			  $.get("/index.php?app=default&type=baidu&act=yxw&s_long="+ r.point.lng+"&s_lat="+r.point.lat+"", function(result){
				//http://wap.bqmart.cn/index.php?app=store&act=redirect&id=42
				if(result>0)
				  {
                  alert(1);
                    window.top.location.href="/index.php?app=storeyxw&id="+result;
				   
				  }else
				  {
					 // alert("该位置没有合适的店铺，请手动选择店铺!");
					   window.top.location.href="/index.php?app=storeyxw&id=8805&status=0";
				  }
				  // $("#yxw").html(result);
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
</body>
</html>
