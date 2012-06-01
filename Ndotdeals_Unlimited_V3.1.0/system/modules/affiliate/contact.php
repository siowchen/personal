<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('header.php');

if ($_POST['contact'])
{
	$fullname = (get_magic_quotes_gpc()) ? stripslashes($_POST['fullname']) : $_POST['fullname'];
	if (!$fullname)
	{
		$error = true;
		$msg = "<li>{$gXpLang['error_contact_fullname']}</li>";
	}
	
	$email = (get_magic_quotes_gpc()) ? stripslashes($_POST['email']) : $_POST['email'];
	/** check emails **/
	if (!preg_match('/^[a-z0-9\-_\.]+@[a-z0-9\-_]+(\.[a-z0-9]{2,5})+$/i', $email))
	{
		$error = true;
		$msg .= "<li>{$gXpLang['error_email_incorrect']}</li>";
	}
	
	$body = (get_magic_quotes_gpc()) ? stripslashes($_POST['body']) : $_POST['body'];
	if (!$body)
	{
		$error = true;
		$msg .= "<li>{$gXpLang['error_contact_body']}</li>";
	}

	if (!$error)
	{
		$gXpDb->addContact(addslashes($fullname), addslashes($email), addslashes($body));
		$msg = "<li>{$gXpLang['contact_added']}</li>";
	}
	$msgstyle = $error?'error':'notify';
	
	$msg = "<ul class=\"{$msgstyle}\">{$msg}</ul>";
}

$title =  $gXpLang['site_title'].' - '.$gXpLang['contact_us'];
$description = $gXpLang['desc_contact'];
$keywords = $gXpLang['keyword_contact'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('msg', $msg);
$gXpSmarty->assign_by_ref('title', $title);
if ($error)
	$gXpSmarty->assign_by_ref('form', $_POST);

$gXpSmarty->display("contact.tpl");

?>
