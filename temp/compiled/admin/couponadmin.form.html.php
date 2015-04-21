<?php echo $this->fetch('header.html'); ?>
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
		 $("#cate_noallow").val($("#icate_ids").val()); 
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
		  $("#cate_noallow").val($("#icate_ids").val()); 
		 }
		 $(function(){
		 	 regionInit("cate_allowadd");

		});
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>红包管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=couponadmin">管理</a></li>
       
        <li><a class="btn1" href="index.php?app=couponadmin&amp;act=add">新增</a></li>
     
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   门店编号:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="store_id" type="text" name="store_id" value="<?php echo htmlspecialchars($this->_var['coupon']['store_id']); ?>" />
                </td>
            </tr>
          
            <tr>
                <th class="paddingT15">
                    红包名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="coupon_name" type="text" name="coupon_name" value="<?php echo $this->_var['coupon']['coupon_name']; ?>" />
                </td>
            </tr>
           
            <tr>
                <th class="paddingT15">
                    <label for="article">红包金额:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="coupon_value" name="coupon_value" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['coupon_value']); ?>"/>
                </td>
            </tr>
			 <tr>
                <th class="paddingT15">
                    <label for="article">使用次数:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="use_times" name="use_times" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['use_times']); ?>"/>
                </td>
            </tr>
			 <tr>
                <th class="paddingT15">
                    <label for="article">开始时间:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="start_time" name="start_time" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['start_time']); ?>"/>
                </td>
            </tr>
			 <tr>
                <th class="paddingT15">
                    <label for="article">结束时间:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="end_time" name="end_time" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['end_time']); ?>"/>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">限额:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="min_amount" name="min_amount" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['min_amount']); ?>"/>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">是否启用:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="if_issue" name="if_issue" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['if_issue']); ?>"/>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">限制门店:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="stores_allow" name="stores_allow" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['stores_allow']); ?>"/>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">限制分类:</label></th>
                <td class="paddingT15 wordSpacing5">
				<p><span class="field_notice" style="padding-left: 0px; " id="cate_allow"> 
                 
         <?php $_from = $this->_var['cateids']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
		 <?php $_from = $this->_var['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item1');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item1']):
?>
        <input type="checkbox" checked="true" value="<?php echo $this->_var['key']; ?>" name="aids"><?php echo $this->_var['item1']; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><br />
		  <input type="button" value="更新分类" name="update_cate" onclick="updatecate(<?php echo $this->_var['store_id']; ?>)"/>
                
                </p>
                    <input id="cate_noallow" name="cate_noallow" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['cate_noallow']); ?>"/>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">添加分类:</label></th>
                <td class="paddingT15 wordSpacing5">
                  <div  id="cate_allowadd"> 
                 <select >
                 <option>请选择</option>
                 <?php echo $this->html_options(array('options'=>$this->_var['cates'])); ?>
                 </select>
            <input type="hidden" name="cate_id" id="cate_id" value=""  />
             <input type="hidden" name="icate_ids" id="icate_ids" value="<?php echo htmlspecialchars($this->_var['coupon']['cate_noallow']); ?>"  />
          <input type="button" value="新增分类" name="add_cate" onclick="addcate()"/>
                
                </div> </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="article">备注:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input id="remark" name="remark" type="text" value="<?php echo htmlspecialchars($this->_var['coupon']['remark']); ?>"/>
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
        <input type="hidden" value="<?php echo $this->_var['coupon']['coupon_id']; ?>" name="coupon_id"/>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
