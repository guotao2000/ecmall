<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>区块管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=area&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get" >
            <div class="left">
                <input type="hidden" name="app" value="area" />
                <input type="hidden" name="act" value="index" />
                区块编码:
                <input class="queryInput" type="text" name="t_qk_code" value="" />
                区块名称:
                <input class="queryInput" type="text" name="t_qk_name" value="" />
              
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
            <td align="left">区块编码</td>
            <td>区块名称</td>
            <td>是否读取数据库</td>
            <td>sql语句</td>
               <td>添加时间</td>
           <td>操作</td>
        </tr>
      
        <?php $_from = $this->_var['areas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'area');if (count($_from)):
    foreach ($_from AS $this->_var['area']):
?>
        <tr class="tatr2">
            <td><?php echo $this->_var['area']['qk_code']; ?></td>
            <td><?php echo $this->_var['area']['qk_name']; ?></td>
            <td><?php if ($this->_var['area']['qk_yes'] == "1"): ?>是<?php else: ?>否<?php endif; ?></td>
            <td><?php echo sub_str($this->_var['area']['qk_sql'],30); ?></td>
             <td><?php echo $this->_var['area']['qk_time1']; ?></td>
            <td><a href="index.php?app=area&amp;act=edit&amp;id=<?php echo $this->_var['area']['qk_id']; ?>">编辑</a>|
                
                <a href="index.php?app=area&amp;act=drop&amp;id=<?php echo $this->_var['area']['qk_id']; ?>');">删除</a></td>
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
