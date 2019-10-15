<?php
	
include('template-parts/header.php');
$id=@$_SESSION['business_owner_id'];

$db->select('bars_list','*',NULL,'Owner_id="'.$id.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$barDetails = $db->getResult();

#echo "<pre>";
#print_r($barDetails);
#exit;
#$_SESSION['business_owner_id'];
?>
<!--==============================Map=================================--> 

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
  <?php
  if(isset($_SESSION['business_owner_id']))
  {
  ?>
    <div class="row clearfix ">
          <div class="span3"></div>
			<div class="span12">
				<h2>Bar Details <a href="edit_bar_profile.php" class="pink pull-right"><i class="fa fa-pencil-square-o  fa-2x" aria-hidden="true"></i></a></h2>
				
			</div>
			
				<div id="note"></div>
				<div id="fields" class="contact-form">
					<form id="profile" class="form-horizontal">
						<div class="span6 pull-left">
								<?php if(isset($_SESSION['msg'])){ 
									echo $_SESSION['msg'];
									unset($_SESSION['msg']);
								 } ?>
								<div class="control-group">
									<label class="control-label" for="inputName">Bar Name:</label>
									<span><?php echo (@$barDetails[0]['Business_Name'])?@$barDetails[0]['Business_Name']:"-"; ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">Location:</label>
									<span><?php echo (@$barDetails[0]['Location_Searched'])?@$barDetails[0]['Location_Searched']:"-"; ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">Postcode:</label>
									<span><?php echo (@$barDetails[0]['Zipcode'])?@$barDetails[0]['Zipcode']:"-"; ?></span>
								</div>
								<br>
								
								
								<div class="control-group">
									<label class="control-label" for="inputName">Contact No:</label>
									<span><?php echo (@$barDetails[0]['PhoneNo'])?@$barDetails[0]['PhoneNo']:"-"; ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputEmail">Category:</label>
									<span><?php echo (@$barDetails[0]['Category'])?@$barDetails[0]['Category']:"-"; ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">Description:</label>
									<span><?php echo (@$barDetails[0]['description'])?@$barDetails[0]['description']:"-"; ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">Established Year:</label>
									<span><?php echo (@$barDetails[0]['Established_Year'])?@$barDetails[0]['Established_Year']:"-"; ?></span>
								</div>
								<br>	
								
						</div>
						<div class="span6 pull-right">
							
							<div class="control-group">
								<label class="control-label" for="inputName">Price Range:</label>
								<span><?php echo (@$barDetails[0]['Price_Range'])?@$barDetails[0]['Price_Range']:"-"; ?></span>
							</div>
							<br>
							
							<div class="control-group">
								<label class="control-label" for="inputName">Hall :</label>
								<span><?php echo (@$barDetails[0]['is_hall_available']==1)?"Available ( Capacity of ".@$barDetails[0]['hall_capacity']." people)":"The bar do not have available hall"; ?></span>
							</div>
							<br>
							
							<?php if(@$barDetails[0]['is_hall_available']==1){?>
							<div class="control-group">
								<label class="control-label" for="inputName">Hall Fee:</label>
								<span><?php echo '&#163;'.number_format(@$barDetails[0]['hall_fee'],2); ?></span>
							</div>
							<br>
							<?php }?>
							
							<div class="control-group">
								<label class="control-label" for="inputName">Available seat:</label>
								<span><?php echo (@$barDetails[0]['seat_for_basic'])?@$barDetails[0]['seat_for_basic']:"-"; ?></span>
							</div>
							<br>
							
							<div class="control-group">
								<label class="control-label" for="inputName">Cost per seat:</label>
								<span><?php echo '&#163;'.number_format(@$barDetails[0]['cost_per_seat'],2); ?></span>
							</div>
							<br>
							
							<div class="control-group">
								<label class="control-label" for="inputName">Discount:</label>
								<span><?php echo (@$barDetails[0]['Discount'])?@$barDetails[0]['Discount']:"-"; ?></span>
							</div>
							<br>
							
							<div class="control-group">
								<label class="control-label" for="inputName">Hours:</label>
								<span><?php echo (@$barDetails[0]['Hours'])?@$barDetails[0]['Hours']:"-"; ?></span>
							</div>
							<br>
							<div class="control-group">
								<label class="control-label" for="inputName">Ratings:</label>
								<span><?php echo (@$barDetails[0]['Rating'])?@$barDetails[0]['Rating']:"-"; ?></span>
							</div>
							<br>
						</div>
						<!--<div class="span12">
							<a href="business_owner_edit_profile.php" >
							<button style="float:right;" type="button"  class="btn submit btn-primary "><i class="icon-envelope icon-white"></i>&nbsp;&nbsp;Edit Profile</button>
							</a>
							<div class="clearfix"></div>
						</div>    -->
					</form>	
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




	
    <?php include('template-parts/footer.php'); ?>