<?php
	
include('template-parts/header.php');

$id=(isset($_SESSION['subUserId'])&&$_SESSION['subUserId']!="")?@$_SESSION['subUserId']:@$_SESSION['business_owner_id'];
unset($_SESSION['msg']);


?>

<?php
		if(isset($_POST['update']))
		{
			global $form;
			#echo "<pre>";
			#print_r($_POST); 
			#exit;
			$name = $db->escapeString($_POST['name']);
			$email = $db->escapeString($_POST['email']);
			$password = $db->escapeString($_POST['password']);
			
			
			if(!$name || strlen($name = trim($name)) == 0) $form->setError("name", "Owner name can not be empty.");
			
			if(!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
			else
			{
				$db->select('user_register','r_id,email',NULL,'email="'.$email.'" and id!="'.$id.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
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
			
			
			if($form->num_errors == 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else
			{
				if($password!="")
				{
					$array = array(
						
						'name'=>$name,
						'email'=>$email,
						'password'=>$password,
						
					);
				}
				else
				{
					$array = array(
						
						'name'=>$name,
						'email'=>$email,
						
					);
				}	
				
				$db->update('user_register',$array,'id='.$id); // Table name, column names and values, WHERE conditions
				$res = $db->getResult();	
				if(!empty($res))
				{
					$_SESSION['msg']=1;
					
				}	
				else
				{
					$_SESSION['msg']="";
					header("location:business_owner_settings.php");
				}				
			}
			
			
		}
?>


<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
  <?php
  if(isset($_SESSION['business_owner_id']))
  {
  ?>
    <div class="row">
			
				<div class="span4"></div>
				<div class="span6">
					<h2>Business owner Details</h2>
					
				</div>
				<div class="span5"></div>
			
	</div> 
	<div class="row clearfix ">
        <div class="span3">
		<?php 
		if(!isset($_SESSION['subUserId']))
		{	
		?>
			<div id="accordion2" class="accordion max-size1">
				
				<div class="accordion-group" >
					<div class="accordion-heading ">
						<div <?php if($page_name=='business_owner_settings.php'){?> class="accordion-toggle-active" style="background:#ff1da5 !important;" <?php }else{?> class="accordion-toggle" <?php }?> data-target="#collapse" data-toggle="collapse" data-parent="#accordion2" >
							<span></span>
							<a style="color:#9393a7;text-decoration:none;" href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php">Update Profile</a>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading ">
						<div <?php if($page_name=='sub_user.php'){?> class="accordion-toggle-active" style="background:#ff1da5 !important;" <?php }else{?> class="accordion-toggle" <?php }?> data-target="#collapse" data-toggle="collapse" data-parent="#accordion2">
							<span></span>
							<a style="color:#9393a7;text-decoration:none;" href="<?php echo SITE_PATH;?>business_owner/sub_user.php">Manage staff</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>	
		</div>
		<div class="span6">
        		<div id="fields" class="contact-form signin-form">
      				<form id="ajax-contact-form" method="post" class="form-horizontal">
      					<div class="control-group">
						<?php
						
						if(isset($_SESSION['msg']))
						{
						?>	
							<div class="alert alert-success">Changes have been updated successfully!!</div>
						<?php	
						
									
						}
						if(!isset($_SESSION['subUserId']))
						{
							$db->select('user_register','*',NULL,'id="'.$id.'" and r_id="1"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
							$result = $db->getResult();	
						}		
						else
						{
							$db->select('user_register','*',NULL,'id="'.$id.'" and r_id="3"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
							$result = $db->getResult();
						}	
						
							
							
						?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">CUSTOMER ID:</label>
      						<input type="text" required name="name" class="form-control" value="<?php echo @$result[0]['id']; ?>" style="background:none;color:#9393a7;height:30px;padding-top:0px;border:none !important;" readonly >
							
      						</div>
						<br>
						
						<?php 
						if(@$_POST['name']!=""){
						?>
						<div class="control-group">
      						<label class="control-label" for="inputName">OWNER NAME:</label>
      						<input type="text" required name="name" class="form-control" value="<?php echo @$_POST['name']; ?>" placeholder="Owner Name..." >
							<span style="float:left;"><?php echo $form->error("name"); ?></span>
      					</div>
						<br>
						<?php }
						else
						{	
						?>
						<div class="control-group">
      						<label class="control-label" for="inputName">OWNER NAME:</label>
      						<input type="text" required name="name" class="form-control" value="<?php echo @$result[0]['name']; ?>" placeholder="Owner Name..." >
							<span style="float:left;"><?php echo $form->error("name"); ?></span>
      					</div>
						<br>		
						<?php 
						}
						?>
						
						<?php 
						if(@$_POST['email']!=""){
						?>						
						<div class="control-group">
							<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required name="email" class="form-control" value="<?php echo @$_POST['email']; ?>" placeholder="Email..." >
							<span style="float:left;"><?php echo $form->error("email"); ?></span>
      					</div>
						<br>
						<?php 
						}else{
						?>
						<div class="control-group">
							<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required name="email" class="form-control" value="<?php echo @$result[0]['email']; ?>" placeholder="Email..." >
							<span style="float:left;"><?php echo $form->error("email"); ?></span>
      					</div>
						<br>
						<?php 
						}
						?>
						<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
							<input type="password" name="password" value="" placeholder="Password...">
							<span style="float:left;"><?php echo $form->error("password"); ?></span>
      					</div>
      					<br>
						<div class="control-group"> 
						    <input type="submit" name="update" class="btn submit btn-primary bg-pink white" value="Update">
						</div>						
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
	<div class="row ">
		<div class="clearfix ">
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




	
    <?php include'template-parts/footer.php'; ?>