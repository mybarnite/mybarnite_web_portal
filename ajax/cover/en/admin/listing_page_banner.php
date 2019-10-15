<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']))
{
	$getsettings = mysql_fetch_array(mysql_query("SELECT * FROM `website_settings` WHERE id = '1'"));
	
	$random = rand(11111,99999);
	if($_FILES['ufile1']['name']!='')
	{
		$target_path1 = "../upload/shopBanner/".$random;
		$target_path1 = $target_path1 . basename($_FILES['ufile1']['name']);
		$FileName1 = $random.$_FILES['ufile1']['name'];
		move_uploaded_file($_FILES['ufile1']['tmp_name'], $target_path1);
	}
	else
	{
		$FileName1 = $getsettings['banner_one'];
	}
	
	if($_FILES['ufile2']['name']!='')
	{
		$target_path2 = "../upload/shopBanner/".$random;
		$target_path2 = $target_path2 . basename($_FILES['ufile2']['name']);
		$FileName2 = $random.$_FILES['ufile2']['name'];
		move_uploaded_file($_FILES['ufile2']['tmp_name'], $target_path2);
	}
	else
	{
		$FileName2 = $getsettings['banner_two'];
	}
	
	if($_FILES['ufile3']['name']!='')
	{
		$target_path3 = "../upload/shopBanner/".$random;
		$target_path3 = $target_path3 . basename($_FILES['ufile3']['name']);
		$FileName3 = $random.$_FILES['ufile3']['name'];
		move_uploaded_file($_FILES['ufile3']['tmp_name'], $target_path3);
	}
	else
	{
		$FileName3 = $getsettings['banner_three'];
	}
	
	mysql_query("UPDATE `website_settings` SET banner_four = '".$FileName1."', banner_five = '".$FileName2."', banner_six = '".$FileName3."', banner_four_url = '".$_REQUEST['banner_four_url']."', banner_five_url = '".$_REQUEST['banner_five_url']."', banner_six_url = '".$_REQUEST['banner_six_url']."' WHERE id = '1'"); 
	header("location:listing_page_banner.php?ret=1"); exit();
}
$getInformation = mysql_fetch_array(mysql_query("SELECT * FROM `website_settings` WHERE id = '1'"));
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
    	  <h5>Site Management</h5></div>
        
        <!-- Static table -->
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Product Details Page Banner</h5></div>
			<?php if(isset($_REQUEST['ret']) == '1') { ?>
            <div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Listing Page Updated Successfully!</div>
            <?php } ?>
            <div class="rowElem noborder">
            <label>Banner 1</label>
            <div class="formRight">
              <input type="file" name="ufile1" id="fileField" />
              <img src="../upload/shopBanner/<?php echo $getInformation['banner_four']; ?>" width="260" alt="" />
              <input type="text" name="banner_four_url" placeholder="Wesbsite URL" value="<?php echo $getInformation['banner_four_url']; ?>" />
            </div></div>
            <div class="rowElem noborder">
            <label>Banner 2</label>
            <div class="formRight">
              <input type="file" name="ufile2" id="fileField2" />
              <img src="../upload/shopBanner/<?php echo $getInformation['banner_five']; ?>" width="260" alt="" />
              <input type="text" name="banner_five_url" placeholder="Wesbsite URL" value="<?php echo $getInformation['banner_five_url']; ?>" />
            </div></div>
            <div class="rowElem noborder">
            <label>Banner 3</label>
            <div class="formRight">
              <input type="file" name="ufile3" id="fileField3" />
              <img src="../upload/shopBanner/<?php echo $getInformation['banner_six']; ?>" width="260" alt="" />
           	  <input type="text" name="banner_six_url" placeholder="Wesbsite URL" value="<?php echo $getInformation['banner_six_url']; ?>" />
            </div><div class="fix"></div></div>
            <br />
            <input type="submit" name="submit" value="Submit form" class="greyishBtn submitForm" />
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
