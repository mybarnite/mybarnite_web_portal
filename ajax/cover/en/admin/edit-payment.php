<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}
if(isset($_REQUEST['submit']) && $_REQUEST['username'] != '')
{
	$Insert = mysql_query("UPDATE `payment` SET `status` = '".$_REQUEST['status']."', `username` = '".$_REQUEST['username']."', `transaction_key` = '".$_REQUEST['transaction_key']."', `transaction_mode` = '".$_REQUEST['transaction_mode']."', `authorization_type` = '".$_REQUEST['authorization_type']."', `auth_amt_percent` = '".$_REQUEST['auth_amt_percent']."', `customer_notifications` = '".$_REQUEST['customer_notifications']."', `merchant_notifications` = '".$_REQUEST['merchant_notifications']."', `CVV_number` = '".$_REQUEST['CVV_number']."', `sort_order_display` = '".$_REQUEST['sort_order_display']."', `payment_zone` = '".$_REQUEST['payment_zone']."', `order_status` = '".$_REQUEST['order_status']."', `proxy_url` = '".$_REQUEST['proxy_url']."' WHERE id = '".$_REQUEST['getaway']."'");	
	header("location:edit-payment.php?getaway=".$_REQUEST['getaway']."&ret=1");
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
    	<div class="title"><h5>Configuration</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        <?php $getGroup = mysql_fetch_array(mysql_query("SELECT * FROM payment WHERE id = '".$_REQUEST['getaway']."'")); ?>
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList"><?php echo $getGroup['getaway_name']; ?></h5></div>
            <?php if(isset($_REQUEST['ret']) == '1') { ?>
            <div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Getaway Information Updated Successfully!</div>
            <?php } ?>
            <div style="color:#333; padding:5px 0 5px 13px;">
              <strong>Automatic Approval Credit Card Numbers:</strong><br />
              <br />
              Visa#: 4007000000027<br />
              MC#: 5424000000000015<br />
              Discover#: 6011000000000012<br />
              AMEX#: 370000000000002<br />
              <br />
              <strong>Note:</strong> The credit card numbers above will return a decline in Live mode, and   an  approval in Test mode.  Any future date can be used for the expiry date   and any 3 digit number can be used for the CVV Code (4 digit number for   AMEX)<br />
              <br />
              <strong>Automatic Decline Credit Card Number:</strong><br />
              <br />
              Card #: 4222222222222<br />
              <br />
              Use the number above to test declined cards.</div>
            <div class="rowElem noborder">
            <label>Enable Authorize.net AIM Module</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:5px; width:100px;">
              <option <?php if($getGroup['status'] == 'N') { ?> selected="selected" <?php } ?> value="N">False</option>
              <option <?php if($getGroup['status'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">True</option>
            </select>
            </div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Login Username</label>
            <div class="formRight">
            <input name="username" type="text" id="username" value="<?php echo $getGroup['username']; ?>" style="width:190px;" />
            </div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Transaction Key</label>
            <div class="formRight">
            <input name="transaction_key" type="text" id="transaction_key" value="<?php echo $getGroup['transaction_key']; ?>" style="width:190px;" />
            </div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Transaction Mode</label>
            <div class="formRight">
            <select name="transaction_mode" id="transaction_mode" style="padding:5px; width:100px;">
              <option <?php if($getGroup['transaction_mode'] == 'N') { ?> selected="selected" <?php } ?> value="N">Test</option>
              <option <?php if($getGroup['transaction_mode'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">Live</option>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Authorization Type</label>
            <div class="formRight">
            <select name="quotes" id="quotes" style="padding:5px; width:100px;">
              <option value="">Authorize</option>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Auth Amt Percent Increase</label>
            <div class="formRight">
            <input name="auth_amt_percent" type="text" id="auth_amt_percent" value="<?php echo $getGroup['auth_amt_percent']; ?>" style="width:190px;" />
            </div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Customer Notifications</label>
            <div class="formRight">
            <select name="customer_notifications" id="customer_notifications" style="padding:5px; width:100px;">
              <option <?php if($getGroup['customer_notifications'] == 'N') { ?> selected="selected" <?php } ?> value="N">False</option>
              <option <?php if($getGroup['customer_notifications'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">True</option>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Merchant Notifications</label>
            <div class="formRight">
            <select name="merchant_notifications" id="merchant_notifications" style="padding:5px; width:100px;">
              <option <?php if($getGroup['merchant_notifications'] == 'N') { ?> selected="selected" <?php } ?> value="N">False</option>
              <option <?php if($getGroup['merchant_notifications'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">True</option>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Request CVV Number</label>
            <div class="formRight">
            <select name="CVV_number" id="CVV_number" style="padding:5px; width:100px;">
              <option <?php if($getGroup['CVV_number'] == 'N') { ?> selected="selected" <?php } ?> value="N">False</option>
              <option <?php if($getGroup['CVV_number'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">True</option>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Sort order of display.</label>
            <div class="formRight">
            <input name="sort_order_display" type="text" id="sort_order_display" value="<?php echo $getGroup['sort_order_display']; ?>" style="width:190px;" />
            </div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Payment Zone</label>
            <div class="formRight">
            <select name="payment_zone" id="payment_zone" style="padding:5px; width:100px;">
              <option selected="selected" value="">All Location</option>
            </select>
            </div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Set Order Status</label>
            <div class="formRight">
            
            <select name="order_status">
                <option selected="" value="0">default</option>
                <option value="Delivered">Delivered</option>
                <option value="Google Canceled">Google Canceled</option>
                <option value="Google New">Google New</option>
                <option value="Google Processing">Google Processing</option>
                <option value="Google Refunded">Google Refunded</option>
                <option value="Google Shipped">Google Shipped</option>
                <option value="Google Shipped and Refunded">Google Shipped and Refunded</option>
                <option value="Pending">Pending</option>
                <option value="Preparing [PayPal IPN]">Preparing [PayPal IPN]</option>
                <option value="Processing">Processing</option>
                <option value="Review [Paypal FMF]">Review [Paypal FMF]</option>
                <option value="Shipped">Shipped</option>
                <option value="Void">Void</option>
            </select>
            
            </div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>CURL Proxy URL</label>
            <div class="formRight">
            <input name="proxy_url" type="text" id="proxy_url" value="<?php echo $getGroup['proxy_url']; ?>" style="width:190px;" />
            </div><div class="fix"></div></div>
            
            <br />
            <input type="submit" name="submit" value="SAVE" class="greyishBtn submitForm" />
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