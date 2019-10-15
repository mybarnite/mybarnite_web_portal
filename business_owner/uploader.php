<?php
include('common.php');
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
{
	$file_name		= strip_tags($_FILES['upload_file']['name']);
	$file_id 		= strip_tags($_POST['upload_file_ids']);
	$file_size 		= $_FILES['upload_file']['size'];
	$file_type		= strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$files_path		= 'uploaded_files/';
	$file_location 	= $files_path . $file_name;
	
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $file_location)){
		$db->insert('tbl_bar_gallary',array('bar_id'=>$_SESSION['bar_id'],'file_name'=>$file_name,'file_path'=>$file_location,'status'=>1));  // Table name, column names and respective values
	}else{
		echo 'system_error';
	}
	
	
}
?>