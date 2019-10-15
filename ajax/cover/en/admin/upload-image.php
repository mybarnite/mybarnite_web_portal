<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['confirm']))
{
	$random = rand(111111,999999);
	$target_path1 = "../upload/product/".$random;
	$target_path1 = $target_path1 . basename($_FILES['ufile1']['name']);
	$FileName1 = $random.$_FILES['ufile1']['name'];
	
	if(move_uploaded_file($_FILES['ufile1']['tmp_name'], $target_path1))
	{
		$image_one = $FileName1;
	}
	else
	{
		$image_one = $getProduct['item_image1'];
	}
	
	$target_path2 = "../upload/product/".$random;
	$target_path2 = $target_path2 . basename($_FILES['ufile2']['name']);
	$FileName2 = $random.$_FILES['ufile2']['name'];
	
	if(move_uploaded_file($_FILES['ufile2']['tmp_name'], $target_path2))
	{
		$image_two = $FileName2;
	}
	else
	{
		$image_two = $getProduct['item_image2'];
	}
	
	$target_path3 = "../upload/product/".$random;
	$target_path3 = $target_path3 . basename($_FILES['ufile3']['name']);
	$FileName3 = $random.$_FILES['ufile3']['name'];
		
	if(move_uploaded_file($_FILES['ufile3']['tmp_name'], $target_path3))
	{
		$image_three = $FileName3;
	}
	else
	{
		$image_three = $getProduct['item_image3'];
	}	
	
	$target_path4 = "../upload/product/".$random;
	$target_path4 = $target_path4 . basename($_FILES['ufile4']['name']);
	$FileName4 = $random.$_FILES['ufile4']['name'];
		
	if(move_uploaded_file($_FILES['ufile4']['tmp_name'], $target_path4))
	{
		$image_four = $FileName4;
	}
	else
	{
		$image_four = $getProduct['item_image4'];
	}
	
	$target_path5 = "../upload/product/".$random;
	$target_path5 = $target_path5 . basename($_FILES['ufile5']['name']);
	$FileName5 = $random.$_FILES['ufile5']['name'];
		
	if(move_uploaded_file($_FILES['ufile5']['tmp_name'], $target_path5))
	{
		$image_five = $FileName5;
	}
	else
	{
		$image_five = $getProduct['item_image5'];
	}

	mysql_query("UPDATE `products` SET item_image1 = '".$image_one."', item_image2 = '".$image_two."', item_image3 = '".$image_three."', item_image4 = '".$image_four."', item_image5 = '".$image_five."' WHERE proid = '".$_REQUEST['id']."'");
	
	unset($_SESSION['item_name']);
	unset($_SESSION['from_size']);
	unset($_SESSION['to_size']);
	
	header("location:upload-image.php?ret=1&proid=".$_REQUEST['id'].""); exit;
}

if(isset($_REQUEST['proceed']) && $_REQUEST['color_name']!='')
{
	mysql_query("INSERT INTO `shoe_colors` (`id`, `uid`, `colors`, `status`) VALUES ('', '0', '".$_REQUEST['color_name']."', 'Y')");
	$lastcatid = mysql_insert_id();
	
	$_SESSION['color'] = $lastcatid;	
	$_SESSION['from_size'] = $_REQUEST['from_size'];
	$_SESSION['to_size'] = $_REQUEST['to_size'];
	
	header("location:another-product.php?id=".$_REQUEST['proid'].""); exit;
}

if(isset($_REQUEST['proceed']) && $_REQUEST['colors']!='')
{	
	$_SESSION['color'] = $_REQUEST['colors'];	
	$_SESSION['from_size'] = $_REQUEST['from_size'];
	$_SESSION['to_size'] = $_REQUEST['to_size'];
	
	header("location:another-product.php?id=".$_REQUEST['proid'].""); exit;
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
    	<div class="title"><h5>Products</h5></div>
        
        <?php if($_REQUEST['ret'] == '') { ?>
        <!-- Static table -->
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Add Product - Step 3</h5></div>
            
            <?php if($_REQUEST['ret'] == '1') { ?><div class="success_alert">Congrats! Product Information Added Scuccessfully.</div><?php } ?>
            
            <div class="rowElem noborder">
            <label>Item Image 1</label>
            <div class="formRight"><input type="file" name="ufile1" /></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 2</label>
            <div class="formRight"><input type="file" name="ufile2" /></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 3</label>
            <div class="formRight"><input type="file" name="ufile3" /></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 4</label>
            <div class="formRight"><input type="file" name="ufile4" /></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 5</label>
            <div class="formRight"><input type="file" name="ufile5" /></div></div>
            <br />
            <input type="submit" name="confirm" value="Save &amp; Continue" class="greyishBtn submitForm" />
            <div class="fix"></div>
            </div>
            </fieldset>
            
            <!-- WYSIWYG editor -->
            
        	</form>
        <?php } ?>
        
        <?php if($_REQUEST['ret'] == '1') { ?>
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        <?php $getProduct = mysql_fetch_array(mysql_query("SELECT * FROM `products` WHERE proid = '".$_REQUEST['proid']."'")); ?>
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Add Same Product in other Color</h5></div>
            
            <?php if($_REQUEST['ret'] == '1') { ?><div class="success_alert">Congrats! Product Information Added Scuccessfully.</div><?php } ?>
            
            <div class="rowElem noborder"><strong>Product Name:</strong></div>
            
            <div style="padding-left:14px;"><?php echo $getProduct['product_name']; ?></div>
            
            <div class="rowElem noborder"><strong>Do you have same product in other color?</strong></div>
            
            <div class="rowElem noborder">
              <select name="colors" id="colors" style="padding:5px; width:180px;">
				<option value="">Select Another Colors</option>
                 <?php $getColor = mysql_query("SELECT * FROM `shoe_colors` ORDER BY colors ASC"); 
					  while($getColorArr = mysql_fetch_array($getColor)) { ?>
                <option value="<?php echo $getColorArr['id']; ?>"><?php echo $getColorArr['colors']; ?></option>
                <?php } ?>
            </select>
            </div>
            
           <div class="rowElem noborder"><strong>Didn't find your preferred color in above dropdown?</strong></div>
            
            <div class="rowElem noborder"><input type="text" name="color_name" id="color_name" placeholder="Enter color name" /></div>
            
            <div class="rowElem noborder">
            <label>From Size</label>
            <div class="formRight"><input name="from_size" type="text" id="from_size" style="width:100px;" value="" /> Min Size: 1</div></div>
            
            <div class="rowElem noborder">
            <label>To Size</label>
            <div class="formRight"><input name="to_size" type="text" id="to_size" style="width:100px;" value="" />  Max Size: 20</div></div>
            
            <br />
            <input type="button" name="proceed" value=" Finish Upload " class="button" onClick="window.location='manage-product.php'" />&nbsp;&nbsp;<input type="submit" name="proceed" value="Continue &gt; &gt;" class="greyishBtn submitForm" />
            <div class="fix"></div>
            </div>
            </fieldset>
            
            <!-- WYSIWYG editor -->
            
        	</form>
                
        <!-- Charts -->
        <?php } ?>
        
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