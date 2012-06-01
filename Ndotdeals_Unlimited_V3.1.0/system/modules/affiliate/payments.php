<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$gProtected = TRUE; 

require_once('header.php');

$title = $gXpLang['site_title'].' - '.$gXpLang['payment_history'];

if(is_array($aff) && $aff['id'] > 0)
{
	$payments = $gXpDb->getPayments($aff['id']);
}

$description = $gXpLang['desc_payments'];
$keywords = $gXpLang['keyword_payments'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('payments', $payments);

$gXpSmarty->display("payments.tpl");

?>
