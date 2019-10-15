<?php

session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();

$detailid = $_GET['event_id'];
$sql = "SELECT g.file_name,g.file_path,g.event_id,g.logo_image,e.*, p.*,b.Business_name, b.Location_Searched, b.Zipcode FROM tbl_events as e left join bars_list as b on e.bar_id=b.id left join tbl_event_gallery as g on e.id=g.event_id and g.logo_image='1' left join tbl_promotions as p on p.eventId=e.id and p.status='Active'  WHERE e.id=".$detailid;
$exe = mysql_query($sql) or die(mysql_error());
$get_event_details = mysql_fetch_assoc($exe);
//echo "sss";
?>
<?php include'head.php'; ?>
<title>Event - <?php echo $get_event_details['event_name'] ?> | MyBarnite</title>
<meta name="keywords" content="Nightclubs, Pubs, Bars, Nightclubs near me, Pubs near me, Bars near me, Bar Events near me, Events near me">
<meta name="description" content="View event details and booking information">
<meta property="og:site_name" content="<?php echo $site_name;?>">
		<meta property="og:url" content="<?php echo "$myMbSiteUrl?$mbSitequeryString";?>">  
		<meta property="og:type" content="website"> 
		
		<meta property="og:title" content="<?php echo $title;?>">
		<meta property="og:description" content="<?php echo $description;?>">
		<?php /*<meta property="og:image" content="<?php echo "$myUrl/business_owner/".$image;?>">*/?>
		<meta property="og:image" content="https://mybarnite.com/images/barlogo.png">
		
		<meta property="fb:app_id" content="579821348728041">
		<meta property="fb:admins" content="579622216,709634581">

<?php include'header.php'; ?>
<!--==============================Map=================================--> 


</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
         <div class="row clearfix ">
        
		
		  
			
		 					
						<div class="span4">
							<div class="row" style="color:#fff;margin-left:0px;">
								<?php
								$path = "business_owner/".$get_event_details['file_path'];
								if($get_event_details['file_path']!=""&&file_exists($path)) {
								?>
								
									<img src="<?php echo "business_owner/".$get_event_details['file_path'];?>" alt="<?php echo $get_event_details['file_name'];?>" height="460" width="460"/>
								
								<?php
								}
								else
								{
								?>
									<img src="images/no_image.png" alt="no image" height="460" width="460"/>
								<?php
								}
								?>
								
							</div>
							<br/>
							<div class="row align-center" style="color:#fff;margin-left:0px;">
								<a href="menu.php?id=<?php echo $get_event_details['bar_id'];?>" value="order" class="pink" style="font-size: 16px;
				text-decoration: none;"><i class="fa fa-bars" aria-hidden="true"></i> Menu</a>&nbsp;&nbsp;&nbsp;
							
							</div>
						</div>
						<div class="span5">
							<h1 style="color:#ff1da5;">Event Detail </h1> 
							<div id="note"></div>
							<div id="fields" class="contact-form">
								<form id="ajax-contact-form" action="event_booking.php" method="post" class="form-horizontal">
					
									<input type="hidden"  name="event_id" id="event_id" class="form-control" value="<?php echo $detailid;?>">	
									
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Event Name: <span style="color:#9393a7;"><?php echo $get_event_details['event_name'] ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Description: <span style="color:#9393a7;"><?php echo $get_event_details['event_description'] ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Bar Name: <span style="color:#9393a7;"><?php echo $get_event_details['Business_name'] ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Location: <span style="color:#9393a7;"><?php echo $get_event_details['Location_Searched'] ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Post code: <span style="color:#9393a7;"><?php echo $get_event_details['Zipcode'] ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Event Date: <?php if($get_event_details['event_start']!=""&&$get_event_details['event_end']!=""){?><span style="color:#9393a7;">From <?php echo date("m/d/Y",strtotime($get_event_details['event_start'])); ?> To <?php echo date("m/d/Y",strtotime($get_event_details['event_end'])); ?></span><?php }?></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Timings:  <?php if($get_event_details['start_time']!=""&&$get_event_details['end_time']!=""){?> <span style="color:#9393a7;">From <?php echo $get_event_details['start_time'] ?> To <?php echo $get_event_details['end_time'] ?></span><?php }?></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Free entry: <span style="color:#9393a7;"><?php echo ($get_event_details['free_event']=='1')?'Yes':'No'; ?></span></label>
									</div>
									<?php if($get_event_details['free_event']!='1'){?>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Entry Fee (Basic): <span style="color:#9393a7;">£<?php echo ($get_event_details['event_price_basic'])?number_format($get_event_details['event_price_basic'],2):'0.00'; ?></span></label>
									</div>
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Entry Fee (VIP): <span style="color:#9393a7;">£<?php echo ($get_event_details['event_price_vip'])?number_format($get_event_details['event_price_vip'],2):'0.00'; ?></span></label>
									</div>
									<?php }?>
									
									<div class="control-group">
										<label  style="font-size:16px;color:#ff1da5" for="inputName">Cancellation policy: <span style="color:#9393a7;"><?php echo ($get_event_details['cancellation_policy']==1)?"Free Cancellation":"Cancellation Policy"; ?></span> <a style="text-decoration:none;" href="<?php if($get_event_details['cancellation_policy']==1){?>free-cancellation.php<?php }else{?>cancellation-policy.php<?php }?> ">(Read more...)</a></label>
									</div>
						
									<?php
									if( (!isset($_SESSION['username'])) && (!isset($_SESSION['memberusername']))&& (!isset($_SESSION['FULLNAME']))  ) 
									{
										if($get_event_details['is_availableForBooking']=="Booked"){
									?>
										<button type="submit" value="book_event" name="book_event" class="btn btn-default bg-pink" disabled>FULLY BOOKED</button> 
									<?php	
											
										}else{
											$_SESSION['eventToBeBooked'] = $_GET['event_id'];
									?>
										<a href="usersignin.php">	
											<button type="button" name="bookbar" class="btn btn-default btn-color">LOGIN TO BOOK</button> 
										</a>
									<?php 
										}
									}
									else
									{ 
										
									?>
									
									<?php
										if($get_event_details['is_availableForBooking']=="Available"){
									?>
										<a href="event_booking.php">	
											<button type="submit" value="book_event" name="book_event" class="btn btn-primary btn-color" style="font-size: 14px;"><i class="fa fa-check-square" aria-hidden="true"></i> BOOK EVENT</button> 
										</a>
										
									<?php
										}else{
									?>
										
										<button type="submit" value="book_event" name="book_event" class="btn btn-primary bg-pink" style="font-size: 14px;" disabled>FULLY BOOKED</button> 
									<?php
										}
									}
									?>
									<div class="media-share pull-right" style="padding: 10px;">
										
										<div class="facebookDiv pull-left">
											<div class="fb-share-button" data-href="<?php echo "$myMbSiteUrl?$mbSitequeryString";?>" data-layout="button_count"></div>
										</div>
										<div class="twitterDiv pull-left" style="padding-left: 15px;padding-right: 15px;">
										   <script id="twitter-wjs" type="text/javascript" async defer src="//platform.twitter.com/widgets.js"></script>
										   <a href="https://twitter.com/share" class="twitter-share-button" data-via="mybarnite" data-related="mybarnite" >Tweet</a>
										</div>
										<script src="https://apis.google.com/js/platform.js" async defer></script>
										<div class="googlePlusDiv pull-left">
										   <g:plusone size="medium"></g:plusone>
										</div>
									</div>
									
									
								</form>
								<br/>
								<br/>
							</div> 
						</div>
						
						<?php
						if($get_event_details['is_availableForBooking']=="Available"){
							if($get_event_details['status']=="Active"){	
								$currentDate = strtotime(date("Y-m-d"));
								$startDate = strtotime($get_event_details['startsat']. " -1 day");
								$endDate = strtotime($get_event_details['endsat']. " +1 day");
								/* if(($currentDate>$startDate)&&($currentDate<$endDate))
								{ */	
								if($get_event_details['discount']!="")
								{	
							
							?>
								<div class="span3">
									<center>
										<div class="price-container">
											<div class="price">
												<span class="number"><?php echo $get_event_details['discount'];?>% off</span>
												<span class="label">from :</span>
												<span class="label"><?php echo date('M d,Y',strtotime($get_event_details['startsat']));?></span>
												<span class="label">To</span>
												<span class="label"><?php echo date('M d,Y',strtotime($get_event_details['endsat']));?></span>
											</div>
											
										</div>
										<div class="pink" style="margin-top: 26px;font-weight: bold;font-size: 15px;">
									<center>COUPON CODE	:	<?php echo $get_event_details['couponcode']?></center>
								</div>	
									</center>	
								</div>	
								
								
								<?php 
								}
								/* } */
							}
						}	?>
							<?php /*
							<div class="span12">
								<div class="carousel-box">
									<div class="inner span12">
										<a class="prev"></a>
										<a class="next"></a>
										<div class="carousel main" >
											<ul >
											
											<?php
												$slider2query = mysql_query("SELECT * FROM slider_images_2 ");
												while($slider2row = mysql_fetch_array($slider2query))
												{
												
											?>
											
												<li>
													<a href="bardetail.php?barid=<?php echo $slider2row['id']; ?>">
														<img src="adminimages/slider2/<?php echo $slider2row['banner_image'];?>" alt="<?php echo $slider2row['banner_image'];?>"  border="0" />
														<div>
															<h4><?php echo $slider2row['heading'];?></h4>
															<p>
																<?php echo $slider2row['desc'];?>
															</p>
														</div>
													</a>
												</li>
												
											<?php 
												} 
											?>
											</ul>
										</div>	
									</div>
								</div>
							</div>
						*/?>
		<?php /*
		<div class="span12">
			<iframe src="http://mybarnite.com/mile_map.php?barid=<?php echo $detailid; ?>" width="1160" height="500" scrolling="no" marginheight="0" marginwidth="0" frameborder="0" name="infosniper_gadget_ip2city"></iframe>
		</div>
		*/?>
    </div>
	<br><br><br>
  </div>
  
</section>

<?php include'footer.php'; ?>