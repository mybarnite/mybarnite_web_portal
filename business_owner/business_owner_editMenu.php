<?php 
include('template-parts/header.php'); 
unset($_SESSION['msg']);
?>

<?php
if(isset($_POST['item_id']))
{
	$_SESSION['itemId'] = $_POST['item_id'];	
}
else
{
	$_SESSION['itemId'] = $_SESSION['itemId'];
}	

$db->select('tbl_menu_items','*',NULL,'id="'.$_SESSION['itemId'].'"','id DESC');
$items = $db->getResult();


if(isset($_POST['Update']))
{
	$items = $db->escapeString($_POST['items']);
	$price = $db->escapeString($_POST['price']);
	$itemCategoryId = $db->escapeString($_POST['cat']);
	$itemCategoryName = ($itemCategoryId=="1")?"Food":"Drink"; 
	
	$array = array(
					'menu_item_name'=>$items,
					'price'=>$price,
					'cat_id'=>$itemCategoryId,
					'cat_name'=>$itemCategoryName,
				);
				
	$db->update('tbl_menu_items',$array,'id='.$_SESSION['itemId']);
	$res = $db->getResult();	
	if(!empty($res[0])&&$res[0]>0)
	{
		$_SESSION['msg']='Data has been updated successfully';
		header("location:business_owner_foodmenu.php");
	}	
	else
	{
		$_SESSION['msg']="Data has not been modified.";
		header("location:business_owner_foodmenu.php");
	}	
				
}



?>

<!--==============================Content=================================--> 
<section id="content" >
	<div class="container divider">
	<?php
	if(isset($_SESSION['business_owner_id']))
	{
	?>
		<div class="row">
			<div class="clearfix ">
				<div class="span4"></div>
				<div class="span6">
					<h2>Update Food</h2>
					<div class="control-group">
						<?php
						
						if(isset($_SESSION['msg']))
						{
						?>	
							<div class="alert alert-success">Data Updated successfully!!</div>
						<?php	
						
									
						}
						
						?>
					</div>
				</div>
				<div class="span5"></div>
			</div>
		</div> 
		
		
		<div class="row">
			<div class="clearfix ">
				<div class="span4"></div>
				<div class="span4">
					<center>
						<div class="my-form">
							<form role="form" method="post" class="form-horizontal">
								<div class="text-box">
									<div class="control-group">
										<label class="control-label" for="box1">Item name</label>
										<input class="form-control" type="text" name="items" required value="<?php echo @$items[0]['menu_item_name'];?>" id="items" />
									</div>
									<div class="control-group">		
										<label class="control-label" for="price1">Price</label>
										<input class="form-control" type="number" name="price" required value="<?php echo @$items[0]['price'];?>" id="price" />
									</div>
									<div class="control-group">	
										<label class="control-label" for="cat1">Category</label>
										<select class="form-control" name="cat" id="cat1">
											<option value="1" <?php if($items[0]['cat_id']==1){?> selected="selected" <?php }?> >Food</option>
											<option value="2" <?php if($items[0]['cat_id']==2){?> selected="selected" <?php }?> >Drink</option>
										</select>
									</div>
									<div class="control-group">	
										<input type="submit" class="btn btn-info bg-pink pull-left" value="Update" name="Update" /><a href="business_owner_foodmenu.php" class="btn btn-info bg-pink pull-right" style="    padding: 10px 26px;">Back</a>
									</div>
								</div>
								
							</form>
						</div>
					</center>
				</div>
				<div class="span4"></div>
			</div>
		</div>	
		
	<?php
	}
	?>	
	</div>
</section>

<?php include'template-parts/footer.php'; ?>