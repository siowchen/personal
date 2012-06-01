<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$category	= 1;
$group		= 1;
require_once('header.php');
$filename = "../includes/config.inc.php";

if ($_POST['task'] == 'save')
{
	if($gXpConf->saveConfig($_POST['param']))
	{
		//$msg = $gXpLang['msg_configuration_saved'];
		set_response_mes(1, $gXpLang['msg_configuration_saved']); 
		header("Location: site-configuration.php");
	}
	else
	{
		//$msg = $gXpLang['msg_config_cannot_be_writing'];
		set_response_mes(-1,  $gXpLang['msg_config_cannot_be_writing']); 
		header("Location: site-configuration.php");
		$error = 'error';
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}

$gDesc = $gXpLang['manage_website_configuration'];
$gPage = $gXpLang['site_configuration'];
$gPath = 'site-configuration';

$buttons = array(0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']));



?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#site-configuration").validate();});
</script>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />
<!--TAB PANEL STARTS-->
	<form action="site-configuration.php" id="site-configuration" method="post" name="adminForm">
  <fieldset class="field" style="margin-left:10px;">         
        <legend class="legend">SITE DETAILS</legend>
<?php
	//print_box($error, $msg);

	if (!is_writable('../includes/config.inc.php'))		
	{
		$type = 'error';
		$cfile = '<span style="font-weight: bold; color: #6F3E44;"> '.$gXpLang['unwriteable'].'</span>';
		print_box($type, 'config.inc.php is : '.$cfile);
	}
	
	$groups =& $gXpAdmin->getGroupsByCategory($category);
	$i=0;

	tab_page_conf($groups[$i], $group, $i);
?>  </fieldset>
	  	<input type="hidden" name="task" value=""/>
	  	<div style="margin:10px 0px 0px 10px;"><input class="button" onclick="document.adminForm.task.value='save'" type="submit" value="<?php echo $gXpLang['save']; ?>"></div>	  	
	</form>	

<script  type="text/javascript" src="<?php echo $gXpConfig['xpurl'];?>includes/js/overlib.js"></script>

<?php
require_once('footer.php');
?>
