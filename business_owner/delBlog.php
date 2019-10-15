<?php

include('common.php');
$id = $_POST['id'];

$db->select('tbl_manage_blogs','image_name',NULL,'id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$image = $db->getResult();
$name = $image[0]['file_name'];


$db->delete('tbl_manage_blogs','id='.$id);  // Table name, WHERE conditions
$res = $db->getResult();  
unlink(ROOT_PATH. "/images/$name");


?>