<?php include '../includes/config.php';

if(isset($_POST['id']))
{
	$id=$_POST['id'];
	$sql = mysql_query("UPDATE `products` SET `popular` = 'N' WHERE `proid` = '".$id."'");
}
?>