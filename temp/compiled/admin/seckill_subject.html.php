<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
 $(function(){
    $('.active_seckill').bind('click',ajax_update_show);
	});
function ajax_update_show(){
    var type = $(this).attr('title') == '取消显示' ? 'hide' : 'show';
	var id = $(this).parent().children('input').eq(0).val();
	var cmd = $(this);
	var imgTil = type == 'show' ? '取消显示' : '激活主题';
	var imgUrl = type == 'show' ? "<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_enabled.gif" : "<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_disabled.gif";
	$.ajax({
	   type: 'get',
	   dataType: 'text',
	   url: 'index.php?module=seckill&act=subject_ajax_update&id='+id+'&type='+type,
	   success: function(msg){
	     if($.trim(msg) == 'true'){
	       cmd.attr('src',imgUrl);
		   cmd.attr('title',imgTil);
		 }
	   }
	});
}
</script>
<div id="rightTop">
  <p>秒杀促销</p>
  <ul class="subnav">
    <li><a class="btn3" href="index.php?module=seckill&act=set_start_time">设置开始时间</a></li>
	</li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_goods_qty">商品数量管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_store_seckill">店铺等级列表</a> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_apply">待审核</a> </li>
    <li><span>秒杀主题</span> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=subject_add">新增主题</a> </li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
        <input type="hidden" name="module" value="seckill" />
        <input type="hidden" name="act" value="seckill_subject" />
        秒杀主题名称:
        <input class="queryInput" type="text" name="subject_name" value="<?php echo htmlspecialchars($_GET['subject_name']); ?>" />
       <!-- 支持秒杀:
        <select class="querySelect" name="state">
          <option value="">请选择...</option>
          
          
            <?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
          
        
        </select>-->
        <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?module=seckill&act=seckill_subject">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?> </div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['subject_lists']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td width="400" style="text-align:center;">秒杀主题名称</td>
      <td><span ectype="order_by" fieldname="store_name">主题描述</span></td>
      <td><span ectype="order_by" fieldname="store_name">显示</span></td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['subject_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists');if (count($_from)):
    foreach ($_from AS $this->_var['lists']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['lists']['subject_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['subject_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['subject_desc']); ?></td>
      <td><?php if ($this->_var['lists']['subject_state'] == 1): ?>
        <img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_enabled.gif"  title="取消显示" class="active_seckill"/>
        <?php else: ?>
        <img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_disabled.gif"  title="激活主题" class="active_seckill"/>
        <?php endif; ?>
		<input type="hidden" value="<?php echo $this->_var['lists']['subject_id']; ?>" />
		</td>
      <td class="handler">
        <a href="index.php?module=seckill&act=edit_subject&id=<?php echo $this->_var['lists']['subject_id']; ?>">编辑</a>&nbsp;|&nbsp;<a href="javascript:drop_confirm('您确定要删除它吗？','index.php?module=seckill&act=seckill_subject_del&id=<?php echo $this->_var['lists']['subject_id']; ?>')">删除</a></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="12">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['subject_lists']): ?>
  <div id="dataFuncs">
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div id="batchAction" class="left paddingT15">
      <input class="formbtn" type="button" value="新增" onClick='javascript:location.href = "index.php?module=seckill&act=subject_add"'/>&nbsp;<input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?module=seckill&act=seckill_subject_del" presubmit="confirm('您真的确认删除所选主题吗？');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 