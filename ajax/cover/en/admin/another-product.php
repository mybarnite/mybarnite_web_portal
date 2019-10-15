<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

$getProduct = mysql_fetch_array(mysql_query("SELECT * FROM `products` WHERE proid = '".$_REQUEST['id']."'"));

if(isset($_REQUEST['submit']))
{	
	mysql_query("INSERT INTO `products` (`proid`, `uid`, `supplier`, `product_name`, `category`, `subcategory`, `barcode_type`, `mrp_differance`, `qtynos`, `pur_rate`, `markup`, `sale_rate`, `dis_percentage`, `o_vat`, `i_vat`, `size1`, `size2`, `size3`, `size4`, `size5`, `size6`, `size7`, `size8`, `size9`, `size10`, `size11`, `size12`, `size13`, `size14`, `size15`, `size16`, `size17`, `size18`, `size19`, `size20`, `colors`, `about_product`, `suggestion_one`, `suggestion_two`, `suggestion_three`, `com_rupees`, `com_percentage`, `discount`, `featured`, `date`, `datetime`, `status`) VALUES ('', '', '".$getProduct['supplier']."', '".$getProduct['product_name']."', '".$getProduct['category']."', '".$getProduct['subcategory']."', '".$getProduct['barcode_type']."', '".$getProduct['mrp_differance']."', '".$getProduct['qtynos']."', '".$getProduct['pur_rate']."', '".$getProduct['markup']."', '".$getProduct['sale_rate']."', '".$getProduct['dis_percentage']."', '".$getProduct['o_vat']."', '".$getProduct['i_vat']."', '".$getProduct['size1']."', '".$getProduct['size2']."', '".$getProduct['size3']."', '".$getProduct['size4']."', '".$getProduct['size5']."', '".$getProduct['size6']."', '".$getProduct['size7']."', '".$getProduct['size8']."', '".$getProduct['size9']."', '".$getProduct['size10']."', '".$getProduct['size11']."', '".$getProduct['size12']."', '".$getProduct['size13']."', '".$getProduct['size14']."', '".$getProduct['size15']."', '".$getProduct['size16']."', '".$getProduct['size17']."', '".$getProduct['size18']."', '".$getProduct['size19']."', '".$getProduct['size20']."', '".$_SESSION['color']."', '".$getProduct['about_product']."', '".$getProduct['suggestion_one']."', '".$getProduct['suggestion_two']."', '".$getProduct['suggestion_three']."', '".$getProduct['com_rupees']."', '".$getProduct['com_percentage']."', '".$getProduct['discount']."', '".$getProduct['featured']."', '".date("d F, Y")."', now(), 'Y')");
	$lastid = mysql_insert_id();
	header("location:upload-image.php?id=".$lastid."");
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

<!--<script type="text/javascript" src="jquery-1.3.2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$('#loader').hide();
	$('#show_heading').hide();
	
	$('#search_category_id').change(function(){
		$('#show_sub_categories').fadeOut();
		$('#loader').show();
		$.post("get_chid_categories.php", {
			parent_id: $('#search_category_id').val(),
		}, function(response){
			
			setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
		});
		return false;
	});
});

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} 

function alert_id()
{
	if($('#sub_category_id').val() == '')
	alert('Please select a sub category.');
	else
	alert($('#sub_category_id').val());
	return false;
}
</script>-->
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
        
        <!-- Static table -->
        <form action="" method="post" enctype="multipart/form-data" name="form1" class="mainForm" id="form1">
        
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head"><h5 class="iList">Add Product - Step 2</h5></div>
             
            
            <div class="rowElem noborder">
            <label>Size Details</label>
            <div class="formRight">
            
            <?php if($_SESSION['from_size'] >= 1) { for($i=1;$i<$_SESSION['from_size'];$i++) { ?>
            <input type="hidden" name="size<?php echo $i; ?>" id="size<?php echo $i; ?>" style="width:75px;" /><?php } } ?>
            
            <?php if($_SESSION['to_size'] > $_SESSION['from_size']) { for($i=$_SESSION['from_size'];$i<=$_SESSION['to_size'];$i++) { ?>
            <div style="width:19%; float:left; text-align:center; padding-bottom:3px;"><strong style="font-size:14px;"><?php echo $i; ?></strong>
            <br /><input type="text" name="size<?php echo $i; ?>" id="size<?php echo $i; ?>" style="width:75px;" /></div><?php } } ?>
            
            <?php if($_SESSION['to_size'] <= 20) {  for($i<=$_SESSION['to_size'];$i<=20;$i++) { ?>
            <input type="hidden" name="size<?php echo $i; ?>" id="size<?php echo $i; ?>" style="width:75px;" /><?php } } ?>
               
            </div></div>
                
            <!--<div class="rowElem noborder">
            <label>Featured</label>
            <div class="formRight">
            <select name="featured" id="featured" style="padding:3px; width:100px;">
              <option value="N">No</option>
              <option value="Y">Yes</option>
            </select></div></div>
            
            <div class="rowElem noborder">
            <label>Status/Visibility</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:3px; width:100px;">
              <option value="Y">Online</option>
              <option value="N">Offline</option>
            </select></div><div class="fix"></div></div>--><div class="fix"></div>
            
            <input type="submit" name="submit" value="Continue &gt;&gt;" class="greyishBtn submitForm" />
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