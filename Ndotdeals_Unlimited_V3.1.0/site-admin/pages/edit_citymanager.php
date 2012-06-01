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

	if($_SESSION["userrole"]==1)
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
	
	//check email address already exist
	$resultSet2 = mysql_query("select * from coupons_users where email='$email' and userid<>$user_id");
	if(mysql_num_rows($resultSet2) > 0)
	{			
		set_response_mes(-1, $admin_language['emailexisttry']);
		
		if($_SESSION['userrole'] =='1')
		$redirect_url = DOCROOT.'admin/rep/citymgr';		 
		else
		$redirect_url = DOCROOT.'admin/profile/';
		url_redirect($redirect_url);	
	}
	
	//admin have rights to change city admin location details
	if($_SESSION["userrole"]==1) {

		$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address',country = '$country',city = '$city',pay_account ='$pay_account' where userid= '$user_id'";
		mysql_query($queryString) or die(mysql_error());

	}
	else
	{

		$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address',pay_account ='$pay_account' where userid= '$user_id'";
		mysql_query($queryString) or die(mysql_error());

	}

	set_response_mes(1,$admin_language['changesmodified']); 	
	if($_SESSION['userrole'] =='1')
	{
	        $redirect_url = DOCROOT.'admin/rep/citymgr';
	}
	else
	{
	        $redirect_url = DOCROOT.'admin/profile/';
	}
	url_redirect($redirect_url);	
	
}
?>

<?php
	if($_SESSION["userrole"]==1)
		$uid = $url_arr[4];
	else
		$uid = $_SESSION['userid'];

	$resultSet = mysql_query("SELECT * FROM coupons_users where userid='$uid'");

		if(mysql_num_rows($resultSet))
		{
			$row=mysql_fetch_array($resultSet);
		}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#userinfo_edit_form").validate();});
</script>

        <form name="userinfo_edit_form" id="userinfo_edit_form" action="" method="post" class="coopen_form">
           
             <input type="hidden" class="title" name="role" id="role" value="<?php echo strtoupper($url_arr[3]); ?>">
            <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['generaldetail']; ?></legend>
	    <p>
              <label for="dummy1"><?php echo $admin_language['firstname']; ?></label><br>
              <input type="text" class="required text"  maxlength="30" minlength="3" title="<?php echo $admin_language['enterfirstname']; ?>" id="firstname" name="firstname" 
value="<?php echo html_entity_decode($row['firstname'], ENT_QUOTES);?>">
             </p>
             
	    <p>
              <label for="dummy1"><?php echo $admin_language['lastname']; ?></label><br>
              <input type="text" class="required text"  maxlength="30" minlength="3" id="lastname" title="<?php echo $admin_language['enterlastname']; ?>" name="lastname" 
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
              <!-- Pay account -->
	      <p>
              <label for="dummy3"><?php echo $admin_language['paypalaccount']; ?></label><br>
              <input type="text" class="required email" title="<?php echo $admin_language['enterpaypalaccount']; ?>" id="pay_account" name="pay_account" value="<?php echo html_entity_decode($row['pay_account'], ENT_QUOTES); ?>" maxlength="50" />
	      </p>
              
<?php if($url_arr[3]=='CM' && $_SESSION['userrole']=='1') { ?>


<p>
 	  <label for="dummy1"><?php echo $admin_language['country']; ?></label><br>
            <select class="required" title="<?php echo $admin_language['choosecountry']; ?>" name="country" id="country" OnChange="loadcountry(this.value,'editcm');" >
            <option value="" ><?php echo $admin_language['choose']; ?></option>
                              
			<?php
				$queryString = " select countryid,countryname from coupons_country where status ='A' order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($location = mysql_fetch_array($resultset)){
				?>	
				<option value="<?php echo $location['countryid'];?>" <?php if($location['countryid'] == $row['country']) echo 'selected = "selected"';?>><?php echo html_entity_decode($location['countryname'], ENT_QUOTES);?></option>
				
				<?php } ?>

	  </select>
            </p>

	<div id="dynamiclocation"></div>

	<p id="edit_cm_citytag">
 	  	<label for="dummy1" class=""><?php echo $admin_language['location']; ?></label><br>
            <select name="city" id="city" class="required" title="<?php echo $admin_language['chooselocation']; ?>">
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
 <?php
             }
             ?>

           <div class="fl clr mt10 width100p"> <?php
                if($_SESSION['userrole'] =='1')
	        {
	                $cancel_url = DOCROOT.'admin/rep/citymgr';
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
    

