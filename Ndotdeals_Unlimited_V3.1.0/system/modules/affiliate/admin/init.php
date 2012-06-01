<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('../includes/config.inc.php');
require_once('../classes/XpDb.php');
require_once('../classes/XpAdmin.php');
require_once('../classes/XpConfig.php');
require_once('util.php');
//require_once(DOCUMENT_ROOT.'/includes/functions.php');

//echo $_SESSION["userid"];
$gXpConf =& new Configuration();

$gXpAdmin =& new AdminXp();
$gXpAdmin->mPrefix = $gXpConfig['prefix'];

$gXpLang =& $gXpAdmin->getLang($gXpConfig['lang']);
//$gXpConfig =& $adminXp->getConfig();
?>
