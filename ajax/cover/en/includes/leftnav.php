<div style="width:22%; float:left; margin-right:20px;">
    	<div class="dashboard_menu">MY ACCOUNT</div>
        
		<?php if($_SESSION['type'] == 'B') { ?>
        	<div class="leftmenu">
        	<ul>
            	<li><a href="dashboard.php">My Dashboard</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="reviews.php">My Reviews & Ratings</a></li>
                <li><a href="return-exchange.php">Return & Exchange</a></li>
                <li><a href="wishlist.php">My Wishlist</a></li>
                <li><div style="border-top:#e0e0e0 1px solid; height:1px; margin:5px 0;"></div></li>
                <li><a href="personal.php">Account Information</a></li>
                <li><a href="password.php">Change Password</a></li>
                <li><a href="address.php">Addresses</a></li>
                <li><a href="update.php">Notifications</a></li>
                <li><a href="deactive.php">Deactivate Account</a></li>
            </ul>
        </div>
        <?php } ?>
        
        <?php if($_SESSION['type'] != 'B') { ?>
        	<div class="leftmenu">
        	<ul>
            	<li><a href="dashboard.php">My Dashboard</a></li>
                <?php if($_SESSION['type'] == 'De') { ?>
                	<li><a href="my-labels.php">My Labels</a></li>
                <?php } ?>
                <li><a href="myProducts.php">Manage Shoes</a></li>
                <!--<li><a href="add-accesories.php">Add Accesories</a></li>-->
                <li><a href="myAccesories.php">Manage Accesories</a></li>
                <li><a href="myOrders.php">My Orders</a></li>
                <!--<li><a href="myWallet.php">My Wallet</a></li>
                <li><a href="myCoupons.php">Manage Coupons</a></li>
                <li><a href="myCustomers.php">Manage Customers</a></li>-->
                <li><a href="trackProducts.php">Track Orders</a></li>
                <li><a href="trends.php">Trend Alerts</a></li>
                <li><a href="check-demand.php">Pre-Launch Reviews</a></li>
                <li><a href="export-reports.php">Export Reports</a></li>
                <li><img src="images/newalert.png" width="30" height="16" alt="" /></li>
                <li style="margin:-8px 0 0 0;"><a href="manage-lsn.php">Low Stock Notification</a></li>
                <li><a href="advertising.php">Advertise With Us</a></li>
                <li><div style="border-top:#e0e0e0 1px solid; height:1px; margin:5px 0;"></div></li>
                <li><a href="companyInfo.php">Company Information</a></li>
                <li><a href="legals-generic.php">Legals and Generic</a></li>
                <li><a href="password.php">Change Password</a></li>
                <li><a href="bankDetails.php">Bank Details</a></li>
                <li><a href="myWallet.php">My Wallet</a></li>
                <li><a href="deactive.php">Deactivate Account</a></li>
            </ul>
  	</div>
        <?php } ?>        
        
        <?php if($_SESSION['type'] == 'B') { ?>
        <div class="midtitle">LAST VISITED PRODUCTS</div>
        
        <?php $lastvisit = mysql_query("SELECT DISTINCT pid FROM `lastvisited` WHERE uid = '".$_SESSION['id']."' ORDER by datetime DESC LIMIT 0, 5");
			  while($lastvisitArr = mysql_fetch_array($lastvisit)) { 
			  	$getVisit = mysql_fetch_array(mysql_query("SELECT * FROM `products` WHERE proid = '".$lastvisitArr['pid']."'")); ?>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><a href="details.php?id=<?php echo $getVisit['proid']; ?>"><?php if($getVisit['item_image1']!='' && (strlen($getVisit['item_image1']) > 5)) { ?><img src="upload/product/<?php echo $getVisit['item_image1']; ?>" width="66" height="66" style="border:#CCC 1px solid; margin-right:2px; cursor:pointer;" alt=""><?php } ?></a></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/norating.png" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">0 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title" style="font-size:16px;"><a href="details.php?id=<?php echo $getVisit['proid']; ?>"><?php echo $getVisit['product_name']; ?></a></div>
                <div>
		<!--<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span><?php echo $getVisit['sale_rate']; ?></span>&nbsp;&nbsp;-->
        <span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span><?php echo number_format($getVisit['sale_rate']); ?></span></div>
              </td>
            </tr>
          </table>
        </div>
        <?php } } ?>        
        
        <?php if($_SESSION['type'] == 'S') { ?>
        <div class="midtitle">RECENT ADDED PRODUCTS</div>
        
        <div class="text_grey" style="padding:10px 0;">No Product Available...</div>
        
        <!--<div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>
        <div style="border-bottom:#e0e0e0 1px solid; padding-bottom:8px; margin-bottom:8px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="32%" align="left" valign="top"><img src="images/smallicon.jpg" width="66" height="66" alt=""></td>
              <td width="68%" align="left" valign="top">
                <div>
                	<div style="width:50%; float:left;"><img src="images/starrating.jpg" width="62" height="13" alt=""></div>
                	<div style="width:50%; float:left; color:#aca7ae; text-align:right; font-size:12px; padding:2px 0 0 0; font-family:Arial, Helvetica, sans-serif;">1 Reviews(s)</div>
                </div>
                <div style="clear:both;"></div>
                <div class="title"><a href="#">NIKE SHOES</a></div>
                <div>
                	<span class="crossprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span>&nbsp;&nbsp;
                	<span class="blueprice"><span style="font-family:'Rupee_Foradian';">`</span>499.00</span></div>
              </td>
            </tr>
          </table>
        </div>-->
        <?php } ?>
        
  </div>