<?php
include 'common.php';
if(isset($_POST['pageNo'])){
	$pageNo = $_POST['pageNo'];
}


$limit  = 15;
$offset = ($pageNo - 1) * $limit;

$name = trim($_POST['name']);
$orderedby = trim($_POST['orderedby']);
$status = $_POST['status'];
$orderid = trim($_POST['orderid']);
$custid = trim($_POST['custid']);
//$_SESSION['business_owner_id']=5811;
//$sql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where owner_id =".$_SESSION['business_owner_id'] ;
//$countsql = "SELECT * , CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o where owner_id =".$_SESSION['business_owner_id'] ;

$sql = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where o.user_id != 0 and owner_id =".$_SESSION['business_owner_id'] ;
$countsql = "SELECT o.* ,u.name as uname ,CASE WHEN order_for_category = 'Bar' THEN (SELECT Business_Name FROM bars_list WHERE id = o.bar_id) ELSE (SELECT event_name from tbl_events WHERE id = o.event_id) END as name FROM tbl_order_history o left join user_register u on u.id=o.user_id where o.user_id != 0 and owner_id =".$_SESSION['business_owner_id'];

if(isset($_POST['custid'])&&$_POST['custid']!="")
{
	@$sql .= " AND o.user_id = ".$_POST['custid'];
	@$countSql .= "	AND o.user_id = ".$_POST['custid'];
}

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

if(isset($_POST['orderedby'])&&$_POST['orderedby']!="")
{
	@$sql .= " AND u.name like '%".$_POST['orderedby']."%'";
	@$countSql .= "	AND u.name like '%".$_POST['orderedby']."%'";
}

if(isset($_POST['status'])&&$_POST['status']!=""&&$_POST['status']!="All")
{
	@$sql .= " AND payment_status = '".$_POST['status']."'";
	@$countSql .= " AND payment_status = '".$_POST['status']."'";
}	
$sql .= " order by order_created_at DESC limit ".$offset.",".$limit;
$res = $db->myconn->query($sql);
$num_rows1 = $res->num_rows;


$countres = $db->myconn->query($countsql);
$num_rows = $countres->num_rows;
#echo $countSql;


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
	//$eventOrBar_id  = ($res1['event_id'])?$res1['event_id']:$res1['bar_id'];
	/* $post_url = "https://mdepayments.epdq.co.uk/ncol/test/querydirect.asp";
 	$post_values = array(
                    
		// the API Login ID and Transaction Key must be replaced with valid values
		"PSPID"            => "mybarnite",
		"ORDERID"        => $res1['transaction_id'],
		"PAYID"            => '',
		"USERID"        => "mybarnite1",
		"PSWD"            => "fE5(hHF0V%",
		
	);
	
	$post_string = "";
    
	foreach( $post_values as $key => $value )
    { 
		$post_string .= "$key=" . urlencode( $value ) . "&"; 
	}
    
	$post_string = rtrim( $post_string, "& " );
              
	$request = curl_init($post_url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_HTTPHEADER, ["application/x-www-form-urlencoded"]);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
	$post_response = curl_exec($request); // execute curl post and store results in $post_response
	
	curl_close ($request); // close curl object
	if($post_response === false)
	{
		echo 'Curl error: ' . curl_error($request);
	}    
	//$post_response response is in xml format
	$simplexml_response = simplexml_load_string($post_response);
	$simplexml_response_array = (array) $simplexml_response;//Convert to array because it is easier to manager for response object name start with @
	$respon = $simplexml_response_array['@attributes']; */
	
	
	/* if($respon['STATUS']=='8')
	{
		$array = array(
					
			'payment_status'=>'Refunded',
			
		);	
		$db->update('tbl_order_history',$array,'id='.$res1['id']); // Table name, column names and values, WHERE conditions	
		$res2 = $db->getResult();
		$lastInsertedId = $res2[0];
	}
	if($respon['STATUS']=='81')
	{
		$array = array(
					
			'payment_status'=>'Refund Requested',
			
		);	
		$db->update('tbl_order_history',$array,'id='.$res1['id']); // Table name, column names and values, WHERE conditions	
		$res2 = $db->getResult();
		$lastInsertedId = $res2[0];
	}
	if($respon['STATUS']=='9')
	{
		$array = array(
					
			'payment_status'=>'Done',
			
		);	
		$db->update('tbl_order_history',$array,'id='.$res1['id']); // Table name, column names and values, WHERE conditions	
		$res2 = $db->getResult();
		$lastInsertedId = $res2[0];
	}
	if($respon['STATUS']=='91')
	{
		$array = array(
					
			'payment_status'=>'Payment processing',
			
		);	
		$db->update('tbl_order_history',$array,'id='.$res1['id']); // Table name, column names and values, WHERE conditions	
		$res2 = $db->getResult();
		$lastInsertedId = $res2[0];
	} */
	
	/* $sql_1 = "SELECT * from tbl_events where id = ".$res1['event_id'];
	$exe_1 = $db->myconn->query($sql_1);
	$getEventDetail= $exe_1->fetch_array(); */
	
?>	
	<tr>
		
		<td><input type="checkbox" name="chk[]" value="<?php echo $res1['id']; ?>" /></td>
		<td><?php echo $res1['user_id'];?></td>
		<td><?php echo $res1['id'];?></td>
		<td><?php echo $res1['name'];?></td>
		<td><?php echo @date("m/d/Y", @strtotime($res1['order_created_at']));?></td>
		<td><?php echo $res1['uname'];?></td>
		<?php if($res1['free_event']=='1')
		{
		?>
		<td>-</td>
		<?php	
		}else
		{
		?>	
		<td>
			<?php 
				if($res1['bar_id']!=0&&$res1['bar_id']!="")
				{
					echo number_format($res1['payable_amount'],2);
				}
				else
				{
					echo number_format($res1['total_amount'],2);
				}	
				
			?>
		</td>
		<?php	
		}	
		?>
		
		
		<?php 
		if($res1['free_event']!=1)
		{
		?>
				<td class="<?php echo ($res1['payment_status']=="Done")?"green":"red"?>" ><?php echo $res1['payment_status'];?></td>	
		<?php 
		}
		else
		{
			echo "<td class='green'>Free entry</td>";
		}	
		?>
		
		<td colspan="2">
		<?php
		if($res1['event_id']!=""&&$res1['event_id']!=0)
		{
				
		?>	
			<a href="javascript:void(0);" onclick="delete_order(<?php echo $res1['id'] ?>,<?php echo $_SESSION['business_owner_id']?>);" class="red">Delete</a> 
			<?php 
			if($res1['free_event']!=1)
			{
			
			?>	
				<?php if(($res1['payment_status']=="Done" || $res1['payment_status']=="Refund Requested") && $res1['is_authorised']=="1"&&$res1['skrill_transaction']==''){?>
				|	<a href="javascript:void(0);" onclick="refundPayment(<?php echo $res1['id'];?>)" class="red">Refund</a> 
				<?php }?>
				<?php if(($res1['payment_status']=="Done" || $res1['payment_status']=="Refund Requested") && $res1['skrill_transaction']!=''){?>
					|	<a href="javascript:void(0);" onclick="refundPaymentSkrill(<?php echo $res1['id'];?>)" class="red">Refund</a> 
				<?php }?>
			<?php	
			}	
			?>
			
		<?php
		}
		else
		{	
		?>
			<a href="javascript:void(0);" onclick="delete_order(<?php echo $res1['id'] ?>,<?php echo $_SESSION['business_owner_id']?>);" class="red">Delete</a>
			<?php if(($res1['payment_status']=="Done" || $res1['payment_status']=="Refund Requested") && $res1['is_authorised']=="1"&&$res1['skrill_transaction']==''){?>
				|	<a href="javascript:void(0);" onclick="refundPayment(<?php echo $res1['id'];?>)" class="red">Refund</a> 
			<?php }?>
			<?php if(($res1['payment_status']=="Done" || $res1['payment_status']=="Refund Requested") && $res1['skrill_transaction']!=''){?>
				|	<a href="javascript:void(0);" onclick="refundPaymentSkrill(<?php echo $res1['id'];?>)" class="red">Refund</a> 
			<?php }?>
		<?php
		}
		?>
		
		</td>
		
	</tr>	
<?php	

}
?>