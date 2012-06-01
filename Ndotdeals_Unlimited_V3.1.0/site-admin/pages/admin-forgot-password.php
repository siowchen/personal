<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#forgot_password").validate();});

</script>

<?php 

if($_SESSION["userid"])
{
	url_redirect(DOCROOT."admin/profile");
}

//generate random code
function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}





if($_POST)
{

	$email = $_POST["email"];
	$queryString = "select * from coupons_users where email='$email'";
	
	$resultSet = mysql_query($queryString); 
	
	if(mysql_num_rows($resultSet) > 0)
	{
		while($row = mysql_fetch_array($resultSet))
		{
				$email = $row["email"];
				$pass = createRandomPassword(); 
				$password=md5($pass); 
					
				$queryString2 = "update coupons_users set password='$password' where email='$email' ";
				$resultSet2 = mysql_query($queryString2);

				// mail function to intimate user regarding new password
				if($resultSet2)
				{
					// send mail, to user regarding password change
					$from = SITE_EMAIL;
					$to = $email;
					$name = $row["firstname"];
					$username = html_entity_decode($row['username'], ENT_QUOTES);
					$logo = DOCROOT."site-admin/images/logo.png";

					//getting subject and description variables
					$subject = $email_variables['forgotpass_subject'];
					$description = 	$email_variables['forgotpass_description'];
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

					set_response_mes(1,$admin_language['passwordsent']);						
					url_redirect(DOCROOT."admin/login/");
					
	 			}
		}	
	}
	else
	{
		set_response_mes(-1,$admin_language['emailaddexist']);						
		url_redirect(DOCROOT."admin/login/");
	}

}



?>


<div class="form_out">
<div class="form">
<div class="form_top1"></div>
<div class="form_cent">
<form action="" name="forgot_password" id="forgot_password" method="post">
<h1 class="font18" style="text-align:center;"><?php echo $admin_language['forgotpassword']; ?></h1>
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user">
<tr>
<td align="right" valign="top"><label><?php echo $admin_language['enteremail']; ?></label></td>
<td><input name="email" type="text" class="required input_box email" title="<?php echo $admin_language['youremailaddress']; ?>" /></td>
</tr>
<tr><td>&nbsp;</td>
<td>
<div class="fl clr">
	<input type="submit" value="<?php echo $admin_language['submit']; ?>" name="submit" />
</div>
</td>
</tr>
</table>
</form>
</div>
<div class="form_bot1"></div>
</div>
</div>
