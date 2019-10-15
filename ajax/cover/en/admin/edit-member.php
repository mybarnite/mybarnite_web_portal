<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']) && $_REQUEST['username'] != ''  && $_REQUEST['password'] != '')
{
	mysql_query("UPDATE `admin_login` SET `firstname` = '".$_REQUEST['firstname']."', `lastname` = '".$_REQUEST['lastname']."', `email` = '".$_REQUEST['email']."', `username` = '".$_REQUEST['username']."', `password` = '".$_REQUEST['password']."', `modaratorid` = '".$_REQUEST['group']."', `type` = 'M', `status` = '".$_REQUEST['status']."' WHERE id = '".$_REQUEST['eID']."'");
	header("location:edit-member.php?eID=".$_REQUEST['eID']."&ret=1");
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
    	<div class="title"><h5>Administrator</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        	<?php $getMEmberInfo = mysql_fetch_array(mysql_query("SELECT * FROM admin_login WHERE id = '".$_REQUEST['eID']."'")); ?>
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head">
              <h5 class="iList">Edit Member</h5></div>
            <?php if(isset($_REQUEST['ret']) == '1') { ?>
            <div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Member Information Edited Successfully!</div>
            <?php } ?>
            <div class="rowElem noborder">
            <label>First Name</label>
            <div class="formRight"><input name="firstname" type="text" id="firstname" value="<?php echo $getMEmberInfo['firstname']; ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Last Name</label>
            <div class="formRight"><input name="lastname" type="text" id="lastname" value="<?php echo $getMEmberInfo['lastname']; ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Email</label>
            <div class="formRight"><input name="email" type="text" id="email" value="<?php echo $getMEmberInfo['email']; ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Username</label>
            <div class="formRight"><input name="username" type="text" id="username" value="<?php echo $getMEmberInfo['username']; ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Password</label>
            <div class="formRight"><input name="password" type="text" id="password" value="<?php echo $getMEmberInfo['password']; ?>" /></div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Group Name</label>
            <div class="formRight">
            <select name="group" id="group" style="padding:5px; width:100px;">
			<?php 
				$getgroupName = mysql_query("SELECT * FROM admin_group ORDER by group_name");
				while($fetchGroup = mysql_fetch_array($getgroupName))
				{
				?>
              <option <?php if($getMEmberInfo['modaratorid'] == $fetchGroup['id']) { ?> selected="selected" <?php } ?> value="<?php echo $fetchGroup['id']; ?>"><?php echo $fetchGroup['group_name']; ?></option>
				<?php } ?>
            </select></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Status</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:5px; width:100px;">
              <option <?php if($getMEmberInfo['status'] == 'N') { ?> selected="selected" <?php } ?> value="N">No</option>
              <option <?php if($getMEmberInfo['status'] == 'Y') { ?> selected="selected" <?php } ?> value="Y">Yes</option>
            </select></div><div class="fix"></div></div>
            <br />
            <input type="submit" name="submit" value="UPDATE" class="greyishBtn submitForm" />
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