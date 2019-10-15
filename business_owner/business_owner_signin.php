<?php
// require_once('../config.php');
// $api_key = 'sk_test_cNbu9LrIJIbVH54LwF3Sav2300VIsKzyCN';
// $curl = curl_init();
// curl_setopt_array($curl, [
//   CURLOPT_URL => 'https://connect.stripe.com/oauth/deauthorize',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_HTTPHEADER => ["Authorization: Bearer $api_key"],
//   CURLOPT_POST => true,
//   CURLOPT_POSTFIELDS => http_build_query([
//     'client_id' => 'ca_F15O3cb0X1lxejvcPfqFkQeNuqAc2VdP',
//     'stripe_user_id' => 'acct_1FIWukHi6VAqMwwH',
//   ])
// ]);
// curl_exec($curl);
// print_r($curl); exit;

include('template-parts/header-start.php');

?>
    <title>Mybarnite - Business owner signIn</title>
    <meta name="keywords" content="Mybarnite Business owner signIn">
    <meta name="description" content="Mybarnite businessowner signIn">

<?php
include('template-parts/header-end.php');

if(isset($_GET)){
    if($_GET['code'] != null){
        require_once('../config.php');
        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => 'https://connect.stripe.com/oauth/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => http_build_query([
            'client_secret' => $stripe['secret_key'],
            'code' => $_GET['code'],
            'grant_type' =>'authorization_code',
          ])
        ]);
        $result = curl_exec($curl);
        $stripe_array = json_decode($result);
        
        if($stripe_array->stripe_user_id != null){
            $_SESSION['stripe_account_id'] = $stripe_array->stripe_user_id;
            $_SESSION['msg'] = '<div class="alert alert-success">Login with to which you want to link your stripe account.</div>';
        } else {
            $_SESSION['msg'] = '<div class="alert alert-danger">'.$stripe_array->error_description.'</div>';
        }
    } else if($_GET['error']) {
        $_SESSION['msg'] = '<div class="alert alert-danger">Sorry, your stripe account is not linked. Please contact our support team for further details.</div>';
    }
}

if (isset($_SESSION['business_owner_id']) && $_SESSION['business_owner_id'] != '') {
    if(isset($_SESSION['stripe_account_id']) && $_SESSION['stripe_account_id'] != ''){
    	$db->select('tbl_accounts', '*', NULL, 'user_id=' . $_SESSION["user_id"]); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
        $result = $db->getResult();
        $rows = $db->numRows();
        if($rows > 0){
            $array = array(
    		    'stripe_account_id'=>$_SESSION['stripe_account_id']
        	);
            $db->update('tbl_accounts',$array, 'user_id = '.$_SESSION["user_id"]);
            $affectedRows = $db->myconn->affected_rows;	
        	if($affectedRows>0){
                $_SESSION['stripe_account_id'] = '';
            }
        } else {
            $db->insert('tbl_accounts',array('role'=>$_SESSION['role_id'],'user_id'=>$_SESSION["user_id"],'customer_id'=>$_SESSION["business_owner_id"],'account_name'=>$_SESSION["business_owner_name"],'stripe_account_id'=>$_SESSION['stripe_account_id'],'status'=>'Active'));  // Table name, column names and respective values
        	$res = $db->getResult();  
        	$lastInsertedId = $res[0];
        	if($lastInsertedId!="") {
        	     $_SESSION['stripe_account_id'] = '';
        	}
        }
    }
    header("location:dashboard.php");
    exit;
}


if (isset($_POST['login'])) {
    global $BarId;
    $useremail = $db->escapeString($_POST['useremail']);
    $userpassword = $db->escapeString($_POST['userpassword']);

    $_SESSION['msg'] = "";

    $db->select('user_register', '*', NULL, 'email="' . $useremail . '" and password="' . $userpassword . '" and status ="Active" and (activation_key="" OR activation_key=null)', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
    $result = $db->getResult();
    $rows = $db->numRows();

    $r_id = $result[0]['r_id'];

    if ($rows > 0) {
        if(isset($_SESSION['stripe_account_id']) && $_SESSION['stripe_account_id'] != ''){
        	$db->select('tbl_accounts', '*', NULL, 'user_id=' . $result[0]['id']); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
            $acount_count = $db->numRows();
            if($acount_count > 0){
                $array = array(
        		    'stripe_account_id'=>$_SESSION['stripe_account_id']
            	);
                $db->update('tbl_accounts',$array, 'user_id = '.$result[0]['id']);
                $affectedRows = $db->myconn->affected_rows;	
            	if($affectedRows>0){
                    $_SESSION['stripe_account_id'] = '';
                }
            } else {
                $db->insert('tbl_accounts',array('role'=>$r_id,'user_id'=>$result[0]['id'],'customer_id'=>$result[0]['id'],'account_name'=>$result[0]['name'],'stripe_account_id'=>$_SESSION['stripe_account_id'],'status'=>'Active'));  // Table name, column names and respective values
            	$res = $db->getResult();  
            	$lastInsertedId = $res[0];
            	if($lastInsertedId!="") {
            	     $_SESSION['stripe_account_id'] = '';
            	}
            }
        }
        if ($r_id == '1') {
            $db->select('bars_list', 'id,Business_Name,Commission', NULL, 'Owner_id="' . $result[0]['id'] . '"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
            $bars = $db->getResult();

            $_SESSION['bar_id'] = $bars[0]['id'];
            $_SESSION['bar_name'] = $bars[0]['Business_Name'];
            $_SESSION['business_owner_id'] = $result[0]['id'];
            $_SESSION['business_owner_name'] = $result[0]['name'];
            $_SESSION['business_owner_email'] = $result[0]['email'];
            $_SESSION['commission'] = $bars[0]['Commission'];
            $_SESSION['role_id'] = $r_id;
            $_SESSION['user_id'] = $result[0]['id'];
            $BarId = $bars[0]['id'];

            ?>
            <script>window.location.href = 'dashboard.php'; </script>
            <?php
        } else if ($r_id == '3') {
            $BarId = $result[0]['bar_id'];
            $sql = "SELECT b.Business_Name,b.id as business_id, b.Commission as Commission, u.id as business_owner_id, u.name as business_owner_name, u.email as business_owner_email  FROM user_register AS u JOIN  bars_list AS b on b.Owner_id = u.id where b.id = " . $BarId;
            $exe = $db->myconn->query($sql);
            $bardetail = $exe->fetch_assoc();
            
            $_SESSION['bar_id'] = $bardetail['business_id'];
            $_SESSION['bar_name'] = $bardetail['Business_Name'];
            $_SESSION['business_owner_id'] = $bardetail['business_owner_id'];
            $_SESSION['business_owner_name'] = $bardetail['business_owner_name'];
            $_SESSION['business_owner_email'] = $bardetail['business_owner_email'];
            $_SESSION['commission'] = $bardetail['Commission'];
            $_SESSION['role_id'] = $r_id;
            $_SESSION['subUserId'] = $result[0]['id'];
            $_SESSION['subUserRoleId'] = '3';
            $_SESSION['subUserName'] = $result[0]['name'];
            $_SESSION['subUserEmail'] = $result[0]['email'];
            $_SESSION['user_id'] = $result[0]['id'];

            ?>
            <script>window.location.href = 'subuser_dashboard.php'; </script>
            <?php
        }

    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger">Enter valid email and password !</div>';
    }
}

if (isset($_POST['forgot_password'])) {
    header("location:forgot_password.php");
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
                        <h2>Business Owner Log In</h2>

                    </div>
                    <div class="span3">

                        <a href="claim_business.php" class="btn submit btn-primary bg-pink">FIND YOUR BUSINESS</a>

                    </div>
                </div>
            </div>
            <div class="row clearfix ">
                <div class="span3"></div>
                <div class="span6">
                    <div id="fields" class="contact-form signin-form">
                        <form id="ajax-contact-form" class="form-horizontal" method="post">
                            <div class="control-group">
                                <?php

                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }

                                ?>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="useremail">EMAIL:</label>
                                <input type="email" required name="useremail" class="form-control"
                                       placeholder="Email..">
                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="userpassword">PASSWORD:</label>
                                <input type="password" required name="userpassword" class="form-control"
                                       placeholder="Password..">

                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <input name="login" type="submit" class="form-control btn submit btn-primary pull-right"
                                       value="Login">

                            </div>
                            <div class="clearfix"></div>
                        </form>

                        <form class="form-horizontal" method="post">
                            <label class="control-label"></label>
                            <input id="forgot_password" name="forgot_password" type="submit"
                                   class="form-control btn submit btn-primary  pull-left" value="Forgot Password">
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>


<?php include 'template-parts/footer.php'; ?>