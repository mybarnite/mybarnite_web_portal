<?php

include('common.php');

$eventid = $_POST['eventid'];
$action = $_POST['action'];
$barid = $_SESSION['bar_id'];

	
	if($action=="Booked")
	{
		 $db->update('tbl_events',array('is_availableForBooking'=>"Booked"),'id='.$eventid.' AND bar_id='.$barid); // Table name, column names and values, WHERE conditions
	}
	else
	{
		 $db->update('tbl_events',array('is_availableForBooking'=>"Available"),'id='.$eventid.' AND bar_id='.$barid); // Table name, column names and values, WHERE conditions
	}		
	
	$affectedRow = $db->getResult();
	//print_r($res);
	
	$db->select('tbl_events','*',NULL,'bar_id='.$barid.' and id='.$eventid,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	
	if($res[0]['is_availableForBooking']=="Available"){
		echo $content =	"<a data-toggle='collapse' href='#collapse".$res[0]['id']."'>".$res[0]['event_name']."</a><a href='#' class='pull-right' style='color:#3c763d;font-size:12px;margin:0;'>Available For Booking</a>";	
	}
	else{
		echo $content =	"<a data-toggle='collapse' href='#collapse".$res[0]['id']."'>".$res[0]['event_name']."</a><a href='#' class='pull-right' style='color:#ff0000;font-size:12px;margin:0;'>Fully Booked</a>";	
	}	
			

	

		



?>
