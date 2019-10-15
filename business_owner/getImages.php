<?php
include('common.php');
$bar_id = $_POST['bar_id'];
if(!empty($bar_id))
{

	$db->select('tbl_bar_gallary','*',NULL,'bar_id='.$bar_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$images = $db->getResult();
	$content ="";
	foreach($images as $image)
	{

		$file_path = "business_owner/".$image['file_path'];
		$id= $image['id'];
		$caption = ($image['logo_image'] == 1 ? "DESELECT LOGO" : "MAKE LOGO"); 
		$content .= "
				<figure class='threecol first gallery-item'>
					<img src='".SITE_PATH.$file_path."'>
					<figcaption class='img-title'>
						<h5>
							<a href='javascript:void(0);' onclick='delete_image(".$id.");'>DELETE</a> | 
							<a href='javascript:void(0);' onclick='logo_image(".$id.");'>".$caption."</a>
						</h5>  
					</figcaption>
				</figure>

		";

	}	

}	
echo $content;
?>