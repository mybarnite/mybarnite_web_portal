<?php
if(!isset($_SESSION))
{
	session_start();
}

$full_name = $_SERVER['PHP_SELF'];
$name_array = explode('/',$full_name);
$count = count($name_array);
$page_name = $name_array[$count-1];	

$currentDate = date('Y-m-d H:s');
$currentDateTimestamp = strtotime($currentDate);
?>
<?php	

	$myMbSiteUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$mbSitequeryString = $_SERVER['QUERY_STRING'];
	if(isset($_GET['event_id']))
	{	
		$detailid = $_GET['event_id'];
		//$sql2 = "SELECT g.file_name,g.file_path,g.event_id,g.logo_image,e.*, p.*,b.Business_name, b.Location_Searched, b.Zipcode, b.entry_fee_basic, b.entry_fee_vip FROM tbl_events as e left join bars_list as b on e.bar_id=b.id left join tbl_event_gallery as g on e.id=g.event_id and g.logo_image='1' left join tbl_promotions as p on p.eventId=e.id and p.status='Active'  WHERE e.id=".$detailid;
		$sql2 = "SELECT g.file_name,g.file_path,g.event_id,g.logo_image,e.*, p.*,b.Business_name, b.Location_Searched, b.Zipcode FROM tbl_events as e left join bars_list as b on e.bar_id=b.id left join tbl_event_gallery as g on e.id=g.event_id and g.logo_image='1' left join tbl_promotions as p on p.eventId=e.id and p.status='Active'  WHERE e.id=".$detailid;
		
		$exe1 = mysql_query($sql2) or die(mysql_error());
		$get_event = mysql_fetch_assoc($exe1);
		$site_name =$get_event['event_name'];
		$title =$get_event['event_name'];
		$description =$get_event['event_description'];
		$image =$get_event['file_path'];
	}
	else if($_GET['barid'])	
	{
		//$sql1 = "select b.id,b.PhoneNo,b.Rating,b.Latitude,b.Longitude,b.Zipcode,b.Address,b.entry_fee_basic,b.entry_fee_vip,b.description,b.Business_Name,b.Hours,b.Category_Searched,b.Location_Searched,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where b.id = ".$barid;
		$sql1 = "select b.id,b.PhoneNo,b.Rating,b.Latitude,b.Longitude,b.Zipcode,b.Address,b.description,b.Business_Name,b.Hours,b.Category_Searched,b.Location_Searched,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where b.id = ".$barid;
		
		$barquery = mysql_query($sql1);
		$bar = mysql_fetch_assoc($barquery);
		$site_name =$bar['Business_Name'];
		$title =$bar['Business_Name'];
		$description =$bar['description'];
		$image =$bar['file_path'];
	}
	if(isset($_SESSION['FBID'])){
		$qstr = "select * from user_register where facebook_id='".$_SESSION['FBID']."'";
		$execute_qstr = mysql_query($qstr)or die(mysql_error());
		$count_row = mysql_num_rows($execute_qstr);
		if($count_row<=0){
			$name = (isset($_SESSION['FULLNAME'])&&$_SESSION['FULLNAME']!="")?mysql_real_escape_string(htmlentities(addslashes(trim($_SESSION['FULLNAME'])))):"";
			$email = (isset($_SESSION['EMAIL'])&&$_SESSION['EMAIL']!="")?mysql_real_escape_string(htmlentities(addslashes(trim($_SESSION['EMAIL'])))):"";
			$facebook_id = (isset($_SESSION['FBID'])&&$_SESSION['FBID']!="")?mysql_real_escape_string(htmlentities(addslashes(trim($_SESSION['FBID'])))):"";
			$str = "INSERT INTO user_register (id,r_id,name,email,facebook_id) VALUES('',2,'".$name."','".$email."','".$facebook_id."')  ";
			$query = mysql_query($str)or die(mysql_error());
			$lastInsertedId = mysql_insert_id();
			$_SESSION['id'] = $lastInsertedId;
			$_SESSION['username'] = $name;
			$_SESSION['useremail'] = $email;
			$_SESSION['FULLNAME']=$name;
		}else{
			$query = mysql_query(" SELECT * FROM user_register WHERE facebook_id='".$_SESSION['FBID']."' AND r_id=2 ");
			$result = mysql_num_rows($query);
			$row = mysql_fetch_array($query);
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $row['name'];
			$_SESSION['useremail'] = $row['email'];
			$_SESSION['FULLNAME']=$row['name'];
						
		}
	}	
?><!DOCTYPE html>
<html lang="en">
<head>
