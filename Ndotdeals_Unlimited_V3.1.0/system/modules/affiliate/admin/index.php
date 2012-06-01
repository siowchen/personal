<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

/** checks if install directory is removed **/
$directory = @opendir('../install/');

if ($directory)
{
	$error = true;
	$msg = $gXpLang['install_not_removed'];
}

$gNoBc = true;
$gDesc = $gXpLang['admin_welcome'];
$gPage = $gXpLang['admin_panel'];
$gTitle = $gXpLang['admin_panel'];

require_once('header.php');

require_once('footer.php');
?>
