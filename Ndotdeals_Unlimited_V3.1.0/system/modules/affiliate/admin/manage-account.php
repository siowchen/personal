<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('./init.php');

$gPage = $gXpLang['manage_accounts'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/accounts.php">account-manager</a>&nbsp;&#187;&nbsp;manage-account';
$gDesc = $gXpLang['manage_affiliate_account'];

unset($id);
$id = $_GET['id'];

$query_items = '';
if ((INT)$_GET['items']>0)
{
	$query_items = '&items='.(INT)$_GET['items'];
}
if (('disapprove' == $_POST['action']) || ('approve' == $_POST['action']) || ('pending' == $_POST['action']))
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: accounts.php?sgn=3".$query_items);
	}
	else
	{
		$ids = Array();
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			if ((INT)$_POST['cid'][$i]>0)
			{
				switch ($_POST['action'])
				{
					case 'approve':
						$apt = 2;
						$sgn = (count($_POST['cid']) > 1)? 13 : 8;
						$tmn = 'afiliate_account_approved';
						break;
					case 'pending':
						$apt = 1;
						$sgn = (count($_POST['cid']) > 1)? 14 : 9;
						$tmn = 'affiliate_new_account_signup';
						break;
					default:
						$apt = 0;
						$sgn = (count($_POST['cid']) > 1)? 12 : 7;
						$tmn = false;
				}
				$ids[] = (INT)$_POST['cid'][$i];
				$gXpAdmin->saveAccount(Array("approved"=>$apt),(INT)$_POST['cid'][$i]);
			}
		}
		if(count($ids)>0)
		{	
			if($tmn)
			{
				$tpl = $gXpAdmin->getEmailTemplateByKey($tmn);
				$gXpAdmin->sendAffiliateMail($tpl,$ids);
			}
		}
		header("Location: accounts.php?sgn=".$sgn.$query_items);
	}
}
elseif($_POST['action'] == 'delete')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: accounts.php?sgn=4".$query_items);
	}
	else
	{
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_account_declined');
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			if((INT)$_POST['cid'][$i]>0)
			{				
				$gXpAdmin->sendAffiliateMail($tpl,Array((INT)$_POST['cid'][$i]));
				$gXpAdmin->deleteAffiliate((INT)$_POST['cid'][$i]);
			}
		}
		header("Location: accounts.php?sgn=".((count($_POST['cid']) > 1)? 10 : 5).$query_items);
	}

}
elseif( ($_POST['task'] == 'Create') || ($_POST['task'] == 'save') )
{
    
	$data['username'] = htmlentities($_POST['username']);
	$data['password'] = htmlentities($_POST['password']);
	$data['firstname'] = htmlentities($_POST['firstname']);
	$data['lastname'] = htmlentities($_POST['lastname']);
	$data['level'] = htmlentities($_POST['level']);
	$data['email'] = htmlentities($_POST['email']);
	$data['address'] = htmlentities($_POST['address']);
	$data['city'] = htmlentities($_POST['city']);
	$data['state'] = htmlentities($_POST['state']);
	$data['zip'] = htmlentities($_POST['zip']);
	$data['country'] = htmlentities($_POST['country']);
	$data['phone'] = htmlentities($_POST['phone']);
	$data['fax'] = htmlentities($_POST['fax']);
	$data['url'] = htmlentities($_POST['url']);
	$data['taxid'] = htmlentities($_POST['taxid']);
	$data['check'] = htmlentities($_POST['check']);
	$data['company'] = htmlentities($_POST['company']);
	$data['password'] = md5(addslashes(htmlentities($_POST['password'])));

	$data = array_map("htmlentities", $data);
	$data = array_map("addslashes", $data);
	
	// Check the username already taken
	$queryStr = mysql_query("SELECT * FROM `aff_affiliates` WHERE username='".$data['username']."'") or die(mysql_error());
	if(mysql_num_rows($queryStr)>0)
	{	
		header("Location: accounts.php?sgn=15".$query_items);
		exit;
	}

	if($_POST['task'] == 'Create')
	{
		$data['approved'] = '1';
		$gXpAdmin->createAffiliateAccount($data);
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_new_account_signup');
		$l_id = mysql_insert_id();
		$gXpAdmin->sendAffiliateMail($tpl,Array($l_id));
		header("Location: accounts.php?sgn=1".$query_items);

	}
	else if((INT)$_POST['id']>0)
	{
		$gXpAdmin->saveAccount($data, (INT)$_POST['id']);
		header("Location: accounts.php?sgn=6".$query_items);
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: accounts.php".str_replace("&","?",$query_items));
}

$buttons = array(

0 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);

require_once('header.php');
$account = $gXpAdmin->getAffiliateById($id);
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#manage_account").validate();});
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
		
<form action="manage-account.php<?php str_replace('&','?',$query_items)?>" id="manage_account" method="post" name="adminForm">

<?php
if(!$msg)
{
	if($_POST['task'] == 'create')
	$head = $gXpLang['add_affiliate'];
	else
	{
		$head  = $gXpLang['account_status'].' : ';
		$head .= '<span style="text-transform: capitalize;">';
		switch ($account['approved'])
		{
			case 1:
				$head .= $gXpLang['status_pending'];
				break;
			case 2:
				$head .= $gXpLang['status_approved'];
				break;
			default:
				$head .= $gXpLang['status_disapproved'];
		}
		$head .= '</span>';
		print_box(0, $head);
	}
	//					echo $head;
				?>
				<!--		</div>-->

		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['affiliate_personal_details']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['first_name']; ?>:</td>
					<td><input class="inputbox required" maxlength="12" title="enter the first name" name="firstname" size="40" id="firstname" value="<?php echo $account['firstname'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['last_name']; ?>:</td>
					<td><input class="inputbox required" maxlength="5" title="enter the last name" name="lastname" size="40" id="lastname" value="<?php echo $account['lastname'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['email']; ?>:</td>
					<td><input class="inputbox required email"  title="enter the email id" name="email" id="email" size="40" value="<?php echo $account['email'];?>" type="text" /></td>
				</tr>
				
				<tr>
					<td><?php echo $gXpLang['tax_id']; ?>:</td>
					<td><input class="inputbox required digits" title="enter numbers only" name="taxid" size="40" id="taxid" value="<?php echo $account['taxid'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['checks_payable']; ?>:</td>
					<td><input class="inputbox required digits" title="enter numbers only" name="check" size="40" value="<?php echo $account['check'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['payout_level']; ?>:</td>
					<td>
						<select name="level" class="required"   title="enter numbers only">
							<option value="0"><?php echo $gXpLang['default_level']." - (".$gXpConfig['payout_percent']."%)"; ?></option>
						<?php
						$paylevels = $gXpAdmin->getPayLevels();
						for($i=0;$i<count($paylevels);$i++)
						{
							echo '<option value="'.$paylevels[$i]['level'].'" '.($account['level'] == $paylevels[$i]['level']? 'selected="selected"':'').'>'.$gXpLang['level'].' - '.$paylevels[$i]['level'].' ('.$paylevels[$i]['amt'].'%)</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['company_details']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['company_name']; ?></td>
					<td><input class="inputbox" maxlength="20" name="company" id="company" size="40" value="<?php echo $account['company'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['website_url']; ?></td>
					<td><input class="inputbox required url"   title="enter valid wbsite" name="url" id="url" size="40" value="<?php echo $account['url'];?>" type="text" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['address']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['street_address']; ?>:</td>
					<td><input class="inputbox required"   title="enter valid address" name="address" id="address" size="40" value="<?php echo $account['address'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['zip_code']; ?>:</td>
					<td><input class="inputbox required digits"   title="enter numbers only" maxlength="6" name="zip" size="40" id="zip" value="<?php echo $account['zip'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['frontend_city']; ?>:</td>
					<td><input class="inputbox required" name="city" id="city" title="enter the city" maxlength="20" size="40" value="<?php echo $account['city'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['state_province']; ?>:</td>
					<td><input class="inputbox required" name="state" id="state" title="enter the state" maxlength="20" size="40" value="<?php echo $account['state'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['frontend_country']; ?>:</td>
					<td>
					<?php 
					$country = $gXpAdmin->getCountryList();
					?>
					<select name="country" class="required"   title="select country name">
					<?php
						for($i=0;$i<count($country);$i++)
						{
							echo '<option value="'.$country[$i]['countryid'].'" '.($account['country'] == $country[$i]['countryid']? 'selected="selected"':'').'>'.$country[$i]['countryname'].'</option>';
						}
					?></select>&nbsp;<span class="inputRequirement">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['contact_Info']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['phone']; ?></td>
					<td><input class="inputbox required digits"   title="enter numbers only" maxlength="15" name="phone" id="phone" size="40" value="<?php echo $account['phone'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['fax']; ?></td>
					<td><input class="inputbox" name="fax"  maxlength="20" size="40" value="<?php echo $account['fax'];?>" type="text" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['account_details']; ?></th>
				</tr>
				<?php
				if($_POST['task'] != 'create')
				{
				?>
				<tr>
					<td width="100"><?php echo $gXpLang['affiliate']; ?> ID:</td>
					<td width="85%"><?php echo $account['id'];?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td><?php echo $gXpLang['username']; ?>:</td>
					<td>
						<input name="username" id="username" title="enter username" maxlength="20" class="inputbox required" size="40" value="<?php echo $account['username'];?>" type="text" />
					</td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['password']; ?>:</td>
					<td>
						<input name="password" id="password" title="enter password" maxlength="20" class="inputbox required" size="40" value="<?php echo $account['password']; ?>" type="password"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				</tbody></table>
				<input name="task" value="" type="hidden" />
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo ($_POST['task']=='create')?'Create':'save';?>'" type="submit" value="<?php echo ($_POST['task']=='create')?$gXpLang['create']:$gXpLang['save']; ?>"></div>	  	
			</td>
			<td valign="top" width="40%">

		<table class="adminform">
			<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_statistics']; ?></th>
				</tr>
				<tr>
					<td>N/A</td>
				</tr>
		<tr>
					<td>Visits:</td>
					<td><?php echo $account['hits'];?></td>
				</tr>
				<tr>
					<td>Unique Visitors:</td>
					<td><?php echo $gXpAdmin->getVisitorsCount($account);?></td>
				</tr>
				<tr>
					<td>Commissions</td>
					<td><?php echo $account['sales'];?></td>
				</tr>
				<tr>
					<td>Current Sales (SUM)</td>
					<td><?php echo CURRENCY.$gXpAdmin->getCommissionsById($account['id']);?></td>
				</tr>
				<tr>
					<td>Current Commissions</td>
					<td><?php echo CURRENCY.$gXpAdmin->getCommissionsById($account['id'])*$gXpConfig['payout_percent']/100;?></td>
						</tr>
			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>

<?php
}
?>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
