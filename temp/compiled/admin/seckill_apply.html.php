<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   $(function(){
       for(var i=0; i<$('.seckill_img_preview').length; i++){
	       $('.seckill_img_preview').eq(i).bind('mouseover',{Iindex:i},show_sec_image);
		   $('.seckill_img_preview').eq(i).bind('mouseout',{Iindex:i},show_sec_image);
	   }
	   
   })
   
   function show_sec_image(event){
      var i=event.data.Iindex;
	  if($('.img_preview').eq(i).css('display') == 'none'){
	     $('.img_preview').eq(i).show(); 
	  }
	  else{
	     $('.img_preview').eq(i).hide();
	  }
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

    <li><span>待审核</span> </li>
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_subject">秒杀主题</a> </li>
	
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
        <input type="hidden" name="module" value="seckill" />
        <input type="hidden" name="act" value="seckill_apply" />
        店铺名称:
        <input class="queryInput" type="text" name="store_name" value="<?php echo htmlspecialchars($_GET['store_name']); ?>" />
        <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?module=seckill&act=seckill_apply">撤销检索</a>
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
      <td width="200" style="text-align:center;">店铺名称&nbsp;|&nbsp;店主</td>
	  <td class="text_align_center">申请秒杀商品数</td>
      <td class="text_align_center"><span ectype="order_by" fieldname="store_name">最新申请秒杀商品</span></td>
      <td class="text_align_center"><span ectype="order_by" fieldname="store_name">最新申请秒杀主题</span></td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['seckill_goods_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists');if (count($_from)):
    foreach ($_from AS $this->_var['lists']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['lists']['subject_id']; ?>" /></td>
      <td class="text_align_center"><?php echo htmlspecialchars($this->_var['lists']['store_name']); ?>&nbsp;|&nbsp;<?php echo htmlspecialchars($this->_var['lists']['owner_name']); ?></td>
      <td class="text_align_center"><?php echo htmlspecialchars($this->_var['lists']['count']); ?></td>
	  <td class="text_align_center seckill_img_preview"><?php echo htmlspecialchars($this->_var['lists']['goods_name']); ?><img src="<?php echo $this->_var['site_url']; ?>/<?php echo htmlspecialchars($this->_var['lists']['default_image']); ?>" class="img_preview" /></td>
      <td class="text_align_center"><?php echo htmlspecialchars($this->_var['lists']['subject_name']); ?></td>
      <td class="handler">
        <a href="index.php?module=seckill&act=seckill_goods_list&id=<?php echo $this->_var['lists']['store_id']; ?>">商品列表</a>&nbsp;|&nbsp;<a href="index.php?module=seckill&act=seckill_subject_del&id=<?php echo $this->_var['lists']['store_id']; ?>&sid=<?php echo $this->_var['lists']['store_id']; ?>">删除</a></td>
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
    <div id="batchAction" class="left paddingT15"><input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?module=seckill&act=seckill_del" presubmit="confirm('您真的确认删除所选主题吗？');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 