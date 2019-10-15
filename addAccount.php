<?php
session_start();
ob_start();

include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

if(isset($_POST['AddAccount']))
{
	$role = '2';
	$user_id = $_SESSION['id'];
	$card_type = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_type']))));
	$cardholder_name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['cardholder_name']))));
	$card_number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_number']))));
	$exoiration_date = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['exoiration_date']))));
	$invoice_address = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['invoice_address']))));
	
	$q1= "INSERT INTO tbl_accounts (role,user_id,card_type,cardholder_name,card_number,exoiration_date,invoice_address) VALUES('2','".$user_id."','".$card_type."','".$cardholder_name."','".$card_number."','".$exoiration_date."','".$invoice_address."')";
	$e1 = mysql_query($q1);
	$lastInsertedId = mysql_insert_id();
	
	if($lastInsertedId!="")
	{
		$_SESSION['msg']="<div class='alert alert-success'>Data inserted successfully.</div>";	
		header("location:account.php");
	}	
}	
if(isset($_POST['EditAccount'])&&$_GET['id']!="")
{
	$role = '2';
	$user_id = $_SESSION['id'];
	$card_type = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_type']))));
	$cardholder_name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['cardholder_name']))));
	$card_number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_number']))));
	$exoiration_date = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['exoiration_date']))));
	$invoice_address = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['invoice_address']))));
	$id = $_GET['id'];
	
	$q2 = "update tbl_accounts set card_type = '".$card_type."', cardholder_name = '".$cardholder_name."',card_number = '".$card_number."', exoiration_date = '".$exoiration_date."', invoice_address = '".$invoice_address."' where id=".$id;
	$exe2 = mysql_query($q2);
	$res = mysql_affected_rows();
	if($res>0)
	{
		$_SESSION['msg']="<div class='alert alert-success'>Data has been updated successfully.</div>";	
		header("location:account.php");
	}
	else
	{
		$_SESSION['msg']="<div class='alert alert-success'>It seems not changes have been made.</div>";	
		header("location:account.php");
	}		
}	
?>
<?php include'header.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
	<?php 
	if(isset($_SESSION['id']))
	{
		$id = $_GET['id']; 
		
		$q3 = "SELECT * FROM tbl_accounts WHERE id=".$id." and role='2'";
		$exe3 = mysql_query($q3);
		$result = mysql_fetch_assoc($exe3);
		
		/* echo "<pre>";
		print_r($result); */
		
	?>	
	<!--==============================Accounts=================================--> 	
	
	
			<div class="row clearfix ">
				<div class="span3"></div>
				<div class="span6">
						<div id="fields" class="contact-form signin-form">
							<form id="ajax-contact-form" method="post" class="form-horizontal">
								<div class="control-group">
								<?php
								
								/* if(isset($_SESSION['msg']))
								{
									echo $_SESSION['msg'];
									unset($_SESSION['msg']);
											
								} */
								?>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputCardType">Card type:</label>
									<select name="card_type" style="width: 69%;color: #333;">
										<option value="1" <?php if($result['card_type']=="1"){?> selected="selected" <?php }?> >Visa/Delta/Electron</option>
										<option value="2" <?php if($result['card_type']=="2"){?> selected="selected" <?php }?> >MasterCard/EuroCard</option>
										<option value="3" <?php if($result['card_type']=="3"){?> selected="selected" <?php }?> >American Express</option>
										<option value="4" <?php if($result['card_type']=="4"){?> selected="selected" <?php }?> >Solo/Maestro</option>
										<option value="5" <?php if($result['card_type']=="5"){?> selected="selected" <?php }?> >Maestro</option>
										
									<select>
								</div>
								<br>
								
								<div class="control-group">
								
									<label class="control-label" for="inputCardholderName">Cardholder name:</label>
									<input type="text" required name="cardholder_name" class="form-control" value="<?php echo ($result['cardholder_name'])?$result['cardholder_name']:"";?>" placeholder="Cardholder name..." >
									
								</div>
								<br>
								
								<div class="control-group">
								
									<label class="control-label" for="inputCardholderName">Card number:</label>
									<input type="text" required name="card_number" class="form-control" value="<?php echo ($result['card_number'])?$result['card_number']:"";?>" placeholder="Card number..." >
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputExoirationDate">Expiration date:</label>
									<input type="date" name="exoiration_date" value="<?php echo ($result['exoiration_date'])?$result['exoiration_date']:"";?>" placeholder="Expiration date...">
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputInvoiceAddress">Invoice address:</label>
									<textarea required name="invoice_address" placeholder="Invoice address..." style="background: white;height: 100px;padding: 12px;"><?php echo ($result['invoice_address'])?$result['invoice_address']:"";?></textarea>
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
<?php include'footer.php'; ?>
