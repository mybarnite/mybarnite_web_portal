<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php include'head.php'; ?>
	<title>Mybarnite - Sign Up</title>
	<meta name="keywords" content="Sign Up for Best Bars,Nightclubs & Pubs">
	<meta name="description" content="Sign Up for Best Bars,Nightclubs & Pubs">
   <?php include'header.php'; ?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
    <div class="row">
		<div class="span12">
			<center>
				<h2 class="pink">How can we help as a Visitor or Business owner ?</h2>
			</center>	
		</div>		  
    </div>
	<div class="row">
		<div class="span3">&nbsp;</div>
		<div class="span6">
			<center>
				<div id="fields" class="contact-form">
					<form id="ajax-contact-form" class="form-horizontal" method="post">
						
						<br>
						<br>
						<input formaction="usersignup.php"  type="submit" class="btn submit btn-primary " value="User SignUp">
						<br>
						<br>
						<br>
						
						<input formaction="business_owner/business_owner_signup.php"  type="submit" class="btn submit btn-primary " value="Businessowner SignUp">
						<div class="clearfix"></div>
					</form>
				</div>    
			</center>	
		</div>
		<div class="span3">&nbsp;</div>		
    </div>
  </div>
</section>




   <?php include'footer.php'; ?>