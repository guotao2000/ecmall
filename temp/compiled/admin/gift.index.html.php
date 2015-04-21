<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>满赠满减管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=gift&amp;act=add">添加满赠满减</a></li>
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="gift" />
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
        <?php if ($this->_var['gifts']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">促销名称</td>
            <td>开始时间</td>
            <td align="left">结束时间</td>
            <td>促销状态</td>
			<td align="left">执行店铺</td>
            <td>操作时间</td>
			<td align="left">操作人</td>
			<td>赠品</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['gifts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gift');if (count($_from)):
    foreach ($_from AS $this->_var['gift']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['gift']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['gift']['id']; ?>"/><?php endif; ?></td>
            <td><?php echo $this->_var['gift']['promotion_name']; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['gift']['start_time']); ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['gift']['end_time']); ?></td>
            <td><?php if ($this->_var['gift']['status'] == 2): ?>启用<?php else: ?>未启用<?php endif; ?></td>
			<td><?php echo $this->_var['gift']['store_id']; ?></td>
			<td><?php echo local_date("Y-m-d H:i:s",$this->_var['gift']['operate_time']); ?></td>
			<td><?php echo $this->_var['gift']['operate_person']; ?></td>
			<td><a href="index.php?app=gift&amp;act=zp&amp;name=<?php echo $this->_var['gift']['promotion_name']; ?>">查看</a></td>
			<td><a href="index.php?app=gift&amp;act=edit&amp;id=<?php echo $this->_var['gift']['id']; ?>">编辑</a>|<a href="index.php?app=gift&amp;act=drop&amp;id=<?php echo $this->_var['gift']['id']; ?>&amp;name=<?php echo $this->_var['gift']['promotion_name']; ?>">删除</a></td>
			
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['gifts']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=gift&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
