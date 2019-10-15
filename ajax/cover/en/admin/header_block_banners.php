<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}
$getsettings = mysql_fetch_array(mysql_query("SELECT * FROM `home_banners` WHERE id = '1'"));
if(isset($_REQUEST['submit']))
{
	$random = rand(11111,99999);
	
	if($_FILES['ufile1']['name']!='')
	{
		$target_path1 = "../upload/shopBanner/".$random;
		$target_path1 = $target_path1 . basename($_FILES['ufile1']['name']);
		$FileName1 = $random.$_FILES['ufile1']['name'];
		move_uploaded_file($_FILES['ufile1']['tmp_name'], $target_path1);
	}
	elseif($getsettings['banner1'] != '' && $_FILES['ufile1']['name']=='')
	{
		$FileName1 = $getsettings['banner1'];
	}
	else
	{
		$FileName1 = $getsettings['banner1'];
	}
	
	if($_FILES['ufile2']['name']!='')
	{
		$target_path2 = "../upload/shopBanner/".$random;
		$target_path2 = $target_path2 . basename($_FILES['ufile2']['name']);
		$FileName2 = $random.$_FILES['ufile2']['name'];
		move_uploaded_file($_FILES['ufile2']['tmp_name'], $target_path2);
	}
	elseif($getsettings['banner2'] != '' && $_FILES['ufile2']['name']=='')
	{
		$FileName2 = $getsettings['banner2'];
	}
	else
	{
		$FileName2 = $getsettings['banner2'];
	}
	
	if($_FILES['ufile3']['name']!='')
	{
		$target_path3 = "../upload/shopBanner/".$random;
		$target_path3 = $target_path3 . basename($_FILES['ufile3']['name']);
		$FileName3 = $random.$_FILES['ufile3']['name'];
		move_uploaded_file($_FILES['ufile3']['tmp_name'], $target_path3);
	}
	elseif($getsettings['banner3'] != '' && $_FILES['ufile3']['name']=='')
	{
		$FileName3 = $getsettings['banner3'];
	}
	else
	{
		$FileName3 = $getsettings['banner3'];
	}
	
	if($_FILES['ufile4']['name']!='')
	{
		$target_path4 = "../upload/shopBanner/".$random;
		$target_path4 = $target_path4 . basename($_FILES['ufile4']['name']);
		$FileName4 = $random.$_FILES['ufile4']['name'];
		move_uploaded_file($_FILES['ufile4']['tmp_name'], $target_path4);
	}
	elseif($getsettings['banner4'] != '' && $_FILES['ufile4']['name']=='')
	{
		$FileName4 = $getsettings['banner4'];
	}
	else
	{
		$FileName4 = $getsettings['banner4'];
	}
	
	if($_FILES['ufile5']['name']!='')
	{
		$target_path5 = "../upload/shopBanner/".$random;
		$target_path5 = $target_path5 . basename($_FILES['ufile5']['name']);
		$FileName5 = $random.$_FILES['ufile5']['name'];
		move_uploaded_file($_FILES['ufile5']['tmp_name'], $target_path5);
	}
	elseif($getsettings['banner5'] != '' && $_FILES['ufile5']['name']=='')
	{
		$FileName5 = $getsettings['banner5'];
	}
	else
	{
		$FileName5 = $getsettings['banner5'];
	}
	
	if($_FILES['ufile6']['name']!='')
	{
		$target_path6 = "../upload/shopBanner/".$random;
		$target_path6 = $target_path6 . basename($_FILES['ufile6']['name']);
		$FileName6 = $random.$_FILES['ufile6']['name'];
		move_uploaded_file($_FILES['ufile6']['tmp_name'], $target_path6);
	}
	elseif($getsettings['banner6'] != '' && $_FILES['ufile6']['name']=='')
	{
		$FileName6 = $getsettings['banner6'];
	}
	else
	{
		$FileName6 = $getsettings['banner6'];
	}
	
	if($_FILES['ufile6']['name']!='')
	{
		$target_path6 = "../upload/shopBanner/".$random;
		$target_path6 = $target_path6 . basename($_FILES['ufile6']['name']);
		$FileName6 = $random.$_FILES['ufile6']['name'];
		move_uploaded_file($_FILES['ufile6']['tmp_name'], $target_path6);
	}
	elseif($getsettings['banner6'] != '' && $_FILES['ufile6']['name']=='')
	{
		$FileName6 = $getsettings['banner6'];
	}
	else
	{
		$FileName6 = $getsettings['banner6'];
	}
	
	if($_FILES['ufile7']['name']!='')
	{
		$target_path7 = "../upload/shopBanner/".$random;
		$target_path7 = $target_path7 . basename($_FILES['ufile7']['name']);
		$FileName7 = $random.$_FILES['ufile7']['name'];
		move_uploaded_file($_FILES['ufile7']['tmp_name'], $target_path7);
	}
	elseif($getsettings['banner7'] != '' && $_FILES['ufile7']['name']=='')
	{
		$FileName7 = $getsettings['banner7'];
	}
	else
	{
		$FileName7 = $getsettings['banner7'];
	}
	
	if($_FILES['ufile8']['name']!='')
	{
		$target_path8 = "../upload/shopBanner/".$random;
		$target_path8 = $target_path8 . basename($_FILES['ufile8']['name']);
		$FileName8 = $random.$_FILES['ufile8']['name'];
		move_uploaded_file($_FILES['ufile8']['tmp_name'], $target_path8);
	}
	elseif($getsettings['banner8'] != '' && $_FILES['ufile8']['name']=='')
	{
		$FileName8 = $getsettings['banner8'];
	}
	else
	{
		$FileName8 = $getsettings['banner8'];
	}
	
	if($_FILES['ufile9']['name']!='')
	{
		$target_path9 = "../upload/shopBanner/".$random;
		$target_path9 = $target_path9 . basename($_FILES['ufile9']['name']);
		$FileName9 = $random.$_FILES['ufile9']['name'];
		move_uploaded_file($_FILES['ufile9']['tmp_name'], $target_path9);
	}
	elseif($getsettings['banner9'] != '' && $_FILES['ufile9']['name']=='')
	{
		$FileName9 = $getsettings['banner9'];
	}
	else
	{
		$FileName9 = $getsettings['banner9'];
	}
	
	if($_FILES['ufile10']['name']!='')
	{
		$target_path10 = "../upload/shopBanner/".$random;
		$target_path10 = $target_path10 . basename($_FILES['ufile10']['name']);
		$FileName10 = $random.$_FILES['ufile10']['name'];
		move_uploaded_file($_FILES['ufile10']['tmp_name'], $target_path10);
	}
	elseif($getsettings['banner10'] != '' && $_FILES['ufile10']['name']=='')
	{
		$FileName10 = $getsettings['banner10'];
	}
	else
	{
		$FileName10 = $getsettings['banner10'];
	}
	
	if($_FILES['ufile11']['name']!='')
	{
		$target_path11 = "../upload/shopBanner/".$random;
		$target_path11 = $target_path11 . basename($_FILES['ufile11']['name']);
		$FileName11 = $random.$_FILES['ufile11']['name'];
		move_uploaded_file($_FILES['ufile11']['tmp_name'], $target_path11);
	}
	elseif($getsettings['banner11'] != '' && $_FILES['ufile11']['name']=='')
	{
		$FileName11 = $getsettings['banner11'];
	}
	else
	{
		$FileName11 = $getsettings['banner11'];
	}
	
	mysql_query("UPDATE `home_banners` SET banner1 = '".$FileName1."', banner2 = '".$FileName2."', banner3 = '".$FileName3."', banner4 = '".$FileName4."', banner5 = '".$FileName5."', banner6 = '".$FileName6."', banner7 = '".$FileName7."', banner8 = '".$FileName8."', banner9 = '".$FileName9."', banner10 = '".$FileName10."', banner11 = '".$FileName11."', banner1_url = '".$_REQUEST['banner1_url']."', banner2_url = '".$_REQUEST['banner2_url']."', banner3_url = '".$_REQUEST['banner3_url']."', banner4_url = '".$_REQUEST['banner4_url']."', banner5_url = '".$_REQUEST['banner5_url']."', banner6_url = '".$_REQUEST['banner6_url']."', banner7_url = '".$_REQUEST['banner7_url']."', banner8_url = '".$_REQUEST['banner8_url']."', banner9_url = '".$_REQUEST['banner9_url']."', banner10_url = '".$_REQUEST['banner10_url']."', banner11_url = '".$_REQUEST['banner11_url']."', lastupdate = '".date("d F, Y")."', ipaddr = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '1'");	
	header("location:header_block_banners.php?ret=1"); exit();
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
    	  <h5>Site Management</h5></div>
        
        <!-- Static table -->
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Home Page Banners</h5></div>
			<?php if(isset($_REQUEST['ret']) == '1') { ?>
            <div style="color:#090; font-weight:bold; padding:5px 0 5px 13px;">Home Page Banners Updated Successfully!</div>
            <?php } ?>
            
            <div class="rowElem noborder">
            <label>BANNER 290X258</label>
            <div class="formRight"><input type="file" name="ufile1" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner1']; ?>" width="200" alt="" />
            	<input type="text" name="banner1_url" placeholder="Banner URL" value="<?php echo $getsettings['banner1_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 287X231</label>
            <div class="formRight"><input type="file" name="ufile2" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner2']; ?>" width="200" alt="" />
            	<input type="text" name="banner2_url" placeholder="Banner URL" value="<?php echo $getsettings['banner2_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 289X400</label>
            <div class="formRight"><input type="file" name="ufile3" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner3']; ?>" width="200" alt="" />
            	<input type="text" name="banner3_url" placeholder="Banner URL" value="<?php echo $getsettings['banner3_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 395X265</label>
            <div class="formRight"><input type="file" name="ufile4" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner4']; ?>" width="200" alt="" />
            	<input type="text" name="banner4_url" placeholder="Banner URL" value="<?php echo $getsettings['banner4_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 140X138</label>
            <div class="formRight"><input type="file" name="ufile5" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner5']; ?>" width="200" alt="" />
            	<input type="text" name="banner5_url" placeholder="Banner URL" value="<?php echo $getsettings['banner5_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 147X138</label>
            <div class="formRight"><input type="file" name="ufile6" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner6']; ?>" width="200" alt="" />
            	<input type="text" name="banner6_url" placeholder="Banner URL" value="<?php echo $getsettings['banner6_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 289X163</label>
            <div class="formRight"><input type="file" name="ufile7" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner7']; ?>" width="200" alt="" />
            	<input type="text" name="banner7_url" placeholder="Banner URL" value="<?php echo $getsettings['banner7_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 395X266</label>
            <div class="formRight"><input type="file" name="ufile8" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner8']; ?>" width="200" alt="" />
            	<input type="text" name="banner8_url" placeholder="Banner URL" value="<?php echo $getsettings['banner8_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 377X349</label>
            <div class="formRight"><input type="file" name="ufile9" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner9']; ?>" width="200" alt="" />
            	<input type="text" name="banner9_url" placeholder="Banner URL" value="<?php echo $getsettings['banner9_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 496X349</label>
            <div class="formRight"><input type="file" name="ufile10" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner10']; ?>" value="<?php echo $getsettings['banner10_url']; ?>" width="200" alt="" />
            	<input type="text" name="banner10_url" placeholder="Banner URL" value="<?php echo $getsettings['banner10_url']; ?>" />
            </div></div>
            
            <div class="rowElem noborder">
            <label>BANNER 394X210</label>
            <div class="formRight"><input type="file" name="ufile11" id="fileField" />
            	<img src="../upload/shopBanner/<?php echo $getsettings['banner10']; ?>" width="200" alt="" />
            	<input type="text" name="banner11_url" placeholder="Banner URL" value="<?php echo $getsettings['banner11_url']; ?>" /></div>
                	<div class="fix"></div></div>
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
