<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function add(obj,id){
	var price = $("#"+id+"_price").val();
	var oprice = $("#"+id+"_oprice").val();
	var shichang = $("#"+id+"_shichang").val();
	var oshichang = $("#"+id+"_oshichang").val();
	var person = $("#"+id+"_person").val();
	var store = $("#"+id+"_store").val();
	var name = $("#"+id+"_name").html();
	var sn = $("#"+id+"_sn").html();
	var title = $("#title").val();
	var goods_sn = $("#goods_sn").val();
	var page = $("#page").val();
		$.post('index.php',{
		app:'price',
		act:'add',
		goods_id:id,
		store:store,
		price:price,
		oprice:oprice,
		shichang:shichang,
		oshichang:oshichang,
		person:person,
		sn:sn,
		name:name
		},
		function(data){
			alert(data);
			window.location.href="index.php?app=price&amp;act=index&amp;goods_sn="+goods_sn+"&amp;title="+title+"&amp;page="+page; 
			//alert(page);
		});
	}
</script>
<div id="rightTop">
    <p>价格批量管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=price&amp;act=back">查看历史</a></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="price" />
                <input type="hidden" name="act" value="index" />
                商品关键字:
                <input class="queryInput" id ="title" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
				<input type="hidden" id ="page" type="text" value="<?php echo $this->_var['page11']; ?>" />
				商品条码:
                <input class="queryInput" id="goods_sn" type="text" name="goods_sn" value="<?php echo htmlspecialchars($this->_var['query']['tag']); ?>">
                <input type="submit" class="formbtn" value="查询" />
            </div>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
	<form method="post">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['prices']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">商品编号</td>
            <td>商品名称</td>
            <td align="left">商品价格</td>
			 <td align="left">市场价格</td>
			<td>店铺名</td>
            <td align="left">执行店铺</td>
			<td>操作人</td>
			<td align="left">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['prices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'price');if (count($_from)):
    foreach ($_from AS $this->_var['price']):
?>
        <tr class="tatr2" id="<?php echo $this->_var['price']['goods_id']; ?>">
            <td class="firstCell"><?php if (! $this->_var['price']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['price']['goods_id']; ?>" /><?php endif; ?></td>
            <td id="<?php echo $this->_var['price']['goods_id']; ?>_sn"><?php echo $this->_var['price']['sku']; ?></td>
			<td id="<?php echo $this->_var['price']['goods_id']; ?>_name"><?php echo $this->_var['price']['goods_name']; ?></td>
			<td><input type="text" name="price" id="<?php echo $this->_var['price']['goods_id']; ?>_price" value="<?php echo $this->_var['price']['price']; ?>" />
			<input type="hidden" type="text" id="<?php echo $this->_var['price']['goods_id']; ?>_oprice" value="<?php echo $this->_var['price']['price']; ?>" /></td>
			<td><input type="text" name="shichang" id="<?php echo $this->_var['price']['goods_id']; ?>_shichang" value="<?php echo $this->_var['price']['shichang']; ?>" />
			<input type="hidden" type="text" id="<?php echo $this->_var['price']['goods_id']; ?>_oshichang" value="<?php echo $this->_var['price']['shichang']; ?>" /></td>
			<td><?php echo $this->_var['price']['store_id']; ?></td>
			<td><input type="text" id='<?php echo $this->_var['price']['goods_id']; ?>_store' name="store" value="" />&nbsp;以英文逗号分隔</td>
			<td><input type="text" id='<?php echo $this->_var['price']['goods_id']; ?>_person' /></td>
			<td><a href="javascript:;" onclick="add(this,<?php echo $this->_var['price']['goods_id']; ?>)">修改</a></td>
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
	</form>
    <?php if ($this->_var['prices']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
