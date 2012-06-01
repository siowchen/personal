<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('header.php');
$items = (int)$_GET['items'];
	$items = $items ? $items : 5 ;

	define(ITEMS_PER_PAGE, $items);

	$page = (int)$_GET['page'];
	$page = ($page < 1) ? 1 : $page;
	$start = ($page - 1) * ITEMS_PER_PAGE;
$commissions = $gXpDb->getCommissionsByStat($aff['id'], 2, $start, ITEMS_PER_PAGE);
//print_r($commissions);
for($i=0;$i<=count($commissions);$i++)
{
        $comm[] = $commissions[$i]['payout'];
        $sales[] = $commissions[$i]['payment'];
}
$commiss  = array_sum($comm);
$sales  = array_sum($sales);


if ($_POST['fund'])
{
      // echo $_POST['com'].$commiss;
        if($_POST['com']<= $commiss)
        {
                $gXpDb->addFund($aff['id'],$commiss,$sales,$_POST['com']);
		$msg = "<li>Your fund request are submitted admin.</li>";
               
        }
        else
        {
		 $msg = "<li>Your fund request are greater the your commission .</li>";
        }
	
}

$title =  $gXpLang['site_title'].' - Fund Raising';
$description = $gXpLang['desc_contact'];
$keywords = $gXpLang['keyword_contact'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('msg', $msg);
$gXpSmarty->assign_by_ref('com', $commiss);
$gXpSmarty->assign_by_ref('title', $title);
if ($error)
	$gXpSmarty->assign_by_ref('form', $_POST);

$gXpSmarty->display("fund-raising.tpl");

?>
