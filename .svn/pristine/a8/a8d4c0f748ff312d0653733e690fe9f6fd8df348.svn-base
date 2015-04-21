<?php
session_start();
include_once('config.php');
include_once('api/tblog.class.php');

$oauth = new OAuth( CONSUMER_KEY, CONSUMER_SECRET , $_SESSION['request_token']['oauth_token'] , $_SESSION['request_token']['oauth_token_secret']  );

if ($access_token = $oauth->getAccessToken(  $_REQUEST['oauth_token'] ) )
{
	$tblog = new TBlog(CONSUMER_KEY, CONSUMER_SECRET , $access_token['oauth_token'] , $access_token['oauth_token_secret']);
	$me = $tblog->verify_credentials();
	
	$go_url="/index.php?app=third_login&act=wangyi_callback&wangyi_token="
	.$access_token['oauth_token']."&wangyi_token_secret=".
	$access_token['oauth_token_secret']."&wangyi_email="
	.$me['email']."&wangyi_nickname=".urlencode($me['name']);
	
	header("location:$go_url");
	exit();
}
else
{
    exit("not get user info.");
}
?>