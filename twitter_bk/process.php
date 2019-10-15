<?php
session_start();
include_once("config.php");
include_once("inc/twitteroauth.php");
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

include('../business_owner/class/business_owner.php');
include('../business_owner/class/form.php');
$db = new business_owner();
$db->connect();
if (isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {

	// if token is old, distroy any session and redirect user to index.php
	session_destroy();
	header('Location: ./index.php');
	
}elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {

	// everything looks good, request access token
	//successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($connection->http_code=='200')
	{
		//redirect user to twitter
		
		$_SESSION['status'] = 'verified';
		$_SESSION['request_vars'] = $access_token;
		
		
		$db->select('user_register','*',NULL,'name="'.$_SESSION['request_vars']['screen_name'].'" and r_id="2"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$rows = $db->numRows();
		
		//User not existed
		if($rows<=0)
		{
			$name = $_SESSION['request_vars']['screen_name'];
			$userid = $_SESSION['request_vars']['user_id'];
			$db->insert('user_register',array('r_id'=>'2','name'=>$name,'twitter_id'=>$userid,'status'=>'Active','activation_key'=>''));  // Table name, column names and respective values
			$res = $db->getResult();
			if($res>0)
			{
				$_SESSION['id'] = $res[0];
				$_SESSION['username'] = $name;
			}	
		}
		if($rows>0)
		{
			$res = $db->getResult();
			$_SESSION['id'] = $res[0]['id'];
			$_SESSION['username'] = $res[0]['name'];
		}
		
		
		// unset no longer needed request tokens
		unset($_SESSION['token']);
		unset($_SESSION['token_secret']);
		header("Location: " ."http://mybarnite.com/editprofile.php");
	}else{
		die("error, try again later!");
	}
		
}else{

	if(isset($_GET["denied"]))
	{
		header("Location: " ."http://mybarnite.com/signin.php");
		die();
	}

	//fresh authentication
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
	
	//received token info from twitter
	$_SESSION['token'] 			= $request_token['oauth_token'];
	$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
	
	// any value other than 200 is failure, so continue only if http code is 200
	if($connection->http_code=='200')
	{
		//redirect user to twitter
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
		header('Location: ' . $twitter_url); 
	}else{
		die("error connecting to twitter! try again later!");
	}
}
?>

