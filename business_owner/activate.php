<?php
	
include('template-parts/header.php');

if (isset($_GET['id']) ) 
{
	$id = $_GET['id'];
}
if (isset($_GET['key']) && (strlen($_GET['key']) == 32))
{
	 //The Activation key will always be 32 since it is MD5 Hash
	$key = $_GET['key'];
}
if (isset($id) && isset($key)) 
{
	$db->select('user_register','email,name',NULL,'id='.$_GET['id'],'id DESC');
	$res = $db->getResult();
		 
	 if ($db->update('user_register',array('activation_key'=>"",'status'=>"Active"),'id='.$id.' AND activation_key="'.$key.'"')) //if update query was successfull
	 {
		
		
		$username = $res[0]['name'];
		$msg = "<html>";
		$msg .= "<head><title>Mybarnite</title></head>";
		$msg .= "<body>";
		$msg .= "Dear $username<br/><br/>Thank you for joining our website.<br/><br/>Your account is successfully activated. Please <a href='".SITE_PATH . "business_owner/business_owner_signin.php'>login</a> to add the details of your bar or claim your business from our Bar listings to complete your registration process.";
		$msg .= "<br/><br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
		$msg .= "</body></html>";
		$subj = 'Account Confirmation';
		$to = $res[0]['email'];
		$from = 'info@mybarnite.com';
		$appname = 'Mybarnite';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: info@mybarnite.com" . "\r\n" ."";	
		 
		if (mail($to,$subj,$msg,$headers)) 
		{
			
			$_SESSION['msg'] = '<div class="alert alert-success">Your account has been activated successfully. You may Log in now.</div>';
			header("location:business_owner_signin.php");	
			
		} 
		else 
		{
			$_SESSION['msg'] = '<div class="alert alert-success">There must be some issue with account activation. Please contact to administrator .</div>';
			header("location:business_owner_signin.php");
		}
		
		
	 } 
	 else 
	 {
		$_SESSION['msg'] =  '<div class="alert alert-danger">Oops !Your account could not be activated. Please recheck the link or contact the system administrator.</div>';
		header("location:business_owner_signin.php");	
	 }

	 mysqli_close($dbc);

} 
else 
{
	$_SESSION['msg'] =  '<div class="alert alert-danger">Error Occured .</div>';
	header("location:business_owner_signin.php");	
}
?>