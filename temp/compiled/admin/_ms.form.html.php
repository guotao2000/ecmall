<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function addTime(obj){
		$.get('index.php',{app:'_ms_promotion',act:'ajax_col',schedule_id:obj.value},
			function(data){
				$("#start_time_id").val(data.start_time);
				$("#end_time_id").val(data.end_time);
			},'json');
			//alert(obj.value);
		
	}
	
	//促销类型修改状态
	 function change_type(obj) {
	     var opt = obj.options[obj.selectedIndex];
		   
		    _typebt_show(opt.value);
		
		 }
	 function _typebt_show(type){
		
	     if (type == -1) {
	         $('#id_gamount').addClass("v_hidden");
	         $('#id_discount').addClass("v_hidden");
              $('#id_stores').addClass("v_hidden");
	         $('#id_gtype').addClass("v_hidden");

	     }else if(type==1){			
			 $('#id_gamount').addClass("v_hidden");
			 $('#id_discount').addClass("v_hidden");
              $('#id_stores').addClass("v_hidden");
			 $('#id_gtype').addClass("v_hidden");
			 
		 }else if (type==2)
		{
			 $('#id_gamount').addClass("v_hidden");
			 $('#id_discount').addClass("v_hidden");
              $('#id_stores').addClass("v_hidden");
			 $('#id_gtype').addClass("v_hidden");
		 }else if (type==3)
		{ 
			 $('#id_gamount').removeClass("v_hidden");
			 $('#id_discount').removeClass("v_hidden");
			 $('#id_gtype').removeClass("v_hidden");
             $('#id_stores').removeClass("v_hidden");
		 }else if (type==4)
		{ 			 
			 $('#id_gamount').removeClass("v_hidden");
			 $('#id_discount').addClass("v_hidden");
              $('#id_stores').addClass("v_hidden");
			 $('#id_gtype').removeClass("v_hidden");
		 }
	 }

	 function Add_GType_()
	 {

	     var type_str = '';
	     $('.checkitem:checked').each(function () {
	         type_str += this.value + ',';
	     });	  
	     
	     $('#GType_').val(type_str);
	  
	     return true;
	 }
</script>
<style>
.v_hidden{
display:none;
}
</style>


<div id="rightTop">
    <p>促销管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=_ms_promotion">管理</a></li>
        <li><span>添加促销</span></li>
    </ul>
</div>

<div class="info">
    <form method="post" id="file_form" autocomplete="off" onsubmit=" return Add_GType_();">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    促销档期名称:</th>
                <td class="paddingT15 wordSpacing5">
					<select id="schedule_name" name="schedule_name" onchange="addTime(this);">
						<option>--选择档期名称--</option>
						<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
							<option <?php if ($this->_var['_ms_promotion']['start_time'] == $this->_var['vo']['start_time']): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_var['vo']['schedule_id']; ?>"><?php echo $this->_var['vo']['schedule_name']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>&nbsp;<span>请选择档期，时间自动填充</span>
                    
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销开始时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="start_time_id" readonly="readonly" class="Wdate" style="width:255px" name="start_time" <?php if ($this->_var['_ms_promotion']['start_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['_ms_promotion']['start_time']); ?>" <?php endif; ?> />
      				<span class="grey"></span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销结束时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="end_time_id" readonly="readonly" class="Wdate" style="width:255px" name="end_time" <?php if ($this->_var['_ms_promotion']['end_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['_ms_promotion']['end_time']); ?>" <?php endif; ?> />
                	<span class="grey"></span>
                </td>
            </tr>   
			<tr>
                <th class="paddingT15">
                    促销活动名称:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="p_name" value="<?php echo $this->_var['_ms_promotion']['_ms_promotion_name']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
            
              
             <tr>
                <th class="paddingT15">
                    促销类型:</th>
                <td class="paddingT15 wordSpacing5">
                   <select name="_promotion_type" onchange="change_type(this);">
						    <option value="-1">--选择请选择促销类型--</option>
							<option value="1">秒杀</option>
							<option value="2">组合</option>
							<option value="3">满减</option>
							<option value="4">满赠</option>
					</select>
                </td>
            </tr> 	
           
            <tr id="id_gamount" class="v_hidden">
                <th class="paddingT15">
                    满额额度:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="g_amount" value="<?php echo $this->_var['_ms_promotion']['g_amount']; ?>" />
                	<span class="grey">*满足此额度才可参加</span>
                </td>
            </tr>             
            
            <tr id="id_discount" class="v_hidden" >
                <th class="paddingT15">
                    满减额度:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="discount" value="<?php echo $this->_var['_ms_promotion']['discount']; ?>" />
                	<span class="grey">*满足额度减少金额</span>
                </td>
            </tr> 
            <tr id="id_stores" class="v_hidden" >
                <th class="paddingT15">
                    允许店铺:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="stores" value="<?php echo $this->_var['_ms_promotion']['stores']; ?>" />
                    <span class="grey">*允许的店铺列表，逗号分隔</span>
                </td>
            </tr> 
            <tr id="id_gtype" class="v_hidden">
                <th class="paddingT15">
                    参加满减/满赠商品类型:
                </th>
                <td class="paddingT15 wordSpacing5">
                    <div style="max-width:800px;">
                        <input id="GType_" name="GType_" type="hidden" value="" />

                        <input class="checkall" type="checkbox" value="1">全部分类<br />
                        <?php $_from = $this->_var['_gtype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
                        <input class="checkitem" type="checkbox" value="<?php echo $this->_var['vo']['cate_id']; ?>"><?php echo $this->_var['vo']['cate_name']; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                </td>
            </tr> 

    
			<tr>
                <th class="paddingT15">
                   促销权重:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="weight"  value="<?php if ($this->_var['_ms_promotion']['weight_factor']): ?> <?php echo $this->_var['_ms_promotion']['weight_factor']; ?> <?php else: ?>10<?php endif; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>
                <tr>
                <th class="paddingT15">
                   循环:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="xunhuan"  value=" <?php if ($this->_var['_ms_promotion']['xunhuan']): ?> <?php echo $this->_var['_ms_promotion']['xunhuan']; ?> <?php else: ?>999<?php endif; ?> " />
                    <span class="grey"></span>
                </td>
            </tr>		
			<tr>
                <th class="paddingT15">
                    操作人:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="operate_person" value="<?php echo $this->_var['_ms_promotion']['operate_person']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr> 
          
	        <tr>
	            <th></th>
             
                <td id="batchAction" class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="保存" />
                    <input class="formbtn" type="button" onclick="javascript: location.reload();" name="Submit2" value="重置" />
                    <input class="formbtn" type="button" onclick="location.href='index.php?app=_ms_promotion'" value="返回" />
                </td>
           </tr>
        </table>
		<input type="hidden" name="id" value="<?php echo $this->_var['_ms_promotion']['_ms_promotion_id']; ?>" />
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
