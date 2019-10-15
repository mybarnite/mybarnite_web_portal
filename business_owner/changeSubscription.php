<?php 
	
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");

include('class/business_owner.php');
include('class/form.php');

$db = new business_owner();
$db->connect();

$barId = $_SESSION['bar_id'];
$subType = $_POST['subType'];
$db->select('tbl_settings','*',null,'id =1','id DESC');
$getSettings = $db->getResult();
// 1: Pay as you go , 2 : Buy subscription 

//PAY AS YOU GO OPTION SELECTED
if($subType==1)
{
	
	// UPDATE BAR WITH is_payasyougo = 1 otherwise null
	$array = array(
		'Commission'=>$getSettings[0]['commision'],
		'is_payasyougo'=>"1"
	);

	$db->update('bars_list',$array,'id='.$_SESSION['bar_id']);
	$affectedRows = $db->myconn->affected_rows;	
	if($affectedRows>0)
	{
		$_SESSION['success_msg'] = "<div class='alert alert-success'>Now you can able to add new event.</div>";
	}	
}
if($subType==2)
{
	// UPDATE BAR WITH is_payasyougo = 1 otherwise null
	$array = array(
		'Discount'=>$getSettings[0]['discount'],
		'is_payasyougo'=>""
	);

	$db->update('bars_list',$array,'id='.$_SESSION['bar_id']);
	$affectedRows = $db->myconn->affected_rows;	
	if($affectedRows>0)
	{
		
		$_SESSION['success_msg'] = "<div class='alert alert-danger'>Pay as you inactivated successfully.</div>";
	}	
}

	
?>