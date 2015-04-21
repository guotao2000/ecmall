<?php echo $this->fetch('member.header.html'); ?>
<style>
.member_no_records {border-top: 0px !important;}
.table td{padding-left: 5px;}
.money_b{color:#ff4f01 !important;}
.groupbuy_deposit{color:#FF4F01 !important; font-weight:normal;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
    <ul class="tab">
      <li class="active">商品列表</li>
      <li class="normal"><a href="<?php echo url('app=seckill&act=add'); ?>">新增秒杀</a></li>
    </ul>
    <div class="wrap">
      <div class="eject_btn_two eject_pos1" title="新增"><b class="ico2" onclick="go('index.php?app=seckill&amp;act=add');">新增秒杀</b></div>
      <div class="public_select table">
        <table>
          <tr class="line_bold">
                                    <th class="width1"><input type="checkbox" id="all" class="checkall"/></th>
                        <th class="align1" colspan="2">
                            <span class="all"><label for="all">全选</label></span>

                            <a href="#" class="delete" ectype="batchbutton" uri="index.php?app=seckill&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a>
                        </th>
            <th colspan="7"> <div class="select_div">
                <form method="get">
                  <?php if ($this->_var['filtered']): ?>
                  <a class="detlink_with_no_bg" style="float:right" href="<?php echo url('app=seckill'); ?>">取消检索</a>
                  <?php endif; ?>
                  <div style="float:right">
                    <input type="text" class="text_normal" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>"/>
                    <select name="state">
                      
                      
                            <?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
                       <option <?php if ($_GET['state'] == 'nosel' || $_GET['state'] == ''): ?> selected="selected" <?php endif; ?> value="nosel">请选择...</option>     
                    
                    </select>
                    <input type="hidden" name="app" value="seckill" />
                    <input type="hidden" name="act" value="index" />
                    <input type="submit" class="btn" value="搜索" />
                  </div>
                </form>
              </div></th>
          </tr>
          <?php if ($this->_var['seckill_list']): ?>
          <tr class="gray">
		  <th width="25">&nbsp;</th>
            <th width="50">&nbsp;</th>
            <th width="160"><span>商品名称</span></th>
            <th width="50"><span>状态</span></th>
            <th width="150"><span>申请时间</span></th>
            <th width="80"><span>开始时间</span></th>
            <th width="80"><span>数量</span></th>
			
            <th width="80"><span>浏览</span></th>
			<th width="80"><span>被推荐</span></th>
            <th width="80">操作</th>
          </tr>
          <?php endif; ?>
          <?php $_from = $this->_var['seckill_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'seckill');$this->_foreach['_group_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_group_f']['total'] > 0):
    foreach ($_from AS $this->_var['seckill']):
        $this->_foreach['_group_f']['iteration']++;
?>
          <tr class="line<?php if (($this->_foreach['_group_f']['iteration'] == $this->_foreach['_group_f']['total'])): ?> last_line<?php endif; ?>">
		  <td width="25" class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['seckill']['sec_id']; ?>"/></td>
            <td width="50" class="align2"><a href="<?php echo url('app=buyer_seckill&act=seckill_goods&id=' . $this->_var['seckill']['goods_id']. '&sid=' . $this->_var['seckill']['sec_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['seckill']['default_image']; ?>" width="50" height="50"  /></a></td>
            <td width="160" align="align2"><p class="ware_text"><span class="color2" ectype="editobj"> <?php echo $this->_var['seckill']['goods_name']; ?> </span></p></td>
            <td width="50" class="align2"><span class="color2"><?php echo $this->_var['seckill']['sec_state']; ?></span></td>
            <td width="150" class="align2"><span class="color2" ectype="editobj"><?php echo local_date("Y-m-d",$this->_var['seckill']['add_time']); ?></span></td>
            <td width="80"><?php echo local_date("Y-m-d",$this->_var['seckill']['start_time']); ?></td>
            <td width="80" class="align2"><span class="color2" ectype="editobj"><?php echo htmlspecialchars($this->_var['seckill']['sec_quantity']); ?> </span></td>
<td width="80" class="align2"><span class="color2" ectype="editobj"><?php echo htmlspecialchars($this->_var['seckill']['views']); ?> </span></td>
            <td width="80" class="align2"><span>
              
              <?php if ($this->_var['seckill']['recommended'] == SECKILL_RECOMMENDED): ?>
              是
              <?php else: ?>
              否
              <?php endif; ?>
              </span></td>
            <td width="80"><div> <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=seckill&amp;act=drop&id=<?php echo $this->_var['seckill']['sec_id']; ?>');" class="delete">删除</a></div></td>
          </tr>
          <?php endforeach; else: ?>
          <tr>
            <td class="align2 member_no_records padding6" colspan="6">没有符合条件的记录</td>
          </tr>
          <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php if ($this->_var['seckill_list']): ?>
          <tr class="line_bold line_bold_bottom">
            <td colspan="10"></td>
          </tr>
          <tr>
		  <th><input type="checkbox" id="all2" class="checkall"/></th>
            <th colspan="8"> <p class="position1"> <span class="all">
                <label for="all2">全选</label>
                </span> <a href="#" class="delete" uri="index.php?app=seckill&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a> </p>
              <p class="position2"> <?php echo $this->fetch('member.page.bottom.html'); ?> </p></th>
          </tr>
          <?php endif; ?>
        </table>
      </div>
      <div class="wrap_bottom"></div>
    </div>
    <div class="clear"></div>
    <div class="adorn_right1"></div>
    <div class="adorn_right2"></div>
    <div class="adorn_right3"></div>
    <div class="adorn_right4"></div>
  </div>
  <div class="clear"></div>
</div>
<iframe name="iframe_post" id="iframe_post" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>