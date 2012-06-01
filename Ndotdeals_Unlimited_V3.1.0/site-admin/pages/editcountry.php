<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$countryid = $url_arr[3];
if($_POST)
{
	$countryname = htmlentities($_POST['countryname'], ENT_QUOTES);
	$countryid = $_POST['countryid'];
	$queryString = "select * from coupons_country where countryname = '$countryname' and countryid<>$countryid";
	$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			set_response_mes(-1, $admin_language['countryexist']); 		 
			$redirect_url = DOCROOT.'edit/country/'.$countryid.'/';
			url_redirect($redirect_url);
		}
		else
		{
			updateCountry($countryname,$countryid);
			set_response_mes(1, $admin_language['changesmodified']); 		 
			$redirect_url = DOCROOT.'manage/country/';
			url_redirect($redirect_url);
		}

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_editcountry").validate();});
</script>

<div class="form">
<div class="form_top"></div>
      <div class="form_cent">  
<form name="form_editcountry" id="form_editcountry" method="post" action="" class="coopen_form fl">
<fieldset class="border_no">
	<p>
	<label><?php echo $admin_language['countryname']; ?></label><br />
	<input type="text" name="countryname" maxlength="50" value="<?php echo getCountry($countryid); ?>"  class="required" title="<?php echo $admin_language['entercountryname']; ?>" />
	<input type="hidden" value="<?php echo $countryid; ?>" name="countryid" />
	</p>

	   <div class="fl clr mt5">
	    <input type="submit" value="<?php echo $admin_language['update']; ?>" class=" button_c">
	  </div>
            	
</fieldset>
</form>
     </div>
<div class="form_bot"></div>
</div>
