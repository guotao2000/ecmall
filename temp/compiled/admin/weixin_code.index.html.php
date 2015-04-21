<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
var weixin_id = <?php echo $this->_var['wx_id']; ?>;

$(document).ready(function(){
	//首次加载时执行
	$.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'list_code', wx_id:weixin_id},
			timeout:3000,
			cache:false,
			success:function(data){
				
				$("#codeBox_" + weixin_id).html(data);
				
			},
			error:function(error){
				//$("#user_msg_list").html(error);	
			},
			async: true
		});
});

</script>
<div id="rightTop">
  <p>微信公众平台管理（支持添加多个公众号）</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=weixin_config">添加公众号</a></li>
    <li><a class="btn1" href="index.php?app=weixin_config&amp;act=wx_list">公众号列表</a></li>
  </ul>
</div>
<div class="info">

    <table class="infoTable">
      <tr>
        <th class="paddingT15"><label for="weixin_uin"> 定义生成二维码规则:</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_uin_<?php echo $this->_var['wx_id']; ?>" style="width:100px;" type="text" name="weixin_uin_<?php echo $this->_var['wx_id']; ?>" class="infoTableInput" onblur="checkUin(<?php echo $this->_var['wx_id']; ?>)"/>
          <span class="grey">（必填，请认真填写推荐人数字编号）</span>&nbsp;
		  <span style="color:#ff3300;" id="error_message"></span>
        </td>
      </tr>
	  <tr>
        <th class="paddingT15"><label for="weixin_code_title"> 定义生成二维码标题:</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_code_title_<?php echo $this->_var['wx_id']; ?>" style="width:400px;" type="text" name="weixin_code_title_<?php echo $this->_var['wx_id']; ?>" class="infoTableInput" onblur="checkTitle(<?php echo $this->_var['wx_id']; ?>)"/>
          <span class="grey">（必填）</span>
		  <span style="color:#ff3300;" id="error_messageSec"></span>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="button" id="btnCreateCode" name="button1" value="生成" onclick="createCode(<?php echo $this->_var['wx_id']; ?>)" />
          <input type="hidden" name="wx_id" value="<?php echo $this->_var['wx_id']; ?>" id="wx_id_hidden" />
        </td>
      </tr>
    </table>

</div>

<div style="display:block;" id="codeBox_<?php echo $this->_var['wx_id']; ?>">
	
</div>

<script type="text/javascript">
//<!CDATA[
//检测推荐人编号是否存在，同时检测推荐人编号是否已生成二维码
function checkUin(wid){
	var weiID = wid;
	var weiRule = $('#weixin_uin_' + weiID).val();
	weiRule = $.trim(weiRule);

	//检测开始
	$.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'check_uin', wx_id:weiID, uin:weiRule},
			timeout:3000,
			cache:false,
			success:function(data){

				if(data == 1){
					$("#error_message").html('该推荐编号已经生成二维码或者不存在');
				}else{
					$("#error_message").html('');
				}
				
			},
			error:function(error){
				//$("#user_msg_list").html(error);	
			},
			async: true
		});
}

function checkUinSec(wid){
	var weiID = wid;
	var weiRule = $('#weixin_uin_' + weiID).val();
	weiRule = $.trim(weiRule);

	//检测开始
	vtext = $.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'check_uin', wx_id:weiID, uin:weiRule},
			timeout:3000,
			cache:false,
			async: false
		});
	return vtext.responseText;
}

//检测标题
function checkTitle(wid){
	var weiID = wid;
	var weiRule = $('#weixin_uin_' + weiID).val();
	weiRule = $.trim(weiRule);
	var weiTitle = $('#weixin_code_title_' + weiID).val();
	weiTitle = $.trim(weiTitle);

	//检测开始
	$.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'check_title', wx_id:weiID, uin:weiRule, title:weiTitle},
			timeout:3000,
			cache:false,
			success:function(data){
				if(data == 1){
					$("#error_messageSec").html('标题不能重复');
				}else{
					$("#error_messageSec").html('');
				}
				
			},
			error:function(error){
				//$("#user_msg_list").html(error);	
			},
			async: true
		});
}

function checkTitleSec(wid){
	var weiID = wid;
	var weiRule = $('#weixin_uin_' + weiID).val();
	weiRule = $.trim(weiRule);
	var weiTitle = $('#weixin_code_title_' + weiID).val();
	weiTitle = $.trim(weiTitle);

	//检测开始
	vtext = $.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'check_title', wx_id:weiID, uin:weiRule, title:weiTitle},
			timeout:3000,
			cache:false,
			async: false
		});
	return vtext.responseText;
}
//检测开发者appid和appsecret
function checkAppidAndAppsecret(wid){
	var weiID = wid;
	//检测开始
	vtext = $.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'check_appid', wx_id:weiID},
			timeout:3000,
			cache:false,
			async: false
		});
	return vtext.responseText;
}
//生成二维码
function createCode(wx_id){
	var weiID = wx_id;
	var weiRule = $('#weixin_uin_' + weiID).val();
	weiRule = $.trim(weiRule);
	var weiTitle = $('#weixin_code_title_' + weiID).val();
	weiTitle = $.trim(weiTitle);
	var reg =/^[0-9]*[1-9][0-9]*$/;
	//检测是否填写appid和appsecret，微信接口配置信息
	if(checkAppidAndAppsecret(weiID) == 1){
		alert('您没有填写开发者appid和appsecret，无法使用生成带参数二维码功能！请返回列表编辑该公众号信息并同时确认微信接口配置正确。');
		return;
	}
	if(weiRule.length == 0){
		alert('规则不能为空！');
		$('#weixin_uin_' + weiID).focus();
		return;
	}
	if(weiRule.length > 0){
		if(!reg.test(weiRule)){
			alert('规则必须为数字！');
			return;
		}
	}
	if(weiTitle.length == 0){
		alert('标题不能为空！');
		$('#weixin_code_title_' + weiID).focus();
		return;
	}
	if(checkUinSec(weiID) == 1){
		alert('该推荐编号已经生成二维码或者不存在');
		return;
	}
	if(checkTitleSec(weiID) == 1){
		alert('该标题已经存在');
		return;
	}
		//生成二维码操作
		$.ajax({
			url:'index.php',
			type:'GET',
			dataType:'text',
			data: {app:'weixin_code', act:'create_code', wx_id:weiID, uin:weiRule, title:weiTitle, is_used:1},
			timeout:3000,
			cache:false,
			success:function(data){
				//$("#user_msg_list").html(data);
				//alert(data);
				$("#codeBox_" + weiID).html(data);
			},
			error:function(error){
				//$("#user_msg_list").html(error);	
			},
			async: true
		});
	


	

}


//]]>
</script>




<?php echo $this->fetch('footer.html'); ?>
