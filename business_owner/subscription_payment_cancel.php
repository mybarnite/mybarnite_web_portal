<?php
include('template-parts/header.php');


if($_SESSION['business_owner_id']!="")
{	

?>

<section id="content" class="main-content">
	<div class="container">
		<div class="row clearfix ">
			
			<div class="span12">
				<br/>
				<center><div class="alert alert-danger">Your payment has been cancelled. Please try again.</div></center>
      			
			</div>		  
		</div>
	</div>
</section>
<?php
}
include'template-parts/footer.php';
?>
