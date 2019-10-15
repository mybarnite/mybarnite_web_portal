<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();
include'head.php'; ?>
	<title>List of promotions by nightclubs  | MyBarnite</title>
	<meta name="keywords" content="list of promotions by nightclubs, Events & promotions in the Nightclubs, Bars & Pubs near me">
	<meta name="description" content="With our list of promotions by nightclubs, we help you to control your spending while you continue to have fun. Grab our best deals">

<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();
$latitude= $_SESSION['latitude'];
$longitude =  $_SESSION['longitude'];
?>

<style>
.promotion-booking-text-btn{border: 1px solid #ff1da5;padding: 10px;border-radius: 5px;}
.grey-hr{border: 0;border-top: 1px solid #333;}
</style>
<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">
    
		
		<div class="row" id="promotion-content">
			<div class="span8">
				<h1>VENUES & PROMOTION</h1>
				<?php
				$getcontent = mysql_query("select * from maincontent where slugname='promotions-title'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
				<div class="form-group">
					<div class="col-sm-8">
						<select class="form-control" name="promotionType" id="promotionType">
							<option value="1">Bar</option>
							<option value="2">Event</option>
						</select>
						<input type="text" name="byLocationOrPostcode" id="byLocationOrPostcode" class="typeahead tt-query" placeholder="Promotion by Location/Postcode">
						<span>  <button type="submit" class="btn btn-default btn-color" id="searchPromotion">Search</button></span>
					</div>
					<br>
				</div>
			</div>
			<div class="span4 aliexpress-ads">
				<script style="text/javascript">
				  document.write('<a style="display:none!important" id="3460070"></a>');
				  if (window.AED_SHOW) {
					window.AED_SHOW({wid: '3460070',shortkey:'RnmY3vj', size:'300x250', custom:{}});
				  } else {
					window.AED_ONLOAD = window.AED_ONLOAD || [];
					window.AED_ONLOAD.push({wid:'3460070',shortkey:'RnmY3vj',size:'300x250',custom:{}});
					if (!document.getElementById("ae-ad-script-$")) {
					  var s = document.createElement("script"),
					  h = document.getElementsByTagName("head")[0];
					  s.id = 'ae-ad-script-$';
					  s.charset = "utf-8";
					  s.async = !0;
					  s.src = "//i.alicdn.com/ae-game/thirdparty/show-window/index.js";
					  h.insertBefore(s, h.firstChild)
					}
				  }
				</script>

			</div>
		</div>
		<?php
		//$sql = "SELECT p.*, b.Business_Name as name from tbl_promotions as p join bars_list as b on b.id=p.barId where  p.eventId=0";
		$sql = "SELECT p.*, b.Business_Name as name, ( 6371 * acos(cos(radians(".$latitude.")) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(".$longitude.")) +	sin(radians(".$latitude.")) * sin(radians(Latitude))) ) AS distance from tbl_promotions as p join bars_list as b on b.id=p.barId where  p.eventId=0 and p.endsat>=CURDATE() HAVING distance < 100";	
		$res = $db->myconn->query($sql);
		$num_rows1 = $res->num_rows;
		?>
		<div class="row" id="promotionForBar">
		<?php
		if($num_rows1>0){?>
		
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
					/* $end_date = strtotime($res1['endsat']);
					$start_date = strtotime($res1['startsat']);
					$current_date = strtotime(date("m/d/Y"));
					if($end_date>=$current_date)
					{	 */
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
					/* } */
				}
			}
		?>

		<?php }?>
		</div>	
	<?php
		//$query = "SELECT p.*, e.event_name as name from tbl_promotions as p join tbl_events as e on e.id=p.eventId where p.eventId!=0";
		$query = "SELECT p.*, e.event_name as name, ( 6371 * acos(cos(radians(".$latitude.")) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(".$longitude.")) + sin(radians(".$latitude.")) * sin(radians(Latitude))) ) AS distance from tbl_promotions as p join tbl_events as e on e.id=p.eventId left join bars_list as b on e.bar_id=b.id where p.eventId!=0 and p.endsat>=CURDATE() HAVING distance < 100";			
		$exe = $db->myconn->query($query);
		$num_event_promotion = $exe->num_rows;
		?>
		<div class="row" id="promotionForEvent">
		<?php
		if($num_event_promotion>0){?>
		
			<div class="span12 grey-hr"><h3>Live Events on Promotion</h3></div>
		<?php
		//echo $num_rows1;
			//$sql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p";
			
			for($i = 1; $i <= $num_event_promotion; $i++)
			{
					$res1 = $exe->fetch_assoc();
				
					$sql1 = "SELECT g.file_name,g.file_path,g.event_id,g.logo_image,e.* FROM tbl_events as e left join tbl_event_gallery as g on e.id=g.event_id and g.logo_image='1' WHERE e.id=".$res1['eventId'];
					$res2 = $db->myconn->query($sql1);
					$res3 = $res2->fetch_assoc();
					$imagePath = "business_owner/".$res3['file_path'];
					$path = "eventsdetail.php?event_id=".$res1['eventId'];
					$booking_text = "Book Event";
				
				if($res3['file_path']=="")
				{
					$imagePath = "images/no_image.png";
				}
				if($res1['name']!="")
				{	
					/* $end_date = strtotime($res1['endsat']);
					$start_date = strtotime($res1['startsat']);
					$current_date = strtotime(date("m/d/Y"));
					if($end_date>=$current_date)
					{ */	
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
					/* } */
				}
			}
		?>
	
		<?php }?>	
	</div>
	<?php
		$getBars = "select b.*,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where b.Rating >=2 and b.Owner_id !=0 limit 10";
		$exe_query = $db->myconn->query($getBars);
		$isBarFound = $exe_query->num_rows;
		if($isBarFound>0)
		{	
	?>
	<div class="row divider">
		<div class="span12">
				<h2>Top Rating Bars</h2>
			</div>
		<div class="span12">
			<div class="carousel-box">
				<div class="inner span12">
					
					<?php
						if($isBarFound>4){	
					?>
						<a class="prev"></a>
						<a class="next"></a>
					
					<?php
						}
						if($isBarFound>0){	
					?>
						<div class="<?php if($isBarFound>4){?>carousel<?php }?> main" >
							<ul >
							
							<?php
								for($c = 1; $c <= $isBarFound; $c++)
								{
									$getDetails = $exe_query->fetch_assoc();	
									if($getDetails['file_path']=="")
									{
										$file_path = "images/no_image.png";
									}	
									else
									{
										$file_path = "business_owner/".$getDetails['file_path'];
										
									}
							?>
							
								<li>
									<a href="bardetail.php?barid=<?php echo $getDetails['id']; ?>">
										<img src="<?php echo $file_path;?>" alt="<?php echo $getDetails['file_name'];?>"  border="0" />
										<div>
											<h4><?php echo $getDetails['Business_Name'];?></h4>
											<p>
												<?php echo 'Rating - '.$getDetails['Rating'];?>
											</p>
										</div>
									</a>
								</li>
								
							<?php 
								} 
							?>
							</ul>
						</div>	
					<?php 
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php 
		}
	?>
	<br/>
</section>
<?php include'footer.php'; ?>
<script>

$(document).ready(function() {

	navigator.geolocation.getCurrentPosition(callback);
	function callback(position) {
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
		//alert(latitude+"-"+longitude)
		$.ajax({
			type: "POST",
			url: "https://mybarnite.com/getLocation.php",
			data: {latitude :latitude,longitude :longitude},
			success: function(result){
				console.log(result);
				//location.reload(1);
				if(document.URL.indexOf("#")==-1){ //Check if the current URL contains '#'
					url = document.URL+"#"; // use "#". Add hash to URL
					location = "#";
					location.reload(true); //Reload the page
				}
				//$("#barsNearByLocation").html(result);		
			},
			error: function(){
				//alert("failure");
			}
	   });
		
	   
	}

	$("#searchPromotion").click(function() {
		var promotionType = $("#promotionType").val();
		//alert(promotionType);
		if(promotionType=='1')
		{
			//alert($("#byLocationOrPostcode").val());
			$.ajax({
				type: "POST",
				url: "https://mybarnite.com/getPromotionForBar.php",
				data: {searchText :$("#byLocationOrPostcode").val()},
				success: function(result){
					//alert(result);
					//console.log(result);
					$("#promotionForEvent").html("");
					$("#promotionForBar").html(result);		
				},
				error: function(){
					//alert("failure");
				}
			});	
				
		}
		else if(promotionType=='2')
		{
			
			$.ajax({
				type: "POST",
				url: "https://mybarnite.com/getPromotionForEvent.php",
				data: {searchText :$("#byLocationOrPostcode").val()},
				success: function(result){
					//console.log(result);
					$("#promotionForBar").html("");
					$("#promotionForEvent").html(result);		
				},
				error: function(){
					//alert("failure");
				}
			});	
		}
		
	}); 	
});
</script>
