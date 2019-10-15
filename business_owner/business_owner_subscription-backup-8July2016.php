<?php
include('template-parts/header.php');
require "../barclaycard/BarclaycardEpdq.class.php";
$barclaycardEpdq = new BarclaycardEpdq();
if(isset($_POST['buyNow']))
{
	
	$db->select('tbl_businessowner_subscription','*',null,'bar_id ='.$_SESSION['bar_id'].' and owner_id ='.$_SESSION['business_owner_id'],'id DESC');
	$getrecord = $db->getResult();
	$countrows = count($getrecord);
	
	$array = array(
		'owner_id'=>$_POST['ownerid'],
		'bar_id'=>$_POST['barid'],
		'subscription_id'=>$_POST['subscriptionid'],
		'duration'=>$_POST['duration'],
		'totalamount'=>$_POST['totalamount'],
		'dueamount'=>$_POST['totalamount'],
		'payment_status'=>'Pending'
		
		
	);
	$db->insert('tbl_businessowner_subscription',$array); // Table name, column names and values, WHERE conditions	
	
	$res = $db->getResult();
	$lastInsertedId = $res[0];
	if($lastInsertedId!="")
	{
		$_SESSION['msg']='<div class="alert alert-success">Order has been placed for subscription!</div>';
		header("location:business_owner_subscription.php");
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
	?>	
	<!--==============================Subscription History=================================--> 	
		 
		<?php 
		$db->select('tbl_businessowner_subscription','tbl_businessowner_subscription.*,tbl_subscription.title','tbl_subscription on tbl_subscription.id=tbl_businessowner_subscription.subscription_id','bar_id ='.$_SESSION['bar_id'].' and owner_id ='.$_SESSION['business_owner_id'],'id DESC',10);
		$res = $db->getResult();
		$numrows = count($res);
		if($numrows>0)
		{	
		?>
		<div class="row">
			
			<div class="span12">
				<center><h2>Subscriptions</h2></center>
			</div>
			
		</div>
		<div class="row clearfix ">
			<div class="span12">
				<table class="table" id="order_history">
					<thead>
						<tr>
							<th>Subscription</th>
							<th>Duration (in months)</th>
							<th>Starting date</th>
							<th>Ending date</th>
							<th>Amount (&#163;)</th>
							<th>Status</th>
							<th colspan="2">Payment method</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$i=1;	
					foreach($res as $subscription)
					{
						$today = time();
						$endofsubscription = strtotime($subscription['end_date']);
						$startofsubscription = strtotime($subscription['start_date']);
						if($today>$endofsubscription)		
						{	
							$rescntryvals  = array();
							$rescntryvals[]=$subscription;
							
							$id1 = @$rescntryvals['id'];
							$ownerid1 = @$rescntryvals['owner_id'];
							$barid1 = @$rescntryvals['bar_id'];
							if($id1!=""&&$ownerid1!=""&&$barid1!="")
							{	
								//$db->delete('tbl_businessowner_subscription','id='.$id1.' AND owner_id='.$ownerid1.' and bar_id='.$barid1);  // Table name, WHERE conditions
								$array = array(
									'payment_status'=>'Expired'
									
								);
								$db->update('tbl_businessowner_subscription',$array,'id='.$id1.' AND owner_id='.$ownerid1.' and bar_id='.$barid1);  // Table name, WHERE conditions
							}	
						}
							
					?>
						<tr>
							
							<td class='pink align-left'><?php echo $subscription['title'];?></td>
							<td><?php echo $subscription['duration'];?></td>
							<td><?php echo ($subscription['start_date']!="0000-00-00")?date('m/d/Y',strtotime($subscription['start_date'])):"-";?></td>
							<td><?php echo ($subscription['end_date']!="0000-00-00")?date('m/d/Y',strtotime($subscription['end_date'])):"-";?></td>
							<td><?php echo number_format($subscription['totalamount'],2);?></td>
							<?php
							if($subscription['payment_status']=="Pending")
							{
								echo "<td class='red'>Pending</td>";
							}	
							elseif($today>$startofsubscription&&$today>$endofsubscription&&$subscription['payment_status']=="Done"){	
								echo "<td class='red'>Expired</td>";
							}
							elseif($today<$startofsubscription&&$today<$endofsubscription&&$subscription['payment_status']=="Done"){	
								echo "<td class='green'>Paid</td>";
							}elseif($today>$startofsubscription&&$today<$endofsubscription&&$subscription['payment_status']=="Done"){
								echo "<td class='pink'>Active</td>";
							}
							else{
								echo "<td>-</td>";
							}
							?>
							<?php /*<td><a href="javascript:void(0);" onclick="deleteSubscription(<?php echo $subscription['id']?>,<?php echo $_SESSION['business_owner_id']?>,<?php echo $_SESSION['bar_id']?>);">Delete</a></td>*/?>
							<?php if($subscription['payment_status']=="Pending"){
								
									$db->select('tbl_businessowner_subscription','*',null,'owner_id ='.$_SESSION["business_owner_id"].' and bar_id = '.$_SESSION["bar_id"].' and payment_status="Done" and ref_date!="" and ref_date!="0000-00-00"','ref_date DESC',1);
									$getrecord1 = $db->getResult();
									$countrows1 = count($getrecord1);
									$_SESSION['refdate']=@$getrecord1[0]['ref_date'];
							?>
							<td>
								<form action="https://www.moneybookers.com/app/payment.pl" method="post" style="margin:0;">
									<input type="hidden" name="pay_to_email" value="demoqco@sun-fish.com">
									<input type="hidden" name="transactionid" value="MBS<?php echo time(); ?>">
									<input type="hidden" name="return_url" value="http://mybarnite.com/business_owner/subscription_payment_success.php">
									<input type="hidden" name="cancel_url" value="http://mybarnite.com/business_owner/subscription_payment_cancel.php">
									<input type="hidden" name="status_url" value="http://mybarnite.com/business_owner/subscription_payment_status.php">
									<input type="hidden" name="language" value="EN">
									<input type="hidden" name="merchant_fields" value="ownerid,subscriptionid,transactionid,amount,duration,refdate">
									<?php
									if($countrows1>0)
									{	
										
									?>
									<input type="hidden" name="refdate" value="<?php echo $_SESSION['refdate']?>">	
								<?php }?>
									<input type="hidden" name="subscriptionid" value="<?php echo $subscription['id'] ?>">
									<input type="hidden" name="ownerid" value="<?php echo $_SESSION['business_owner_id']?>">
									<input type="hidden" name="barid" value="<?php echo $_SESSION['bar_id']?>">
									<input type="hidden" name="duration" value="<?php echo $subscription['duration']?>">
									 
									<input type="hidden" name="detail1_description" value="Subscription:">
									<input type="hidden" name="detail1_text" value="<?php echo $subscription['title'];?>">
									
									<input type="hidden" name="amount" value="<?php echo $subscription['totalamount'];?>">
									<input type="hidden" name="currency" value="GBP">		
									<input type="submit" name="buyNow" value="Pay via Skrill" class="btn btn-info bg-pink" />		
								</form>	
							</td>
							<td>
							<?php 
								$db->select('user_register','*',NULL,'id='.$_SESSION['business_owner_id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
								$userdetails = $db->getResult();
								
								if($_SESSION['refdate']!="")
								{
									$customer = array(
										'name' => $userdetails[0]['name'],
										'email' => $userdetails[0]['email'],
										'refdate' => $_SESSION['refdate'],
										'PARAMPLUS' => 'emailid='.$userdetails[0]['email'].'&roleid='.$userdetails[0]['r_id'].'&userid='.$_SESSION['business_owner_id'].'&duration='.$subscription['duration'].'&refdate='.strtotime($_SESSION['refdate'])
										
									);	
								}
								else{
									$customer = array(
										'name' => $userdetails[0]['name'],
										'email' => $userdetails[0]['email'],
										'refdate' => $_SESSION['refdate'],
										'PARAMPLUS' => 'emailid='.$userdetails[0]['email'].'&roleid='.$userdetails[0]['r_id'].'&userid='.$_SESSION['business_owner_id'].'&duration='.$subscription['duration']
										
									);
								}		
								
								$orderid = 'MB'.time();
								$order = array(
									'amount' => $subscription['totalamount'],
									'orderid' => $subscription['id'].'-MBS'.time()
								);
								
								$formParams = array(
									'ORDERID' => $order['orderid'],
									'AMOUNT' => round($order['amount'] * 100),
									'CN' => $customer['name'],
									'COM' => $customer['refdate'],
									'PARAMPLUS' => $customer['PARAMPLUS'],
									'EMAIL' => $customer['email'],
									'TITLE' => 'Subscription Payment form',
									'LOGO' => 'http://mybarnite.com/images/barlogo.png',
									'BUTTONBGCOLOR' => '802626',
									'BUTTONTXTCOLOR' => 'FFFFFF'
								);
								
								
								
								$barclaycardEpdq->outputForm($formParams); 
							?>
						</td>
							<?php }else{?>
							<td>-</td>
							<?php }?>
						</tr>	
					<?php
						
					$i++;
					}
					?>	
					</tbody>
				</table>
			</div>
		</div>
		<?php
		}
		?>
		<!--==============================New Subscription=================================--> 
		<?php
		$db->select('tbl_subscription','*',NULL,NULL,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$subscriptions = $db->getResult();
		$countSubscriptions = count($subscriptions);
		if($countSubscriptions>0)
		{	
		?>
		<div class="row">
			
			<div class="span12">
				<center><h2>Buy Subscription</h2></center>
			</div>
			
		</div> 

		<div class="row clearfix ">
				<?php 
					
					
					foreach($subscriptions as $subscription)					
					{
						
					?>
					<div class="span4">
						<div class="panel-group" id="subscription_contents">
							<div class="panel panel-default">
								<div class="panel-heading"><center><h3><?php echo $subscription['title'];?></h3></center></div>
								<center>	
									<div class="panel-body">
										<span><?php echo $subscription['type'];?></span>
										<br/><br/>
										<span>Duration will be <?php echo $subscription['duration'];if($subscription['duration']==1){?> month<?php }else{?> months <?php }?> </span>
										<br/><br/>
										<span>Price :<?php echo $subscription['price'];?></span>
										
									</div>
								</center>
								<div class="panel-footer">
									<center>
										
										<form action="" method="post">
											<input type="hidden" name="ownerid" value="<?php echo $_SESSION['business_owner_id']?>">
											<input type="hidden" name="barid" value="<?php echo $_SESSION['bar_id']?>">
											<input type="hidden" name="subscriptionid" value="<?php echo $subscription['id']?>">
											<input type="hidden" name="duration" value="<?php echo $subscription['duration']?>">
											<input type="hidden" name="totalamount" value="<?php echo $subscription['price']?>">
											<input type="submit" name="buyNow" value="Buy Now!" class="btn btn-info" />	
										</form>	
											
									</center>
								</div>
							</div>
						</div>
					</div>	
					<?php
					}
					?>
				
		</div> 
		<?php
		
		}
	
	}
	?>
	</div>
</section>	
<?php include'template-parts/footer.php'; ?>