<?php

session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();
$full_name = $_SERVER['PHP_SELF'];
$name_array = explode('/',$full_name);
$count = count($name_array);
$page_name = $name_array[$count-1];
$id=(isset($_SESSION['id'])&&$_SESSION['id']!="")?@$_SESSION['id']:"";
unset($_SESSION['msg']);
if($id=="")
{
	include'head.php';
?>
<title>Mybarnite - Dashboard</title>
	<meta name="keywords" content="Nightclubs, Pubs, Bars, Nightclubs near me, Pubs near me, Bars near me">
	<meta name="description" content="View the event details, booking information, promotions and opening hours">
   <?php include'header.php'; ?>
<div class="padcontent"></div>
<!--==============================Content=================================--> 
<section id="content"  class="main-content">
	<div class="container" id="events_container">
		<div class="row ">
			<div class="clearfix ">
				<div class="span12">
				<h5>You are not Logged in yet. Please <a href="usersignin.php" style="color:#3179d8;">login </a></h5>
				</div>
			</div>
		</div>	
	</div>
</section>
<?php include'footer.php'; ?>

<?php
}else{
	

$db->select('user_register','*',NULL,'id="'.$id.'" and r_id="2"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$result = $db->getResult();
$isOptOutUser = $result[0]['is_opt_out'];
$userName = $result[0]['name'];
 
/* $sql = "SELECT u.*,b.Business_Name from user_register as u join bars_list as b on b.Owner_id = u.id where u.id=".$id." and u.r_id='1'" ;
$res = $db->myconn->query($sql);
$getData = $res->fetch_assoc();
$isOptOutUser = $getData['is_opt_out'];
$businessName = $getData['Business_Name'];
 */
 ?>
<html !DOCTYPE>
<head>
    <title>Mybarnite - Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="We understand that sometimes it could be dfificult finding a  place to relax or hangout with friends, colleagues and loved ones. Helping you to find the right place to relax and have a drink is our priority. No more struggling with finding a place to go and enjoy a night regardless of your location. ">
    <meta name="keywords" content="mybarnite,bars,clubs,pubs">
    <meta name="author" content="Mybarnite">
    
	<link rel="icon" href="<?php echo SITE_PATH;?>images/barlogo.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo SITE_PATH;?>images/barlogo.png" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/camera.css" type="text/css" media="screen"> 
    
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH;?>datepicker/jquery.timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH;?>datepicker/lib/bootstrap-datepicker.css" />
	
    
	<!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
	 <link rel="stylesheet" href="../css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	
	 <style>
		.wrapper {display: flex;align-items: stretch;}
		#sidebar {min-width: 250px;max-width: 250px;min-height: 100vh;}
		#sidebar.active {margin-left: -250px;}
		a[data-toggle="collapse"] {	position: relative;}
		a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {content: '\e259';display: block;position: absolute;right: 20px;font-family: 'Glyphicons Halflings';font-size: 0.6em;}
		a[aria-expanded="true"]::before {content: '\e260';}
		@media (max-width: 768px) {
			#sidebar {margin-left: -250px;}
			#sidebar.active {margin-left: 0;}
		}
		body {font-family: Arial, Helvetica, sans-serif;font-size: 12px;line-height: 20px;color: #9393a7;background: #16151f url(../images/bg_top.jpg) 50% top repeat-x;}
		p {font-family: 'Poppins', sans-serif;font-size: 1.1em;font-weight: 300;line-height: 1.7em;color: #999;}
		a, a:hover, a:focus {color: inherit;text-decoration: none;transition: all 0.3s;}
		#sidebar {
		/* don't forget to add all the previously mentioned styles here too */
		background: #1a1a21;color: #fff;transition: all 0.3s;}
		#sidebar .sidebar-header {/* padding: 20px; */background: #101014;}
		#sidebar ul.components {padding: 20px 0;border-bottom: 1px solid #101014;}
		#sidebar ul p {color: #fff;padding: 10px;}
		#sidebar ul li a {padding: 10px;font-size: 1.1em;display: block;}
		#sidebar ul li a:hover {color: #fff;background: #101014;}
		#sidebar ul li.active > a, a[aria-expanded="true"] {color: #fff;background:#101014;}
		ul ul a {font-size: 0.9em !important;padding-left: 30px !important;   background: #101014;}
		#sidebar ul li a .fa{margin-right:5%;}
		#sidebarCollapse{color:#fff !important;}
		.sidebar-header-logo{height: 27.5%;width: 100%;}
	</style>
</head>
<body>


    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
	
	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.easing.1.3.js"></script>
  	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/camera.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jtweet.js"></script>	
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.cookie.js"></script> 
	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jcarousellite.js"></script>	
  	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.mobile.customized.min.js"></script>
	
	<!-- Date Picker  -->
	<script type="text/javascript" src="<?php echo SITE_PATH;?>datepicker/jquery.timepicker.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PATH;?>datepicker/lib/bootstrap-datepicker.js"></script>
	<script src="https://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
	<script src="https://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
	
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-3914601175484330",
		enable_page_level_ads: true
	  });
	</script>
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1918966981681705'); // Insert your pixel ID here.
		fbq('track', 'PageView');
		<?php 
			if($page_name == 'business_owner_signin.php'){?>
			fbq('track', 'CompleteRegistration');
		<?php }?>
	</script>
	<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=1918966981681705&ev=PageView&noscript=1"/>
	</noscript>
		<!-- DO NOT MODIFY -->
	<!-- End Facebook Pixel Code -->
	
	<!-- Google Weekly Report Analysis Code -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-84340404-1', 'auto');
	  ga('send', 'pageview');

	</script>
	<!-- End Google Weekly Report Analysis Code -->
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/81200f842c77909ee75442f18/75b9f45d7664896cf82ac26fc.js");</script>
	
	<div class="wrapper">
		<?php 
		if(isset($_SESSION['id']))
		{
		?>	
		<!-- Sidebar -->
		<nav id="sidebar">
			<!-- Sidebar Header -->
			<div class="sidebar-header">
				<img src="https://mybarnite.com/images/barlogo.png" alt="mybarnite logo" class="sidebar-header-logo"/>
			</div>

			<!-- Sidebar Links -->
			<ul class="list-unstyled components">
			<?php if($isOptOutUser!=1){?>
				<li <?php if($page_name==''){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li <?php if($page_name=='profile.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Profile</a></li>
				<li <?php if($page_name=='user_gallery.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>user_gallery.php"><i class="fa fa-picture-o" aria-hidden="true"></i>Gallery</a></li>
				<li <?php if($page_name=='orders.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>orders.php"><i class="fa fa-file-text" aria-hidden="true"></i>Orders</a></li>
				<li <?php if($page_name=='myfavourites.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>myfavourites.php"><i class="fa fa-star" aria-hidden="true"></i>My Favourite</a></li>
				<li <?php if($page_name=='myblogs.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>myblogs.php"><i class="fa fa-rss-square"></i>My Blog</a></li>
				<li <?php if($page_name=='editprofile.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>editprofile.php"><i class="fa fa-cog"></i>Settings</a></li>
			<?php }else{?>
				<li><a href="#" id="deleteAccount"><i class="fa fa-user-times" aria-hidden="true"></i>Delete Account</a></li>
			<?php }
				if(isset($_SESSION['id']))
				{
				?>
				<li><a href="<?php echo SITE_PATH;?>logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
				<?php }?>
				<!--<li> Link with dropdown items
					<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
					<ul class="collapse list-unstyled" id="homeSubmenu">
						<li><a href="#">Page</a></li>
						<li><a href="#">Page</a></li>
						<li><a href="#">Page</a></li>
					</ul>-->

				
			</ul>
		</nav>
		<?php }?>	
		<!-- Page Content -->
		<div id="content" class="container">
			<?php 
			if(isset($_SESSION['id']))
			{
			?>	
			<div class="col-md-12">
				<button type="button" id="sidebarCollapse" class="btn bg-pink navbar-btn">
					<i class="glyphicon glyphicon-align-left"></i>
					Toggle Sidebar
				</button>
			</div>
			<div class="col-md-12">
				<h2 class="align-center">Welcome to User Panel <?php echo $userName;?></h2>
			</div>
			<div class="col-md-10">
				<div id="errMsg"></div>
			</div>	
			<?php if($isOptOutUser!=1){?>
			<div class="col-md-5 align-center" style="background:#15161f;padding:4%;margin:0 3px 3px 0;">
				<h2 style="text-transform: capitalize;"><a href="<?php echo SITE_PATH?>events.php" class="btn btn-color">Book Events</a></h2>
				<span class=""> 
					<i class="fa fa-calendar fa-5x" style="padding-top: 11%;color: #E4287C;" aria-hidden="true"></i> 
					
				</span>
			</div>
			<div class="col-md-5 align-center" style="background:#15161f;padding:4%;margin:0 3px 3px 0;">
			
				<h2 style="text-transform: capitalize;"><a href="<?php echo SITE_PATH;?>" class="btn btn-color">Book Venue</a></h2>
				<span class=""> 
					<i class="fa fa-map-marker fa-5x" style="padding-top: 11%;color: #E4287C;" aria-hidden="true"></i> 
					
				</span>
			</div>
			<div class="col-md-10 align-center" style="background:#15161f;padding:4%;margin:0 3px 3px 0;">
			
				<h2 style="text-transform: capitalize;"><a href="<?php echo SITE_PATH;?>promotion.php" class="btn btn-color">View Venue and Promotions</a></h2>
				<span class=""> 
					<i class="fa fa-gift fa-5x" style="color: #E4287C;" aria-hidden="true"></i> 
					
				</span>
			</div>
			<?php }?>
			<div id="fields" class="col-md-10" style="background:#15161f;padding:2%;">
				<form id="ajax-contact-form" class="form-horizontal edit_profile" method="post">
					
						<div class="form-check">
							<label class="form-check-label" for="checkbox100">Opt-in:
							<input type="radio" name="radiobtn" class="form-check-input pull-left" id="checkbox100" value="0" <?php if($isOptOutUser==0){ echo "checked";}?>>
							 I have read and agreed to Mybarnite Limited <a target="_blank"  style="color:#3179d8;" href="<?php echo SITE_PATH;?>/terms.php">Terms and Conditions</a> & <a target="_blank"  style="color:#3179d8;" href="<?php echo SITE_PATH;?>/policy.php">Privacy Policy</a></label>
						</div>

						<div class="form-check">
							<label class="form-check-label" for="checkbox100">Opt-Out:
							<input type="radio" name="radiobtn" class="filled-in form-check-input pull-left" id="checkbox101" value="1" <?php if($isOptOutUser==1){ echo "checked";}?>>
							We may contact you about products and services, unless you select Opt-Out from the <a target="_blank"  style="color:#3179d8;" href="<?php echo SITE_PATH;?>/terms.php">Terms and Conditions</a> & <a target="_blank"  style="color:#3179d8;" href="<?php echo SITE_PATH;?>/policy.php">Privacy Policy</a></label>
						</div>
						<input type="button" class="btn bg-pink" value="Continue" style="color:#fff;">
					
				</form>
			</div>
		<?php
			}
		else
		{
		?>
		<div class="col-md-12">
				<h5>You are not Logged in yet. Please <a href="usersignin.php">login </a></h5>
		</div>	
		<?php
			
		}
		?>
		</div>
		
	</div>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
	<script>
		function deleteUserAccount(userId,rId){
			$.ajax({
					type: "POST",
					url: "https://mybarnite.com/admin/deleteUserAccount.php",
					data: {userId :userId,rId :rId},
					success: function(result){
						//location.reload(true);
						//alert(result);
						 //$("#errMsg").html(result);return false;
						 //popUpWarningMessage(isOptInOut);
						 //setTimeout("window.location='logout.php'", 1500);
						 $.confirm({
								title: 'Success!',
								content: 'Your account has been deleted successfully! Confirmation email will be sending you shortly.',
								type: 'red',
								typeAnimated: true,
								columnClass: 'col-md-6 col-md-offset-4',
								buttons: {
									tryAgain: {
										text: 'Ok',
										btnClass: 'btn-red',
										action: function(){
											//location.reload(true);
											window.location='logout.php';
										}
									}
								}
								
							});
					},
					error: function(){
						//alert("failure");
					}
			   });
		}
		function popUpWarningMessage(isOptInOut,userId){
			
			if(isOptInOut==1){
				var content = 'Dear value customer you may not be able to use your account if you Opt-Out, as we need your consent to process your transactions with the details that you provided to us. Likewise, send you interesting offers in the future. We would need your consent according to the new General Data Protection Right(GDPR) regulation. This is available when you Opt-In to our privacy policy which was designed to protect your right, so that you can control the use of your data. Would you like to proceed to delete your account?';
				var text = "Proceed";
			}else{
				var content = "Dear valuable customer, please check and agree with our <a target='_blank' href='https://mybarnite.com/policy.php' style='color: blue;   text-decoration: underline;'>Privacy Policy</a>";
				var text = "I Agree!";
			}
			$.confirm({
					title: 'Important!',
					content: content,
					type: 'red',
					typeAnimated: true,
					columnClass: 'col-md-6 col-md-offset-4',
					buttons: {
						tryAgain: {
							text: text,
							btnClass: 'btn-red',
							action: function(){
								//location.reload(true);
								if(isOptInOut==1){
									$.confirm({
										title: 'Important!',
										content: 'Are sure you want to delete your account? if you proceed, all your data will be delete from our system.',
										type: 'red',
										typeAnimated: true,
										columnClass: 'col-md-6 col-md-offset-4',
										buttons: {
											tryAgain: {
												text: 'Proceed',
												btnClass: 'btn-red',
												action: function(){
													deleteUserAccount(userId,2);	
													
												}
											},
											close: function () {
											}
										}
										
									});
									//deleteUserAccount(userId,2);	
								}else{
									updateUserForOptInOut(isOptInOut,userId);
								
								}
								
							}
						},
						close: function () {
						}
					}
					
				});
		}
		function updateUserForOptInOut(isOptInOut,userId){
		if(isOptInOut){
				//alert("Your are a - " + radioValue);
				$.ajax({
					type: "POST",
					url: "https://mybarnite.com/common-files/updateOptinOptOutUser.php",
					data: {userId :userId,isOptInOut :isOptInOut},
					success: function(result){
						//location.reload(true);
						 $("#errMsg").html(result);
						 //popUpWarningMessage(isOptInOut);
						 setTimeout("location.reload(true)", 1000);;
					},
					error: function(){
						//alert("failure");
					}
			   });
			}else{
				
			}
		}
		function sendNotificationToAdmin(userId){
				$.ajax({
					type: "POST",
					url: "https://mybarnite.com/common-files/sendNotificationToAdmin.php",
					data: {userId :userId,rId:2},
					success: function(result){
						//alert(result);
						//location.reload(true);
						 $("#errMsg").html(result);
						 //popUpWarningMessage(isOptInOut);
						 setTimeout("location.reload(true)", 2000);

					},
					error: function(){
						//alert("failure");
					}
			   });
		}
		$(document).ready(function () {

			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
			});
			$("input[type='button']").click(function(){
				var isOptInOut = $("input[name='radiobtn']:checked").val();
				var userId = <?php echo $id;?>;
				popUpWarningMessage(isOptInOut,userId);
				
			});
			$("#deleteAccount").click(function(){
				var userId = <?php echo $id;?>;
				$.confirm({
					title: 'Warning!',
					content: 'Are you sure? Do you want to delete your account.',
					type: 'red',
					typeAnimated: true,
					columnClass: 'col-md-6 col-md-offset-4',
					buttons: {
						tryAgain: {
							text: 'Yes',
							btnClass: 'btn-red',
							action: function(){
								//location.reload(true);
								sendNotificationToAdmin(userId);
							}
						},
						close: {
							text: 'No',
							btnClass: 'btn-red',
							action: function(){
								//location.reload(true);
								//sendNotificationToAdmin(userId)
							}
						}
					}
				});
				
			});
		});
	</script>	
</body>
</html>
<?php }	?>