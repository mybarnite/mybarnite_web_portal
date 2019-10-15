<?php
session_start();

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$_SESSION['latitude']= $latitude;
$_SESSION['longitude']= $longitude;
//$_SESSION['latitude']= "51.4859582";
//$_SESSION['longitude']= "-0.1849112";
?>