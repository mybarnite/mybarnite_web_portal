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

$orderid = $_POST['orderId'];
$amount = $_POST['Amount'];
$code = $_POST['code'];
$barid = $_POST['barId'];
$eventid = $_POST['eventId'];

if($barid!=""&&$barid!=0)
{
	
	$sql = $db->select('tbl_promotions','*',null,'status = "Active" and couponcode ="'.$code.'" and barId='.$barid,null);  // Table name, WHERE conditions	
}
elseif($eventid!=""&&$eventid!=0)	
{
	
	$sql = $db->select('tbl_promotions','*',null,'status = "Active" and couponcode ="'.$code.'" and eventId='.$eventid,null);  // Table name, WHERE conditions
}
$res = $db->getResult(); 	
$numRows = count($res); 

$current_date = strtotime(date("Y-m-d"));
$startsat = strtotime($res[0]['startsat']. " -1 day");
$endsat = strtotime($res[0]['endsat']. " +1 day");
if($numRows>0)
{
	
	if(($current_date>$startsat)&&($current_date<$endsat))
	{
		$discount = ($res[0]['discount']/100)*$amount;
		$payableamount = $amount - $discount; 
		$_SESSION['discount'] = $discount;
		$_SESSION['usercount'] = $res[0]['userCount'];
		$_SESSION['isValid'] = "";
		echo $_SESSION['payableamount']=$payableamount;
	}
	else
	{
		echo $_SESSION['isValid']="Invalid";
	}		
	
	
}
else
{
	echo $_SESSION['isValid']="Invalid";
}
?>