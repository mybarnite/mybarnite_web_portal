<?php

include("../includes/config.php");



if(isset($_REQUEST['submit']))

{

	$query = "select * from `admin_login` where `username`='".$_REQUEST['login']."' AND `password`='".$_REQUEST['password']."'";

	$sql=mysql_query($query);

	$get = mysql_fetch_array($sql);

	if(mysql_num_rows($sql) > 0)

	{

		$_SESSION['AdminID'] = $get['id'];

		$_SESSION['username'] = $get['username'];

		$_SESSION['modaratorid'] = $get['modaratorid'];

		header("location:index.php");

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

<link href="http://fonts.googleapis.com/css?family=Cuprum" rel="stylesheet" type="text/css" />



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

            <div class="backTo"><a href="../" title=""><img src="images/icons/topnav/mainWebsite.png" alt="" /><span>Main website</span></a></div>

            <!--<div class="userNav">

                <ul>

                    <li><a href="#" title=""><img src="images/icons/topnav/register.png" alt="" /><span>Register</span></a></li>

                    <li><a href="#" title=""><img src="images/icons/topnav/contactAdmin.png" alt="" /><span>Contact admin</span></a></li>

                    <li><a href="#" title=""><img src="images/icons/topnav/help.png" alt="" /><span>Help</span></a></li>

                </ul>

            </div>-->

            <div class="fix"></div>

        </div>

    </div>

</div>



<!-- Login form area -->

<div class="loginWrapper">

	<div class="loginLogo"><?php $getlogo = mysql_fetch_array(mysql_query("SELECT * FROM `website_settings` WHERE id = '1'")); ?><a href="index.php"><img src="../upload/logo/<?php echo $getlogo['site_logo']; ?>" alt="" border="0" /></a></div>

    <div class="loginPanel">

        <div class="head"><h5 class="iUser">Login</h5></div>

        <form action="login.php?check=acct" id="valid" class="mainForm" method="post">

            <fieldset>

                <div class="loginRow noborder">

                    <label for="req1">Username:</label>

                    <div class="loginInput"><input type="text" name="login" class="validate[required]" id="req1" /></div>

                    <div class="fix"></div>

                </div>

                

                <div class="loginRow">

                    <label for="req2">Password:</label>

                    <div class="loginInput"><input type="password" name="password" class="validate[required]" id="req2" /></div>

                    <div class="fix"></div>

                </div>

                

                <div class="loginRow">

                    <input type="submit" name="submit" value="Log me in" class="greyishBtn submitForm" />

                    <div class="fix"></div>

                </div>

            </fieldset>

        </form>

    </div>

</div>



<!-- Footer -->

<div id="footer">

	<div class="wrapper">

    	<span>&copy; Copyright <?php echo date("Y"); ?> Basicfeet.com. All rights reserved. </span>

    </div>

</div>



</body>

</html>

