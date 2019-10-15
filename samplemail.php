<?php
/*
From http://www.html-form-guide.com 
This is the simplest emailer one can have in PHP.
If this does not work, then the PHP email configuration is bad!
*/
$msg="";
if(isset($_POST['submit']))
{
   $to = "vidhi.scrumbees@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: info@mybarnite.com" . "\r\n" .
"CC: info@mybarnite.com";

mail($to,$subject,$txt,$headers);

	
	if(mail($to,$subject,$txt,$headers)) 
	{
		$msg = "Mail sent OK";
	} 
	else 
	{
 	   $msg = "Error sending email!";
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Test form to email</title>
</head>

<body>
<?php echo $msg ?>
<p>
<form action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' method='post'>
<input type='submit' name='submit' value='Submit'>
</form>
</p>


</body>
</html>