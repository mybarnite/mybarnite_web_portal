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
include'head.php'; ?>
	<title>Blog | MyBarnite</title>
	<meta name="keywords" content="blog,mybarnite blog">
	<meta name="description" content="MyBarnite Blog">

<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();
?>

<?php 
	
	$sql = "SELECT * from tbl_manage_blogs where status = 'Active' ORDER BY created_at DESC limit 8";
	$res = $db->myconn->query($sql);
	$num_rows1 = $res->num_rows;
	
?>

<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">    		
		<div class="row">
			<div class="span3">&nbsp;</div>
			<div class="span6 align-center">
				<iframe src="//rcm-eu.amazon-adsystem.com/e/cm?t=mybarnite-21&o=2&p=26&l=ez&f=ifr&f=ifr" width="468" height="60" scrolling="no" marginwidth="0" marginheight="0" border="0" frameborder="0" style="border:none;max-width:800px;max-height:600px;"></iframe>
			</div>
			<div class="span3">&nbsp;</div>
		</div>
		<div class="row" class="promotion-content">
			<div class="span10">
				<?php
				$getcontent = mysql_query("select * from maincontent where slugname='blogs'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
				?>
			</div>
		</div>
		<div class="row blog-post" id="blog-posts">
		<?php
			if($num_rows1 > 0){
				for($i = 1; $i <= $num_rows1; $i++)
				{
					$res1 = $res->fetch_assoc();
					if($res1['image_path']!="")
					{
						$imagePath = 'admin/'.$res1['image_path'];
					}		
					else
					{
						$imagePath = "images/no_image.png";
					}	
					$post_id = strtotime($res1['created_at']);	
					$created_at = date('d M, Y',strtotime($res1['created_at']));
					$author = ($res1['author']==0)?" by MyBarnite":"";
					//echo $res1['author'];
					?>
			<div class="span8">
				<div class="row">
					<!-- Date -->
					<div class="span1">
						<div class="blog-post-date">
							<h2><?php echo date('d',strtotime($res1['created_at']))?></h2>
						</div>
						<div class="blog-post-month-year">
							<span><?php echo date('M',strtotime($res1['created_at']))?></span>
						</div>
						<div class="blog-post-month-year">
							<span><?php echo date('Y',strtotime($res1['created_at']))?></span>
						</div>
					</div>
					<!-- Content -->
					<div class="span7">
						<div class="blog-item-header">
							<h2><a href="blog-detail.php?id=<?php echo $res1['id']?>"><?php echo ucwords(strtolower($res1['title']));?></a></h2>
							<span><?php echo $author;?></span>
						</div>
						<div class="blog-post-details-item">
							<a href="blog-detail.php?id=<?php echo $res1['id']?>"><img src="<?php echo $imagePath;?>" alt="blog-image" style="width:200px;"/></a>
							<p><?php echo substr($res1['excerpt'],0,250).'...';?>
							<a class="font-color-blue" href="blog-detail.php?id=<?php echo $res1['id']?>">Read more</a>
							</p>
						</div>
					<div class="divider"/>
					</div>					
				</div>	
				<?php
					}
				?>	
				<div class="span8 offset1" id="show_more_main_container<?php echo $post_id; ?>"> 
					<div class="show_more_main" id="show_more_main<?php echo $post_id; ?>">
						<span id="<?php echo $post_id; ?>" class="btn_show_more btn submit btn-primary bg-pink" title="Load more posts">Show more</span>
						<span class="loding"><div class="loader"></div></span>
					</div>
				</div>
				<br>
				<?php
					}else
					{
					?>	
						<div class="span2">&nbsp;</div>
						<div class="span8"> 
							<div class="alert alert-danger align-center">No post available.</div>
						</div>
						<div class="span2">&nbsp;</div>
					<?php	
					}	
					?>
			</div>	
		</div>				
	</div>	
</section>
<?php include'footer.php'; ?>
<script>
	$('.loding').hide();
    $(document).on('click','.btn_show_more',function(){
        var ID = $(this).attr('id');
		//alert(ID);
        $('.btn_show_more').hide();
        $('.loding').show();
        $.ajax({
            type:'POST',
            url:'moreBlogs.php',
            data:'id='+ID,
			success:function(html){
				//alert(html);return false;
                $('#show_more_main_container'+ID).remove();
                $('#blog-posts').append(html);
            }
        }); 
    });

</script>