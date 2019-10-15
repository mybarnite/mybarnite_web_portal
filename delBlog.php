<?php

session_start();
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('admin/includes/config.cfg');
include(ROOT_PATH.'business_owner/class/business_owner.php');
include(ROOT_PATH.'business_owner/class/form.php');
include(ROOT_PATH.'admin/includes/funcs_lib.inc.php');
$db = new business_owner();
$db->connect();

$id = $_POST['id'];

$db->select('tbl_manage_blogs','image_name',NULL,'id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$image = $db->getResult();
$name = $image[0]['file_name'];


$db->delete('tbl_manage_blogs','id='.$id);  // Table name, WHERE conditions
$res = $db->getResult();  
unlink(ROOT_PATH. "/images/$name");


?>