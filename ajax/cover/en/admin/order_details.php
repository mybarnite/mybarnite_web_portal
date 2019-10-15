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
            <div class="welcome"><a href="#" title=""><img src="images/userPic.png" alt="" /></a><span>Howdy, Admin!</span></div>
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
    	<div class="title"><h5>Orders / Quotes</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
                <div class="widget first">
                    <div class="head"><h5 class="iList">Manage Order <strong><?php echo 'BF'.$_REQUEST['order_id']; ?></strong></h5></div>
                    <div style="padding:10px;">
            <?php $getTransaction = mysql_query("SELECT * FROM orders WHERE orderid = '".$_REQUEST['order_id']."'");
			$shoppingVal = mysql_fetch_array($getTransaction); ?>
            <table width="50%" border="0" cellspacing="0" cellpadding="0" style="border:#cccccc 1px solid; border-bottom:2px solid #cccccc;">
              <tr>
                <td style="padding:6px;"><div style="border-bottom:#333 2px solid; padding:5px 0 5px 0; font-size:16px;">Order Summary</div></td>
                <td style="padding:6px;"><div style="border-bottom:#333 2px solid; padding:5px 0 5px 0; font-size:16px;">Shipping Address</div></td>
              </tr>
              <tr>
                <td width="50%" align="left" valign="top" style="padding:6px;">
                <div style="padding:0 0 8px 0; border-bottom:#cccccc 1px solid;"><?php echo mysql_num_rows($getTransaction); ?> Items</div>
                <div style="padding:8px 0 8px 0; border-bottom:#cccccc 1px solid;">Order ID: <strong>BF<?php echo $_REQUEST['order_id']; ?></strong></div>
                <div style="padding:8px 0 8px 0; border-bottom:#cccccc 1px solid;">Date: <?php echo $shoppingVal['date']; ?></div>
<div style="padding:8px 0 8px 0;">Total: <?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders` WHERE orderid = '".$shoppingVal['orderid']."'"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?><strong style="font-size:20px;">Rs. <?php echo number_format($cartArrayVal1[0]); ?></strong></div>
                
                <div style="padding:8px 0 8px 0;">
                <?php if($shoppingVal['status'] == 'Y') { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16%" align="left" valign="top"><img src="images/1338632217_001_06.gif" alt="" /></td>
                      <td width="84%" align="left" valign="top" style="color:#090; font-size:15px;">Success</td>
                    </tr>
                  </table>
                  <?php } ?>
                  
                  <?php if($shoppingVal['status'] == 'N') { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16%" align="left" valign="top"><img src="images/1338632000_block.png" width="24" height="24" alt="" /></td>
                      <td width="84%" align="left" valign="top" style="color:#F00; font-size:15px;">Pending</td>
                    </tr>
                  </table>
                  <?php } ?>
                </div>
                
                </td>
                <td width="50%" align="left" valign="top" style="padding:6px; line-height:18px;">
                <div style="padding:0 0 9px 0; border-bottom:#cccccc 1px solid; font-weight:bold;"><?php echo $shoppingVal['firstname']; ?> <?php echo $shoppingVal['lastname']; ?></div>
                <div style="padding:5px 0 8px 0; border-bottom:#cccccc 1px solid; line-height:20px;">
				<?php if($shoppingVal['address1'] != '') { echo $shoppingVal['address1'].','; } ?>
				<?php if($shoppingVal['address2'] != '') { echo $shoppingVal['address2'].','; } ?>
                <?php if($shoppingVal['country'] != '') { echo $shoppingVal['country'].','; } ?>
                <?php if($shoppingVal['state'] != '') { echo $shoppingVal['state'].','; } ?>
                <?php if($shoppingVal['city'] != '') { echo $shoppingVal['city'].','; } ?>
                <?php if($shoppingVal['zip_code'] != '') { echo $shoppingVal['zip_code'].','; } ?></div>
                <div style="padding:0 0 8px 0;"><?php echo $shoppingVal['telephone']; ?></div>
                </td>
              </tr>
            </table>
          </div>
          <div style="text-align:left; font-size:16px; padding:0 0 10px 10px;">Order ID: <strong>BF<?php echo $_REQUEST['order_id']; ?></strong></div>
		  <div style="padding:10px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
	        <tr>
                <td width="30%" style="background-color:#f2f2f2; padding:7px 0 7px 8px;"><strong>Product Name</strong></td>
                <td width="24%" align="center" valign="middle" style="background-color:#f2f2f2; padding:7px 0 7px 0;"><strong>Seller</strong></td>
                <td width="14%" align="center" valign="middle" style="background-color:#f2f2f2; padding:7px 0 7px 0;"><strong>Price</strong></td>
                <td width="9%" align="center" valign="middle" style="background-color:#f2f2f2; padding:7px 0 7px 0;"><strong>Size</strong></td>
                <td width="10%" align="center" valign="middle" style="background-color:#f2f2f2; padding:7px 0 7px 0;"><strong>Quantity</strong></td>
                <td width="13%" align="center" valign="middle" style="background-color:#f2f2f2; padding:7px 0 7px 0;"><strong>Total Price</strong></td>
		   </tr>
    	  	  <?php
			  $getloopVal = mysql_query("SELECT * FROM orders WHERE orderid = '".$_REQUEST['order_id']."' AND `status` = 'Y'");
			  while($transID1 = mysql_fetch_array($getloopVal)) { 
			  	$getResultVal = mysql_fetch_array(mysql_query("SELECT * FROM products WHERE proid = '".$transID1['proid']."'"));
			  ?>
              <tr style="border-bottom:#cccccc 1px solid;">
                <td width="30%" height="28" align="left" valign="top" style="padding:6px 0 6px 8px;">
				<a href="../details.php?id=<?php echo $getResultVal['proid']; ?>" target="_blank"><?php echo $getResultVal['product_name']; ?></a></td>
                <td width="24%" height="28" align="center"><?php $getSeller = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$transID1['sellerid']."'")); ?><a href="seller-details.php?id=<?php echo $getSeller['id']; ?>"><?php echo $getSeller['company_name']; ?></a></td>
                <td width="14%" height="28" align="center"><?php echo 'Rs. '.number_format($transID1['price']); ?> /each</td>
                <td width="9%" height="28" align="center"><?php echo $transID1['size']; ?></td>
                <td width="10%" height="28" align="center"><?php echo $transID1['quantity']; ?></td>
                <td width="13%" height="28" align="center"><?php echo 'Rs.'.number_format($transID1['total_price'],2); ?></td>
      		  </tr>
              <?php } ?> 
		  </table>
          		</div>
               <fieldset>
            </fieldset>
            <div class="fix"></div>
            </div>
            </fieldset>
            <!-- WYSIWYG editor -->
        </form>
        <!-- Charts -->
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