<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();


if(isset($_GET['id'])&&$_GET['id']!="")
{
		$id = $_GET['id'];
	
}	

$db->select('tbl_order_history','tbl_order_history.*,bars_list.Business_Name,bars_list.id as barId,bars_list.Owner_id','bars_list on tbl_order_history.bar_id=bars_list.id','tbl_order_history.id='.$id,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$barDetial = $db->getResult();

$bar_id = $barDetial[0]['barId'];
$bar_name = $barDetial[0]['Business_Name'];
$is_hall_booked = $barDetial[0]['is_hall_booked'];
$hall_fee = $barDetial[0]['hall_fee'];
$bar_booking_start_date = $barDetial[0]['bar_booking_start_date'];
$bar_booking_starts = $barDetial[0]['bar_booking_starts'];
$bar_booking_ends = $barDetial[0]['bar_booking_ends'];
$noofpersons = $barDetial[0]['no_of_persons'];
$Owner_id = $barDetial[0]['Owner_id'];
$bar_booking_purpose = $barDetial[0]['bar_booking_purpose'];

$db->select('bars_list','id,Owner_id,Business_Name,is_hall_available,hall_fee,cost_per_seat,seat_for_basic',null,'id='.$bar_id,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$barDetial1 = $db->getResult();


$bar_name = $barDetial1[0]['Business_Name'];
$Owner_id = $barDetial1[0]['Owner_id'];
$seat_for_basic = $barDetial1[0]['seat_for_basic'];
$hall_fee = $barDetial1[0]['hall_fee'];
$cost_per_seat = $barDetial1[0]['cost_per_seat']; 

if(!empty($_POST))
{   
			$Owner_id = $db->escapeString($_POST['Owner_id']);
			echo $order_id = $db->escapeString($_POST['order_id']);
			$bar_id = $db->escapeString($_POST['bar_id']);
			/* $bar_name = $db->escapeString($_POST['bar_name']);
			$user_id = $db->escapeString($_SESSION['id']);
			$type_of_purchase = $db->escapeString($_POST['booking_type']);
			$no_of_persons = $db->escapeString($_POST['noofpersons']); 
			$bar_booking_date = date('Y-m-d',strtotime($db->escapeString($_POST['bookingdate']))); 
			$bar_booking_timing = $db->escapeString($_POST['barstime']); 
			$entry_fee_basic = $db->escapeString($_POST['entry_fee_basic']); 
			$entry_fee_vip = $db->escapeString($_POST['entry_fee_vip']); 
					
			$fees = ($type_of_purchase=="Basic")?$entry_fee_basic:$entry_fee_vip;
			$total_amount = $fees*$no_of_persons;
			 */
			 
			$bar_name = $db->escapeString($_POST['bar_name']);
			$user_id = $db->escapeString($_SESSION['id']);
			$booking_purpose = $db->escapeString($_POST['booking_purpose']);
			echo $no_of_persons = $db->escapeString($_POST['noofpersons']);
			$cost_per_seat = $db->escapeString($_POST['cost_per_seat']);	
			$bar_booking_start_date = date('Y-m-d',strtotime($db->escapeString($_POST['bar_booking_start_date']))); 
			$bar_booking_starts = $db->escapeString($_POST['bar_booking_starts']); 
			$bar_booking_ends = $db->escapeString($_POST['bar_booking_ends']); 
			$is_hall_booked = ($_POST['hall_booking']!="")?$db->escapeString($_POST['hall_booking']):0; 
			$hall_fee = ($is_hall_booked==1)?$db->escapeString($_POST['hall_fee']):0; 
			
			$total_cost_for_booked_seats = $cost_per_seat*$no_of_persons;
			$total_amount = $hall_fee + $total_cost_for_booked_seats; 
			 
			$payment_status = "Pending";
			$transaction_id = 0;
			$order_created_at = date('Y-m-d H:i:s');
			
			
			if($no_of_persons!="")
			{
					if(!is_numeric($no_of_persons))
					{
						
						$form->setError("noofpersons", "Please enter valid total no of persons.");
				    }
						
			}
			
			
			if($form->num_errors > 1||$form->num_errors == 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else			
			{
				
				/* $array = array(
						
						'bar_id'=>$bar_id,
						'user_id'=>$user_id,
						'type_of_purchase'=>$type_of_purchase,
						'no_of_persons'=>$no_of_persons,
						'total_amount'=>$total_amount,
						'payment_status'=>$payment_status,
						'transaction_id'=>$transaction_id,
						'order_created_at'=>$order_created_at,
						'bar_booking_date'=>$bar_booking_date,
						'bar_booking_timing'=>date("H:i:s", strtotime($bar_booking_timing)),
						
					); */
					
				$array = array(
					'bar_id'=>$bar_id,
					'user_id'=>$user_id,
					'no_of_persons'=>$no_of_persons,
					'total_amount'=>$total_amount,
					'payment_status'=>$payment_status,
					'transaction_id'=>$transaction_id,
					'order_created_at'=>$order_created_at,
					'bar_booking_purpose'=>$booking_purpose,
					'is_hall_booked'=>$is_hall_booked,
					'bar_hall_fee'=>$hall_fee,
					'bar_booking_start_date'=>$bar_booking_start_date,
					//'bar_booking_end_date'=>$bar_booking_start_date,
					'bar_booking_starts'=>date("H:i:s", strtotime($bar_booking_starts)),
					'bar_booking_ends'=>date("H:i:s", strtotime($bar_booking_ends))
				);
					
				$db->select('tbl_order_history','id',null,'id='.$order_id,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
				$is_booked = $db->getResult();
				#echo "<pre>";print_r($is_booked);exit;
				if(!empty($is_booked)&&count($is_booked)>0)
				{
					$db->update('tbl_order_history',$array,'id='.$is_booked[0]['id']); // Table name, column names and values, WHERE conditions	
				}	
					
				
				
				$res = $db->getResult();
				$lastInsertedId = $is_booked[0]['id'];
				if(!empty($lastInsertedId))
				{
					//$_SESSION['msg']='<div class="alert alert-success">Order has been updated successfully!!</div>';
					//header("Location: orders.php");
				?>
				<script>window.location.href= 'checkoutdetail.php?orderid=<?php echo $order_id;?>'; </script>
				<?php	
				}	
				else
				{
					$_SESSION['msg']='<div class="alert alert-danger">There is some issue while updating order. Try after few minutes!!</div>';
				?>	
					<script>window.location.href= 'orders.php'; </script>
				<?php	
				}
			}	
			
			
}	


?>

<style>
.jconfirm.jconfirm-white .jconfirm-box, .jconfirm.jconfirm-light .jconfirm-box{margin-left: 20% !important;margin-right: 20% !important;}
</style>
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
	<div class="row"><div class="span12"><center><h2>Bar Booking</h2></center></div></div>
	<div class="row">
		<div class="span4"></div>
		<div class="span4 align-center" id="errMsg"></div>	
		<div class="span4"></div>
	</div>
    <div class="row clearfix ">
		<div class="span3"></div>
		<div class="span6">
        	
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
					<form action="update_bar_order.php" id="update_bar_order" name="update_bar_order" method="post" class="form-horizontal order_history" >
						<input type="hidden"  name="order_id" id="order_id" class="form-control" value="<?php echo $_GET['id'];?>">	
						<input type="hidden"  name="bar_id" id="bar_id" class="form-control" value="<?php echo $bar_id;?>">	
						<input type="hidden"  name="ordername" id="ordername" class="form-control" value="<?php echo $bar_name;?>">	
						<input type="hidden"  name="hall_fee" id="hall_fee" class="form-control" value="<?php echo $hall_fee; ?>">	
						<input type="hidden"  name="cost_per_seat" id="cost_per_seat" class="form-control" value="<?php echo $cost_per_seat ?>">	
						<input type="hidden"  name="Owner_id" id="Owner_id" class="form-control" value="<?php echo $Owner_id ?>">	
						
						<div class="control-group">
      						<label  class="control-label" for="inputName">Booking purpose :</label>
							<input type="text" name="booking_purpose" id="booking_purpose" value="<?php echo $bar_booking_purpose;?>" class="form-control">
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputName">Bar Name:</label>
      						<input type="text" name="bar_name" value="<?php echo $bar_name; ?>" class="form-control" readonly>
								
      					</div>
						<br>
										
      					<div class="control-group">
      						<label class="control-label" for="inputName">Booking date:</label>
      						<input type="text" required name="bar_booking_start_date" id="bar_booking_start_date" class="form-control date start" value="<?php echo date("m/d/Y",strtotime($bar_booking_start_date)); ?>" placeholder="mm/dd/yyyy" autocomplete="off"/>
							
      					</div>
						<br>
						
						<!--
						<div class="control-group">
      						<label class="control-label" for="inputName">Ends at:</label>
      						<input type="text" required name="bar_booking_end_date" id="bar_booking_end_date" class="form-control date end" value="" placeholder="mm/dd/yyyy"/>
      					</div>
						<br>
						-->
					
      					<div class="control-group">
							<label class="control-label" for="inputName">Booking Timing:</label>
      						<input type="text" required name="bar_booking_starts" id="bar_booking_starts" class="form-control time start" value="<?php echo date("g:ia",strtotime($bar_booking_starts)); ?>" placeholder="From">
      						<label class="control-label" for="inputName"></label>
							<input type="text" required name="bar_booking_ends" id="bar_booking_ends" class="form-control time endtime" value="<?php echo date("g:ia",strtotime($bar_booking_ends)); ?>" placeholder="To">
      					</div>
						<br>
						
						<?php if($barDetial1[0]['is_hall_available']==1){?>
						<div class="control-group">
      						<label  class="control-label" for="inputName">Book a full hall <?php echo '	(&#163;'.$barDetial1[0]['hall_fee'].')';?> :</label>
							<select required name="hall_booking" id="hall_booking">
								<option value="0" <?php if($is_hall_booked==0){?> selected="selected" <?php }?> >No</option>
								<option value="1" <?php if($is_hall_booked==1){?> selected="selected" <?php }?> >Yes</option>
								
							</select>
      					</div>
						<br>
						<?php }?>
						<div class="control-group" id="availability">
							<label class="control-label" for="inputEmail">No of seats to book <?php echo '	(&#163;'.$barDetial1[0]['cost_per_seat'].' /Seat)';?>:</label>
							<input type="text"  name="noofpersons" id="noofpersons" class="form-control" value="<?php echo $noofpersons;?>">
							
						</div>
						<span ><?php echo $form->error("noofpersons"); ?></span>
						<br>
						<div class="control-group">
							<input type="button" name="update_order" id="btn_submit"  class="btn btn-default btn-color" value="Update" />
						</div>
						
					</form>
				</div>   
		</div>		  
	</div>
  </div>
</section>
<?php include'footer.php'; ?>
<!-- Date Picker  -->
	<script type="text/javascript" src="https://mybarnite.com/datepicker/jquery.timepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="https://mybarnite.com/datepicker/jquery.timepicker.css" />

	<script type="text/javascript" src="https://mybarnite.com/datepicker/lib/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="https://mybarnite.com/datepicker/lib/bootstrap-datepicker.css" />
	
	<script src="https://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
	<script src="https://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>	
<!-- Date Picker  -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script><script>

		$('#update_bar_order .time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia'
		});

		$('#update_bar_order .date').datepicker({
			'format': 'mm/dd/yyyy',
			'autoclose': true,
			'startDate':'<?=date("m/d/Y")?>'
		});

		$('#update_bar_order').datepair();
		
		$(document).ready(function() {
			$("#btn_submit").click(function() {
				
				var bar_id = <?php echo $barDetial[0]['barId'];?>;
				var start_date = $("#bar_booking_start_date").val();
				//var end_date = $("#bar_booking_end_date").val();
				var start_time = $("#bar_booking_starts").val();
				var end_time = $("#bar_booking_ends").val();
				var hall_booking = $("#hall_booking").val();
				var no_of_persons = $("#noofpersons").val();
				if(start_date!=""&&start_time!=""&&end_time!="")
				{
					if(hall_booking!=1)
					{
						if(no_of_persons=="")
						{
							$("#errMsg").html('<div class="alert alert-danger">Please enter number of seat to book.</div>');
							return false;
						}
					}
					$.ajax({
						type: "POST",
						url: "https://mybarnite.com/checkAvailabilityForSeat.php",
						data: {bar_id:bar_id,start_date:start_date,start_time:start_time,end_time:end_time,hall_booking:hall_booking,no_of_persons:no_of_persons},
						success: function(result){
							if(result=="Available")
							{
								$('form[name=update_bar_order]').submit();
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
												$('form[name=update_bar_order]').submit();
											}
										},
										close: function () {
										}
									}
								});
							}
							else if(hall_booking!=1&&no_of_persons>0&&result=="Seats not available")
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
												$('form[name=update_bar_order]').submit();
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
				else
				{
					$("#errMsg").html('<div class="alert alert-danger">Please fill in all the required fields.</div>');
				}		
				
			});
		});

</script>
