<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
   
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>区块管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=area">管理</a></li>
       
        <li><a class="btn1" href="index.php?app=area&amp;act=add">新增</a></li>
     
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   区块编码:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="qk_code" type="text" name="qk_code" value="<?php echo htmlspecialchars($this->_var['area']['qk_code']); ?>" />
                </td>
            </tr>
          
            <tr>
                <th class="paddingT15">
                    区块名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="qk_name" type="text" name="qk_name" value="<?php echo $this->_var['area']['qk_name']; ?>" />
                </td>
            </tr>
           
            <tr>
                <th class="paddingT15">
                    <label for="article">是否读取数据库:</label></th>
                <td class="paddingT15 wordSpacing5">
                  <?php echo $this->html_radios(array('name'=>'qk_yes','options'=>$this->_var['qk_yeses'],'checked'=>$this->_var['area']['qk_yes'])); ?>
                 </td>
            </tr>
              <tr>
                <th class="paddingT15">
                    <label for="article">区块SQL:</label></th>
                <td class="paddingT15 wordSpacing5">
                 <textarea id="qk_sql" name="qk_sql" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['area']['qk_sql']); ?></textarea>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">区块头:</label></th>
                <td class="paddingT15 wordSpacing5">
                  <textarea id="qk_xhtop" name="qk_xhtop" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['area']['qk_xhtop']); ?></textarea>
                 </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">区块体:</label></th>
                <td class="paddingT15 wordSpacing5">
                 <textarea id="qk_xhbody" name="qk_xhbody" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['area']['qk_xhbody']); ?></textarea>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">区块底部:</label></th>
                <td class="paddingT15 wordSpacing5">
                  <textarea id="qk_xhbottom" name="qk_xhbottom" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['area']['qk_xhbottom']); ?></textarea>
               </td>
            </tr>
       <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="Submit2" value="重置" />
            </td>
        </tr>
        </table>
        <input type="hidden" value="<?php echo $this->_var['area']['qk_id']; ?>" name="qk_id"/>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
