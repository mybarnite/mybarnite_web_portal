<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>


<?php include'header.php'; ?>

</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
		<div class="row clearfix ">
        	<div class="span12">
				<h2>Free Cancellation Policy</h2>
			</div>		  
		</div>
		<div class="row clearfix ">
        	<div class="span12">
				<div class="max-size1" style="color:#fff">
					<?php
					$getcontent = mysql_query("select * from maincontent where slugname='free-cancellation'");
					$fetchContent = mysql_fetch_assoc($getcontent);
					echo $fetchContent['message'];
					?>
				</div>
				<div class="padcontent"></div>
			</div>
		</div>
	</div>
</section>
<?php include'footer.php'; ?>