<?php
 
 
 $host='localhost';
	$uname='msglobal_barnite';
	$pwd='Sg?#Ltt1C=ca';
	$db="msglobal_barnite";

	$con = mysql_connect ('localhost','msglobal_barnite', 'Sg?#Ltt1C=ca' ) or die ( mysql_error() );

	mysql_select_db ( $db, $con ) or die (mysql_error());
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
//require_once __DIR__ . '/db_connect.php';
 
// connecting to db
//$db = new DB_CONNECT();
 
// get all products from products table
$word = $_POST['cat'];
	$post = $_POST['post'];

		  $word .= '';
		  $post .= '%';
    //fetch table rows from mysql db
    $sql = " SELECT  id,Business_name,address,Rating FROM bars_list WHERE  ( Zipcode like ('".$post."') or Business_Name like ('".$post."')) and Category = ('".$word."') limit 5";
    //print_r($sql);
	$count;
$result = mysql_query($sql) or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["products"] = array();
	
	$count =0;
    while ($row = mysql_fetch_array($result)) {
        // temp user array id,Business_name,address,Rating
		
        $product = array();
        $product["id"] = $row["id"];
        $product["Business_name"] = $row["Business_name"];
        $product["address"] = $row["address"];
        $product["Rating"] = $row["Rating"];
       // $product["updated_at"] = $row["updated_at"];
	   //echo $count++;
	   //print_r($product);
	  // echo '<br>';
	   
 
        // push single product into final response array
        array_push($response["products"], $product);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response json_encode($rows);
    echo json_encode($response);
  
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>