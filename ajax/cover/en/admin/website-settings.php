<?php include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']))
{	
	$random = rand(1,999999);
	$target_path = "../upload/logo/".$random;
	$target_path = $target_path . basename($_FILES['ufile']['name']);
	$FileName = $random.$_FILES['ufile']['name'];

	if(move_uploaded_file($_FILES['ufile']['tmp_name'], $target_path))
	{		
	mysql_query("UPDATE `website_settings` SET 
						`title` = '".$_REQUEST['title']."',
						`metadesc` = '".$_REQUEST['metadesc']."',
						`metatag` = '".$_REQUEST['metatag']."',
						`faddress` = '".$_REQUEST['faddress']."',
						`fphone` = '".$_REQUEST['fphone']."',
						`femail` = '".$_REQUEST['femail']."',
						`paypalmail` = '".$_REQUEST['paypalmail']."',
						`site_logo` = '".$FileName."',
						`shipping_rate` = '".$_REQUEST['shipping_rate']."',
						`facebook` = '".$_REQUEST['facebook']."',
						`twitter` = '".$_REQUEST['twitter']."',
						`rssfeed` = '".$_REQUEST['rssfeed']."',
						`dorrable` = '".$_REQUEST['dorrable']."',
						`googleplus` = '".$_REQUEST['googleplus']."',
						`pintest` = '".$_REQUEST['pintest']."',
						`linkedin` = '".$_REQUEST['linkedin']."',
						`youtube` = '".$_REQUEST['youtube']."',
						`google1` = '".$_REQUEST['google1']."',
						`google2` = '".$_REQUEST['google2']."',
						`google3` = '".$_REQUEST['google3']."',
						`buyer_one` = '".mysql_real_escape_string($_REQUEST['buyer_one'])."',
						`buyer_two` = '".mysql_real_escape_string($_REQUEST['buyer_two'])."',
						`buyer_three` = '".mysql_real_escape_string($_REQUEST['buyer_three'])."',
						`buyer_four` = '".mysql_real_escape_string($_REQUEST['buyer_four'])."',
						`buyer_five` = '".mysql_real_escape_string($_REQUEST['buyer_five'])."',
						`seller_one` = '".mysql_real_escape_string($_REQUEST['seller_one'])."',
						`seller_two` = '".mysql_real_escape_string($_REQUEST['seller_two'])."',
						`seller_three` = '".mysql_real_escape_string($_REQUEST['seller_three'])."',
						`seller_four` = '".mysql_real_escape_string($_REQUEST['seller_four'])."',
						`seller_five` = '".mysql_real_escape_string($_REQUEST['seller_five'])."',
						`date` = '".date("d F, Y")."',
						`status` = 'Y' WHERE `id` = '1'");
		header("location:website-settings.php");
		exit;	
	}
		else
	{	
	mysql_query("UPDATE `website_settings` SET 
						`title` = '".$_REQUEST['title']."',
						`metadesc` = '".$_REQUEST['metadesc']."',
						`metatag` = '".$_REQUEST['metatag']."',
						`faddress` = '".$_REQUEST['faddress']."',
						`fphone` = '".$_REQUEST['fphone']."',
						`femail` = '".$_REQUEST['femail']."',
						`paypalmail` = '".$_REQUEST['paypalmail']."',
						`shipping_rate` = '".$_REQUEST['shipping_rate']."',
						`facebook` = '".$_REQUEST['facebook']."',
						`twitter` = '".$_REQUEST['twitter']."',
						`rssfeed` = '".$_REQUEST['rssfeed']."',
						`dorrable` = '".$_REQUEST['dorrable']."',
						`googleplus` = '".$_REQUEST['googleplus']."',
						`pintest` = '".$_REQUEST['pintest']."',
						`linkedin` = '".$_REQUEST['linkedin']."',
						`youtube` = '".$_REQUEST['youtube']."',
						`google1` = '".$_REQUEST['google1']."',
						`google2` = '".$_REQUEST['google2']."',
						`buyer_one` = '".mysql_real_escape_string($_REQUEST['buyer_one'])."',
						`buyer_two` = '".mysql_real_escape_string($_REQUEST['buyer_two'])."',
						`buyer_three` = '".mysql_real_escape_string($_REQUEST['buyer_three'])."',
						`buyer_four` = '".mysql_real_escape_string($_REQUEST['buyer_four'])."',
						`buyer_five` = '".mysql_real_escape_string($_REQUEST['buyer_five'])."',
						`seller_one` = '".mysql_real_escape_string($_REQUEST['seller_one'])."',
						`seller_two` = '".mysql_real_escape_string($_REQUEST['seller_two'])."',
						`seller_three` = '".mysql_real_escape_string($_REQUEST['seller_three'])."',
						`seller_four` = '".mysql_real_escape_string($_REQUEST['seller_four'])."',
						`seller_five` = '".mysql_real_escape_string($_REQUEST['seller_five'])."',
						`date` = '".date("d F, Y")."',
						`status` = 'Y' WHERE `id` = '1'");
		header("location:website-settings.php"); exit;
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
	<?php $data = mysql_query("SELECT * FROM website_settings WHERE id = '1'"); $dataVal = mysql_fetch_array($data); ?>
	<!-- Left navigation -->
    <?php include'include/leftnav.php';?>
    
    <!-- Content -->
    <div class="content">
      <div class="title"><h5>Site Management</h5>
      </div>
      <!-- Static table -->
	<form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
      <!-- Input text fields -->
      <fieldset>
          <div class="widget first">
            <div class="head">
              <h5 class="iList">Site Configuration</h5>
            </div>
            <div class="rowElem noborder">
              <label>Page Title</label>
              <div class="formRight">
                <input name="title" type="text" id="title" value="<?php echo $dataVal['title']; ?>" />
              </div></div>
            
            <div class="rowElem">
              <label>Page Description:</label>
              <div class="formRight">
                <input name="metadesc" type="text" id="metadesc" value="<?php echo $dataVal['metadesc']; ?>" />
              </div></div>
            
            <div class="rowElem">
              <label>Page Metatag:</label>
              <div class="formRight">
                <input name="metatag" type="text" id="metatag" value="<?php echo $dataVal['metatag']; ?>" />
              </div></div>
            
            <div class="rowElem">
              <label>Footer Address:</label>
              <div class="formRight">
                <input name="faddress" type="text" id="faddress" value="<?php echo $dataVal['faddress']; ?>" />
              </div></div>
            
            <div class="rowElem">
              <label>Footer Phone:</label>
              <div class="formRight">
                <input name="fphone" type="text" id="fphone" value="<?php echo $dataVal['fphone']; ?>" />
              </div></div>
            
            <div class="rowElem">
              <label>Footer Email:</label>
              <div class="formRight">
                <input name="femail" type="text" id="femail" value="<?php echo $dataVal['femail']; ?>" />
              </div></div>
            
            <!--<div class="rowElem"><label>PayPal Email:</label>
            	<div class="formRight"><input name="paypalmail" type="text" id="paypalmail" value="<?php echo $dataVal['paypalmail']; ?>" />
            </div></div>-->
            
          <div class="rowElem">
          	<label>Facebook URL:</label>
          	<div class="formRight"><input name="facebook" type="text" id="paypalmail" value="<?php echo $dataVal['facebook']; ?>" /></div></div>
          
          <div class="rowElem">
          	<label>Twitter URL:</label>
          	<div class="formRight"><input name="twitter" type="text" id="twitter" value="<?php echo $dataVal['twitter']; ?>" /></div></div>
            
          <div class="rowElem">
          	<label>RSS Feed URL:</label>
          	<div class="formRight"><input name="rssfeed" type="text" id="rssfeed" value="<?php echo $dataVal['rssfeed']; ?>" /></div></div>
            
          <div class="rowElem">
          	<label>Dorrable URL:</label>
          	<div class="formRight"><input name="dorrable" type="text" id="dorrable" value="<?php echo $dataVal['dorrable']; ?>" /></div></div>
          
          <div class="rowElem">
          	<label>GooglePlus URL:</label>
          	<div class="formRight"><input name="googleplus" type="text" id="googleplus" value="<?php echo $dataVal['googleplus']; ?>" /></div></div>
            
          <div class="rowElem">
          	<label>Pinterest URL:</label>
          	<div class="formRight"><input name="pintest" type="text" id="pintest" value="<?php echo $dataVal['pintest']; ?>" /></div></div>
            
          <div class="rowElem">
          	<label>Instagram URL:</label>
          	<div class="formRight"><input name="linkedin" type="text" id="linkedin" value="<?php echo $dataVal['linkedin']; ?>" /></div></div>
            
          <div class="rowElem">
          	<label>YouTube URL:</label>
          	<div class="formRight"><input name="youtube" type="text" id="youtube" value="<?php echo $dataVal['youtube']; ?>" /></div></div>
            
            <div class="rowElem">
              <label>Site Logo:</label>
              <div class="formRight">
                <input type="file" name="ufile" id="ufile" />
                <div style="padding:8px 0 0 0;"><img src="../upload/logo/<?php echo $dataVal['site_logo']; ?>" alt="" /></div>
              </div>
              <div class="fix"></div>
            </div>
            
            <!--<div class="rowElem">
          	<label>Google Ads <br />(Header):</label>
          	<div class="formRight">
            	<textarea name="google3" id="textarea" cols="45" rows="6"><?php echo $dataVal['google3']; ?></textarea></div>
            		<div class="fix"></div></div>
            
            <div class="rowElem">
          	<label>Google Ads <br />:</label>
          	<div class="formRight">
          	  <textarea name="google1" id="textarea" cols="45" rows="6"><?php echo $dataVal['google1']; ?></textarea></div>
            	<div class="fix"></div></div>
            
            <div class="rowElem">
          	<label>Google Ads <br />:</label>
          	<div class="formRight">
            	<textarea name="google2" id="textarea" cols="45" rows="6"><?php echo $dataVal['google2']; ?></textarea></div>
            		<div class="fix"></div></div>-->
            
            <div style="text-align:center; padding:10px 0;"><strong>Buyer Notifications</strong></div>
            <div class="rowElem">
          		<label>Message 1</label>
          		<div class="formRight"><input type="text" name="buyer_one" value="<?php echo $dataVal['buyer_one']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 2</label>
          		<div class="formRight"><input type="text" name="buyer_two" value="<?php echo $dataVal['buyer_two']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 3</label>
          		<div class="formRight"><input type="text" name="buyer_three" value="<?php echo $dataVal['buyer_three']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 4</label>
          		<div class="formRight"><input type="text" name="buyer_four" value="<?php echo $dataVal['buyer_four']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 5</label>
          		<div class="formRight"><input type="text" name="buyer_five" value="<?php echo $dataVal['buyer_five']; ?>" /></div>
       		<div class="fix"></div></div>
            
            <div style="text-align:center; padding:10px 0;"><strong>Seller Notifications</strong></div>
            <div class="rowElem">
          		<label>Message 1</label>
          		<div class="formRight"><input type="text" name="seller_one" value="<?php echo $dataVal['seller_one']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 2</label>
          		<div class="formRight"><input type="text" name="seller_two" value="<?php echo $dataVal['seller_two']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 3</label>
          		<div class="formRight"><input type="text" name="seller_three" value="<?php echo $dataVal['seller_three']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 4</label>
          		<div class="formRight"><input type="text" name="seller_four" value="<?php echo $dataVal['seller_four']; ?>" /></div>
       		<div class="fix"></div></div>
            <div class="rowElem">
          		<label>Message 5</label>
          		<div class="formRight"><input type="text" name="seller_five" value="<?php echo $dataVal['seller_five']; ?>" /></div>
       		<div class="fix"></div></div>
            
            <br />
            <input type="submit" name="submit" value="SAVE" class="greyishBtn submitForm" />
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
    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved. Created By: <a href="http://www.webmantratech.com" target="_blank">WebMantra Technologies (India) Pvt Ltd.</a> </span>
    </div>
</div>

</body>
</html>
