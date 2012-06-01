
<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#unsubscribe").validate();});

</script>

<ul>
<li><a href="/" title="<?php echo $language['home']; ?>"><?php echo $language['home']; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="<?php echo $language['unsubscribe']; ?>"><?php echo $language['unsubscribe']; ?></a></li>    
</ul>

<h1><?php echo $page_title; ?></h1>

<?php 
if($_POST)
{
    
	$email = $_POST['email'];
	$cityname = $_POST['cityname'];
	
	
	        
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
		set_response_mes(-1,$language['invalid_	email']);
		url_redirect($_SERVER['REQUEST_URI']);
	} 
	
	if((empty($_POST['newsletter_unsubscribe'])) && (empty($_POST['email_unsubscribe'])))
	{
            set_response_mes(-1,$language['unsubc_choose']);
	    url_redirect($_SERVER['REQUEST_URI']);
	
	}
	 // check 
	 $check = mysql_query("select * from newsletter_subscribers where email='$email' and city_id='$cityname'");
         if(mysql_num_rows($check) == 0)
         {
           set_response_mes(-1,$language["email_doent_exist"]);
	   url_redirect($_SERVER['REQUEST_URI']);
         }
         
         //get newsletter emailid 
         $querystring = mysql_query("select * from newsletter_subscribers where email='$email' and city_id='$cityname' and status='D'");
	 if(mysql_num_rows($querystring))
         {
           set_response_mes(-1,$language['emailid_already_unsbscribed']);
	   url_redirect($_SERVER['REQUEST_URI']);
         }
         
            // select cityname
             $cityquerystring = mysql_query("select * from coupons_cities where cityid='$cityname'");
		 while($row_cityname = mysql_fetch_array($cityquerystring)) 
		 {
		     $unsubs_citynmae=$row_cityname['cityname'];
		 }
                $logo = DOCROOT."site-admin/images/logo.png";
		// Send mail to user regarding successfull registration
		$from = SITE_EMAIL;
		$to = $_POST["email"];
		$name = "Customer";

		//getting subject and description variables
		$subject = $email_variables['unsubscribe_subject'];
		$description = 	$email_variables['unsubscribe_message']. $unsubs_citynmae.$email_variables['but_hope_you_will_visit'];
                $siteurl = $email_variables['subscription_visit'];
                $sitename_moreinfo = $email_variables['subscription_visit'];
                $siteurl = $email_variables['visit_us'];

                /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
                	
                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                
                $str = str_replace("SITEURL",$docroot,$str);
                $str = str_replace("SITELOGO",$logo,$str);
                $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
                $str = str_replace("MESSAGE",ucfirst($description),$str);
                $str = str_replace("MOREINFO",ucfirst($sitename_moreinfo),$str);
                $str = str_replace("SITE_URL",ucfirst($siteurl),$str);
                $str = str_replace("SITENAME",SITE_NAME,$str);

		$message = $str;
		$SMTP_STATUS = SMTP_STATUS;	
		
		if($SMTP_STATUS==1)
		{

			include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
		}
		else
		{
	     		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			// Additional headers
			$headers .= 'From: '.$from.'' . "\r\n";
			mail($to,$subject,$message,$headers);	
		} 
         
	if($_POST['newsletter_unsubscribe']==1)
	{
              
 		mysql_query("delete from newsletter_subscribers where email='$email' and city_id='$cityname'"); 		
                set_response_mes(1, $language['subscriber_emailid']); 
               	url_redirect(DOCROOT.'unsubscribe.html'); 
	}

	if($_POST['email_unsubscribe']==1)
	{
	 	mysql_query("update coupons_users set status='D' where email='$email' and city_id='$cityname'");
		set_response_mes(1, $language['changes_updated']); 
		url_redirect(DOCROOT.'unsubscribe.html');
	}
                               


}
?>

                        
<div class="work_bottom">

<form action="" name="unsubscribe" id="unsubscribe" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user">

<tr>
<td align="right" valign="top">
<input class="fr required" type="checkbox"  name="newsletter_unsubscribe" value="1" class="required" /></td>
<td><label><?php echo $language['unsubscribe_txtmsg']; ?></label><label for="newsletter_unsubscribe" style="display:none;" class="errorvalid"><br /><?php echo $language['choose_unsbscriber_newsletter']; ?></label></td>
</tr>

<tr>
<td align="right" valign="top">
<input class="fr required" type="checkbox" name="email_unsubscribe" value="1" class="required" /></td>
<td><label><?php echo $language['unsubscribe_txtmsg2']; ?></label><label for="email_unsubscribe" style="display:none;" class="errorvalid"><br /><?php echo $language['choose_unsbscriber_emailid']; ?></label></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right">
 <select name="cityname" id="city" style="width:256px;float:left;padding:2px;">                                           
	  <?php 
	  //get the cityname list
	  $category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");
	  while($city_row = mysql_fetch_array($category_list)) { ?>
	  <option value="<?php echo $city_row["cityid"];?>" <?php if($_COOKIE['defaultcityId'] == $city_row["cityid"]){ echo "selected";} ?>><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?></option>
	  <?php } ?>
  
  </select>
</td>
</tr>
<tr>
<td align="right" valign="top">
<label class="uner"><?php echo $language['email']; ?> :</label></td>
<td><input type="text" class="input_box required email fl flnone" name="email" id="email" title="<?php echo $language['valid_email']; ?>" /></td>
</tr>
					
<tr><td>&nbsp;</td>
<td>
<div class="signup_now">
<span class="submit fl"> <input type="submit" class="bnone fl" value="<?php echo $language['submit']; ?>" name="submit"  /></span>
<span class="reset fl"><input type="reset" value="<?php echo $language['reset']; ?>" name="submit" class="bnone" /></span>
</td>
</tr>


</table
></form>

</div>
