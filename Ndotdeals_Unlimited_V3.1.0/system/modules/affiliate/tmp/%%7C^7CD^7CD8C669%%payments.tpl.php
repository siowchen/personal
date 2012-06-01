<?php /* Smarty version 2.6.14, created on 2011-11-10 16:51:27
         compiled from payments.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['payment_history']; ?>
</h2>
<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>
	<?php if ($this->_tpl_vars['payments']): ?>
	<table class="con_box" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->_tpl_vars['lang']['payment_id']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['date']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['time']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['total_sales']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['commissions']; ?>
</th>
	</tr>
	<?php $_from = $this->_tpl_vars['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['payment']):
?>
	
	<tr>
		<td><?php echo $this->_tpl_vars['payment']['id']; ?>
</td>
		<td><?php echo $this->_tpl_vars['payment']['date']; ?>
</td>
		<td><?php echo $this->_tpl_vars['payment']['time']; ?>
</td>
		<td><?php echo $this->_tpl_vars['payment']['sales']; ?>
</td>
		<td><?php echo $this->_tpl_vars['payment']['commission']; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php else: ?>
	<p style="font-weight: bold;"><?php echo $this->_tpl_vars['lang']['history_clear']; ?>
</p>
	<?php endif; ?>
<?php else: ?>
	<strong class="fl"><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
