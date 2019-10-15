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
				<h2>Privacy and Policy</h2>
			</div>		  
		</div>
		<div class="row clearfix ">
        	<div class="span12">
				<?php
				$getcontent = mysql_query("select * from maincontent where slugname='privacy-and-policy'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
			</div>		  
		</div>
	</div>
</section>
<?php include 'footer.php'; ?>