<?php 
if($_SESSION["userid"]!='')
{
	url_redirect(DOCROOT);
}
else
{ 
	require_once(DOCUMENT_ROOT.'/site-admin/pages/login.php');
}
?>

