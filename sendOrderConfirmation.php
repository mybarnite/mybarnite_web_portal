<?php

//echo "test";exit;
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
	$orderid = $_POST['orderId'];
	
	$sql = "SELECT o.* ,u.name as uname , u.email ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where payment_status = 'Pending' and o.id =".$orderid;
	$res = $db->myconn->query($sql);
	$order = $res->fetch_assoc();
	//echo $order['event_id']."-".$order['bar_id'];exit;
	/* echo "<pre>";
	print_r($order);
	echo "</pre>";
	exit;
	 */
	if($order['bar_id']==0)
	{
		$sql_1 = "SELECT * from tbl_events where id = ".$order['event_id'];
		$res_1 = $db->myconn->query($sql_1);
		$getEventDetail = $res_1->fetch_assoc();
		
		$eventstart = date('m/d/Y',strtotime($getEventDetail['event_start']));
		$eventend = date('m/d/Y',strtotime($getEventDetail['event_end']));

		$starttime = $getEventDetail['start_time'];
		$endtime = $getEventDetail['end_time'];
		
		
		$name = $order['name'];
		$_SESSION['discount'] = 0;
		$_SESSION['payableamount'] = 0;
		
		
		/*********************************** Sending email to customer ***********************************/
		
		$to = $order['email'];
		$subject = 'Mybarnite - Order Confirmation';
		$from = 'info@mybarnite.com';
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message
		$message = "<html>";
		$message .= "<head><title>Order Confirmation!</title></head>";
		$message .= "<body>";
		$message .= "<p>Dear Customer,</p>";
		$message .= "<p>Your order has been placed successfully!</p><br/><br/>";
		$message .= "<h3>Order details are as below :</h3>";
		$message .= "<table>";
		$message .= "	
						<tr><th>Event Name :</th><td>$name</td></tr>
						<tr><th>Date :</th><td>From $eventstart to $eventend </td></tr>
						<tr><th>Timings :</th><td>$starttime - $endtime</td></tr>
					";	
		$message .= "</table><br/><br/>";
		$message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
		$message .= "</body></html>";

		// Sending email
		if(mail($to, $subject, $message, $headers)){
			$_SESSION['msg'] = '<div class="alert alert-success">Your order has been placed successfully.</div>';
			if($getEventDetail['free_event']==1)
			{
				echo "orders.php";	
			}	
			else
			{
				echo "checkoutdetail.php?orderid=".$orderid;	
			}
			
		} else{
			$_SESSION['msg'] = '<div class="alert alert-success">There must be some issue with placing order.</div>';
			if($getEventDetail['free_event']==1)
			{
				echo "orders.php";	
			}	
			else
			{
				echo "checkoutdetail.php?orderid=".$orderid;	
			}	
		}
	}
	else if($order['event_id']==0)
	{
		/* $sql_1 = "SELECT * from tbl_events where id = ".$order['event_id'];
		$res_1 = $db->myconn->query($sql_1);
		$getEventDetail = $res_1->fetch_assoc();
		
		$eventstart = date('m/d/Y',strtotime($getEventDetail['event_start']));
		$eventend = date('m/d/Y',strtotime($getEventDetail['event_end']));

		$starttime = $getEventDetail['start_time'];
		$endtime = $getEventDetail['end_time']; */
		
		$sql_1 = "SELECT * from tbl_events where id = ".$order['bar_id'];
		$res_1 = $db->myconn->query($sql_1);
		$getBarDetail = $res_1->fetch_assoc();
		
		$hallcapacity = ($getBarDetail['hall_capacity'])?$getBarDetail['hall_capacity']." People":"-";
		
		$name = $order['ordername'];
		$bookingdate = date('m/d/Y',strtotime($order['bar_booking_start_date']));
		$bookingtime = $order['bar_booking_starts'].'-'.$order['bar_booking_ends'];
		$bookingtype = $order['bar_booking_purpose'];
		$numberofbookings = $order['no_of_persons'];
		$amounttobepaid = $order['total_amount'];
		$hallbooking = ($order['is_hall_booked']==1)?"Yes":"No";
		
		$_SESSION['discount'] = 0;
		$_SESSION['payableamount'] = 0;
		
		
		/*********************************** Sending email to customer ***********************************/
		
		$to = $order['email'];
		//$to = "anvi007@gmail.com";
		$subject = 'Mybarnite - Order Confirmation';
		$from = 'info@mybarnite.com';
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message
		$message = "<html>";
		$message .= "<head><title>Order Confirmation!</title></head>";
		$message .= "<body>";
		$message .= "<p>Dear Customer,</p>";
		$message .= "<p>Your order has been placed successfully!</p><br/><br/>";
		$message .= "<h3>Order details are as below :</h3>";
		$message .= "<table>";
		$message .= "	
						<tr><th>Bar Name :</th><td>$name</td></tr>
						<tr><th>Booking Purpose :</th><td>$bookingtype</td></tr>
						<tr><th>Booking Date :</th><td>$bookingdate</td></tr>
						<tr><th>Timings :</th><td>$bookingtime</td></tr>
						<tr><th>Hall bookings :</th><td>$hallbooking</td></tr>";
		if($order['is_hall_booked']==1)
		{
			$message .= "	<tr><th>Hall capacity :</th><td>$hallcapacity</td></tr>";
		}
		else
		{
			$message .= "	<tr><th>Number of bookings :</th><td>$numberofbookings</td></tr>";	
		}		
		
		$message .= "
						
						<tr><th>Total amount to pay :</th><td>$amounttobepaid</td></tr>
					";	
		$message .= "</table><br/><br/>";
		$message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
		$message .= "</body></html>";

		// Sending email
		if(mail($to, $subject, $message, $headers)){
			$_SESSION['msg'] = '<div class="alert alert-success">Your order has been placed successfully.</div>';
			if($getEventDetail['free_event']==1)
			{
				echo "orders.php";	
			}	
			else
			{
				echo "checkoutdetail.php?orderid=".$orderid;	
			}
			
		} else{
			$_SESSION['msg'] = '<div class="alert alert-success">There must be some issue with placing order.</div>';
			if($getEventDetail['free_event']==1)
			{
				echo "orders.php";	
			}	
			else
			{
				echo "checkoutdetail.php?orderid=".$orderid;	
			}	
		}
	}	
	
?>