<?php  ?><?php


$new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=103.254.202.196'));
echo "Latitude:".$new_arr[0]['geoplugin_latitude']." and Longitude:".$new_arr[0]['geoplugin_longitude'];


?>