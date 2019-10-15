<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

   <?php include'header.php'; ?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
    <div class="row clearfix ">
          <div class="span3"></div>
		<div class="span6">
        	<h2>Member Profile </h2>
			
			<?php
					$showdataquery = mysql_query(" SELECT * FROM member_register WHERE id='".$_SESSION['memberid']."' ") or die(mysql_error());
					$showdatarow = mysql_fetch_array($showdataquery);
			?>
			<?php if(isset($_GET['editstatus'])){ ?>
			<span style="color:green">Successfully Edit Profile</span>
			<?php } ?>
			
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
      				<form id="ajax-contact-form" class="form-horizontal">
      					<div class="control-group">
      						<label class="control-label" for="inputName">NAME:</label>
      					<span style="font-size:16px;"><?php echo $showdatarow['name']; ?></span>
      					</div>
						<br>
						<form id="ajax-contact-form" class="form-horizontal">
      					<div class="control-group">
      						<label class="control-label" for="inputName">EMAIL:</label>
      							<span style="font-size:16px;"><?php echo $showdatarow['email']; ?></span>
      					</div>
						<br>
						<form id="ajax-contact-form" class="form-horizontal">
      					<div class="control-group">
      						<label class="control-label" for="inputName">CONTACT NO:</label>
      							<span style="font-size:16px;"><?php echo $showdatarow['contact']; ?></span>
      					</div>
						
      					<br>
						<br>
						<a href="membereditprofile.php" >
      					<button style="float:right;" type="button"  class="btn submit btn-primary "><i class="icon-envelope icon-white"></i>&nbsp;&nbsp;Edit Profile</button> </a>
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
	

    </div>
  </div>
</section>




	
    <?php include'footer.php'; ?>