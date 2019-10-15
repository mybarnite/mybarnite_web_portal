<?php
include('template-parts/header.php');
if(isset($_POST['AddAccount']))
{
	$role = '1';
	$user_id = $_SESSION['business_owner_id'];
	$customer_id = $db->escapeString($_POST['customer_id']);
	$account_name = $db->escapeString($_POST['account_name']);
	$short_code = $db->escapeString($_POST['short_code']);
	$account_number = $db->escapeString($_POST['account_number']);
	$stripe_account_id = $db->escapeString($_POST['stripe_account_id']);
	
	
	$db->insert('tbl_accounts',array('role'=>$role,'user_id'=>$user_id,'customer_id'=>$customer_id,'account_name'=>$account_name,'short_code'=>$short_code,'account_number'=>$account_number,'stripe_account_id'=>$stripe_account_id));  // Table name, column names and respective values
	$res = $db->getResult();  
	$lastInsertedId = $res[0];
	if($lastInsertedId!="")
	{
		$_SESSION['msg']="<div class='alert alert-success'>Data has been inserted successfully.</div>";
		header("location:business_owner_account.php");		
	}	
}	
if(isset($_POST['EditAccount'])&&$_GET['id']!="")
{
	$role = '1';
	$user_id = $_SESSION['business_owner_id'];
	$customer_id = $db->escapeString($_POST['customer_id']);
	$account_name = $db->escapeString($_POST['account_name']);
	$short_code = $db->escapeString($_POST['short_code']);
	$account_number = $db->escapeString($_POST['account_number']);
	$stripe_account_id = $db->escapeString($_POST['stripe_account_id']);
	$id = $_GET['id'];
	
	$array = array(
		'customer_id'=>$customer_id,
		'account_name'=>$account_name,
		'short_code'=>$short_code,
		'account_number'=>$account_number,
		'stripe_account_id'=>$stripe_account_id,
	);
	
	$db->update('tbl_accounts',$array,'id='.$id); // Table name, column names and values, WHERE conditions
	$res = $db->getResult();
	if($res[0]==1)
	{
		$_SESSION['msg']="<div class='alert alert-success'>Data has been updated successfully.</div>";	
		header("location:business_owner_account.php");		
	}
	else
	{
		$_SESSION['msg']="<div class='alert alert-success'>It seems not changes have been made.</div>";	
	}		
}	
?>
<script type="text/javascript" src="js/custom.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
	<?php 
	if(isset($_SESSION['business_owner_id']))
	{
		$id = $_GET['id']; 
		$db->select('tbl_accounts','*',NULL,'id="'.$id.'" and role="1"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$result = $db->getResult();
	?>	
	<!--==============================Accounts=================================--> 	
	
			<div class="row">
			
				<div class="span4"></div>
				<div class="span4">
					<center>
						<h2>Account</h2>
					</center>
				</div>
				<div class="span4"><a href="business_owner_account.php" class="btn btn-info submitEvent bg-pink pull-right">Back to account</a></div>
					
			</div>
			<div class="row clearfix ">
				<div class="span3"></div>
				<div class="span6">
						<div id="fields" class="contact-form signin-form">
							<form id="ajax-contact-form" method="post" class="form-horizontal">
								
								<div class="control-group">
									<label class="control-label" for="inputName">Customer ID:</label>
									<input type="text" required name="customer_id" class="form-control" value="<?php echo ($result[0]['customer_id'])?$result[0]['customer_id']:"";?>" placeholder="Customer ID..." >
									<span ><?php echo $form->error("customerid"); ?></span>
								</div>
								<br>
								
								<div class="control-group">
								
									<label class="control-label" for="inputName">Account name:</label>
									<input type="text" required name="account_name" class="form-control" value="<?php echo ($result[0]['account_name'])?$result[0]['account_name']:"";?>" placeholder="Account name..." >
									<span ><?php echo $form->error("email"); ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputEmail">Sort code:</label>
									<input type="text" name="short_code" value="<?php echo ($result[0]['short_code'])?$result[0]['short_code']:"";?>" placeholder="Sort code...">
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputEmail">Account number:</label>
									<input type="text" name="account_number" value="<?php echo ($result[0]['account_number'])?$result[0]['account_number']:"";?>" placeholder="Account number...">
									
								</div>
								<br>
                                <div class="control-group">
									<label class="control-label" for="inputEmail">Stripe Account id:</label>
									<input type="text" name="stripe_account_id" value="<?php echo ($result[0]['stripe_account_id'])?$result[0]['stripe_account_id']:"";?>" placeholder="Stripe Account id...">
									
								</div>
								<br>
								
								<div class="control-group"> 
									<?php if($_GET['id']!=""){?>
									<input type="submit" name="EditAccount" class="btn submit btn-primary" value="Save changes">
									<?php }else{?>
									<input type="submit" name="AddAccount" class="btn submit btn-primary" value="Add account">
									<?php }?>
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
