<script type="text/javascript">
$(function(){
    $('#cancel_button').click(function(){
        DialogManager.close('seller_order_<?php echo $this->_var['act']; ?>');
    });
    $('#seller_order_<?php echo $this->_var['act']; ?>').validate({
    errorLabelContainer: $('#warning'),
    invalidHandler: function(form, validator) {
           $('#warning').show();
    },
     rules : {
            remark : {
                required   : true
            }
        },
        messages : {
            remark  : {
                required   : '备注不能为空！'
            }
        }
    });
});
</script>
<ul class="tab">
    <li class="active"><?php echo $this->_var['title']; ?></li>
</ul>
<div class="content1">
<div id="warning"></div>
<form method="post" action="index.php?app=seller_order&amp;act=<?php echo $this->_var['act']; ?>&amp;oid=<?php echo $this->_var['order']['order_id']; ?>" target="seller_order" id="seller_order_<?php echo $this->_var['act']; ?>">
    <h1><?php echo $this->_var['title']; ?></h1>
 
    <p>订单号&nbsp;&nbsp;&nbsp;&nbsp;:<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
  
    <dl>
        <dt>取消原因:</dt>
        <dd style="display:none;">
            <div class="li"><input type="hidden"  name="act" id="act" value="<?php echo $this->_var['act']; ?>" /> </div>
              <div class="li"><input type="hidden"  name="oid" id="oid" value="<?php echo $this->_var['order']['order_id']; ?>" /> </div>
        </dd>
        <dd id="other_reason" >
            <textarea id="other_reason_input" class="text" style="width:200px;" name="remark"></textarea>
        </dd>
    </dl>
    <div class="btn">
       <input type="submit" id="confirm_button" class="btn1" value="确认" />
        <input type="button" id="cancel_button" class="btn2" value="取消" />
    </div>
</form>
</div>