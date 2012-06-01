<?php /* Smarty version 2.6.14, created on 2012-04-21 12:30:31
         compiled from general-statistics.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['general_statistics']; ?>
</h2>
<table cellpadding="0" cellspacing="0" class="stat-box">
	
	<tr>
		<td>
		<fieldset style="border:1px solid #e1e1e1;width:630px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">Approved Transactions</legend>
			<table cellpadding="0" cellspacing="0" class="stat" width="100%">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['transactions']; ?>
:</td>
					<td style="text-align:left">$<?php echo $this->_tpl_vars['trans']['transaction']; ?>
</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['sales']; ?>
:</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['trans']['salecount']; ?>
</td>
				</tr>
			</table></fieldset>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>

<table cellpadding="0" cellspacing="0" class="stat-box">
	
	<tr>
		<td>
		<fieldset style="border:1px solid #e1e1e1;width:630px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['commissions']; ?>
</legend>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['transactions']; ?>
:</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['stat']['transactions']; ?>
</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['earnings']; ?>
:</td>
					<td style="text-align:left">$<?php echo $this->_tpl_vars['stat']['earnings']; ?>
</td>
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
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['traffic_stat']; ?>
</legend>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['visits']; ?>
(Total Hits):</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['traffic']['visits']; ?>
</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['unique_visitors']; ?>
(No Of Sales):</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['traffic']['visitors']; ?>
</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['sales']; ?>
:</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['traffic']['sales']; ?>
</td>
				</tr>
				<tr>
					<td style="text-align:right;font:bold 12px arial;width:230px;"><?php echo $this->_tpl_vars['lang']['sales_ratio']; ?>
:</td>
					<td style="text-align:left"><?php echo $this->_tpl_vars['traffic']['ratio']; ?>
%</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
<?php else: ?>
	<strong class="fl clr" style="float:left;clear:both;width:650px;"><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>