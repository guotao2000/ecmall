<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function addTime(obj){
		$.get('index.php',{app:'discount',act:'ajax_col',schedule_id:obj.value},
			function(data){
				$("#start_time_id").val(data.start_time);
				$("#end_time_id").val(data.end_time);
			},'json');
			//alert(obj.value);
		
	}
	
	
</script>

<div id="rightTop">
    <p>折扣管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=discount">管理</a></li>
        <li><span>添加促销</span></li>
		 
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
            
       
    </ul>
</div>

<div class="info">
    <form method="post" id="file_form" autocomplete="off">
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
							<option <?php if ($this->_var['discount']['start_time'] == $this->_var['vo']['start_time']): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_var['vo']['schedule_id']; ?>"><?php echo $this->_var['vo']['schedule_name']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>&nbsp;<span>请选择档期，时间自动填充</span>
                    
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销开始时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="start_time_id" readonly="readonly" class="Wdate" style="width:255px" name="start_time" <?php if ($this->_var['discount']['start_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['start_time']); ?>" <?php endif; ?> />
      				<span class="grey"></span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销结束时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="end_time_id" readonly="readonly" class="Wdate" style="width:255px" name="end_time" <?php if ($this->_var['discount']['end_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['end_time']); ?>" <?php endif; ?> />
                	<span class="grey"></span>
                </td>
            </tr>   
			<tr>
                <th class="paddingT15">
                    折扣促销名称:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="discount_name" value="<?php echo $this->_var['discount']['discount_name']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>      
			<tr>
                <th class="paddingT15">
                    折扣促销状态:</th>
                <td class="paddingT15 wordSpacing5">
                   <select name="discount_state">
						<option>--选择促销状态--</option>
							<option <?php if ($this->_var['discount']['discount_state'] == 2): ?> selected="selected" <?php endif; ?> value="2">启用</option>
							<option <?php if ($this->_var['discount']['discount_state'] == 1): ?> selected="selected" <?php endif; ?> value="1">未启用</option>
					</select>
                </td>
            </tr> 

			<tr>
                <th class="paddingT15">
                    执行依据:</th>
                <td class="paddingT15 wordSpacing5">
                   <select name="exec_type">
						<option>--选择执行依据--</option>
							<option <?php if ($this->_var['discount']['exec_type'] == 0): ?> selected="selected" <?php endif; ?> value="0">金额</option>
							<option <?php if ($this->_var['discount']['exec_type'] == 1): ?> selected="selected" <?php endif; ?> value="1">数量</option>
					</select>
                </td>
            </tr>    
			
			<tr>
                <th class="paddingT15">
                   权重:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="weight_factor"  value="<?php if ($this->_var['discount']['weight_factor']): ?> <?php echo $this->_var['discount']['weight_factor']; ?> <?php else: ?>10<?php endif; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>      
            <tr>
                <th class="paddingT15">
                    执行店铺:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="store_id" value="<?php echo $this->_var['discount']['store_id']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>       
			
			<tr>
                <th class="paddingT15">
                    循环次数:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="loop_num" value="<?php if ($this->_var['discount']['loop_num']): ?> <?php echo $this->_var['discount']['loop_num']; ?> <?php else: ?>99<?php endif; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>       
			
			<!--<tr>
                <th class="paddingT15">
                    满足条件:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="condition" />
                	<span class="grey"></span>
                </td>
            </tr>    -->   
			
			<tr>
                <th class="paddingT15">
                    操作人:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="operate_person" value="<?php echo $this->_var['discount']['operate_person']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>       
	        <tr>
	            <th></th>
	            <td class="ptb20">
	                <input class="formbtn" type="submit" name="Submit" value="保存" />
	                <input class="formbtn" type="reset" name="Submit2" value="重置" />
					<input class="formbtn" type="button" onclick="location.href='index.php?app=discount'" value="返回" />
					<?php if ($this->_var['discount']): ?>
					<input class="formbtn" type="button" onclick="location.href='index.php?app=discount&amp;act=zhuhe&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>&amp;p_type=1'" value="组合A" />
					<input class="formbtn" type="button" onclick="location.href='index.php?app=discount&amp;act=zhuhe&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>&amp;p_type=2'" value="组合B" />
					<?php endif; ?>
	            </td>
	        </tr>
        </table>
		<input type="hidden" name="id" value="<?php echo $this->_var['discount']['discount_id']; ?>" />
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
