<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['eID']) && $_REQUEST['eID'] != '')
{
	$getCarousel = mysql_fetch_array(mysql_query("SELECT * FROM carousel WHERE carousel_id = '".$_REQUEST['eID']."'"));
}

if(isset($_REQUEST['submit']) && $_REQUEST['eID'] == '')
{
	$random = rand(1,999999);
	$target_path = "../upload/carousel/".$random;
	$target_path = $target_path . basename($_FILES['ufile']['name']);
	$FileName = $random.$_FILES['ufile']['name'];

	if(move_uploaded_file($_FILES['ufile']['tmp_name'], $target_path)) 
	{
		$Insert = mysql_query("INSERT INTO `carousel` (`carousel_id`, `image`, `URL`, `datetime`, `status`) VALUES ('', '$FileName', '".$_REQUEST['product_name']."', now(), '".$_REQUEST['status']."')");
	header("location:addCarousel.php?ret=1");
	exit;
  }
}

if(isset($_REQUEST['submit']) && $_REQUEST['eID'] != '')
{
	$random = rand(1,999999);
	$target_path = "../upload/carousel/".$random;
	$target_path = $target_path . basename($_FILES['ufile']['name']);
	$FileName = $random.$_FILES['ufile']['name'];

	if(move_uploaded_file($_FILES['ufile']['tmp_name'], $target_path)) 
	{
		$Insert = mysql_query("UPDATE `carousel` SET `URL` = '".$_REQUEST['product_name']."', `image` = '$FileName', `datetime` = now(), `status` = '".$_REQUEST['status']."' WHERE carousel_id = '".$_REQUEST['eID']."'");
	}
	else
	{
		$Insert = mysql_query("UPDATE `carousel` SET `URL` = '".$_REQUEST['product_name']."', `datetime` = now(), `status` = '".$_REQUEST['status']."' WHERE carousel_id = '".$_REQUEST['eID']."'");	
	}

	header("location:addCarousel.php?eID=".$_REQUEST['eID']."&ret=3");
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
    	<div class="title"><h5>Manage Carousel</h5></div>
        
        <!-- Static table -->
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Add Carousel</h5></div>
            <?php if(isset($_REQUEST['ret']) && $_REQUEST['ret'] == '1') { ?>
           		<div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Carousel Added Successfully!</div>
            <?php } ?>
            <?php if(isset($_REQUEST['ret']) && $_REQUEST['ret'] == '3') { ?>
           		<div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Carousel Updated Successfully!</div>
            <?php } ?>
            
            <div class="rowElem noborder">
            <label>Image URL</label>
            	<div class="formRight"><input name="product_name" type="text" id="product_name" value="<?php if(isset($getCarousel['URL']) &&$getCarousel['URL']!='') { echo $getCarousel['URL']; } ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Image</label>
            <div class="formRight">
              <input type="file" name="ufile" id="ufile" />
              <img src="../upload/carousel/<?php echo $getCarousel['image']; ?>" width="200" height="" border="" alt="" />
            </div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Visibility Status</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:5px; width:100px;">
              <option <?php if(isset($getCarousel['status']) && $getCarousel['status']=='Y') { ?> selected="selected" <?php } ?> value="Y">Online</option>
              <option <?php if(isset($getCarousel['status']) && $getCarousel['status']=='N') { ?> selected="selected" <?php } ?> value="N">Offline</option>
            </select></div><div class="fix"></div></div>
            
            <br />
            <input type="submit" name="submit" value="Save Carousel" class="greyishBtn submitForm" />
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