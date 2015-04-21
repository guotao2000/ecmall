	//增加商品
	function cartjia(){
		var n=$(this).prev(".s_num").html();//当前商品的数量
        n = parseInt(n);//转换格式
		$("#details .s_num").html(n+1);	//修改详情中的数量	
        $(this).prev(".s_num").html(n+1);//修改当前商品的数量
	   n=$(this).prev(".s_num").html();//当前商品的数量
	   //var count=$("#f_num").html();//购物车中商品的数量
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
		var spec_id =$(this).parent().children('.s2').val();
		var quantity=$(this).prev(".s_num").html();//当前商品的数量
		var store_id=$(this).parent().children('.s1').val();
		//alert(spec_id+"-"+store_id);
         add_to_shop(spec_id, quantity,store_id);
	  }
	//减少商品
		function cartjian(){
		
		var n=$(this).next(".s_num").html();//当前商品的数量
		n = parseInt(n);//转换格式
		$(this).next(".s_num").html(n-1);//修改当前商品的数量
		$("#details").find(".s_num").html(n-1);
		n=$(this).next(".s_num").html();//当前商品的数量
		//var count=$("#f_num").html();//购物车中商品的数量
		//count = parseInt(count);
		//document.getElementById("f_num").innerHTML = count-1;//修改购物车中商品的数量
		var spec_id =$(this).parent().children('.s2').val();
		var rec_id =$(this).parent().children('.s1').attr('rid');
		var quantity=$(this).next(".s_num").html();//当前商品的数量
		var store_id=$(this).parent().children('.s1').val();
		//alert(rec_id);
        add_to_shop(spec_id, quantity,store_id);
		if(n<1){
			//隐藏
			$(this).next(".s_num").hide();
			$(this).hide();
			$(this).next(".s_num").next(".op2").css({'color':'#999'});
			$("#details").find(".op1").hide();
			$("#details").find(".s_num").hide();
			$("#details").find(".op2").css({'color':'#999'});
			$("#cart_item_"+rec_id).remove();
			//location=location;
			
		}	
        
	
			
	}