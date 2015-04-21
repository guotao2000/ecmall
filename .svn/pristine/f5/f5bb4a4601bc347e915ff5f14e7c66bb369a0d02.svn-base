<!doctype html>
<html>
    <head>
        <title>倍全商城-分享到微信</title>
        <meta charset="utf-8">
        <meta name="keywords" content="倍全,倍全商城,倍全订货,社区O2O,社区便利店,网上超市,济南社区020,便利店O2O,济南社区便利店" />
        <meta name="description" content="倍全商城-倍全旗下品牌，济南同城最快速的便利店商品订购派送网站" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" />
        
        <meta content="yes" name="apple-mobile-web-app-capable" />
        
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        
        <meta content="telephone=no" name="format-detection" />
        
        <!--<link rel="/touch/apple-touch-startup-image" href="startup.png" />-->
        
        <!--<link rel="apple-touch-icon" href="/touch/iphon_tetris_icon.png"/>-->
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>"/> 
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/index.css'; ?>"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/cart/index.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>"></script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
</head>
<body>
<div class="com-content">

  <div class="com-header-area" id="js-com-header-area">
          <a href="<?php echo url('app=default'); ?>" class="com-header-retun"></a>
		  <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">分享到微信</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
		  <div class="clear"></div>
        </div>


<div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
   
   <div class="page-role cart_empty-page">
      <div class="pxui-area">
         
           <div class="cart_empty-top">
              <p>
               <span class="cart_empty-topicon"></span>客官：分享到微信后有惊喜哦~~
              </p>
           </div>
           
         
         <div style="display:block;" id="share_index">
		
         <div class="wx_share-info">
		  <a href="<?php echo htmlspecialchars($this->_var['result']['url']); ?>">
            <h4>
              <?php echo htmlspecialchars($this->_var['result']['title']); ?>
            </h4>
            <p class="wx_share-time"><?php echo local_date("Y-m-d",$this->_var['result']['add_time']); ?></p>
            <div class="wx_share-img">
               <img src="<?php echo $this->res_base . "/" . 'bqmart/template/images/cart/weixin_share.jpg'; ?>" >
            </div>
            <div class="wx_share-jianjie">
                <p>
					<?php echo html_filter($this->_var['result']['content']); ?>
                </p>
            </div>
		 </a>
         </div>
         <div class="wx_share-list">
            <div id="mess_share">
               <div id="share_1">
                  <button class="button2" onclick="_system._guide(true)">
                    <img src="<?php echo $this->res_base . "/" . 'bqmart/template/images/cart/icon_msg.png'; ?>">&nbsp;发送给朋友
                  </button>
                </div>
                <div id="share_2">
                  <button class="button2" onclick="_system._guide(true)">
                     <img src="<?php echo $this->res_base . "/" . 'bqmart/template/images/cart/icon_timeline.png'; ?>">&nbsp;分享到朋友圈
                  </button>
                </div>
                <div class="clr"></div>
            </div>
         </div>
	     <script type="text/javascript">
            var _system={
                $:function(id){return document.getElementById(id);},
           _client:function(){
              return {w:document.documentElement.scrollWidth,h:document.documentElement.scrollHeight,bw:document.documentElement.clientWidth,bh:document.documentElement.clientHeight};
           },
           _scroll:function(){
              return {x:document.documentElement.scrollLeft?document.documentElement.scrollLeft:document.body.scrollLeft,y:document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop};
           },
           _cover:function(show){
              if(show){
             this.$("cover").style.display="block";
             this.$("cover").style.width=(this._client().bw>this._client().w?this._client().bw:this._client().w)+"px";
             this.$("cover").style.height=(this._client().bh>this._client().h?this._client().bh:this._client().h)+"px";
          }else{
             this.$("cover").style.display="none";
          }
           },
           _guide:function(click){
              this._cover(true);
              this.$("guide").style.display="block";
              this.$("guide").style.top=(_system._scroll().y+5)+"px";
              window.onresize=function(){_system._cover(true);_system.$("guide").style.top=(_system._scroll().y+5)+"px";};
          if(click){_system.$("cover").onclick=function(){
                 _system._cover();
                 _system.$("guide").style.display="none";
         _system.$("cover").onclick=null;
         window.onresize=null;
          };}
           },
           _zero:function(n){
              return n<0?0:n;
           }
        }
        </script>
        <div id="cover"></div>
        <div id="guide" style="top:0px;"><img src="<?php echo $this->res_base . "/" . 'bqmart/template/images/cart/guide1.png'; ?>"></div>
        </div>
         
        
        <div class="cart_empty-info" style="display:none;" id="share_success">
		
             <div class="login_success-img">
                <img src="<?php echo $this->res_base . "/" . 'bqmart/template/images/cart/bq_login_success.png'; ?>" > </div>
             <p>
             亲，恭喜您已成功分享到微信~~
             </p>
             <div class="cart_empty-btn">
                 <a type="button"  href="<?php echo url('app=default'); ?>"  >去　逛　逛</a>
             </div>
             <div class="login_success-btn">
                 <a type="button"  href="<?php echo url('app=member'); ?>" style="background:#03C631; box-shadow: 0 1px 20px #8BF74D inset;"  >会员中心</a>
             </div>

        </div>
                
       </div>
      </div>
      
      
      <?php echo $this->fetch('member.footer.html'); ?>
      

</div> 

</div>
<?php echo $this->fetch('store.menu.html'); ?>
</body>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
	//debug: true,
    appId: '<?php echo $this->_var['signPackage']['appId']; ?>',
    timestamp: <?php echo $this->_var['signPackage']['timestamp']; ?>,
    nonceStr: '<?php echo $this->_var['signPackage']['nonceStr']; ?>',
    signature: '<?php echo $this->_var['signPackage']['signature']; ?>',
    jsApiList: [
	  'onMenuShareTimeline',
	  'onMenuShareAppMessage'
    ]
  });
  wx.ready(function () {
	//分享到朋友圈
    wx.onMenuShareTimeline({
        title: '<?php echo htmlspecialchars($this->_var['result']['title']); ?>', // 分享标题
        link: '<?php echo htmlspecialchars($this->_var['result']['url']); ?>', // 分享链接
        imgUrl: '<?php echo htmlspecialchars($this->_var['result']['picurl']); ?>', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
			$('#share_success').show();
			$('#share_index').hide();
        }
    });

	//分享给朋友
	wx.onMenuShareAppMessage({
		title: '<?php echo htmlspecialchars($this->_var['result']['title']); ?>', // 分享标题
		desc: '<?php echo htmlspecialchars($this->_var['result']['description']); ?>', // 分享描述
		link: '<?php echo htmlspecialchars($this->_var['result']['url']); ?>', // 分享链接
		imgUrl: '<?php echo htmlspecialchars($this->_var['result']['picurl']); ?>', // 分享图标
		type: 'link', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () { 
			// 用户确认分享后执行的回调函数
			$('#share_success').show();
			$('#share_index').hide();
		}
	});

  });
</script>

</html>
