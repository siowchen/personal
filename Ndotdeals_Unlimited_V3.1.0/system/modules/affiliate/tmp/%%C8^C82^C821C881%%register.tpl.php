<?php /* Smarty version 2.6.14, created on 2012-04-21 11:33:22
         compiled from register.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="affilite">
<h2><?php echo $this->_tpl_vars['lang']['create_new_account']; ?>
</h2>
<b style="color:red; float:left;"><?php echo $this->_tpl_vars['msg']; ?>
 &nbsp;</b>
<?php echo "<script type='text/javascript'>$(document).ready(function(){ $('#register').validate();});</script>"; ?>

<form name="create_account" id="register" action="register.php" method="post" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	
   <!-- <tr>
		<td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
	</tr> -->
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['personal_details']; ?>
</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['first_name']; ?>
:</label></td>
                <td style="text-align:left"><input name="firstname" class="required" title="Enter the first name" type="text" value="<?php echo $this->_tpl_vars['form']['firstname']; ?>
" /></td>
              </tr>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['last_name']; ?>
:</label></td>

                <td style="text-align:left"><input name="lastname" class="required" type="text" title="Enter the last name" value="<?php echo $this->_tpl_vars['form']['lastname']; ?>
" /></td>
              </tr>
              <tr>

                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['email_address']; ?>
:</label></td>
                <td style="text-align:left"><input name="email" class="required" type="text" title="Enter the Email" value="<?php echo $this->_tpl_vars['form']['email']; ?>
" /></td>
              </tr>
            </tbody>
            </table>              
              </fieldset>
              </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['company_details']; ?>
</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['company_name']; ?>
:</label></td>
                <td style="text-align:left"><input name="company" class="required" type="text" title="Enter the company name" value="<?php echo $this->_tpl_vars['form']['company']; ?>
" /></td>
              </tr>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['website_url']; ?>
:</label></td>
                <td style="text-align:left"><input name="url" class="required url" type="text" title="Enter the website URL" value="<?php echo $this->_tpl_vars['form']['url']; ?>
" /></td>
              </tr>
            </tbody>
            </table>              
              </fieldset>
              </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['your_address']; ?>
</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                 <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['street_address']; ?>
:</label></td>
                <td style="text-align:left"><input name="address" class="required" type="text" title="Enter the address" value="<?php echo $this->_tpl_vars['form']['address']; ?>
" /></td>
              </tr>
              
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['zip_code']; ?>
:</label></td>
                <td style="text-align:left"><input name="zip"  class="required" type="text" title="Enter the zip-code" value="<?php echo $this->_tpl_vars['form']['zip']; ?>
" /></td>
              </tr>
              <tr>
				<td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['frontend_city']; ?>
:</label></td>
                <td style="text-align:left"><input name="city" class="required" type="text" title="Enter the city" value="<?php echo $this->_tpl_vars['form']['city']; ?>
" /></td>
              </tr>
              <tr>
              	 <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['state_province']; ?>
:</label></td>
                <td style="text-align:left"><input name="state" class="required" title="Enter the state" type="text" value="<?php echo $this->_tpl_vars['form']['state']; ?>
" /></td>
              </tr>
               <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['frontend_country']; ?>
:</label></td>
                <td style="text-align:left"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "countries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>

              </tr>
            </tbody>
            </table>              
              </fieldset>
              </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
       <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['your_contact_Info']; ?>
</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['telephone_number']; ?>
:</label></td>
                <td style="text-align:left"><input name="phone" class="required" title="Enter the phone number" type="text" value="<?php echo $this->_tpl_vars['form']['phone']; ?>
" /></td>
              </tr>
              
               <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['fax_number']; ?>
:</label></td>
                <td style="text-align:left"><input name="fax" type="text" value="<?php echo $this->_tpl_vars['form']['fax']; ?>
" />&nbsp;</td>
              </tr>
              
            </tbody>
            </table>              
              </fieldset>
              </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
      <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;"><?php echo $this->_tpl_vars['lang']['your_password']; ?>
</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right" ><label><?php echo $this->_tpl_vars['lang']['username']; ?>
:</label></td>
                <td style="text-align:left"><input name="username" class="required" title="Enter the user name" type="text" value="<?php echo $this->_tpl_vars['form']['username']; ?>
" /></td>
            </tr>
             <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['password']; ?>
:</label></td>
                <td style="text-align:left"><input name="password" class="required" maxlength="40" title="Enter the password" type="password" value="<?php echo $this->_tpl_vars['form']['password']; ?>
" /></td>
            </tr>
              <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['password_confirm']; ?>
:</label></td>
                <td style="text-align:left"><input name="password2" class="required" maxlength="40" type="password"  title="Enter the password" value="<?php echo $this->_tpl_vars['form']['password']; ?>
" /></td>
              </tr>
               <tr>
                <td style="text-align:right"><label><?php echo $this->_tpl_vars['lang']['aff_email_address']; ?>
:</label></td>
                <td style="text-align:left"><input name="aemail" class="required email" type="text" title="Enter the affiliate email address" value="<?php echo $this->_tpl_vars['form']['aemail']; ?>
" /></td>
              </tr>
            </tbody>
            </table>              
              </fieldset>
              </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
     <!--  <tr>
        <td><img src="<?php echo $this->_tpl_vars['images']; ?>
pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>  -->
      
       <tr>
        <td>
        <table  border="0" class="register_table infoBox"  cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <table border="0" cellpadding="2" cellspacing="0" class="register_table" width="100%">
              <tbody>
              <tr style="text-align:left;">
                <td>
                <input  src="<?php echo $this->_tpl_vars['images']; ?>
button_continue.gif" alt=" <?php echo $this->_tpl_vars['lang']['continue']; ?>
 " title=" <?php echo $this->_tpl_vars['lang']['continue']; ?>
 "  type="image" class="fl" style="margin-left:275px;" /></td>
              
              </tr>
            </tbody>
            </table>
            </td>
          </tr>
        </tbody>
        </table>
        </td>
      </tr>
      
    </tbody>
    </table>

	<input type="hidden" name="register" value="1" />
</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>