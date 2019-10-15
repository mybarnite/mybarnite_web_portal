<?php
session_start();
ob_start();
unset($_SESSION['discount']);
unset($_SESSION['payableamount']);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");
$connection = DB_CONNECTION();
?>
<?php include 'head.php'; ?>
<title>My Orders</title>
<?php
include('header.php');

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

if (isset($_POST['instId'])) {
    require_once('./config.php');
    $token = $_POST['stripeToken'];
    $email = $_POST['stripeEmail'];
   
    $customer = \Stripe\Customer::create([
        'email' => $email,
        'source' => $token,
    ]);

    $charge = \Stripe\Charge::create([
        'customer' => $customer->id,
        'amount' => $_POST['MC_totalpayable'],
        'currency' => 'gbp',
        "metadata" => $_POST
    ]);

//     $account = \Stripe\Account::retrieve('acct_1F9XX5Fks0ov2odH');
// $account->delete();

//   $account = \Stripe\Transfer::create([
//   "amount" => 400,
//   "currency" => "gbp",
//   "destination" => "acct_1F1hxKH6OpRSvVDa"
// ]);

    $_POST['MC_totalpayable'] = $_POST['MC_totalpayable'] / 100;
    $_POST['transId'] = $charge->id;
    $_POST['cartId'] = $customer->default_source;


    if ($charge->id) {
        $_POST['transStatus'] = 'Y';
        require_once('./barclaycard/return.php');
    }
    /*$tmpa = array('payment_status' => 'Done' , 'transaction_id' => $customer->id,'cartId' => $customer->default_source);
    $db->update('tbl_order_history',$tmpa,'id='.$_POST['instId']);
	$tres2 = $db->getResult();*/
}

$query = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where user_id =" . $_SESSION['id'] . " and payment_status = 'Done' and is_authorised = '0' order by id DESC limit 1";
$exe = $db->myconn->query($query);
//$order = $exe->fetch_assoc();
$num_authorised = $exe->num_rows;
if ($num_authorised > 0) {
    $order = $exe->fetch_assoc();
    $ORDERID = $order['id'] . '-' . $order['transaction_id'];
    #echo "<pre>";
    #print_r($order);
    $post_url = "https://mdepayments.epdq.co.uk/ncol/test/maintenancedirect.asp";

    $post_values = array(

        // the API Login ID and Transaction Key must be replaced with valid values
        "PSPID" => 'mybarnite',
        "ORDERID" => $order['transaction_id'],
        "PAYID" => '',
        "USERID" => "mybarnite1",
        "PSWD" => "fE5(hHF0V%",
        "OPERATION" => "SAS",//capture payment
        "AMOUNT" => $order['payable_amount'] * 100,//Amount to be paid MULTIPLIED BY 100, as the format of the amount must not contain any decimals or other separators.
    );

    $post_string = "";

    foreach ($post_values as $key => $value) {
        $post_string .= "$key=" . urlencode($value) . "&";
    }

    $post_string = rtrim($post_string, "& ");

    $request = curl_init($post_url); // initiate curl object
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_HTTPHEADER, ["application/x-www-form-urlencoded"]);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
    $post_response = curl_exec($request); // execute curl post and store results in $post_response

    curl_close($request); // close curl object
    if ($post_response === false) {
        echo 'Curl error: ' . curl_error($request);
    }
    //$post_response response is in xml format
    $simplexml_response = simplexml_load_string($post_response);

    $simplexml_response_array = (array)$simplexml_response;//Convert to array because it is easier to manager for response object name start with @

    $respon = $simplexml_response_array['@attributes'];
    if ($respon['STATUS'] == 91) {
        $array = array(

            'is_authorised' => 1

        );
        $db->update('tbl_order_history', $array, 'id=' . $order['id']); // Table name, column names and values, WHERE conditions
        $res2 = $db->getResult();
        echo $lastInsertedId = $res2[0];
    }

}

if ($_SESSION['id'] != "") {

    $sql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where user_id =" . $_SESSION['id'];
    $res = $db->myconn->query($sql);
    $num_rows = $res->num_rows;

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
        <script>window.location.href = "orders.php?msg=<?=$_SESSION['msg'];?>";</script>
        <?php
    }

    ?>
    <script type="text/javascript" src="js/frontend_custom.js"></script>
    <section id="content" class="main-content">
        <div class="container">
            <div class="row clearfix ">

                <div class="span12">
                    <br/>
                    <center><h2>Order History</h2></center>

                </div>
            </div>

            <div class="row clearfix ">
                <?php /*
			<div class="span12">
				<h4><strong style="text-transform:none;font-size:14px;">Total order placed : <?php echo $num_rows;?></strong></h4>
			</div>
			*/
                ?>

                <div class="span12 table-responsive" id="order_history_container">
                    <form action="" method="post">
                        <br/>
                        <center>
                            <?php if (isset($_SESSION['msg'])) {
                                echo "<div class='alert alert-success color_green'><b>".$_SESSION['msg']."</b></div>";
                                unset($_SESSION['msg']);
                            } ?>
                            
                            <?php if (@$_REQUEST['msg'] == "success") {
                                echo "<div class='alert alert-success'>Data has been deleted successfully.</div>";
                            } ?>
                            
                            <?php if (@$_REQUEST['msg'] == "error") {
                                echo "<div class='alert alert-danger' >Please select atleast one order.</div>";

                            } ?>
                        </center>
                        <?php
                        if ($num_rows > 0) {
                            ?>

                            <table class="table" id="order_history">
                                <thead>
                                <tr>

                                    <th><input type="checkbox" id="selecctall" onClick="selectAll(this)"
                                               style="margin: 0 4px 0;"/>Select All
                                    </th>
                                    <th>Order id</th>
                                    <th>Name</th>
                                    <th>Purchased Date</th>
                                    <th>Event Status</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th colspan="2">Actions</th>
                                    <th colspan="2"></th>
                                    <th colspan="2"></th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="submit" name="delete" value="Delete" class="input btn btn-danger"/>
                                    </td>
                                    <td><input name="orderid" id="orderid"
                                               style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                               value="" placeholder="Order id..."/></td>
                                    <td><input name="name" id="name"
                                               style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                               value="" placeholder="Name..."/></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select name="status" id="status" style="width: 60px;">
                                            <option value="All">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Done">Paid</option>
                                            <option value="Canceled">Cancel</option>
                                        </select>
                                    </td>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                    <td colspan="2"><input type="submit" name="filter" id="filter" value="Filter"
                                                           class="btn btn-info"/><input type="submit" name="reset"
                                                                                        id="reset" value="Reset"
                                                                                        class="btn btn-info"/></td>
                                    <td></td>


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
                                        <button type="button" class="btn btn-primary start"><b><<</b></button>
                                        <button type="button" class="btn btn-primary left"><b><</b></button>
                                        <button type="button" class="btn btn-primary right"><b>></b></button>
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
        </div>
    </section>
    <?php
} else {
    header('Location: https://mybarnite.com/index.php');
}
include('footer.php');
?>
<script>
    function refundRequest(orderid, role) {

        $.ajax({
            url: "<?php echo SITE_PATH;?>refundRequest.php",
            type: "POST",
            data: {orderid: orderid, role: 2},

            success: function (result) {
                window.location = "orders.php";
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });

    }

    $(document).ready(function () {
        getDetals();
        var limit = 15;
        $("#filter").click(function () {
            $("#Page").val("1");
            getDetals();
            return false;
        });
        $(".right").click(function () {

            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (parseInt($("#Page").val()) != finalPage) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) + 1);
                getDetals();
                enableDisPagination();
            }

        });

        $(".left").click(function () {
            if ($("#Page").val() != 1) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) - 1);
                getDetals();
                enableDisPagination();
            }

        });


        $(".start").click(function () {
                if ($("#Page").val() != 1) {
                    $("#Page").val(1);
                    getDetals();
                    enableDisPagination();
                }
            }
        );

        $(".end").click(function () {

            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (parseInt($("#Page").val()) != finalPage) {
                $("#Page").val(finalPage);
                getDetals();
                enableDisPagination();
            }
        });

        function getDetals() {
            $.ajax(
                {
                    url: "orderList.php",
                    type: "POST",
                    data: {
                        pageNo: $("#Page").val(),
                        name: $("#name").val(),
                        status: $("#status").val(),
                        orderid: $("#orderid").val()
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

    function selectAll(source) {

        checkboxes = document.getElementsByName('chk[]');
        for (var i in checkboxes)
            checkboxes[i].checked = source.checked;

    }
</script>