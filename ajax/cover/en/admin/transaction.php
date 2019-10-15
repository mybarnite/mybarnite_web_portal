<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['DelId'])!='')
{
	$UpdateData = mysql_query("DELETE FROM transaction WHERE id = '".$_REQUEST['DelId']."'");
	header("location:transaction.php");
	exit;
}

if(isset($_REQUEST['activate'])!= '')
{
	if(isset($_REQUEST['update']) && $_REQUEST['update'] == 'Y') 
	{
	$ShowTrans = mysql_fetch_array(mysql_query("SELECT * FROM transaction WHERE transaction_code = '".$_REQUEST['activate']."'"));
	$UpdateValue = mysql_query("UPDATE transaction SET status = '".$_REQUEST['update']."' WHERE transaction_code = '".$_REQUEST['activate']."'");
	$UpdateCart = mysql_query("UPDATE mycart SET success = 'S', TranKey = '".$_REQUEST['activate']."' WHERE uid = '".$ShowTrans['uid']."'");
	} 
	else 
	{
	$ShowTrans = mysql_fetch_array(mysql_query("SELECT * FROM transaction WHERE transaction_code = '".$_REQUEST['activate']."'"));
	$UpdateValue = mysql_query("UPDATE transaction SET status = '".$_REQUEST['update']."' WHERE transaction_code = '".$_REQUEST['activate']."'");
	$UpdateCart = mysql_query("UPDATE mycart SET success = 'P', TranKey = '' WHERE uid = '".$ShowTrans['uid']."'");
	}
	header("location:transaction.php?ret=1");
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
    	  <h5>Orders</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        <?php $comission = mysql_fetch_array(mysql_query("SELECT * FROM `website_settings` WHERE id = '1'")); ?>
        	<div class="head"><h5 class="iFrames">Transaction Report</h5></div>
            <div style="padding:10px;"><strong>Total Sale Amount:</strong>&nbsp;&nbsp;<?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders`"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>Rs. <?php echo number_format($cartArrayVal1[0]); ?><br /><strong>Basicfeet Comission:</strong> <?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders`"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>Rs. <?php echo $cartArrayVal1[0] * $comission['retailor_com']/100; ?><br /><strong>Logistics Comission:</strong> <?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders`"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>Rs. 0.00<br /><strong>Payment Gateway:</strong> <?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders`"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>Rs. 0.00<br /><strong>Seller Balance:</strong> <?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders`"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?>Rs. <?php echo $cartArrayVal1[0] - ($cartArrayVal1[0] * $comission['retailor_com']/100); ?></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
            	<thead>
                	<tr>
                        <td width="16%" align="center" valign="middle">Order No.</td>
                        <td width="18%" align="center" valign="middle">Order Placed By</td>
                        <td width="29%" align="center" valign="middle">Product Details</td>
                        <td width="17%" align="center" valign="middle">Amount</td>
                        <td width="20%" align="center" valign="middle"></td>
                    </tr>
                </thead>
                <tbody>
                <?php $getQuery = mysql_query("SELECT * FROM orders ORDER by id DESC");	while($getValue = mysql_fetch_array($getQuery)) { ?>
                	<tr>
                       <td align="center" valign="middle"><strong><?php echo 'BF'.$getValue['orderid'];?></strong></td>
                       <td align="center" valign="middle"><?php $GetUserDetails = mysql_fetch_array(mysql_query("SELECT * FROM register WHERE id = '".$getValue['uid']."'")); echo $GetUserDetails['firstname'].' '.$GetUserDetails['lastname']; ?></td>
                       <td colspan="2" align="center" valign="middle">
                       <?php $getInfoUser = mysql_query("SELECT * FROM `products` WHERE proid = '".$getValue['proid']."'");
					   while($fetchResult = mysql_fetch_array($getInfoUser)) { ?>
                       <div style="width:66%; float:left;"><a href="../details.php?id=<?php echo $getValue['proid']; ?>" target="_blank"><?php echo $fetchResult['product_name']; ?></a></div>
                       <div style="width:34%; float:left; padding:15px 0 5px 0;"><?php echo 'Rs. '.number_format($getValue['price']); ?></div><?php } ?></td>
                        <td align="center" valign="middle"><?php if($gettrsVal['success'] == 'Y') { ?><a href="transaction.php?activate=<?php echo $getValue['orderid']; ?>&update=N"><img src="images/1338632217_001_06.gif" alt="" width="21" height="21" /></a><?php } else { ?><a href="transaction.php?activate=<?php echo $getValue['orderid']; ?>&update=Y"><img src="images/1338632000_block.png" alt="" /></a><?php } ?><?php echo $gettrsVal['getaway'];?><?php if($getValue['success'] == 'N') { echo '<span style="color:#F00;">Pending</span>'; } else { echo '<span style="color:#090;">Success</span>'; } ?> <?php echo $gettrsVal['date'];?><br /><a href="order_details.php?order_id=<?php echo $getValue['orderid']; ?>">View Details</a> | <a href="transaction.php?DelId=<?php echo $getValue['orderid']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                  </tr>
                    <?php } ?>
                </tbody>
            </table>
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
