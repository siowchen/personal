<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
require_once('./init.php');
$buttons = array(

0 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);
require_once('header.php');
$gPage = $gXpLang['manage_admin'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/admin-manager.php">admin-manager</a>&nbsp;&#187;&nbsp;manage-admin';
$gDesc = ($id) ? $gXpLang['edit'] : $gXpLang['add'];
$gDesc .= ' '.$gXpLang['administrator'];

$id = (INT)$_POST['cid'][0]>0? (INT)$_POST['cid'][0]:(INT)$_GET['id'];


if($_POST['task'] == 'edit')
{
	if(count($_POST['cid'])>1)
	{
		header("Location: admin-manager.php?sgn=2");
	}
	elseif( count($_POST['cid']) == 0 )
	{
		header("Location: admin-manager.php?sgn=3");
	}
	else
	{
		$data = $_POST;
		$data['id'] = $id;
		$gXpAdmin->editAdmin($data);
		//$msg = $gXpLang['msg_admin_success_modified'];
		set_response_mes(1, $gXpLang['msg_admin_success_modified']); 
		header("Location: manage-admin.php"); 
	}
}
elseif($_POST['action'] == 'delete')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: admin-manager.php?sgn=4");
	}
	else
	{
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			$gXpAdmin->deleteAdmin($_POST['cid'][$i]);
		}
		header("Location: admin-manager.php?sgn=".(count($_POST['cid'])>1? 6:5));
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: admin-manager.php");
}
elseif($_POST['task'] == 'add')
{
	$data = $_POST;
	$gXpAdmin->addAdmin($data);

	header("Location: admin-manager.php?sgn=1");
}

$buttons = array(
0 => array('name'=>($id)?'edit':'add','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => ($id)?$gXpLang['save']:$gXpLang['add']),
1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);


$admin = $gXpAdmin->getAdminById($id);
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#manage_admin").validate();});
</script>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />

<?php
print_box($error, $msg);
?>	
	
<style>
.errorvalid{float: none !important;}
</style>		
<form action="manage-admin.php" id="manage_admin" method="post" name="adminForm">
		<table class="admintable" width="100%" cellpadding="0" cellspacing="0">
		<tbody><tr>
			<td>
			
			<fieldset style="width:350px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['admin_account_details']; ?></legend>
				<table class="adminform" cellpadding="5" cellspacing="0">
				<tbody>
				
				<tr>
					<td valign="top" style="font-weight: bold;float:left;width:60px;text-align:left;"><?php echo $gXpLang['primary_account']; ?>:</td>
					<td valign="top" style="font-weight: bold;"><?php echo ($admin['primary']) ? $gXpLang['yes'] : $gXpLang['no'];?></td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo $gXpLang['username']; ?>:</td>
					<td valign="top">
						<input name="username" class="inputbox required" size="40" value="<?php echo $admin['username'];?>" type="text" <?php echo $id ? 'readonly="readonly"' : '' ;?> />
					</td>
				</tr><tr>
					<td valign="top" align="right"><?php echo $gXpLang['password']; ?>:</td>
					<td valign="top">
						<input class="inputbox required" name="password" size="40" value="<?php echo $admin['password'];?>" type="text" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo $gXpLang['email']; ?>:</td>
					<td valign="top"><input class="inputbox required" name="email" size="40" value="<?php echo $admin['email'];?>" title="<?php echo $gXpLang['valid_email']; ?>" type="text" /></td>
				</tr>

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>


				</tbody>
				</table>
				</fieldset>
				<input name="task" value="" type="hidden" />
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo ($id)?'edit':'add';?>'" type="submit" value="<?php echo ($id) ? $gXpLang['save'] : $gXpLang['add']; ?>"></div>	  	
			</td>
			<td style="vertical-align: top; margin: 0; padding: 0;">
                       <fieldset style="width:350px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['account_statistics']; ?></legend>
				<table class="adminform" cellpadding="0" cellspacing="0">
				
				<tr>
					<td><?php echo $gXpLang['last_logged']; ?>:</td>
					<td><?php echo $admin['date'].' '.$admin['time'];?></td>
				</tr>
		</table>
		
		</fieldset>

		</td>
		</tr>
		</tbody>
		</table>
		<input name="cid[]" value="<?php echo $id;?>" type="hidden" />

</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
