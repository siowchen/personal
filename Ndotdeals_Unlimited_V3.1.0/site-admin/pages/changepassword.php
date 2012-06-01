<?php 
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
$userid = $_SESSION['userid'];
	if($_POST)
	{
	        $password_old = md5($_POST["old_password"]);
	        $password_1 = $_POST["password"];
	        $password_2 = $_POST["password_2"];
	        $queryString = "select * from coupons_users where password ='$password_old' and  userid='$userid' ";
	        $resultSet = mysql_query($queryString); 
	
	        if(mysql_num_rows($resultSet) > 0)
	        {
	                while($row = mysql_fetch_array($resultSet))
		        {			                	     
	                        if($password_1 == $password_2)
	                        {
	                                $email = $row["email"];
		                        $uid = $_SESSION['userid'];
		                        $pass=$_POST['password'];
		                        $password = md5($_POST['password']);
		                        updatepassword($uid,$password);
		                        // send mail, to user regarding password change
				        $from = SITE_EMAIL;
				        $to = $email;
				        $name = $row["firstname"];
				        $username = html_entity_decode($row['username'], ENT_QUOTES);
				        $logo = DOCROOT."site-admin/images/logo.png";

				        //getting subject and description variables
				        $subject = $email_variables['forgotpass_subject'];
				        $description = $email_variables['forgotpass_description'];
	                                $description = str_replace("USERNAME",$username,$description);
	                                $description = str_replace("PASSWORD",$pass,$description);					
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
		                        set_response_mes(1,$admin_language['yourpasswordchanged']); 	
		                        url_redirect(DOCROOT.'admin/profile/');
		                }
	                        else
	                        {
		                        set_response_mes(-1,$admin_language['yourpassworddoesntmatch']);
		                        url_redirect(DOCROOT."admin/profile/");
	                        }
                        }
                }
                else
                {
                        set_response_mes(-1,$admin_language['yourpassworddoesntmatch']);
		        url_redirect(DOCROOT."admin/profile/");
                        
                }
	}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#changepassword_form").validate();});
</script>


<div class="form">
<div class="form_top"></div>
      <div class="form_cent">
        <form name="changepassword_form" id="changepassword_form" action="" method="post">

	<table width="" border="0" cellpadding="5" cellspacing="5" class="">
	<tr>
	<td align="right" valign="top"><label><?php echo $admin_language['oldpassword']; ?></label></td>
	<td><input name="old_password" id="old_password" type="password" class="required" title="<?php echo $admin_language['entertheoldpassword']; ?>" maxlength="50" /></td>
	</tr>
	<tr>
	<td align="right" valign="top"><label><?php echo $admin_language['newpassword']; ?></label></td>
	<td><input name="password" id="password" type="password" class="required" title="<?php echo $admin_language['enternewpassword']; ?>" maxlength="50" /></td>
	</tr>
	<tr>
	<td align="right" valign="top"><label><?php echo $admin_language['confirmpassword']; ?></label></td>
	<td><input type="password" name="password_2" equalTo="#password" class="required" title="<?php echo $admin_language['entertheconfirmpassword']; ?>" maxlength="50" /></td>
	</tr>
	<tr><td>&nbsp;</td>
	<td>
	<?php $cancel_url = DOCROOT.'admin/profile/'; ?>
	<input type="submit" value="<?php echo $admin_language['update']; ?>" name="submit" /> &nbsp;
	<input type="button" value="<?php echo $admin_language['cancel']; ?>" name="submit" onclick="javascript:window.location='<?php echo $cancel_url; ?>'" />
	</td>
	</tr>
	</table>

        </form>
     </div>
<div class="form_bot"></div>
</div>
            

