<?php 
	
session_start();
ob_start();


include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");

include('class/business_owner.php');
include('class/form.php');

$db = new business_owner();
$db->connect();

$id = $_POST['id'];
$accountStatus = $_POST['accountStatus'];
$user_id = ($_SESSION['business_owner_id']!="")?$_SESSION['business_owner_id']:$_SESSION['id'];
$role = $_POST['role'];
if($id!="")
{
	$array = array(
		'status'=>($accountStatus==1)?"Active":"Inactive"
	);
	$db->update('tbl_accounts',$array,'id='.$id.' and role = '.$role.' and user_id = '.$user_id);
	$affectedRows = $db->myconn->affected_rows;	
	if($affectedRows>0)
	{
		
		if($accountStatus==1)
		{
			$array = array(
				'status'=>"Inactive"
			);
			$db->update('tbl_accounts',$array,'id!='.$id.' and role = '.$role.' and user_id = '.$user_id);		
		}	
		
		$_SESSION['success_msg'] = "<div class='alert alert-success'>Activated.</div>";
	}	
}	
?>