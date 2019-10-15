<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['DelId'])!='')
{
	mysql_query("DELETE FROM contacts WHERE support_id = '".$_REQUEST['DelId']."' ");
	header("location:support.php");
	exit;
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
    	<div class="title">
    	  <h5>Payment</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        	<div class="head"><h5 class="iFrames">Manage Orders</h5></div>
          
          <?php $getTransaction = mysql_query("SELECT DISTINCT orderid FROM orders WHERE status = 'Y' ORDER BY id DESC"); 
		  		if(mysql_num_rows($getTransaction) > 0) { while($orderArray = mysql_fetch_array($getTransaction)) { ?> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div class="orderID" onClick="window.location='order_details.php?order_id=<?php echo $orderArray['orderid']; ?>&src=od&link=order_number'" style="cursor:pointer; padding:8px; font-size:16px; font-weight:bold; color:#06F;"><?php echo $orderArray['orderid']; ?></div></td>
            </tr>
            <tr>
              <td><?php $getOrder = mysql_query("SELECT * FROM orders WHERE orderid = '".$orderArray['orderid']."'"); 
			  		while($getOrderArr = mysql_fetch_array($getOrder)) { 
					$product = mysql_fetch_array(mysql_query("SELECT * FROM `products` WHERE proid = '".$getOrderArr['proid']."'")); ?>
            <div style="border-bottom:#e2ecf5 1px solid; padding:6px 0;">
           	<div style="width:12%; float:left; padding-left:8px;"><img src="../upload/product/<?php echo $product['item_image1']; ?>" width="66" height="66" alt="" style="border:#e2ecf5 1px solid;"></div>
            <div style="width:25%; float:left;">
                	<div><a href="../details.php?id=<?php echo $product['proid']; ?>" target="_blank"><?php echo $product['product_name']; ?></a></div>
            <div style="color:#999; font-family:Arial, Helvetica, sans-serif; font-size:12px; padding:5px 0; line-height:20px;">Shoe Size: <strong><?php echo $getOrderArr['size']; ?></strong><br>Quantity: <strong><?php echo $getOrderArr['quantity']; ?></strong></div></div>
            
            <div style="width:46%; float:left;">Order Placed: <?php echo $getOrderArr['date']; ?><div style="color:#a5a5a5; padding:6px 0 5px 0;">Seller: <?php $getSeller = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$getOrderArr['sellerid']."'")); ?><a href="../designer-page.php?uid=<?php echo $getOrderArr['sellerid']; ?>" target="_blank"><?php echo $getSeller['company_name']; ?></a></div> Delivery expected by <?php $date = $getOrderArr['date']; $date = strtotime($date); $date = strtotime("+7 day", $date); echo date('d F, Y', $date); ?><div style="color:#a5a5a5; padding:3px 0; font-size:12px; color:#090;">Your item has been confirmed</div></div>
            
            <div style="width:15%; float:left;"><a href="<?php if($getOrderArr['shipping_code']!='') { ?>http://track.delhivery.com/p/<?php echo $getOrderArr['shipping_code']; } else { ?>#<?php } ?>"<?php if($getOrderArr['shipping_code']=='') { ?> onClick="return confirm('Tracking details will be available after the product will be shipped.')"<?php } ?> <?php if($getOrderArr['shipping_code']!='') { ?>target="_blank"<?php } ?>><img src="../images/track_order.jpg" alt="" width="98" height="26" border="0"></a><br><a href="#" onClick="return confirm('Try after some time.')">Update Status</a></div>
            	<div style="clear:both;"></div>
            </div>
 			<?php } ?>
            
          <div class="order_total" style="text-align:right; padding:8px;">O<span>rder</span> T<span>otal</span>: <strong><?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders` WHERE orderid = '".$orderArray['orderid']."'"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?><strong style="font-size:18px;">Rs. <?php echo number_format($cartArrayVal1[0]); ?></strong></strong></div>
            </td>
            </tr>
          </table>
          
			<?php } } else { ?>
       	  <div class="text_grey" style="text-align:center; padding:30px 0;">You have placed no orders.</div>
        <?php } ?>
          
      </div>
        
                
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
