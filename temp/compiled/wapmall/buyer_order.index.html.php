<!doctype html>
<html>
  <head>
    <title>倍全商城-订单列表页</title>
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
    <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/good/index.css'; ?>" />
   <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/user/index.css'; ?>" />
    <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
    
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
    
    
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/swipe.js'; ?>" charset="utf-8"></script>
    
    
    <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/home/index.js'; ?>"></script>
    
    <script type="text/javascript" src="index.php?act=jslang"></script>
    <style type="text/css">
            /*退换货弹出层的样式开始 BY wei 2015.01.30*/
            .mydiv {
            background-color: #666666;
            text-align: center;
            line-height: 40px;
            font-size: 12px;
            font-weight: bold;
            z-index:99;
            width: 298px;
            height: 230px;
            left:50%;/*FF IE7*/
            top: 30%;/*FF IE7*/
			border-radius:5px;
            
            margin-left:-150px!important;/*FF IE7 该值为本身宽的一半 */
            margin-top:-60px!important;/*FF IE7 该值为本身高的一半*/
            
            margin-top:0px;
            
            position:fixed!important;/*FF IE7*/
            position:absolute;/*IE6*/
            
            _top:       expression(eval(document.compatMode &&
                        document.compatMode=='CSS1Compat') ?
                        documentElement.scrollTop + (document.documentElement.clientHeight-this.offsetHeight)/2 :/*IE6*/
                        document.body.scrollTop + (document.body.clientHeight - this.clientHeight)/2);/*IE5 IE5.5*/
            
            }
            .mydiv p{
				padding:12px 0px 0px;
				color:#FFF;
				font-size:16px;
				font-family:微软雅黑;
				font-weight:100;
				}
			.mydiv .kefu_dianhua{
				text-align:center;
				padding:0px 10px;
				height:40px;
				line-height:40px;
					}
            .mydiv .kefu_dianhua span{
				display:inline-block;
				width:45px;
				height:40px;
				background:url(themes/bqmart/images/ddchaxun_icon.png) center no-repeat;
				background-size:35px 30px;
				padding:2px;
				vertical-align:middle;
				}
			.mydiv .kefu_dianhua a{
				font-size:20px;
				color:#00fa12;
				font-weight:bold;
				}
		    .mydiv .dingdanhao {
				font-size:16px;
				height:35px;
				line-height:35px;
				color:#FFF;
				font-weight:100;
				}
			.mydiv .yuanyin{
				font-size:14px;
				color:#FFF;
				font-weight:100;
				}
			.mydiv .tijiao{
				height:50px;
				line-height:50px;
				}
			.mydiv .guanbi_btn{
				display:block;
				color:#FFF;
				height:30px;
				width:30px;
				margin:0 auto;
				line-height:27px;
				font-size:18px;
				background:#F52121;
				border-radius:30px;
				position:absolute;
				top:5px;
				right:5px;
				}
            .bg {
            background-color: #ccc;
            width: 100%;
            height: 100%;
            left:0;
            top:0;/*FF IE7*/
            filter:alpha(opacity=50);/*IE*/
            opacity:0.5;/*FF*/
            z-index:1;
            
            position:fixed!important;/*FF IE7*/
            position:absolute;/*IE6*/
            
            _top:       expression(eval(document.compatMode &&
                        document.compatMode=='CSS1Compat') ?
                        documentElement.scrollTop + (document.documentElement.clientHeight-this.offsetHeight)/2 :/*IE6*/
                        document.body.scrollTop + (document.body.clientHeight - this.clientHeight)/2);/*IE5 IE5.5*/
            
            }
            /*退换货弹出层的样式结束 End  Wei 2015.01.30*/
            
        </style>
	    <script type="text/javascript">
		    //控制退换货弹出层的js函数开始 
            function showDiv(yxsn,oid){
            document.getElementById('popDiv').style.display='block';
            document.getElementById('bg').style.display='block';
           $("#yxwsn").html("订单号："+yxsn);
           $("#yxwhid").val(oid);
            }
            
            function closeDiv(){
            document.getElementById('popDiv').style.display='none';
            document.getElementById('bg').style.display='none';
            }
            //控制退换货弹出层的js函数结束

            function song()
            {
              var text=$("#yxwtext").val();
              var oid=$("#yxwhid").val();
              if(!text.length*oid.length)
              {
                 alert('退货原因不能为空！')
                 return false;
              }
              var url = '/index.php?app=buyer_order&act=thsq&oid='+oid+'&remark='+text+'';
              $.get(url, '', function(data){
                if (data==3)
                {
                   alert('退货申请成功');
                   //closeDiv();
                   window.top.location=window.top.location;
                }else
                {
                   alert('退货申请失败！不符合退货条件！');
                }
             });
            }
       </script>
  </head>
  <body>
    <div class="com-content" style="box-shadow:none;">
       
        <div class="com-header-area" id="js-com-header-area" style=" background-color: #FFF;
  border-bottom: 2px solid #ccc;color:#000;">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">订单列表</span>
         
		  <div class="clear"></div>
        </div>
      
	  
      <div id="popDiv" class="mydiv" style="display:none;">
      <form>
         <p>客官，退换货请拨打客服!</p>
         <div class="kefu_dianhua">
            <span></span><a href="wtai://wp/mc;[400-070-0707]">400-070-0707</a>
         </div>
         <div class="dingdanhao" id="yxwsn">
            订单号：1503588756
         </div>
         <div class="yuanyin">
           退货原因：<textarea id="yxwtext" cols="24" rows="2" style="border:none; font-size:14px;"></textarea>
         </div>
         <a href="javascript:closeDiv()" class="guanbi_btn">X</a>
         <div class="tijiao">
            <input name="yxwsub" onclick="song();" type="button" value="提 交" style="margin:0px; padding:3px 40px 5px; font-size:16px; border:none; border-radius:8px;background:#F52121; color:#FFF; cursor:pointer;">
         </div>
         <input type="hidden" id="yxwhid" />
        </form>
       </div>
       <div id="bg" class="bg" style="display:none;"></div>
      
       
        <div class="com-content-area" id="js-com-content-area">
          <div class="page-role user_order-page">
          
          <div class="pxui-area">
           
         <div  style="height:10px; background:#EDEBE9; clear:both;"></div>
           <div class="pxui-tab pxui-tab-style pxui-tab-no-top">
          <a href="<?php echo url('app=buyer_order&act=index&type=all'); ?>" <?php if ($this->_var['type'] == all): ?> class="selected" <?php endif; ?>>全部</a>
          <a href="<?php echo url('app=buyer_order&act=index&type=pending'); ?>" <?php if ($this->_var['type'] == pending): ?> class="selected" <?php endif; ?>>待付款</a>
          <a href="<?php echo url('app=buyer_order&act=index&type=accepted'); ?>" <?php if ($this->_var['type'] == accepted): ?> class="selected" <?php endif; ?> >待发货</a>
          <a href="<?php echo url('app=buyer_order&act=index&type=shipped'); ?>" <?php if ($this->_var['type'] == shipped): ?> class="selected" <?php endif; ?> >待收货</a>
          <a href="<?php echo url('app=buyer_order&act=index&type=finished'); ?>" <?php if ($this->_var['type'] == finished): ?> class="selected" <?php endif; ?> >已完成</a>
          </div>
         
         <div class="bq_cplb_bg" style="margin-top:-4px;"></div>
          <div class="pxui-shoes">
          
          <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
          <div class="user_orderlist-show" style="margin-bottom:15px;">
            <div class="order_showlist-title">
               <span class="order_shop-icon"></span>
               <p class="order_shop-name"><?php echo htmlspecialchars($this->_var['order']['seller_name']); ?>
               </p>
               <p class="order_shop-number" style="height:30px;overflow: hidden; color:#3152F2;">订单号：<?php echo htmlspecialchars($this->_var['order']['order_sn']); ?></p>
            </div>
            <div class="user_orderlist-info" >
              <ul>
              <?php $_from = $this->_var['order']['order_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                 <li>
                    <a href="javascript:return false;" style=" border-right:none; float:none; margin-left:0px;">
                     <img src="<?php echo $this->_var['goods']['goods_image']; ?>">
                    </a>
                   <div class="orderlist_Pre-info">
                     <p class="orderlist_Pre-name" style=" max-height:40px;">
                        <a href="javascript:return false;" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;padding-top:0px;" ><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                     </p>
                     <span class="orderlist_Pre-price">价格：&nbsp;&nbsp;<?php echo price_format($this->_var['goods']['price']); ?></span>
                     <span class="orderlist_Pre-number">数量：&nbsp;&nbsp;X&nbsp;&nbsp;<?php echo $this->_var['goods']['quantity']; ?></span>
                   </div>
                 </li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
              </ul>
            </div>
            <div class="order_list-btn" style="border-bottom:1px #b2b2b2 dashed; padding-bottom:10px; margin-top:10px;">
            	<b>&nbsp;&nbsp;订单状态：<font style="color:#b20005;">
                
                        <?php if ($this->_var['order']['status'] == 11): ?>等待买家付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 12): ?>等待买家收货付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 13): ?>买家已付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 20): ?>等待卖家发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 21): ?>货到付款已发货<?php endif; ?>
						<?php if ($this->_var['order']['status'] == 25): ?>订单已确认<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 30): ?>卖家已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 40): ?>交易完成<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 0): ?>交易关闭<?php endif; ?> 
                        <?php if ($this->_var['order']['status'] == 51): ?>退货申请中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 52): ?>退货审核中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 53): ?>退货失败<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 54): ?>退货成功<?php endif; ?> 

                </font></b>
            </div>
            <div class="order_list-btn">
              <?php if ($this->_var['order']['status'] == 11): ?>
              <a href="<?php echo url('app=cashier&order_id=' . $this->_var['order']['order_id']. ''); ?>" style="margin-left:0px; float:none;">去支付</a>
              <?php endif; ?>
              <?php if ($this->_var['order']['status'] == 13 || $this->_var['order']['status'] == 21 || $this->_var['order']['status'] == 30): ?>
              <a href="/index.php?app=buyer_order&act=evaluate&order_id=<?php echo $this->_var['order']['order_id']; ?>"  style="margin-left:0px; float:none;">确认收货</a>
              <?php endif; ?>
              <?php if ($this->_var['order']['status'] == 11 || $this->_var['order']['status'] == 12 || $this->_var['order']['status'] == 10): ?>
              <a href="javascript:cancel_order(<?php echo $this->_var['order']['order_id']; ?>);"  style="margin-left:0px; float:none;">取消</a>
              <?php endif; ?>
              <a href="<?php echo url('app=buyer_order&act=view&order_id=' . $this->_var['order']['order_id']. ''); ?>" style=" margin-left:0px; float:none; ">查看订单</a>
	
			  <?php if ($this->_var['order']['status'] == 40): ?>
			 <?php if ($this->_var['order']['evaluation_status'] == 1): ?> <a href="javascript:;" style="margin-left:0px; float:none;" >已评价</a><?php endif; ?>
			  <?php endif; ?>
			  <?php if ($this->_var['order']['status'] == 13 || $this->_var['order']['status'] == 21 || $this->_var['order']['status'] == 30): ?>
			  <a href="javascript:void(0)" style="margin-left:0px; float:none;" onclick="javascript:showDiv('<?php echo htmlspecialchars($this->_var['order']['order_sn']); ?>',<?php echo $this->_var['order']['order_id']; ?>)" >退换货</a>
			  <?php endif; ?>
              <!--<a href="#" style=" margin-left:0px; float:none; <?php if ($this->_var['order']['status'] != ORDER_FINISHED): ?>display:none;<?php endif; ?>" >再次购买</a>-->
                <!-- <?php if ($this->_var['order']['status'] == 13 || $this->_var['order']['status'] == 21 || $this->_var['order']['status'] == 30): ?>
              <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" style=" margin-left:0px; float:none;" >退换货</a>
              <?php endif; ?>
              <div>
              <div id="light" class="white_content" >
                <p style=" font-size:16px;">客官，想退换货请先致电客服：</p> 
                 <p style=" font-size:28px; padding:10px 0px; color:#F00;"> <?php echo $this->_var['order']['store_info']['tel']; ?></p> 
                 <p style=" font-size:14px;">注：根据规定生鲜产品不允许退换货</p> 
                <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" style=" height:20px; width:30px; float:none; position:absolute; top:0px; right:-10px; min-width:0px; padding:3px 10px 6px; ">关闭</a></div> 
        <div id="fade" class="black_overlay"></div>  -->
            </div>
            
            
            <div class="order_list-btn" style="display:none; text-align:left;" id="order_<?php echo $this->_var['order']['order_id']; ?>">
            	<form method="post" id="order_form_<?php echo $this->_var['order']['order_id']; ?>">
                	<p><input type="radio" checked name="cancel_reason_<?php echo $this->_var['order']['order_id']; ?>" value="改选其他商品" onClick="change_radio_r(<?php echo $this->_var['order']['order_id']; ?>)" /><label>改选其他商品</label></p>
                    <p><input type="radio" name="cancel_reason_<?php echo $this->_var['order']['order_id']; ?>" value="改选其他配送方式" onClick="change_radio_r(<?php echo $this->_var['order']['order_id']; ?>)" /><label>改选其他配送方式</label></p>
                    <p><input type="radio" name="cancel_reason_<?php echo $this->_var['order']['order_id']; ?>" value="改选其他卖家" onClick="change_radio_r(<?php echo $this->_var['order']['order_id']; ?>)" /><label>改选其他卖家</label></p>
                    <p><input type="radio" name="cancel_reason_<?php echo $this->_var['order']['order_id']; ?>" value="其他原因" onClick="change_radio(<?php echo $this->_var['order']['order_id']; ?>)" /><label>其他原因</label></p>
                    <p id="other_reason_<?php echo $this->_var['order']['order_id']; ?>" style="display:none;"><textarea class="text" style="width:200px;" name="remark_<?php echo $this->_var['order']['order_id']; ?>"></textarea></p>
                    <p><input type="button" name="btn_<?php echo $this->_var['order']['order_id']; ?>" id="btn_<?php echo $this->_var['order']['order_id']; ?>" value="确认" onClick="javascript:if(confirm('您是否确定要取消以下订单？')){post_data(<?php echo $this->_var['order']['order_id']; ?>);}" />&nbsp;&nbsp;<input type="button" name="btn_reset_<?php echo $this->_var['order']['order_id']; ?>" id="btn_reset_<?php echo $this->_var['order']['order_id']; ?>" value="取消" onClick="reset_data(<?php echo $this->_var['order']['order_id']; ?>)" /></p>
                </form>
            </div>
            
            
            
            <div class="order_list-btn" style="display:none; text-align:left;" id="confirm_order_<?php echo $this->_var['order']['order_id']; ?>">
            <form id="confirm_form_<?php echo $this->_var['order']['order_id']; ?>" style="padding:0px 10px; border-top:1px solid #ccc; ">
            <p style="color:#1695e6;padding:5px 0px; font-size:16px;">您是否确已经收到以下订单的货品？</p>
            <p>订单号:&nbsp;&nbsp;<span style="color:#1695e6;"><?php echo $this->_var['order']['order_sn']; ?></span></p>
            <p>注意:&nbsp;&nbsp;如果你尚未收到货品请不要点击“确认”。大部分被骗案件都是由于提前确认付款被骗的，请谨慎操作！ </p>
            <p style="text-align: center; margin-top:5px; border-top: 1px dashed #ccc; padding-top:10px;"><input type="button" value="确认" onClick="javascript:if(confirm('您确定要确认吗？')) confirm_yes(<?php echo $this->_var['order']['order_id']; ?>);" style="padding: 5px 20px; border-radius: 6px; border:none;background:#ec0000;color: #fff;" />&nbsp;&nbsp;<input type="button" onClick="confirm_cancel(<?php echo $this->_var['order']['order_id']; ?>)" value="取消"style="padding: 5px 20px; border-radius: 6px;" /></p>
        	</form>
            </div>
            
         
         </div>
         <?php endforeach; else: ?>
         <div class="null" style="display:none; margin-top:120px;">
         	<p><img src="/themes/mall/default/styles/wxmall/images/order_null.png" /></p>
            <p>你没有订单信息~</p>
            <p><a href="javascript:history.back(-1);" class="white_btn">去购物</a></p>
         </div>
         <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
         
          </div>
          <div class="page">
          	
           <?php if (! $this->_var['goods_list_order']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
           
          </div>
          </div>
          </div>
		</div>
        
		<script type="text/javascript">

		    //取消订单操作
		    function cancel_order(order_id) {
		        $('#order_' + order_id).slideDown('slow');
		    }

		    //取消操作
		    function reset_data(order_id) {
		        $('#order_' + order_id).slideUp('slow');
		    }

		    //单击显示其他原因
		    function change_radio(order_id) {
		        $('#other_reason_' + order_id).show();
		    }

		    //单击隐藏其他原因
		    function change_radio_r(order_id) {
		        $('#other_reason_' + order_id).hide();
		    }

		    //异步提交表单
		    function post_data(order_id) {
		        var reason = '';
		        var len = document.getElementsByName("cancel_reason_" + order_id).length;

		        //获取选中单选按钮
		        for (var i = 0; i < len; i++) {
		            if (document.getElementsByName("cancel_reason_" + order_id).item(i).checked) {
		                reason = document.getElementsByName("cancel_reason_" + order_id).item(i).value;
		            }
		        }

		        //获取其他原因输入内容
		        var remark = (document.getElementsByName("remark_" + order_id).item(0).value).length == 0 ? 'null_data' : (document.getElementsByName("remark_" + order_id).item(0).value);

		        //异步操作开始
		        var url = "index.php?app=buyer_order&act=cancel_order_new&order_id=" + order_id + "&reason=" + reason + "&remark=" + remark;
		        $.getJSON(url, '', function (data) {
		            if (data.done) {
		                alert('操作成功！');
		                $('#order_' + order_id).slideUp('slow');
		                location.reload();
		            } else {
		                alert(data.msg);
		            }
		        });


		    }

		    //以下为确认收货操作部分

		    function confirm_order(order_id) {
		        $('#confirm_order_' + order_id).slideDown('slow');
		    }

		    function confirm_cancel(order_id) {
		        $('#confirm_order_' + order_id).slideUp('slow');
		    }

		    //确认操作
		    function confirm_yes(order_id) {
		        //异步操作开始
		        var url = "index.php?app=buyer_order&act=confirm_order_new&order_id=" + order_id;
		        $.getJSON(url, '', function (data) {
		            if (data.done) {
		                alert('操作成功！');
		                $('#confirm_order_' + order_id).slideUp('slow');
		                location.reload();
		            } else {
		                alert(data.msg);
		            }
		        });
		    }
			
  		</script>

      
</div>

</body>
</html>
