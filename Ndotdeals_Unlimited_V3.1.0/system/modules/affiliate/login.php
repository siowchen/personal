<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('header.php');

if(isset($_COOKIE['aff_id']) && isset($_COOKIE['aff_pwd'])){

		url_redirect(DOCROOT);

}

if ($_POST['authorize'])
{
	$valid = true;

	if (!$_POST['username'])
	{
		$valid = false;
		$msg .= "<li>{$gXpLang['editor_incorrect']}</li>";
	}
	
	if (!$_POST['password'])
	{
		$valid = false;
		$msg .= "<li>{$gXpLang['editorpsw_incorrect']}</li>";
	}

	if ($valid)
	{
		aff_login($_POST['username'], $_POST['password']);
	}

	//if($msg)
		//echo "<script>alert('Incorrect Username and Password, please try again'); document.location.href='login.php';</script>\n";
}


$title = 'Affiliate Program - Login';
$description = $gXpLang['desc_login'];
$keywords = $gXpLang['keyword_login'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('msg', $msg);

$gXpSmarty->assign_by_ref('title', $title);


$gXpSmarty->display("login.tpl");

?>
