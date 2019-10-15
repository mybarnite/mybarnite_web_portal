<?php
include('template-parts/header.php');
if(isset($_POST['register']))
		{
			global $form;
			/* echo "<pre>";
			print_r($_POST['name']); */
			$name = $db->escapeString($_POST['name']);
			$email = $db->escapeString($_POST['email']);
			$password = $db->escapeString($_POST['password']);
			//$number = $db->escapeString($_POST['number']);
			
			if(!$name || strlen($name = trim($name)) == 0) $form->setError("name", "Owner name can not be empty.");
			
			if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
			else
			{
				$db->select('user_register','r_id,email',NULL,'email="'.$email.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$rows = $db->numRows();
				if($rows>0)
				{
					$form->setError("email", "Email already exists");
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
				//$_SESSION['message'] = "No errors in the form, good to go!";
				
				$activation = md5(uniqid(rand(), true));

				$db->insert('user_register',array('r_id'=>'1','name'=>$name,'email'=>$email,'password'=>$password,'status'=>'Inactive','activation_key'=>$activation));  // Table name, column names and respective values
				$res = $db->getResult();  
				
				/* if(!empty($res))
				{ */						
										
					$lastInsertedId = $res[0];
					
					$db->insert('bars_list',array('Owner_id'=>$lastInsertedId,'Owner_Name'=>$name));  // Table name, column names and respective values
					$res1 = $db->getResult();
					$encodedid = urlencode($lastInsertedId);
					//$to = $email;
					$to = 'vidhi.scrumbees@gmail.com';
					
					$msg = "<html>";
					$msg .= "<head><title>Mybarnite</title></head>";
					$msg .= "<body>";
					$msg .= "Dear Customer<br/><br/>Thank you for joining our website.<br/><br/>To activate your account, please click on this link<br/><br/>";
					$msg .= "Thank you for joining our website.<br/><br/>";
					$msg .= "Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
					$msg .= "</body></html>";
					
					/* $msg = "<html>";
					$msg .= "<head><title>Mybarnite</title></head>";
					$msg .= "<body>";
					$msg .= "Dear Customer<br/><br/>Thank you for joining our website.<br/><br/>To activate your account, please click on this link:\n\n";
					$msg .= SITE_PATH . "business_owner/activate.php";
					$msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>EMail: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
					$msg .= "</body></html>"; */
					$subj = 'Account Activation';
					
					$from = 'info@mybarnite.com';
					$appname = 'Mybarnite';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					 
					// Create email headers
					$headers .= 'From: '.$from."\r\n".
						'Reply-To: '.$from."\r\n" .
						'X-Mailer: PHP/' . phpversion();
					
					

					if (mail($to,$subj,$msg,$headers)) 
					{
						
						$_SESSION['msg'] = '<div class="alert alert-success">Thank you for registering! Activation email has been sent to your email address, Please click on the Activation Link to Activate your account. </div>';
						
					} 
					else 
					{
						
						$_SESSION['msg'] = 'There is some issue while sending email.';
						
					}
					
					echo "<script>window.location.href='business_owner_signin.php'</script>";	
					//header("location:business_owner_signin.php");
				/* }	
				else
				{
					$_SESSION['msg']="";
					header("location:business_owner_signup.php");
				} */
			}
			
			
		}
	?>	