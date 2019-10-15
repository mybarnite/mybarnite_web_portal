<?php

include('common.php');

	$eventid = $_POST['eventid'];
	$barid = $_SESSION['bar_id'];
	$db->select('tbl_events','*',NULL,'bar_id='.$barid.' and id='.$eventid,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	if($res[0]['is_availableForBooking']=="Available"){
		$available = "readonly";
		
	}
	if($res[0]['is_availableForBooking']=="Booked"){
		$booked = "readonly";
		
	}	
	$content = 	"
					<input type='hidden' name='event_id' value='".$res[0]['id']."' id='event_id' />
					<input style='border: none;' class='btn btn-info bg-pink' type='submit' value='Edit' name='UpdateItem' />
					<input style='border: none;' class='btn btn-info bg-pink' type='button' value='Delete' onclick='manageEvents(".$res[0]['id'].")' name='DeleteItem' />
					<input style='border: none;' class='btn btn-danger pull-right' type='button' value='Fully Booked' onclick=isAvailableForBooking(".$res[0]['id'].",'Booked') name='booked' ".@$booked." />
					<input style='border: none;' class='btn btn-success pull-right' type='button' value='Booking Available' onclick=isAvailableForBooking(".$res[0]['id'].",'Available') name='availforbook' ".@$available." />
				";
				
	echo $content;		
		//echo $content = 	($res[0]['is_availableForBooking']=="Available")?"Available For Booking":"Fully Booked";				

?>
