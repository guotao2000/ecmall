<?php

/* load library. */
require_once('kxoauth/kxClient.php');


/* Build KXOAuth object with client credentials. */
$connection = new KXClient();
	
$scope = 'create_records create_album user_photo friends_photo upload_photo';
		
$opt = $_GET['opt'];
if(!empty($opt))
{
	if(3 == $opt)
	{
		$username = "";
		$password = "";
		$response =  $connection->getAccessTokenFromPassword($username,$password,$scope);
		var_dump($response); 
		if(isset($response->access_token))
		{
			session_start();
			$_SESSION['access_token'] =	$response->access_token;
			$_SESSION['refresh_token'] = $response->refresh_token;
			header("Location:index.php");
		}
	}
	elseif (4 == $opt)
	{	
		session_start();
		print_r($_SESSION);
		$response =  $connection->getAccessTokenFromRefreshToken($_SESSION['refresh_token'],$scope);
		var_dump($response); 
		if(isset($response->access_token))
		{
			$_SESSION['access_token'] =	$response->access_token;
			$_SESSION['refresh_token'] = $response->refresh_token;
			header("Location:index.php");
		} 
	}
}

header("Location:".$connection->getAuthorizeURL('code',$scope));
?>
