<?php
include('template-parts/header.php');
require "../barclaycard/BarclaycardEpdq.class.php";
$barclaycardEpdq = new BarclaycardEpdq();
require_once('../config.php');
if (isset($_POST['instId'])) {

    $token = $_POST['stripeToken'];
    $email = $_POST['stripeEmail'];
    $cartId = $_POST['cartId'];

    $customer = \Stripe\Customer::create([
        'email' => $email,
        'source' => $token,
    ]);

    $charge = \Stripe\Charge::create([
        'customer' => $customer->id,
        'amount' => $_POST['amount'],
        'currency' => 'gbp',
        'metadata' => $_POST
    ]);

    $ownerid = $_POST['ownerid'];
    $subscriptionid = $_POST['subscriptionid'];
    $transactionid = $customer->default_source;
    $amount = ($_POST['amount'] / 100);
    #$_POST['duration'] = 12;
    $months = "+" . $_POST['MC_duration'];
    $duration = "$months months";
    $barid = $_POST['barid'];
    $emailid = $_POST['MC_emailid'];
    $username = $_POST['MC_CN'];
    $refdate = $_POST['MC_refdate'];
    $currentdt = ($refdate) ? date('Y-m-d', $_POST['MC_refdate']) : date('Y-m-d', time());
    $MonthsLater = ($refdate) ? strtotime($duration, $refdate) : strtotime($duration, time());
    $enddt = date('Y-m-d', $MonthsLater);
    $refdatenew = $enddt;

    $array = array(
        'dueamount' => 0,
        'start_date' => $currentdt,
        'end_date' => $enddt,
        'ref_date' => $refdatenew,
        'payment_status' => 'Done',
        'transaction_id' => $transactionid,
        'skrill_transaction' => $_REQUEST['transaction_id'],
        'is_active' => 'Active'

    );

    $db->update('tbl_businessowner_subscription', $array, 'id=' . $subscriptionid);
    $res = $db->getResult();
    $lastInsertedId = $res[0];

    if ($lastInsertedId != "") {

        $array = array(
            'is_payasyougo' => "2"
        );

        $db->update('bars_list', $array, 'id=' . $barid);

        $db->select('user_register', 'email,name', NULL, 'id=' . $ownerid, 'id DESC');
        $res = $db->getResult();

        $to = $emailid;
        $name = $username;
        //kubavatdharmesh@gmail.com
        // subject
        $subject = 'Mybarnite - Subscription';

        // message
        $message = "
		<html>
		<head>
		  <title>Mybarnite</title>

		</head>
		<body>
			Dear $name,
			<br/><br/>
			Thank you for your recent purchase from Mybarnite.com.<br/>
			Please find enclosed the proof of purchase and the receipt attached. Should you have any further query, please contact our customer support team<br/><br/>
		  <table cellspacing='0'>
			<tr>
			  <th>Name :</th>
			  <td>$name</td>
			</tr>
			<tr>
			  <th>Email :</th>
			  <td>$to</td>
			</tr>
			<tr>
			  <th>Duration :</th>
			  <td>From : $currentdt to $enddt </td>
			</tr>
			<tr>
			  <th>Amount :</th>
			  <td>$amount</td>
			</tr>
			<tr>
			  <th>Payment :</th>
			  <td>Done</td>
			</tr>
			<tr>
			  <th>Transaction id :</th>
			  <td>$transactionid</td>
			</tr>
		  </table>
		<br/><br/>
		Thanks again you for using our website
		<br/><br/>
		Mybarnite Limited<br/>
		EMail: info@mybarnite.com<br/>
		URL: newbarnite.mybarnite.com<br/><br/>
		<img src='http://newbarnite.mybarnite.com/images/Picture1.png' width='50%'>
		<br/>

		</body>
		</html>
		";

        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: ' . $to . "\r\n";
        $headers .= 'From: Mybarnite <info@mybarnite.com>' . "\r\n";
        mail($to, $subject, $message, $headers);
    }
}

$db->select('tbl_settings', '*', null, 'id =1', 'id DESC');
$getSettings = $db->getResult();

$db->select('tbl_businessowner_subscription', '*', null, 'bar_id =' . $_SESSION['bar_id'] . ' and is_active="Active"', 'id DESC');
$getRows = $db->getResult();
$countRows1 = count($getRows);


$db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'] . ' and is_payasyougo=""', 'id DESC');
$getPayasyougoNull = $db->getResult();
$countPayasyougoNull = count($getPayasyougoNull);
if ($countPayasyougoNull == 0) {
    if ($countRows1 > 0) {
        $array = array(
            'is_payasyougo' => '2'
        );

        $db->update('bars_list', $array, 'id=' . $_SESSION['bar_id']);
        $is_res = $db->myconn->affected_rows;
    }
}

$db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'] . ' and is_payasyougo!=""', 'id DESC');
$getPayasyougo = $db->getResult();

$countPayasyougo = count($getPayasyougo);

if (isset($_POST['buyNow'])) {

    $db->select('tbl_businessowner_subscription', '*', null, 'bar_id =' . $_SESSION['bar_id'] . ' and owner_id =' . $_SESSION['business_owner_id'], 'id DESC');
    $getrecord = $db->getResult();
    $countrows = count($getrecord);

    $db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'] . ' and owner_id =' . $_SESSION['business_owner_id'], 'id DESC');
    $getBarDetail = $db->getResult();


    if ($getBarDetail[0]['is_payasyougo'] == 1) {
        // Comission
        $comissionAmount = ($getBarDetail[0]['Comission'] * $_POST['totalamount']) / 100;
        $totalPayableAmount = $_POST['totalamount'] - $comissionAmount;

    }
    if ($getBarDetail[0]['is_payasyougo'] == 2) {
        // Comission
        $discountAmount = ($getBarDetail[0]['Discount'] * $_POST['totalamount']) / 100;
        $totalPayableAmount = $_POST['totalamount'] - $discountAmount;

    }


    $array = array(
        'owner_id' => $_POST['ownerid'],
        'bar_id' => $_POST['barid'],
        'subscription_id' => $_POST['subscriptionid'],
        'duration' => $_POST['duration'],
        'totalamount' => $_POST['totalamount'],
        'totalPayableAmount' => ($totalPayableAmount) ? $totalPayableAmount : 0,
        'comissionAmount' => ($comissionAmount) ? $comissionAmount : 0,
        'discountAmount' => ($discountAmount) ? $discountAmount : 0,
        'dueamount' => $_POST['totalamount'],
        'payment_status' => 'Pending'
    );
    $db->insert('tbl_businessowner_subscription', $array); // Table name, column names and values, WHERE conditions

    $res = $db->getResult();
    $lastInsertedId = $res[0];
    if ($lastInsertedId != "") {
        $_SESSION['msg'] = '<div class="alert alert-success">Order has been placed for subscription!</div>';
        header("location:business_owner_summary.php?id=" . $lastInsertedId);
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
            <!--==============================Subscription History=================================-->

            <?php
            if (isset($_SESSION['bar_id'])) {
                $db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'], 'id DESC');
                $getBar = $db->getResult();
                $countBar = count($getBar);
                if ($countBar > 0) {
                    $db->select('tbl_businessowner_subscription', 'tbl_businessowner_subscription.*,tbl_subscription.title', 'tbl_subscription on tbl_subscription.id=tbl_businessowner_subscription.subscription_id', 'bar_id =' . $_SESSION['bar_id'] . ' and owner_id =' . $_SESSION['business_owner_id'], 'id DESC', 10);
                    $res = $db->getResult();
                    $numrows = count($res);
                    if ($numrows > 0) {
                        ?>
                        <div class="row">

                            <div class="span8">
                                <h2 class="pull-left">Subscriptions</h2>
                            </div>
                            <div class="span4">
                                <h2 class="pull-right">

                                    <?php
                                    if ($getBar[0]['is_payasyougo'] == "1") {
                                        ?>
                                        <strong style="text-transform:none;font-size:14px;">Commission per
                                            transaction: <?php echo $getBar[0]['Commission'] . "%"; ?></strong>
                                    <?php } ?>
                                    <?php if ($getBar[0]['is_payasyougo'] == "2") { ?>
                                        <strong style="text-transform:none;font-size:14px;">Discount per
                                            transaction: <?php echo $getBar[0]['Discount'] . "%"; ?></strong>
                                    <?php } ?>
                                    <?php if ($getBar[0]['is_payasyougo'] == "0" || $getBar[0]['is_payasyougo'] == "" || $getBar[0]['is_payasyougo'] == null) {

                                        ?>
                                        <strong style="text-transform:none;font-size:14px;">Discount
                                            (%): <?php echo $getSettings[0]['discount']; ?></strong>
                                        <strong style="text-transform:none;font-size:14px;">Commission
                                            (%): <?php echo $getSettings[0]['commision']; ?></strong>
                                    <?php } ?>
                                </h2>
                            </div>

                        </div>
                        <div class="row clearfix ">
                            <div class="span12 table-responsive">
                                <table class="table" id="order_history" style="border-bottom:2px #2e2e37 solid;">
                                    <thead>
                                    <tr>
                                        <th>Subscription</th>
                                        <th>Duration (in months)</th>
                                        <th>Starting date</th>
                                        <th>Ending date</th>
                                        <th>Amount (&#163;)</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $active_id = 0;
                                    foreach ($res as $subscription) {
                                        if ($subscription['is_active'] == 'Active') {
                                            $active_id = $subscription['subscription_id'];
                                        }
                                        $today = time();
                                        $endofsubscription = @strtotime($subscription['end_date']);
                                        $startofsubscription = @strtotime($subscription['start_date']);
                                        if ($today > $endofsubscription) {
                                            $rescntryvals = array();
                                            $rescntryvals[] = $subscription;

                                            $id1 = @$rescntryvals['id'];
                                            $ownerid1 = @$rescntryvals['owner_id'];
                                            $barid1 = @$rescntryvals['bar_id'];
                                            if ($id1 != "" && $ownerid1 != "" && $barid1 != "") {
                                                //$db->delete('tbl_businessowner_subscription','id='.$id1.' AND owner_id='.$ownerid1.' and bar_id='.$barid1);  // Table name, WHERE conditions
                                                $array = array(
                                                    'is_active' => 'Expired'

                                                );
                                                $db->update('tbl_businessowner_subscription', $array, 'id=' . $id1 . ' AND owner_id=' . $ownerid1 . ' and bar_id=' . $barid1);  // Table name, WHERE conditions

                                                $active_id = 0;
                                            }
                                        }

                                        ?>
                                        <tr>

                                            <td class='pink align-left'><?php echo $subscription['title']; ?></td>
                                            <td><?php echo $subscription['duration']; ?></td>
                                            <td><?php echo ($subscription['start_date'] != "0000-00-00") ? date('m/d/Y', strtotime($subscription['start_date'])) : "-"; ?></td>
                                            <td><?php echo ($subscription['end_date'] != "0000-00-00") ? date('m/d/Y', strtotime($subscription['end_date'])) : "-"; ?></td>
                                            <td><?php echo ($subscription['totalPayableAmount']) ? number_format($subscription['totalPayableAmount'], 2) : number_format($subscription['totalamount'], 2); ?></td>
                                            <?php
                                            if ($subscription['payment_status'] == "Pending") {
                                                echo "<td class='red'>Inactive</td>";
                                            } elseif ($today > $startofsubscription && $today > $endofsubscription && $subscription['payment_status'] == "Done") {
                                                echo "<td class='red'>Expired</td>";
                                            } elseif ($today < $startofsubscription && $today < $endofsubscription && $subscription['payment_status'] == "Done") {
                                                echo "<td class='red'>Inactive</td>";
                                            } elseif ($today > $startofsubscription && $today < $endofsubscription && $subscription['payment_status'] == "Done") {
                                                echo "<td class='pink'>Active</td>";
                                            } else {
                                                echo "<td class='red'>Inactive</td>";
                                            }
                                            ?>
                                            <td class='red'>
                                                <?php
                                                if ($subscription['payment_status'] == "") {
                                                    echo "Pending";
                                                } elseif ($subscription['payment_status'] == "Done") {
                                                    echo "Paid";
                                                } elseif ($subscription['payment_status'] == "Refund Requested") {
                                                    echo "Refund Requested";
                                                } else {
                                                    echo $subscription['payment_status'];
                                                }
                                                ?>
                                            </td>

                                            <?php if ($subscription['payment_status'] == "Done" && $subscription['is_authorised'] == "1") {
                                                if ($today < $startofsubscription) {
                                                    ?>
                                                    <td>
                                                        <a href="javascript:void(0);"
                                                           onclick="refundRequest(<?php echo $subscription['id'] ?>)"
                                                           class="btn btn-danger">Request Refund</a>
                                                    </td>
                                                    <?php
                                                } else {
                                                    echo "<td></td>";
                                                }
                                            } elseif ($subscription['payment_status'] != "Refund Requested" && $subscription['payment_status'] != "Done" && $subscription['payment_status'] == "Pending" && $subscription['payment_status'] != "Refunded") {

                                                ?>
                                                <td>
                                                    <a href="business_owner_summary.php?id=<?php echo $subscription['id']; ?>"
                                                       class="btn btn-danger">Make Payment</a>
                                                </td>
                                                <?php

                                            }
                                            ?>

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
                        <div class="row">

                            <div class="span8">
                                &nbsp;
                            </div>
                            <div class="span4">
                                <h2 class="pull-right">
                                    <?php if ($getBar[0]['is_payasyougo'] == "1") { ?>
                                        <strong style="text-transform:none;font-size:14px;">Commission per
                                            transaction: <?php echo $getBar[0]['Commission'] . "%"; ?></strong>
                                    <?php } ?>
                                    <?php if ($getBar[0]['is_payasyougo'] == "2") { ?>
                                        <strong style="text-transform:none;font-size:14px;">Discount per
                                            transaction: <?php echo $getBar[0]['Discount'] . "%"; ?></strong>
                                    <?php } ?>
                                    <?php if ($getBar[0]['is_payasyougo'] == "0" || $getBar[0]['is_payasyougo'] == "" || $getBar[0]['is_payasyougo'] == null) {

                                        ?>
                                        <strong style="text-transform:none;font-size:14px;">Discount
                                            (%): <?php echo $getSettings[0]['discount']; ?></strong>
                                        <strong style="text-transform:none;font-size:14px;">Commission
                                            (%): <?php echo $getSettings[0]['commision']; ?></strong>
                                    <?php } ?>
                                </h2>
                            </div>

                        </div>
                        <?php
                    }

                }
            }
            ?>
            <!--==============================New Subscription=================================-->
            <?php
            $where = null;
            if($active_id != 1){
                $where = 'id != 1';
            }
            $db->select('tbl_subscription', '*', NULL, $where, 'id ASC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
            $subscriptions = $db->getResult();
            $countSubscriptions = count($subscriptions);
            if ($countSubscriptions > 0) {
                ?>
                <div class="row">

                    <div class="span12">
                        <center><h2>Buy Subscription</h2></center>
                    </div>

                </div>

                <div class="row clearfix ">
                    <?php
                    foreach ($subscriptions as $subscription) {

                        ?>
                        <div class="span4">
                            <div class="panel-group" id="subscription_contents">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <center><h3><?php echo $subscription['title']; ?></h3></center>
                                    </div>
                                    <center>
                                        <div class="panel-body">
                                            <span><?php echo $subscription['type']; ?></span>
                                            <br/><br/>
                                            <span>Duration will be <?php echo $subscription['duration'];
                                                if ($subscription['duration'] == 1) {
                                                    ?> month<?php } else {
                                                    ?> months <?php } ?> </span>
                                            <br/><br/>
                                            <span>Price (&pound;) :<?php echo number_format($subscription['price'], 2); ?></span>

                                        </div>
                                    </center>
                                    <div class="panel-footer">
                                        <center>
                                            <?php
                                            $disable = '';
                                            if ($subscription['id'] == 1) {
                                                $disable = 'disabled="disabled"';
                                            }
                                            if ($active_id > 0 && $active_id == $subscription['id']) { ?>
                                                <button type="button" class="btn btn-info" <?php echo $disable ?>
                                                        style="opacity:0.5 !important;margin-bottom:20px;">Active
                                                </button>
                                            <?php } else { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="ownerid"
                                                           value="<?php echo $_SESSION['business_owner_id'] ?>">
                                                    <input type="hidden" name="barid"
                                                           value="<?php echo $_SESSION['bar_id'] ?>">
                                                    <input type="hidden" name="subscriptionid"
                                                           value="<?php echo $subscription['id'] ?>">
                                                    <input type="hidden" name="duration"
                                                           value="<?php echo $subscription['duration'] ?>">
                                                    <input type="hidden" name="totalamount"
                                                           value="<?php echo $subscription['price'] ?>">
                                                    <input type="submit" name="buyNow"
                                                           value="Buy Now!" <?php echo $disable ?>
                                                           class="btn btn-info"/>
                                                </form>
                                            <?php } ?>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="span4">
                        <div class="panel-group" id="subscription_contents">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <center><h3>Pay as you go</h3></center>
                                </div>
                                <center>
                                    <div class="panel-body">
                                        <span>Percentage charged</span>
                                        <br/><br/>
                                        <span>Per transaction</span>
                                        <br/><br/>
                                        <span>
											<?php
                                            if ($getPayasyougo[0]['is_payasyougo'] == '1') {
                                                echo $getPayasyougo[0]['Commission'] . "%";
                                            } else {
                                                echo $getSettings[0]['commision'] . "%";
                                            }
                                            ?>
										</span>

                                    </div>
                                </center>
                                <div class="panel-footer">
                                    <center>
                                        <?php
                                        if ($countPayasyougoNull == 0 && $countRows1 > 0 && $countPayasyougo > 0) {
                                            ?>
                                            <a href="javascript:void(0)" class="btn btn-info"
                                               onclick="payAsyouGo(1)">Active</a>
                                        <?php } elseif ($countRows1 > 0 && $countPayasyougoNull == 0 && $countPayasyougo > 0) {
                                            ?>
                                            <button type="button" class="btn btn-info" disabled="disabled"
                                                    style="opacity:0.5 !important">Active
                                            </button>
                                            <?php
                                        } elseif ($countPayasyougoNull == 0 && $countRows1 == 0 && $countPayasyougo > 0) {
                                            ?>
                                            <button type="button" class="btn btn-info" disabled="disabled"
                                                    style="opacity:0.5 !important">Active
                                            </button>
                                            <button type="button" class="btn btn-info" onclick="payAsyouGo(2);">
                                                Inactive
                                            </button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="button" class="btn btn-info" onclick="payAsyouGo(1)">
                                                Active
                                            </button>
                                            <button type="button" class="btn btn-info" onclick="payAsyouGo(2);">
                                                Inactive
                                            </button>
                                            <?php
                                        } ?>

                                    </center>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
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
<script>

    function refundRequest(orderid) {

        $.ajax({
            url: "<?php echo SITE_PATH;?>refundRequest.php",
            type: "POST",
            data: {orderid: orderid, role: 1},

            success: function (result) {
                console.log(result);

                window.location = "business_owner_subscription.php";
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });

    }

    function refundPayment(orderid) {

        $.ajax({
            url: "<?php echo SITE_PATH;?>refundSubscription.php",
            type: "POST",
            data: {orderid: orderid},

            success: function (result) {
                console.log(result);

                window.location = "business_owner_subscription.php";
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });

    }

    function payAsyouGo(subType) {


        $.ajax({
            url: "<?php echo SITE_PATH;?>business_owner/changeSubscription.php",
            type: "POST",
            data: {user: "Owner", subType: subType},

            success: function (result) {
                //alert(result);
                //console.log(result);
                if (subType == 1) {
                    window.location = "business_owner_events.php";
                }
                if (subType == 2) {
                    window.location = "business_owner_subscription.php";
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });


    }
</script>