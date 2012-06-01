<?php
ob_start();
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$directory = @opendir('./install/');
if ($directory)
{
	header("Location: install/index.php");
	exit;
}

/** require necessary files **/

require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/config.php');
require_once('includes/config.inc.php');
require_once('classes/Xp.php');
require_once('includes/auth.inc.php');
require_once('templates/'.$gXpConfig['tmpl'].'/Layout.php');
require_once('classes/XpSmarty.php');
require_once('utils/util.php');



/** define used language **/
$GLOBALS['langs'] = $_SESSION["site_language"];
$l = !empty($_GET['language']) ? $_GET['language'] : (!empty($_COOKIE['language']) ? $_COOKIE['language'] : false);
/*if(!$l || !in_array($l, $GLOBALS['langs']))
{
	// get default
	$gXpLang = $gXpDb->getLangPhrase($gXpConfig['lang']);
} else {
	$gXpLang = $gXpDb->getLangPhrase($l);
}*/

include($_SERVER["DOCUMENT_ROOT"]."/system/modules/affiliate/language/affiliate_en.php");

define("LANGUAGE", $l);
unset($l);

$theme_name = CURRENT_THEME; //theme name
$_SESSION['theme'] = $theme_name;
#-------------------------------------------------------------------------------
$default_city_id = $_SESSION['defaultcityId']; //get the default city id
$_SESSION['city'] = $default_city_id;
#-------------------------------------------------------------------------------
$root_dir_path = 'themes/'.$theme_name.'/pages/'; //root directory
$_SESSION['path_root'] = $root_dir_path;

$root_sidebar_path = 'themes/'.$theme_name.'/';
$_SESSION['path_sideroot'] = $root_sidebar_path;

#-------------------------------------------------------------------------------
$file_name = $_REQUEST["file"]; //get the file name
#-------------------------------------------------------------------------------
# language file included here
#-------------------------------------------------------------------------------
$lang = $_SESSION["site_language"];
if($lang)
{
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/en.php");
}


$_SESSION['lang_aff'] = $lang_list;

if($_COOKIE['aff_id']>0)
{
	$aff =& $gXpDb->getAffiliateById($_COOKIE['aff_id']);
	if($aff)
	{
		$login = '<a href="logout.php?action=logout">'.$gXpPrase['logout'].'</a>';
		$username = $aff['username'];
		$stat['transactions'] = $gXpDb->getSalesCount($aff);
		$temp = $gXpDb->getEarnings($aff);
		if($temp)
		$stat['earnings'] = $temp;
		else
		$stat['earnings'] = "0.00";
	}
}
$images = $gXpConfig['templates'].$gXpConfig['tmpl'].$gXpConfig['dir'].$gXpConfig['images'];

//$styles = $gXpConfig['templates'].$gXpConfig['tmpl'].$gXpConfig['dir'].'css'.$gXpConfig['dir'];
$path = 'http://'.$_SERVER["HTTP_HOST"].'/'.$_SESSION['path_sideroot'];



$main_menu[] = array('title' => $gXpLang['home'], 'link' => 'index.php');
if($aff['approved'] == 2)
{
	$main_menu[] = array('title' => $gXpLang['my_account'] ,'link' => 'account.php');
}
$main_menu[] = array('title' => $gXpLang['contact_us'], 'link' => 'contact.php');
$main_menu[] = array('title' => $gXpLang['create_account'], 'link' => 'register.php');
$main_menu[] = $login ? array('title' => $gXpLang['logout'], 'link' => 'logout.php?action=logout') : array('title' => $gXpLang['affiliate_login'], 'link' => 'login.php');


$context_menu = array(
0 => array('title' => $gXpLang['general_statistics'], 'link' => 'statistics.php'),
1 => array('title' => $gXpLang['payment_history'] ,'link' => 'payments.php'),
2 => array('title' => $gXpLang['commission_details'] ,'link' => 'commission-details.php'),
3 => array('title' => $gXpLang['edit_myaccount'] ,'link' => 'edit-account.php'),
//                      4 => array('title' => 'Rising te affiliate funds','link' => 'fund-raising.php'),
);

$marketing_menu = array(
//0 => array('title' => $gXpLang['banners'], 'link' => 'banners.php'),
//1 => array('title' => $gXpLang['text_ads'] ,'link' => 'text-ads.php'),
//2 => array('title' => $gXpLang['text_links'] ,'link' => 'text-links.php'),
//3 => array('title' => $gXpLang['email_links'] ,'link' => 'email-links.php'),
4 => array('title' => 'Deals' ,'link' => 'deals.php'),
5 => array('title' => $gXpLang['logout'], 'link' => 'logout.php?action=logout'),
);

$gXpSmarty->assign_by_ref('xpurl', $gXpConfig['xpurl']);
$gXpSmarty->assign_by_ref('marketing_items', $marketing_menu);
$gXpSmarty->assign_by_ref('context_items', $context_menu);
$gXpSmarty->assign_by_ref('main_items',$main_menu);
$gXpSmarty->assign_by_ref('id', $aff['id']);
$gXpSmarty->assign_by_ref('stat', $stat);
$gXpSmarty->assign_by_ref('images', $images);
$gXpSmarty->assign_by_ref('path', $path);
$gXpSmarty->assign_by_ref('scripts',$scripts);
$gXpSmarty->assign_by_ref('username', $username);
$gXpSmarty->assign_by_ref('aff', $aff);
$gXpSmarty->assign_by_ref('login', $login);
?>
