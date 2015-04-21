<?php

/* 店铺控制器 */
class Store_copygoodsApp extends BackendApp
{
	function copygoods()
	{
		//复制商品信息
			$sql = "select goods_id from " . DB_PREFIX ."goods where store_id='{$id}'";
			$gid = $user_mod->getAll($sql);
			
			foreach($gid as $ggid){
				$gggid = $ggid['goods_id'];
				$sql = "INSERT INTO " . DB_PREFIX ."goods(store_id,type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags,from_goods_id) SELECT '{$uid}',type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags,goods_id FROM " . DB_PREFIX ."goods where goods_id='{$gggid}'";

				$user_mod->db->query($sql);
				$sql = "select @@IDENTITY;";
				$gnid = $user_mod->getOne($sql);
				
				/*$sql = "INSERT INTO " . DB_PREFIX ."goods_image(goods_id,image_url,thumbnail,sort_order,file_id) SELECT '{$gnid}',image_url,thumbnail,sort_order,file_id FROM " . DB_PREFIX ."goods_image where goods_id in (select goods_id FROM " . DB_PREFIX ."goods where goods_id='{$gggid}')";
				$user_mod->db->query($sql);*/
				$sql = "INSERT INTO " . DB_PREFIX ."goods_spec(goods_id,spec_1,spec_2,color_rgb,price,stock,sku) SELECT '{$gnid}',spec_1,spec_2,color_rgb,price,stock,sku FROM " . DB_PREFIX ."goods_spec where goods_id='{$gggid}'";
				$user_mod->db->query($sql);

				$sql = "select @@IDENTITY;";
				$specid = $user_mod->getOne($sql);

				$user_mod->db->query("UPDATE ". DB_PREFIX ."goods SET default_spec={$specid} WHERE goods_id={$gnid}");

				$sql = "INSERT INTO " . DB_PREFIX ."goods_statistics(goods_id,views,collects,carts,orders,sales,comments) SELECT '{$gnid}',views,collects,carts,orders,sales,comments FROM " . DB_PREFIX ."goods_statistics where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
				$sql = "INSERT INTO " . DB_PREFIX ."category_goods(cate_id,goods_id) SELECT cate_id,'{$gnid}' FROM " . DB_PREFIX ."category_goods where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
			}
	}
    	
}

?>
