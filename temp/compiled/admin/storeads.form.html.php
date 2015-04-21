<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
   
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>店铺广告位管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=storeads">管理</a></li>
       
        <li><a class="btn1" href="index.php?app=storeads&amp;act=add">新增</a></li>
     
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                   店铺编号:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="store_id" type="text" name="store_id" value="<?php echo htmlspecialchars($this->_var['conf']['store_id']); ?>" />
                </td>
            </tr>
          
            <tr>
                <th class="paddingT15">
                    店铺名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="store_name" type="text" name="store_name" value="<?php echo $this->_var['conf']['store_name']; ?>" />
                </td>
            </tr>
              <tr>
                <th class="paddingT15">
                    <label for="article">左侧特色服务内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="menu_value" name="menu_value" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['conf']['menu_value']); ?></textarea>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="article">右侧广告位内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="ad_value" name="ad_value" style="width:650px;height:100px;"><?php echo htmlspecialchars($this->_var['conf']['ad_value']); ?></textarea>
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
       
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
