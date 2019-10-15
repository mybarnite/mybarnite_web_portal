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
$refundMethod = $_POST['refundMethod'];

// Skrill refundMethod == 1
if($refundMethod == '1')
{
	$sql = "SELECT * from tbl_businessowner_subscription where id=".$orderid."  and skrill_transaction!=''";
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	if($num_rows1>0)	
	{
		$order = $res->fetch_assoc();
		$transaction_id = $order['skrill_transaction'];
		$mb_transaction_id = $order['skrill_transaction'];
		$amount = $order['totalamount'];
		$url="https://www.moneybookers.com/app/refund.pl?action=prepare&email=mybarnite1@gmail.com&password=ef67bdf54dc84302dd01aa25fbbda876&transaction_id=".$transaction_id."&amount=".$amount."&refund_note=example_note";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = simplexml_load_string($data);
		echo $sid = $xml->sid;
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
					'mb_transaction_id'=>$xml1->mb_transaction_id,
					'is_active'=>'Inactive'
				);	
				$db->update('tbl_businessowner_subscription',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
				$res2 = $db->getResult();
				$lastInsertedId = $res2[0];
			}	
			
			
		}
		
			
		
	}
}


// worldpay refundMethod == 2
if($refundMethod == '2')
{
	$sql = "SELECT * from tbl_businessowner_subscription where id=".$orderid." and payment_status='Refund Requested' and is_authorised='1'";
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	if($num_rows1>0)	
	{
		$order = $res->fetch_assoc();
		/* echo "<pre>";
		print_r($order);  */
		
		$post = [
			'instId' => '1289280',
			'authPW' => 'Sgnd3PYm',
			'cartId'   => $order['cartId'],
			'op'   => 'refund-full',
			'transId'   => $order['transaction_id'],
			'amount'   => ($order['totalPayableAmount'])?$order['totalPayableAmount']:$order['totalamount'],
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
			$db->update('tbl_businessowner_subscription',$array,'id='.$orderid); // Table name, column names and values, WHERE conditions	
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