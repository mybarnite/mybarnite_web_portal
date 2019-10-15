<?php
include('template-parts/header.php');

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
	?>	
	<!--==============================Subscription History=================================--> 	
		 
		<?php 
		$db->select('tbl_businessowner_subscription','tbl_businessowner_subscription.*,tbl_subscription.title','tbl_subscription on tbl_subscription.id=tbl_businessowner_subscription.subscription_id','bar_id ='.$_SESSION['bar_id'].' and owner_id ='.$_SESSION['business_owner_id'],'id DESC',10);
		$res = $db->getResult();
		$numrows = count($res);
		/* if($numrows>0)
		{ */	
		?>
		<div class="row">
			
			<div class="span12">
				<center><h2>Sales</h2></center>
			</div>
			
		</div>
		<div class="row">
			<?php 
			$db->select('bars_list','*',null,'id ='.$_SESSION['bar_id'],'id DESC');
			$getBar = $db->getResult();
			$db->select('tbl_order_history','SUM(total_amount) as totalPurchase',NULL,'Owner_id="'.$_SESSION['business_owner_id'].'" and payment_status="Done"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$totalPurchase = $db->getResult();
			if($getBar[0]['is_payasyougo']=="1")
			{
				$commission = ($totalPurchase[0]['totalPurchase'] * $getBar[0]['Commission'])/100;
				$amountToRetriev = $totalPurchase[0]['totalPurchase'] - $commission;	
			}	
			if($getBar[0]['is_payasyougo']=="2")
			{
				$commission = ($totalPurchase[0]['totalPurchase'] * $getBar[0]['Discount'])/100;
				$amountToRetriev = $totalPurchase[0]['totalPurchase'] - $commission;	
			}
			
			?>
			
			<div class="span6">
				<center>
					<h3 style="margin:0;">
						<?php if($getBar[0]['is_payasyougo']=="1"){?>
						<strong style="text-transform:none;font-size:14px;">Commission per transaction: <?php echo $getBar[0]['Commission']."%";?></strong>
						<?php }?>
						<?php if($getBar[0]['is_payasyougo']=="2"){?>
						<strong style="text-transform:none;font-size:14px;">Discount per transaction: <?php echo $getBar[0]['Discount']."%";?></strong>
						<?php }?>
						<?php if($getBar[0]['is_payasyougo']=="0"||$getBar[0]['is_payasyougo']==""||$getBar[0]['is_payasyougo']==null){
							$db->select('tbl_settings','*',null,'id =1','id DESC');
							$getSettings = $db->getResult();	
						?>
						<strong style="text-transform:none;font-size:14px;">Discount (%): <?php echo $getSettings[0]['discount'];?></strong>
						<strong style="text-transform:none;font-size:14px;">Commission (%): <?php echo $getSettings[0]['commision'];?></strong>
						<?php }?>
					</h3>
				</center>
			</div>
			
			
			
			<div class="span6">
				<center><h3 style="margin:0;"><strong>Amount to be recieved (&pound;)	: <?php echo number_format($amountToRetriev,2);?></strong></h3></center>
			</div>
			
			
			<div class="span6">
				<center>
					<h3 style="margin:0;">
						<?php if($getBar[0]['is_payasyougo']=="1"){?>
						<strong style="text-transform:none;font-size:14px;">Commission amount (&pound;): <?php echo number_format($commission,2);?></strong>
						<?php }?>
						<?php if($getBar[0]['is_payasyougo']=="2"){?>
						<strong style="text-transform:none;font-size:14px;">Discount amount (&pound;): <?php echo number_format($commission,2);?></strong>
						<?php }?>
						
					</h3>
				</center>
			</div>
			<div class="span6">
				<?php 
				$db->select('tbl_order_history','SUM(total_amount) as totalRefund',NULL,'Owner_id="'.$_SESSION['business_owner_id'].'" and payment_status="Refunded"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$totalRefund = $db->getResult();
				$refundAmount = $totalRefund[0]['totalRefund'];
				?>
			
				<center><h3 style="margin:0;"><strong style="text-transform:none;font-size:14px;">Total refund amount	(&pound;) : <?php echo number_format($refundAmount,2);?></strong></h3></center>
			</div>
			
		</div>
		<?php
			//SELECT SUM(total_amount) AS Total_Amount FROM tbl_order_history WHERE order_created_at BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01 00:00:00') AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), '%Y-%m-%d 23:59:59')
			$db->select('tbl_order_history','SUM(total_amount) AS Total_Amount',null,'owner_id = '.$_SESSION["business_owner_id"].' and payment_status="Done"  and order_created_at BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, "%Y-%m-01 00:00:00") AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), "%Y-%m-%d 23:59:59")',null,null);
			$monthlySales = $db->getResult();
			$countsales = count($monthlySales);
			if($countsales>0)
			{	
			?>
			<div class="row">
				<div class="span12">
					<center>
						<div class="span4">
							<div class="panel-group" id="subscription_contents">
								<div class="panel panel-default">
									<div class="panel-heading bg-sales-heading"><center><h3 class="color-white">Last Month</h3></center></div>
									<center>	
										<div class="panel-body">
											<span><img src="<?php echo SITE_PATH;?>images/shopping-basket-xxl.png" height="100" width="100"></span>
											<br/><br/>
											<span>Total Purchase</span>
											<br/><br/>
											<span style="color:#ff1da5;font-weight:bold;font-size:20px;">&#8356;	<?php echo ($monthlySales[0]['Total_Amount'])?number_format($monthlySales[0]['Total_Amount'],2):0.00;?></span>
										</div>
									</center>
								</div>
							</div>
						</div>	
						<div class="span7">
							<div class="panel-group" id="subscription_contents">
								<div class="panel panel-default">
									<div class="panel-heading bg-sales-heading"><center><h3 class="color-white">Check Total Sales :</h3></center></div>

									<div class="panel-body">
										<span id="msg" style="color:#ff0000;">
									<div class="control-group">
			      						<label class="control-label pink-color-cls" for="inputName">Select date :</label>
			      						<input type="text" name="startdate" id="startdate" class="date start" required placeholder="mm/dd/yyyy" />
			      					</div>

			      					<div class="control-group">
			      						<label class="control-label pink-color-cls" for="inputName">To :</label>
			      						<input type="text" name="enddate" id="enddate" class="date end" placeholder="mm/dd/yyyy" required />
			      					</div>

			      					<div class="control-group">
			      						<label class="control-label" for="inputName"></label>
			      						<input type="submit" name="filter" id="filter" class="btn btn-info bg-pink" value="Submit" onclick="gettotalpurchase();" />
			      					</div>

			      					<span id="amount" style="color:#ff1da5;font-weight:bold;font-size:20px;"></span>
										
										
									</div>
								</div>
							</div>
						</div>
					</center>	
				</div>
			</div>
			<br/>
		<?php
			}
		/* } */
		?>
		<!--==============================New Subscription=================================--> 
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
<script>
	$('#subscription_contents .time').timepicker({
		'showDuration': true,
		'timeFormat': 'g:ia'
	});

	$('#subscription_contents .date').datepicker({
		'format': 'mm/dd/yyyy',
		'allowInputToggle': true
	});

	$('#subscription_contents').datepair();
</script>
<?php include'template-parts/footer.php'; ?>