{include file="header.tpl"}
{php}echo "<script type='text/javascript'>$(document).ready(function(){ $('#commission').validate();});

		function checkUncheckAll(theElement) 
		{ 
			 var theForm = theElement.form, z = 0;
			 for(z=0; z<theForm.length;z++)
			 {
				  if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
				  { //alert(theElement);
					theForm[z].checked = theElement.checked;
				  }
			 }
		}

		function approve_deallist()
		{

				var chks = document.getElementsByName('com[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert('Please select at least one record!');
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm('Are you sure want to proceed?');				
				if(booSubmit == true)
				{
					document.commission.submit();

				}
			
		}


</script>";{/php}
<h2>{$lang.commission_details}</h2>
{if ( $ctype!="approved" && $msg!='')}
{if ($msg == 1)}
Your fund request are submitted admin.
{elseif ($msg == 0)}
Your fund request are greater the your commission .
{else}
Your fund request are not valid amount .
{/if}
{/if}

{if $commission.id eq '' && $smarty.get.id eq ''}
	{if $aff.approved eq 2}
		<div style="font-size: 13px;" class="com_dts">
		<ul class="options">
			<li>{$lang.commissions}: </li>
			<li>
				{if ($ctype!="pending")}
				<a href="commission-details.php?type=pending" style="font-size: 13px;">{$lang.pending_approval}</a>
				{else}
				<b>{$lang.pending_approval}</b>
				{/if}
			</li>
			<li>
				{if ($ctype!="approved")}
				<a href="commission-details.php?type=approved" style="font-size: 13px;">{$lang.approved}</a>
				{else}
				<b>{$lang.approved}</b>
				{/if}
			</li>
		<!--	<li>
				{if ($ctype!="paid")}
				<a href="commission-details.php?type=paid" style="font-size: 13px;">Paid</a>
				{else}
				<b>Paid</b>
				{/if}
			</li>
		-->
		</ul>
		
		<div style="clear: both;"></div>
		<fieldset style="border:2px solid #e1e1e1;">
		<legend style="border:1px solid #e1e1e1;margin-left:10px;padding:3px;font:bold 12px arial;"> Commission Details</legend>
		<table cellpadding="0" cellspacing="0" class="" class="con_com" >


		{if ($ctype == "approved" && count($commissions) > 0)}

		<form name="commission" id="commission" class="" action="commission-details.php?type=approved" method="post">

				<!-- My check-->
				
			<tr style="font-weight: bold;">
				<td width="10%">All</td>
				<td width="20%">{$lang.sale_date}</td>
				<td width="20%">{$lang.status}</td>
				<td width="20%">{$lang.sale_amount}</td>
				<td width="20%">{$lang.action}</td>
			</tr>

		{foreach from=$commissions item=commission}
			<tr>

				<td><input type="checkbox" value="{$commission.id}" name='com[]' style="width:30px"; /></td>
				<td>{$commission.date}</td>
				<td>{if $commission.approved}{$lang.approved}{else}{$lang.pending}{/if}</td>
				<td>{$commission.payment}</td>
				<td><a href="commission-details.php?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}&{/if}id={$commission.id}" >{$lang.small_view_details}</a></td>
			</tr>
		{/foreach}

		       

<tr>   <!-- My check-->

					<td style="width:100px";><input type="checkbox" value="0" name='checkall' onclick="checkUncheckAll(this);" style="width:30px"; /></td>
					<td><label class="ml-10"> All/ None</label></td>
			<td colspan="3" align="left" style="text-align:left; padding-left:20px;">
					<select name="approve_saleslist" onchange="approve_deallist();" style="width:80px";>
					<option value="">-Choose-</option>
					<option value="1">Process</option>
					</select></td>
</tr>

                   
                      <input type="hidden" name="fund" value="1" />
		 </from>
		 {/if}
		</table>
	</fieldset>
		<br />
		{$navigation}
		</div>
	{else}
		<strong class="fl">{$lang.msg_account_pending_approval}</strong>
	{/if}
{elseif $commission.id > 0}

	<a href="commission-details.php?{if $smarty.get.type}type={$smarty.get.type}{/if}{if $smarty.get.page}&page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}{/if}" class="fl clr pb10">{$lang.return_go_back}</a><br />
	<br />
	<fieldset style="border:1px solid #e1e1e1;">
		<legend style="border:1px solid #e1e1e1;margin-left:10px;padding:3px;font:bold 12px arial;"> Commission Details</legend>
	<table border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" width="100%">
		<tr>
			<td width="150" bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong>{$lang.sale_date}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;">{$commission.date} {$commission.time}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong>{$lang.sale_amount}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;">{$commission.payment}</td>
		</tr>		
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong>{$lang.commissions}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;">{$commission.payout}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong>{$lang.order_number}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;">{$commission.order_number}</td>
		</tr>
	</table>
    </fieldset>
{elseif $smarty.get.id > 0}
	<strong style="color: #FF0000">{$lang.msh_incorrect_param}</strong>
{/if}	
{include file="footer.tpl"}
