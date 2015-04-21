<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>红包管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=couponadmin&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get" >
            <div class="left">
                <input type="hidden" name="app" value="couponadmin" />
                <input type="hidden" name="act" value="index" />
                红包编号:
                <input class="queryInput" type="text" name="t_coupon_id" value="" />
                 门店编号:
                <input class="queryInput" type="text" name="t_store_id" value="" />
                红包名称:
                 <input class="queryInput" type="text" name="t_coupon_name" value="" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
          
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
       
        <tr class="tatr1">
            <td align="left">红包编号</td>
            <td>门店编号</td>
            <td align="left">红包名称</td>
            <td>金额</td>
			<td align="left">使用次数</td>
            <td>开始时间</td>
            <td align="left">结束时间</td>
            <td>限额</td>
			<td align="left">是否启用</td>
            <td>允许店铺列表</td>
			<td align="left">限制分类</td>
            <td>备注</td>
           <td>操作</td>
        </tr>
      
        <?php $_from = $this->_var['confs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'conf');if (count($_from)):
    foreach ($_from AS $this->_var['conf']):
?>
        <tr class="tatr2">
            <td><?php echo $this->_var['conf']['coupon_id']; ?></td>
            <td><?php echo $this->_var['conf']['store_id']; ?></td>
            <td><?php echo sub_str($this->_var['conf']['coupon_name'],10); ?></td>
             <td><?php echo $this->_var['conf']['coupon_value']; ?></td>
			  <td><?php echo $this->_var['conf']['use_times']; ?></td>
            <td><?php echo $this->_var['conf']['start_time']; ?></td>
            <td><?php echo $this->_var['conf']['end_time']; ?></td>
             <td><?php echo $this->_var['conf']['min_amount']; ?></td>
			   <td><?php echo $this->_var['conf']['if_issue']; ?></td>
            <td><?php echo sub_str($this->_var['conf']['stores_allow'],10); ?></td>
            <td><?php echo sub_str($this->_var['conf']['cate_noallow'],10); ?></td>
             <td><?php echo $this->_var['conf']['remark']; ?></td>
            <td><a href="index.php?app=couponadmin&amp;act=edit&amp;id=<?php echo $this->_var['conf']['coupon_id']; ?>">编辑</a>|
                
                <a href="index.php?app=couponadmin&amp;act=drop&amp;id=<?php echo $this->_var['conf']['coupon_id']; ?>');">删除</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
  
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>

    </div>
    <div class="clear"></div>
  
</div>
<?php echo $this->fetch('footer.html'); ?>
