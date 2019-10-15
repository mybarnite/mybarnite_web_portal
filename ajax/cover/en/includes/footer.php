<div style="border-top:#d9d9d9 3px solid; background-image:url(images/bgtexture.jpg); min-height:220px;">
	<div class="container">
    	<div style="width:25%; float:left;">
        	<div class="footerHead">Information</div>
            <div class="footermenu">
            	<ul>
                	<li><a href="blog.php">Our Blog</a></li>
                    <li><a href="about.php">About Basicfeet</a></li>
                    <li><a href="product-reviews.php">Review Requested</a></li>
                    <li><a href="pages.php?id=2">Privacy Policy</a></li>
                    <li><a href="pages.php?id=3">Delivery Information</a></li>
                </ul>
            </div>
        </div>
        <div style="width:25%; float:left;">
        	<div class="footerHead">Customer Care</div>
            <div class="footermenu">
            	<ul>
                	<li><a href="contact.php">Contact Us</a></li>
                    <li><a href="sitemap.php">Sitemap</a></li>
                    <li><a href="pages.php?id=5">Terms &amp; Conditions</a></li>
                    <li><a href="pages.php?id=19">Careers</a></li>
                    <li><a href="best-sellers.php">Best Sellers</a></li>
                </ul>
            </div>
        </div>
        <div style="width:25%; float:left;">
        	<div class="footerHead">Your Account</div>
            <div class="footermenu">
            	<ul>
                	<li><a href="<?php if($_SESSION['type']=='B') { ?>orders.php<?php } else { ?>myOrders.php<?php } ?>">My Orders</a></li>
                  	<li><?php if($_SESSION['type']=='B') { ?>
                    	<a href="wishlist.php">My Wishlist</a><?php } else { ?><a href="myWallet.php">My Wallet</a><?php } ?></li>
                    <li><?php if($_SESSION['type']=='B') { ?>
                    	<a href="reviews.php">My Reviews</a><?php } else { ?><a href="myProducts.php">Manage Shoes</a><?php } ?></li>
                	<li><?php if($_SESSION['type']=='B') { ?>
                    	<a href="payments.php">My Payments</a><?php } else { ?><a href="myCustomers.php">Manage Customers</a><?php } ?></li>
                </ul>
            </div>
        </div>
        <div style="width:25%; float:left;">
        	<div class="footerHead">Newsletter Subscribe</div>
          <div style="font-family:Georgia; font-size:13px; color:#666; padding-left:10px; line-height:18px;">Subscribe to be the first to know about Sales, Events, and Exclusive Offers!</div>
            <div style="padding:10px 0; margin-left:8px;">
              <form name="form1" method="post" action="">
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              	  <tr>
              	    <td><input type="text" name="textfield2" class="newsketter_input" placeholder="Enter your email"></td>
              	    <td><input type="submit" name="button" id="button" value="" class="sendbutton"></td>
           	      </tr>
           	    </table>
              </form>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<div style="background-color:#1c1c1c;">
	<div class="container">
    	<div style="text-align:center; padding-bottom:20px;"><a href="#"><img src="images/pgtop.jpg" alt="" width="58" height="16" border="0"></a></div>
        <div style="width:25%; float:left;"><a href="index.php"><img src="images/footer_logo.jpg" alt="" width="211" height="87" border="0"></a></div>
      <div class="copyright">Copyright &copy; <?php echo date("Y"); ?> basicfeet.com. All Rights Reserved.<br>Mobile: <span>+91.9696345345</span><br>Email: <span>info@basicfeet.com</span></div>
        <div class="copyright" style="width:35%; text-align:right;"><a href="sitemap.php">Sitemap</a><!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Advanced</a>-->&nbsp;&nbsp;&nbsp;&nbsp;<a href="pages.php?id=7">Orders and Returns</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.php">Contact Us</a><!--<br>Designed by: <span>WebMantra</span>--></div>
    </div>
    
    <div style="clear:both;"></div>
    
    <div style="border-top:#101010 2px solid; margin:20px 0 0 0;">
    	<div class="container">
        	<div style="width:55%; float:left;">
            	<div class="socialicon">
                	<ul>
                    	<li style="padding-left:0px; margin-left:0px;">CONNECT US</li>
                        <li class="fbicon"><a href="https://www.facebook.com/Basicfeetonline?fref=ts" target="_blank">Facebook</a></li>
                        <li class="twitter"><a href="https://twitter.com/Basicfeet" target="_blank">Twitter</a></li>
                        <li class="pinterest"><a href="https://www.pinterest.com/basicfeet/" target="_blank">Pinterest</a></li>
                        <li class="google"><a href="https://vimeo.com/basicfeet" target="_blank">Vimeo</a></li>
                        <li class="google"><a href="https://instagram.com/basicfeet/" target="_blank">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div style="width:45%; float:left;">
            	<div class="paymenttrans">
                	<ul>
                    	<li>Payment Method</li>
                        <li><img src="images/creditcard.jpg" width="191" height="22" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<!--<script type="text/javascript" src="http://basicfeet.com/livechat/php/app.php?widget-init.js"></script>-->

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5690f5d961001a157dd248d3/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<!--Start of Google Analytics Script-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67272664-1', 'auto');
  ga('send', 'pageview');

</script>
<!--End of Google Analytics Script-->

<!-- Start of StatCounter Code for Dreamweaver -->
<script type="text/javascript">
var sc_project=10799883; 
var sc_invisible=1; 
var sc_security="b889f404"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="shopify traffic
stats" href="http://statcounter.com/shopify/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/10799883/0/b889f404/1/"
alt="shopify traffic stats"></a></div></noscript>
<!-- End of StatCounter Code for Dreamweaver -->