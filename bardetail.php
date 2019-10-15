<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

$barid=$_REQUEST['barid'];
?>
<?php include'head.php'; ?>
<title>Mybarnite - Bar Details</title>
	<meta name="keywords" content="Nightclubs, Pubs, Bars, Nightclubs near me, Pubs near me, Bars near me">
	<meta name="description" content="View the event details, booking information, promotions and opening hours">
   <?php include'header.php'; ?>
<!--==============================Content=================================--> 
<?php 
				
$sql = "select p.*,b.id,b.Owner_id,b.is_requestedForClaim,b.PhoneNo,b.Rating,b.Latitude,b.Longitude,b.Zipcode,b.Address,b.description,b.Business_Name,b.Hours,b.Category_Searched,b.Location_Searched,b.is_hall_available,b.seat_for_basic,b.hall_fee,b.hall_capacity,b.cost_per_seat,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' left join tbl_promotions as p on p.barId=b.id and p.status='Active' where b.id = ".$barid;

$slider2query = mysql_query($sql);
$slider2row = mysql_fetch_assoc($slider2query);

//User details

$userSql = "select * from user_register where bar_id = ". $barid;
$userQuery = mysql_query($userSql);
$user2row = mysql_fetch_assoc($userQuery);

$userSql1 = "select * from user_register where id = ". $slider2row['Owner_id'];
$userQuery1 = mysql_query($userSql1);
$user2row1 = mysql_fetch_assoc($userQuery1);


if($slider2row['file_path']=="")
{
	$file_path = "images/no_image.png";
}	
else
{
	$file_path = "business_owner/".$slider2row['file_path'];
	
}
$ip = $_SESSION['ip'];
 
$latitude = $_SESSION['latitude'];
$longitude = $_SESSION['longitude'];

$point1 = array("lat" => $latitude, "long" => $longitude); // Paris (France)
$point2 = array("lat" => $slider2row['Latitude'], "long" => $slider2row['Longitude']); // Mexico City (Mexico)
//$km = distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long']); // Calculate distance in kilometres (default)
$mi = distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'mi'); // Calculate distance in miles
//$nmi = distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'nmi'); // Calculate distance in nautical miles	



if( $slider2row ){?>

		
<section id="content" >
	<div class="container divider" id="events_details">
			
		<div class="row">
			<div class="span4">
				<div class="row" style="color:#fff;margin-left:0px;">
					<img src="<?php echo $file_path;?>" alt="<?php echo $slider2row['file_name'];?>"  border="0" class="alignleft" height="177" width="284" />
				</div>
				
				<div class="row" style="color:#fff;margin-left:0px;">
					<a href="menu.php?id=<?php echo $barid;?>" value="order" class="pink" style="font-size: 14px;
    text-decoration: none;"><i class="fa fa-bars" aria-hidden="true"></i> Menu</a>&nbsp;&nbsp;&nbsp;
				
				<?php if(isset($_SESSION['id'])&&$_SESSION['id']!=""&&$slider2row['Owner_id']!=0)
				{
					$select = "select * from  tbl_user_myfavourites where userid = ".$_SESSION['id']." and barid = ".$barid." and is_favourite = '1'";
					$is_fav = mysql_query($select);
					$favourite = mysql_num_rows($is_fav);
					if($favourite<=0)
					{	
				?>
				
					<a href="javascript:void(0);" value="order" class="pink" style="font-size: 14px;
    text-decoration: none;" onclick="addToFavourite('',<?php echo $_REQUEST['barid'];?>,'Add');"><i class="fa fa-star" aria-hidden="true"></i> Add to favourite</a>&nbsp;&nbsp;&nbsp;
				
				<?php 
						}
				?>
				<?php 
				if($slider2row['Owner_id'] != 0 && $user2row1['status'] == 'Active')
				{
				?>
					<a href="book_bar.php?bar_id=<?php echo $barid;?>" value="order" class="pink" style="font-size: 14px;
    text-decoration: none;"><i class="fa fa-check-square" aria-hidden="true"></i> Book Bar</a>
    				<?php			
				}
				?>
				
				<?php			
				}
				?>
				</div>
			</div>
		
			<div class="span5 form-horizontal">
				<div class="control-group">
					<h1 style="color:#ff1da5;font-size: 17px;margin-top: 0;"><?php echo $slider2row['Business_Name'];?></h1>
				</div>
				<div class="control-group">
					<p style="color:#9393a7;font-size:14px;"><?php echo $slider2row['description'];?></p>
				</div>	
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Hours : <span style="color:#9393a7"><?php if($slider2row['Hours']) {echo  $slider2row['Hours']; } else { echo "-"; }?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Location : <span style="color:#9393a7"><?php if($slider2row['Location_Searched']) {echo  $slider2row['Location_Searched']; } else { echo "-"; }?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Postcode : <span style="color:#9393a7"><?php echo $slider2row['Zipcode'] ;?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Hall : <span style="color:#9393a7"><?php echo ($slider2row['is_hall_available']==1)?"Available for renting (&#163;".$slider2row['hall_fee']." with capacity of ".$slider2row['hall_capacity']." people)":"Not available for renting" ;?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Number of available seat : <span style="color:#9393a7"><?php echo ($slider2row['seat_for_basic']!="")?$slider2row['seat_for_basic']." (&#163;".$slider2row['cost_per_seat']."/seat)":"-" ;?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName">Ratings : <span style="color:#9393a7"><?php echo (!empty($slider2row['Rating']))?$slider2row['Rating']:"-" ;?></span></label>
				</div>
				<div class="control-group">
					<label  style="font-size:16px;color:#ff1da5;margin-bottom:0px;" for="inputName" id="distanceKm">Distance (Miles) : <span style="color:#9393a7"><?php echo (!empty($mi))?$mi:"-" ;?></span></label>
				</div>
				<?php 

				if($slider2row['Owner_id'] != 0 && $user2row1['status'] == 'Active')
				{
				?>	
			
				<div class="row" style="color:#ff1da5;margin-left:0px;">
					<?php 
					//echo $_SESSION['id']."-".$_SESSION['business_owner_id'];
					if($_SESSION['id']=="")
					{
						$_SESSION['barToBeBooked'] = $barid;	
					}		
					
					?>
						<a href="book_bar.php?bar_id=<?php echo $barid;?>" value="order" class="btn btn-primary bg-pink" style="font-size: 14px;
    text-decoration: none;"><i class="fa fa-check-square" aria-hidden="true"></i> Book seat or Book full bar</a>
					
				</div>
				<?php
				}
				else
				{
				?>	
					<a href="<?php echo SITE_PATH.'business_owner/business_owner_signup.php?id='.$barid;?>" value="register" class="btn btn-primary bg-pink" style="font-size: 14px;
    text-decoration: none;">Register your business</a>
				<?php	
				}		
				?>	

			</div>
			<div class="span3">
				
				<h2 class="pink" style="margin-top:10px;line-height: 17px;">Events</h2>	
				<div id="accordion2" class="accordion max-size1">
				
				<?php
						//UB3 5BP
						$count = 1;
						$upcomingquery = mysql_query(" SELECT id,event_name,event_description FROM tbl_events where bar_id=".$barid." and event_end > CURDATE() order by id DESC limit 0,5");
						$event_counts = mysql_num_rows($upcomingquery);
						if($event_counts!=""&&$event_counts>0)
						{	
								while($upcomingrow = mysql_fetch_assoc($upcomingquery))
								{
			
						?>
									<div class="accordion-group">
										<div class="accordion-heading ">
											<div class="accordion-toggle" data-target="#collapse<?php echo $count; ?>" data-toggle="collapse" data-parent="#accordion2">
												<span></span>
												<a style="color:#9393a7;text-decoration:none;" href="eventsdetail.php?event_id=<?php echo $upcomingrow['id'];?>"><?php echo $upcomingrow['event_name']; ?></a>
											</div>
										</div>
										<div id="collapse<?php echo $count; ?>" class="accordion-body collapse ">
											<div class="accordion-inner">
												<?php echo $upcomingrow['event_description']; ?>
												
											</div>
										</div>
									</div>
						
								<?php
								 $count++;
								} 
						}
						else
						{
							echo "<p style='color:#9393a7;'>Events are not available.</p>";
						}		
						?>
				
				</div>
			</div>
		</div>
		<?php
		$sql = "select * from tbl_bar_gallary where bar_id=".$barid." order by id DESC limit 10";
		$slider2query = mysql_query($sql);
		$num_images = mysql_num_rows($slider2query);
		if(isset($num_images)&&$num_images>0)
		{	
		?>
		<hr class="hr_gray_class" />
		<div class="row">	
			<div class="span12">
				<h2 class="pink">Bar Images</h2>
			</div>		
		</div>	
		<div class="row">
			<div class="carousel-box">
				
				<div class="inner span12">
					
					<a class="prev"></a>
					<a class="next"></a>
					<div class="carousel main" >
						<ul>
						<?php
							while($slider2row = mysql_fetch_assoc($slider2query))
							{		//echo $slider2row['file_path'];
									if (file_exists("business_owner/".$slider2row['file_path'])) 
									{ 
							?>
									<li>
										<img src="business_owner/<?php echo $slider2row['file_path'];?>" alt="<?php echo $slider2row['file_name'];?>"  border="0" />
									</li>
							<?php
									 } 
							} 
						?>
						</ul>
					</div>	
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</section>


<?php
} else{ ?>
   <section>
   	<div class="container divider" id="events_details">
		<div class="row">
			<div class="control-group">
				<h1 style="color:#ff1da5;font-size: 17px;margin-top: 0;">No details found</h1>
			</div>
		</div>
	</div>
   </section>
   
<?php } ?>

<script type="text/javascript" src="js/frontend_custom.js"></script>
<?php include'footer.php'; ?>
<script>
$(document).ready(function() {

	navigator.geolocation.getCurrentPosition(callback);
	function callback(position) {
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
		$.ajax({
			type: "POST",
			
			url: "https://mybarnite.com/getDistanceInKm.php",
			data: {latitude :latitude,longitude :longitude, barid :<?php echo $_GET['barid'];?>},
			success: function(result){
				//alert(result);
				console.log(result);
				$("#distanceKm").html(result);		
			},
			error: function(){
				//alert("failure");
			}
	   });
		
	   
	}

		
});
</script>