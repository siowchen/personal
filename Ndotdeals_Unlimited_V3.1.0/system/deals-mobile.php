<?php  ob_start(); ?>
<?php 

/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
 #-------------------------------------------------------------------------------
 require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
 #-------------------------------------------------------------------------------
 
 $_SESSION["mobile_access"] = "mobile";
 url_redirect(DOCROOT);

?>
<?php ob_flush(); ?>
