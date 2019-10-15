<?php
include('template-parts/header.php');
require "../barclaycard/BarclaycardEpdq.class.php";
require_once('../config.php');
$barclaycardEpdq = new BarclaycardEpdq();

$subscriptionid = $_GET['id'];
$db->select('tbl_businessowner_subscription','tbl_businessowner_subscription.*,tbl_subscription.title','tbl_subscription on tbl_subscription.id=tbl_businessowner_subscription.subscription_id','tbl_businessowner_subscription.id = '.$subscriptionid.' and bar_id ='.$_SESSION['bar_id'].' and owner_id ='.$_SESSION['business_owner_id'],'id DESC',10);
$res = $db->getResult();
$numrows = count($res);	

if($res[0]['discountAmount']!=""&&$res[0]['discountAmount']!="0"){
	$amountNeedToPay = $res[0]['totalPayableAmount'];
}
else{
	$amountNeedToPay = $res[0]['totalamount'];	
}
?>
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
	<?php
	if(isset($_SESSION['business_owner_id']))
	{	
		if($numrows>0)
		{	
		?>
		<div class="row">
			<div class="span4">&nbsp;</div>
			<div class="span4 table-responsive">
				<center>
					<table class="table ordersummary" id="ordersummary">
					    <tr class="tbl_title">
							<td colspan="3">SUMMARY</td>
						</tr>
						<tr>
							<td><strong>Subscription</strong></td><td><strong>:</strong></td><td><?php echo $res[0]['title'];?></td>
						</tr>	
						<tr>	
							<td><strong>Duration (in months)</strong></td><td><strong>:</strong></td><td><?php echo $res[0]['duration'];?></td>
						</tr>	
						<?php if($res[0]['discountAmount']!=""&&$res[0]['discountAmount']!="0"){?>
						<tr>	
							<td><strong>Amount (&#163;)</strong></td><td><strong>:</strong></td><td><?php echo number_format($res[0]['totalPayableAmount'],2);?></td>
						</tr>
						<?php }else{
							?>
						<tr>	
							<td><strong>Amount (&#163;)</strong></td><td><strong>:</strong></td><td><?php echo number_format($res[0]['totalamount'],2);?></td>
						</tr>
						<?php	
						}?>
						
						<?php if($res[0]['discountAmount']!=""&&$res[0]['discountAmount']!="0"){?>
						<tr>	
							<td><strong>Discount (&#163;)</strong></td><td><strong>:</strong></td><td><?php echo number_format($res[0]['discountAmount'],2);?></td>
						</tr>
						<?php 
						}
						?>
						<?php if($res[0]['payment_status']=="Pending"){
							
									$db->select('tbl_businessowner_subscription','*',null,'owner_id ='.$_SESSION["business_owner_id"].' and bar_id = '.$_SESSION["bar_id"].' and payment_status="Done" and ref_date!="" and ref_date!="0000-00-00"','ref_date DESC',1);
									$getrecord1 = $db->getResult();
									$countrows1 = count($getrecord1);
									$_SESSION['refdate']=@$getrecord1[0]['ref_date'];
						?>
						<tr>
							
							
							 <td colspan="2">
								<?php 
									$db->select('user_register','*',NULL,'id='.$_SESSION['business_owner_id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
									$userdetails = $db->getResult();
								 ?>
									<form action="https://mybarnite.com/business_owner/business_owner_subscription.php" method="post" value="">
										<input type="hidden" name="instId"  value="1273779">
										<input type="hidden" name="cartId" value="<?php echo $res[0]['id']; ?>">
										<input type="hidden" name="currency" value="GBP">
										<input type="hidden" name="amount"  value="<?php echo ($amountNeedToPay * 100 );?>">
										<input type="hidden" name="MC_success" value="http://mybarnite.com/">
										<input type="hidden" name="MC_name" value="<?php echo $userdetails[0]['name'];?>">
										<input type="hidden" name="subscriptionid" value="<?php echo $subscriptionid;?>">
										<input type="hidden" name="ownerid" value="<?php echo $_SESSION["business_owner_id"];?>">
										<input type="hidden" name="bar_id" value="<?php echo $_SESSION["bar_id"];?>">
										<input type="hidden" name="MC_userid" value="<?php echo $_SESSION['business_owner_id'];?>">
										<input type="hidden" name="MC_duration" value="<?php echo $res[0]['duration'];?>">
										<input type="hidden" name="MC_roleid" value="1">
										<input type="hidden" name="MC_emailid" value="<?php echo $userdetails[0]['email'];?>">
										<input type="hidden" name="MC_orderID" value="<?php echo $res[0]['id'].'-MBS'.time();?>">
										<input type="hidden" name="MC_CN" value="<?php echo $userdetails[0]['name'];?>">
										<?php 
										if($countrows1>0)
										{	
										?>
										<input type="hidden" name="MC_refdate" value="<?php echo strtotime($_SESSION['refdate']);?>">
										<?php 
										}
										
										?>										
										<script
										    src="https://checkout.stripe.com/checkout.js"
										    class="stripe-button"
										    data-billing-address="true"
										    data-label="Make Payment"
										    data-key="<?php echo $stripe['publishable_key']; ?>"
										    data-name="<?php echo $row['name'];?>"
										    data-description=""
										    data-amount="<?php echo $amountNeedToPay * 100;?>"
										    data-currency="gbp"
										    data-image = "https://mybarnite.com/images/barlogo.png"
										    data-allow-remember-me = "false">
										</script>      	
									</form>
								</td>	
									
						</tr>
						<tr>
							<td colspan="3"><a href="business_owner_subscription.php">Back</a>
								<img src="../img/card.jpg" class="pull-right" height="100" width="200" style="background:white;">
							</td>
						</tr>
						<?php 
						}
						?>
					</table>	
				</center>	
			</div>
			<div class="span4">&nbsp;</div>
		</div>
		<?php
		}
	}	
?>
	</div>
</section>			
<?php include'template-parts/footer.php'; ?>
<style type="text/css">
	.stripe-button-el {
	    background: #ff1da5;
	    border-radius: 50px;
	    float: right;
	    margin-top: 5px;
	}
	.stripe-button-el span {
	    background: #ff1da5;
	    border-radius: 50px;
	}
</style>