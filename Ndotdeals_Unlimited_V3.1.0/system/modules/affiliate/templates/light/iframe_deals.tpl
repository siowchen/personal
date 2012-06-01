{include file="header.tpl"}

<h2>Deals</h2>
{if $aff.approved eq 2}
	
	<table cellpadding="2" cellspacing="1" class="banners">
		<tr style="background-color: #E5E5E5; font-weight: bold;">
			<td width="25%">Deal Name</td>
			<td width="25%">Deal Dis</td>
		</tr>
		{foreach from=$deals item=deal}
		<tr>
			<td>{$deals}</td>
		</tr>
		{/foreach}
	</table>
	
{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}

{include file="footer.tpl"}
