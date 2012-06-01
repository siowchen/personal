<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
	
$gProtected = TRUE; 

require_once('header.php');
$pid=(INT)$_GET['pid'];
$lid=(INT)$_GET['lid'];
$deals = $gXpDb->getDeals($pid,$lid);
//print_r(count($deals)); exit;

$title = $gXpLang['site_title'].' - Deals ';
$description = urldecode($gXpLang['desc_deals']);
$keywords = $gXpLang['keyword_deals'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);

$sql = "SELECT `cityid`, `cityname` FROM `coupons_cities` where status = 'A' order by cityname asc";
$result = $gXpDb->mDb->getAll($sql);
$num_product = count($result);
for($i=0; $i<$num_product; $i++)
{
	$f = $result[$i];
	$products[$f['cityid']] = $f['cityname'];
}

/*
if(count($deals)>0)
{
        $limit[]  = 'Select';
        for($i=1; $i<=10; $i++)
        {
                $limit[]  = $i;
        }
}
else
{
        $limit[]  = ' No Deals Available ';
}
*/

$gXpSmarty->assign_by_ref('deals', $deals);
$gXpSmarty->assign_by_ref('products', $products);
//$gXpSmarty->assign_by_ref('limit', $limit);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("deals.tpl");

?>
