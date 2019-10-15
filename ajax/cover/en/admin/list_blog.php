<?php
include("../includes/config.php");

if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['DelId']) && $_REQUEST['DelId']!='')
{
	mysql_query("DELETE FROM blogs WHERE blog_id = '".$_REQUEST['DelId']."' ");
	header("location:list_blog.php?ret=2");
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

               		<!--<li><a href="transaction.php" title=""><span>Total Deposits: <strong><?php $investmentQry = mysql_fetch_array(mysql_query("SELECT SUM(amount) FROM transaction WHERE type = 'D'")); echo '$'.round($investmentQry[0]) ?></strong></span></a></li>

                    <li><a href="#" title=""><span>Total Available Fund: <strong><?php $investmentQry1 = mysql_fetch_array(mysql_query("SELECT SUM(amount) FROM transaction WHERE type = 'W'")); echo '$'.round($investmentQry[0] - $investmentQry1[0]) ?></strong></span></a></li>-->

                    <li><a href="settings.php" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>

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
        	<li class="iMes"><a href="support.php" title=""><span>Support tickets</span></a><span class="numberMiddle">0</span></li>
            <li class="iUser"><a href="employers.php" title=""><span>Employers</span></a></li>
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
        	<h5>Blog Management</h5></div>

        <!-- Static table -->

        <div class="widget first">

        	<div class="head"><h5 class="iFrames">Manage Blog</h5></div>

            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
            	<thead>
                	<tr>
                        <td width="57%" align="left" style="text-align:left; padding-left:8px;">Blog Title</td>
                        <td width="23%" align="center" valign="middle">Category</td>
                        <td width="20%">Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php $getQuery = mysql_query("SELECT * FROM `blogs` ORDER BY blog_id DESC");
				while($getValue = mysql_fetch_array($getQuery)) { ?>
                	<tr>
                        <td><?php echo $getValue['blog_title']; ?></td>
                        <td align="center" valign="middle"><?php $getCatName = mysql_fetch_array(mysql_query("SELECT * FROM `blog_category` WHERE bcat_id = '".$getValue['blog_category']."'")); echo $getCatName['blog_category']; ?></td>
                        <td width="20%" align="center"><a href="add-blog.php?id=<?php echo $getValue['blog_id']; ?>" onclick="return confirm('Are you sure you want to edit the article?')">Edit</a> / <a href="list_blog.php?DelId=<?php echo $getValue['blog_id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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

    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved.</span>

    </div>

</div>



</body>

</html>

