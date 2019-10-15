<?php

include('common.php');

$img_id = $_POST['img_id'];
$bar_id = $_SESSION['bar_id'];

if($img_id!="")
{
	
		
		$db->delete('tbl_barfoodmenu_uploads','id='.$img_id.' and bar_id ='.$bar_id);  // Table name, WHERE conditions
		$res = $db->getResult();  
		
		
}	

?>