<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>促销管理</p><?php echo $this->_var['conditions']; ?>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=promote">添加档期</a></li>
        <li><a class="btn1" href="index.php?app=promote&amp;act=list_schedule">档期列表</a></li>
        <li><span>快讯列表</span></li>
        <li><a class="btn1" href="index.php?app=promote">折扣列表</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="promote" />
                <input type="hidden" name="act" value="list_kuaixun" />
                快讯名称:
                <input class="queryInput" type="text" name="kuaixun_name" style="width:250px; vertical-align:middle;" value="<?php echo htmlspecialchars($_GET['kuaixun_name']); ?>" />
                快讯状态:
                <select class="querySelect" id="kuaixun_state" name="kuaixun_state">
					<option value="0" <?php if ($_GET['kuaixun_state'] == 0): ?>selected="selected"<?php endif; ?> >请选择</option>
					<option value="1" <?php if ($_GET['kuaixun_state'] == 1): ?>selected="selected"<?php endif; ?> >申请</option>
					<option value="2" <?php if ($_GET['kuaixun_state'] == 2): ?>selected="selected"<?php endif; ?> >确认</option>
					<option value="3" <?php if ($_GET['kuaixun_state'] == 3): ?>selected="selected"<?php endif; ?> >执行中</option>
					<option value="4" <?php if ($_GET['kuaixun_state'] == 4): ?>selected="selected"<?php endif; ?> >已结束</option>
					<option value="5" <?php if ($_GET['kuaixun_state'] == 5): ?>selected="selected"<?php endif; ?> >已取消</option>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=promote&amp;act=list_kuaixun">取消</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['kuaixuns']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td>快讯名称</td>
            <td>开始时间</td>
            <td>结束时间</td>
			<td>商品名称</td>
			<td>快讯价格</td>
			<td>执行店铺</td>
            <td>快讯状态</td>
            <td>录入时间</td>
            <td>操作人</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['kuaixuns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'kuaixun');if (count($_from)):
    foreach ($_from AS $this->_var['kuaixun']):
?>
        <tr class="tatr2">
            <td class="firstCell">
            	<input type="checkbox" class="checkitem" value="<?php echo $this->_var['kuaixun']['kuaixun_id']; ?>"/>
            </td>
            <td><?php echo htmlspecialchars($this->_var['kuaixun']['kuaixun_name']); ?></td>
            <td><?php echo $this->_var['kuaixun']['start_time']; ?></td>
            <td><?php echo $this->_var['kuaixun']['end_time']; ?></td>
			<td><?php echo htmlspecialchars($this->_var['kuaixun']['goods_name']); ?></td>
			<td><?php echo htmlspecialchars($this->_var['kuaixun']['kuaixun_price']); ?></td>
			<td><?php echo htmlspecialchars($this->_var['kuaixun']['store_ids']); ?></td>
            <td><?php echo $this->_var['kuaixun']['kuaixun_state']; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['kuaixun']['add_time']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['kuaixun']['operate_person']); ?></td>
           
            <td>
				<a href="index.php?app=promote&amp;act=add_kuaixun_goods&amp;kuaixun_id=<?php echo $this->_var['kuaixun']['kuaixun_id']; ?>&amp;kuaixun_state=<?php echo $this->_var['kuaixun']['kuaixun_state']; ?>">添加商品</a>|
	            <a href="index.php?app=promote&amp;act=edit_kuaixun&amp;id=<?php echo $this->_var['kuaixun']['kuaixun_id']; ?>">编辑</a>|
	            <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=promote&amp;act=drop_kuaixun&amp;id=<?php echo $this->_var['kuaixun']['kuaixun_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="11">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['kuaixuns']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=promote&act=drop_kuaixun" presubmit="confirm('您确定要删除它吗？');" />
			&nbsp;&nbsp;
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="申请" name="id" uri="index.php?app=promote&act=apply_kuaixun" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="确认" name="id" uri="index.php?app=promote&act=besure_kuaixun" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="执行中" name="id" uri="index.php?app=promote&act=executing_kuaixun" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
			<input class="formbtn batchButton" type="button" value="已结束" name="id" uri="index.php?app=promote&act=finished_kuaixun" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
			<input class="formbtn batchButton" type="button" value="已取消" name="id" uri="index.php?app=promote&act=canceled_kuaixun" />
            &nbsp;&nbsp;
            &nbsp;&nbsp;
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
