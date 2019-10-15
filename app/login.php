<?php
	$host='localhost';
	$uname='msglobal_barnite';
	$pwd='Sg?#Ltt1C=ca';
	$db="msglobal_barnite";

	$con = mysql_connect ('localhost','msglobal_barnite', 'Sg?#Ltt1C=ca' ) or die ( mysql_error() );

	mysql_select_db ( $db, $con ) or die (mysql_error());
	 
	$Email=$_REQUEST['email'];
	$pass = $_REQUEST['pass'];
	 
	$r=mysql_query("select * from user_register where email = '".$Email."' AND password ='".$pass."' ",$con);
	$query_exec = $r or die(mysql_error());
	$rows = mysql_num_rows($query_exec);
//echo $rows;
	$flag['code'] = 0;
	if($rows == 0) { 
		
		echo "No Such User Found"; 
		}
		else  {
			$flag['code']=1;
			echo "User Found"; 
}
		print(json_encode($flag));
		mysql_close($con);