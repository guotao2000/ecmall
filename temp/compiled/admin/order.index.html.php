<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="/includes/libraries/javascript/bqmart.js" ></script>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<div id="rightTop">
    <p>订单管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
             <div class="left">
                <input type="hidden" name="app" value="order" />
                <input type="hidden" name="act" value="index" />
                <select class="querySelect" name="field"><?php echo $this->html_options(array('options'=>$this->_var['search_options'],'selected'=>$_GET['field'])); ?>
                </select>:<input class="queryInput" type="text" name="search_name" value="<?php echo htmlspecialchars($this->_var['query']['search_name']); ?>" />
                <select class="querySelect" name="status">
                    <option value="">订单状态</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['order_status_list'],'selected'=>$this->_var['query']['status'])); ?>
                </select>
                下单时间从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                订单金额从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['order_amount_from']; ?>" name="order_amount_from" />
                至:<input class="queryInput2" type="text" style="width:60px;" value="<?php echo $this->_var['query']['order_amount_to']; ?>" name="order_amount_to" class="pick_date" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=order">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['orders']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['orders']): ?>
        <tr class="tatr1">
            <td width="15%" class="firstCell"><span ectype="order_by" fieldname="seller_id">店铺名称</span></td>
            <td width="15%"><span ectype="order_by" fieldname="order_sn">订单号</span></td>
            <td width="10%"><span ectype="order_by" fieldname="add_time">下单时间</span></td>
            <td width="10%"><span ectype="order_by" fieldname="buyer_name">买家名称</span></td>
            <td width="10%"><span ectype="order_by" fieldname="order_amount">订单总价</span></td>
            <td>支付方式</td>
            <td width="10%"><span ectype="order_by" fieldname="status">订单状态</span></td>
             <td width="10%"><span ectype="order_by" fieldname="uin">推荐人号</span></td>
            <td width="10%">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php echo htmlspecialchars($this->_var['order']['seller_name']); ?></td>
            <td><?php echo $this->_var['order']['order_sn']; ?>&nbsp;&nbsp;<?php if ($this->_var['order']['extension'] == 'groupbuy'): ?>[团购]<?php endif; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['add_time']); ?></td>
            <td><?php if ($this->_var['order']['from_weixin'] == 1): ?><?php echo $this->_var['order']['wx_nickname']; ?><?php else: ?><?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?><?php endif; ?></td>
            <td><?php echo price_format($this->_var['order']['order_amount']); ?></td>
            <td><?php echo (htmlspecialchars($this->_var['order']['payment_name']) == '') ? '-' : htmlspecialchars($this->_var['order']['payment_name']); ?></td>
            <td><?php if ($this->_var['order']['status'] == 11): ?>等待买家付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 12): ?>等待买家收货付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 13): ?>买家已付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 20): ?>等待卖家发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 21): ?>货到付款已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 30): ?>卖家已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 40): ?>交易完成<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 0): ?>交易关闭<?php endif; ?> 
						 <?php if ($this->_var['order']['status'] == 25): ?>订单已确认<?php endif; ?> 
                        <?php if ($this->_var['order']['status'] == 51): ?>退货申请中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 52): ?>退货审核中<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 53): ?>退货失败<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 54): ?>退货成功<?php endif; ?> 
                    </td>
            <td><?php echo htmlspecialchars($this->_var['order']['uin']); ?></td>
            <td><a href="index.php?app=order&amp;act=view&amp;id=<?php echo $this->_var['order']['order_id']; ?>">查看</a>|<a href="index.php?app=order&amp;act=turn&amp;id=<?php echo $this->_var['order']['order_id']; ?>">甩单</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php if ($this->_var['orders']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<input type="hidden" value="0" id="store_id"/>
<?php echo $this->fetch('footer.html'); ?>
