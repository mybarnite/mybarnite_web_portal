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
	ORDER BY distance limit 40"; 
	
	#echo date('h:i:s a m/d/Y', strtotime($date));
	
	 //$sql = "select sl.,( 6371  acos(	cos( radians($lat) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 1) ) )  cos( radians( SPLIT_STR(sl.googlegps, ',', 2) ) - radians($lng)) + sin( radians($lat) ) * sin( radians( SPLIT_STR(sl.googlegps, ',', 1) ) ) ) ) AS distance from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = '".$CommBrand."' and sl.listings_id IN (select sl.listings_id from sdc_listings sl,sdc_listings_approvals sla where sla.listings_id = sl.listings_id and sla.approvals_id = 132 and sl.is_active = 1) HAVING distance <= ".$SelectedRadius ."  order by sl.MSRFA desc";
	
	$barlistquery = mysql_query($sql);
	$countbars = mysql_num_rows($exe);
	
		while($row = mysql_fetch_array($barlistquery))
		{ 
			if($row['Business_Name']!="")
			{	
	?>
			
			<br>
			<a class="barlist" href="bardetail.php?barid=<?php echo $row['id'] ?>" >
				<?php echo $row['Business_Name'] ?>
			</a>
			
		<?php
			}	
		}
		?>