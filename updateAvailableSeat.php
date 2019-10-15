<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();
$bar_id = $_POST['bar_id'];
$hall_booking = $_POST['hall_booking'];
$db->select('bars_list','id,Owner_id,Business_Name,hall_booking,seat_for_basic',null,'id='.$bar_id,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$barDetial = $db->getResult();

//$hall_booking = ($barDetial[0]['hall_booking']==1)?"Available":"Not available";
$seat_for_basic = $barDetial[0]['seat_for_basic'];


echo "Available seat : $seat_for_basic";

?>