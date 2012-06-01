<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
	
$gProtected = TRUE; 

require_once('header.php');

$title = $gXpLang['site_title'].' - '.$gXpLang['aff_area'];
$description = $gXpLang['desc_account'];
$keywords = $gXpLang['keyword_account'];

$icons = array(
				0 => array('path' => 'banners.php','img' => $gXpConfig['xpurl'].'templates/'.$gXpConfig['tmpl'].'/images/config.png', 'text' => $gXpLang['banners']),
				1 => array('path' => 'text-ads.php','img' => $gXpConfig['xpurl'].'templates/'.$gXpConfig['tmpl'].'/images/user.png', 'text' => $gXpLang['text_ads']),
				2 => array('path' => 'text-links.php','img' => $gXpConfig['xpurl'].'templates/'.$gXpConfig['tmpl'].'/images/addedit.png', 'text' => $gXpLang['text_links']),
				3 => array('path' => 'email-links.php','img' => $gXpConfig['xpurl'].'templates/'.$gXpConfig['tmpl'].'/images/langmanager.png', 'text' => $gXpLang['email_links']),
//				4 => array('path' => 'custom-links.php','img' => $gXpConfig['xpurl'].'templates/'.$gXpConfig['tmpl'].'/images/menu.png', 'text' => 'Custom Keyword Links'),
			);
			
$control_panel = $gXpLayout->print_control_panel($icons);			

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('xproot', $gXpConfig['xpurl']);
$gXpSmarty->assign_by_ref('control_panel', $control_panel);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("account.tpl");

?>
