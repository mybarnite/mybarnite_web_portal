<?php

include('common.php');

$id = $_POST['img_id'];
$event_id = $_POST['event_id'];
//$currentPage = $_POST['currentPage'];

$db->select('tbl_event_gallery','file_name',NULL,'bar_id='.$_SESSION['bar_id'].' and id='.$id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$image = $db->getResult();
$name = $image[0]['file_name'];


$db->delete('tbl_event_gallery','id='.$id);  // Table name, WHERE conditions
$res = $db->getResult();  

unlink(ROOT_PATH. "/business_owner/uploaded_files/$name");
	
	$db->select('tbl_event_gallery','*',NULL,'event_id='.$_POST['event_id'].' and bar_id='.$_SESSION['bar_id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$images = $db->getResult();
	$content="";
	foreach($images as $image)
	{
		$file_path = "uploaded_files/".$image['file_name'];
		$caption = ($image['logo_image'] == 1 ? "REMOVE LOGO" : "MAKE LOGO"); 
		if (file_exists($image['file_path'])) 
		{
		$content .= "
				<li>
					<a accordion-toggle href='javascript:void(0);'>
						<img src='".$image['file_path']."' width='150' height='150' />";
						if($image['logo_image'] == 1)
						{
		$content .=		"<div class='cssarrow'><i class='fa fa-check fa-2x' style='position: absolute;top: 1px;right: -47px;color: white;' aria-hidden='true'></i></div>";
						}
		$content .=		"<span class='text-content'>
							<span onclick='delete_event_image(".$image['id'].",".$_POST['event_id'].");'><i class='fa fa-trash-o fa-3x' aria-hidden='true'></i></span>
							<span onclick='event_logo_image(".$image['id'].",".$image['logo_image'].",".$_POST['event_id'].");'>".$caption."</span>
						</span>
					</a>
				</li>
		";
		}
	
	}
	echo $content ;

?>