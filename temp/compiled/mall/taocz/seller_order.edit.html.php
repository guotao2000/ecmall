<?php echo $this->fetch('member.header.html'); ?>
<script language="javascript" type="text/javascript">
    function yxwquantity(that) {
        var inval = $(that).html();
        var gid = $(that).attr("idvalue");
        var oid = $(that).attr("oid");
        $(that).html("<input type='text' id='edit" + oid + "q" + gid + "' value='" + inval + "'>");
        $("#edit" + oid + "q" + gid + "").focus().live("blur", function () {
            var editval = $(this).val();
            $(that).html(editval);
            var url = "/index.php?app=seller_order&act=editgood&otype=quantity";
            $.getJSON(url, {order_id: oid, good_id: gid, val: editval}, function (data) {
                if (data.done) {
                    $(".yxwshipfee").html(price_format(data.retval.shipping_fee));
                    $(".yxwdis").html(price_format(data.retval.discount));
                    $(".yxwamount").html(price_format(data.retval.order_amount));

                }
            });
        });
    }
    function yxwprice(that) {
        var inval = $(that).html();
        var gid = $(that).attr("idvalue");

        var oid = $(that).attr("oid");
        $(that).html("<input type='text' id='edit" + oid + "p" + gid + "' value='" + inval + "'>");
        $("#edit" + oid + "p" + gid + "").focus().live("blur", function () {
            var editval = $(this).val();

            $(that).html(editval);
            var reg = /^\d+\.?\d*$/;
            if (!reg.test(editval)) {
                alert("请输入数字！！");
                $(that).html(inval);
                return false;
            }
            var url = "/index.php?app=seller_order&act=editgood&otype=price";
            $.getJSON(url, {order_id: oid, good_id: gid, val: editval}, function (data) {
                if (data.done) {
                    $(".yxwshipfee").html(price_format(data.retval.shipping_fee));
                    $(".yxwdis").html(price_format(data.retval.discount));
                    $(".yxwamount").html(price_format(data.retval.order_amount));
                }
            });
        });
    }

    function yxwshipfee(that) {
        var inval = $(that).html()
        len = inval.length;

        inval = inval.substr(1, len - 1);
        var oid = $(that).attr("oid");
        $(that).html("<input type='text' id='edit" + oid + "f' value='" + inval + "'>");
        $("#edit" + oid + "f").focus().live("blur", function () {
            var editval = $(this).val();

            $(that).html(price_format(editval));
            var reg = /^\d+\.?\d*$/;
            if (!reg.test(editval)) {
                alert("请输入数字！！");
                $(that).html(price_format(inval));
                return false;
            }
            var url = "/index.php?app=seller_order&act=editorder&otype=shipfee";
            $.getJSON(url, {order_id: oid, val: editval}, function (data) {
                if (data.done) {
                    $(".yxwshipfee").html(price_format(data.retval.shipping_fee));
                    $(".yxwdis").html(price_format(data.retval.discount));
                    $(".yxwamount").html(price_format(data.retval.order_amount));
                }
            });
        });
    }
    function yxwdis(that) {
        var inval = $(that).html()
        len = inval.length;

        inval = inval.substr(1, len - 1);
        var oid = $(that).attr("oid");
        $(that).html("<input type='text' id='edit" + oid + "d' value='" + inval + "'>");
        $("#edit" + oid + "d").focus().live("blur", function () {
            var editval = $(this).val();

            $(that).html(price_format(editval));
            var reg = /^\d+\.?\d*$/;
            if (!reg.test(editval)) {
                alert("请输入数字！！");
                $(that).html(price_format(inval));
                return false;
            }
            var url = "/index.php?app=seller_order&act=editorder&otype=discount";
            $.getJSON(url, {order_id: oid, val: editval}, function (data) {
                if (data.done) {
                    $(".yxwshipfee").html(price_format(data.retval.shipping_fee));
                    $(".yxwdis").html(price_format(data.retval.discount));
                    $(".yxwamount").html(price_format(data.retval.order_amount));
                }
            });
        });
    }

    function yxwaddress(that) {
        var inval = $(that).html();
        var oid = $(that).attr("oid");
        $(that).html("<input type='text' id='edit" + oid + "' value='" + inval + "'>");
        $("#edit" + oid + "").focus().live("blur", function () {
            var editval = $(this).val();
            $(that).html(editval);
            var url = "/index.php?app=seller_order&act=editorder&otype=address";
            $.getJSON(url, {order_id: oid, val: editval}, function (data) {
                if (data.done) {
                    alert("修改成功！");
                }
            });
        });
    }


        function delgood(oid, gid,that) {
            var url = "/index.php?app=seller_order&act=editgood&otype=delete";
            $.getJSON(url, {order_id: oid, good_id: gid}, function (data) {
                if (data.done) {
                    if (data.retval.count == 0) {
                        window.top.location.href = "/index.php?app=seller_order";
                    }
                    $(".yxwshipfee").html(price_format(data.retval.shipping_fee));
                    $(".yxwdis").html(price_format(data.retval.discount));
                    $(".yxwamount").html(price_format(data.retval.order_amount));
                  $(that).parent().parent().parent().remove();
                }
            });
      }



</script>
<div class="content">
    <div class="particular">
        <div class="particular_wrap"><h2>订单详情 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?app=order_print&order_id=<?php echo $_GET['order_id']; ?>" target="_blank">打印订单</a></h2>
        
        
        <style type="text/css">
        .log_list {color:#666666; list-style:none; padding:5px 10px;}
         .log_list li {margin:8px 0px;}
        .log_list li .operator {font-weight:bold; color:#FE5400; margin-right:5px;}
        .log_list li .log_time {font-style:italic; margin:0px 5px; font-weight:bold;}
        .log_list li .order_status {font-style:italic; margin:0px 5px; font-weight:bold;}
        .log_list li .reason {font-style:italic; margin:0px 5px; font-weight:bold;}
		.particular_wrap a{font-size:12px; text-decoration:underline;}
        </style>
            <div class="box">
                <div class="state">订单状态&nbsp;:&nbsp;<strong>
                        <?php if ($this->_var['order']['status'] == 11): ?>等待买家付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 12): ?>等待买家收货付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 13): ?>买家已付款<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 20): ?>等待卖家发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 21): ?>货到付款已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 30): ?>卖家已发货<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 40): ?>交易完成<?php endif; ?>
                        <?php if ($this->_var['order']['status'] == 0): ?>交易关闭<?php endif; ?> 
                </strong></div>
                <div class="num">订单号&nbsp;:&nbsp;<?php echo $this->_var['order']['order_sn']; ?></div>
                <div class="time">下单时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['add_time']); ?></div>
            </div>
            <h3>订单信息</h3>
            <dl class="info">
                <dt>买家信息</dt>
                <dd>买家&nbsp;:&nbsp;<?php if ($this->_var['order']['from_weixin'] == 1): ?><?php echo $this->_var['order']['wx_nickname']; ?><?php else: ?><?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?><?php endif; ?></dd>
                <dd>电话号码&nbsp;:&nbsp;<?php echo ($this->_var['order']['phone_tel'] == '') ? '-' : $this->_var['order']['phone_tel']; ?></dd>
                 <dd>所在地区&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['region_name']) == '') ? '-' : htmlspecialchars($this->_var['order']['region_name']); ?></dd>
                 <dd>手机号码&nbsp;:&nbsp;<?php echo ($this->_var['order']['phone_mob'] == '') ? '-' : $this->_var['order']['phone_mob']; ?></dd>
                 <dd>电子邮件&nbsp;:&nbsp;<?php echo ($this->_var['order']['buyer_email'] == '') ? '-' : $this->_var['order']['buyer_email']; ?></dd>
                 <dd>详细地址&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['address']) == '') ? '-' : htmlspecialchars($this->_var['order']['address']); ?></dd>
             </dl>
         <div class="ware_line">
            <div class="ware">
                 <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                <div class="ware_list">
                       <div class="ware_pic"><img src="<?php echo $this->_var['goods']['goods_image']; ?>" width="50" height="50"  /></div>
                    <div class="ware_text">
                        <div class="ware_text1">
                        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                        <?php if ($this->_var['group_id']): ?><a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group_id']. ''); ?>"><strong class="color8">[团购]</strong></a><?php endif; ?>
                        <br />
                        <span><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></span>
                        </div>
                        <div class="ware_text2">
                          <span>数量&nbsp;:&nbsp;<strong ondblclick="yxwquantity(this)" class="yxwquantity"  idvalue="<?php echo $this->_var['goods']['spec_id']; ?>" oid="<?php echo $this->_var['order']['order_id']; ?>"><?php echo $this->_var['goods']['quantity']; ?></strong></span>
                          <span>单价&nbsp;:&nbsp;<strong ondblclick="yxwprice(this)" class="yxwprice"  idvalue="<?php echo $this->_var['goods']['spec_id']; ?>" oid="<?php echo $this->_var['order']['order_id']; ?>"><?php echo $this->_var['goods']['price']; ?></strong></span>
                          <?php if ($this->_var['goods']['sku']): ?><span>商家编码&nbsp;:&nbsp;<strong><?php echo $this->_var['goods']['sku']; ?></strong></span><?php endif; ?>
                        </div>
                         <div class="ware_text2">
                         <a href="javascript:return false;" onclick="delgood(<?php echo $this->_var['order']['order_id']; ?>, <?php echo $this->_var['goods']['spec_id']; ?>,this) ">删除</a>
                         </div>
                    </div>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <div class="order_edit-title" >
                  编辑当前订单
                  <strong>(请输入你要添加的商品iD或者商品名称点搜索)</strong>
                  <span onclick="bianji()">编  辑</span>
                </div>
                <div id="bianji"  class="addgoods"  style=" display:none;">
        <div class="search">
        <span class="search_goodsid">商品ID:</span><input id="good_id" type="text" width="50px;" /><span class="search_goodsname">商品名称:</span><input id="good_name" type="text" /><span class="search_goodsname">商品条码:</span><input id="goodsku" type="text" /><input id="sousuo" type="button" value="搜 索" onclick="gosearch() " />
        </div>
        <table ><thead id="tophead"> <tr width="100%"><td width="10%">商品ID</td><td width="40%">商品名称</td><td width="10%">商品条码</td><td width="10%">商品价格</td><td width="10%">商品数量</td><td width="10%">操作</td></tr></thead>
       <tbody id="sresult">
       </tbody> 
        </table>
        
        </div>
        <script type="text/javascript">
            function addgood(that, goodid) {
                oid=<?php echo $this->_var['order']['order_id']; ?>;
                shuliang = $("input[name='g_" + goodid + "']").val();
                
                var url = "/index.php?app=seller_order&act=addgood&good_id="+goodid+"&order_id="+oid+"&shu="+shuliang;
                
                $.get(url, '', function (data) {
             
                    if (data == 1) {
                        window.top.location = window.top.location;
                    } 
                    else if(data==-1)
                    {
                     alert("已经存在，添加失败！！");
                    }
                    else {
                        alert("添加失败！！");
                    }
                });

            }
            function gosearch() {
                goodsid = $("#good_id").val();
                goodname = $("#good_name").val();
                goodsku=$("#goodsku").val();
                gall=goodsid+goodname+goodsku;
                if (goodsid.length > 0) {

                    var url = "/index.php?app=seller_order&act=sgoods&otype=gid&good_id=" + goodsid;
                 $.get(url, '', function (data) {
                     $("#sresult").html(data);
                 });
                    return false;
                } else if(goodname.length>0){
                    var url = "/index.php?app=seller_order&act=sgoods&otype=gname&good_name=" + goodname;
                    $.get(url, '', function (data) {
                    $("#sresult").html(data);
                    });
                }
                else if(goodsku.length>0)
                {
                var url = "/index.php?app=seller_order&act=sgoods&otype=gsku&gsku=" + goodsku;
                    $.get(url, '', function (data) {
                    $("#sresult").html(data);
                    });

                }else if(gall.length<1){
                alert('请输入查询条件！！');
                }
            }
        
        function bianji() {
             var sbtitle=document.getElementById('bianji');
                       if(sbtitle.style.display=='none'){
                       sbtitle.style.display='block';
                       }else{
                       sbtitle.style.display='none';
                       }
                    }
        </script>
                <div class="transportation">配送费用&nbsp;:&nbsp;<span><span ondblclick="yxwshipfee(this)" class="yxwshipfee"  oid="<?php echo $this->_var['order']['order_id']; ?>"><?php echo price_format($this->_var['order_extm']['shipping_fee']); ?></span><strong>(<?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?>)</strong></span>优惠打折&nbsp;:&nbsp;<span ondblclick="yxwdis(this)" class="yxwdis" oid="<?php echo $this->_var['order']['order_id']; ?>"><?php echo price_format($this->_var['order']['discount']); ?></span>订单总价&nbsp;:&nbsp;<b class="yxwamount"><?php echo price_format($this->_var['order']['order_amount']); ?></b>
                </div>
                <ul class="order_detail_list">
                   <?php if ($this->_var['order']['payment_code']): ?>
                    <li>支付方式&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['payment_name']); ?></li>
                    <?php endif; ?>
                    <?php if ($this->_var['order']['pay_message']): ?>
                    <li>支付留言&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['pay_message']); ?></li>
                    <?php endif; ?>
                    <li>下单时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['add_time']); ?></li>
                    <?php if ($this->_var['order']['pay_time']): ?>
                    <li>支付时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['pay_time']); ?></li>
                    <?php endif; ?>
                    <?php if ($this->_var['order']['ship_time']): ?>
                    <li>发货时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['ship_time']); ?></li>
                    <?php endif; ?>
                    <?php if ($this->_var['order']['finished_time']): ?>
                    <li>完成时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['finished_time']); ?></li>
                    <?php endif; ?>
                </ul>
           </div>
       </div>
       <h3>收货人及物流信息</h3>
          <div class="goods">
           收货地址&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?><?php if ($this->_var['order_extm']['phone_mob']): ?>, &nbsp;<?php echo $this->_var['order_extm']['phone_mob']; ?><?php endif; ?><?php if ($this->_var['order_extm']['phone_tel']): ?>,&nbsp;<?php echo $this->_var['order_extm']['phone_tel']; ?><?php endif; ?>
                ,&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<strong ondblclick="yxwaddress(this)"  class="yxwaddress" oid="<?php echo $this->_var['order']['order_id']; ?>"><?php echo htmlspecialchars($this->_var['order_extm']['address']); ?></strong>
                <?php if ($this->_var['order_extm']['zipcode']): ?>,&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['zipcode']); ?><?php endif; ?><br />
           配送方式&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?><br/>
            <?php if ($this->_var['order']['invoice_no']): ?>
               物流单号&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['invoice_no']); ?><!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_var['shipping_info']['query_url']; ?>&amp;<?php echo $this->_var['order']['invoice_no']; ?>" target="_blank">query_logistics</a>-->
               <br />
           <?php endif; ?>
           <?php if ($this->_var['order']['postscript']): ?>
           买家附言&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['postscript']); ?><br />
           <?php endif; ?>
          </div>
       <?php if ($this->_var['order_logs']): ?>
       <h3>操作历史</h3>
        <ul class="log_list">
            <?php $_from = $this->_var['order_logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'log');if (count($_from)):
    foreach ($_from AS $this->_var['log']):
?>
            <li>
                <span class="operator"><?php if ($this->_var['log']['operator'] == '0'): ?><span style="color:green;">[系统]</span><?php else: ?><?php echo htmlspecialchars($this->_var['log']['operator']); ?><?php endif; ?></span>
                            在
                <span class="log_time"><?php echo local_date("Y-m-d H:i:s",$this->_var['log']['log_time']); ?></span>
                            将订单状态从
                <span class="order_status"><?php echo $this->_var['log']['order_status']; ?></span>
                            改变为
                <span class="order_status"><?php echo $this->_var['log']['changed_status']; ?></span>
                <?php if ($this->_var['log']['remark']): ?>
                原因:<span class="reason"><?php echo htmlspecialchars($this->_var['log']['remark']); ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
       <?php endif; ?>
       </div>
          <div class="particular_bottom"></div>
        </div>

        <div class="clear"></div>

        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>

    <div class="clear"></div>
</div>
</div>
<?php echo $this->fetch('footer.html'); ?>