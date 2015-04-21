<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>折扣管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=discount&amp;act=add">添加促销</a></li>
		<!--<li><span>组合列表</span></li>-->
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="article" />
                <input type="hidden" name="act" value="index" />
                标题:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=article">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['zhuhes']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">促销名称</td>
            <td>商品编号</td>
            <td align="left">商品名称</td>
            <td>商品原价</td>
			<td align="left">商品促销价</td>
            <td>促销数量</td>
			<td align="left">组合方式</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['zhuhes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'zhuhe');if (count($_from)):
    foreach ($_from AS $this->_var['zhuhe']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['zhuhe']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['zhuhe']['pa_id']; ?>"/><?php endif; ?></td>
            <td><?php echo $this->_var['zhuhe']['pa_name']; ?></td>
            <td><?php echo $this->_var['zhuhe']['goods_id']; ?></td>
            <td><?php echo $this->_var['zhuhe']['goods_name']; ?></td>
            <td><?php echo $this->_var['zhuhe']['original_price']; ?></td>
			<td><?php echo $this->_var['zhuhe']['promotion_price']; ?></td>
			<td><?php echo $this->_var['zhuhe']['promotion_num']; ?></td>
			<td><?php if ($this->_var['zhuhe']['p_type'] == 1): ?>组合A<?php else: ?>组合B<?php endif; ?></td>
			<td><a href="index.php?app=discount&amp;act=edit_zhuhe&amp;id=<?php echo $this->_var['zhuhe']['pa_id']; ?>">编辑</a>|<a href="index.php?app=discount&amp;act=drop_zhuhe&amp;id=<?php echo $this->_var['zhuhe']['pa_id']; ?>">删除</a></td>
			
          
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['zhuhes']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=discount&act=drop_zhuhe" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
			<input class="formbtn" type="button" onclick="history.back()" value="返回" />
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
