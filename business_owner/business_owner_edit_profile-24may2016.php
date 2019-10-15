<?php
include('template-parts/header.php');

echo $id=@$_SESSION['business_owner_id'];

$db->select('user_register','*',NULL,'id="'.$id.'" and r_id="1"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$result = $db->getResult();
$_SESSION['msg'] ="";

$db->select('bars_list','*',NULL,'Owner_id="'.$id.'"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$barDetails = $db->getResult();



?>

<?php
		if(isset($_POST['editprofile']))
		{
			
			/* echo "<pre>";
			print_r($_POST);
			exit; */
			
			$name = $db->escapeString($_POST['name']);
			$email = $db->escapeString($_POST['email']);
			//$password = isset($_POST['password']) ? $db->escapeString($_POST['password']) : "";
			$number = $db->escapeString($_POST['number']);
			$barname = $db->escapeString($_POST['barname']); 
			$category_searched  = $db->escapeString($_POST['category_searched']);
			$price_range = $db->escapeString($_POST['price_range']);
			$established_year = $db->escapeString($_POST['established_year']);
			$location = $db->escapeString($_POST['location']);
			$Zipcode = $db->escapeString($_POST['Zipcode']);
			$opening_time = $db->escapeString($_POST['opening_time']);
			$entry_fee_vip = $db->escapeString($_POST['entry_fee_vip']);
			$entry_fee_basic = $db->escapeString($_POST['entry_fee_basic']);
			$description = $db->escapeString($_POST['description']);
			$val = getLnt($Zipcode);
			$Longitude = $val['lng'];
			$Latitude = $val['lat'];
			
			$array = array(
						
						'PhoneNo'=>$number,
						'Business_Name'=>$barname,
						'Category_Searched'=>$category_searched,
						'entry_fee_basic'=>$entry_fee_basic,
						'entry_fee_vip'=>$entry_fee_vip,
						'description'=>$description,
						'Category'=>$category_searched,
						'Price_Range'=>$price_range,
						'Longitude'=>$Longitude,
						'Latitude'=>$Latitude,
						'Established_Year'=>$established_year,
						'Location_Searched'=>$location,
						'Zipcode'=>$Zipcode,
						'Hours'=>$opening_time,
						
						
					);
			
			if($number)
			{
						if(!is_numeric($number)) $form->setError("number", "Invalid Contact No");
						else if(strlen($number = trim($number)) != 10) $form->setError("number", "Contact No should be of 10 digits");
			}
			else $form->setError("number", "Contact No. not entered"); 
			if(!$barname || strlen($barname = trim($barname)) == 0) $form->setError("barname", "Barname can not be empty.");	
			if(!$category_searched || strlen($category_searched = trim($category_searched)) == 0) $form->setError("category", "Category can not be empty.");	
			if(!$location || strlen($location = trim($location)) == 0) $form->setError("location", "Location can not be empty.");	
			if(!$Zipcode || strlen($Zipcode = trim($Zipcode)) == 0) $form->setError("Zipcode", "Zipcode can not be empty.");
			else
			{
				if ( 10 <= strlen( trim( $Zipcode ) ) ) 
				{
					if ( !preg_match( '/^\d{5}(\-?\d{4})?$/', $Zipcode ) ) {
						$form->setError("Zipcode", "Invalid Zipcode.");
					}	
				}
				elseif ( 10 > strlen( trim( $Zipcode ) ) ) 
				{
					$form->setError("Zipcode", "Invalid Zipcode.");
				}		
				
					
				
			}
			if(!$entry_fee_vip || strlen($entry_fee_vip = trim($entry_fee_vip)) == 0) $form->setError("entry_fee_vip", "Entry fee can not be empty.");	
			if(!$entry_fee_basic || strlen($entry_fee_basic = trim($entry_fee_basic)) == 0) $form->setError("entry_fee_basic", "Entry fee can not be empty.");	
			
			if($form->num_errors > 1)
			{
						//$_SESSION['value_array'] = $_POST;
						//$_SESSION['error_array'] = $form->getErrorArray();
			}
			else			
			{
				
				$db->update('bars_list',$array,'Owner_id="'.$id.'"'); // Table name, column names and values, WHERE conditions
				$res = $db->getResult();
				
				$_SESSION['bar_id'] =  @$barDetails[0]['id'];
				if(!empty($res))
				{
					$_SESSION['msg']='<div class="alert alert-success">Profile has been updated successfully!!</div>';
					header("location:business_owner_profile.php");
				}	
				else
				{
					$_SESSION['msg']="";
					header("location:business_owner_edit_profile.php");
				}
			}	
			
			
			
			
		}
?>


<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
	<div class="row">
			<div class="clearfix ">
				<div class="span5"></div>
				<div class="span6">
					<h2>EDIT BAR DETAILS</h2>
					
				</div>
				<div class="span5"></div>
			</div>
	</div> 
    <div class="row" style="margin-left: 0;">
        		<div id="fields" class="contact-form">
					
					<form id="ajax-contact-form" class="form-horizontal edit_profile" method="post">
						<?php if(isset($_SESSION['msg'])){ 
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						 } ?>
						 
						
							<div class="col-md-6 pull-left">
								<div class="control-group">
									<label class="control-label" for="inputName">OWNER NAME:</label>
									<input type="text" value="<?php echo @$result[0]['name']; ?>" name="name" class="form-control" readonly>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">EMAIL:</label>
									<input type="email" value="<?php echo @$result[0]['email']; ?>" name="email" class="form-control" readonly>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">CONTACT NO:</label>
									<input type="number" required value="<?php echo @$barDetails[0]['PhoneNo']; ?>" name="number" class="form-control" placeholder="Contact No..." >
									<span ><?php echo $form->error("number"); ?></span>
								</div>
								<br>
							
								<div class="control-group">
									<label class="control-label" for="inputName">BAR NAME:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Business_Name']; ?>" required name="barname" placeholder="Bar name...">
									<span ><?php echo $form->error("barname"); ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">BAR DETAILS:</label>
									<input type="text" value="<?php echo @$barDetails[0]['description']; ?>" required name="description" placeholder="Bar details...">
									
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputEmail">CATEGORY:</label>
									<select name="category_searched" style="width: 76%;color: #333;">
										<option value="Bars" <?php if(@$barDetails[0]['Category']=="Bars"){?> selected="selected" <?php }?> >Bars</option>
										<option value="Clubs" <?php if(@$barDetails[0]['Category']=="Clubs"){?> selected="selected" <?php }?> >Clubs</option>
										<option value="Pubs" <?php if(@$barDetails[0]['Category']=="Pubs"){?> selected="selected" <?php }?> >Pubs</option>
									</select>
									
									
								</div>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputName">ESTABLISHED YEAR:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Established_Year']; ?>" name="established_year" placeholder="Established year...">
									
								</div>
								
								
								<br>
								
							</div>
						 
							<div class="col-md-6 pull-right">
							
								
								<div class="control-group">
									<label class="control-label" for="inputName">LOCATION:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Location_Searched']; ?>" required name="location" placeholder="Location...">
									<span ><?php echo $form->error("location"); ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">ZIPCODE:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Zipcode']; ?>" required name="Zipcode" placeholder="Zipcode...">
									<span ><?php echo $form->error("Zipcode"); ?></span>
								</div>
								
								<br>
								<div class="control-group">
									<label class="control-label" for="inputName">PRICE RANGE:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Price_Range']; ?>" name="price_range" placeholder="Price range...">
									
								</div>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputName">ENTRY FEE (BASIC):</label>
									<input type="text" value="<?php echo @$barDetails[0]['entry_fee_basic']; ?>" required name="entry_fee_basic" placeholder="Entry fee...">
									<span ><?php echo $form->error("entry_fee_basic"); ?></span>
								</div>
								<br>
								
								<div class="control-group">
									<label class="control-label" for="inputName">ENTRY FEE (VIP):</label>
									<input type="text" value="<?php echo @$barDetails[0]['entry_fee_vip']; ?>" required name="entry_fee_vip" placeholder="Entry fee...">
									<span ><?php echo $form->error("entry_fee_vip"); ?></span>
								</div>
								<br>
								
								
								
								<div class="control-group">
									<label class="control-label" for="inputName">Hours:</label>
									<input type="text" value="<?php echo @$barDetails[0]['Hours']; ?>" name="opening_time" placeholder="Hours...">
								</div>
								<br>
							
							</div>
						
						<br>
						
						<div class="span12">
							<input name="editprofile" id="businesseditprofile" type="submit" value="SAVE CHANGES" class="btn submit btn-primary ">
							
						</div>
						
      				</form>
					
				</div>    
  </div>
</section>




	
 <?php include'template-parts/footer.php'; ?>