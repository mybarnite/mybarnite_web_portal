<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']) && $_REQUEST['product_name'] != '')
{	
	mysql_query("INSERT INTO `products` (`proid`, `uid`, `supplier`, `product_name`, `meta_title`, `meta_keyword`, `meta_description`, `category`, `subcategory`, `barcode_type`, `mrp_differance`, `qtynos`, `pur_rate`, `markup`, `sale_rate`, `dis_percentage`, `o_vat`, `i_vat`, `size1`, `size2`, `size3`, `size4`, `size5`, `size6`, `size7`, `size8`, `size9`, `size10`, `size11`, `size12`, `size13`, `size14`, `size15`, `size16`, `size17`, `size18`, `size19`, `size20`, `colors`, `about_product`, `suggestion_one`, `suggestion_two`, `suggestion_three`, `com_rupees`, `com_percentage`, `discount`, `walking_easy`, `featured`, `date`, `datetime`, `status`) VALUES ('', '', '".$_REQUEST['supplier']."', '".$_REQUEST['product_name']."', '".$_REQUEST['meta_title']."', '".$_REQUEST['meta_keyword']."', '".$_REQUEST['meta_description']."', '".$_REQUEST['category']."', '".$_REQUEST['subcat']."', '".$_REQUEST['barcode_type']."', '".$_REQUEST['mrp_differance']."', '".$_REQUEST['qtynos']."', '".$_REQUEST['pur_rate']."', '".$_REQUEST['markup']."', '".$_REQUEST['sale_rate']."', '".$_REQUEST['dis_percentage']."', '".$_REQUEST['o_vat']."', '".$_REQUEST['i_vat']."', '".$_REQUEST['size1']."', '".$_REQUEST['size2']."', '".$_REQUEST['size3']."', '".$_REQUEST['size4']."', '".$_REQUEST['size5']."', '".$_REQUEST['size6']."', '".$_REQUEST['size7']."', '".$_REQUEST['size8']."', '".$_REQUEST['size9']."', '".$_REQUEST['size10']."', '".$_REQUEST['size11']."', '".$_REQUEST['size12']."', '".$_REQUEST['size13']."', '".$_REQUEST['size14']."', '".$_REQUEST['size15']."', '".$_REQUEST['size16']."', '".$_REQUEST['size17']."', '".$_REQUEST['size18']."', '".$_REQUEST['size19']."', '".$_REQUEST['size20']."', '".$_REQUEST['colors']."', '".$_REQUEST['about_product']."', '".$_REQUEST['suggestion_one']."', '".$_REQUEST['suggestion_two']."', '".$_REQUEST['suggestion_three']."', '".$_REQUEST['com_rupees']."', '".$_REQUEST['com_percentage']."', '".$_REQUEST['discount']."', '".$_REQUEST['walking_easy']."', '".$_REQUEST['featured']."', '".date("d F, Y")."', now(), 'Y')");
	$lastid = mysql_insert_id();
	header("location:upload-image.php?id=".$lastid."");
	exit;
}
$getProduct = mysql_fetch_array(mysql_query("SELECT * FROM `products` WHERE proid = '".$_REQUEST['eID']."'"));
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

<script type="text/javascript" src="jquery-1.3.2.js"></script>
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
</script>
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
            <label>Supplier Name</label>
            	<div class="formRight">
            	  <select name="supplier" id="supplier" style="padding:3px; width:200px;">
            	    <option value="">- Select Supplier -</option>
                    <?php $getsupplier = mysql_query("SELECT * FROM `manufacturers` ORDER BY manufacturer ASC"); 
						  while($getsupplierArr = mysql_fetch_array($getsupplier)) {?>
            	    <option <?php if($getProduct['supplier']==$getsupplierArr['id']) { ?> selected="selected" <?php } ?> value="<?php echo $getsupplierArr['id']; ?>"><?php echo $getsupplierArr['manufacturer']; ?></option>
                    <?php } ?>
          	      </select>
           	  </div></div>
            
            <div class="rowElem noborder">
            <label>Item Name</label>
           	<div class="formRight"><input name="product_name" type="text" id="product_name" value="<?php if($getProduct['product_name']!='') { echo $getProduct['product_name']; } else { echo $_SESSION['item_name']; }?>" /></div></div>
            
            <div class="rowElem noborder">
            <label>Meta Title</label>
           	<div class="formRight"><input name="meta_title" type="text" value="<?php echo $getProduct['meta_title']; ?>" /></div></div>
            <div class="rowElem noborder">
            <label>Meta Keyword</label>
           	<div class="formRight"><input name="meta_keyword" type="text" value="<?php echo $getProduct['meta_keyword']; ?>" /></div></div>
            <div class="rowElem noborder">
            <label>Meta Description</label>
           	<div class="formRight"><input name="meta_description" type="text" value="<?php echo $getProduct['meta_description']; ?>" /></div></div>
            
            <div class="rowElem noborder">
            <label>Category</label>
            <div class="formRight">
            <select name="category" id="search_category_id" style="padding:5px; width:200px;">
            <option value=""></option>
				<?php $getCategory = mysql_query("SELECT * FROM `category` order by id ASC");
                while($getNameCat = mysql_fetch_array($getCategory)) { ?>
                	<option <?php if($getProduct['category']==$getNameCat['id']) { ?> selected="selected" <?php } ?> value="<?php echo $getNameCat['id']; ?>"><?php echo $getNameCat['catname']; ?></option>
                <?php } ?>
            </select>
            </div></div>
            
            <div class="rowElem noborder">
            <label>Sub-Category</label>
            <div class="formRight" style="background-image:url(images/ajax-loader.gif); background-repeat:no-repeat; background-position:left; height:30px;">
            <div id="show_sub_categories">
			<select name="subcat" id="sub_category_id" style="padding:5px; width:200px;">
				<?php if($_REQUEST['eID']!='') { 
                	$getsubcatval = mysql_query("SELECT * FROM `subcat` WHERE catid = '".$getProduct['category']."'"); 
                	while($getsubcatvalArr = mysql_fetch_array($getsubcatval)) { ?>
                		<option <?php if($getProduct['subcategory']==$getsubcatvalArr['id']) { ?> selected="selected" <?php } ?> value="<?php echo $getsubcatvalArr['id']; ?>"><?php echo $getsubcatvalArr['subcat']; ?></option>
                <?php } } ?>
                
                <?php if($_REQUEST['eID']=='') { ?>
					<option value=""></option>
                <?php } ?>
            </select>
			</div>
            </div></div>
            
            <div class="rowElem noborder">
            <label>Barcode Type</label>
            	<div class="formRight"><input name="barcode_type" type="text" id="barcode_type" value="<?php if($getProduct['barcode_type']!='') { echo $getProduct['barcode_type']; } ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>MRP Differance</label>
            	<div class="formRight"><input name="mrp_differance" type="text" id="mrp_differance" value="<?php if($getProduct['mrp_differance']!='') { echo $getProduct['mrp_differance']; } ?>" /></div></div>    
                
            <div class="rowElem noborder">
            <label>Qty (Nos)</label>
            <div class="formRight">Rs. <input name="qtynos" type="text" id="qtynos" style="width:100px;" value="<?php if($getProduct['qtynos']!='') { echo $getProduct['qtynos']; } ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>Pur Rate</label>
            <div class="formRight">Rs. <input name="pur_rate" type="text" id="pur_rate" style="width:100px;" value="<?php if($getProduct['pur_rate']!='') { echo $getProduct['pur_rate']; } ?>" /></div></div>
            
            
            <div class="rowElem noborder">
            <label>Markup</label>
            	<div class="formRight"><input name="markup" type="text" id="markup" style="width:100px;" value="<?php if($getProduct['markup']!='') { echo $getProduct['markup']; } ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>Sale Rate</label>
            	<div class="formRight"><input name="sale_rate" type="text" id="sale_rate" style="width:100px;" value="<?php if($getProduct['sale_rate']!='') { echo $getProduct['sale_rate']; } ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>Dis(%)</label>
            	<div class="formRight"><input name="dis_percentage" type="text" id="dis_percentage" style="width:100px;" value="<?php if($getProduct['dis_percentage']!='') { echo $getProduct['dis_percentage']; } ?>" /></div></div>
            
            <div class="rowElem noborder">
            <label>O-VAT(%)</label>
            	<div class="formRight"><input name="o_vat" type="text" id="o_vat" style="width:200px;" value="<?php if($getProduct['o_vat']!='') { echo $getProduct['o_vat']; } ?>" /></div></div>
            
            <div class="rowElem noborder">
            <label>I-VAT(%)</label>
            	<div class="formRight"><input name="i_vat" type="text" id="i_vat" style="width:200px;" value="<?php if($getProduct['i_vat']!='') { echo $getProduct['i_vat']; } ?>" /></div></div>    
            
            <div class="rowElem noborder">
            <label>Size Details</label>
            	<div class="formRight">
                
<?php if($getProduct['size1'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>1</strong>
<br /><input type="text" name="size1" id="size1" value="<?php echo $getProduct['size1']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size2'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>2</strong>
<br /><input type="text" name="size2" id="size2" value="<?php echo $getProduct['size2']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size3'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>3</strong>
<br /><input type="text" name="size3" id="size3" value="<?php echo $getProduct['size3']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size4'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>4</strong>
<br /><input type="text" name="size4" id="size4" value="<?php echo $getProduct['size4']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size5'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>5</strong>
<br /><input type="text" name="size5" id="size5" value="<?php echo $getProduct['size5']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size6'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>6</strong>
<br /><input type="text" name="size6" id="size6" value="<?php echo $getProduct['size6']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size7'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>7</strong>
<br /><input type="text" name="size7" id="size7" value="<?php echo $getProduct['size1']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size8'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>8</strong>
<br /><input type="text" name="size8" id="size8" value="<?php echo $getProduct['size8']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size9'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>9</strong>
<br /><input type="text" name="size9" id="size9" value="<?php echo $getProduct['size9']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size10'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>10</strong>
<br /><input type="text" name="size10" id="size10" value="<?php echo $getProduct['size10']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size11'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>11</strong>
<br /><input type="text" name="size11" id="size11" value="<?php echo $getProduct['size11']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size12'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>12</strong>
<br /><input type="text" name="size12" id="size12" value="<?php echo $getProduct['size12']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size13'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:13px;"><strong>13</strong>
<br /><input type="text" name="size13" id="size13" value="<?php echo $getProduct['size13']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size14'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>14</strong>
<br /><input type="text" name="size14" id="size14" value="<?php echo $getProduct['size14']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size15'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>15</strong>
<br /><input type="text" name="size15" id="size15" value="<?php echo $getProduct['size15']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size16'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>16</strong>
<br /><input type="text" name="size16" id="size16" value="<?php echo $getProduct['size16']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size17'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>17</strong>
<br /><input type="text" name="size17" id="size17" value="<?php echo $getProduct['size17']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size18'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>18</strong>
<br /><input type="text" name="size18" id="size18" value="<?php echo $getProduct['size18']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size19'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>19</strong>
<br /><input type="text" name="size19" id="size19" value="<?php echo $getProduct['size19']; ?>" style="width:75px;" /></div><?php } ?>

<?php if($getProduct['size20'] != '0') { ?>
<div style="width:19%; float:left; text-align:center; padding-bottom:3px; font-size:14px;"><strong>20</strong>
<br /><input type="text" name="size20" id="size20" value="<?php echo $getProduct['size20']; ?>" style="width:75px;" /></div><?php } ?>
				
                   
            	</div></div>
            
            <div class="rowElem noborder">
            <label>Colors</label>
            <div class="formRight">
            <select name="colors" id="colors" style="padding:5px; width:180px;">
				<option value="">Select Colors</option>
                <?php $getColor = mysql_query("SELECT * FROM `shoe_colors` ORDER BY colors ASC"); 
					  while($getColorArr = mysql_fetch_array($getColor)) { ?>
                <option <?php if($getProduct['colors']==$getColorArr['id']) { ?> selected="selected" <?php } ?> value="<?php echo $getColorArr['id']; ?>"><?php echo $getColorArr['colors']; ?></option>
                <?php } ?>                    
            </select></div></div>
            
            <div class="rowElem noborder">
            <label>About Product</label>
            <div class="formRight">
              <textarea name="about_product" id="about_product" cols="45" rows="5"><?php echo $getProduct['about_product']; ?></textarea></div><div class="fix"></div></div>
            
            <div style="padding-left:15px;"><strong>Feetman Suggestion(s)</strong></div>
            
            <div class="rowElem noborder"><label>Suggestion 1</label>
           	<div class="formRight"><input type="text" name="suggestion_one" id="textfield" value="<?php echo $getProduct['suggestion_one']; ?>" /></div></div>
            
            <div class="rowElem noborder"><label>Suggestion 2</label>
           	<div class="formRight"><input type="text" name="suggestion_two" id="textfield" value="<?php echo $getProduct['suggestion_two']; ?>" /></div></div>
            
            <div class="rowElem noborder"><label>Suggestion 3</label>
           	<div class="formRight"><input type="text" name="suggestion_three" id="textfield" value="<?php echo $getProduct['suggestion_three']; ?>" /></div></div>
             
            <div class="rowElem noborder">
            <label>Com(Rs.)</label>
            	<div class="formRight"><input name="com_rupees" type="text" id="weight" style="width:100px;" value="<?php echo $getProduct['com_rupees']; ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>Com(%)</label>
            	<div class="formRight"><input name="com_percentage" type="text" id="weight" style="width:100px;" value="<?php echo $getProduct['com_percentage']; ?>" /></div></div>
                
            <div class="rowElem noborder">
            <label>Dis(%)</label>
            	<div class="formRight"><input name="discount" type="text" id="weight" style="width:100px;" value="<?php echo $getProduct['discount']; ?>" /></div></div>    
                
            <div class="rowElem noborder">
            <label>Item Image 1</label>
            <div class="formRight"><input type="file" name="ufile1" id="ufile1" />
            	<br /><?php $value1 = strlen($getProduct['item_image1']); if($value1 > 5) { ?><img src="../upload/product/<?php echo $getProduct['item_image1']; ?>" width="200" alt="" /><?php } ?></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 2</label>
            <div class="formRight"><input type="file" name="ufile2" id="ufile2" />
            	<br /><?php $value2 = strlen($getProduct['item_image2']); if($value2 > 5) { ?><img src="../upload/product/<?php echo $getProduct['item_image2']; ?>" width="200" alt="" /><?php } ?></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 3</label>
            <div class="formRight"><input type="file" name="ufile3" id="ufile3" />
            	<br /><?php $value3 = strlen($getProduct['item_image3']); if($value3 > 5) { ?><img src="../upload/product/<?php echo $getProduct['item_image3']; ?>" width="200" alt="" /><?php } ?></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 4</label>
            <div class="formRight"><input type="file" name="ufile4" id="ufile4" />
            	<br /><?php $value4 = strlen($getProduct['item_image4']); if($value4 > 5) { ?><img src="../upload/product/<?php echo $getProduct['item_image4']; ?>" width="200" alt="" /><?php } ?></div></div>
            
            <div class="rowElem noborder">
            <label>Item Image 5</label>
            <div class="formRight"><input type="file" name="ufile5" id="ufile5" />
            	<br /><?php $value5 = strlen($getProduct['item_image5']); if($value5 > 5) { ?><img src="../upload/product/<?php echo $getProduct['item_image1']; ?>" width="200" alt="" /><?php } ?></div></div>    
                
            <div class="rowElem noborder">
            <label>Walking Easy</label>
            <div class="formRight">
            <select name="walking_easy" id="walking_easy" style="padding:3px; width:100px;">
              <option value="N" <?php if($getProduct['walking_easy']=='N') { ?> selected="selected" <?php } ?>>No</option>
              <option value="Y" <?php if($getProduct['walking_easy']=='Y') { ?> selected="selected" <?php } ?>>Yes</option>
            </select></div></div>
            
            <div class="rowElem noborder">
            <label>Featured</label>
            <div class="formRight">
            <select name="featured" id="featured" style="padding:3px; width:100px;">
              <option value="N" <?php if($getProduct['featured']=='N') { ?> selected="selected" <?php } ?>>No</option>
              <option value="Y" <?php if($getProduct['featured']=='Y') { ?> selected="selected" <?php } ?>>Yes</option>
            </select></div></div>
            
            <div class="rowElem noborder">
            <label>Status/Visibility</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:3px; width:100px;">
              <option value="Y" <?php if($getProduct['status']=='Y') { ?> selected="selected" <?php } ?>>Online</option>
              <option value="N" <?php if($getProduct['status']=='N') { ?> selected="selected" <?php } ?>>Offline</option>
            </select></div><div class="fix"></div></div>
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