<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script type="text/javascript" src="<?php echo DOCROOT;?>themes/_base_theme/scripts/jquery.validations.js" /></script>
<script type="text/javascript">
  
	/* validation */
	$(document).ready(function(){ 
	
	//For Special character Restriction
	//==================================
        $("#phone").numeric({allow:""});
               
   });
   
</script>
<script type = "text/javascript">
/* validation */

$(document).ready(function(){$("#contactus").validate();});

</script>



<ul>
<li><a href="/" title="<?php echo $language["home"]; ?>"><?php echo $language["home"]; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="<?php echo $language["contact_us"]; ?>"><?php echo $language["contact_us"]; ?></a></li>    
</ul>

<h1><?php echo $page_title; ?></h1>

<?php
	if($_POST['contactus'] == $language['post'])
	{
		$to = SITE_EMAIL;
		$name = $_POST["name"];
		$from = $_POST["email"];
		$phone = $_POST["phone"];
		$location = $_POST["location"];
		$subject = $_POST["subject"];
		
		$logo = DOCROOT."site-admin/images/logo.png";
		
		$mes = "<p> Name:".$name."</p><p>Phone:".$phone."</p><p>Location:".$location."</p>"."<p>".$_POST["description"]."</p>";
		/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                
                $str = str_replace("SITEURL",$docroot,$str);
                $str = str_replace("SITELOGO",$logo,$str);
                $str = str_replace("RECEIVERNAME",'Admin',$str);
                $str = str_replace("MESSAGE",ucfirst($mes),$str);
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
			$headers .= 'Bcc: '.$to.'' . "\r\n";
			mail($to,$subject,$message,$headers);	
		}
		
		//send_email($email,$to,$subject,$mes); //call email function
		set_response_mes(1,$language['thank_you_for_enquiry']);
		url_redirect(DOCROOT.'contactus.html');
	}
?>

<div class="work_bottom contactus">
<form action="" name="contactus" id="contactus" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user">
<tr><td align="right" valign="top">
<label><?php echo $language["contact_name"]; ?> :</label>
</td><td>
<input name="name" type="text" class="required nospecialchars" title="<?php echo $language['valid_name']; ?>" />
</td></tr>
<tr><td align="right" valign="top">
<label><?php echo $language["e-mail"]; ?> :</label>
</td><td>
<input name="email" type="text" class="required email input_box" title="<?php echo $language['valid_email']; ?>" />
</td></tr>

<tr><td align="right" valign="top">
<label><?php echo $language["phone"]; ?> :</label></td>
<td><input name="phone" type="text" id="phone" minlength="5" maxlength="20" title="<?php echo $language['valid_mobile']; ?>"/> </td></tr>

<tr><td>&nbsp;</td>
<td><span><?php echo $language["optional_text"]; ?></span>
</td></tr>

<tr><td align="right" valign="top">
<label><?php echo $language["location"]; ?> :</label></td><td><input name="location" type="text" id="location" class="required input_box" title="<?php echo $language['valid_location']; ?>" /></td></tr>

<tr><td align="right" valign="top">
<label><?php echo $language["subject"]; ?> :</label></td>
<td>
<input name="subject" type="text" id="subject" class="required input_box" title="<?php echo $language['valid_subject']; ?>" /></td></tr>

<tr><td align="right" valign="top">
<label><?php echo $language["message"]; ?> :</label> </td>
<td >
<textarea name="description" cols="40" rows="5" class="borderccc required" title="<?php echo $language['valid_message']; ?>"></textarea>
</td></tr>

<tr>
<td>&nbsp; </td>
<td>
<div class="fl">
<span class="submit"><input type="submit" name="contactus" value="<?php echo $language['post']; ?>" class="bnone" /></span>
</div>
</td>
</tr>
</table>
</form>
</div>

