<?php

/**
 *    购物车控制器，负责会员购物车的管理工作，她与下一步售货员的接口是：购物车告诉售货员，我要买的商品是我购物车内的商品
 *
 *    @author    Garbin
 */

class CartyxwApp extends MallbaseApp
{
    /**
     *    列出购物车中的商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function index()
    {
       if(isset($_SESSION['store_id']))
	   {
		   if(intval($_SESSION['store_id'])>0)
		   {
			  header('Location:index.php?app=storeyxw&status=1&id=' . intval($_SESSION['store_id']));
			  exit;
		   }
	   }
	   header('Location:index.php');
    }
	
	

}

?>
