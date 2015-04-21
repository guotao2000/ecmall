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
        
		  <script src="/themes/bqmart/js/jquery.js"></script>
	 
    </head>
<body>
    <div class="com-content">
        
    	<div class="page-title">
           <!--<a href="<?php echo url('app=default'); ?>"><i class="retun"> </i></a>-->
            <?php echo $this->_var['qufujin']; ?>附近
           <a href="<?php echo url('app=default'); ?>"><i class="homebutom"></i></a>
		</div>
        
        
        <div class="shoplist" style="text-align:center;margin-bottom: 50px;margin-top:50px;">
            <div style="text-align:center;color:#E30308;background:#F3F2F1;float: left; margin-left: 29px;
    margin-top: -15px;font-size: 16pt;">
               选择店铺
            </div>
            <div id="seleyxw" style="border: 2px #E30308 solid;margin:10px; auto;padding-top:50px;padding-bottom:50px;" >
			
			

				<select id="sheng" style="width:83px;">
				<option>请选择省</option>
               <?php echo $this->html_options(array('options'=>$this->_var['shengs'],'selected'=>$this->_var['shengs_id'])); ?>
                </select>

				
				<select id="shi" style="width:83px;">
				<option>请选择市</option>
               <?php echo $this->html_options(array('options'=>$this->_var['shis'],'selected'=>$this->_var['shis_id'])); ?>
                </select>
			
				<select id="qu" style="width:83px;">
				<option>请选择区</option>
				<?php echo $this->html_options(array('options'=>$this->_var['qus'],'selected'=>$this->_var['qus_id'])); ?>
                </select>
			  <input type="hidden" id="region_id" value="<?php echo $this->_var['qus_id']; ?>" />
			     <input type="button" id="query" value="确  认" onclick="getalls();" style="color:#fff;background:#E30308;text-align:center;" />
            </div>
        </div>
        
		        
        <div class="shoplist">
            <h3>
                我附近的店铺
            </h3>
            <ul id="yxw" style="text-align:center;">
			
				<li>
					亲，请手动选择所在区域
				</li>
			
            </ul>
        </div>
        
     
      </div>
	  
	<div id="allmap"></div>
	
	<script type="text/javascript">

           $("#sheng").change(shengChange); 
		     $("#shi").change(shiChange); 
			  $("#qu").change(quChange); 
		   function shengChange()
		   {
              if (this.value > 0)
				{
					$("#region_id").val(this.value);
					var _self = this;
					//var url = REAL_SITE_URL + '/index.php?app=mlselection&type=region';
					var url = 'index.php?app=mlselection&type=region';
					$.getJSON(url, {'pid':this.value}, function(data){
						if (data.done)
						{
							if (data.retval.length > 0)
							{
								$(_self).next("select").html("<option>请选择市</option>");
								$("#qu").html("<option>请选择区</option>");
								var data  = data.retval;
								for (i = 0; i < data.length; i++)
								{
									$(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
								}
							}
						}
						else
						{
							alert(data.msg);
						}
					});
				}
		   }
		   function shiChange()
		   {
              if (this.value > 0)
				{
					$("#region_id").val(this.value);
					var _self = this;
					//var url = REAL_SITE_URL + '/index.php?app=mlselection&type=region';
					var url = 'index.php?app=mlselection&type=region';
					$.getJSON(url, {'pid':this.value}, function(data){
						if (data.done)
						{
							if (data.retval.length > 0)
							{
								$(_self).next("select").html("<option>请选择区</option>");
								
								var data  = data.retval;
								for (i = 0; i < data.length; i++)
								{
									$(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
								}
							}
						}
						else
						{
							alert(data.msg);
						}
					});
				}
		   }
		   function quChange()
		   {
              if (this.value > 0)
				{
					$("#region_id").val(this.value);
				}
			}
			function getalls(){
			$.ajaxSettings.async = false;  
			var regionid=$("#region_id").val();
			
			  $.get("/index.php?app=default&act=getAlls&region_id="+ regionid+"", function(result){
				//http://wap.bqmart.cn/index.php?app=store&act=redirect&id=42
				
				    $("#yxw").html(result);
				
				 
			  });
			
			}
    </script>
</body>
</html>