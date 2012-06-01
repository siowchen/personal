{include file="header.tpl"}

<h2>{$lang.general_statistics}</h2>
<table cellpadding="0" cellspacing="0" class="stat-box">
	
	<tr>
		<td>
		<fieldset style="border:1px solid #e1e1e1;width:630px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">Approved Transactions</legend>
			<table cellpadding="0" cellspacing="0" class="stat" width="100%">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.transactions}:</td>
					<td style="text-align:left">${$trans.transaction}</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.sales}:</td>
					<td style="text-align:left">{$trans.salecount}</td>
				</tr>
			</table></fieldset>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
{if $aff.approved eq 2}

<table cellpadding="0" cellspacing="0" class="stat-box">
	
	<tr>
		<td>
		<fieldset style="border:1px solid #e1e1e1;width:630px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.commissions}</legend>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.transactions}:</td>
					<td style="text-align:left">{$stat.transactions}</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.earnings}:</td>
					<td style="text-align:left">${$stat.earnings}</td>
				</tr>
			</table></fieldset>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>


<table cellpadding="0" cellspacing="0" class="stat-box">
	
	<tr>
		<td>
		<fieldset style="border:1px solid #e1e1e1;width:630px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.traffic_stat}</legend>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.visits}(Total Hits):</td>
					<td style="text-align:left">{$traffic.visits}</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.unique_visitors}(No Of Sales):</td>
					<td style="text-align:left">{$traffic.visitors}</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.sales}:</td>
					<td style="text-align:left">{$traffic.sales}</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;">{$lang.sales_ratio}:</td>
					<td style="text-align:left">{$traffic.ratio}%</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
{else}
	<strong class="fl clr" style="float:left;clear:both;width:650px;">{$lang.msg_account_pending_approval}</strong>
{/if}
{include file="footer.tpl"}
