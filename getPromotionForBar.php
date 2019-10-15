<?php

session_start();
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
$searchText = $_POST['searchText'];
if($searchText!="")
{
	$query_str = "SELECT p.*, b.Business_Name as name from tbl_promotions as p join bars_list as b on b.id=p.barId join user_register as u on u.id=b.Owner_id where  p.eventId=0 and (b.Zipcode like '".$searchText."%' or b.Location_Searched like '%".$searchText."%' or b.Address like '%".$searchText."%' or b.Region like '%".$searchText."%' ) and p.endsat>=CURDATE()";	
	$res = $db->myconn->query($query_str);
	$num_rows1 = $res->num_rows; 
	if($num_rows1>0){ 
	?>
	<div class="span12 grey-hr"><h3>Venue Available for Rent</h3></div>
	<?php	
		for($i = 1; $i <= $num_rows1; $i++)
		{
				$res1 = $res->fetch_assoc();
			
				$sql1 = "select b.*,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where b.id = ".$res1['barId'];
				$res2 = $db->myconn->query($sql1);
				$res3 = $res2->fetch_assoc();
				$imagePath = "business_owner/".$res3['file_path'];
				$path = "bardetail.php?barid=".$res1['barId'];
				$booking_text = "Book Bar";
			
			if($res3['file_path']=="")
			{
				$imagePath = "images/no_image.png";
			}
			if($res1['name']!="")
			{
				?>
				<div class="span6" class="promotion-list">
					<a href="<?php echo $path;?>"><img src="<?php echo $imagePath;?>" alt="list of promotions by nightclubs"  border="0" class="alignleft" width="284" height="177"/></a>
					<p class="font-color-white">
						<a href="<?php echo $path;?>" class="text-decoration-none"><strong class="font-size16px"><?php echo $res1['name'];?></strong></a>
						
						<span>Discount :</span>
						<span><?php echo $res1['discount'];?>% off</span>
						<br/>
						<span>Valid from :</span>
						<span><?php echo date('M d,Y',strtotime($res1['startsat']));?></span>
						<span>To</span>
						<span><?php echo date('M d,Y',strtotime($res1['endsat']));?></span>
						<br/>
						<strong>
							<span>COUPON CODE :</span>
							<span><?php echo $res1['couponcode'];?></span>
						</strong>
						<br/>
						<a href="<?php echo $path;?>" class="text-decoration-none pink promotion-booking-text-btn"><?php echo $booking_text;?></a>
					</p>
				</div>
				<?php
			}
		}	
	} 
	else
	{
		?>
		<div class="span12" class="promotion-list">
			<div class="alert alert-danger align-center">Promotions not available</div>
		</div>
		<?php
	}	
}
else
{
	?>
	<div class="span12" class="promotion-list">
		<div class="alert alert-danger align-center">Promotions not available</div>
	</div>
	<?php
}	
?>