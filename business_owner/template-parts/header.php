<?php

include('common.php');
$full_name = $_SERVER['PHP_SELF'];
$name_array = explode('/', $full_name);
$count = count($name_array);
$page_name = $name_array[$count - 1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3914601175484330",
            enable_page_level_ads: true
        });
    </script>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="We understand that sometimes it could be dfificult finding a  place to relax or hangout with friends, colleagues and loved ones. Helping you to find the right place to relax and have a drink is our priority. No more struggling with finding a place to go and enjoy a night regardless of your location. ">
    <meta name="keywords" content="mybarnite,bars,clubs,pubs">
    <meta name="author" content="Mybarnite">

    <link rel="icon" href="<?php echo SITE_PATH; ?>images/barlogo.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo SITE_PATH; ?>images/barlogo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>css/camera.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>css/style.css" type="text/css" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/camera.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jtweet.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jcarousellite.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('.camera_wrap').camera();
            jQuery('a.prev, a.next, .camera_prev, .camera_next').animate({'opacity': '.45'}, 10);
            jQuery('a.prev, a.next, .camera_prev, .camera_next').hover(
                function () {
                    jQuery(this).animate({'opacity': '1'}, 150);
                },
                function () {
                    jQuery(this).animate({'opacity': '.45'}, 250);
                }
            );


            jQuery(function () {
                jQuery(".carousel.main").jCarouselLite({btnNext: ".next", btnPrev: ".prev"});
            });
        });
    </script>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>js/jquery.mobile.customized.min.js"></script>

    <!-- Date Picker  -->
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>datepicker/jquery.timepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH; ?>datepicker/jquery.timepicker.css"/>

    <script type="text/javascript" src="<?php echo SITE_PATH; ?>datepicker/lib/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH; ?>datepicker/lib/bootstrap-datepicker.css"/>

    <script src="https://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
    <script src="https://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
    <!-- Date Picker  -->

    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
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
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-84340404-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- End Google Weekly Report Analysis Code -->
    <script id="mcjs">!function (c, h, i, m, p) {
            m = c.createElement(h), p = c.getElementsByTagName(h)[0], m.async = 1, m.src = i, p.parentNode.insertBefore(m, p)
        }(document, "script", "https://chimpstatic.com/mcjs-connected/js/users/81200f842c77909ee75442f18/75b9f45d7664896cf82ac26fc.js");</script>
</head>

<body>
<div class="bg_center">


    <!--==============================Header=================================-->
    <header>
        <div class="container">

            <div class="row">
                <div class="span4">
                    <div class="clearfix">
                        <div class="clearfix header-block-pad">
                            <?php if ($page_name == 'claim_business.php' || (!isset($_SESSION['business_owner_id']) && $_SESSION['business_owner_id'] == "")) { ?>
                                <a href="<?php echo SITE_PATH; ?>"><img src="<?php echo SITE_PATH; ?>images/barlogo.png"
                                                                        width="70%"/></a>
                            <?php } else {
                                ?>
                                <img src="<?php echo SITE_PATH; ?>images/barlogo.png" width="70%"/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <h1 class="pink">Home of Entertainment</h1>
                </div>
                <div class="span4 top_right">

                    <?php if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false && $_SERVER['HTTP_REFERER'] != '') { ?>
                        <a class="backbtn hide" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
                    <?php }

                    if (isset($_SESSION['business_owner_id']) && !isset($_SESSION['subUserId'])) {

                        ?>
                        <a href="logout.php" style="font-size:15px;" class="listen_live">LOGOUT</a>
                        <a style="color:Black; font-size:15px;"
                           class="on_air"><?php echo substr($_SESSION['business_owner_name'], 0, 10); ?></a>

                        <?php
                    } else if (isset($_SESSION['business_owner_id']) && isset($_SESSION['subUserId'])) {
                        ?>
                        <a href="logout.php" style="font-size:15px;" class="listen_live">LOGOUT</a>
                        <a style="color:Black; font-size:15px;"
                           class="on_air"><?php echo substr($_SESSION['subUserName'], 0, 10); ?></a>
                        <?php
                    } else {

                        ?>

                        <a href="<?php echo SITE_PATH; ?>signup.php" class="listen_live">SIGN UP</a>
                        <a href="<?php echo SITE_PATH; ?>signin.php" class="on_air">SIGN IN</a>

                    <?php } ?>

                </div>
                <div class="span7 top_right">
                    <a><img src="<?php echo SITE_PATH; ?>images/shopping-basket-xxl.png" class="cart-image"/></a>
                </div>
                <div class="span7 top_right get-social">
                    <ul>
                        <li><a href="https://www.instagram.com/mybarnitehomeofclubs/" target="_blank"><i
                                        class="fa fa-instagram">&nbsp;</i></a></li>
                        <li><a href="https://www.linkedin.com/company/mybarnite-limited/" target="_blank"><i
                                        class="fa fa-linkedin">&nbsp;</i></a></li>
                        <li><a href="https://twitter.com/mybarnite" target="_blank"><i class="fa fa-twitter">&nbsp;</i></a>
                        </li>
                        <li><a href="https://www.facebook.com/mybarnitelondon/" target="_blank"><i
                                        class="fa fa-facebook">&nbsp;</i></a></li>
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
                                    <a class="btn btn-navbar" data-toggle="collapse"
                                       data-target=".nav-collapse_">MENU</a>
                                    <div class="nav-collapse nav-collapse_ collapse">
                                        <?php
                                        if (isset($_SESSION['business_owner_id']) && !isset($_SESSION['subUserId'])) {

                                            ?>
                                            <ul class="nav sf-menu">
                                                <li <?php if ($page_name == 'dashboard.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/dashboard.php">Dashboard</a>
                                                </li>

                                                <li <?php if ($page_name == 'business_owner_events.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/business_owner_events.php">Events</a>
                                                </li>
                                                <li <?php if ($page_name == 'business_owner_orders.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/business_owner_orders.php">Orders</a>
                                                </li>
                                                <li <?php if ($page_name == 'business_owner_sales.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/business_owner_sales.php">Sales</a>
                                                </li>
                                                <li <?php if ($page_name == 'business_owner_promotions.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/business_owner_promotions.php">Promotions</a>
                                                </li>
                                                <li <?php if ($page_name == 'contact.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>contact.php">Contact Us</a></li>

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
													<a href="<?php echo SITE_PATH;?>business_owner/business_owner_foodmenu.php" class="sf-with-ul">Food Menu</a>
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
										</li>*/
                                                ?>
                                                <?php /*	<li <?php if($page_name=='index.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>">Home</a></li> */
                                                ?>
                                                <?php /*
										<li <?php if($page_name=='business_owner_profile.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_profile.php">Profile</a></li>
										<li <?php if($page_name=='business_owner_gallary.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_gallary.php">Gallery</a></li>
										<li <?php if($page_name=='business_owner_events.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_events.php">Events</a></li>
										<li <?php if($page_name=='business_owner_foodmenu.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_foodmenu.php">Food Menu</a></li>
										<li <?php if($page_name=='business_owner_subscription.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_subscription.php">Subscription</a></li>
										<li <?php if($page_name=='business_owner_orders.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_orders.php">Orders</a></li>
										<li <?php if($page_name=='business_owner_sales.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_sales.php">Sales</a></li>
										<li <?php if($page_name=='business_owner_promotions.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_promotions.php">Promotions</a></li>
										<li <?php if($page_name=='business_owner_account.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_account.php">Account</a></li>
										<li <?php if($page_name=='business_user_guide.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_user_guide.php">User guide</a></li>
										<li <?php if($page_name=='business_owner_settings.php'){?> class="active" <?php }?>><a href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php">Settings</a></li>
										<?php /*	<li><a href="<?php echo SITE_PATH.'business_owner/'.$bars[0]['file_path'];?>" target="_blank">User guide</a></li> */
                                                ?>
                                                <li <?php if ($page_name == 'blogs.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>blogs.php">Blog</a></li>
                                            </ul>
                                            <?php
                                        } else if (isset($_SESSION['business_owner_id']) && isset($_SESSION['subUserId'])) {
                                            ?>
                                            <ul class="nav sf-menu">
                                                <li <?php if ($page_name == 'subuser_dashboard.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/subuser_dashboard.php">Dashboard</a>
                                                </li>
                                                <li <?php if ($page_name == 'business_owner_settings.php') { ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SITE_PATH; ?>business_owner/business_owner_settings.php">Edit
                                                        profile</a></li>
                                            </ul>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--==============================End Nav=================================-->