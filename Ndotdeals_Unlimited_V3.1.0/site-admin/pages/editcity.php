<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$cityid = $url_arr[3];
if($_POST)
{

	$country = $_POST['country'];
	$cityname = htmlentities($_POST['cityname'], ENT_QUOTES);
	$city_url = htmlentities($_POST['permalink'], ENT_QUOTES);
	$rep_city = $_POST['rep_city'];
	$cityid = $_POST['rep_city'];
	$result = mysql_query("select * from coupons_cities where cityname='$cityname' and countryid='$country' and cityid<>$cityid");
	if(mysql_num_rows($result) > 0){ 
		set_response_mes(-1, $admin_language['cityexist']); 		 
		$redirect_url = DOCROOT.'edit/city/'.$rep_city;
		url_redirect($redirect_url);
	}
	
	//update into database
	updateCity($cityname,$city_url,$country,$rep_city);
	set_response_mes(1, $admin_language['changesmodified']); 		 
	$redirect_url = DOCROOT.'manage/city/';
	url_redirect($redirect_url);
	
}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_editcity").validate();});
</script>

<?php

$queryString = " select * from coupons_cities where cityid=".$cityid." ";
$resultSet = mysql_query($queryString);
if(mysql_num_rows($resultSet)>0){
	while($result = mysql_fetch_array($resultSet)){
			$rscountryid = $result['countryid'];
		?>

<div class="form">
<div class="form_top"></div>
      <div class="form_cent">  

<form name="form_editcity" id="form_editcity" method="post" action="" class="coopen_form fl">
<fieldset class="border_no">
		<legend></legend>
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['countryname']; ?></label><br>
            <select class="required" name="country" title="<?php echo $admin_language['choosecountry']; ?>" id="country">
                   <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultSet = mysql_query($queryString);
				if(mysql_num_rows($resultSet)>0){
				while($loaction = mysql_fetch_array($resultSet)){
				?>

				<option value="<?php echo $loaction['countryid']; ?>" <?php if($loaction['countryid']==$rscountryid){ ?> selected="selected" <?php } ?>><?php echo html_entity_decode($loaction["countryname"], ENT_QUOTES); ?></option>

			<?php
				}
				}
				
			?>
			</select>
                <input type="hidden" name="rep_city" value="<?php echo $result['cityid']; ?>">
            </p>
	
	<p>
	<label for=""><?php echo $admin_language['cityname']; ?></label><br />
	<input type="text" name="cityname" maxlength="50" value="<?php echo html_entity_decode($result['cityname'], ENT_QUOTES); ?>"  class="required" title="<?php echo $admin_language['entercityname']; ?>" onchange="generate_permalink(this.value,'deal_permalink');" />
	</p>
	
        <p>
	<label ><?php echo $admin_language['permalink']; ?></label><br />
	<input type="text" name="permalink" id="deal_permalink" maxlength="50" value="<?php echo html_entity_decode($result['city_url'], ENT_QUOTES); ?>"  class="required" title="<?php echo $admin_language['permalink_required']; ?>" />
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
<div class="form_bot"></div>
</div>

<?php }
}?>
