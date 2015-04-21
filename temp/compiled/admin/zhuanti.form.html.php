<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
   
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>配置项管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=zhuanti">管理</a></li>
       
        <li><a class="btn1" href="index.php?app=zhuanti&amp;act=add">新增</a></li>
     
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   专题编码:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="zt_code" type="text" name="zt_code" value="<?php echo htmlspecialchars($this->_var['zhuanti']['zt_code']); ?>" />
                </td>
            </tr>
          
            <tr>
                <th class="paddingT15">
                    专题名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="zt_name" type="text" name="zt_name" value="<?php echo $this->_var['zhuanti']['zt_name']; ?>" />
                </td>
            </tr>
           
            <tr>
                <th class="paddingT15">
                    <label for="article">专题内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="zt_content" name="zt_content" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['zhuanti']['zt_content']); ?></textarea>
                </td>
            </tr>
              <tr>
                <th class="paddingT15">
                    <label for="article">创建时间:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_createtime" name="zt_createtime"  readonly="readonly" class="Wdate" style="width:255px" value="<?php echo $this->_var['zhuanti']['createtime']; ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">创建人:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_createuser" name="zt_createuser" readonly="readonly"  style="width:255px" value="<?php echo htmlspecialchars($this->_var['zhuanti']['zt_createuser']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">编辑人:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_edituser" name="zt_edituser"  readonly="readonly"  style="width:255px" value="<?php echo htmlspecialchars($this->_var['zhuanti']['zt_edituser']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">编辑时间:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_edittime" name="zt_edittime"  readonly="readonly" class="Wdate" style="width:255px" value="<?php echo $this->_var['zhuanti']['edittime']; ?>" />
                </td>
            </tr>
              <tr>
                <th class="paddingT15">
                    <label for="article">生成状态:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_state" name="zt_state"  readonly="readonly"  style="width:255px" value="<?php echo htmlspecialchars($this->_var['zhuanti']['zt_state']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">生成时间:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" id="zt_sctime" name="zt_sctime"  readonly="readonly" class="Wdate" style="width:255px" value="<?php echo $this->_var['zhuanti']['sctime']; ?>" />
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
        <input type="hidden" value="<?php echo $this->_var['zhuanti']['zt_id']; ?>" name="zt_id"/>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
