<?php include '../includes/config.php';

if(isset($_POST['id']))
{
	$id=$_POST['id'];
	$sql = mysql_query("UPDATE `products` SET `featured` = 'N' WHERE `proid` = '".$id."'");
}
?>