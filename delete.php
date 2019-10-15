<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();



$ide=$_REQUEST['ide'];

$delte=mysql_query("DELETE FROM `bar_booking` WHERE `id`=$ide ")or die(mysql_error());










?>
<script>window.location.href='checkoutdetail.php? msg=<h2>Your Order Deleted Succesfull....</h2>'</script>