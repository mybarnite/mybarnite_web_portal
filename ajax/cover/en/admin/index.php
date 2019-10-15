<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<title>Basicfeet - Admin Control Panel</title>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.4.4.js" type="text/javascript"></script>

<script type="text/javascript" src="js/spinner/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/spinner/ui.spinner.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

<script type="text/javascript" src="js/fileManager/elfinder.min.js"></script>

<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="js/wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="js/wysiwyg/wysiwyg.table.js"></script>

<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/excanvas.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.resize.js"></script>

<script type="text/javascript" src="js/dataTables/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/dataTables/colResizable.min.js"></script>

<script type="text/javascript" src="js/forms/forms.js"></script>
<script type="text/javascript" src="js/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="js/forms/autotab.js"></script>
<script type="text/javascript" src="js/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/forms/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="js/forms/jquery.filestyle.js"></script>

<script type="text/javascript" src="js/colorPicker/colorpicker.js"></script>

<script type="text/javascript" src="js/uploader/plupload.js"></script>
<script type="text/javascript" src="js/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="js/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="js/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="js/ui/progress.js"></script>
<script type="text/javascript" src="js/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/ui/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/ui/jquery.alerts.js"></script>

<script type="text/javascript" src="js/wizards/jquery.form.wizard.js"></script>
<script type="text/javascript" src="js/wizards/jquery.validate.js"></script>
<script type="text/javascript" src="js/wizards/jquery.smartWizard.min.js"></script>

<script type="text/javascript" src="js/jBreadCrumb.1.1.js"></script>
<script type="text/javascript" src="js/cal.min.js"></script>
<script type="text/javascript" src="js/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="js/jquery.ToTop.js"></script>
<script type="text/javascript" src="js/jquery.listnav.js"></script>
<script type="text/javascript" src="js/jquery.sourcerer.js"></script>
<script type="text/javascript" src="js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>

<script type="text/javascript" src="js/custom.js"></script>

</head>

<body>

<!-- Top navigation bar -->
<div id="topNav">
    <div class="fixed">
        <div class="wrapper">
            <div class="welcome"><a href="#" title=""><img src="images/userPic.png" alt="" /></a><span style="text-transform:capitalize;">Howdy, <?php echo $_SESSION['username']; ?></span></div>
            <div class="userNav">
                <ul>
                    <li><a href="website-settings.php" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>
                    <li><a href="logout.php" title=""><img src="images/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>

<!-- Header -->
<div id="header" class="wrapper">
    <div class="logo"><?php $getlogo = mysql_fetch_array(mysql_query("SELECT * FROM `website_settings` WHERE id = '1'")); ?><a href="index.php"><img src="../upload/logo/<?php echo $getlogo['site_logo']; ?>" alt="" border="0" /></a></div>
    <div class="middleNav">
    	<ul>
        	<li class="iStat"><a href="index.php" title=""><span>Dashboard</span></a></li>
        	<li class="iMes"><a href="support.php" title=""><span>Support</span></a></li>
            <li class="iView"><a href="manage-product.php" title=""><span>Products</span></a></li>
            <li class="iUser"><a href="merchants.php" title=""><span>All Sellers</span></a></li>
        </ul>
    </div>
    <div class="fix"></div>
</div>


<!-- Content wrapper -->
<div class="wrapper">
	
	<!-- Left navigation -->
    <?php include'include/leftnav.php';?>
    
    <!-- Content -->
  <div class="content">
    	<div class="title"><h5>Dashboard</h5></div>
        
        <!-- Statistics -->
        <div class="stats">
        	<ul>
            	<li><a href="all-user.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `register` WHERE type = 'B'")); ?></a><span>Total Buyers</span></li>
                <li><a href="manage-product.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `products`")); ?></a><span>Total Products</span></li>
                <li><a href="merchants.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `register` WHERE type != 'B'")); ?></a><span>Total Sellers</span></li>
                <li class="last"><a href="#" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `orders` WHERE success = 'Y'")); ?></a><span>Total Orders</span></li>
            </ul>
            	<div style="clear:both;"></div>
            <ul style="margin:12px 0;">
            	<li><a href="buyer-cancel.php" class="count grey" title="">0</a><span>Order Cancel - Buyer</span></li>
                <li><a href="seller-cancel.php" class="count grey" title="">0</a><span>Order Cancel - Seller</span></li>
                <li><a href="#" class="count grey" title="">1</a><span>Order Accept - Seller</span></li>
                <li class="last"><a href="designerLabels.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `labels` WHERE status = 'N'")); ?></a><span>New Label Request</span></li>
            </ul>
            	<div style="clear:both;"></div>
            <ul style="margin:12px 0;">
            	<li><a href="manage-product.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `products` WHERE status = 'N'")); ?></a><span>New Product - Pending</span></li>
                <li><a href="wefind-notify.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `wefind_notify`")); ?></a><span>We find notification</span></li>
                <li><a href="low-stock-notify.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `products` WHERE qtynos < 3")); ?></a><span>Low Stock Notification</span></li>
                <li class="last"><a href="withdrawRequest.php" class="count grey" title="">0</a><span>Withdraw request</span></li>
            </ul>
            	<div style="clear:both;"></div>
            <ul style="margin:12px 0;">
            	<li><a href="return_exchange.php" class="count grey" title=""><?php echo mysql_num_rows(mysql_query("SELECT * FROM `register` WHERE type = 'B'")); ?></a><span>Return Request</span></li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li class="last">&nbsp;</li>
            </ul>
            <div class="fix"></div>
        </div>
               
        <div class="widget first">
            <div class="head"><h5 class="iUsers">New Registered Buyers</h5></div>
			<div class="body" style="padding:10px;">
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr style="background-color:#3a3e47; color:#FFF;">
                      <td width="19%" height="28" align="left" valign="middle" style="padding:6px 0 0 8px;"><strong>Date</strong></td>
                      <td width="31%" height="28" align="center" valign="middle"><strong>Buyer Name</strong></td>
                      <td width="25%" height="28" align="center" valign="middle"><strong>Phone Number</strong></td>
                      <td width="25%" height="28" align="center" valign="middle"><strong>Email</strong></td>
                    </tr>
                    <?php $getQuery = mysql_query("SELECT * FROM `register` WHERE type = 'B' ORDER BY id DESC");
						  while($getValue = mysql_fetch_array($getQuery)) { ?>
                    <tr>
                      <td height="25" align="left" valign="middle" style="padding:12px 0 0 8px; border-bottom:#CCC 1px solid;"><?php echo $getValue['date']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['firstname'].' '.$getValue['lastname']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['phone']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['email']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                 	<div style="text-align:right; padding:6px 0 0 0;"><a href="all-user.php">View All</a></div> 
				</div>
            </div>
      </div>
                        
		<div class="widget first">
            <div class="head"><h5 class="iUsers">New Registered Sellers/Vendors</h5></div>
			<div class="body" style="padding:10px;">
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr style="background-color:#3a3e47; color:#FFF;">
                      <td width="19%" height="28" align="left" valign="middle" style="padding:6px 0 0 8px;"><strong>Date</strong></td>
                      <td width="31%" height="28" align="center" valign="middle"><strong>Company Name</strong></td>
                      <td width="25%" height="28" align="center" valign="middle"><strong>Seller Name</strong></td>
                      <td width="25%" height="28" align="center" valign="middle"><strong>Email</strong></td>
                    </tr>
                    <?php $getQuery = mysql_query("SELECT * FROM `register` WHERE type != 'B' ORDER BY id DESC");
						  while($getValue = mysql_fetch_array($getQuery)) { ?>
                    <tr>
                      <td height="25" align="left" valign="middle" style="padding:12px 0 0 8px; border-bottom:#CCC 1px solid;"><?php echo $getValue['date']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['company_name']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['firstname'].' '.$getValue['lastname']; ?></td>
                      <td height="25" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $getValue['email']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                 	<div style="text-align:right; padding:6px 0 0 0;"><a href="merchants.php">View All</a></div> 
				</div>
            </div>
      </div>
                
        <!-- Charts -->
    	<div class="widget first">
            <div class="head"><h5 class="iGraph">Statistics</h5></div>
            <div class="body"><?php $gettrsVal = mysql_fetch_array(mysql_query("SELECT SUM(amount) AS COST FROM transaction WHERE date = '".date("d M, Y")."' AND status = 'Y'")); ?>
            <div>Sales total, today:  <strong><?php echo 'Rs. '.number_format($gettrsVal[0]); ?></strong>&nbsp;&nbsp;&nbsp;Number of orders, today:  <strong><?php $gettrsVal1 = mysql_num_rows(mysql_query("SELECT * FROM transaction WHERE date = '".date("d M, Y")."' AND status = 'Y'")); echo $gettrsVal1; ?></strong></strong></div>
                
            </div>
			<div class="body" style="padding-top:0px;">
              <div style="background-color:#2b7dc7; padding:5px 5px 5px 8px; color:#FFF; font-weight:bold; margin-bottom:1px;">Recent Visitors</div>
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="19%" height="30" align="left" valign="middle" style="padding:6px 0 0 8px; background-color:#3a3e47; color:#FFF;"><strong>Time stamp</strong></td>
                      <td width="18%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Repeat visitor</strong></td>
                      <td width="17%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>IP #, Server name</strong></td>
                      <td width="46%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Browser / OS</strong></td>
                    </tr>
                    <?php
					$getVisitor = mysql_query("SELECT * FROM visitor ORDER by id DESC LIMIT 0, 15");
					while($trackUser = mysql_fetch_array($getVisitor))
					{
					?>
                    <tr>
                      <td width="19%" height="34" align="left" valign="middle" style="padding:6px 0 0 8px; border-bottom:#CCC 1px solid;"><?php echo $trackUser['timestamp']; ?></td>
                      <td width="18%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $trackUser['again']; ?></td>
                      <td width="17%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $trackUser['IP']; ?></td>
                      <td width="46%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $trackUser['browser']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
</div>
            </div>
      </div>
        
      <!-- Calendar -->
      <!-- Full width tabs -->
      <!-- Dynamic table -->
      <!-- Widgets -->
    </div>
    <div class="fix"></div>
</div>

<!-- Footer -->
<div id="footer">
	<div class="wrapper">
    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved. </span>
    </div>
</div>

</body>
</html>