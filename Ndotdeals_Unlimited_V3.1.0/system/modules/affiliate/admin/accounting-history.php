<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');
	
if($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}

$gDesc = $gXpLang['view_accounting_history'];
$gPage = $gXpLang['accounting_history'];
$gPath = 'accounting-history';

require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$commissions =& $gXpAdmin->getPreviousPayments($start, ITEMS_PER_PAGE);
$commissions_num = count($gXpAdmin->getPreviousPayments(0, 0));

?>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_7").slideToggle(); 
document.getElementById("left_menubutton_7").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<?php
	$total = $gXpAdmin->getTotalCommission();
?>

<br />
		<form action="accounting-history.php" method="post" name="adminForm">

			<table class="adminlist" style="text-align: left;">

				<tr>
					<th class="p6">ID</th>
					<th class="p6"><?php echo $gXpLang['username']; ?></th>
					<th class="p6"><?php echo $gXpLang['last_payment'].'('.$_SESSION['CURRENCY'].')'; ?></th>
					<th class="p6"><?php echo $gXpLang['average_payment'].'('.$_SESSION['CURRENCY'].')'; ?></th>
					<th class="p6"><?php echo $gXpLang['total_payments'].'('.$_SESSION['CURRENCY'].')'; ?></th>
					<th class="p6"><?php echo $gXpLang['process']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($commissions); $i++)
	{
		$account = $gXpAdmin->getAffiliateById($commissions[$i]['aff_id']);
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td><?php echo $account['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $account['id'];?>" title="<?php  echo $gXpLang['edit_account']; ?>"><?php echo $account['username'];?></a></td>
					<td><?php echo $commissions[$i]['commission'];?></td>
					<td><?php echo format($commissions[$i]['Avg']);?></td>
					<td><?php echo $commissions[$i]['Total'];?></td>
					<td><a href="view-history.php?id=<?php echo $account['id'];?>"><?php echo $gXpLang['view_history']; ?></a></td>
				</tr>
<?php
	}
	if(count($commissions)==0)
	{ ?>
		<tr class="row0">
			<td colspan="6" align="center">No Items</td>
		</tr>
	<?php
	}
?>
				<tr>
					<th colspan="4" align="center">Total Sales </th>
					<th colspan="2"><?php echo $_SESSION['CURRENCY'].$total;?></th>	
				</tr>
			</table>
			
			<input type="hidden" name="task" value="" />
		</form>
		
	<div style="height: 5px;clear:both;"></div>
<?php
	$url = "accounting-history.php?items=".ITEMS_PER_PAGE;
	navigation($commissions_num, $start, count($commissions), $url, ITEMS_PER_PAGE);

?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
