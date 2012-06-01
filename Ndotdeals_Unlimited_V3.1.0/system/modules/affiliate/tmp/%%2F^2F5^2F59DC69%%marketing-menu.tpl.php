<?php /* Smarty version 2.6.14, created on 2011-12-24 12:06:04
         compiled from marketing-menu.tpl */ ?>
<div class="marketing-menu">
	<div class="marketing-content">
			<?php $_from = $this->_tpl_vars['marketing_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['marketing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['marketing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['marketing']['iteration']++;
?>
				<a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
			<?php endforeach; endif; unset($_from); ?>

	</div>
</div>