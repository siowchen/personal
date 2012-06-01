{include file="header.tpl"}

<h2>{$lang.email_links}</h2>
{if $aff.approved eq 2}
	<p>{$lang.source_code}</p>
	
	<form name="code1">
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();">{$xpurl}xp.php?id={$id}</textarea><br>	
	</form>
{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}
{include file="footer.tpl"}
