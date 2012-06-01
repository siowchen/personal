<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#login").validate();});

</script>

<?php 

if($_SESSION["userid"])
{
	url_redirect(DOCROOT."profile.html");
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
					
					/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
                                        $str = implode("",file('themes/_base_theme/email/email_all.html'));
                                        
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

					set_response_mes(1,$language['password_sent']);						
					url_redirect(DOCROOT."login.html");
					
	 			}
		}	
	}
	else
	{
		set_response_mes(-1,$language['email_not_exist']);						
		url_redirect(DOCROOT."registration.html");
	}

}



?>
<h1 class="page_tit"><?php echo $page_title; ?></h1>


<div class="work_bottom ">
<form action="" name="login" id="login" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="forms">
<tr>
<td align="left" valign="top"><label><?php echo $language['email']; ?> :</label></td></tr><tr>
<td><input name="email" type="text" class="required input_box email" title="<?php echo $language['valid_email']; ?>" /></td>
</tr>
<tr>
<td>
	<input type="submit" value="<?php echo $language['post']; ?>" name="submit" />

</td>
</tr>
</table>
</form>

</div>
