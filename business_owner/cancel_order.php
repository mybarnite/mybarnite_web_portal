<?php

include('common.php');
$id = $_POST['id'];
$owner_id = $_POST['owner_id'];
$action = $_POST['action'];
if($action=="Cancel")
{	
	$db->update('tbl_order_history',array('payment_status'=>"Canceled"),'id='.$id.' AND owner_id='.$owner_id); // Table name, column names and values, WHERE conditions
	$res = $db->getResult();
	$_SESSION['msg']="";
	$_SESSION['msg'] = "<div class='alert alert-success'>Data has been canceled successfully.</div>";
}

if($action=="Delete")
{
	$db->delete('tbl_order_history','id='.$id.' AND owner_id='.$owner_id);  // Table name, WHERE conditions
	$res = $db->getResult();  
	$_SESSION['msg']="";
	$_SESSION['msg'] = "<div class='alert alert-success'>Data has been deleted successfully.</div>";
}	

?>