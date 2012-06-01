<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/docroot.php');
require_once('classes/XpConfig.php');
require_once('classes/Xp.php');
require_once('utils/util.php');

$vid = (INT)$_GET['affiliate'];
$city = $_GET['city'];
$pid = (INT)$_GET['pid'];
$cname = $_GET['page'];

$vref = getenv("HTTP_REFERER");

if ($vid > 0)
{
	
	$acb = $gXpDb->checkByCookie($vid, addslashes($_COOKIE['xp']), $pid);	
	if(!empty($_COOKIE['xp']) && count($acb)>0)
	{
		$gXpDb->updateVisitor(addslashes($_COOKIE['xp']), $vid, $pid);
		$gXpDb->addHit($vid);
	}
	else
	{
		$uid = $_COOKIE['xp']? addslashes($_COOKIE['xp']) : registerVisitor($vid, '');//set cookies
		if($uid)
		{
			$gXpDb->addVisitor($vid, $pid, $uid, $vref);
		}
	}
	/* Change to the header location  */	
	//header("Location: {$gXpConfig['incoming_page']}?affiliate=".$vid);
	header("Location: {$gXpConfig['incoming_page']}deals/".$cname.".html?affiliate=".$vid."&city=".$city); //redirection issue fixed
	exit;

}
?>
