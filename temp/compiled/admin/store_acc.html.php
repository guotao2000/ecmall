<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   $(function(){
       $(".active_seckill").click(function(){
	       var sgrade_id = $(this).parent().children('input').eq(0).val();
		   var handle = $(this).parent().children('input').eq(1).val();
		   var sgrade_function = $(this).parent().prev().text();
		   var cmdObj = $(this);
		   var img_name = "";
		   var update_handle = "";
		   if(sgrade_id == ''){
		       alert('无此店铺等级');
			   return;
		   }
		   var action_alert = handle == 1 ? '你确认要取消该功能?' : '您确认要添加该功能?';
		   if(!window.confirm(action_alert)){
		       return;
		   }
		   img_name = handle == 1 ? 'positive_disabled' : 'positive_enabled';
		   update_handle = handle == 1 ? '' : 1;
		   handle = handle == 1 ? 'del' : 'add';
		   
		   $.ajax({
		       type: 'GET',
			   url: 'index.php?module=seckill&act=ajax_update_functions&handle='+handle+'&id='+sgrade_id,
			   success: function(msg){
			       if($.trim(msg) == ''){
				       alert('修改成功');
				       cmdObj.parent().children('input').eq(1).val(update_handle);
					   cmdObj.attr("src","<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/"+img_name+".gif");
					   if(handle == 'add'){
					       cmdObj.parent().prev().html(cmdObj.parent().prev().html()+"秒杀促销");
					   }
					   else{
					       cmdObj.parent().prev().html(cmdObj.parent().prev().html().replace("秒杀促销",""));
					   }
					   
				   }
				   else{
				       alert('更新失败');
				   }
			   }
		   });
	   });
   });
</script>
<div id="rightTop">
  <p>秒杀促销</p>
  <ul class="subnav">
<li><a class="btn3" href="index.php?module=seckill&act=set_start_time">设置开始时间</a></li>
	</li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_goods_qty">商品数量管理</a></li>
	<li><span>店铺等级列表</span>
	</li>
	<li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a>
	</li>
	<li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_apply">待审核</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_subject">秒杀主题</a>
	</li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
        <input type="hidden" name="module" value="seckill" />
        <input type="hidden" name="act" value="set_store_seckill" />
        等级名称:
        <input class="queryInput" type="text" name="sgrade_name" value="<?php echo htmlspecialchars($_GET['sgrade_name']); ?>" />
		支持秒杀:
          <select class="querySelect" name="state">
            <option value="">请选择...</option>
            <?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
          </select>
        <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?module=seckill&act=set_store_seckill">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?> </div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['stores']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>等级名称</td>
      <td><span ectype="order_by" fieldname="store_name">商品数</span></td>
      <td><span ectype="order_by" fieldname="store_name">上传空间(MB)</span></td>
      <td><span ectype="order_by" fieldname="region_id">模板数</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="sgrade">收费标准</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="add_time">附加功能</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="state">秒杀促销</span></td>
      <td class="handler">简介</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['store']['grade_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['store']['grade_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['store']['goods_limit']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['store']['space_limit']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['store']['skin_limit']); ?></td>
      <td class="table-center"><span><?php echo price_format($this->_var['store']['charge']); ?>/<?php echo $this->_var['lang'][$this->_var['store']['unit']]; ?></span>
</td>
      <td class="table-center"><span><?php $_from = $this->_var['store']['functions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'function');if (count($_from)):
    foreach ($_from AS $this->_var['function']):
?><?php echo htmlspecialchars($this->_var['function']); ?><br /><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span></td>
      <td class="table-center"><?php if ($this->_var['store']['has_seckill']): ?><img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_enabled.gif"  title="取消该功能" class="active_seckill"/><?php else: ?><img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_disabled.gif"  title="激活该功能" class="active_seckill"/><?php endif; ?><input type="hidden" value="<?php echo $this->_var['store']['grade_id']; ?>" /><input type="hidden" value="<?php echo $this->_var['store']['has_seckill']; ?>" /></td>
      <td class="handler">
<?php echo $this->_var['store']['description']; ?></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="12">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['stores']): ?>
  <div id="dataFuncs">
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div id="batchAction" class="left paddingT15">
      <input class="formbtn batchButton" type="button" value="批量修改" name="id" uri="index.php?module=seckill&act=batch_update" presubmit="confirm('你确定批量修改?');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 