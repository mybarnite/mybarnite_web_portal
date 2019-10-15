<?php
include('template-parts/header.php');

if ($_SESSION['business_owner_id'] != "") { ?>
    <script type="text/javascript" src="<?php echo SITE_PATH; ?>business_owner/js/custom.js"></script>
    </header>
    <div class="padcontent"></div>
    <section id="content" class="main-content">
        <div class="container">
            <?php if (isset($_SESSION['business_owner_id'])) {
                if (isset($_SESSION['bar_id'])) { ?>
                    <div class="row clearfix ">
                        <div class="span12">
                            <br/>
                            <center><h2>Billed Orders History</h2></center>
                        </div>
                    </div>
                    <div class="row clearfix ">
                        <?php $sql = "SELECT * FROM tbl_order_history WHERE user_id != 0 AND bill_trans_id=" . intval($_REQUEST['id']) . " AND owner_id =" . $_SESSION['business_owner_id'];
                        $res = $db->myconn->query($sql);
                        $num_orders = $res->num_rows; ?>
                        <div class="span12">
                            <h4><strong style="text-transform:none;font-size:14px;">Total billed orders
                                    : <?php echo $num_orders; ?></strong></h4>
                        </div>
                        <div class="span12 table-responsive" id="order_history_container">
                            <form action="" method="post">
                                <?php if ($num_orders > 0) { ?>
                                    <table class="table" id="order_history">
                                        <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Booking Type</th>
                                            <th>Ordered on</th>
                                            <th>Ordered by</th>
                                            <th>Amount (&pound;)</th>
                                            <th>Paid (&pound;)</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input name="orderid" id="orderid"
                                                       style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                       value="" placeholder="Order id..."/></td>
                                            <td>
                                                <select name="bookingType" id="bookingType" style="width: 135px;">
                                                    <option value="">Booking Type</option>
                                                    <option value="Event">Event</option>
                                                    <option value="Bar">Bar</option>
                                                </select>
                                            </td>
                                            <td></td>
                                            <td><input name="orderedby" id="orderedby"
                                                       style="padding: 4px 9px;border-radius: 2px;box-shadow: none;border: 1px solid white;width: 115px;"
                                                       value="" placeholder="Ordered by..."/></td>
                                            <td></td>
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
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row text-center">
                        <div class="span12">
                            <h5 class="alert alert-danger h5-notregisteredbar">You can not able to access this page
                                because your Bar / Business has not been registered yet.<br/> Please <a
                                    href="business_owner_edit_profile.php"> register your Business </a> here.</h5>
                        </div>
                    </div>
                <?php }
            } else { ?>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.backbtn').show();
        getOrderFilterData();
        var limit = 15;
        $("#filter").click(function () {
            $("#Page").val("1");
            getOrderFilterData();
            return false;
        });
        $(".right").click(function () {
            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (parseInt($("#Page").val()) != finalPage) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) + 1);
                getOrderFilterData();
                enableDisPagination();
            }

        });

        $(".left").click(function () {
            if ($("#Page").val() != 1) {
                var currentPageNo = $("#Page").val();
                $("#Page").val(parseInt(currentPageNo) - 1);
                getOrderFilterData();
                enableDisPagination();
            }

        });


        $(".start").click(function () {
                if ($("#Page").val() != 1) {
                    $("#Page").val(1);
                    getOrderFilterData();
                    enableDisPagination();
                }
            }
        );

        $(".end").click(function () {
            var totalRecords = $("#totalCount").val();
            var finalPage = Math.ceil(totalRecords / limit);

            if (parseInt($("#Page").val()) != finalPage) {
                $("#Page").val(finalPage);
                getOrderFilterData();
                enableDisPagination();
            }
        });

        function getOrderFilterData() {
            $.ajax(
                {
                    url: "billed_order_list.php",
                    type: "POST",
                    data: {
                        pageNo: $("#Page").val(),
                        bookingtype: $("#bookingType").val(),
                        orderedby: $("#orderedby").val(),
                        orderid: $("#orderid").val(),
                        billid: <?php echo intval($_REQUEST['id']); ?>
                    },
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