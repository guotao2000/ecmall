<?php echo $this->fetch('header.html'); ?>




<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>

<?php if ($this->_var['categories']): ?>
<div style="width: 300px;margin: 10px 4px;padding: 10px;background: #fff;border: 1px solid #dedede;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;">
    <span class="red">
        <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
        <a href='<?php echo url('app=search&cate_id=' . $this->_var['category']['cate_id']. ''); ?>' style="display: inline-table;width: 30%;padding: 6px 0;text-align: center;color: #546280;font-size: .75em;"><?php echo htmlspecialchars($this->_var['category']['cate_name']); ?></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </span>
</div>
<?php endif; ?>
<?php echo $this->fetch('curlocal.html'); ?>
<div class="radius">
    <ul class="mu-l2w">
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
        <li style="padding: 10px;border-top: none;overflow: hidden;<?php if ($this->_foreach['fe_goods']['iteration'] != 1): ?>border-top: 1px solid #DED6C9;<?php endif; ?>line-height: 1.6em;">
            <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style="display: block;overflow: hidden;lear: both;padding: .22em 0;">
                <span class="mu-tmb" style="float:left;margin-right:8px;">
                    <img src="<?php echo $this->_var['goods']['default_image']; ?>" alt="<?php echo $this->_var['goods']['name']; ?>" width="100" height="100"/>
                </span>
                <span><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span>
                <span class="red" style="display: block;"><?php echo price_format($this->_var['goods']['price']); ?></span>
                <span><?php echo $this->_var['goods']['grade_name']; ?><img src="<?php echo $this->_var['goods']['credit_image']; ?>"/></span>
            </a>
        </li>
        <?php endforeach; else: ?>
        暂无此类商品
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</div>

<?php echo $this->fetch('page.bottom.html'); ?>


<?php echo $this->fetch('footer.html'); ?>

</div>
</body>
</html>