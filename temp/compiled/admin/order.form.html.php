<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>订单管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=order">管理</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="user_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 甩到店铺号:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="seller_id" type="text" />
            <label class="field_notice"></label>        
		</td>
      </tr>
      <tr>
        <th class="paddingT15"> 甩到店铺名称:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="seller_name" type="text" />        
		</td>
      </tr>
    
      <tr>
	  <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />        </td>
      </tr>
	   <input type="hidden" name="order_id" value="<?php echo $this->_var['order_id']; ?>" /> 
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>