<?php
include("../includes/config.php");

if($_REQUEST)
{
	$id = $_REQUEST['parent_id'];
	$query = "SELECT * FROM `subcat` WHERE catid = ".$id;
	$results = mysql_query( $query);?>
	<select name="subcat" id="sub_category_id" style="padding:5px; width:200px;">
        <option value="" selected="selected"></option>
        <?php while ($rows = mysql_fetch_assoc(@$results)) { ?>
            <option value="<?php echo $rows['id'];?>"><?php echo $rows['subcat'];?></option>
        <?php } ?>
	</select>	
	
<?php } ?>