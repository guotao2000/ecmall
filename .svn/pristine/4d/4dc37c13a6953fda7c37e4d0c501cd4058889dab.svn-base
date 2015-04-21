<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $("#goods_qty_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parents('td');
            //error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success: function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules: {        	
        	goods_qty: {
                required: true,
                digits:true
            }
        },
        messages: {        	
        	goods_qty: {
                required: '活动商品总数不能为空',
                digits:'只能为整数'
            }
        }
    });
});
//]]>
</script>
<div id="rightTop">
  <p>秒杀促销</p>
  <ul class="subnav">
  <li><a class="btn3" href="index.php?module=seckill&act=set_start_time">设置开始时间</a></li>
	</li>
  	<li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><span>商品数量管理</span></li>    
	<li><a class="btn3" href="index.php?module=seckill&act=set_store_seckill">店铺等级列表</a>
	</li>
		<li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a>
	</li>
	<li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_apply">待审核</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_subject">秒杀主题</a>
	</li>
  </ul>
</div>

<div class="info">
<form method="post" enctype="multipart/form-data" id="goods_qty_form">
	<table class="infoTable">
    	<tr>
        	<th style="width:152px;">秒杀促销活动总商品件数:</th>
        	<td><input type="text" id="goods_qty" name="goods_qty" value="<?php echo $this->_var['goods_qty']; ?>" />
        	<label class="field_notice">0为不限制活动数量</label></td>
        </tr>
        <tr>
        	<th></th>
            <td class="ptb20">
            	<input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="Submit2" value="重置" />
            </td>
        </tr>
	</table>
 </form>
</div>

<?php echo $this->fetch('footer.html'); ?> 