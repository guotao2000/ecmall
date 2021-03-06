<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>促销管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=promote">添加档期</a></li>
        <li><span>档期列表</span></li>
              
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_kuaixun">快讯列表</a></li>
            
        <li><a class="btn1" href="index.php?app=_ms_promotion">促销列表</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="promote" />
                <input type="hidden" name="act" value="list_schedule" />
                档期名称:
                <input class="queryInput" type="text" name="schedule_name" style="width:250px; vertical-align:middle;" value="<?php echo htmlspecialchars($_GET['schedule_name']); ?>" />
                档期状态:
                <select class="querySelect" id="schedule_state" name="schedule_state">
                <option value="0" <?php if ($_GET['schedule_state'] == 0): ?> selected="selected" <?php endif; ?> >请选择</option>
                <option value="1" <?php if ($_GET['schedule_state'] == 1): ?> selected="selected" <?php endif; ?>>未启用</option>
                <option value="2" <?php if ($_GET['schedule_state'] == 2): ?> selected="selected" <?php endif; ?>>启用</option>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
			<?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=promote&amp;act=list_schedule">取消</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['schedule']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td>档期名称</td>
            <td>开始时间</td>
            <td>结束时间</td>
            <td>档期状态</td>
            <td>录入时间</td>
            <td>操作人</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['schedule']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'schedule_item');if (count($_from)):
    foreach ($_from AS $this->_var['schedule_item']):
?>
        <tr class="tatr2">
            <td class="firstCell">
            	<input type="checkbox" class="checkitem" value="<?php echo $this->_var['schedule_item']['schedule_id']; ?>"/>
            </td>
            <td><?php echo htmlspecialchars($this->_var['schedule_item']['schedule_name']); ?></td>
            <td><?php echo $this->_var['schedule_item']['start_time']; ?></td>
            <td><?php echo $this->_var['schedule_item']['end_time']; ?></td>
            <td><?php echo $this->_var['schedule_item']['schedule_state']; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['schedule_item']['add_time']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['schedule_item']['operate_person']); ?></td>
           
            <td>
            	<a href="index.php?app=promote&amp;act=add_kuaixun&amp;scid=<?php echo $this->_var['schedule_item']['schedule_id']; ?>">添加快讯</a>|
                <a href="index.php?app=_ms_promotion">添加促销</a>|
            	<a href="index.php?app=promote&amp;act=enable_schedule&amp;id=<?php echo $this->_var['schedule_item']['schedule_id']; ?>">启用</a>|
            	<a href="index.php?app=promote&amp;act=disable_schedule&amp;id=<?php echo $this->_var['schedule_item']['schedule_id']; ?>">不启用</a>|
	            <a href="index.php?app=promote&amp;act=edit_schedule&amp;id=<?php echo $this->_var['schedule_item']['schedule_id']; ?>">编辑</a>|
	            <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=promote&amp;act=drop_schedule&amp;id=<?php echo $this->_var['schedule_item']['schedule_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['schedule']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=promote&act=drop_schedule" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="启用" name="id" uri="index.php?app=promote&act=enable_schedule" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="不启用" name="id" uri="index.php?app=promote&act=disable_schedule" />
            &nbsp;&nbsp;
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
