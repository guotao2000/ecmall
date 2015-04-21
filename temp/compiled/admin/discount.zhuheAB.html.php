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
	
	function search(){
		var obj = $('#goods_name');
		var obj1 = $('#goods_sn');
		$.post('index.php',{app:'discount',act:'ajax_col',goods_name:obj.val(),goods_sn:obj1.val()},
			function(data){
			$('#bb').html("");
				$('#bb').html(data);
				$('#bbhead').css('display','block');
			});
	}
	//删除商品
	function drop(obj,id){
		var obj = $('#goods_name');
		$.post('index.php',{app:'discount',act:'ajax_drop',id:id},
			function(data){
				//alert('11111');
				$("#"+id).remove();
			});
	}
	
	
	function add(obj,id){
		var c_id = $('#cuxiao_id').val();
		var p_name = $('#pa_name').val();
		var p_type = $('#p_type option:selected').val();
		var p_price = $("#p"+id).val();
		//var p_num = $(this).parent().find('#p_num').val();
		var p_num = $("#"+id).val();
		$.post('index.php',{
		app:'discount',
		act:'add_ajax',
		goods_id:id,
		cuxiao_id:c_id,
		pa_name:p_name,
		p_type:p_type,
		p_price:p_price,
		p_num:p_num
		},
		function(data){
			$('#tian').append(data).css('display','block');
			$('.no_data').css('display','none');
			//alert(data);
		});
	}
	
	function AB(obj){
		location.href='index.php?app=discount&amp;act=zhuhe&amp;id=<?php echo $this->_var['list']['discount_id']; ?>&amp;p_type='+$(obj).val();
		//alert($(obj).val());
	}
	
	
</script>

<div id="rightTop">
    <p>折扣管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=discount">管理</a></li>
		<li><a class="btn1" href="index.php?app=discount&amp;act=add">添加促销</a></li>
		
    </ul>
</div>

<div class="info">
    <form method="post" id="file_form" autocomplete="off">
	   <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    折扣促销名称:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="text"  class="Wdate" style="width:255px" id="pa_name" name="pa_name" value="<?php echo $this->_var['list']['discount_name']; ?>" />
					<input type="hidden"  style="width:255px" id="cuxiao_id" name="cuxiao_id" value="<?php echo $this->_var['list']['discount_id']; ?>" />
					<span class="grey"></span>
                </td>
            </tr>
           
			<tr>
                <th class="paddingT15">
                    组合类型:</th>
                <td class="paddingT15 wordSpacing5">
                   <select id="p_type" name="p_type" onchange="AB(this)">
						<option>--选择组合类型--</option>
							<option <?php if ($this->_var['type'] == 1): ?> selected="selected" <?php endif; ?> value="1">组合A</option>
							<option <?php if ($this->_var['type'] == 2): ?> selected="selected" <?php endif; ?> value="2">组合B</option>
					</select>
                </td>
            </tr>  
			
			<tr id="kkk">
                <th class="paddingT15">
                    商品搜索:</th>
                <td class="paddingT15 wordSpacing5">
                   关键字搜索：<input type="text"  class="Wdate" id="goods_name" style="width:255px" name="goods_name" />
                	<span class="grey"></span>
					商品条码搜索：<input type="text"  class="Wdate" id="goods_sn" style="width:255px" name="goods_sn" />
					<span class="grey"></span>
					<input class="formbtn" type="button" name="Submit"   value="搜索" onclick="search()" />
                </td>
				
            </tr>
	
			     
	        
        </table>
		
		<table class="infoTable">
			<tbody id="tian">
				<tr><th>商品编号</th><th>商品名称</th><th>商品原价</th><th>商品促销价</th><th>促销数量</th><th>操作</th></tr>
				<?php $_from = $this->_var['zhuhes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'zhuhe');if (count($_from)):
    foreach ($_from AS $this->_var['zhuhe']):
?>
					<tr id="<?php echo $this->_var['zhuhe']['pa_id']; ?>"><th><?php echo $this->_var['zhuhe']['goods_id']; ?></th><th><?php echo $this->_var['zhuhe']['goods_name']; ?></th><th><?php echo $this->_var['zhuhe']['goods_original_price']; ?></th><th><?php echo $this->_var['zhuhe']['promotion_price']; ?></th><th><?php echo $this->_var['zhuhe']['promotion_num']; ?></th><th><a href='javascript:void(0)' onclick="drop(this,<?php echo $this->_var['zhuhe']['pa_id']; ?>)">删除</a></th></tr>
					<?php endforeach; else: ?>
					<tr class="no_data">
						<td colspan="6">没有符合条件的记录</td>
					</tr>
				<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</tbody>
		</table>
		<br /><br />
		<table class="infoTable">
		<thead id="bbhead" style="display:none;"><tr><th>商品编号</th><th>商品名称</th><th>商品价格</th><th>商品促销价</th><th>促销数量</th><th>选择</th></tr></thead>
			<tbody id="bb"></tbody>
		</table>
		
	    <input class="formbtn" type="button" onclick="history.back()" value="返回" />
	            
	        
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
