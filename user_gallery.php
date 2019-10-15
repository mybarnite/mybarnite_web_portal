<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
$user_id=@$_SESSION['id'];
unset($_SESSION['msg']);
?>
<?php include 'head.php'; ?>
<title>My Gallery</title>
<?php
include("header.php");


?>

</header>

<script type="text/javascript" src="js/uploader.js"></script>
<script type="text/javascript" src="js/frontend_custom.js"></script>

<link type="text/css" href="business_owner/css/uploader.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

<script type="text/javascript">
$(document).ready(function()
{
	new multiple_file_uploader
	({
		form_id: "fileUpload", 
		autoSubmit: true,
		server_url: "uploader_user_gallery.php" // PHP file for uploading the browsed files
		
	});
	
	$('.gallery-item').hover( function() {
        $(this).find('.img-title').fadeIn(300);
    }, function() {
        $(this).find('.img-title').fadeOut(100);
    });
	
	
});
</script>


<section id="content" >
  <div class="container divider">
	<div class="row ">
	  <div class="clearfix ">
			<div class="span12">
				<h2>Gallery</h2>
				<div class="upload_box">
					<form name="fileUpload" id="fileUpload" action="javascript:void(0);" accept="image/png,image/jpeg,image/gif" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $_SESSION['id'];?>" id="user_id" name="user_id" accept="image/png,image/jpeg,image/gif"/>
						<div class="file_browser"><input type="file" name="multiple_files[]" id="_multiple_files" class="hide_broswe" style="width: 95%;" multiple accept="image/png,image/jpeg,image/gif" hidden/><input type="button" value="Select Files" onclick="$('#_multiple_files').click();" class="upload_button" style="width:100%" /></div>
						<div class="file_upload"><input type="submit" value="Upload Files" class="upload_button" style="width:100%" /> </div>
                        <div style="width: 100%;float: left;margin-top: 10px;">Upload only .png , .jpeg, .jpg or gif images. </div>
					</form>
				</div>	
				<div class="file_boxes"><div>No Files Selected. Please click on 'Select Files' and then click on 'upload files'.</div></div>
				<span id="removed_files"></span>
			</div>	
			<div class="span12">
				<div class="container" id="gallery">
					
					<?php
					$sql = "select * from tbl_user_gallery where user_id=".$user_id." order by id DESC";
					$exe = mysql_query($sql);
					$countRows = mysql_num_rows($exe);
					
					
					if(!empty($countRows)&&$countRows>0)
					{	
						while($images = mysql_fetch_assoc($exe))
						{
						
							$file_path = $images['file_path'];
							if (file_exists($file_path)) 
							{
						?>
								<figure class="threecol first gallery-item">
									<img src="<?php echo SITE_PATH.$file_path;?>" alt="<?php echo $images['file_name'];?>">
									<h3><?php echo $images['file_type']; ?></h3>
									<figcaption class="img-title">
										<h5>
											<a href="javascript:void(0);" onclick="delete_image(<?php echo $images['id'];?>);">DELETE</a> 
											
										</h5>  
									</figcaption>
								</figure>
						
						
						<?php
							}
						
						}
					}	
					?>
					
				</div>
			</div>	
			
		</div>	
	</div>	
  </div>	
</section>	



 <?php include'footer.php'; ?>