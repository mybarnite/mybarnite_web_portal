<?php

include('template-parts/header.php');



		if(isset($_SESSION['business_owner_id']))
		{
			header("location:business_owner_profile.php");
			exit;
		}
		
		
		if(isset($_POST['login']))
		{
			global $BarId;
			$useremail =$db->escapeString($_POST['useremail']);
			$userpassword = $db->escapeString($_POST['userpassword']);
			$_SESSION['msg']="";
			
			$db->select('user_register','*',NULL,'r_id="1" and email="'.$useremail.'" and password="'.$userpassword.'" and status ="Active" and activation_key=""','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$result = $db->getResult();
			$rows = $db->numRows();
			if($rows>0)
			{
				$db->select('bars_list','id,Business_Name',NULL,'Owner_id="'.$result[0]['id'].'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$bars = $db->getResult();
				
				$_SESSION['bar_id'] = $bars[0]['id'];
				$_SESSION['bar_name'] = $bars[0]['Business_Name'];
				$_SESSION['business_owner_id'] = $result[0]['id'];
				$_SESSION['business_owner_name'] = $result[0]['name'];
				$_SESSION['business_owner_email'] = $result[0]['email'];
				$BarId = $bars[0]['id'];
				header("location:business_owner_profile.php");
			}
			else
			{
				$_SESSION['msg']='<div class="alert alert-danger">Enter valid email and password!!</div>';
			}	
			
			
			
		}
		
		if(isset($_POST['forgot_password']))
		{
			header("location:forgot_password.php");
		}	
?>

  
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
       <div class="row">
		<div class="clearfix ">
			<div class="span5"></div>
			<div class="span6">
				<h2>Log In</h2>
				
			</div>
			<div class="span5"></div>
		</div>
	</div> 	
    <div class="row clearfix ">
          <div class="span3"></div>
          <div class="span6">
        		<div id="fields" class="contact-form">
      				<form id="ajax-contact-form" class="form-horizontal" method="post">
      					<div class="control-group">
						<?php
						
						if(isset($_SESSION['msg']))
						{
									echo $_SESSION['msg'];
									
						}
						
						?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">EMAIL:</label>
      						<input type="email" required name="useremail" class="form-control" placeholder="User Name..."  >
      					</div>
						<br>
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">PASSWORD:</label>
      						<input type="password" required name="userpassword" class="form-control" placeholder="Password..">
								
      					</div>
						<br>
						<div class="control-group">
							<input name="login" type="submit" class="form-control btn submit btn-primary pull-right" value="Login">
							
						</div>
						<div class="clearfix"></div>
      				</form>
					
					<form class="form-horizontal" method="post">
						<input id="forgot_password" name="forgot_password" type="submit" class="form-control btn submit btn-primary  pull-left" value="Forgot Password">
					</form>	
      			</div>    
			</div>		  
		
		
    </div>
  </div>
</section>




   <?php include'template-parts/footer.php'; ?>