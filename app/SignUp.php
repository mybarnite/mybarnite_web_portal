<?php
	$host='localhost';
	$uname='msglobal_barnite';
	$pwd = 'Sg?#Ltt1C=ca';
	$db = 'msglobal_barnite';

	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	
	 
	
	$name=$_REQUEST['username'];
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$contact=$_REQUEST['contact'];

	$flag['code']=0;
	
	if($r=mysql_query("INSERT INTO user_register (name,email,password,contact,status) values ('$name','$email','$password','$contact','Active') ",$con))
	{
		$flag['code']=1;
		echo"1111";
	}

	print(json_encode($flag));
	mysql_close($con);
?>