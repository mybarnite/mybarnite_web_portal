<?php

include('common.php');

$id = $_POST['id'];

$role =  $_POST['role'];


if($id!="")
{
	$db->delete('tbl_accounts','id='.$id.'  and role='.$role);  // Table name, WHERE conditions
	$res = $db->getResult();  
	
	$_SESSION['msg']="<div class='alert alert-success'>Data has been deleted successfully.</div>";
	
	
}	

?>