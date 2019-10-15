<?php $getuser = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$_SESSION['id']."'")); ?>
<div class="topgrey">
	<div class="container">
    	<div class="toplink">
            <ul>
            	<?php if($_SESSION['id']=='') { ?>
                	<li class="account_icon"><a href="register.php">register</a></li>
                	<li class="signin_icon"><a href="login.php">sign in</a></li>
                <?php } else { ?>
                    <li class="account_icon"><a href="logout.php">logout</a></li>
                    <li class="account_icon"><a href="dashboard.php">Dashboard</a></li>
                <?php } ?>
                <li class="shopping_icon"><a href="viewcart.php">shopping cart</a></li>
                <!--<li class="checkout_icon"><a href="#">checkout</a></li>-->
                <li class="wishlist_icon"><a href="wishlist.php">wishlist</a></li>
                <?php if($_SESSION['id']=='') { ?>
                	<li class="seller_icon"><a href="sell.php">Sell On Basicfeet</a></li>
                <?php } ?>
                <li class="track_icon"><a href="track-order.php">track order</a></li>
            </ul>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>

<div style="background-color:#FFF;">
	<div class="container">
	<div class="logo"><a href="index.php"><img src="images/logo.jpg" alt="" width="250" border="0"></a></div>
    <div style="width:770px; float:right;">
   	  <div class="contacts">
        	<ul>
                <li class="phone">09696345345<br><span>We are available 24X7</span></li>
                <li class="email">info@basicfeet.com<br><span>Our sales team will reach you.</span></li>
                <li class="whatsapp">+91.9696345345<br><span>We are always there for you</span></li>
                <?php $checkCartVal1 = mysql_query("SELECT SUM(totalPrice) AS COST FROM `mycart` WHERE uid = '".$_SESSION['id']."' AND success = 'P'"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>
                <li class="shoppingicon"><a href="viewcart.php">SHOPPING CART</a><br><span><?php $getCartVal = mysql_query("SELECT * FROM `mycart` WHERE uid = '".$_SESSION['id']."' AND success = 'P'"); if(mysql_num_rows($getCartVal) > 0) { echo mysql_num_rows($getCartVal); } else { echo '0'; } ?> Items(s) - <span style="font-family:'Rupee_Foradian';">`</span><?php if($cartArrayVal1[0] > 0) { echo number_format($cartArrayVal1[0]); } else { ?>0.00<?php } ?></span></li>
            </ul>
      </div>
      <div style="clear:both; height:12px;"></div>
        <div>
          <form id="form1" name="form1" method="post" action="search.php">
            <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td width="87%" align="right" valign="top"><input type="text" name="keyword" style="border:#e9e9e9 3px solid; border-right:none; padding:8px 6px 9px; width:460px;" placeholder="What are you looking?" required /></td>
                <td width="5%" align="left" valign="top"><input type="submit" name="search" id="button" value="" style="background-image:url(images/search.jpg); background-repeat:no-repeat; border:none; width:35px; height:40px; cursor:pointer;" /></td>
                <td width="8%" align="right" valign="middle"><a href="wishlist.php"><img src="images/likes.jpg" alt="" width="44" height="40" border="0" /></a></td>
              </tr>
            </table>
          </form>
        </div>
    </div>
</div>
	<div style="clear:both;"></div>
</div>

<div class="menubg">
	<div class="container">
    	<div id="ulwidth">
            <div class="dropdown">
                <ul>
                    <li onclick="window.location='men.php?id=1'">MEN
                        <ul style="width:1010px; background: #555; z-index:1000;">
                        <?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '1'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="men.php?id=1&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        </ul>
                	</li>
                    <li onclick="window.location='women.php?id=2'">WOMEN
                    	<ul style="width:956px; background: #555; z-index:1000;">
                        <?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '2'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="women.php?id=1&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                    <li class="newicon" onclick="window.location='brands.php'">BRANDS
                    	<ul style="width:870px; background: #555; z-index:1000;">
                        <?php $getmen = mysql_query("SELECT * FROM `manufacturers` ORDER by manufacturer ASC"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:116px; float:left;">
                              	<a href="brand-result.php?brand=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['manufacturer']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                    <li onclick="window.location='kids.php?id=7'">KIDS
                    	<ul style="width:790px; background: #555; z-index:1000;">
                        	
                            <li style="width:762px;"><strong>Baby Boy <span style="font-size:11px;">(Age 0-2 yrs)</span></strong></li>
						<?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '7'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="kids.php?id=5&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        
                        	<li style="width:762px;"><strong>Baby Girl <span style="font-size:11px;">(Age 0-2 yrs)</span></strong></li>
                        <?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '8'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="kids.php?id=6&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        
                        	<li style="width:762px;"><strong>Boys Shoes <span style="font-size:11px;">(Age 2-12 yrs)</span></strong></li>
                        <?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '5'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="kids.php?id=6&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        
                        	<li style="width:762px;"><strong>Girls Shoes <span style="font-size:11px;">(Age 2-12 yrs)</span></strong></li>
                        <?php $getmen = mysql_query("SELECT * FROM `subcat` WHERE catid = '6'"); 
							  while($getmenArr1 = mysql_fetch_array($getmen)) { ?>
                              <li style="width:120px; float:left;">
                              	<a href="kids.php?id=6&category=<?php echo $getmenArr1['id']; ?>"><?php echo $getmenArr1['subcat']; ?></a></li>
                        <?php } ?>
                        
                        </ul>
                    </li>
                    <li class="hoticon" onclick="window.location='new-arrival.php'">NEW ARRIVALS</li>
                    <li style="border-left:#d3d5d7 1px solid;" onclick="window.location='new-accesories.php?id=4'">Accessories</li>
                </ul>
    		</div>
      </div>
		    <div class="specialmenu">
                <ul>
                    <li><a href="designers.php"><img src="images/designers-btn.png" alt="" height="18" border="0"></a></li>
                    <li><a href="walking-easy.php"><img src="images/walking-btn.png" alt="" height="18" border="0"></a></li>
                    <li><a href="trending.php"><img src="images/trending-btn.png" alt="" height="18" border="0"></a></li>
                    <li><a href="midnight-sale.php"><img src="images/mid-night-sale-btn.png" alt="" height="18" border="0"></a></li>
                </ul>
            </div>
            <div style="clear:both;"></div>
    </div>
</div>