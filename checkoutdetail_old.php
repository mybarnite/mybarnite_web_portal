<?php
session_start();

include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
/*--------------------- Barclaycard  --------------------*/
require "barclaycard/BarclaycardEpdq.class.php";
$resultUrl = "https://mybarnite.com/barclaycard/return.php";
$barclaycardEpdq = new BarclaycardEpdq();

/*--------------------- Barclaycard ends here --------------------*/?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
<?php include'head.php'; ?>
<title>Your Order Details</title>
<meta name="keywords" content="Order Details">
<meta name="description" content="Order checkout details">
<?php include'header.php'; ?>

<!--==============================Content=================================--> 
<section id="content" >
	<div class="container divider">
    
		<div class="row">
			<div class="span12">
				
			</div>
		</div>  
		<?php 
		if(isset($_GET['orderid'])&&$_GET['orderid']!='Y')
		{
				$orderid = $_GET['orderid'];
				$sql = "SELECT o.* ,u.name as uname , u.email ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name 
				FROM tbl_order_history o left join user_register u on u.id=o.user_id where payment_status = 'Pending' and o.id =".$orderid;
				$exe = mysql_query($sql)or die(mysql_error()); 
				$rowcount = mysql_num_rows($exe);
				$row=mysql_fetch_assoc($exe);
				/*echo "<pre>";
				print_r($row);*/
				
				if($row['event_id']==0)
				{
					$sql_1 = "SELECT b.*,g.file_path as file_path from bars_list b left outer join tbl_bar_gallary g on b.id = g.bar_id and g.logo_image = '1' where  b.id = ".$row['bar_id'];
					$exe_1 = mysql_query($sql_1)or die(mysql_error()); 
					$getBarDetail=mysql_fetch_assoc($exe_1);
					
					if($getBarDetail['file_path']=="")
					{
						$file_path = "images/no_image.png";
					}	
					else
					{
						$file_path = "business_owner/".$getBarDetail['file_path'];
					}
				}	
				else
				{
					$sql_1 = "SELECT e.*,g.file_path as file_path from tbl_events e left outer join tbl_event_gallery g on e.id = g.event_id and g.logo_image = '1' where e.id = ".$row['event_id'];
					$exe_1 = mysql_query($sql_1)or die(mysql_error()); 
					$getEventDetail=mysql_fetch_assoc($exe_1);
					if($getEventDetail['file_path']=="")
					{
						$file_path = "images/no_image.png";
					}	
					else
					{
						$file_path = "business_owner/".$getEventDetail['file_path'];
					}
					
				}	
				//$getEventDetail['free_event'];
				if($rowcount>0)
				{	
					$totalamount = (isset($_SESSION['payableamount'])&&$_SESSION['payableamount']!=0)?$_SESSION['payableamount']:$row['total_amount'];
					if($row['email']=="")
					{	
				?>
					<div class="row">
						<div class="span2">&nbsp;</div>
						<div class="span8">
							<div class="alert alert-danger">Warning! - If you want payment reciept in your email then you need to set your email address in settings page before payment done.</div>		
						</div>
						<div class="span2">&nbsp;</div>
					</div>  
				<?php 
					}
				?>	
				<div class="row">
					<div class="span1">&nbsp;</div>
					<div class="span 7 table-responsive">
						<center>
						
						<?php if(isset($_SESSION['msg'])){ 
											echo $_SESSION['msg'];
											unset($_SESSION['msg']);
									 } ?>
									 
						<?php if($_SESSION['discount']==0){
										if(isset($_SESSION['isValid'])){	
											echo "<div class='alert alert-danger'>You are entering coupon code which might be invalid or not activated!</div>";
										unset($_SESSION['isValid']);} 
									}unset($_SESSION['isValid']);?>
							<table class="table ordersummary" id="checkoutdetails">
								<tr class="tbl_title">
									<td>BOOKING SUMMARY</td>
									<td></td>
								</tr>
								
								<tr>
									<td><img src="<?php echo $file_path;?>" alt="no_image"  border="0" class="alignleft" height="100" width="150" /></td>
									
									<td>
										<table class="table ordersummary">
										<?php if($row['event_id']=="0"){
										?>
											<tr>
												
												<td colspan="2"><strong><?php echo $row['name']; ?></strong></td>
											</tr>
											<tr>
												<td><strong>Booking Date </strong></td>
												<td><?php echo date('m/d/Y',strtotime($row['bar_booking_start_date'])); ?></td>
											</tr>
											<tr>
												<td><strong>Booking Timing </strong></td>
												<td><?php echo date('g:ia',strtotime($row['bar_booking_starts'])).'-',date('g:ia',strtotime($row['bar_booking_ends'])); ?></td>
											</tr>
											
											<tr>
												<td><strong>Booking purpose </strong></td>
												<td><?php echo ($row['bar_booking_purpose'])?$row['bar_booking_purpose']:"-"; ?></td>
											</tr>
											<tr>
												<td colspan="2"><?php echo ($row['is_hall_booked']==1)?"The bar has hall available":"The bar do not have any available hall"; ?></td>
											</tr>
											<?php if($row['is_hall_booked']==1){?>
											<tr>
												<td><strong>Hall capacity </strong></td>
												<td><?php echo $getBarDetail['hall_capacity']." People"; ?></td>
											</tr>
											
											<?php }else{?>
											<tr>
												<td><strong>No Of Persons</strong></td>
												<td><?php echo $row['no_of_persons']; ?></td>
											</tr>
												
											<?php }?>
											
										<?php } else { ?>
											<tr>
												<td colspan="2"><strong><?php echo $row['name']; ?></strong></td>
											</tr>
											<tr>
												<td><strong>No of Days </strong></td>
												<td><?php echo $row['no_of_days']; ?></td>
											</tr>
											<tr>
												<td><strong>No Of Persons </strong></td>
												<td><?php echo $row['no_of_persons']; ?></td>
											</tr>
										<?php }?>
										<tr>
											<td></td>
											<?php if($row['event_id']=="0"){?>
												<td><a href="update_bar_order.php?id=<?php echo $row['id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Update Booking"/></a></td>
												<?php }?>
									
												<?php if($row['bar_id']=="0"){?>
												<td><a href="update_order.php?id=<?php echo $row['id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Update Booking"/></a></td>
												<?php }?>
										</tr>
										</table>
									</td>
								</tr>
							</table>
						</center>
					</div>
					<div class="span4 table-responsive">
						<center>
							<table class="table ordersummary" id="bookingordersummary">
								<tr class="tbl_title">
									<td>ORDER SUMMARY</td>
									<td></td>
								</tr>
								<?php if($getEventDetail['free_event']!='1'){?>
									<tr>
										<td><strong>Amount (£) </strong></td>
										
										<td  id="saleamount"><?php echo number_format($row['total_amount'], 2, ".", ""); ?></td>
									</tr>
									<?php 
									if($row['event_id']=="0"){
									$sql1 = "SELECT * from tbl_promotions where barId=".$row['bar_id'];
									}elseif($row['bar_id']=="0"){
									$sql1 = "SELECT * from tbl_promotions where eventId=".$row['event_id'];
									}
									$exe1 = mysql_query($sql1)or die(mysql_error()); 
									$row1=mysql_fetch_assoc($exe1);
								/* 	echo "<pre>";
									print_r($row1); */
									
									?>
									<?php if(!isset($_SESSION['discount']) || $_SESSION['discount']==0){?>
										<tr>
											
											<td><strong>Dicount (£) </strong></td>
											<td data-toggle="modal" data-target="#myModalHorizontal" class="blue" style="cursor:pointer; color:#3179d8" >Click here to apply the coupon</td>
											
										</tr>
										<?php }?>
										
										
										<?php if(isset($_SESSION['discount'])&&$_SESSION['discount']!=0){?>
										
										<tr>
											<td><strong>Dicount (£) </strong></td>
											<td><?php echo number_format($_SESSION['discount'],2, ".", ""); ?></td>
										</tr>
										
										<?php }
										
										?>
										<tr>
											<td><strong>Total Payable amount (£) </strong></td>
											<td id="halfPayableAmount"><?php echo (isset($_SESSION['payableamount'])&&$_SESSION['payableamount']!=0)?number_format($_SESSION['payableamount'],2, ".", ""):number_format($row['total_amount'],2,".", ""); ?></td>
										</tr>
										<?php 
											$discount = ($_SESSION['discount']!=0||$_SESSION['discount']!="")?$_SESSION['discount']:0;
											$totalamount = number_format($totalamount,2, ".", "");
											if($row['bar_id']=="0"){?>
										<tr>
									<td></td>
									<td>
										 
										<!-- <form action="https://secure-test.worldpay.com/wcc/purchase" method="post" style="margin:0;"> -->
										 <form action="https://secure-test.worldpay.com/wcc/purchase" method="post" style="margin:0;">
												<?php 
												$sql2 = "select * from user_register where id=".$_SESSION['id'];
												$exe2 = mysql_query($sql2)or die(mysql_error()); 
												$rowcount2 = mysql_num_rows($exe2);
												$userdetails=mysql_fetch_assoc($exe2);
												$eventid = ($row['event_id'])?$row['event_id']:0;
												$barid = ($row['bar_id'])?$row['bar_id']:0;
												$usercount = $_SESSION['usercount'];
												?>
												<input type="hidden" name="instId"  value="1273779"><!-- The "instId" value "211616" should be replaced with the Merchant's own installation Id -->
												<input type="hidden" name="cartId" value="MB<?php echo time(); ?>"><!-- This is a unique identifier for merchants use. Example: PRODUCT123 -->
												<input type="hidden" name="currency" value="GBP"><!-- Choose appropriate currency that you would like to use -->
												<input type="hidden" name="amount"  value="<?php echo $totalamount;?>">
												<input type="hidden" name="desc" value="">
												<input type="hidden" name="testMode" value="100"> 
												<input type="hidden" name="MC_success" value="http://mybarnite.com/">
												<input type="hidden" name="MC_userid" value="<?php echo $_SESSION['id'];?>">
												<input type="hidden" name="MC_eventid" value="<?php echo $eventid;?>">
												<input type="hidden" name="MC_barid" value="<?php echo $barid;?>">
												<input type="hidden" name="MC_roleid" value="2">
												<input type="hidden" name="MC_persons" value="<?php echo $row['no_of_persons'];?>">
												<input type="hidden" name="MC_emailid" value="<?php echo $userdetails['email'];?>">
												<input type="hidden" name="MC_usercount" value="<?php echo $_SESSION['usercount'];?>">
												<input type="hidden" name="MC_orderID" value="<?php echo $row['id'].'-MB'.time();?>">
												<input type="hidden" name="MC_CN" value="<?php echo $userdetails['name'];?>">
												<input type="hidden" name="MC_name" value="<?php echo $row['name'];?>">
												<input type="submit" value="Make Payment" class="btn btn-info bg-pink pull-right"> <!--Submit-->
												 <!--<img src="img/skrill.PNG" style="height: 44px;">-->
										</form>
										
									</td>
									</tr>
									<tr>
										<td></td>
										<?php if($row['event_id']=="0"){?>
										
										<td><a href="bardetail.php?barid=<?php echo $row['bar_id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Cancel"/></a></td>
												<?php }?>
										
										<?php if($row['bar_id']=="0"){?>
										
										<td><a href="eventsdetail.php?event_id=<?php echo $row['event_id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Cancel"/></a></td>
										
										
										<?php }?>
									</tr>
									<tr>
										<td colspan="2">	
											<p>How does Mybarnite Limited handle your Payment?</p>
											
											<p>We are using WorldPay technology to collect the details and process your payment on our website.</p>
											
											<p>After confirming your order(s), you will be redirected to WorldPay's secure page to complete and submitt your payment for final processing.</p>
											
											<p>WorldPay will re-submit your transaction to your bank for authentication, whether or not the transaction is successful or declined, you will received an email confirming the transaction details in the email provided while registering on our website.</p>
										</td>
									</tr>	
									<tr>
									<td colspan="2">
										<img src="img/worlspay-cards.png" class="pull-right" height="100" width="200" style="background:white;">
											<!--<script language="JavaScript" src="https://secure.worldpay.com/wcc/logo?instId=1140022"></script>-->
									</td>
									</tr>
								<?php 
									}
									else
									{
									?>
								<tr>
									<td><strong>Choose payment option </strong></td>
									
									<td>
										<input type="radio" name="payment_opt" value="1" style="margin:0;"> Pay online<br>
										<input type="radio" name="payment_opt" value="0" style="margin:0;"> Pay at venue (You have to pay 20%)
									</td>
								</tr>
								<tr>
									<td colspan="2" id="payment_opt_err">
									
									</td>
								</tr>	
								<tr>
									<td></td>
									<td>
									
										<form action="https://secure-test.worldpay.com/wcc/purchase" name="worldpayForm" id="worldpayForm" method="post" style="margin:0;">
												<?php 
												$sql2 = "select * from user_register where id=".$_SESSION['id'];
												$exe2 = mysql_query($sql2)or die(mysql_error()); 
												$rowcount2 = mysql_num_rows($exe2);
												$userdetails=mysql_fetch_assoc($exe2);
												$eventid = ($row['event_id'])?$row['event_id']:0;
												$barid = ($row['bar_id'])?$row['bar_id']:0;
												$usercount = $_SESSION['usercount'];
												
												?>
												<input type="hidden" name="instId"  value="1273779"><!-- The "instId" value "211616" should be replaced with the Merchant's own installation Id -->
												<input type="hidden" name="cartId" value="MB<?php echo time(); ?>"><!-- This is a unique identifier for merchants use. Example: PRODUCT123 -->
												<input type="hidden" name="currency" value="GBP"><!-- Choose appropriate currency that you would like to use -->
												<input type="hidden" name="MC_totalpayable" value="<?php echo $totalamount;?>">
												<input type="hidden" name="amount" id="halfPayAmount" value="<?php echo $totalamount;?>">
												
												<input type="hidden" name="desc" value="">
												<input type="hidden" name="testMode" value="100">
												<input type="hidden" name="MC_success" value="http://mybarnite.com/">
												<input type="hidden" name="MC_payonline" id="MC_payonline" value="1">
												<input type="hidden" name="MC_pendingamount" id="MC_pendingamount" value="0">
												<input type="hidden" name="MC_discount" value="<?php echo $discount;?>">
												<input type="hidden" name="MC_userid" value="<?php echo $_SESSION['id'];?>">
												<input type="hidden" name="MC_eventid" value="<?php echo $eventid;?>">
												<input type="hidden" name="MC_barid" value="<?php echo $barid;?>">
												<input type="hidden" name="MC_roleid" value="2">
												<input type="hidden" name="MC_persons" value="<?php echo $row['no_of_persons'];?>">
												<input type="hidden" name="MC_hall" value="<?php echo $row['is_hall_booked'];?>">
												<input type="hidden" name="MC_emailid" value="<?php echo $userdetails['email'];?>">
												<input type="hidden" name="MC_usercount" value="<?php echo $_SESSION['usercount'];?>">
												<input type="hidden" name="MC_orderID" value="<?php echo $row['id'].'-MB'.time();?>">
												<input type="hidden" name="MC_CN" value="<?php echo $userdetails['name'];?>">
												<input type="hidden" name="MC_name" value="<?php echo $row['name'];?>">
												 <!-- <input type="submit" class="btn btn-cards"> Submit-->
												<input type="button" class="btn btn-info bg-pink pull-right" name="makePayment" id="makePayment" value="Make Payment">		
												
												<!--<img src="img/skrill.PNG" style="height: 44px;">-->
										</form>
									</td>
									</tr>
									<tr>
										<td></td>
										<?php if($row['event_id']=="0"){?>
										
										<td><a href="bardetail.php?barid=<?php echo $row['bar_id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Cancel"/></a></td>
												<?php }?>
										
										<?php if($row['bar_id']=="0"){?>
										
										<td><a href="eventsdetail.php?event_id=<?php echo $row['event_id']?>"><input type="button" class="btn btn-info bg-pink pull-right" value="Cancel"/></a></td>
										
										
										<?php }?>
									</tr>
									<tr>
										<td colspan="2">	
											<p>How does Mybarnite Limited handle your Payment?</p>
											
											<p>We are using WorldPay technology to collect the details and process your payment on our website.</p>
											
											<p>After confirming your order(s), you will be redirected to WorldPay's secure page to complete and submit your payment for final processing.</p>
											
											<p>WorldPay will re-submit your transaction to your bank for authentication, whether or not the transaction is successful or declined, you will received an email confirming the transaction details in the email provided while registering on our website.</p>
										</td>
									</tr>	
									<tr>
									<td colspan="2">
										<img src="img/worlspay-cards.png" class="pull-right" height="100" width="200" style="background:white;">
											<!--<script language="JavaScript" src="https://secure.worldpay.com/wcc/logo?instId=1140022"></script>-->
									</td>
									</tr>
								<?php }
								}?>
								
								
							</table>
						</center>
					</div>
					
					
					
					
				<?php
				}
		
		}
		else
		{
		?>	
			<div class="row">
				<div class="span12">
					<center><h3 class="red" style="text-transform: inherit;">Order can not be placed, Something went wrong!</h3></center>
				</div>
			</div> 
		<?php	
		}
		?>
	</div>
</section>

	
<?php include'footer.php'; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
<script>

$(document).ready( function() 
{
	//alert($('input[name=payment_opt]:checked').val());
	$('#bookingordersummary input').on('change', function() {
		var payment_opt = $('input[name=payment_opt]:checked', '#bookingordersummary').val();
		//alert(payment_opt);
		$("#MC_payonline").val(payment_opt);
		if(payment_opt==0)
		{//Pay at venue
			
			var amount = <?php echo (isset($_SESSION['payableamount'])&&$_SESSION['payableamount']!=0)?$_SESSION['payableamount']:$row['total_amount']; ?>;
			
			//var halfamount = 0.2;
			var payableamount = 0.2 * amount;
			var pendingpayableamount = amount - payableamount;
			$("#halfPayableAmount").html(payableamount.toFixed(2)+" ("+pendingpayableamount.toFixed(2)+" will remain from "+amount.toFixed(2)+")");
			//alert(payableamount);
			$("#halfPayAmount").val(payableamount.toFixed(2));
			$("#MC_pendingamount").val(pendingpayableamount.toFixed(2));
			
		}
		else
		{
			var amount = <?php echo (isset($_SESSION['payableamount'])&&$_SESSION['payableamount']!=0)?$_SESSION['payableamount']:$row['total_amount']; ?>;
			//alert(amount);
			//var halfamount = 0.2;
			var payableamount = amount;
			var pendingpayableamount = 0;
			$("#halfPayableAmount").html(payableamount.toFixed(2));
			$("#halfPayAmount").val(payableamount.toFixed(2));
			$("#MC_pendingamount").val(0);	
			
		}		
	});
	
    $('#checkcode').click(function() {
				
				 $.ajax({
						type: "POST",
						url: "https://mybarnite.com/countAmount.php",
						data: {orderId :$("#OrderId").val(),Amount :$("#Amount1").val(),code :$("#code").val(),barId :$("#barId").val(),eventId :$("#eventId").val()},
							 success: function(result){
									//console.log(result);return false;
										setTimeout(function(){
										   window.location.reload(1);
										},500);
									
									//window.location="checkoutdetail.php?orderid=<?php echo $row['id'] ?>";
									
							 },
							error: function(){
								//alert("failure");
							}
				   });
			
    })

<?php if(isset($_GET['orderid'])&&$_GET['orderid']!='Y')
{?>

			$("#makePayment").click(function() {
				var payment_opt = $('input[name=payment_opt]:checked', '#bookingordersummary').val();
				//alert(payment_opt);
				if(payment_opt==""||payment_opt=="undefined"||payment_opt==null)
				{
					$("#payment_opt_err").html("Please select payment option.");return false;
				}	
				else
				{
					var bar_id = <?php echo $row['bar_id'];?>;
					var start_date = "<?php echo $row['bar_booking_start_date'];?>";
					//var end_date = $("#bar_booking_end_date").val();
					var start_time = "<?php echo date('g:ia',strtotime($row['bar_booking_starts']));?>";
					var end_time = "<?php echo date('g:ia',strtotime($row['bar_booking_ends']));?>";
					var hall_booking = <?php echo $row['is_hall_booked'];?>;
					var no_of_persons = <?php echo $row['no_of_persons'];?>;
					$.ajax({
						type: "POST",
						url: "https://mybarnite.com/checkAvailabilityForSeat.php",
						data: {order_id:<?php echo $_GET['orderid']?>,bar_id:bar_id,start_date:start_date,start_time:start_time,end_time:end_time,hall_booking:hall_booking,no_of_persons:no_of_persons},
						success: function(result){
							console.log(result);	
							if(result=="Available")
							{
								//window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
								//sendOrderConfirmation();
								$('form[name=worldpayForm]').submit();
							}
							else if(hall_booking==1&&no_of_persons==""&&result=="Hall not available")
							{
								
								$.confirm({
									title: 'Booking request error!',
									content: 'Requested hall is not available.',
									type: 'red',
									typeAnimated: true,
									columnClass: 'span12',
									buttons: {
										tryAgain: {
											text: 'Try again',
											btnClass: 'btn-red',
											action: function(){
												//alert("Hall is not available.");
												window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
											}
										},
										close: function () {
										}
									}
								});
							}
							else if(hall_booking==1&&no_of_persons>0&&result=="Hall not available")
							{
								
								$.confirm({
									title: 'Booking request error!',
									content: 'Requested hall is not available.Do you want to continue?',
									type: 'red',
									typeAnimated: true,
									columnClass: 'span12',
									buttons: {
										tryAgain: {
											text: 'Continune',
											btnClass: 'btn-red',
											action: function(){
												//alert("Hall is not available.");
												//window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
												//sendOrderConfirmation();
												$('form[name=worldpayForm]').submit();
											}
										},
										close: function () {
										}
									}
								});
							}
							else if(hall_booking==""&&no_of_persons>0&&result=="Seats not available")
							{
								//alert("Requested seats are not available.");
								$.confirm({
									title: 'Booking request error!',
									content: 'Requested seats are not available.',
									type: 'red',
									typeAnimated: true,
									columnClass: 'span12',
									buttons: {
										tryAgain: {
											text: 'Try again',
											btnClass: 'btn-red',
											action: function(){
												//alert("Hall is not available.");
												//$('form[name=bar_booking]').submit();
												window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
											}
										},
										close: function () {
										}
									}
								});
							}
							else if(hall_booking==1&&no_of_persons>0&&result=="Seats not available")
							{
								//alert("Requested seats are not available.");
								$.confirm({
									title: 'Booking request error!',
									content: 'Requested seats are not available.Do you want to continue?',
									type: 'red',
									typeAnimated: true,
									columnClass: 'span12',
									buttons: {
										tryAgain: {
											text: 'Continune',
											btnClass: 'btn-red',
											action: function(){
												//alert("Hall is not available.");
												//window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
												//sendOrderConfirmation();
												$('form[name=worldpayForm]').submit();
											}
										},
										close: function () {
										}
									}
								});
							}
							else if(result=="Not available")
							{
								//alert("Venue is not available.");
								$.confirm({
									title: 'Booking request error!',
									content: 'Venue is not available.',
									type: 'red',
									typeAnimated: true,
									columnClass: 'span12',
									buttons: {
										tryAgain: {
											text: 'Try again',
											btnClass: 'btn-red',
											action: function(){
												//alert("Hall is not available.");
												window.location.href =	"update_bar_order.php?id=<?php echo $orderid?>";
											}
										},
										close: function () {
										}
									}
								});
							}			
							//alert(result);return false;
							
							//$("#availability").append(result);
						},
						error: function(){
							//alert("failure");
						}
				   });
				}	
				
			});
		});
	
<?php }?>
</script>
<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog"   aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="form-horizontal"  method="post">
					<input type="hidden" name="orderId" id="OrderId" value="<?php echo $row['id'] ?>">
					<input type="hidden" name="Amount" id="Amount1" value="<?php echo $row['total_amount'] ?>">
					<input type="hidden" name="barId" id="barId" value="<?php echo $row['bar_id'] ?>">
					<input type="hidden" name="eventId" id="eventId" value="<?php echo $row['event_id'] ?>">
					  <div class="form-group">
						<label  class="col-sm-2 control-label" for="inputEmail3">Coupon Code</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="code" id="code" style="height: 32px;"/>
						</div>
					  </div>
						<br/>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <input type="button" id="checkcode" class="btn btn-info" name="Submit" value="Submit" />
						</div>
					  </div>
                </form>
            </div>
         
        </div>
    </div>
</div>


