<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php include'head.php'; ?>
	<title>Mybarnite - Sign In</title>
	<meta name="keywords" content="Sign In for Best Bars,Nightclubs & Pubs bookings">
	<meta name="description" content="Sign In for Best Bars,Nightclubs & Pubs bookings">
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
				<a href="twitterlogin/twitter_login.php"><img src="img/twitter.png" alt="twitter sign in"/></a>
				<a href="fb/fbconfig.php"><img src="img/facebook.png" alt="facebook sign in" /></a>
			</center>
		</div>	
	</div>		
    <div class="row">
        <div class="span3">&nbsp;</div>
		<div class="span6">
			<center>	
				<div id="fields" class="contact-form sign-in-form">
					<form id="ajax-contact-form" class="form-horizontal" method="post">
						<br><br>
						<center><input formaction="usersignin.php"  type="submit" class="btn submit btn-primary sign-in-btn" value="User SignIn"></center><br>
						<br><br>
						<center><input formaction="business_owner/business_owner_signin.php"  type="submit" class="btn submit btn-primary sign-in-btn" value="SignIn for Businessowner"> </center>
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