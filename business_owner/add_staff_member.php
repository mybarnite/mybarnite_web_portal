<?php
	include('template-parts/header.php');
	$barId = $_SESSION['bar_id'];	
	
	if($_POST['updateUser']!="")
	{
		$name = $db->escapeString($_POST['name']);	
		$email = $db->escapeString($_POST['email']);
		$password = $db->escapeString($_POST['password']);
		$chkpage = $_POST['chkpage'];
		
		if(!$name || strlen($name = trim($name)) == 0) $form->setError("name", "Name can not be empty.");
		else
		{
			$db->select('user_register','*',NULL,'name="'.$name.'" and id!='.$_GET['id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$rows = $db->numRows();
			if($rows>0)
			{
				$form->setError("name", "User name already exists");
			}
		}	
		if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
		else
		{
			$db->select('user_register','*',NULL,'email="'.$email.'" and id!='.$_GET['id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$rows = $db->numRows();
			if($rows>0)
			{
				$form->setError("email", "Email already exists");
			}
		}
		if($form->num_errors >= 1)
		{
					//$_SESSION['value_array'] = $_POST;
					//$_SESSION['error_array'] = $form->getErrorArray();
		}
		else
		{
			
			/* $db->insert('user_register',array('r_id'=>'3','name'=>$name,'email'=>$email,'password'=>$password,'status'=>'Active','activation_key'=>'','bar_id'=>$barId));  // Table name, column names and respective values
			$res = $db->getResult(); 
			$lastInserId = $res[0]; */
			if($password!="")
			{
				$array = array(
				
					'r_id'=>3,
					'name'=>$name,
					'email'=>$email,
					'password'=>$password,
					'status'=>'Active',
					'activation_key'=>'',
					'bar_id'=>$barId
					
				);
			}
			else
			{
				$array = array(
				
					'r_id'=>3,
					'name'=>$name,
					'email'=>$email,
					'status'=>'Active',
					'activation_key'=>'',
					'bar_id'=>$barId
					
				);
			}		
			
			$db->update('user_register',$array,'id="'.$_GET['id'].'"'); // Table name, column names and values, WHERE conditions
			$res = $db->getResult();
			$lastInserId=$_GET['id'];
			
			if($lastInserId>0)
			{
				if(count($chkpage)>0)
				{
					$db->select('tbl_staffPermission','*',NULL,'subuser_id ='.$_GET['id'].' and bar_id = '.$barId,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
					$countPermission = $db->numRows();
					if($countPermission>0)
					{
						$db->delete('tbl_staffPermission','subuser_id='.$_GET['id'].'  and bar_id='.$barId);  // Table name, WHERE conditions
						
					}	
					$i=0;
					foreach($chkpage as $accessPage)
					{
						if($accessPage==1)
						{
							$pagename = 'Bar profile';
						}
						if($accessPage==2)
						{
							$pagename = 'Gallery';
						}
						if($accessPage==3)
						{
							$pagename = 'Event management';
						}					
						if($accessPage==4)
						{
							$pagename = 'Food management';
						}
						if($accessPage==5)
						{
							$pagename = 'Subscription';
						}
						if($accessPage==6)
						{
							$pagename = 'Order management';
						}
						if($accessPage==7)
						{
							$pagename = 'Sales';
						}
						if($accessPage==8)	
						{
							$pagename = 'Promotion';
						}
						if($accessPage==9)		
						{
							$pagename = 'Account';
						}
						if($accessPage==10)		
						{
							$pagename = 'User guide';
						}
						if($accessPage==11)				
						{
							$pagename = 'Profile settings';
						}
						if($accessPage==12)				
						{
							$pagename = 'Manage blog';
						}						
						$db->insert('tbl_staffPermission',array('subuser_id'=>$_GET['id'],'bar_id'=>$barId,'can_access'=>$accessPage,'page_name'=>$pagename));  // Table name, column names and respective values
						$getPermission = $db->getResult(); 	
						$lastId = $getPermission[0];
						$permissions[] = $pagename;
						
						$i++;
					}
					if($i>0)
					{
						$permissionGarnted  = implode(",",$permissions);
						$to1 = $email;
						//$to1 = 'vidhi.patel@scrumbees.com';
						$subject1 = 'Mybarnite - Permission details ';
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
						$message1 .= "Dear $name,<br/>";
						$message1 .= "You can access below features,<br/><br/>";
						$message1 .= "$permissionGarnted<br/><br/>";
						$message1 .= "Thank you for joining our website.\n\n";
						$message1 .= "<p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='http://mybarnite.com/images/Picture1.png' width='110'></p>";
						$message1 .= "</body></html>";

						mail($to1, $subject1, $message1, $headers1);
						$_POST = array();
						$_SESSION['message']='<div class="alert alert-success">Data has been updated successfully !</div>';
					}	
					?>
					<script>
					window.setTimeout(function(){
						window.location.href = "sub_user.php";
					}, 2000);

					</script>
					<?php	
				}	
				
			}	
			else
			{
				$_SESSION['message']='<div class="alert alert-danger">Data can not be updated !</div>';
			}	
		}
	}
	
	if($_POST['AddUser']!="")
	{
		
		$name = $db->escapeString($_POST['name']);	
		$email = $db->escapeString($_POST['email']);
		$password = $db->escapeString($_POST['password']);
		$chkpage = $_POST['chkpage'];
		
		if(!$name || strlen($name = trim($name)) == 0) $form->setError("name", "Name can not be empty.");
		else
		{
			$db->select('user_register','*',NULL,'name="'.$name.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$rows = $db->numRows();
			if($rows>0)
			{
				$form->setError("name", "User name already exists");
			}
		}	
		if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
		else
		{
			$db->select('user_register','*',NULL,'email="'.$email.'" ','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
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
		
		if($form->num_errors >= 1)
		{
					//$_SESSION['value_array'] = $_POST;
					//$_SESSION['error_array'] = $form->getErrorArray();
		}
		else
		{
			
			$db->insert('user_register',array('r_id'=>'3','name'=>$name,'email'=>$email,'password'=>$password,'status'=>'Active','activation_key'=>'','bar_id'=>$barId));  // Table name, column names and respective values
			$res = $db->getResult(); 
			$lastInserId = $res[0];
			if($lastInserId>0)
			{
				$resetpasskey = md5($lastInserId);
			
				$db->update('user_register',array('resetpasskey'=>"$resetpasskey"),'id= "'.$lastInserId.'" and email="'.$email.'" and status="Active" and r_id="3"');
				
				if(count($chkpage)>0)
				{
					$db->select('tbl_staffPermission','*',NULL,'subuser_id ='.$lastInserId.' and bar_id = '.$barId,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
					$countPermission = $db->numRows();
					if($countPermission>0)
					{
						$db->delete('tbl_staffPermission','subuser_id='.$lastInserId.'  and bar_id='.$barId);  // Table name, WHERE conditions
						
					}	
					$i=0;
					foreach($chkpage as $accessPage)
					{
						if($accessPage==1)
						{
							$pagename = 'Bar profile';
						}
						if($accessPage==2)
						{
							$pagename = 'Gallery';
						}
						if($accessPage==3)
						{
							$pagename = 'Event management';
						}					
						if($accessPage==4)
						{
							$pagename = 'Food management';
						}
						if($accessPage==5)
						{
							$pagename = 'Subscription';
						}
						if($accessPage==6)
						{
							$pagename = 'Order management';
						}
						if($accessPage==7)
						{
							$pagename = 'Sales';
						}
						if($accessPage==8)	
						{
							$pagename = 'Promotion';
						}
						if($accessPage==9)		
						{
							$pagename = 'Account';
						}
						if($accessPage==10)		
						{
							$pagename = 'User guide';
						}
						if($accessPage==11)				
						{
							$pagename = 'Profile settings';
						}
						if($accessPage==12)				
						{
							$pagename = 'Manage blog';
						}		
						$db->insert('tbl_staffPermission',array('subuser_id'=>$lastInserId,'bar_id'=>$barId,'can_access'=>$accessPage,'page_name'=>$pagename));  // Table name, column names and respective values
						$getPermission = $db->getResult(); 	
						$lastId = $getPermission[0];
						$i++;
					}
					if($i>0)
					{
						
						$to1 = $email;
						//$to1 = 'vidhi.patel@scrumbees.com';
						$subject1 = 'Mybarnite - Reset Password ';
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
						$message1 .= "Dear User,<br/><br/>";
						$message1 .= "Your account has been created successfully!<br/><br/>";
						$message1 .= "You can set your password using below link :<br/><br/>";
						$message1 .= SITE_PATH . "business_owner/resetpassword.php?id=$resetpasskey<br/><br/>";
						$message1 .= "Thank you for joining our website.\n\n";
						$message1 .= "Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
						$message1 .= "</body></html>";

						mail($to1, $subject1, $message1, $headers1);
						$_POST = array();
						$_SESSION['message']='<div class="alert alert-success">Data has been added successfully !</div>';
					}	
					?>
					<script>
					window.setTimeout(function(){
						window.location.href = "sub_user.php";
					}, 2000);

					</script>
					<?php
				}	
				
			}	
			else
			{
				$_SESSION['message']='<div class="alert alert-danger">Data can not be added !</div>';
			}	
		}
	}	
?>
<!--==============================Map=================================--> 
	<script type="text/javascript" src="js/custom.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
	<style>
	.checkbox{margin-left: 20%;text-align:left;}
	.control-label {width: 30%;}
	</style>
</header>
<div class="padcontent"></div>
<!--==============================Content=================================--> 
<section id="content"  class="main-content">
	<div class="container">
	<?php
	if(isset($_SESSION['business_owner_id']))
	{
		
			
	?>
	<div class="row clearfix ">
		<div class="span4"></div>
		<div class="span4">
			<center>
				<h2>Add staff member</h2>
			</center>
		</div>
		<div class="span4"><a href="sub_user.php" class="btn btn-info submitEvent bg-pink pull-right">Back to users</a></div>	
	</div>
	<div class="row">
		<div class="span4"></div>
		<div class="span4">
			 <form class="form-inline event-form" method="post" action="">
				<div class="form-group">
						<?php
						
						if(isset($_SESSION['message']))
						{
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
						
						?>
				</div>
				<?php 
				if($_GET['id']!="")
				{
					$sql = "SELECT a.*, GROUP_CONCAT( DISTINCT b.can_access) as permissions FROM user_register AS a LEFT JOIN  tbl_staffPermission AS b ON FIND_IN_SET( b.subuser_id, a.id ) where a.id = ".$_GET['id']." and a.r_id = 3 and a.bar_id = ".$barId." GROUP BY id";	
					$res = $db->myconn->query($sql);
					$res1 = $res->fetch_assoc();
					
					$permission = explode(",",$res1['permissions']);
					
				?>	
					<div class="form-group">
						<label class="control-label"  for="inputEmail">Name :</label>
						<input type="text" class="form-control" required name="name" value="<?php echo $res1['name'];?>" id="name" placeholder="Name">
						<span><?php echo $form->error("name"); ?></span>
					</div>
					<div class="form-group">
						<label class="control-label"  for="inputEmail">Email :</label>
						<input type="email" class="form-control" required name="email" value="<?php echo $res1['email'];?>" id="email" placeholder="Email">
						<span><?php echo $form->error("email"); ?></span>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputEmail">Password:</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password...">
						
					</div>
					<div class="form-group">
						<label for="inputPassword">Permissions :</label>
					</div>	
					<div class="form-group" style="text-align:center;">
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="1" <?php if (in_array("1", $permission)){?> checked="checked" <?php }?>> Bar profile</label>
						</div>	
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="2" <?php if (in_array("2", $permission)){?> checked="checked" <?php }?>> Gallery</label>
						</div>
						<div class= "checkbox">					
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="3" <?php if (in_array("3", $permission)){?> checked="checked" <?php }?>> Event management</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="4" <?php if (in_array("4", $permission)){?> checked="checked" <?php }?>> Food management</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="5" <?php if (in_array("5", $permission)){?> checked="checked" <?php }?>> Subscription</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="6" <?php if (in_array("6", $permission)){?> checked="checked" <?php }?>> Order management</label>
						</div>
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="7" <?php if (in_array("7", $permission)){?> checked="checked" <?php }?>> Sales</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="8" <?php if (in_array("8", $permission)){?> checked="checked" <?php }?>> Promotion</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="9" <?php if (in_array("9", $permission)){?> checked="checked" <?php }?>> Account</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="10" <?php if (in_array("10", $permission)){?> checked="checked" <?php }?>> User guide</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="12" <?php if (in_array("12", $permission)){?> checked="checked" <?php }?>> Manage blog</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="11" <?php if (in_array("11", $permission)){?> checked="checked" <?php }?>> Profile settings</label>
						</div>	
					</div>
					
					<br/>
					<div class="form-group pull-right">
						
						<button type="submit" id="updateUser"  name="updateUser" value="Update User" class="btn btn-info submitEvent bg-pink">Save changes</button>	
						<button type="button" id="reset"  name="reset" value="reset" class="btn btn-info submitEvent bg-pink">Reset</button>
					</div>	
					</br>
				<?php	
				}
				else
				{		
				?>
					<div class="form-group">
						<label class="control-label"  for="inputEmail">Name :</label>
						<input type="text" class="form-control" required name="name" id="name" placeholder="Name">
						<span><?php echo $form->error("name"); ?></span>
					</div>
					<div class="form-group">
						<label class="control-label"  for="inputEmail">Email :</label>
						<input type="email" class="form-control" required name="email" id="email" placeholder="Email">
						<span><?php echo $form->error("email"); ?></span>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputEmail">Password:</label>
						<input type="password" class="form-control" required name="password" id="password" placeholder="Password...">
						<span><?php echo $form->error("password"); ?></span>
					</div>
					<div class="form-group">
						<label for="inputPassword">Permissions :</label>
					</div>	
					<div class="form-group" style="text-align:center;">
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="1"> Bar profile</label>
						</div>	
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="2"> Gallery</label>
						</div>
						<div class= "checkbox">					
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="3"> Event management</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="4"> Food management</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="5"> Subscription</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="6"> Order management</label>
						</div>
						<div class= "checkbox">
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="7"> Sales</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="8"> Promotion</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="9"> Account</label>
						</div>	
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="10"> User guide</label>
						</div>
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="12"> Manage blog</label>
						</div>						
						<div class= "checkbox">	
							<label class= "checkbox"><input type="checkbox" name="chkpage[]" value="11"> Profile settings</label>
						</div>	
					</div>
					
					<br/>
					<div class="form-group pull-right">
						
						<button type="submit" id="AddUser"  name="AddUser" value="Add User" class="btn btn-info submitEvent bg-pink">Add</button>	
						<button type="button" id="reset"  name="reset" value="reset" class="btn btn-info submitEvent bg-pink">Reset</button>
					</div>
					</br>
				<?php 
				}
				?>
			</form>
		</div>
		<div class="span4"></div>
	</div>	
	<?php
	}
	else
	{
		?>
		<div class="row">
			<div class="clearfix">
				<div class="span12">
				<h5>You are not Logged in yet. Please <a href="business_owner_signin.php">login </a></h5>
				</div>
			</div>
		</div>	
	<?php	
	}	
	?>	
	</div>
</section>
<?php
	include('template-parts/footer.php');
?>
<script>

$(document).ready(function() {

	$("#reset").click(function(){
        location.reload();
    }); 
	
});
</script>