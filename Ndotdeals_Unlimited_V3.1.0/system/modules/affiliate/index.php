<?php
ob_start();
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('header.php'); 


if($_COOKIE['aff_id'])
{
	$title = SITE_NAME.' - '.$gXpLang['general_statistics'];
	$traffic['visits'] = $aff['hits'];
	$traffic['visitors'] = $gXpDb->getVisitorsCount($aff);
	$traffic['sales'] = $gXpDb->getSalesCount($aff);
	
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
	
	$gXpSmarty->display("general-statistics.tpl");
}
else
{

	$title = SITE_NAME.' - '.$gXpLang['join_us'];
	$description = $gXpLang['desc_index'];
	$keywords = $gXpLang['keyword_index'];
	
	$gXpSmarty->assign_by_ref('title', $title);
	$gXpSmarty->assign_by_ref('description', $description);
	$gXpSmarty->assign_by_ref('keywords', $keywords);
	
	$gXpSmarty->display("index.tpl");
	
}

?>
