<?php 
	
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");

include('../business_owner/class/business_owner.php');
include('../business_owner/class/form.php');

$db = new business_owner();
$db->connect();

$userId = $_POST['userId'];
$rId = $_POST['rId'];

$queryStr = "SELECT * from user_register where id=".$userId." and r_id='".$rId."' and is_requested_for_delete_account=1" ;
$executeQuery = $db->myconn->query($queryStr);
$num_rows = $executeQuery->num_rows;
if($num_rows>0){
	echo '<div class="alert alert-danger">Your request for deleting account has already been sent to Admin, Please contact to site administrator.</div>';
	exit;
}	
if($rId==1)
{
	$sql = "SELECT u.*,b.Business_Name from user_register as u join bars_list as b on b.Owner_id = u.id where u.id=".$userId." and u.r_id='1'" ;
	$res = $db->myconn->query($sql);
	$accountDetail = $res->fetch_assoc();
	$name = $accountDetail['name'];	
	$email = $accountDetail['email']; 
	$barName = $accountDetail['Business_Name'];
	
}else{
	$sql = "SELECT * from user_register where id=".$userId." and r_id='2'" ;
	$res = $db->myconn->query($sql);
	$accountDetail = $res->fetch_assoc();
	$name = $accountDetail['name'];	
	$email = $accountDetail['email']; 
	
	
}

$insertData = array(
						
	'r_id'=>$rId,
	'user_id'=>$userId,
	'is_opt_out'=>1
);	

$db->insert('tbl_delete_account_request',$insertData);  // Table name, column names and respective values
$res = $db->getResult();
$requestId=@$res[0];

$upadeteData = array(
						
	'is_requested_for_delete_account'=>1,
	
);	
$db->update('user_register',$upadeteData,'id='.$userId); // Table name, column names and values, WHERE conditions	
$getResult = $db->getResult();
$lastInsertedId = $getResult[0];
if($lastInsertedId!=""){
		

	//$to = $order['email'];
	$to = "radicalinweb@gmail.com";
	$subject = 'Mybarnite - Notification for deleting account';
	$from = $email;
	 
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	 
	// Compose a simple HTML email message
	// Compose a simple HTML email message
	$message = "<html>";
	$message .= "<head><title>Notification!</title></head>";
	$message .= "<body>";
	$message .= "<p>Dear Admin,</p>";
	$message .= "<p>Delete account request has been generated!</p><br/><br/>";
	$message .= "<h3>Check user detail as given below :</h3>";
	$message .= "<table>";
	$message .= "	
					<tr><th>User id :</th><td>".$userId."</td></tr>
					<tr><th>Name :</th><td>From $name </td></tr>
					<tr><th>Email :</th><td>$email</td></tr>
				";	
	$message .= "</table><br/><br/>";
	$message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
	$message .= "</body></html>";
	if(mail($to, $subject, $message, $headers))
	{
		echo '<div class="alert alert-success">Your request has been sent to Admin successfully.</div>';
		
	}
	else
	{
		echo '<div class="alert alert-danger">There is some issue while sending email . Please try later or contact to administrator.</div>';
	}

}else{
	echo '<div class="alert alert-danger">There is some error. Please try later or contact to administrator</div>';
}
?>