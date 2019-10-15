<?php
	
include('template-parts/header.php');

$id=@$_SESSION['business_owner_id'];
$barId=@$_SESSION['bar_id'];
$subUserId=@$_SESSION['subUserId'];

$query = "select can_access from tbl_staffPermission where subuser_id = ".$subUserId." and bar_id = ".$barId;
$res = $db->myconn->query($query);
$num_rows = $res->num_rows;
?>
<!--==============================Map=================================--> 

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
  <?php
  if(isset($_SESSION['business_owner_id'])&&isset($_SESSION['subUserId']))
  {
  ?>
    <div class="row clearfix">
		<div class="span12">
			<center>
				<h2>Dashboard</h2>
			</center>
		</div>		  
	</div>
	<div class="row">
	<?php
	if($num_rows>0)
	{	
		for($i = 1; $i <= $num_rows; $i++)
		{
			$accessiblePages = $res->fetch_assoc();
			
			if (in_array("1", $accessiblePages)){
				$title = 'Bar Profile';
				$pageUrl = 'business_owner_profile.php';
				$icon = '<i class="fa fa-pencil-square-o pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("2", $accessiblePages))
			{
				$title = 'Gallery';
				$pageUrl = 'business_owner_gallary.php';
				$icon = '<i class="fa fa-file-picture-o pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("3", $accessiblePages))
			{
				$title = 'Event management';
				$pageUrl = 'business_owner_events.php';
				$icon = '<i class="fa fa-calendar pink fa-4x" aria-hidden="true"></i>';
			}					
			else if (in_array("4", $accessiblePages))
			{
				$title = 'Food management';
				$pageUrl = 'business_owner_foodmenu.php';
				$icon = '<i class="fa fa-file-text pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("5", $accessiblePages))
			{
				$title = 'Subscription';
				$pageUrl = 'business_owner_subscription.php';
				$icon = '<i class="fa fa-check-square-o pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("6", $accessiblePages))
			{
				$title = 'Order management';
				$pageUrl = 'business_owner_orders.php';
				$icon = '<i class="fa fa-shopping-cart pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("7", $accessiblePages))
			{
				$title = 'Sales';
				$pageUrl = 'business_owner_sales.php';
				$icon = '<i class="fa fa-line-chart pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("8", $accessiblePages))
			{
				$title = 'Promotion';
				$pageUrl = 'business_owner_promotions.php';
				$icon = '<i class="fa fa-gift pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("9", $accessiblePages))
			{
				$title = 'Account';
				$pageUrl = 'business_owner_account.php';
				$icon = '<i class="fa fa-bars pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("10", $accessiblePages))
			{
				$title = 'User guide';
				$pageUrl = 'business_user_guide.php';
				$icon = '<i class="fa fa-info-circle pink fa-4x" aria-hidden="true"></i>';
			}
			else if (in_array("11", $accessiblePages))			
			{
				$title = 'Profile settings';
				$pageUrl = 'business_owner_settings.php';
				$icon = '<i class="fa fa-user pink fa-4x" aria-hidden="true"></i>';
			}	
			else if (in_array("12", $accessiblePages))			
			{
				$title = 'Manage blog';
				$pageUrl = 'myblogs.php';
				$icon = '<i class="fa fa-bars pink fa-4x" aria-hidden="true"></i>';
			}	
			
			
			if($num_rows==1)	
			{	
		?>
				<div class="span4"></div>
				<div class="span4">
					<div class="panel-group" id="subscription_contents">
						<div class="panel panel-default">
							<div class="panel-heading"><center><h3><?php echo @$title;?></h3></center></div>
							<center>	
								<div class="panel-body">
									<span><h5><?php echo $bars[0]['file_name'];?></h5></span>
									<span>
										<a href="<?php echo SITE_PATH.'business_owner/'.$pageUrl;?>" target="_blank"><?php echo @$icon;?></a>
										<figcaption class="img-title">
											<h5>
												<a href="<?php echo SITE_PATH.'business_owner/'.$pageUrl;?>" target="_blank" class="btn btn-info bg-pink">Click here</a>	
											</h5>  
										</figcaption>
									</span>
								</div>
							</center>
						</div>
					</div>
				</div>	
				<div class="span4"></div>
		<?php
			}
			else
			{
		?>
				<div class="span4">
					<div class="panel-group" id="subscription_contents">
						<div class="panel panel-default">
							<div class="panel-heading"><center><h3><?php echo @$title;?></h3></center></div>
							<center>	
								<div class="panel-body">
									<span><h5><?php echo $bars[0]['file_name'];?></h5></span>
									<span>
										<a href="<?php echo SITE_PATH.'business_owner/'.$pageUrl;?>" target="_blank"><?php echo @$icon;?></a>
										<figcaption class="img-title">
											<h5>
												<a href="<?php echo SITE_PATH.'business_owner/'.$pageUrl;?>" target="_blank" class="btn btn-info bg-pink">Click here</a>	
											</h5>  
										</figcaption>
									</span>
								</div>
							</center>
						</div>
					</div>
				</div>	
		<?php			
			}	
		}	
	}
	?>	
	</div>
	<br/>
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




	
    <?php include('template-parts/footer.php'); ?>