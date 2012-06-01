<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

if($_POST)
{
	$countryname = htmlentities($_POST['countryname'], ENT_QUOTES);
	$queryString = "select * from coupons_country where countryname = '$countryname' ";
	$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			set_response_mes(-1, $admin_language['countryexist']); 		 
			$redirect_url = DOCROOT.'add/country/';
			url_redirect($redirect_url);
		}
		else
		{
			createCountry($countryname);
			set_response_mes(1, $admin_language['countryadded']); 		 
			$redirect_url = DOCROOT.'add/country/';
			url_redirect($redirect_url);
		}

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_createcountry").validate();});

$(document).ready(function(){ 
$(".toggleul_4").slideToggle(); 
document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});

</script>
<fieldset class="field border_no" style="margin-left:10px;">               
        <legend class="legend"><?php echo $admin_language['country']; ?></legend>	
        <form name="form_createcountry" id="form_createcountry" method="post" action="" class="coopen_form fl">
        
            <p>
            <label ><?php echo $admin_language['countryname']; ?></label><br />
            <input type="text" name="countryname" maxlength="50" value="" class="required" title="<?php echo $admin_language['entercountryname']; ?>" />
            </p>
        
               <div class="fl clr  mt10 width100p">
                <input type="submit" value="<?php echo $admin_language['submit']; ?>" class=" button_c">
                <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class=" button_c ml10">
              </div>
                        
        </form>
 </fieldset>
