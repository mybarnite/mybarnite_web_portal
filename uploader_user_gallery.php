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

if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
{
	$file_name		= strip_tags($_FILES['upload_file']['name']);
	$file_id 		= strip_tags($_POST['upload_file_ids']);
	$file_size 		= $_FILES['upload_file']['size'];
	$files_path		= 'user_gallery/';
	$file_type		= strtolower(pathinfo($_FILES['upload_file']['name'],PATHINFO_EXTENSION));
	$file_location 		= $files_path . $file_name;
	
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $file_location)){
		$db->insert('tbl_user_gallery',array('user_id'=>$_SESSION['id'],'file_name'=>$file_name,'file_path'=>$file_location,'status'=>1,'logo_image'=>0));  // Table name, column names and respective values'file_path'=>$file_location,
	}else{
		echo 'system_error';
	}
	
	
}
?>