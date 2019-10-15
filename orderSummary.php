<?php
session_start();

include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

$connection=DB_CONNECTION();

if(isset($_GET['orderid'])&&$_GET['orderid']!='Y')
{	
	$orderid = $_GET['orderid'];
	$sql = "SELECT o.* ,u.name as uname , u.email ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where payment_status = 'Pending' and o.id =".$orderid;
	$exe = mysql_query($sql)or die(mysql_error()); 
	$rowcount = mysql_num_rows($exe);
	$row=mysql_fetch_assoc($exe);
	
	/* $sql_1 = "SELECT * from tbl_events where id = ".$row['event_id'];
	$exe_1 = mysql_query($sql_1)or die(mysql_error()); 
	$getEventDetail=mysql_fetch_assoc($exe_1);
	 */
	
	if($row['event_id']==0)
	{
		$sql_1 = "SELECT * from bars_list where id = ".$row['bar_id'];
		$exe_1 = mysql_query($sql_1)or die(mysql_error()); 
		$getBarDetail=mysql_fetch_assoc($exe_1);
	
		
	}	
	else
	{
		$sql_1 = "SELECT * from tbl_events where id = ".$row['event_id'];
		$exe_1 = mysql_query($sql_1)or die(mysql_error()); 
		$getEventDetail=mysql_fetch_assoc($exe_1);
		
	}	
	
}

	
?>
<?php include'head.php'; ?>
	<title>Order Summary</title>
	<meta name="description" content="Order Summary">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
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
				
				#echo "<pre>";
				#print_r($row);
				
				
				
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
					<div class="span3">&nbsp;</div>
					<div class="span6 table-responsive">
						<center>
							
							<table class="table ordersummary" id="ordersummary">
								<?php if(!isset($_SESSION['discount'])&&$_SESSION['discount']==0){?>
								<tr id="isValidCode">
									<td colspan="3" >
										<?php 
										if(isset($_SESSION['isValid'])){	
											echo "<div class='alert alert-danger'>You are entering coupon code which might be invalid or expired!</div>";
										unset($_SESSION['isValid']);}?>
									</td>
								</tr>
								
								<?php }unset($_SESSION['isValid']);?>
								<tr>
									<td class="tbl_title">ORDER SUMMARY</td>
									<td></td>
									<?php if($row['event_id']=="0"){?>
									<td><a href="update_bar_order.php?id=<?php echo $row['id']?>"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a></td>
									<?php }?>
									
									<?php if($row['bar_id']=="0"){?>
									<td><a href="update_order.php?id=<?php echo $row['id']?>"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a></td>
									<?php }?>
									
									
								</tr>
								<?php if($row['event_id']=="0"){?>
								<tr>
									<td><strong>Bar Name</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $row['name']; ?></td>
								</tr>
								<tr>
									<td><strong>Booking Date:</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo date('m/d/Y',strtotime($row['bar_booking_start_date'])); ?></td>
								</tr>
								
								<tr>
									<td><strong>Booking Timing:</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo date('g:ia',strtotime($row['bar_booking_starts'])).'-',date('g:ia',strtotime($row['bar_booking_ends'])); ?></td>
								</tr>
								<tr>
									<td><strong>Booking purpose</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo ($row['bar_booking_purpose'])?$row['bar_booking_purpose']:"-"; ?></td>
								</tr>
								<tr>
									<td><strong>Hall</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo ($row['is_hall_booked']==1)?"Yes":"No"; ?></td>
								</tr>
								<?php if($row['is_hall_booked']==1){?>
								<tr>
									<td><strong>Hall capacity</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $getBarDetail['hall_capacity']." People"; ?></td>
								</tr>
								
								<?php }else{?>
								<tr>
									<td><strong>No Of Persons</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $row['no_of_persons']; ?></td>
								</tr>
									
								<?php }?>
								<?php
								}else{
								?>
								<tr>
									<td><strong>Event Name</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $row['name']; ?></td>
								</tr>
								<tr>
									<td><strong>No of Days</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $row['no_of_days']; ?></td>
								</tr>
								<tr>
									<td><strong>No Of Persons</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo $row['no_of_persons']; ?></td>
								</tr>
								<?php }?>
								
								
								
								<?php if($getEventDetail['free_event']!='1'){?>
								<tr>
									<td><strong>Amount (£)</strong></td>
									<td><strong>:</strong></td>
									<td  id="saleamount"><?php echo number_format($row['total_amount'], 2); ?></td>
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
								<?php /* if(!isset($_SESSION['discount'])&&$_SESSION['discount']==0){?>
								<tr>
									
									<td width="10" data-toggle="modal" data-target="#myModalHorizontal" style="color:#3179d8;text-align: right;">Do you have coupon code?</td>
									<td data-toggle="modal" data-target="#myModalHorizontal" class="pink" style="cursor:pointer" >Click here</td>
									
								</tr>
								<?php }?>
								
								
								<?php if(isset($_SESSION['discount'])&&$_SESSION['discount']!=0){?>
								
								<tr>
									<td><strong>Dicount (£)  :</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo number_format($_SESSION['discount'],2); ?></td>
								</tr>
								<tr>
									<td><strong>Total Payable amount (£):</strong></td>
									<td><strong>:</strong></td>
									<td><?php echo number_format($_SESSION['payableamount'],2); ?></td>
								</tr>
								<?php }
								*/
								?>
								<tr></tr>
								<tr></tr>
								<tr></tr>
								<tr></tr>
								<tr></tr>
								
								<?php 
								}
								?>
								
								<tr>
									<td></td>
									<td></td>
									<?php if($row['event_id']=="0"){?>
									<td>
										<input type="submit" class="btn btn-info bg-pink" name="confirmBarOrder" id="confirmBarOrder" value="Confirm order">
									</td>
									<?php }?>
									<?php if($row['bar_id']=="0"){?>
									<td>
										<input type="submit" class="btn btn-info bg-pink" name="confirmEventOrder" id="confirmEventOrder" value="Confirm order">
									</td>
									<?php }?>
								</tr>
							</table> 
						</center>
					</div>
					<div class="span3">&nbsp;</div>
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
<script>
function sendOrderConfirmation()
	{
		$.ajax({
		type: "POST",
		url: "sendOrderConfirmation.php",
		data: {orderId :<?php echo $orderid;?>},
			 success: function(result){
				//alert(result);return false;
				window.location.href =	result; 
			 },
			error: function(){
				//alert("failure");
			}
	   });
	}
<?php if(isset($_GET['orderid'])&&$_GET['orderid']!='Y')
{?>
$(document).ready(function() {
			$("#confirmBarOrder").click(function() {
				
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
							sendOrderConfirmation();
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
											sendOrderConfirmation();
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
											sendOrderConfirmation();
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
			});
		});
	
<?php }?>
</script>
<?php /*
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

*/
?>