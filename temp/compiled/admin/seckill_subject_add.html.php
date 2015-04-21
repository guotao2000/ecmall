<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>"></script>
<script type="text/javascript">
$(function(){
    $('#gcategory_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onfocusout : false,
        onkeyup    : false,
        rules : {
		<?php if (! $this->_var['sec_subject_info']): ?>
            subject_name : {
                required : true,
                remote   : {
                    url :'index.php?module=seckill&act=check_subject&ajax=1',
                    type:'get',
                    data:{
                        subject_name : function(){
                            return $('#subject_name').val();
                        }
                    }
                }
            },
		<?php endif; ?>
            subject_detail : {
                required : true
            }
        },
        messages : {
            subject_name : {
                required : '描述主题名称不能为空',
                remote   : '秒杀主题已经存在'
            },
            subject_detail  : {
                required : '秒杀主题描述不能为空'
            }
        }
    });
	/*$('#subject_name').blur(function(){
	    $.ajax({
		   type: 'get',
		   url: 'index.php?module=seckill&act=check_subject&ajax=1&subject_name='+encodeURI($('#subject_name').val()),
		   
		   success: function(msg){
		      alert(msg);
		   }
		});
	});*/
});
</script>
<div id="rightTop">
  <p>秒杀促销</p>
  <ul class="subnav">
    <li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_goods_qty">商品数量管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_store_seckill">店铺等级列表</a> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">待审核</a> </li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_subject">秒杀主题</a> </li>
    <li><span>新增秒杀主题</span> </li>
  </ul>
</div>
<div class="info">
    <form method="post" enctype="multipart/form-data" id="gcategory_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    秒杀主题名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="subject_name" type="text" name="subject_name" value="<?php echo htmlspecialchars($this->_var['sec_subject_info']['subject_name']); ?>" <?php if ($this->_var['sec_subject_info']): ?>readonly="readonly"<?php endif; ?> /> <label class="field_notice">秒杀主题名称</label>               </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    秒杀主题描述:</th>
                <td class="paddingT15 wordSpacing5"><textarea name="subject_detail" class="subject_detail"><?php echo htmlspecialchars($this->_var['sec_subject_info']['subject_desc']); ?></textarea>         </td>
            </tr>

            <tr>
              <th class="paddingT15">显示:</th>
              <td class="paddingT15 wordSpacing5"><p>
                <label>
                  <input type="radio" name="if_show" value="1" <?php if ($this->_var['sec_subject_info']['subject_state']): ?>checked="checked"<?php endif; ?> />
                  是</label>
                <label>
                  <input type="radio" name="if_show" value="0" <?php if (! $this->_var['sec_subject_info']['subject_state']): ?>checked="checked"<?php endif; ?> />
                  否</label> <label class="field_notice">新增的秒杀主题是否显示</label>
              </p></td>
            </tr>

          <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
