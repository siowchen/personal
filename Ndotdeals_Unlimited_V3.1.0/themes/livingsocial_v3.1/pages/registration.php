<?php 
if($_SESSION["userid"])
{
	url_redirect(DOCROOT."profile.html");
}

$url_array = explode('=',$_SERVER['REQUEST_URI']);
if(isset($url_array[1]))
{
        $_SESSION['referral_id'] = $url_array[1];
}
?>



<script type="text/javascript">
/* validation */
$(document).ready(function(){$("#registration_form").validate();});</script>
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/_base_theme/scripts/common.js" ></script>
<script type="text/javascript">
$(function() {
  //username validation to allow only alphanumeric
  $('#usernameval').keyup(function() {

      //cache input and value
      var input = $('#usernameval');
      var value = $('#value');

      // only allow letters, numbers, don't allow spaces
      var tempVal = input.val().match(/[A-Za-z0-9]+/g);
      tempVal = tempVal == null ? "" : tempVal.join("");

      // display formatted input
      input.val(tempVal);
      //value.html(tempVal);
  });
});
</script>
<?php
$action_url = DOCROOT.'themes/_base_theme/pages/adduser.php';
?>


<div class="work_bottom1">

       <!--  <form name="registration" id="registration"  action="<?php echo $action_url; ?>"  method="post"  >  -->
       
       
           <form name="registration_form" id="registration_form" action="<?php echo $action_url; ?>" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="5" cellspacing="5"  align="center">
		<tr>
		<td align="right" valign="middle"><label><?php echo $language['username']; ?> : </label></td>
		<td>
		<!--<input type="text" class="input_box required nospecialchars" name="username" title="<?php echo $language['valid_username']; ?>" id="usernameval" onblur="checkusername(this.value)" maxlength="50" value=""  />
		 <span id="unameavilable" class="validerror" style="color:red"> </span>   -->
		 
		 
		   <input type="text" class="required" title="<?php echo $language['enterusernameinalphanumeric']; ?>" name="username" id="usernameval" value="" onblur="checkusername(this.value)" maxlength="50" /><br />
	      <span id="unameavilable" class="validerror" style="color:red"> </span>
	      
	      
		</td>
		</tr>

		<tr>
		<td align="right" valign="middle"><label><?php echo $language['password']; ?> : </label></td>
		<td><input type="password" class="input_box required" name="password" id="password" title="<?php echo $language['valid_password']; ?>" /></td>
		</tr>
		<tr>
		<td align="right" valign="middle"><label><?php echo $language['first_name']; ?> : </label></td>
		<td><input type="text" class="input_box required nospecialchars" name="firstname" id="firstname" title="<?php echo $language['valid_firstname']; ?>" /></td>
		</tr>

		<tr>
		<td align="right" valign="middle"><label><?php echo $language['last_name']; ?> : </label></td>
		<td><input type="text" class="input_box required nospecialchars" name="lastname" id="lastname" title="<?php echo $language['valid_lastname']; ?>" /></td>
		</tr>

		<tr>
		<td align="right" valign="middle"><label><?php echo $language['email']; ?> : </label></td>
		<td>
		<!-- <input type="text" class="input_box required email" name="email" id="email" title="<?php echo $language['valid_email']; ?>" />  -->
		
		<input type="text" class="email required" title="<?php echo $language['enteremailaddress']; ?>" id="email" name="email" value="" onblur="checkeamil(this.value)" maxlength="100" /><br />
	       <span id="emailavilable" class="validerror" style="color:red"> </span>
		
		</td>
		</tr>
		<tr>
		<td align="right" valign="middle"><label><?php echo $language['mobile']; ?> : </label></td>
		<td><input type="text" class="input_box" name="mobile" id="mobile" title="<?php echo $language['valid_mobile']; ?>" /></td>
		</tr>
		<tr><td>&nbsp;</td><td><span class="quit"><?php echo $language['optional_mobile']; ?></span></td></tr>
		<tr>
		<td>&nbsp;</td>
		<td>
        	<div class="signup_now">
			<div class="submit">
		
            <input type="submit" name="signup" value="<?php echo $language['signup']; ?>" class="bnone"/>
          
			</div>
			<div class="reset">
			
           <input type="reset" class="bnone" value="<?php echo $language['reset']; ?>" />
        
			
			</div>
               
	      
          	</div>      
		</td>
		</tr>
		</table>           

        </form>
</div>
