// JavaScript Document
       function add_to_shop(spec_id, quantity,store_id)
		{	
			var url = '/index.php?app=cart&act=to_shop&spec_id='+spec_id+'&quantity='+quantity+'&store_id='+store_id;
			$.getJSON(url, '', function(data){
				if (data.done)
				{
					

					if($('#p_count_'+ data.retval.cart.store_id).length)
					{
						$('#p_count_'+ data.retval.cart.store_id).text(data.retval.cart.quantity);
					}    
					if($('#yxwcart').length)
					{
						$('#yxwcart').text(data.retval.cart.totalcount);
					}
					if($('#amount').length)
					{
						$('#amount').html(data.retval.cart.amount);
					}
					if($('#f_num').length)
					{
						$('#f_num').html(data.retval.cart.totalcount);
						
					}
					peisong(data.retval.cart.totalcount);

				}
				else
				{ 
					alert(data.msg);
                   // textField.val(quantity-1)
				   var str_id='spec_'+spec_id;
				   $("#"+str_id).html(quantity-1);
				  
				}
			});
		}
	  //点击购物车
	  function dianji()
	  {
		  var url = '/index.php?app=address';
	    $.get(url, '', function(data){
			
			if(data<0)
			{
				 window.location.href="/index.php?app=member&act=login";
				 return false;
			}
			if(data<1)
			{
				alert('请陛下先填写收货地址！');
				window.location.href="/index.php";
				 return false;
			}
			window.location.href="/index.php?app=cart";
		});
		  
	  }
	  function peisong(zongjia)
	  {
		  if(zongjia>=1)
		  {
			   $(".f_bg").css({"background-color":"#EE7700",
                               "border":"2px outset #EE7700"});
			  $(".f_t1").css("color","black");
        	  //$(".money_no").css({"background-color":"#BABABA","margin-right":"10px"});	  
		      //$(".f_t2").css("border-left","2px groove #EE7700");
			  $(".f_gwc").html('<img width="30px" src="/themes/bqmart/images/gwc2.png">');
			  $(".f_show").css({"background-color":"#ffd200",
                               "border":"3px solid #EE7700"});
				$(".money_no").hide();			  
				$(".money_yes").show();
			  //$("#peisong").html(Subtr(20,zongjia));
			   $(".footer").unbind("click").on("click",dianji);
			  
		  }else{
			  $(".f_bg").css({"background-color":"rgb(255, 255, 255)",
                               "border":"2px outset rgb(236, 237, 241)"});
			  $(".f_t1").css("color","#A6A6A6");
        	  $(".money_no").css({"background-color":"#BABABA","margin-right":"10px"});	  
		      //$(".f_t2").css("border-left","0px groove #fff");
			  $(".f_gwc").html('<img width="30px" src="/themes/bqmart/images/gwc2hui.png">');
			  $(".f_show").css({"background-color":"#D7D7D7",
                               "border":"3px solid #d7d7d7"});
			  $(".money_no").show();			  
			  $(".money_yes").hide();
			  $("#peisong").html(Subtr(1,zongjia));
			  $(".footer").unbind("click");
		 }
	  }
	  function op2jia(){
		
		var n=$(this).prev(".s_num").html();//当前商品的数量
        n = parseInt(n);//转换格式
		$("#details .s_num").html(n+1);	//修改详情中的数量	
        $(this).prev(".s_num").html(n+1);//修改当前商品的数量
		var spec_id =$(this).attr("value");
		var quantity=$(this).prev(".s_num").html();//当前商品的数量
		var store_id=$("#hd_store_id").val();
         add_to_shop(spec_id, quantity,store_id);
	   n=$(this).prev(".s_num").html();//当前商品的数量
	  // var count=$("#f_num").html();//购物车中商品的数量
	  // count = parseInt(count);
	  // document.getElementById("f_num").innerHTML = count+1;//修改购物车中商品的数量

		if(n>0)
		{			
			$(this).css({'color':'red'});		
			//显示
			$(this).prev(".s_num").show();
			$(this).prev(".s_num").prev(".op1").show();
			$("#details").find(".op1").show();
			$("#details").find(".s_num").show();
			$("#details").find(".op2").css({'color':'red'});
		}
		
	  }
      function op1jian(){
		
		var n=$(this).next(".s_num").html();//当前商品的数量
		n = parseInt(n);//转换格式
		$(this).next(".s_num").html(n-1);//修改当前商品的数量
		$("#details").find(".s_num").html(n-1);
		n=$(this).next(".s_num").html();//当前商品的数量
		//var count=$("#f_num").html();//购物车中商品的数量

		//count = parseInt(count);
		//document.getElementById("f_num").innerHTML = count-1;//修改购物车中商品的数量
        var spec_id =$(this).attr("value");
		var quantity=$(this).next(".s_num").html();//当前商品的数量
		var store_id=$("#hd_store_id").val();
         add_to_shop(spec_id, quantity,store_id);
		if(n<1){
			//隐藏
			$(this).next(".s_num").hide();
			$(this).hide();
			$(this).next(".s_num").next(".op2").css({'color':'#999'});
			$("#details").find(".op1").hide();
			$("#details").find(".s_num").hide();
			$("#details").find(".op2").css({'color':'#999'});
			
			
		}	
        
	
			
	}
	function showpic(){
		$(".share").floatdiv({left:"0px",top:"102px"});
		$(".share").parent().css("z-index",1000);
		$(".share").show();
		$(".current").removeClass('current');
		$(this).parent().addClass('current');
		
		$(this).parents("#index").nextAll("#details").addClass('s');
		
		//商品图片
		var p1 = $(this).html();
		
		$('#details .detail_pic').html(p1);		
		//商品名称
		var p2 = $(this).next().find('.n2').html();
		$('#details .detail_name').html(p2);
		//商品价格
		var p3 = $(this).next().find('.price').html();
		$('#details .price').find('span').html(p3);
		//商品数量
		var p4 = $(this).next().find('.s_num').html();
		//var p3=$("#details").find(".s_num");
		
		
		$('#details .s_num').html(p4);
		if(p4<1){
			$('.current').find('.op2').css({'color':'#999'});
			$('.s').find('.op1').hide();
			$('.s').find('.s_num').hide();
			$('.s').find('.op2').css({'color':'#999'});	
		}		
		if(p4>=1){
			$('.current').find('.op2').css({'color':'red'});
			$('.s').find('.op1').show();
			$('.s').find('.s_num').show();
			$('.s').find('.op2').css({'color':'red'});	
			};

		
			

		//商品规格

		$('#details').width($(window).width());

		//CommonPerson.Base.LoadingPic.FullScreenShow();

		
		var detail_height=$(window).height();
		var detail_width=$(window).width();
		detail_height=parseInt(detail_height)-100;
		detail_width=parseInt(detail_width);
		$('#details .d_all').height(detail_height+'px');
		$('#details .d_all').width(detail_width+'px');
		            $(".s_num").each(function(){
						if($(this).html()<1) 
						{
							$(this).prev(".op1").hide();
							$(this).hide();
						}
						 
					 });
        var spec_id=$(this).parent().attr("value");
		var url = '/index.php?app=storeyxw&act=get_good&spec_id='+spec_id+'';
	    $.getJSON(url, '', function(data){
			if (data.done)
			{
				 
				var data  = data.retval;
				
				
				$("#details").find(".pinpai").html(data[0].brand);
				$("#details").find(".guige").html(data[0].cate_name);
				$("#details").find(".detalis_ad").html(data[0].description);
			   // CommonPerson.Base.LoadingPic.FullScreenHide();

		        $('#details').show();
			}
			else
			{ 
				alert(data.msg);
			}
		});
		
	}
	function op2jia_d(){			
			var m=$('#details .s_num').html();
			m=parseInt(m);//转换格式
			$('.current').find('.s_num').html(m+1);	//修改当前商品的数量
			$('#details .s_num').html(m+1);
			//当前商品的数量
			//var count=$("#f_num").html();//购物车中商品的数量
			
			if($('#details .s_num').html()>0)
			{
				
				$('#details .s_num').show();
				$('#details .op1').show();
				$('.current').find('.s_num').show();
				$('.current').find('.op1').show();
				$('.current').find('.op2').css({'color':'red'});
				$(this).css({'color':'red'});
			}
			//count = parseInt(count);

			//单个商品的数量与块的显示隐藏			
			//$("#f_num").html(count+1);//修改购物车中商品的数量
			var spec_id =$('.current').find('.s_num').attr("value");
		var quantity=$(this).prev(".s_num").html();//当前商品的数量
		var store_id=$("#hd_store_id").val();
         add_to_shop(spec_id, quantity,store_id);
									
		}
		function op1jian_d(){
			var m=$('#details .s_num').html();
			$('.current').find('.s_num').html(m-1);	//修改当前商品的数量
			//var count=$("#f_num").html();//购物车中商品的数量		
			m = parseInt(m);//转换格式
			$('#details .s_num').html(m-1);
			if($('#details .s_num').html()<1){
				$(this).hide();
				$(this).next().hide();
				$(this).next().next().css({'color':'#999'});
				$('.current').find('.s_num').hide();
				$('.current').find('.op1').hide();
				$(".current .op2").css({'color':'#999'});
				}
			//count = parseInt(count);

			//if(m>=0){			
				//document.getElementById("f_num").innerHTML = count-1;//修改购物车中商品的数量
			
			//}
         	var spec_id =$('.current').find('.s_num').attr("value");
		var quantity=$(this).next(".s_num").html();//当前商品的数量
		var store_id=$("#hd_store_id").val();
         add_to_shop(spec_id, quantity,store_id);			
		}
		function showimage()
		{
			$(this).parent().parent().parent().prev().click();
		}
$(document).ready(function(){
	$("img.lazy").lazyload();
    $("img.lazy").lazyload({ threshold : 200 });
	
	//导航栏点击	
	/* 滑动/展开 */
	$(".zq_nav .header").click(function(){
												   
		var arrow = $(this).find("span.arrow");
	//切换图标
		if(arrow.hasClass("up")){
			arrow.removeClass("up");
			arrow.addClass("down");
		}else if(arrow.hasClass("down")){
			arrow.removeClass("down");
			arrow.addClass("up");
		}
	//动画
		$(this).parent().find(".menu").slideToggle();
		
	});
	//当前样式
	$(".li").click(function(){
		$(".zq_nav").find("span").removeClass('selected');
		$(this).find("span").addClass('selected');	
        var cate_id=$(this).attr("value");
		//$("#wangshang").attr("value",$(this).attr("id"));
		val=$(this).attr("id");
        	if($("#"+val).next().size()==0)
			{
			
			 if($("#"+val).parent().parent().next().find(".menu2").size() )
			 {
				$("#wangshang").attr("value",$("#"+val).parent().parent().next().find(".menu2").eq(0).parent().attr("id"));
			 }
			}else{
			
			  $("#wangshang").attr("value",$("#"+val).next().attr("id"));
						
			}
			
		//CommonPerson.Base.LoadingPic.FullScreenShow();
		$("#hd_cateid").val(cate_id);
		$("#hd_pages").val(0);
		$("#hd_status").val(1);
		
		//$.ajaxSettings.async = false;
		
		var store_id=GetQueryString("id");
		if(store_id !=null && store_id.toString().length>1)
		{
		  store_id=GetQueryString("id");
		}
		var url = '/index.php?app=storeyxw&act=get_goodsyxw&cate_id='+cate_id+'&page=0&store_id='+store_id+'';
		
			$.getJSON(url, '', function(data){
			if (data.done)
			{
				 if (data.retval.length > 0)
				 {
						var data  = data.retval;
						var content='';
						for (i = 0; i < data.length; i++)
						{
						content=content+
						'<div class="show" value="'+data[i].spec_id+'">'+
							 '<div class="show_pic" >'+
								'<a href="javascript:void(0)"> <img class="lazy" style="float:left;" src="/'+data[i].default_image+' "/></a>'+
							 '</div>'+                           
							' <div class="t">'+
								' <div class="tt" style="float:left;" >'+
									  '<div class="text"><span class="n2">'+data[i].goods_name+'</span></div>'+
								 '</div>'+
								 '<div>'+
									  '<div id="aaa"><span class="c price">'+data[i].price+'</span><span class="c">元</span> </div>'+
									  '<div ><span style="text-decoration:line-through; color:#999">原价'+data[i].shichang+'元</span></div>'+
									  '<div class="s_op" >'+
											  '<div class="op1" style="float:left;" value="'+data[i].spec_id+'">-</div> '+
										'<div class="s_num" style="font-size:18px;float:left;margin-top: 10px; " id="spec_'+data[i].spec_id+'" value="'+data[i].spec_id+'">0</div>'+
										   '<div class="op2" style="float:right;" value="'+data[i].spec_id+'">+</div> '+                                                          
									  '</div>'+
								 '</div>'+
							   
							 '</div>'+
						
						'</div>';
						}
						
						$(".cont_r #bqmart01").html(content);
						//CommonPerson.Base.LoadingPic.FullScreenHide();
						//$("#hd_sumtouch").val("0");
						$(".show .op2").unbind("click").on('click', addProduct).on('click', op2jia);
						$("#contenter .op1").unbind("click").on('click', op1jian);
						$('.show_pic').unbind("click").on('click', showpic);
						$('.n2').unbind("click").on('click', showimage);
						$('#details .op2').unbind("click").on('click', op2jia_d);
						$('#details .op1').unbind("click").on('click', op1jian_d);
						$(".show .text").width($(window).width()-200);
						$(".s_num").each(function(){
							if($(this).html()<1) 
							{
								$(this).prev(".op1").hide();
								$(this).hide();
							}
							 
						 });
				  $(".xinshuju").html('向上拖动加载数据');	 
				 }else{
				  $(".xinshuju").html('本分类数据加载完毕');
				 }
				// CommonPerson.Base.LoadingPic.FullScreenHide();
				// $("#hd_sumtouch").val("0");
				$("#bqmart01").parent().scrollTop(0);
				 
			}
			else
			{ 
				alert(data.msg);
				//CommonPerson.Base.LoadingPic.FullScreenHide();
               //$("#hd_sumtouch").val("0");
				$(".xinshuju").html('本分类数据加载完毕');
			}
		});	
	});
//数量价格变化

     $(".s_num").each(function(){
		if($(this).html()<1) 
		{
			$(this).prev(".op1").hide();
			$(this).hide();
		}
		 
	 });
	//加
	$(".show .op2").on('click', addProduct).on('click', op2jia);
	//减
  	$("#contenter .op1").on('click', op1jian);
	
	

	var aheight = $(window).height();
	aheight = parseInt(aheight);
	//修改导航栏的高度
	$(".expmenu").innerHeight(aheight-85) ;
	//修改商品列表的高度
	$(".cont_r").innerHeight(aheight-85) ;
	//切换地址，下拉菜单
	$('.pos').click(function(){
		$(this).next('ul').slideToggle(300);
	});
	$('.cha li').click(function(){
		var t = $(this).html();
		$(this).parent().parent().find('span').html(t);
		$(this).parent().hide();
	});
	
	//点击单个商品时
	$('.show_pic').on('click', showpic);
//详情中的加与减
		//加
		$('#details .op2').on('click', op2jia_d);					
		//减
		$('#details .op1').on('click', op1jian_d);
	$('#details .d_pic').click(function(){
		$('#details').hide();
		$(".share").floatdiv({left:"0px",top:"102px"});
		$(".share").hide();
	});
	$('.detail_bg').click(function(){
		$('#details').hide();
		$(".share").floatdiv({left:"0px",top:"102px"});
		$(".share").hide();
	});
	$('.share').click(function(){
		$('#details').hide();
		$(".share").floatdiv({left:"0px",top:"102px"});
		$(".share").hide();
	});




});
function addProduct(event) {
	$("img.u-flyer").remove();
	var offset = $('#end').offset();
	flyer = $('<img class="u-flyer" style="width:20px;height:20px; border-radius:13px 13px 13px 13px;" src="/themes/bqmart/images/1.png"/>');
	flyer.fly({
		start: {
			left: event.pageX,
			top: event.pageY
		},
		end: {
			left: offset.left,
			top: offset.top,
			width: 20,
			height: 20
		}
	});
	}

   function  gosearch()
   {
	       

			   $("#hd_status").val(0);
			  // CommonPerson.Base.LoadingPic.FullScreenShow();

	var cate_id=$("#searchinput").val();
	var ca_length=cate_id.replace(/\s+/g,"").length;
	if(ca_length<2)
	{
		alert("请输入要查询的关键字,字数大于2");
		return false;
	}
		var page_num=parseInt($("#hd_pages").val())+1;
		//alert(page_num);
		//$.ajaxSettings.async = false;
		var store_id=GetQueryString("id");
		if(store_id !=null && store_id.toString().length>1)
		{
		  store_id=GetQueryString("id");
		}
		var url = '/index.php?app=storeyxw&act=get_bykey&keywords='+cate_id+'&store_id='+store_id+'';
	 
			$.getJSON(url, '', function(data){
			if (data.done)
			{
			
				 if (data.retval.length > 0)
				 {
				 //alert(data.retval.length);
				 $("#hd_pages").val(parseInt($("#hd_pages").val())+1);
						var data  = data.retval;
						var content='';
						for (i = 0; i < data.length; i++)
						{
						content=content+
						'<div class="show" value="'+data[i].spec_id+'">'+
							 '<div class="show_pic" >'+
								'<a href="javascript:void(0)"> <img class="lazy" style="float:left;" src="/'+data[i].default_image+' "/></a>'+
							 '</div>'+                           
							' <div class="t">'+
								' <div class="tt" style="float:left;" >'+
									  '<div class="text"><span class="n2">'+data[i].goods_name+'</span></div>'+
								 '</div>'+
								 '<div>'+
									  '<div id="aaa"><span class="c price">'+data[i].price+'</span><span class="c">元</span> </div>'+
									  '<div ><span style="text-decoration:line-through; color:#999">原价'+data[i].shichang+'元</span></div>'+
									  '<div class="s_op" >'+
											  '<div class="op1" style="float:left;" value="'+data[i].spec_id+'">-</div> '+
										'<div class="s_num" style="font-size:18px;float:left;margin-top: 10px; " id="spec_'+data[i].spec_id+'"  value="'+data[i].spec_id+'">0</div>'+
										   '<div class="op2" style="float:right;" value="'+data[i].spec_id+'">+</div> '+                                                          
									  '</div>'+
								 '</div>'+
							   
							 '</div>'+
						
						'</div>';
						if(i==data.length-1)
						{
						 $("#hd_status").val(1);
						}
						}
						
						$(".cont_r #bqmart01").html(content);
						content=null;
						//CommonPerson.Base.LoadingPic.FullScreenHide();
						//$("#hd_sumtouch").val("0");
						
						$(".show .op2").unbind("click").on('click', addProduct).on('click', op2jia);
						$("#contenter .op1").unbind("click").on('click', op1jian);
						$('.show_pic').unbind("click").on('click', showpic);
						$('.n2').unbind("click").on('click', showimage);
						$('#details .op2').unbind("click").on('click', op2jia_d);
						$('#details .op1').unbind("click").on('click', op1jian_d);
						$(".show .text").width($(window).width()-200);
						$(".s_num").each(function(){
							if($(this).html()<1) 
							{
								$(this).prev(".op1").hide();
								$(this).hide();
							}
							 
						 });
					 $(".xinshuju").html('');	
            document.getElementById('searchbox').style.display='none';
            document.getElementById('bg_wn').style.display='none';
			int_j=0;					 
				 }else{
				  $(".xinshuju").html('没有数据加载');
				 }
				// CommonPerson.Base.LoadingPic.FullScreenHide();
				// $("#hd_sumtouch").val("0");
				
				 
			}
			else
			{ 
				alert(data.msg);
				//CommonPerson.Base.LoadingPic.FullScreenHide();
               //$("#hd_sumtouch").val("0");
				 $(".xinshuju").html('没有数据加载');
			}
		});	
			
   }