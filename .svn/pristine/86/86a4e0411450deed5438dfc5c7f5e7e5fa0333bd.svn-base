<?php echo $this->fetch('member.header.html'); ?>
<script language = "JavaScript">
function chongzhi()
{
  if (document.chongzhi_form.cz_money.value=="")
  {
    alert("填写要充值的金额");
	document.chongzhi_form.cz_money.focus();
	return false;
  }

  return true;  
}


function card()
{
  if (document.card_form.user_name1.value =="")
  {
    alert("充值帐户不能为空!");
	document.card_form.user_name1.focus();
	return false;
  }
  if (document.card_form.user_name2.value =="")
  {
    alert("确认帐户不能为空!");
	document.card_form.user_name2.focus();
	return false;
  }
  if (document.card_form.user_name1.value != document.card_form.user_name2.value)
  {
    alert("两次输入充值帐户不同!");
	document.card_form.user_name2.focus();
	return false;
  }
  if (document.card_form.card_sn.value =="")
  {
    alert("充值卡卡号不能为空!");
	document.card_form.card_sn.focus();
	return false;
  }
  if (document.card_form.card_pass.value =="")
  {
    alert("充值卡密码不能为空!");
	document.card_form.card_pass.focus();
	return false;
  }
  return true;  
}
</script>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
          <ul class="tab">
				<li class="active">在线充值</li>
				<li class="normal"><a href="index.php?app=my_money&act=paylog">充值记录</a></li>
                <li class="normal"><a href="index.php?app=my_money&act=txlist">提现申请</a></li>
                
          </ul>
          
        <div class="wrap margin1">
            <div class="public table">
				<div class="information_index" style="overflow:hidden; margin: 0px 0 -15px;">
                <div class="info">
                        <h3 class="margin2">
                            <span>您好！<?php echo $this->_var['visitor']['user_name']; ?>，欢迎来到资金管理中心</span>
                           <!-- <a href="index.php?app=my_money&act=index" target="_blank">什么是商付通？</a>-->
                        </h3>
                      <table class="width6">
                      <tr>
					  <td><span style="font-size:14px">
					  <?php $_from = $this->_var['my_money']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
帐户总金额：<span style="font-size:16px;font-weight:bold; color:#FE5400;"><?php echo $this->_var['val']['money']; ?></span>
&nbsp;元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;冻结金额：<span style="color:blue;"><?php echo $this->_var['val']['money_dj']; ?></span>&nbsp;元
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积分：<span style="color:blue;"><?php echo $this->_var['val']['jifen']; ?></span></span>
					  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					  </td>
                      </tr>
                      <tr>
                      <td>上次登陆IP: <?php echo $this->_var['visitor']['last_ip']; ?><br>
                                    上次登陆时间:<?php echo local_date("Y-m-d H:i:s",$this->_var['visitor']['last_login']); ?><br> 
                                    
                                    <A 
href="index.php?app=my_money&act=mibao"><span style="color:red;">绑定动态密码</span></A>&nbsp;|&nbsp;<A 
href="index.php?app=my_money&act=paylist">立即充值</A>&nbsp;|&nbsp;<A 
class=G href="index.php?app=my_money&act=txlist"><span style="color:green;">提现</span></A>  
					  </td> 

                      </tr>
                      </table>
                  </div>
				
				
                </div>
             </div>
        </div>


           <div class="wrap margin1">
            <div class="public table">
            <h3 class="title" style="margin: -10px 0 20px; color:#3E3E3E">在线充值</h3>
                  <div style="color:#646665;float:left;font-size:12px;font-weight:normal;line-height:30px;">
<form name="chongzhi_form" onSubmit="return chongzhi();" action="index.php?app=my_money&act=czfs" method="post" target="_blank">
				  充值金额：
                  <input name="cz_money" type="text" value="100" size="8" />&nbsp;元
                    充值方式：
                    <select name="czfs" class="select">
                    <option value="tenpay">财付通充值</option>
                    <option value="alipay">支付宝充值</option>
                    <option value="chinabank">网银在线充值</option>                    
					</select>
                  <BR>注：目前支持支付宝、财付通、各大银行网银、银联充值。您也可以<a href="index.php?app=article&act=view&article_id=31" target="_blank">[线下汇款]</a>。<BR><input type="submit" class="money_btn" value="立即充值" />
                  </form>
             </div>
			</div>
           </div>		
	

           <div class="wrap">
            <div class="public table">
            <h3 class="title" style="margin: -10px 0 20px; color:#3E3E3E">充值卡充值</h3>
                  <div style="color:#646665;float:left;font-size:12px;font-weight:normal;line-height:30px;">
<form name="card_form" onSubmit="return card();" action="index.php?app=my_money&act=card_cz" method="post" target="_blank">
				  充值帐户：<input name="user_name1" type="text" id="user_name1" value="<?php echo $this->_var['visitor']['user_name']; ?>" size="15" />
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  商付卡卡号：<input name="card_sn" type="text" id="card_sn" size="30" />
				  <br>
				  确认帐户：<input name="user_name2" type="text" id="user_name2" size="15" />
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  商付卡密码：<input name="card_pass" type="text" id="card_pass" size="30" />
				  <br>注：如果您通过线下汇款或活动赚金，请联系管理员索取。(QQ:<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1939828248&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:1939828248:41 &r=0.4908261565915385" alt="为您服务" title="为您服务"></a> 热线:540616918)<br>
                  <input type="submit" class="money_btn" value="立即充值" />
                  </form>
             </div>
			</div>
           </div>		
		

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<iframe id='iframe_post' name="iframe_post" frameborder="0" width="0" height="0">
</iframe>
<?php echo $this->fetch('footer.html'); ?>
