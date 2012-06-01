{include file="header.tpl"}
<div class="affilite">
<h2>{$lang.create_new_account}</h2>
<b style="color:red; float:left;">{$msg} &nbsp;</b>
{php}echo "<script type='text/javascript'>$(document).ready(function(){ $('#register').validate();});</script>";{/php}

<form name="create_account" id="register" action="register.php" method="post" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	
    <tr>
		<td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
	</tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.personal_details}</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label>{$lang.first_name}:</label></td>
                <td style="text-align:left"><input name="firstname" class="required" title="Enter the first name" type="text" value="{$form.firstname}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"><label>{$lang.last_name}:</label></td>

                <td style="text-align:left"><input name="lastname" class="required" type="text" title="Enter the last name" value="{$form.lastname}" /></td>
              </tr>
              <tr>

                <td style="text-align:right"><label>{$lang.email_address}:</label></td>
                <td style="text-align:left"><input name="email" class="required" type="text" title="Enter the Email" value="{$form.email}" /></td>
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
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.company_details}</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label>{$lang.company_name}:</label></td>
                <td style="text-align:left"><input name="company" class="required" type="text" title="Enter the company name" value="{$form.company}" /></td>
              </tr>
              <tr>
                <td style="text-align:right"><label>{$lang.website_url}:</label></td>
                <td style="text-align:left"><input name="url" class="required url" type="text" title="Enter the website URL" value="{$form.url}" /></td>
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
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.your_address}</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                 <td style="text-align:right"><label>{$lang.street_address}:</label></td>
                <td style="text-align:left"><input name="address" class="required" type="text" title="Enter the address" value="{$form.address}" /></td>
              </tr>
              
              <tr>
                <td style="text-align:right"><label>{$lang.zip_code}:</label></td>
                <td style="text-align:left"><input name="zip"  class="required" type="text" title="Enter the zip-code" value="{$form.zip}" /></td>
              </tr>
              <tr>
				<td style="text-align:right"><label>{$lang.frontend_city}:</label></td>
                <td style="text-align:left"><input name="city" class="required" type="text" title="Enter the city" value="{$form.city}" /></td>
              </tr>
              <tr>
              	 <td style="text-align:right"><label>{$lang.state_province}:</label></td>
                <td style="text-align:left"><input name="state" class="required" title="Enter the state" type="text" value="{$form.state}" /></td>
              </tr>
               <tr>
                <td style="text-align:right"><label>{$lang.frontend_country}:</label></td>
                <td style="text-align:left">{include file="countries.tpl"}</td>

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
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.your_contact_Info}</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right"><label>{$lang.telephone_number}:</label></td>
                <td style="text-align:left"><input name="phone" class="required" title="Enter the phone number" type="text" value="{$form.phone}" /></td>
              </tr>
              
               <tr>
                <td style="text-align:right"><label>{$lang.fax_number}:</label></td>
                <td style="text-align:left"><input name="fax" type="text" value="{$form.fax}" />&nbsp;</td>
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
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      <tr>
        <td><table class="register_table" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <fieldset style="border:1px solid #e1e1e1;width:620px;">
               <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">{$lang.your_password}</legend>
            <table border="0" cellpadding="2" class="register_table" cellspacing="2">
              <tbody>
              <tr>
                <td style="text-align:right" ><label>{$lang.username}:</label></td>
                <td style="text-align:left"><input name="username" class="required" title="Enter the user name" type="text" value="{$form.username}" /></td>
            </tr>
             <tr>
                <td style="text-align:right"><label>{$lang.password}:</label></td>
                <td style="text-align:left"><input name="password" class="required" maxlength="40" title="Enter the password" type="password" value="{$form.password}" /></td>
            </tr>
              <tr>
                <td style="text-align:right"><label>{$lang.password_confirm}:</label></td>
                <td style="text-align:left"><input name="password2" class="required" maxlength="40" type="password"  title="Enter the password" value="{$form.password}" /></td>
              </tr>
               <tr>
                <td style="text-align:right"><label>{$lang.aff_email_address}:</label></td>
                <td style="text-align:left"><input name="aemail" class="required email" type="text" title="Enter the affiliate email address" value="{$form.aemail}" /></td>
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
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%" /></td>
      </tr>
      
      
      
       <tr>
        <td>
        <table  border="0" class="register_table infoBox"  cellpadding="2" cellspacing="1" width="100%">
          <tbody>
          <tr class="infoBoxContents">
            <td>
            <table border="0" cellpadding="2" cellspacing="0" class="register_table" width="100%">
              <tbody>
              <tr style="text-align:left;">
                <td style="text-align:center;" width="100%" >
                <input  src="{$images}button_continue.gif" alt=" {$lang.continue} " title=" {$lang.continue} "  type="image" /></td>
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
{include file="footer.tpl"}
