<?php

include('template-parts/header.php');

if(isset($_POST['SavePromotion']))
{
	if(!isset($_POST['code'])) $form->setError("code", "Enter alphanumeric couponcode.");
	else
	{
			$pid = (isset($_GET['eid'])&&$_GET['eid']!="")?$_GET['eid']:$_GET['bid'];
			$sql3 = $db->select('tbl_promotions','couponcode',null,'couponcode ="'.$_POST['code'].'"  and id!='.$pid,null);
			$res3 = $db->getResult(); 	
			$numRows3 = count($res3); 
			if($numRows3>0)
			{
				$form->setError("code", "Coupon code already exists.");
			}	
				
		
						
	}
	if(!isset($_POST['discount'])|| $_POST['discount']==0 || strlen($_POST['discount'] = trim($_POST['discount'])) == 0) $form->setError("discount", "Enter proper amount. Only digits allowed.");
	else
	{
		if(!is_numeric($_POST['discount'])) $form->setError("discount", "Enter proper amount. Only digits allowed");
						
	}
	if(@$_POST['event']==0) $form->setError("event", "Select proper event.");
	
	if($form->num_errors > 1)
	{
			//$_SESSION['value_array'] = $_POST;
			//$_SESSION['error_array'] = $form->getErrorArray();
	}
	else			
	{
		
		$array = array(
			'couponcode'=>$_POST['code'],
			'discount'=>$_POST['discount'],
			'description'=>$_POST['description'],
			'startsat'=>@date('Y-m-d',@strtotime($_POST['startsat'])),
			'endsat'=>@date('Y-m-d',@strtotime($_POST['endsat']))
		);
		
		$db->update('tbl_promotions',$array,'id='.$_POST['id']); // Table name, column names and values, WHERE conditions	
		
		$res = $db->getResult();
		$lastInsertedId = $res[0];
		if($lastInsertedId!="")
		{
			$_SESSION['msg']='<div class="alert alert-success">Promotion has been updated successfully!</div>';
			
		}	
	}	
}	

?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">	
<script type="text/javascript" src="js/custom.js"></script>
</header>
<div class="padcontent"></div>	

<section id="content" class="main-content">
	<div class="container">
		<div class="row">
			<div class="span12">
				<center><h2>Update Promotion</h2></center>
			</div>
		</div>	
		<?php
		if(isset($_SESSION['bar_id'])&&isset($_SESSION['business_owner_id']))
		{
			$id = (isset($_GET['bid']))?@$_GET['bid']:@$_GET['eid'];
			$sql = "SELECT p.*, case when eventId=0 THEN (SELECT Business_Name FROM bars_list WHERE id = p.barId) ELSE (SELECT event_name from tbl_events WHERE id = p.eventId) END as name from tbl_promotions as p where id =".$id ;
			$res = $db->myconn->query($sql);
			$res1 = $res->fetch_assoc();
			
		?>
		<div class="row">
			<div class="span4">&nbsp;</div>
			<div class="span4">
				<div id="promotion" class="PromotionContainer">
					
					<div class="control-group">
						<?php
						if(isset($_SESSION['msg']))
						{
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						}
						?>
					</div>
      				<form id="promotion-form" method="post" class="form-horizontal">
						<input type="hidden" name="id" id="id" class="form-control" value="<?php echo (isset($_GET['bid']))?$_GET['bid']:$_GET['eid'];?>" readonly >
      					<?php if(isset($_GET['eid'])){?>
						<div class="control-group">
							<label class="control-label" for="inputName">Event Name:</label>
      						<input type="text" name="event" id="event" class="form-control" value="<?php echo $res1['name'];?>" readonly >
							
      					</div>
						<br>
						<?php }?>
						<?php if(@$_GET['bid']!=""){?>
						<div class="control-group">
							<label class="control-label" for="inputName">Bar Name:</label>
      						<input type="text" name="barname" id="barname" class="form-control" value="<?php echo $res1['name'];?>" readonly >
							
      					</div>
						<br>
						<?php }?>
						<div class="control-group">
							<label class="control-label" for="inputName">Coupon Code:</label>
      						<input type="text" required name="code" id="code" class="form-control" value="<?php echo $res1['couponcode'];?>" ><a href="javascript:void(0);" name="generate" id="generate" class="pink" style="text-decoration:none;">Generate Coupon code</a>
							<span><?php echo $form->error("code"); ?></span>
      					</div>
						<br>
						<div class="control-group">
							<label class="control-label" for="inputName">Discount (in %):</label>
      						<input type="text" required name="discount" class="form-control" value="<?php echo $res1['discount'];?>">
							<span><?php echo $form->error("discount"); ?></span>
      					</div>
						<br>
						<div class="control-group">
							<label class="control-label" for="inputName">Starts at:</label>
      						<input type="text" required name="startsat" class="form-control date start" value="<?php echo @date('m/d/Y',@strtotime($res1['startsat']));?>"/>
      					</div>
						<br>
						
						<div class="control-group">
							<label class="control-label" for="inputName">Ends at:</label>
      						<input type="text" required name="endsat" class="form-control date end" value="<?php echo @date('m/d/Y',@strtotime($res1['endsat']));?>"/>
      					</div>
						<br>
						
						<div class="control-group">
							<label class="control-label" for="inputName">Description:</label>
      						<textarea name="description" id="description"><?php echo $res1['description'];?></textarea>
							
      					</div>
						<br>
						
						<div class="control-group"> 
						    <input type="submit" name="SavePromotion" id="SavePromotion" class="btn submit btn-primary bg-pink white" value="Save">
							<a href="business_owner_promotions.php" id="reset" class="btn submit btn-primary bg-pink white">Back</a>
						</div>						
						<div class="clearfix"></div>
      				</form>
      			</div>
			</div>	
			<div class="span4">&nbsp;</div>
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
	$('#promotion-form .time').timepicker({
		'showDuration': true,
		'timeFormat': 'g:ia'
	});

	$('#promotion-form .date').datepicker({
		'format': 'mm/dd/yyyy',
		'autoclose': true
	});

	$('#promotion-form').datepair();
</script>
<script>
$(document).ready(function() {
	
	 
	$("#code").blur(function() 
	{
		var code = $("#code").val();
		checkCouponCode(code,"Update",<?php echo $id ;?>);
	});
	
	$("#generate").click(function(){
		var code = $("#code").val();
		generateCouponCode(code,"Update",<?php echo $id ;?>);
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