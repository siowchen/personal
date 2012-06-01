<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

/** deletes cookies **/
setcookie('aff_id', '', time() - 3600, '/');
setcookie('aff_pwd', '', time() - 3600, '/');

/** requires common header file **/
require_once('header.php');

if ($_GET['action'] == 'logout')
{
	header('Location: logout.php');
}

$title = $gXpLang['site_title'].' - '.$gXpLang['email_links'];
$description = $gXpLang['desc_logout'];
$keywords = $gXpLang['keyword_logout'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->assign_by_ref('title', $gXpLang['logout']);

$gXpSmarty->display('logout.tpl');
?>
