<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>配置项管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=conf">管理</a></li>
       
        <li><a class="btn1" href="index.php?app=conf&amp;act=add">新增</a></li>
     
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   配置项编码:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="conf_code" type="text" name="conf_code" value="<?php echo htmlspecialchars($this->_var['conf']['conf_code']); ?>" />
                </td>
            </tr>
          
            <tr>
                <th class="paddingT15">
                    配置项名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="conf_name" type="text" name="conf_name" value="<?php echo $this->_var['conf']['conf_name']; ?>" />
                </td>
            </tr>
           
            <tr>
                <th class="paddingT15">
                    <label for="article">配置内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="conf_value" name="conf_value" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['conf']['conf_value']); ?></textarea>
                </td>
            </tr>
              <tr>
                <th class="paddingT15">
                    <label for="article">备注:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="remark" name="remark" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['conf']['remark']); ?></textarea>
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
        <input type="hidden" value="<?php echo $this->_var['conf']['conf_id']; ?>" name="conf_id"/>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
