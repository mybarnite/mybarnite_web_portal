<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']) && $_REQUEST['eID']!='')
{
	mysql_query("UPDATE mypitch SET title = '".$_REQUEST['project_name']."', 	category = '".$_REQUEST['category']."', investment = '".$_REQUEST['investment']."', minimum = '".$_REQUEST['minimum']."', expiry = '".$_REQUEST['expiry']."', details = '".$_REQUEST['details']."', company_name = '".$_REQUEST['company_name']."', owner_name = '".$_REQUEST['owner_name']."', telephone = '".$_REQUEST['telephone']."', email = '".$_REQUEST['email']."', biography = '".$_REQUEST['biography']."', website = '".$_REQUEST['website']."', location = '".$_REQUEST['location']."' WHERE id = '".$_REQUEST['eID']."'");
	header("location:edit-project.php?eID=".$_REQUEST['eID']."");
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
    <div class="logo"><a href="#" title=""><img src="../images/logoB.png" alt="" /></a></div>
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
    	<div class="title"><h5>Projects</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        	<?php $getProj = mysql_fetch_array(mysql_query("SELECT * FROM mypitch WHERE id = '".$_REQUEST['eID']."'")); ?>
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Edit Project</h5></div>
            <div class="rowElem noborder">
            <label>Project Title</label>
            <div class="formRight"><input name="project_name" type="text" id="project_name" value="<?php echo $getProj['title']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Category</label>
            <div class="formRight">
                <select name="category" id="category">
                    <option value="opt1">Select Category</option>
                    <?php $getdata = mysql_query("SELECT * FROM category ORDER by catname ASC"); 
                    while($fetchCat = mysql_fetch_array($getdata))
                    {
                    ?>
                    <option <?php if($getProj['category'] == $fetchCat['id']) { ?> selected="selected" <?php } ?> value="<?php echo $getProj['id']; ?>"><?php echo $fetchCat['catname']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Invetsment Required</label>
            <div class="formRight"><input name="investment" type="text" id="investment" value="<?php echo $getProj['investment']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Minimum Required</label>
            <div class="formRight"><input name="minimum" type="text" id="minimum" value="<?php echo $getProj['minimum']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Expiry Date</label>
            <div class="formRight"><input name="expiry" type="text" id="expiry" value="<?php echo $getProj['expiry']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Details</label>
            <div class="formRight"><textarea rows="6" cols="" name="details"><?php echo $getProj['details']; ?></textarea></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Company Name</label>
            <div class="formRight"><input name="company_name" type="text" id="company_name" value="<?php echo $getProj['company_name']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Owner Name</label>
            <div class="formRight"><input name="owner_name" type="text" id="owner_name" value="<?php echo $getProj['owner_name']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Telephone</label>
            <div class="formRight"><input name="telephone" type="text" id="telephone" value="<?php echo $getProj['telephone']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Email ID</label>
            <div class="formRight"><input name="email" type="text" id="email" value="<?php echo $getProj['email']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Biography</label>
            <div class="formRight"><textarea rows="6" cols="" name="biography"><?php echo $getProj['biography']; ?></textarea></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Website</label>
            <div class="formRight"><input name="website" type="text" id="website" value="<?php echo $getProj['website']; ?>" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Location</label>
            <div class="formRight"><input name="location" type="text" id="location" value="<?php echo $getProj['location']; ?>" /></div><div class="fix"></div></div>
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