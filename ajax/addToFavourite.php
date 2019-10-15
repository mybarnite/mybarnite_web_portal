<?php
session_start();
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../admin/includes/config.cfg');
include(ROOT_PATH.'business_owner/class/business_owner.php');
include(ROOT_PATH.'business_owner/class/form.php');
include(ROOT_PATH.'admin/includes/funcs_lib.inc.php');
$db = new business_owner();
$db->connect();
$action = $_POST['action'];
if($action=="Add")
{	

	$barid = $_POST["barid"];
	$userid = $_SESSION["id"];
	if($barid!="")
	{
		$db->select('tbl_user_myfavourites','*',null,'userid='.$userid.' and barid='.$barid,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
		$is_fav = $db->getResult();
		if($is_fav>0&&!empty($is_fav))
		{
			$db->update('tbl_user_myfavourites',array('is_favourite'=>1),'id = '.$is_fav[0]["id"].' and barid = '.$barid.' and userid ='.$userid);  // Table name, column names and respective values
		}	
		else
		{
			$db->insert('tbl_user_myfavourites',array('userid'=>$userid,'barid'=>$barid,'is_favourite'=>1));  // Table name, column names and respective values
		}	
		
		$res = $db->getResult();  
		echo $res[0];					
		if(!empty($res))
		{
			$_SESSION['msg'] = "<div class='alert alert-success'>Successfully added to your favourites.</div>";
		}
		else
		{
			$_SESSION['msg'] = "<div class='alert alert-danger'>There is some error.</div>";
		}		
	}	
}

if($action=="Remove")
{
	$id = $_POST['id'];
	$barid = $_POST['barid'];
	$userid = $_SESSION['id'];
	if($barid!="")
	{
		$db->update('tbl_user_myfavourites',array('is_favourite'=>0),'id = '.$id.' and barid = '.$barid.' and userid ='.$userid);  // Table name, column names and respective values
		$res = $db->getResult();  
		echo $res[0];					
		if(!empty($res))
		{
			$_SESSION['msg'] = "<div class='alert alert-success'>Successfully removed from your favourites.</div>";
		}
		else
		{
			$_SESSION['msg'] = "<div class='alert alert-danger'>There is some error.</div>";
		}		
	}
}	
?>