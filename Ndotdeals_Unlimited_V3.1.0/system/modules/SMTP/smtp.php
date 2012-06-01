<?php
//error_reporting(E_ALL);
//error_reporting(E_STRICT);
//date_default_timezone_set('America/Toronto');
require_once('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

//$body             = file_get_contents('contents.html');

$body             = $message;
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP

// $mail->SMTPDebug  = 2;                   
// enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only

$mail->SMTPAuth   = true;                           // enable SMTP authentication
$mail->SMTPSecure = SMTP_TRANSPORT_LAYER_SECURITY;  // sets the prefix to the server
$mail->Host       = SMTP_HOST;      	            // sets SMTP server HOST name
$mail->Port       = SMTP_PORT;                      // set the SMTP port for the server
$mail->Username   = SMTP_USERNAME;  	           // SMTP username
$mail->Password   = SMTP_PASSWORD;                 // SMTP password

$mail->SetFrom(FROM_EMAIL, FROM_NAME);

$mail->AddReplyTo(REPLY_TO_EMAIL,REPLY_TO_NAME);

$mail->Subject    = $subject;

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAddress(SITE_EMAIL, APP_NAME);

$to_list = explode(',',$to);

$between_delay = 75; //max limit of mails send at a slot
$send_count = 1; 
$send_delay = 1; //Delays the program execution for the given number of seconds.

ignore_user_abort(true); // Ignore user aborts and allow the script to run forever
set_time_limit(300); //to prevent the script from dying

foreach($to_list as $row)
{

	if ( ($send_count % $between_delay) == 0 ){
		sleep( $send_delay ); //Delays the program execution for the given number of seconds.
	}
	$address = $row;
	if(!empty($address)) {
		$mail->AddAddress($address, "User");
		$mail->Send();	
		$mail->ClearAddresses(); //clear address
	}
$send_count++;

}

if(!empty($mail->ErrorInfo)) { 

	  set_response_mes(-1,"Mailer Error: " . $mail->ErrorInfo);
	  if($_SESSION['userrole'] == 1)
	  {
		$url = substr($_SERVER['REQUEST_URI'],1); 
		if($url=='admin/daily_mails/' || $url=='admin/daily_mails.php/'){ 
			$url='admin/profile/'; 
		}
		url_redirect(DOCROOT.$url);
	  }
	  url_redirect(DOCROOT);

}

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

?>
