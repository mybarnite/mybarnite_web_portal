<?php
	
include('common.php');

$ownerid = $_POST['ownerid'];
$subscriptionid = $_POST['subscriptionid'];
$transactionid = $_POST['transactionid'];
$amount = $_POST['amount'];
#$_POST['duration'] = 12;
$months = "+".$_POST['duration'];
$duration = "$months months";
$barid = $_POST['barid'];
$emailid = $_POST['emailid'];  
$username = $_POST['username'];  
$refdate = strtotime(@$_POST['refdate']);
$currentdt = ($refdate)?$_POST['refdate']:date('Y-m-d', time());
$MonthsLater = ($refdate)?strtotime($duration, $refdate):strtotime($duration, time());
$enddt = date('Y-m-d', $MonthsLater);
$refdatenew = $enddt;	

	$array = array(
		'dueamount'=>0,
		'start_date'=>$currentdt,
		'end_date'=>$enddt,
		'ref_date'=>$refdatenew,
		'payment_status'=>'Done',
		'transaction_id'=>$transactionid,
		'skrill_transaction'=>$_REQUEST['transaction_id'],
		'is_active'=>'Active'
		
	);	

	$db->update('tbl_businessowner_subscription',$array,'id='.$subscriptionid); 
	$res = $db->getResult();
	$lastInsertedId = $res[0];
	
	if($lastInsertedId!="")
	{
		
		$array = array(
			'is_payasyougo'=>"2"
		);

		$db->update('bars_list',$array,'id='.$barid);
		
		$db->select('user_register','email,name',NULL,'id='.$ownerid,'id DESC');
		$res = $db->getResult();
		
		$to = $emailid;
		$name = $username;
		//kubavatdharmesh@gmail.com
		// subject
		$subject = 'Mybarnite - Subscription';

		// message
		$message = "
		<html>
		<head>
		  <title>Mybarnite</title>
				
		</head>
		<body>
			Dear $name,
			<br/><br/>	
			Thank you for your recent purchase from Mybarnite.com.<br/>
			Please find enclosed the proof of purchase and the receipt attached. Should you have any further query, please contact our customer support team<br/><br/>
		  <table cellspacing='0'>
			<tr>
			  <th>Name :</th>
			  <td>$name</td>
			</tr>
			<tr>
			  <th>Email :</th>
			  <td>$to</td>
			</tr>
			<tr>
			  <th>Duration :</th>
			  <td>From : $currentdt to $enddt </td>
			</tr>
			<tr>
			  <th>Amount :</th>
			  <td>$amount</td>
			</tr>	
			<tr>
			  <th>Payment :</th>
			  <td>Done</td>
			</tr>
			<tr>
			  <th>Transaction id :</th>
			  <td>$transactionid</td>
			</tr>			
		  </table>
		<br/><br/>
		Thanks again you for using our website
		<br/><br/>
		Mybarnite Limited<br/>
		EMail: info@mybarnite.com<br/>
		URL: mybarnite.com<br/><br/>
		<img src='http://mybarnite.com/images/Picture1.png' width='50%'>
		<br/>
		
		</body>
		</html>
		";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: ' .$to. "\r\n";
		$headers .= 'From: Mybarnite <info@mybarnite.com>' . "\r\n";
		mail($to, $subject, $message, $headers);
	}

?>