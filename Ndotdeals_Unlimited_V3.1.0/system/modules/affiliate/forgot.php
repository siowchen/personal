<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('header.php');

if ($_POST['recover'])
{
	$email = get_magic_quotes_gpc() ? stripslashes($_POST['email']) : $_POST['email'];
	if (!$email)
	{
		$error = true;
		$msg = 'Email incorrect. Please try again.';
	}
	else
	{
		$account = $gXpDb->getAffiliateByEmail($_POST['email']);

		if (!$account)
		{
			$error = true;
			$msg .= 'No account registered with this email.';
		}
		else
		{
			$new_pass = newPassword();
			$gXpDb->setNewPass(Array("id"=>$account['id'], "password"=>$new_pass));
			
			$subject = 'Password recovery request!';
			$body = "Dear {$account['username']},\n\n";
			$body .= "You should use the following credentials to get access\n";
			//$body .= "to NDot Affiliate Member area:\n\n";
			$body .= "username: {$account['username']}\n";
			$body .= "password: {$new_pass}\n";
			$body .= "____________________________\n";
			$body .= "SITE_NAME Support Team\n";
			$body .= "DOCROOT\n";
			//$body .= "mailto:support@ndot.in";

               		/*$SMTP_STATUS = SMTP_STATUS;	
			
			if($SMTP_STATUS==1)
			{

				include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
				
				$msg = 'New password has just been sent to your email.';
			}
			else
			{*/
		     		// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// Additional headers
				$headers .= 'From: '.$From.'' . "\r\n";		
				
				if (mail($_POST['email'], $subject, $body))
				{
					$msg = 'New password has just been sent to your email.';
				}
				else
				{
					$error = true;
					$msg = 'Unknown problem during sending.';
				}	
			//}

		
		}
	}
}	

$title = SITE_NAME.'Affiliate Program - Password Recovery';
$description = $gXpLang['desc_forgot'];
$keywords = $gXpLang['keyword_forgot'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('msg', $msg);

$gXpSmarty->display("forgot.tpl");

?>
