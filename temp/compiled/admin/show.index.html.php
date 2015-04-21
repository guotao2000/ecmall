<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function add(obj,id){
	var wxgoods = $("#"+id+"_wxgoods").val();
	var owxgoods = $("#"+id+"_owxgoods").val();
	var person = $("#"+id+"_person").val();
	var store = $("#"+id+"_store").val();
	var name = $("#"+id+"_name").html();
	var sn = $("#"+id+"_sn").html();
	var title = $("#title").val();
	var goods_sn = $("#goods_sn").val();
	var page = $("#page").val();
		$.post('index.php',{
		app:'wxgoods',
		act:'add',
		goods_id:id,
		store:store,
		wxgoods:wxgoods,
		owxgoods:owxgoods,
		person:person,
		sn:sn,
		name:name
		},
		function(data){
			alert(data);
			window.location.href="index.php?app=wxgoods&amp;act=index&amp;goods_sn="+goods_sn+"&amp;title="+title+"&amp;page="+page; 
			//alert(page);
		});
	}
</script>
<div id="rightTop">
    <p>商品名称管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="show" />
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
        <?php if ($this->_var['showgoods']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">商品编号</td>
            <td>商品名称</td>
			<td align="left">店铺名</td>
			<td>库存</td>
			<td align="left">上下架</td>
			<td>标签</td>
			<td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['showgoods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'show');if (count($_from)):
    foreach ($_from AS $this->_var['show']):
?>
        <tr class="tatr2" id="<?php echo $this->_var['wxgoods']['goods_id']; ?>">
            <td class="firstCell"><?php if (! $this->_var['show']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['wxgood']['goods_id']; ?>" /><?php endif; ?></td>
            <td id="<?php echo $this->_var['wxgoods']['goods_id']; ?>_sn"><?php echo $this->_var['show']['sku']; ?></td>
			<td id="<?php echo $this->_var['wxgoods']['goods_id']; ?>_name"><?php echo $this->_var['show']['goods_name']; ?></td>
			<td><?php echo $this->_var['show']['store_id']; ?></td>
			<td><?php echo $this->_var['show']['stock']; ?></td>
			<td><?php if ($this->_var['show']['if_show'] == 1): ?>上架<?php else: ?>下架<?php endif; ?></td>
			<td><?php echo $this->_var['show']['tags']; ?></td>
			<td><a href="index.php?app=show&act=edit&id=<?php echo $this->_var['show']['goods_id']; ?>">编辑</a></td>
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
	</form>
    <?php if ($this->_var['showgoods']): ?>
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
