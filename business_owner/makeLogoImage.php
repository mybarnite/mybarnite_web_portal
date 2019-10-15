<?php

include('common.php');

$id = $_POST['img_id'];
$status = $_POST['status'];
$bar_id = $_SESSION['bar_id'];
if(!empty($id))
{
	
	if($status==1)
	{
		$sql = "UPDATE tbl_bar_gallary SET logo_image = '0' WHERE id = ".$id." and bar_id = ".$bar_id;
	}
	else
	{
		$sql = "UPDATE tbl_bar_gallary SET logo_image = (case when id = ".$id." then  '1' else '0' end)	WHERE  bar_id = ".$bar_id;	
	}		
	
	mysqli_query($db->myconn,$sql); 
	$db->select('tbl_bar_gallary','*',NULL,'bar_id=155','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$images = $db->getResult();
	$content ="";
	foreach($images as $image)
	{
		$file_path = "business_owner/".$image['file_path'];
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