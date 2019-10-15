<?php
require_once('latesttweets/TwitterAPIExchange.php');

//Old credentials

// $settings = array(
//     'oauth_access_token' => "760460892316270592-9usI5Ts4czMNk6i2bZma6wbkwXhR14A",
//     'oauth_access_token_secret' => "e5ZJH46h5mzbZrMI5VBHshyqWLJ6Y1e8FgVEBR8VrEvdS",
//     'consumer_key' => "otkbMAqrOQopASPSbxECQstui",
//     'consumer_secret' => "rtmB0eiSFb2MrwK22tYWTQNzjqJKqLLcLZWWbOKZkty1qcshtp"
// );

//New credentials as on 23rd June

$settings = array(
    'oauth_access_token' => "760460892316270592-DPWO82TINQpgnY0lssmC4rtPGLJVwJG",
    'oauth_access_token_secret' => "IimZM0ru4MKLtjWQhvUaiouViOPzZCtPp8IKOrTjzhPRT",
    'consumer_key' => "otkbMAqrOQopASPSbxECQstui",
    'consumer_secret' => "rtmB0eiSFb2MrwK22tYWTQNzjqJKqLLcLZWWbOKZkty1qcshtp"
);

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=mybarnite&count=2';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$data = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
			 
$feeds = json_decode($data);	 

/* foreach($feeds as $feed)
{
	#echo "<pre>";
	#print_r($feed);
	echo $feed->user->screen_name;
	echo "<br/>";
	echo $feed->text;
	echo "<br/>";
	echo $feed->user->profile_image_url;
	echo "<br/>";
} */
?>