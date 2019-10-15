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
require_once('./config.php');

$db = new business_owner();
$db->connect();

$user = $_POST['user'];
$orderid = $_POST['orderid'];
if($user=="Owner")
{
	$sql = "SELECT o.* ,u.name as uname,u.email ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where owner_id =".$_SESSION['business_owner_id']." and o.id=".$orderid ;
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	if($num_rows1>0)	
	{
		$order = $res->fetch_assoc();
		//$order["email"]
		if($order['bar_id']!=0&&$order['bar_id']!="")
		{	
			if($order['pending_amount']!=0)
			{
				$amount = $order['payable_amount'] - $order['pending_amount'];
			}
			else
			{
				$amount = $order['payable_amount'];
			}
			
			$refund = \Stripe\Refund::create([
				'charge' => $order['transaction_id'],
				'amount' => $amount * 100
			]);
		}
		else
		{
			$refund = \Stripe\Refund::create([
				'charge' => $order['transaction_id'],
				'amount' => $amount * 100
			]);
		}	
		
		/* if(mail($to1, $subject1, $message1, $headers1))
		{ */
			
			/*curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			// execute!
			$response = curl_exec($ch);

			// close the connection, release resources used
			curl_close($ch);

			// do anything you want with your response
			$res_status = explode(",",$response);*/
			
			if($refund['status']=="succeeded")
			{
				$array = array(
						
					'payment_status'=>'Refunded',
					
				);	
				$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
				$res2 = $db->getResult();
				$lastInsertedId = $res2[0];
				
				$to1 = $order["email"];	
				$subject1 = 'Mybarnite - Refund confirmation';
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
				$message1 .= "<p>Dear User,</p>";
				$message1 .= "<p>Your refund request has been accepted and initiated successfully for order number ".$orderid."</p><br/><br/>";
				$message1 .= "<br/><br/>";
				$message1 .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>EMail: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
				$message1 .= "</body></html>";
			
				if(mail($to1, $subject1, $message1, $headers1))
				{
					echo $_SESSION['msg']= '<div class="alert alert-success">Refund has been initiated successfully.</div>';
					
				}
				else
				{
					echo $_SESSION['msg']= '<div class="alert alert-danger">Error.</div>';
				}	
			
			}	
			else
			{
				echo $_SESSION['msg'] = "<div class='alert alert-danger' >Currently refund is not possible .Try after 1 hour.</div>";
			}
		/* }	
		else
		{
			echo $_SESSION['msg']= '<div class="alert alert-danger">Error.</div>';
		}	 */
		
		
		
		
	}	
	

}	
elseif($user=="Admin")
{
	$orderid = $_POST['orderid'];
	$sql = "SELECT * from tbl_order_history where id=".$orderid." and payment_status='Done' and is_authorised='1'" ;
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	if($num_rows1>0)	
	{
		$order = $res->fetch_assoc();
		/* echo "<pre>";
		print_r($order); */
		$post = [
			'instId' => '1289280',
			'authPW' => 'Sgnd3PYm',
			'cartId'   => $order['cartId'],
			'op'   => 'refund-full',
			'transId'   => $order['transaction_id'],
			'amount'   => $order['payable_amount'],
			'currency'   => 'GBP',
			'testMode'   => 100,
			
		];
		
		$ch = curl_init('https://secure-test.worldpay.com/wcc/itransaction');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		$res_status = explode(",",$response);
		if($res_status[0]=="A")
		{
			$array = array(
					
				'payment_status'=>'Refunded',
				
			);	
			$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
			$res2 = $db->getResult();
			$lastInsertedId = $res2[0];
		
		}	
		else
		{
			echo $_SESSION['msg'] = "<div class='alert alert-danger' >Currently refund is not possible .Try after 1 hour.</div>";
		}
		
		
	}	
}
	
	
?>