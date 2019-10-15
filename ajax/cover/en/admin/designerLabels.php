<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['label'])!= '')
{
	$getlabel = mysql_fetch_array(mysql_query("SELECT * FROM `labels` WHERE id = '".$_REQUEST['label']."'"));
	$getuser = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE uid = '".$getlabel['uid']."'"));
	
	if($_REQUEST['status'] == 'Y')
	{
		// multiple recipients
		$to = $getuser['email'];
	
		// subject
		$subject = 'Your Designer label approved by Basicfeet!';
	
		// message
		$message = '<div style="background-color:#f9f9f9; padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/logo.jpg" width="277" height="104" alt=""></div>
		<div>Congrats! your designer label approved by admin.</p>		
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/go-green.jpg" width="592" height="28" alt="">
		<div style="padding-top:10px; color:#666;">As a part of go-green initiative we will not be sending the invoice to you with the shipment. You will receive a soft copy of a invoice as a part of the delivery confirmation email <span tabindex="0" data-term="goog_1208647089">within 24 hours</span> of the delivery completion.</div>
		<div style="padding:10px 0;">Basicfeet.com</div>
		<div style="padding-bottom:20px;">24x7 Customer Support  |  Buyer Protection  |  Flexible Payment Options  |  Largest Collection</div></div>
	</div>';
	
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		// Additional headers
		$headers .= 'To: '.$getuser['firstname'].' <'.$getuser['email'].'>' . "\r\n";
		$headers .= 'From: Basicfeet <support@basicfeet.com>' . "\r\n";
	
		// Mail it
		mail($to, $subject, $message, $headers);
	}
	
	mysql_query("UPDATE labels SET status = '".$_REQUEST['status']."' WHERE id = '".$_REQUEST['label']."'");
	header("location:designerLabels.php"); exit;
}

if(isset($_REQUEST['DelId'])!='')
{
	mysql_query("DELETE FROM labels WHERE id = '".$_REQUEST['DelId']."' ");
	header("location:designerLabels.php"); exit;
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
    	<div class="title"><h5>Sellers/Vendors</h5></div>
        
        <!-- Static table -->
      <div class="widget first">
       	<div class="head"><h5 class="iFrames">Designer Labels</h5></div>
          <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
           	  <thead>
               	  <tr>
                      <td width="29%" style="text-align:left; padding-left:8px;">Label Name</td>
                      <td width="20%">LOGO</td>
                      <td width="27%" align="center" valign="middle">Added By</td>
                   	  <td width="14%" align="center" valign="middle">&nbsp;</td>
                      <td width="10%" align="center" valign="middle">Action</td>
                  </tr>
              </thead>
              <tbody>
                <?php $getQuery = mysql_query("SELECT * FROM labels ORDER by datetime DESC");
					  while($getValue = mysql_fetch_array($getQuery)) { ?>
               	  <tr>
                      <td><?php echo $getValue['label_name']; ?></td>
                      <td align="center"><img src="../upload/labels/<?php echo $getValue['label_logo']; ?>" alt="" width="160" /></td>
                      <td width="27%" align="center" valign="middle"><?php $getsubcatName = mysql_fetch_array(mysql_query("SELECT * FROM register WHERE id = '".$getValue['uid']."'")); echo $getsubcatName['firstname'].' '.$getsubcatName['lastname']; ?></td>
                    <td width="14%" align="center" valign="middle"><?php if($getValue['status'] == 'Y') { ?><a href="designerLabels.php?label=<?php echo $getValue['id']; ?>&status=N" style="color:#090;">Active</a><?php } else { ?><a href="designerLabels.php?label=<?php echo $getValue['id']; ?>&status=Y" style="color:#F00;">Inactive</a><?php } ?></td>
                      <td width="10%" align="center" valign="middle"><a href="designerLabels.php?DelId=<?php echo $getValue['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
