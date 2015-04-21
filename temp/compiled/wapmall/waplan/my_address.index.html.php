
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <base href="<?php echo $this->_var['site_url']; ?>/" />
        <?php echo $this->_var['page_seo']; ?>
        <link href="<?php echo $this->res_base . "/" . 'css/common.css'; ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $this->res_base . "/" . 'css/address.css'; ?>" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="index.php?act=jslang"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'member.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.8.0.min.js'; ?>"</script>


        <script type="text/javascript">
            //<!CDATA[
            var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
            var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
            var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';
            //]]>
        </script>
        <?php echo $this->_var['_head_tags']; ?>
    </head>
    <body style="background:#f7f7f7;">
        <div class="w320">
            <div class="fixed">
                
                <div class="header header2">
                    <a href="<?php echo url('app=buyer_order&act=index'); ?>" class="back2_pre"></a>
                    收货地址
                    <a  ectype="dialog" dialog_title="新增地址" dialog_id="my_address_add" dialog_width="100%" uri="index.php?app=my_address&act=add" class="add_address"></a>
                </div>  
            </div>
            
            <div class="add_box" style="display:none">
                <form method="post" action="index.php?app=my_address&act=<?php echo $this->_var['act']; ?>&addr_id=<?php echo $this->_var['address']['addr_id']; ?>" >
                    <p><input  name="consignee" value="<?php echo htmlspecialchars($this->_var['address']['consignee']); ?>"  type="text" placeholder="请填写你的真实姓名"/></p>
                    <p><input type="text" placeholder="请填写你的手机号码" /></p>
                    <p>
                        <select>
                            <option>请选择</option>
                        </select>
                    </p>
                    <p>
                        <select>
                            <option>请选择</option>
                        </select>
                    </p>
                    <p>
                        <select>
                            <option>请选择</option>
                        </select>
                    </p>
                    <p>
                        <input type="text" placeholder="不必重复填写地区" name="address" value="<?php echo htmlspecialchars($this->_var['address']['address']); ?>" />
                    </p>
                    <p><input type="text" placeholder="邮政编码"/></p>
                    <p><input type="checkbox"  class="mr"/>设为默认地址</p>
                    <p><input type="submit"  class="white_btn add_submit" value="<?php if ($this->_var['address']['addr_id']): ?>编辑地址<?php else: ?>新增地址<?php endif; ?>"></p>
                </form>
            </div>
            
            <div class="edit_box" style="display:none">
                <p><input type="text" placeholder="请填写你的真实姓名" value="秋刀鱼"/></p>
                <p><input type="text" placeholder="请填写你的手机号码" name="phone_mob" value="<?php echo $this->_var['address']['phone_tel']; ?>" /></p>
                <p>
                    <select>
                        <option>福建省</option>
                    </select>
                </p>
                <p>
                    <select>
                        <option>厦门市</option>
                    </select>
                </p>
                <p>
                    <select>
                        <option>思明区</option>
                    </select>
                </p>
                <p>
                    <input type="text" placeholder="不必重复填写地区" value="莲前西林西二里路金沙花园31号702" />
                </p>
                <p><input type="text" placeholder="邮政编码" value="361000"/></p>
                <p><input type="checkbox"  class="mr"/>设为默认地址</p>
                <p><a href="#" class="white_btn add_submit">确定</a></p>
            </div>
            
            <div class="address_con">
                <?php $_from = $this->_var['addresses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['address']):
        $this->_foreach['v']['iteration']++;
?>
                <div class="address_box" >
                    <div class="address_info">
                        <p><?php echo htmlspecialchars($this->_var['address']['consignee']); ?>（<?php if ($this->_var['address']['phone_tel']): ?><?php echo $this->_var['address']['phone_tel']; ?> <?php else: ?> <?php echo $this->_var['address']['phone_mob']; ?><?php endif; ?> ）</p>
                        <p><?php echo htmlspecialchars($this->_var['address']['region_name']); ?></p>
                        <p><?php echo htmlspecialchars($this->_var['address']['address']); ?></p>
                    </div>
                    <p class="oprate"><a href="javascript:void(0);" ectype="dialog" dialog_id="my_address_edit" dialog_title="编辑地址" dialog_width="100%" uri="index.php?app=my_address&act=edit&addr_id=<?php echo $this->_var['address']['addr_id']; ?>" class="edit_address"><b></b>编辑<i></i></a><a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_address&amp;act=drop&addr_id=<?php echo $this->_var['address']['addr_id']; ?>');" class="del_address"><b></b>删除</a></p>
                </div>
                <?php endforeach; else: ?>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </div>
            <iframe id='iframe_post' name="iframe_post" frameborder="0" width="0" height="0">
                
        </div>
        <?php echo $this->fetch('member.footer.html'); ?>