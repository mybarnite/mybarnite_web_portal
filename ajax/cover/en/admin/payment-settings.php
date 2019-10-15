<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

$query = mysql_fetch_array(mysql_query("SELECT * FROM paymentgty WHERE id = '1'"));

if(isset($_REQUEST['paypal']))
{
	mysql_query("UPDATE paymentgty SET getaway1 = '".$_REQUEST['paypal']."' WHERE id = '1'");
	header("location:payment-settings.php"); exit();
}

if(isset($_REQUEST['authorise']))
{
	mysql_query("UPDATE paymentgty SET getaway2 = '".$_REQUEST['authorise']."' WHERE id = '1'");
	header("location:payment-settings.php"); exit();
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
    	<div class="title"><h5>Payment</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Payment Getaway</h5></div>
            
            <div class="body">
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" height="30" align="left" valign="middle" style="padding:12px 0 0 8px; background-color:#3a3e47; color:#FFF;"><strong>Available Payment Method</strong></td>
                      <td width="32%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Getaway Type</strong></td>
                      <td width="18%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Status</strong></td>
                    </tr>
                    <tr>
                      <td width="50%" height="30" align="left" valign="middle" style="padding:15px 0 0 0;"><img src="images/instamojo.png" width="250" alt="" /></td>
                      <td width="32%" height="30" align="center" valign="middle">Debit Card / Credit Card / Net Banking</td>
                      <td width="18%" height="30" align="center" valign="middle">
					  <?php if($query['getaway1'] == 'Y') { ?>
                        <a href="payment-settings.php?activate=<?php echo $query['id']; ?>&paypal=N"><img src="images/1338632217_001_06.gif" alt="" width="21" height="21" /></a><?php } else { ?><a href="payment-settings.php?activate=<?php echo $query['id']; ?>&paypal=Y"><img src="images/1338632000_block.png" alt="" /></a><?php } ?></td>
                    </tr>
                    <!--<tr>
                      <td height="30" align="left" valign="middle" style="padding:6px 0 0 8px;"><a href="edit-payment.php?getaway=1"><img src="images/authorise-logo.jpg" alt="" width="150" height="52" border="0" /></a></td>
                      <td height="30" align="center" valign="middle">Credit Card</td>
                      <td height="30" align="center" valign="middle" style="padding-left:45px;">
                      <img src="../images/disable.png" width="24" height="19" alt="" />
<?php /*?><?php if($query['getaway2'] == 'Y') { ?>
                        <a href="payment-settings.php?activate=<?php echo $query['id']; ?>&authorise=N"><img src="../images/1338632217_001_06.gif" alt="" width="21" height="21" /></a><?php } else { ?><a href="payment-settings.php?activate=<?php echo $query['id']; ?>&authorise=Y"><img src="../images/1338632000_block.png" alt="" /></a><?php } ?><?php */?></td>
                    </tr>-->
                  </table>
                </div>
            </div>
            
            <!--<br />
            	<input name="submitBtn" type="submit" class="greyishBtn submitForm" id="submitBtn" value="CHANGE" />-->
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
