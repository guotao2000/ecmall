<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/My97DatePicker/WdatePicker.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	$("#schedule_form").submit(function(){
		var kuaixun_name = $('#kuaixun_name').val();
		kuaixun_name = $.trim(kuaixun_name);
		var start_time = $('#start_time_id').val();
		start_time = $.trim(start_time);
		var end_time = $('#end_time_id').val();
		end_time = $.trim(end_time);
		var reg =/^-?\d+\.?\d*$/;
		var kuaixun_price = $('#kuaixun_price').val();
		kuaixun_price = $.trim(kuaixun_price);
		var store_ids = $('#store_ids').val();
		store_ids = $.trim(store_ids);
		var operate_person = $('#operate_person').val();
		operate_person = $.trim(operate_person);
		if(kuaixun_name.length == 0){
			alert('快讯名称不能为空！');
			return false;
		}
		
		if(kuaixun_price.length == 0){
			alert('快讯价格不能为空！');
			return false;
		}else{
			if(!reg.test(kuaixun_price)){
				alert('快讯价格必须为数字！');
				return false;
			}
		}
		
		if(start_time.length == 0){
			alert('开始时间不能为空！');
			return false;
		}
		if(end_time.length == 0){
			alert('结束时间不能为空！');
			return false;
		}
		/*if(store_ids.length == 0){
			alert('执行店铺不能为空！');
			return false;
		}*/
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
    	<li><a class="btn1" href="index.php?app=promote">添加档期</a></li>
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_schedule">档期列表</a></li>
            
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_kuaixun">快讯列表</a></li>
               
        <li><a class="btn1" href="index.php?app=promote">折扣列表</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" id="schedule_form" action="index.php?app=promote&amp;act=add_kuaixun" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    快讯名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="kuaixun_name" type="text" name="kuaixun_name" />
                    <span class="grey">(必填，不能重复)</span>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    快讯图片:</th>
                <td class="paddingT15 wordSpacing5">
                    <input type="file" name="kuaixun_picurl" />
                    <span class="grey">(上传图片类型：.jpg,.png,.gif,.jpeg，图片不大于2M)</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    快讯开始时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="start_time_id" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', hmsMenuCfg:{H: [1, 6], m: [1, 8], s: [1, 8]}})" readonly="readonly" class="Wdate" style="width:255px" name="start_time" value="<?php echo $this->_var['start_time']; ?>"/>
     				<span class="grey">(时间格式：2014-12-12 23:05:05)</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    快讯结束时间:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="end_time_id" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', hmsMenuCfg:{H: [1, 6], m: [1, 8], s: [1, 8]}})" readonly="readonly" class="Wdate" style="width:255px" name="end_time" value="<?php echo $this->_var['end_time']; ?>"/>
                	<span class="grey">(时间格式：2014-12-12 23:05:05)</span>
                </td>
            </tr>  
			
			<tr>
                <th class="paddingT15">
                    快讯价格:</th>
                <td class="paddingT15 wordSpacing5">
                	<input type="text" id="kuaixun_price" class="infoTableInput" name="kuaixun_price"/>
                	<span class="grey">(必填)</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    执行店铺:</th>
                <td class="paddingT15 wordSpacing5">
 
                    <input class="infoTableInput" id="store_ids" type="text" name="store_ids" readonly />
                    <span class="grey">(多个店铺使用英文半角逗号","隔开，例如：2,3,4,5 等等)</span>
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
