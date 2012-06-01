{include file="header.tpl"}

<div class="log_form1">
<h2>{$lang.affiliate_login}</h2>

<table class="login" align="center">
	<tr>
		<td>
		
			<div class="login-form" >
				<form action="login.php" method="post" name="loginForm" id="loginForm">
					<div class="form-block">
					        <table>
					                <tr>
					                        <td style="text-align:right;">{$lang.username}:</td>
						                <td><input name="username" type="text" class="inputbox" size="15" /></td>
						                {php}if (!$_POST['username']){<div style="color:red; margin-left:10px;">{$msg}</div>}{/php}
						         </tr>
						         <tr>
					                        <td style="text-align:right;">{$lang.password}:</td>
						                <td><input name="password" type="password" class="inputbox" size="15" /></td>
						                {php}if (!$_POST['password']){<div style="color:red; margin-left:10px;">{$msg}</div>}{/php}
						         </tr>
						        <tr>
						        <td></td>
						        <td align="center">
                                <span class="submit"><input type="submit" name="submit" class="bnone" value="{$lang.login}" /></span>
                                <span class="reset"><input type="reset" name="reset" class="bnone" value="Reset" /></span></td></tr>
					
					<input type="hidden" name="authorize" value="1" />
					</table>
				</form>
				
			</div>
			
		</td>
	</tr>
</table>
</div>

<noscript>
{$lang.warning_noscript}
</noscript>
<script type="text/javascript">
{literal}
window.onload = function()
{
	document.loginForm.username.select();
	document.loginForm.username.focus();
}
{/literal}
</script>
{include file="footer.tpl"}
