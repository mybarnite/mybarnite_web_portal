<?php

include('common.php');

$id = $_POST['id'];
$ownerid = $_POST['ownerid'];
$barid = $_POST['barid'];

if($id!=""&&$ownerid!=""&&$barid!="")
{
	$db->delete('tbl_businessowner_subscription','id='.$id.' AND owner_id='.$ownerid.' and bar_id='.$barid);  // Table name, WHERE conditions
	$res = $db->getResult();  
}	

?>