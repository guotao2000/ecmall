
<script type="text/javascript">
//<!CDATA[

/* 总部分类选择函数 */
function regionInit(divId)
{
	$("#" + divId + " > select").change(regionChange); // select的onchange事件
	
}

function regionChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $("#cate_id").val(id);

    // ajax请求下级地区
    if (this.value > 0)
    {
        var _self = this;
        var url =  '/index.php?app=mlselection&type=gcategoryyxw';
        $.getJSON(url, {'pid':this.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(regionChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].cate_id + "'>" + data[i].cate_name + "</option>");
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
//新增分类
function addcate()
{
	
	   id=$("#cate_id").val();
	
	    var cars=$("#icate_ids").val().split(",");
		//alert(cars);
		for (var i=0;i<cars.length;i++)
		{
		if(cars[i]==id){alert("此项选择已经存在，请重新选择！");return false;}
		}
        $("#icate_ids").val($("#icate_ids").val()+","+id);
		getcates();
}
    //显示选择分类
     function getcates(){
	   var cars=$("#icate_ids").val();
	   $.post("/index.php?app=mlselection&act=getcates", {aids: cars},
			   function(data){
		     // if(status=='success'){
		         // alert(data);
		           $("#cate_allow").html(data);
		       // }
			   }); 
			   }
	 //更新分类
		 function updatecate()
		 {
			 	 var s=''; 
	  $('input[name="aids"]:checked').each(function(){ 
	    s+=','+$(this).val(); 
	  }); 
	      $("#icate_ids").val(s);
		  getcates();
		 }
$(function(){
	
    $('#coupon_form').validate({
         errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            coupon_name : {
                required : true
            },
            coupon_value : {
                required : true,
                number : true
            },
            use_times : {
                required : true,
                digits : true
            },
            min_amount : {
                required : true,
                number : true
            },
            end_time : {
                required : true
            }
        },
            messages : {
            coupon_name : {
                required : '红包名称不能为空'
            },
            coupon_value : {
                required : '优惠金额必填且必须大于0',
                number : '优惠金额仅能为数字'
            },
            use_times : {
                required : '使用次数不能为空',
                digits : '使用次数仅能为整数'
            },
            min_amount : {
                required : '使用条件不能为空',
                number : '商品最低金额仅能为数字'
            },
            end_time : {
                required : '结束时间不能为空'
            }
        }
    });
	 regionInit("cate_allowadd");
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});

 
//]]>
</script>


<ul class="tab">
    <li class="active"><?php if ($_GET['act'] == edit): ?>编辑红包<?php else: ?>新增红包<?php endif; ?></li>
</ul>
<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="index.php?app=coupon&act=<?php echo $_GET['act']; ?>&id=<?php echo $_GET['id']; ?>" target="coupon" id="coupon_form">
        <ul>
            <li>
                <h3>红包名称:</h3>
                <p><input type="text" class="text width14" name="coupon_name" value="<?php echo htmlspecialchars($this->_var['coupon']['coupon_name']); ?>"/><b class="strong">*</b></p>
            </li>
            <li>
                <h3>优惠金额:</h3>
                <p><input type="text" class="text width2" name="coupon_value" value="<?php echo $this->_var['coupon']['coupon_value']; ?>" /><b class="strong">*</b></p>
            </li>
            <li>
                <h3>使用次数:</h3>
                <p><input type="text" class="text width2" name="use_times" value="<?php if ($this->_var['coupon']['use_times']): ?><?php echo $this->_var['coupon']['use_times']; ?><?php else: ?>1<?php endif; ?>" /><span class="field_notice">一个红包号码可以使用的次数</span><b class="strong">*</b></p>
            </li>
            <li>
                <h3>使用期限:</h3>
                <p><input type="text" class="text width2" name="start_time" value="<?php if ($this->_var['coupon']['start_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?><?php else: ?><?php echo local_date("Y-m-d",$this->_var['today']); ?><?php endif; ?>" id="add_time_from" readonly="readonly" />
                 至 <input type="text" class="text width2" name="end_time" value="<?php if ($this->_var['coupon']['end_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?><?php endif; ?>" id="add_time_to" readonly="readonly" /><b class="strong">*</b>
                </p>
            </li>
            <li>
                <h3>使用条件:</h3>
                <p><span class="field_notice" style="padding-left: 0px; ">一次购物满  <input type="text" class="text width1" name="min_amount" value="<?php echo $this->_var['coupon']['min_amount']; ?>" />   才可使用</span><b class="strong">*</b></p>
            </li>
               <li>
                <h3>使用说明:</h3>
                <p><span class="field_notice" style="padding-left: 0px; ">  <input type="text" class="text width14" name="remark" value="<?php echo $this->_var['coupon']['remark']; ?>" /></span></p>
            </li>
            <li>
                <h3>限制使用门店:</h3>
                <p><span class="field_notice" style="padding-left: 0px; ">  <input type="text" class="text width14" name="stores_allow" value=",<?php echo $this->_var['store_id']; ?>," <?php if ($this->_var['power_coupon'] == 0): ?> readonly="true"<?php endif; ?> />  <br/>允许使用的店铺ID,多个店铺之间用英文逗号隔开</span></p>
            </li>
            <li>
                <h3>限制使用分类:</h3>
                <p><span class="field_notice" style="padding-left: 0px; " id="cate_allow"> 
                 
         <?php $_from = $this->_var['cateids']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        <input type="checkbox" checked="true" value="<?php echo $this->_var['key']; ?>" name="aids"><?php echo $this->_var['item']; ?>

          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><br />
          <input type="button" value="更新分类" name="update_cate" onclick="updatecate(<?php echo $this->_var['store_id']; ?>)"/>
                
                </p>
            </li>
                <li>
                <h3>添加分类:</h3>
                <div  id="cate_allowadd"> 
                 <select >
                 <option>请选择</option>
                 <?php echo $this->html_options(array('options'=>$this->_var['cates'])); ?>
                 </select>
            <input type="hidden" name="cate_id" id="cate_id" value=""  />
             <input type="hidden" name="icate_ids" id="icate_ids" value=""  />
          <input type="button" value="新增分类" name="add_cate" onclick="addcate()"/>
                
                </div>
            </li>
            <li>
                <h3>发布:</h3>
                <p style="line-height:25px;"><input type="checkbox" name="if_issue" value="1" />立即发布 <span class="field_notice">一旦发布将不能修改红包信息</span></p>
                <div class="clear"></div>
            </li>
        </ul>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
    <div style="border:0px; height:70px; width:10px;"></div>
</div>