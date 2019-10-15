<?php
include('template-parts/header.php'); 

?>

<?php
$db->select('tbl_manage_blogs','*',NULL,'id='.@$_REQUEST['id'],'id DESC');
$fetch_blog = $db->getResult();
//echo "<pre>";
//print_r($fetch_blog);

 if(isset($_POST['addnew']))
{
	#echo "<pre>";
	#print_r($_POST);
	#exit;
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$created_at = date("Y-m-d H:i:s");
	$status = 'Inactive';
	$excerpt = $_POST['excerpt'];
	$author_id = $_SESSION['business_owner_id'];
	
	global $flag;
	$valid_formats = array("png","gif","jpeg","jpg");
	$path = "../images/"; // Upload directory
	$count = 0;
	$new_filename = $_FILES['file']['name'];	
	if(!empty($_FILES['file']['name']))
	{
		if( ! in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $valid_formats) ){
			$_SESSION['errmsg']="<div class='alert alert-danger'>File format is invalid.</div>";
			$flag=1;
			 // Skip invalid file formats
		}
		else
		{ // No error found! Move uploaded files 
			if($flag!=1)
			{
				$new_filename = time().$_FILES['file']['name'];
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $path.$new_filename))
				{
					echo $file_path = '../images/'.$new_filename;
					//$sql = 'INSERT INTO tbl_manage_blogs (title, author_id, created_at, excerpt, content, image_name, image_path, status) VALUES ("'.$title.'",'.$author_id.',"'.$created_at.'","'.$excerpt.'","'.$content.'","'.$new_filename.'","'.$file_path.'","'.$status.'")';
					
					$db->insert('tbl_manage_blogs',array('title'=>$title,'author_id'=>$author_id,'created_at'=>$created_at,'excerpt'=>$excerpt,'content'=>$content,'image_name'=>$new_filename,'image_path'=>$file_path,'status'=>$status));  // Table name, column names and respective values
					$res1 = $db->getResult();  
					if($res1!="")
					{
						$flag = 0;
						$_SESSION['errmsg']="<div class='alert alert-success'>Data has been added successfully.</div>";
					}
					
					//$flag = 0;
					
					
				}	
				else
				{
					$flag = 1;
					$_SESSION['errmsg']="<div class='alert alert-danger'>There is some issue with file uploading.</div>";
				
				}	
			}	
			
			
		}
	}
	else
	{
		//$sql = 'INSERT INTO tbl_manage_blogs (title, author_id, created_at, excerpt, content, status) VALUES ("'.$title.'",'.$author_id.',"'.$created_at.'","'.$excerpt.'","'.$content.'","'.$status.'")';
		$db->insert('tbl_manage_blogs',array('title'=>$title,'author_id'=>$author_id,'created_at'=>$created_at,'excerpt'=>$excerpt,'content'=>$content,'status'=>$status));  // Table name, column names and respective values
		$res1 = $db->getResult();  
		if($res1!="")
		{
			$flag = 0;
			$_SESSION['errmsg']="<div class='alert alert-success'>Data has been added successfully.</div>";
		}
								
	}		
	
	
	//$exe = mysql_query($sql);
	//$_SESSION['errmsg']="<div class='alert alert-success'>Data has been added successfully.</div>";	
}	
if(isset($_POST['update']))
{
	#echo "<pre>";
	#print_r($_POST);
	#exit;
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$created_at = date("Y-m-d H:i:s");
	//$status = $_POST['status'];
	$excerpt = $_POST['excerpt'];
	$author_id = $_SESSION['business_owner_id'];
	
	global $flag;
	$valid_formats = array("png","gif","jpeg","jpg");
	$path = "../images/"; // Upload directory
	$count = 0;
	$new_filename = $_FILES['file']['name'];	
	if(!empty($_FILES['file']['name']))
	{
		if( ! in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $valid_formats) ){
			$_SESSION['errmsg']="<div class='alert alert-danger'>File format is invalid.</div>";
			$flag=1;
			 // Skip invalid file formats
		}
		else
		{ // No error found! Move uploaded files 
			if($flag!=1)
			{
				$new_filename = $_FILES['file']['name'];
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $path.$new_filename))
				{
					$file_path = '../images/'.$new_filename;
					//$sql = 'update tbl_manage_blogs set title = "'.$title.'", author_id = '.$author_id.', created_at = "'.$created_at.'",excerpt="'.$excerpt.'", content = "'.$content.'", image_name = "'.$new_filename.'", image_path = "'.$file_path.'" where id='.$_REQUEST['id'];
					$array = array(
						'title'=>$title,
						'author_id'=>$author_id,
						'created_at'=>$created_at,
						'excerpt'=>$excerpt,
						'content'=>$content,
						'image_name'=>$new_filename,
						'image_path'=>$file_path
					);	
					$db->update('tbl_manage_blogs',$array,'id='.$_REQUEST['id']); // Table name, column names and values, WHERE conditions
					//$res = $db->getResult();
					
					$flag = 0;
					$_SESSION['errmsg']="<div class='alert alert-success'>Data has updated added successfully.</div>";
					
				}	
				else
				{
					$flag = 1;
					$_SESSION['errmsg']="<div class='alert alert-danger'>There is some issue with file uploading.</div>";
				
				}	
			}	
			
			
		}
	}
	else
	{

		$array = array(
			'title'=>$title,
			'author_id'=>$author_id,
			'created_at'=>$created_at,
			'excerpt'=>$excerpt,
			'content'=>$content
			
		);
		//$sql = 'update tbl_manage_blogs set title = "'.$title.'", author_id = '.$author_id.', created_at = "'.$created_at.'",excerpt="'.$excerpt.'", content = "'.$content.'" where id='.$_REQUEST["id"];
		$db->update('tbl_manage_blogs',$array,'id='.$_REQUEST['id']); // Table name, column names and values, WHERE conditions
		//$res = $db->getResult();
								
	}		
	//$sql = "update maincontent set heading='".$title."' , message='".$content."' where id='".$_REQUEST['id']."'";
	$is_res = $db->myconn->affected_rows;	
	if($is_res!=""&&$is_res>0)
	{
		//$_SESSION['errmsg']="<div class='alert alert-success'>Data has been updated successfully</div>";
		header("location:myblogs.php");
	}	
			
	/* if(isset($lastId)&&$lastId>0)
	{
		header("location:blogs.php?msg=true");
	} */	
} 	
?>
<!--==============================Map=================================--> 
<script type="text/javascript" src="../admin/ckeditor/ckeditor.js"></script>
<style>
.add-blog .cke_skin_kama{margin-left:15% !important;}
.add-blog .cke_skin_kama iframe{width:632px !important;}
.add-blog textarea{border-color:white !important;background:white !important;}

</style>
</header>
<div class="padcontent"></div>		
<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
		<div class="row">
			<div class="span12 align-center">
				<h1>Add Blog</h1>
			</div>
		</div>
		<div class="row">
			<div class="span2"></div>
			<div class="span8">
				<div id="fields" class="contact-form add-blog">
					<form id="ajax-contact-form" class="form-horizontal" method="post" enctype="multipart/form-data">
						<?php 
						if(isset($_SESSION['errmsg']))
						{	
						?>
						<div class="control-group">
						<?php echo $_SESSION['errmsg'];unset($_SESSION['errmsg']);?>
						</div>
						<?php
						}	
						?>
						<div class="control-group">
      						<label class="control-label" for="inputName">Title <span style="color:#ff0000;">*</span>:</label>
      						<input type="text" class="form-control"  name="title" id="title" value="<?php if($_GET['id']!="")echo $fetch_blog[0]['title']; ?>"  size="40" required>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Upload image:</label>
      						<input type="file" class="form-control" name="file" id="blog_img" accept="image/*">
							<?php 
							if($_REQUEST['id']!="")
							{
							?>
							<img src="<?php echo $fetch_blog[0]['image_path']; ?>" height="50" width="50"/>
							<?php
							}
							?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Excerpt <span style="color:#ff0000;">*</span>:</label>
      						<textarea name="excerpt" id="excerpt" class="form-control" maxlength="250" required><?php if($_GET['id']!="")echo $fetch_blog[0]['excerpt']; ?></textarea>
      					</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Content:</label>
      						<textarea name="content" id="content" class="content form-control" ><?php if($_GET['id']!="")echo $fetch_blog[0]['content']; ?></textarea>
      					</div>
						<?php 
						if($_REQUEST['id']!="")
						{
						?>	
							<input name="update" id="update" type="submit" value="SAVE CHANGES" class="btn submit btn-primary ">	
						<?php	
						}else{		
						?>
							<input name="addnew" id="addnew" type="submit" value="ADD NEW" class="btn submit btn-primary ">
							
						<?php
						}
						?>
						<br/>
					</form>
				</div>
			</div>
			<div class="span2"></div>
		</div>
				
	</div>
</section>

<?php include 'template-parts/footer.php'; ?>
<script type="text/javascript">                               
	CKEDITOR.replaceAll('content');	
	</script>
