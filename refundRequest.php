<?php 
	
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');

$db = new business_owner();
$db->connect();
$orderid = $_POST['orderid'];
$role = $_POST['role'];
if($role==2)
{
	$db->select('tbl_order_history','tbl_order_history.*,user_register.name as username, user_register.email','user_register on user_register.id=tbl_order_history.user_id','tbl_order_history.id ='.$orderid,'tbl_order_history.id DESC',1);
	$res = $db->getResult();

	$ordername = $res[0]['ordername'];
	$username = $res[0]['username'];
	$amount = ($res[0]['payable_amount'])?$res[0]['payable_amount']:$res[0]['total_amount'];
	$transaction_id = $res[0]['transaction_id']; 
	$payment_status = $res[0]['payment_status']; 
	$email = $res[0]['email']; 
	
	$db->select('tbl_order_history','user_register.email as username, user_register.email','user_register on user_register.id=tbl_order_history.owner_id','tbl_order_history.id ='.$orderid,'tbl_order_history.id DESC',1);
	$res1 = $db->getResult();
	/* echo "<pre>";
	print_r($res1); */
	
	
	
		/******************************** Sending Refund request to Owner  ********************************/
	
		//$res1[0]["email"]="radicalinweb@gmail.com";
		$to1 = $res1[0]["email"];
		$subject1 = 'Mybarnite - Refund Request';
		$from1 = 'info@mybarnite.com';
		 
		// To send HTML mail, the Content-type header must be set
		$headers1  = 'MIME-Version: 1.0' . "\r\n";
		$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers1 .= 'From: '.$from1."\r\n".
			'Reply-To: '.$from1."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message
		$message1 = "<html>";
		$message1 .= "<head><title>Mybarnite</title></head>";
		$message1 .= "<body>";
		$message1 .= "<p>Dear Admin,</p>";
		$message1 .= "<p>New refund has been requested for order id ".$orderid."</p><br/><br/>";
		$message1 .= "<br/><br/>";
		$message1 .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>EMail: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
		$message1 .= "</body></html>";

		if(mail($to1, $subject1, $message1, $headers1))
		{
			$array = array(
				'payment_status'=>'Refund Requested'
			);	
			$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
			$res2 = $db->getResult();
			echo $_SESSION['msg']= '<div class="alert alert-success">Refund request has been sent successfully.</div>';
		}	
		else{
			echo $_SESSION['msg']= '<div class="alert alert-danger">Unable to send email. Please try again.</div>';
		}
		
	
}	
if($role==1)
{
	$db->select('tbl_businessowner_subscription','tbl_businessowner_subscription.*,tbl_subscription.title','tbl_subscription on tbl_subscription.id=tbl_businessowner_subscription.subscription_id','tbl_businessowner_subscription.id ='.$orderid,'id DESC',10);
	$res = $db->getResult();

	$barId = $res[0]['bar_id'];
	$ownerId = $res[0]['owner_id'];
	$subscription = $res[0]['title'];
	$duration = $res[0]['duration'];
	$amount = $res[0]['totalamount'];
	$is_active = $res[0]['is_active']; 
	$is_authorised = $res[0]['is_authorised']; 
	$transaction_id = $res[0]['transaction_id']; 
	$payment_status = $res[0]['payment_status']; 

	if($payment_status=='Done'&&$is_authorised=='1')
	{
		$db->select('bars_list','bars_list.Business_Name,user_register.email,user_register.name','user_register on user_register.id=bars_list.Owner_id','bars_list.id ='.$barId,'bars_list.id DESC');
		$getDetails = $db->getResult();
		$count = count($getDetails);
		if($count>0)
		{
			$barName = $getDetails[0]['Business_Name'];
			$email = $getDetails[0]['email'];
			$name = $getDetails[0]['name'];
		}	
	}	

	/* echo "<pre>";
	print_r($getDetails);
	exit;

	 */
	$to = 'info@mybarnite.com';
	$subject = 'Mybarnite - Refund Request';
	$from = $email;
	 
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	 
	// Compose a simple HTML email message
	$message = "<html>";
	$message .= "<head><title>Mybarnite</title></head>";
	$message .= "<body>";
	$message .= "<table>";
	$message .= "	
					<tr><th>Order Id :</th><td>".$orderid."</td></tr>
					<tr><th>Owner name :</th><td>$name</td></tr>
					<tr><th>Subscription :</th><td>$subscription</td></tr>
					<tr><th>Amount :</th><td>".$amount."</td></tr>
					<tr><th>Duration :</th><td>".$duration."</td></tr>
					
					
					";	
	$message .= "</table>";
	$message .= "</body></html>";

	// Sending email
	if(mail($to, $subject, $message, $headers)){
		$array = array(
			
			'payment_status'=>'Refund Requested'
			
			
		);	
		$db->update('tbl_businessowner_subscription',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
		$res2 = $db->getResult();
		echo $_SESSION['msg']= 'Email has been sent successfully for refund request.';
		
	} else{
		echo $_SESSION['msg']= 'Unable to send email. Please try again.';
	}
}	

?>