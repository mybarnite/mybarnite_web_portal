<?php
session_start();
ob_start(); 
define('SITE_PATH','https://mybarnite.com/');
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);
include('../admin/includes/config.cfg');
include(ROOT_PATH.'business_owner/class/business_owner.php');
include(ROOT_PATH.'business_owner/class/form.php');
include(ROOT_PATH.'admin/includes/funcs_lib.inc.php');
$db = new business_owner();
$db->connect();

//PAGE_PROHIBITTED($_SESSION['SESSION_AUTHENTICATE_HITTING']);
//$connection=DB_CONNECTION();

/* echo "<pre>";
print_r($_SESSION);
exit; */
?>