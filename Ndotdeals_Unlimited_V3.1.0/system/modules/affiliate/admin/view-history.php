<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['view_history'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/accounting-history.php">accounting-history</a>&nbsp;&#187;&nbsp;payment-history';
$gDesc = $gXpLang['view_payment_history'];

$buttons = array(0 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']));
				
unset($id);
$id = $_GET['id'];

if($_POST['task'] == 'archive')
{
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: accounting-history.php");
}

require_once('header.php');

$account = $gXpAdmin->getAffiliateById($id);
$payments = $gXpAdmin->getPayments($id);
?>
<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_11").slideToggle(); 
document.getElementById("left_menubutton_11").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>
<br />
	
<form action="view-history.php" method="post" name="adminForm">

		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="60%">
				<table class="adminlist" style="width:400px!important;">
				<tbody>
				<tr>
					<th>ID</th>
					<th><?php echo $gXpLang['username']; ?></th>
					<th><?php echo $gXpLang['date']; ?></th>
					<th><?php echo $gXpLang['amount'].'('.$_SESSION['CURRENCY'].')'; ?></th>
					<th><?php echo $gXpLang['details']; ?></th>
				</tr>
				
				<tr>
					<td><?php echo $account['id'];?></td>
					<td><?php echo $account['username'];?></td>
				</tr>

				<?php
				for($i=0;$i<count($payments);$i++)
				{
				?>
				<tr style="font-weight: bold;" class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td colspan="2"></td>
					<td><?php echo $payments[$i]['date'];?></td>
					<td><?php echo '$'.$payments[$i]['commission'].' USD';?></td>
					<td></td>
				</tr>
				<?php
					$sales = $gXpAdmin->getArchivedSales($payments[$i]['uid']);
					for($j=0;$j<count($sales);$j++)
					{
					?>
					<tr>
						<td colspan="3"></td>
						<td>$<?php echo format($sales[$j]['payment']*$gXpConfig['payout_percent']/100);?> USD</td>
						<td><a href="sale-details.php?id=<?php echo $sales[$j]['id'];?>">View</a></td>
					</tr>
					<?php
					}
				
				}
				$total = $gXpAdmin->getTotalPayments($id);
				?>
				<tr>
				        <td colspan="2"></td>
					<td colspan="1" style="padding-top:25px!important;color:#010101;font:bold 12px arial;"><?php echo $gXpLang['total_amount']; ?></th>
					<td style="padding-top:25px!important;color:#010101;font:bold 12px arial;">$<?php echo $total;?> USD </td>
					<td></td>
				</tr>

				</tbody></table>
			</td>
			<td valign="top" width="40%">
<fieldset style="width:350px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['hints']; ?></legend>
		<table class="adminform">
			<tbody>
				<tr>
					<td><?php echo $gXpLang['here_will be_some_hints']; ?></td>
				</tr>
	<tr>
					<td>Commission:</td>
					<td><?php echo $_SESSION['CURRENCY'].format(($commission['Total']*$gXpConfig['payout_percent'])/100);?></td>
				</tr>
				<tr>
					<td>Number of Sales:</td>
					<td><?php echo $commission['Sales'];?></td>
				</tr>
				<tr style="font-weight: bold;">					
					<th colspan="2">Sales In This Payment:</th>
				</tr>
				<tr>					
					<?php
						for($i=0;$i<count($sales);$i++)
						{
							echo "<tr><td>{$sales[$i]['date']}</td><td>$_SESSION[CURRENCY]{$sales[$i]['payment']}</td></tr>";
						}
					?>

				</tr>
				<tr style="font-weight: bold;">
					<td>Earned Commission:</td>
					<td><?php echo $_SESSION['CURRENCY'].format(($commission['Total']*$gXpConfig['payout_percent'])/100);?></td>
				</tr>
			</tbody>
		</table>
</fieldset>
		</td>
		</tr>
		</tbody></table>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		<input name="sales" value="<?php echo $commission['Total'];?>" type="hidden" />
		<input name="commission" value="<?php echo ($commission['Total']*$gXpConfig['payout_percent'])/100;?>" type="hidden" />

		<input name="task" value="" type="hidden" />
</form>
<table>
<!--				<tr>
					<td style="text-align: center;">
					<?php
				   	if ( $account['paypal_email'] )  
					{ 
					?>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="amount" value="<?php echo format(($commission['Total']*$gXpConfig['payout_percent'])/100);?>">
							<input type="hidden" name="item_number" value="Affiliate_Payment_<?php echo date("Y-m-d");?>">
							<input type="hidden" name="item_name" value="<?php echo $gXpConfig['site'];?> Affiliate Payment">
							<input type="hidden" name="business" value="<?php echo $account['paypal_email'];?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="submit" name="submit" value="Pay Using PayPal">
						</form>
					<? 
					} 
					else 
					{ 
					?>
						<font color=#CC0000>PayPal Payment Not Available</font>
					<?php
					}
					?>
					</td>
					</tr>-->
</table>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
