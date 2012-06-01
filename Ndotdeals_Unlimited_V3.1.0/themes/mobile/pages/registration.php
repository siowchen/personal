<script type="text/javascript">

var win2;
function fbconnect(docroot){

  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
  checkChild();  
    
}

function checkChild() {
	  if (win2.closed) {
		window.location.reload(true);
	  } else setTimeout("checkChild()",1);
}


</script>

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

	if($_POST)
	{

		if($_POST["username"]==$language['valid_username'] || $_POST["password"]==$language['valid_password'] || $_POST["firstname"]==$language['valid_firstname'] || $_POST["lastname"]==$language['valid_lastname'] || $_POST["email"]==$language['valid_email']){

				set_response_mes(-1,'All fields are mandatory');
				url_redirect(DOCROOT."registration.html");

		}

		$username = htmlentities($_POST["username"], ENT_QUOTES);
		$password = md5($_POST["password"]);
		$firstname = htmlentities($_POST["firstname"], ENT_QUOTES);
		$lastname = htmlentities($_POST["lastname"], ENT_QUOTES);
		$email = $_POST["email"];
		$mobile = htmlentities($_POST["mobile"], ENT_QUOTES);
		
		//check user availability 
		$result = mysql_query("select * from coupons_users where username='$username'");
		if(mysql_num_rows($result) == 0)
		{
			//check email address already exist
			$resultSet = mysql_query("select * from coupons_users where email='$email'");
			if(mysql_num_rows($resultSet) > 0)
			{			
				set_response_mes(-1, $language['reg_email_exist']);
				url_redirect(DOCROOT."registration.html");
			}		

			$ranval = referral_ranval();
			$query = "insert into coupons_users(username,password,firstname,lastname,email,mobile,user_role,user_status,referral_id) values('$username','$password','$firstname','$lastname','$email','$mobile','4','A','$ranval')";
			$res = mysql_query($query) or die(mysql_error());
			$last_insert_id = mysql_insert_id();
			
			//insert referal list
			if(!empty($_SESSION['referral_id']))
			{
				$referral_id = $_SESSION['referral_id'];
				$resultSet = mysql_query("select * from coupons_users where referral_id='$referral_id'");
				
				if(mysql_num_rows($resultSet) > 0)
				{
				
					while($row = mysql_fetch_array($resultSet))
					{
						$userid = $row['userid'];
					}

					mysql_query("insert into referral_list (reg_person_userid,referred_person_userid,deal_bought_count) values ('$last_insert_id','$userid','0')");

					$_SESSION['referral_id']='';	
											
				}
				

			}
			
			
			if($last_insert_id)
			{
			
			        $logo = DOCROOT."site-admin/images/logo.png";
				// Send mail to user regarding successfull registration
				$from = SITE_EMAIL;
				$to = $_POST["email"];
				$name = $_POST["firstname"];

				//getting subject and description variables
				$subject = $email_variables['registration_subject'];
				$description = 	$email_variables['registration_description'];
                                $description = str_replace("USERNAME",$_POST["username"],$description);
                                $description = str_replace("PASSWORD",$_POST["password"],$description);
	  
	                        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	                        	
                                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                                
                                $str = str_replace("SITEURL",$docroot,$str);
                                $str = str_replace("SITELOGO",$logo,$str);
                                $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
                                $str = str_replace("MESSAGE",ucfirst($description),$str);
                                $str = str_replace("SITENAME",SITE_NAME,$str);

				$message = $str;
				
				$SMTP_USERNAME = SMTP_USERNAME;
				$SMTP_PASSWORD = SMTP_PASSWORD;
				$SMTP_HOST = SMTP_HOST;
				$SMTP_STATUS = SMTP_STATUS;	
				
				if($SMTP_STATUS==1)
				{
	
					include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
				}
				else
				{
			     		// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					// Additional headers
					$headers .= 'From: '.$from.'' . "\r\n";
					mail($to,$subject,$message,$headers);	
				}
			
				set_response_mes(1,$language['registration_success']);
				url_redirect(DOCROOT."login.html");
			}
		}
		else
		{
			set_response_mes(-1,$language['username_exists']);
			url_redirect(DOCROOT."registration.html");
		}
	}
?>
<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#registration").validate();});

</script>


    <div class="mobile_content">
     <form name="registration" id="registration" action="" method="post"  >
      <div class="sign">
        <ul>
          <li>
            <input type="text" class="required" name="username" id="username" title="<?php echo $language['valid_username']; ?>" />
          </li>
          <li>
            <input type="password" class="required" name="password" id="password" title="<?php echo $language['valid_password']; ?>" />
          </li>
           <li>
            <input type="text" class="required" name="firstname" id="firstname" title="<?php echo $language['valid_firstname']; ?>" />
          </li>
           <li>
            <input type="text" class="required" name="lastname" id="lastname" title="<?php echo $language['valid_lastname']; ?>" />
          </li>
           <li>
            <input type="text" class="required" name="email" id="email" title="<?php echo $language['valid_email']; ?>" />
          </li>
           <li>
            <input type="text" class="" name="mobile" id="mobile" title="<?php echo $language['valid_mobile']; ?>" />
          </li>
          <li class="facebook1"><a href="javascript:;" onclick="return fbconnect('<?php echo DOCROOT; ?>');" title="facebook connect"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/facebook.png" width="38" height="32" alt="face" border="0" class="fl" /><span href="javascript:;" onclick="return fbconnect('<?php echo DOCROOT; ?>');" title="facebook connect" class="facebook">Login with Facebook</span></a></li>
          
           <li class='twitter1'><a href="<?php echo DOCROOT;?>system/modules/twitter/index.php" title="twitter connect"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/twit_ico.png" width="38" height="32" alt="face" border="0" class="fl"/>  	
          <span href="<?php echo DOCROOT;?>system/modules/twitter/index.php" title="twitter connect" class="facebook">Login with twitter</span></a></li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="sign_btn">
          <tr>
            <td><input name="" type="submit" value="SIGN UP"/>
	        
		<!--<a href="<?php echo DOCROOT;?>login.html">SIGN IN</a>-->
		 <input name="" type="button" value="SIGN IN" onclick="window.location='<?php echo DOCROOT;?>login.html'"/>
	        <input name="" type="button" value="CANCEL" onclick="window.location='<?php echo DOCROOT;?>'"/>
	    </td>
          </tr>
        </table>
      </div>
     </form>	
    </div>


<script type="text/javascript">
$('input[type="text"],input[type="password"]').each(function(){
 
    this.value = $(this).attr('title');
    $(this).addClass('text-label');
 
    $(this).focus(function(){
        if(this.value == $(this).attr('title')) {
            this.value = '';
            $(this).removeClass('text-label');
        }
    });
 
    $(this).blur(function(){
        if(this.value == '') {
            this.value = $(this).attr('title');
            $(this).addClass('text-label');
        }
    });
});

</script>
