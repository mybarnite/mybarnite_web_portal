
<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
include'head.php';
?>
<title>Best bars, pubs and nightclubs | About Mybarnite</title>
<meta name="keywords" content="Best bars, pubs and nightclubs">
<meta name="description" content="Our business is to let you know about what is happening in your locality and events going on in the best bars, pubs and nightclubs and others. Contact us today.">
<?php include'header.php'; ?>

<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">
	
    <div class="row ">
	  <div class="clearfix ">
    	<div class="span6">
          <h1>About Us</h1>
		  <div class="max-size1 font-color-white">
				<?php
				$getcontent = mysql_query("select * from maincontent where slugname='about-us'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
		  </div>
		  <div class="padcontent"></div>
        </div>
    	
    	<div class="span6">
          <h2 class="h2-margin">Customer Services</h2>
		  <img src="images/img7.jpg" alt="Best bars, pubs and nightclubs"  border="0" class="alignleft "/>
		  <div class="table">
			<?php
				$getcontent = mysql_query("select * from maincontent where slugname='customer-service'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
			<div class="padcontent"></div>
		  </div>
        </div>
	  </div>
    </div> 

  </div>
</section>
<?php include'footer.php'; ?>