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

$user = $_POST['user'];
$orderid = $_POST['orderid'];
if($user=="Owner")
{
	$sql = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where owner_id =".$_SESSION['business_owner_id']." and o.id=".$orderid ;
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	if($num_rows1>0)	
	{	$order = $res->fetch_assoc();
		
		$transaction_id = $order['skrill_transaction'];
		$mb_transaction_id = $order['skrill_transaction'];
		$amount = $order['payable_amount'];
		$url="https://www.moneybookers.com/app/refund.pl?action=prepare&email=mybarnite1@gmail.com&password=ef67bdf54dc84302dd01aa25fbbda876&transaction_id=".$transaction_id."&amount=".$amount."&refund_note=example_note";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = simplexml_load_string($data);
		$sid = $xml->sid;
		if($sid!="")
		{
			$url="https://www.moneybookers.com/app/refund.pl?action=refund&sid=".$sid;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

			$response = curl_exec($ch); // execute curl request
			curl_close($ch);
			$xml1 = simplexml_load_string($response);
			
			if($xml1->status=='2')
			{
				$array = array(
					
					'payment_status'=>'Refunded',
					'mb_transaction_id'=>$xml1->mb_transaction_id
				);	
				$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
				$res2 = $db->getResult();
				$lastInsertedId = $res2[0];
			}	
			
			
		}	
		
		
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
		
		
		$transaction_id = $order['skrill_transaction'];
		$mb_transaction_id = $order['skrill_transaction'];
		$amount = $order['payable_amount'];
		$url="https://www.moneybookers.com/app/refund.pl?action=prepare&email=mybarnite1@gmail.com&password=ef67bdf54dc84302dd01aa25fbbda876&transaction_id=".$transaction_id."&amount=".$amount."&refund_note=example_note";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = simplexml_load_string($data);
		$sid = $xml->sid;
		if($sid!="")
		{
			$url="https://www.moneybookers.com/app/refund.pl?action=refund&sid=".$sid;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

			$response = curl_exec($ch); // execute curl request
			curl_close($ch);
			$xml1 = simplexml_load_string($response);
			
			if($xml1->status=='2')
			{
				$array = array(
					
					'payment_status'=>'Refunded',
					'mb_transaction_id'=>$xml1->mb_transaction_id
				);	
				$db->update('tbl_order_history',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
				$res2 = $db->getResult();
				$lastInsertedId = $res2[0];
			}	
			
			
		}
		
		
			
		
	}	
}
?>


										