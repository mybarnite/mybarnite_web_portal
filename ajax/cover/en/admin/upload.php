<?php
include("../includes/config.php");
if (!empty($_FILES)) 
{

	if(!empty($_FILES['file']['name']))
	{
		$tmp_name = $_FILES["file"]["tmp_name"];
		$file_name =$_FILES["file"]["name"];
		 $id=$_POST['req_id'];
		$upload_image ='../upload/product/';
				$upload_img = resize_crop_image(100, 100, $tmp_name,$file_name, '../upload/product/thumb/');

		move_uploaded_file($_FILES['file']['tmp_name'],$upload_image.$_FILES['file']['name']);
		
		
		echo $sql="INSERT INTO product_img(product_id,image_path,image_name, crop_path,crop_name) VALUES ('$id','../upload/product/','$file_name','../upload/product/thumb/','$upload_img')";
		mysql_query($sql);
	}
    
}
//
function resize_crop_image($max_width, $max_height, $source_file, $file_name, $dst_dir, $quality = 80){
	
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
	 $crop_image ='';
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
			$crop_image   = time().$file_name.".gif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
			$crop_image   = time().$file_name.".png";

            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
			$crop_image   = time().$file_name.".jpeg";

            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
     
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
     
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
         			$dst_dir   = $dst_dir.$crop_image;


    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
	
	return $dst_dir;
}
//usage example
//

?>  
