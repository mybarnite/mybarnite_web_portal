<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

if($_SESSION['id']!=""||$_SESSION['business_owner_id']!="")
{	

?>

<section id="content" class="main-content">
	<div class="container">
		<div class="row clearfix ">
			
			<div class="span12">
				<br/>
				<center><div class="alert alert-danger">Your payment has been cancelled. Please go to your basket and  try again.</div></center>
      			
			</div>		  
		</div>
	</div>
</section>
<?php
}
include('footer.php');
?>