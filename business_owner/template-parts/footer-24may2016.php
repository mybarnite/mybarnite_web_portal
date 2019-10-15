 <!--==============================Bottom content=================================--> 
<aside id="bottom-content">
  <div class="container divider">
    <div class="row ">
        <div class="clearfix ">
			  <div class="span4 ">
				<h2>Most popular Nightclubs</h2>
				<a href="#">
					<img src="../images/img5.jpg" alt="" width="61" height="61" border="0" class="alignleft border_img" />
				</a>
				<p>
					<strong>NightClub Name here </strong>
				Content goes here Content goes here Content goes here.
				Content goes here Content goes here.
				</p>
				<div class="clearfix"></div>
				
				<a href="#">
					<img src="../images/img5.jpg" alt="" width="61" height="61" border="0" class="alignleft border_img" />
				</a>
				<p>
					<strong>NightClub Name here </strong>
				Content goes here Content goes here Content goes here.
				Content goes here Content goes here.
				</p>
				<div class="clearfix"></div>
				
				
				<div class="padcontent"></div>
			  </div>
			  
			  <div class="span4 ">
				<h2><img src="../images/twitter.png" alt="" width="45" height="38" border="0" />&nbsp;&nbsp;Latest tweets</h2>
				  <div class="clearfix"></div>
				
				<a href="#">
					<img src="../images/img5.jpg" alt="" width="61" height="61" border="0" class="alignleft border_img" />
				</a>
				<p>
					<strong>Your Caption here </strong>
				Content goes here Content goes here Content goes here.
				Content goes here Content goes here.
				</p>
				 <div class="clearfix"></div>
				
				<a href="#">
					<img src="../images/img5.jpg" alt="" width="61" height="61" border="0" class="alignleft border_img" />
				</a>
				<p>
					<strong>Your Caption here </strong>
				Content goes here Content goes here Content goes here.
				Content goes here Content goes here.
				</p>
				
			  </div>
			  
			  <?php
				$db->select('bottom_banner','*','','id=1','id DESC',''); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
				$result = $db->getResult();
				
				
			?>
			  
			  <div class="span3 offset1 ">
				<h2>Your Caption here</h2>
				<a href="#">
					<img src="<?php echo SITE_PATH;?>/adminimages/banner/<?php echo $result[0]['banner_image'];?>" alt=""  border="0" class="aligncenter border_img" />
				</a>
				<p>
					<strong><?php echo $result[0]['heading'] ?> </strong>
				<?php echo $result[0]['desc'] ?>
				</p>
				
				<div class="padcontent"></div>
			  </div>
			
        </div>
   
    </div>
 
 <div class="row copyright">
    
	  <div class="span8">
	
				Copyright © 2015. Designed &amp; Developed by <span style="color:#3179d8">Mybarnite</span>
				
      </div>
	
	<!-- {%FOOTER_LINK} -->
      <div class="span4">
			<ul class="footer_links">
				  <li><a href="#">Privacy Policy</a></li>
				  <li>|</li>
				  <li><a href="<?php echo SITE_PATH;?>contact.php">Contact Us</a></li>
			</ul>       
      </div>
    </div>
	
	
  </div>    
</aside>


</div>
<script type="text/javascript" src="../js/bootstrap.js"></script>
</body>
</html>