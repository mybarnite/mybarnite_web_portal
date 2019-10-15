<?php
session_start();
ob_start();
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection = DB_CONNECTION();

$current_date = strtotime(date("Y-m-d"));
$end_date = strtotime("2016-11-25");

if (isset($_POST['loginbut'])) {

    /* if($current_date<$end_date)
    { */


    $useremail = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['useremail']))));
    $userpassword = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['userpassword']))));
    $loginfailmsg = "";


    //$query = mysql_query(" SELECT * FROM user_register WHERE (email='".$useremail."' AND password='".$userpassword."') or (name='".$useremail."' AND password='".$userpassword."') AND r_id=2 ");
    $query = mysql_query(" SELECT * FROM user_register WHERE (email='" . $useremail . "' or name='" . $useremail . "') AND password='" . $userpassword . "' AND r_id=2 ");
    $result = mysql_num_rows($query);
    $row = mysql_fetch_array($query);
    if ($result > 0) {

        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['name'];
        $_SESSION['useremail'] = $row['email'];
        $_SESSION['FULLNAME'] = $row['name'];
        if (isset($_SESSION['eventToBeBooked'])) {
            echo "<script>window.location.href='eventsdetail.php?event_id=" . $_SESSION['eventToBeBooked'] . "'</script>";
        }
        if (isset($_SESSION['barToBeBooked'])) {
            echo "<script>window.location.href='book_bar.php?bar_id=" . $_SESSION['barToBeBooked'] . "'</script>";
        } else {
            echo "<script>window.location.href='index.php'</script>";
        }

    } else {
        $loginfailmsg = "value";
    }
    /* }
    else
    {
        $loginfailmsg='Invalid Login. Please contact to administrator!!';
    } */

}


if (isset($_POST['forgot_password'])) {
    header("location:forgot_password.php");
}
?>
<?php include 'head.php'; ?>
    <title>Mybarnite - Sign In</title>
    <meta name="keywords" content="SignIn to book the event">
    <meta name="description" content="Mybarnite User signIn">
<?php include 'header.php'; ?>
    <!--==============================Map=================================-->


    </header>
    <div class="padcontent"></div>

    <!--==============================Content=================================-->
    <section id="content" class="main-content">
        <div class="container">
            <div class="row">
                <div class="clearfix ">
                    <div class="span5"></div>
                    <div class="span6">
                        <h2>User Log In</h2>

                    </div>
                    <div class="span5"></div>
                </div>
            </div>
            <div class="row clearfix ">
                <div class="span3"></div>
                <div class="span6">

                    <?php if (isset($_GET['registerstatus'])) { ?>
                        <span style="color:green">Registration Successfully. You can Login Now</span>
                    <?php } ?>
                    <?php if (isset($_SESSION['msg'])) { ?>
                        <span style="color:green">Registration Successfully. You can Login Now</span>
                        <?php
                        unset($_SESSION['msg']);
                    } ?>
                    <div id="note"></div>
                    <div id="fields" class="contact-form signin-form">
                        <form id="ajax-contact-form" class="form-horizontal" method="post">
                            <div class="control-group">
                                <label class="control-label" for="inputName">Email:</label>
                                <input type="text" name="useremail" class="form-control" placeholder="Email..">
                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="inputEmail">Passowrd:</label>
                                <input type="password" required name="userpassword" class="form-control"
                                       placeholder="Password..">

                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <input name="loginbut" type="submit" class="btn submit btn-primary " value="Login">
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <form class="form-horizontal" method="post">
                            <label class="control-label"></label>
                            <input id="forgot_password" name="forgot_password" type="submit"
                                   class="form-control btn submit btn-primary  pull-left" value="Forgot Password">
                        </form>
                    </div>
                </div>

                <!--<div class="span6">
    			<h2>User SIGN UP</h2>
          			<div id="note"></div>
          			<div id="fields" class="contact-form">
          				<form id="ajax-contact-form" method="post" class="form-horizontal">
          					<div class="control-group">
          						<label class="control-label" for="inputName">NAME:</label>
          							<input type="text" required name="name" class="form-control" placeholder="Name..." >
          					</div>
    						<br>
    						
    						<?php //if(isset($_GET['duplicateemailstatus'])){ ?>
    			<span style="color:red">Email Already Exists</span>
    			<?php // } ?>
    			
          					<div class="control-group">
    						
          						<label class="control-label" for="inputName">EMAIL:</label>
          							<input type="email" required name="email" class="form-control" placeholder="Email..." >
          					</div>
    						<br>
    						
    						<div class="control-group">
          						<label class="control-label" for="inputEmail">PASSWORD:</label>
          							<input type="password" required name="password" placeholder="Password...">
          					</div>
          					<br>
    						
          					<div class="control-group">
          						<label class="control-label" for="inputName">CONTACT NO:</label>
          							<input type="number" required name="number" class="form-control" placeholder="Contact No..." >
          					</div>
    						<br>
    					
          					
    						<br>
          					<input type="submit" name="register" class="btn submit btn-primary " value="SIGN UP">
    						<div class="clearfix"></div>
          				</form>
          			</div>
    		  </div>-->


            </div>
        </div>
    </section>


<?php include 'footer.php'; ?>