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
//include('template-parts/header.php');
if(isset($_POST['AddAccount']))
{
	$role = '2';
	$user_id = $_SESSION['id'];
	$card_type = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_type']))));
	$cardholder_name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['cardholder_name']))));
	$card_number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['card_number']))));
	$exoiration_date = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['exoiration_date']))));
	$invoice_address = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['invoice_address']))));
	
	$q1= "INSERT INTO tbl_accounts (role,user_id,card_type,cardholder_name,exoiration_date,invoice_address) VALUES('2','".$user_id."','".$card_type."','".$cardholder_name."','".$exoiration_date."','".$invoice_address."')";
	$e1 = mysql_query($q1);
	$lastInsertedId = mysql_insert_id();
	
	if($lastInsertedId!="")
	{
		$_SESSION['msg']="<div class='alert alert-success'>Data inserted successfully.</div>";	
	}	
}	
?>

<?php include'header.php'; ?>
<script type="text/javascript" src="business_owner/js/custom.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
	<?php 
	if(isset($_SESSION['id']))
	{
	?>	
	<!--==============================Accounts=================================--> 	
	
		<?php
		
		$q2 = "select * from tbl_accounts where user_id=".$_SESSION['id']." and role='2'";
		$exe2 = mysql_query($q2);
		$countAccounts = mysql_num_rows($exe2);
		while($getAccount=mysql_fetch_assoc($exe2))
		{
			$totalAccount++;
			$accounts[]=$getAccount; 
		}
		if($countAccounts>0)
		{	
		?>
		<div class="row">
			<div class="span2">&nbsp;</div>
			<div class="span8">
				<center><h2>Accounts</h2></center>
			</div>
			<div class="span2">
				<a href="addAccount.php" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add account</a>
			</div>
			
		</div> 
		<div class="row">
			<div class="span3">&nbsp;</div>
			<div class="span6">
				<center>
				<?php
				if(isset($_SESSION['msg']))
				{
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
							
				}
				?>
				</center>
			</div>
			<div class="span3">&nbsp;</div>
		</div>
		<?php 
		if($countAccounts==1)
		{
		?>	
			<div class="row clearfix">
				<div class="span4">&nbsp;</div>
				<div class="span4">
				<?php
				
				foreach($accounts as $account)					
				{
					if($account['card_type']==1)$account['card_type']='Visa/Delta/Electron';
					if($account['card_type']==2)$account['card_type']='MasterCard/EuroCard';
					if($account['card_type']==3)$account['card_type']='American Express';
					if($account['card_type']==4)$account['card_type']='Solo/Maestro';
					if($account['card_type']==5)$account['card_type']='Maestro';
				?>
					<div class="panel-group" id="subscription_contents">
						<div class="panel panel-default">
							<center>	
								<div class="panel-body">
									<span>Card type : <?php echo $account['card_type'];?></span>
									<br/><br/>
									<span>Cardholder name : <?php echo $account['cardholder_name'];?></span>
									<br/><br/>
									<span>Card number : <?php echo $account['card_number'];?></span>
									<br/><br/>
									<span>Expiration date : <?php echo $account['exoiration_date'];?></span>
									<br/><br/>
									<span>Invoice address : <?php echo $account['invoice_address'];?></span>
									<br/><br/>
									<span style="font-size: 20px;" class="pink"><?php echo ($account['status']=="Active")?$account['status']." : Use above card details.":$account['status'];?></span>
									<br/><br/>
								</div>
								<div class="panel-footer">
									
									<?php if($account['status']=="Active"){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);" disabled="disabled" style="opacity:0.5 !important">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									
									<?php if($account['status']=="Inactive"){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);" disabled="disabled" style="opacity:0.5 !important">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									
									<?php if($account['status']==""){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									<div class="row">
										<a href="addAccount.php?id=<?php echo $account['id'];?>"><i class="fa fa-pencil fa-2x pink" aria-hidden="true"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="deleteAccount(<?php echo $account['id'];?>,2)"><i class="fa fa-trash-o fa-2x pink" aria-hidden="true"></i></a>
									</div>
								</div>
							</center>
						</div>
					</div>
				<?php 
				}
				?>
				</div>	
				<div class="span4">&nbsp;</div>
			</div>
		<?php	
		}
		else		
		{
		?>	
			<div class="row clearfix ">
			<?php 
				
				
				foreach($accounts as $account)					
				{
					if($account['card_type']==1)$account['card_type']='Visa/Delta/Electron';
					if($account['card_type']==2)$account['card_type']='MasterCard/EuroCard';
					if($account['card_type']==3)$account['card_type']='American Express';
					if($account['card_type']==4)$account['card_type']='Solo/Maestro';
					if($account['card_type']==5)$account['card_type']='Maestro';
				?>
				<div class="span4">
					<div class="panel-group" id="subscription_contents">
						<div class="panel panel-default">
							<center>	
								<div class="panel-body">
									<span>Card type : <?php echo $account['card_type'];?></span>
									<br/><br/>
									<span>Cardholder name : <?php echo $account['cardholder_name'];?></span>
									<br/><br/>
									<span>Card number : <?php echo $account['card_number'];?></span>
									<br/><br/>
									<span>Expiration date : <?php echo $account['exoiration_date'];?></span>
									<br/><br/>
									<span>Invoice address : <?php echo $account['invoice_address'];?></span>
									<br/><br/>
									<span style="font-size: 20px;" class="pink"><?php echo ($account['status']=="Active")?$account['status']." : Use above card details.":$account['status'];?></span>
									<br/><br/>
								</div>
								<div class="panel-footer">
									<?php if($account['status']=="Active"){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);" disabled="disabled" style="opacity:0.5 !important">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									
									<?php if($account['status']=="Inactive"){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);" disabled="disabled" style="opacity:0.5 !important">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									
									<?php if($account['status']==""){?>
									<div class="row">
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,1,2);">Active</button>	
										<button type="button"  class="btn btn-info" onclick="changeAccountStatus(<?php echo $account['id'];?>,0,2);">Inactive</button>	
									</div>
									<br/><br/>
									<?php }?>
									<div class="row">
										<a href="addAccount.php?id=<?php echo $account['id'];?>"><i class="fa fa-pencil fa-2x pink" aria-hidden="true"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="deleteAccount(<?php echo $account['id'];?>,2)"><i class="fa fa-trash-o fa-2x pink" aria-hidden="true"></i></a>
									</div>
								</div>
							</center>
						</div>
					</div>
				</div>	
				<?php
				}
				?>
						
			</div> 
			<br/>
		<?php	
		}	
		?>
		
		
		<?php
		
		}
		else
		{
		?>
			<div class="row clearfix ">
				<div class="span3"></div>
				<div class="span6">
						<div id="fields" class="contact-form signin-form">
							<form id="ajax-contact-form" method="post" class="form-horizontal">
								
								<div class="control-group">
									<label class="control-label" for="inputCardType">Card type:</label>
									<select name="card_type" style="width: 69%;color: #333;">
										<option value="1">Visa/Delta/Electron</option>
										<option value="2">MasterCard/EuroCard</option>
										<option value="3">American Express</option>
										<option value="4">Solo/Maestro</option>
										<option value="5">Maestro</option>
										
									<select>
								</div>
								<br>
								
								<div class="control-group">
								
									<label class="control-label" for="inputCardholderName">Cardholder name:</label>
									<input type="text" required name="cardholder_name" class="form-control" value="" placeholder="Cardholder name..." >
									
								</div>
								<br>
								
								<div class="control-group">
								
									<label class="control-label" for="inputCardholderName">Card number:</label>
									<input type="text" required name="card_number" class="form-control" value="" placeholder="Card number..." >
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputExoirationDate">Expiration date:</label>
									<input type="date" name="exoiration_date" value="" placeholder="Expiration date...">
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputInvoiceAddress">Invoice address:</label>
									<textarea required name="invoice_address" placeholder="Invoice address..." style="background: white;height: 100px;padding: 12px;"></textarea>
								</div>
								<br>
								
								<div class="control-group"> 
									<input type="submit" name="AddAccount" class="btn submit btn-primary" value="Add account">
								</div>						
								<div class="clearfix"></div>
							</form>
						</div>    
				</div>		  
			</div>
			
		<?php	
		}	
	
	}
	else
	{
	?>
	<div class="row ">
		<div class="clearfix ">
			<div class="span12">
			<h5>You are not Logged in yet. Please <a href="usersignin.php">login </a></h5>
			</div>
		</div>
	</div>	
	<?php
		
	}
	?>
	</div>
</section>	
<?php include'footer.php'; ?>

