<?php

include('common.php');


$barId = $_SESSION['bar_id'];

if(@$_POST['action']=="")
{
	$id = $_POST['subuser_id'];
	$db->delete('tbl_staffPermission','subuser_id='.$id.'  and bar_id='.$barId);  // Table name, WHERE conditions
	$res = $db->getResult(); 

	$db->delete('user_register','id='.$id);  // Table name, WHERE conditions
	$res = $db->getResult(); 
	
	echo $_SESSION['message1'] = '<div class="alert alert-success">Data has been deleted successfully!</div>';
}	
else if(@$_POST['action']=="Multiple")
{	
	echo $ids = $_POST['Ids'];
	$user_ids = explode(";",$ids);
	foreach($user_ids as $user_id)
	{
		$db->delete('tbl_staffPermission','subuser_id='.$user_id.'  and bar_id='.$barId);  // Table name, WHERE conditions
		$res = $db->getResult(); 

		$db->delete('user_register','id='.$user_id);  // Table name, WHERE conditions
		$res = $db->getResult(); 
	}	
	echo $_SESSION['message1'] = '<div class="alert alert-success">Data has been deleted successfully!</div>';
}	

