<?php 
ob_start();
$myRoot = $_SERVER["DOCUMENT_ROOT"];
include($myRoot.'/business_owner/template-parts/header.php'); 


?>

<?php
if(isset($_POST['event_id']))
{
	$_SESSION['eventId'] = $_POST['event_id'];	
}
else
{
	$_SESSION['eventId'] = $_SESSION['eventId'];
}	

$db->select('tbl_events','*',NULL,'id="'.$_SESSION['eventId'].'"','id DESC');
$items = $db->getResult();


if(isset($_POST['Update']))
{
	
	$eventName = $db->escapeString($_POST['event_name']);
	$eventDescription = $db->escapeString($_POST['event_description']);
	$eventStart = @date('Y-m-d',@strtotime($db->escapeString($_POST['event_startdate'])));
	$eventEnd = @date('Y-m-d',@strtotime($db->escapeString($_POST['event_enddate'])));
	//$event_starttimestamp = strtotime($eventStart);
	//$event_endtimestamp = strtotime($eventEnd);
	$start_time = $db->escapeString($_POST['start_time']);
	$end_time = $db->escapeString($_POST['end_time']);
	$start = @strtotime($eventStart." ".$start_time);
	$end = @strtotime($eventEnd." ".$end_time);
	$event_price_vip =$db->escapeString($_POST['event_price_vip']);
	$event_price_basic =$db->escapeString($_POST['event_price_basic']);
	$cancellation_policy = $db->escapeString($_POST['cancellation_policy']); 
	$free_event = $db->escapeString($_POST['free_event']); 
	$eventtype = $db->escapeString($_POST['eventtype']); 
	
	$array = array(
					'event_name'=>$eventName,
					'event_description'=>$eventDescription,
					'event_start'=>$eventStart,
					'event_end'=>$eventEnd,
					'event_price_vip'=>$event_price_vip,
					'event_price_basic'=>$event_price_basic,
					'cancellation_policy'=>$cancellation_policy,
					'start_time'=>$start_time,
					'end_time'=>$end_time,
					'event_starttimestamp'=>$start,
					'event_endtimestamp'=>$end,
					'eventtype' => $eventtype ,
					'free_event' => $free_event 
					
				);
			
			$db->update('tbl_events',$array,'id='.$_SESSION['eventId']);
			$is_res = $db->myconn->affected_rows;	
			if($is_res!=""&&$is_res>0)
			{
				$_SESSION['msg']="<div class='alert alert-success'>Data has been updated successfully</div>";
			}	
			global $flag;
			$valid_formats = array("jpg", "png", "gif");
			$path = "uploaded_files/"; // Upload directory
			$count = 0;
			
			// Loop $_FILES to exeicute all files
			$total = count($_FILES['files']['name']);
			// Loop through each file
			for($i=0; $i<$total; $i++) {
				$new_filename = time()."-".$_FILES['files']['name'][$i];		   
				if ($_FILES['files']['error'][$i] == 0) {	           
					if( ! in_array(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION), $valid_formats) ){
						$_SESSION['msg']="<div class='alert alert-danger'>Data has been updated successfully but image can not be uploaded with invalid format. </div>";
						$flag=1;
						 // Skip invalid file formats
					}
					else
					{ // No error found! Move uploaded files 
						if($flag!=1)
						{
							$new_filename = time()."-".$_FILES['files']['name'][$i];
							if(move_uploaded_file($_FILES["files"]["tmp_name"][$i], $path.$new_filename))
							$count++; // Number of successfully uploaded file
							//$db->insert('tbl_event_gallery',array('bar_id'=>$_SESSION['bar_id'],'event_id'=>$lastInsertedId,'file_name'=>$eventDescription,'file_path'=>$eventStart,'status'=>$eventEnd,'logo_image'=>$start_time));  // Table name, column names and respective values
							
							$db->insert('tbl_event_gallery',array('bar_id'=>$_SESSION['bar_id'],'event_id'=>$_SESSION['eventId'],'file_name'=>$new_filename,'file_path'=>$path.$new_filename,'status'=>1,'logo_image'=>0));  // Table name, column names and respective values
							$res1 = $db->getResult();  
							if($res1!="")
							{
								$flag = 0;
								$_SESSION['msg']="<div class='alert alert-success'>Data has been uploaded successfully, Your uploads will get published after admin approval.</div>";
								
							}	
							else
							{
								
								$_SESSION['msg']="<div class='alert alert-danger'>Invalid file format.</div>";
								
							}
							
						}	
						
						
					}
				}
			}	
			?>
			<script>
			
				window.location.href = "business_owner_events.php";
			

			</script>
			<?php	
				
	
}



?>

<!--==============================Content=================================--> 

<section id="content" >
	<div class="container divider" id="events_container">
	
		<div class="row">
			<div class="clearfix ">
				<div class="span4"></div>
				<div class="span3">
					<h2>Edit Event</h2>
					
				</div>
				<div class="span5 pink" style="font-size: 16px;"><input type="checkbox" <?php if(@$items[0]['free_event']=='1'){?>  checked="checked"  <?php }?> class="form-control chkbox" id="freeEventOption" name="freeEventOption" style="vertical-align:top" onclick="freeEventOption();"> Free Entry</div>
			</div>
		</div> 
		<div class="row">
			<div class="clearfix ">
				<div class="span3"></div>
				<div class="span6">
					<div class="event-form">
						<form class="form-inline" role="form" id="bar_events" method="post" enctype="multipart/form-data">
							<input type="hidden" class="form-control" id="free_event" name="free_event" value="<?php echo @$items[0]['free_event'];?>">
							<?php
							
							if(isset($_SESSION['msg']))
							{
							?>	
							<div class="control-group">
								<?php echo $_SESSION['msg'];?>
							</div>	
							<?php	
							
										
							}
							
							?>
							<div class="form-group">
								<label for="event_name" class="pull-left">Event name :</label>
								<input type="text" class="form-control" id="event_name" name="event_name" required value="<?php echo @$items[0]['event_name'];?>" placeholder="Event Name...">
							</div>
							<div class="form-group">
								<label for="event_description" class="pull-left">Description :</label>
								<textarea class="form-group" id="event_description" name="event_description" placeholder="Event Description..."><?php echo @$items[0]['event_description'];?></textarea>
							</div>
							
							<div class="form-group">
								<label for="event_startdate" class="pull-left date start">Event starts	:</label>
								<input type="text" class="date start form-control pull-left" id="event_startdate" required name="event_startdate" placeholder="mm/dd/yyyy" value="<?php echo @date('m/d/Y',@strtotime(@$items[0]['event_start']));?>"/>
								<input type="text" class="time start" id="timepicker1" name="start_time" placeholder="Starting time..." value="<?php echo @$items[0]['start_time'];?>"/>
							</div>
							<div class="form-group">
								<label for="event_startdate" class="pull-left">Event ends	:</label>
								<input type="text" class="date end form-control  pull-left" id="event_enddate" required  name="event_enddate" placeholder="mm/dd/yyyy" value="<?php echo @date('m/d/Y',@strtotime(@$items[0]['event_end']));?>"/>
								<input type="text" class="time end" id="timepicker2" name="end_time" placeholder="Ending time..." value="<?php echo @$items[0]['end_time'];?>"/>
							</div>
							
							<div class="form-group"  id="vip" >
								<label for="event_name" class="pull-left">Price - VIP (&pound;):</label>
								<input type="number" class="form-control" id="event_price_vip" name="event_price_vip"  placeholder="Event Price..." value="<?php echo @$items[0]['event_price_vip'];?>">
							</div>
							<div class="form-group"  id="basic">
								<label for="event_name" class="pull-left">Price - Basic (&pound;):</label>
								<input type="number" class="form-control" id="event_price_basic" name="event_price_basic"  placeholder="Event Price..." value="<?php echo @$items[0]['event_price_basic'];?>">
							</div>
							
							<div class="form-group">
								<label for="event_name" class="pull-left">Cancellation:</label>
								<select class="form-control" id="cancellation_policy" name="cancellation_policy">
									<option value="1" <?php if(@$items[0]['cancellation_policy']=='1'){?> selected="selected" <?php }?> >Free cancellation</option>
									<option value="2" <?php if(@$items[0]['cancellation_policy']=='2'){?> selected="selected" <?php }?>>Cancellation Policy</option>
								</select>
							</div>
							<div class="form-group">
								<label for="eventtype" class="pull-left">Event Type:</label>
								
								<select name="eventtype" id="eventtype" class="form-control">
									<option value="latest" <?php if(trim($items[0]['eventtype']) == "latest"){?> selected="selected" <?php }?> >Latest Event</option>
									<option value="upcoming" <?php if(trim($items[0]['eventtype']) == "upcoming"){?> selected="selected" <?php }?> >Upcoming Event</option>
									<option value="special" <?php if(trim($items[0]['eventtype']) == "special"){?> selected="selected" <?php }?> >Special Event</option>
								</select>
							</div>
							<div class="form-group">
								<label for="event_name" class="pull-left">Upload image :</label>
								<input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
							</div>
							<div class="form-group">
								<button type="submit" id="UpdateEvent"  name="Update" value="Update Event" class="btn btn-info submitEvent bg-pink">Save changes</button>
								<a href="business_owner_events.php" id="Eventlist"  name="Eventlist" class="btn btn-info submitEvent bg-pink">Back to events</a>
							</div>
							
						</form>
						
					</div>
				</div>
				<div class="span5"></div>
			</div>
		</div>	
		
		
	</div>
</section>

<script>
	$('#bar_events .time').timepicker({
		'showDuration': true,
		'timeFormat': 'g:ia'
	});

	$('#bar_events .date').datepicker({
		'format': 'mm/dd/yyyy',
		'autoclose': true
	});

	$('#bar_events').datepair();
	/* $('#freeEventOption').click(function() {
        if(!$(this).is(':checked'))
		{	
           // alert('unchecked');
			$("#vip").css("display","block");
			$("#basic").css("display","block");
			$("#free_event").val("0");
		}	
        else
		{	
            //alert('checked');
			$("#vip").css("display","none");
			$("#basic").css("display","none");
			$("#free_event").val("1");
		}	
    }); */

	function freeEventOption()
	{
		if(!$("#freeEventOption").is(':checked'))
		{	
           // alert('unchecked');
			$("#vip").css("display","block");
			$("#basic").css("display","block");
			$("#free_event").val("0");
		}	
        else
		{	
            //alert('checked');
			$("#vip").css("display","none");
			$("#basic").css("display","none");
			$("#free_event").val("1");
		}	
	}
	freeEventOption();
</script>
<?php include'template-parts/footer.php'; ?>