<?php
ob_start();
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
if($_REQUEST['lang']!='')
{
	session_start();
	$_SESSION["site_language"] = $_REQUEST['lang'];
}
else
{
	session_start();
        $_SESSION["site_language"] = 'en';
}

// include language file

$lang = $_SESSION["site_language"];
if($lang)
{
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/en.php");
}
//set_response_mes(1,$language['language_has_been_changed']);

set_response_mes(1,$language['language_changed']);

url_redirect(DOCROOT);
ob_flush();
?>	
