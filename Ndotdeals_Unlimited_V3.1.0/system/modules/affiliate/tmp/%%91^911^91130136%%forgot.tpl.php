<?php /* Smarty version 2.6.14, created on 2011-11-10 17:12:06
         compiled from forgot.tpl */ ?>
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
 <fieldset style="border:1px solid #e1e1e1;width:620px;margin-left:20px;padding-bottom:15px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;"><?php echo $this->_tpl_vars['lang']['password_recovery']; ?>
</legend>
<form method="post" action="forgot.php">
<div style="margin:30px 0 0 30px;width:580px;padding-bottom:10px;float:left;">

<p class="forget_cont fl pb5"><?php echo $this->_tpl_vars['lang']['msg_please_register']; ?>
</p>
	<div style="float:left;clear:both;width:400px;">
	<input name="email" class="for_email fl" size="30" type="text" /><input class="for_img no fl" src="<?php echo $this->_tpl_vars['images']; ?>
button_continue.gif" type="image" />
	<input name="recover" value="1" type="hidden" />
    </div>
</div>
</form>
</fieldset>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>