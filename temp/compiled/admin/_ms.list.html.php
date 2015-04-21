<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>促销商品管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=_ms_promotion">管理</a></li>
        <li><a class="btn1" href="index.php?app=_ms_promotion&amp;act=add">添加促销</a></li>
	
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="_ms_promotion" />
                <input type="hidden" name="act" value="list_zhuhe" />
               商品名:
                <input class="queryInput" type="text" name="title" value="<?php echo $this->_var['title']; ?>" />
                <input class="queryInput" type="hidden" name="id" value="<?php echo $this->_var['id']; ?>" />
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
        <?php if ($this->_var['zhuhes']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">秒杀促销名称</td>
            <td>商品编号</td>
            <td align="left">商品名称</td>
            <td>商品原价</td>
			<td align="left">商品促销价</td>
            <td>促销数量</td>

            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['zhuhes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'zhuhe');if (count($_from)):
    foreach ($_from AS $this->_var['zhuhe']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['zhuhe']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['zhuhe']['id']; ?>"/><?php endif; ?></td>
            <td><?php echo $this->_var['zhuhe']['p_name']; ?></td>
            <td><?php echo $this->_var['zhuhe']['goods_id']; ?></td>
            <td><?php echo $this->_var['zhuhe']['goods_name']; ?>-<?php echo $this->_var['zhuhe']['store_id']; ?></td>
            <td><?php echo $this->_var['zhuhe']['oldprice']; ?></td>
			<td><?php echo $this->_var['zhuhe']['newprice']; ?></td>
			<td><?php echo $this->_var['zhuhe']['quantity']; ?></td>
			<td><a href="index.php?app=_ms_promotion&amp;act=edit_zhuhe&amp;id=<?php echo $this->_var['zhuhe']['id']; ?>">编辑</a>|<a href="index.php?app=_ms_promotion&amp;act=drop_zhuhe&amp;id=<?php echo $this->_var['zhuhe']['id']; ?>">删除</a></td>
			
          
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
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=_ms_promotion&act=drop_zhuhe" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
			<input class="formbtn" type="button" onclick="history.back()" value="返回" />
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
