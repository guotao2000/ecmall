<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>配置项管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=conf&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get" >
            <div class="left">
                <input type="hidden" name="app" value="conf" />
                <input type="hidden" name="act" value="index" />
                配置编码:
                <input class="queryInput" type="text" name="t_conf_code" value="" />
                 配置名称:
                <input class="queryInput" type="text" name="t_conf_name" value="" />
                配置内容:
                 <input class="queryInput" type="text" name="t_conf_value" value="" />
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
            <td align="left">配置编码</td>
            <td>配置名称</td>
            <td align="left">配置内容</td>
            <td>备注</td>
           <td>操作</td>
        </tr>
      
        <?php $_from = $this->_var['confs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'conf');if (count($_from)):
    foreach ($_from AS $this->_var['conf']):
?>
        <tr class="tatr2">
            <td><?php echo $this->_var['conf']['conf_code']; ?></td>
            <td><?php echo $this->_var['conf']['conf_name']; ?></td>
            <td><?php echo sub_str($this->_var['conf']['conf_value'],10); ?></td>
             <td><?php echo $this->_var['conf']['remark']; ?></td>
            <td><a href="index.php?app=conf&amp;act=edit&amp;id=<?php echo $this->_var['conf']['conf_id']; ?>">编辑</a>|
                
                <a href="index.php?app=conf&amp;act=drop&amp;id=<?php echo $this->_var['conf']['conf_id']; ?>');">删除</a></td>
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
