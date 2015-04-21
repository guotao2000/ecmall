<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>微信公众平台管理（支持添加多个公众号）</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=weixin_config">添加公众号</a></li>
    <li><a class="btn1" href="index.php?app=weixin_config&amp;act=wx_list">公众号列表</a></li>
	<li><a class="btn1" href="index.php?app=weixin_message&amp;wx_id=<?php echo $_GET['wx_id']; ?>">新增图文</a></li>
  </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="weixin_message" />
                <input type="hidden" name="act" value="wxtw_list" />
				<input type="hidden" name="wx_id" value="<?php echo $_GET['wx_id']; ?>" />
				 标题:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" style="width:400px;" />
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
        <?php if ($this->_var['wxtws']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td>编号</td>
			<td>封面图片</td>
            <td>标题</td>
            <td>自动回复类型</td>
            <!-- <td>图文类型</td> -->
			<!-- <td>是否默认</td> -->
            <td>显示</td>
            <td>指定二维码参数值</td>
			<td>关键词</td>
			<td>自定义链接</td>
			<td>添加时间</td>
			<td>修改时间</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['wxtws']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'wxtw');if (count($_from)):
    foreach ($_from AS $this->_var['wxtw']):
?>
        <tr class="tatr2">
            <td class="firstCell">
            <input type="checkbox" class="checkitem" value="<?php echo $this->_var['wxtw']['wxtw_id']; ?>"/>
            </td>
            <td><?php echo htmlspecialchars($this->_var['wxtw']['wxtw_id']); ?></td>
            <td><?php if ($this->_var['wxtw']['picurl']): ?><img src="<?php echo htmlspecialchars($this->_var['wxtw']['picurl']); ?>" width="80px" height="80px" /><?php else: ?>暂无图片<?php endif; ?></td>
			<td><?php echo sub_str($this->_var['wxtw']['title'],15); ?></td>
            <td><?php if ($this->_var['wxtw']['is_subscribe'] == 0): ?>关注时自动回复<?php else: ?>普通自动回复<?php endif; ?></td>
            <!-- <td><?php if ($this->_var['wxtw']['tw_type'] == 0): ?>单图文<?php else: ?>多图文<?php endif; ?></td> -->
			<!-- <td><?php if ($this->_var['wxtw']['is_default'] == 0): ?>否<?php else: ?>是<?php endif; ?></td> -->
            <td><?php if ($this->_var['wxtw']['is_pub'] == 0): ?>否<?php else: ?>是<?php endif; ?></td>
            <td><?php echo sub_str($this->_var['wxtw']['allow_uin'],15); ?></td>
			<td><?php echo sub_str($this->_var['wxtw']['keywords'],15); ?></td>
			<td><?php echo sub_str($this->_var['wxtw']['url'],15); ?></td>
			<td><?php echo local_date("Y-m-d H:i:s",$this->_var['wxtw']['add_time']); ?></td>
			<td><?php if ($this->_var['wxtw']['update_time']): ?><?php echo local_date("Y-m-d H:i:s",$this->_var['wxtw']['update_time']); ?><?php else: ?><?php endif; ?></td>
            <td>
				<!-- <a href="index.php?app=weixin_message&amp;act=view&amp;wx_id=<?php echo $this->_var['wxtw']['wx_id']; ?>&amp;wxtw_id=<?php echo $this->_var['wxtw']['wxtw_id']; ?>" target="_blank">预览</a>
                | -->
            	<a href="index.php?app=weixin_message&amp;act=edit&amp;wx_id=<?php echo $this->_var['wxtw']['wx_id']; ?>&amp;wxtw_id=<?php echo $this->_var['wxtw']['wxtw_id']; ?>">编辑</a>
                |
                <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=weixin_message&amp;act=drop&amp;id=<?php echo $this->_var['wxtw']['wxtw_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="11">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['wxtws']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=weixin_message&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>