<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    var del_state = false;
    var add_state = false;
	function addTime(obj){
		$.get('index.php',{app:'_ms_promotion',act:'ajax_col',schedule_id:obj.value},
			function(data){
				$("#start_time_id").val(data.start_time);
				$("#end_time_id").val(data.end_time);
			},'json');
			//alert(obj.value);
		
	}	
	function search(){
		var obj = $('#goods_name');
		var obj1 = $('#goods_sn');
		$.post('index.php',{app:'_ms_promotion',act:'ajax_col',goods_name:obj.val(),goods_sn:obj1.val()},
			function(data){
				$('#bb').html(data);
				$('#bbhead').css('display','block');
			});
	}
	//删除商品
	function drop(obj,id){
	    var obj = $('#goods_name');

	    if (!del_state) {
	        del_state = true;
	        $.post('index.php', {app: '_ms_promotion', act: 'ajax_drop_goods', id: id},
                function (data) {                 
                    del_state = false;
                    $("#_pg_" + id).remove();
                });
	    } else {
	        alert("系统正在处理一个删除操作请稍后...");
	    }
	}
	
	function add(obj, id) {
	   
	   //判断商品是否存在
	    if ($(".v_pg_" + id).html() != null)
	    {
	        alert("改商品已经添加！");
	        return;
	    }

	    if (!add_state) {
	        add_state = true;
	        var c_id = $('#cuxiao_id').val();
	        var p_name = $('#pa_name').val();
	        var p_type = $('#cuxiao_type').val();
	        var p_price = $("#p" + id).val();
	        var p_num = $("#" + id).val();
	        var stores=$("#sg" + id).val();
	        $.post('index.php', {
	            app: '_ms_promotion',
	            act: 'add_ajax',
	            goods_id: id,//商品id
	            cuxiao_id: c_id,//促销id
	            pa_name: p_name,//促销活动名称
	            p_type: p_type,//促销类型
	            p_price: p_price,//商品价格
	            p_num: p_num,//商品数量
	            stores:stores
	        },
            function (data) {
                add_state = false;
               // $('#tian').append(data).css('display', 'block');
                alert(data);
                window.location=window.location;
            });
	    } else {
	        alert("系统正在处理一个添加商品操作，请稍后...");
	    }
	}	
	
</script>

<div id="rightTop">
    <p>秒杀管理管理</p>   
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=_ms_promotion">管理</a></li>
		<li><a class="btn1" href="index.php?app=_ms_promotion&amp;act=add">添加促销</a></li>
        <li>  <input class="formbtn" type="button" onclick="location.href='index.php?app=_ms_promotion&amp;act=edit&amp;id=<?php echo $this->_var['id']; ?>'" value="<返回" /></li>        
</ul>
</div>
<div class="info">
    <form method="post" id="file_form" autocomplete="off">
	   <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   促销活动名称:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="text"  class="Wdate" style="width:255px" id="pa_name" name="pa_name" value="<?php echo $this->_var['list']['p_name']; ?>"  readonly/>
					<input type="hidden"  style="width:255px" id="cuxiao_id" name="cuxiao_id" value="<?php echo $this->_var['list']['p_id']; ?>" />
                    <input type="hidden" style="width:255px" id="cuxiao_type" name="cuxiao_type" value="<?php echo $this->_var['list']['p_type']; ?>" />
					<span class="grey"></span>
                </td>
            </tr>           
			<tr>
                <th class="paddingT15">
                    选择商品说明:</th>
                <td class="paddingT15 wordSpacing5"><p><?php if ($this->_var['list']['p_type'] == 1): ?>参加秒杀商品配置 <?php elseif ($this->_var['list']['p_type'] == 2): ?> 参加组合促销商品配置<?php elseif ($this->_var['list']['p_type'] == 4): ?> 满额赠送商品选择 <?php endif; ?> </p>
             
                </td>
            </tr>  
			
			<tr id="kkk">
                <th class="paddingT15">
                    商品搜索:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" id="goods_name" style="width:255px" name="goods_name" />
                	<span class="grey"></span>
					商品条码搜索：<input type="text"  class="Wdate" id="goods_sn" style="width:255px" name="goods_sn" />
					<span class="grey"></span>
					<input class="formbtn" type="button" name="Submit"   value="搜索" onclick="search()" />
                </td>
				
            </tr>
	
			     
	        <!--<tr>
	            <th></th>
	            <td class="ptb20">
	                <input class="formbtn" type="submit" name="Submit" value="提交" />
	                <input class="formbtn" type="reset" name="Submit2" value="重置" />
	            </td>
	        </tr>-->
        </table>
		
		<table class="infoTable">		
			<tbody id="tian" <?php if ($this->_var['_content']): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?> >
				<tr><th>商品编号</th><th>商品条码</th><th>门店名称编号</th><th>商品名称</th><th>商品原价</th><th>商品促销价</th><th>促销数量</th><th>操作</th></tr>

				<?php if ($this->_var['_content']): ?><?php echo $this->_var['_content']; ?><?php endif; ?> 
			</tbody>
		</table>
		<br />
        <hr/>
		<table class="infoTable">
		 <tr><th>商品编号</th><th>商品条码</th><th>门店名称编号</th><th>商品名称</th><th>商品价格</th><th>商品促销价</th><th>促销数量</th><th>促销店铺</th><th>选择</th></tr>
			<tbody id="bb"></tbody>
		</table>
		

    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
