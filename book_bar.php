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
include'head.php'; ?>

	<title>Mybarnite - Bar Booking</title>
	<meta name="keywords" content="Nightclubs, Pubs, Bars, Nightclubs near me, Pubs near me, Bars near me">
	<meta name="description" content="View the event details, booking information, promotions and opening hours">

<?php include'header.php'; 
include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

/* if(isset($_POST['order'])&&$_POST['order']=="order")
{
	$_SESSION['barToBeBooked']=$_POST['bar_id'];
 */	if(isset($_SESSION['id'])&&$_SESSION['id']!="")
	{
		$bar_id = $_GET['bar_id'];		
	}
	else
	{
		header("location: usersignin.php");	
	}	
/* } */	

$db->select('bars_list','*',null,'id='.$bar_id,'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$barDetial = $db->getResult();


$bar_name = $barDetial[0]['Business_Name'];
$Owner_id = $barDetial[0]['Owner_id'];
$seat_for_basic = $barDetial[0]['seat_for_basic'];
$hall_fee = $barDetial[0]['hall_fee'];
$cost_per_seat = $barDetial[0]['cost_per_seat']; 

if(!empty($_POST))
{

			$Owner_id = $db->escapeString($_POST['Owner_id']);
			$bar_id = $db->escapeString($_POST['bar_id']);
			$bar_name = $db->escapeString($_POST['bar_name']);
			$user_id = $db->escapeString($_SESSION['id']);
			//$type_of_purchase = $db->escapeString($_POST['booking_type']);
			$booking_purpose = $db->escapeString($_POST['booking_purpose']);
			$no_of_persons = $db->escapeString($_POST['noofpersons']);
			$cost_per_seat = $db->escapeString($_POST['cost_per_seat']);	
			$bar_booking_start_date = date('Y-m-d',strtotime($db->escapeString($_POST['bar_booking_start_date']))); 
			//$bar_booking_end_date = date('Y-m-d',strtotime($db->escapeString($_POST['bar_booking_end_date']))); 
			$bar_booking_starts = $db->escapeString($_POST['bar_booking_starts']); 
			$bar_booking_ends = $db->escapeString($_POST['bar_booking_ends']); 
			//$entry_fee_basic = $db->escapeString($_POST['entry_fee_basic']); 
			//$entry_fee_vip = $db->escapeString($_POST['entry_fee_vip']); 
			$is_hall_booked = ($_POST['hall_booking']!="")?$db->escapeString($_POST['hall_booking']):0; 
			$hall_fee = ($is_hall_booked==1)?$db->escapeString($_POST['hall_fee']):0; 
			
			//$fees = ($type_of_purchase=="Basic")?$entry_fee_basic:$entry_fee_vip;
			//$total_amount = $fees*$no_of_persons;
			
			$total_cost_for_booked_seats = $cost_per_seat*$no_of_persons;
			$total_amount = $hall_fee + $total_cost_for_booked_seats;
			
			$payment_status = "Pending";
			$transaction_id = 0;
			$order_created_at = date('Y-m-d H:i:s');
			$ordername=$_POST['ordername'];
			
			if($is_hall_booked!=1)
			{
				if($no_of_persons=="")
				{
						/* if(!is_numeric($no_of_persons))
						{
						 */	
							$form->setError("noofpersons", "Please enter number of seat to book.");
						/* } */
							
				}
			}	
			
			
			
			if($form->num_errors > 1||$form->num_errors == 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else			
			{
				
				$array = array(
						
						
						'Owner_id'=>$Owner_id,
						'bar_id'=>$bar_id,
						'user_id'=>$user_id,
						'order_for_category'=>"Bar",
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
						'bar_booking_ends'=>date("H:i:s", strtotime($bar_booking_ends)),
						'ordername'=>$ordername
						
					);
					
					
				/* $db->select('tbl_order_history','id',null,'bar_id='.$bar_id.' and user_id = '.$user_id.' and owner_id = '.$Owner_id.' and payment_status!="Done"','id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
				$is_booked = $db->getResult();
				#echo "<pre>";print_r($is_booked);exit;
				if(!empty($is_booked)&&count($is_booked)>0)
				{
					$db->update('tbl_order_history',$array,'id='.$is_booked[0]['id']); // Table name, column names and values, WHERE conditions	
					$res = $db->getResult();
					$lastInsertedId = $is_booked[0]['id'];
				}	
				else
				{ */
					$db->insert('tbl_order_history',$array); // Table name, column names and values, WHERE conditions
					$res = $db->getResult();
					$lastInsertedId = $res[0];
				/* } */	
				//echo "aaa-".$lastInsertedId;exit;
				
				
				if(!empty($lastInsertedId))
				{
					//$_SESSION['msg']='<div class="alert alert-success">Order has been placed successfully!!</div>';
					//header("Location: orders.php");
				?>
				<script>window.location.href= 'orderSummary.php?orderid=<?php echo $lastInsertedId;?>'; </script>
				<?php	
				}	
				else
				{
					$_SESSION['msg']='<div class="alert alert-danger">There is some issue while placing order. Try after few minutes!!</div>';
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
<section id="content" class="main-content">
  <div class="container">
	<br/>
    <div class="row clearfix ">
		<div class="span12 align-center">
				<h1>Bar Booking</h1>
			
		</div>
	</div>
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
					<form name="bar_booking" action="book_bar.php" id="bar_booking" method="post" class="form-horizontal order_history" >
						
						<input type="hidden"  name="bar_id" id="bar_id" class="form-control" value="<?php echo $bar_id;?>">	
						<input type="hidden"  name="ordername" id="ordername" class="form-control" value="<?php echo $bar_name;?>">	
						<input type="hidden"  name="hall_fee" id="hall_fee" class="form-control" value="<?php echo $hall_fee; ?>">	
						<input type="hidden"  name="cost_per_seat" id="cost_per_seat" class="form-control" value="<?php echo $cost_per_seat ?>">	
						<input type="hidden"  name="Owner_id" id="Owner_id" class="form-control" value="<?php echo $Owner_id ?>">	
						
						<div class="control-group">
      						<label  class="control-label" for="inputName">Booking purpose :</label>
							<input type="text" name="booking_purpose" id="booking_purpose" value="" class="form-control">
      					</div>
						<br>
						
						<div class="control-group">
      						<label class="control-label" for="inputName">Bar Name:</label>
      						<input type="text" name="bar_name" value="<?php echo $bar_name; ?>" class="form-control" readonly>
								
      					</div>
						<br>
										
      					<div class="control-group">
      						<label class="control-label" for="inputName">Booking date<span style="color:#ff0000;">*</span>:</label>
      						<input type="text" required name="bar_booking_start_date" id="bar_booking_start_date" class="form-control date start" value="" placeholder="mm/dd/yyyy"/>
							
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
	<label class="control-label" for="inputName">Booking Timing<span style="color:#ff0000;">*</span>:</label>
			<input type="text" required name="bar_booking_starts" id="bar_booking_starts" class="form-control time start" value="" placeholder="From"/>
	<label class="control-label" for="inputName"></label>
			<input type="text" required name="bar_booking_ends" id="bar_booking_ends" class="form-control time endtime" value="" placeholder="To"/>
		
	
	
</div>
						<br>
						
						
						<div class="control-group">
      						<label  class="control-label" for="inputName">Book a full hall <?php echo '	(&#163;'.$barDetial[0]['hall_fee'].')';?> :</label>
							<select required name="hall_booking" id="hall_booking">
								<option value="0">No</option>
								<option value="1">Yes</option>
								
							</select>
      					</div>
						<br>
						
						<div class="control-group" id="hallCapacity" style="display:none;">
							<label class="control-label" for="inputEmail">Hall capacity :</label>
							<input type="text"  name="hall_capacity" id="hall_capacity" value="<?php echo $barDetial[0]['hall_capacity']." People"?>" class="form-control" readonly>
							
						</div>
						
						<div class="control-group" id="availability">
							<label class="control-label" for="inputEmail">No of seats to book <?php echo '	(&#163;'.$barDetial[0]['cost_per_seat'].' /Seat)';?>:</label>
							<input type="text"  name="noofpersons" id="noofpersons" class="form-control">
							
						</div>
						<span ><?php echo $form->error("noofpersons"); ?></span>
						<br>
						<div class="control-group" style="padding:0px 58px 0px 116px">
							<input type="button" name="book_bar" id="btn_submit"  class="btn btn-default btn-color pull-left book-bar-btn" value="Book Bar" />
							<a href="index.php" id="btn_back"  class="btn btn-default btn-color pull-right" style="padding:10px 26px;"> Back</a>
						</div>
						
					</form>
				</div>    
		</div>		  
	</div>
  </div>
</section>

<?php
include('footer.php');
?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
<script>

		$('#bar_booking .time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia'
		});

		$('#bar_booking .date').datepicker({
			'format': 'mm/dd/yyyy',
			'autoclose': true,
			'startDate' : '<?=date('m/d/Y')?>'
		});

		$('#bar_booking').datepair();
		
		$(document).ready(function() {
			$('#hall_booking').on('change', function() {
				if($(this).val()==1)
				{
					$("#hallCapacity").css("display","block");
					$("#availability").css("display","none");
				}				
				else
				{
					$("#hallCapacity").css("display","none");
					$("#availability").css("display","block");
				}	
			});
			
				
			$("#btn_submit").click(function() {
				
				var bar_id = <?php echo $_GET['bar_id'];?>;
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
								$('form[name=bar_booking]').submit();
							}
							else if(hall_booking==1&&no_of_persons==""&&result=="Hall not available")
							{
								
								$.confirm({
									title: 'Booking request update!',
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
												$('form[name=bar_booking]').submit();
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
												$('form[name=bar_booking]').submit();
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
	
	/*$(document).ready(function() {
		
		
		
		 $(".fa-times").remove();
		$(".fa-check").remove();
	
		$("#btn_submit").click(function() {
		
			updateAvailableSeat();
			var noofpersons = $("#noofpersons").val();
			var booking_type = $("#booking_type").val();
			var bar_booking_timing = $("#barstime").val();
			var booking_timing_end = $("#barstimeend").val();
			var booking_date = $("#barsdate").val();
			$.ajax({
				type: "POST",
				url: "https://mybarnite.com/checkAvailabilityForSeat.php",
				data: {bar_id :<?php echo $_GET['bar_id'];?>,noofpersons:noofpersons,booking_type:booking_type,booking_date:booking_date,booking_starts:bar_booking_timing,booking_ends:booking_timing_end},
				success: function(result){
					console.log(result);
					//alert(result);return false;
					if(result=="true")
					{	//alert("1");
						$(".fa-times").remove();
						$(".fa-check").remove();
						$("#availability").append('<i class="fa fa-check pink" style="font-size:20px;"></i>');
						$('form[name=bar_booking]').submit();
						//flag = true;
						//$("form").submit();
					}
					else if(result=="false")
					{
						//e.preventDefault();
						//alert("0");
						$(".fa-check").remove();
						$(".fa-times").remove();
						$("#availability").append('<i class="fa fa-times pink" style="font-size:20px;"></i>');
						
						//flag = false;
					}	
					//$("#availability").append(result);
				},
				error: function(){
					//alert("failure");
				}
		   });
			//alert(flag);
		});			
	}); */
	
	
	
	/* function updateAvailableSeat()
	{	
		$.ajax({
			type: "POST",
			
			url: "https://mybarnite.com/updateAvailableSeat.php",
			data: {bar_id :<?php echo $_GET['bar_id'];?>,hall_booking:$("#hall_booking").val()},
			success: function(result){
				$("#updateAvailableSeat").html(result);		
			},
			error: function(){
				//alert("failure");
			}
	   });
	} */
</script>