<div class="pxui-pages">
	
    <?php if ($this->_var['page_info']['prev_link']): ?>
     <a href="<?php echo $this->_var['page_info']['prev_link']; ?>"><i class="arrow-left"></i>&nbsp;&nbsp;上一页</a>
    <!--<a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"><span><i class="arrow-left"></i>&nbsp;&nbsp;上一页</span></a>-->
    <?php else: ?>
    <span><i class="arrow-left"></i>&nbsp;&nbsp;上一页</span>
    <!--<span class="former_no"><span><i class="arrow-left"></i>&nbsp;&nbsp;上一页</span></span>-->
    <?php endif; ?>
    <b class="total"><?php echo $this->_var['page_info']['curr_page']; ?>/<?php echo $this->_var['page_info']['page_count']; ?></b>
    <?php if ($this->_var['page_info']['next_link']): ?>
    <a href="<?php echo $this->_var['page_info']['next_link']; ?>">下一页&nbsp;&nbsp;<i class="arrow-right"></i></a>
   <!-- <a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>"><span>下一页&nbsp;&nbsp;<i class="arrow-right"></i></span></a>-->
    <?php else: ?>
    <span>下一页&nbsp;&nbsp;<i class="arrow-right"></i></span>
    <!--<span class="down_no"><span>下一页&nbsp;&nbsp;<i class="arrow-right"></i></span></span>-->
    <?php endif; ?>
</div>
