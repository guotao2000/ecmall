// JavaScript Document
$(document).ready(function(e) {
	//文本框 鼠标点击时
    $(".zq_input").eq(1).mousedown(function(){
	var str=$(this).val();
	if(str=="请输入红包编号"){
		$(this).val("");
		}	
	});
	//文本框 鼠标点击时
    $(".zq_input").eq(2).mousedown(function(){
	var str=$(this).val();
	if(str=="请填写备注信息"){
		$(this).val("");
		}	
	});
	//鼠标离开时
$(".zq_input").eq(1).mouseleave(function(){
	var str=$(this).val();
	if(str==""){
		$(this).val("请输入红包编号");
		}

	})
	//鼠标离开时
$(".zq_input").eq(2).mouseleave(function(){
	var str=$(this).val();
	if(str==""){
		$(this).val("请填写备注信息");
		}

	})

	$(".link").click(function(){
	var s=$(this).find(".goods_anjian");
	if(s.hasClass("down")){
		s.removeClass("down");
		s.addClass("up");
		}else if(s.hasClass("up")){
			s.removeClass("up");
			s.addClass("down");
			
			}
	})
	
//支付方式
$(".zq_payment").each(function(){
	$(this).click(function(){
		var id=$(this).find("input").attr("id");
	$(".zq_payment").find("input").removeAttr("checked");
	$(this).find("input").attr("checked","checked");
	  if($(this).find("input").attr("checked")=="checked"){
		$(".zq_img").css("display","none");
     	$(this).find(".zq_img").css("display","block");
		
   }
		
		
	});
	
	
});
$(".new li ").click(function(){
	$(".new li span").find("img").css("display","none");
	$(this).find("img").css("display","block");
	
	});
$(".zq_payment").find("input").eq(0).click();	
	
});

