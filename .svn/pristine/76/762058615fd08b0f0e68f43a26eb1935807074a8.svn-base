<?php

	//计算商品总价（根据店铺store_id)
	function total($store_id)
	{
       $db=&db();
	 //1、清空sessionid，store_id对应的促销商品销售表
	   $sql_cxspxs="delete from ecm_promotion_sale where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
	   $db->query($sql_cxspxs);
	 //2、用购物车商品数量还原购物车的剩余数量，
	   $sql_upcart="update ecm_cart set remains=quantity  where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
	   $db->query($sql_upcart);
	 //3、遍历所有满足的促销，分别取判断组合A和组合B是否满足
	   $cart_model =& m('cart');

		$cart_items      =  $cart_model->find(array(
			'conditions' => " store_id = {$store_id} AND session_id='" . SESS_ID . "'",
			'join'       => 'belongs_to_goodsspec',
		));
		if (empty($cart_items))
		{
			return false;
		}
		$string_cuxiaoids=array();
		foreach ($cart_items as $rec_id => $goods)
		{
			 $arr_ids=explode(",", $goods['cuxiao_ids']);
			 foreach ($arr_ids as $value) {
				 if(!empty( $value)){
				  $string_cuxiaoids[]= $value;  //拼接所有的促销id
				 }
				}
		 }
		
	
		$arr_cuxiaoids=array_unique($string_cuxiaoids);//array_filter(explode(",",array_unique($string_cuxiaoids)),array($this,"myfunction"));
		
	//按照权重排序
	  $arr_cuxiaoids= $this-> weight_order($db,$arr_cuxiaoids);
	  //将促销id进行分类，筛选组合，满赠，满减
	  for($j=0;$j<count($arr_cuxiaoids);$j++)
		{
		
	       $string_type="select p_type from ecm_promotion where  p_id=".$arr_cuxiaoids[$j];
	       $rows_type= $db->getAll($string_type);
	       if(!count($rows_type))
	       {
               continue;
	       }
	       
	       switch ($rows_type[0])
			{
			case 1:
			$arr_cuxiaoidsa[]=$rows_type[0];//组合促销
			break;  
			case 2:
			$arr_cuxiaoidsb[]=$rows_type[0];//满赠
			break;
			case 3:
			$arr_cuxiaoidsc[]=$rows_type[0];//满减
			break;
			default:
			break;
			}

	    }
	


	 //计算组合促销
	 $cart_items= $this->zuhe($arr_cuxiaoidsa,$cart_items,$db,$store_id );
	 //计算满赠
	 $cart_items= $this->manzeng($arr_cuxiaoidsb,$cart_items,$db,$store_id);
	//计算总价和满减

	return $this-> total($arr_cuxiaoidsc,$cart_items,$db,$store_id);
    }

    //计算组合促销
    function zuhe($arr_cuxiaoids,$cart_items,$db,$store_id )
    {
    	 //4、在遍历算法内，将满足促销的商品数量从购物车减去插入促销商品表内。
		for($j=0;$j<count($arr_cuxiaoids);$j++)
		{
			
			$bool_a=0;
			
			$agoods_id=array();//存放符合条件的goods_id
			$anum=array();//存放符合条件的num数量
			$sql_state="select * from ecm_promotion where p_id=".$arr_cuxiaoids[$j]." and ‘state’=3 and (unix_timestamp() between  start_time and end_time )";
		   $get_state=$db->getAll($sql_state)[0];
		   
			if(empty($get_state))
			{
				continue;
			}
			$sql_a="select * from ecm_promotion_goods where  p_id=".$arr_cuxiaoids[$j];
			$que1=$db->getAll($sql_a);
			for($i=0;$i<count($que1);$i++)
			{
			   //判断商品组单品是否满足促销需求
				if( $this->cart_num($cart_items,$que1[$i]['goods_id'],$que1[$i]['quantity']))
				{
					 $bool_a++;
				}

			}
		
		  
			if($bool_a==count($que1))
			{
			 //5、遍历此促销的所有商品，更新购物车商品数
			   for($i=0;$i<count($que1);$i++)
				{
		
				  $cart_items=$this->cart_remain($db,$cart_items,$que1[$i]['goods_id'],$que1[$i]['quantity'],$que1[$i]['p_id'],$que1[$i]['price'],$store_id);
				}
			}

		}

		return $cart_items;
    }
    //计算满赠
    function manzeng($arr_cuxiaoids,$cart_items,$db,$store_id )
    {
       //判断满赠条件
         
       //4、在遍历算法内，将满足促销的商品数量从购物车减去插入促销商品表内。
		for($j=0;$j<count($arr_cuxiaoids);$j++)
		{
			
			$bool_a=0;
			
			$agoods_id=array();//存放符合条件的goods_id
			$anum=array();//存放符合条件的num数量
			$sql_state="select * from ecm_promotion where p_id=".$arr_cuxiaoids[$j]." and ‘state’=3 and (unix_timestamp() between  start_time and end_time )";
		   $get_state=$db->getAll($sql_state)[0];
		   if(empty($get_state))
			{
				continue;
			}
		   //判断购物车中剩余商品总价是否满足购买条件
		   //  1.筛选分类
			$conditions="";
			if(!intval($get_state['allow_cates']))
			{
               $conditions="where a.store_id = {$store_id} AND a.session_id='" . SESS_ID . "' ";
			}else
			{
				 $s_cates= implode(",", array_filter(explode(",",$get_state['allow_cates'])));
				$conditions="where a.store_id = {$store_id} AND a.session_id='" . SESS_ID . "' and b.cate_id_1 in(".$s_cates.") or b.cate_id_2 in(".$s_cates.") or b.cate_id_3 in(".$s_cates.") or b.cate_id_4 in(".$s_cates.")";
			}
          $string_cart="SELECT a.* from ecm_cart a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id ".$conditions;
          $row_cart=$db->getAll($string_cart);

		   //  2.判断价格
            $total_count=0;
            foreach ($row_cart as $key=>$value)//$value是购物车单项
			{
			  $total_count+=  $value["price"]*$value["remains"];
			}
			if(!($total_count>=$get_state['g_amount']))
			{
				continue;
			}

			
			$sql_a="select * from ecm_promotion_goods where  p_id=".$arr_cuxiaoids[$j];
			$que1=$db->getAll($sql_a);
			for($i=0;$i<count($que1);$i++)
			{
			   //判断商品A组单品是否满足促销需求
				if( $this->cart_num($cart_items,$que1[$i]['goods_id'],$que1[$i]['quantity']))
				{
					 $bool_a++;
				}

			}
		
		  
			if($bool_a==count($que1))
			{
			 //5、遍历此促销的所有商品，更新购物车商品数
			   for($i=0;$i<count($que1);$i++)
				{
		
				  $cart_items=$this->cart_remain($db,$cart_items,$que1[$i]['goods_id'],$que1[$i]['quantity'],$que1[$i]['p_id'],$que1[$i]['price'],$store_id);
				}
			}

		}
        return $cart_items;
    }
    //满减
    function manjian($arr_cuxiaoids,$cart_items,$db,$store_id,$total_count)
    {
    	$linshi=$total_count;
    	for($j=0;$j<count($arr_cuxiaoids);$j++)
		{
			
			$bool_a=0;
			
			$agoods_id=array();//存放符合条件的goods_id
			$anum=array();//存放符合条件的num数量
			$sql_state="select * from ecm_promotion where p_id=".$arr_cuxiaoids[$j]." and ‘state’=3 and (unix_timestamp() between  start_time and end_time )";
		   $get_state=$db->getAll($sql_state)[0];
		   if(empty($get_state))
			{
				continue;
			}
		   //判断购物车中剩余商品总价是否满足购买条件
		   //  1.筛选分类
			$conditions="";
			if(!intval($get_state['allow_cates']))
			{
               $conditions="where a.store_id = {$store_id} AND a.session_id='" . SESS_ID . "' ";
			}else
			{
				 $s_cates= implode(",", array_filter(explode(",",$get_state['allow_cates'])));
				$conditions="where a.store_id = {$store_id} AND a.session_id='" . SESS_ID . "' and b.cate_id_1 in(".$s_cates.") or b.cate_id_2 in(".$s_cates.") or b.cate_id_3 in(".$s_cates.") or b.cate_id_4 in(".$s_cates.")";
			}
          $string_cart="SELECT a.* from ecm_cart a LEFT JOIN ecm_goods b on a.goods_id=b.goods_id ".$conditions;
          $row_cart=$db->getAll($string_cart);

		   //  2.判断价格
            $total_count=0;
            foreach ($row_cart as $key=>$value)//$value是购物车单项
			{
			  $total_count+=  $value["price"]*$value["remains"];
			}
			if(!($linshi>=$get_state['g_amount']))
			{
				continue;
			}
			
			$linshi=$linshi-$get_state['g_amount'];
			
			$total_count=$total_count-$get_state['discount'];
		}
		return $total_count;
    }
	//计算总价
	function total($arr_cuxiaoids,$cart_items,$db,$store_id)
	{
		//计算购物车总价
		$total_count=0;
		$string_cart="select * from ecm_cart where store_id = {$store_id} AND session_id='" . SESS_ID . "' and remains>0";
		$arr_cart=$db->getAll($string_cart);
		foreach ($arr_cart as $key=>$value)//$value是购物车单项
		{
		  $total_count+=  $value["price"]*$value["remains"];
		}

		//计算满减
        $total_count=$this->manjian($arr_cuxiaoids,$cart_items,$db,$store_id,$total_count);
		//echo $total_count;
		//计算促销商品销售总价
		$string_promotion="select * from ecm_promotion_sale where store_id = {$store_id} AND session_id='" . SESS_ID . "'";
		$arr_promotion=$db->getAll($string_promotion);
		foreach ($arr_promotion as $key=>$value)//$value是购物车单项
		{
		  $total_count+=  $value["sale_price"]*$value["sale_num"];
		}
		// echo $total_count;
		 //返回总价
		 return $total_count;
		

	 }
	//权重排序
	function weight_order($db,$arr_cuxiaoids)
	{
		
	 $string_in="select p_id from ecm_promotion where p_id in (". implode(",",$arr_cuxiaoids).") order by weight desc";
	 $arr_idrows= $db->getAll($string_in);
		$i=0;
		foreach($arr_idrows as $key=>$value)
		{
			$arr_ids[$i]=$value['p_id'];
			$i++;
		}

	 return $arr_ids;
	}

    //更新购物车相应商品的remains字段值,$goods_id促销商品里的商品id，$num促销商品里的促销商品数量
	function cart_remain($db,$cart_items,$goods_id,$num,$promotion_id,$promotion_price,$store_id)
	{
		
		foreach ($cart_items as $key=>$value)//$value是购物车单项
		{
			
			if($value["goods_id"]==$goods_id&&$value["remains"]>=$num)
			{
				$value["remains"]=$value["remains"]-$num;
				$string_update="update ecm_cart set remains=remains-".$num." where  store_id = {$store_id} AND session_id='" . SESS_ID . "' and goods_id={$goods_id};";
				$db->query($string_update);
				$string_insert="insert into ecm_promotion_sale(promotion_id,goods_id,goods_sn,goods_name,sale_price,sale_num,user_id,session_id,sale_flag,store_id) values( {$promotion_id} ,{$goods_id} ,'{$value['sku']}','{$value['goods_name']}',{$promotion_price},{$num},{$value['user_id']},'" . SESS_ID . "',0,{$store_id})";
			
		//	echo $string_update.$string_insert;
				 $db->query($string_insert);
			  
				return $cart_items;
			}
		}
		return $cart_items;

	}
   //查找购物车指定商品的数量
	function cart_num($cart_items,$goods_id,$num)
	{
	   foreach ($cart_items as $key=>$value)
		{
			 if($value["goods_id"]==$goods_id&&$value["remains"]>=$num)
			{
				return true;
			}
		}
		return false;
	}
?>