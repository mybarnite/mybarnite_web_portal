<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['DelId'])!='')
{
	mysql_query("DELETE FROM `products` WHERE id = '".$_REQUEST['DelId']."' ");
	header("location:manage-product.php"); exit;
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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>  
<script type="text/javascript">
$(function() {
$(".follow").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "insertFeatured.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="youfollowing_b"> Featured </span>');
	
return false;
});
});

$(function() {
$(".remove_follow").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "removeFeatured.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="follow_b"> Feature </span>');
	
return false;
});
});


$(function() {
$(".popular").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "insertPopular.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="youfollowing_b"> Remove Popular </span>');
	
return false;
});
});

$(function() {
$(".remove_popular").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "removePopular.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="follow_b"> Popular </span>');
	
return false;
});
});


$(function() {
$(".walking_easy").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "insertWalking.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="youfollowing_b"> Remove Walking Easy </span>');
	
return false;
});
});

$(function() {
$(".remove_walking_easy").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "removeWalking.php",
   data: info,
   success: function(){}
 });
 
    $(this).html('<span class="follow_b"> Walking Easy </span>');
	
return false;
});
});
</script>
<style type="text/css">
	.follow_b { background-color:#285694; font-size:11px; padding:5px 8px; color:#FFFFFF; }
	.youfollowing_b { background-color:#598724; font-size:11px; padding:5px 8px; color:#FFFFFF; }
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
    	<div class="title"><h5>Products</h5></div>
        
        <!-- Static table -->
        <div class="widget first">
        	<div class="head">
        	  <h5 class="iFrames">Manage Product</h5>
       	  </div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
            	<thead>
                	<tr>
                        <td colspan="2" style="text-align:left; padding-left:8px;">Product Name</td>
                        <td width="25%" align="center" valign="middle"></td>
                        <td width="12%" align="center" valign="middle">Price</td>
                        <td width="15%" align="center" valign="middle">Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php $getQuery = mysql_query("SELECT * FROM `products` ORDER BY proid DESC");
				while($getValue = mysql_fetch_array($getQuery)) { 
					  $getuser = mysql_fetch_array(mysql_query("SELECT * FROM `register` WHERE id = '".$getValue['uid']."'")); ?>
                	<tr>
                        <td colspan="2"><?php echo $getValue['product_name']; ?><br /><strong>Category:</strong> <?php $getcategory = mysql_fetch_array(mysql_query("SELECT * FROM category WHERE id = '".$getValue['category']."'")); echo $getcategory['catname']; ?> <strong>Sub-category:</strong> <?php $getsubcatName = mysql_fetch_array(mysql_query("SELECT * FROM subcat WHERE id = '".$getValue['subcategory']."'")); echo $getsubcatName['subcat']; ?><br />

<div style="padding:6px 0;"><?php if($getValue['featured'] == 'N' || $getValue['featured'] == '') { ?><a href="#" class="follow" id="<?php echo $getValue['proid']; ?>"><span class="follow_b"> Feature </span></a><?php } if($getValue['featured'] == 'Y') { ?><a href="#" class="remove_follow" id="<?php echo $getValue['proid']; ?>"><span class="youfollowing_b"> Featured </span></a><?php } ?>&nbsp;&nbsp;&nbsp;

<?php if($getValue['popular'] == 'N' || $getValue['popular'] == '') { ?><a href="#" class="popular" id="<?php echo $getValue['proid']; ?>"><span class="follow_b"> Popular </span></a><?php } if($getValue['popular'] == 'Y') { ?><a href="#" class="remove_popular" id="<?php echo $getValue['proid']; ?>"><span class="youfollowing_b"> Remove Popular </span></a><?php } ?>&nbsp;&nbsp;&nbsp;

<?php if($getValue['walking_easy'] == 'N' || $getValue['walking_easy'] == '') { ?><a href="#" class="walking_easy" id="<?php echo $getValue['proid']; ?>"><span class="follow_b"> Walking Easy </span></a><?php } if($getValue['walking_easy'] == 'Y') { ?><a href="#" class="remove_walking_easy" id="<?php echo $getValue['proid']; ?>"><span class="youfollowing_b"> Remove Walking Easy </span></a><?php } ?>&nbsp;&nbsp;&nbsp;

</div>


</td>
                        <td width="25%" align="center" valign="middle"><img src="../upload/product/<?php echo $getValue['item_image1'];?>" width="160" alt="" /></td>
                      	<td width="12%" align="center" valign="middle"><?php echo 'Rs.'.number_format($getValue['sale_rate'],2); ?></td>
                        <td width="15%" align="center" valign="middle"><a href="../secure-edititem.php?id=<?php echo $getValue['proid']; ?>&uid=<?php echo $getValue['uid']; ?>&type=<?php echo $getuser['type']; ?>" target="_blank">Edit</a> / <a href="manage-product.php?DelId=<?php echo $getValue['proid']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                    </tr>
                    <?php } ?>
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

</body>
</html>
