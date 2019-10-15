<?php 
	session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Twitter Login using PHP</title>

<style>

.wrapper
{
	width: 800px;
	margin:0 auto;
}

h1
{
	font-size:28px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
</style>
</head>

<body>
<div class="wrapper">

<?php	
	if(!isset($_SESSION['name']))
	{
		echo "<a href='twitter_login.php'>Login with Twitter</a>";
	}else
	{
		echo "User's Name: ". $_SESSION['name'] . "<br>";
		echo "Screen Name: ". $_SESSION['username'] . "<br>";
		echo "Last Tweet: " .$text = $_SESSION['text'];
	}
?>



</div>
</body>
</html>
