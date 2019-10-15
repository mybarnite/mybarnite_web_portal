<?php
include('template-parts/header.php');
require_once('../config.php');
?>
    <script type="text/javascript" src="js/custom.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
    </header>

    <div class="padcontent"></div>

    <!--==============================Content=================================-->
    <section id="content" class="main-content">
        <div class="container">
            <?php
            if (isset($_SESSION['business_owner_id'])) { ?>
                <!--==============================Billing Transaction History=================================-->
                <div class="row clearfix ">
                    <div class="span12">
                        <center><h2>Billing Transactions</h2></center>
                    </div>
                </div>
                <?php if (isset($_SESSION['bar_id'])) {
                    $db->select('bar_billing_transactions', '*', null, 'bar_id =' . $_SESSION['bar_id'], 'bar_billing_id DESC');
                    $BillingTransactions = $db->getResult();
                    $countTransactions = count($BillingTransactions);
                    if ($countTransactions > 0) { ?>
                        <div class="row clearfix ">
                            <div class="span12 table-responsive">
                                <table class="table" id="order_history" style="border-bottom:2px #2e2e37 solid;">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Bill Cycle Start</th>
                                        <th>Bill Cycle End</th>
                                        <th>Bill Amount (&#163;)</th>
                                        <th>Paid Amount (&#163;)</th>
                                        <th>Transaction Id</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($BillingTransactions as $billingTransaction) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo ($billingTransaction['bill_start_date'] != "0000-00-00") ? date('m/d/Y', strtotime($billingTransaction['bill_start_date'])) : "-"; ?></td>
                                            <td><?php echo ($billingTransaction['bill_end_date'] != "0000-00-00") ? date('m/d/Y', strtotime($billingTransaction['bill_end_date'])) : "-"; ?></td>
                                            <td><?php echo number_format($billingTransaction['bill_amount'], 2); ?></td>
                                            <td><?php echo number_format($billingTransaction['paid_amount'], 2); ?></td>
                                            <td><?php echo $billingTransaction['stripe_transaction_id']; ?></td>
                                            <td>
                                                <a href="billed_orders_history.php?id=<?php echo $billingTransaction['bar_billing_id']; ?>"
                                                   class="btn btn-danger">View Orders</a></td>
                                        </tr>
                                        <?php

                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="row ">
                            <div class="clearfix ">
                                <div class="span12">
                                    <h5>There are no transactions made yet..!</a></h5>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else { ?>
                    <div class="row text-center">
                        <div class="span12">
                            <h5 class="alert alert-danger h5-notregisteredbar">You can not able to access this page
                                because your Bar / Business has not been registered yet.<br/> Please <a
                                        href="business_owner_edit_profile.php"> register your Business </a> here.</h5>
                        </div>
                    </div>
                <?php }
            } else {
                ?>
                <div class="row ">
                    <div class="clearfix ">
                        <div class="span12">
                            <h5>You are not Logged in yet. Please <a href="business_owner_signin.php">login </a></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php include 'template-parts/footer.php'; ?>