<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"><style type="text/css">
body,td {font-size:13px;}
</style>

</head><body><h1 align="center">订单信息</h1>
<table cellpadding="1" width="100%">
    <tbody><tr>
        <td width="8%">卖家名称：</td>
        <td><?php echo htmlspecialchars($this->_var['order']['seller_name']); ?></td>
        <td align="right">下单时间：</td><td><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['add_time']); ?></td>
        <td align="right">支付方式：</td><td><?php echo htmlspecialchars($this->_var['order']['payment_name']); ?></td>
        <td align="right">订单编号：</td><td><?php echo htmlspecialchars($this->_var['order']['order_sn']); ?></td>
    </tr>
    <tr>
        <td>付款时间：</td><td><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['pay_time']); ?></td>
        <td align="right">发货时间：</td><td><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['ship_time']); ?></td>
        <td align="right">配送方式：</td><td><?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?></td>
        <td align="right">订单状态：</td><td><?php if ($this->_var['order']['status'] == 11): ?>等待买家付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 12): ?>等待买家收货付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 13): ?>买家已付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 20): ?>等待卖家发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 21): ?>货到付款已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 30): ?>卖家已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 40): ?>交易完成<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 0): ?>交易关闭<?php endif; ?> </td>
    </tr>
    <tr>
        <td>收货地址：</td>
        <td colspan="1">
        <?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['address']); ?>&nbsp;
        </td>
		<td align="right">买家用户名：</td>
        <td><?php if ($this->_var['order']['from_weixin'] == 1): ?><?php echo $this->_var['order']['wx_nickname']; ?><?php else: ?><?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?><?php endif; ?>&nbsp;</td>
        <td align="right">收货人：</td>
        <td><?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?>&nbsp;</td>
        <td align="right">手机：</td>
        <td><?php echo htmlspecialchars($this->_var['order_extm']['phone_mob']); ?></td>
        
    </tr>
</tbody></table>
<table style="border-collapse:collapse;border-color:#000;" border="1" width="100%">
    <tbody><tr align="center">
        <td bgcolor="#cccccc">商品名称  </td>
        <td bgcolor="#cccccc">货号    </td>
        <td bgcolor="#cccccc">属性  </td>
        <td bgcolor="#cccccc">价格 </td>
        <td bgcolor="#cccccc">数量</td>
        <td bgcolor="#cccccc">小计    </td>
    </tr>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr>
        <td>&nbsp;<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>
        </td>
        <td>&nbsp;<?php echo htmlspecialchars($this->_var['goods']['goods_sn']); ?> </td>
        <td><?php echo htmlspecialchars($this->_var['goods']['specification']); ?>
        </td>
        <td align="right"><?php echo price_format($this->_var['goods']['price']); ?>元&nbsp;</td>
        <td align="right"><?php echo $this->_var['goods']['quantity']; ?>&nbsp;</td>
        <td align="right"><?php echo price_format($this->_var['goods']['per_amount']); ?>元&nbsp;</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <tr>
        
        <td colspan="4">
                </td>
        
        <td colspan="2" align="right">商品总金额：<?php echo price_format($this->_var['order']['goods_amount']); ?>元</td>
    </tr>
</tbody></table>
<table border="0" width="100%">
    <tbody><tr align="right">
        <td>                        
        + 配送费用：<?php echo price_format($this->_var['order_extm']['shipping_fee']); ?>元                        
        </td>
    </tr>
    <tr align="right">
        <td>
        - 红&#12288;包：<?php echo price_format($this->_var['order']['discount']); ?>元        </td>
    </tr>
    <tr align="right">
        <td>
        = 应付款金额：<?php echo price_format($this->_var['order']['order_amount']); ?>元        </td>
    </tr>
</tbody></table>
<table border="0" width="100%">
            
    <tbody><tr>
        <td>
        倍全商城
        </td>
    </tr>
    <tr>
        <td>
        	<img src="<?php echo $this->_var['qrcode_src']; ?>" />
        </td>
    </tr>
    <tr align="right">
        <td>打印时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['otime']); ?>&nbsp;&nbsp;&nbsp;操作者：<?php echo htmlspecialchars($this->_var['user_name']); ?></td>
    </tr>
</tbody></table></body></html>