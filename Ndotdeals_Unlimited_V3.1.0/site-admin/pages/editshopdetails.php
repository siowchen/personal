<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$userid = $_SESSION["userid"];

$shopid = $url_arr[3];

	$obj = new EditShop();
	$obj->editShopDetails($shopid);

if($_POST)
{

	$shopname = htmlentities($_POST['shopname'], ENT_QUOTES);
	$shopaddress = htmlentities($_POST['shopaddress'], ENT_QUOTES);
	$city = $_POST["city"];
	$country = $_POST['country'];
	$lat = htmlentities($_POST['lat'], ENT_QUOTES);
	$lang = htmlentities($_POST['lang'], ENT_QUOTES);
	$result = updateShop($shopid,$userid,$shopname,$shopaddress,$city,$country,$lat,$lang);
	$coopon_url = DOCROOT."admin/view/rep/shops/";
	set_response_mes(1, $admin_language['changesmodified']); 	
	url_redirect($coopon_url);

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_editshop").validate();});
</script>

<div class="form">
<div class="form_top"></div>
      <div class="form_cent"> 

<form name="form_editshop" id="form_editshop" method="post" action="" class="coopen_form fl" > 
<fieldset>

	<p>
	<label for=""><?php echo $admin_language['shopname']; ?></label><br />
	<input type="text" class="required" maxlength="50" title="<?php echo $admin_language['entertheshopname']; ?>"  name="shopname" value="<?php echo $obj->getshopname();?>" id="shopname" />
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopaddress']; ?></label><br />
		<textarea name="shopaddress"  class="required" title="<?php echo $admin_language['entertheshopaddress']; ?>"  id="shopaddress" rows="7" cols="35"><?php echo $obj->getshopaddress();?></textarea>
	</p>

	<p>
	<label for=""><?php echo $admin_language['googlemaplati']; ?></label><br />
	<input type="text" name="lat" id="lat" maxlength="25" value="<?php echo $obj->getshoplatitude();?>" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>
    
    <p>
	<label for=""><?php echo $admin_language['googlemaplong']; ?></label><br />
	<input type="text" name="lang" id="lang" maxlength="25" value="<?php echo $obj->getshoplongitude();?>" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopcountry']; ?></label><br />
	<select name="country" id="country"  class="required" title="<?php echo $admin_language['choosetheshopcountry']; ?>"  OnChange="shoploadcountry(this.value)">
	<option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($location = mysql_fetch_array($resultset)){
				?>
				<option value="<?php echo $location['countryid'];?>" <?php if($location['countryid'] == $obj -> getshopcountry()) echo 'selected = "selected"';?>><?php echo html_entity_decode($location["countryname"], ENT_QUOTES);?></option>
			<?php
				}
			?>
	</select>
	</p>

<p id="citytag">
 	  	<label for="dummy1"><?php echo $admin_language['location']; ?></label><br>
            <select name="city" id="city" OnChange="" class="required" title="<?php echo $admin_language['chooselocation']; ?>">
                   <option value="" >Choose </option>
			<?php
				
				$queryString = " select cityid,cityname from coupons_cities where status='A' and countryid =".$obj->getshopcountry();
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				?>
					<option value="<?php echo $loaction['cityid'];?>" <?php if($obj->getshopcity() == $loaction["cityid"]) echo 'selected = "selected"';?>><?php echo html_entity_decode($loaction["cityname"], ENT_QUOTES);?></option>
				<?php
				}
			?>
			</select>
            </p>
	<p id="dynamiclocation"></p>   
	   <?php
	   ?>

	   <div class="fl clr">
              <input type="submit" value="<?php echo $admin_language['update']; ?>" class=" button_c">
            </div>
            
</fieldset>
</form>

     </div>
<div class="form_bot"></div>
</div>
