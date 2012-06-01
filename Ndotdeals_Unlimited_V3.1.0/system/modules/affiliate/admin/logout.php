<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

setcookie('admin_name', $_COOKIE['admin_name'], time() - 3600, '/' );
setcookie( 'admin_pwd', $_COOKIE['admin_pwd'], time() - 3600, '/' );
header("Location: ./index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>

<head>
	<title><?php echo $gXpLang['logout']; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $gXpConfig['charset']; ?>" />
	<base href="<?php echo $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['admin']; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['admin']; ?>css/admin_login.css" />
</head>

<body>

<div class="content">
	<div class="top">
		<div class="top-left"></div>
		<!--<div class="top-right">
			<a href="<?php echo $gXpConfig['dir']; ?>"><img src="img/logo.gif" class="logo" title="Go to directory index" /></a>
			<div class="header"><?php echo $gCaption; ?></div>
		</div>
		</div>-->
	
	<p style="text-align: center;"><a href="<?php echo $gXpConfig['base'].$gXpConfig['xpdir'].$gXpConfig['admin']; ?>"><?php echo $gXpLang['click_here']; ?></a><?php echo $gXpLang['2go_admin_panel']; ?></p>
</div>

</body>
</html>

