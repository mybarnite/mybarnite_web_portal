<?php

include('template-parts/header.php');

?>
    <style>
        .validation-note {
            margin-left: 0 !important;
            border: 1px solid #ff1da5 !important;
            padding: 10px !important;
        }

        .validation-note ul li {
            line-height: 25px !important;
            font-size: 14px !important;
        }

        .signup-chk {
            width: 5% !important;
            vertical-align: middle !important;
            height: 20px !important;
        }
    </style>
<?php
$barId = $_GET['id'];
if (isset($_GET['id'])) {
    //$query = "select b.id, b.Business_Name, b.Owner_id, u.id as u_id , u.name, u.email from bars_list as b left join user_register as u on b.Owner_id = u.id where b.id = ".$barId;
    $query = "select b.id, b.Business_Name, b.Owner_id, b.is_requestedForClaim, b.PhoneNo, u.name, u.email from bars_list as b left join user_register as u on u.id=b.Owner_id where b.id = " . $barId;
    $exe = $db->myconn->query($query);
    $getDetails = $exe->fetch_assoc();

    if (isset($_POST['submit'])) {
        $name = $db->escapeString($_POST['name']);
        $email = $db->escapeString($_POST['email']);
        $number = $db->escapeString($_POST['number']);
        $isAcceptedTc = $_POST['checkbox'];
        $count = 0;

        // Loop $_FILES to exeicute all files

        if ($getDetails['is_requestedForClaim'] == 1) {
            if ($name != "") {

                $array = array(
                    'name' => $name

                );

                $db->update('user_register', $array, 'id=' . $getDetails["Owner_id"]);
            }
            if ($number != "") {
                $array = array(
                    'PhoneNo' => $number,
                    'is_requestedForClaim' => 1
                );

                $db->update('bars_list', $array, 'id="' . $getDetails["id"] . '" and Business_Name = "' . $getDetails["Business_Name"] . '"');
            } else {
                $form->setError("number", "Contact No can not be empty");
            }
            if (!$isAcceptedTc || $isAcceptedTc != 1) $form->setError("checkbox", "Please select checkbox to agree.");
            $to = 'info@mybarnite.com';

            $msg = "<html>";
            $msg .= "<head><title>Mybarnite</title></head>";
            $msg .= "<body>";
            $msg .= "Dear Admin,<br/><br/>";
            $msg .= "New business claim has been requested.<br/><br/>";
            $msg .= "Business id : " . $getDetails['id'] . "<br/>";
            $msg .= "Business Name : " . $getDetails['Business_Name'] . "<br/>";
            $msg .= "Owner Name : " . $name . "<br/>";
            $msg .= "Owner Email : " . $email . "<br/>";
            $msg .= "Owner Contact No : " . $number . "<br/>";
            $msg .= "<br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
            $msg .= "</body></html>";
            //$msg = " To activate your account, please click on this link:\n\n";
            //$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
            $subj = 'Notification : Business Claim';
            $from = $email;

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From: " . $email . "\r\n" . "";
            if (mail($to, $subj, $msg, $headers)) {

                $_SESSION['msg1'] = '<div class="alert alert-success">Business claim has been sent successfully to admin. You will get confirmation email after admin approval.</div>';
                echo "<script>window.location.href='business_owner_signup.php?msg1=success'</script>";
                //header("location:business_owner_signup.php?msg1='success'");

            } else {
                $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                //header("location:business_owner_signup.php?msg1='error'");
            }

        } else {

            if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] != null) {
                if (isset($_SESSION['bar_id']) && $_SESSION['bar_id'] != null && $_SESSION['bar_name'] == '') {
                    print_r('deleted');
                    $db->delete('bars_list', 'id=' . $_SESSION['bar_id']);  // Table name, WHERE conditions
                } else {
                    echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                }
            } else {
                if ($name != "") {
                    $db->select('user_register', '*', NULL, 'name="' . $name . '" and id!= ' . $getDetails['Owner_id'], 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                    $rows = $db->numRows();
                    if ($rows > 0) {
                        $form->setError("name", "User name already exists");
                    }
                }
                if (!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
                else {
                    $db->select('user_register', '*', NULL, 'email="' . $email . '" and id!= ' . $getDetails['Owner_id'], 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                    $rows = $db->numRows();
                    if ($rows > 0) {
                        $form->setError("email", "Email already exists");
                    }
                }
            }
            if ($number == "") {
                $form->setError("number", "Contact No can not be empty");
            }

            if (!$isAcceptedTc || $isAcceptedTc != 1) $form->setError("checkbox", "Please select checkbox to agree.");

            if ($form->num_errors == 1) {
                //$_SESSION['value_array'] = $_POST;
                //$_SESSION['error_array'] = $form->getErrorArray();
            } else {
                if ($getDetails['Owner_id'] == 0) {
                    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] != null) {
                        $lastInsertedId = intval($_SESSION['isLoggedIn']);
                    } else {
                        $db->insert('user_register', array('r_id' => '1', 'name' => $name, 'email' => $email, 'contact' => $number, 'status' => 'Inactive'));  // Table name, column names and respective values
                        $res4 = $db->getResult();
                        $lastInsertedId = $res4[0];
                    }

                    if ($lastInsertedId > 0) {
                        $array = array(
                            'Owner_id' => $lastInsertedId,
                            'PhoneNo' => $number,
                            'is_requestedForClaim' => 1
                        );

                        $db->update('bars_list', $array, 'id="' . $getDetails["id"] . '" and Business_Name = "' . $getDetails["Business_Name"] . '"'); // Table name, column names and values, WHERE conditions
                        $res5 = $db->getResult();
                        if ($res5 > 0) {

                            $to = 'info@mybarnite.com';

                            $msg = "<html>";
                            $msg .= "<head><title>Mybarnite</title></head>";
                            $msg .= "<body>";
                            $msg .= "Dear Admin,<br/><br/>";
                            $msg .= "New business claim has been requested.<br/><br/>";
                            $msg .= "Business id : " . $getDetails['id'] . "<br/>";
                            $msg .= "Business Name : " . $getDetails['Business_Name'] . "<br/>";
                            $msg .= "Owner Name : " . $name . "<br/>";
                            $msg .= "Owner Email : " . $email . "<br/>";
                            $msg .= "Owner Contact No : " . $number . "<br/>";
                            $msg .= "<br/>Thank you for using our website.<br/><br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
                            $msg .= "</body></html>";
                            //$msg = " To activate your account, please click on this link:\n\n";
                            //$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
                            $subj = 'Notification : Business Claim';
                            $from = $email;

                            $headers = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $headers .= "From: " . $email . "\r\n" . "";
                            if (mail($to, $subj, $msg, $headers)) {

                                $_SESSION['msg1'] = '<div class="alert alert-success">Business claim has been sent successfully to admin. You will get confirmation email after admin approval.</div>';
                                //header("location:business_owner_signup.php?msg1=success");
                                echo "<script>window.location.href='business_owner_signup.php?msg1=success'</script>";

                            } else {
                                $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                                echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                                //header("location:business_owner_signup.php?msg1=error");
                            }
                        } else {
                            $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                            echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                            //header("location:business_owner_signup.php?msg1=error");
                        }
                    } else {
                        $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                        echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                        //header("location:business_owner_signup.php?msg1=error");
                    }
                } else if ($getDetails['Owner_id'] != 0 && $getDetails['is_requestedForClaim'] == 0) {
                    $array = array(
                        'name' => $name,
                        'contact' => $number
                    );
                    $db->update('user_register', $array, 'id=' . $getDetails["Owner_id"]);

                    $array1 = array(
                        'PhoneNo' => $number,
                        'is_requestedForClaim' => 1
                    );

                    $db->update('bars_list', $array1, 'id="' . $getDetails["id"] . '" and Business_Name = "' . $getDetails["Business_Name"] . '"'); // Table name, column names and values, WHERE conditions
                    $res5 = $db->getResult();

                    if ($res5 > 0) {

                        $to = 'info@mybarnite.com';

                        $msg = "<html>";
                        $msg .= "<head><title>Mybarnite</title></head>";
                        $msg .= "<body>";
                        $msg .= "Dear Admin,<br/><br/>New business claim has been requested.<br/><br/>";
                        $msg .= "Business id : " . $getDetails['id'] . "<br/>";
                        $msg .= "Business Name : " . $getDetails['Business_Name'] . "<br/>";
                        $msg .= "Owner Name : " . $name . "<br/>";
                        $msg .= "Owner Email : " . $email . "<br/>";
                        $msg .= "Owner Contact No : " . $number . "<br/>";
                        $msg .= "<br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
                        $msg .= "</body></html>";
                        //$msg = " To activate your account, please click on this link:\n\n";
                        //$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
                        $subj = 'Notification : Business Claim';
                        $from = $email;

                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= "From: " . $email . "\r\n" . "";
                        if (mail($to, $subj, $msg, $headers)) {

                            $_SESSION['msg1'] = '<div class="alert alert-success">Business claim has been sent successfully to admin. You will get confirmation email after admin approval.</div>';
                            //header("location:business_owner_signup.php?msg1=success");
                            echo "<script>window.location.href='business_owner_signup.php?msg1=success'</script>";

                        } else {
                            $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                            echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                            //header("location:business_owner_signup.php?msg1=error");
                        }
                    } else {
                        $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                        echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                        //header("location:business_owner_signup.php?msg1=error");
                    }


                } else if ($getDetails['Owner_id'] != 0 && $getDetails['is_requestedForClaim'] == 3) {
                    $db->insert('user_register', array('r_id' => '1', 'name' => $name, 'email' => $email, 'contact' => $number, 'status' => 'Inactive'));  // Table name, column names and respective values
                    $res4 = $db->getResult();
                    /* echo "<pre>";
                    print_r($res4); */
                    if (!empty($res4)) {
                        $lastInsertedId = $res4[0];
                        $array = array(
                            'Owner_id' => $lastInsertedId,
                            'PhoneNo' => $number,
                            'is_requestedForClaim' => 1
                        );

                        $db->update('bars_list', $array, 'id="' . $getDetails["id"] . '" and Business_Name = "' . $getDetails["Business_Name"] . '"'); // Table name, column names and values, WHERE conditions
                        $res5 = $db->getResult();

                        if ($res5 > 0) {

                            $to = 'info@mybarnite.com';

                            $msg = "<html>";
                            $msg .= "<head><title>Mybarnite</title></head>";
                            $msg .= "<body>";
                            $msg .= "Dear Admin,<br/><br/>New business claim has been requested.<br/><br/>";
                            $msg .= "Business id : " . $getDetails['id'] . "<br/>";
                            $msg .= "Business Name : " . $getDetails['Business_Name'] . "<br/>";
                            $msg .= "Owner Name : " . $name . "<br/>";
                            $msg .= "Owner Email : " . $email . "<br/>";
                            $msg .= "Owner Contact No : " . $number . "<br/>";
                            $msg .= "<br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
                            $msg .= "</body></html>";
                            //$msg = " To activate your account, please click on this link:\n\n";
                            //$msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
                            $subj = 'Notification : Business Claim';
                            $from = $email;

                            $headers = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $headers .= "From: " . $email . "\r\n" . "";
                            if (mail($to, $subj, $msg, $headers)) {

                                $_SESSION['msg1'] = '<div class="alert alert-success">Business claim has been sent successfully to admin. You will get confirmation email after admin approval.</div>';
                                //header("location:business_owner_signup.php?msg1=success");
                                echo "<script>window.location.href='business_owner_signup.php?msg1=success'</script>";

                            } else {
                                $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                                echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                                //header("location:business_owner_signup.php?msg1=error");
                            }
                        } else {
                            $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                            echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                            //header("location:business_owner_signup.php?msg1=error");
                        }
                    } else {
                        $_SESSION['msg1'] = '<div class="alert alert-danger">There is some issue while sending business claim. Try after some time.</div>';
                        echo "<script>window.location.href='business_owner_signup.php?msg1=error'</script>";
                        //header("location:business_owner_signup.php?msg1=error");
                    }
                }

            }
        }


    }

}

if (isset($_POST['register'])) {
    global $form;
    /* echo "<pre>";
    print_r($_POST); exit;
     */
    $name = $db->escapeString($_POST['name']);
    $email = $db->escapeString($_POST['email']);
    $password = $db->escapeString($_POST['password']);
    $isAcceptedTc = $_POST['checkbox'];
    //$number = $db->escapeString($_POST['number']);

    if (!$name || strlen($name = trim($name)) == 0) $form->setError("name", "Owner name can not be empty.");

    if (!$email || strlen($email = trim($email)) == 0) $form->setError("email", "Email can not be empty.");
    else {
        $db->select('user_register', 'r_id,email', NULL, 'email="' . $email . '"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
        $rows = $db->numRows();
        if ($rows > 0) {
            $form->setError("email", "Email already exists");
        }
    }

    if ($password) {
        if (strlen($password = trim($password)) < 7) $form->setError("password", "Minimum 7 characters required.");
    } else $form->setError("password", "Password not entered");
    if (!$isAcceptedTc || $isAcceptedTc != 1) $form->setError("checkbox", "Please select checkbox to agree.");

    if ($form->num_errors == 1) {
        //$_SESSION['value_array'] = $_POST;
        //$_SESSION['error_array'] = $form->getErrorArray();
    } else {
        //$_SESSION['message'] = "No errors in the form, good to go!";

        $activation = md5(uniqid(rand(), true));

        $db->insert('user_register', array('r_id' => '1', 'name' => $name, 'email' => $email, 'password' => $password, 'status' => 'Inactive', 'activation_key' => $activation));  // Table name, column names and respective values
        $res = $db->getResult();

        if (!empty($res)) {

            $lastInsertedId = $res[0];

            $db->insert('bars_list', array('Owner_id' => $lastInsertedId, 'Owner_Name' => $name));  // Table name, column names and respective values
            $res1 = $db->getResult();
            $encodedid = urlencode($lastInsertedId);
            /* $msg = "<html><body>";
            $msg .= "Dear Customer<br/><br/>Thank you for joining our website.<br/><br/>To activate your account, please click on this link:\n\n";
            $msg .= SITE_PATH . 'business_owner/activate.php?id=' . urlencode($lastInsertedId) . "&key=$activation";
            $msg .= "<br/><br/>Thank you for using our website<br/><br/>Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='50%'>";
            $msg .= "</body></html>";

            $subj = 'Account Activation';
            $to = $email;
            $from = 'info@mybarnite.com';
            $appname = 'Mybarnite';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From: info@mybarnite.com" . "\r\n" .""; */
            $to1 = $email;
            //$to1 = 'vidhi.scrumbees@gmail.com';
            $subject1 = 'Mybarnite - Account Activation';
            $from1 = 'info@mybarnite.com';

            // To send HTML mail, the Content-type header must be set
            $headers1 = 'MIME-Version: 1.0' . "\r\n";
            $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers1 .= 'From: ' . $from1 . "\r\n" .
                'Reply-To: ' . $from1 . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Compose a simple HTML email message
            $message1 = "<html>";
            $message1 .= "<head><title>Mybarnite</title></head>";
            $message1 .= "<body>";
            $message1 .= "Dear Customer,<br/><br/>";
            $message1 .= "To activate your account please click on below link,<br/>";
            $message1 .= "<a href='http://mybarnite.com/business_owner/activate.php?id=$encodedid&key=$activation'>Activate Account</a><br/><br/>";
            $message1 .= "Thank you for joining our website.<br/>";
            $message1 .= "<p>Mybarnite Limited</p><p>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a></p><p>URL: <a href='http://mybarnite.com'>mybarnite.com</a></p><p><img src='http://mybarnite.com/images/Picture1.png' width='110'></p>";
            $message1 .= "</body></html>";


            if (mail($to1, $subject1, $message1, $headers1)) {

                $_SESSION['msg'] = '<div class="alert alert-success">Thank you for registering! Activation email has been sent to your email address, Please click on the Activation Link to Activate your account. </div>';

            } else {

                $_SESSION['msg'] = 'There is some issue while sending email. Please contact to administrator';

            }


            header("location:business_owner_signin.php");
        } else {
            $_SESSION['msg'] = "";
            header("location:business_owner_signup.php");
        }
    }


}
?>


    <!--==============================Map=================================-->


    </header>
    <div class="padcontent"></div>

    <!--==============================Content=================================-->
    <section id="content" class="main-content">
        <div class="container">
            <div class="row">
                <div class="clearfix ">
                    <div class="span3"></div>
                    <div class="span6">
                        <center>
                            <h2>Business owner sign up</h2>
                        </center>
                    </div>
                    <div class="span3">
                        <?php
                        if ($_GET['id'] == "") {
                            ?>
                            <a href="claim_business.php" class="btn submit btn-primary bg-pink">FIND YOUR BUSINESS</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row clearfix ">
                <div class="span3"></div>
                <div class="span6">

                    <div id="fields" class="contact-form signin-form">

                        <form id="ajax-contact-form" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            <?php
                            if ($_GET['msg1'] == 'success') {
                                ?>
                                <div class="control-group">
                                    <div class="alert alert-success">Business claim has been sent successfully to admin.
                                        You will get confirmation email after admin approval.
                                    </div>
                                </div>
                                <?php
                            }

                            if ($_GET['msg1'] == 'error') {
                                ?>
                                <div class="control-group">
                                    <div class="alert alert-danger">There is some issue while sending business claim or
                                        you have already claimed your business.
                                        Please try after some time.
                                    </div>
                                </div>
                                <?php
                            }
                            if ($_GET['id'] != "") { ?>
                                <div class="control-group">
                                    <label class="control-label" for="inputName">BUSINESS NAME:</label>
                                    <input type="text" required name="business_name" class="form-control"
                                           value="<?php echo $getDetails['Business_Name']; ?>" readonly>
                                </div>
                                <br>
                                <?php
                                #echo $getDetails['is_requestedForClaim'];
                                if ($getDetails['is_requestedForClaim'] == 1 || (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] != null)) {
                                    @$readonly = 'readonly="readonly"';
                                } else if ($getDetails['is_requestedForClaim'] == 3) {
                                    $getDetails['name'] = "";
                                    $getDetails['email'] = "";
                                }
                                ?>
                                <div class="control-group">
                                    <label class="control-label" for="inputName">OWNER NAME:</label>
                                    <input type="text" required name="name" class="form-control"
                                           value="<?php echo $_SESSION['business_owner_name']; ?>" <?php echo $readonly; ?>
                                           placeholder="Owner Name...">
                                    <span style="float: left;"><?php echo $form->error("name"); ?></span>
                                </div>
                                <br>

                                <div class="control-group">
                                    <label class="control-label" for="inputName">EMAIL:</label>
                                    <input type="email" required name="email" class="form-control"
                                           value="<?php echo $_SESSION['business_owner_email']; ?>"
                                           placeholder="Email..." <?php echo $readonly; ?>>
                                    <span style="float: left;"><?php echo $form->error("email"); ?></span>
                                </div>
                                <br>
                                <?php
                            } else {
                                ?>
                                <div class="control-group">
                                    <label class="control-label" for="inputName">OWNER NAME:</label>
                                    <input type="text" required name="name" class="form-control" value=""
                                           placeholder="Owner Name...">
                                    <span style="float: left;"><?php echo $form->error("name"); ?></span>
                                </div>
                                <br>

                                <div class="control-group">
                                    <label class="control-label" for="inputName">EMAIL:</label>
                                    <input type="email" required name="email" class="form-control" value=""
                                           placeholder="Email...">
                                    <span style="float: left;"><?php echo $form->error("email"); ?></span>
                                </div>
                                <br>
                                <?php
                            }
                            if (!isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == null) {
                                ?>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">PASSWORD:</label>
                                    <input type="password" id="password" required
                                           pattern="^(?=[^\d_].*?\d)\w(\w|[!@#$%]){6,}"
                                           title="Alphanumeric, specialchars and min 7 Chars" name="password"
                                           placeholder="Password...">
                                    <span><?php echo $form->error("password"); ?></span>
                                </div>
                                <br>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">CONFIRM PASSWORD:</label>
                                    <input type="password" placeholder="Confirm Password" id="confirm_password"
                                           required>
                                </div>
                                <br>
                            <?php } ?>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="inputEmail">CONTACT NO.:</label>
                                <input type="number" required name="number" class="form-control"
                                       value="<?php echo $getDetails['PhoneNo']; ?>" placeholder="Contact No...">
                                <span style="float: left;"><?php echo $form->error("number"); ?></span>
                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="inputEmail" class="check_box">&nbsp;</label>
                                <input type="checkbox" name="checkbox" value="1" required class="signup-chk">I have read
                                and agree to the <a href="<?php echo SITE_PATH; ?>/terms.php"
                                                    style="color:#3179d8;text-decoration:underline;" target="_blank">Terms
                                    of conditions</a> and <a href="<?php echo SITE_PATH; ?>/policy.php"
                                                             style="color:#3179d8;text-decoration:underline;"
                                                             target="_blank">Privacy policy</a>
                                <span><?php echo $form->error("checkbox"); ?></span>
                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <?php if ($_GET['id'] != "") { ?>
                                    <input type="submit" name="submit" class="btn submit btn-primary " value="SUBMIT">
                                <?php } else { ?>
                                    <input type="submit" name="register" class="btn submit btn-primary "
                                           value="SIGN UP">
                                <?php } ?>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php include 'template-parts/footer.php'; ?>
<?php if ($_GET['id'] == "") { ?>
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
<?php } ?>