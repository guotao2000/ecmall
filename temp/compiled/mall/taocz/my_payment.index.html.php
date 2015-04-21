<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
        <div class="public_index table">
            <table>
                <tr class="line_bold">
                    <th class="" colspan="6">
                    </th>
                </tr>
                <?php if ($this->_var['payments']): ?>
                <tr class="gray_new">
                    <th class="width13">名称</td>
                    <th>插件说明</th>
                    <th class="width4">启用</th>
                    <th class="width13">操作</th>
                </tr>
                <?php endif; ?>
                <?php $_from = $this->_var['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['v']['iteration']++;
?>
                <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                    <td><span class="padding1"><?php echo htmlspecialchars($this->_var['payment']['payment_name']); ?></span></td>
                    <td><?php echo $this->_var['payment']['payment_desc']; ?></td>
                    <td class="align2"><?php if ($this->_var['payment']['enabled']): ?>是<?php else: ?>否<?php endif; ?></td>
                    <td>
                    <div class="padding1">
                     <?php if ($this->_var['payment']['enabled']): ?>
                        <a href="javascript:uninstall(<?php echo $this->_var['payment']['payment_code']; ?>);" class="delete">卸载</a>
                    <?php else: ?>
                        <a href="javascript:install(<?php echo $this->_var['payment']['payment_code']; ?>);" class="add1_ico">安装</a>
                    <?php endif; ?>
                    </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" class="member_no_records">没有可用的支付方式，请联系管理员解决此问题</td>
                </tr>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
            <div class="wrap_bottom"></div>
        </div>
        <iframe name="my_payment" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
</div>
<div class="clear"></div>
    <script type="text/javascript">
        function uninstall( payment_code) {
            url = "/index.php?app=my_payment&act=uyxw&payment_code=" + payment_code;
            $.get(url, '', function (data) {
                if (data == 1) {
                    alert("卸载成功！！");
                    window.top.location = window.top.location;
                } else {
                    alert("卸载失败！！");
                }


            });

        }

        function install(payment_code) {
            url = "/index.php?app=my_payment&act=iyxw&payment_code=" + payment_code;
            $.get(url, '', function (data) {
                if (data == 1) {
                    alert("安装成功！！");
                    window.top.location = window.top.location;
                } else {
                    alert("安装失败！！");
                }


            });
        }
    
    </script>
<?php echo $this->fetch('footer.html'); ?>
