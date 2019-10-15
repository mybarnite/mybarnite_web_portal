<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

$getuserinfo = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$_REQUEST['id']."'"));

if(isset($_REQUEST['submitBtn']) && $_REQUEST['newpass']!='')
{
	//$OldPass = $_REQUEST['oldpass'];
	$NewPass = md5($_REQUEST['newpass']);
	$ConfPass = md5($_REQUEST['confpass']);
	//$query = mysql_fetch_array(mysql_query("SELECT * FROM admin_login WHERE password = '$OldPass'"));
	
	if($NewPass == $ConfPass && $_REQUEST['reason'] == 'Incomplete')
	{
		mysql_query("UPDATE `register` SET password = '$NewPass', user_password = '$NewPass', status = 'Y' WHERE id = '".$_REQUEST['id']."'");
		
		// subject
		$subject = 'Basicfeet.com - Password Reset!';
	
		// message
		$message = '<div style="background-color:#f9f9f9; padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/logo.jpg" width="277" height="104" alt=""></div>
		<div><p>Hi '.$getuserinfo['firstname'].',</p>
		<p>We found your registration is incomplete. You unable to generate a password for your account. We have generated a temporary password for you to login in account and browse profiles.</p>
		<p>Your Password: '.$_REQUEST['newpass'].'</p>
		<p>Click this link to enter in your account and complete registration process. <a href="http://www.basicfeet.com/skip.php?verify='.$getuserinfo['id'].'" target="_blank">Click Here</a></p>
		<p>After complete singup, You will be able to sign in and upload your photos.</p>
		<p>If you are unable to click on the above link please copy and paste the following URL into your browser:<br>
		  http://www.basicfeet.com/skip.php?verify='.$getuserinfo['id'].'&type='.$getuserinfo['type'].'</p>
		<p>Thanks for joining basicfeet and we wish you the best of luck.</p></div>
		
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/go-green.jpg" width="592" height="28" alt="">
		<div style="padding-top:10px; color:#666;">As a part of go-green initiative we will not be sending the invoice to you with the shipment. You will receive a soft copy of a invoice as a part of the delivery confirmation email <span tabindex="0" data-term="goog_1208647089">within 24 hours</span> of the delivery completion.</div>
		<div style="padding:10px 0;">Basicfeet.com</div>
		<div style="padding-bottom:20px;">24x7 Customer Support  |  Buyer Protection  |  Flexible Payment Options  |  Largest Collection</div></div>
	</div>';
	
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		// Additional headers
		$headers .= 'To: '.$getuserinfo['firstname'].' <'.$getuserinfo['email'].'>' . "\r\n";
		$headers .= 'From: Basicfeet <support@basicfeet.com>' . "\r\n";
	
		// Mail it
		mail($to, $subject, $message, $headers);
		header("location:reset-password.php?id=".$_REQUEST['id']."&reset=done"); 
		exit();
	}
	
	if($NewPass == $ConfPass && $_REQUEST['reason'] == 'Reset')
	{
		mysql_query("UPDATE `register` SET `password` = '$NewPass', `user_password` = '$NewPass' WHERE id = '".$_REQUEST['id']."'");
		
		// subject
		$subject = 'Basicfeet.com - Password Reset!';
	
		// message
		$message = '<div style="background-color:#f9f9f9; padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/logo.jpg" width="277" height="104" alt=""></div>
		<div><p>Hi '.$getuserinfo['firstname'].',</p>
		<p>As per our request, we have updated your password.</p>
		<p>Your Password: '.$_REQUEST['newpass'].'</p>
		<p>Click this link to login in your account. <a href="http://www.basicfeet.com/login.php" target="_blank">Click Here</a></p>
		<p>Note: After login, please change your password from account.</p>
		<p>If you are unable to click on the above link please copy and paste the following URL into your browser:<br>
		  http://www.basicfeet.com/login.php</p>
		<p>Thanks for joining basicfeet and we wish you the best of luck.</p></div>
		
		<div style="text-align:center; background-color:#FFF;"><img src="http://www.basicfeet.com/images/go-green.jpg" width="592" height="28" alt="">
		<div style="padding-top:10px; color:#666;">As a part of go-green initiative we will not be sending the invoice to you with the shipment. You will receive a soft copy of a invoice as a part of the delivery confirmation email <span tabindex="0" data-term="goog_1208647089">within 24 hours</span> of the delivery completion.</div>
		<div style="padding:10px 0;">Basicfeet.com</div>
		<div style="padding-bottom:20px;">24x7 Customer Support  |  Buyer Protection  |  Flexible Payment Options  |  Largest Collection</div></div>
	</div>';
	
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		// Additional headers
		$headers .= 'To: '.$getuserinfo['firstname'].' <'.$getuserinfo['email'].'>' . "\r\n";
		$headers .= 'From: Basicfeet <support@basicfeet.com>' . "\r\n";
	
		// Mail it
		mail($to, $subject, $message, $headers);
		header("location:reset-password.php?id=".$_REQUEST['id']."&reset=done"); 
		exit();
	}
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
    	<div class="title"><h5>Reset Password</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Password</h5></div>
            <?php if($_REQUEST['reset'] == 'done') { ?> Password Reset Done <?php } ?>
            
            
            <?php if($getuserinfo['type'] == 'B') { ?>
            <div class="rowElem">
            <label>Full Name:</label>
            	<div class="formRight"><?php echo $getuserinfo['firstname'].' '.$getuserinfo['lastname']; ?></div></div>
            <?php } ?>
            
            <?php if($getuserinfo['type'] != 'B') { ?>
            <div class="rowElem">
            <label>Company Name:</label>
            	<div class="formRight"><?php echo $getuserinfo['company_name']; ?></div></div>
            <?php } ?>
            
            <div class="rowElem">
            <label>Reason of Change:</label>
            <div class="formRight"><div><input type="radio" name="reason" value="Incomplete" /> Incomplete Profile Reset</div><div><input type="radio" name="reason" value="Reset" checked="checked" /> Reset Password</div></div><div class="fix"></div></div>
            
            
            <div class="rowElem">
            <label>NEW Password:</label>
            <div class="formRight"><input type="password" name="newpass" /></div><div class="fix"></div></div>
            <div class="rowElem"><label>Confirm Password:</label><div class="formRight">
            <input name="confpass" type="password" id="confpass" /></div><div class="fix"></div></div>
            <br />
            <input name="submitBtn" type="submit" class="greyishBtn submitForm" id="submitBtn" value="Update Password" />
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
