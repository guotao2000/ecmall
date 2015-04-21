<!doctype html>
<html>
    <head>
        <title>倍全商城-编辑收货地址</title>
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
			   
</head>
<body>
<script type="text/javascript">
$(function(){
	regionInityxw("region");	
	$('#editAddressForm').submit(function(){
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
		if(consignee.length == 0){
			$('#nameErrorMsg').show();
			return false;
		} else {
			$('#nameErrorMsg').hide();	
		}
		//收货人手机号码
		if(phone_mob.length == 0){
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
		if(sel_region == '--请选择地区--'){
			$('#regionErrorMsg').show();
			return false;	
		} else {
			$('#regionErrorMsg').hide();
		}
		//收货人详细地址
		if(address_detail.length == 0){
			$('#addressErrorMsg').show();
			return false;
		} else {
			$('#addressErrorMsg').hide();	
		}
		
		return true;
		
	});
	
	
});

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
          <span class="bq_header_title" style="padding-left:0px;">编辑收货地址</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">

<div class="page-role good-page">	
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
  <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/index.css'; ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/order/order.css'; ?>" >	
  
     
     <div class="pxui-area">
        
        <form action="index.php?app=address&act=edit_address&store_id=<?php echo $_GET['store_id']; ?>" method="post" id="editAddressForm">
         <div class="new-ct shouhuo">
            <div class="makeorder_shdz-title">
              <p>填写收货人信息</p>
            </div>
            <div class="info-list">
           
            <div class="info pd">
        	 <div class="tbl-type">
            	<span class="tbl-cell w80"><span>收货人姓名：</span></span>
                <span class="tbl-cell"><span><input maxlength="20" class="new-input" name="consignee" id="consignee" style="width:95%;" type="text" value="<?php echo htmlspecialchars($this->_var['address']['consignee']); ?>"></span></span>
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
                <span class="tbl-cell"><span><input maxlength="11" class="new-input" name="phone_mob" id="phone_mob" style="width:95%;"  type="text" value="<?php echo htmlspecialchars($this->_var['address']['phone_mob']); ?>"></span></span>
               </div>
            </div>
           
           
            <div class="info pd" id="mobileErrorMsgDiv" style="display:none">
        	 <div class="tbl-type">
            	<span class="tbl-cell w80"><span style="color:red" id="mobileErrorMsg">手机号码格式不正确！</span></span>
             </div>
           </div>
           

           
		    <div class="info pd">
        	  <div class="tbl-type" style=" padding:10px 0px;">
            	<span class="tbl-cell w100"><span>收货地址：</span></span>
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
							margin-top:10px;
							margin-bottom:5px;
							display:block;
					   }
					   </style>
                       <p id="region" class="region_select">
                       <input type="hidden" name="region_id" value="<?php echo $this->_var['address']['region_id']; ?>" id="region_id" class="mls_id" />
                       <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['address']['region_name']); ?>" class="mls_names" />
                       <span><?php echo htmlspecialchars($this->_var['address']['region_name']); ?></span>
                        <input type="button" value="编辑" class="edit_region" onclick="newregionEdit(this,<?php echo $this->_var['address']['region_id']; ?>);"/>
                        <select style="display:none;" onchange="hide_error();">
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
           
           
            <div class="info border-b-none pd">
        	  <div class="tbl-type">
            	<span class="tbl-cell w70"><span>地址信息：</span></span>
                <span class="tbl-cell"><span>
                <input style="height:auto;width:95%;" type="text" class="new-input" value="<?php echo htmlspecialchars($this->_var['address']['address']); ?>" name="address_detail" id="address_detail" />
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
        <input type="hidden" name="addr_id" value="<?php echo $this->_var['address']['addr_id']; ?>" />
    	<input type="submit" style="background:#f71f1f;border:none;background-color: #e50505;border-radius: 6px;color: #fff;
    font-family: 微软雅黑;font-size: 16px;padding: 8px 30%; margin:20px 0px;"  name="submit1" value="保&nbsp;&nbsp;存"	/>
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
