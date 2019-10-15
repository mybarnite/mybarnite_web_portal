<?php

include('template-parts/header.php');

if(isset($_POST['AddPromotion']))
{
	
	
	if(!isset($_POST['code'])) $form->setError("code", "Enter alphanumeric couponcode.");
	else
	{
		
			$sql3 = $db->select('tbl_promotions','couponcode',null,'couponcode ="'.$_POST['code'].'"',null);
			$res3 = $db->getResult(); 	
			$numRows3 = count($res3); 
			if($numRows3>0)
			{
				$form->setError("code", "Couponcode already exists.");
			}	
		
						
	}
	if(!isset($_POST['discount'])|| $_POST['discount']==0 || strlen($_POST['discount'] = trim($_POST['discount'])) == 0) $form->setError("discount", "Enter proper amount. Only digits allowed.");
	else
	{
		if(!is_numeric($_POST['discount'])) $form->setError("discount", "Enter proper amount. Only digits allowed");
						
	}
	if($_POST['event']==0) $form->setError("event", "Select proper event.");
	
	if($form->num_errors > 1)
	{
			//$_SESSION['value_array'] = $_POST;
			//$_SESSION['error_array'] = $form->getErrorArray();
	}
	else			
	{
		
		if(isset($_POST['event']))
		{
			$sql4 = $db->select('tbl_promotions','*',null,'ownerId ="'.$_SESSION['business_owner_id'].'" and barId="'.$_SESSION['bar_id'].'" and eventId="'.$_POST['event'].'"',null);	
			$res4 = $db->getResult(); 	
			$numRows4 = count($res4); 
			if($numRows4>0)
			{
				$array = array(
					'status'=>'Inactive',
				);
				$db->update('tbl_promotions',$array,'ownerId ="'.$_SESSION['business_owner_id'].'" and barId="'.$_SESSION['bar_id'].'" and eventId="'.$_POST['event'].'"'); // Table name, column names and values, WHERE conditions
				$res = $db->getResult();
			}
		}	
		else
		{
			$sql4 = $db->select('tbl_promotions','*',null,'ownerId ="'.$_SESSION['business_owner_id'].'" and barId="'.$_SESSION['bar_id'].'"',null);	
			$res4 = $db->getResult(); 	
			$numRows4 = count($res4); 
			if($numRows4>0)
			{
				$array = array(
					'status'=>'Inactive',
				);
				$db->update('tbl_promotions',$array,'ownerId ="'.$_SESSION['business_owner_id'].'" and barId="'.$_SESSION['bar_id'].'"'); // Table name, column names and values, WHERE conditions
				$res = $db->getResult();
			}
		}	
		
			
		$array = array(
			'ownerId'=>$_SESSION['business_owner_id'],
			'barId'=>$_SESSION['bar_id'],
			'eventId'=>(isset($_POST['event']))?$_POST['event']:0,
			'couponcode'=>$_POST['code'],
			'discount'=>$_POST['discount'],
			'description'=>$_POST['description'],
			'status'=>'Active',
			'userCount'=>0,
			'startsat'=>date('y-m-d',strtotime($_POST['startsat'])),
			'endsat'=>date('y-m-d',strtotime($_POST['endsat']))
		);
		
		$db->insert('tbl_promotions',$array); // Table name, column names and values, WHERE conditions	
		
		$res = $db->getResult();
		$lastInsertedId = $res[0];
		if($lastInsertedId!="")
		{
			$_SESSION['msg']='<div class="alert alert-success">Promotion has been added successfully!</div>';
			
		}	
	}	
}	
if(isset($_REQUEST['inactive']))
{

	$chk=$_REQUEST['chk'];
	foreach($chk as $id)
	{
		$array = array(
					
					'status'=>'Inactive'
					
					
				);
		$succ_del=$db->update("tbl_promotions",$array,"id=".$id);
	}
	if($succ_del)
	{
		$_SESSION['msg']="success";
	}
	else
	{
		$_SESSION['msg']="error";
	}
	?>
	   <script>window.location.href="business_owner_promotions.php?msg=<?=$_SESSION['msg'];?>";</script>
	<?php
}
if(isset($_REQUEST['active']))
{

	$chk=$_REQUEST['chk'];
	foreach($chk as $id)
	{
		$array = array(
					
					'status'=>'Active'
					
					
				);
		$succ_del=$db->update("tbl_promotions",$array,"id=".$id);
	}
	if($succ_del)
	{
		$_SESSION['msg']="success";
	}
	else
	{
		$_SESSION['msg']="error";
	}
	?>
	   <script>window.location.href="business_owner_promotions.php?msg=<?=$_SESSION['msg'];?>";</script>
	<?php
}

?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">	
<script type="text/javascript" src="js/custom.js"></script>
</header>
<div class="padcontent"></div>	

<section id="content" class="main-content">
	<div class="container MainPromotionContainer">
	<?php 
	if(isset($_SESSION['business_owner_id']))
	{
	?>	
		<div class="row">
			<div class="span12">
				<center>
					<div class="control-group" id="msg">
					
						<?php if(isset($_SESSION['msg'])){ 
								echo $_SESSION['msg'];
								unset($_SESSION['msg']);
							 } ?>
						<?php if(@$_REQUEST['msg']=="success"){ 
								echo "<div class='alert alert-success'>Data hase been updates successfully!</div>";
								
							 } ?>	 
						<?php if(@$_REQUEST['msg']=="error"){ 
								echo "<div class='alert alert-danger' >Error occured!</div>";
								
							 } ?>	 	 
					
					</div>
				</center>	
			</div>
		</div>	
		<?php
		if(isset($_SESSION['bar_id']))
		{
			
			$sql = $db->select('tbl_events','*',null,'free_event != 1 AND bar_id ='.$_SESSION['bar_id'],'event_name DESC');  // Table name, WHERE conditions
			$res = $db->getResult(); 
			$numRows = count($res); 
		?>
		<div class="row">
			<div class="span4">&nbsp;</div>
			<div class="span4">
				<div id="promotion" class="PromotionContainer">
					<center><h2>Add Promotion</h2></center>
					
      				<form id="promotion-form" method="post" class="form-horizontal">
      					<div class="control-group">
      						<label class="control-label" for="inputName">Promotions:</label>
							<div class="span1 pull-left">
								<input type="radio" required name="optradio" id="baroptradio" class="form-control" value="bar" checked style="width: 33px !important;vertical-align: top;height: 15px;"><span>Bar</span>
							</div>
							<div class="span1 pull-left">
								<input type="radio" required name="optradio" id="eventoptradio" class="form-control" value="bar" style="width: 33px !important;vertical-align: top;height: 15px;"><span>Event</span>
							</div>
      					</div>
						<br>
						<div class="control-group hidden" id="eventList">
							<label class="control-label" for="inputName">Events:</label>
      						<select name="event" id="event">
								<option value="0">Select</option>
							<?php foreach($res  as $event){
							    if(@strtotime(@date('Y-m-d')) <= @strtotime($event['event_end'])){ ?>
								    <option value="<?php echo $event['id'];?>"><?php echo $event['event_name'];?></option>
							<?php  }
							} ?>	
							</select>
							<span><?php echo $form->error("event"); ?></span>
						</div>
						<br>
						<div class="control-group">
							<label class="control-label" for="inputName">Coupon Code:</label>
      						<input type="text" required name="code" id="code" class="form-control" value="" placeholder="Code..." style="float: left;" ><a href="javascript:void(0);" name="generate" id="generate" class="pink" style="text-decoration:none; float: left;">Generate Coupon code</a>
							<span><?php echo $form->error("code"); ?></span>
      					</div>
						<br>
						<div class="control-group">
							<label class="control-label" for="inputName">Discount (in %):</label>
      						<input type="text" required name="discount" class="form-control" value="" placeholder="Discount..." >
							<span><?php echo $form->error("discount"); ?></span>
      					</div>
						<br>
						
						<div class="control-group">
							<label class="control-label" for="inputName">Starts at:</label>
      						<input type="text" required name="startsat" class="date start form-control" value="" placeholder="mm/dd/yyyy"/>
      					</div>
						<br>
						
						<div class="control-group">
							<label class="control-label" for="inputName">Ends at:</label>
      						<input type="text" required name="endsat" class="form-control date end" value="" placeholder="mm/dd/yyyy"/>
      					</div>
						<br>
						
						<div class="control-group">
							<label class="control-label" for="inputName">Description:</label>
      						<textarea name="description" id="description" placeholder="Description..."></textarea>
							
      					</div>
						<br>
						
						<div class="control-group"> 
						    <input type="submit" name="AddPromotion" id="AddPromotion" class="btn submit btn-primary bg-pink white" value="Add">
							
							<button type="button" id="reset"  name="reset" value="reset" class="btn submit btn-primary bg-pink white">Reset</button>
						</div>						
						<div class="clearfix"></div>
      				</form>
      			</div>
			</div>	
			<div class="span4">&nbsp;</div>
		</div>		
		<div class="row">
			<div class="span12 table-responsive" id="order_history_container">
				<form action="" method="post">
			<?php 
				$sql1 = "select * from tbl_promotions where barId = ".$_SESSION['bar_id'];
				$res1 = $db->myconn->query($sql1);
				$num_rows = $res1->num_rows;	
				if($num_rows>0)
				{	
			?>			<center><h2>Promotions</h2></center>
						
						<table class="table" id="order_history">
							<thead>
								<tr>
									
									<th><input type="checkbox" id="selecctall" onClick="selectAll(this)" style="margin: 0 4px 0;" />Select All</th>
									<th>Name</th>
									<th>Discount (%)</th>
									<th>Validity</th>
									<th>Status</th>
									<th colspan="2">Actions</th>
									
								</tr>
								
							</thead>
							<tbody>
								<tr>
									<td colspan="2" style="text-align:left"><input type="submit" name="inactive" value="Inactive" class="input btn btn-danger"/><input type="submit" name="active" value="Active" class="input btn btn-danger"/></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									
								</tr>
							</tbody>
							<tbody id="target-content">
								<input type="hidden" id="totalCount" value=""/>
								<input type="hidden" id="Page" value="1"/>
									
							</tbody>
						</table>
						<center>
							<div class="allPage">
								<div class="btn-group">
									<button type="button" class="btn btn-primary start"><b><<</b></button>
									<button type="button" class="btn btn-primary left"><b><</b></button>
									<button type="button" class="btn btn-primary right"><b>></b></button>
									<button type="button" class="btn btn-primary end"><b>>></b></button>
								</div>
							</div>
						</center>
			<?php 
				}
			?>
				</form>
			</div>
		</div>
		<?php
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
<?php
include('template-parts/footer.php');
?>
<script>
	
	$('#promotion .date').datepicker({
		'format': 'mm/dd/yyyy',
		'autoclose': true
	});

	$('#promotion').datepair();
</script>
<script>
$(document).ready(function() {
	
	$("#code").blur(function() 
	{
		var code = $("#code").val();
		checkCouponCode(code,"Add");
	});
	
	$("#generate").click(function(){
		var code = $("#code").val();
		generateCouponCode(code,"Add");
	});
	
    $('input[type=radio][name=optradio]').change(function() {
		 
		if ($("#baroptradio").attr("checked")) {
			$("#eventList").addClass('hidden');
        }
        else {
			$("#eventList").removeClass('hidden');
        }
        
    });
	
	
	
	getUserDetals();
	var limit = 15;
	
	$(".right").click(function(){
		
		var totalRecords =  $("#totalCount").val();
		var finalPage = Math.ceil(totalRecords/limit);
		//alert(finalPage);
		
		if(parseInt($("#Page").val()) != finalPage ){
			  var currentPageNo =  $("#Page").val();
			  $("#Page").val(parseInt(currentPageNo)+1);
			  getUserDetals();
		  
		}
    
  });

    $(".left").click(function(){
    if($("#Page").val() != 1){
      var currentPageNo =  $("#Page").val();
      $("#Page").val(parseInt(currentPageNo)-1);
      getUserDetals();
      
    }
    
  });


    $(".start").click(function(){
    if($("#Page").val() != 1){
      $("#Page").val(1);
      getUserDetals();
      enableDisPagination();
    }
  }
                   );
  
  $(".end").click(function(){
    
    var totalRecords =  $("#totalCount").val();
    var finalPage = Math.ceil(totalRecords/limit);
    
    if(parseInt($("#Page").val()) != finalPage ){
      $("#Page").val(finalPage);
      getUserDetals();
      enableDisPagination();
    }
});
      function getUserDetals(){
    //alert($("#CostPage").val());
    
    $.ajax(
      {
        url: "promotionList.php", 
        type:"POST",
        data:{
          pageNo:$("#Page").val()}
        ,
        success: function(response){
          //alert(response);
          $("#target-content").html(response);
                   if(parseInt($("#totalCount").val()) > limit){
            $(".allPage").show();
          }
          else{
            $(".allPage").hide();
          }
          
      
        }
      }
    );
  }
  function enableDisPagination(){
    if($("#Page").val() != 1){
      $(".start").removeClass("disabled");
      $(".left").removeClass("disabled");
      
    }
    else{
      $(".start").addClass("disabled");
      $(".left").addClass("disabled");
      
    }
    
    var totalRecords =  $("#totalCount").val();
    var finalPage = Math.ceil(totalRecords/limit);
    
    if(finalPage == $("#Page").val()){
      
      $(".right").addClass("disabled");
      $(".end").addClass("disabled");
    }
    else{
      
      $(".right").removeClass("disabled");
      $(".end").removeClass("disabled");
    }
  }
});
</script>
<script>
$(document).ready(function() {
    $("#reset").click(function(){
        $.ajax({
				url : "removeSession.php",
				type: "POST",
				success: function(result)
				{	
					window.location="business_owner_promotions.php";
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
		
    }); 
});
</script>
