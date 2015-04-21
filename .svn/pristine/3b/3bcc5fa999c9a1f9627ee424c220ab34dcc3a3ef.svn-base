<?php echo $this->fetch('header.html'); ?>
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
    <li><a class="btn3" href="index.php?module=seckill&act=seckill_manage">秒杀主题</a> </li>
  </ul>
</div>
<div id="group_view_content">
  <div id="groupbuy_info">
    <ul>
      <li class="item">秒杀主题</li>
      <li class="colon">:</li>
      <li class="content"><span><?php echo htmlspecialchars($this->_var['seckill_info']['subject_name']); ?></span></li>
      <li class="item">所属店铺</li>
      <li class="colon">:</li>
      <li class="content"><?php echo htmlspecialchars($this->_var['seckill_info']['store_name']); ?></li>
      <li class="item">商品名称</li>
      <li class="colon">:</li>
      <li class="content"><?php echo htmlspecialchars($this->_var['seckill_info']['goods_name']); ?></li>

      <li class="item">商品数量</li>
      <li class="colon">:</li>
      <li class="content"><?php echo htmlspecialchars($this->_var['seckill_info']['sec_quantity']); ?></li>
      <li class="item">申请时间</li>
      <li class="colon">:</li>
      <li class="content"><?php echo local_date("Y-m-d",$this->_var['seckill_info']['add_time']); ?></li>
      <li class="item">开始时间</li>
      <li class="colon">:</li>
      <li class="content"><?php echo local_date("Y-m-d",$this->_var['seckill_info']['start_time']); ?></li>
      <li class="item">商品规格</li>
      <li class="colon">:</li>
      <li class="content">
        <ul>
          <li class="distance2">规格</li>
          <li class="distance1">库存</li>
          <li class="distance1">价格</li>
          <li class="distance1">秒杀价</li>
          <?php $_from = $this->_var['seckill_info']['_spec']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
          <li class="distance2">
            <?php if ($this->_var['spec']['spec_1'] == "" && $this->_var['spec']['spec_2'] == "" && $this->_var['spec']['color_rgb'] == ""): ?>
            默认规格
            <?php else: ?>
            <?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>&nbsp;|&nbsp;<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>&nbsp;|&nbsp;<?php echo htmlspecialchars($this->_var['spec']['color_rgb']); ?>
            <?php endif; ?>
          </li>
          <li class="distance1"><?php echo htmlspecialchars($this->_var['spec']['stock']); ?></li>
          <li class="distance1"><?php echo price_format($this->_var['spec']['price']); ?></li>
          <li class="distance1"><?php echo price_format($this->_var['spec']['seckill_price']); ?></li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <div class="clear"></div>
        </ul>
        <div class="clear"></div>
      </li>
      <div class="clear"></div>
    </ul>
  </div>
  <div id="goods_image"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo htmlspecialchars($this->_var['seckill_info']['default_image']); ?>"/></div>
  <div class="clear"></div>
  <div class="groupbuy_view_action"><a href="index.php?module=seckill&act=seckill_goods_list&id=<?php echo $_GET['uid']; ?>" class="formbtn">返回</a></div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>