<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$stitle = str_replace("http://", "", $gXpConfig['base']);
$stitle = str_replace("/", "", $stitle);

$adinfo = $gXpAdmin->getAdById((INT)$_GET['ad']);
$adpid = (INT)$_GET['pid'];

$title = $adinfo['title'];
$text = $adinfo['content'];

$base_url = $gXpConfig['xpurl'];

print "document.write(\"<div><table border=0 cellspacing=0 bgcolor=\"+XP_OutlineColor+\">\");";
print "document.write(\"<tr><td><div align=center><center><div align=center>\");";
print "document.write(\"<table border=0 cellspacing=0 width=\"+XP_BoxWidth+\" cellpadding=2 height=\"+XP_BoxHeight+\" bgcolor=\"+XP_TextBackgroundColor+\">\");";
print "document.write(\"<tr><td width=100% height=5% bgcolor=\"+XP_OutlineColor+\">\");";
print "document.write(\"<font color=\"+XP_TitleTextColor+\"><b id='title_ads'>$title</b></font></td></tr>\");";
print "document.write(\"<tr><td width=100% height=95% valign=top\");";
?>

document.write(' onClick=location.href=\'<?php echo $base_url;?>xp.php?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>\' style=cursor:hand onmouseover=\"self.status=\'Visit <?=$stitle?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');
document.write('<a href=\'<?=$base_url?>xp.php?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>\' onmouseover=\"self.status=\'Visit <?php echo $stitle;?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');

<?php
print "document.write(\"<font color=\"+XP_LinkColor+\"><u>$stitle</u></font></a>\");";
print "document.write(\"<BR><font id='content_ads' color=\"+XP_TextColor+\">$text</font></td></tr></table></div></td></tr></table></center></div>\");";

?>
