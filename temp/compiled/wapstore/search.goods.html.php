<!doctype html>
<html>
    <head>
        <title>倍全商城-商品分类列表页</title>
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
        <link rel="stylesheet" type="text/css" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/home/cplb.css'; ?>"  />  
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/com/com.css'; ?>"/>
          <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'bqmart/template/css/list/style.css'; ?>" />
        <script src="<?php echo $this->res_base . "/" . 'bqmart/js/jquery.js'; ?>" type="application/javascript"></script>
        <script>
    

        $(document).ready(function(e) {
        //alert(window.top.location.href);
      top_url=window.top.location.href;
      if(top_url.indexOf("price") > 0)
      {
        $(".pxui-tab>a").removeClass("selected");
        $("#jiage").addClass("selected");
      }
      if(top_url.indexOf("hot=1") > 0)
      {
        $(".pxui-tab>a").removeClass("selected");
        $("#xiaoliang").addClass("selected");
      }
      if(top_url.indexOf("hot=2") > 0)
      {
        $(".pxui-tab>a").removeClass("selected");
        $("#zuixin").addClass("selected");
      }
      $('.spinnerExample').spinner({
          value:0,
          min:0,
          
        });
        $('.spinnerExample').change(function(){
          alert($('.spinnerExample').val());
          
          });
      });
        </script>
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/com.js'; ?>"></script>
        
        
        <script src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/template.js'; ?>"></script>
        
        
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'bqmart/template/js/com/jquery.spinner.js'; ?>"></script>
        
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>
</head>
<body>
<div class="com-content">
    
      <div class="com-header-area" id="js-com-header-area">
          <a href="javascript:history.back(-1);" class="com-header-retun"></a>
      <dfn></dfn>
          <span class="bq_header_title" style="padding-left:0px;">商品列表</span>
          <a href="<?php echo url('app=default'); ?>" class="com-header-home "><del></del></a>
      <div class="clear"></div>
        </div>
    
     <div class="com-content-area" id="js-com-content-area" style=" margin:0px;">
      
       <div class="page-role">
        
       <div  class="bq_cat-search" id="js-attrs-title" >
        <div class="cat_seach-box">
        
          <div class="search" style="position:relative">
          <span class="input-box">
          <form action="" id="searchForm"  name="searchForm" method="get" >
              <input type="text" name="keyword" id="keyword" class="new-input"  value="" placeholder="请输入关键词" style="background: none repeat scroll 0 0 #fff;border: 0 none;border-radius: 0;color: #bdbdbd;vertical-align: middle;width: 85%; padding:4px 0px;">
              <input type="hidden" name="app" value="store" />
              <input type="hidden" name="act" value="search" />
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
          </form> 
          <a href="javascript:void(0)" onclick="$('#searchForm').submit();" class="btn-search"><span>search</span></a>
          </span>
          <div class="new-srch-lst" id="shelper" style="position: absolute; top: 2em; left: 3.28em; z-index: 10; width: 404.2px; display: none;"></div>
          </div>
        
        </div>
       </div>
       
      <div class="pxui-tab" style="margin-bottom:10px;">
            <a href="#"  class="selected"  id="tuijian" >推  荐</a>
            <a href="javascript:sort_price();" id="jiage" >
      价 格
      <i class="arrow2-top gray"></i>
      <i class="arrow2-bottom gray"></i>
        </a>
        <a href="javascript:sort_sale();" id="xiaoliang" >销 量</a>
        <a href="javascript:sort_new();"  id="zuixin" >最 新</a>
        </div>
      <div class="pxui-area">
           
         <div class="liebiao" id="js-goodlist">
            
              <div class="zxList">
               <ul>
               <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                 <li class="clearfix">
                   <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px;"><img src="<?php echo $this->_var['goods']['default_image']; ?>"></a>
                   <div class="zxProInfo" style="line-height:22px;" >
                      <p class="proName" style="line-height:22px; margin-bottom:5px;"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" style=" border-right:none; float:none; margin-left:0px; border-bottom:none;"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                   <!--  <p class="proSlogan">超值特价，数量有限！</p>-->
                      <span class="proPrice" style="display:block;">倍全价：<?php echo price_format($this->_var['goods']['price']); ?></span>
				      <span style="margin-left:20px; font-size:12px; display:block; margin-top:3px;">市场价：<del>
						 <?php echo price_format($this->_var['goods']['shichang']); ?></del></span> 
                      <span style="position:absolute; right:10px; bottom:18px;" gid="<?php echo $this->_var['goods']['spec_id']; ?>" sid="<?php echo $this->_var['goods']['store_id']; ?>"><input type="text" class="spinnerExample"/></span>
                  </div>
                 </li>
               <?php endforeach; else: ?>
            暂无此类商品
             <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
               </ul>
              </div>
            
          </div>
           
           
           <?php if (! $this->_var['goods_list_order']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
           
      </div>
       </div>
      
   </div>
      <?php echo $this->fetch('member.footer.html'); ?>
</div>
</div>

 <?php echo $this->fetch('store.menu.html'); ?>


</body>

<script type="text/javascript">

//按照价格排序
function sort_price()
{
  top_url=window.top.location.href;

  if(top_url.indexOf("price%20desc") > 0 )
  {
    window.top.location.href=changeURLPar(changeURLPar(top_url,'order','price asc'),'hot','0');
  }else
  {
    window.top.location.href=changeURLPar(changeURLPar(top_url,'order','price desc'),'hot','0');
  }
  
  
}
//按照销量排序
function sort_sale()
{
  top_url=window.top.location.href;

    window.top.location.href=changeURLPar(changeURLPar(top_url,'order','add_time desc'),'hot','1');

  
}

//按照最新
function sort_new()
{
  top_url=window.top.location.href;

    window.top.location.href=changeURLPar(changeURLPar(top_url,'order','add_time desc'),'hot','2');

  
}
function changeURLPar(destiny, par, par_value) 
{ 
var pattern = par+'=([^&]*)'; 
var replaceText = par+'='+par_value; 
if (destiny.match(pattern)) 
{ 
var tmp = '/\\'+par+'=[^&]*/'; 
tmp = destiny.replace(eval(tmp), replaceText); 
return (tmp); 
} 
else 
{ 
if (destiny.match('[\?]')) 
{ 
return destiny+'&'+ replaceText; 
} 
else 
{ 
return destiny+'?'+replaceText; 
} 
} 
return destiny+'\n'+par+'\n'+par_value; 
} 

</script>



</html>
