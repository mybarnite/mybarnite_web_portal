<?php
include 'common.php';
if (isset($_POST['pageNo'])) {
    $pageNo = $_POST['pageNo'];
}


$limit = 15;
$offset = ($pageNo - 1) * $limit;

$sql = "SELECT o.* ,u.name as uname FROM tbl_order_history o left join user_register u on u.id=o.user_id where o.user_id != 0 and bill_trans_id=" . intval($_POST['billid']) . " and owner_id =" . $_SESSION['business_owner_id'];

if (isset($_POST['orderid']) && $_POST['orderid'] != "") {
    @$sql .= " AND o.id like '%" . $_POST['orderid'] . "%'";
}
if (isset($_POST['bookingtype']) && $_POST['bookingtype'] != "") {
    @$sql .= " AND o.order_for_category = '" . $_POST['bookingtype'] . "'";
}

if (isset($_POST['orderedby']) && $_POST['orderedby'] != "") {
    @$sql .= " AND u.name like '%" . $_POST['orderedby'] . "%'";
}
$countsql = $sql;
$sql .= " order by order_created_at DESC limit " . $offset . "," . $limit;
$res = $db->myconn->query($sql);
$num_rows = $res->num_rows;

$countres = $db->myconn->query($countsql);
$count_num_rows = $countres->num_rows;
?>
    <input type='hidden' id='totalCount' value='<?php echo $count_num_rows; ?>'/>
    <input type='hidden' id='Page' value='<?php echo "$pageNo" ?>'/>
<?php if ($num_rows > 0) { ?>
    <?php for ($i = 1; $i <= $num_rows; $i++) {
        $res1 = $res->fetch_array(); ?>
        <tr>
            <td><?php echo $res1['id']; ?></td>
            <td><?php echo $res1['order_for_category']; ?></td>
            <td><?php echo @date("m/d/Y", @strtotime($res1['order_created_at'])); ?></td>
            <td><?php echo $res1['uname']; ?></td>
            <td><?php echo number_format($res1['total_amount'], 2); ?></td>
            <td><?php echo number_format($res1['bill_trans_amount'], 2); ?></td>
        </tr>
        <?php
    }
} else { ?>
    <tr>
        <td colspan="6">No records found..!</td>
    </tr>
<?php } ?>