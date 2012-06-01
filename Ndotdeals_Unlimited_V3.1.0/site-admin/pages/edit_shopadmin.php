<?php 
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<!--<script type="text/javascript">
jQuery.validator.addMethod('mobile', function(value) {
var numbers = value.split(/\d/).length - 1;
return (5 <= numbers && numbers <= 16 && value.match(/^(\+){0,1}(\d|\s|\(|\)|\-){5,16}$/)); }, 'Please enter a valid mobile number');
</script>-->

<?php
if($_POST)
{

	if($_SESSION["userrole"]==1 || $_SESSION["userrole"]==2)
		$user_id = $url_arr[4];
	else
		$user_id = $_SESSION['userid'];

	$firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
	$lastname = htmlentities($_POST['lastname'], ENT_QUOTES);
	$email = htmlentities($_POST['email'], ENT_QUOTES);
	$mobile = htmlentities($_POST['mobile'], ENT_QUOTES);
	$address = htmlentities($_POST['address'], ENT_QUOTES);
	$pay_account = htmlentities($_POST['pay_account'], ENT_QUOTES);
	$country = $_POST['country'];
	$city = $_POST['city'];
	$shopid = $_POST['shopid'];
	$shopname = htmlentities($_POST['shopname'], ENT_QUOTES);
	$shopaddress = htmlentities($_POST['shopaddress'], ENT_QUOTES);
	$lat = htmlentities($_POST['lat'], ENT_QUOTES);
	$lang = htmlentities($_POST['lang'], ENT_QUOTES);
	$shopurl = htmlentities($_POST['shopurl'], ENT_QUOTES);

       	//check email address already exist
	$resultSet2 = mysql_query("select * from coupons_users where email='$email' and userid<>$user_id");
	if(mysql_num_rows($resultSet2) > 0)
	{			
		set_response_mes(-1, $admin_language['emailexisttry']);
		
		if($_SESSION['userrole'] =='1' || $_SESSION["userrole"]==2)
	        {
	                $redirect_url = DOCROOT.'admin/rep/shopadmin/';
	        }
	        else
	        {
	                $redirect_url = DOCROOT.'admin/profile/';
	        } 
		url_redirect($redirect_url);	
	}
        
        $queryString = "select * from coupons_shops where shopname = '$shopname' and shop_city = '$city' and shopid<>'$shopid'";
	$resultSet = mysql_query($queryString);
       // mysql_num_rows($resultSet);
	if(mysql_num_rows($resultSet)>0)
	{
                set_response_mes(-1, $admin_language['shopnameexist']); 		 
                $redirect_url = DOCROOT.'admin/edit/SA/'.$user_id.'/';
                url_redirect($redirect_url);
        }
	//admin have rights to change shop location
	if($_SESSION["userrole"]==1) {

		$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', user_shopid='$shopid', country = '$country', city ='$city',pay_account='$pay_account' where userid= '$user_id'";
		mysql_query($queryString) or die(mysql_error());

		$queryString = "update coupons_shops set shopname='$shopname',shop_address='$shopaddress',shop_city='$city',shop_country='$country',shop_latitude ='$lat',shop_longitude='$lang',shop_url='$shopurl' where shopid = '$shopid'";
		mysql_query($queryString) or die(mysql_error());

	}
	else {

		$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', user_shopid='$shopid',pay_account='$pay_account' where userid= '$user_id'";
		mysql_query($queryString) or die(mysql_error());

		$queryString = "update coupons_shops set shopname='$shopname',shop_address='$shopaddress',shop_latitude ='$lat',shop_longitude='$lang',shop_url='$shopurl' where shopid = '$shopid'";
		mysql_query($queryString) or die(mysql_error());

	}

	                        if(isset($_FILES["logo"]))
	                        {
	                                $logo_id = $shopid.'.jpg';
                               
	                               if($_FILES["logo"]["error"] > 0)
	                                {

	                                }
	                                
	                                else if($_FILES['logo']['type']== "image/jpg" || $_FILES['logo']['type']== "image/jpeg" || $_FILES['logo']['type']== "image/png" || $_FILES['logo']['type']== "image/gif")
	                                {
                                                if(is_uploaded_file($_FILES['logo']['tmp_name']))
		                                {

                                                        $targetFile = DOCUMENT_ROOT.'/uploads/logo_images/'.$logo_id;
		                                        move_uploaded_file($_FILES['logo']['tmp_name'],$targetFile); 

		                                }
                                        }
	                        }


		set_response_mes(1,$admin_language['changesmodified']); 		 
		if($_SESSION['userrole'] =='1' || $_SESSION["userrole"]==2)
	        {
	                $redirect_url = DOCROOT.'admin/rep/shopadmin/';
	        }
	        else
	        {
	                $redirect_url = DOCROOT.'admin/profile/';
	        } 		 
		url_redirect($redirect_url);	
	
}
?>

<?php
	if($_SESSION["userrole"]==1 || $_SESSION["userrole"]==2)
		$uid = $url_arr[4];
	else
		$uid = $_SESSION['userid'];


	$resultSet = mysql_query("SELECT * FROM coupons_users u left join coupons_shops s on s.shopid=u.user_shopid where userid='$uid'");

		if(mysql_num_rows($resultSet))
		{
			$row=mysql_fetch_array($resultSet);
		}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#userinfo_edit_form").validate();});
</script>

        <form name="userinfo_edit_form" id="userinfo_edit_form" action="" method="post" class="coopen_form" enctype="multipart/form-data">
           
             <input type="hidden" class="title" name="role" id="role" value="<?php echo strtoupper($url_arr[3]); ?>">
            <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['generaldetail']; ?></legend>
	    <p>
              <label for="dummy1"><?php echo $admin_language['firstname']; ?></label><br>
              <input type="text"  maxlength="30" minlength="3" class="required text" title="<?php echo $admin_language['enterfirstname']; ?>" id="firstname" name="firstname" 
value="<?php echo html_entity_decode($row['firstname'], ENT_QUOTES);?>">
             </p>
             
	    <p>
              <label for="dummy1"><?php echo $admin_language['lastname']; ?></label><br>
              <input type="text"  maxlength="30" minlength="3" class="required text" id="lastname" title="<?php echo $admin_language['enterlastname']; ?>" name="lastname" 
value="<?php echo html_entity_decode($row['lastname'], ENT_QUOTES);?>">
              </p>
              
              <p>
              <label for="dummy1"><?php echo $admin_language['email']; ?></label><br>
              <input type="text" class="required email text" title="<?php echo $admin_language['enteremailaddress']; ?>" id="email" name="email" value="<?php echo $row['email'];?>">
              </p>
	    
	    <p>
              <label for="dummy1"><?php echo $admin_language['mobile']; ?></label><br>
              <input type="text" class="mobile" title="<?php echo $admin_language['entermobileno']; ?>" id="mobile" name="mobile" value="<?php echo $row['mobile'];?>" maxlength="16" >
              <label for="dummy1">(Optional) Please specify your country code in your phone number</label>
              </p>
            
              <p>
              <label for="dummy2"><?php echo $admin_language['address']; ?></label><br>
              <textarea name="address" id="address" class="required" title="<?php echo $admin_language['enteraddress']; ?>" rows="7" cols="35"><?php echo html_entity_decode($row['address'], ENT_QUOTES);?></textarea>
              </p>
              <p>
              <label for="dummy3"><?php echo $admin_language['paypalaccount']; ?></label><br>
              <input type="text" class="required email" title="<?php echo $admin_language['enterpaypalaccount']; ?>" id="pay_account" name="pay_account" value="<?php echo html_entity_decode($row['pay_account'], ENT_QUOTES); ?>" maxlength="50" />
	      </p>
            </fieldset>
                   
	                  
<?php if(strtolower($url_arr[3])=="sa") { ?>

	<input type="hidden" name="shopid" id="shopid" value="<?php echo $row['shopid']; ?>" >
<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['shopdetails']; ?></legend>
	<p>
	<label for=""><?php echo $admin_language['shopname']; ?></label><br />
	<input type="text" name="shopname" maxlength="50" value="<?php echo html_entity_decode($row['shopname'], ENT_QUOTES);?>" class="required" title="<?php echo $admin_language['entertheshopname']; ?>" id="shopname" />
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopaddress']; ?></label><br />
	<textarea name="shopaddress"  class="required" title="<?php echo $admin_language['entertheshopaddress']; ?>"  id="shopaddress" rows="7" cols="35"><?php echo html_entity_decode($row['shop_address'], ENT_QUOTES);?></textarea>
	</p>

	<p>
	<label for=""><?php echo $admin_language['googlemaplati']; ?></label><br />
	<input type="text" name="lat" id="lat" maxlength="25" value="<?php echo html_entity_decode($row['shop_latitude'], ENT_QUOTES);?>" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>
    
	<p>
	<label for=""><?php echo $admin_language['googlemaplong']; ?></label><br />
	<input type="text" name="lang" id="lang" maxlength="25" value="<?php echo html_entity_decode($row['shop_longitude'], ENT_QUOTES);?>" /> <span style="color:#ff9f00;"><?php echo $admin_language['optional']; ?></span>
	</p>

	<p>
	<label for=""><?php echo $admin_language['shopurl']; ?></label><br />
	<input type="text" name="shopurl" id="shopurl" maxlength="100" value="<?php echo html_entity_decode($row['shop_url'], ENT_QUOTES);?>" class="required url" title="Enter the URL" /> 
	</p>

    <p>
      <label for="dummy3"><?php echo $admin_language['shoplogo']; ?></label><br>
      <input type="file" class="text" name="logo" id="logo" value="" >
    </p>
</fieldset>
  <?php } ?>
          

          <?php if(($url_arr[3]=='SA' && $_SESSION['userrole']=='1') || $url_arr[3]=='AD') { ?>
          
          
        <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['countrydetails']; ?></legend>               
            <p>
 	  <label for="dummy1"><?php echo $admin_language['country']; ?></label><br>
            <select class="required" title="<?php echo $admin_language['choosecountry']; ?>" name="country" id="country" OnChange="loadcountry(this.value,'<?php echo strtolower($url_arr[3]); ?>');" >
            <option value="" ><?php echo $admin_language['choose']; ?> </option>
                              
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($location = mysql_fetch_array($resultset)){
				?>	
				<option value="<?php echo $location['countryid'];?>" <?php if($location['countryid'] == $row['country']) echo 'selected = "selected"';?>><?php echo html_entity_decode($location['countryname'], ENT_QUOTES);?></option>
				
<?php
				}
			?>
	  </select>
            </p>
<div id="dynamiclocation"></div>

<p id="citytag">
 	  	<label for="dummy1"><?php echo $admin_language['location']; ?></label><br>
            <select name="city" id="city" class="required" title="Choose the location">
                   <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select cityid,cityname from coupons_cities where status='A' and countryid =".$row['country'];
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				?>
					<option value="<?php echo $loaction['cityid'];?>" <?php if($row['city'] == $loaction["cityid"]) echo 'selected = "selected"';?>><?php echo html_entity_decode($loaction["cityname"], ENT_QUOTES);?></option>
				<?php
				}
			?>
			</select>
            </p>  
</fieldset>
 <?php
             }
             ?>

           <div class="fl clr mt10 width100p"> <?php  
                if($_SESSION['userrole'] =='1' || $_SESSION['userrole'] =='2')
	        {
	                $cancel_url = DOCROOT.'admin/rep/shopadmin/';
	        }
	        else
	        {
	                $cancel_url = DOCROOT.'admin/profile/';
	        }
             ?>
              <input type="submit" value="<?php echo $admin_language['update']; ?>" class="button_c">
              <input type="button" onclick="javascript:window.location='<?php echo $cancel_url; ?>'" value="<?php echo $admin_language['cancel']; ?>" class=" ml10 button_c">
            </div>

        </form>

