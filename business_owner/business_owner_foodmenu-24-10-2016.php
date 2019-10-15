<?php 
include('template-parts/header.php'); 

?>

<?php

if(isset($_POST['AddItem']))
{
	
		$itemName = $_POST['boxes'];
		$itemPrice = $_POST['price'];
		$itemCategoryId = $_POST['cat'];
		$itemCategoryName = ($itemCategoryId=="1")?"Food":"Drink"; 
		
		$db->insert('tbl_menu_items',array('bar_id'=>$_SESSION['bar_id'],'cat_id'=>$itemCategoryId,'cat_name'=>$itemCategoryName,'menu_item_name'=>$itemName,'price'=>$itemPrice));  // Table name, column names and respective values
		$res = $db->getResult();  
		$lastInsertedId = $res[0];
		if($lastInsertedId!="")
		{
			$_SESSION['msg']="Data inserted successfully";
		}
		else
		{
			$_SESSION['msg']="";
		}		
	
	
}	

$db->select('tbl_menu_items','*',NULL,'bar_id='.@$_SESSION['bar_id'],'id DESC');
$items = $db->getResult();

?>
<!--==============================Map=================================--> 

	
</header>
<div class="padcontent"></div>
<!--==============================Content=================================--> 
<section id="content"  class="main-content">
	<div class="container divider">
	<?php
	if(isset($_SESSION['business_owner_id']))
	{
	?>
		
		<?php if(isset($_SESSION['bar_id']))
		{	
			$db->select('bars_list','*',null,'bar_id ='.$_SESSION['bar_id'],'id DESC');
			$getBar = $db->getResult();
			$countBar = count($getBar);
			?>
			<div class="row">
				<div class="clearfix">
					<div class="span4"></div>
					<div class="span6">
						<h2>Foods</h2>
						
					</div>
					<div class="span5"></div>
				</div>
			</div> 
			<?php
			if($countBar>0)
			{?>
				<div class="row">
					
						
						<div class="span6 pull-left">
							<div class="my-form">
								<div class="control-group">
								<?php
								
								if(isset($_SESSION['msg']))
								{
								?>	
									<div class="alert alert-success"><?php echo $_SESSION['msg'];?></div>
								<?php	
								
									unset($_SESSION['msg']);		
								}
								?>
								</div>
								<form role="form" method="post" class="form-horizontal">
									
									<div class="text-box">
										
										<div class="control-group">
											<label  class="control-label" for="box1">Item name</label>
											<input class="form-control" type="text" name="boxes" required value="" id="box1" />
										</div>
										<div class="control-group">								
											<label class="control-label" for="price1">Price</label>
											<input class="form-control" type="number" name="price" required value="" id="price1" />
										</div>
										<div class="control-group">		
											<label class="control-label" for="cat1">Category</label>
											<select class="form-control" name="cat" id="cat1">
												<option value="1">Food</option>
												<option value="2">Drink</option>
											</select>
										</div>	
										
									</div>
									<p><input type="submit" value="Add New" name="AddItem"  class="btn submit btn-info bg-pink"/><button type="button" id="reset"  name="reset" value="reset" class="btn btn-info submitEvent bg-pink">Reset</button></p>
								</form>
							</div>
						</div>
						
						<div class="span6 pull-right">
						<?php
							if(!empty($items)&&isset($_SESSION['bar_id']))
							{
						?>
							<table class="table" id="menuItems">
								<thead>
									<tr>
										<th>No.</th>
										<th>Item Name</th>
										<th>Category Name</th>
										<th>Price (&#163;)</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i=1;
								
									foreach($items as $item)
									{
									?>
										<tr>
											<td><?php echo $i;?></td>
											<td><?php echo $item['menu_item_name'];?></td>
											<td><?php echo $item['cat_name'];?></td>
											<td><?php echo number_format($item['price'],2);?></td>
											<td colspan="2">
												<form role="form" method="post" action="business_owner_editMenu.php">
													<input type="hidden" name="item_id" value="<?php echo $item['id'];?>" id="item_id" />
													<input class="btn btn-info bg-pink" type="submit" value="Edit" name="UpdateItem" />
													<input class="btn btn-info bg-pink" type="button" value="Delete" onclick="manageMenuItems(<?php echo $item['id'];?>)" name="DeleteItem" />
												</form>
												
											</td>
										</tr>
									<?php
									$i++;
									}
									
								?>	
								</tbody>
							</table>
						<?php }?>	
						</div>
						<div class="span5"></div>
					
				</div>
			<?php
			}
		}
		else
		{
		?>
		<div class="row text-center">
			<div class="span12">
				<h5 class="alert alert-danger h5-notregisteredbar">You can not able to access this page because your Bar / Business has not been registered yet.<br/> Please <a href="business_owner_edit_profile.php"> register your Business </a> here.</h5>
				
			</div>
		</div>	
		<?php	
		}	
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
<script type="text/javascript">

function manageMenuItems(id)
{
	$.ajax({
			url : "manageMenuItems.php",
			type: "POST",
			data :{ itemId: id },
			
			success: function(result)
			{	
			
				//data - response from server
				$("#menuItems tbody").html(result);
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$("#menuItems tbody").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		});
}
</script>
<?php include'template-parts/footer.php'; ?>
<script>
$(document).ready(function() {
    $("#reset").click(function(){
        $.ajax({
				url : "removeSession.php",
				type: "POST",
				success: function(result)
				{	
					window.location="business_owner_foodmenu.php";
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
		
    }); 
});
</script>