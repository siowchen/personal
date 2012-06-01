{include file="header.tpl"}
{php}echo "<script type='text/javascript'>$(document).ready(function(){ $('#loginForm').validate();});</script>";{/php}
<div class="log_form1 ">
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
						                <td style="text-align:left!important;"><input name="username" type="text" title="Enter the Username" class="inputbox required" size="15" /></td>
						         </tr>
						         <tr>
					                        <td style="text-align:right;">{$lang.password}:</td>
						                <td style="text-align:left!important;"><input name="password" type="password" title="Enter the Password" class="inputbox required" size="15" /></td>
						         </tr>
						        <tr>
						        <td></td>
						        <td align="center">
                                	<div style="width:250px;" class="fl">
                                    	<span class="submit">
                                        	<input type="submit" name="submit" class="bnone fl" value="{$lang.login}" />
                                        </span>
                                        <span class="reset " >
                                            <input type="reset" name="reset" class="bnone fl" value="Reset" />
                                        </span>
                                    
                                    </div>
                                </td>
                                </tr>
					
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
