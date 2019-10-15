<?php

include('common.php');

$id = $_POST['img_id'];
$status = $_POST['status'];
$event_id = $_POST['event_id'];
if(!empty($id))
{
	if($_POST['user']=="Owner")
	{
		@$bar_id = $_SESSION['bar_id'];
		if($status==1)
		{
			$sql = "UPDATE tbl_event_gallery SET logo_image = '0' WHERE id = ".$id." and bar_id = ".$bar_id." and event_id=".$event_id;
		}
		else
		{
			$sql = "UPDATE tbl_event_gallery SET logo_image = (case when id = ".$id." then  '1' else '0' end)	WHERE  bar_id = ".$bar_id." and event_id=".$event_id;	
		}		
		
		mysqli_query($db->myconn,$sql); 
		$db->select('tbl_event_gallery','*',NULL,'bar_id='.$bar_id.' and event_id='.$event_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$images = $db->getResult();
		$content ="";
		foreach($images as $image)
		{
			$file_path = "business_owner/".$image['file_path'];
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
		echo $content;
	}	
	else if($_POST['user']=="Admin")
	{
		if($status==1)
		{
			$sql = "UPDATE tbl_event_gallery SET logo_image = '0' WHERE id = ".$id." and event_id=".$event_id;
		}
		else
		{
			$sql = "UPDATE tbl_event_gallery SET logo_image = (case when id = ".$id." then  '1' else '0' end)	WHERE  event_id=".$event_id;	
		}		
		
		mysqli_query($db->myconn,$sql); 
		$db->select('tbl_event_gallery','*',NULL,'event_id='.$event_id,'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$images = $db->getResult();
	}
		
}	



?>
