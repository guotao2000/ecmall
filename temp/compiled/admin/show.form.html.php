<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
</script>

<div id="rightTop">
    <p>商品名称管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=show">管理</a></li>
		 
		<!--<li><a class="btn1" href="index.php?app=discount&amp;act=list_zhuhe">组合列表</a></li>-->
            
       
    </ul>
</div>

<div class="info">
    <form method="post" id="file_form" autocomplete="off">
        <table class="infoTable">
			<tr>
                <th class="paddingT15">
                    商品编号:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="hidden"  class="Wdate" style="width:255px" name="goods_sn" value="<?php echo $this->_var['good']['sku']; ?>" />
				   <input type="text"  class="Wdate" style="width:255px" name="new_sn" value="<?php echo $this->_var['good']['sku']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
			
			<tr>
                <th class="paddingT15">
                    商品名称:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="goods_name" value="<?php echo $this->_var['good']['goods_name']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
			
            <tr>
                <th class="paddingT15">
                    商品库存:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="text"  class="Wdate" style="width:255px" name="stock" value="<?php echo $this->_var['good']['stock']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>
			
			 <tr>
                <th class="paddingT15">
                    商品标签:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="text"  class="Wdate" style="width:255px" name="tags" value="<?php echo $this->_var['good']['tags']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>
               
			  <tr>
                <th class="paddingT15">
                    商品上下架:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="radio" <?php if ($this->_var['good']['if_show'] == 1): ?> checked="checked" <?php endif; ?> name="if_show" value="1" />上架
					<input type="radio" <?php if ($this->_var['good']['if_show'] == 0): ?> checked="checked" <?php endif; ?> name="if_show" value="0" />下架
                	<span class="grey"></span>
                </td>
            </tr> 
			<tr>
                <th class="paddingT15">
                    执行店铺:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="store_id" value="<?php echo $this->_var['good']['store_id']; ?>" />
                	<span class="grey">可以多个店铺修改，以英文逗号分隔</span>
                </td>
            </tr>   
			  
			      
			
			<!--<tr>
                <th class="paddingT15">
                    满足条件:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" name="condition" />
                	<span class="grey"></span>
                </td>
            </tr>    -->     
	        <tr>
	            <th></th>
	            <td class="ptb20">
	                <input class="formbtn" type="submit" name="Submit" value="提交" />
	                <input class="formbtn" type="reset" name="Submit2" value="重置" />
	            </td>
	        </tr>
        </table>
		<input type="hidden" name="id" value="<?php echo $this->_var['good']['goods_id']; ?>">
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
