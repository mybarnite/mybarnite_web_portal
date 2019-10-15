<?php 
	
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');

$db = new business_owner();
$db->connect();


$orderid = $_POST['orderid'];

$sql = "SELECT * from tbl_businessowner_subscription where id=".$orderid;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;
if($num_rows1>0)	
{
	$order = $res->fetch_assoc();
	/* echo "<pre>";
	print_r($order); */
	
	$post_url = "https://mdepayments.epdq.co.uk/ncol/test/maintenancedirect.asp";
 	$post_values = array(
                    
		// the API Login ID and Transaction Key must be replaced with valid values
		"PSPID"            => "mybarnite",
		"ORDERID"        => $order['transaction_id'],
		"PAYID"            => '',
		"USERID"        => "mybarnite1",
		"PSWD"            => "fE5(hHF0V%",
		"OPERATION"            => "RFS",//capture payment
		"AMOUNT"            => $order['payable_amount']*100,//Amount to be paid MULTIPLIED BY 100, as the format of the amount must not contain any decimals or other separators.
	);
	
	$post_string = "";
    
	foreach( $post_values as $key => $value )
    { 
		$post_string .= "$key=" . urlencode( $value ) . "&"; 
	}
    
	$post_string = rtrim( $post_string, "& " );
              
	$request = curl_init($post_url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_HTTPHEADER, ["application/x-www-form-urlencoded"]);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
	$post_response = curl_exec($request); // execute curl post and store results in $post_response
	
	curl_close ($request); // close curl object
	if($post_response === false)
	{
		echo 'Curl error: ' . curl_error($request);
	}    
	//$post_response response is in xml format
	$simplexml_response = simplexml_load_string($post_response);

	$simplexml_response_array = (array) $simplexml_response;//Convert to array because it is easier to manager for response object name start with @
  
	$respon = $simplexml_response_array['@attributes'];
	
	
}	

	
	
?>