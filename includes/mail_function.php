<?php
function mail_attachment($mailto, $from_name, $from_mail, $subject, $message) 
{
	$uid = md5(uniqid(time()));
	$header = "From: ".$from_name." <".$from_mail.">\r\n";
	//$header .= "Reply-To: ".$replyto."\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	$header .= "This is a multi-part message in MIME format.\r\n";
	$header .= "--".$uid."\r\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\r\n";
	$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	$header .= $message."\r\n\r\n";
	$header .= "--".$uid."--";
	#	die($mailto.'<br><br>'.$subject.'<br><br>'.$message.'<br><br>'.$header.'<br><br>'.$from_mail);
	if (mail($mailto, $subject, $message, $header, $from_mail)) {
		 return true;
	} else {
			return false;
	}
}

/////////////////////////////////////status mail////// Email to varification form 
function registerationonfirmationEmail($to, $from_name, $from_email, $subject,$username,$password,$loginID)
{
   
	  $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				 
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Welcome,
							</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Dear ".$loginID.",<br><br>
Welcome to ".SITEROOT."! We are glad to inform you that you are <br>successfully registered. Your login Details are given below: 
<br><br>

                
                Your username is : = ".$username."<br />
                Password is 	 : = ".$password."<br /><br />
                You can click on  <a href='".SITEROOT."login.php'>click on this link </a> to visit our site 
                <br><br>
                With Regards<br />
                ".FROMSITETITLE."<br>
				".$from_email."<br>	
							</td>
					</tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; ".SITEROOT."</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}


/////////////////////////////////////status mail////// Email to varification form 
function pre_registerationonfirmationEmail($to, $from_name, $from_email, $subject,$username,$password,$loginID)
{
	
   
	  $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				 
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Welcome,
							</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'><p>Dear ".$loginID.",<br>
				      <br>
				      Welcome to ".SITEROOT."! We are glad to inform you that you are <br>
successfully registered as a premium member. Your account has been activatied soon.<br />
<br />
                You can click on  <a href='".SITEROOT."login.php'>click on this link </a> to visit our site 
                <br>
                <br>
                With Regards<br />
".FROMSITETITLE."<br>
".$from_email."<br>	
				      </p>
				    </td>
					</tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; ".SITEROOT."</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}	

function requestEmailAdmin($to, $from_name, $from_email, $subject,$message)
{
   
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}	



function forgotpasswordEmail($to, $from_name, $from_email, $subject,$username,$password)
{
   
	  $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				 
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Welcome,
							</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Your new login information on ".FROMSITETITLE." is following: <br> <br />
                
                Your username is : = ".$username."<br />
                Password is 	 : = ".$password."<br /><br />
                You can click on this link <a href='".SITEROOT."'>here</a> to access your account 
                <br><br>
                With Regards<br />
                ".FROMSITETITLE."
							</td>
					</tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; ".SITEROOT."</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}	






function referToFriendEmail($to, $from_name, $from_email, $subject,$friend,$sender)
{
   
 	 $message="<table width='950' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'></td>
        </tr>
        <tr>
          <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'><p> Dear ".$friend.",<br>
              <br>
                  How are you, I really found some thing interesting<br>
              for you when i am surfing n net. You also like<br>
              this site (".SITEROOT.") <br>
              when you want to purchase Indian fabrics that are rare.<br>
              You can become a permanent member of this site <a href='".SITEROOT."'>Click Here</a><br>
              <br><br>
              From  ".$sender."<br>
              <br>
              <br>
              With Regards<br />
              ".FROMSITETITLE." </td>
        </tr>
        <tr>
          <td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; ".SITEROOT.".</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
";
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}	

/*
function deactivate_email($to, $from_name, $from_email, $subject,$username,$password)
{
   
	 echo $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Welcome on http://kesstudent.com/
							</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Your account had been deactivated by the admin. on http://kesstudent.com/ <BR /><BR />.
							</td>
					</tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; kesstudent.com/.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$sign_up = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($sign_up)
	{
		return true;
	}
}	
*/


/*function contact_mail($to, $to_name, $from, $from_name, $subject, $comment)
{
  $message="<table width='607' border='0' align='left' cellpadding='0' cellspacing='0'>
	      <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
			  <tr>
				<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
			font-size: 16px; font-weight:bold;
			color: #0099FF; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Hi,&nbsp;<span style='font-family: Arial, Helvetica, sans-serif;
			font-size: 16px; font-weight:bold;
			color: #333333;'>".$to_name."</span></td>
			  </tr>
			  <tr>
				<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #626262;'><strong>".$from_name."</strong> sent an email from his email address  <strong>".$from."</strong> through Posh-Swaps.com contact form <br> His message follows.<p>".$comment."</td>
				</tr>
			  <tr>
				<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
				  </tr>
				</table></td>
			  </tr>
			</table></td>
		  </tr>
		</table>";
$succ = mail_attachment($to, $from_name, $from, $subject, $message);
if($succ)
	{
		return true;
	}
}*/	

/////////////////////////////////////status mail////// Email to varification form 
/*function notification_email($to_notify, $to_name1, $from_name1, $from_mail, $email, $user_name, $text, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name1.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>A new user register on the site www.posh-swaps.com <br> username is <strong>".$user_name."</strong> <br>
					    Email address of the user is <strong>".$email."</strong></td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Notify of the user ".$text."</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name1, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/


/////////////////////////////////////news Add/////////////// 
/*function news_add($to, $to_name, $from_name, $from, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>A news added on the www.posh-swaps.com <br></td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to, $from_name, $from, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/

/////  invite friends///
/*function invite_friends($to,$from_name,$from_email,$invite_name,$subject,$message)
{
	$message="<table width='607' border='0' align='left' cellpadding='0' cellspacing='0'>
	      <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
			  <tr>
				<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
			font-size: 16px; font-weight:bold;
			color: #0099FF; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Hi,&nbsp;<strong>".$invite_name."</strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-family: Arial, Helvetica, sans-serif;
			font-size: 16px; font-weight:bold;
			color: #333333;'>I am ".$from_name."<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email id </span>: -".$from_email."</span>
			</td>
			  </tr>
			  <tr>
				<td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #626262;'><p><strong>Invite you to join :</strong> Posh-Swaps.com  To swap and buy your Cloths<br>
			<hr><strong>If you have registration </strong>&nbsp;&nbsp;&nbsp;click &nbsp;&nbsp;<a href='".GetSiteRoot()."'register.php><strong>HERE</strong></a><hr></p>
			</td>
				</tr>
				<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				</table></td>
			  </tr>
		  </tr>
		</table>";
	$invite_friends = mail_attachment($to, $from_name, $from_email, $subject, $message);
	if($invite)
	{
		return true;
	}
}*/


///////////////////////////////////// Swap Notification Email //////////////////
/*function notification_swap($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'><strong>You have received a swap proposal on posh-swaps.com<br>Click <a href='http://Posh-Swaps.com/'>here</a> to view </strong> ".GetSiteRoot()."</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}*/	

///////////////////////////////////// Buying Notification Email //////////////////
/*function notification_Buy($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px; border-top:1px solid #CCCCCC;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>A user wants to buy an item on site www.posh-swaps.com<br> click <a href='http://Posh-Swaps.com/'>here</a> to view proposal ".GetSiteRoot()."</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px; border-top:1px solid #CCCCCC;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/

///////////////////////////////////// Confirm Sell //////////////////
/*function Confirm_Sell($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>You offer has been accepted on posh-swaps.com. Please log into ".GetSiteRoot()." to make payment.</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/


/*function Accept_Swap($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			    <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
					<tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Your swap has been accepted</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Your swap has been accepted Click <a href='http://Posh-Swaps.com/'>here</a> to view  ".GetSiteRoot()."</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}*/	

/*function Reject_Swap($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
					<tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Your swap has been rejected</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Your swap has been rejected Click <a href='http://Posh-Swaps.com/'>here</a> to view  ".GetSiteRoot()."</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/


/*function Reject_Buy($to_notify, $to_name, $from_name, $from_mail, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			    <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
					<tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Your swap has been rejected</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Your swap has been rejected Click here to view ".GetSiteRoot()."</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}	*/


#message

/*function Send_Message($to, $to_name, $from_name, $from_email, $subject)
{
			 
			 $message="<table width='607' border='0' align='center' cellpadding='0' cellspacing='0'>
			    <tr>
				<td align='center' background=".GetSiteRoot()."images/mid.gif'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='65' align='left' valign='top'><img src='".GetSiteRoot()."images/logo.gif' width='302' height='65' hspace='8' /></td>
				  </tr>
					<tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>You have a message on posh-swaps.com</td>
				  </tr>
				  <tr>
					<td align='left' valign='top' style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #626262; padding:5px 10px 5px 10px;'>Hi <span style='font-family: Arial, Helvetica, sans-serif;
				font-size: 16px; font-weight:bold;
				color: #1d8deb;'>".$to_name.",</span>
							</td>
				  </tr>
				  <tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>You have a message on posh-swaps.com Click <a href='http://Posh-Swaps.com/'>here</a> to view </td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>With warmest wishes</td> 
				  </tr>
					<tr>
				    <td align='left' valign='top' style='padding:5px 10px 10px 10px; font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>Posh Swaps</td> 
				  </tr>
				  <tr>
					<td align='left' valign='top' style='padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='left' valign='top' style='Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #626262;'>&copy; Copyright Heathcote Communications Ltd All Rights Reserved.</td>
					  </tr>
					</table></td>
			  </tr>
			</table>";
	$notification = mail_attachment($to_notify, $from_name, $from_mail, $subject, $message);
	if($send)
		{
			return true;
		}
}*/	

?>