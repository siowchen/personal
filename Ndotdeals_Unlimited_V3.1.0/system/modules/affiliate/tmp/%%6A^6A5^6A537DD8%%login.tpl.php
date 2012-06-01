<?php /* Smarty version 2.6.14, created on 2012-04-18 20:39:02
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if (( $this->_tpl_vars['msg'] )): ?>
<ul class="error">
	<li><?php echo $this->_tpl_vars['msg']; ?>
</li>
</ul>
<?php endif; ?>
<?php echo "<script type='text/javascript'>$(document).ready(function(){ $('#loginForm').validate();});</script>"; ?>
<div class="log_form1 ">
<h2><?php echo $this->_tpl_vars['lang']['affiliate_login']; ?>
</h2>

<table class="login" align="center">
	<tr>
		<td>
			<div class="login-form" >
				<form action="login.php" method="post" name="loginForm" id="loginForm">
					<div class="form-block">
					        <table>
					                <tr>
					                     <td width="200" style="text-align:right;"><?php echo $this->_tpl_vars['lang']['username']; ?>
:</td>
						                <td style="text-align:left!important;"><input name="username" type="text" title="Enter the Username" class="inputbox required" size="15" /></td>
						         </tr>
						         <tr>
					                    <td width="200" style="text-align:right;"><?php echo $this->_tpl_vars['lang']['password']; ?>
:</td>
						                <td style="text-align:left!important;"><input name="password" type="password" title="Enter the Password" class="inputbox required" size="15" /></td>
						         </tr>
						        <tr>
						        <td width="200">&nbsp;</td>
						        <td align="center">
                                	<div style="width:250px;" class="fl">
                                    	<span class="submit">
                                        	<input type="submit" name="submit" class="bnone fl" value="<?php echo $this->_tpl_vars['lang']['login']; ?>
" />
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
<?php echo $this->_tpl_vars['lang']['warning_noscript']; ?>

</noscript>
<script type="text/javascript">
<?php echo '
window.onload = function()
{
	document.loginForm.username.select();
	document.loginForm.username.focus();
}
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>