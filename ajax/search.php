<?php
include("../admin/includes/config.cfg");
include("../admin/includes/connection.con");
include("../admin/includes/funcs_lib.inc.php");
//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
$connection=DB_CONNECTION();
?>
<?php
    $key=$_GET['key'];
    $array = array();
   
    $query=mysql_query("select * from bars_list where Business_Name LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['Business_Name'];
    }
    echo json_encode($array);
?>
