<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

 
		  $detailid = $_GET['barid'];
		 
			$bardetailquery = mysql_query(" SELECT * FROM bars_list WHERE id='".$detailid."' ") or die(mysql_error());
			$bardetailrow = mysql_fetch_array($bardetailquery);
			//echo $bardetailrow['Location_Searched'] ;
		  ?>
<?php 	
	require_once('geoplugin.class/geoplugin.class.php');

$geoplugin = new geoPlugin();

/* 
Notes:

The default base currency is USD (see http://www.geoplugin.com/webservices:currency ).
You can change this before the call to geoPlugin::locate with eg:
$geoplugin->currency = 'EUR';

The default IP to lookup is $_SERVER['REMOTE_ADDR']
You can lookup a specific IP address, by entering the IP in the call to geoPlugin::locate
eg
$geoplugin->locate('209.85.171.100');

*/

//locate the IP
$geoplugin->locate();

//echo "Geolocation results for {$geoplugin->ip}: <br />\n".
	//"City: {$geoplugin->city} <br />\n".
	//"Region: {$geoplugin->region} <br />\n".
	//"Area Code: {$geoplugin->areaCode} <br />\n".
	//"DMA Code: {$geoplugin->dmaCode} <br />\n".
	//"Country Name: {$geoplugin->countryName} <br />\n".
	//"Country Code: {$geoplugin->countryCode} <br />\n".
	//"Longitude: {$geoplugin->longitude} <br />\n".
	//"Latitude: {$geoplugin->latitude} <br />\n".
	//"Currency Code: {$geoplugin->currencyCode} <br />\n".
	//"Currency Symbol: {$geoplugin->currencySymbol} <br />\n".
	//"Exchange Rate: {$geoplugin->currencyConverter} <br />\n";

/*
How to use the in-built currency converter
geoPlugin::convert accepts 3 parameters
$amount - amount to convert (required)
$float - the number of decimal places to round to (default: 2)
$symbol - whether to display the geolocated currency symbol in the output (default: true)
/
if ( $geoplugin->currency != $geoplugin->currencyCode ) {
	//our visitor is not using the same currency as the base currency
	echo "<p>At todays rate, US$100 will cost you " . $geoplugin->convert(100) ." </p>\n";
}

/* Finding places nearby 
nearby($radius, $maxresults)
$radius (optional: default 10)
$maxresults (optional: default 5)

$nearby = $geoplugin->nearby();

if ( isset($nearby[0]['geoplugin_place']) ) {

	echo "<pre><p>Some places you may wish to visit near " . $geoplugin->city . ": </p>\n";

	foreach ( $nearby as $key => $array ) {
		
		echo ($key + 1) .":<br />";
		echo "\t Place: " . $array['geoplugin_place'] . "<br />";
		echo "\t Region: " . $array['geoplugin_region'] . "<br />";
		echo "\t Latitude: " . $array['geoplugin_latitude'] . "<br />";
		echo "\t Longitude: " . $array['geoplugin_longitude'] . "<br />";
	}
	echo "</pre>\n";
}
 */
?>


<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
		<title></title>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<style type="text/css">
			#map_canvas { 
				height: 100%;
			}
		</style>
		
		
		
		
		<script type="text/javascript">
		
		
		
		window.onload = function() {
			var start = document.getElementById("start").value;
			var end = document.getElementById("end").value;
			var distanceInput = document.getElementById("distance");
			
			var request = {
				origin:start, 
				destination:end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
					distanceInput.value = response.routes[0].legs[0].distance.value / 1000;
				}
			});
		};
		
		</script>
		
		
		
		
		
		
		<script type="text/javascript">
		var directionDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;
		
		function initialize() {
			directionsDisplay = new google.maps.DirectionsRenderer();
			var melbourne = new google.maps.LatLng(-37.813187, 144.96298);
			var myOptions = {
				zoom:12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: melbourne
			}

			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			directionsDisplay.setMap(map);
		}

		
		
		

		
		
		</script>
	</head>
	<body onload="initialize()">
	<div>
			<p>
				<!--label for="start">Start: </label-->
				<input type="hidden" name="start"   value="<?php echo "{$geoplugin->city}"; ?>"  id="start" />
				
				<!--label for="end">End: </label-->
				<input type="hidden" name="end"   value="<?php echo $bardetailrow['Location_Searched'] ;?>" id="end" />
				
				<!--input type="submit" value="Calculate Route"  onload="calcRoute()"> onclick="calcRoute()" /-->
				<!--input type="submit" value="Calculate Route"  onload="calcRoute()"/-->  
			</p>
			<p>
				<!--label for="distance">Distance (km): </label-->
				<input type="hidden" name="distance" id="distance" readonly="true" />
			</p>
		</div>
	
	</body>
		<div id="map_canvas"></div>
	</body>
	
	
	
</html>