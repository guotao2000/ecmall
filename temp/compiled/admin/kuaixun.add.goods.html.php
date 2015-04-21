<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/My97DatePicker/WdatePicker.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
$(function(){
    // multi-select mall_gcategory
    $('#gcategory').length>0 && gcategoryInit("gcategory");
});
//]]>
</script>
<div id="rightTop">
  <p>促销管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=promote">添加档期</a></li>
    <li><a class="btn1" href="index.php?app=promote&amp;act=list_schedule">档期列表</a></li>
    <li><a class="btn1" href="index.php?app=promote&amp;act=list_kuaixun">快讯列表</a></li>
    <li><a class="btn1" href="index.php?app=promote">折扣列表</a></li>
  </ul>
</div>

<div class="mrightTop1 info">
  <div class="fontl">
    <form method="get">
      <input type="hidden" name="app" value="promote" />
      <input type="hidden" name="act" value="add_kuaixun_goods" />
      <input type="hidden" name="kuaixun_state" value="确认" />
      <input type="hidden" name="kuaixun_id" value="<?php echo $_GET['kuaixun_id']; ?>" />
      <?php if ($_GET['closed']): ?>
      <input type="hidden" name="closed" value="1" />
      <?php endif; ?> 商品名称:
      <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />
      店铺名称:
      <input class="queryInput" type="text" name="store_name" value="<?php echo htmlspecialchars($_GET['store_name']); ?>" />
      <!--品牌:
      <input class="queryInput" type="text" name="brand" value="<?php echo htmlspecialchars($_GET['brand']); ?>" />-->
      商品条码:
      <input class="queryInput" type="text" name="goods_sn" value="<?php echo htmlspecialchars($_GET['goods_sn']); ?>" />
      <br />
      <span style="position: relative; top: 5px;">
      <div class="left">
          商品分类:
          <div id="gcategory" style="display:inline;">
            <input type="hidden" name="cate_id" value="0" class="mls_id" />
            <select class="querySelect">
              <option>请选择...</option>
              <?php echo $this->html_options(array('options'=>$this->_var['gcategories'])); ?>
            </select>
          </div>
          <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($_GET['cate_id'] || $this->_var['query']['goods_name'] || $this->_var['query']['store_name'] || $this->_var['query']['brand']): ?>
      <a class="left formbtn1" href="index.php?app=promote&act=add_kuaixun_goods&kuaixun_state=确认&kuaixun_id=<?php echo $_GET['kuaixun_id']; ?><?php if ($this->_var['query']['closed']): ?>&amp;closed=<?php echo $this->_var['query']['closed']; ?><?php endif; ?>">撤销检索</a>
      <?php endif; ?>
      </span>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>

<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['goods_list']): ?>
    <tr class="tatr1">
      <td width="10%" class="firstCell">选择</td>
      <td width="35%"><span ectype="order_by" fieldname="goods_name">商品名称</span></td>
      <td width="15%"><span ectype="order_by" fieldname="goods_sn">商品编码</span></td>
      <td width="10%"><span ectype="order_by" fieldname="price">商品价格</span></td>
      <td width="20%"><span ectype="order_by" fieldname="cate_id">分类名称</span></td>
      <td width="10%"><span ectype="order_by" fieldname="store_name">店铺名称</span></td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
      <td><span><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['sku']); ?></td>
      <td><?php echo $this->_var['goods']['price']; ?></td>
      <td><?php echo nl2br($this->_var['goods']['cate_name']); ?></td>
	  <td><?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data info">
      <td colspan="6">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['goods_list']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15">&nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="添加" name="id" uri="index.php?app=promote&act=add_goods_to_kuaixun&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>&kuaixun_id=<?php echo $this->_var['kuaixun_id']; ?>&kuaixun_state=确认" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
   <?php endif; ?>
  </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>