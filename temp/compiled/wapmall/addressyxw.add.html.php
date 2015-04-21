<!doctype html>
<html>
    <head>
        <title>倍全商城-添加收货地址</title>
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
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/order/zepto.js'; ?>"></script>
        
        <script type="text/javascript" src="index.php?act=jslang"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'mlselection.js'; ?>" ></script>
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
			url="/index.php?app=address&type=weixin&act=get_local&s_long="+longitude+"&s_lat="+latitude+"";
			  $.getJSON(url, '', function(result){
		         if(result.status==0)
				  {
                    window.top.location.href="/index.php?app=storeyxw&id="+result;
				   
				  }else
				  {
					  alert("定位失败，请陛下手动选择地址!");
					  window.top.location.href="/index.php?app=default&act=cover";
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
<script type="text/javascript">
    $(function () {
        regionInityxw("region");
        newregionEdit($("#yxwedit"), <?php echo $this->_var['sregion_id']; ?>);
        $('#mySelectyxw').change(function(){ 
          //alert($(this).children('option:selected').val()); 
            newregionEdit($("#yxwedit"), $(this).children('option:selected').val());
          });
        var a=  $('#mySelectyxw').children('option:first');
          a.selected = true;
		   $('#mySelectyxw').change();
        $('#editAddressForm').submit(function () {
            //验证输入
            var consignee = $('#consignee').val();
            consignee = $.trim(consignee);
            var phone_mob = $('#phone_mob').val();
            phone_mob = $.trim(phone_mob);
            var sel_region = $('#region > select').val();
            sel_region = $.trim(sel_region);
            var address_detail = $('#address_detail').val();
            address_detail = $.trim(address_detail);

            //验证收货人姓名
            if (consignee.length == 0) {
                $('#nameErrorMsg').show();
                return false;
            } else {
                $('#nameErrorMsg').hide();
            }
            //收货人手机号码
            if (phone_mob.length == 0) {
                $('#mobileErrorMsgDiv').show();
                return false;
            } else {
                $('#mobileErrorMsgDiv').hide();
            }
			 if (phone_mob.length > 0) {
                if(!checkMobile(phone_mob)){
                     $('#mobileErrorMsgDiv').show();
                     return false;
                }
            } else {
                $('#mobileErrorMsgDiv').hide();
            }

            //所在地区
            if (sel_region == '--请选择地区--') {
                $('#regionErrorMsg').show();
                return false;
            } else {
                $('#regionErrorMsg').hide();
            }
            //收货人详细地址
            if (address_detail.length == 0) {
                $('#addressErrorMsg').show();
                return false;
            } else {
                $('#addressErrorMsg').hide();
            }

            return true;

        });




    });
function changeregion() {
    //$("select").get(0).value = 1;
   // $("select").get(0).change();

    $("select").get(0).change(function () {
        $("select").get(0).value = 1;
    });


}
//验证手机号函数
	    function checkMobile(tel) {
	        var reg = /^[1][3-9]\d{9}$/;
	        if (reg.test(tel)) {
	            return true;
	        } else {
	            return false;
	        }
	    }
</script>
<div class="com-content">

  <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">添加收货地址</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">

<div class="page-role good-page">	
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/order.css'; ?>" >	
  
     
     <div class="pxui-area">
        
        <form action="index.php?app=address&act=add_address&store_id=<?php echo $_GET['store_id']; ?>" method="post" id="editAddressForm">
         <div class="new-ct shouhuo">
            <div class="makeorder_shdz-title">
              <p>填写收货人信息</p>
            </div>
            <div class="info-list">
           
            <div class="info pd">
        	 <div class="tbl-type">
            	<span class="tbl-cell w80"><span>收货人姓名：</span></span>
                <span class="tbl-cell"><span><input maxlength="20" class="new-input" name="consignee" id="consignee" style="width:95%;" type="text"></span></span>
            </div>
           </div>
           
           
            <div class="info pd" style="display:none" id="nameErrorMsg">
        	  <div class="tbl-type">
            	<span class="tbl-cell w80"><span style="color:red">收货人姓名不能为空</span></span>
              </div>
            </div>
           
           
            <div class="info pd">
        	   <div class="tbl-type">
            	<span class="tbl-cell w100"><span>收货人手机号：</span></span>
                <span class="tbl-cell"><span><input maxlength="11" class="new-input" name="phone_mob" id="phone_mob" style="width:95%;  type="text""></span></span>
               </div>
            </div>
           
           
            <div class="info pd" id="mobileErrorMsgDiv" style="display:none">
        	 <div class="tbl-type">
            	<span class="tbl-cell w80"><span style="color:red" id="mobileErrorMsg">手机号码格式不正确！</span></span>
             </div>
           </div>
           
		   		    
           <div class="info pd">
        	   <div class="tbl-type">
            	<span class="tbl-cell w100" style="width: 113px;"><span>定位到当前位置：</span></span>
                <span class="tbl-cell"><span class="gps_addr" style="  position: absolute;width: 35px;height: 35px;left: 270px;margin-top: -18px;background:url(/themes/bqmart/images/gps.png) no-repeat;"></span></span>
               </div>
            </div>
           
           
		    <div class="info pd" style="<?php if ($this->_var['countrows'] > 0): ?>display:none;<?php endif; ?> padding:10px">
        	  <div class="tbl-type">
            	<span class="tbl-cell w100"><span>所在地区：</span></span>
                <span class="tbl-cell">                	
                    <span class="new-input-span">
                        <span class="new-sel-box new-p-re">
                          
                       <style type="text/css">
					   .region_select select{
					        background: none repeat scroll 0 0 #fff;
							border: medium none;
							color: #3c3c3c;
							font-size: 1em;
							padding: 0;
							border: 1px solid #ccc;
							padding: 0 0 0 10px;
							display: block;
							margin:10px 0px;
					   }
					   </style>
                       <p id="region" class="region_select">
                       <input type="hidden" name="region_id" value="<?php echo $this->_var['address']['region_id']; ?>" id="region_id" class="mls_id" />
                        <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['address']['region_name']); ?>" class="mls_names" />
                         <input type="hidden" value="编辑" id="yxwedit" />
                            <select>
                              <option>--请选择地区--</option>
                              <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                            </select>
        				</p>
                          
                        </span>
                    </span>
                </span>
             </div>
           </div>
           

           
            <div class="info pd" style="display:none" id="regionErrorMsg">
        	  <div class="tbl-type">
            	<span class="tbl-cell w80"><span style="color:red">所在地区不能为空！</span></span>
              </div>
            </div>
           
            
            <?php if ($this->_var['countrows'] > 0): ?>
            <div class="info  pd">
        	   <div class="tbl-type">
            	<span class="tbl-cell w100"><span>所在地区：</span></span>
                <span class="tbl-cell"><span>
                   <select id="mySelectyxw" style=" height:34px; line-height:34px; margin:10px 0px 10px 15px;">
                   <?php $_from = $this->_var['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['row']):
?>
                            <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['row']; ?></option>
                          
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>    
                </span></span>
               </div>
           </div>
 
           <?php endif; ?>
           
           
            <div class="info border-b-none pd">
        	  <div class="tbl-type">
            	<span class="tbl-cell w70"><span>详细地址：</span></span>
                <span class="tbl-cell"><span>
                <input  style="height:auto; width:95%;" type="text" class="new-input" name="address_detail" id="address_detail" />
                </span></span>
               </div>
           </div>
           
         </div>
         
		 <div class="info pd" style="display:none" id="addressErrorMsg">
        	<div class="tbl-type">
            	<span class="tbl-cell w80"><span style="color:red">地址信息不能为空</span></span>
            </div>
         </div>
         
         <div style=" width:100%; text-align:center;">
        <input type="hidden" name="store_id" value="<?php echo $this->_var['store_id']; ?>" />
    	<input type="submit" style="background:#f71f1f;border:none;background-color: #e50505;border-radius: 6px;color: #fff;
    font-family: 微软雅黑;font-size: 16px;padding: 8px 30%; margin:20px 0px;" name="submit1" value="保&nbsp;&nbsp;存"	/>
        </div>
</div>
         </div>
       </form>
         
     </div>
     
     
     <?php echo $this->fetch('member.footer.html'); ?>
     
</div> 

</div>

<?php echo $this->fetch('store.menu.html'); ?>


</body>
</html>
