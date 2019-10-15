<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

$barid=$_REQUEST['id'];
?>
<?php include'head.php'; ?>
<title>Bar Menu</title>
<?php include'header.php'; ?>
<!--==============================Content=================================--> 
	
<section id="content" >
	<div class="container" id="menu_details">
		<br/>
		<div class="row">
			<center>
				<h2>Menu</h2>
			</center>
		</div>
		<?php 
		$q1 = "select * from  tbl_barfoodmenu_uploads where bar_id = ".$barid;
		$exe1 = mysql_query($q1);
		$count = mysql_num_rows($exe1);
		
		
		?>	
		<div class="row">
			<div class="span12">
				<div class="container" id="gallery">
				<?php
					if($count>0)
					{	
						while($row = mysql_fetch_assoc($exe1))
						{
							
							$formats = array("jpg", "png", "gif", "pdf", "JPG", "PNG", "GIF", "PDF");
							$file_path = "business_owner/".$row['file_path'];
							$ext = pathinfo($row['file_name'], PATHINFO_EXTENSION);
							if(!in_array($ext,$formats)) 
							{
								$file_path = "business_owner/foodmenu_uploads/PDF-icon.png";
							}
							else
							{
								$file_path = "business_owner/".$row['file_path'];
							}	
							
							if (file_exists("business_owner/".$row['file_path'])) 
							{
						?>
							<figure class="threecol first gallery-item">
								<a href="<?php echo SITE_PATH."business_owner/".$row['file_path'];?>" target="_blank"><img src="<?php echo SITE_PATH.$file_path;?>" alt="<?php echo $row['file_name'] ?>" height="300" width="300"></a>
								<figcaption class="img-title">
									<h5>
										<a href="<?php echo SITE_PATH."business_owner/".$row['file_path'];?>" target="_blank">VIEW</a> 
									</h5>  
								</figcaption>
							</figure>
						
						
						<?php
							}
						}
					}
					else
					{
					?>	
						<div class='alert alert-danger'>Records not found.</div>
					<?php	
					}		
					?>
				</div>
			</div>		
		</div>
	</div>
	
</section>
<script type="text/javascript" src="business_owner/js/uploader.js"></script>
<link type="text/css" href="business_owner/css/uploader.css" rel="stylesheet" />
<?php include'footer.php'; ?>
