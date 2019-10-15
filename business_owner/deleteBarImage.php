<?php

include('common.php');

$id = $_POST['img_id'];

$db->select('tbl_bar_gallary','file_name',NULL,'id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$image = $db->getResult();
$name = $image[0]['file_name'];


$db->delete('tbl_bar_gallary','id='.$id);  // Table name, WHERE conditions
$res = $db->getResult();  

unlink(ROOT_PATH. "/business_owner/uploaded_files/$name");

/* if(!empty($res))
{
	$content = "<ul>";
	$db->select('tbl_bar_gallary','*',NULL,'bar_id=155','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$images = $db->getResult();
	foreach($images as $image)
	{
		$file_path = "business_owner/".$image['file_path'];

		$content .="<li>
						<a class='grow' href='javascript:void(0);' onclick='delete_image(".$image['id'].");'>
							<img src='".SITE_PATH.$file_path."' width='310' height='200' />
							<div class='hover-content'><i class='fa fa-trash-o'></i></div>
						</a>
					</li>";
	

	
	}
	$content .= "</ul>";
}	
echo $content;		
 */

?>