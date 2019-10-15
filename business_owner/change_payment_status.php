<?php

include('common.php');

$ids = $_POST['ids'];
$payment_status = $_POST['payment_status'];
$owner_id = $_POST['owner_id'];
//$ids = explode(",",$eventids);
if(isset($ids)&&$ids!="")
{
	foreach($ids as $id)
	{		
	
		$db->update('tbl_order_history',array('payment_status'=>$payment_status),'id='.$id.' AND owner_id='.$owner_id); // Table name, column names and values, WHERE conditions
		$res = $db->getResult();
		if($res[0]==1)
		{	
			$_SESSION['msg'] = "<div class='alert alert-success'>Data has been updated successfully.</div>";
		}
			
	//echo ($lastAffectedRow!="")?$lastAffectedRow:"There must be some issue.";
	}	
}	
else
{
	$_SESSION['msg'] = "<div class='alert alert-danger'>Please select at least one order.</div>";
}	
	

?>