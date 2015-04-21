<?php
	 function copy()
    {
		set_time_limit(300);
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		$num = empty($_GET['num']) ? 1 : intval($_GET['num']);
		$user_mod =& m('member');
		$user = $user_mod->get_info($user_id);
		
		for($i=1;$i<=$num;$i++){
			//复制用户信息
			$sql = "SELECT user_name FROM " . DB_PREFIX ."member where user_id='{$id}'";
			$uname = $user_mod->getOne($sql);
			$uname = 'bq' . rand(1,10000);
			$sql = "INSERT INTO " . DB_PREFIX ."member(user_name,email,password,real_name,gender,birthday,phone_tel,phone_mob,im_qq,im_msn,im_skype,im_yahoo,im_aliww,reg_time,last_login,last_ip,logins,ugrade,portrait,outer_id,activation,feed_config) SELECT '{$uname}',email,password,real_name,gender,birthday,phone_tel,phone_mob,im_qq,im_msn,im_skype,im_yahoo,im_aliww,reg_time,last_login,last_ip,logins,ugrade,portrait,outer_id,activation,feed_config FROM " . DB_PREFIX ."member where user_id='{$id}'";
			$user_mod->db->query($sql);
			$sql = "select @@IDENTITY;";
			$uid = $user_mod->getOne($sql);
			
			//复制店铺信息
			$sql = "INSERT INTO " . DB_PREFIX ."store(store_id,store_name,owner_name,owner_card,region_id,region_name,address,zipcode,tel,sgrade,apply_remark,credit_value,praise_rate,domain,state,close_reason,add_time,end_time,certification,sort_order,recommended,theme,store_banner,store_logo,description,image_1,image_2,image_3,im_qq,im_ww,im_msn,enable_groupbuy,enable_radar) SELECT '{$uid}',store_name,owner_name,owner_card,region_id,region_name,address,zipcode,tel,sgrade,apply_remark,credit_value,praise_rate,domain,state,close_reason,add_time,end_time,certification,sort_order,recommended,theme,store_banner,store_logo,description,image_1,image_2,image_3,im_qq,im_ww,im_msn,enable_groupbuy,enable_radar FROM " . DB_PREFIX ."store where store_id='{$id}'";
			$user_mod->db->query($sql);			
			
			//复制支付方式
			$sql = "INSERT INTO " . DB_PREFIX ."payment(store_id,payment_code,payment_name,payment_desc,config,is_online,enabled,sort_order) SELECT '{$uid}',payment_code,payment_name,payment_desc,config,is_online,enabled,sort_order FROM " . DB_PREFIX ."payment where store_id='{$id}'";
			$user_mod->db->query($sql);			
			
			//复制上传文件
			$sql = "INSERT INTO " . DB_PREFIX ."uploaded_file(store_id,file_type,file_size,file_name,file_path,add_time,belong,item_id) SELECT '{$uid}',file_type,file_size,file_name,file_path,add_time,belong,item_id FROM " . DB_PREFIX ."uploaded_file where store_id='{$id}'";
			$user_mod->db->query($sql);   //复制上传文件存在问题 item_id是之前商品的id，不是复制后的商品id
			
			//复制店铺权限
			$sql = "INSERT INTO " . DB_PREFIX ."user_priv(user_id,store_id,privs) SELECT '{$uid}','{$uid}',privs FROM " . DB_PREFIX ."user_priv where store_id='{$id}'";
			$user_mod->db->query($sql);
	
			//复制商品信息
			$sql = "select goods_id from " . DB_PREFIX ."goods where store_id='{$id}'";
			$gid = $user_mod->getAll($sql);
			
			foreach($gid as $ggid){
				$gggid = $ggid['goods_id'];
				$sql = "INSERT INTO " . DB_PREFIX ."goods(store_id,type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags) SELECT '{$uid}',type,goods_name,description,cate_id,cate_name,brand,spec_qty,spec_name_1,spec_name_2,if_show,closed,close_reason,add_time,last_update,default_spec,default_image,recommended,cate_id_1,cate_id_2,cate_id_3,cate_id_4,price,tags FROM " . DB_PREFIX ."goods where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
				$sql = "select @@IDENTITY;";
				$gnid = $user_mod->getOne($sql);
				
				/*更新图片地址*/
				$img=$user_mod->getOne("SELECT default_image FROM ". DB_PREFIX ."goods where goods_id='{$gggid}'");
				$new_img=str_replace("/store_{$id}/goods_{$g}/","/store_{$uid}/goods_{$gnid}/",$img);
				$fso= new CopyFile($img,$new_img);
				$user_mod->db->query("UPDATE ". DB_PREFIX ."goods SET default_image='{$new_img}' where goods_id='{$gnid}'");
				
				$images=$user_mod->getAll("select * FROM " . DB_PREFIX ."goods where goods_id='{$gggid}'");
				foreach($images as $v){
					$img=$v['image_url'];
					$thumb=$v['thumbnail'];
					$new_img=str_replace("/store_{$id}/goods_{$gggid}/","/store_{$uid}/goods_{$gnid}/",$img);
					$new_thumb=str_replace("/store_{$id}/goods_{$gggid}/","/store_{$uid}/goods_{$gnid}/",$thumb);
					$fso->copyFile($img,$new_img);
					$fso->copyFile($thumb,$new_thumb);
					$file_id=$user_mod->getOne("SELECT file_id FROM ".DB_PREFIX."uploaded_file WHERE store_id={$uid} AND file_path='{$img}'");
					
					/*更新商品图片表*/
					$sql = "INSERT INTO " . DB_PREFIX ."goods_image(goods_id,image_url,thumbnail,sort_order,file_id) VALEUS ('{$gnid}','{$new_img}','{$new_thumb}','{$v['sort_order']}','{$file_id}')";
					$user_mod->db->query($sql);
					
					/*更新上传文件表*/
					$sql="UPDATE ".DB_PREFIX."uploaded_file SET file_path='{$new_img}',item_id='{$gnid}' WHERE file_id={$file_id}";
					$user_mod->db->query($sql);
				}
				/*
				$sql = "INSERT INTO " . DB_PREFIX ."goods_image(goods_id,image_url,thumbnail,sort_order,file_id) SELECT '{$gnid}',image_url,thumbnail,sort_order,file_id FROM " . DB_PREFIX ."goods_image where goods_id in (select goods_id FROM " . DB_PREFIX ."goods where goods_id='{$gggid}')";
				$user_mod->db->query($sql);
				*/
				$sql = "INSERT INTO " . DB_PREFIX ."goods_spec(goods_id,spec_1,spec_2,color_rgb,price,stock,sku) SELECT '{$gnid}',spec_1,spec_2,color_rgb,price,stock,sku FROM " . DB_PREFIX ."goods_spec where goods_id='{$gggid}'";

				$user_mod->db->query($sql);
				$sql = "INSERT INTO " . DB_PREFIX ."goods_statistics(goods_id,views,collects,carts,orders,sales,comments) SELECT '{$gnid}',views,collects,carts,orders,sales,comments FROM " . DB_PREFIX ."goods_statistics where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
				$sql = "INSERT INTO " . DB_PREFIX ."category_goods(cate_id,goods_id) SELECT cate_id,'{$gnid}' FROM " . DB_PREFIX ."category_goods where goods_id='{$gggid}'";
				$user_mod->db->query($sql);
			}
			
			
			//复制店铺分类
			$sql = "select cate_id from " . DB_PREFIX ."gcategory where store_id='{$id}' and parent_id='0'";
			$cateid = $user_mod->getAll($sql);
			
			foreach($cateid as $ccateid){
				$cccateid = $ccateid['cate_id'];
				$sql = "INSERT INTO " . DB_PREFIX ."gcategory(store_id,cate_name,parent_id,sort_order,if_show) SELECT '{$uid}',cate_name,parent_id,sort_order,if_show FROM " . DB_PREFIX ."gcategory where cate_id='{$cccateid}'";
				$user_mod->db->query($sql);
				$sql = "select @@IDENTITY;";
				$cnid = $user_mod->getOne($sql);
				//更新商品cateid 大类
				$sql = "update " . DB_PREFIX ."category_goods set cate_id='{$cnid}' where cate_id='{$cccateid}' and goods_id in(select goods_id from " . DB_PREFIX ."goods where store_id={$uid})";
				$user_mod->db->query($sql);
				
				//更新商品cateid 小类
				$sql = "select cate_id from " . DB_PREFIX ."gcategory where store_id='{$id}' and parent_id='{$cccateid}'";
				$xcateid = $user_mod->getAll($sql);
				foreach($xcateid as $cxcateid){
					$ccxcateid = $cxcateid['cate_id'];
					$sql = "INSERT INTO " . DB_PREFIX ."gcategory(store_id,cate_name,parent_id,sort_order,if_show) SELECT '{$uid}',cate_name,'{$cnid}',sort_order,if_show FROM " . DB_PREFIX ."gcategory where cate_id='{$ccxcateid}'";
					$user_mod->db->query($sql);
					$sql = "select @@IDENTITY;";
					$cxnid = $user_mod->getOne($sql);
					
					$sql = "update " . DB_PREFIX ."category_goods set cate_id='{$cxnid}' where cate_id='{$ccxcateid}' and goods_id in(select goods_id from " . DB_PREFIX ."goods where store_id={$uid})";
					$user_mod->db->query($sql);
				}
			}
		}
		$this->show_message('copyok');
	}
	
	

?>