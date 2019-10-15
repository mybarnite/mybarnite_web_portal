<?php
include 'common.php';
if(isset($_POST['pageNo'])){
	$pageNo = $_POST['pageNo'];
}


$limit  = 15;
$offset = ($pageNo - 1) * $limit;

$barId = trim($_POST['barId']);
$name = trim($_POST['name']);
$email = trim($_POST['email']);

$sql = "SELECT a . * , GROUP_CONCAT( b.page_name ) AS permissions FROM user_register AS a LEFT JOIN tbl_staffPermission AS b ON FIND_IN_SET( b.subuser_id, a.id ) WHERE a.r_id =3 and a.bar_id = ".$barId;
$countsql = "SELECT a.*, GROUP_CONCAT( b.page_name ) as permissions FROM user_register AS a left JOIN  tbl_staffPermission AS b ON b.subuser_id= a.id where a.r_id = 3 and a.bar_id = ".$barId." GROUP BY id";

if(isset($_POST['name'])&&$_POST['name']!="")
{
	@$sql .= " AND a.name like '%".$_POST['name']."%'";
	@$countSql .= "	AND a.name like '%".$_POST['name']."%'";
}
if(isset($_POST['email'])&&$_POST['email']!="")
{
	@$sql .= " AND a.email like '%".$_POST['email']."%'";
	@$countSql .= "	AND a.email like '%".$_POST['email']."%'";
}


$sql .= " GROUP BY a.id limit ".$offset.",".$limit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;


$countres = $db->myconn->query($countsql);
$num_rows = $countres->num_rows;



?>
	<input type='hidden' id='totalCount' value='<?php echo $num_rows; ?>'/>
	<input type='hidden' id='Page' value='<?php echo "$pageNo" ?>'/>
<?php	
for($i = 1; $i <= $num_rows1; $i++)
{
	$res1 = $res->fetch_assoc();
	/* echo "<pre>";
	print_r($res1); */
	
	
?>	
	<tr>
		
		<td><input type="checkbox" class="chkbox" name="chk[]" id="<?php echo $res1['id']; ?>" value="<?php echo $res1['id']; ?>" /></td>
		<td><?php echo $res1['name'];?></td>
		<td><?php echo $res1['email'];?></td>
		<td colspan="3"><?php echo $res1['permissions'];?></td>
		<td colspan="3">
			<a href="add_staff_member.php?id=<?php echo $res1['id'];?>" class="pink"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a> 
			<a href="javascript:void(0);" class="pink pull-right" onclick="deleteSubUser(<?php echo $res1['id'] ?>);"><i class="fa fa-trash  fa-2x" aria-hidden="true"></i></a> 
			
		</td>
		
	</tr>	
<?php	

}
?>