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


$limit  = 2;
$offset = ($pageNo - 1) * $limit;
$sql = "select f.is_favourite, f.id as favouriteid,b.id as barid,b.Business_Name,b.Location_Searched,b.Address,b.description,b.Hours,b.Price_Range,g.file_path,g.file_name from tbl_user_myfavourites as f left join bars_list as b on f.barid = b.id left join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where f.is_favourite = '1' and  f.userid =".$_SESSION['id'] ;
$sql .= " order by f.id DESC limit ".$offset.",".$limit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;

$countsql = "select f.is_favourite, f.id as favouriteid,b.id as barid,b.Business_Name,b.Location_Searched,b.Address,b.description,b.Hours,b.Price_Range,g.file_path,g.file_name from tbl_user_myfavourites as f left join bars_list as b on f.barid = b.id left join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where f.is_favourite = '1' and  f.userid =".$_SESSION['id'] ;
$countres = $db->myconn->query($countsql);
$num_rows = $countres->num_rows;

#echo $_SESSION['useremail'];

?>
	<input type='hidden' id='totalCount' value='<?php echo $num_rows; ?>'/>
	<input type='hidden' id='Page' value='<?php echo "$pageNo" ?>'/>
<?php	
for($i = 1; $i <= $num_rows1; $i++)
{
	$res1 = $res->fetch_array();
	
	$path = ($res1['file_path'])?"/business_owner/".$res1['file_path']:"images/no_image.png";
	
	if(isset($res1['barid']))
	{
?>	
		<div>	
			<a href="bardetail.php?barid=<?php echo $res1['barid'];?>"> <img src="<?php echo SITE_PATH.$path;?>" alt="<?php echo $res1['file_name'];?>" width="270" height="199" border="0" class="alignleft "/></a>
			<span style="color:#fff">
				<a href="bardetail.php?barid=<?php echo $res1['barid']; ?>" style="text-decoration:none;"> <strong><?php echo $res1['Business_Name'];?></strong></a>
				<p><?php echo $res1['description'];?></p>
				
			</span>
			<button type="button" name="removefavourites" value="removefavourites" class="btn btn-primary pull-right bg-pink" onclick="addToFavourite(<?php echo $res1['favouriteid'];?>,<?php echo $res1['barid'];?>,'Remove');">Remove from favourite</button>
		</div>	
		
		<div class="clearfix padcontent"></div>
		
<?php
	}	
	
}
?>