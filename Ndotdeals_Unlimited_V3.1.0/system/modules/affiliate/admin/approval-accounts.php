<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['approval_accounts'];
$gPath = 'approve-accounts';
$gDesc = $gXpLang['approve_affiliate'];

require_once('header.php');

$ids = $_POST['cid'];

if($_POST['task'] == 'approve')
{
	$gXpAdmin->approveAccounts($ids);
	//$msg = $gXpLang['msg_account_success_approved'];
	set_response_mes(1,$gXpLang['msg_account_success_approved']); 
	header("Location: approval-accounts.php"); 
	
}
elseif($_POST['task'] == 'decline')
{
	$gXpAdmin->declineAccounts($ids);
	//$msg = $gXpLang['msg_account_success_delete'];
	set_response_mes(1,$gXpLang['msg_account_success_delete']); 
	header("Location: approval-accounts.php"); 
}

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

$query_items = '';
if ((INT)$_GET['items']>0)
{
	$query_items = '&items='.(INT)$_GET['items'];
}

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$accounts_num =& $gXpAdmin->getNumAccounts(0);

$accounts =& $gXpAdmin->getAccountsByStatus(1, $start, ITEMS_PER_PAGE);

?>
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
		<form action="approval-accounts.php<?php echo str_replace("&","?",$query_items)?>" method="post" name="adminForm" >

			<table class="adminlist" style="text-align:center;width:775px;">

				<tr>
					<th width="20" align="center"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($accounts);?>);" /></th>
					<th>ID</th>
					<th><?php echo $gXpLang['username']; ?></th>
					<th><?php echo $gXpLang['real_name']; ?></th>
					<th><?php echo $gXpLang['email']; ?></th>
					<th class="empty"><?php echo $gXpLang['status']; ?></th>
					<th><?php echo $gXpLang['view']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($accounts); $i++)
	{
?>	
<?php 
                                        $countrow += 1;
	                                if($countrow % 2 == 1 ){
		                                echo '<tr style=" background:#EDEDED;">';
	                                }else{
		                                echo '<tr>';
	                                }
	                                 ?>
					<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $accounts[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><?php echo $accounts[$i]['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php  echo $gXpLang['edit_account']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
					<td><?php echo $accounts[$i]['firstname'].' '.$accounts[$i]['lastname'];?></td>
					<td><a href="mailto:<?php echo $accounts[$i]['email'];?>"><?php echo $accounts[$i]['email'];?></a></td>
					<?php
					switch ($accounts[$i]['approved'])
					{
						case 0:
							$bgcolor = "bgcolor='#FFBBBB'";
							$status = $gXpLang['status_disapproved'];
							break;
						case 1:
							$bgcolor = "bgcolor='#FFF4CD'";
							$status = $gXpLang['status_pending'];
							break;
						case 2:
							$bgcolor = "bgcolor='#BBFFBB'";
							$status = $gXpLang['status_approved'];
							break;
					}
					?>
					<td width="50" <?php echo $bgcolor; ?>><?php echo $status;?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>"><?php echo $gXpLang['full_details']; ?></a></td>
				</tr>
<?php
	}
	if(count($accounts)==0)
	{ ?>
		<tr class="row0">
			<td colspan="8" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none">
			<select name="task" id="action">
				<option value="">-- select --</option>
				<option value="approve"><?php echo $gXpLang['approve'];?></option>
				<option value="decline">Decline</option>
			</select>
			<input type="submit" style="margin-top:5px;" class="ml10 fl mt5" value=" Go " />
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />

		</form>
<div style="height: 5px; clear:both;"></div>
<?php
		$url = "approval-accounts.php?items=".ITEMS_PER_PAGE;
		navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);
?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
