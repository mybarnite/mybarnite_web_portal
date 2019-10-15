<?php

session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$barid = $_POST['barid'];
$sql = "select b.id,b.Latitude,b.Longitude from bars_list as b where b.id = ".$barid;
$slider2query = mysql_query($sql);
$slider2row = mysql_fetch_assoc($slider2query);
#echo $latitude.",".$longitude."-".$slider2row['Latitude'].",".$slider2row['Longitude'];

$point1 = array("lat" => $latitude, "long" => $longitude); // Paris (France)
$point2 = array("lat" => $slider2row['Latitude'], "long" => $slider2row['Longitude']); // Mexico City (Mexico)

$mi = 'Distance (miles) : <span style="color:#9393a7">'.distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'mi').'</span>';
echo (!empty($mi))?$mi:"-";
?>