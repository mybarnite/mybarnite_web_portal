<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection=DB_CONNECTION();
?>
<?php include'head.php'; ?>
<title>My favourite Clubs & Bars</title>
<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

if($_SESSION['id']!="")
{	

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<script type="text/javascript" src="js/frontend_custom.js"></script>
<section id="content" class="main-content">
	<div class="container">
		<div class="row clearfix ">
			
			<div class="span12">
				<br/>
				<center><h2>My Favourites</h2></center>
      			
			</div>		  
		</div>
	
		<div class="row clearfix ">
			<div  class="span2"></div>
			
			<div  class="span8"  id="order_history_container">
				<br/>
					<center>
						<?php if(isset($_SESSION['msg'])){ 
								echo $_SESSION['msg'];
								unset($_SESSION['msg']);
							 } ?>
					</center>
					<!--<div class="span2"></div>--?
					<!--<div class="span10" id="target-content">-->
					<div id="target-content">
						<input type="hidden" id="totalCount" value=""/>
						<input type="hidden" id="Page" value="1"/>
					</div>
					
					
				
			</div>	
			
			<div  class="span2"></div>	
		</div>
	</div>
</section>
<?php
}
include('footer.php');
?>
<script>
$(document).ready(function(){
	getDetals();
	var limit = 2;

	$(".right").click(function(){
		
		var totalRecords =  $("#totalCount").val();
		var finalPage = Math.ceil(totalRecords/limit);
		//alert(finalPage);
		
		if(parseInt($("#Page").val()) != finalPage ){
			  var currentPageNo =  $("#Page").val();
			  $("#Page").val(parseInt(currentPageNo)+1);
			  getDetals();
		  
		}
    
  });

    $(".left").click(function(){
    if($("#Page").val() != 1){
      var currentPageNo =  $("#Page").val();
      $("#Page").val(parseInt(currentPageNo)-1);
      getDetals();
      
    }
    
  });


    $(".start").click(function(){
    if($("#Page").val() != 1){
      $("#Page").val(1);
      getDetals();
      enableDisPagination();
    }
  }
                   );
  
  $(".end").click(function(){
    
    var totalRecords =  $("#totalCount").val();
    var finalPage = Math.ceil(totalRecords/limit);
    
    if(parseInt($("#Page").val()) != finalPage ){
      $("#Page").val(finalPage);
      getDetals();
      enableDisPagination();
    }
});
      function getDetals(){
    //alert($("#CostPage").val());
    
    $.ajax(
      {
        url: "myFavouriteList.php", 
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