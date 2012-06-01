{include file="header.tpl"}

{if ($msg)}
<ul class="error">
	<li>{$msg}</li>
</ul>
{/if}
 <fieldset style="border:1px solid #e1e1e1;width:620px;margin-left:20px;padding-bottom:15px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.password_recovery}</legend>
<form method="post" action="forgot.php">
<div style="margin:30px 0 0 30px;width:580px;padding-bottom:10px;float:left;">

<p class="forget_cont fl pb5">{$lang.msg_please_register}</p>
	<div style="float:left;clear:both;width:400px;">
	<input name="email" class="for_email fl" size="30" type="text" /><input class="for_img no fl" src="{$images}button_continue.gif" type="image" />
	<input name="recover" value="1" type="hidden" />
    </div>
</div>
</form>
</fieldset>
{include file="footer.tpl"}
