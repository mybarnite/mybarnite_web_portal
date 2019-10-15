<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("admin/includes/config.cfg");
include("admin/includes/connection.con");
include("admin/includes/funcs_lib.inc.php");

include('business_owner/class/business_owner.php');
include('business_owner/class/form.php');
$db = new business_owner();
$db->connect();

/*--------------------- Barclaycard  --------------------*/
require "barclaycard/BarclaycardEpdq.class.php";
$resultUrl = "http://mybarnite.com/barclaycard/return.php";
$barclaycardEpdq = new BarclaycardEpdq();

/*--------------------- Barclaycard ends here --------------------*/

if(isset($_POST['pageNo'])){
	$pageNo = $_POST['pageNo'];
}


$limit  = 15;
$offset = ($pageNo - 1) * $limit;
$name = trim($_POST['name']);
$orderid = trim($_POST['orderid']);
$status = $_POST['status'];

$sql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name,
CASE WHEN order_for_category = 'Bar' THEN 0 ELSE (SELECT event_end from tbl_events WHERE id = o.event_id) END as event_end_date FROM tbl_order_history o where user_id =".$_SESSION['id'] ;
$countsql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where user_id =".$_SESSION['id'] ;

if(isset($_POST['orderid'])&&$_POST['orderid']!="")
{
	@$sql .= " AND o.id = ".$_POST['orderid'];
	@$countSql .= "	AND o.id = ".$_POST['orderid'];
}

if(isset($_POST['name'])&&$_POST['name']!="")
{
	@$sql .= " AND o.ordername like '%".$_POST['name']."%'";
	@$countSql .= "	AND o.ordername like '%".$_POST['name']."%'";
}


if(isset($_POST['status'])&&$_POST['status']!=""&&$_POST['status']!="All")
{
	@$sql .= " AND payment_status = '".$_POST['status']."'";
	@$countSql .= " AND payment_status = '".$_POST['status']."'";
}

$sql .= " order by id DESC limit ".$offset.",".$limit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;

$countres = $db->myconn->query($countsql);
$num_rows = $countres->num_rows;

#echo $_SESSION['useremail'];

?>
	<input type='hidden' id='totalCount' value='<?php echo $num_rows; ?>'/>
	<input type='hidden' id='Page' value='<?php echo "$pageNo" ?>'/>
<?php	
for($i = 1; $i <= $num_rows1; $i++)
{
	$res1 = $res->fetch_array();
	$start = @strtotime($res1['order_created_at']);
	$end = @strtotime($res1['order_created_at']. ' + 4 hours');
	$dt = @date("Y-m-d H:i:s");
	$current = @strtotime($dt);
	if(isset($res1['name']))
	{	

		/* $sql_1 = "SELECT * from tbl_events where id = ".$res1['event_id'];
		$exe_1 = $db->myconn->query($sql_1);
		$getEventDetail= $exe_1->fetch_array(); */
		//echo $res1['event_id'];
?>	
	<tr <?php if($res1['event_id']!=0&&@strtotime($res1['event_end_date'])<= @strtotime(date('Y-m-d'))){?> class="bg-grey" <?php }?>>
		<td><input type="checkbox" name="chk[]" value="<?php echo $res1['id']; ?>" /></td>
		<td><?php echo $res1['id'];?></td>
		<td class="align-left"><?php echo $res1['name'];?></td>
		<td class="align-left"><?php echo @date("m/d/Y", @strtotime($res1['order_created_at']));?></td>
		<?php 
		if($res1['event_id']!=0&&@strtotime(@date('Y-m-d')) >= @strtotime($res1['event_end_date'])){?>
				<td class="align-left expired">Expired</td>
		<?php }else{?><td class="align-left">Not expired</td><?php }?>	
		<?php if($res1['free_event']=='1')
		{
		?>
		<td class="align-right">-</td>
		<?php	
		}else
		{
		?>	
		<td class="align-right"><?php echo number_format(($res1['payable_amount'])?$res1['payable_amount']:$res1['total_amount'], 2);?></td>	
		<?php	
		}	
		?>
		
		<?php 
		if($res1['free_event']=='1')
		{
		?>	
			<td  class="green">Free entry</td>
		<?php	
		}else{
		?>
			<?php 
			if($res1['event_id']!=0&&@strtotime(@date('Y-m-d')) >= @strtotime($res1['event_end_date'])){?>
			<td>-</td>
			<?php }else{?>
			<td  class="<?php echo ($res1['payment_status']=="Done")?"green":"red"?>" ><?php echo ($res1['payment_status']=="Done")?"Paid":$res1['payment_status'];?></td>
			<?php }?>
		<?php	
		}	
		?>
		
		<td colspan="2">
		<?php
		if($res1['event_id']!=""&&$res1['event_id']!=0)
		{
		
		?>	
			<a href="javascript:void(0);" onclick="delete_order(<?php echo $res1['id'] ?>,<?php echo $_SESSION['id']?>);">Delete</a> <?php if($res1['payment_status']=="Pending"  && @strtotime(@date('Y-m-d')) <= @strtotime($res1['event_end_date'])){?>| <a href="update_order.php?id=<?php echo $res1['id']?>">Edit</a>	<?php }?>
		<?php
		}
		else
		{	
		?>
			<a href="javascript:void(0);" onclick="delete_order(<?php echo $res1['id'] ?>,<?php echo $_SESSION['id']?>);">Delete</a> <?php if($res1['payment_status']=="Pending"){?>| <a href="update_bar_order.php?id=<?php echo $res1['id']?>">Edit</a>	<?php }?>
		<?php
		}
		?>
		</td>
		
			
			<?php if($res1['payment_status']=="Pending" && ($res1['event_end_date'] == 0
			|| @strtotime(@date('Y-m-d')) <= @strtotime($res1['event_end_date']))){
				
				//5438311234567890

				?> 
				<td colspan="2" >
					<?php if($res1['free_event']=='1'){?>
					-
					<?php }else{?>
					<a class="btn btn-info bg-pink" href="checkoutdetail.php?orderid=<?php echo $res1['id'] ?>" >Make Payment</a>
					<?php }?>
					
				</td>
							
			<?php
				}
				else
				{
					echo "<td colspan='2' ></td>";
				}
				
				if($res1['payment_status']=="Pending"&&$current<$end)
				{	
			?>
					<td><a href="javascript:void(0);" onclick="cancel_order(<?php echo $res1['id'] ?>,<?php echo $_SESSION['id']?>);">Cancel Booking</a></td> 
			
			<?php 
				}
				
				else
				{
					if($res1['payment_status']=="Done")
					{
			?>			
						<td><a class="btn btn-danger" href="javascript:void(0);"  onclick="refundRequest(<?php echo $res1['id']?>,2)">Request refund</a></td>
			<?php
					}	
					else
					{
						echo "<td></td>";
					}	
				}	
				
			?>
		
	</tr>		
<?php	
	}
}
?>
