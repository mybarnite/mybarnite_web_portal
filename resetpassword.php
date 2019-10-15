<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>
<?php include'head.php'; ?>
<title>Mybarnite</title>
<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

$resetpasskey = $_GET['id'];
$db->select('user_register','*',NULL,'resetpasskey="'.$resetpasskey.'"','id DESC'); 
$res = $db->getResult();
$resetpass_timestamp = $res[0]['resetpass_timestamp'];
$effective_timestamp = strtotime("+60 minutes", strtotime($resetpass_timestamp));
/* echo $resetpass_timestamp;
echo "<br/>";
echo date("Y-m-d H:i:s",$effective_timestamp);
echo "<br/>";
echo date("Y-m-d H:i:s");
 */?>

<?php
		if(isset($_POST['submit']))
		{
			$email = $db->escapeString($_POST['email']);
			$password = $db->escapeString($_POST['password']);
			$resetpasskey = $_GET['id'];
			if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email not entered");
			else
			{
				$db->select('user_register','*',NULL,'email="'.$email.'" and r_id="2" and resetpasskey="'.$resetpasskey.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$rows = $db->numRows();
				if($rows==0)
				{
					$form->setError("email", "Invalid Email.");
				}
			}
			if($password)
			{
						if(strlen($password = trim($password)) < 6) $form->setError("password", "Password too short");
			}
			else $form->setError("password", "Password not entered");
			if($form->num_errors == 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else
			{
				
				$db->update('user_register',array('password'=>"$password",'resetpasskey'=>"",'resetpass_timestamp'=>""),'email="'.$email.'" and resetpasskey="'.$resetpasskey.'" and status="Active" and r_id="2"');
				$affectedRow = $db->myconn->affected_rows;
				
				if(!empty($affectedRow)&&$affectedRow>0)
				{
					$msg = "<html>";
					$msg .= "<head><title>Mybarnite</title></head>";
					$msg .= "<body>";
					$msg .= "Dear Customer<br/><br/>Thank you for joining our website.<br/><br/>Your Password has been changed successfully , you can login now by clicking below link:\n\n";
					$msg .= SITE_PATH . 'usersignin.php';
					$msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>EMail: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='https://mybarnite.com/images/Picture1.png' width='50%'>";
					$msg .= "</body></html>";
					$subj = 'Mybarnite - Reset Password';
					$to = $email;
					$from = 'info@mybarnite.com';
					$appname = 'Mybarnite';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From: info@mybarnite.com" . "\r\n" ."";	
					
					 
					if (mail($to,$subj,$msg,$headers)) 
					{
						$_SESSION['msg']='<div class="alert alert-success">Password has been changed successfully.</div>';
					}
					else
					{
						$_SESSION['msg']='<div class="alert alert-danger">Error occured.</div>';
					}	
				}
				else
				{
					$_SESSION['msg']='<div class="alert alert-danger">Error occured.</div>';
					
				}		
			} 
		}	
?>


	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 

<section id="content" class="main-content">
  <div class="container">
	<div class="row">
			<div class="clearfix ">
				<div class="span5"></div>
				<div class="span6">
					<h2>Forgot Password</h2>
				</div>
				<div class="span5"></div>
			</div>
	</div>
	<?php 
	$expired_timestamp = strtotime(date("Y-m-d H:i:s"));
	if($resetpass_timestamp!=""&&$effective_timestamp>$expired_timestamp)
	{	
	?>	
    <div class="row clearfix ">
          <div class="span3"></div>
			<div class="span6">
        	
      			<div id="note"></div>
      			<div id="fields" class="contact-form" id="forgot_password_container">
      				<form id="ajax-contact-form" method="post" class="form-horizontal">
      					
						<?php
						
						if(isset($_SESSION['msg']))
						{
						?>	
							<div class="control-group"><?php echo $_SESSION['msg'];?></div>
						<?php	
						unset($_SESSION['msg']); 
									
						}
						
						?>
						
						<div class="control-group">
						
      						<label class="control-label" for="inputName">Email:</label>
      						<input type="email" required name="email" class="form-control" placeholder="Email..." >
							<span><?php echo $form->error("email"); ?></span>
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputEmail">New Password:</label>
							<input type="password" required name="password" pattern="^(?=[^\d_].*?\d)\w(\w|[!@#$%]){6,}" title="Alphanumeric, specialchars and min 7 Chars" placeholder="Password...">
							<span><?php echo $form->error("password"); ?></span>
      					</div>
      					<br>
						
						<br>
      					<input type="submit" name="submit" class="btn submit btn-primary " value="SUBMIT">
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		
    </div>
	<?php 
	}
	else
	{
	?>	
	<div class="row">
		<div class="span12 align-center">
			<div class="alert alert-danger">Link for resetting password has been expired.</div>
		</div>
	</div>
	<?php
	}	
	?>
  </div>
</section>




	
    <?php include'footer.php'; ?>