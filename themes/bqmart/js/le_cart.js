	//������Ʒ
	function cartjia(){
		var n=$(this).prev(".s_num").html();//��ǰ��Ʒ������
        n = parseInt(n);//ת����ʽ
		$("#details .s_num").html(n+1);	//�޸������е�����	
        $(this).prev(".s_num").html(n+1);//�޸ĵ�ǰ��Ʒ������
	   n=$(this).prev(".s_num").html();//��ǰ��Ʒ������
	   //var count=$("#f_num").html();//���ﳵ����Ʒ������
	  // count = parseInt(count);
	  // document.getElementById("f_num").innerHTML = count+1;//�޸Ĺ��ﳵ����Ʒ������
		if(n>0)
		{			
			$(this).css({'color':'red'});		
			//��ʾ
			$(this).prev(".s_num").show();
			$(this).prev(".s_num").prev(".op1").show();
			$("#details").find(".op1").show();
			$("#details").find(".s_num").show();
			$("#details").find(".op2").css({'color':'red'});
		}
		var spec_id =$(this).parent().children('.s2').val();
		var quantity=$(this).prev(".s_num").html();//��ǰ��Ʒ������
		var store_id=$(this).parent().children('.s1').val();
		//alert(spec_id+"-"+store_id);
         add_to_shop(spec_id, quantity,store_id);
	  }
	//������Ʒ
		function cartjian(){
		
		var n=$(this).next(".s_num").html();//��ǰ��Ʒ������
		n = parseInt(n);//ת����ʽ
		$(this).next(".s_num").html(n-1);//�޸ĵ�ǰ��Ʒ������
		$("#details").find(".s_num").html(n-1);
		n=$(this).next(".s_num").html();//��ǰ��Ʒ������
		//var count=$("#f_num").html();//���ﳵ����Ʒ������
		//count = parseInt(count);
		//document.getElementById("f_num").innerHTML = count-1;//�޸Ĺ��ﳵ����Ʒ������
		var spec_id =$(this).parent().children('.s2').val();
		var rec_id =$(this).parent().children('.s1').attr('rid');
		var quantity=$(this).next(".s_num").html();//��ǰ��Ʒ������
		var store_id=$(this).parent().children('.s1').val();
		//alert(rec_id);
        add_to_shop(spec_id, quantity,store_id);
		if(n<1){
			//����
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