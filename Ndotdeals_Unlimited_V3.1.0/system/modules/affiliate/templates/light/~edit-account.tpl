{include file="header.tpl"}

<h2>{$lang.edit_account Info}</h2>

{php}echo "<script type='text/javascript'>$(document).ready(function(){ $('#edit_register').validate();});</script>";{/php}

<form name="create_account" id="edit_register" action="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/edit-account.php" method="post" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%" >
	<tbody>

      <tr>
        <td><table border="0" cellpadding="2" cellspacing="1" width="100%" class="register_table">
          <tbody><tr class="infoBoxContents">
            <td>
             <fieldset style="border:1px solid #e1e1e1;width:600px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.personal_details}</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label>{$lang.first_name}:</label></td>
                <td style="text-align:left"><input name="firstname" class="required" type="text" value="{$form.firstname}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"><label>{$lang.last_name}: </label></td>

                <td style="text-align:left"><input name="lastname" class="required" type="text" value="{$form.lastname}" /></td>
              </tr>
              <tr>

                <td style="text-align:right"> <label>{$lang.email_address}:</label></td>
                <td style="text-align:left"><input name="email" class="required" type="text" value="{$form.email}" /></td>
              </tr>
              <tr>

                <td style="text-align:right"> <label>{$lang.tax_id}:</label></td>
                <td style="text-align:left"><input name="taxid" class="required" type="text" value="{$form.taxid}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"> <label>{$lang.checks_payable}:</label></td>
                <td style="text-align:left"><input name="check" class="required" type="text" value="{$form.check}" /></td>
              </tr>

            </tbody></table> 
            </fieldset>
            </td>
          </tr>
        </tbody></table></td>
      </tr>
      <tr>

        <td><img src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td>
         <fieldset style="border:1px solid #e1e1e1;width:600px;margin-left:20px;">
              <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.company_details}</legend>
              <table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
              <tbody>
              <tr class="infoBoxContents">
                <td>
                <table border="0" cellpadding="2" cellspacing="2">
                  <tbody>
                <tr>
                    <td style="text-align:right"> <label>{$lang.company_name}: </label></td>
                    <td style="text-align:left"><input name="company" class="required" type="text" value="{$form.company}" /></td>
                </tr>
                <tr>
                    <td style="text-align:right"> <label>{$lang.website_url}:</label></td>
                    <td style="text-align:left"><input name="url" class="required" type="text" value="{$form.url}" /></td>
                </tr>
                </tbody>
                </table>
                </td>
              </tr>
            </tbody>
            </table>
        </fieldset>
        </td>

      </tr>
      <tr>
        <td><img src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td>
        <fieldset style="border:1px solid #e1e1e1;width:600px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.your_address}</legend>
        <table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td style="text-align:right"> <label>{$lang.street_address}: </label></td>
                <td style="text-align:left"><input name="address" class="required" type="text" value="{$form.address}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"> <label>{$lang.zip_code}:</label></td>
                <td style="text-align:left"><input name="zip" class="required" type="text" value="{$form.zip}"  /></td>
              </tr>

              <tr>
                <td style="text-align:right"> <label>{$lang.frontend_city}:</label></td>
                <td style="text-align:left"><input name="city" class="required" type="text" value="{$form.city}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"> <label>{$lang.state_province}:</label></td>
                <td style="text-align:left">

					<input name="state" class="required" type="text" value="{$form.state}" /></td>
              </tr>
              <tr>
               <td style="text-align:right"><label>{$lang.frontend_country}:</label></td>
                <td style="text-align:left">{include file="countries.tpl"}</td>

              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table>
        </fieldset>
        </td>
      </tr>
      <tr>
        <td><img src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td>
        <fieldset style="border:1px solid #e1e1e1;width:600px;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.your_contact_Info}</legend>
        <table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody><tr>
                <td style="text-align:right"> <label>{$lang.telephone_number}:</label></td>
                <td style="text-align:left"><input name="phone" class="required" type="text" value="{$form.phone}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"> <label>{$lang.fax_number}:</label></td>
                <td style="text-align:left"><input name="fax" type="text" value="{$form.fax}" />&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>

        </tbody></table>
        </fieldset>
        </td>
      </tr>
      <tr>
        <td><img src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td>
        <fieldset style="border:1px solid #e1e1e1;width:600px;margin-left:20px;" >
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;text-align:left;">{$lang.your_password}</legend>
        <table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="2">
              <tbody>
			<tr>
                <td style="text-align:right"> <label>{$lang.username}:</label></td>
                <td style="text-align:left"><input name="username" class="required" type="text" value="{$form.username}" readonly="readonly" /></td>
            </tr>
			<tr>
                <td style="text-align:right"> <label>{$lang.new_password}:</label></td>
                <td style="text-align:left"><input name="password"  maxlength="40" type="password" value="" /></td>
            </tr>
              <tr>
                <td style="text-align:right"> <label>{$lang.password_confirm}:</label></td>
                <td style="text-align:left"><input name="password2"  maxlength="40" type="password" value="" /></td>
              </tr>
              <tr>

                <td style="text-align:right"> <label>{$lang.aff_email_address}:</label></td>
                <td style="text-align:left"><input name="paypal_email" class="required" type="text" value="{$form.paypal_email}" /></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table>
        </fieldset>
        </td>

      </tr>
      <tr>
        <td><img src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tbody><tr>
                <td style="text-align:center" class="con_btn_cen" width="100%">
                <input src="file://///192.168.1.18/groupon/Ndotdeals_Unlimited_V3.5/themes/black/css/{$images}button_continue.gif" alt=" {$lang.continue} " title=" {$lang.continue} " border="0" type="image"></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
    </tbody></table>
	<input type="hidden" name="edit" value="1" />
</form>

{include file="footer.tpl"}
