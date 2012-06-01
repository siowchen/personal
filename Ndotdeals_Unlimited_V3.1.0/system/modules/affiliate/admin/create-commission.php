<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['create_commission_admin'];
$gDesc = $gXpLang['create_commission_admin'];
$gPath = 'create-commission';
require_once('header.php');
$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/edit_f2.gif', 'text' => $gXpLang['create']));
$sale = array_map('htmlentities',$_POST);
if( $sale['task'] == 'create' )
{
	$error = 0;
	
	if( !$sale['payout'] )
	{
		$error = 1;
		//$msg .= $gXpLang['payout_amount'].'<br/>';
		set_response_mes(-1, $gXpLang['payout_amount']); 
		header("Location: create-commission.php");
	}
	
	if( !$sale['payment'] )
	{
		$error = 1;
		//$msg .= $gXpLang['sale_amount'].'<br/>';
		set_response_mes(-1, $gXpLang['sale_amount']);
		header("Location: create-commission.php"); 
	}
	
	if( !$sale['order_number'] )
	{
		$error = 1;
		//$msg .=  $gXpLang['order_number'].'<br/>';
		set_response_mes(-1,$gXpLang['order_number']); 
		header("Location: create-commission.php");
	}
	
	if(!$error)
	{
		$gXpAdmin->addSale($sale);
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_new_approved_sale_generated');
		$gXpAdmin->sendAffiliateMail($tpl, Array((INT)$sale['aff_id']));
		//$msg .= $gXpLang['msg_sale_success_added'];
		set_response_mes(1, $gXpLang['msg_sale_success_added']); 
		header("Location: commissions.php");
	}
	else
		//$msg = $gXpLang['msg_pls_correct_fields'].":<br/> {$msg}";
		set_response_mes(-1, $gXpLang['msg_pls_correct_fields']); 
		header("Location: create-commission.php");
}
elseif( $sale['task'] == 'cancel' )
{
	header("Location: index.php");
}
	


$months = explode('|',$gXpLang['months_name']);

$date = getdate();				

$years = array(
				0 => '2006',
				1 => '2007',
				2 => '2008',
				3 => '2009',
				4 => '2010',
				5 => '2011',
				6 => '2012',
				7 => '2013',
				8 => '2014',
				9 => '2015',
				10 => '2016',
			);

$affiliates = $gXpAdmin->getAccounts(-1);
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#create_com").validate();});
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
		<form action="create-commission.php" id="create_com" method="post" name="adminForm">

		<table class="admintable">
		<tbody><tr>
			<td width="60%">
			<fieldset style="width:384px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['account_details']; ?></legend>
				<table class="adminform">
				<tbody>
				
				<tr class="row0">
					<td><?php echo $gXpLang['sale_date']; ?>:</td>
					<td width="75%">
						<select name="month">
							<?php
								for($i=1;$i<count($months); $i++)
								{
									$sel = ($i == $date['mon'])?'selected':'';
									$num = ($i<10)? '0' : '' ;
									echo '<option value="'.$num.$i.'" '.$sel.'>'.$months[$i].'</option>';
								}
							?>
						</select>
						<select name="day">
							<?php
								for($i=1;$i<32;$i++)
								{
									$sel = ($i == $date['mday'])? 'selected' : '' ;
									$num = ($i<10)? '0' : '' ;
									echo '<option value="'.$num.$i.'" '.$sel.'>'.$num.$i.'</option>';
								}
							?>
						</select>
						<select name="year">
							<?php
								for($i=0;$i<10;$i++)
								{
									$sel = ($years[$i] == $date['year'])? 'selected' : '' ;
									echo '<option value="'.$years[$i].'" '.$sel.'>'.$years[$i].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['affiliate']; ?>:</td>
					<td>
						<select name="aff_id">
							<?php
								for($i=0;$i<count($affiliates);$i++)
								{
									echo '<option value="'.$affiliates[$i]['id'].'">ID: '.$affiliates[$i]['id'].' - '.$gXpLang['username'].': '.$affiliates[$i]['username'].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['sale_amount']; ?>:</td>
					<td>
						<input class="inputbox required digits" name="payment" size="40" value="<?php echo $sale['payment'];?>" type="text" /><br /><br /><br />( <b>USD</b> )
					</td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['payout_amount']; ?>:</td>
					<td>
						<input class="inputbox  required digits" name="payout" size="40" value="<?php echo $sale['payout'];?>" type="text" /><br /><br /><br />( <b>USD</b> )
					</td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['order_number_transaction']; ?>:</td>
					<td><input class="inputbox  required digits" name="order_number" size="40" value="<?php echo $sale['order_number'];?>" type="text" /></td>
				</tr>
				</tbody></table>
				</fieldset>
				<input type="hidden" name="task" value=""/>
				<div style="margin:10px 0px 0px 10px;"><input class="button" onclick="document.adminForm.task.value='create'" type="submit" value="<?php echo $gXpLang['create']; ?>"></div>	  	
			</td>
			<td valign="top" width="40%">
<fieldset style="width:350px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['important_note']; ?></legend>
		<table class="adminform">
			<tbody>
				<tr>
					<td><?php echo $gXpLang['important_note_text']; ?></td>
				</tr>
			</tbody>
		</table>
		</fieldset>

		</td>
		</tr>
		</tbody></table>
		</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
