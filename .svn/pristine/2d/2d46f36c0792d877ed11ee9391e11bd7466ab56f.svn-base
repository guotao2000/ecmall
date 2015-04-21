<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#article_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        rules : {    
            title :{
                required : true
            },
			description :{
                required : true
            },
			diy_url :{
                url : true
            }
        },
        messages : {
            title: {
                required : '标题不能为空'
            },
			description :{
                required : '描述不能为空'
            },
			diy_url :{
                url : '链接不正确'
            }
        }
    });
});

function add_uploadedfile(file_data)
{
    var newImg = '<tr id="' + file_data.file_id + '" class="tatr2"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><td><img width="40px" height="40px" src="' + SITE_URL + '/' + file_data.file_path + '" /></td><td>' + file_data.file_name + '</td><td><a href="javascript:insert_editor(\'' + file_data.file_name + '\', \'' + file_data.file_path + '\');">插入编辑器</a> | <a href="javascript:drop_uploadedfile(' + file_data.file_id + ');">删除</a></td></tr>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_name, file_path){
    tinyMCE.execCommand('mceInsertContent', false, '<img src="'+ SITE_URL +'/' + file_path + '" alt="'+ file_name + '">');
}
function drop_uploadedfile(file_id)
{
    if(!window.confirm(lang.uploadedfile_drop_confirm)){
        return;
    }
    $.getJSON('index.php?app=weixin_message&act=drop_uploadedfile&file_id=' + file_id, function(result){
        if(result.done){
            $('#' + file_id).remove();
        }else{
            alert('drop_error');
        }
    });
}
</script>
<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['build_upload']; ?>
<div id="rightTop">
  <p>微信公众平台管理（支持添加多个公众号）</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=weixin_config">添加公众号</a></li>
    <li><a class="btn1" href="index.php?app=weixin_config&amp;act=wx_list">公众号列表</a></li>
  </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="article_form">
        <table class="infoTable">
			<tr>
				<th class="paddingT15"><label for="is_subscribe"> 自动回复类型:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <input type="radio" name="is_subscribe" value="0" <?php if ($this->_var['wxtw']['is_subscribe'] == 0): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />关注时自动回复
				  <input type="radio" name="is_subscribe" value="1" <?php if ($this->_var['wxtw']['is_subscribe'] == 1): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />普通自动回复
				  <span class="grey"></span>
				</td>
			</tr>
			  <!-- <tr>
				<th class="paddingT15"><label for="tw_type"> 图文类型:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <input type="radio" name="tw_type" value="0" <?php if ($this->_var['wxtw']['tw_type'] == 0): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />单图文
				  <input type="radio" name="tw_type" value="1" <?php if ($this->_var['wxtw']['tw_type'] == 1): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />多图文
				  <span class="grey"></span>
				</td>
			  </tr> -->
			  <tr>
				<th class="paddingT15"><label for="is_pub"> 显示:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <input type="radio" name="is_pub" value="1" <?php if ($this->_var['wxtw']['is_pub'] == 1): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />是
				  <input type="radio" name="is_pub" value="0" <?php if ($this->_var['wxtw']['is_pub'] == 0): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />否
				  <span class="grey"></span>
				</td>
			  </tr>
			  <!-- <tr>
				<th class="paddingT15"><label for="is_default"> 设为默认:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <input type="radio" name="is_default" value="1" <?php if ($this->_var['wxtw']['is_default'] == 1): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />是
				  <input type="radio" name="is_default" value="0" <?php if ($this->_var['wxtw']['is_default'] == 0): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />否
				  <span class="grey"></span>
				</td>
			  </tr> -->
			  <tr>
                <th class="paddingT15">
                    指定二维码参数值:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="allow_uin" type="text" name="allow_uin" value="<?php echo htmlspecialchars($this->_var['wxtw']['allow_uin']); ?>" style="width:600px;" />
					<span class="grey">（选填，多个参数值之间用英文半角逗号“,”隔开，留空则不限制表示全部发送）</span>
                </td>
            </tr>
            <tr>
				<th class="paddingT15"><label for="picurl"> 上传封面图片:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <p><input type="file" id="picurl" name="picurl" />
				  <span class="grey">（必填，上传图片类型必须是：.jpg,.gif,.png,.jpeg，图片大小不能大于2M）</span></p>
				  <p><input type="hidden" name="picurl_hide" value="<?php echo htmlspecialchars($this->_var['wxtw']['picurl']); ?>" /></p>
				</td>
			</tr>
			<tr>
                <th class="paddingT15">
                    标题:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="title" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['wxtw']['title']); ?>" style="width:600px;" />
					<span class="grey">（必填）</span>
                </td>
            </tr>
			<tr>
				<th class="paddingT15"><label for="keywords"> 关键词:</label></th>
				<td class="paddingT15 wordSpacing5">
				  <input id="keywords" style="width:600px;" type="text" name="keywords" class="infoTableInput" value="<?php echo htmlspecialchars($this->_var['wxtw']['keywords']); ?>"/>
				  <span class="grey">（选填，多个关键词之间使用英文半角逗号隔开“,”）</span>
				</td>
			</tr>
            <tr>
                <th class="paddingT15">
                    <label for="description">描述:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="description" name="description" style="width:600px;height:70px;"><?php echo htmlspecialchars($this->_var['wxtw']['description']); ?></textarea>
					<span class="grey">（必填）</span>
                </td>
            </tr>
			<tr>
                <th class="paddingT15">
                    <label for="content">内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea id="content" name="content" style="width:650px;height:400px;"><?php echo htmlspecialchars($this->_var['wxtw']['content']); ?></textarea>
					<span class="grey">（必填）</span>
                </td>
            </tr>
            <tr>
            <th>图片上传:</th>
            <td height="100" valign="top">
            <div id="divUploadTypeContainer">
                <input name="upload_types" id="bat_upload" type="radio" value="bat_upload" checked="checked" /> <label for="bat_upload">批量上传</label>
                <input name="upload_types" id="com_upload" type="radio" value="com_upload" /> <label for="com_upload">普通上传</label>
            </div>
            <div id="divSwfuploadContainer">
                <div id="divButtonContainer">
                    <span id="spanButtonPlaceholder"></span>
                </div>
                <div id="divFileProgressContainer"></div>
            </div>
            <iframe id="divComUploadContainer" style="display:none;" src="index.php?app=comupload&act=view_iframe&id=<?php echo $this->_var['id']; ?>&belong=<?php echo $this->_var['belong']; ?>" width="500" height="46" scrolling="no" frameborder="0">
            </iframe>
            </td>
            </tr>
            <tr>
            <th>已传图片:</th>
            <td>                
            <div class="tdare">
    <table  width="600px" cellspacing="0" class="dataTable">
        <tbody id="thumbnails">
        <?php $_from = $this->_var['files_belong_wxtw']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
    foreach ($_from AS $this->_var['file']):
?>
        <tr class="tatr2" id="<?php echo $this->_var['file']['file_id']; ?>">
        <input type="hidden" name="file_id[]" value="<?php echo $this->_var['file']['file_id']; ?>" />
        <td><img alt="<?php echo $this->_var['file']['file_name']; ?>" src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['file']['file_path']; ?>" width="40px" height="40px" /></td>
        <td><?php echo $this->_var['file']['file_name']; ?></td>
        <td><a href="javascript:insert_editor('<?php echo $this->_var['file']['file_name']; ?>', '<?php echo $this->_var['file']['file_path']; ?>');">插入编辑</a> | <a href="javascript:drop_uploadedfile(<?php echo $this->_var['file']['file_id']; ?>);">删除</a></td>
        </tr>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </tbody>
    </table>
</div>
            </td>
            </tr>
        
        <tr>
                <th class="paddingT15">
                    自定义链接:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="diy_url" type="text" name="diy_url" value="<?php echo htmlspecialchars($this->_var['wxtw']['url']); ?>" style="width:600px;" />
					<span class="grey">（必填）</span>
                </td>
       </tr>    
        
        <tr>
            <th></th>
            <td class="ptb20">
				<input type="hidden" name="wx_id" value="<?php echo $this->_var['wx_id']; ?>" />
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="Submit2" value="重置" />
            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
