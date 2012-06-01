<?php
if($_POST)
{
        $email = $_POST['subscription']['email_address'];
        $city = $_POST['subscription']['division_id'];
        if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
	        url_redirect(DOCROOT);
	}
        
	$cityString = "select * from coupons_cities where status='A' order by cityname asc";
        $resultCity = mysql_query($cityString);
        if(mysql_num_rows($resultCity)>0)
        {
                while( $row = mysql_fetch_array($resultCity))
                {
                        if($city == $row['cityid'])
                        {
                                $_SESSION['defaultcityname'] = $row["cityname"];
				$_SESSION['default_city_url'] = $row["city_url"];
                        }
                        
                }
        }
		
        $month = 2592000 + time();
        setcookie("defaultcityId", "");	
        setcookie("defaultcityId", $_POST['subscription']['division_id'], $month);
        $_SESSION["defaultcityId"] = $_POST['subscription']['division_id'];
	    $city_url = $_SESSION['default_city_url'];
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
        }
        else
        {
                set_response_mes(1,$language['receive_emails']);
        }
        url_redirect(DOCROOT.$city_url.'/');
        
}
else
{
        $queryString = "select * from coupons_cities where status='A' order by cityname asc";
        $resultSet = mysql_query($queryString);
        if(mysql_num_rows($resultSet)>0)
        {
                $cnt = 1;
                while( $row = mysql_fetch_array($resultSet))
                {
                        if($cnt == 1)
                        {
			        $SITE_DEFAULT_CITYID = SITE_DEFAULT_CITYID;
				//getting default cityid
				if($SITE_DEFAULT_CITYID)
				{
				        $city_id = SITE_DEFAULT_CITYID;
					//get the city name
                                        $get_city_qs = "select * from coupons_cities where status='A' AND cityid = '$city_id' ";
					$get_city_result = mysql_query($get_city_qs);
					while($city_val = mysql_fetch_array($get_city_result))
					{
					        $city_name = $city_val['cityname'];
					        $city_url = $city_val['city_url'];
					}
				}
				else
				{
				        $city_id = $row['cityid']; 
					$city_name = $row['cityname'];
					$city_url = $row['city_url'];
				}
                                $cnt++;
                                break;       
                        }
                        
                }
        }	    
        $month = 2592000 + time();
        setcookie("defaultcityId", "");	
        setcookie("defaultcityId", $city_id, $month);
        
	$_SESSION['defaultcityname'] = $city_name;
	$_SESSION['default_city_url'] = $city_url;
	//$cityname = friendlyURL($_SESSION['defaultcityname']);
        $_SESSION["defaultcityId"] = $city_id;
       
        $ref_page = end(explode("=",$_SERVER['REQUEST_URI']));
        
        if($ref_page == 'Signin')
                $ref_page = DOCROOT.'login.html';
        else if($ref_page == 'privacy')
                $ref_page = DOCROOT.'privacy.html';
        else
                $ref_page = DOCROOT.$city_url.'/';
        url_redirect($ref_page);
}
 
?>

