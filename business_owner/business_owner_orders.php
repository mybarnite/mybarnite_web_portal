<?php
include('template-parts/header.php');

if ($_SESSION['business_owner_id'] != "") {
    //$sql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where owner_id =".$_SESSION['business_owner_id'];
    //$sql = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where owner_id =".$_SESSION['business_owner_id'] ;
    $sql = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where o.user_id != 0 and owner_id =" . $_SESSION['business_owner_id'];
    $res = $db->myconn->query($sql);
    $num_rows = $res->num_rows;
#$result = $res->fetch_array();
#echo "<pre>";
#print_r($res);
    if (isset($_REQUEST['delete'])) {

        $chk = $_REQUEST['chk'];
        foreach ($chk as $id) {
            $succ_del = $db->delete("tbl_order_history", "id=" . $id);
        }
        if ($succ_del) {
            $_SESSION['msg'] = "success";
        } else {
            $_SESSION['msg'] = "error";
        }
        ?>
        <script>window.location.href = "business_owner_orders.php?msg=<?=$_SESSION['msg'];?>";</script>
        <?php
    }

    ?>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>business_owner/js/custom.js"></script>

    <!--==============================Map=================================-->
    <style>
        .jconfirm-box {
            width: 50% !important;
        }
    </style>
    </header>
    <div class="padcontent"></div>
    <section id="content" class="main-content">
        <div class="container">
            <?php
            if (isset($_SESSION['business_owner_id'])) {
                ?>


                <?php
                if (isset($_SESSION['bar_id'])) {
                    $db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'], 'id DESC');
                    $getBar = $db->getResult();
                    $countBar = count($getBar);
                    ?>
                    <div class="row clearfix ">
                        <div class="span12">
                            <br/>
                            <center><h2>Order History</h2></center>
                        </div>
                    </div>
                    <?php
                    if ($countBar > 0) {
                        ?>
                        <div class="row clearfix ">
                            <?php
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
                            <div class="span12">
                                <h4><strong style="text-transform:none;font-size:14px;">Amount to be recieved (&pound;)
                                        : <?php echo number_format($amountToRetriev, 2); ?></strong></h4>

                                <?php
                                $sql1 = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where payment_status = 'Done' and owner_id =" . $_SESSION['business_owner_id'];
                                $getTotalOrdersPaid = $db->myconn->query($sql1);
                                $num_orders = $getTotalOrdersPaid->num_rows;
                                ?>
                                <h4><strong style="text-transform:none;font-size:14px;">Total order placed
                                        : <?php echo $num_orders; ?></strong></h4>
                            </div>
                            <?php /*
			<?php 
			$db->select('tbl_order_history','SUM(total_amount) as totalRefund',NULL,'Owner_id="'.$_SESSION['business_owner_id'].'" and payment_status="Refunded"','id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
			$totalRefund = $db->getResult();
			$refundAmount = $totalRefund[0]['totalRefund'];
			?>
			<div class="span6">
				<h4 class="pull-right"><strong style="text-transform:none;font-size:14px;">Refunded amount (&pound;)	: <?php echo number_format($refundAmount,2);?></strong></h4>
			</div>
			*/
                            ?>
                            <div class="span12 table-responsive" id="order_history_container">
                                <form action="" method="post">
                                    <br/>
                                    <center>
                                        <?php if (isset($_SESSION['msg'])) {
                                            echo $_SESSION['msg'];
                                            unset($_SESSION['msg']);
                                        } ?>
                                        <?php if (@$_REQUEST['msg'] == "success") {
                                            echo "<div class='alert alert-success'>Data has been deleted successfully!</div>";

                                        } ?>
                                        <?php if (@$_REQUEST['msg'] == "error") {
                                            echo "<div class='alert alert-danger' >Error occured!</div>";

                                        } ?>
                                    </center>
                                    <?php
                                    if ($num_rows > 0) {
                                        ?>

                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th width="150" style="vertical-align: middle;">
                                                    <input type="submit" name="delete" value="Delete"
                                                           class="input btn btn-danger"/>
                                                    <!--<strong>Change Payment Status:</strong>-->

                                                </th>
                                                <th>
                                                    <?php /*<select name="payment_status" id="payment_status" onchange="change_payment_status();">
											<option value="Select">Select</option>
											<option value="Pending">Pending</option>
											<option value="Done">Paid</option>
											<option value="Canceled">Cancel</option>
											<option value="Refund">Refund</option>
										</select> */
                                                    ?>

                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>

                                                </th>

                                            </tr>
                                            </thead>
                                        </table>
                                        <table class="table" id="order_history">
                                            <thead>
                                            <tr>

                                                <th><input type="checkbox" id="selecctall" onClick="selectAll(this)"/>
                                                </th>
                                                <th>Customer id</th>
                                                <th>Order id</th>
                                                <th>Name</th>
                                                <th>Ordered at</th>
                                                <th>Ordered by</th>
                                                <th>Amount (&pound;)</th>
                                                <th>Payment Status</th>
                                                <th colspan="2">Actions</th>

                                            </tr>

                                            </thead>
                                            <tbody>
                                            <tr>

                                                <td></td>
                                                <td><input name="custid" id="custid"
                                                           style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                           value="" placeholder="Customer id..."/></td>
                                                <td><input name="orderid" id="orderid"
                                                           style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                           value="" placeholder="Order id..."/></td>
                                                <td><input name="name" id="name"
                                                           style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                           value="" placeholder="Name..."/></td>
                                                <td><input name="orderedby" id="orderedby"
                                                           style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                           value="" placeholder="Ordered by..."/></td>
                                                <td></td>

                                                <td>
                                                    <select name="status" id="status" style="width: 135px;">
                                                        <option value="All">All</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Done">Paid</option>
                                                        <option value="Canceled">Cancel</option>
                                                        <option value="Refund">Refund</option>
                                                    </select>
                                                </td>
                                                <td colspan="2"><input type="submit" name="filter" id="filter"
                                                                       value="Filter" class="btn btn-info"/><input
                                                            type="submit" name="reset" id="reset" value="Reset"
                                                            class="btn btn-info"/></td>

                                            </tr>
                                            </tbody>
                                            <tbody id="target-content">
                                            <input type="hidden" id="totalCount" value=""/>
                                            <input type="hidden" id="Page" value="1"/>

                                            </tbody>
                                        </table>
                                        <center>
                                            <div class="allPage">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary start"><b><<</b>
                                                    </button>
                                                    <button type="button" class="btn btn-primary left"><b><</b></button>
                                                    <button type="button" class="btn btn-primary right"><b>></b>
                                                    </button>
                                                    <button type="button" class="btn btn-primary end"><b>>></b></button>
                                                </div>
                                            </div>
                                        </center>
                                        <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="row text-center">
                        <div class="span12">
                            <h5 class="alert alert-danger h5-notregisteredbar">You can not able to access this page
                                because your Bar / Business has not been registered yet.<br/> Please <a
                                        href="business_owner_edit_profile.php"> register your Business </a> here.</h5>

                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
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
    <?php
}
include 'template-parts/footer.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.js"></script>
<script>

    function refundPaymentSkrill(orderid) {

        $.ajax({
            url: "<?php echo SITE_PATH;?>refundPaymentSkrill.php",
            type: "POST",
            data: {orderid: orderid, user: "Owner"},

            success: function (result) {
                window.location = "business_owner_orders.php";
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });

    }


    function refundPayment(orderid) {
        $.confirm({
            title: 'Refund request!',
            content: 'Are you sure, you want to proceed for refund!',

            buttons: {
                confirm: function () {

                    $.ajax({
                        url: "<?php echo SITE_PATH;?>refundPayment.php",
                        type: "POST",
                        data: {orderid: orderid, user: "Owner"},

                        success: function (result) {
                            //console.log(result);return false;
                            window.location = "business_owner_orders.php";
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                        }
                    });
                },
                cancel: function () {
                    $.ajax({
                        url: "<?php echo SITE_PATH;?>refundRejected.php",
                        type: "POST",
                        data: {orderid: orderid, user: "Owner"},

                        success: function (result) {
                            window.location = "business_owner_orders.php";
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                        }
                    });
                }
            }
        });
    }

    $(document).ready(function () {
        getUserDetals();
        var limit = 15;
        $("#filter").click(function () {
            $("#Page").val("1");
            getUserDetals();
            return false;
        });
        $(".right").click(function () {

            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);
            //alert(finalPage);

            if (parseInt($("#Page").val()) != finalPage) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) + 1);
                getUserDetals();
                enableDisPagination();
            }
        });

        $(".left").click(function () {
            if ($("#Page").val() != 1) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) - 1);
                getUserDetals();
                enableDisPagination();
            }
        });


        $(".start").click(function () {
                if ($("#Page").val() != 1) {
                    $("#Page").val(1);
                    getUserDetals();
                    enableDisPagination();
                }
            }
        );

        $(".end").click(function () {

            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (parseInt($("#Page").val()) != finalPage) {
                $("#Page").val(finalPage);
                getUserDetals();
                enableDisPagination();
            }
        });

        function getUserDetals() {
            $.ajax(
                {
                    url: "orderList.php",
                    type: "POST",
                    data: {
                        pageNo: $("#Page").val(),
                        name: $("#name").val(),
                        orderedby: $("#orderedby").val(),
                        status: $("#status").val(),
                        orderid: $("#orderid").val(),
                        custid: $("#custid").val()
                    }
                    ,
                    success: function (response) {
                        $("#target-content").html(response);
                        if (parseInt($("#totalCount").val()) > limit) {
                            $(".allPage").show();
                            enableDisPagination();
                        } else {
                            $(".allPage").hide();
                        }


                    }
                }
            );
        }

        function enableDisPagination() {
            if ($("#Page").val() != 1) {
                $(".start").removeClass("disabled");
                $(".left").removeClass("disabled");

            } else {
                $(".start").addClass("disabled");
                $(".left").addClass("disabled");

            }

            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (finalPage == $("#Page").val()) {

                $(".right").addClass("disabled");
                $(".end").addClass("disabled");
            } else {

                $(".right").removeClass("disabled");
                $(".end").removeClass("disabled");
            }
        }
    });

</script>