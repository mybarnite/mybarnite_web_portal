<?php
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>
<?php include'head.php'; ?>
<title>Mybarnite</title>
   <?php include'header.php'; ?>
<style>
	table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
	</style>

<!--==============================Content=================================--> 
<section id="content" >
  <div class="container divider">
	
    <div class="row ">
	  <div class="clearfix ">
    	<div class="span12">
          <br/><br/><br/>
		  <table style="width:100%">
<tr>
	<th>#</th>
  <th>Bar Name</th>
  <th>Booking Date</th>	
  <th>Booking Time</th>	
<th>Person</th>  
  <th>Price</th>
</tr>


<tr>
   <td>1</td>
  <td>Korova</td>		
  <td>MM/DD/YYYY</td>
  <td>00:00:00</td>
  <td>5</td>
   <td>$0</td>
  
   
 
  
</tr>

		
	<tr >
  
   <td colspan="5"></td>
  
  <td>$0</td>	
  
 
 
  
</tr>

</table>
<br/><br/>
<button type="button" class="btn btn-primary" style="background-color:#ff1da5;">Check out</button>

		  <div class="padcontent"></div>
        </div>
    	
    	
	  </div>
    </div> 

  </div>
</section>



	
    <?php include'footer.php'; ?>