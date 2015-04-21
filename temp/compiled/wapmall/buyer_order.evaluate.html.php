<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>确认收货</title>
<meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" />
        
        <meta content="yes" name="apple-mobile-web-app-capable" />
        
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        
        <meta content="telephone=no" name="format-detection" />
<link href="/themes/bqmart/style/zq_comment.css" type="text/css" rel="stylesheet">
<script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>" type="text/javascript"></script>
<script src="<?php echo $this->res_base . "/" . 'bqmart/js/zq_comment.js'; ?>" type="text/javascript"></script>
</head>
	
<body>
	<div class="zq_comment" style="height: 640px;
  background: #F0F0F0">
    	
    	<div class="zq_header" style="background-color: #fff;color: #000;">
        	<a href="/index.php?app=buyer_order&act=index&type=all" class="zq_back"></a>
            <span>确认收货</span>
        </div>
			<form method="post">
			<?php if ($this->_var['pensongs']): ?>
			 
        <div class="zq_peisong">          	
             
				
                <div  id="star" class="star" style="margin: 10px 0% 1px 10px;height:20px;  background-color: #fff;">
                    <span>服务态度评价:</span>
                    <ul>
                        <li class="on"><a href="javascript:;">1</a></li>
                        <li class="on"><a href="javascript:;">2</a></li>
                        <li id="star_3" class="on"><a href="javascript:;">3</a></li>
                        <li><a href="javascript:;">4</a></li>
                        <li><a href="javascript:;">5</a></li>
                   </ul>
                   <span></span>
                   <p><input type='hidden' name='pen_service' value='3'></input></p>    
               </div>
			   <!--
               <div  id="star2"class="star">
                    <span>送货速度评价:</span>
                    <ul>
                        <li><a href="javascript:;">1</a></li>
                        <li><a href="javascript:;">2</a></li>
                        <li><a href="javascript:;">3</a></li>
                        <li><a href="javascript:;">4</a></li>
                        <li><a href="javascript:;">5</a></li>
                   </ul>
                   <span></span>
                   <p></p>     
               </div>-->
               <textarea name="pen_remark" id="clear" rows="4" style="border:thin solid #999; margin-top:10px; margin-left:10px; margin-bottom:10px;font-size:12px; color:#999;margin-right:10px;overflow-y:auto"></textarea>
		</div>
		<?php endif; ?>
        
        <div class="zq_shop" style="display:none;">
        	<div class="zq_sp"><span style="font-size:18px; color:red;"><i>点我</i></span>&nbsp;&nbsp;&nbsp;对购买的商品评价</div>
            <div class="zq_list"  style=" margin-bottom:10px;">
            	<ul>
					<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                	<li style="position:relative; border-bottom:dotted thin #CCC; margin-bottom:10px;">
                    	
                    	<div style="width:80px; height:80px;; margin-left:10px;">
                        	<img src="<?php echo $this->_var['goods']['goods_image']; ?>" width="80px" height="76px;">
                        </div>
                        <div style="width:70%; position:absolute; left:92px;top:1px; line-height:25px;">
                            <span style="color:#666; font-size:12px;">&nbsp;&nbsp;<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span><br/>
                            <span>&nbsp;&nbsp;价格：<span style="color:#F00; font-weight:600;"><?php echo price_format($this->_var['goods']['price']); ?></span><br/>
                           	<span>&nbsp;&nbsp;数量：<span><?php echo $this->_var['goods']['quantity']; ?>件</span></span></span>
                        </div>
                        
                        <div style="width:100%; position:relative; margin:4px auto">
                        	<span class="zq_evaluate" style="margin-left:2%;">
                                <input class="radio" type="radio" name="evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][evaluation]" checked="checked" value="3">
                                <img src="/themes/bqmart/images/good.png" style="position:relative; top:6px;">
                                <span style="font-size:12px;">好评</span>
                            </span>
                            <span class="zq_evaluate">
                                <input class="radio" type="radio" name="evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][evaluation]" value="2">
                                <img src="/themes/bqmart/images/zhong.png" style="position:relative; top:6px;">
                                <span style="font-size:12px;">中评</span>
                            </span>
                            <span class="zq_evaluate">
                                <input class="radio" type="radio" name="evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][evaluation]" value="1">
                                <img src="/themes/bqmart/images/bad.png" style="position:relative; top:6px;">
                                <span style="font-size:12px;">差评</span>
                            </span><br/>
                     		<textarea class="text" name="evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][comment]" rows="4" style="border:thin solid #999; margin-left:2%; margin-top:15px; font-size:12px; color:#999; width:96%;">商品很不错哟</textarea>
                        </div>                                         	
                    </li>
                   	 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                </ul>
            </div>
        </div>
		<input type="hidden" name="pen_id" value="<?php echo $this->_var['pensongs']['user_id']; ?>">
		 <input type="submit" class="zq_header" style="border-bottom:2px solid #FB8C08;background-color: #FB8C08;" value="确认收货">
		</form>
     
                       
      
    </div>
	<script>
	$(document).ready(function(){
	 
	$("textarea").width($(window).width()-20);
	
	
	
	});
	</script>
	
</body>
</html>
