<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

?>

<?php include'head.php'; ?>
<title>Best Clubs,Bars and Lounges near me</title>
<meta name="keywords" content="List of bars in london, bars and nightclubs near me, pubs around me, best pubs near me,list of bars in london,list of clubs in london">
<meta name="description" content="Nightclubs, Pubs & Bars list">
   <?php include'header.php'; ?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
		<h1><?php echo $_POST['cat']; ?> List</h1>
		<div class="row clearfix ">
        
		  <?php
			$word = $_POST['searchtxt'];
			 
			$barlistquery = mysql_query(" SELECT * FROM bars_list WHERE Business_Name LIKE ('%".$word."%') or Zipcode LIKE ('%".$word."%') order by id desc  LIMIT 40 ") or die(mysql_error());
			$result = mysql_num_rows($barlistquery);
			header('Content-type: text/html; charset=utf-8');
			if($result > 0)
			{
			?>
			
			<div class="span2">
			<?php
				while($row = mysql_fetch_array($barlistquery))
				{ 
					if($row['Business_Name']!="")
					{	
$muserSql = "select * from user_register where id = ". $row['Owner_id'];
	$muserQuery = mysql_query($muserSql);
	$m1 = mysql_fetch_assoc($muserQuery);
			?>
					
					<br>
					<a class="barlist" href="bardetail.php?barid=<?php echo $row['id'] ?>" >
						<?php echo $row['Business_Name']; if($row['Owner_id'] != 0 && $m1['status'] === 'Active'){  echo ' - Available';  } else {  echo ' - Not Available';  } ?>
					</a>
					
				<?php
					}	
				}
				?>
			</div>
			<?php	
			}
				
			?>
		
			
					<?php
					$word = $_POST['searchtxt'];
					$counter = 1;
					$barlistquery = mysql_query(" SELECT * FROM bars_list WHERE Business_Name LIKE '%".$word."%' or Zipcode LIKE '%".$word."%' LIMIT 6 ") or die(mysql_error());
					$result = mysql_num_rows($barlistquery);
					if($result > 0){
					?>
					<div class="span10">
						<div class="row bar-list">	
						<?php
						while($row = mysql_fetch_array($barlistquery))
						{ ?>
					
					
							<div class="span3">
								<img src="img/<?php echo $counter; ?>.jpg" alt="<?php echo $counter; ?>"  border="0" />
								<h3  style="color:#fff;font-size:14px;word-break: break-all;width: 10em;"><?php echo (!empty($row['Business_Name']))? $row['Business_Name']:"Mybarnite"; ?></h3>
<p><span style="color: #ff1da5;">Booking Status : </span>
<?php 
$userSql1 = "select * from user_register where id = ". $row['Owner_id'];
$userQuery1 = mysql_query($userSql1);
$user2row1 = mysql_fetch_assoc($userQuery1);
	if($row['Owner_id'] != 0 && $user2row1['status'] === 'Active'){ echo 'Available'; }
	else { echo 'Not Available'; } ?></p>
<p>Rating <?php echo $row['Rating']; ?></p>
<a href="bardetail.php?barid=<?php echo $row['id'] ?>"> <button type="button" class="btn btn-default <?php if($row['Owner_id'] != 0 && $user2row1['status'] === 'Active') { echo 'btn-gr-color'; }else{ echo 'btn-color'; }?>" style="float:right;margin-top:-60px;">Detail</button> </a>				
							</div>
							
						<?php $counter++;	
						}
						?>
						</div>
					</div>
					<?php	
					}
					else
					{
						echo '<div class="span12">';
						echo '<div class="alert alert-danger" style="text-align:center;">Records not found or you might have entered wrong keyword.</div>';
						echo '</div>';
						
						echo '<div class="row">';
						echo '<div class="col-md-6">';
				        echo '<img src="images/barlogo.png" alt="mybarnite">';
						echo '</div>';
						echo '<div class="col-md-6">';
				        echo '<p> Join us now. Registration is free. </p>';
				        echo '<p><a href="https://mybarnite.com/signup.php"> Sign-Up Here. </a></p>';
						echo '</div>';
						echo '</div>';
					}			
					?>
				
		</div>
	</div>
</section>


	<br><br><br>

	
    <?php include'footer.php'; ?>