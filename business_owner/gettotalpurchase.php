<?php
require('common.php');
$startdate = @date('Y-m-d',@strtotime($_POST['startdate']));
$enddate = @date('Y-m-d',@strtotime($_POST['enddate'])) ;
$ownerid = $_SESSION['business_owner_id'];

if(($startdate!="1970-01-01")&&($enddate=="1970-01-01"))
{
	$db->select('tbl_order_history','SUM(total_amount) AS Total_Amount',null,'owner_id = '.$ownerid.' and order_created_at >= "'.$startdate.'"',null,null);	
}	
if(($startdate=="1970-01-01")&&($enddate!="1970-01-01"))
{
	$db->select('tbl_order_history','SUM(total_amount) AS Total_Amount',null,'owner_id = '.$ownerid.' and order_created_at >="'.$enddate.'"',null,null);	
	
}	
if(($startdate!="1970-01-01")&&($enddate!="1970-01-01"))
{
	$db->select('tbl_order_history','SUM(total_amount) AS Total_Amount',null,'owner_id = '.$ownerid.' and date(order_created_at) BETWEEN "'.$startdate.'" AND "'.$enddate.'"',null,null);	
}	
//SELECT SUM(total_amount) AS Total_Amount  FROM tbl_order_history WHERE order_created_at BETWEEN '2016-06-16' AND '2016-06-17'

$Sales = $db->getResult();
echo ($Sales[0]['Total_Amount'])?$Sales[0]['Total_Amount']:0;

?>