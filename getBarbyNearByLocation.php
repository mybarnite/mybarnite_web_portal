<?php


session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

//$latitude = $_POST['latitude'];
//$longitude = $_POST['longitude'];

$latitude= "51.4859582";
$longitude= "-0.1849112";

$sql = "SELECT *,
		( 6371 * acos(
		cos(radians(".$latitude.")) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(".$longitude.")) +
		sin(radians(".$latitude.")) * sin(radians(Latitude))
		) ) AS distance
	FROM bars_list
	HAVING distance < 100
	ORDER BY distance limit 10"; 
	
	#echo date('h:i:s a m/d/Y', strtotime($date));
	
	 //$sql = "select sl.,( 6371  acos(	cos( radians($lat) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 1) ) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 2) ) - radians($lng)) + sin( radians($lat) ) * sin( radians( SPLIT_STR(sl.googlegps, ',', 1) ) ) ) ) AS distance from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = '".$CommBrand."' and sl.listings_id IN (select sl.listings_id from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = 132 and sl.is_active = 1) HAVING distance <= ".$SelectedRadius ."  order by sl.MSRFA desc";
	
	$slider2query = mysql_query($sql);
	$countbars = mysql_num_rows($slider2query);
	
	if($countbars>0)
	{
		?>
		<div class="inner span12">
			<?php if($countbars>4){?>
			<a class="prev"></a>
			<a class="next"></a>
			<?php }?>
			<div class="carousel main" >
				<ul>
				
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
									<img src="business_owner/<?php echo $logoImage['file_path'];?>" alt="<?php echo $logoImage['file_name'];?>"  border="0" />
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
	<?php	
	}
	else
	{
?>
		<li>Records not found</li>
		
<?php		
	}		
?>
	