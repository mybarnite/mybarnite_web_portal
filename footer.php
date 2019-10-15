 <!--==============================Bottom content=================================--> 
<aside id="bottom-content">
  <div class="container divider">
    <div class="row ">
        <div class="clearfix ">
			  
			  
			  <div class="span4">
				
			<!--	<h5 class="footer-title-h5">Subscribe to our newsletter</h5>
				
			
				<input type="text" id="useremail" name="useremail" class="input-field-newsletter"  placeholder="Enter your Email">
				<span>  <button type="button" class="btn btn-primary btn-newsletter" id="subscribeToNewsletter">Go</button></span>
				<span id="newslettermsg">  </span> -->
				
				<!-- Begin MailChimp Signup Form -->
				<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
				
				<h5 class="footer-title-h5">Subscribe to our mailing list</h5>
				<form action="//mybarnite.us14.list-manage.com/subscribe/post?u=81200f842c77909ee75442f18&amp;id=ccb753a57d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<input type="email" value="" name="EMAIL"class="input-field-newsletter"  placeholder="Enter your Email" id="mce-EMAIL">
					<input type="submit" value="Go" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary btn-newsletter">
					
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_81200f842c77909ee75442f18_ccb753a57d" tabindex="-1" value=""></div>
					
					
				</form>
				
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
				<!--End mc_embed_signup-->
				
				
				
				
			  </div>
			  
			  <?php 
			  require_once('twitter.php');

			  ?>
			  <div class="span4 ">
				<h5 class="footer-title-h5"><img src="images/twitter.png" alt="Best local bars, pubs and nightclubs  in UK" width="45" height="38" border="0" />&nbsp;&nbsp;Latest tweets</h5>
					<div class="clearfix"></div>
				<?php 
				foreach($feeds as $feed)
				{
				
				?>
					<a href="https://twitter.com/mybarnite" target="_blank">
						<img src="<?php echo $feed->user->profile_image_url_https;?>" alt="Best local bars, pubs and nightclubs  in UK" width="61" height="61" border="0" class="alignleft border_img" />
					</a>
					<p>
						<a style="text-decoration:none" href="https://twitter.com/mybarnite" target="_blank"><strong><?php echo $feed->user->screen_name;?> </strong></a>
						<?php echo $feed->text;?>
					</p>
					<div class="clearfix"></div>
				<?php 
				}
				?>
			  </div>
			  
				<?php
					$bannerquery = mysql_query(" SELECT * FROM bottom_banner ");
					$bannerrow = mysql_fetch_array($bannerquery);

				?>
			  
			  <div class="span4">
				<h5 class="footer-title-h5">Follow us on Facebook</h5>
				<a href="https://www.facebook.com/mybarnitelondon/" target="_blank">
					<img src="images/img4.jpg" alt="Best local bars, pubs and nightclubs  in UK"  border="0" class="aligncenter border_img" />
				</a>
				<p>
				<a style="text-decoration:none" href="https://www.facebook.com/mybarnitelondon/" target="_blank"><strong><?php echo $bannerrow['heading'] ?> </strong></a>
				<?php echo $bannerrow['desc'] ?>
				</p>
				
				<div class="padcontent"></div>
			  </div>
        </div>
   
    </div>
 
 <div class="row copyright">
      <div class="span8">
	
				Copyright © 2019. Designed &amp; Developed by <span style="color:#3179d8">Mybarnite</span>
				
      </div>

	
      <div class="span4">
			<ul class="footer_links">
				  <li><a href="<?php echo SITE_PATH;?>terms.php">Terms & conditions</a></li>
				  <li>|</li>
				  <li><a href="<?php echo SITE_PATH;?>policy.php">Privacy Policy</a></li>
				  <li>|</li>
				  <li><a href="<?php echo SITE_PATH;?>contact.php">Contact Us</a></li>
			</ul>       
      </div>
    </div>
	
	
  </div>    
</aside>

<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=8mPgVVmRZCLCwqSvDnfFUDyajZVGGLdqFkhnsqcqDY4D30RDLsFPezRxbWJ9"></script></span>
</div>


<!-- header scripts -->

    <script type="text/javascript" src="js/superfish.js"></script>
    <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
  	<script type="text/javascript" src="js/camera.js"></script>
	<script type="text/javascript" src="js/jtweet.js"></script>	
    <script type="text/javascript" src="js/jquery.cookie.js"></script> 
	<script type="text/javascript" src="js/jcarousellite.js"></script>	
  	<script>
        jQuery(document).ready(function(){   
                jQuery('.camera_wrap').camera();
				jQuery('a.prev, a.next, .camera_prev, .camera_next').animate({'opacity':'.45'},10);
				jQuery('a.prev, a.next, .camera_prev, .camera_next').hover(
						function () {
								jQuery(this).animate({'opacity':'1'},150);
						},
						function () {
								jQuery(this).animate({'opacity':'.45'},250);
						}
				);
			

			jQuery(function() { jQuery(".carousel").jCarouselLite({ btnNext: ".next", btnPrev: ".prev",auto:true, speed: 3000, visible: ($(".carousel li img").length>1)?4:2 }); });
			

          });    
  	</script>		
    <script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>

<!-- header scripts -->

<script type="text/javascript" src="js/bootstrap.js"></script>
<script>

$(document).ready(function() {
	$("#reset").click(function(){
        location.reload();
    }); 
	
});
</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-578cc5dfa6588974"></script>-->
<script type="text/javascript">
    
	/* function validatePass(p1, p2) {
		
			if (p1.value != p2.value || p1.value == '' || p2.value == '') {
				alert("Incorrect");
				p2.setCustomValidity('Password incorrect');
			} else {
				alert("Correct");
				p2.setCustomValidity('');
			}
		} */	
        
	$(document).ready(function(){ 
 
		$(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        }); 
 
        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
		
		$('#checkcode').click(function() {
				
				 $.ajax({
						type: "POST",
						url: "https://mybarnite.com/countAmount.php",
						data: {orderId :$("#OrderId").val(),Amount :$("#Amount1").val(),code :$("#code").val(),barId :$("#barId").val(),eventId :$("#eventId").val()},
							 success: function(result){
										setTimeout(function(){
										   window.location.reload(1);
										},500);
									
									//window.location="checkoutdetail.php?orderid=<?php echo $row['id'] ?>";
									
							 },
							error: function(){
								//alert("failure");
							}
				   });
			
		});
		<?php  if(isset($orderid)){?>
		$('#confirmEventOrder').click(function() {
				
				 $.ajax({
						type: "POST",
						url: "sendOrderConfirmation.php",
						data: {orderId :<?php echo $orderid;?>},
							 success: function(result){
								//alert(result);return false;
								window.location.href =	result; 
							 },
							error: function(){
								//alert("failure");
							}
				   });
			
		});
		/* $('#confirmBarOrder').click(function() {
				 checkAvailabilityForSeat();	
				 
			
		}); */
		<?php }?>
		
		$('#subscribeToNewsletter').click(function() {
				
				var emailId = document.getElementById("useremail").value;
				$("#newslettermsg").html("");;
				 $.ajax({
						type: "POST",
						url: "newsletter.php",
						data: {emailId :emailId,roleId:2},
							 success: function(result){
								//alert(result);return false;
								//window.location.href =	result; 
								$("#newslettermsg").html(result);
								$("#useremail").val("");
							 },
							error: function(){
								//alert("failure");
							}
				   });
			
		});

 
    });
	
	
</script>

<style>
.scrollup{position:fixed;bottom:0px;right:100px;display:none;}
</style>
<div class="scrollup"><a href="https://www.jqueryscript.net/tags.php?/Scroll/"><img src="img/icon_top.png" alt="Best local bars, pubs and nightclubs  in UK" style="width: 50px; height: 50px;"></a></div>
</body>
</html>