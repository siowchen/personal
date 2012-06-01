<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['admin_manager'];
$gPath = 'admin-manager';
$gDesc = $gXpLang['manage_administrators'];
require_once('header.php');
switch($_GET['sgn'])
{
	case 1: 
			//$msg = $gXpLang['msg_admin_success_added'];
			set_response_mes(1, $gXpLang['msg_admin_success_added']);
			header("Location: admin-manager.php"); 
			break;
	case 2: 
			//$msg = $gXpLang['msg_cannot_admin_modify'];
			set_response_mes(1,$gXpLang['msg_cannot_admin_modify']); 
			header("Location: admin-manager.php"); 
			break;
	case 3: 
			//$msg = $gXpLang['msg_select_admin2edit'];
			set_response_mes(1, $gXpLang['msg_select_admin2edit']); 
			header("Location: admin-manager.php"); 
			break;
	case 4: 
			//$msg = $gXpLang['msg_select_admin2delete'];
			set_response_mes(1, $gXpLang['msg_select_admin2delete']); 
			header("Location: admin-manager.php"); 
			break;
	case 5: 
			//$msg = $gXpLang['msg_admin_success_deleted'];
			set_response_mes(1, $gXpLang['msg_admin_success_deleted']); 
			header("Location: admin-manager.php"); 
			break;
	case 6: 
			//$msg = $gXpLang['msg_admins_success_deleted'];
			set_response_mes(1, $gXpLang['msg_admins_success_deleted']); 
			header("Location: admin-manager.php"); 
			break;
	default: ;
}

	

if($_GET['action'] == 'primary')
{
	// Check the username already taken
	/* $queryStr = mysql_query("SELECT * FROM `aff_affiliates` WHERE username='".$data['username']."'") or die(mysql_error());
	if(mysql_num_rows($queryStr)>0)
	{	
		set_response_mes(1, $gXpLang['msg_new_admin_assigned']); 
		header("Location: admin-manager.php"); 
	} */
	
	$gXpAdmin->makeAdminPrimary($_GET['aid']);
	//$msg = $gXpLang['msg_new_admin_assigned'];
	set_response_mes(1, $gXpLang['msg_new_admin_assigned']); 
	header("Location: admin-manager.php"); 
}
   
$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));
	

	
$admins = $gXpAdmin->getAdmins();
?>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />

<?php print_box($error, $msg);?>

		<form action="manage-admin.php" method="post" name="adminForm">
		
			<table style="text-align: left; width:100%;float:left;clear:both;">
	<fieldset class="field" style="margin-left:10px;">         
        <legend class="legend">ADMIN MANAGER SETTING</legend>
				<tr>
					<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($admins);?>);" /></th>
					<th class=empty fl ><?php echo $gXpLang['username']; ?></th>
					<th></th>
					<th class="fl"><?php echo $gXpLang['last_logged']; ?></th>
					<th><?php echo $gXpLang['action']; ?></th>
				</tr>
				
<?php
	for($i=0; $i<count($admins); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $admins[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><a href="manage-admin.php?id=<?php echo $admins[$i]['id'];?>" title="<?php  echo $gXpLang['edit_account']; ?>"><?php echo $admins[$i]['username']; if($admins[$i]['primary']) echo '<b style="color: #000;">&nbsp;('.$gXpLang['primary_account'].')</b>' ;?></a></td>
					<td><?php echo ($admins[$i]['primary']) ? '' : '<a href="admin-manager.php?action=primary&amp;aid='.$admins[$i]['id'].'"><b>make primary</b></a>' ;?></td>
					<td><?php echo $admins[$i]['date'].' ['.$admins[$i]['time'].']';?></td>
					<td><a href="manage-admin.php?id=<?php echo $admins[$i]['id'];?>"><img src="images/edit.gif" border="0" /></a></td>
				</tr>
<?php
	}
	if(count($admins)==0)
	{ ?>
		<tr class="row0">
			<td colspan="5" align="center">No Items</td>
		</tr>
	<?php
	}
?>

			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none;float:left;">
			<select name="action" id="action" style="margin:0 0 0 10px;" class="fl">
				<option value="">-- select --</option>
				<option value="delete"><?php echo $gXpLang['delete'];?></option>
			</select>
			<input type="submit" value=" Go " onclick="return dyId('action').value == 'delete'? admin_del_confirm(): true; " class="fl ml10 mt2" />
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" name="task" value="" />
</fieldset>
		</form>
<div style="height: 5px;"></div>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
