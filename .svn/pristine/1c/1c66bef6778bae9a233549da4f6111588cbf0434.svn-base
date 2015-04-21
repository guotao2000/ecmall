<?php
session_start();
include_once('config.php');
include_once('api/tblog.class.php');

$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
$request_token = $oauth->getRequestToken();

//echo "Request Token: ".$request_token['oauth_token'];
//echo "<br>";
//echo "Request Token Secret: ".$request_token['oauth_token_secret'];

$aurl = $oauth->getAuthorizeURL( $request_token['oauth_token'], "http://".$_SERVER['HTTP_HOST'].'/includes/third/163_api/callback.php');
$_SESSION['request_token'] = $request_token;

header("location:$aurl");
exit();
?>