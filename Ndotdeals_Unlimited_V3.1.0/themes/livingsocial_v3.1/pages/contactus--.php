<?php 
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<!-- Not allowing the specialchars in Quantity field--> 
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


<?php
	if($_POST['contactus'] == $language['post'])
	{

		if($_POST['agreeopt']!=1){

			set_response_mes(-1,$language['you_have_to_agree_terms_conditions']);
			url_redirect(DOCROOT.'contactus.html');

		}

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
		$lang = $_SESSION["site_language"];
                if($lang)
                {
                        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
                }
                else
                {
                        include(DOCUMENT_ROOT."/system/language/en.php");
                }
		
		
		set_response_mes(1,$language['thank_you_for_enquiry']);
		url_redirect(DOCROOT.'contactus.html');
	}
?>
<div class="work_bottom1 contactus">
  <h4><?php echo $language['contactus_heading'];?></h4>
  <div class="contact_left">
    <form action="" name="contactus" id="contactus" method="post">
      <table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user">
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["contact_name"]; ?> :</label>
          </td>
          <td><input name="name" type="text" class="required nospecialchars" title="<?php echo $language['valid_name']; ?>" />
          </td>
        </tr>
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["e-mail"]; ?> :</label>
          </td>
          <td><input name="email" type="text" class="required email input_box" title="<?php echo $language['valid_email']; ?>" />
          </td>
        </tr>
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["phone"]; ?> :</label></td>
          <td><input name="phone" type="text" id="phone" minlength="5" maxlength="20" />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><span><?php echo $language["optional_text"]; ?></span> </td>
        </tr>
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["location"]; ?> :</label></td>
          <td><input name="location" type="text" id="location" class="required input_box" title="<?php echo $language['valid_location']; ?>" /></td>
        </tr>
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["subject"]; ?> :</label></td>
          <td><input name="subject" type="text" id="subject" class="required input_box" title="<?php echo $language['valid_subject']; ?>" /></td>
        </tr>
        <tr>
          <td width="100" align="right" valign="middle"><label><?php echo $language["message"]; ?> :</label>
          </td>
          <td ><textarea name="description" cols="40" rows="5" class="borderccc required" title="<?php echo $language['valid_message']; ?>"></textarea>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="checkbox" value="1" name="agreeopt" class="fl"/>
            <h3 style="width:235px;float:left;margin-top:3px;"><span  style="float:left;font:normal 12px arial;color:#000;"><?php echo $language['agree']; ?> </span><br />
              <a style="float:left;font:normal 12px arial;color:#FA7A0A;" href="<?php echo DOCROOT;?>privacy.html"><?php echo $language['terms_of_privacy']; ?></a></h3></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div class="fl"> <span class="submit">
              <input type="submit" name="contactus" value="<?php echo $language['post']; ?>" class="bnone" />
              </span> </div></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="contact_us_right">
    <div class="fl clr mb20 ">
      <h5><?php echo $language['today_deal_question']; ?></h5>
      <p>
 	<?php echo $language['today_deal_answer']; ?>
      </p>
    </div>
    <div class="fl clr  mb20">
      <h5><?php echo $language['trouble']; ?></h5>
      <p><?php echo $language['trouble_answer']; ?></p>
    </div>
    <div class="fl clr mb20">
      <h5><?php echo $language['having_trouble']; ?></h5>
      <p style="color:#939598;"><?php echo $language['having_trouble_answer']; ?></p>
    </div>
    <div class="fl clr mb20">
      <h5 style="color:#939598;"><?php echo $language['press']; ?></h5>
      <p style="color:#939598;"><?php echo $language['email_us_with_media'];?> <br />
        <?php echo SITE_EMAIL; ?></p>
    </div>
   
  </div>
</div>

