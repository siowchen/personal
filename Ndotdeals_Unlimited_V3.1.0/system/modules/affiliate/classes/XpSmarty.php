<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('smarty/Smarty.class.php');

class gXpSmarty extends Smarty
{ 
	function gXpSmarty() 
	{ 
		global $gXpConfig;

		$this->Smarty(); 
		$this->template_dir = $gXpConfig['templates'].$gXpConfig['tmpl'].'/';
		$this->compile_dir  = 'tmp/'; 
		$this->config_dir   = 'configs/'; 
		$this->cache_dir    = 'cache/'; 

		$this->caching = false; 
	} 
} 

$gXpSmarty = new gXpSmarty();

/** global arrays used in the script **/
$gXpSmarty->assign_by_ref('config', $gXpConfig);
$gXpSmarty->assign_by_ref('lang', $gXpLang);
//$gXpSmarty->assign_by_ref('editor', $gXpEditor);

/** register modifiers **/
$gXpSmarty->register_modifier("sslash", "stripslashes");

/** register functions **/
$gXpSmarty->register_function("navigation", "navigation");
$gXpSmarty->register_function("convert_str", "convert_str");
$gXpSmarty->register_function("text_to_html", "text_to_html");
$gXpSmarty->register_function("in_array_exist", "in_array_exist");
$gXpSmarty->register_function("array_to_lang", "array_to_lang");
$gXpSmarty->register_function("print_stars", "print_stars");
$gXpSmarty->register_function("print_pagerank", "print_pagerank");

$gXpSmarty->assign('templates', $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['templates'].$gXpConfig['tmpl']);
$gXpSmarty->assign('images', "{$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['templates']}{$gXpConfig['tmpl']}/images/");
//$gXpSmarty->assign('adsense', $gXpLayout->print_adsense());
?>
