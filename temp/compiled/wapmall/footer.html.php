<div class="footer" style="max-width: 640px;">
            <div class="f_show">
                <div class="f_gwc">
                    <img src="/themes/bqmart/images/gwc2.png" width="30px">
                </div>
                <i id="end"></i>
                <div id="f_num"><?php echo $this->_var['cart']['quantity']; ?></div>
            </div>
            <div class="f_t1">
                <p>共<span id="amount"><?php echo $this->_var['cart']['amount']; ?></span>元 </p>
                <p>满￥<?php echo $this->_var['cart']['shipping']; ?>，免运费</p>
            </div>
            <div  class="f_t2">
                <div class="money_no">差<span id="peisong"><?php echo $this->_var['cart']['quantity']; ?></span>件起送</div>
                <div class="money_yes">结算</div>
            </div>
            <div class="f_bg"></div>
        
    </div>
		
		<div id="details"  style="overflow: hidden; display:none;position:absolute;
	z-index:1000;">
    	
    	<div class="detail_bg"></div>
       <div class="d_all">
       			
                
                <div class="d_info">
                    
                    <div class="d_pic">
                   	  
               	    	<span class="action"><img src="/themes/bqmart/images/action.png" alt="分享"> </span>			
                        <div class="detail_pic">                       
                        </div>
                        <span>确定</span>                      
                    </div>                  
                    
                    <div class="detail_price" value="">
                    	<p>&nbsp;&nbsp;<span class="detail_name"></span></p>
                        <p class="price">&nbsp;&nbsp;￥<span></span></p>
                        <div class="detail_op">
                        	<span class="op1">-</span>
                            <span class="s_num">0</span>
                            <span class="op2">+</span>
                        </div>
                    </div>	
                </div>
            </div> 
    </div>