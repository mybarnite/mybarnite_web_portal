<?php
session_start();
ob_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php
$query=mysql_query("select * FROM tbl_manage_blogs where id='".$_REQUEST['id']."'");
$fetch_blog=mysql_fetch_array($query);
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
	$author_id = $_SESSION['id'];
	
	global $flag;
	$valid_formats = array("png","gif","jpeg","jpg");
	$path = "images/"; // Upload directory
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
					$file_path = 'images/'.$new_filename;
					$sql = "INSERT INTO tbl_manage_blogs (title, author_id, created_at, excerpt, content, image_name, image_path, status) VALUES ('".$title."',".$author_id.",'".$created_at."','".$excerpt."','".$content."','".$new_filename."','".$file_path."','".$status."')";
					
					//$sql = 'INSERT INTO tbl_manage_blogs (title, author_id, created_at, excerpt, content, status) VALUES ("'.$title.'",'.$author_id.',"'.$created_at.'","'.$excerpt.'","'.$content.'","'.$status.'")';
					$exe = mysql_query($sql);
					$_SESSION['errmsg']="<div class='alert alert-success'>Data has been added successfully.</div>";	
					$flag = 0;
					
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
		$sql = "INSERT INTO tbl_manage_blogs (title, author_id, created_at, excerpt, content, status) VALUES ('".$title."',".$author_id.",'".$created_at."','".$excerpt."','".$content."','".$status."')";
					
		$exe = mysql_query($sql);
		$_SESSION['errmsg']="<div class='alert alert-success'>Data has been added successfully.</div>";				
	}		
	
	
	
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
	$author_id = $_SESSION['id'];
	
	global $flag;
	$valid_formats = array("png","gif","jpeg","jpg");
	$path = "images/"; // Upload directory
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
					$file_path = 'images/'.$new_filename;
					$sql = "update tbl_manage_blogs set title = '".$title."', author_id = ".$author_id.", created_at = '".$created_at."',excerpt='".$excerpt."', content = '".$content."', image_name = '".$new_filename."', image_path = '".$file_path."' where id=".$_REQUEST['id'];
					
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
		//$sql = 'update tbl_manage_blogs set title = "'.$title.'", author_id = '.$author_id.', created_at = "'.$created_at.'",excerpt="'.$excerpt.'", content = "'.$content.'" where id='.$_REQUEST["id"];
			
		$sql = "update tbl_manage_blogs set title = '".$title."', author_id = ".$author_id.", created_at = '".$created_at."',excerpt='".$excerpt."', content = '".$content."' where id=".$_REQUEST['id'];
							
	}		
	//$sql = "update maincontent set heading='".$title."' , message='".$content."' where id='".$_REQUEST['id']."'";
	$exe = mysql_query($sql);
	$lastId = mysql_affected_rows();
	if(isset($lastId)&&$lastId>0)
	{
		header("location:myblogs.php?msg=true");
	}	
}	
?>
<?php include'head.php'; ?>
<title>Manage blog</title>
<?php include'header.php'; ?>
<!--==============================Map=================================--> 
<script type="text/javascript" src="admin/ckeditor/ckeditor.js"></script>
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
	<?php
	if(isset($_SESSION['id']))
	{
		
	?>
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
      						<input type="text" class="form-control"  name="title" id="title" value="<?php echo $fetch_blog['title']; ?>"  size="40" required>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Upload image:</label>
      						<input type="file" class="form-control" name="file" id="blog_img" accept="image/*">
							<?php 
							if($_REQUEST['id']!="")
							{
							?>
							<img src="<?php echo $fetch_blog['image_path']; ?>" height="50" width="50"/>
							<?php
							}
							?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Excerpt <span style="color:#ff0000;">*</span>:</label>
      						<textarea name="excerpt" id="excerpt" class="form-control" maxlength="250" required><?php echo $fetch_blog['excerpt']; ?></textarea>
      					</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Content:</label>
      						<textarea name="content" id="content" class="content form-control" ><?php echo $fetch_blog['content']; ?></textarea>
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
		<?php
		}
	else
	{
	?>
	<div class="row ">
		<div class="clearfix ">
			<div class="span12">
			<h5>You are not Logged in yet. Please <a href="usersignin.php">login </a></h5>
			</div>
		</div>
	</div>	
	<?php	
	}	
	?>		
	</div>
</section>
<?php include'footer.php'; ?>
<script type="text/javascript">                               
	CKEDITOR.replaceAll('content');	
	</script>