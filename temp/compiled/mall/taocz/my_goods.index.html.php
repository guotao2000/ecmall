<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
$(function(){
    var t = new EditableTable($('#my_goods'));
    $('#truncate').click(function(){
        var goods_ids = '<?php echo $this->_var['goods_ids']; ?>';
        if(goods_ids && confirm('<?php echo sprintf('确定要删除检索到的%s条结果吗？删除商品后不可恢复！', $this->_var['page_info']['item_count']); ?>')){
            $('#truncate_form').append('<input type="hidden" name="act" value="truncate" />');
            $('#truncate_form').append('<input type="hidden" name="goods_ids" value="' + goods_ids + '" />');
            $('#truncate_form').submit();
            return false;
        }
    });
});
function quanzhong(good_id) {
    url = "/index.php?app=my_goods&act=quanzhong&good_id=" + good_id;
    $.get(url, '', function (data) {
        if (data > 0) {
            alert("升序成功！");
        } else {
            alert("设置失败！");
        }
    });
}

function jiangquan(good_id) {
    url = "/index.php?app=my_goods&act=jiangquan&good_id=" + good_id;
    $.get(url, '', function (data) {
        if (data > 0) {
            alert("降序成功！");
        } else {
            alert("设置失败！");
        }
    });
}
</script>
<style>
.member_no_records {border-top: 0px !important;}
.table td{padding-left: 5px;}
.table .ware_text {width: 155px;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
    <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" title="淘宝助理导入"><b class="ico1" onclick="go('index.php?app=my_goods&amp;act=import_taobao');">淘宝助理导入</b></div>
            <div class="eject_btn_two eject_pos2" title="新增商品"><b class="ico2" onclick="go('index.php?app=my_goods&amp;act=add');">新增商品</b></div>
            <div class="public_select table">
                <table id="my_goods" server="<?php echo $this->_var['site_url']; ?>/index.php?app=my_goods&amp;act=ajax_col" >

                    <tr class="line_bold">
                        <th class="width1"><input type="checkbox" id="all" class="checkall"/></th>
                        <th class="align1" colspan="3">
                            <span class="all"><label for="all">全选</label></span>
                            <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&act=batch_edit" name="id">编辑</a>
                            <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_goods&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a>
                        </th>
                        <th colspan="8">
                            <div class="select_div">
                            <form id="truncate_form" method="post">
                            </form>
                            
                            <form id="my_goods_form" method="get">
                            <a id="truncate" class="detlink" style="float:right" href="javascript:;">清空结果</a>
                            
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink" style="float:right" href="<?php echo url('app=my_goods'); ?>">取消检索</a>
                            <?php endif; ?>
                            <input type="hidden" name="app" value="my_goods">
                            <select class="select1" name='sgcate_id'>
                                <option value="0">本店分类</option>
                                <?php echo $this->html_options(array('options'=>$this->_var['sgcategories'],'selected'=>$_GET['sgcate_id'])); ?>
                            </select>
                            <select class="select2" name="character">
                                <option value="0">状态</option>
                                <?php echo $this->html_options(array('options'=>$this->_var['lang']['character_array'],'selected'=>$_GET['character'])); ?>
                                <option value="10">国际条码</option>
                            </select>
                            <input type="text" class="text_normal" name="keyword" value="<?php echo htmlspecialchars($_GET['keyword']); ?>"/>
                            <input type="submit" class="btn" value="搜索" />
                            </form>
                            </div>
                        </th>
                    </tr>
                    <?php if ($this->_var['goods_list']): ?>
                    <tr class="gray"  ectype="table_header">
                        <th width="30"></th>
                        <th width="55"></th>
                        <th width="50">排序</th>
                     
                        <th width="165" coltype="editable" column="goods_name" checker="check_required" inputwidth="90%" title="排序"  class="cursor_pointer"><span ectype="order_by">商品名称</span></th>
                        <th width="70" column="cate_id" title="排序"  class="cursor_pointer"><span ectype="order_by">商品分类</span></th>
                        <th width="55" coltype="editable" column="brand" checker="check_required" inputwidth="55px" title="排序"  class="cursor_pointer"><span ectype="order_by">国际条码</span></th>
                        <th width="55" class="cursor_pointer" coltype="editable" column="price" checker="check_number" inputwidth="50px" title="排序"><span ectype="order_by">价格</span></th>
                         <th width="25" column="closed" title="排序" class="cursor_pointer"><span ectype="order_by">市场价</span></th>
                        <th width="55" class="cursor_pointer" coltype="editable" column="stock" checker="check_pint" inputwidth="50px" title="排序"><span ectype="order_by">库存</span></th>
                        <th width="25" coltype="switchable" column="if_show" onclass="right_ico" offclass="wrong_ico" title="排序"  class="cursor_pointer"><span ectype="order_by">上架</span></th>
                        <th width="25" coltype="switchable" column="recommended" onclass="right_ico" offclass="wrong_ico" title="排序"  class="cursor_pointer"><span ectype="order_by">推荐</span></th>
                       
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['_goods_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_goods_f']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['_goods_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_goods_f']['iteration'] == $this->_foreach['_goods_f']['total'])): ?> last_line<?php endif; ?>" ectype="table_item" idvalue="<?php echo $this->_var['goods']['goods_id']; ?>">
                        <td width="25" class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
                        <td width="50" class="align2"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods']['default_image']; ?>" width="50" height="50"  /></a></td>
                       <?php if ($this->_var['store']['enable_radar']): ?>
                        <td width="50"  align="center"><span id="r<?php echo $this->_var['goods']['goods_id']; ?>" class="radar_product_point" onclick="quanzhong('<?php echo $this->_var['goods']['goods_id']; ?>')" style=" cursor:pointer; " alt="升序">《</span>|<span id="Span1" class="radar_product_point" onclick="jiangquan('<?php echo $this->_var['goods']['goods_id']; ?>')" style=" cursor:pointer; " alt="降序">》</span></td>
                        <?php endif; ?>
                        <td width="160" align="align2">
                          <p class="ware_text"><span class="color2" ectype="editobj"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></p>
                        </td>
                        <td width="65"><span class="color2"><?php echo nl2br($this->_var['goods']['cate_name']); ?></span></td>
                        <td width="50" class="align2"><span class="color2" ><?php echo htmlspecialchars($this->_var['goods']['sku']); ?></span></td>
                        <td width="50" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo price_format($this->_var['goods']['price']); ?></span></td>
                        <td width="20" class="align2"><?php echo price_format($this->_var['goods']['shichang']); ?></td>
                        <td width="50" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo $this->_var['goods']['stock']; ?></span></td>
                        <td width="20" class="align2"><span style="margin:0px 5px;" ectype="editobj" <?php if ($this->_var['goods']['if_show']): ?>class="right_ico" status="on"<?php else: ?>class="wrong_ico" stauts="off"<?php endif; ?>></span></td>
                        <td width="20" class="align2"><span style="margin:0px 5px;" ectype="editobj" <?php if ($this->_var['goods']['recommended']): ?>class="right_ico" status="on"<?php else: ?>class="wrong_ico" stauts="off"<?php endif; ?>></span></td>
                        
                        <td><div>
						<?php if ($this->_var['power_coupon'] > 0): ?><a href="javascript:return false;" onclick="fabu(<?php echo $this->_var['goods']['goods_id']; ?>)" >发布</a><?php endif; ?>
						<a href="<?php echo url('app=my_goods&act=edit&id=' . $this->_var['goods']['goods_id']. ''); ?>" class="edit">编辑</a>
                            <a  href="javascirpt:;" ectype="dialog" dialog_id="export_ubbcode" dialog_title="导出UBB" dialog_width="380" uri="<?php echo url('app=my_goods&act=export_ubbcode&id=' . $this->_var['goods']['goods_id']. ''); ?>" class="export">导出UBB</a> <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_goods&amp;act=drop&id=<?php echo $this->_var['goods']['goods_id']; ?>');" class="delete">删除</a></div></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="10"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的商品</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['goods_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="11"> </td>
                    </tr>
                    <tr>
                        <th><input type="checkbox" id="all2" class="checkall"/></th>
                        <th colspan="10">
                            <p class="position1">
                                <span class="all"><label for="all2">全选</label></span>
                                <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&amp;act=batch_edit&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" name="id">编辑</a>
                                <a href="javascript:void(0);" class="delete" uri="index.php?app=my_goods&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
                            </p>
                            <p class="position2">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
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
<script type="text/javascript">
function fabu(goodid)
{
  var n=prompt('您要发布到那几个店铺，请把店铺编号输入，用英文逗号分隔','');
  if(n.length>0)
  {
   var url='index.php?app=store_copygoods&act=copygoods&goods_id='+goodid+'&sids='+n;
  $.get(url, function(result){
    alert(result);
  });
  }else{
   alert('请输入相应的店铺编号，多个店铺编号用逗号分隔，英文逗号');
  }
  
   
}
</script>
<?php if ($this->_var['store']['enable_radar']): ?>
<input type="hidden" id="radar_lincense_id" value="" />
<input type="hidden" id="radar_product_key" value="ecmall" />
<input type="hidden" id="radar_sign_key" value="" />
<script type="text/javascript" src="http://js.sradar.cn/radarForGoodsList.js"></script>
<script>
radar_point_extract();
</script>
<?php endif; ?>