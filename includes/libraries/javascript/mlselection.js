/* 多级选择相关函数，如地区选择，分类选择
 * multi-level selection
 */

/* 地区选择函数 */
function regionInityxw(divId)
{
    $("#" + divId + " > select").change(regionChange); // select的onchange事件
	//$("#" + divId + " > input:button[class='edit_region']").click(regionEdit);
}
/* 地区选择函数 */
function regionInit(divId)
{
    $("#" + divId + " > select").change(regionChange); // select的onchange事件
	$("#" + divId + " > input:button[class='edit_region']").click(regionEdit);
}
/*配送区域选择*/
function psregionInit(divId)
{
    $("#" + divId + " > select").change(psregionChange); // select的onchange事件
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
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));
    // ajax请求下级地区
    if (this.value > 0)
    {
        var _self = this;
		//var url = REAL_SITE_URL + '/index.php?app=mlselection&type=region';
        var url = 'index.php?app=mlselection&type=region';
        $.getJSON(url, {'pid':this.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(regionChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
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
//yangxiuwei  new function
function newregionChange(thatsel)
{
    // 删除后面的select
	$(thatsel).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(thatsel).siblings("select").andSelf();
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
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级地区
    if (thatsel.value > 0)
    {
        var _self = thatsel;
        var url =  '/index.php?app=mlselection&type=region&yxwtime='+Math.random()*10000;
        $.getJSON(url, {'pid':thatsel.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(regionChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
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

//配送区域下拉框
function psregionChange()
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
    $(".area_id").val(id);
    // ajax请求下级地区
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=region&yxwtime='+Math.random()*10000;
        $.getJSON(url, {'pid':_self.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(psregionChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
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
//end yangxiuwei

function regionEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().hide();
}

//by yangxiuwei 编辑地区保持原样
function newregionEdit(that,pid)
{
	
    $(that).siblings("select").show();
    $(that).siblings("span").andSelf().hide();
    var url =  '/index.php?app=mlselection&type=newregion';
    //alert(url);
    $.ajaxSettings.async = false;  
    $.getJSON(url, {'pid':pid}, function(data){
    if (data.done)
    {
		   
        	if (data.retval.length > 0)
            {
        	 var data  = data.retval;
             for (iyxw = data.length-1; iyxw > -1; iyxw--)
             {
              
               $(that).siblings("select").get([data.length-1-iyxw]).value=data[iyxw];
               newregionChange($(that).siblings("select").get([data.length-1-iyxw]));
               //alert(data[iyxw]);
             }
		
            }
			 
			
     }
     });
	
	  $(that).siblings("select").eq(0).hide();
}

//end yangxiuwei

/* 商品分类选择函数 */
function gcategoryInit(divId)
{
    $("#" + divId + " > select").get(0).onchange = gcategoryChange; // select的onchange事件
    window.onerror = function(){return true;}; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(gcategoryEdit); // 编辑按钮的onclick事件
}

function gcategoryChange()
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
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=gcategory';
        $.getJSON(url, {'pid':this.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(gcategoryChange).insertAfter(_self);
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
	// ajax 请求该商品分类的属性设置 sku tyioocom 
	if(id>0)
	{
		$("#props").children().remove(); // 先除掉原先加载的 属性列表 html
		var url = REAL_SITE_URL  + '/index.php?app=my_goods&act=ajax_props';
		$.getJSON(url,{'cate_id':id},function(data){
			if(data.done)
			{
				//alert(data.retval.length);
				if(data.retval.length > 0)
				{
					$("#prop_list").show();
					var data = data.retval;
					for (i = 0;i < data.length; i++)
					{
						//alert(data[i].pid);
						$("#props").append("<span>"+data[i].name+"</span>");
						$("#props").append("<select name=props[] id='prop"+data[i].pid+"'>");
						values = data[i].value;
						option = "<option value=''></option>";
						for(j = 0; j < values.length; j++)
						{
							//alert(values[j].prop_value);
							if(values[j].prop_value!=undefined){
								option += "<option value='"+values[j].pid+":"+values[j].vid+"'>"+values[j].prop_value+"</option>" 
							}
						}
						$("#prop"+data[i].pid).append(option);
						$("#props").append("</select>");
					}
				}
				else
				{
					$("#prop_list").hide();
				}
			}
		});
	}
	else{
		
		$("#prop_list").hide();
	}
	// end sku
	
	
}

function gcategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}
//新增配送区域
function addarea(storeid){
	//alert($("#area_id").val());
	$.get("/index.php?app=mlselection&act=add&aid="+$("#area_id").val()+"&id="+storeid,function(data,status){
		    if(data==1&&status=='success'){
		      alert("新增成功");
		      getarea(storeid);
		    }
		  });
	
}

//更新配送区域
function updatearea(storeid){
	 var s=''; 
	  $('input[name="aids"]:checked').each(function(){ 
	    s+=','+$(this).val(); 
	  }); 
	  $.post("/index.php?app=mlselection&act=update&id="+storeid, { aids: s },
			   function(data){
		      if(data==1){
		          alert("更新成功");
		          getarea(storeid);
		        }
			   });
	
}
//获取配送区域
function getarea(storeid){
	$.get("/index.php?app=mlselection&act=getarea&id="+storeid,function(data,status){
	    if(status=='success'){
	      //alert("新增成功");
	      $("#areaids").html(data);
	    }
	  });
	
}
