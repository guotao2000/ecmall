<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/My97DatePicker/WdatePicker.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	$("#schedule_form").submit(function(){
		var schedule_name = $('#schedule_name').val();
		schedule_name = $.trim(schedule_name);
		var start_time = $('#start_time_id').val();
		start_time = $.trim(start_time);
		var end_time = $('#end_time_id').val();
		end_time = $.trim(end_time);
		var operate_person = $('#operate_person').val();
		operate_person = $.trim(operate_person);
		if(schedule_name.length == 0){
			alert('档期名称不能为空！');
			return false;
		}
		if(start_time.length == 0){
			alert('开始时间不能为空！');
			return false;
		}
		if(end_time.length == 0){
			alert('结束时间不能为空！');
			return false;
		}
		if(operate_person.length == 0){
			alert('操作人不能为空！');
			return false;
		}
		return true;
	});
	
});
</script>
<div id="rightTop">
    <p>促销管理</p>
    <ul class="subnav">
    	<li><span>添加档期</span></li>
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_schedule">档期列表</a></li>
           
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_kuaixun">快讯列表</a></li>
            
        <li><a class="btn1" href="index.php?app=_ms_promotion">促销列表</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" id="schedule_form" action="index.php?app=promote&amp;act=add_schedule">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    档期名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="schedule_name" type="text" name="schedule_name" />
                    <span class="grey">(必填，不能重复)</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    档期开始时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="start_time_id" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', hmsMenuCfg:{H: [1, 6], m: [1, 8], s: [1, 8]}})" readonly="readonly" class="Wdate" style="width:255px" name="start_time"/>
      				<span class="grey">(必选，时间格式：2014-12-12 23:05:05)</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    档期结束时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="end_time_id" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', hmsMenuCfg:{H: [1, 6], m: [1, 8], s: [1, 8]}})" readonly="readonly" class="Wdate" style="width:255px" name="end_time"/>
                	<span class="grey">(必选，时间格式：2014-12-12 23:05:05)</span>
                </td>
            </tr>   
            <tr>
                <th class="paddingT15">
                    操作人:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="operate_person" type="text" name="operate_person" />
                    <span class="grey">(必填)</span>
                </td>
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
