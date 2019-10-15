<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['exportXLS']))
{
	header("location:export-order-data.php");
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
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
<style type="text/css">
.calendar {
	font-family: 'Trebuchet MS', Tahoma, Verdana, Arial, sans-serif;
	font-size: 0.9em;
	background-color: #EEE;
	color: #333;
	border: 1px solid #DDD;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	padding: 0.2em;
	width: 14em;
}

.calendar .months {
	background-color: #F6AF3A;
	border: 1px solid #E78F08;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	color: #FFF;
	padding: 0.2em;
	text-align: center;
}

.calendar .prev-month,
.calendar .next-month {
	padding: 0;
}

.calendar .prev-month {
	float: left;
}

.calendar .next-month {
	float: right;
}

.calendar .current-month {
	margin: 0 auto;
}

.calendar .months .prev-month,
.calendar .months .next-month {
	color: #FFF;
	text-decoration: none;
	padding: 0 0.4em;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	cursor: pointer;
}

.calendar .months .prev-month:hover,
.calendar .months .next-month:hover {
	background-color: #FDF5CE;
	color: #C77405;
}

.calendar table {
	border-collapse: collapse;
	padding: 0;
	font-size: 0.8em;
	width: 100%;
}

.calendar th {
	text-align: center;
}

.calendar td {
	text-align: right;
	padding: 1px;
	width: 14.3%;
}

.calendar td span {
	display: block;
	color: #1C94C4;
	background-color: #F6F6F6;
	border: 1px solid #CCC;
	text-decoration: none;
	padding: 0.2em;
	cursor: pointer;
}

.calendar td span:hover {
	color: #C77405;
	background-color: #FDF5CE;
	border: 1px solid #FBCB09;
}

.calendar td.today span {
	background-color: #FFF0A5;
	border: 1px solid #FED22F;
	color: #363636;
}
</style>
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
    	<div class="title"><h5>Export Data</h5></div>
        
        <!-- Static table -->
        <!--<form action="" class="mainForm" method="post" name="form1" id="form1">-->
        
        	<!-- Input text fields -->
            <fieldset>
            <!--<div class="widget first">
            <div class="head"><h5 class="iList">Export Orders</h5></div>
            <div class="rowElem noborder">
            <label>Start Order #:</label>
            <div class="formRight"><input name="catname" type="text" id="catname" value="" style="width:190px;" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>End Order #:</label>
            <div class="formRight"><input name="catname" type="text" id="catname" value="" style="width:190px;" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Start Date:<br />(YYYY-MM-DD)</label>
            <div class="formRight"><input name="catname" type="text" id="datepick" value="" style="width:190px;" /></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>End Date:<br />(YYYY-MM-DD)</label>
             <div class="formRight"><input name="catname" type="text" id="datepick2" value="" style="width:190px;" /></div><div class="fix"></div></div>
           <div class="rowElem noborder">
            <label>Order Status:</label>
            <div class="formRight">
            <select name="orders_status"><option selected="" value="">All Orders</option><option value="1">Pending</option><option value="2">Processing</option><option value="3">Delivered</option><option value="101">Google Processing</option><option value="100">Google New</option><option value="102">Google Shipped</option><option value="103">Google Refunded</option><option value="104">Google Shipped and Refunded</option><option value="105">Google Canceled</option><option value="106">Preparing [PayPal IPN]</option><option value="4">Void</option><option value="107">Shipped</option><option value="5">Review [Paypal FMF]</option></select>
            </div><div class="fix"></div></div>
            <br />
            <input type="submit" name="exportXLS" id="exportXLS" value="" style="background-image:url(images/exportCustomer.png); background-repeat:no-repeat; border:0px; width:97px; height:35px; margin:0 0 25px 14px;" onclick="return confirm('Exporting Service Temporarily Disabled.')" />
            <div class="fix"></div>
            </div>-->
            
            <div class="widget first">
        	<div class="head"><h5 class="iFrames">Export Orders</h5></div>
          <div style="font-weight:bold; padding:10px 10px 10px 10px;">Export and Save Order Data onto your Local Machine</div>
            <div style="font-weight:bold; padding:2px 10px 10px 10px;">All order records will be exported as an Excel (.xls) file.</div>
            <div style="font-weight:bold; padding:5px 10px 20px 10px;">
              <!--<form id="form1" name="form1" method="post" action="">-->
                <input type="submit" name="exportXLS" id="exportXLS" value="" style="background-image:url(images/exportCustomer.png); background-repeat:no-repeat; border:0px; width:97px; height:35px;" onclick="return confirm('Exporting Service Temporarily Disabled.')" />
              <!--</form>-->
            </div>
      </div>
            
            </fieldset>
            
            <!-- WYSIWYG editor -->
            
        	<!--</form>-->
        
                
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
<script type="text/javascript" src="datepickr.js"></script>
<script type="text/javascript">
	new datepickr('datepick', {
		'dateFormat': 'd M, Y'
	});
	
	new datepickr('datepick2', {
		'dateFormat': 'd M, Y'
	});
	
	new datepickr('datepick3', {
		'fullCurrentMonth': false,
		'dateFormat': 'd M, Y'
	});
</script>
</body>
</html>