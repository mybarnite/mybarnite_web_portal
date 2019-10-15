    <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
	
		<meta property="og:site_name" content="<?php echo $site_name;?>">
		
		<meta property="og:title" content="<?php echo $title;?>">
		<meta property="og:description" content="<?php echo $description;?>">
		<?php /*<meta property="og:image" content="<?php echo "$myUrl/business_owner/".$image;?>">*/?>
		<meta property="og:image" content="https://mybarnite.com/images/barlogo.png">
		
		<meta property="fb:app_id" content="579821348728041">
		<meta property="fb:admins" content="579622216,709634581">

	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
    <meta name="author" content="Mybarnite">
    <link rel="icon" href="images/favicon.html" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo SITE_PATH;?>images/barlogo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/camera.css" type="text/css" media="screen"> 
    <link rel="stylesheet" href="css/style.css?new" type="text/css" media="screen">
	
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	
	
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
			if($page_name == 'usersignin.php'){?>
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
	<style>
		.padding-style ul li a{padding:13px 0px 1px 4px	!important;}
		/* Smartphones (landscape) ----------- */
@media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
.searchtxt{width:220px !important;}}

@media only screen and (max-device-width: 480px) {
      .smScreen {
        display: block;
      }
      .lgScreen {
        display: none;
      }
    }

 @media only screen and (min-device-width: 481px) {
      .smScreen {
        display: none;
      }
      .lgScreen {
        display: block;
      }
    }

	</style>
	<script type="text/javascript" src="js/jquery.js"></script>

</head>

<body>
<div id="fb-root"></div>
<script>/* (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&version=v2.7&appId=579821348728041";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk')); */</script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '393374527798615',
      xfbml      : true,
      version    : 'v3.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script><div class="bg_center">


<!--==============================Header=================================-->
<header>
    <div class="container">
		<div class="row">
        	<div class="span4">
            	<div class="clearfix">
                    <div class="clearfix header-block-pad">
                       <a href="https://mybarnite.com/"><img src="<?php echo SITE_PATH;?>images/barlogo.png" alt="mybarnite logo"  width="70%" /></a>										
                    </div>
                </div>
            </div>
			<div class="span4 align-center heder-title-width">
				<h1 class="pink">Home of Entertainment</h1>
			</div>
        	<div class="span4 top_right">
        	
				<?php
				#echo $_SESSION['id'];exit;
				#echo md5("SB123#");
				#echo "<pre>";
				#print_r($_SESSION['request_vars']);
				if((isset($_SESSION['status']) && $_SESSION['status']=='verified')||isset($_SESSION['business_owner_id'])){
					$screenname = ($_SESSION['request_vars']['screen_name'])?$_SESSION['request_vars']['screen_name']:$_SESSION['business_owner_name'];
				?>
						<a href="logout.php" class="listen_live">LOGOUT</a>
						<a style="color:Black; font-size:18px;" class="on_air"><?php echo substr($screenname,0,10); ?></a>
				<?php
					
				}
				else
				{
					if(isset($_SESSION['FULLNAME'])||isset($_SESSION['business_owner_name'])){      
						$UserName = ($_SESSION['FULLNAME'])?$_SESSION['FULLNAME']:$_SESSION['business_owner_name'];
				?>	
						<a href="logout.php" class="listen_live">LOGOUT</a>
						<a class="on_air" style="color:Black; font-size:18px;" ><?php echo substr($UserName,0,10); ?></a>
				<?php 
				} 
				else
				{
					if( (!isset($_SESSION['username'])) && (!isset($_SESSION['memberusername'])) && (!isset($_SESSION['business_owner_name'])) ) {
				?>
					<a href="signup.php" class="listen_live">SIGN UP</a>
					<a href="signin.php" class="on_air">SIGN IN</a>
				<?php 
				} 
				?> 
						<?php  if(isset($_SESSION['username'])){ ?>
						<a href="logout.php" class="listen_live">LOGOUT</a>
						<a style="color:Black; font-size:18px;" class="on_air"><?php echo substr($_SESSION['username'],0,10); ?></a>
						
						<?php }elseif(isset($_SESSION['memberusername'])){ ?>
						<a href="logout.php" class="listen_live">LOGOUT</a>
						<a style="color:Black; font-size:18px; " class="on_air"><?php echo substr($_SESSION['memberusername'],0,10); ?></a>
						
				<?php }   }  } ?>
				
			</div>


		<?php if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false) { if($_SERVER['HTTP_REFERER'] != ''){ ?>
			        <a class="backbtn" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> 
			<?php } } ?> 			
			
			<?php
			if(isset($_SESSION['id'])&&$_SESSION['id']!="")
			{	
			?>
			<div class="span7 top_right">
				<a href="orders.php">
					<img src="images/shopping-basket-xxl.png" alt="shopping cart" class="cart-image"/>
				</a>
			</div>	
			<?php
			}
			else
			{	
			?>	
			<div class="span7 top_right">
				<img src="images/shopping-basket-xxl.png" alt="shopping cart" class="cart-image" />
			</div>	
			<?php
			}
			?>
			<div class="span7 top_right get-social">
				<ul>
					<li><a href="https://www.instagram.com/mybarnitehomeofclubs/" target="_blank"><i class="fa fa-instagram">&nbsp;</i></a></li>
					<li><a href="https://www.linkedin.com/company/mybarnite-limited/" target="_blank"><i class="fa fa-linkedin">&nbsp;</i></a></li>
					<li><a href="https://twitter.com/mybarnite" target="_blank"><i class="fa fa-twitter">&nbsp;</i></a></li>
					<li><a href="https://www.facebook.com/mybarnitelondon/" target="_blank"><i class="fa fa-facebook">&nbsp;</i></a></li>
				</ul>
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
						  <?php
						  if(!isset($_SESSION['business_owner_id']))
						  { 
							
						  ?>
                            <li <?php if($page_name=='index.php'){?> class="active" <?php }?>><a href="index.php">Home</a></li>
			    <li <?php if($page_name=='bars-pubs-list.php'){?> class="active lgScreen" <?php } else{?> class="lgScreen" <?php }?>><a href="bars-pubs-list.php">Night Clubs, Bars & Restaurants</a></li>
			    <li <?php if($page_name=='bars-pubs-list.php'){?> class="active smScreen" <?php } else{?> class="smScreen" <?php }?>><a href="bars-pubs-list.php">Night Clubs & Bars</a></li>
                            <li <?php if($page_name=='events.php'){?> class="active" <?php }?>><a href="events.php">Events</a></li>
							<li <?php if($page_name=='promotion.php'){?> class="active" <?php }?>><a href="promotion.php">Venues & Promotions</a></li>
							<li <?php if($page_name=='contact.php'){?> class="active" <?php }?>><a href="contact.php">Contact Us</a></li>	
							<?php
							if(isset($_SESSION['id']))
							{ 
							?>
							<?php /*
							<li <?php if($page_name=='profile.php'){?> class="active" <?php }?>>
								<a href="#a" class="sf-with-ul">User account</a>
								<ul style="display: none;">
									<li>
										<a href="profile.php">Profile</a>
									</li>
									<li>
										<a href="user_gallery.php">Gallery</a>
									</li>
									<li class="current">
										<a href="orders.php" class="sf-with-ul">Orders</a>
									</li>
									<li class="">
										<a href="myfavourites.php" class="sf-with-ul">My Favourite</a>
									</li>
									<li class="">
										<a href="myblogs.php" class="sf-with-ul">My Blog</a>
									</li>
									<li>
										<a href="editprofile.php" class="sf-with-ul">Settings</a>
									</li>
								</ul>
							</li>*/?>
							<?php
							}
							?>
							<li <?php if($page_name=='blogs.php'){?> class="active" <?php }?>><a href="blogs.php">Blog</a></li>
							<?php
							if(isset($_SESSION['id'])||isset($_SESSION['FULLNAME']))
							{
							?>
							<li <?php if($page_name=='dashboard.php'){?> class="active" <?php }?>><a href="dashboard.php">Dashboard</a></li>	
							
							<?php
							/*
							?>
							<li <?php if($page_name=='user_gallery.php'){?> class="active" <?php }?>><a href="user_gallery.php">Gallery</a></li>
							<li <?php if($page_name=='orders.php'){?> class="active" <?php }?>><a href="orders.php">Orders</a></li>
							<li <?php if($page_name=='myfavourites.php'){?> class="active" <?php }?>><a href="myfavourites.php">My Favourite</a></li>
							
							<li <?php if($page_name=='editprofile.php'){?> class="active" <?php }?>><a href="editprofile.php">Settings</a></li>
							
							<?php
							
							?>
							<li <?php if($page_name=='profile.php'){?> class="active" <?php }?>>
								<a href="#a" class="sf-with-ul">2User account</a>
								<ul style="display: none;">
									
									<li>
										<a href="user_gallery.php">Gallery</a>
									</li>
									<li class="current">
										<a href="orders.php" class="sf-with-ul">Orders</a>
									</li>
									<li class="">
										<a href="myfavourites.php" class="sf-with-ul">My Favourite</a>
									</li>
									<li class="">
										<a href="myblogs.php" class="sf-with-ul">My Blog</a>
									</li>
									
								</ul>
							</li>	
							<?php
							*/
							}
							?>
							
						  <?php 
						  }
						  else
						  {
						  ?>
							
							<?php/* <li <?php if($page_name=='index.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>">Home</a></li> */?>
							
							<?php /*
							<li <?php if($page_name=='business_owner_profile.php'){?> class="active" <?php }?>>
								<a href="<?php echo SITE_PATH;?>business_owner/business_owner_profile.php">Profile</a>
							</li>
							<li <?php if($page_name=='business_owner_gallary.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_gallary.php">Gallery</a></li>
							<li <?php if($page_name=='business_owner_foodmenu.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_foodmenu.php">Food Menu</a></li>
							<li <?php if($page_name=='business_owner_subscription.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_subscription.php">Subscription</a></li>
							<li <?php if($page_name=='business_owner_settings.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php">Settings</a></li>
							<li <?php if($page_name=='business_owner_account.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_account.php">Account</a></li>
							*/?>
							<li <?php if($page_name=='dashboard.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/dashboard.php">Dashboard</a></li>
						
							<li <?php if($page_name=='business_owner_events.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_events.php">Events</a></li>
							<li <?php if($page_name=='business_owner_orders.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_orders.php">Orders</a></li>
							<li <?php if($page_name=='business_owner_sales.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_sales.php">Sales</a></li>
							<li <?php if($page_name=='business_owner_promotions.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_promotions.php">Promotions</a></li>
							<?php /*<li <?php if($page_name=='about.php'){?> class="active" <?php }?>><a href="about.php">About Us</a></li>*/?>
                            <li <?php if($page_name=='contact.php'){?> class="active" <?php }?>><a href="contact.php">Contact Us</a></li>	
							
							<?php /*
							<li>
								<a href="#a" class="sf-with-ul">User account</a>
								<ul style="display: none;">
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/manage_bar_profile.php">Add Bar/Venue Booking</a>
										
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_owner_gallary.php">Gallery</a>
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_owner_foodmenu.php" class="sf-with-ul">Food menu</a>
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_owner_subscription.php" class="sf-with-ul">Subscription</a>
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_owner_account.php" class="sf-with-ul">Account</a>
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/myblogs.php" class="sf-with-ul">My Blog</a>
									</li>
									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_user_guide.php" class="sf-with-ul">User Guide</a>
									</li>

									<li>
										<a href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php" class="sf-with-ul">Settings</a>
									</li>
								</ul>
							</li>*/?>
							<li <?php if($page_name=='blogs.php'){?> class="active" <?php }?>><a href="../blogs.php">Blog</a></li>
						<?php
						  }
						?>	
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