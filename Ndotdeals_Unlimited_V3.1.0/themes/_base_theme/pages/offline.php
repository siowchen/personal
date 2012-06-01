<?php
if($_POST["subscriber"] == $language['submit'])
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
		         /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	                        $to = $email;
	                        $From = SITE_EMAIL;
	                        $subject = $email_variables['subscription_subject'];	
	                        $description = $email_variables['subscription_thankyou'];	
                                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                                
                                $str = str_replace("SITEURL",$docroot,$str);
                                $str = str_replace("SITELOGO",$logo,$str);
                                $str = str_replace("RECEIVERNAME","Subscriber",$str);
                                $str = str_replace("MESSAGE",ucfirst($description),$str);
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
					mail($to,$subject,$message,$headers);	
				}
			set_response_mes(1,$language['subscribe_success']);
			url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language["email_exist"]);
			url_redirect($_SERVER['REQUEST_URI']);			
		}
	}
	else
	{
		set_response_mes(-1,$language['try_again']);
		url_redirect($_SERVER['REQUEST_URI']);

	}
	
	
}

//get the category list
$category_list = mysql_query("select * from coupons_cities where status='A' order by cityname asc");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo APP_DESC;?>" />
<meta name="keywords" content="<?php echo APP_KEYWORDS;?>" />
<link rel="shortcut icon" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/favicon.jpg" type="image/x-icon" />
<title><?php echo APP_NAME;?></title>
<link href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/css/offline.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/jquery.js" /></script>

</head>

<body class="js_enabled">  
<!-- logo -->
<div class="header1">
<div class="header_left">
	<img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/logo.png" border="0" />
</div>
</div>
<!-- logo end -->


	
<!-- form start -->	
<div class="form_selection">
	<div class='main clearfix'>
        <form action="" class="form_list" id="offline" method="post" >
					<div class="conf_top"></div>
					<div class="form_inner">
					<div class='page_content clearfix' >
								  
					<div class='input_three_steps'>
					
					<?php 
					success_mes(); //success message
					failed_mes();	//failed response message			  
				  	?>


					<div class='header_three_steps'>
						<h1><?php echo $language["offline_title"];?></h1>
						<p class="soon_slogan"><?php echo $language["offline_sub_title"];?></p>
					</div>
					
					  <table border="0" cellpadding="5">
					  <tr>
					  <td>							
					  <select name="city_name" id="city">
					  <?php while($city_row = mysql_fetch_array($category_list)) { ?>
						  <option value="<?php echo $city_row["cityid"];?>">
							  <?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?>
						  </option>
					  <?php } ?>
					  
					  </select>
					  </td>
					  </tr>
					  
					  <tr>
					  <td>
	                  <input type="text" name="email" id="email"  title="<?php echo $language['valid_email']; ?>" value="<?php echo $language['valid_email']; ?>" onfocus="if(this.value=='Enter your email address')this.value=''" onblur="if(this.value=='')this.value='Enter your email address'" />
					  </td>
					  </tr>
					  <tr>
	                      <td align="right"><input name="subscriber" type="submit" value="<?php echo $language['submit']; ?>" class="submit_button" /></td>
					  </tr>
					  
					</table>
							
					</div>
					</div>
					</div>
					<div class="conf_bot"></div>
        </form>
    </div>
</div>
<!-- form end -->

</body>
</html>
