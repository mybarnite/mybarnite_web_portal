<?php

session_start();
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('admin/includes/config.cfg');
include(ROOT_PATH.'business_owner/class/business_owner.php');
include(ROOT_PATH.'business_owner/class/form.php');
include(ROOT_PATH.'admin/includes/funcs_lib.inc.php');
$db = new business_owner();
$db->connect();

$id = $_POST['id'];

#$event_id = $_POST['event_id'];

$user_id = $_POST['user_id'];
#echo "<br/>";
$action = $_POST['action'];

if($action=="Cancel")
{	
	echo $id.",".$user_id.",".$action;
	$db->update('tbl_order_history',array('payment_status'=>"Canceled"),'id='.$id.' AND user_id='.$user_id); // Table name, column names and values, WHERE conditions
	$res = $db->getResult();
}

if($action=="Delete")
{	

	$db->delete('tbl_order_history','id='.$id.' AND  user_id='.$user_id);  // Table name, WHERE conditions
	$res = $db->getResult();  
}	

?>