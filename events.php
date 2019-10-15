<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>
	<?php include'head.php'; ?>
	<title>List of events by nightclubs in London | MyBarnite</title>
	<meta name="keywords" content="List of events by nightclubs in London, Nightclubs, Pubs, Bars, Nightclubs near me, Pubs near me, Bars near me">
	<meta name="description" content="We have a list of events by nightclubs in London, in your locality organised by Bars/Pubs/Night clubs. Explore today.">
	<?php include'header.php'; ?>
<!--==============================Content=================================--> 
<section id="content" >
	<div class="container divider">
		<div class="row">
			<div class="span4">
				<h1>Upcoming Events</h1>
					<?php
					$getcontent = mysql_query("select * from maincontent where slugname='upcoming-event-title'");
					$fetchContent = mysql_fetch_assoc($getcontent);
					echo $fetchContent['message'];
					?>
				
			</div>
			<div class="span4">
				<h2 class="h2-margin">Special Event</h2>
					<?php
					$getcontent = mysql_query("select * from maincontent where slugname='special-event-title'");
					$fetchContent = mysql_fetch_assoc($getcontent);
					echo $fetchContent['message'];
					?>
			</div>
			<div class="span4 aliexpress-ads">
				<script>
        (function(){
            var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
            var containerId = 'container-' + uuid;
            var scriptId = 'script-' + uuid;
            document.write('<a style="display:none!important" id="' + containerId + '"></a>');

            var args = {
                wid: '2000000059288',
                digestAdId: '2000000059288_-1018514828',
                shortKey: '7a89mfnu',
                size: '300x250',
                containerId: containerId,
                custom: {}
            };

            if (window.JSCODE_AD_SHOW) {
                window.JSCODE_AD_SHOW(args);
            } else {
                window.JSCODE_AD_ONLOAD = window.JSCODE_AD_ONLOAD || [];
                window.JSCODE_AD_ONLOAD.push(args);
                if (!document.getElementById(scriptId)) {
                    var s = document.createElement("script"),
                        h = document.getElementsByTagName("head")[0];
                    s.id = scriptId;
                    s.charset = "utf-8";
                    s.async = !0;
                    s.src = "//i.alicdn.com/sc-affiliate/jscode/lib/index.js?v=" + Math.floor(Date.now() / Math.pow(10, 6));
                    h.insertBefore(s, h.firstChild);
                }
            }
        })();
    </script>
    

				<!--
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					
					<ins class="adsbygoogle"
						 data-ad-client="ca-pub-3914601175484330"
						 data-ad-slot="7806497606"></ins>
					
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
				-->
			</div>
		</div>
		<div class="row">
		
			<div class="span4">
				
				<div class="row">
					<div class="span4">
						<div id="accordion2" class="accordion max-size1">
				
						<?php
								
								$count = 1;
								$upcomingquery = mysql_query("SELECT e.* FROM tbl_events as e join bars_list as b on e.bar_id=b.id join user_register as u on u.id=b.Owner_id WHERE e.eventtype = 'upcoming' AND event_end > CURDATE( ) order by e.id DESC");
								$countRow = mysql_num_rows($upcomingquery);
								/* if($countRow>0)
								{ */	
									while($upcomingrow = mysql_fetch_array($upcomingquery)){
								
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
												<?php 
													if($upcomingrow['event_description']=="")
													{
														echo "Contents not available.";
													}
													else
													{
														echo $upcomingrow['event_description']; 	
													}		
												?>
											</div>
										</div>
									</div>
						
								<?php
									$count++;
									} 
								/* }	
								else
								{
									echo "No upcoming events for now.";
								} */
								?>
						
						</div>
					</div>
				</div>
				

			</div>
			
			<div class="span8">
				
				<div class="row">
				<?php 

				$query = "SELECT e.*,g.file_path FROM tbl_events AS e  LEFT JOIN tbl_event_gallery AS g ON e.id = g.event_id AND g.logo_image =  '1' join bars_list as b on e.bar_id=b.id join user_register as u on u.id=b.Owner_id WHERE eventtype =  'special' AND event_end > CURDATE( )";
				$sel_banner_query= mysql_query($query); 
				while($fetch_banner=mysql_fetch_array($sel_banner_query))
				{
					/* echo "<pre>";
					print_r($fetch_banner); */
					$_SESSION['event_id'] =$fetch_banner['id'];
					$path = ($fetch_banner['file_path'])?"/business_owner/".$fetch_banner['file_path']:"/images/no_image.png";
				?>
					
					<div class="span8 event-list">
						<a href="eventsdetail.php?event_id=<?php echo $fetch_banner['id'];?>"><img src="<?php echo SITE_PATH.$path;?>" alt="list of events by nightclubs in London"  border="0" class="alignleft" width = "170px" height="192px"/></a>
						<p class="font-color-white">
							<a href="eventsdetail.php?event_id=<?php echo $fetch_banner['id'];?>" class="text-decoration-none"><strong class="event-title-strong" style="display: inline"><?php echo $fetch_banner['event_name'];?></strong></a>
							<br/>
							<?php echo $fetch_banner['event_description'];?>
						</p>
						<p class="font-color-white">
							<strong class="font-color-white">Event Starts :<?php echo date('m/d/Y',strtotime($fetch_banner['event_start']));?></strong>
							<strong class="font-color-white">Event Ends :<?php echo date('m/d/Y',strtotime($fetch_banner['event_end']));?></strong>
						</p>
						
						<?php
							if($fetch_banner['is_availableForBooking']=="Booked"){
						?>
							<button type="submit" class="btn btn-default bg-pink float-right fully_booked_btn" id="book_event" value="book_event" name="book_event" disabled>Fully Booked</button> 
						<?php
							}
							else
							{
						?>	
							<a href="eventsdetail.php?event_id=<?php echo $fetch_banner['id'];?>" class="btn btn-default bg-pink float-right available_for_book_btn" id="book_event" value="book_event" name="book_event">Available for booking</a>	
						<?php		
							}	
						?>
					</div>  		
				  	
				<?php	
				}
				?>	
				</div>
			</div>  
			
			<div class="padcontent"></div>
			
		</div>  
		<div class="row divider">
		<div class="span12">
				<h2>Top Rating Bars</h2>
			</div>
		<div class="span12">
			<div class="carousel-box">
				<div class="inner span12">
					<?php
						$getBars = mysql_query("select b.*,g.bar_id,g.file_name,g.file_path from bars_list as b  left  outer join tbl_bar_gallary as g on b.id = g.bar_id and g.logo_image = '1' where b.Rating >=2 and b.Owner_id !=0 limit 10");
						$isBarFound = mysql_num_rows($getBars);
					?>
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
								while($getDetails = mysql_fetch_array($getBars))
								{
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
	<br/>
		
	</div>
</section>



	
    <?php include'footer.php'; ?>