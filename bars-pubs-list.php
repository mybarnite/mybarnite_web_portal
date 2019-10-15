<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();



?>

<?php include'head.php'; ?>
<title>Bars and pubs near you | Mybarnite</title>
<meta name="keywords" content="Bars and pubs near you, List of bars in london, bars and nightclubs near me">
<meta name="description" content="Check out your favorite Bars and pubs near you, plus the Night Clubs.  Be the first to know what is going on in your area.">
   <?php include'header.php'; ?>
<!--==============================Map=================================--> 
<style>
@media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
.amazon-ads iframe{max-width:270px !important;}
}
</style>
	
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
		<div class="row amazon-ads">
			<div class="span3">&nbsp;</div>
			<div class="span6 align-center">
				<iframe src="//rcm-eu.amazon-adsystem.com/e/cm?t=mybarnite-21&o=2&p=26&l=ez&f=ifr&f=ifr" width="468" height="60" scrolling="no" marginwidth="0" marginheight="0" border="0" frameborder="0" style="border:none;max-width:800px;max-height:600px;"></iframe>
			</div>
			<div class="span3">&nbsp;</div>
		</div>
		
		<div class="row">
			<div class="span12">
				<h1>BARS, CLUBS, PUBS AND RESTAURANTS NEAR YOU</h1>	
				<?php
								$getcontent = mysql_query("select * from maincontent where slugname='clubs-bars-and-nightclubs-title'");
								$fetchContent = mysql_fetch_assoc($getcontent);
								echo $fetchContent['message'];
								?>
			</div>
		</div>
		
		
		<div class="row clearfix">
			<div class="span6 offset3 bg-style-search">
				<h3>Find Night Clubs, Bars and Restaurants:</h3>
				<form class="form-horizontal" method="post" action="search-bars-list.php">
					<div class="form-group">
						<div class="col-sm-8">
							<input type="text" required  name="barName" id="barName" class="typeahead tt-query" placeholder="Search by Name">
							<input type="text" required  name="barPostcode" id="barPostcode" class="typeahead tt-query"  placeholder="Search by Zipcode/Postcode">
							<span>  <button type="submit" class="btn btn-default btn-color">Search</button></span>
						</div>
						<br>
					</div>
				</form>
			</div>
		</div>
		
		<br/>
		
	</div>
</section>

<?php

	//$latitude= "51.4859582";
	//$longitude= "-0.1849112";
	$latitude= $_SESSION['latitude'];
	$longitude =  $_SESSION['longitude'];
	
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
		<?php if($countbars>4){?>
			<a class="prev"></a>
			<a class="next"></a>
		<?php }?>	
			<div class="<?php if($countbars>4){?>carousel<?php }?> main" >
				<ul >
				
				<?php
				
		
			while($slider2row = mysql_fetch_assoc($slider2query))
			{
				$get_image = "select file_path,file_name,logo_image from tbl_bar_gallary where bar_id=".$slider2row['id']." and logo_image='1'";
				$execute_query = mysql_query($get_image);
				$logoImage = mysql_fetch_assoc($execute_query);
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
	<br><br><br>

	
    <?php include'footer.php'; ?>
	<script>

	$(document).ready(function() {
		navigator.geolocation.getCurrentPosition(callback);
		function callback(position) {
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;
			$.ajax({
				type: "POST",
				url: "https://newbarnite.mybarnite.com/getLocation.php",
				data: {latitude :latitude,longitude :longitude},
				success: function(result){
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

			var $inputs = $('input[name=barName],input[name=barPostcode');
			$inputs.on('input', function () {
				// Set the required property of the other input to false if this input is not empty.
				$inputs.not(this).prop('required', !$(this).val().length);
			});	
			
	}); 
	
	
</script>
