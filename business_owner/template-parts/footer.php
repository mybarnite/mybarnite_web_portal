 <!--==============================Bottom content=================================--> 
<aside id="bottom-content">
  <div class="container divider">
    <div class="row ">
        <div class="clearfix ">
			  
			  <div class="span4">
				
				<h5 class="footer-title-h5">Subscribe to our newsletter</h5>
				
			
				<input type="text" id="useremail" name="useremail" class="input-field-newsletter"  placeholder="Enter your Email">
				<span>  <button type="button" class="btn btn-primary btn-newsletter" id="subscribeToNewsletter">Go</button></span>
				<span id="newslettermsg">  </span>
			  </div>
			  
			  <?php 
			  
			  require_once($_SERVER["DOCUMENT_ROOT"].'/twitter.php');
			  ?>
			  <div class="span4">
				<h5 class="footer-title-h5"><img src="https://mybarnite.com/images/twitter.png" alt="" width="45" height="38" border="0" />&nbsp;&nbsp;Latest tweets</h5>
					<div class="clearfix"></div>
				<?php 
				foreach($feeds as $feed)
				{
				
				?>
					<a href="https://twitter.com/mybarnite" target="_blank">
						<img src="<?php echo $feed->user->profile_image_url_https;?>" alt="" width="61" height="61" border="0" class="alignleft border_img" />
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
					$db->select('bottom_banner','*','','id=1','id DESC',''); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
					$result = $db->getResult();
				?>
			  
			  <div class="span4">
				<h5 class="footer-title-h5">Follow us on Facebook</h5>
				<a href="https://www.facebook.com/mybarnitelondon/" target="_blank">
					<img src="<?php echo SITE_PATH;?>/images/img4.jpg" alt=""  border="0" class="aligncenter border_img" />
				</a>
				<p>
				<a style="text-decoration:none" href="https://www.facebook.com/mybarnitelondon/" target="_blank">	<strong><?php echo $result[0]['heading'] ?> </strong></a>
				<?php echo $result[0]['desc'] ?>
				</p>
				<div class="padcontent"></div>
			  </div>
			
        </div>
   
    </div>
 
 <div class="row copyright">
    
	  <div class="span8">
	
				Copyright © 2018. Designed &amp; Developed by <span style="color:#3179d8">Mybarnite</span>
				
      </div>
	
	<!-- {%FOOTER_LINK} -->
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


</div>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-578cc5dfa6588974"></script>-->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title red" style="font-size:15px;">It seems you don't have any subscription activated , please choose any one option from below for adding event.</div>
      </div>
      <div class="modal-body">
		<form class="form-inline" role="form" id="bar_events" method="post">
			<div class="form-group">
				<label class="radio-inline" style="margin:0 22px 0 0;font-size: 15px;"><input type="radio" name="subType" id="subType" value="1" style="margin:0 10px 0 0;vertical-align:middle">Pay as you go</label>
				<label class="radio-inline" style="margin:0 22px 0 0;font-size: 15px;"><input type="radio" name="subType" id="subType" value="2" style="margin:0 10px 0 0;vertical-align:middle">Buy subscription</label>
			</div>
		</div>	
      </div>
      
    </div>

  </div>
<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=8mPgVVmRZCLCwqSvDnfFUDyajZVGGLdqFkhnsqcqDY4D30RDLsFPezRxbWJ9"></script></span> 
</div>

<script type="text/javascript">
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
		
		$('#subscribeToNewsletter').click(function() {
				
				var emailId = document.getElementById("useremail").value;
				$("#newslettermsg").html("");;
				 $.ajax({
						type: "POST",
						url: "<?php echo SITE_PATH;?>/newsletter.php",
						data: {emailId :emailId,roleId:1},
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
<div class="scrollup"><a href="https://www.jqueryscript.net/tags.php?/Scroll/"><img src="../img/icon_top.png" alt="" style="width: 50px; height: 50px;"></a></div>

</body>
</html>