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

/* $db->select('tbl_order_history','tbl_events.bar_id,tbl_events.event_price_basic,tbl_events.event_price_vip,tbl_events.event_start,tbl_events.event_end,tbl_events.event_name,tbl_order_history.*,bars_list.entry_fee_basic,bars_list.entry_fee_vip','tbl_events ON tbl_order_history.event_id = tbl_events.id left join bars_list on bars_list.id = tbl_events.bar_id ','tbl_order_history.id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
 */
$db->select('tbl_order_history','tbl_events.bar_id,tbl_events.event_price_basic,tbl_events.event_price_vip,tbl_events.event_start,tbl_events.event_end,tbl_events.event_name,tbl_order_history.*','tbl_events ON tbl_order_history.event_id = tbl_events.id left join bars_list on bars_list.id = tbl_events.bar_id ','tbl_order_history.id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
 
$eventDetails = $db->getResult();
#echo "<pre>";
#print_r($eventDetails);
$event_id = $eventDetails[0]['event_id'];
$type_of_purchase = $eventDetails[0]['type_of_purchase'];
$bar_id = $eventDetails[0]['bar_id'];
$event_name = $eventDetails[0]['event_name'];
$event_basic_fee = $eventDetails[0]['event_price_basic'];
$event_vip_fee = $eventDetails[0]['event_price_vip'];
$date1 = $eventDetails[0]['event_start'];
$date2 = $eventDetails[0]['event_end'];
$totalAmount = $eventDetails[0]['total_amount'];
$no_of_days = $eventDetails[0]['no_of_days'];
$no_of_persons = $eventDetails[0]['no_of_persons'];
$daysBetween = dateDiff ($date1, $date2);
$totalDays = $daysBetween+1;

if(isset($_POST['update_order']))
{
	
			$event_id = $db->escapeString($_POST['event_id']);
			$user_id = $db->escapeString($_SESSION['id']);
			$type_of_purchase = $db->escapeString($_POST['booking_type']);
			$no_of_persons = $db->escapeString($_POST['noofpersons']); 
			$no_of_days = $db->escapeString($_POST['noofdays']); 
			$fees = ($type_of_purchase=="Basic")?$event_basic_fee:$event_vip_fee;
			$amount  = $fees*$no_of_persons;
			$total_amount = $amount*$no_of_days;
			
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
						
						'event_id'=>$event_id,
						'user_id'=>$user_id,
						'type_of_purchase'=>$type_of_purchase,
						'no_of_persons'=>$no_of_persons,
						'no_of_days'=>$no_of_days,
						'total_amount'=>$total_amount,
						'order_for_category'=>'Event'						
					);
				$db->select('tbl_order_history','id',null,'id='.$_GET['id'],'id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
				$is_booked = $db->getResult();
				#echo "<pre>";print_r($is_booked);exit;
				if(!empty($is_booked)&&count($is_booked)>0)
				{
					$db->update('tbl_order_history',$array,'id='.$is_booked[0]['id']); // Table name, column names and values, WHERE conditions	
				}	
					
				
				
				$res = $db->getResult();
				$lastInsertedId = $res[0];
				if($lastInsertedId>0)
				{
					$_SESSION['msg']='<div class="alert alert-success">Order has been updated successfully!!</div>';
					//header("Location: orders.php");
				?>
				<script>window.location.href= 'orderSummary.php?orderid=<?php echo $is_booked[0]['id']?>'; </script>
				<?php	
				}	
				else
				{
					$_SESSION['msg']='<div class="alert alert-danger">There is some issue while updating order. Try after few minutes!!</div>';
				?>	
					<script>window.location.href= 'orderSummary.php?orderid=<?php echo $is_booked[0]['id']?>'; </script>
				<?php	
				}
			}	
			
			
}	


?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
    <div class="row clearfix ">
		<div class="span3"></div>
		<div class="span6">
        	<h2>Event Booking</h2>
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
      			<form action="#" id="order_update" method="post" class="form-horizontal order_history" >
					
					<input type="hidden"  name="event_id" id="event_id" class="form-control" value="<?php echo $event_id;?>">	
					<input type="hidden"  name="bar_id" id="bar_id" class="form-control" value="<?php echo $bar_id;?>">	
					<input type="hidden"  name="event_name" id="event_name" class="form-control" value="<?php echo $event_name;?>">	
					<input type="hidden"  name="event_basic_fee" id="event_basic_fee" class="form-control" value="<?php echo $event_basic_fee; ?>">	
					<input type="hidden"  name="event_vip_fee" id="event_vip_fee" class="form-control" value="<?php echo $event_vip_fee ?>">	
					<input type="hidden"  name="totalDays" id="totalDays" class="form-control" value="<?php echo $totalDays;?>">	
					
					<div class="control-group">
      					<label class="control-label" for="inputEmail">Event Name :</label>
      					<input type="text"  name="event_name" id="event_name" class="form-control" value="<?php echo $event_name;?>" readonly>
      				</div>
      				<br>
					
					<div class="control-group">
      					<label  class="control-label" for="inputName">Booking Type :</label>
						<select name="booking_type" id="booking_type" class="form-control">
								<option value="Basic" <?php if($type_of_purchase=="Basic"){ ?>  selected="selected" <?php }?>>Basic</option>
								<option value="Vip" <?php if($type_of_purchase=="Vip"){ ?>  selected="selected" <?php }?>>Vip</option>
						</select>
					</div>
					<br>
					
					<div class="control-group">
      					<label class="control-label" for="inputEmail">No Of Days:</label>
      					<select name="noofdays" id="noofdays"  class="form-control">
						<?php 
						$i=1;
						while($i<=$totalDays)
						{	
						?>
								<option value="<?php echo $i;?>" <?php if($no_of_days==$i){?> selected="selected" <?php }?>><?php echo $i;?></option>
						
						<?php
						$i++;	
						}
						?>	
						</select>
						
      				</div>
      				<br>
					
					<div class="control-group">
      					<label class="control-label" for="inputEmail">No Of Persons:</label>
      					<input type="text"  name="noofpersons" required id="noofpersons" class="form-control" value="<?php echo $no_of_persons;?>" />
      				</div>
					<span ><?php echo $form->error("noofpersons"); ?></span>
      				<br>
					<div class="control-group">
						<input type="submit" name="update_order" id="btn_submit"  class="btn btn-default btn-color" value="Update order" />
					</div>
					
      			</form>
				</div>    
		</div>		  
	</div>
  </div>
</section>


	
    <?php include'footer.php'; ?>