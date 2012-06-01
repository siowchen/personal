<?php session_start(); 
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<script>
$(document).ready(function()
	{ 
		//for create form validation
		$("#news_letter").validate();
	});
</script>

<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_12").slideToggle();
document.getElementById("left_menubutton_12").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>

<?php
if($_POST)
{
	 $name='';
	 $to1=$_POST['to'];
	 $to=substr($to1,0,strlen($to1)-1);
	 $subject=$_POST['subject'];
	 $msg=nl2br($_POST['message']);
	 
		 if($subject=='' && $description=='')
		 { 
		 	
			$redirect_url = DOCROOT."admin/emailall/";
			set_response_mes(-1, $admin_language['fieldmandatory']); 	
			url_redirect(DOCROOT.'admin/emailall/');

		 }

	$from = SITE_EMAIL;
             
        $logo = DOCROOT."site-admin/images/logo.png";
	   
        if(empty($name))
                $name='Customer';
                
	/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
        $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
        
        $str = str_replace("SITEURL",$docroot,$str);
        $str = str_replace("SITELOGO",$logo,$str);
        $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
        $str = str_replace("MESSAGE",ucfirst($msg),$str);
        $str = str_replace("SITENAME",SITE_NAME,$str);        
        
        $message = $str;

	$message .= '<div style="width:660px;float:left;padding:10px;font-family:Arial, Helvetica, sans-serif;">
<p>'.$email_variables['daily_email'].' <a href="'.DOCROOT.'unsubscribe.html" title="'.$email_variables['unsubscribe_click'].'">'.$email_variables['unsubscribe_click'].' </a>.</p></div>';

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
			mail($from,$subject,$message,$headers);	
		}
		
		$redirect_url = DOCROOT."admin/emailall/";
		set_response_mes(1, $admin_language['mailsend']); 	
		url_redirect($redirect_url);

}?>


  <fieldset class="field" style="margin-left:10px;">         
        <legend class="legend"><?php echo $admin_language['emailinform']; ?></legend>

<form name="news_letter" id="news_letter" action="" method="post" enctype="multipart/form-data" >	
<table border="0"  cellpadding="5" align="left" class="p5">
<tr>
<td valign="top" align="right"><label><?php echo $admin_language['from']; ?></label></td>
<td align="top"><input type="text"  name="from" value="<?php echo SITE_EMAIL; ?>"  class="email required width400" title="<?php echo $admin_language['entervalidemail']; ?>" />
</td>

<?php
//get email list
	$resultSet = mysql_query("select email from coupons_users where status='A'");
	if(mysql_num_rows($resultSet) >0)
	{
		$user_email_list='';
		while($row=mysql_fetch_array($resultSet))
		{
			if($row['email']!='')
			{
				$user_email_list .= $row['email'].',';
			}
		}
	}

	$email_list = $user_email_list;

?>

<input type="hidden" name="to" value="<?php echo $email_list; ?>" />

<tr><td valign="top" align="right"><label><?php echo $admin_language['subject']; ?></label></td><td><input type="text"  name="subject" class="required width400" title="<?php echo $admin_language['enterthesubject']; ?>" /></td></tr>
<tr><td valign="top" align="right"><label><?php echo $admin_language['message']; ?></label></td><td><textarea name="message" rows="7"  class="required width400" title="<?php echo $admin_language['enteryourmessage']; ?>" ></textarea></td></tr>

<tr><td></td><td>
<div class="fl clr">
<input type="submit" value="<?php echo $admin_language['send']; ?>" class="button_c" />
</div>
</td></tr>
</table>
</form>
</fieldset>

