<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

if($_POST)
{
	$cityname = htmlentities($_POST['city'], ENT_QUOTES);
	$city_url = htmlentities($_POST['permalink'], ENT_QUOTES);
	$country = $_POST['country'];
	$queryString = "select * from coupons_cities where countryid = '$country' and cityname='$cityname' ";
	$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			set_response_mes(-1,$admin_language['cityexist']); 		 
			$redirect_url = DOCROOT.'add/city/';
			url_redirect($redirect_url);
		}
		else
		{
			createCity($cityname,$city_url,$country);
			set_response_mes(1, $admin_language['cityadded']); 		 
			$redirect_url = DOCROOT.'add/city/';
			url_redirect($redirect_url);
		}

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_createcity").validate();});
</script>

<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_4").slideToggle(); 
document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>


<form name="form_createcity" id="form_createcity" method="post" action="" class="coopen_form fl">
<fieldset  style="width:715px;border:none !important">         
        <legend class="legend"><?php echo $admin_language['countrydetails']; ?></legend>	
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['countryname']; ?></label><br>
            <select class="required" name="country" title="<?php echo $admin_language['choosecountry']; ?>" id="country">
                   <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultSet = mysql_query($queryString);
				if(mysql_num_rows($resultSet)>0){
				while($loaction = mysql_fetch_array($resultSet)){
					echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
				}
				
			?>
			</select>
            </p>
	
	<p>
	<label for=""><?php echo $admin_language['cityname']; ?></label><br />
	<input type="text" name="city" maxlength="50" value=""  class="required" title="<?php echo $admin_language['entercityname']; ?>" onchange="generate_permalink(this.value,'deal_permalink');" />
	</p>
	
        <p>
	<label ><?php echo $admin_language['permalink']; ?></label><br />
	<input type="text" name="permalink" id="deal_permalink" maxlength="50" value=""  class="required" title="<?php echo $admin_language['permalink_required']; ?>" />
     <br />
			  <span class="quite"><?php echo $admin_language['permalink_ex']; ?></span>
	</p>


	   <div class="fl clr mt10 width100p">
	    <input type="submit" value="<?php echo $admin_language['submit']; ?>" class=" button_c">
	    <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class=" button_c ml10">
	  </div>
            	
</fieldset>
</form>
     </div>

</div>
