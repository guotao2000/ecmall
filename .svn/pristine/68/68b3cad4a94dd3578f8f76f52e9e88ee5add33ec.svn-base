<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function selChanged(id_val){
		var selId = $('#selectOptionID_' + id_val).val();
		if(selId == 0){
			return;
		}
		/*if(selId == 1){
			window.location.href = "index.php?app=weixin_follow&wx_id=" + id_val;
		}
		if(selId == 2){
			window.location.href = "index.php?app=weixin_keyword&wx_id=" + id_val;
		}*/
		if(selId == 3){
			window.location.href = "index.php?app=weixin_message&act=wxtw_list&wx_id=" + id_val;
		}
		/*if(selId == 4){
			window.location.href = "index.php?app=weixin_menu&wx_id=" + id_val;
		}*/
		if(selId == 5){
			window.location.href = "index.php?app=weixin_code&wx_id=" + id_val;
		}
		
	}
</script>
<div id="rightTop">
  <p>微信公众平台管理（支持添加多个公众号）</p>
  <ul class="subnav">
    <li>
    	<a class="btn1" href="index.php?app=weixin_config">添加公众号</a>
    </li>
    <li> 	
    	<span>公众号列表</span>
    </li>
  </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="weixin_config" />
                <input type="hidden" name="act" value="wx_list" />
				 标题:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=weixin_config&amp;act=wx_list">取消查询</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['weixins']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td>编号</td>
            <td>公众号名称</td>
            <td>接口配置URL</td>
            <td>接口配置Token</td>
            <td>微信AppId</td>
            <td>微信AppSecret</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['weixins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'weixin');if (count($_from)):
    foreach ($_from AS $this->_var['weixin']):
?>
        <tr class="tatr2">
            <td class="firstCell">
            <input type="checkbox" class="checkitem" value="<?php echo $this->_var['weixin']['wx_id']; ?>"/>
            </td>
            <td><?php echo $this->_var['weixin']['wx_id']; ?></td>
            <td><?php echo htmlspecialchars($this->_var['weixin']['account']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['weixin']['url']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['weixin']['token']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['weixin']['appid']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['weixin']['appsecret']); ?></td>
            <td>
            	<a href="index.php?app=weixin_config&amp;act=edit&amp;id=<?php echo $this->_var['weixin']['wx_id']; ?>">编辑</a>
                |
                <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=weixin_config&amp;act=drop&amp;id=<?php echo $this->_var['weixin']['wx_id']; ?>');">删除</a>
            	<select class="querySelect" id="selectOptionID_<?php echo $this->_var['weixin']['wx_id']; ?>" name="selectOption" onchange="selChanged(<?php echo $this->_var['weixin']['wx_id']; ?>)">
                	<option value="0">请选择...</option>
                	<!--<option value="1">关注自动回复</option>
                	<option value="2">关键词自动回复</option>-->
                	<option value="3">消息自动回复</option>
                	<!--<option value="4">自定义菜单</option>-->
                	<option value="5">带参数二维码</option>
                </select>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['weixins']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=weixin_config&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>