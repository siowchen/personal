<?php 
ob_start();
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
* @Author: NDOT
* @URL : http://www.ndot.in
********************************************/
session_start();
//include(DOCUMENT_ROOT.'/includes/library.inc.php');

require_once('./init.php');
/* Add to the affiliate sales starts  */
//print_r($_POST); exit;
if (!empty($_POST))
{
       $r_min = 000000001;
	$r_max = 999999999;
	$uid = mt_rand($r_min, $r_max);

	$data['uid'] = $uid;
	$affId = split('_',$_POST['item_number']);//print_r($affId[0]);
	$sales = split('_',$_POST['item_name']);//print_r($sales[0]);
	
	$data['aff_id'] = sql($affId[0]);
	$data['sales'] = sql($sales[0]);
	$data['commission'] = sql($_POST['mc_gross']);

	$gXpAdmin->insertPayment($data);

	$sales = $gXpAdmin->getSales($affId[0]);

	for($i=0;$i<count($sales);$i++)
	{
		$gXpAdmin->archiveSales($sales[$i], $uid);
	}

	$gXpAdmin->deleteSales($affId[0]);

	$msg .= $gXpLang['payment_success_archived'];
	header("Location: pay-affiliates.php");
}

/* Add to the affiliate Ends  */


ob_flush();
?>



