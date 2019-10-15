<?php
session_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>

<?php
		$messagestatus = "";
		if(isset($_POST['sendmessagebut']))
		{
			$name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['namee']))));
			$email = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['email']))));
			$message = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['message']))));
			
			$to = "info@mybarnite.com";
			$subject = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['subject']))));
			$txt = $message;
			$headers = "From: $email" . "\r\n";
			mail($to,$subject,$txt,$headers);
			
			$to1 = $email;
			$subject1 = "Mybarnite - Contact";
			$txt1 = "<html>";
			$txt1 .= "<head><title>Mybarnite</title></head>";
			$txt1 .= "<body>";
			$txt1 .= "Dear $name<br/><br/>";
			$txt1 .= "Thank you for contacting us. Our Mybarnite team will get back to you soon!<br/><br/>Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='http://mybarnite.com/images/Picture1.png' alt='Mybarnite' width='110'>";
			$txt1 .= "</body></html>";
			$headers1  = 'MIME-Version: 1.0' . "\r\n";
			$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers1 .= "From: info@mybarnite.com" . "\r\n" ."";
			
			if(mail($to1,$subject1,$txt1,$headers1))
			{
				$_SESSION['status'] = "<div class='alert alert-success'>Email sent!</div>";
			}
			else
			{
				$_SESSION['status'] = "<div class='alert alert-danger'>Seomething went wrong.</div>";
			}		
			
			$messagestatus = "value";
		}
?>

<?php include'head.php';?>
<title>Contact us and be well served |Mybarnite</title>
<meta name="keywords" content="Mybarnite">
<meta name="description" content="At Mybarnite, You are very welcome to revisit us as many times as you like, we would ensure that you're well served and enjoy your outing.">
<?php include'header.php'; ?>
<!--==============================Map=================================--> 
<div class="container">
    <div class="clearfix ">
	<!--	<div class="map span12">
			 <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:440px;width:1000px;'><div id='gmap_canvas' style='height:440px;width:1000px;'></div><div><small><a href="http://embedgooglemaps.com">Embed your Google Map here!</a></small></div><div><small><a href="https://binaireoptieservaringen.nl/">Lees hier ervaringen van diverse binaire opties aanbieders</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:15,center:new google.maps.LatLng(51.5275124,-0.0900963),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(51.5275124,-0.0900963)});infowindow = new google.maps.InfoWindow({content:'<strong>Mybarnite</strong><br>152-160 City Rd, London EC1V 2NP, UK<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script> 
		</div> -->
		<!--<div class="span12 main-logo">-->
		<!--    <img src="https://mybarnite.com/images/barlogo.png" alt="mybarnite logo">-->
		<!--</div>-->
	</div>
</div>
	
</header>
<div class="padcontent"></div>		

<!--==============================Content=================================--> 
<section id="content" class="main-content">
  <div class="container">
    <div class="row clearfix ">
        <div class="span3 main-logo">
		    <img src="https://mybarnite.com/images/barlogo.png" alt="mybarnite logo">
		</div>
		<div class="span5">
        	<h1>Get in touch</h1>
      			<div id="note"></div>
      			<div id="fields" class="contact-form">
				<?php /* if($messagestatus != ""){ ?>
				<span style="color:white">Message Sended</span>
				<?php } */ ?>
      				<form id="ajax-contact-form" class="form-horizontal" action="" method="post">
      					<div class="control-group">
						<?php
						
						if(isset($_SESSION['status']))
						{
									echo $_SESSION['status'];
									unset($_SESSION['status']);
						}
						
						?>
						</div>
						<div class="control-group">
      						<label class="control-label" for="inputName">Your name:</label>
      						<input type="text" name="namee" >
      					</div>
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">Your Email:</label>
      						<input type="email" name="email" >
      					</div>
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">Subject:</label>
      						<input type="text" name="subject" >
      					</div>
      					<div class="control-group">
      						<label class="control-label" for="inputEmail">Your Message:</label>
      						<textarea  name="message" rows="3" style=" background-color: white"></textarea>
						</div>
						<div class="control-group">
							<button type="submit" name="sendmessagebut" class="btn submit btn-primary" style="margin-left:120px"><i class="icon-envelope icon-white" ></i>&nbsp;&nbsp;submit</button>
						</div>	
						<div class="clearfix"></div>
      				</form>
					
      			</div>  
				<div id="fields" class="contact-form row align-center">
					<img src="<?php echo SITE_PATH?>/img/card.jpg" alt="Mybarnite" style="height:150px;width:300px;"/>&nbsp;&nbsp;<img src="<?php echo SITE_PATH?>/img/ssl-logo-300x166.png" alt="SSL logo" style="height:150px;width:300px;"/>
				</div>
				<br/>	
		</div>		  
		
		<div class="span4">
        	<h2 class="h2-margin">Our Address</h2>
			<div class="row clearfix ">
				<div class="span3">
					<?php
						$getcontent = mysql_query("select * from maincontent where slugname='contact-address'");
						$fetchContent = mysql_fetch_assoc($getcontent);
						echo $fetchContent['message'];
					?>
			      <div class="padcontent_small"></div>		
				</div>
				
			</div>
			<?php
				$getcontent = mysql_query("select * from maincontent where slugname='contact'");
				$fetchContent = mysql_fetch_assoc($getcontent);
				echo $fetchContent['message'];
			?>
  		</div>

    </div>
  </div>
</section>

<?php include'footer.php'; ?>