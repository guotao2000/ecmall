<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
//<!CDATA[
$(function(){
    $("#form1").submit(function(){
    	var weixin_account = $("#weixin_account").val();
    	weixin_account = $.trim(weixin_account);
    	if(weixin_account.length == 0){
			alert("微信账号不能为空！");
			return false;
		} else {
			return true;
		}
    });
});
//]]>
</script>

<div id="rightTop">
  <p>微信公众平台管理（支持添加多个公众号）</p>
  <ul class="subnav">
    <li><span>添加公众号</span></li>
    <li><a class="btn1" href="index.php?app=weixin_config&amp;act=wx_list">公众号列表</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" id="form1">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"><label for="weixin_account"> 微信公众账号:</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_account" style="width:600px;" type="text" name="weixin_account" class="infoTableInput"/>
          <span class="grey">（必填，请认真填写微信公众号名称）</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="weixin_url"> 接口配置URL:</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_url" style="width:600px; background:#e4e4e4;" readonly type="text" name="weixin_url" class="infoTableInput" value="<?php echo $this->_var['weixin_url']; ?>"/>
          <span class="grey">（系统自动生成，不能修改）</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="weixin_token"> 接口配置Token:</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_token" style="width:600px; background:#e4e4e4;" readonly type="text" name="weixin_token" class="infoTableInput" value="<?php echo $this->_var['weixin_token']; ?>"/>
          <span class="grey">（系统自动生成，不能修改）</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="weixin_appid"> 微信AppId：</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_appid" style="width:600px;" type="text" name="weixin_appid" class="infoTableInput"/>
          <span class="grey">（选填，自定义菜单时用到）</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="weixin_appsecret"> 微信AppSecret：</label></th>
        <td class="paddingT15 wordSpacing5">
          <input id="weixin_appsecret" style="width:600px;" type="text" name="weixin_appsecret" class="infoTableInput"/>
          <span class="grey">（选填，自定义菜单时用到）</span>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Submit2" value="重置" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
