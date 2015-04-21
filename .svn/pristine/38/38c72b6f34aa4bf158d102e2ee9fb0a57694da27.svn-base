<?php echo $this->fetch('member.header.html'); ?>
<style>
.txt {margin-right:20px}
.spec ul {width: 530px; overflow: hidden;}
.spec .td {padding-bottom: 10px;}
.spec li {float: left; margin-left: 6px; display: inline;}
.spec li input {text-align: center;}
.spec .th {padding: 3px 0; margin-bottom: 10px; border-top: 2px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; background: #f8f8f8;}
</style>
<script type="text/javascript">
//<!CDATA[
    
 var max_price;
 var  min_end_time = new Date();
$(function(){

    $('#start_time input').datepicker({dateFormat: 'yy-mm-dd',minDate: new Date()});
    $('#end_time input').datepicker({dateFormat: 'yy-mm-dd',minDate:min_end_time});
    $('#group_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
            group_name : {
                required   : true
            },
			start_time :{
			    required : true
			},
            end_time      : {
                required     : true
            },
            goods_id      : {
                required   :true,
                min    : 1
            },
            min_quantity :{
                required   :true,
                min    :0
            },
			money_per_user :{
			    required : true,
				min : 0,
                max : max_price
			}
        },
        messages : {
            group_name  : {
                required   : 'fill_group_name'
            },
			start_time : {
				required     : 'fill_start_time'
			},
            end_time       : {
                required     : 'fill_end_time'
            },
            goods_id      : {
                required:  '商品名称不能为空',
                min   : '商品名称不能为空'
            },
            min_quantity: {
                required : '商品数量不能为空',
                min   : '商品数量不能为空'
            },
			money_per_user: {
			    required : 'fill_per_user_eanst',
				
				min : 'fill_min_user_eanst',
				
				max : 'fill_max_user_eanst'
			}
        }
    });
	$('#end_time input').click(function(){
	     min_end_time = new Date($('#start_time input').val().replace("-",","));
		$('#end_time input').datepicker({dateFormat: 'yy-mm-dd',minDate: min_end_time});
	});
});

function gs_callback(){
    query_spec($('#goods_id').val());
}

function check_spec(){
    $('input[name="spec_id[]"]').click(function(){
        var obj_group_price = $(this).parent().parent().find('input[name="group_price[]"]')
        if($(this).attr('checked') == true){
            obj_group_price.show();
            obj_group_price.attr('disabled', false);
        }else{
            obj_group_price.hide();
            obj_group_price.attr('disabled', true);
            obj_group_price.val('');
            $('label.error').remove();
        }
    });

    $('#submit_group').unbind('click');
    $('#submit_group').click(function(){
        $('label .error').remove();
	    var d = new Date();
        nowTime = new Date(d.getYear(),d.getMonth(),d.getDate()).getTime();
        var selTime = new Date($('#start_time input').val().replace("-",",")).getTime();
		var selEndTime = new Date($('#end_time input').val().replace("-",",")).getTime();
     	var timeDiff = selTime - nowTime
		if(timeDiff < 0){
		    $('#start_time').find('label').remove();
		    $('#startTime').addClass('error')
		    $('#startTime').after('<label class="error" for="start_time" generated="true">fill_lt_today</label>');
			return false;
		}
		if(selEndTime < selTime){
		   $('label').remove();
		    $('#end_time').find('label').remove();
		    $('#endTime').addClass('error')
		    $('#endTime').after('<label class="error" for="start_time" generated="true">fill_lt_today</label>');
			return false;
		}
        var qty = 0;
        var error = false;
        var price_empty = false;
        $('*[ectype="spec_item"]').each(function(){
            var obj_group_price = $(this).find('input[name="group_price[]"]'); 
            var group_price = obj_group_price.val();
            var if_checked = $(this).find('input[name="spec_id[]"]').attr('checked');
            if_checked && qty++;
            if(group_price != '' && (group_price < 0 || isNaN(group_price))){
                error = obj_group_price;
            }
            if(if_checked && group_price == ''){
                price_empty = obj_group_price;
            return false;
            }
        })
		var spec_price_obj = $('*[ectype="spec_item"]').find('input[name="group_price[]"]');
		var price_str="";
		for(var i=0; i<spec_price_obj.length;i++){
		    price_str += spec_price_obj.eq(i).val()+",";
		}
		max_price = get_max_price(price_str);
		if(parseFloat($("#perMoney").val()) > max_price){
		    $('#perMoney').parent('.txt').find('label').remove();
			
		    $("#perMoney").addClass('error');
			$("#perMoney").after('<label class="error" for="group_price[]" generated="true">fill_gt_max_price</label>');
			return false;
		}
        if(qty == 0){
            alert('fill_spec');
            return false;
        }
        if(error != false){
            error.focus();
            error.addClass('error');
            error.after('<label class="error" for="group_price[]" generated="true">invalid_group_price</label>');
            return false;
        }
        if(price_empty != false){
            price_empty.focus();
            price_empty.addClass('error');
            price_empty.after('<label class="error" for="group_price[]" generated="true">fill_group_price</label>');
            return false;
        }
    });
}
function query_spec(goods_id){
    $.getJSON('index.php?app=seckill&act=query_goods_info',{
        'goods_id':goods_id
        },
        function(data){
            if(data.done){
                var goods = data.retval;
                $('#spec_name').html(goods.spec_name);
                $('ul[ectype="spec_item"]').remove();
                    $.each(goods._specs,function(i,item){
                        $('#group_spec').append('<ul ectype="spec_item" class="td"><li class="distance2"><input name="spec_id[]" value="'+ item.spec_id +'" type="checkbox" checked="checked" />'+ item.spec +'</li><li class="distance1">' + item.stock + '</li><li class="distance1">'+ item.price +'</li><li><input name="group_price[]" type="text" class="text width2" /></li></ul>');
                });
                check_spec();
            }
        });
}

function get_max_price(str){
    var str_arr = str.split(",");
	var max_temp = str_arr[0];
	for(var i=0;i<str_arr.length;i++){
        if(max_temp > str_arr[i] && str_arr[i] != ""){
		    max_temp = str_arr[i];
		}

	}
	return max_temp;
}
//]]>
</script>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> 
         <ul class="tab">
            
            <li class="normal"><a href="<?php echo url('app=seckill'); ?>">商品列表</a></li>
            <li class="active">新增秒杀</li>
        </ul>
    <div id="seller_groupbuy_form" class="wrap">
      <div class="public">
        <form method="post" id="group_form">
          <input type="hidden" name="seller_id" value="<?php echo $this->_var['visitor']['user_id']; ?>" />
          <div class="information_index">
            <h4>秒杀基本信息</h4>
            <div class="add_wrap">

            <!--  <div class="assort">
                <p class="txt" id="start_time"> 开始时间：
                  <input name="start_time" value="<?php echo local_date("Y-m-d",$this->_var['group']['start_time']); ?>" type="text" class="text width2" id="startTime" />
                </p>

              </div>
              <div class="assort">
                <p class="txt" id="start_time"> group_desc：
                  <textarea style="height: 150px; overflow-y: auto; width: 250px; vertical-align: top;" name="group_desc" class="text"><?php echo htmlspecialchars($this->_var['group']['group_desc']); ?></textarea>
                </p>
              </div>
            </div>-->
            <div class="add_wrap">
              <div class="assort">
                <p class="txt">选择商品：
                  <?php if (! $this->_var['goods']): ?>
                  <input gs_id="goods_id" gs_name="goods_name" gs_callback="gs_callback" gs_title="gselector" gs_width="480" gs_type="store" gs_store_id="<?php echo $this->_var['store_id']; ?>" ectype="gselector" type="text" name="goods_name" id="goods_name" value="<?php echo htmlspecialchars($this->_var['group']['goods_name']); ?>" class="text" />
                  <?php else: ?>
                  <?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>
                  <?php endif; ?>
                  <input type="hidden" id="goods_id" name="goods_id" value="<?php echo $this->_var['group']['goods_id']; ?>" />
                </p>
              </div>
              <div class="assort">
                <p class="txt">秒杀商品数量：
                  <input type="text" name="min_quantity" value="<?php echo $this->_var['group']['min_quantity']; ?>" class="text width2" />
                  <span class="red">*</span><span class="field_notice">0表示无限制</span></p>
              </div>
              <div class="assort">
                <p class="txt">秒杀主题：
				  <select name="seckill_subject">
				  <?php echo $this->html_options(array('options'=>$this->_var['subject_lists'],'selected'=>$this->_var['subject_id'])); ?>
				  </select>
                  <span class="red">*</span><span class="field_notice">参与秒杀活动的主题</span></p>
              </div>
            <!--  <div class="assort">
                <p class="txt">max_per_user：
                  <input type="text" name="max_per_user" value="<?php echo $this->_var['group']['max_per_user']; ?>" class="text width2"/>
                  <span class="field_notice">note_max_per_user</span></p>
              </div>-->
            <div class="assort">
                <p class="txt" id="start_time"> 开始时间：
                  <input name="start_time" value="<?php echo local_date("Y-m-d",$this->_var['group']['start_time']); ?>" type="text" class="text width2" id="startTime" />
                </p>

              </div>
              <div class="assort">
                <p class="txt" style="float:left;">价格： </p>
                <div id="group_spec" class="spec" style="float:left">
                  <ul class="th" id="gourp_price">
                    <li id="spec_name" class="distance2"><?php if ($this->_var['goods']): ?><?php echo $this->_var['goods']['spec_name']; ?><?php else: ?>规格<?php endif; ?></li>
                    <li class="distance1">库存</li>
                    <li class="distance1">价格</li>
                    <li class="distance1">秒杀价</li>
                  </ul>
                  <?php $_from = $this->_var['goods']['_specs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
                  <ul ectype="spec_item" class="td">
                    <li class="distance2">
                      <input name="spec_id[]" value="<?php echo $this->_var['spec']['spec_id']; ?>" type="checkbox"<?php if ($this->_var['spec']['group_price']): ?> checked="checked"<?php endif; ?> />
                      <?php echo $this->_var['spec']['spec']; ?></li>
                    <li class="distance1"><?php echo $this->_var['spec']['stock']; ?></li>
                    <li class="distance1"><?php echo $this->_var['spec']['price']; ?></li>
                    <li>
                      <input ectype="group_price" name="group_price[]" type="text" class="price_group text width2" value="<?php echo $this->_var['spec']['group_price']; ?>"/>
                    </li>
                  </ul>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
              </div>

              <input type="hidden" name="if_publish" value="0" />
              <div class="issuance">
                <input id="submit_group" type="submit" class="btn" value="立即申请" />
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="wrap_bottom"></div>
    </div>
    <div class="clear"></div>
    <div class="adorn_right1"></div>
    <div class="adorn_right2"></div>
    <div class="adorn_right3"></div>
    <div class="adorn_right4"></div>
  </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?> 