<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>

<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#change_password").validate();});

</script>

<?php 

is_login(DOCROOT."login.html"); //checking whether user logged in or not. 

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
	                        $pass=$password_1;
		                $password = md5($password_1);
		                $query = "update coupons_users set password='$password' where userid='$userid' ";
		                mysql_query($query);		                
		                
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
				        
				        
		
		                set_response_mes(1,$language["password_changed"]);
		                url_redirect(DOCROOT."change-password.html");
	                }
	                else
	                {
			                set_response_mes(-1,$language["not_matched"]);
			                url_redirect(DOCROOT."change-password.html");
	                }
	       }
        }
        else
        {
                set_response_mes(-1,$language["not_matched"]);
		url_redirect(DOCROOT."change-password.html");
                
        }
}
?>	 

<?php include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>


<div class="work_bottom ">
<form action="" name="login" id="change_password" method="post">
<table width="600px;" border="0" cellpadding="5" cellspacing="5" class="contact_user">

<?php if($_SESSION["logintype"] == 'connect') { 

	$userid = $_SESSION['userid'];

	$queryString = "SELECT * FROM coupons_users where userid='$userid'";
	$resultSet = mysql_query($queryString);

		while($row = mysql_fetch_array($resultSet))
		{
			$password = $row['password'];
		}

		if($password==md5('allowme'))
		{
		?>

			<tr>
			<td align="right" valign="top"><label>Dummy Password:</label></td>
			<td>allowme</td>
			</tr>

		<?php
		}

}?>

<tr>
<td align="right" valign="top"><label><?php echo $language["password_old"]; ?> :</label></td>
<td><input name="old_password" id="old_password" type="password" class="required input_box" title="<?php echo $language['valid_password']; ?>" /></td>
</tr>
<tr>
<td align="right" valign="top"><label><?php echo $language["password_new"]; ?> :</label></td>
<td><input name="password" id="password" type="password" class="required input_box" title="<?php echo $language['valid_password']; ?>" /></td>
</tr>

<tr>
<td align="right" valign="top"><label><?php echo $language["reenter_password"]; ?> :</label></td>
<td><input name="password_2" id="password_2" equalto="#password" type="password" class="required input_box" title="<?php echo $language['valid_password']; ?>" /></td>
</tr>

<tr><td>&nbsp;</td>
<td><span class="submit"><input type="submit" value="<?php echo $language['update']; ?>" name="submit" class="bnone" /></span>
</td>
</tr>
</table>
</form> 
</div>
