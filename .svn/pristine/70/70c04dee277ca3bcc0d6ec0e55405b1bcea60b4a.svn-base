<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   $(function(){
       $('.active_seckill').bind('click',active_seckill);
   });
   
   function active_seckill(){
       var sec_id = $(this).parent().children('input').val();
	   var type = ($(this).attr('title') == "激活该功能") ? 'active' : 'cancel';
	   var text = type == 'active' ? '取消该功能' : '激活该功能';
	   var image_url = type != 'active' ? '<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_disabled.gif' : '<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_enabled.gif';
	   var cmdObj = $(this);
	   $.ajax({
	       type: 'get',
		   url: 'index.php?module=seckill&act=seckill_recommended&ajax=true&id='+sec_id+'&type='+type,
		   success: function(msg){
		       if($.trim(msg) == 'success'){
			       cmdObj.attr('title',text);
				   
				   cmdObj.attr('src',image_url);
			   }
			   else{
			       alert('edit_recommended_error');
			   }
		   }
	   })

   }
</script>
<div id="rightTop">
  <p>秒杀促销</p>
  <ul class="subnav">
    <li><a class="btn3" href="index.php?module=seckill&act=set_start_time">设置开始时间</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_period">秒杀时间管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_goods_qty">商品数量管理</a></li>
    <li><a class="btn3" href="index.php?module=seckill&act=set_store_seckill">店铺等级列表</a> </li>
    <li><span>秒杀商品管理</span></li>
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
        <input type="hidden" name="act" value="seckill_manage" />
        商品名称:
        <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />
		状态:
          <select class="querySelect" name="state">
            <option value="">请选择...</option>
            <?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
          </select>
        <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?module=seckill&act=seckill_manage">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?> </div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['seckill_goods_lists']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>秒杀主题</td>
      <td><span ectype="order_by" fieldname="store_name">商品名称</span></td>
      <td><span ectype="order_by" fieldname="store_name">秒杀价/商品原价</span></td>
      <td><span ectype="order_by" fieldname="region_id">商品数量</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="sgrade">所属店铺</span></td>
	  <td class="table-center"><span ectype="order_by" fieldname="sgrade">开始时间</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="add_time">状态</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="state">推荐</span></td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['seckill_goods_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists');if (count($_from)):
    foreach ($_from AS $this->_var['lists']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['lists']['sec_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['subject_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['goods_name']); ?></td>
      <td><?php echo price_format($this->_var['lists']['sec_price']['0']['price']); ?>/<?php echo price_format($this->_var['lists']['price']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['sec_quantity']); ?></td>
      <td class="table-center"><span><?php echo htmlspecialchars($this->_var['lists']['store_name']); ?></span> </td>
	  <td class="table-center"><span><?php echo local_date("Y-m-d",$this->_var['lists']['start_time']); ?></span> </td>
      <td class="table-center"><span><?php echo htmlspecialchars($this->_var['lists']['sec_state']); ?>
        </span></td>
      <td class="table-center"> <?php if ($this->_var['lists']['sec_state'] != $this->_var['lang']['seckill_end']): ?><?php if ($this->_var['lists']['recommended'] == SECKILL_RECOMMENDED): ?>
        <img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_enabled.gif"  title="取消该功能" class="active_seckill"/>
        <?php else: ?>
        <img src="<?php echo $this->_var['site_url']; ?>/admin/templates/style/images/positive_disabled.gif"  title="激活该功能" class="active_seckill"/>
        <?php endif; ?>
		<?php else: ?>
		已结束
		<?php endif; ?>
        <input type="hidden" value="<?php echo $this->_var['lists']['sec_id']; ?>" /></td>
      <td class="handler"><a href="index.php?module=seckill&act=seckill_del&id=<?php echo $this->_var['lists']['sec_id']; ?>"> 删除</a></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="12">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['seckill_goods_lists']): ?>
  <div id="dataFuncs">
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div id="batchAction" class="left paddingT15">
	 <input class="formbtn batchButton" type="button" value="推荐" name="id" uri="index.php?module=seckill&act=seckill_recommended" presubmit="confirm('您确定批量推荐秒杀商品?');" />
      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?module=seckill&act=seckill_del" presubmit="confirm('batch_delete');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 