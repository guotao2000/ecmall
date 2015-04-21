<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>促销管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=_ms_promotion&amp;act=add">添加促销</a></li>
	
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="_ms_promotion" />
                <input type="hidden" name="act" value="index" />
                活动名称:
                <input class="queryInput" type="text" name="s_p_name" value="<?php echo $this->_var['s_p_name']; ?>" />
               
                <select id="schedule_name" name="s_p_type" onchange="addTime(this);">
                   <option value="0">全部</option>
                    <option <?php if ($this->_var['s_p_type'] == 1): ?> selected="selected" <?php endif; ?> value="1">秒杀</option>
                    <option <?php if ($this->_var['s_p_type'] == 2): ?> selected="selected" <?php endif; ?> value="2">组合</option>
                    <option <?php if ($this->_var['s_p_type'] == 3): ?> selected="selected" <?php endif; ?> value="3">满减</option>
                    <option <?php if ($this->_var['s_p_type'] == 4): ?> selected="selected" <?php endif; ?> value="4">满赠</option>
                
                </select>

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
            <td align="left">促销活动名称</td>
            <td>开始时间</td>
            <td align="left">结束时间</td>
            <td>促销状态</td>	
            <td>促销类型</td>	
            <td>操作时间</td>            
			<td align="left">操作人</td>
			<td>活动商品</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['discounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'discount');if (count($_from)):
    foreach ($_from AS $this->_var['discount']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['discount']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['discount']['p_id']; ?>"/><?php endif; ?></td>
            <td> <?php if ($this->_var['discount']['p_type'] != 3): ?> <a href="index.php?app=_ms_promotion&amp;act=list_zhuhe&amp;id=<?php echo $this->_var['discount']['p_id']; ?>"><?php echo $this->_var['discount']['p_name']; ?> <?php else: ?> <?php echo $this->_var['discount']['p_name']; ?> </a><?php endif; ?> </td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['start_time']); ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['end_time']); ?></td>
            <td><?php if ($this->_var['discount']['state'] == 1): ?>未确认<?php elseif ($this->_var['discount']['state'] == 2): ?>确认<?php elseif ($this->_var['discount']['state'] == 3): ?>启动中<?php elseif ($this->_var['discount']['state'] == 4): ?>终止<?php endif; ?></td>
            <td><?php echo $this->_var['discount']['p_type_name']; ?></td>
			<td><?php echo local_date("Y-m-d H:i:s",$this->_var['discount']['add_time']); ?></td>
			<td><?php echo $this->_var['discount']['operate_person']; ?></td>
			<td> <?php if ($this->_var['discount']['p_type'] != 3): ?> <a href="index.php?app=_ms_promotion&amp;act=edit_sp&amp;id=<?php echo $this->_var['discount']['p_id']; ?>&amp;p_type=<?php echo $this->_var['discount']['p_type']; ?>&amp;state=<?php echo $this->_var['discount']['state']; ?>">编辑活动商品 </a><?php endif; ?></td>
			<td><a href="index.php?app=_ms_promotion&amp;act=edit&amp;id=<?php echo $this->_var['discount']['p_id']; ?>">编辑</a>|<a href="index.php?app=_ms_promotion&amp;act=drop&amp;id=<?php echo $this->_var['discount']['p_id']; ?>">删除</a></td>
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
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=_ms_promotion&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="未确认" name="id" uri="index.php?app=_ms_promotion&act=unbesure" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="确认" name="id" uri="index.php?app=_ms_promotion&act=besure" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="启动" name="id" uri="index.php?app=_ms_promotion&act=executing" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="终止" name="id" uri="index.php?app=_ms_promotion&act=finished" />
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
