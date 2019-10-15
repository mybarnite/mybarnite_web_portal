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
if(isset($_POST['pageNo'])){
	$pageNo = $_POST['pageNo'];
}


$limit  = 15;
$offset = ($pageNo - 1) * $limit;


$sql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p";
$countsql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p";

$sql .= " order by id DESC limit ".$offset.",".$limit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;


$countres = $db->myconn->query($countsql);
$num_rows = $countres->num_rows;
#echo $countSql;


?>
	<input type='hidden' id='totalCount' value='<?php echo $num_rows; ?>'/>
	<input type='hidden' id='Page' value='<?php echo "$pageNo" ?>'/>
<?php
$c=1;	
for($i = 1; $i <= $num_rows1; $i++)
{
	$res1 = $res->fetch_array();
	
	if($res1['name']!="")
	{
		$end_date = strtotime($res1['endsat']);
		$start_date = strtotime($res1['startsat']);
		$current_date = strtotime(date("m/d/Y"));
		if($end_date>$current_date)
		{	
?>	
	<tr>
		
		<td><?php echo $c;?></td>
		<td><?php echo $res1['name'];?></td>
		<td><?php echo $res1['couponcode'];?></td>
		<td><?php echo $res1['discount'];?></td>
		<td><?php echo date('m/d/Y',strtotime($res1['startsat']))." - ".date('m/d/Y',strtotime($res1['endsat'])) ;?></td>
		
	</tr>	
<?php	
		$c++;}
	}
}
?>