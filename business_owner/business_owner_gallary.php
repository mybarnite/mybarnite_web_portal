<?php
	
include('template-parts/header.php');
$id=@$_SESSION['business_owner_id'];

unset($_SESSION['msg']);


/* echo "<pre>";
print_r($result); */
?>

</header>

<script type="text/javascript" src="js/uploader.js"></script>
<link type="text/css" href="css/uploader.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

<script type="text/javascript">
$(document).ready(function()
{
	new multiple_file_uploader
	({
		form_id: "fileUpload", 
		autoSubmit: true,
		server_url: "uploader.php" // PHP file for uploading the browsed files
		
	});
	
	$('.gallery-item').hover( function() {
        $(this).find('.img-title').fadeIn(300);
    }, function() {
        $(this).find('.img-title').fadeOut(100);
    });
	
});
function delete_image(id)
{
		$.ajax({
			url : "deleteBarImage.php",
			type: "POST",
			data :{ img_id: id },
			
			success: function(result)
			{	
			
				//data - response from server
				//$("#gallery").html(result);
				window.location="business_owner_gallary.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		});
}

function logo_image(id,logo_image)
{
		$.ajax({
			url : "makeLogoImage.php",
			type: "POST",
			data :{ img_id: id,status:logo_image},
			
			success: function(result)
			{	
			
				//alert(result);
				//data - response from server
				//$("#gallery").html(result);
				window.location="business_owner_gallary.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		});
}
</script>


<section id="content" >
  <div class="container divider">
  <?php	
  if($_SESSION['business_owner_id']!="")
  {
  ?>
	<div class="row ">
	  <div class="clearfix ">
			<div class="span12">
				<h2>Gallery</h2>
				<div class="upload_box">
					<form name="fileUpload" id="fileUpload" action="javascript:void(0);" accept="image/png,image/jpeg,image/gif" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $_SESSION['bar_id'];?>" id="bar_id" name="bar_id" /> 
						<div class="file_browser"><input type="file" name="multiple_files[]" id="_multiple_files" class="hide_broswe" style="width: 95%;" multiple accept="image/png,image/jpeg,image/gif" hidden/><input type="button" value="Select Files" onclick="$('#_multiple_files').click();" class="upload_button" style="width:100%" /></div>
						<div class="file_upload"><input type="submit" value="Upload" class="upload_button" style="width:100%" /> </div>
<div style="width: 100%;float: left;margin-top: 10px;">Upload only .png , .jpeg, .jpg or gif images. </div>
					</form>
				</div>	
				<div class="file_boxes"><div style="float:left;">No Files Selected. Please click on 'Select Files' and then click on 'upload files'.</div></div>
				<span id="removed_files"></span>
			</div>	
			<div class="span12">
				<div class="container" id="gallery">
					
					<?php
					$db->select('tbl_bar_gallary','*',NULL,'bar_id='.$_SESSION['bar_id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
					$images = $db->getResult();
					if(!empty($images))
					{	
						foreach($images as $image)
						{
							$file_path = "business_owner/".$image['file_path'];
							$caption = ($image['logo_image'] == 1 ? "REMOVE PROFILE PICTURE" : "MAKE PROFILE PICTURE"); 
							if (file_exists($image['file_path'])) 
							{
						?>
							<figure class="threecol first gallery-item">
								<img src="<?php echo SITE_PATH.$file_path;?>">
								<?php if($image['logo_image'] == 1){?>
								<div class="cssarrow"><i class="fa fa-check fa-2x" style="position: absolute;top: 1px;right: -47px;color: white;" aria-hidden="true"></i></div>
								<?php }?>
								<figcaption class="img-title">
									<h5>
										<a href="javascript:void(0);" onclick="delete_image(<?php echo $image['id'];?>);">DELETE</a> | 
										<a href="javascript:void(0);" onclick="logo_image(<?php echo $image['id'];?>,<?php echo $image['logo_image'];?>);"><?php echo $caption;?></a>
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
	<?php
	}
	else
	{
	?>
	<div class="row ">
		<div class="clearfix ">
			<div class="span12">
			<h5>You are not Logged in yet. Please <a href="business_owner_signin.php">login </a></h5>
			</div>
		</div>
	</div>	
	<?php	
	}	
	?>	
  </div>	
</section>	



 <?php include'template-parts/footer.php'; ?>