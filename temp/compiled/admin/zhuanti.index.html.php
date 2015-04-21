<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>专题管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=zhuanti&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get" >
            <div class="left">
                <input type="hidden" name="app" value="zhuanti" />
                <input type="hidden" name="act" value="index" />
                专题编码:
                <input class="queryInput" type="text" name="t_zt_code" value="" />
                专题名称:
                <input class="queryInput" type="text" name="t_zt_name" value="" />
              
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
            <td align="left">专题编码</td>
            <td>专题名称</td>
            <td>编辑时间</td>
            <td>编辑人</td>
            <td align="left">专题生成状态</td>
            <td>专题生成时间</td>
           <td>操作</td>
        </tr>
      
        <?php $_from = $this->_var['zhuantis']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'zhuanti');if (count($_from)):
    foreach ($_from AS $this->_var['zhuanti']):
?>
        <tr class="tatr2">
            <td><?php echo $this->_var['zhuanti']['zt_code']; ?></td>
            <td><?php echo $this->_var['zhuanti']['zt_name']; ?></td>
            <td><?php echo $this->_var['zhuanti']['edittime']; ?></td>
            <td><?php echo $this->_var['zhuanti']['zt_edituser']; ?></td>
            <td><?php echo $this->_var['zhuanti']['zt_state']; ?></td>
            <td><?php echo $this->_var['zhuanti']['zt_sctime']; ?></td>
            <td><a href="index.php?app=zhuanti&amp;act=edit&amp;id=<?php echo $this->_var['zhuanti']['zt_id']; ?>">编辑</a>|
                
                <a href="index.php?app=zhuanti&amp;act=drop&amp;id=<?php echo $this->_var['zhuanti']['zt_id']; ?>');">删除</a></td>
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
