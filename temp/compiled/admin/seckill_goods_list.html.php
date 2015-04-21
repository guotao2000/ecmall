<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   $(function(){
       for(var i=0;i<$('.goods_image_td').length;i++){
	       $('.goods_image_td').eq(i).bind('mouseover',{iIndex:i},showimageframe);
		   $('.goods_image_td').eq(i).bind('mouseout',{iIndex:i},showimageframe);
	   }
   });
   
   function showimageframe(event){
       var i = event.data.iIndex;
	   if($('.prev_image_frame').eq(i).css('display') == 'none'){
	       $('.prev_image_frame').eq(i).show();
		   $('.prev_image_frame').eq(i).children('img').bind('mouseover',zone_img_max);
		   $('.prev_image_frame').eq(i).children('img').bind('mouseout',zone_img_min);
	   }
	   else{
	       $('.prev_image_frame').eq(i).hide();
	   }
   }
   
   function zone_img_max(){
       $(this).addClass('img_zone_win');
   }
   
   function zone_img_min(){
      $(this).removeClass('img_zone_win'); 
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
	<li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀商品管理</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_apply">待审核</a>
	</li>
<li><a class="btn3" href="index.php?module=seckill&act=seckill_subject">秒杀主题</a>
	</li>
	<li><span>商品列表</span> </li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
        <input type="hidden" name="module" value="seckill" />
		<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <input type="hidden" name="act" value="seckill_goods_list" />
        商品名称:
        <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />
        <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?module=seckill&act=seckill_goods_list&id=<?php echo $_GET['id']; ?>">撤销检索</a>
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
	 
      <td class="table-center"><span ectype="order_by" fieldname="add_time">申请时间</span></td>
	   <td class="table-center"><span ectype="order_by" fieldname="sgrade">开始时间</span></td> 

     
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['seckill_goods_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists');if (count($_from)):
    foreach ($_from AS $this->_var['lists']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['lists']['sec_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['subject_name']); ?></td>
      <td class="goods_image_td"><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=goods&id=<?php echo $this->_var['lists']['sec_id']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['lists']['goods_name']); ?></a><div class="prev_image_frame"><?php $_from = $this->_var['lists']['image']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'image');if (count($_from)):
    foreach ($_from AS $this->_var['image']):
?> <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['image']['image_url']; ?>"/><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div></td>
      <td><?php echo price_format($this->_var['lists']['sec_price']['0']['price']); ?>/<?php echo price_format($this->_var['lists']['price']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['lists']['sec_quantity']); ?></td>
      <td class="table-center"><span><?php echo htmlspecialchars($this->_var['lists']['store_name']); ?></span> </td>
	  <td class="table-center"><span><?php echo local_date("Y-m-d",$this->_var['lists']['add_time']); ?></span> </td>
      <td class="table-center"><span><?php echo local_date("Y-m-d",$this->_var['lists']['start_time']); ?>
        </span></td>
  
      <td class="handler"><a href="javascript:drop_confirm('您真的批准此件商品参加秒杀活动吗?','index.php?module=seckill&act=seckill_agree&id=<?php echo $this->_var['lists']['sec_id']; ?>')">通过</a>&nbsp;|&nbsp;<a href="index.php?module=seckill&act=seckill_view&id=<?php echo $this->_var['lists']['sec_id']; ?>&uid=<?php echo $this->_var['lists']['store_id']; ?>">查看</a><br /><a href="index.php?module=seckill&act=seckill_refuce&id=<?php echo $this->_var['lists']['sec_id']; ?>&uid=<?php echo $this->_var['lists']['store_id']; ?>">拒绝</a>&nbsp;|&nbsp;<a href="javascript:drop_confirm('您确定要删除它吗？','index.php?module=seckill&act=seckill_del&id=<?php echo $this->_var['lists']['sec_id']; ?>')">删除</a></td>
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

	  <input class="formbtn batchButton" type="button" value="通过" name="id" uri="index.php?module=seckill&act=seckill_agree" presubmit="confirm('你确定批量修改?');" />
      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?module=seckill&act=seckill_del" presubmit="confirm('你确定批量修改?');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 