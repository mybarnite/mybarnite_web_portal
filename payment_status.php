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

$orderid = $_REQUEST['orderid'];
$userid = $_REQUEST['userid'];
$transactionid = $_REQUEST['transactionid'];
$email = $_REQUEST['emailid'];
$detail1 = $_POST['detail1'];
$detail2 = $_POST['detail2'];
$amount = $_POST['amount'];
$payableamount = $_POST['amount'];

$eventid = $_POST['eventid1'];
$barid = $_POST['barid1'];
$usercount = $_POST['usercount'];

$dt = date('d-m-Y');

	$array = array(
		
		'payment_status'=>'Done',
		'transaction_id'=>$transactionid,
		'payable_amount'=>$payableamount,
		'skrill_transaction'=>$_REQUEST['transaction_id']
		
	);	
	$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
	$res = $db->getResult();
	$lastInsertedId = $res[0];
	
	
	if($lastInsertedId!="")
	{
		$array1 = array(
			'userCount'=>($usercount+1)
		);	
		if($barid!=""&&$barid!=0)
		{
			$db->update('tbl_promotions',$array1,'barId='.$barid); // Table name, column names and values, WHERE conditions		
		}
		elseif($eventid!=""&&$eventid!=0)
		{
			$db->update('tbl_promotions',$array1,'eventId='.$eventid); // Table name, column names and values, WHERE conditions		
		}		
		
		function qr($transactionid, $width = 200, $height = 200, $charset = 'utf-8', $error = 'H')
		{
		  // Google chart api url
		  $uri = 'https://chart.googleapis.com/chart?';

		  // url queries
		  $query = array(
			'cht' => 'qr',
			'chs' => $width .'x'. $height,
			'choe' => $charset,
			'chld' => $error,
			'chl' => $transactionid
		  );

		  // full url
		  $uri = $uri .= http_build_query($query);

		  return $uri;
		}
		
		

		
		
		//$to = "vidhi.scrumbees@gmail.com";
		
		//kubavatdharmesh@gmail.com
		$to = $email;
		$subject = 'Mybarnite';
		$from = 'info@mybarnite.com';
		$username = $_SESSION['FULLNAME']; 
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
		$message .= "<table border='1' cellspacing='0' style='width:100%;'>";
		$message .= "<tr class='border_bottom'><td  colspan='2' align='center'><img src='http://mybarnite.com/images/barlogo.png' width='329' height='192'/></td><td>Name : $username<br/>To : ".$to."<br/>Transaction id : ".$transactionid."</td></tr>";
		$message .= "<tr>
						  <th>Title</th><th>No Of Persons</th><th>Amount</th>
						</tr>
						<tr>
						  <td>$detail1</td><td>$detail2</td><td>".$amount."</td>
						</tr>
						<tr>
							<td></td>
							<td>Sub total</td>
							<td align='right'>".$amount."</td>
						</tr>
						<tr>
							
							<td colspan='2'><img src=".qr($transactionid, 400, 200)."></td>
							<td><img alt='".$transactionid."' src='http://mybarnite.com/barcode.php?codetype=Code39&size=40&text=".$transactionid."' /></td>
						</tr>";	
		$message .= "</table>";
		$message .= "</body></html>";
		mail($to, $subject, $message, $headers);
		unset($_SESSION['payableamount']);
		unset($_SESSION['discount']);
	}

?>