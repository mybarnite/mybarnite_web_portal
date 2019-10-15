<?php
include '../business_owner/common.php';
$isOptInOut = $_POST['isOptInOut'];
$userId = $_POST['userId'];
//echo $userId."-".$isOptInOut;
if($isOptInOut==1){
	
	$array = array(
		'is_opt_out'=>$isOptInOut
	);
	
}else{
	
	$queryStr = "SELECT * from user_register where id=".$userId." and is_requested_for_delete_account=1" ;
	$executeQuery = $db->myconn->query($queryStr);
	$num_rows = $executeQuery->num_rows;
	if($num_rows>0){
		$db->delete('tbl_delete_account_request','user_id='.$userId);  // Table name, WHERE conditions
		$array = array(
			'is_opt_out'=>$isOptInOut,
			'is_requested_for_delete_account'=>0
		);

	}else{
		$array = array(
			'is_opt_out'=>$isOptInOut
		);

	}

}

$db->update('user_register',$array,'id='.$userId); // Table name, column names and values, WHERE conditions	

$res = $db->getResult();
$lastInsertedId = $res[0];
if($lastInsertedId!=""){
	echo '<div class="alert alert-success">Your profile has been successfully updated.</div>';
}else{
	echo "<div class='alert alert-danger'>We noticed that you have already agreed to the privacy policy, no action is required.</div>";
}	

		
?>