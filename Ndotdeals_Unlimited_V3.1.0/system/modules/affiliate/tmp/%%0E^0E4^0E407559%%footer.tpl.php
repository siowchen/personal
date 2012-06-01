<?php /* Smarty version 2.6.14, created on 2011-12-28 18:40:34
         compiled from footer.tpl */ ?>
			</div>
			</div>


       <?php 
   if(CURRENT_THEME=='nightcity') 
   {  ?>

			<div class="inner_bottom cnt_btmborder"></div>

  <?php  } 
   else 
   {  ?>

			<div class="content_bottom"></div>

  <?php  }  ?>


                    </div>
                                   <div class="content_right">
				              
               	                        <div class="great_deals">
                                        		<div class="great_top1"></div>
                    	                        <div class="great_top">
                    	                                         <?php if (! $this->_tpl_vars['login']): ?>
					                                <h1 class="miniheader">Login Form</h1>
				                                <?php else: ?>
					                               <h1 class="miniheader">Affiliates</h1>
				                                <?php endif; ?></div>
                                                 <div class="login-small">
                     	                                <div class="great_center">
                                                       
				                                <?php if (! $this->_tpl_vars['login']): ?>
					                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "login-form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				                                <?php else: ?>
					                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "context-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "marketing-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				                                <?php endif; ?>
				                        </div>
                     	                        <div class="great_bottom"></div>
                                                
                                                </div>
                                        </div>
                                        
			                </div>                    
                    
                    
			</div>
          </div>
      </div>
  </div>
  
  <?php 
  
 
 include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/footer.php");
  ?>

</body>

</html>