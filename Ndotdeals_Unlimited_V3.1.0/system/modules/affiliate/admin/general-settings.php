<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$category	= 1;
$group		= 1;

$filename = "../includes/config.inc.php";

if ($_POST['task'] == 'save')
{
	if($gXpConf->saveConfig($_POST['param']))
	{		
		header("Location: general-settings.php?s=1");
		exit;
	}
	else
	{		
		header("Location: general-settings.php?s=2");
		exit;
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}
require_once('header.php');
switch($_GET['s'])
{
	case 1:
		//$msg = $gXpLang['msg_configuration_saved'];
		set_response_mes(1, $gXpLang['msg_configuration_saved']);
		header("Location: general-settings.php");
		break;
	case 2:
		//$msg = $gXpLang['msg_config_cannot_be_writing'];
		set_response_mes(-1, $gXpLang['msg_config_cannot_be_writing']);
		header("Location: general-settings.php");
		$error = 'error';
		break;
}
$gDesc = $gXpLang['manage_general_settings'];
$gPage = $gXpLang['general_settings'];
$gPath = 'general-settings';

$buttons = array(0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']));


?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#general-settings").validate();});
</script>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />

<?php
//	print_box($type, $msg);
?>	

<!--TAB PANEL STARTS-->
	<form action="general-settings.php" id="general-settings" method="post" name="adminForm">

<!-- TAB SITE STARTS-->
<fieldset class="field" style="margin-left:10px;">         
        <legend class="legend">GENERAL DETAILS</legend>
<?php
	print_box($error, $msg);
	if (!is_writable('../includes/config.inc.php'))		
	{
		$type = 'error';
		$cfile = '<span style="font-weight: bold; color: #6F3E44;"> '.$gXpLang['unwriteable'].'</span>';
		print_box($type, 'config.inc.php is : '.$cfile);
	}

	$groups =& $gXpAdmin->getGroupsByCategory($category);
	$i=1; //Group 2
	
	tab_page_conf($groups[$i], $group, $i);
?>
<!--TAB SITE ENDS-->
			
<!--TAB LOCALE STARTS-->

<!--</div>		-->
</fieldset>
		<input type="hidden" name="task" value=""/>
		<div style="margin-top:10px;margin-left:10px;"><input class="button" onclick="document.adminForm.task.value='save'" type="submit" value="<?php echo $gXpLang['save']; ?>"></div>	  	
	</form>

<script  type="text/javascript" src="<?php echo $gXpConfig['xpurl'];?>includes/js/overlib_mini.js"></script>

<?php
require_once('footer.php');
?>
