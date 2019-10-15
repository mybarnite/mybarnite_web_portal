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
?>
<?php include'head.php'; ?>
<title>Mybarnite</title>
<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();


if(isset($_POST['book_event'])&&$_POST['book_event']=="book_event")
{
	if(isset($_POST['event_id'])&&$_POST['event_id']!="")
	{
		 $_SESSION['event_id'] = $_POST['event_id'];
		
		
		
	}	
}	
$event_id =  $_SESSION['event_id'];
//$db->select('tbl_events','*',NULL,'id=21','id DESC');
//$db->select('tbl_events','tbl_events.*,bars_list.entry_fee_basic,bars_list.entry_fee_vip,bars_list.Owner_id','bars_list ON tbl_events.bar_id = bars_list.id','tbl_events.id='.$event_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions

$db->select('tbl_events','tbl_events.*,bars_list.Owner_id','bars_list ON tbl_events.bar_id = bars_list.id','tbl_events.id='.$event_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions


$eventDetails = $db->getResult();
/* echo "<pre>";
print_r($eventDetails); */
$bar_id = $eventDetails[0]['bar_id'];
$event_name = $eventDetails[0]['event_name'];


$event_basic_fee = $eventDetails[0]['event_price_basic'];
$event_vip_fee = $eventDetails[0]['event_price_vip'];

$date1 = $eventDetails[0]['event_start'];
$date2 = $eventDetails[0]['event_end'];

$daysBetween = dateDiff($date1, $date2);
$totalDays = $daysBetween+1;

$Owner_id = $eventDetails[0]['Owner_id'];

if(isset($_POST['purchase']))
{
			$Owner_id = $_POST['Owner_id'];
			#echo "<br/>";
			$event_id = $_POST['event_id'];
			$user_id = $_SESSION['id'];
			
			//$password = isset($_POST['password']) ? $db->escapeString($_POST['password']) : "";
			$event_booking_start_date = $db->escapeString($_POST['event_booking_start_date']);
			$event_booking_end_date = $db->escapeString($_POST['event_booking_end_date']);			
			$type_of_purchase = $db->escapeString($_POST['booking_type']);
			$no_of_persons = $db->escapeString($_POST['noofpersons']); 
			$startD = strtotime( $event_booking_start_date );
			$startDate = date( 'y-m-d', $startD );
			$endD = strtotime( $event_booking_end_date );
			$endDate = date( 'y-m-d', $endD );
			$no_of_days = dateDiff($startDate, $endDate) + 1; 
			$fees = ($type_of_purchase=="Basic")?$event_basic_fee:$event_vip_fee;
			$amount  = $fees*$no_of_persons;
			$total_amount = $amount*$no_of_days;
			
			$payment_status = "Pending";
			$transaction_id = 0;
			$order_created_at = date('Y-m-d H:i:s');
			$event_name=$_POST['event_name'];
			
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
				$array = array(
						
						'Owner_id'=>$Owner_id,
						'event_id'=>$_SESSION['event_id'],
						'user_id'=>$user_id,
						'type_of_purchase'=>$type_of_purchase,
						'no_of_persons'=>$no_of_persons,
						'no_of_days'=>$no_of_days,
						'event_booking_start_date'=>$startDate,
						'event_booking_end_date'=>$endDate,						
						'total_amount'=>$total_amount,
						'payment_status'=>$payment_status,
						'transaction_id'=>$transaction_id,
						'order_created_at'=>$order_created_at,
						'order_for_category'=>'Event',
						'ordername'=>$event_name,
						'free_event'=>$eventDetails[0]['free_event']
					);
				/* $db->select('tbl_order_history','id',null,'event_id='.$event_id.' and user_id = '.$user_id.' and owner_id = '.$Owner_id.' and payment_status!="Done"','id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
				$is_booked = $db->getResult(); */
				#echo $_SESSION['event_id'];exit;
				#echo "<pre>";print_r($is_booked);exit;
				/* if(!empty($is_booked)&&count($is_booked)>0)
				{
					$db->update('tbl_order_history',$array,'id='.$is_booked[0]['id']); // Table name, column names and values, WHERE conditions	
					$res = $db->getResult();
					$orderid=$is_booked[0]['id'];
				}	
				else
				{ */
					$db->insert('tbl_order_history',$array); // Table name, column names and values, WHERE conditions
					$res = $db->getResult();
					$lastInsertedId = $res[0];
					$orderid=$lastInsertedId;
				/* } */	
				
				
				/* $res = $db->getResult();
				$lastInsertedId = $res[0];
			echo "<pre>";print_r($res);exit;
				echo $is_booked[0]['id'];
				exit; */
				if(!empty($orderid))
				{
					$_SESSION['msg']='<div class="alert alert-success">Order has been placed successfully!!</div>';
					//header("Location: orders.php");
				?>
				<script>window.location.href= 'orderSummary.php?orderid=<?php echo $orderid;?>'; </script>
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

<!--==============================Map=================================--> 
<style>
.jconfirm.jconfirm-white .jconfirm-box, .jconfirm.jconfirm-light .jconfirm-box{margin-left: 20% !important;margin-right: 20% !important;}
</style>
	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
	<div class="row clearfix ">
		<div class="span12">
			<center><h2>Event Booking</h2></center>
		</div>
	</div>	
    <div class="row clearfix ">
		<div class="span3"></div>
		<div class="span6">
        	
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
      			<form action="#" id="event_booking" method="post" class="form-horizontal order_history" >
					
					<input type="hidden"  name="event_id" id="event_id" class="form-control" value="<?php echo $event_id;?>">	
					<input type="hidden"  name="bar_id" id="bar_id" class="form-control" value="<?php echo $bar_id;?>">	
					<input type="hidden"  name="event_name" id="event_name" class="form-control" value="<?php echo $event_name;?>">	
					<input type="hidden"  name="event_basic_fee" id="event_basic_fee" class="form-control" value="<?php echo $event_basic_fee; ?>">	
					<input type="hidden"  name="event_vip_fee" id="event_vip_fee" class="form-control" value="<?php echo $event_vip_fee ?>">	
					<input type="hidden"  name="totalDays" id="totalDays" class="form-control" value="<?php echo $totalDays;?>">	
					<input type="hidden"  name="Owner_id" id="Owner_id" class="form-control" value="<?php echo $Owner_id ?>">																			 
                                        <input type="hidden"  name="event_booking_start_date" id="event_booking_start_date" class="form-control" value="<?php echo $event_booking_start_date ?>">
                                        <input type="hidden"  name="event_booking_end_date" id="event_booking_end_date" class="form-control" value="<?php echo $event_booking_end_date ?>">	
					
					<div class="control-group">
      					<label class="control-label" for="inputEmail">Event Name :</label>
      					<input type="text"  name="event_name" id="event_name" class="form-control" value="<?php echo $event_name;?>" readonly>
      				</div>
      				<br>
			
					<div class="control-group">
      					<label  class="control-label" for="inputName">Booking Type :</label>
						<select name="booking_type" id="booking_type" class="form-control">
								<option value="Basic">Basic</option>
								<option value="Vip">Vip</option>
						</select>
					</div>
					<br>
					
					<div class="control-group">
      						<label class="control-label" for="event_booking_start_date">Booking Start Date:<span style="color:#ff0000;">*</span>:</label>
      						<input type="text" required name="event_booking_start_date" id="event_booking_start_date" class="form-control date start" value="" placeholder="mm/dd/yyyy"/>
      					</div>
      					<br>
      					
      					<div class="control-group">
      						<label class="control-label" for="event_booking_end_date">Booking End Date:<span style="color:#ff0000;">*</span>:</label>
      						<input type="text" required name="event_booking_end_date" id="event_booking_end_date" class="form-control date end" value="" placeholder="mm/dd/yyyy"/>
							
      					</div>
						<br>
					
      				<br>
					
					<div class="control-group">
      					<label class="control-label" for="inputEmail">No Of Persons:</label>
      					<input type="text"  name="noofpersons" required id="noofpersons" class="form-control"  >
      				</div>
					<span ><?php echo $form->error("noofpersons"); ?></span>
      				<br>
					<div class="control-group" id="eventBookingBtns">
						<input type="submit" name="purchase" id="btn_submit"  class="btn btn-default btn-color  pull-left" value="Book Tickets" />
						<a href="eventsdetail.php?event_id=<?php echo $event_id;?>" id="btn_back"  class="btn btn-default btn-color pull-right" style="padding:10px 26px;"> Back</a>
					</div>
					
      			</form>
				</div>    
		</div>		  
	</div>
  </div>
</section>


	
    <?php include'footer.php'; ?>
    
  <!-- Date Picker  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
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

		$('#event_booking .time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia'
		});

		$('#event_booking .date').datepicker({
			'format': 'mm/dd/yyyy',
			'autoclose': true,
			'startDate': moment("<?php echo $date1 ?>").format('MM/DD/YYYY'),
			'endDate': moment("<?php echo $date2 ?>").format('MM/DD/YYYY'),
		});

		$('#event_booking').datepair();
			
</script>