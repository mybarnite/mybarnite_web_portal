<?php /*session_start(); // place it on the top of the script ?>
<?php
    $statusMsg = !empty($_SESSION['msg'])?$_SESSION['msg']:'';
    unset($_SESSION['msg']);
    echo $statusMsg;
?>

<form method="post" action="">
    
    <p><label>Email: </label><input type="text" name="email" /></p>
    <p><input type="submit" name="submit" value="SUBSCRIBE"/></p>
</form> */

?>









<?php
if(isset($_POST['emailId'])){
   
    $email = $_POST['emailId'];
	$roleId = $_POST['roleId'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        // MailChimp API credentials
        $apiKey = 'fa2ad061b00d484a7ffd0eda21c0936f-us14';
		
		// Business owner newsletter list 
		if($roleId == 1){
			$listID = '0f2f3e2c0c';
		} 
		// Visitor' newsletter
		else {
			$listID = 'ccb753a57d';
		}
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
			'language'      => 'en'
            
        ]);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		
        // store the status message based on response code
        if ($httpCode == 200) {
            $msg = '<p style="color:#21DC15;">Thank you for subscribing to mybarnite newsletter.</p>';
        } else {
            switch ($httpCode) {
                case 214:
                    $msg = '<p style="color:#FF0000;">You are already subscribed to mybarnite newsletter.</p>';
                    break;
                default:
                    $msg = '<p style="color:#FF0000;">Some problem occurred, please try again.</p>';
                    break;
            }
            
        }
    }else{
        $msg = '<p style="color:#FF0000;">Please enter valid email address.</p>';
    }
	
	echo $msg;
}
// redirect to homepage
