<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');
$gDesc = $gXpLang['pay_affiliates'];
$gPage = $gXpLang['pay_affiliates'];
$gPath = 'pay-affiliates';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$commissions =& $gXpAdmin->getAccountsToBePaid($start, ITEMS_PER_PAGE);
//print_r($commissions);
$commissions_num = count($gXpAdmin->getAccountsToBePaid(0, 0));





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
					<th style="padding:6px;"><?php echo $gXpLang['sales']; ?></th>
					<th style="padding:6px;">Balance commission</th>
					<th style="padding:6px;"><?php echo $gXpLang['process']; ?></th>
				</tr>
<?php
	for($c_i=0; $c_i<count($commissions); $c_i++)
	{
	
		$account = $gXpAdmin->getAffiliateById($commissions[$c_i]['aff_id']);

		//print_r($account);

                $RFund = $gXpAdmin->getRaisingFund($commissions[$c_i]['aff_id']);
                
                $sales = $gXpAdmin->getAccountToBeComm($commissions[$c_i]['aff_id']);
                
                //print_r($sales);
                if($RFund[$c_i]['raising_amount']>0)
                {
                       $bal = $sales['Total'];
                       $sales = $gXpAdmin->getSales($commissions[$c_i]['aff_id']);

                        for($i=0;$i<=count($sales);$i++)
                        {
                              $com[] = $sales[$i]['payout']; 
                        }
                        $Commis = array_sum($com);
                        
                        for($i=0;$i<=count($FRaising);$i++)
                        {
                                $Ramount[] = $FRaising[$i]['raising_amount']; 
                        }
                        $Commis = array_sum($com);
                        $new_Ramount = array_sum($Ramount);
                }
                else
                {
                        $bal = format($commissions[$c_i]['Total']*$gXpConfig['payout_percent']/100);
                        $sales = $gXpAdmin->getSales($commissions[$c_i]['aff_id']);
                }

?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><?php echo $account['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $account['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><?php echo $account['username'];?></a></td>
					<td><?php
						for($i=0;$i<count($sales);$i++)
						{
							$sales[$i]['payment'];
							$sale[] = $sales[$i]['payment'];
						}
						echo $sales_amount = array_sum($sale);
						
						?></td>
					<td><?php echo $bal;?></td>
					<td><a href="<?php echo DOCROOT;?>system/modules/gateway/paypal/MassPayReceipt.php?type=pay_affiliates&uid=<?php echo $account['id'];?>&amt=<?php echo $bal;?>&sales=<?php echo $sales_amount ;?>"><?php echo $gXpLang['continue']; ?></a></td>
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
	$url = "pay-affiliates.php?items=".ITEMS_PER_PAGE;
	navigation($commissions_num, $start, count($commissions), $url, ITEMS_PER_PAGE);

?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
