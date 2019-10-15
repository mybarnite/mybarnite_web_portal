<?php


session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$sql = "SELECT *,
		( 6371 * acos(
		cos(radians(".$latitude.")) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(".$longitude.")) +
		sin(radians(".$latitude.")) * sin(radians(Latitude))
		) ) AS distance
	FROM bars_list
	HAVING distance < 100
	ORDER BY distance limit 15"; 
	
	#echo date('h:i:s a m/d/Y', strtotime($date));
	
	 //$sql = "select sl.,( 6371  acos(	cos( radians($lat) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 1) ) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 2) ) - radians($lng)) + sin( radians($lat) ) * sin( radians( SPLIT_STR(sl.googlegps, ',', 1) ) ) ) ) AS distance from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = '".$CommBrand."' and sl.listings_id IN (select sl.listings_id from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = 132 and sl.is_active = 1) HAVING distance <= ".$SelectedRadius ."  order by sl.MSRFA desc";
	
	$slider2query = mysql_query($sql);
	$countbars = mysql_num_rows($slider2query);
	if($countbars>0)
	{
		?>
				
				<?php
				
				
					while($slider2row = mysql_fetch_assoc($slider2query))
					{
						$get_image = "select file_path,file_name,logo_image from tbl_bar_gallary where bar_id=".$slider2row['id']." and logo_image='1'";
						$execute_query = mysql_query($get_image);
						$logoImage = mysql_fetch_assoc($execute_query);
						if($slider2row['Business_Name']!="")
						{	
				?>
							<div class="span3">
								
									<?php
									if (isset($logoImage['file_path'])&&file_exists("business_owner/".$logoImage['file_path'])) 
									{
									?>
									<img src="business_owner/<?php echo $logoImage['file_path'];?>" alt="Bars and pubs near you"  border="0" class="image-resize" />
									<?php 
									}
									else
									{
									?>	
									<img src="images/no_image.png" alt="Bars and pubs near you"  border="0" class="no-image-resize"/>	
									<?php	
									}	
									?>
										<h3  style="color:#fff;font-size:14px;word-break: break-all;width: 10em;"><?php echo (!empty($slider2row['Business_Name']))? $slider2row['Business_Name']:"Mybarnite"; ?></h3>
										<p>
											Rating <?php echo $slider2row['Rating'] ?>
										</p>
										<a href="bardetail.php?barid=<?php echo $slider2row['id'] ?>"> <button type="button" class="btn btn-default btn-color" style="float:right;margin-top:-60px;">Detail</button> </a>
							
							</div>
					<?php 
					
						} 
					}	
				?>
					
					
					
				
	<?php	
	}
	else
	{
?>
		<div class="span4 offset2"><div class="alert alert-danger" style="text-align: center;">Records not found</div></div>
		
<?php		
	}		
?>