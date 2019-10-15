<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

if(isset($_SESSION['business_owner_id']))
{
	$_SESSION['isLoggedIn'] = $_SESSION['business_owner_id'];	
}
if(isset($_SESSION['id']))
{
	$_SESSION['isLoggedIn'] = $_SESSION['id'];	
}		
		
?>
	<?php include'head.php'; ?>
	<title>Best local bars, pubs and Nightclubs  in UK | Mybarnite</title>
	<meta name="keywords" content="Best local bars, pubs and Nightclubs in UK, best pubs uk, best nigtclubs uk, best local pubs in london">
	<meta name="description" content="How awesome is finding the Best local bars, pubs and Nightclubs in UK or Events of your choice anywhere, at anytime, to enjoy yourself? We guide you to find a place.Best Nightclubs, Pubs & Bars near me">
	<?php include'header.php'; ?>
   
	<script src="flexslider/js/modernizr.js"></script> <!-- Modernizr -->

    <!--==============================Slider=================================--> 
    <div class="slider">
		<div class="camera_wrap span12">
		
		<?php
			$sliderquery = mysql_query("SELECT * FROM slider_images_tb ");
			while($sliderrow = mysql_fetch_array($sliderquery))
			{
			
		?>
		
		
			<div data-src="adminimages/slider/<?php echo $sliderrow['banner_image'];?>">
			     
			
			</div>

			<?php } ?>

		</div>
		
	   
	</div>

	<div class="row search-form offset3">
	<div class="span6">
	<h3>Find Night Clubs, Bars and Restaurants:</h3>
	<form class="form-horizontal" method="post" action="bars-list.php">
		<div class="form-group">
			<div class="col-sm-8">
				<select class="form-control select-option" name="cat">
					<option>Bars</option>
					<option>Pubs</option>
					<option>Wine Bars</option>
					<option>Lounges</option>
					<option>Restaurant</option>
				</select>
				<input type="text" name="searchtxt" class="typeahead tt-query searchtxt"  placeholder="Enter Zipcode/Postcode/Club name">
				<span>  <button type="submit" class="btn btn-default btn-color">Search</button></span>
			</div>
		<br>
		</div>
	</form>
	</div>
	</div>
	<style>
	.slider-tumb{display:none !important:}
	</style>
</header>


<!--==============================Carusel=================================--> 
		
	<?php

	$ip = $_SERVER['REMOTE_ADDR'];
	$url = getUserLocationDetails($ip);
	
	$ipAddress = $url->ipAddress;
	//$latitude = $url->latitude;
	//$longitude = $url->longitude;
	//$latitude= "51.4859582";
	//$longitude= "-0.1849112";
	$latitude= $_SESSION['latitude'];
	$longitude =  $_SESSION['longitude'];
	$_SESSION['ip'] = $ip;
	$_SESSION['latitude'] = $latitude;
	$_SESSION['longitude'] = $longitude;
	
	$sql = "SELECT *,
		( 6371 * acos(
		cos(radians(".$latitude.")) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(".$longitude.")) +
		sin(radians(".$latitude.")) * sin(radians(Latitude))
		) ) AS distance
	FROM bars_list
	HAVING distance < 10
	ORDER BY distance limit 10"; 
	
	$slider2query = mysql_query($sql);
	$countbars = mysql_num_rows($slider2query);
	?>	
	<div class="carousel-box">
		<div class="inner span12">
		
			<?php				if($countbars>4){				?>				<a class="prev"></a>				<a class="next"></a>						<?php				}				?>
		
			<div class="<?php if($countbars>4){?>carousel<?php }?> main" >
				<ul >
				
				<?php
				
		
			while($slider2row = mysql_fetch_assoc($slider2query))
			{
				$get_image = "select file_path,file_name,logo_image from tbl_bar_gallary where bar_id=".$slider2row['id']." and logo_image='1'";
				$execute_query = mysql_query($get_image);
				$logoImage = mysql_fetch_assoc($execute_query);
				
				$muserSql = "select * from user_register where id = ". $slider2row['Owner_id'];
				$muserQuery = mysql_query($muserSql);
				$m1 = mysql_fetch_assoc($muserQuery);
				
				if($slider2row['Business_Name']!="")
				{
		?>
				
					<li >
						<?php 
						if(isset($_SESSION['business_owner_id']))
						{
						?>	
							<a href="#">
						<?php	
						}
						else					
						{	
						?>
							<a href="bardetail.php?barid=<?php echo $slider2row['id'];?>">
						<?php
						}
						?>
						<?php
						if (isset($logoImage['file_path'])&&file_exists("business_owner/".$logoImage['file_path'])) 
						{
						?>
						<img src="business_owner/<?php echo $logoImage['file_path'];?>" alt="<?php echo $logoImage['file_name'];?>"  border="0" class="carousel-box-image"/>
						<?php 
						}
						else
						{
						?>	
						<img src="images/no_image.png" alt="no image"  border="0" />	
						<?php	
						}	
						?>
						<div>
							<h4><?php echo $slider2row['Business_Name'];?></h4>
							<p>
								<?php echo $slider2row['Category'];?>
							</p>
							<p>
								Booking Status<?php if($slider2row['Owner_id'] != 0 && $m1['status'] === 'Active'){  echo ' - Available';  } else {  echo ' - Not Available';  }  ?>
							</p>
						</div>
					  </a>
					</li>
					
			<?php
				}	
			} 
			
			?>
					
				</ul>
			</div>	
		</div>
	</div>
<section id="content" class="main-content">
	<div class="container">
		<div class="row">
			<div class="span12">
				<?php
				$mainquery = mysql_query(" SELECT * FROM maincontent ");
				$mainrow = mysql_fetch_array($mainquery);
				?>
				<h1 class="pink"><?php echo $mainrow['heading'];?></h1>
			</div>
			<div class="span7 what_we_do">
				<?php echo $mainrow['message'];?>
			</div>
			<div class="span1">&nbsp;</div>
			<div class="span4 pull-right aliexpress-ads">
				    <!--
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
					-->
				
			</div>
		</div>
		<hr class="grey-hr">
		<div class="row">
			<div class="span4">
				<h2>Get your venue listed!</h2>
				<span class="claim-box-image"> 
					<i class="fa fa-question-circle fa-5x fa-question-bg-pink" aria-hidden="true"></i> 
					
				</span>
				<span class="align-center pull-left" style="margin:0 30px;">
					
						Your business is not yet registered!!
						<br/>
						Claim your business now!
					
				</span>
				<br/><br/>
				<span class="align-center pull-left">
					<a href="https://mybarnite.com/business_owner/business_owner_signup.php" class="btn btn-primary btn-color" style="margin:10px 45px 0 70px;">Apply Now</a>
				</span>		
			</div>
			<div class="span4">
				<h2>Promote Your Event!</h2>
			
				<?php 
				$query_str3 = "SELECT p.*, e.event_name as name from tbl_promotions as p join tbl_events as e on e.id=p.eventId left join bars_list as b on e.bar_id=b.id where p.eventId!=0 and p.endsat>=CURDATE() and e.event_end>=CURDATE() limit 5";
		
				$exe_query3 = mysql_query($query_str3);
				$numOfEventPromotion = mysql_num_rows($exe_query3);
				if($numOfEventPromotion>0)
				{	
				?>
				<div class="cd-testimonials-wrapper cd-container">
					<ul class="cd-testimonials">
					<?php
					while($getEventPromotion = mysql_fetch_assoc($exe_query3))
					{
						$query_str2 = "SELECT g.file_name,g.file_path,g.event_id,g.logo_image,e.* FROM tbl_events as e left join tbl_event_gallery as g on e.id=g.event_id and g.logo_image='1' WHERE e.id=".$getEventPromotion['eventId'];
						$exe_query2 = mysql_query($query_str2);
						$getEventImagePath = mysql_fetch_assoc($exe_query2);
						
						$imagePath = "business_owner/".$getEventImagePath['file_path'];
						$path = "eventsdetail.php?event_id=".$getEventPromotion['eventId'];
						$booking_text = "Book Event";
					
						
						
					?>
						<li>
							<?php 
								if($getEventImagePath['file_path']=="")
								{
									//$imagePath = "images/icon-4.png";
									?>
									<span class="bar-box-image"> 
										<i class="fa fa-calendar fa-5x calendar-bg-pink" aria-hidden="true"></i>
									</span>
									
									<?php
								}
								else
								{
								?>

									<img src="<?php echo $imagePath;?>" alt="list of promotions by nightclubs"  border="0" class="aligncenter box-image"/>
								<?php		
								}	
								
							?>
							<p class="font-color-white pull-left">
								<a href="<?php echo $path;?>" class="text-decoration-none"><strong class="font-size16px"><?php echo $getEventPromotion['name'];?></strong></a>
								
								<span>Discount :</span>
								<span><?php echo $getEventPromotion['discount'];?>% off</span>
								<br>
								<span>Valid from :</span>
								<span><?php echo date('M d,Y',strtotime($getEventPromotion['startsat']));?></span>
								<span>To</span>
								<span><?php echo date('M d,Y',strtotime($getEventPromotion['endsat']));?></span>
								<br>
								<strong>
									<span>COUPON CODE :</span>
									<span><?php echo $getEventPromotion['couponcode'];?></span>
								</strong>
								<br>
								<a href="<?php echo $path;?>" class="text-decoration-none pink promotion-booking-text-btn"><?php echo $booking_text;?></a>
							</p>
							
						</li>
					<?php 
					}
					?>	
					
					</ul>
				</div>
				<?php 
				}
				else
				{
					echo "Coming Soon..";
				}	
				?>
			</div>
			<div class="span4">
				<h2>Download Mobile App</h2>
		 
				<?php
					$mobilequery = mysql_query(" SELECT * FROM mobile_app_message ");
					$mobilerow = mysql_fetch_array($mobilequery);
				?>
		  
				<img src="images/img1.jpg" alt="Best local bars, pubs and nightclubs  in UK"  border="0" class="aligncenter "/>
				<p>
					<?php echo $mobilerow['desc'];?>
				</p>
				<a href="#" class="btn btn-primary">Download Now</a>
				<div class="padcontent"></div>
			</div>
			
			
		</div>
		<hr class="grey-hr">
		<div class="row">
			<div class="span4">
				<h2>Popular nightclubs</h2>
		 
				<?php 
				$query_str4 = "SELECT o.bar_id,COUNT(*) as c,b.id,b.Business_Name, b.description, g.file_path
				FROM bars_list as b join tbl_order_history as o on b.id=o.bar_id left join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' group by o.bar_id having o.bar_id!=0 ORDER BY c DESC limit 5";
		
				$exe_query4 = mysql_query($query_str4);
				$numOfPopularBars = mysql_num_rows($exe_query4);
				if($numOfPopularBars>0)
				{	
				?>
				<div class="cd-testimonials-wrapper cd-container">
					<ul class="cd-testimonials">
					<?php
					while($popularBar = mysql_fetch_assoc($exe_query4))
					{
						$query_str5 = "select p.* from tbl_promotions as p where p.barId = ".$popularBar['id']." and p.eventId=0 and p.endsat>=CURDATE()";
						$exe_query5 = mysql_query($query_str5);
						$numOfPopularBarPromotion = mysql_num_rows($exe_query5);
						$getPopularBarPromotion = mysql_fetch_assoc($exe_query5);
						
						$imagePath = "business_owner/".$popularBar['file_path'];
						$path = "bardetail.php?barid=".$popularBar['id'];
						$booking_text = "Book Bar";
					
						
						
					?>
						<li>
							<?php 
								if($popularBar['file_path']=="")
								{
									$imagePath = "images/bar-icon4.png";
									?>
									<span class="bar-box-image"> 
										<img alt="list of promotions by nightclubs" src="<?php echo $imagePath;?>"> 
									</span>
									<?php
								}
								else
								{
								?>

									<img src="<?php echo $imagePath;?>" alt="list of promotions by nightclubs"  border="0" class="aligncenter box-image"/>
								<?php		
								}	
							
							if($numOfPopularBarPromotion>0)
							{	
							?>
							<p class="font-color-white pull-left">
								<a href="<?php echo $path;?>" class="text-decoration-none"><strong class="font-size16px"><?php echo $popularBar['Business_Name'];?></strong></a>	
								<span>Discount :</span>
								<span><?php echo $getPopularBarPromotion['discount'];?>% off</span>
								<br>
								<span>Valid from :</span>
								<span><?php echo date('M d,Y',strtotime($getPopularBarPromotion['startsat']));?></span>
								<span>To</span>
								<span><?php echo date('M d,Y',strtotime($getPopularBarPromotion['endsat']));?></span>
								<br>
								<strong>
									<span>COUPON CODE :</span>
									<span><?php echo $getPopularBarPromotion['couponcode'];?></span>
								</strong>
								<br/>
								<a href="<?php echo $path;?>" class="text-decoration-none pink promotion-booking-text-btn"><?php echo $booking_text;?></a>
							</p>
							<?php
							}else
							{
							?>	
							<p class="font-color-white pull-left" style="margin:0 70px;line-height: 17px">
								<a href="<?php echo $path;?>" class="text-decoration-none"><strong class="font-size16px"><?php echo $popularBar['Business_Name'];?></strong></a>	
								
								<br/>
								<a href="<?php echo $path;?>" class="text-decoration-none pink promotion-booking-text-btn"><?php echo $booking_text;?></a>
								
								<br/>
							</p>	
							<?php	
							}	
							?>
								
							
						</li>
					<?php 
					}
					?>	
					
					</ul>
				</div>
				<?php 
				}
				else
				{
					echo "Coming Soon..";
				}	
				?>
				<div class="padcontent"></div>
			</div>
			<div class="span4">
				<h2>Upcoming events</h2>
				<?php
				$getcontent = mysql_query("select * from maincontent where slugname='upcoming-event-title'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
				<div id="accordion2" class="accordion">
			
					<?php
						$count = 1;
						//$upcomingquery = mysql_query(" SELECT * FROM tbl_events WHERE event_start >= CURDATE() and end_time >= CURTIME() ");
						//$upcomingquery = mysql_query("SELECT * FROM tbl_events WHERE event_starttimestamp >= '".$currentDateTimestamp."' order by event_start DESC limit 5");
						$upcomingquery = mysql_query("SELECT * FROM tbl_events WHERE eventtype='Upcoming' order by id DESC limit 5");
						$countRow = mysql_num_rows($upcomingquery);
						if($countRow>0)
						{	
							while($upcomingrow = mysql_fetch_array($upcomingquery))
							{
								$current_date = strtotime(date("m/d/Y"));	
								$start_date = strtotime($upcomingrow['event_start']);	
								$end_date = strtotime($upcomingrow['event_end']);	
								if($current_date<=$end_date)
								{
						?>

							<div class="accordion-group">
								<div class="accordion-heading ">
									<div class="accordion-toggle" data-target="#collapse<?php echo $count; ?>" data-toggle="collapse" data-parent="#accordion2">
										<span></span>
										<a class="event-title-a" href="eventsdetail.php?event_id=<?php echo $upcomingrow['id'];?>"><?php echo $upcomingrow['event_name']; ?></a>
									</div>
								</div>
								<div id="collapse<?php echo $count; ?>" class="accordion-body collapse ">
									<div class="accordion-inner">
										<?php echo $upcomingrow['event_description']; ?>
										
									</div>
								</div>
							</div>
				
						<?php
							}
						 $count++;
						} 
					}
					else
					{
						echo "No upcoming events for now.";
					}		
					?>
				</div>
				<div class="padcontent"></div>
			</div>
			<div class="span4">
				<h2>Blogs</h2>
		 
				<div id="accordion3" class="accordion">
					<ul style="padding:10px;">
					<?php
						$count1 = 1;
						$query = mysql_query("SELECT * from tbl_manage_blogs where status = 'Active' ORDER BY created_at DESC limit 5");
						$num_rows = mysql_num_rows($query);
						if($num_rows>0)
						{	
							while($blogs = mysql_fetch_array($query))
							{
								//$current_date = strtotime(date("m/d/Y"));	
								//$start_date = strtotime($upcomingrow['event_start']);	
								//$end_date = strtotime($upcomingrow['event_end']);	
								/* if($current_date<=$end_date)
								{ */
						?>
							<li style="padding-bottom: 10px;">
								<a class="event-title-a" href="blog-detail.php?id=<?php echo $blogs['id']?>"><?php echo $blogs['title']; ?></a>
							</li>
							
						<?php
							//}
						 $count1++;
						} 
					}
					else
					{
						echo "No blogs available.";
					}		
					?>
					</ul>
				</div>
				<div class="padcontent"></div>
			</div>
		</div>
	</div>
</section>

<?php include'footer.php'; ?>
<script>

$(document).ready(function() {
	/* $('.cd-testimonials-wrapper').flexslider({
		selector: ".cd-testimonials > li",
		animation: "slide",
		controlNav: false,
		slideshow: false,
		smoothHeight: true,
		start: function(){
			$('.cd-testimonials').children('li').css({
				'opacity': 1,
				'position': 'relative'
			});
		}
	}); */

	//open the testimonials modal page
	$('.cd-see-all').on('click', function(){
		$('.cd-testimonials-all').addClass('is-visible');
	});

	//close the testimonials modal page
	$('.cd-testimonials-all .close-btn').on('click', function(){
		$('.cd-testimonials-all').removeClass('is-visible');
	});
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
		if(event.which=='27'){
			$('.cd-testimonials-all').removeClass('is-visible');	
		}
	});
	$('.cd-testimonials-wrapper').flexslider({
		selector: ".cd-testimonials > li",
		animation: "slide",
		controlNav: false,
		slideshow:true,
		smoothHeight: true,
		directionNav: false,
		pauseOnHover: true,
		start: function(){
		  $('.cd-testimonials').children('li').css({
			'opacity': 1,
			'position': 'relative'
		  });
		}
	});

	navigator.geolocation.getCurrentPosition(callback);
	function callback(position) {
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
		$.ajax({
			type: "POST",
			//url: "https://newbarnite.mybarnite.com/getBarbyNearByLocation.php",
			url: "https://mybarnite.com/getLocation.php",
			data: {latitude :latitude,longitude :longitude},
			success: function(result){
				//console.log(result);
				//$("#barsNearByLocation").html(result);		
				//$(".carousel-box").html(result);	
				 if(document.URL.indexOf("#")==-1){ //Check if the current URL contains '#'
					url = document.URL+"#"; // use "#". Add hash to URL
					location = "#";
					location.reload(true); //Reload the page
				}				
			},
			error: function(){
				//alert("failure");
			}
	   });
		
	   
	}

	 	
});
</script><!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a8123eed6fb0232"></script>

<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-578cc5dfa6588974"></script>-->
<script src="flexslider/js/jquery.flexslider-min.js"></script>

