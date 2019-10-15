<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();
include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

//$loggedinUser = $_SESSION['id'];

$sql = "SELECT * from tbl_manage_blogs where id = ".$_GET['id'];
$res = $db->myconn->query($sql);
$res1 = $res->fetch_assoc();
	
if($res1['author_id']==0)
{
	$author = "by MyBarnite";	
}	
else
{
	$db->select('user_register','*',NULL,'id='.$res1['author_id'],'id DESC');
	$getAuthor = $db->getResult();
	$author = "by ".$getAuthor[0]['name'];
}		
	
include'head.php'; ?>
	<title>Blog - <?php echo $res1['title']?> | MyBarnite</title>
	<meta name="keywords" content="">
	<meta name="description" content="">

<?php
include('header.php');

?>


<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">
	<div class="row blog-post" id="blog-posts">
				<?php
				if($res1['image_path']!="")
				{
					if($res1['author_id']==0)
					{
						$imagePath = 'admin/'.$res1['image_path'];	
					}	
					else
					{
						$imagePath = $res1['image_path'];
					}	
					
				}		
				else
				{
					$imagePath = "images/no_image.png";
				}	
				
				
				?>
				<div class="span8">
					<div class="blog-item-header">
						<h2><a href="#"><?php echo $res1['title']?></a></h2>
						<?php 
						if($res1['author_id']==$_SESSION['id'])
						{	
						?>
						<div class="row">
							<div class="span5 offset1"><?php echo $author;?> on <?php echo date('d M Y',strtotime($res1['created_at']))?></div>
							<div class="span1">
								<a href="add-blog.php?id=<?php echo $res1['id']?>" class="pink"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a>
								<a href="javascript:void(0);" id="delBlog" class="pink" style="margin-left: 33%;"><i class="fa fa-trash  fa-2x" aria-hidden="true"></i></a>
							</div>	
						</div>
						<?php }else{?>
						<span><?php echo $author;?> on <?php echo date('d M Y',strtotime($res1['created_at']))?></span>
						<?php }?>
						
					</div>
					<div class="blog-post-details-item">
						<div class="align-center">
							<a href="#"><img src="<?php echo $imagePath;?>" alt="blog-image" width="600" height="200"/></a>
						</div>
						<div class="align-center">
						<div class="row media-share blog-post-details-share">
							
							<div class="facebookDiv pull-left">
								<div class="fb-share-button" data-href="<?php echo "$myUrl?$queryString";?>" data-layout="button_count"></div>
							</div>
							<div class="twitterDiv pull-left" style="padding-left: 15px;padding-right: 15px;">
							   <script id="twitter-wjs" type="text/javascript" async defer src="//platform.twitter.com/widgets.js"></script>
							   <a href="https://twitter.com/share" class="twitter-share-button" data-via="mybarnite" data-related="mybarnite" >Tweet</a>
							</div>
							<script src="https://apis.google.com/js/platform.js" async defer></script>
							<div class="googlePlusDiv pull-left">
							   <g:plusone size="medium"></g:plusone>
							</div>
						</div>
						</div>		
						
						<div class="blog-post-details-content">
							<p><?php echo $res1['content'];?></p>
						</div>
					</div>
				</div>
	</div>
</section>
<?php include'footer.php'; ?>
<?php 
if($res1['author_id']==$_SESSION['id'])
{	
?>
<script>
	$(document).on('click','#delBlog',function(){
        var ID = <?php echo $_GET['id'];?>;
		$.ajax({
            type:'POST',
            url:'delBlog.php',
            data:'id='+ID,
			success:function(html){
				window.location.href = "myblogs.php"; 
            }
        }); 
    });

</script>
<?php }?>