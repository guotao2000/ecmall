<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function addTime(obj){
		$.get('index.php',{app:'gift',act:'ajax_time',schedule_id:obj.value},
			function(data){
				$("#start_time_id").val(data.start_time);
				$("#end_time_id").val(data.end_time);
			},'json');
			//alert(obj.value);
		
	}
	
	
</script>

<div id="rightTop">
    <p>满赠满减管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=gift">管理</a></li>
        <li><span>添加满赠满减</span></li>
		 
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
							<option <?php if ($this->_var['gift']['start_time'] == $this->_var['vo']['start_time']): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_var['vo']['schedule_id']; ?>"><?php echo $this->_var['vo']['schedule_name']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>&nbsp;<span>请选择档期，时间自动填充</span>
                    
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销开始时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="start_time_id" readonly="readonly" class="Wdate" style="width:255px" name="start_time" <?php if ($this->_var['gift']['start_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['gift']['start_time']); ?>" <?php endif; ?> />
      				<span class="grey"></span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    促销结束时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="end_time_id" readonly="readonly" class="Wdate" style="width:255px" name="end_time" <?php if ($this->_var['gift']['end_time']): ?> value="<?php echo local_date("Y-m-d H:i:s",$this->_var['gift']['end_time']); ?>" <?php endif; ?> />
                	<span class="grey"></span>
                </td>
            </tr>   
			<tr>
                <th class="paddingT15">
                    促销名称:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="promotion_name" value="<?php echo $this->_var['gift']['promotion_name']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>      
			<tr>
                <th class="paddingT15">
                    促销状态:</th>
                <td class="paddingT15 wordSpacing5">
                   <select name="status">
						<option>--选择促销状态--</option>
							<option <?php if ($this->_var['gift']['status'] == 2): ?> selected="selected" <?php endif; ?> value="2">启用</option>
							<option <?php if ($this->_var['gift']['status'] == 1): ?> selected="selected" <?php endif; ?> value="1">未启用</option>
					</select>
                </td>
            </tr> 
   
            <tr>
                <th class="paddingT15">
                    执行店铺:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="store_id" value="<?php echo $this->_var['gift']['store_id']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>       
			
			<tr>
                <th class="paddingT15">
                    额度:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="edu" value="<?php if ($this->_var['gift']['edu']): ?> <?php echo $this->_var['gift']['edu']; ?> <?php endif; ?>" />
                	<span class="grey">消费要达到的额度，才开始赠送</span>
                </td>
            </tr> 
			
			<tr>
                <th class="paddingT15">
                    红包编码:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="hubao_sn" value="<?php if ($this->_var['gift']['hubao_sn']): ?> <?php echo $this->_var['gift']['hubao_sn']; ?> <?php endif; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>  
			
			<tr>
                <th class="paddingT15">
                    减额:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="jiane" value="<?php if ($this->_var['gift']['jiane']): ?> <?php echo $this->_var['gift']['jiane']; ?><?php endif; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>  
			
			<tr>
                <th class="paddingT15">
                    操作人:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="operate_person" value="<?php echo $this->_var['gift']['operate_person']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>       
	        <tr>
	            <th></th>
	            <td class="ptb20">
	                <input class="formbtn" type="submit" name="Submit" value="保存" />
	                <input class="formbtn" type="reset" name="Submit2" value="重置" />
					<input class="formbtn" type="button" onclick="location.href='index.php?app=gift'" value="返回" />
					<?php if ($this->_var['gift']): ?>
					<input class="formbtn" type="button" onclick="location.href='index.php?app=gift&amp;act=add_edit&amp;name=<?php echo $this->_var['gift']['promotion_name']; ?>'" value="添加赠品" />
					<?php endif; ?>
	            </td>
	        </tr>
        </table>
		<input type="hidden" name="id" value="<?php echo $this->_var['gift']['id']; ?>" />
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
