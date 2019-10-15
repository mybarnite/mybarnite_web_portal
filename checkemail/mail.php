<?php
require 'class.phpmailer.php';


$mail = new PHPMailer();
$mail->IsSMTP();               
$mail->SMTPDebug  = 2;          
$mail->SMTPAuth = true;      
$mail->SMTPSecure = "tls";      
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
 
$mail->Username   = "";
$mail->Password   = "";

$mail->Subject = 'Hello Subject';
$mail->Body = 'This is test message';        
 
$mail->AddAddress("");

if($mail->send())
{
    echo "Y";
}
?>
