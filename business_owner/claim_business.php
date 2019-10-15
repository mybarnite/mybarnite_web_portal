<?php
	
include('template-parts/header.php');

?>

<?php
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
						
						if(!empty($res))
						{						
												
							$lastInsertedId = $res[0];
							
							$db->insert('bars_list',array('Owner_id'=>$lastInsertedId,'Owner_Name'=>$name));  // Table name, column names and respective values
							$res1 = $db->getResult();
							
							$msg = "Dear Customer<br/><br/>Thank you for joining our website.<br/><br/>To activate your account, please click on this link:\n\n";
							$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
							$msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>EMail: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='50%'>";
		
							//$msg = " To activate your account, please click on this link:\n\n";
							//$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
							$subj = 'Account Activation';
							$to = $email;
							$from = 'info@mybarnite.com';
							$appname = 'Mybarnite';
							 
							//$to = "somebody@example.com";
							//$subject = "My subject";
							//$txt = "Hello world!";
							$headers = "From: info@mybarnite.com" . "\r\n" ."";	

					
							 
							if (mail($to,$subj,$msg,$headers)) 
							{
								
								$_SESSION['msg'] = '<div class="alert alert-success">Thank you for registering! Activation email has been sent to your email address, Please click on the Activation Link to Activate your account. </div>';
								
							} 
							else 
							{
								if (!mail($to,$subj,$msg,$headers)) {
									if (!empty($error)) $_SESSION['msg'] = $error;
								} else {
									//$_SESSION['msg'] = 'Yep, the message is send (after doing some hard work)';
								}
							}
							
							
							header("location:business_owner_signin.php");
						}	
						else
						{
							$_SESSION['msg']="";
							header("location:business_owner_signup.php");
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
   
	<div class="row search-form" style="margin-top:0px; position: relative;">
		<div class="span3">&nbsp;</div>
		<div class="span6">
			<h3>Find your business:</h3>
			<form class="form-horizontal" method="post">
				<div class="form-group">
					
					<div class="col-sm-8">
						<input type="text" name="barName" id="barName" class="typeahead tt-query" placeholder="Search by Name">
						<input type="text" name="barCity" id="barCity" class="typeahead tt-query" placeholder="Search by city">
						<span>  <button type="button" class="btn btn-default btn-color" onclick="searchBarDetail();">Search</button></span>
					</div>
					<br>
				</div>
				<a href="business_owner_signup.php" class="pink" style="font-size:15px;">SKIP - My bar does not exist.</a>
			</form>
		</div>
		<div class="span3">&nbsp;</div>
	</div> 
	<br/>
	<div class="row clearfix" id="searchResult"></div>
  </div>
</section>
<script>
function searchBarDetail()
{
	
	var barName = $("#barName").val();
	var barCity = $("#barCity").val();
	
	 $.ajax({
		url : "searchBarDetail.php",
		type: "POST",
		data :{ barName :barName, barCity :barCity },
		
		success: function(result)
		{	
			//console.log(result);
			$("#searchResult").html(result);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
		}
	});
}
</script>
<?php include'template-parts/footer.php'; ?>