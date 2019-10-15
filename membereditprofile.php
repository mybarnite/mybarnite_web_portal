<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php
		if(isset($_POST['editprofile']))
		{
			$name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['name']))));
			$email = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['email']))));
			$password = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['password']))));
			$number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['number']))));
			
			$query = mysql_query(" UPDATE member_register set name='".$name."',email='".$email."',password='".$password."',contact='".$number."' ") or die(mysql_error());
			
			echo "<script>window.location.href='memberprofile.php?editstatus=Successfully Edit Profile'</script>";
		}
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
        	<h2>Edit Profile</h2>
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
				<?php
					$editdataquery = mysql_query(" SELECT * FROM member_register WHERE id='".$_SESSION['memberid']."' ") or die(mysql_error());
					$editdatarow = mysql_fetch_array($editdataquery);
					?>
      				<form id="ajax-contact-form" class="form-horizontal" method="post">
      					<div class="control-group">
      						<label class="control-label" for="inputName">NAME:</label>
      							<input type="text" value="<?php echo $editdatarow['name']; ?>" name="name" class="form-control" placeholder="Name..." >
      					</div>
						<br>
						
      					<div class="control-group">
      						<label class="control-label" for="inputName">EMAIL:</label>
      							<input type="email" value="<?php echo $editdatarow['email']; ?>" name="email" class="form-control" placeholder="Email..." >
      					</div>
						<br>
						
      					<div class="control-group">
      						<label class="control-label" for="inputName">CONTACT NO:</label>
      							<input type="number" value="<?php echo $editdatarow['contact']; ?>" name="number" class="form-control" placeholder="Contact No..." >
      					</div>
						<br>
					
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
      							<input type="password" value="<?php echo $editdatarow['password']; ?>" name="password" placeholder="Password...">
      					</div>
      					<br>
						<br>
						
      					<input style="float:right;" name="editprofile" type="submit" value="SAVE CHANGES" class="btn submit btn-primary ">
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		

    </div>
  </div>
</section>




	
 <?php include'footer.php'; ?>