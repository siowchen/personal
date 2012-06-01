<?php /* Smarty version 2.6.14, created on 2012-04-21 12:36:41
         compiled from deals.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'html_entity_decode', 'deals.tpl', 30, false),array('modifier', 'strip_tags', 'deals.tpl', 30, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2>Deals</h2>
<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>
	<?php echo $this->_tpl_vars['lang']['products']; ?>
 - 
		<select onchange="getDeals(this.options[this.selectedIndex].value)">
		<option value="">- All -</option>
		<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pid'] => $this->_tpl_vars['product']):
?>
		<option value="<?php echo $this->_tpl_vars['pid']; ?>
" <?php if ($_GET['pid'] == $this->_tpl_vars['pid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['product']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
	</select><br />&nbsp;
	
	<!--<?php if ($_GET['pid']): ?>
	Limits - 
		<select onchange="getLimits(this.options[this.selectedIndex].value)">
		<?php $_from = $this->_tpl_vars['limit']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['limit']):
?>
		<option value="<?php echo $this->_tpl_vars['limit']; ?>
" <?php if ($_GET['lid'] == $this->_tpl_vars['limit']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['limit']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
	</select><br />&nbsp;
	<?php endif; ?>-->
	
	<table cellpadding="2" border="0" cellspacing="5" class="banners_deals">
		<tr style="background-color: #E5E5E5; font-weight: bold;">
			<td width="48%" style="font:bold 12px arial;color:#000;padding-left:5px;" class="txt_ali_cen" style="text-align:left;">Deal Name</td>
			<td width="48%" style="padding-left:10px;font:bold 12px arial;color:#000;" class="txt_ali_cen">Description</td>
		</tr>
		<?php $_from = $this->_tpl_vars['deals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['deal']):
?>
		<tr>
			<td width="48%" style="text-align:justify;"><a class="width325_b" href="deal-details.php?id=<?php echo $this->_tpl_vars['deal']['coupon_id'];  if ($_GET['pid'] > 0): ?>&pid=<?php echo $_GET['pid'];  endif; ?>"><?php echo $this->_tpl_vars['deal']['coupon_name']; ?>
</a></td>
			<td width="48%" style="text-align:justify;padding-left:10px;"><div class="aff_del_des width325_b"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['deal']['coupon_description'])) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)))) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div></td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	<script type="text/javascript">
	<?php echo '
	function getDeals(val)
	{
		var loc = document.location.href;
		
		if(loc.indexOf(\'pid=\')>-1 && parseInt(val)>0)
		{
			loc = loc.replace(/pid\\=(\\d+)/,\'pid=\'+val);
			document.location.href = loc;
		}
		else if(parseInt(val)>0)
		{
			document.location.href = loc+"?pid="+val;
		}
		else
		{
			loc = loc.replace(/\\?pid\\=(\\d+)?$/,\'\');
			document.location.href = loc;
		}
	}
	'; ?>

	</script>
	
	
	
	<script type="text/javascript">
	<?php echo '
	function getLimits(val)
	{
		var loc = document.location.href;
		
		if(loc.indexOf(\'lid=\')>-1 && parseInt(val)>0)
		{
			loc = loc.replace(/lid\\=(\\d+)/,\'lid=\'+val);
			document.location.href = loc;
		}
		else if(parseInt(val)>0)
		{
			document.location.href = loc+"&lid="+val;
		}
		else
		{
			loc = loc.replace(/\\?lid\\=(\\d+)?$/,\'\');
			document.location.href = loc;
		}
	}
	'; ?>

	</script>
<?php else: ?>
	<strong class="fl"><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>