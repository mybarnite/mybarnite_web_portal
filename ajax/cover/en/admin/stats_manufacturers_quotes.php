<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
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
    	<div class="title"><h5>Reports</h5></div>
    <div style="padding:18px 0 0 0;">This report displays all manufacturers with the Total products, Total sold item and total Sold amount.</div>
    <!--<div style="padding:6px 0 0 0;">
      <form id="form1" name="form1" method="post" action="">
        <table width="70%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%" align="left" valign="middle">From</td>
            <td width="30%" align="left" valign="middle"><input type="text" name="datepick" id="datepick" <?php if(isset($_REQUEST['datepick']) == '') { ?> value="" placeholder="Click Here to Select Date" <?php } else { ?> value="<?php echo $_REQUEST['datepick']; ?>" <?php } ?> style="padding:6px 6px 7px 6px;" /></td>
            <td width="7%" align="center" valign="middle">To</td>
            <td width="32%" align="left" valign="middle"><input type="text" name="datepick2" id="datepick2" value="<?php if(isset($_REQUEST['datepick2']) == '') { echo date("d M, Y"); } else { echo $_REQUEST['datepick2']; } ?>" style="padding:6px 6px 7px 6px;" placeholder="Cliek Here to Select Date" /></td>
            <td width="22%" align="left" valign="middle"><input type="submit" name="button" id="button" value="Get Record" /></td>
          </tr>
        </table>
      </form>
  </div>-->
        <!-- Static table -->
        <div class="widget first">
       	  <div class="head"><h5 class="iFrames">Seller/Vendor Quotes</h5></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
            	<thead>
                	<tr>
                        <td width="28%" align="left" valign="middle" style="text-align:left; padding-left:8px;">Manufacturer</td>
                        <td width="18%">Total Products</td>
                        <td width="18%">Total Sold</td>
                        <td width="18%">Sold Amount</td>
                        <td width="18%">Staus</td>
                    </tr>
                </thead>
                <tbody>
					<?php $whileLoop = mysql_query("SELECT * FROM manufacturers ORDER by manufacturer");
					      while($getArray = mysql_fetch_array($whileLoop)) { ?>
                    <tr>
                        <td width="28%" align="left" valign="middle"><?php echo $getArray['manufacturer']; ?></td>
                        <td width="18%" align="center"><?php $productName =  mysql_query("SELECT * FROM products WHERE supplier = '".$getArray['id']."'"); $valueNeeded = mysql_fetch_array($productName); echo mysql_num_rows($productName); ?></td>
                      <td width="18%" align="center"><?php $countAmount1 = mysql_query("SELECT SUM(qty) FROM transaction WHERE proid = '".$valueNeeded['proid']."' and status = 'Y'"); $cartArrayVal1 = mysql_fetch_array($countAmount1); echo number_format($cartArrayVal1[0]); ?></td>
                      <td width="18%" align="center"><?php $countAmount = mysql_query("SELECT SUM(amount) FROM transaction WHERE proid = '".$valueNeeded['proid']."' and status = 'Y'"); $cartArrayVal = mysql_fetch_array($countAmount); echo 'Rs.'.number_format($cartArrayVal[0]); ?></td>
                        <td width="18%" align="center"><?php if($getArray['status']=='Y') { ?>Active<?php } else { ?>Inactive<?php } ?></td>
                    </tr>
                	<?php }  ?>
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