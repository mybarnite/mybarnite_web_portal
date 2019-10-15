<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Ajax Tutorial: Dynamic Loading of ComboBox using jQuery and Ajax in PHP</title>

<script type="text/javascript" src="jquery-1.3.2.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	$('#loader').hide();
	$('#show_heading').hide();
	
	$('#search_category_id').change(function(){
		$('#show_sub_categories').fadeOut();
		$('#loader').show();
		$.post("get_chid_categories.php", {
			parent_id: $('#search_category_id').val(),
		}, function(response){
			
			setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
		});
		return false;
	});
});

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} 

function alert_id()
{
	if($('#sub_category_id').val() == '')
	alert('Please select a sub category.');
	else
	alert($('#sub_category_id').val());
	return false;
}

</script>
<style>
.both h4{ font-family:Arial, Helvetica, sans-serif; margin:0px; font-size:14px;}
#search_category_id{ padding:3px; width:200px;}
#sub_category_id{ padding:3px; width:200px;}
.both{ float:left; margin:0 15px 0 0; padding:0px;}
</style>
</head>
<?php
		include('dbcon.php');?>
<body>

<h1>Dynamic Loading of ComboBox using jQuery and Ajax in PHP </h1>

<br clear="all" /><br clear="all" /><br clear="all" />

<div style="padding-left:30px;">
<form action="#" name="form" id="form" method="post" onsubmit="return alert_id();" enctype="multipart/form-data">

	<div class="both">
		<h4>Select Category</h4>
		<select name="search_category"  id="search_category_id">
		<option value="" selected="selected"></option>
		<?php
		$query = "select * from ajax_categories where pid = 0";
		$results = mysql_query($query);
		
		while ($rows = mysql_fetch_assoc(@$results))
		{?>
			<option value="<?php echo $rows['id'];?>"><?php echo $rows['category'];?></option>
		<?php
		}?>
		</select>		
	</div>
	
	<div class="both">
		<h4 id="show_heading">Select Sub Category</h4>
		<div id="show_sub_categories" align="center">
			<img src="loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
		</div>
	</div>
	<br clear="all" /><br clear="all" />
	
	<input type="submit" name="" value="GO" />
</form>
</div>
<br clear="all" /><br clear="all" /><br clear="all" />
<br clear="all" /><br clear="all" /><br clear="all" />
<br clear="all" /><br clear="all" />
<br clear="all" /><br clear="all" /><br clear="all" />
<br clear="all" /><br clear="all" /><br clear="all" />

</body>
</html>