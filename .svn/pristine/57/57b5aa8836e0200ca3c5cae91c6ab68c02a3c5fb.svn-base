<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
	function addTime(obj){
		$.get('index.php',{app:'discount',act:'ajax_col',schedule_id:obj.value},
			function(data){
				$("#start_time_id").val(data.start_time);
				$("#end_time_id").val(data.end_time);
			},'json');
			//alert(obj.value);
		
	}
	
	
</script>

<div id="rightTop">
    <p>商品详情管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=wxgoods">管理</a></li>
		 
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
                   <input type="text"  class="Wdate" readonly="readonly" style="width:255px" name="goods_sn" value="<?php echo $this->_var['good']['sku']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
			
			<tr>
                <th class="paddingT15">
                    商品名称:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" readonly=readonly"" style="width:255px" name="goods_name" value="<?php echo $this->_var['good']['goods_name']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
			
			<tr>
                <th class="paddingT15">
                    商品店铺:</th>
                <td class="paddingT15 wordSpacing5">
                   <input type="text"  class="Wdate" style="width:255px" readonly="readonly" name="store_id" value="<?php echo $this->_var['good']['store_id']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>   
			
            <tr>
                <th class="paddingT15">
                    微信标题:</th>
                <td class="paddingT15 wordSpacing5">
					<input type="text"  class="Wdate" style="width:255px" name="wxtitle" value="<?php echo $this->_var['good']['wxtitle']; ?>" />
                	<span class="grey"></span>
                </td>
            </tr>
               
			  <tr>
                <th class="paddingT15">
                    微信详情:</th>
                <td class="paddingT15 wordSpacing5">
					<textarea name="wxdesc"><?php echo $this->_var['good']['wxdesc']; ?></textarea>
                	<span class="grey"></span>
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
