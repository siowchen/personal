{include file="header.tpl"}

<h2>Deals</h2>
{if $aff.approved eq 2}
	{$lang.products} - 
		<select onchange="getDeals(this.options[this.selectedIndex].value)">
		<option value="">- All -</option>
		{foreach from=$products key=pid item=product}
		<option value="{$pid}" {if $smarty.get.pid eq $pid}selected{/if}>{$product}</option>
		{/foreach}
	</select><br />&nbsp;
	
	<!--{if $smarty.get.pid }
	Limits - 
		<select onchange="getLimits(this.options[this.selectedIndex].value)">
		{foreach from=$limit  item=limit}
		<option value="{$limit}" {if $smarty.get.lid eq $limit}selected{/if}>{$limit}</option>
		{/foreach}
	</select><br />&nbsp;
	{/if}-->
	
	<table cellpadding="2" border="0" cellspacing="5" class="banners_deals">
		<tr style="background-color: #E5E5E5; font-weight: bold;">
			<td width="48%" style="font:bold 12px arial;color:#000;padding-left:5px;" class="txt_ali_cen" style="text-align:left;">Deal Name</td>
			<td width="48%" style="padding-left:10px;font:bold 12px arial;color:#000;" class="txt_ali_cen">Description</td>
		</tr>
		{foreach from=$deals item=deal}
		<tr>
			<td width="48%" style="text-align:justify;"><a class="width325_b" href="deal-details.php?id={$deal.coupon_id}{if $smarty.get.pid>0}&pid={$smarty.get.pid}{/if}">{ $deal.coupon_name }</a></td>
			<td width="48%" style="text-align:justify;padding-left:10px;"><div class="aff_del_des width325_b">{$deal.coupon_description|html_entity_decode|strip_tags}</div></td>
		</tr>
		{/foreach}
	</table>
	<script type="text/javascript">
	{literal}
	function getDeals(val)
	{
		var loc = document.location.href;
		
		if(loc.indexOf('pid=')>-1 && parseInt(val)>0)
		{
			loc = loc.replace(/pid\=(\d+)/,'pid='+val);
			document.location.href = loc;
		}
		else if(parseInt(val)>0)
		{
			document.location.href = loc+"?pid="+val;
		}
		else
		{
			loc = loc.replace(/\?pid\=(\d+)?$/,'');
			document.location.href = loc;
		}
	}
	{/literal}
	</script>
	
	
	
	<script type="text/javascript">
	{literal}
	function getLimits(val)
	{
		var loc = document.location.href;
		
		if(loc.indexOf('lid=')>-1 && parseInt(val)>0)
		{
			loc = loc.replace(/lid\=(\d+)/,'lid='+val);
			document.location.href = loc;
		}
		else if(parseInt(val)>0)
		{
			document.location.href = loc+"&lid="+val;
		}
		else
		{
			loc = loc.replace(/\?lid\=(\d+)?$/,'');
			document.location.href = loc;
		}
	}
	{/literal}
	</script>
{else}
	<strong class="fl">{$lang.msg_account_pending_approval}</strong>
{/if}

{include file="footer.tpl"}
