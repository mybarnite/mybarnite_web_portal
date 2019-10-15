<?php
include('template-parts/header.php');

?>

<?php
		if(isset($_POST['submit']))
		{
			$email = $db->escapeString($_POST['email']);
			
			if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email not entered");
			else
			{
				$db->select('user_register','r_id,email,id',NULL,'email="'.$email.'" and status="Active"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$rows = $db->numRows();
				$res = $db->getResult();
				if($rows==0)
				{
					$form->setError("email", "Invalid Email.");
				}
			}
			
			if($form->num_errors == 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else
			{
				//$resetpasskey = md5($res[0]['id']);
				$resetpasskey = $res[0]['id']."-".md5(uniqid(rand(), true));
				$resetpass_timestamp = date("Y-m-d H:i:s");
				
				if($db->update('user_register',array('resetpasskey'=>"$resetpasskey",'resetpass_timestamp'=>"$resetpass_timestamp"),'email="'.$email.'" and status="Active" '))
				{
					$msg = "<html>";
					$msg .= "<head><title>Mybarnite</title></head>";
					$msg .= "<body>";
					$msg .= "Dear customer<br/><br/>Thank you for contacting us.<br/>To change password, please click on this link:\n\n";
					$msg .= SITE_PATH . 'business_owner/resetpassword.php?id=' .$resetpasskey;
					$msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>EMail: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='50%'>";
					$msg .= "</body></html>";
					$subj = 'Mybarnite :Reset Password';
					$to = $email;
					$from = 'info@mybarnite.com';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From: info@mybarnite.com" . "\r\n" ."";
					if (mail($to,$subj,$msg,$headers)) 
					{
						
						$_SESSION['msg'] = '<div class="alert alert-success">Reset password url has been sent to your email !</div>';
						
					} 
					else 
					{
						
						$_SESSION['msg'] = '<div class="alert alert-danger">Error occured.</div>';
						
					}	
					
				}
				else 
				{
					
					$_SESSION['msg'] = '<div class="alert alert-danger">Error occured.</div>';
					
				}		
			}
		}	
?>


	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
    <div class="row clearfix">
		<div class="span12">
			<center><h2>Forgot Password</h2></center>
		</div>
	</div>
	<div class="row clearfix ">
          <div class="span3"></div>
		<div class="span6">
        	
      			<div id="note"></div>
      			<div id="fields" class="contact-form signin-form">
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
						<br>
						<div class="control-group">
						
      						<label class="control-label" for="inputName"></label>
      						<input type="submit" name="submit" class="btn submit btn-primary " value="SUBMIT">
      					</div>
      					
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		
    </div>
  </div>
</section>




	
    <?php include'template-parts/footer.php'; ?>