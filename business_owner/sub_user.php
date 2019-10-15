<?php
include('template-parts/header.php');
$barId = $_SESSION['bar_id'];

?>
<script type="text/javascript" src="<?php echo SITE_PATH;?>business_owner/js/custom.js"></script>
<!--==============================Map=================================--> 
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">	
</header>
<div class="padcontent"></div>
<section id="content" class="main-content">
	<div class="container">
	<?php
	if(isset($_SESSION['business_owner_id']))
	{
	?>
	<div class="row clearfix ">
		<div class="span10">
			<center><h2>Staff account details</h2></center>
		</div>		  
		<div class="span2">
			<a href="add_staff_member.php" class="btn btn-info bg-pink">Add Staff member</a>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<div id="accordion2" class="accordion max-size1" style="margin-top: 15px;">
				<div class="accordion-group" >
					<div class="accordion-heading ">
						<div <?php if($page_name=='business_owner_settings.php'){?> class="accordion-toggle-active" style="background:#ff1da5 !important;" <?php }else{?> class="accordion-toggle" <?php }?> data-target="#collapse" data-toggle="collapse" data-parent="#accordion2" >
							<span></span>
							<a style="color:#9393a7;text-decoration:none;" href="<?php echo SITE_PATH;?>business_owner/business_owner_settings.php">Update Profile</a>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading ">
						<div <?php if($page_name=='sub_user.php'){?> class="accordion-toggle-active" style="background:#ff1da5 !important;" <?php }else{?> class="accordion-toggle" <?php }?> data-target="#collapse" data-toggle="collapse" data-parent="#accordion2">
							<span></span>
							<a style="color:#9393a7;text-decoration:none;" href="<?php echo SITE_PATH;?>business_owner/sub_user.php">Manage staff</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="span10 table-responsive" id="subUsers_Container" >
			<form action="" method="post">
				
				
					<?php if(isset($_SESSION['message1'])){ 
							echo "<center>";
								echo $_SESSION['message1'];
							echo "</center>";	
								unset($_SESSION['message1']);
								
						 } ?>
					<?php if(@$_REQUEST['message1']=="success"){ 
							echo "<center><div class='alert alert-success'>Data has been deleted successfully!</div></center>";
							
						 } ?>	 
					<?php if(@$_REQUEST['message1']=="error"){ 
							echo "<center><div class='alert alert-danger' >Error occured!</div></center>";
							
						 } ?>	 	 
				
				<?php
				$sql = "SELECT * from user_register where r_id = 3 and bar_id = ".$barId ;
				$res = $db->myconn->query($sql);
				$num_rows = $res->num_rows;	
				if($num_rows>0)
				{	
				?>
				
					<table class="table" style="margin-top:0;margin-bottom:0;">
						<thead>
							<tr>
								<th width="150" style="vertical-align: middle;"></th>
								<th></th>
								<th></th>
								<th colspan="3"></th>
								<th colspan="3"></th>
								
							</tr>
						</thead>
					</table>	
					<table class="table" id="order_history">
						<thead>
							<tr>
								
								<th><input class="checkbox" type="checkbox" id="selecctall" onClick="selectAll(this)" style="margin-top:0"/>	All</th>
								<th>Name</th>
								<th>Email</th>
								<th width="20%" colspan="3">Accessible</th>
								<th colspan="3">Actions</th>
								
							</tr>
							
						</thead>
						<tbody>
							<tr>
								
								<td ><a class="pink" href="javascript:void(0);" onClick="deleteMutipleSubUsers();"><i class="fa fa-trash  fa-2x" aria-hidden="true"></i></a></td>
								<td><input name="name" id="name" style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;" value="" placeholder="Name..."/></td>
								<td><input name="email" id="email" style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;" value="" placeholder="Email..."/></td>
								<td colspan="3"></td>
								<td colspan="3"><input type="submit" name="filter" id="filter" value="Filter" class="btn btn-info"/><input type="submit" name="reset" id="reset" value="Reset" class="btn btn-info pull-right"/></td>
								
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
		<div class="row">
			<div class="clearfix">
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
include'template-parts/footer.php'; 
?>
<script>

$(document).ready(function(){
	getUserDetals();
	var limit = 15;
	$("#filter").click(function(){
		$("#Page").val("1");
		getUserDetals();
		return false;
	});
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
        url: "subUserList.php", 
        type:"POST",
        data:{ pageNo:$("#Page").val(),barId : <?php echo @$_SESSION['bar_id'];?>, name : $("#name").val(), email : $("#email").val()},
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