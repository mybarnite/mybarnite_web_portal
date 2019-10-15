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

$id = $_POST['img_id'];

$db->select('tbl_user_gallery','file_name',NULL,'id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$image = $db->getResult();
$name = $image[0]['file_name'];


$db->delete('tbl_user_gallery','id='.$id);  // Table name, WHERE conditions
$res = $db->getResult();  
unlink(ROOT_PATH. "/user_gallery/$name");

/* $db->select('tbl_user_gallery','*',NULL,'user_id='.$_SESSION['id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$images = $db->getResult();
$content ="";
foreach($images as $image)
{
	$file_path = $image['file_path'];
	$id= $image['id'];
	$caption = ($image['logo_image'] == 1 ? "DESELECT LOGO" : "MAKE LOGO"); 
	$content .= "
			<figure class='threecol first gallery-item'>
				<img src='".SITE_PATH.$file_path."'>
				<figcaption class='img-title'>
					<h5>
						<a href='javascript:void(0);' onclick='delete_image(".$id.");'>DELETE</a>
						
					</h5>  
				</figcaption>
				
			</figure>
	";
}	
echo $content; */
?>