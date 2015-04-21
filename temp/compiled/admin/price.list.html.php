<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>价格批量管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=price&amp;act=index">管理</a></li>
        <li><span>查看历史</span></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
   <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="price" />
                <input type="hidden" name="act" value="back" />
                操作人:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
				开始时间:
                <select name="start_time">
				<option value="">--选择开始时间--</option>
				<?php $_from = $this->_var['start_time']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'time');if (count($_from)):
    foreach ($_from AS $this->_var['time']):
?>
				<option value="<?php echo $this->_var['time']['operate_time']; ?>"><?php echo local_date("Y-m-d",$this->_var['time']['operate_time']); ?></option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
				结束时间:
                <select name="end_time">
				<option value="">--选择结束时间--</option>
				<?php $_from = $this->_var['end_time']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'time');if (count($_from)):
    foreach ($_from AS $this->_var['time']):
?>
				<option value="<?php echo $this->_var['time']['operate_time']; ?>"><?php echo local_date("Y-m-d",$this->_var['time']['operate_time']); ?></option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
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
        <?php if ($this->_var['results']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">商品编号</td>
            <td>商品名称</td>
			<td align="left">商品原价</td>
            <td>商品价格</td>
			<td align="left">原市场价</td>
            <td>新市场价</td>
			<td>店铺名</td>
            <td align="left">执行店铺</td>
			<td>操作人</td>
			<td align="left">操作时间</td>
			<td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'result');if (count($_from)):
    foreach ($_from AS $this->_var['result']):
?>
        <tr class="tatr2" id="<?php echo $this->_var['result']['goods_id']; ?>">
            <td class="firstCell"><?php if (! $this->_var['result']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['result']['h_id']; ?>" /><?php endif; ?></td>
            <td><?php echo $this->_var['result']['goods_sn']; ?></td>
			<td><?php echo $this->_var['result']['goods_name']; ?></td>
			<td><?php echo $this->_var['result']['original_price']; ?></td>
			<td><?php echo $this->_var['result']['price']; ?></td>
			<td><?php echo $this->_var['result']['oshichang']; ?></td>
			<td><?php echo $this->_var['result']['shichang']; ?></td>
			<td><?php echo $this->_var['result']['store_id']; ?></td>
			<td><?php echo $this->_var['result']['store_id']; ?></td>
			<td><?php echo $this->_var['result']['operate_person']; ?></td>
			<td><?php echo local_date("Y-m-d",$this->_var['result']['operate_time']); ?></td>
			<td><a href="index.php?app=price&amp;act=drop&amp;id=<?php echo $this->_var['result']['h_id']; ?>">删除</a></td>
			
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
	</form>
    <?php if ($this->_var['results']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=price&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
