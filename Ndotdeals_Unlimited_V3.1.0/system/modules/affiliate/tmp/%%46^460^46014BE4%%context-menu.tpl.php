<?php /* Smarty version 2.6.14, created on 2011-12-24 12:06:04
         compiled from context-menu.tpl */ ?>
<div class="context">
		<?php $_from = $this->_tpl_vars['context_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['context'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['context']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['context']['iteration']++;
?>
			<a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
		<?php endforeach; endif; unset($_from); ?>	

</div>