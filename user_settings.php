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
					<h2>User Details</h2>
					
				</div>
				<div class="span5"></div>
			
	</div> 
	<div class="row clearfix ">
        <div class="span3"></div>
		<div class="span6">
        		<div id="fields" class="contact-form">
      				<form id="ajax-contact-form" method="post" class="form-horizontal">
      					<div class="control-group">
						<?php
						
						if(isset($_SESSION['msg']))
						{
						?>	
							<div class="alert alert-success">Changes have been updated successfully!!</div>
						<?php	
						
									
						}
						$db->select('user_register','*',NULL,'id="'.$id.'" and r_id="2"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
						$result = $db->getResult();
						?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">OWNER NAME:</label>
      						<input type="text" required name="name" class="form-control" value="<?php echo @$result[0]['name']; ?>" placeholder="Owner Name..." >
							<span ><?php echo $form->error("name"); ?></span>
      					</div>
						<br>
						
						<div class="control-group">
						
      						<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required name="email" class="form-control" value="<?php echo @$result[0]['email']; ?>" placeholder="Email..." >
							<span ><?php echo $form->error("email"); ?></span>
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
							<input type="password" name="password" value="" placeholder="Password...">
							<span ><?php echo $form->error("password"); ?></span>
      					</div>
      					<br>
						  
						<br>
      					<input type="submit" name="update" class="btn submit btn-primary " value="Update">
						<div class="clearfix"></div>
      				</form>
      			</div>    
		</div>		  
		
		
		
    </div>
    <?php
    }
    ?>
  </div>
</section>




	
    <?php include'template-parts/footer.php'; ?>