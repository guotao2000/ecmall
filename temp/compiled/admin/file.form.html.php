<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function add(){
		var content = "<tr><td>上传文件:</td><td>"; 
		content += "<input type='file' name='file[]'><span style='cursor:pointer;' onclick='remove(this)'>&nbsp;&nbsp;-</span>"; 
		content += "</td></tr>";
		$("#up").append(content); 
	}
	
	function remove(obj) { 
		$(obj).parent().parent().remove(); 
	} 
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
    <p>文件管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=file">管理</a></li>
        <?php if ($this->_var['article']['article_id']): ?>
        <li><a class="btn1" href="index.php?app=file&amp;act=add">新增</a></li>
        <?php else: ?>
        <li><span>新增</span></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="file_form">
        <table class="infoTable">
         <?php if (! $this->_var['file']): ?>   
        <tr class="tatr1" id="up" >
            <td align="left">上传文件:</td>
            <td align="left"><input  name="file[]" type="file" /><span onclick="add()" style="cursor:pointer;">&nbsp;&nbsp;+</span></td></tr>
        <tr>
			<td align="left"><input type="submit" class="formbtn" value="确定上传" /></td>
		</tr>
        </table>
		<?php else: ?>
		 <table class="infoTable">
         <input name="id" type="hidden" value="<?php echo $this->_var['file']['id']; ?>" />
		<input type="hidden" name="oldname" value="<?php echo $this->_var['file']['filename']; ?>" />
        <tr class="tatr1" id="up" >
            <td align="left">上传文件:</td>
            <td align="left"><input  name="filename" type="text" value="<?php echo $this->_var['file']['filename']; ?>" /></td></tr>
        <tr>
			
			<td align="left"><input type="submit" class="formbtn" value="确定修改" /></td>
		</tr>
		
        </table>
		<?php endif; ?>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
