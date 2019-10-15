<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

if(isset($_POST['order_id']))
{
	$order_id = $_POST['order_id'];	
}	

$bar_id = $_POST['bar_id'];
$start_date = $_POST['start_date'];
//$end_date = $_POST['end_date'];
$start_time = date("H:i:s", strtotime($_POST['start_time']));
$end_time = date("H:i:s", strtotime($_POST['end_time']));
$hall_booking = $_POST['hall_booking'];
$no_of_persons = $_POST['no_of_persons'];


if($hall_booking==1)
{
	if(isset($_POST['order_id']))
	{
		$db->select('tbl_order_history','count(*) as hall_booked',null,'id!= '.$order_id.' and payment_status = "Done" and bar_id='.$bar_id.' and bar_booking_start_date = "'.Date("Y-m-d",strtotime($start_date)).'" AND ((bar_booking_starts <=  "'.$start_time.'" AND bar_booking_ends >  "'.$start_time.'")OR (bar_booking_starts <  "'.$end_time.'" AND bar_booking_ends >=  "'.$end_time.'")OR (bar_booking_starts >=  "'.$start_time.'" AND bar_booking_starts <  "'.$end_time.'")OR (bar_booking_ends >  "'.$start_time.'" AND bar_booking_ends <=  "'.$end_time.'")) and is_hall_booked = "1"','id DESC');
	
	}
	else
	{
		$db->select('tbl_order_history','count(*) as hall_booked',null,'bar_id='.$bar_id.' and payment_status = "Done" and bar_booking_start_date = "'.Date("Y-m-d",strtotime($start_date)).'" AND ((bar_booking_starts <=  "'.$start_time.'" AND bar_booking_ends >  "'.$start_time.'")OR (bar_booking_starts <  "'.$end_time.'" AND bar_booking_ends >=  "'.$end_time.'")OR (bar_booking_starts >=  "'.$start_time.'" AND bar_booking_starts <  "'.$end_time.'")OR (bar_booking_ends >  "'.$start_time.'" AND bar_booking_ends <=  "'.$end_time.'")) and is_hall_booked = "1"','id DESC');
		
	}	
	$is_hall_booked = $db->getResult();
	$is_hall_available = $is_hall_booked[0]['hall_booked'];
	
}
else
{
	$is_hall_available = 0;
}	

if($no_of_persons!=""&&$no_of_persons>0)
{
	//Get total seats from bars_list
	$db->select('bars_list','seat_for_basic as seats',null,'id='.$bar_id,'id DESC');
	$total_seats = $db->getResult();
	$total_seats = $total_seats[0]['seats'];
	
	//Get total booked seats from order history table
	if(isset($_POST['order_id']))
	{
		$db->select('tbl_order_history','SUM(no_of_persons) as seats',null,'id!= '.$order_id.' and payment_status = "Done" and bar_id='.$bar_id.' and no_of_persons >0 and bar_booking_start_date <= "'.Date("Y-m-d",strtotime($start_date)).'" AND ((bar_booking_starts <=  "'.$start_time.'" AND bar_booking_ends >  "'.$start_time.'")OR (bar_booking_starts <  "'.$end_time.'" AND bar_booking_ends >=  "'.$end_time.'")OR (bar_booking_starts >=  "'.$start_time.'" AND bar_booking_starts <  "'.$end_time.'")OR (bar_booking_ends >  "'.$start_time.'" AND bar_booking_ends <=  "'.$end_time.'"))','id DESC');
	
	}
	else
	{
		$db->select('tbl_order_history','SUM(no_of_persons) as seats',null,'bar_id='.$bar_id.' and payment_status = "Done" and no_of_persons >0 and bar_booking_start_date <= "'.Date("Y-m-d",strtotime($start_date)).'" AND ((bar_booking_starts <=  "'.$start_time.'" AND bar_booking_ends >  "'.$start_time.'")OR (bar_booking_starts <  "'.$end_time.'" AND bar_booking_ends >=  "'.$end_time.'")OR (bar_booking_starts >=  "'.$start_time.'" AND bar_booking_starts <  "'.$end_time.'")OR (bar_booking_ends >  "'.$start_time.'" AND bar_booking_ends <=  "'.$end_time.'"))','id DESC');
	
	}
	
	$reserved_seats = $db->getResult();
	$total_booked_seats = $reserved_seats[0]['seats'];
	$available_seats = $total_seats - $total_booked_seats;
	
	if($no_of_persons<=$available_seats)
	{
		$is_no_of_seats_available = 0;
	}
	elseif($no_of_persons>$total_seats)
	{
		$is_no_of_seats_available = 1;
	}
	elseif($no_of_persons>=$available_seats)
	{
		$is_no_of_seats_available = 0;
	}
	else
	{
		$is_no_of_seats_available = 0;
	}	
	//echo 
}
//echo $is_no_of_seats_available;
//echo "-".$is_hall_available;
if($is_hall_available==1&&$is_no_of_seats_available==1)
{
	//If both not available for booking
	echo "Not available";	
}	
elseif($is_hall_available==0&&$is_no_of_seats_available==1)
{
	//Seats not available
	echo "Seats not available";
}
elseif($is_hall_available==1&&$is_no_of_seats_available==0)
{
	//Hall not available
	echo "Hall not available";
}
elseif($is_hall_available==0&&$is_no_of_seats_available==0)
{
	//Hall and seats available
	echo "Available";
}



?>