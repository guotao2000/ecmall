<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $("#period_form").validate({
        errorPlacement: function(error, element){
            element.parents('td').append(error);
        },
        success: function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules: {
        	period: {
                required: true,                
                digits:true,
                min:1
            }
        },
        messages: {
        	period:{
        		required:'活动周期不能为空',
        		digits:'只能为整数',
        		min:'不能少于0'        		
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
    <li><span>秒杀时间管理</span></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_goods_qty">商品数量管理</a></li>
	<li><a class="btn3" href="index.php?module=seckill&act=set_store_seckill">店铺等级列表</a>
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
<form method="post" enctype="multipart/form-data" id="period_form">
	<table class="infoTable">
    	<tr>
        	<th class="paddingT15">秒杀时间(秒):</th>
        	<td><input type="text" id="period" name="period" value="<?php echo $this->_var['period']; ?>" /></td>
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