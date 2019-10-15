<?php
include ("common.php");
if(isset($_POST['submit']))
			{#echo "123";
				
				
				echo $query = "select b.id, b.Business_Name, b.Owner_id, b.is_requestedForClaim, u.name, u.email from bars_list as b left join user_register as u on u.id=b.Owner_id where b.id = ".$_POST['businessid'];
				$exe = $db->myconn->query($query);
				$getDetails = $exe->fetch_assoc();
			
				$name = $db->escapeString($_POST['name']);	
				$email = $db->escapeString($_POST['email']);
				$count = 0;
			
				// Loop $_FILES to exeicute all files
				$total = count($_FILES['files']['name']);
				if($total<1)
				{
					$flag = 0;
					$_SESSION['msg']="<div class='alert alert-success'>Please select any file.</div>";
				}
				else
				{
					if($getDetails['is_requestedForClaim']==1)
					{echo "222";
						
						$to = "vidhi.scrumbees@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: info@mybarnite.com" . "\r\n" ;

mail($to,$subject,$txt,$headers);
						
						
						if(mail($to,$subject,$txt,$headers)) 
						{
							
							//$_SESSION['msg1'] = '<div class="alert alert-success">Business claim has been sent successfully to admin. You will get confirmation email after admin approval.</div>';
							
							echo "<script>window.location.href='business_owner_signup.php?msg1=success'</script>";
							//header("location:business_owner_signup.php?msg1='success'");
							
						} 
						else 
						{
							$_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
							echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
							//header("location:business_owner_signup.php?msg1='error'");
						}
						
					}
						
					
				}	
				
				
				
			}	
			