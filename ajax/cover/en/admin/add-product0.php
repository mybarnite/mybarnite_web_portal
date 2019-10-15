<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']) && $_REQUEST['product_name'] != '')
{	
	$totalQuantity = ($_REQUEST['size1'] + $_REQUEST['size2'] + $_REQUEST['size3'] + $_REQUEST['size4'] + $_REQUEST['size5'] + $_REQUEST['size6'] + $_REQUEST['size7'] + $_REQUEST['size8'] + $_REQUEST['size9'] + $_REQUEST['size10'] + $_REQUEST['size11'] + $_REQUEST['size12'] + $_REQUEST['size13'] + $_REQUEST['size14'] + $_REQUEST['size15'] + $_REQUEST['size16'] + $_REQUEST['size17'] + $_REQUEST['size18'] + $_REQUEST['size19'] + $_REQUEST['size20']);
	$productID = rand(111111,999999);
	mysql_query("INSERT INTO `products` (`proid`, `uid`, `similar`, `supplier`, `designer_brand`, `product_name`, `meta_title`, `meta_keyword`, `meta_description`, `category`, `subcategory`, `sale_rate`, `qtynos`, `mrp_price`, `exchange_policy`, `o_vat`, `i_vat`, `leather_type`, `size1`, `size2`, `size3`, `size4`, `size5`, `size6`, `size7`, `size8`, `size9`, `size10`, `size11`, `size12`, `size13`, `size14`, `size15`, `size16`, `size17`, `size18`, `size19`, `size20`, `size21`, `size22`, `size23`, `size24`, `size25`, `size26`, `size27`, `size28`, `size29`, `size30`, `size31`, `size32`, `size33`, `size34`, `size35`, `size36`, `size37`, `size38`, `size39`, `size40`, `size41`, `size42`, `size43`, `size44`, `size45`, `size46`, `size47`, `size48`, `colors`, `about_product`, `sizing`, `material`, `return_policy`, `suggestion`, `discount`, `midnight_deal`, `cash_on_delivery` , `wedutch_discount`, `shipping_price`, `cod_charge`, `shoe_type`, `date`, `datetime`, `status`) VALUES ('$productID', '".$_SESSION['id']."', '$productID', '".$_REQUEST['supplier']."', '".$_REQUEST['designer_brand']."', '".mysql_real_escape_string($_REQUEST['product_name'])."', '".mysql_real_escape_string($_REQUEST['meta_title'])."', '".mysql_real_escape_string($_REQUEST['meta_keyword'])."', '".mysql_real_escape_string($_REQUEST['meta_description'])."', '".$_REQUEST['category']."', '".$_REQUEST['subcat']."', '".$_REQUEST['sale_rate']."', '$totalQuantity', '".$_REQUEST['mrp_price']."', '".$_REQUEST['exchange_policy']."', '".$_REQUEST['o_vat']."', '".$_REQUEST['i_vat']."', '".$_REQUEST['leather_type']."', '".$_REQUEST['size1']."', '".$_REQUEST['size2']."', '".$_REQUEST['size3']."', '".$_REQUEST['size4']."', '".$_REQUEST['size5']."', '".$_REQUEST['size6']."', '".$_REQUEST['size7']."', '".$_REQUEST['size8']."', '".$_REQUEST['size9']."', '".$_REQUEST['size10']."', '".$_REQUEST['size11']."', '".$_REQUEST['size12']."', '".$_REQUEST['size13']."', '".$_REQUEST['size14']."', '".$_REQUEST['size15']."', '".$_REQUEST['size16']."', '".$_REQUEST['size17']."', '".$_REQUEST['size18']."', '".$_REQUEST['size19']."', '".$_REQUEST['size20']."', '".$_REQUEST['size21']."', '".$_REQUEST['size22']."', '".$_REQUEST['size23']."', '".$_REQUEST['size24']."', '".$_REQUEST['size25']."', '".$_REQUEST['size26']."', '".$_REQUEST['size27']."', '".$_REQUEST['size28']."', '".$_REQUEST['size29']."', '".$_REQUEST['size30']."', '".$_REQUEST['size31']."', '".$_REQUEST['size32']."', '".$_REQUEST['size33']."', '".$_REQUEST['size34']."', '".$_REQUEST['size35']."', '".$_REQUEST['size36']."', '".$_REQUEST['size37']."', '".$_REQUEST['size38']."', '".$_REQUEST['size39']."', '".$_REQUEST['size40']."', '".$_REQUEST['size41']."', '".$_REQUEST['size42']."', '".$_REQUEST['size43']."', '".$_REQUEST['size44']."', '".$_REQUEST['size45']."', '".$_REQUEST['size46']."', '".$_REQUEST['size47']."', '".$_REQUEST['size48']."', '".$_REQUEST['colors']."', '".mysql_real_escape_string($_REQUEST['about_product'])."', '', '".mysql_real_escape_string($_REQUEST['material'])."', '".mysql_real_escape_string($_REQUEST['return_policy'])."', '".$_REQUEST['suggestion']."', '".$_REQUEST['discount']."', '".$_REQUEST['midnight_deal']."', '".$_REQUEST['cash_on_delivery']."', '".$_REQUEST['wedutch_discount']."', '".$_REQUEST['shipping_price']."', '".$_REQUEST['cod_charge']."', '".$_REQUEST['shoe_type']."', '".date("d F, Y")."', now(), 'Y')");	
	$lastid = mysql_insert_id();

	/*mysql_query("INSERT INTO `products` (`proid`, `uid`, `supplier`, `product_name`, `meta_title`, `meta_keyword`, `meta_description`, `category`, `subcategory`, `barcode_type`, `mrp_differance`, `qtynos`, `pur_rate`, `markup`, `sale_rate`, `dis_percentage`, `o_vat`, `i_vat`, `size1`, `size2`, `size3`, `size4`, `size5`, `size6`, `size7`, `size8`, `size9`, `size10`, `size11`, `size12`, `size13`, `size14`, `size15`, `size16`, `size17`, `size18`, `size19`, `size20`, `colors`, `about_product`, `suggestion_one`, `suggestion_two`, `suggestion_three`, `com_rupees`, `com_percentage`, `discount`, `featured`, `date`, `datetime`, `status`) VALUES ('', '', '".$_REQUEST['supplier']."', '".$_REQUEST['product_name']."', '".$_REQUEST['meta_title']."', '".$_REQUEST['meta_keyword']."', '".$_REQUEST['meta_description']."', '".$_REQUEST['category']."', '".$_REQUEST['subcat']."', '".$_REQUEST['barcode_type']."', '".$_REQUEST['mrp_differance']."', '".$_REQUEST['qtynos']."', '".$_REQUEST['pur_rate']."', '".$_REQUEST['markup']."', '".$_REQUEST['sale_rate']."', '".$_REQUEST['dis_percentage']."', '".$_REQUEST['o_vat']."', '".$_REQUEST['i_vat']."', '".$_REQUEST['size1']."', '".$_REQUEST['size2']."', '".$_REQUEST['size3']."', '".$_REQUEST['size4']."', '".$_REQUEST['size5']."', '".$_REQUEST['size6']."', '".$_REQUEST['size7']."', '".$_REQUEST['size8']."', '".$_REQUEST['size9']."', '".$_REQUEST['size10']."', '".$_REQUEST['size11']."', '".$_REQUEST['size12']."', '".$_REQUEST['size13']."', '".$_REQUEST['size14']."', '".$_REQUEST['size15']."', '".$_REQUEST['size16']."', '".$_REQUEST['size17']."', '".$_REQUEST['size18']."', '".$_REQUEST['size19']."', '".$_REQUEST['size20']."', '".$_REQUEST['colors']."', '".mysql_real_escape_string($_REQUEST['about_product'])."', '".$_REQUEST['suggestion_one']."', '".$_REQUEST['suggestion_two']."', '".$_REQUEST['suggestion_three']."', '".$_REQUEST['com_rupees']."', '".$_REQUEST['com_percentage']."', '".$_REQUEST['discount']."', '".$_REQUEST['featured']."', '".date("d F, Y")."', now(), 'Y')");*/
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
            <label>Brand Name</label>
            	<div class="formRight">
            	  <select name="supplier" id="supplier" style="padding:3px; width:200px;">
            	    <option value="">- Select Brand -</option>
                    <?php $getsupplier = mysql_query("SELECT * FROM `manufacturers` ORDER BY manufacturer ASC"); 
						  while($getsupplierArr = mysql_fetch_array($getsupplier)) {?>
            	    <option value="<?php echo $getsupplierArr['id']; ?>"><?php echo $getsupplierArr['manufacturer']; ?></option>
                    <?php } ?>
          	      </select>
           	  </div></div>
            
            <div class="rowElem noborder">
            <label>Item Name</label>
           	<div class="formRight"><input name="product_name" type="text" value="<?php echo $_SESSION['item_name']; ?>" /></div></div>
                        
            <div class="rowElem noborder">
            <label>Category</label>
            <div class="formRight">
            <select name="category" id="search_category_id" style="padding:5px; width:200px;">
            <option value=""></option>
				<?php $getCategory = mysql_query("SELECT * FROM `category` order by id ASC");
                while($getNameCat = mysql_fetch_array($getCategory)) { ?>
                	<option value="<?php echo $getNameCat['id']; ?>"><?php echo $getNameCat['catname']; ?></option>
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
                		<option value="<?php echo $getsubcatvalArr['id']; ?>"><?php echo $getsubcatvalArr['subcat']; ?></option>
                <?php } } ?>
                
                <?php if($_REQUEST['eID']=='') { ?>
					<option value=""></option>
                <?php } ?>
            </select>
			</div>
            </div></div>
            
            <!--<div class="rowElem noborder">
            <label>Barcode Type</label>
            	<div class="formRight"><input name="barcode_type" type="text" id="barcode_type" /></div></div>
            
            <div class="rowElem noborder">
            <label>MRP Differance</label>
            	<div class="formRight"><input name="mrp_differance" type="text" id="mrp_differance" /></div></div>
            
            <!--<div class="rowElem noborder">
            <label>Markup</label>
            	<div class="formRight"><input name="markup" type="text" id="markup" style="width:100px;" /></div></div>-->
            
            <div class="rowElem noborder">
            <label>MRP Price</label>
            <div class="formRight">Rs. <input name="mrp_price" type="text" style="width:100px;" /></div></div>
                
            <div class="rowElem noborder">
            <label>Sale Rate</label>
            	<div class="formRight">Rs. <input name="sale_rate" type="text" style="width:100px;" /></div></div>
            
            <div class="rowElem noborder">
            <label>O-VAT(%)</label>
            	<div class="formRight">
            	  <input name="o_vat" type="radio" id="radio" value="12.5" checked="checked" /> 12.5% &nbsp;&nbsp;&nbsp;<input type="radio" name="o_vat" id="radio2" value="5" /> 5%
              </div></div>
                          
            <div class="rowElem noborder">
            	<label>Shoe Type</label>
            	<div class="formRight">
            	  <input type="radio" name="shoe_type" value="WL"> With Laces&nbsp;&nbsp;&nbsp;<input name="shoe_type" type="radio" value="NL" checked> Without Laces&nbsp;&nbsp;&nbsp;<input type="radio" name="shoe_type" value="V"> Velcro Tape
            </div></div>
             
            <div class="rowElem noborder">
            <label>Leather Type</label>
            	<div class="formRight">
            	  <input type="radio" name="leather_type" id="leather_type" value="1" checked="checked" /> Pure Leather &nbsp;&nbsp;&nbsp;<input type="radio" name="leather_type" id="leather_type" value="2" /> Artificial Leather
              </div></div>      
            
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
            
            <div class="rowElem noborder">
            <label>Colors</label>
            <div class="formRight">
            <select name="colors" id="colors" style="padding:5px; width:180px;">
				<option value="">Select Colors</option>
                <?php $getColor = mysql_query("SELECT * FROM `shoe_colors` ORDER BY colors ASC"); 
					  while($getColorArr = mysql_fetch_array($getColor)) { ?>
                <option value="<?php echo $getColorArr['id']; ?>"><?php echo $getColorArr['colors']; ?></option>
                <?php } ?>
            </select></div></div>
            
            <div class="rowElem noborder">
            <label>About Product</label>
            <div class="formRight">
              <textarea name="about_product" cols="45" rows="5"></textarea></div><div class="fix"></div></div>
            <div class="rowElem noborder">
            <label>Material</label>
            <div class="formRight">
              <textarea name="material" cols="45" rows="5"></textarea></div><div class="fix"></div></div>
            
            <div style="clear:both;"></div>
            <div style="padding:0 0 10px 15px;"><input name="cash_on_delivery" type="checkbox" value="Y"> Please check, If this product is not available for <strong>Cash On Delivery</strong>.</div>
            <div style="padding:0 0 10px 15px;">
            	<table width="82%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="25%" height="26" align="left" valign="top"><strong>MidNight Deal Price</strong></td>
             <td width="25%" height="26" align="left" valign="top"><strong>WeDutch Discount (%)</strong></td>
             <td width="25%" align="left" valign="top"><strong>Shipping Charge</strong></td>
             <td width="25%" align="left" valign="top"><strong>COD Charge</strong></td>
           </tr>
           <tr>
             <td width="25%" align="left" valign="top">Rs. <input type="text" name="midnight_deal" class="inputbox" style="width:100px;"></td>
             <td width="25%" align="left" valign="top"><input name="wedutch_discount" type="text" class="inputbox" style="width:100px;" /></td>
             <td width="25%" align="left" valign="top">Rs. <input name="shipping_price" type="text" class="inputbox" style="width:100px;" /></td>
             <td width="25%" align="left" valign="top">Rs. <input type="text" name="cod_charge" class="inputbox" style="width:80px;"></td>
           </tr>
         </table>
            </div>
            
            <div style="clear:both;"></div>
            
          <div style="padding:0 0 10px 15px;">
            	<div style="padding-bottom:5px;"><strong>Exchange Policy</strong></div>
         <table width="54%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="5%"><input type="radio" name="exchange_policy" id="radio" value="NE"></td>
             <td width="25%">No Exchange</td>
             <td width="5%"><input name="exchange_policy" type="radio" id="radio2" value="ES" checked></td>
             <td width="25%">Exchange for Size</td>
             <td width="5%"><input type="radio" name="exchange_policy" id="radio5" value="EA"></td>
             <td width="25%">Easy Returns</td>
           </tr>
         </table>
         <div style="padding:10px 0 5px 0;"><strong>Feetman Suggestion</strong></div>
         <table width="60%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="7%"><input type="radio" name="suggestion" value="1"></td>
             <td width="25%">Buy a Size Large</td>
             <td width="5%"><input type="radio" name="suggestion" value="2"></td>
             <td width="30%">Go for the prefect size</td>
             <td width="7%"><input type="radio" name="suggestion" value="3"></td>
             <td width="26%">Take a size smaller</td>
           </tr>
         </table>
         </div>
         	<div style="padding:10px 0 8px 15px;"><strong>SEO Meta Information for Better SEO Search Result</strong></div>
            <div style="clear:both;"></div>
            
            <div class="rowElem noborder">
            <label>Meta Title</label>
           	<div class="formRight"><input name="meta_title" type="text" value="" /></div></div>
            <div class="rowElem noborder">
            <label>Meta Keyword</label>
           	<div class="formRight"><input name="meta_keyword" type="text" value="" /></div></div>
            <div class="rowElem noborder">
            <label>Meta Description</label>
           	<div class="formRight"><input name="meta_description" type="text" value="" /></div></div>
            
            <div class="rowElem noborder">
            <label>Status/Visibility</label>
            <div class="formRight">
            <select name="status" id="status" style="padding:3px; width:100px;">
              <option value="Y">Online</option>
              <option value="N">Offline</option>
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