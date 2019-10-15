<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}
if(isset($_REQUEST['submit']))
{
	$update = mysql_query("UPDATE `ownerinfo` SET `page_title` = '".$_REQUEST['page_title']."',
												  `name` = '".$_REQUEST['name']."',
												  `website` = '".$_REQUEST['website']."',
												  `phone` = '".$_REQUEST['phone']."',
												  `fax` = '".$_REQUEST['fax']."',
												  `address1` = '".$_REQUEST['address1']."',
												  `address2` = '".$_REQUEST['address2']."',
												  `city` = '".$_REQUEST['city']."',
												  `country` = '".$_REQUEST['country']."',
												  `zip` = '".$_REQUEST['zip']."',
												  `state` = '".$_REQUEST['state']."',
												  `storeemail` = '".$_REQUEST['storeemail']."',
												  `adminemail` = '".$_REQUEST['adminemail']."',
												  `datetime` = '".date("d F, Y")."' WHERE `id` = 1");
	header("location:owner-profile.php");
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
	<?php $data = mysql_query("SELECT * FROM ownerinfo WHERE id = '1'"); $dataVal = mysql_fetch_array($data); ?>
	<!-- Left navigation -->
    <?php include'include/leftnav.php';?>
    
    <!-- Content -->
    <div class="content">
      <div class="title"><h5>Site Management</h5>
      
      </div>
      <!-- Static table -->
      <form action="" class="mainForm" method="post" name="form1" id="form1">
        <!-- Input text fields -->
        <fieldset>
          <div class="widget first">
            <div class="head">
              <h5 class="iList">Owner's Profile</h5>
            </div>
            <div class="rowElem noborder">
              <label>Store Page Title</label>
              <div class="formRight">
                <input name="page_title" type="text" id="page_title" value="<?php echo $dataVal['page_title']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Name</label>
              <div class="formRight">
                <input name="name" type="text" id="name" value="<?php echo $dataVal['name']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Website</label>
              <div class="formRight">
                <input name="website" type="text" id="website" value="<?php echo $dataVal['website']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Phones</label>
              <div class="formRight">
                <input name="phone" type="text" id="phone" value="<?php echo $dataVal['phone']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Fax</label>
              <div class="formRight">
                <input name="fax" type="text" id="fax" value="<?php echo $dataVal['fax']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Address Line 1</label>
              <div class="formRight">
                <input name="address1" type="text" id="address1" value="<?php echo $dataVal['address1']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Address Line 2</label>
              <div class="formRight">
                <input name="address2" type="text" id="address2" value="<?php echo $dataVal['address2']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>City</label>
              <div class="formRight">
                <input name="city" type="text" id="city" value="<?php echo $dataVal['city']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Country</label>
              <div class="formRight">
                <input name="country" type="text" id="country" value="<?php echo $dataVal['country']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>ZIP Code</label>
              <div class="formRight">
                <input name="zip" type="text" id="zip" value="<?php echo $dataVal['zip']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>State</label>
              <div class="formRight">
                <input name="state" type="text" id="state" value="<?php echo $dataVal['state']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Store e-mail address</label>
              <div class="formRight">
                <input name="storeemail" type="text" id="storeemail" value="<?php echo $dataVal['storeemail']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
            <div class="rowElem">
              <label>Site administrator e-mail</label>
              <div class="formRight">
                <input name="adminemail" type="text" id="adminemail" value="<?php echo $dataVal['adminemail']; ?>" />
              </div>
              <div class="fix"></div>
            </div>
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
