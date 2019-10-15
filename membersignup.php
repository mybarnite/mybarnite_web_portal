<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php
		if(isset($_POST['memberregister']))
		{
			$name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['name']))));
			$email = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['email']))));
			$password = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['password']))));
			$number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['number']))));
			
			$duplicatemail = mysql_query(" SELECT * FROM member_register WHERE email='".$email."' ");
			$result = mysql_num_rows($duplicatemail);
			if($result > 0)
			{
				echo "<script>window.location.href='membersignup.php?duplicateemailstatus=Email Already Exists '</script>";
			}
			
			$query = mysql_query(" INSERT INTO member_register VALUES('','".$name."','".$email."','".$password."','".$number."','Active')  ");
			
			echo "<script>window.location.href='membersignin.php?registerstatus=Registration Successfully Login Now'</script>";
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
        	<h2>Member SIGN UP</h2>
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
      				<form id="ajax-contact-form" method="post" class="form-horizontal">
      					<div class="control-group">
      						<label class="control-label" for="inputName">NAME:</label>
      							<input type="text" required name="name" class="form-control" placeholder="Name..." >
      					</div>
						<br>
						
						<?php if(isset($_GET['duplicateemailstatus'])){ ?>
			<span style="color:red">Email Already Exists</span>
			<?php } ?>
			
      					<div class="control-group">
						
      						<label class="control-label" for="inputName">EMAIL:</label>
      							<input type="email" required name="email" class="form-control" placeholder="Email..." >
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
      							<input type="password" required name="password" placeholder="Password...">
      					</div>
      					<br>
						
      					<div class="control-group">
      						<label class="control-label" for="inputName">CONTACT NO:</label>
      							<input type="number" required name="number" class="form-control" placeholder="Contact No..." >
      					</div>
						<br>
					
      					
						<br>
      					<input style="float:right;" type="submit" name="memberregister" class="btn submit btn-primary " value="SIGN UP">
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		
    </div>
  </div>
</section>




	
    <?php include'footer.php'; ?>