<?php

session_start();
session_destroy();
echo "<script>window.location.href='business_owner_signin.php'</script>";
exit;
?>