<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['approval_commissions'];
$gPath = 'approve-commissions';
$gDesc = $gXpLang['approve_commissions'];

require_once('header.php');
$user = (INT)$_GET['user']>0 ? (INT)$_GET['user'] : '';
unset($_GET['user']);

if($_GET['mg'])
{

	switch ($_GET['mg'])
	{
		case 1:
			//$msg .= $gXpLang['status_approved'];
			set_response_mes(1, $gXpLang['status_approved']); 
			header("Location: pay-affiliates.php");
			break;
		case 2:
			//$msg .= $gXpLang['status_declined'];
			set_response_mes(1, $gXpLang['status_declined']); 
			header("Location: commissions.php");
			break;
		case 3:
			$gDesc = $gXpLang['current_commissions'];
			$gPage = $gXpLang['current_commissions'];
			if($user>0)
			{
				$userData = $gXpAdmin->getAffiliateById($user);
				$gPath = '<a href="javascript: history.back(1);">current-commissions</a>&nbsp;&#187;&nbsp;<span style="text-transform: lowercase;">'.$gXpLang['affiliate']."</span> ".$userData['username'];
			}
			else
			{
				$gPath = 'current-commissions';
			}
			break;
		default:
			//$msg = $gXpLang['msg_commission_success'];
			set_response_mes(1, $gXpLang['msg_commission_success']); 
			header("Location: commissions.php");
	}
}
if($user>0)
{
	$gDesc = $gXpLang['current_commissions'];
	$gPage = $gXpLang['current_commissions'];
	$userData = $gXpAdmin->getAffiliateById($user);
	$gPath = '<a href="javascript: history.back(1);">current-commissions</a>&nbsp;&#187;&nbsp;<span style="text-transform: lowercase;">'.$gXpLang['affiliate']."</span> ".$userData['username'];
}


$items = (int)$_GET['items'];
$items = $items ? $items : 50 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$commissions_num =& $gXpAdmin->getNumCommissions(1, $user);

$commissions =& $gXpAdmin->getCommissionsByStatus(1, $start, ITEMS_PER_PAGE, $user);

?><script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>

<br />
	
<?php
print_box($error, $msg);
?>
		<form action="manage-commission.php<?php echo ($user>0? "?user=".$user : ""); ?>" method="post" name="adminForm">

			<table class="adminlist">

				<tr>
					<th width="20" style="padding:6px;">ID</th>
					<th width="20" style="padding:6px;"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($commissions);?>);" /></th>
					<th align="left" style="padding:6px;" nowrap><?php echo $gXpLang['affiliate_name']; ?></th>
					<th width="10%" style="padding:6px;" nowrap><?php echo $gXpLang['order_number']; ?></th>
					<th width="11%" style="padding:6px;" nowrap><?php echo $gXpLang['sale_amount']; ?></th>
					<th width="11%" style="padding:6px;" nowrap><?php echo $gXpLang['commission_amount']; ?></th>
					<th width="11%" style="padding:6px;" nowrap><?php echo $gXpLang['date']; ?></th>
					<th class="empty" style="padding:6px;"><?php echo $gXpLang['status']; ?></th>
					<th></th>
					<th width="11%" nowrap style="padding:6px;"><?php echo $gXpLang['action']; ?></th>
				</tr>
<?php
for($i=0; $i<count($commissions); $i++)
{
	$aff = $gXpAdmin->getAffiliateById($commissions[$i]['aff_id']);
	switch ($commissions[$i]['approved'])
	{
		case 0:
			$bgcolor = "bgcolor='#FFBBBB'";
			$status = $gXpLang['status_disapproved'];
			break;
		case 1:
			$bgcolor = "bgcolor='#FFF4CD'";
			$status = $gXpLang['approval'];
			break;
		case 2:
			$bgcolor = "bgcolor='#BBFFBB'";
			$status = $gXpLang['status_approved'];
			break;
	}
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td align="center"><?php echo $commissions[$i]['id'];?></td>
					<td align="center"><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $commissions[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td align="left"><a href="manage-account.php?id=<?php echo $aff['id'];?>" title="<?php  echo $gXpLang['view_details']; ?>"><?php echo $aff['username'];?></a></td>
					<td align="left"><?php echo $commissions[$i]['order_number'];?></td>
					<td align="left"><?php echo $commissions[$i]['payment'];?></td>
					<td align="left"><?php echo $commissions[$i]['payment']*$gXpConfig['payout_percent']/100;?></td>
					<td align="left"><?php echo $commissions[$i]['date'];?></td>
					<td width="50" <?php echo $bgcolor; ?> style="text-transform:lowercase;"><?php echo $status;?></td>
					<td></td>
					<td align="left"><a href="manage-commission.php?id=<?php echo $commissions[$i]['id']; if($user>0){echo "&user=".$commissions[$i]['aff_id']."&mg=3";} ?>"><?php  echo $gXpLang['small_view_details']; ?></a></td>
				</tr>
<?php
}
	if(count($commissions)==0)
	{ ?>
		<tr class="row0">
			<td colspan="10" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none;float:left;clear:both;">
			<select name="task" id="action">
				<option value="">-- select --</option>
				<option value="approve"><?php echo $gXpLang['approve'];?></option>
				<option value="decline"><?php echo $gXpLang['decline'];?></option>
			</select>
			<input type="submit" value=" Go " style="margin-top:5px;" class="mt5"/>
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" name="id" value="<?php echo $commission[$i]['id'];?>" />

		</form>
<div style="height: 5px; clear:both"></div>

<?php
$url = "commissions.php?items=".ITEMS_PER_PAGE.($user>0? "&user=".$user:"");
navigation($commissions_num, $start, count($commissions), $url, ITEMS_PER_PAGE);
?>
		
<!--main part ends-->
	
<?php
require_once('footer.php');
?>
