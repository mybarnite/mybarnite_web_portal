<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

   <?php include'header.php'; ?>
<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">
    
		<div class="row">
			<div class="span12">
			<br/><br/>
				<center><h1 style="color:#ff1da5;">Select Your Payment Method</h1></center>
				<br/><br/>
				<div class="span3">
				</div>
				<div class="span3">
					<br/>
					<h4><a href="#">Pay by Card</a></h4>
					<h4><a href="#">Pay by Skrill</a></h4>
					<img src="img/skrill.PNG"/>
				</div>
				<div class="span3">
					<img src="images/barlogo.png" style="width: 100%;"/>
				</div>
			</div>  
			
			<div class="padcontent"></div>
			
		</div>  

  </div>
</section>



	
    <?php include'footer.php'; ?>