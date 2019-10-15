<?php

include('common.php');

$id = $_POST['id'];
$ownerid = $_SESSION['business_owner_id'];
$barid = $_SESSION['bar_id'];

if($id!=""&&$ownerid!=""&&$barid!="")
{
	$db->delete('tbl_promotions','id='.$id.' AND ownerId='.$ownerid.' and barId='.$barid);  // Table name, WHERE conditions
	$res = $db->getResult();  
	
	$_SESSION['msg']="<div class='alert alert-success'>Data has been deleted successfully.</div>";
	
	
}	

?>