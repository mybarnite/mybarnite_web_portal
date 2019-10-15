<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();

?>

<?php include'head.php'; ?>
<title>Best Clubs,Bars and Lounges</title>
<meta name="keywords" content="List of bars in london, bars and nightclubs near me, pubs around me, best pubs near me,list of bars in london,list of clubs in london">
<meta name="description" content="Nightclubs, Pubs & Bars list">
   <?php include'header.php'; ?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
	<div class="container">
		<h1>Pubs & Clubs List</h1>
		
		<div class="row clearfix ">
        
		  <?php
			
			$barName = trim($_POST['barName']);
			$barPostcode = trim($_POST['barPostcode']);
			$query = "SELECT * FROM bars_list"; 

			if($barName!=""&&$barPostcode=="")
			{
				@$query .= " where Business_Name like '".$barName."%'";
			}	

			if($barPostcode!=""&&$barName=="")
			{
				@$query .= " where Zipcode like '".$barPostcode."%'";
			}
				
			if($barPostcode!=""&&$barName!="")
			{
				@$query .= " where Business_Name like '".$barName."%' and Zipcode like '".$barPostcode."%'";
			}
			$limitForList = " limit 40";
			@$query1 = $query.$limitForList;

			$barlistquery = mysql_query($query1) or die(mysql_error());
			$result = mysql_num_rows($barlistquery);
			header('Content-type: text/html; charset=utf-8');
			if($result > 0)
			{
			?>
			
			<div class="span2">
			<?php
				while($barName = mysql_fetch_array($barlistquery))
				{ 
					if($barName['Business_Name']!="")
					{	
$muserSql = "select * from user_register where id = ". $barName['Owner_id'];
	$muserQuery = mysql_query($muserSql);
	$m1 = mysql_fetch_assoc($muserQuery);
			?>
					
					<br>
					<a class="barlist" href="bardetail.php?barid=<?php echo $barName['id'] ?>" >
						<?php echo utf8_encode($barName['Business_Name']); if($barName['Owner_id'] != 0 && $m1['status'] === 'Active'){  echo ' - Available';  } else {  echo ' - Not Available';  }  ?>
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
					$counter = 1;
					
					$limitForList1 = " limit 6";
					@$query2 = $query.$limitForList1;
					$barlistquery1 = mysql_query($query2) or die(mysql_error());
					$result1 = mysql_num_rows($barlistquery1);
					
					if($result1 > 0){
					?>
					<div class="span10">
						<div class="row bar-list">	
						<?php
						while($row = mysql_fetch_array($barlistquery1))
						{ ?>
					
					
							<div class="span3">
								<img src="img/<?php echo $counter; ?>.jpg" alt="<?php echo $counter; ?>"  border="0" />
								<h3  style="color:#fff;font-size:14px;word-break: break-all;width: 10em;"><?php echo (!empty($row['Business_Name']))? $row['Business_Name']:"Mybarnite"; ?></h3>
					<p><span style="color: #ff1da5;">Booking Status : </span>
<?php 
$userSql = "select * from user_register where id = ". $row['Owner_id'];
		$userQuery = mysql_query($userSql);
		$user2row = mysql_fetch_assoc($userQuery);
	if($row['Owner_id'] != 0 && $user2row['status'] === 'Active'){ echo 'Available'; }
	else { echo 'Not Available'; } ?></p>
<p>Rating <?php echo $row['Rating']; ?></p>
<a href="bardetail.php?barid=<?php echo $row['id'] ?>"> <button type="button" class="btn btn-default <?php if($row['Owner_id'] != 0 && $user2row['status'] === 'Active') { echo 'btn-gr-color'; }else{ echo 'btn-color'; }?>" style="float:right;margin-top:-60px;">Detail</button> </a>
				

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