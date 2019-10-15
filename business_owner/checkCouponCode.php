<?php
require('common.php');
$code = $_POST['code'];
$action = $_POST['action'];
if($code!="")
{	
	if($action=="Add")
	{
		$sql = $db->select('tbl_promotions','couponcode',null,'couponcode ="'.$code.'"',null);  // Table name, WHERE conditions
	}
	else if($action=="Update")
	{	
		$id=$_POST['id'];
		$sql = $db->select('tbl_promotions','couponcode',null,'couponcode ="'.$code.'" and id!='.$id,null);  // Table name, WHERE conditions
	}	
	$res = $db->getResult(); 	
	$numRows = count($res); 
	if($numRows>0)
	{
		echo "<i class='fa fa-times red' style='font-size:20px;'></i> Click here to generate";
	}	
	else
	{
		echo "<i class='fa fa-check pink' style='font-size:20px;'></i>";
	}	
}
else
{
	echo "Generate new coupon code.";
}
	
?>