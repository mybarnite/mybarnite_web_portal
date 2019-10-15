<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['DelId'])!='')
{
	mysql_query("DELETE FROM register WHERE id = '".$_REQUEST['DelId']."'");
	header("location:approved-user.php"); exit;
}

if($_REQUEST['activate']!= '')
{
	mysql_query("UPDATE register SET eVerify = '".$_REQUEST['update']."', status = '".$_REQUEST['update']."' WHERE id = '".$_REQUEST['activate']."'");
	header("location:approved-user.php"); exit;
}

if($_REQUEST['mValidate']!= '')
{
	mysql_query("UPDATE register SET mVerify = '".$_REQUEST['update']."' WHERE id = '".$_REQUEST['mValidate']."'");
	header("location:approved-user.php"); exit;
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
    	<div class="title"><h5>Buyer Controls</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        	<div class="head"><h5 class="iFrames">Verified Buyers</h5></div>
        	<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
        	  <thead>
        	    <tr>
        	      <td width="34%" style="text-align:left; padding-left:8px;">Full Name</td>
        	      <td width="33%" style="text-align:left; padding-left:8px;">Email</td>
        	      <td width="22%">Action</td>
        	      <td width="11%">Type</td>
      	      </tr>
      	    </thead>
        	  <tbody>
        	    <?php $getQuery = mysql_query("SELECT * FROM `register` WHERE status = 'Y' AND type = 'B' ORDER BY id DESC");
				while($getValue = mysql_fetch_array($getQuery)) { ?>
                	<tr>
                        <td style="text-align:left; padding-left:8px;"><?php echo $getValue['firstname'].' '.$getValue['lastname']; ?><br /> - <a href="wishlist.php?uid=<?php echo $getValue['id']; ?>">View Wishlist</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="reset-password.php?id=<?php echo $getValue['id']; ?>" target="_blank">Set Password</a></td>
                        <td style="text-align:left; padding-left:8px;"><?php echo $getValue['email']; ?><br /><strong>Password:</strong> <?php echo $getValue['user_password']; ?></td>
                        <td align="center"><table width="60%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="middle"><?php if($getValue['eVerify'] == 'Y') { ?><a href="approved-user.php?activate=<?php echo $getValue['id']; ?>&update=N"><img src="images/email-verify.png" alt="" width="24" title="Email Verified" /></a><?php } else { ?><a href="approved-user.php?activate=<?php echo $getValue['id']; ?>&update=Y"><img src="images/email-not-verify.png" width="24" alt="" title="Email Not-Verified" /></a><?php } ?></td>
                            <td align="center" valign="middle"><?php if($getValue['mVerify'] == 'Y') { ?><a href="approved-user.php?mValidate=<?php echo $getValue['id']; ?>&update=N"><img src="images/phone-verify.png" alt="" width="24" title="Phone Verified" /></a><?php } else { ?><a href="approved-user.php?mValidate=<?php echo $getValue['id']; ?>&update=Y"><img src="images/phone-not-verify.png" width="24" alt="" title="Phone Not-Verified" /></a><?php } ?></td>
                            <td align="center" valign="middle"><a href="approved-user.php?DelId=<?php echo $getValue['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="images/1338632825_trash_16x16.gif" alt="" /></a></td>
                          </tr>
                      </table></td>
                        <td align="center"><?php if($getValue['eVerify'] == 'Y') { ?><span style="color:#090;">Verified</span><?php } else { ?><span style="color:#F00;">Un-verified</span><?php } ?></td>
                    </tr>
                    <?php
				}
					?>
      	    </tbody>
      	  </table>
        	<?php if(mysql_num_rows($getQuery) < 1) { ?>
<div style="padding:15px; text-align:center;"><strong>No Record Found!</strong></div>
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
