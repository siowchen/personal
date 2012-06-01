<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');
$gDesc = 'Raising Fund';
$gPage = 'Raising Fund';
$gPath = 'raising-fund';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$commissions =& $gXpAdmin->getAccountsToRaisingFund($start, ITEMS_PER_PAGE);
$commissions_num = count($gXpAdmin->getAccountsToRaisingFund(0, 0));
?>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />
		<form action="pay-affiliate.php" method="post" name="adminForm">

			<table class="adminlist" style="text-align:center;">

				<tr>
					<th style="padding:6px;">ID</th>
					<th style="padding:6px;"><?php echo $gXpLang['username']; ?></th>
					<th style="padding:6px;"><?php echo 'Commission'; ?></th>
					<th style="padding:6px;"><?php echo 'Raising Amount'; ?></th>
					<th style="padding:6px;"><?php echo $gXpLang['process']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($commissions); $i++)
	{
		$account = $gXpAdmin->getAffiliateById($commissions[$i]['aff_id']);

?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><?php echo $account['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $account['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><?php echo $account['username'];?></a></td>
					<td><?php echo $commissions[$i]['commission'];?></td>
					<td><?php echo $commissions[$i]['raising_amount'];?></td>
					<td>
					<a href="<?php echo DOCROOT;?>system/modules/gateway/paypal/MassPayReceipt.php?type=affiliates&uid=<?php echo $account['id'];?>&amt=<?php echo $commissions[$i]['commission'];?>"><?php echo $gXpLang['continue']; ?></a></td>
				</tr>
<?php
	}
	if(count($commissions)==0)
	{ ?>
		<tr class="row0">
			<td colspan="5" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>

			<input type="hidden" name="task" value="" />
		</form>

		<div style="height: 30px;clear:both;"></div>
<?php
	$url = "raising-fund.php?items=".ITEMS_PER_PAGE;
	navigation($commissions_num, $start, count($commissions), $url, ITEMS_PER_PAGE);

?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
