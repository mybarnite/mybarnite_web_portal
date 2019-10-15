<?php
session_start();
ob_start();
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
// 			$oldPassword = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['oldPassword']))));
// 			$password = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['confirmPassword']))));
            $password = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['password']))));
			$number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['number']))));
			//echo "UPDATE user_register set name='".$name."',email='".$email."',password='".$password."',contact='".$number."' where id=".$_SESSION['id']." and r_id = 2";
			$duplicatemail = mysql_query(" SELECT * FROM user_register WHERE email='".$email."' and id!=".$_SESSION['id']);
			$result = mysql_num_rows($duplicatemail);
			
			// $duplicatusername = mysql_query(" SELECT * FROM user_register WHERE name='".$name."' and id!=".$_SESSION['id']);
			//$result1 = mysql_num_rows($duplicatusername);
			
// 			$matchPassword = mysql_query(" SELECT * FROM user_register WHERE password='".$oldPassword."' and id=".$_SESSION['id']);
// 			$result2 = mysql_num_rows($matchPassword);
			
			
			if($result > 0)
			{
				echo "<script>window.location.href='editprofile.php?duplicateemailstatus=true'</script>";
			}
            // elseif($result1 > 0)
            // {
            // 	echo "<script>window.location.href='editprofile.php?duplicateusername=true'</script>";
            // }
            
//            elseif($result2 == 0)
//            {
//            	echo "<script>window.location.href='editprofile.php?wrongpassword=true'</script>";
//            }
			else
			{
				$query = mysql_query("UPDATE user_register set name='".$name."',email='".$email."',password='".$password."',contact='".$number."' where id=".$_SESSION['id']." and r_id = 2") or die(mysql_error());
				$lastid = mysql_affected_rows();
				if($lastid==1)
				{
					//$_SESSION['msg'] = "<div class='alert alert-success'>Data has been updated successfully.</div>";
					//header("location:editprofile.php");
					echo "<script>window.location.href='editprofile.php?editstatus=true'</script>";
				}	
				else
				{
					//$_SESSION['msg'] = "<div class='alert alert-success'>There is some erroe</div>";
					//header("location:editprofile.php");
					echo "<script>window.location.href='editprofile.php?editstatus=false'</script>";
				}
			}	
			
				
			
		}
?>
<?php include'head.php'; ?>
<title>Settings</title>
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
      			<div id="note">
					
					<?php if($_GET['editstatus']=='true'){?>
					<div class="alert alert-success">Data has been updated successfully.</div>
					<?php }elseif($_GET['editstatus']=='false'){?>
					<div class="alert alert-danger">It seems no changes have been done.</div>
					<?php }elseif($_GET['duplicateemailstatus']=='true'){?>
					<div class="alert alert-danger">Email already exists.</div>
					<?php }elseif($_GET['duplicateusername']=='true'){?>
					<div class="alert alert-danger">Username already exists.</div>
					<?php }?>
				</div>
      			<div id="fields" class="contact-form signin-form">
					<?php
					$editdataquery = mysql_query(" SELECT * FROM user_register WHERE id='".$_SESSION['id']."' ") or die(mysql_error());
					$editdatarow = mysql_fetch_array($editdataquery);
					?>
      				<form id="ajax-contact-form" class="form-horizontal" method="post">
      					<div class="control-group">
      						<label class="control-label" for="inputName">NAME:</label>
      						<input type="text" required value="<?php echo $editdatarow['name']; ?>" name="name" class="form-control" placeholder="Name...">
      					</div>
						<br>
						
      					<div class="control-group">
      						<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required value="<?php echo $editdatarow['email']; ?>" name="email" class="form-control" placeholder="Email..." >
      					</div>
						<br>
						
      					<div class="control-group">
      						<label class="control-label" for="inputName">CONTACT NO:</label>
      						<input type="number" value="<?php echo $editdatarow['contact']; ?>" name="number" class="form-control" placeholder="Contact No..." >
      					</div>
						<br>
						<?php 
						if(!isset($editdatarow['twitter_id'])&&$editdatarow['twitter_id']==""&&!isset($editdatarow['facebook_id'])&&$editdatarow['facebook_id']=="")
						{	
						?>
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
      						<input type="password" value="" name="password" id="password" placeholder="Password...">
      						<span id="message1"></span>
      					</div>
						<!--<br>-->
      <!--					<div class="control-group">-->
      <!--						<label class="control-label" for="inputEmail">NEW PASSWORD:</label>-->
      <!--						<input type="password" value="" name="newPassword" id="newPassword" placeholder="New Password...">-->
      <!--					</div>-->
						<!--<br>-->
      <!--					<div class="control-group">-->
      <!--						<label class="control-label" for="inputEmail">CONFIRM PASSWORD:</label>-->
      <!--						<input type="password" value="" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password...">-->
      <!--						<span id="message"></span>-->
      <!--					</div>-->
						<!--<br>-->
						<?php 
						}
						?>
      					
						<br>
						<div class="control-group">
      						<label class="control-label" for="inputEmail"></label>
      						<input name="editprofile" type="submit" value="SAVE CHANGES" class="btn submit btn-primary ">
      					</div>
						
      					
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		

    </div>
  </div>
</section>
<script type="application/javascript">
//     $('#confirmPassword').on('keyup', function () {
//         if ($('#oldPassword').val()==""){
//             $('#message1').html('Please Enter Old Password First.').css('color', 'red');
//             return false;
//         }
//         if ($('#confirmPassword').val()==""){
//             $('#message').html('').css('color', 'transparent');
//             return false;
//         }
//         else if ($('#newPassword').val() == $('#confirmPassword').val()) {
//             $('#message').html('Password Match').css('color', 'green');
//             return false;
//         } else {
//             $('#message').html('Password not Match').css('color', 'red');
//             return false;
//         }
//     });
    
</script>

	
 <?php include'footer.php'; ?>