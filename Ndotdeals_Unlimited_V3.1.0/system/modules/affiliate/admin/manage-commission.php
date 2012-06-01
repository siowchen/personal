<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
require_once('./init.php');

$gPage = $gXpLang['manage_commission'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/commissions.php">approve-commissions</a>&nbsp;&#187;&nbsp;approve-commission';
$gDesc = $gXpLang['commission_status'];

$mg = (INT)$_GET['mg'];
$user = (INT)$_GET['user']>0 ? (INT)$_GET['user'] : '';
unset($_GET['user']);

if(3 == $mg && $user>0)
{
	$gDesc = $gXpLang['current_commissions'];
	$gPage = $gXpLang['current_commissions'];
	$userData = $gXpAdmin->getAffiliateById($user);
	$gPath = '<a href="javascript: history.back(1);">current-commissions</a>&nbsp;&#187;&nbsp;<span style="text-transform: lowercase;">'.$gXpLang['affiliate']."</span> ".$userData['username'];
}


if($_POST['task'] == 'approve')
{
	//check if we came from commissions.php page
	if(!$_POST['id'])
	{
		if(count($_POST['cid']) == 0)
		{
			$msg = '<a href="commissions.php">'.$gXpLang['msg_pls_go_back'].'</a>';
		}
		else
		{
			foreach($_POST['cid'] as $key=>$value)
			{
				$gXpAdmin->changeCommissionStatus($value, 2);
			}
			header("Location: commissions.php?mg=1".(($user>0)? "&user=".$user : ""));
		}
	}
	else
	{
		$gXpAdmin->changeCommissionStatus($_POST['id'], 2);
		header("Location: commissions.php?mg=1".(($user>0)? "&user=".$user : ""));
	}
}
elseif($_POST['task'] == 'decline')
{
	if(!$_POST['id'])
	{
		if(count($_POST['cid']) == 0)
		{
			$msg = '<a href="commissions.php">'.$gXpLang['msg_pls_go_back'].'</a>';
		}
		else
		{
			foreach($_POST['cid'] as $key=>$value)
			{
				$gXpAdmin->changeCommissionStatus($value, 0);//should delete the commission once it declined
			}
			header("Location: commissions.php?mg=2".(($user>0)? "&user=".$user : ""));
		}
	}
	else
	{
		$gXpAdmin->changeCommissionStatus($_POST['id'], 0);//should delete the commission once it declined
		header("Location: commissions.php?mg=2".(($user)? "&user=".$user : ""));
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: commissions.php");
}

$buttons = array(
0 => array('name'=>'approve','img'=> $gXpConfig['xpurl'].'admin/images/edit_f2.gif', 'text' => $gXpLang['approve']),
1 => array('name'=>'decline','img'=> $gXpConfig['xpurl'].'admin/images/delete_f2.gif', 'text' => $gXpLang['decline']),
2 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);

require_once('header.php');
?>

<br />

<?php
print_box($error, $msg);

$commission = $gXpAdmin->getCommissionById($_GET['id']);
$aff = $gXpAdmin->getAffiliateById($commission['aff_id']);
?>
		
<form action="manage-commission.php<?php echo ($user>0? "?user=".$user : ""); ?>" method="post" name="adminForm">

<?php
if(!$msg)
{
	print_box(0, ($user>0? '' : $gXpLang['commission_status_approval']));
?>
		
		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="60%">
			<fieldset style="width:384px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['commission_details']; ?></legend>
				<table class="adminform">
				<tbody>

				<tr>
					<td width="100"><?php echo $gXpLang['affiliate']; ?> ID:</td>
					<td width="85%"><?php echo $aff['id'];?></td>
				</tr>
				<tr>
					<td>
					<?php echo $gXpLang['affiliate_username']; ?>:
					</td>
					<td>
						<input name="username" class="inputbox" size="40" value="<?php echo $aff['username'];?>" type="text" readonly="readonly" />
					</td>
				</tr><tr>
					<td>
					<?php echo $gXpLang['order_number']; ?>:
					</td>

					<td>
						<input class="inputbox" name="email" size="40" value="<?php echo $commission['order_number'];?>" type="text" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $gXpLang['order_date']; ?>:
					</td>
					<td><?php echo $commission['date'];?></td>
				</tr>
				<tr>
					<td>
					<?php echo $gXpLang['order_time']; ?>:
					</td>
					<td><?php echo $commission['time'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['sale_total']; ?></td>
					<td><input class="inputbox" name="email" size="40" value="<?php echo $commission['payment'];?>" type="text" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['commissions']; ?></td>
					<td><input class="inputbox" name="commission" size="40" value="<?php echo $commission['payment']*$gXpConfig['payout_percent']/100;?>" type="text" /></td>
				</tr>

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				</tbody></table>
				</fieldset>
			</td>
			<td valign="top" width="40%">
<fieldset style="width:350px;border:1px solid #e9e9e9;padding:0px 0px 10px 10px;margin:10px 0px 10px 0px;">
			        <legend style="border:1px solid #e9e9e9;font:bold 12px arial;color:#333;padding:3px;"><?php echo $gXpLang['contact_Info']; ?></legend>
		<table class="adminform">
			<tbody>
				<tr>
					<td><?php echo $gXpLang['full_name']; ?></td>
					<td><?php echo "{$aff['firstname']} {$aff['lastname']}";?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['email']; ?></td>
					<td><a href="mailto:<?php echo $aff['email'];?>"><?php echo $aff['email'];?></a></td>
				</tr>
			</tbody>
		</table></fieldset>

		</td>
		</tr>
		</tbody></table>

<?php
}
?>
		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		<input name="task" value="" type="hidden" />
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
