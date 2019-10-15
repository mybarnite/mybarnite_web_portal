<?php 
	
session_start();
ob_start();


include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");

include('class/business_owner.php');
include('class/form.php');

$db = new business_owner();
$db->connect();

$barName = trim($_POST['barName']);
$barCity = trim($_POST['barCity']);
//$query = "select b.* from bars_list as b left join user_register as u on b.Owner_id = u.id and where u.status = 'Inactive'";

$query = "SELECT b. * , 
CASE WHEN b.Owner_id !=0
THEN (

SELECT STATUS 
FROM user_register
WHERE id = b.Owner_id
AND STATUS =  'Inactive'
)
ELSE  'Inactive'
END AS user_status
FROM bars_list AS b
";

//$query = "select b.* from bars_list as b left join user_register as u on b.Owner_id = u.id where (b.Owner_id = '0') or (b.Owner_id != '0' and u.status = 'Inactive')";
//$query = "select b.* from bars_list as b where b.Owner_id = '0'";

if($barName!=""&&$barCity=="")
{
	@$query .= " where b.Business_Name like '".$barName."%' HAVING user_status =  'Inactive'";
}	

if($barCity!=""&&$barName=="")
{
	@$query .= " where b.Location_Searched like '".$barCity."%' HAVING user_status =  'Inactive'";
}
	
if($barCity!=""&&$barName!="")
{
	@$query .= " where b.Business_Name like '".$barName."%' and b.Location_Searched like '".$barCity."%' HAVING user_status =  'Inactive'";
}


#echo $query;
$res = $db->myconn->query($query);
$num_rows1 = $res->num_rows;
if($num_rows1>0)
{	
	?>

	<?php
	for($i = 1; $i <= $num_rows1; $i++)
	{
		$res1 = $res->fetch_array();
		if($num_rows1==1)	
		{
	?>
		<div class="span4">&nbsp;</div>
		<div class="span4">
			<div class="panel-group" id="subscription_contents">
				<div class="panel panel-default">
					<div class="panel-heading"><center><h3><?php echo $res1['Business_Name'];?></h3></center></div>
					<center>	
						<div class="panel-body">
							<span><?php echo $res1['Address']; ?></span>
							<br/>
							<span><?php echo $res1['Location_Searched']; ?></span>
							<br/>
							<span><?php echo $res1['Zipcode']; ?></span>
							
						</div>
					</center>
					<div class="panel-footer">
						<center>
							<a href="business_owner_signup.php?id=<?php echo $res1['id']; ?>" class="btn btn-info">Claim business</a>	
						</center>
						<br/>
					</div>
				</div>
			</div>
		</div>	
		<div class="span4">&nbsp;</div>	
	<?php		
		}
		else	
		{	
	?>
			<div class="span4">
				<div class="panel-group" id="subscription_contents">
					<div class="panel panel-default">
						<div class="panel-heading"><center><h3><?php echo $res1['Business_Name'];?></h3></center></div>
						<center>	
							<div class="panel-body">
								<span><?php echo $res1['Address']; ?></span>
								<br/>
								<span><?php echo $res1['Location_Searched']; ?></span>
								<br/>
								<span>Postcode :<?php echo $res1['Zipcode']; ?></span>
							</div>
						</center>
						<div class="panel-footer">
							<center>
								<a href="business_owner_signup.php?id=<?php echo $res1['id']; ?>" class="btn btn-info">Claim business</a>	
							</center>
						</div>
						<br/>
					</div>
				</div>
			</div>	
			
	<?php
		}	
	}
}
else
{
?>
<div class="span4">&nbsp;</div>
<div class="span4"><div class="alert alert-danger">No records found.</div></div>
<div class="span4">&nbsp;</div>
<?php	
}	
?>	


