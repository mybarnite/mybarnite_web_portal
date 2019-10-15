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

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
</script>

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
    	  <h5>Invoice Management</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        	<div class="head">
        	  <h5 class="iFrames">Search Invoice</h5>
       	  </div>
        
        <div style="clear:both; height:8px;"></div>    
            <form id="form1" name="form1" method="post" action="">
                <table width="50%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                <tr>
                	<!--<td><input type="text" name="keyword" id="datepicker" style="padding:6px; width:150px;" placeholder="Select Date" /></td>-->
                	<td width="45%">
                    	<input type="text" name="textfield" style="padding:6px; width:130px; margin-left:8px;" placeholder="Invoice ID" /></td>
               	 <td width="55%"><input type="submit" name="button" id="button" value="SEARCH" /></td>
                </tr>
                </table>
            </form>
        <div style="clear:both; height:8px;"></div>    
        
          <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
<thead>
                	<tr>
                        <td width="20%" style="text-align:left; padding-left:8px;">Date</td>
                        <td width="16%" align="center" valign="middle">Invoice ID#</td>
                        <td width="48%" align="center" valign="middle">Person Name</td>
                        <td width="16%" align="center" valign="middle">Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php $getQuery = mysql_query("SELECT DISTINCT orderid, date, uid FROM `orders` ORDER BY datetime ASC");
					  while($getValue = mysql_fetch_array($getQuery)) { ?>
                	<tr>
                        <td><?php echo $getValue['date']; ?></td>
                        <td align="center" valign="middle"><?php echo $getValue['orderid']; ?></td>
                        <td align="center" valign="middle">
                       <?php $valInfo = mysql_query("SELECT * FROM orders WHERE orderid = '".$getValue['orderid']."'");
					   		while($showData = mysql_fetch_array($valInfo)) {
					   $getInfoUser = mysql_query("SELECT * FROM `products` WHERE proid = '".$showData['proid']."'");
					   		while($fetchResult = mysql_fetch_array($getInfoUser)) { ?>
                        <div style="width:100%; float:left; border-bottom:#CCC 1px solid;"><a href="../details.php?id=<?php echo $fetchResult['proid']; ?>" target="_blank"><?php echo $fetchResult['product_name']; ?></a><br />Seller Details: <?php $getSeller = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$fetchResult['uid']."'")); ?><strong><?php echo $getSeller['company_name']; ?></strong><br />Email: <strong><?php echo $getSeller['email']; ?></strong> | Phone: <strong><?php echo $getSeller['phone']; ?></strong></div>
                    	<!--<div style="width:34%; float:left; padding:15px 0 5px 0; border-bottom:#CCC 1px solid;"><?php echo 'Rs. '.number_format($showData['price']).'.00'; ?></div>--><?php } } ?>
                        </td>
                        	<td width="16%" align="center" valign="middle"><a href="../invoice.php?order_id=<?php echo $getValue['orderid']; ?>" target="_blank">View Invoice</a></td>
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
    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved. Created By: <a href="http://www.webmantratech.com" target="_blank">WebMantra Technologies (India) Pvt Ltd.</a> </span>
    </div>
</div>

</body>
</html>
