
{php}echo "<script type='text/javascript'>$(document).ready(function(){ $('#loginForm1').validate();});</script>";{/php}	
			<table cellpadding="0" cellspacing="0" id="toolbar">
				<tr height="60" valign="top" align="center">
					<td>
						<form action="login.php" method="post" name="login" id="loginForm1" style="text-align: left;">
							<table cellpadding="0" cellspacing="0" align="center" border="0">
								<tr>
									<td>
										<span>{$lang.username}</span><br />
										<input name="username"  title="Enter the Username" id="mod_login_username" class="inputbox-small required" size="18" type="text"/><br />
									</td>
								</tr>
								<tr>
									<td>
										<span>{$lang.password}</span><br/>
										<input id="mod_login_password" title="Enter the Password" name="password" class="inputbox-small required" size="18" alt="password" type="password"/><br/>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;width:100%;" align="center">
										<input name="option" value="login" type="hidden"/>
										<span class="submit mt5"><input  class="bnone" name="Submit" value="{$lang.login}" type="submit"/></span>
									</td>
								</tr>
								<tr>
									<td>
										<a style="float:left;clear:both;text-align:center;width:170px;" href="forgot.php">{$lang.forgot_password}</a>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;" >
										<span style="font-size: 13px;">{$lang.no_account_yet}</span><br/>
                                        <a style="float:left;clear:both;text-align:center;width:170px;" href="register.php">Registration</a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="authorize" value="1" />
						</form>
					</td>
				</tr>
			</table>

