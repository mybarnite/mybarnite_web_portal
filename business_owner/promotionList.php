<?php
include 'common.php';
if(isset($_POST['pageNo'])){
	$pageNo = $_POST['pageNo'];
}


$limit  = 15;
$offset = ($pageNo - 1) * $limit;


$sql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p where barId =".$_SESSION['bar_id'] ;
$countsql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p where barId =".$_SESSION['bar_id'];

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
for($i = 1; $i <= $num_rows1; $i++)
{
	$res1 = $res->fetch_array();
	
?>	
	<tr>
		
		<td><input type="checkbox" name="chk[]" value="<?php echo $res1['id']; ?>" /></td>
		<td><?php echo $res1['name'];?></td>
		<td><?php echo $res1['discount'];?></td>
		<td><?php echo @date('m/d/Y',@strtotime($res1['startsat']))." - ".@date('m/d/Y',@strtotime($res1['endsat'])) ;?></td>
		<td><?php echo $res1['status'];?></td>
		<td colspan="2">
			
			<?php if($res1['eventId']!="0"){?>
			<a href="business_owner_editpromotion.php?eid=<?php echo $res1['id'] ?>" class="pink pull-left"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a> 
			<?php }else{?>
			<a href="business_owner_editpromotion.php?bid=<?php echo $res1['id'] ?>" class="pink pull-left"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a> 
			<?php }?>
			<a href="javascript:void(0);" onclick="deletePromotion(<?php echo $res1['id'] ?>);" class="pink"><i class="fa fa-trash  fa-2x" aria-hidden="true"></i></a> 
		</td>
		
	</tr>	
<?php	

}
?>