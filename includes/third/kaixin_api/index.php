<?php

/**
 * @file
 * User has successfully authenticated with Kaixin. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('kxoauth/kxClient.php');

/* Get user access tokens out of the session. */

$access_token = '';
if(array_key_exists('access_token', $_SESSION))
{
	$access_token = $_SESSION['access_token'];
}
else 
{

}

/* Create a KaixinOauth object with consumer/user tokens. */
$connection = new KXClient($access_token);

/* If method is set change API call made. Test is called by default. */
$example2 = $connection->users_me();

$go_url="/index.php?app=third_login&act=kaixin_callback&kaixin_token="
.$_SESSION['keys']['oauth_token']."&kaixin_token_secret=".
$_SESSION['keys']['oauth_token_secret']."&kaixin_email="
.$_SESSION['email']."&kaixin_nickname=".urlencode($example2['response']->name);

header("location:$go_url");
exit();
?>