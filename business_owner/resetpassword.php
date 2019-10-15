<?php
include('template-parts/header.php');
$resetpasskey = $_GET['id'];
$db->select('user_register','*',NULL,'resetpasskey="'.$resetpasskey.'"','id DESC'); 
$res = $db->getResult();
$resetpass_timestamp = $res[0]['resetpass_timestamp'];
$effective_timestamp = strtotime("+60 minutes", strtotime($resetpass_timestamp));

?>

<?php
		if(isset($_POST['submit']))
		{
			$email = $db->escapeString($_POST['email']);
			$password = $db->escapeString($_POST['password']);
			$resetpasskey = $_GET['id'];
			$db->select('user_register','*',NULL,'resetpasskey="'.$resetpasskey.'" and email = "'.$email.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$isExist = $db->numRows();
			
			if($isExist>0)
			{
				$getRole = $db->getResult(); 
				$role = $getRole[0]['r_id'];
				$r_id = ($role == 1)?1:3;
				
				if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email not entered");
				else
				{
					$db->select('user_register','r_id,email',NULL,'email="'.$email.'" and r_id='.$r_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
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
					$resetpasskey = $_GET['id'];
					$db->update('user_register',array('password'=>"$password",'resetpasskey'=>""),'email="'.$email.'" and resetpasskey="'.$resetpasskey.'" and status="Active" and r_id='.$r_id);
					$affectedRow = $db->myconn->affected_rows;
					
					if(!empty($affectedRow)&&$affectedRow>0)
					{
						
						
						$to1 = $email;
						//$to1 = 'vidhi.patel@scrumbees.com';
						$subject1 = 'Mybarnite - Login details ';
						$from1 = 'info@mybarnite.com';
						 
						// To send HTML mail, the Content-type header must be set
						$headers1  = 'MIME-Version: 1.0' . "\r\n";
						$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						 
						// Create email headers
						$headers1 .= 'From: '.$from1."\r\n".
							'Reply-To: '.$from1."\r\n" .
							'X-Mailer: PHP/' . phpversion();
						 
						// Compose a simple HTML email message
						$message1 = "<html>";
						$message1 .= "<head><title>Mybarnite</title></head>";
						$message1 .= "<body>";
						$message1 .= "Dear User,<br/>";
						$message1 .= "Your Password has been reset successfully , you can login now by clicking below link:\n\n";
						$message1 .= SITE_PATH . "business_owner/business_owner_signin.php<br/><br/>";
						$message1 .= "Thank you for joining our website.<br/><br/>";
						$message1 .= "Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
						$message1 .= "</body></html>";

						if (mail($to1, $subject1, $message1, $headers1)) 
						{
							$_SESSION['msg']='<div class="alert alert-success">Password has been changed successfully. Please check your email.</div>';
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
			else
			{
				$_SESSION['msg']='<div class="alert alert-danger">User not found with this email.</div>';
			}		
			
			
			
		}	
?>


	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
	<div class="row clearfix ">   
		<div class="span12">
			<center><h2>Set your password</h2></center>
		</div>
	</div>
	<?php 
	$expired_timestamp = strtotime(date("Y-m-d H:i:s"));
	if($resetpass_timestamp!=""&&$effective_timestamp>$expired_timestamp)
	{	
	?>	
    
	<div class="row">
			<div class="span3"></div>
			<div class="span6">
        	
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
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
						
      						<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required name="email" class="form-control" placeholder="Email..." >
							<span><?php echo $form->error("email"); ?></span>
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputEmail">NEW PASSWORD:</label>
							<input type="password" required name="password" placeholder="Password...">
							<span><?php echo $form->error("password"); ?></span>
      					</div>

      					<div class="control-group">
      						<label class="control-label" for="inputEmail"></label>
							<input type="submit" name="submit" class="btn submit btn-primary " value="SUBMIT">
      					</div>
      					
      					
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		<div class="span3"></div>
		
		
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




	
    <?php include'template-parts/footer.php'; ?>