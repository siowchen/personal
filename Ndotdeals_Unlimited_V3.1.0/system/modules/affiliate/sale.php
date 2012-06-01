<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$include_path = dirname(__FILE__);

require_once($include_path.'/includes/config.inc.php');
require_once($include_path.'/classes/Xp.php');
require_once($include_path.'/includes/variables.inc.php');


unset($data);
unset($xp);
unset($merchant);

if($_POST)
{
	$data = array_map("htmlentities", $_POST);
}
elseif($_GET)
{
	$data = array_map("htmlentities", $_GET);
}

if(!$vip)
{
	$vip = $data['vip'];
}

$affs = $gXpDb->checkByIP($vip);//$data['vip']);

if(!$vref)
{
	$vref = $data['merchant'];
}

//merchant identification starts

include('includes/merchants.inc.php');

for($i=0; $i<count($merchants); $i++)
{
	if(strstr($vref, $merchants[$i]['name']))
	{
		$amount = $data[$merchants[$i]['amount']];
		$order_number = $data[$merchants[$i]['order_number']];
		$name = $merchants[$i]['name'];
		break;
	}
}

//echo "amount = {$amount} order_number = {$order_number}";

//mrechant identification ends

if(count($affs))
{
	$xp = $affs[0]['aff_id'];
}

if($xp)
{
	//	$payment = $data[$gXpConfig['amount_variable']];

	if($amount>0)
	{
		$gXpDb->addSale($xp, $amount, $vip, $order_number, $name);//$data['vip']);
		$gXpDb->addAffiliateSale($xp);

		$tpl = $gXpDb->getEmailTemplateByKey('admin_new_sale');
		$subject = $tpl['subject'];
		$body = $tpl['body'].$tpl['footer'];
		$body = stripslashes($body);

		$body = str_replace('{your_sitename}',$gXpDb->mConfig['site'],$body);
		$body = str_replace('{your_sitename_link}',$gXpDb->mConfig['xpurl'],$body);
		
		$gXpDb->mMailer->sendEmail($gXpDb->mConfig['site_email'], $subject, $body, $gXpDb->mConfig['site_email'], $gXpDb->mConfig['site_email']);

	}
}


?>
