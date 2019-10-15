<?php
include('template-parts/header.php');
if (isset($_POST['AddAccount'])) {
    $role = '1';
    $user_id = $_SESSION['business_owner_id'];
    $customer_id = $db->escapeString($_POST['customer_id']);
    $account_name = $db->escapeString($_POST['account_name']);
    $short_code = $db->escapeString($_POST['short_code']);
    $account_number = $db->escapeString($_POST['account_number']);

    $db->insert('tbl_accounts', array('role' => $role, 'user_id' => $user_id, 'customer_id' => $customer_id, 'account_name' => $account_name, 'short_code' => $short_code, 'account_number' => $account_number));  // Table name, column names and respective values
    $res = $db->getResult();
    $lastInsertedId = $res[0];
    if ($lastInsertedId != "") {
        $_SESSION['msg'] = "<div class='alert alert-success'>Data inserted successfully.</div>";
    }
}
?>
<script type="text/javascript" src="js/custom.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</header>

<div class="padcontent"></div>

<!--==============================Content=================================-->
<section id="content" class="main-content">
    <div class="container">
        <?php
        if (isset($_SESSION['business_owner_id'])) {
            ?>
            <!--==============================Accounts=================================-->

            <?php
            $db->select('tbl_accounts', '*', NULL, 'user_id=' . $_SESSION['business_owner_id'] . ' and role="1"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
            $accounts = $db->getResult();
            $countAccounts = count($accounts);
            if ($countAccounts > 0) {
                ?>
                <div class="row">
                    <?php
                    $db->select('tbl_order_history', 'SUM(total_amount) as totalRefund', NULL, 'Owner_id="' . $_SESSION['business_owner_id'] . '" and payment_status="Refund Requested"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                    $totalRefund = $db->getResult();
                    $refundAmount = $totalRefund[0]['totalRefund'];
                    ?>
                    <div class="span3">

                    </div>
                    <div class="span6">
                        <center><h2>Accounts</h2></center>
                    </div>
                    <div class="span3">
                        <a href="business_owner_addAccount.php" class="btn btn-info pull-right"><i class="fa fa-plus"
                                                                                                   aria-hidden="true"></i>
                            Add account</a>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">&nbsp;</div>
                    <div class="span6">
                        <center>
                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);

                            }
                            ?>
                        </center>
                    </div>
                    <div class="span3">&nbsp;</div>
                </div>
                <?php
                if ($countAccounts == 1) {
                    $db->select('tbl_order_history', 'SUM(total_amount) as totalRefund', NULL, 'Owner_id="' . $_SESSION['business_owner_id'] . '" and payment_status="Refund Requested"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                    $totalRefund = $db->getResult();
                    $refundAmount = $totalRefund[0]['totalRefund'];
                    ?>
                    <div class="row clearfix">
                        <h5 style="margin-left: 32px;margin-bottom: 0;">Transaction Details</h5>
                        <div class="span6">
                            <div class="panel-group" id="subscription_contents">
                                <div class="panel panel-default">
                                    <div class="panel-body p-l-30">
                                        <h4 style="margin:0;"><strong
                                                    style="text-transform:none;font-size:16px;padding-bottom:20px;padding-top:20px">Requested
                                                refund (&pound;)
                                                : <?php echo number_format($refundAmount, 2); ?></strong></h4>
                                        <?php
                                        $db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'], 'id DESC');
                                        $getBar = $db->getResult();
                                        $db->select('tbl_order_history', 'SUM(total_amount) as totalPurchase', NULL, 'Owner_id="' . $_SESSION['business_owner_id'] . '" and payment_status="Done"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                                        $totalPurchase = $db->getResult();
                                        if ($getBar[0]['is_payasyougo'] == "1") {
                                            $commission = ($totalPurchase[0]['totalPurchase'] * $getBar[0]['Commission']) / 100;
                                            $amountToRetriev = $totalPurchase[0]['totalPurchase'] - $commission;
                                        }
                                        if ($getBar[0]['is_payasyougo'] == "2") {
                                            $commission = ($totalPurchase[0]['totalPurchase'] * $getBar[0]['Discount']) / 100;
                                            $amountToRetriev = $totalPurchase[0]['totalPurchase'] - $commission;
                                        }

                                        ?>
                                        <?php if ($getBar[0]['is_payasyougo'] == "1") { ?>
                                            <h4 style="margin;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Commission
                                                    per
                                                    transaction: <?php echo $getBar[0]['Commission'] . "%"; ?></strong>
                                            </h4>
                                        <?php } ?>
                                        <?php if ($getBar[0]['is_payasyougo'] == "2") { ?>
                                            <h4 style="margin:0;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Discount
                                                    per
                                                    transaction: <?php echo $getBar[0]['Discount'] . "%"; ?></strong>
                                            </h4>
                                        <?php } ?>
                                        <?php if ($getBar[0]['is_payasyougo'] == "0" || $getBar[0]['is_payasyougo'] == "" || $getBar[0]['is_payasyougo'] == null) {
                                            $db->select('tbl_settings', '*', null, 'id =1', 'id DESC');
                                            $getSettings = $db->getResult();
                                            ?>
                                            <h4 style="margin:0;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Discount
                                                    (%): <?php echo $getSettings[0]['discount']; ?></strong></h4>
                                            <h4 style="margin:0;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Commission
                                                    (%): <?php echo $getSettings[0]['commision']; ?></strong></h4>
                                        <?php } ?>
                                        <h4 style="margin:0;"><strong
                                                    style="text-transform:none;font-size:16px;padding-bottom:20px;">Amount
                                                to be recieved (&pound;)
                                                : <?php echo number_format($amountToRetriev, 2); ?></strong></h4>
                                        <?php if ($getBar[0]['is_payasyougo'] == "1") { ?>
                                            <h4 style="margin:0;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Commission
                                                    amount
                                                    (&pound;): <?php echo number_format($commission, 2); ?></strong>
                                            </h4>
                                        <?php } ?>
                                        <?php if ($getBar[0]['is_payasyougo'] == "2") { ?>
                                            <h4 style="margin:0;"><strong
                                                        style="text-transform:none;font-size:16px;padding-bottom:20px;">Discount
                                                    amount
                                                    (&pound;): <?php echo number_format($commission, 2); ?></strong>
                                            </h4>
                                        <?php } ?>
                                        <?php
                                        $db->select('tbl_order_history', 'SUM(total_amount) as totalRefund', NULL, 'Owner_id="' . $_SESSION['business_owner_id'] . '" and payment_status="Refunded"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                                        $totalRefund = $db->getResult();
                                        $refundAmount = $totalRefund[0]['totalRefund'];
                                        ?>

                                        <h4 style="margin:0;"><strong
                                                    style="text-transform:none;font-size:16px;padding-bottom:20px;">Total
                                                refund amount (&pound;)
                                                : <?php echo number_format($refundAmount, 2); ?></strong></h4>
                                        <?php
                                        $sql1 = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where payment_status = 'Done' and owner_id =" . $_SESSION['business_owner_id'];
                                        $getTotalOrdersPaid = $db->myconn->query($sql1);
                                        $num_orders = $getTotalOrdersPaid->num_rows;
                                        ?>
                                        <h4 style="margin:0;"><strong
                                                    style="text-transform:none;font-size:16px;padding-bottom:20px;">Total
                                                order placed : <?php echo $num_orders; ?></strong></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <?php
                            foreach ($accounts as $account) {
                                ?>
                                <div class="panel-group" id="subscription_contents">
                                    <div class="panel panel-default">
                                        <center>
                                            <div class="panel-body">
                                                <span>Customer Id : <?php echo $account['customer_id']; ?></span>
                                                <br/><br/>
                                                <span>Account name : <?php echo $account['account_name']; ?></span>
                                                <br/><br/>
                                                <span>Account number : <?php echo $account['account_number']; ?></span>
                                                <br/><br/>
                                                <span>Sort code : <?php echo $account['short_code']; ?></span>
                                                <br/><br/>
                                                <span style="font-size: 20px;"
                                                      class="pink"><?php echo ($account['status'] == "Active") ? $account['status'] . " : Use above card details." : $account['status']; ?></span>
                                                <br/><br/>
                                            </div>
                                            <div class="panel-footer">
                                                <?php if ($account['status'] == "Active") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);"
                                                                disabled="disabled" style="opacity:0.5 !important">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php }
                                                if ($account['status'] == "Inactive") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);"
                                                                disabled="disabled" style="opacity:0.5 !important">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php }
                                                if ($account['status'] == "") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>
                                                <div class="row">
                                                    <a href="business_owner_addAccount.php?id=<?php echo $account['id']; ?>"><i
                                                                class="fa fa-pencil fa-2x pink" aria-hidden="true"></i></a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:void(0);"
                                                       onclick="deleteAccount(<?php echo $account['id']; ?>,1)"><i
                                                                class="fa fa-trash-o fa-2x pink" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="span4">&nbsp;</div>
                    </div>
                <?php } else { ?>
                    <div class="row clearfix ">
                        <?php foreach ($accounts as $account) { ?>
                            <div class="span4">

                                <div class="panel-group" id="subscription_contents">
                                    <div class="panel panel-default">

                                        <center>
                                            <div class="panel-body">

                                                <span>Customer Id : <?php echo $account['customer_id']; ?></span>
                                                <br/><br/>
                                                <span>Account name : <?php echo $account['account_name']; ?></span>
                                                <br/><br/>
                                                <span>Account number : <?php echo $account['account_number']; ?></span>
                                                <br/><br/>
                                                <span>Sort code : <?php echo $account['short_code']; ?></span>
                                                <br/><br/>
                                                <span style="font-size: 20px;"
                                                      class="pink"><?php echo ($account['status'] == "Active") ? $account['status'] . " : Use above card details." : $account['status']; ?></span>
                                                <br/><br/>
                                            </div>
                                            <div class="panel-footer">
                                                <?php if ($account['status'] == "Active") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);"
                                                                disabled="disabled" style="opacity:0.5 !important">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>

                                                <?php if ($account['status'] == "Inactive") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);"
                                                                disabled="disabled" style="opacity:0.5 !important">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>

                                                <?php if ($account['status'] == "") { ?>
                                                    <div class="row">
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,1,1);">
                                                            Active
                                                        </button>
                                                        <button type="button" class="btn btn-info"
                                                                onclick="changeAccountStatus(<?php echo $account['id']; ?>,0,1);">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>

                                                <div class="row">
                                                    <a href="business_owner_addAccount.php?id=<?php echo $account['id']; ?>"><i
                                                                class="fa fa-pencil fa-2x pink" aria-hidden="true"></i></a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:void(0);"
                                                       onclick="deleteAccount(<?php echo $account['id']; ?>,1)"><i
                                                                class="fa fa-trash-o fa-2x pink" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                    <br/>
                    <?php
                }
            } else {
                ?>
                <div class="row clearfix ">
                    <div class="span3"></div>
                    <div class="span6">
                        <div id="fields" class="contact-form signin-form">
                            <form id="ajax-contact-form" method="post" class="form-horizontal">
                                <div class="control-group">
                                    <?php

                                    if (isset($_SESSION['msg'])) {
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);

                                    }
                                    ?>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputName">Customer ID:</label>
                                    <input type="text" required name="customer_id" class="form-control" value=""
                                           placeholder="Customer ID...">
                                    <span><?php echo $form->error("customerid"); ?></span>
                                </div>
                                <br>

                                <div class="control-group">

                                    <label class="control-label" for="inputName">Account name:</label>
                                    <input type="text" required name="account_name" class="form-control" value=""
                                           placeholder="Account name...">
                                    <span><?php echo $form->error("email"); ?></span>
                                </div>
                                <br>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Sort code:</label>
                                    <input type="text" name="short_code" value="" placeholder="Sort code...">

                                </div>
                                <br>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Account number:</label>
                                    <input type="text" name="account_number" value="" placeholder="Account number...">

                                </div>
                                <br>

                                <div class="control-group">
                                    <input type="submit" name="AddAccount" class="btn submit btn-primary"
                                           value="Add account">
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
            }

        } else {
            ?>
            <div class="row ">
                <div class="clearfix ">
                    <div class="span12">
                        <h5>You are not Logged in yet. Please <a href="business_owner_signin.php">login </a></h5>
                    </div>
                </div>
            </div>
            <?php

        }
        ?>
    </div>
</section>
<?php include 'template-parts/footer.php'; ?>

