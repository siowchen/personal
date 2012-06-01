<?php 
if($_POST["subscriber"] == $language['post'])
{
	$email = $_POST['email'];
	$city = $_POST['city_name'];
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
		set_response_mes(-1,$language['invalid_email']);
		url_redirect($_SERVER['REQUEST_URI']);
	} 
	
	if(!empty($email))
	{
		$val = add_subscriber($email,$city);
		if($val)
		{
			       // select cityname
                               $subscityquerystring = mysql_query("select * from coupons_cities where cityid='$city'");
				 while($row_cityname = mysql_fetch_array($subscityquerystring)) 
				 {
				     $subs_citynmae = $row_cityname['cityname'];
				 }
			       
			        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	                        $to = $email;
	                        $From = SITE_EMAIL;
	                        $subject = $email_variables['subscription_subject'];	
	                        $description = $email_variables['subscription_thankyou'].$subs_citynmae;		                        
	                        $sitename_moreinfo = $email_variables['subscription_visit'];
	                        $siteurl = $email_variables['visit_us'];
                                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                                
                                $str = str_replace("SITEURL",$docroot,$str);
                                $str = str_replace("SITELOGO",$logo,$str);
                                $str = str_replace("RECEIVERNAME","Subscriber",$str);                                
                                $str = str_replace("MESSAGE",ucfirst($description),$str);
                                $str = str_replace("MOREINFO",ucfirst($sitename_moreinfo),$str);
                                $str = str_replace("SITE_URL",ucfirst($siteurl),$str);                                
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
					$headers .= 'From: '.$From.'' . "\r\n";
					mail($to,$subject,$message,$headers);	
				}
			set_response_mes(1,$language['subscribe_success']);
			url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language['email_exist']);
			url_redirect($_SERVER['REQUEST_URI']);			
		}
	}
	else
	{
		set_response_mes(-1,$language['try_again']);
		url_redirect($_SERVER['REQUEST_URI']);

	}
	
	
}

//get the categpry list
$category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");

?>
<div class="fl clr borderF2F ">
  <div class="great_deals">
    <div class="great_top">
      <h1><?php echo $language['get_deals_by_email']; ?></h1>
    </div>
    <div class="great_center fl clr">
      <div class="submit_right fl clr ml5">
        <p class="ml5"><?php echo $language['subscribe_text']; ?></p>
        <form action="" method="post" name="subscribe_updates" id="subscribe_updates">
          <select name="city_name" id="city" class="fl m15 city_sel mt10">
            <?php while($city_row = mysql_fetch_array($category_list)) { ?>
            <option value="<?php echo $city_row["cityid"];?>" <?php if($_COOKIE['defaultcityId'] == $city_row["cityid"]){ echo "selected";} ?>><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?></option>
            <?php } ?>
          </select>
          <input type="text" name="email" id="email" class="fl m15 mt10" title="<?php echo $language['valid_email']; ?>" value="" style="font-size:12px;" />
          <div class="fl mt10">
            <div class="submit">
			
           <input name="subscriber" type="submit" value="<?php echo $language['post']; ?>" class="" />
		 
             
            </div>
          </div>
        </form>
      </div>
      <p class="mt10 fl clr ml10 width230 "> <?php echo $language['subscribe_message']; ?> </p>
    </div>
    <div class="great_bottom"> </div>
  </div>
</div>
