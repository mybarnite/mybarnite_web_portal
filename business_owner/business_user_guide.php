
<?php
include('template-parts/header.php');
require "../barclaycard/BarclaycardEpdq.class.php";
$barclaycardEpdq = new BarclaycardEpdq();

$db->select('tbl_settings','*',null,'id =1','id DESC');
$getSettings = $db->getResult();	

$db->select('tbl_businessowner_subscription','*',null,'bar_id ='.$_SESSION['bar_id'].' and is_active="Active"','id DESC');
$getRows = $db->getResult();
$countRows1 = count($getRows);


$db->select('bars_list','*',null,'id ='.$_SESSION['bar_id'].' and is_payasyougo=""','id DESC');
$getPayasyougoNull = $db->getResult();
$countPayasyougoNull = count($getPayasyougoNull);
if($countPayasyougoNull==0)
{
	if($countRows1>0)
	{
		$array = array(
			'is_payasyougo'=>'2'
		);
		
		$db->update('bars_list',$array,'id='.$_SESSION['bar_id']);
		$is_res = $db->myconn->affected_rows;	
	}
}
	
$db->select('bars_list','*',null,'id ='.$_SESSION['bar_id'].' and is_payasyougo!=""','id DESC');
$getPayasyougo = $db->getResult();

$countPayasyougo = count($getPayasyougo);	
	
?>
<script type="text/javascript" src="js/custom.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header>

<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
	<?php 
	if(isset($_SESSION['business_owner_id']))
	{
	?>	
	<!--==============================Subscription History=================================--> 	
		 
		
		<!--==============================New Subscription=================================--> 
		<?php
		$db->select('tbl_user_guide','*',NULL,'id=1','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
		$bars = $db->getResult();
		
		?>
		
		<div class="row clearfix ">
			<div class="span4">&nbsp;</div>
			<div class="span4">
				<div class="panel-group" id="subscription_contents">
					<div class="panel panel-default">
						<div class="panel-heading"><center><h3>User Guide</h3></center></div>
						<center>	
							<div class="panel-body threecol first gallery-item">
								
								<span><h5><?php echo $bars[0]['file_name'];?></h5></span>
								<span>
									<a href="<?php echo SITE_PATH.'business_owner/'.$bars[0]['file_path'];?>" target="_blank"><img src=<?php echo SITE_PATH."business_owner/foodmenu_uploads/PDF-icon.png";?> height="100" width="100"></a>
									<figcaption class="img-title">
										<h5>
											<a href="<?php echo SITE_PATH.'business_owner/'.$bars[0]['file_path'];?>" target="_blank" class="btn btn-info bg-pink">Click here to View</a>	
										</h5>  
									</figcaption>
								</span>
								
							</div>
						</center>
						
						<br/>
					</div>
				</div>
			</div>	
			<div class="span4">&nbsp;</div>
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
<?php include'template-parts/footer.php'; ?>
