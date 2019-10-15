<?php
session_start();
ob_start();

include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection = DB_CONNECTION();
?>

<?php
if (isset($_POST['register'])) {
    $name = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['name']))));
    $email = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['email']))));
    $password = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['password']))));
    $number = mysql_real_escape_string(htmlentities(addslashes(trim($_POST['number']))));
    $isAcceptedTc = $_POST['checkbox'];
    $duplicatemail = mysql_query(" SELECT * FROM user_register WHERE email='" . $email . "' ");
    $result = mysql_num_rows($duplicatemail);
    if ($result > 0) {
        echo "<script>window.location.href='usersignup.php?duplicateemailstatus=exists'</script>";
    } else {
        #echo "INSERT INTO user_register (id,r_id,name,email,password,contact,status) VALUES ('',2,'".$name."','".$email."','".$password."','".$number."','Active')  ";
        $query = mysql_query("INSERT INTO user_register (id,r_id,name,email,password,contact,status) VALUES ('',2,'" . $name . "','" . $email . "','" . $password . "','" . $number . "','Active')  ");
        $msg = "<html>";
        $msg .= "<head><title>Mybarnite</title></head>";
        $msg .= "<body>";
        $msg .= "Dear $name<br/><br/>Thank you for joining our website.<br/><br/>your account has been activated, please click on this link:\n\n";
        $msg .= SITE_PATH . 'usersignin.php';
        $msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='https://mybarnite.com/images/Picture1.png' width='110'>";
        $msg .= "</body></html>";
        $subj = 'Account Confirmation';
        $to = $email;
        $from = 'info@mybarnite.com';
        $appname = 'Mybarnite';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: info@mybarnite.com" . "\r\n" . "";

        if (mail($to, $subj, $msg, $headers)) {
            $_SESSION['msg'] = '<div class="alert alert-success">Your account has been activated successfully. You may Log in now.</div>';
            echo "<script>window.location.href='usersignin.php'</script>";

        } else {
            $_SESSION['msg'] = '<div class="alert alert-success">There must be some issue with account activation. Please contact to administrator .</div>';
            echo "<script>window.location.href='usersignin.php'</script>";
        }


        //echo "<script>window.location.href='signin.php?registerstatus=true'</script>";
    }
}
?>
<?php include 'head.php'; ?>
<title>Mybarnite - Sign Up</title>
<?php include 'header.php'; ?>
<!--==============================Map=================================-->

<style>
    .signup-chk {
        width: 5% !important;
        vertical-align: middle !important;
        height: 20px !important;
    }
</style>
</header>
<div class="padcontent"></div>

<!--==============================Content=================================-->
<section id="content" class="main-content">
    <div class="container">
        <div class="row clearfix ">
            <div class="span3"></div>
            <div class="span6">
                <h2>User SIGN UP</h2>
                <div id="note"></div>
                <div id="fields" class="contact-form signin-form">
                    <form id="ajax-contact-form" method="post" class="form-horizontal">
                        <?php if (isset($_GET['duplicateemailstatus'])) { ?>
                            <div class="control-group">
                                <label class="control-label" for="inputName" style="color:#ff0000;">Email Already
                                    Exists</label>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['duplicateusername'])) { ?>
                            <div class="control-group">
                                <label class="control-label" for="inputName" style="color:#ff0000;">Name Already
                                    Exists</label>
                            </div>
                        <?php } ?>

                        <div class="control-group">
                            <label class="control-label" for="inputName">NAME:</label>
                            <!--<input type="text" required name="name" class="form-control" placeholder="Name..." pattern="[A-Za-z0-9\S]{1,25}">-->
                            <input type="text" required name="name" class="form-control" placeholder="Name...">
                        </div>
                        <br>


                        <div class="control-group">

                            <label class="control-label" for="inputName">EMAIL:</label>
                            <input type="email" required name="email" class="form-control" placeholder="Email...">
                        </div>
                        <br>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">PASSWORD:</label>
                            <input type="password" id="password" required name="password"
                                   pattern="^(?=[^\d_].*?\d)\w(\w|[!@#$%]){6,}"
                                   title="Alphanumeric, specialchars and min 7 Chars" placeholder="Password...">
                        </div>
                        <br>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">CONFIRM PASSWORD:</label>
                            <input type="password" placeholder="Confirm Password" id="confirm_password" required>
                        </div>
                        <br>

                        <div class="control-group">
                            <label class="control-label" for="inputName">CONTACT NO:</label>
                            <input type="number" required name="number" class="form-control"
                                   placeholder="Contact No...">
                        </div>
                        <br>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail" class="check_box">&nbsp;</label>
                            <input type="checkbox" name="checkbox" value="1" required class="signup-chk">I have read and
                            agree to the <a href="<?php echo SITE_PATH; ?>/terms.php"
                                            style="color:#3179d8;text-decoration:underline;" target="_blank">Terms of
                                conditions</a> and <a href="<?php echo SITE_PATH; ?>/policy.php"
                                                      style="color:#3179d8;text-decoration:underline;" target="_blank">Privacy
                                policy</a>

                        </div>
                        <br>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <input type="submit" name="register" class="btn submit btn-primary " value="SIGN UP">
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
<script>
    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>