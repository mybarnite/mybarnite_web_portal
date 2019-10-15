<?php
session_start();
include ('config.php');
//LOADING LIBRARY
require "lib/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;



if($_GET['oauth_token'] || $_GET['oauth_verifier'])
{	
	$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $_REQUEST['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));
	$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	$params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
	$user_info = $connection->get('account/verify_credentials',$params);

	$oauth_token = $access_token['oauth_token'];
	$oauth_token_secret = $access_token['oauth_token_secret'];
	

	$user_id = $user_info->id;
	$email_id = $user_info->email;
	$user_name = $user_info->name;
	$user_pic = $user_info->profile_image_url_https;
	$text = $user_info->status->text;
	$username = $user_info->screen_name;

	
	$sql="SELECT * FROM user_register WHERE name = '$username' and r_id = '2'";
	$result=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

	if(mysqli_num_rows($result) == 1)
	{
		$_SESSION['id'] = $row['id'];
	  	$_SESSION['name'] = $user_name;
	  	$_SESSION['useremail'] = $email_id;
		$_SESSION['dp'] = $user_pic;
		$_SESSION['text'] = $text;
		$_SESSION['username'] = $username;
		$_SESSION['FULLNAME'] = $username;
		
		header('Location: https://mybarnite.com/');
	}
	else
	{
		$query = mysqli_query($db, "INSERT INTO user_register(name,email,twitter_id,status,r_id) VALUES ('$username','$email_id',$user_id, 'Active', 2)");
		
		if($query)
		{
			$lastInsertedId = mysqli_insert_id($db);
			$_SESSION['id'] = $lastInsertedId;
			$_SESSION['username'] = $username;
			$_SESSION['useremail'] = $email_id;
			$_SESSION['text'] = $text;
			$_SESSION['name'] = $user_name;
			$_SESSION['dp'] = $user_pic;
			$_SESSION['FULLNAME'] = $username;
			header('Location: https://mybarnite.com/');
		}else
		{
			echo mysqli_error($db);
		}
	}
}else
{ 
	header('Location: https://mybarnite.com/twitterlogin/twitter_login.php');
}

	
	

?>