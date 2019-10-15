<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TradeKeyIndia.Com</title>
<style>
td { font-family:Arial, Helvetica, sans-serif;};
h1 { font-family:Arial, Helvetica, sans-serif; font-size:22px; }
</style>
</head>
<body bgcolor="#FBF5EE">
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td align="center" height="100"><h1><a href="tradekeyindia.Com"><img src="http://www.tradekeyindia.com/images/logo.gif" border="0" /></a></h1>&nbsp;</td>
  </tr>
  <tr>

    <td><table style="border-bottom:5px solid #c06800; border-top:5px solid #c06800;" cellspacing="8" ><tr>
<?php
function getDirectory( $path = '.', $level = 0 )
{
    $ignore = array( 'cgi-bin', '.', '..' );
    // Directories to ignore when listing output. Many hosts
    // will deny PHP access to the cgi-bin.
    $dh = @opendir( $path );
    // Open the directory to the handle $dh
    
    while( false !== ( $file = readdir( $dh ) ) ){
    // Loop through the directory
    static $i=1;
        if( !in_array( $file, $ignore ) ){
        // Check that this file is not to be ignored
            
            $spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
            // Just to add spacing to the list, to better
            // show the directory tree.
            
            if(is_dir("$path/$file"))
			{
            // Its a directory, so we need to keep reading down...
            
               	 $cat[] = "$file";
                //getDirectory( "$path/$file", ($level+1) );
                // Re-call this same function but on a new directory.
                // this is what makes function recursive.
               
            } 
			else 
			{
				//echo "$spaces $file<br />";
				// Just print out the filename
            }
        }
    $i++;
    }    
	 return $cat;
    closedir($dh);
    // Close the directory handle
}
$con = getDirectory( "." ); 
//$arry = $con;
//print_r($con);
asort($con);
foreach ($con as $key => $val) 
{
static $i=1;
if($i%3=='0')
{
	$co="</tr><tr>";
}
else
{
	$co="";
}
    echo "<td width='25'><b>$i.</b></td><td width='375'><b><a target='_blank' href='http://tradekeyindia.in/620.124.745/projectsb2b/$val/'>$val</a><b></td>$co";
	
$i++;	
}
?></table></td>
  </tr>
  <tr><td height="20">



	<table width="100%" border="0" cellpadding="0" class="bdr4">



	<tr>



	<td class=" bg3 white" ><b class="pl15px">We Own &amp; Manage</b></td>



	<td class=" bg6" ><p class="p5px"><a href="http://www.tradekeyindia.com/" target="_blank">TradeKeyIndia.Com</a></p></td>



	<td class=" bg6" ><p class="p5px"><a href="http://www.tradekeyindia.com/" target="_blank">TravelKeyIndia.Com</a></p></td>



	<td class=" bg6" ><p class="p5px"><a href="http://www.delhincrads.com/" target="_blank">DelhiNCRads.Com</a></p></td>



	<td class=" bg6" ><p class="p5px"><a href="http://www.jobskeyindia.com/" target="_blank">JobsKeyIndia.Com</a></p></td>



	</tr>



	</table>	



	<p class="p2px ac" >&copy; Copyright  2011. Web Key Network Pvt Ltd All Rights Reserved. - TradeKeyIndia.com</p>



</td>
  </tr>
</table>
</body>
</html>
