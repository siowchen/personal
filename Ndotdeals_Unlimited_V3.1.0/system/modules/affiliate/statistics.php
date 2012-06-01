<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$gProtected = TRUE; 

require_once('header.php');

$title = $gXpLang['site_title'].' - '.$gXpLang['general_statistics'];
$traffic['visits'] = $aff['hits'];
$traffic['visitors'] = $gXpDb->getVisitorsCount($aff);
$traffic['sales'] = $gXpDb->getSalesCount($aff);
$trans['transaction'] = $gXpDb->getTransactionList($aff);
$trans['salecount'] = $gXpDb->getSaleList($aff);
if(empty($trans['transaction']))
{
        $trans['transaction'] = 0;
}
if ($traffic['sales'] && $traffic['visits'])
{
	$traffic['ratio'] = format($traffic['sales'] / $traffic['visits'] * 100);
} 
else 
{
	$traffic['ratio'] = "0.000"; 
}

$description = $gXpLang['desc_statistics'];
$keywords = $gXpLang['keyword_statistics'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('xproot', $gXpConfig['xpurl']);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('traffic', $traffic);
$gXpSmarty->assign_by_ref('trans', $trans);

$gXpSmarty->display("general-statistics.tpl");

?>
