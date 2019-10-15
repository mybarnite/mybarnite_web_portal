<?php

include('common.php');
$full_name = $_SERVER['PHP_SELF'];
$name_array = explode('/',$full_name);
$count = count($name_array);
$page_name = $name_array[$count-1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your description">
    <meta name="keywords" content="Your keywords">
    <meta name="author" content="Your name">
    
	<link rel="icon" href="../images/favicon.html" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo SITE_PATH;?>images/favicon.html" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/camera.css" type="text/css" media="screen"> 
    <link rel="stylesheet" href="<?php echo SITE_PATH;?>css/style.css" type="text/css" media="screen">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
	
  	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.easing.1.3.js"></script>
  	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/camera.js"></script>
	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jtweet.js"></script>	
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.cookie.js"></script> 
	<script type="text/javascript" src="<?php echo SITE_PATH;?>js/jcarousellite.js"></script>	
  	<script>
        jQuery(document).ready(function(){   
                jQuery('.camera_wrap').camera();
				jQuery('a.prev, a.next, .camera_prev, .camera_next').animate({'opacity':'.45'},10);
				jQuery('a.prev, a.next, .camera_prev, .camera_next').hover(
						function () {
								jQuery(this).animate({'opacity':'1'},150);
						},
						function () {
								jQuery(this).animate({'opacity':'.45'},250);
						}
				);
			

			jQuery(function() { jQuery(".carousel.main").jCarouselLite({ btnNext: ".next", btnPrev: ".prev" }); });
	    });    
  	</script>		
    <script type="text/javascript" src="<?php echo SITE_PATH;?>js/jquery.mobile.customized.min.js"></script>
</head>

<body onload="initialize()">
<div class="bg_center">


<!--==============================Header=================================-->
<header>
    <div class="container">
    	<div class="row">
        	<div class="span5">
            	<div class="clearfix">
                    <div class="clearfix header-block-pad">
                       <a href="<?php echo SITE_PATH;?>"><img src="<?php echo SITE_PATH;?>images/barlogo.png"  width="70%" /></a>					
                    </div>
                </div>
            </div>
			
        	<div class="span7 top_right">
				
				<?php
				
				if(isset($_SESSION['business_owner_id'])){
					
				?>
						<a href="logout.php" style="font-size:15px;" class="listen_live">LOGOUT</a>
						<a style="color:Black; font-size:15px; float:right; " class="on_air"><?php echo substr($_SESSION['business_owner_name'],0,10); ?></a>
						
				<?php 

				}else{
				
				?>
				
				<a href="business_owner_signup.php" class="listen_live">SIGN UP</a>
				<a href="business_owner_signin.php" class="on_air">SIGN IN</a>
				
				<?php } ?> 
						
			</div>
			<div class="span6 top_right">
			</p><img src="<?php echo SITE_PATH;?>images/shopping-basket-xxl.png"  style="float: right;width: 92px;margin-top: -51px;margin-right: 27px;" /></a>
			
			</div>
		</div>   
    </div>
    
    <!--==============================Nav=================================-->          
    <div id="nav_section">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="navbar navbar_ clearfix">
						<div class="navbar-inner navbar-inner_">
							<div class="container">
								<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse_">MENU</a>                                                   
								<div class="nav-collapse nav-collapse_ collapse">
									<ul class="nav sf-menu">
										<li <?php if($page_name=='business_owner_profile.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_profile.php">Profile</a></li>
										<li <?php if($page_name=='business_owner_gallary.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_gallary.php">Bar Gallery</a></li>
										<li <?php if($page_name=='business_owner_events.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_events.php">Events</a></li>
										<li <?php if($page_name=='business_owner_foodmenu.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_foodmenu.php">Food Menu</a></li>
										<li <?php if($page_name=='business_owner_promotions.php'){?> class="active" <?php }?>><a href="#">Promotions</a></li>
										<li <?php if($page_name=='business_owner_settings.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php">Settings</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>   
		</div>
    </div>
	
	 <!--==============================End Nav=================================-->