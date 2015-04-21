<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>折扣管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=discount&amp;act=add">添加促销</a></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=add_zhuhe">添加组合</a></li>
		<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="discount" />
                <input type="hidden" name="act" value="index" />
                标题:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['discounts']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">促销名称</td>
            <td>开始时间</td>
            <td align="left">结束时间</td>
            <td>促销状态</td>
			<td align="left">执行店铺</td>
            <td>操作时间</td>
			<td align="left">操作人</td>
			<td>组合方式</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['discounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'discount');if (count($_from)):
    foreach ($_from AS $this->_var['discount']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['discount']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['discount']['discount_id']; ?>"/><?php endif; ?></td>
            <td><a href="index.php?app=discount&amp;act=list_zhuhe&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>"><?php echo $this->_var['discount']['discount_name']; ?></a></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['start_time']); ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['end_time']); ?></td>
            <td><?php if ($this->_var['discount']['discount_state'] == 2): ?>启用<?php else: ?>未启用<?php endif; ?></td>
			<td><?php echo $this->_var['discount']['store_id']; ?></td>
			<td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['operate_time']); ?></td>
			<td><?php echo $this->_var['discount']['operate_person']; ?></td>
			<td><a href="index.php?app=discount&amp;act=list_zhuhe&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>&amp;p_type=1">组合A</a>|<a href="index.php?app=discount&amp;act=list_zhuhe&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>&amp;p_type=2">组合B</a></td>
			<td><a href="index.php?app=discount&amp;act=edit&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>">编辑</a>|<a href="index.php?app=discount&amp;act=drop&amp;id=<?php echo $this->_var['discount']['discount_id']; ?>">删除</a></td>
			
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['discounts']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=discount&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
