<?php
ini_set('display_errors', 0);
//if you DO want a file to cache, use:
header("Cache-Control: max-age=2592000");  //30days (60sec * 60min * 24hours * 30days)

ob_start();
session_start();
date_default_timezone_set("Asia/Kolkata");

//local server
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("basicfee_database") or die(mysql_error());

//live web server
//$conn = mysql_connect("198.38.82.92", "prosol_feet", "Infoms321") or die(mysql_error());
//mysql_select_db("prosol_feet") or die(mysql_error());

$sitetitle = "basicfeet - Online Shoes Portal";
$domainName = 'http://www.basicfeet.com';
?>
