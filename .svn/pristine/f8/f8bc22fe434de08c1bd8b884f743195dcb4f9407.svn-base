<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function add(obj,id){
	var tag = $("#"+id+"_tag").val();
	var store = $("#"+id+"_store").val();
	var name = $("#"+id+"_name").html();
	var sn = $("#"+id+"_sn").html();
	var title = $("#title").val();
	var goods_sn = $("#goods_sn").val();
	var page = $("#page").val();
		$.post('index.php',{
		app:'tags',
		act:'add',
		goods_id:id,
		store:store,
		tag:tag,
		sn:sn,
		name:name
		},
		function(data){
			alert(data);
			window.location="index.php?app=tags&act=index&goods_sn="+goods_sn+"&title="+title+"&page="+page; 
			//alert(page);
		});
	}
</script>
<div id="rightTop">
    <p>标签批量管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="tags" />
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
        <?php if ($this->_var['tags']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">商品编号</td>
            <td>商品名称</td>
            
			<td>商品标签</td>
            <td align="left">执行店铺</td>
			<td align="left">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['tag']):
?>
        <tr class="tatr2" id="<?php echo $this->_var['tag']['goods_id']; ?>">
            <td class="firstCell"><?php if (! $this->_var['tag']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['tag']['goods_id']; ?>" /><?php endif; ?></td>
            <td id="<?php echo $this->_var['tag']['goods_id']; ?>_sn"><?php echo $this->_var['tag']['sku']; ?></td>
			<td id="<?php echo $this->_var['tag']['goods_id']; ?>_name"><?php echo $this->_var['tag']['goods_name']; ?></td>
			
			<td><input type="text" name="tag" id="<?php echo $this->_var['tag']['goods_id']; ?>_tag" value="<?php echo $this->_var['tag']['tags']; ?>" />
			<td><input type="text" id='<?php echo $this->_var['tag']['goods_id']; ?>_store' name="store" value="<?php echo $this->_var['tag']['store_id']; ?>" />&nbsp;以英文逗号分隔</td>
			<td><a href="javascript:;" onclick="add(this,<?php echo $this->_var['tag']['goods_id']; ?>)">修改</a></td>
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
	</form>
    <?php if ($this->_var['tags']): ?>
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
