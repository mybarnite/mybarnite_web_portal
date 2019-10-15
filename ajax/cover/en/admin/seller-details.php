<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}
$getInfo = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$_REQUEST['id']."'"));

if($_REQUEST['status'] != '') 
{
	mysql_query("UPDATE register SET status = '".$_REQUEST['status']."' WHERE id = '".$_REQUEST['id']."'");
	header("location:seller-details.php?id=".$_REQUEST['id'].""); exit();
}

if(isset($_REQUEST['submit']))
{
	$random = rand(11111,99999);
	$target_path1 = "../upload/documents/".$random;
	$target_path1 = $target_path1 . basename($_FILES['trade_licence']['name']);
	$FileName1 = $random.$_FILES['trade_licence']['name'];
	move_uploaded_file($_FILES['trade_licence']['tmp_name'], $target_path1);
	
	$target_path2 = "../upload/documents/".$random;
	$target_path2 = $target_path2 . basename($_FILES['professional_tax']['name']);
	$FileName2 = $random.$_FILES['professional_tax']['name'];
	move_uploaded_file($_FILES['professional_tax']['tmp_name'], $target_path2);
	
	$target_path3 = "../upload/documents/".$random;
	$target_path3 = $target_path3 . basename($_FILES['vat_certificate']['name']);
	$FileName3 = $random.$_FILES['vat_certificate']['name'];
	move_uploaded_file($_FILES['vat_certificate']['tmp_name'], $target_path3);
	
	$target_path4 = "../upload/documents/".$random;
	$target_path4 = $target_path4 . basename($_FILES['cst_certificate']['name']);
	$FileName4 = $random.$_FILES['cst_certificate']['name'];
	move_uploaded_file($_FILES['cst_certificate']['tmp_name'], $target_path4);
	
	mysql_query("UPDATE `register` SET firstname = '".$_REQUEST['firstname']."', lastname = '".$_REQUEST['lastname']."', address1 = '".$_REQUEST['address1']."', address2 = '".$_REQUEST['address2']."', address2 = '".$_REQUEST['address2']."', towncity = '".$_REQUEST['towncity']."', country = '".$_REQUEST['country']."', postalcode = '".$_REQUEST['postalcode']."', phone = '".$_REQUEST['phone']."', mobile = '".$_REQUEST['mobile']."', pan = '".$_REQUEST['pan']."', tin = '".$_REQUEST['tin']."', tan = '".$_REQUEST['tan']."', VATNO = '".$_REQUEST['VATNO']."', CSTNO = '".$_REQUEST['CSTNO']."', trade_licence = '".$FileName1."', professional_tax = '".$FileName2."', vat_certificate = '".$FileName3."', cst_certificate = '".$FileName4."' WHERE id = '".$_REQUEST['id']."'"); 
	header("location:seller-details.php?id=".$_REQUEST['id'].""); exit();	
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
    	  <h5>Sellers/Vendors</h5></div>
        
        <!-- Static table -->
      <div class="widget first">
       	<div class="head">
        	  <h5 class="iFrames">Profile: <strong><?php echo $getInfo['company_name']; ?></strong></h5>
   	    </div>
        
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        <div style="padding:10px; line-height:23px;">
                <div><strong>Company Name:</strong></div>
                <div><input type="text" name="company_name" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['company_name']; ?>" /></div>
                <div><strong>Email:</strong></div>
                <div><input type="text" name="email" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['email']; ?>" readonly="readonly" /></div>
                <div><strong>First Name:</strong></div>
                <div><input type="text" name="firstname" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['firstname']; ?>" /></div>
                
                <div><strong>Last Name:</strong></div>
                <div><input type="text" name="lastname" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['lastname']; ?>" /></div>
                <div><strong>Address 1:</strong></div>
                <div><input type="text" name="address1" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['address1']; ?>" /></div>
                <div><strong>Address 2:</strong></div>
                <div><input type="text" name="address2" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['address2']; ?>" /></div>
                <div><strong>Town/City:</strong></div>
                <div><input type="text" name="towncity" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['towncity']; ?>" /></div>
                <div><strong>Country:</strong></div>
                <div><input type="text" name="country" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['country']; ?>" /></div>
                <div><strong>Postal Code:</strong></div>
                <div><input type="text" name="postalcode" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['postalcode']; ?>" /></div>
                <div><strong>Phone:</strong></div>
                <div><input type="text" name="phone" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['phone']; ?>" /></div>
                
                <div><strong>Mobile:</strong></div>
                <div><input type="text" name="mobile" style="padding:7px 5px; width:250px;" value="<?php echo $getInfo['mobile']; ?>" /></div>
                
                <div><strong>PAN No:</strong></div>
                <div><input type="text" name="pan" style="padding:7px 5px; width:150px;" value="<?php echo $getInfo['pan']; ?>" /></div>
                <div><strong>TIN No:</strong></div>
                <div><input type="text" name="tin" style="padding:7px 5px; width:150px;" value="<?php echo $getInfo['tin']; ?>" /></div>
                <div><strong>TAN No:</strong></div>
                <div><input type="text" name="tan" style="padding:7px 5px; width:150px;" value="<?php echo $getInfo['tan']; ?>" /></div>
                <div><strong>VAT No:</strong></div>
                <div><input type="text" name="VATNO" style="padding:7px 5px; width:150px;" value="<?php echo $getInfo['VATNO']; ?>" /></div>
                <div><strong>CST No:</strong></div>
                <div><input type="text" name="CSTNO" style="padding:7px 5px; width:150px;" value="<?php echo $getInfo['CSTNO']; ?>" /></div>
                
                <div><strong>Trade Licence:</strong></div>
                <div><input type="file" name="trade_licence" id="trade_licence" />
                	 <br /><a href="../upload/documents/<?php echo $getInfo['trade_licence']; ?>" target="_blank"><img src="../upload/documents/<?php echo $getInfo['trade_licence']; ?>" width="200" alt="" /></a></div>
                <div><strong>Professional Tax:</strong></div>
                <div><input type="file" name="professional_tax" id="professional_tax" />
                	 <br /><a href="../upload/documents/<?php echo $getInfo['professional_tax']; ?>" target="_blank"><img src="../upload/documents/<?php echo $getInfo['professional_tax']; ?>" width="200" alt="" /></a></div>
              	<div><strong>VAT Certificate:</strong></div>
                <div><input type="file" name="vat_certificate" id="vat_certificate" />
                	 <br /><a href="../upload/documents/<?php echo $getInfo['vat_certificate']; ?>" target="_blank"><img src="../upload/documents/<?php echo $getInfo['vat_certificate']; ?>" width="200" alt="" /></a></div>
                <div><strong>CST Certificate:</strong></div>
                <div><input type="file" name="cst_certificate" id="cst_certificate" />
                	 <br /><a href="../upload/documents/<?php echo $getInfo['cst_certificate']; ?>" target="_blank"><img src="../upload/documents/<?php echo $getInfo['cst_certificate']; ?>" width="200" alt="" /></a></div>
                
<div style="padding:8px 0;"><b>This account is <?php if($getInfo['status']=='N') { ?><a href="seller-details.php?id=<?php echo $_REQUEST['id']; ?>&status=Y" style="color:#F00;">Deactive</a><?php } else { ?><a href="seller-details.php?id=<?php echo $_REQUEST['id']; ?>&status=N" style="color:#090;">Active</a><?php } ?></b></div>
                
                <div style="clear:both;"></div>
            	<input type="submit" name="submit" value="Submit form" class="greyishBtn submitForm" />
                <div style="clear:both;"></div>
                
            </div>
        </form>
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
