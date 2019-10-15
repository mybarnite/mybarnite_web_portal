<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['backupSQL']))
{
	header("location:sqlBackup.php");
	exit();
}

if(isset($_REQUEST['fileName']))
{
	$dbSQLQuery = "INSERT INTO `backupdb` (`id`, `dbname`, `date`, `filesize`, `status`) VALUES ('', '".$_REQUEST['fileName']."', now(), '".$_REQUEST['fileSize']."', 'Y')";
	$dbBAckup = mysql_query($dbSQLQuery);
	header("location:backup-database.php");
	exit();
}

if(isset($_REQUEST['DelId'])!='')
{
	mysql_query("DELETE FROM backupdb WHERE id = '".$_REQUEST['DelId']."' ");
	header("location:backup-database.php");
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
    	<div class="title">
    	  <h5>Tools / Extras</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        	<div class="head"><h5 class="iFrames">Backup Database</h5></div>
          <div style="font-weight:bold; padding:10px 10px 10px 10px;">Database Backup Manager</div>
            <div style="padding:2px 10px 10px 10px;">Please click the below button <span style="font-weight:bold;">"Export Database"</span> to export current database SQL file. After that, click the latest date and time file to download the recent backup database from below.</div>
            <div style="font-weight:bold; padding:5px 10px 20px 10px;">
              <form id="form1" name="form1" method="post" action="">
                <input type="submit" name="backupSQL" id="backupSQL" value="" style="background-image:url(images/exportDatabase.png); background-repeat:no-repeat; border:0px; width:140px; height:35px;" />
              </form>
            </div>
				<div class="body" style="padding-top:0px;">
              <div style="background-color:#2b7dc7; padding:5px 5px 5px 8px; color:#FFF; font-weight:bold; margin-bottom:1px;">MySQL Backups</div>
                <div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" height="30" align="left" valign="middle" style="padding:6px 0 0 8px; background-color:#3a3e47; color:#FFF;"><strong>File Name</strong></td>
                      <td width="20%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Date</strong></td>
                      <td width="15%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Size</strong></td>
                      <td width="15%" height="30" align="center" valign="middle" style="background-color:#3a3e47; color:#FFF;"><strong>Action</strong></td>
                    </tr>
                    <?php
					$getVisitor = mysql_query("SELECT * FROM backupdb ORDER by id DESC");
					while($trackUser = mysql_fetch_array($getVisitor))
					{
					?>
                    <tr>
                      <td width="50%" height="34" align="left" valign="middle" style="padding:6px 0 0 8px; border-bottom:#CCC 1px solid;"><?php echo $trackUser['dbname'].'.zip'; ?></td>
                      <td width="20%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $trackUser['date']; ?></td>
                      <td width="15%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><?php echo $trackUser['filesize']; ?></td>
                      <td width="15%" height="34" align="center" valign="middle" style="border-bottom:#CCC 1px solid;"><a href="myBackups/<?php echo $trackUser['dbname'].'.zip'; ?>">Download</a> | <a href="backup-database.php?DelId=<?php echo $trackUser['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                    </tr>
                    <?php } ?>
                  </table>
</div>
            </div>
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
