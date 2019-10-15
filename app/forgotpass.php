<?php

	
	
	$host='localhost';

	$uname='msglobal_barnite';

	$pwd='Sg?#Ltt1C=ca';

	$db="msglobal_barnite";

	$con = mysql_connect ('localhost','msglobal_barnite', 'Sg?#Ltt1C=ca' ) or die ( mysql_error() );

	mysql_select_db ( $db, $con ) or die (mysql_error());
	 
	$Email=$_REQUEST['email'];
	$Pass = $_REQUEST['pass'];
	 
	$r=mysql_query("UPDATE user_register SET password = '$Pass' where email = '$Email' ",$con);

	//$query_exec = $r or die(mysql_error());
	//$result = mysql_query($r) or die(mysql_error());
	$flag = array();
	
	
	if(mysql_affected_rows() >= 1){
		
		$flag['status'] = 1;
		$flag['message'] = "your record has  Updated scuessfully";
		
         $to = "sanjaigoswami619@gmail.com";
         $subject = "BarNight Password";
         
         $message = "Your Email address ".$Email;
         $message .= "Your Password is ". $Pass ;
         
         $header = "From:abc@somedomain.com \r\n";
         $header = "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true )
         {
			 $flag['email_conformation'] = "Conformation Email has been Scuessfully sent on your Email Address";
            //echo "Message sent successfully...";
         }
         else
         {
			  $flag['emaail_conformation'] = "Problem Occur while Sending Conformation Email on your Email Address";
            echo "Message could not be sent...";
         }
    
	}else{
	$flag['status'] = 0;
	$flag ['message'] = "Your Record has not Updated";
	//	echo " ";
	}
	print(json_encode($flag));
		mysql_close($con);
