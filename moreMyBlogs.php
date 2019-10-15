<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

//echo $_POST['id'];

$created_at = date('Y-m-d h:i:s',$_POST['id']);

$sql1 = "SELECT COUNT(*) as num_rows FROM tbl_manage_blogs WHERE author_id= ".$_SESSION['id']." and created_at < '".$created_at."' ORDER BY created_at DESC";
$res2 = $db->myconn->query($sql1);
$row = $res2->fetch_assoc();
$allRows = $row['num_rows'];

$showLimit = 8;

$sql = "SELECT * from tbl_manage_blogs where author_id = ".$_SESSION['id']." and created_at < '".$created_at."' ORDER BY created_at DESC LIMIT ".$showLimit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;

if($num_rows1 > 0){ 

for($i = 1; $i <= $num_rows1; $i++)
	{
		$res1 = $res->fetch_assoc();
		if($res1['image_path']!="")
		{
			$imagePath = $res1['image_path'];
		}		
		else
		{
			$imagePath = "images/no_image.png";
		}	
		$post_id = strtotime($res1['created_at']);			
		$created_at = date('d M, Y',strtotime($res1['created_at']));
		$author = ($res1['author']==0)?" By Mybarnite":"";
		?>
			
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
					<div class="span6">
						<div class="blog-item-header">
							<h2><a href="blog-detail.php?id=<?php echo $res1['id']?>"><?php echo ucwords(strtolower($res1['title']));?></a></h2>
						</div>
						<div class="blog-post-details-item">
							<a href="blog-detail.php?id=<?php echo $res1['id']?>"><img src="<?php echo $imagePath;?>" alt="blog-image" width="600" height="200"/></a>
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
	
	<div class="row" id="show_more_main_container<?php echo $post_id; ?>"> 
		<div class="span8 show_more_main" id="show_more_main<?php echo $post_id; ?>">
			<span id="<?php echo $post_id; ?>" class="btn_show_more btn submit btn-primary bg-pink" title="Load more posts">Show more</span>
			<span class="loding"><div class="loader"></div></span>
			
		</div>
	</div>
	<?php
}	
else
{
?>	
	<div class="span8 offset1" id="show_more_main_container<?php echo $post_id; ?>"> 
		<div style="color:#333;">No post available.</div>
	</div>
<?php	
}	
?>