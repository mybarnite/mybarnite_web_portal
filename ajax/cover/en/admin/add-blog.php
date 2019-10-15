<?php
include("../includes/config.php");
if($_SESSION['AdminID'] < '1')
{
	header("location:login.php");
}

if(isset($_REQUEST['submit']) && $_REQUEST['blog_title'] != '' && $_REQUEST['id'] == '')
{
	$random = rand(111111,999999);
	$target_path = "../upload/blogs/".$random;
	$target_path = $target_path . basename($_FILES['ufile']['name']);
	$FileName = $random.$_FILES['ufile']['name'];
	
	$link = $_REQUEST['youtube'];
	strtok($link, '?');
	parse_str(strtok(''));
	
	if(move_uploaded_file($_FILES['ufile']['tmp_name'], $target_path)) 
	{	
		mysql_query("INSERT INTO `blogs` (`blog_id`, `blog_title`, `blog_category`, `short_description`, `description`, `youtube`, `blog_image`, `datetime`, `status`) VALUES ('', '".$_REQUEST['blog_title']."', '".$_REQUEST['category']."', '".mysql_real_escape_string($_REQUEST['short_description'])."', '".mysql_real_escape_string($_REQUEST['description'])."', '".$v."', '".$FileName."', now(), 'Y')");
		header("location:list_blog.php?ret=1"); exit;
	}
		else
	{
		mysql_query("INSERT INTO `blogs` (`blog_id`, `blog_title`, `blog_category`, `short_description`, `description`, `youtube`, `blog_image`, `datetime`, `status`) VALUES ('', '".$_REQUEST['blog_title']."', '".$_REQUEST['category']."', '".mysql_real_escape_string($_REQUEST['short_description'])."', '".mysql_real_escape_string($_REQUEST['description'])."', '".$v."', '', now(), 'Y')");
		header("location:list_blog.php?ret=1"); exit;	
	}
}

if(isset($_REQUEST['submit']) && $_REQUEST['blog_title'] != '' && $_REQUEST['id'] != '')
{
	$random = rand(111111,999999);
	$target_path = "../upload/blogs/".$random;
	$target_path = $target_path . basename($_FILES['ufile']['name']);
	$FileName = $random.$_FILES['ufile']['name'];

	$link = $_REQUEST['youtube'];
	strtok($link, '?');
	parse_str(strtok(''));

	if(move_uploaded_file($_FILES['ufile']['tmp_name'], $target_path)) 
	{		
		mysql_query("UPDATE `blogs` SET `blog_title` = '".$_REQUEST['blog_title']."', `blog_category` = '".$_REQUEST['category']."', `short_description` = '".mysql_real_escape_string($_REQUEST['short_description'])."', `description` = '".mysql_real_escape_string($_REQUEST['description'])."', `youtube` = '".$v."', `blog_image` = '".$FileName."' WHERE blog_id = '".$_REQUEST['id']."'");
		header("location:list_blog.php?id=".$_REQUEST['id']."&ret=1"); exit;
	}
		else
	{
		mysql_query("UPDATE `blogs` SET `blog_title` = '".$_REQUEST['blog_title']."', `blog_category` = '".$_REQUEST['category']."', `short_description` = '".mysql_real_escape_string($_REQUEST['short_description'])."', `description` = '".mysql_real_escape_string($_REQUEST['description'])."', `youtube` = '".$v."' WHERE blog_id = '".$_REQUEST['id']."'");
		header("location:list_blog.php?id=".$_REQUEST['id']."&ret=1"); exit;	
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
<script type="text/javascript" src="js/spinner/ui.spinner.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 
<script type="text/javascript" src="js/fileManager/elfinder.min.js"></script>
<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>

<script type="text/javascript" src="js/dataTables/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/dataTables/colResizable.min.js"></script>
<script type="text/javascript" src="js/colorPicker/colorpicker.js"></script>
<script type="text/javascript" src="js/uploader/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="js/ui/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/forms/forms.js"></script>
<script type="text/javascript" src="js/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="js/forms/autotab.js"></script>
<script type="text/javascript" src="js/forms/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="js/forms/jquery.filestyle.js"></script>

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
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['bold','italic','underline','left','center','right','ol','ul','fontSize','fontFamily','fontFormat','link','unlink','striketrhough','forecolor','bgcolor']}).panelInstance('description');

});
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
                    <li><a href="settings.php" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>
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
        	<li class="iMes"><a href="support.php" title=""><span>Support tickets</span></a><span class="numberMiddle">0</span></li>
            <li class="iUser"><a href="employers.php" title=""><span>Employers</span></a></li>
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
    	  <h5>Articles</h5></div>
        
        <!-- Static table -->
        <form action="" class="mainForm" method="post" name="form1" id="form1" enctype="multipart/form-data">
        <?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') {
		$getQuery = mysql_fetch_array(mysql_query("SELECT * FROM blogs WHERE blog_id = '".$_REQUEST['id']."'")); } ?>
        	<!-- Input text fields -->
            <fieldset>
            <div class="widget first">
            <div class="head">
              <h5 class="iList"><?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') { echo 'Update'; } else { echo 'Add'; } ?> Articles</h5></div>
			<?php if(isset($_REQUEST['ret']) && $_REQUEST['ret'] == '1') { ?>
            <div style="background-color:#e0edc1; color:#415a06; border:#7a9a2f 1px solid; font-weight:bold; padding:8px;">
            	Blog Posted Successfully.</div>
            <?php } ?>
            
            <?php if(isset($_REQUEST['ret']) && $_REQUEST['ret'] == '2') { ?>
            <div style="background-color:#e0edc1; color:#415a06; border:#7a9a2f 1px solid; font-weight:bold; padding:8px;">
            	Blog Information Updated Successfully.</div>
            <?php } ?>
              
            <div class="rowElem noborder">
            <label>Category</label>
            <div class="formRight">
            <select name="category" id="category">
            <option value="">Select Category...</option>
				<?php $getCategory1 = mysql_query("SELECT * FROM `blog_category` ORDER by bcat_id ASC");
                	  while($getNameCat1 = mysql_fetch_array($getCategory1)) { ?>
                <option <?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='' && $getNameCat1['bcat_id'] == $getQuery['blog_category']) { ?> selected="selected" <?php } ?> value="<?php echo $getNameCat1['bcat_id']; ?>"><?php echo $getNameCat1['blog_category']; ?></option>
                <?php } ?>
            </select>
            </div><div class="fix"></div></div>
            
            <div class="rowElem noborder">
            <label>Blog Title</label>
            <div class="formRight"><input name="blog_title" type="text" value="<?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') { echo $getQuery['blog_title']; } ?>" /></div></div>
            
            <div class="rowElem noborder">
            <label>Short Description</label>
            <div class="formRight">
              <textarea name="short_description" cols="45" rows="2"><?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') { echo $getQuery['short_description']; } ?></textarea>
            </div></div>
            
            <div class="rowElem noborder">
            <label>Long Description</label>
            <div class="formRight">
              <textarea name="description" id="description" cols="45" rows="8"><?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') { echo $getQuery['description']; } ?></textarea>
            </div></div>
            <div class="rowElem noborder">
            <label>YouTube Video</label>
            <div class="formRight">
              <input name="youtube" type="text" placeholder="Please enter YouTube Video URL" value="<?php if($getQuery['youtube']!='') { echo 'https://www.youtube.com/watch?v='.$getQuery['youtube']; } ?>" /></div></div>
            <div class="rowElem noborder">
            <label>Picture</label>
            <div class="formRight">
              <input type="file" name="ufile" id="ufile" />
              <div style="padding:8px 0 0 0;"><img src="../upload/blogs/<?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='') { echo $getQuery['blog_image']; } ?>" width="200" alt="" /></div></div><div class="fix"></div></div>
              
            <input type="submit" name="submit" value=" UPDATE " class="greyishBtn submitForm" />
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
    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved.</span>
    </div>
</div>

</body>
</html>