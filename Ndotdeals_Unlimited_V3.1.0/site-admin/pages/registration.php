<?php 
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<!--<script type="text/javascript">
jQuery.validator.addMethod('mobile', function(value) {
var numbers = value.split(/\d/).length - 1;
return (5 <= numbers && numbers <= 16 && value.match(/^(\+){0,1}(\d|\s|\(|\)|\-){5,16}$/)); }, 'Please enter a valid mobile number');
</script>
-->

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
if($url_arr[3]=='cm')
{?>
<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_103").slideToggle();
document.getElementById("left_menubutton_103").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>
<?php
}
else if($url_arr[3]=='sa')
{?>
<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_99").slideToggle();
document.getElementById("left_menubutton_99").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>
<?php
}
?>

	<script type="text/javascript">
	/* validation */
	$(document).ready(function(){ $("#registration_form").validate();});
	</script>

	<script type="text/javascript">
	$.validator.addMethod('phone', function(value) {
	var numbers = value.split(/\d/).length - 1;
	return (9 <= numbers && numbers <= 20 && value.match(/^(\+){0,1}(\d|\s|\(|\)|\-){9,20}$/)); }, 'Please enter a valid phone number');
	</script>
<?php
$action_url = DOCROOT.'site-admin/pages/adduser.php';
?>
        <form name="registration_form" id="registration_form" action="<?php echo $action_url; ?>" method="post" enctype="multipart/form-data">
                   
             <input type="hidden" class="title" name="role" id="role" value="<?php echo strtoupper($url_arr[3]); ?>">
<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['logininform']; ?></legend>	
            <p>
              <label for="dummy0"><?php echo $admin_language['username']; ?></label><br>
              <input type="text" class="required" title="<?php echo $admin_language['enterusernameinalphanumeric']; ?>" name="username" id="usernameval" value="" onblur="checkusername(this.value)" maxlength="50" /><br>
	      <span id="unameavilable" class="validerror" style="color:red"> </span>
            </p>
	    <p>
              <label for="dummy3"><?php echo $admin_language['password']; ?></label><br>
              <input type="password" class="required" title="<?php echo $admin_language['enterpassword']; ?>" id="password" name="password" value="" maxlength="50" />
            </p>
	   <p>
              <label for="dummy3"><?php echo $admin_language['confirmpassword']; ?></label><br>
              <input type="password" class="required" equalTo="#password" title="<?php echo $admin_language['entertheconfirmpassword']; ?>" id="repassword" name="repassword" value="" maxlength="50" />
            </p>
</fieldset>
	<!-- Pay account -->
<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['paypalaccount']; ?></legend>	
	  <p>
              <label for="dummy3"><?php echo $admin_language['paypalaccount']; ?></label><br>
              <input type="text" class="required email" title="<?php echo $admin_language['enterpaypalaccount']; ?>" id="pay_account" name="pay_account" value="" maxlength="50" />
	   </p>
</fieldset>

<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['personalinform']; ?></legend>	
	   <p>
              <label for="dummy1"><?php echo $admin_language['firstname']; ?></label><br>
              <input type="text"  maxlength="30" minlength="3"  class="required nospecialchars" title="<?php echo $admin_language['enterfirstname']; ?>" id="firstname" name="firstname" value="" />
            </p>
	   <p>
              <label for="dummy1"><?php echo $admin_language['lastname']; ?></label><br>
              <input type="text"  maxlength="30" minlength="3" class="required nospecialchars" title="<?php echo $admin_language['enterlastname']; ?>" id="lastname" name="lastname" value="" />
            </p>

            <p>
              <label for="dummy1"><?php echo $admin_language['email']; ?></label><br>
              <input type="text" class="required email" title="<?php echo $admin_language['enteremailaddress']; ?>" id="email" name="email" value="" onblur="checkeamil(this.value)" maxlength="100" /><br>
	       <span id="emailavilable" class="validerror" style="color:red"> </span>
            </p>

	    <p>
              <label for="dummy1"><?php echo $admin_language['mobile']; ?></label><br>
              <input type="text" class="mobile" title="<?php echo $admin_language['entermobileno']; ?>" id="mobile" name="mobile" value="" maxlength="16" />
              <label for="dummy1">(Optional) Please specify your country code in your phone number</label>
            </p>
            <p>
              <label for="dummy2"><?php echo $admin_language['address']; ?></label><br>
              <textarea name="address" id="address" class="required" title="<?php echo $admin_language['enteraddress']; ?>" rows="7" cols="35"></textarea>
            </p>

        <?php if($url_arr[3]=="sa") { ?>
        <fieldset class="field1">         
        <legend class="legend1"><?php echo $admin_language['shopinform']; ?></legend>	
	<p>
	<label for=""><?php echo $admin_language['shopname']; ?></label><br />
	<input type="text" name="shopname" maxlength="50" value=""  class="required" title="<?php echo $admin_language['entertheshopname']; ?>" id="shopname" />
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopaddress']; ?></label><br />
	<textarea name="shopaddress"  class="required" title="<?php echo $admin_language['entertheshopaddress']; ?>"  id="shopaddress" rows="7" cols="35"></textarea>
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopurl']; ?></label><br />
	<input type="text" name="shopurl" class="required url" id="shopurl" maxlength="100" title="Enter the URL" /> 
	</p>

            <p>
              <label for="dummy3"><?php echo $admin_language['shoplogo']; ?></label><br>
	      <input type="file" class="text" name="logo" id="logo" value="" > <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
            </p>

            <p id="countrylist">
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label><br>
            <select name="country" class="required" title="<?php echo $admin_language['choosecountry']; ?>" id="country" OnChange="loadcountry(this.value,'<?php echo $url_arr[3]; ?>');" >
                   <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				if($_SESSION['userrole']==1){
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				}
				else{
				$queryString = " select countryid,countryname from coupons_country where status ='A' and countryid='".$_SESSION["countryid"]."' order by countryname asc ";
}
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
					echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
			?>
			</select>
            </p>
	    <div id="dynamiclocation"></div>
          </fieldset>
              <fieldset class="field1">         
        <legend class="legend1"><?php echo $admin_language['googlesetting']; ?></legend>	
          <p>
	<label for=""><?php echo $admin_language['googlemaplati']; ?></label><br />
	<input type="text" name="lat" id="lat" maxlength="25" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>
    
	<p>
	<label for=""><?php echo $admin_language['googlemaplong']; ?></label><br />
	<input type="text" name="lang" id="lang" maxlength="25" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>
	</fieldset>	
          <?php 
	} 
	else { ?>
                           
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label><br>
            <select name="country" class="required" title="<?php echo $admin_language['choosecountry']; ?>" id="country" OnChange="loadcountry(this.value,'cmreg');" >
                   <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
					echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
			?>
			</select><br>
                <span id="countryerror" style="color:red"> </span>
            </p>
	    <div id="dynamiclocation"></div>
          <?php } ?>
          </fieldset>

	

	  <div class="fl clr mt10 width100p">	
              <input style="margin-left:10px;" type="submit" value="<?php echo $admin_language['submit']; ?>" class="button_c">
              <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class="ml10 button_c">	  
            </div>
        </form>
        

