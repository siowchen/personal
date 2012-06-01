<?php
ob_start();
//require_once ($_SERVER["DOCUMENT_ROOT"].'/system/includes/library.inc.php');
require_once ($_SERVER["DOCUMENT_ROOT"].'/system/includes/dboperations.php');
require_once ($_SERVER["DOCUMENT_ROOT"].'/system/includes/docroot.php'); 
require_once ($_SERVER["DOCUMENT_ROOT"].'/system/includes/config.php');
$city_id = '';
//get the parameters and store it in array
$api_url = explode('?',$_SERVER['REQUEST_URI']);
$params = explode('&',$api_url[1]);
foreach($params as $key=>$value)
{
        $new_val = explode('=',$value);
        $parameters[$new_val[0]] = $new_val[1];
}
//get the parameters list and save settings for response
$client_id = $parameters['client_id']; 
$city = urldecode($parameters['city']);
$format = $parameters['format'];
if($client_id) //if client_id is set
{
        $file = $_REQUEST['file'];  //get the value of file (city or deal)
        if($format == 'xml')
        {
                echo ltrim('<?xml version="1.0" encoding="UTF-8"?>');
        }
        
        //CHECK FOR VALID CLIENT ID
        $clientid_result = mysql_query("select * from api_client_details where api_key='".$client_id."' and status=1");
        if(mysql_num_rows($clientid_result))
        {
        
        //API -CITY LIST       
         
        if($file == 'city') //get the list of cities
        {
                $city_result = mysql_query("select * from coupons_cities left join coupons_country on coupons_country.countryid = coupons_cities.countryid where coupons_country.status = 'A' and coupons_cities.status='A'");
                if(mysql_num_rows($city_result)>0)
                {
                        if($format == 'xml')
                        {
                                $xml_content = '<response><cities>';
                        }
                        while($city_row = mysql_fetch_object($city_result))
                        {
                                if($format == 'xml')
                                {
                                        $xml_content .= '<city><cityid>'.$city_row->cityid.'</cityid><cityname>'.$city_row->cityname.'</cityname><cityurl>'.$city_row->city_url.'</cityurl><country>'.$city_row->countryname.'</country></city>';
                                }
                                else
                                {
                                        $json_response[] = array
                                                           ("city" => array("cityid" => $city_row->cityid,
                                                            "cityname" => $city_row->cityname,
                                                            "cityurl" => $city_row->city_url,
                                                            "country" => $city_row->countryname));
                                }
                        }
                }
                else //error response
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>No city found</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"No city found"}}';
                        }
                        exit;
                }
                if($format == 'xml')
                {
                        $xml_content .= '</cities></response>';
                        echo $xml_content;
                }
                else
                {
                        $deals_response["cities"] = $json_response;
                        echo json_encode($deals_response);
                }
                exit;
                
        }
        
        
        //get the default city information      
        
        else if($file == 'defaultcity') //get the list of cities
        {
                $city =mysql_query("select default_cityid from general_settings where default_cityid !=0");
                 $value = mysql_num_rows($city);
                 if($value > 0)
                
                   {
                    while($city_res = mysql_fetch_object($city))
                     {
                       $city_res_id = $city_res->default_cityid;    
                    
                      }
                
               
                 $default_city = mysql_query("select * from coupons_cities where cityid = '$city_res_id'"); 
                
                if(mysql_num_rows($default_city)>0)
                {
                        if($format == 'xml')
                        {
                                $xml_content = '<response><cities>';
                        }
                        while($default_city_row = mysql_fetch_object($default_city))
                        {
                                if($format == 'xml')
                                {
                                        $xml_content .= '<city><cityid>'.$default_city_row->cityid.'</cityid><cityname>'.$default_city_row->cityname.'</cityname><cityurl>'.$default_city_row->city_url.'</cityurl><country>'.$default_city_row->countryname.'</country></city>';
                                }
                                else
                                {
                                        $json_response[] = array
                                                           ("city" => array("cityid" => $default_city_row->cityid,
                                                            "cityname" => $default_city_row->cityname,
                                                            "cityurl" => $default_city_row->city_url,
                                                            ));
                                }
                        }
                }    
                    
                    
                }
                
                else if($value == 0)     
                {    
                $city_result = mysql_query("select * from coupons_cities left join coupons_country on coupons_country.countryid = coupons_cities.countryid where coupons_country.status = 'A' and coupons_cities.status='A' order by cityid limit 1");
                
                if(mysql_num_rows($city_result)>0)
                {
                        if($format == 'xml')
                        {
                                $xml_content = '<response><cities>';
                        }
                        while($city_row = mysql_fetch_object($city_result))
                        {
                                if($format == 'xml')
                                {
                                        $xml_content .= '<city><cityid>'.$city_row->cityid.'</cityid><cityname>'.$city_row->cityname.'</cityname><cityurl>'.$city_row->city_url.'</cityurl><country>'.$city_row->countryname.'</country></city>';
                                }
                                else
                                {
                                        $json_response[] = array
                                                           ("city" => array("cityid" => $city_row->cityid,
                                                            "cityname" => $city_row->cityname,
                                                            "cityurl" => $city_row->city_url,
                                                            "country" => $city_row->countryname));
                                }
                        }
                }
             }
                else //error response
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>No city found</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"No city found"}}';
                        }
                        exit;
                }
                if($format == 'xml')
                {
                        $xml_content .= '</cities></response>';
                        echo $xml_content;
                }
                else
                {
                        $deals_response["cities"] = $json_response;
                        echo json_encode($deals_response);
                }
                exit;
                
        }
        
        //API -LOGIN
        
        else if($file == 'login') //if the request is for login
        {
                if(isset($parameters['username']))
                {
                        $username = $parameters['username'];
                }
                if(!empty($username))
                {
                        $userQuery = "SELECT * FROM coupons_users where username ='".$username."'";
                        $userResult = mysql_query($userQuery);
                }
                else
                {
                        $email = $parameters['email'];  
                        $password = $parameters['password'];
                        if(empty($email) || empty($password)) //if email or password is empty generate error
                        {
                                if($format == 'xml') //for xml response -error
                                {
                                        $xml_content = '<response><error><httpCode>400</httpCode><message>';
                                                                        
                                        if(empty($email))
                                        {
                                                $xml_content .='Invalid email';
                                        }
                                        else 
                                        {
                                                $xml_content .='Invalid password';
                                        }
                                        $xml_content.='</message></error></response>';
                                        echo $xml_content;
                                        exit;
                                }
                                else //for json response -error
                                {
                                        $resp = '{"error":{"httpCode":400,"message":';
                                        if(empty($email))
                                        {
                                        $resp .= '"Invalid email"';
                                        }
                                        else
                                        {
                                        $resp .= '"Invalid password"';
                                        }
                                        $resp .= '}}';
                                        echo $resp;
                                }
                                exit;  
                        }
                        $userQuery = "SELECT * FROM coupons_users where email ='".$email."' and password='".$password."'";
                        $userResult = mysql_query($userQuery);
                }
                if(mysql_num_rows($userResult)>0) //valid user
                {
                        if($format == 'xml')
                        {
                                $xml_content = '<response><userinfo>';
                        }
                        while($user_row = mysql_fetch_object($userResult))
                        {
                                if($format == 'xml')
                                {
                                        $xml_content .= '<user><userid>'.$user_row->userid.'</userid><username>'.$user_row->username.'</username><email>'.$user_row->email.'</email><mobile>'.$user_row->mobile.'</mobile><referralid>'.$user_row->referral_id.'</referralid><userrole>'.$user_row->user_role.'</userrole><referralearnings>'.$user_row->referral_earned_amount.'</referralearnings><accountbalance>'.$user_row->account_balance.'</accountbalance></user>';
                                }
                                else
                                {
                                        $json_response[] = array
                                                           ("userinfo" => array("userid" => $user_row->userid,
                                                            "username" => $user_row->username,
                                                            "email" => $user_row->email,
                                                            "mobile" => $user_row->mobile,
                                                            "referralid" => $user_row->referral_id,
                                                            "userrole" => $user_row->user_role,
                                                            "referralearnings" => $user_row->referral_earned_amount,
                                                            "accountbalance" => $user_row->account_balance));
                                }
                        }
                        if($format == 'xml')
                        {
                                $xml_content .= '</userinfo></response>';
                                echo $xml_content;
                        }
                        else
                        {
                                $deals_response["userinfo"] = $json_response;
                                echo json_encode($deals_response);
                        }
                        exit;
                

                }
                else
                {
                        if(!empty($username))
                        {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>Invalid username</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"Invalid username"}}';
                                }
                        }
                        else
                        {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>Invalid email or password</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"Invalid email or password"}}';
                                }
                        }
                        exit;

              }
        }
        
      //Password change
      else if($file == 'change-password') 
        {
                if(isset($parameters['userid']))
                {
                        $userid = $parameters['userid'];
                }
                $oldpassword =  $parameters['oldpassword'];
                $newpassword = $parameters['newpassword'];
                if(!empty($userid))
                {
                        $userQuery = "SELECT * FROM coupons_users where userid ='".$userid."' and password='".$oldpassword."'";
                        $userResult = mysql_query($userQuery);
                }
                
                if(mysql_num_rows($userResult)>0) //valid user
                {
                   while($user_row = mysql_fetch_array($userResult))
		        {
		        $userQuery = mysql_query("update coupons_users set password='".$newpassword."' where userid ='".$userid."'");
                        
		        } 
                         if($format == 'xml')
                        {
                                echo $xml_content = '<response><message>Password has been changed.</message></response>';
                        }
                        else
                        {
                                echo '{"success":{"message":"Password has been changed."}}';
                        } 
                        exit;    
	
                }
                else
                {
                       if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Oldpassword is Incorrect</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"Oldpassword is Incorrect"}}';
                        }
                        
                        

              }
              exit;  
        }


	// forgot password start

	else if($file == 'forgot-password') 
	{
		if(isset($parameters['email']))
		{
			$email = $parameters['email'];

		}
		else
		{
		       if($format == 'xml')
			{
				echo $xml_content = '<response><error><httpCode>400</httpCode><message>Invalid Email id</message></error></response>';
			}
			else
			{
				echo '{"error":{"httpCode":400,"message":"Invalid Email id"}}';
			}
			exit;
		}
	       
		$queryString = "select * from coupons_users where email='$email'";

		$resultSet = mysql_query($queryString); 

		if(mysql_num_rows($resultSet) > 0)
		{
			while($row = mysql_fetch_array($resultSet))
			{
				$email = $row["email"];
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
					include(DOCUMENT_ROOT."/themes/_base_theme/email/email_variables.php");
					//getting subject and description variables
					$subject = $email_variables['forgotpass_subject'];
					$description = 	$email_variables['forgotpass_description'];
					$description = str_replace("USERNAME",$username,$description);
					$description = str_replace("PASSWORD",$pass,$description);
		
					/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
					$str = implode("",file($_SERVER['DOCUMENT_ROOT'].'/themes/_base_theme/email/email_all.html'));
					
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

					 if($format == 'xml')
					{
						echo $xml_content = '<response><message>Password has been sent to your email id.</message></response>';
					}
					else
					{
						echo '{"success":{"message":"Password has been sent to your email id."}}';
					} 
				}
			}
		}
		else
		{
			if($format == 'xml')
		        {
		                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Email id does not exists</message></error></response>';
		        }
		        else
		        {
		                echo '{"error":{"httpCode":400,"message":"Email id does not exists"}}';
		        }
		                
		}
		exit;
	}
	
	// Forgot password end

      //credit details
      else if($file == 'credit') 
        {
                if(isset($parameters['userid']))
                {
                        $userid = $parameters['userid'];
                }
               
                if(!empty($userid))
                {
                        $userQuery = "SELECT referral_earned_amount FROM coupons_users where userid ='".$userid."'";
                        $userResult = mysql_query($userQuery);
                }
                
                if(mysql_num_rows($userResult)>0) //valid user
                {
                                    if($format == 'xml')
                                        {
                                                $xml_content = '<response><referralamount>';
                                        }
                                        while($userreferral = mysql_fetch_object($userResult))
                                        {      if($userreferral->referral_earned_amount)
                                                 {
                                                   $count = $userreferral->referral_earned_amount;        
                                                  }
                                               else
                                               {
                                                 $count ='zero';
                                                }
                                                if($format == 'xml')
                                                {
                                                        $xml_content .= '
                                                        <amount>'.CURRENCY.$count.'</amount>';

                                                }
                                                else
                                                {
                                                        $json_response[] = array
                                                        ("referralamount" => array("amount" => CURRENCY.$userreferral->referral_earned_amount));
                                                         
                                                }
                                        }
                                        if($format == 'xml')
                                        {
                                                $xml_content .= '</referralamount></response>';
                                                echo $xml_content;
                                        }
                                        else
                                        {
                                                $deals_response["referral"] = $json_response;
                                                echo json_encode($deals_response);
                                        }
                                        exit;  
	
                }
                else
                {
                       if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Oldpassword is Incorrect</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"Oldpassword is Incorrect"}}';
                        }
                        
                        

              }
              exit;  
        }
        
        //API - USER REGISTRATION (SIGNUP)
        
        else if($file == 'signup') //if the request is for signup
        {
                $username = $parameters['username'];  
                $password = $parameters['password'];
                $email = $parameters['email'];
                $mobile = htmlentities($parameters['mobile'], ENT_QUOTES);
                
                if(empty($email) || empty($password) || empty($username) || empty($mobile)) //if email or password is empty generate error
                {
                        if($format == 'xml') //for xml response -error
                        {
                                $xml_content = '<response><error><httpCode>400</httpCode><message>All fields are mandatory</message></error></response>';
                                echo $xml_content;
                                exit;
                        }
                        else //for json response -error
                        {
                                $resp = '{"error":{"httpCode":400,"message":"All fields are mandatory"}}';
                                echo $resp;
                        }
                        exit;  
                }
                
                
                
                $userQuery = "SELECT * FROM coupons_users where email ='".$email."' or username='".$username."'";
                $userResult = mysql_query($userQuery);
                if(mysql_num_rows($userResult) == 0) // new user registration starts here
                {
                          srand(time());     
	                  $random_letter_lcase = chr(rand(ord("a"), ord("z"))); 
	                  $random_letter_ucase = chr(rand(ord("A"), ord("Z")));
	                  $random_letter_number = chr(rand(ord("0"), ord("9")));
	                  $random_letter_lcase1 = chr(rand(ord("a"), ord("z")));  
	                  $random_letter_lcase2 = chr(rand(ord("a"), ord("z"))); 
	                  $random_letter_ucase2 = chr(rand(ord("A"), ord("Z")));
	                  $random_letter_number2 = chr(rand(ord("0"), ord("9")));
	                  $random_letter_lcase2 = chr(rand(ord("a"), ord("z")));  
	                  
	                  $randomvalue = $random_letter_lcase.$random_letter_ucase.$random_letter_number.$random_letter_lcase1.$random_letter_lcase2.$random_letter_ucase2.$random_letter_number2.$random_letter_lcase2;
                        $username = htmlentities($parameters['username'], ENT_QUOTES);  
			$userInsert = "insert into coupons_users(username,password,firstname,email,mobile,user_role,user_status,referral_id) values('$username','$password','$username','$email','$mobile','4','A','$ranval')";
			$insertResult = mysql_query($userInsert);
			$last_insert_id = mysql_insert_id();
			
			if($last_insert_id) //if user is registered
			{
			        
			        $logo = DOCROOT."site-admin/images/logo.png";
				// Send mail to user regarding successfull registration
				$from = SITE_EMAIL;
				$to = $email;
				$name = $username;

				//getting subject and description variables
				$subject = $email_variables['registration_subject'];
				$description = 	$email_variables['registration_description'];
                                $description = str_replace("USERNAME",$username,$description);
                                $description = str_replace("PASSWORD",$password,$description);
	  
	                        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	                        	
                                $str = implode("",file($_SERVER['DOCUMENT_ROOT'].'/themes/_base_theme/email/email_all.html'));
                                
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
	
					include($_SERVER['DOCUMENT_ROOT']."/system/modules/SMTP/smtp.php"); //mail send thru smtp
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
				$userQuery1 = "select * from coupons_users where userid='$last_insert_id'";
			        $userResult1 = mysql_query($userQuery1);
			        if(mysql_num_rows($userResult1) >0)
			        {
                                        if($format == 'xml')
                                        {
                                                $xml_content .= '<response><userinfo>';
                                        }
                                        while($user_row = mysql_fetch_object($userResult1))
                                        {
                                                if($format == 'xml')
                                                {
                                                        $xml_content .= '<user><userid>'.$user_row->userid.'</userid><username>'.$user_row->username.'</username><email>'.$user_row->email.'</email><mobile>'.$user_row->mobile.'</mobile><referralid>'.$user_row->referral_id.'</referralid><userrole>'.$user_row->user_role.'</userrole><referralearnings>'.$user_row->referral_earned_amount.'</referralearnings><accountbalance>'.$user_row->account_balance.'</accountbalance></user>';
                                                }
                                                else
                                                {
                                                        $json_response[] = array
                                                                           ("userinfo" => array("userid" => $user_row->userid,
                                                                            "username" => $user_row->username,
                                                                            "email" => $user_row->email,
                                                                            "mobile" => $user_row->mobile,
                                                                            "referralid" => $user_row->referral_id,
                                                                            "userrole" => $user_row->user_role,
                                                                            "referralearnings" => $user_row->referral_earned_amount,
                                                                            "accountbalance" => $user_row->account_balance));
                                                }
                                        }
                                        if($format == 'xml')
                                        {
                                                $xml_content .= '</userinfo></response>';
                                                echo $xml_content;
                                        }
                                        else
                                        {
                                                $deals_response["userinfo"] = $json_response;
                                                echo json_encode($deals_response);
                                        }
                                        exit;
                                }

			
			        }
			        else
			        {
			                if($format == 'xml')
                                        {
                                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>User signup error</message></error></response>';
                                        }
                                        else
                                        {
                                                echo '{"error":{"httpCode":400,"message":"User signup error"}}';
                                        }
                                        exit;
			        }
                }
                else
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Email or username already exists</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"Email or username already exists"}}';
                        }
                        exit;

              }
        }
        
         //API - USER COUPONS LIST (MY COUPONS)
        
        else if($file == 'my-coupons') //if the request is for signup
        {
                $userid = $parameters["userid"];
                if(!empty($userid))
                {
                        $couponQuery =" SELECT  (
    if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
    ) AS name ,u.mobile, p.coupon_purchaseid, p.coupon_purchaseddate, p.couponid, c.coupon_status, c.coupon_name, c.coupon_enddate, c.coupon_image,c.coupon_description,c.coupon_fineprints,c.coupon_highlights,c.terms_and_condition,c.coupon_expirydate, p.coupon_userid, p.coupon_validityid, p.coupon_validityid_date, p.coupon_validityid_createdby,p.coupons_userstatus FROM coupons_purchase p,coupons_users u,coupons_coupons c where  u.userid=p.coupon_userid and c.coupon_id=p.couponid and p.Coupon_amount_Status='T' and p.coupon_userid=".$userid;
                        $couponResult = mysql_query($couponQuery);
                        if(mysql_num_rows($couponResult) > 0)
                        {
                                while($mycoupon = mysql_fetch_object($couponResult))
                                {
                                         $discount = $row->coupon_realvalue - $row->coupon_value;
					 //$discount = round(($deal_value/$row->coupon_realvalue)*100);
                                         	        
                                         //$discount = ($mycoupon->coupon_realvalue * ($mycoupon->coupon_value/100));
                                         if(!empty($mycoupon->coupon_image))
                                         {
                                                if(file_exists(DOCUMENT_ROOT.'/'.$mycoupon->coupon_image))
                                                {
                                                        $img_url = DOCROOT.$mycoupon->coupon_image;
                                                }
                                                else
                                                {
                                                        $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';    
                                                }
                                        }
                                        else
                                        {
                                                $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'; 
                                        }
                                                $thumburl = DOCROOT.'system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image='.$img_url;
                                        if($format == 'xml')
                                        {
                                                $xml_content = '<response><mycoupons>';
                                        }
                                        //while($mycoupon = mysql_fetch_object($couponResult))
                                        //{
                                                if($format == 'xml')
                                                {
                                                        $xml_content .= '
                                                 <coupon>
                                                        <couponid>'.$mycoupon->couponid.'</couponid>
                                                        <couponimage>'.$thumburl.'</couponimage>
                                                        <couponname>'.htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_name, ENT_QUOTES))).'</couponname>
                                                        <description>'.htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_description, ENT_QUOTES))).'</description>
                                                        <highlights>'.htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_highlights, ENT_QUOTES))).'</highlights>
                                                        <fineprints>'.htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_fineprints, ENT_QUOTES))).'</fineprints>
                                                        <termsandcondition>'.htmlspecialchars(strip_tags(html_entity_decode($mycoupon->terms_and_condition, ENT_QUOTES))).'</termsandcondition>
                                                        <purchaseddate>'.$mycoupon->coupon_purchaseddate.'</purchaseddate>
                                                        <expirydate>'.$mycoupon->coupon_expirydate.'</expirydate>
                                                        <validityid>'.$mycoupon->coupon_validityid.'</validityid>
                                                        <couponusedstatus>'.$mycoupon->coupons_userstatus.'</couponusedstatus>
                                                 </coupon>';
                                                }
                                                else
                                                {
                                                        $json_response[] = array
                                                                           ("coupon" => array("couponid" => $mycoupon->couponid,
                                                                            "couponimage" => $thumburl,
                                                                            "couponname" => htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_name, ENT_QUOTES))),
                                                                            "description"=> htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_description, ENT_QUOTES))),
                                                                            "highlights"=> htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_highlights, ENT_QUOTES))),
                                                                            "fineprints"=> htmlspecialchars(strip_tags(html_entity_decode($mycoupon->coupon_fineprints, ENT_QUOTES))),
                                                                            "termsandcondition"=> htmlspecialchars(strip_tags(html_entity_decode($mycoupon->terms_and_condition, ENT_QUOTES))),
                                                                            "purchaseddate" => $mycoupon->coupon_purchaseddate,
                                                                            "expirydate" => $mycoupon->coupon_expirydate,
                                                                            "validityid" => $mycoupon->coupon_validityid,
                                                                            "couponusedstatus" => $mycoupon->coupons_userstatus));
                                                }
                                        //}
                                        if($format == 'xml')
                                        {
                                                $xml_content .= '</mycoupons></response>';
                                                echo $xml_content;
                                        }
                                        else
                                        {
                                                $deals_response["mycoupons"] = $json_response;
                                                echo json_encode($deals_response);
                                        }
                                        exit;  
                                }
                        }
                        else
                        {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>No coupons purchased</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"No coupons purchased"}}';
                                }
                                exit;
                        }
                        
                }
                else
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Userid is required</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"Userid is required"}}';
                        }
                        exit;
                }
        }
        
        //categorylist 
        else if($file == 'categorylist') //if the request is for categorylist
        {
                $today = date('Y-m-d');
                $end_time = $today.' 23:59:59';
                $categorylist = $parameters["categorylist"];
                $citynmae = urldecode($parameters['city']);
                
                        $categorylistQuery ="SELECT * , (SELECT COUNT( coupon_id ) FROM coupons_coupons left join coupons_cities on coupons_coupons.coupon_city=coupons_cities.cityid left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid WHERE coupons_coupons.coupon_category = coupons_category.category_id and coupons_cities.city_url='".$citynmae."' and coupon_status='A' and coupon_enddate>now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now()))) as ccount FROM coupons_category WHERE STATUS =  'A'";
                        $categorylistResult = mysql_query($categorylistQuery);
                              if(mysql_num_rows($categorylistResult) > 0)
                                 {
                                                                      
                                        if($format == 'xml')
                                        {
                                                $xml_content = '<response><category>';
                                        }
                                        while($allcategory = mysql_fetch_object($categorylistResult))
                                        {
                                                if($format == 'xml')
                                                {
                                                        $xml_content .= '
                                                 <categorylist><categoryname>'.$allcategory->category_name.'</categoryname><ccount>'.$allcategory->ccount.'</ccount></categorylist>';

                                                }
                                                else
                                                {
                                                        $json_response[] = array
                                                        ("category" => array("categoryname" => $allcategory->category_name, "count" => $allcategory->ccount));
                                                         
                                                }
                                        }
                                        if($format == 'xml')
                                        {
                                                $xml_content .= '</category></response>';
                                                echo $xml_content;
                                        }
                                        else
                                        {
                                                $deals_response["category"] = $json_response;
                                                echo json_encode($deals_response);
                                        }
                                        exit;  
                                
                        }
                        else
                        {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>No category Available</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"No category Available"}}';
                                }
                                exit;
                        }                                                
                
        }
        
        // Category
        else if($file == 'category') //if the request is for signup
        {
                $city = urldecode($parameters['city']);
                $categoryname = $parameters["category_name"];
                $today = date('Y-m-d');
                $end_time = $today.' 23:59:59';
                if(!empty($city))
                {
                
                               if($city)  //get the city id from cityname in url
				{
				        //get the list of cities
				        $city_result = mysql_query("select * from coupons_cities");
				        while($row = mysql_fetch_array($city_result))
				        {
				                $city_list[$row["cityid"]] = $row["city_url"];
				                if($city == $row["city_url"] || $city == $row["cityname"])
				                {
				                        $city_id = $row["cityid"];
				                }
				        }
				}
				
				if($categoryname)  //get the city id from cityname in url
				{

				        //get the list of cities
				        $category_result = mysql_query("select * from coupons_category");
				        while($categoryrow = mysql_fetch_array($category_result))
				        {
				                
				                if($categoryname == $categoryrow["category_url"] || $categoryname == $categoryrow["category_name"])
				                {
				                        $category_id = $categoryrow["category_id"];
				                }
				        }
				}
                        
                        $categoryQuery ="select (SELECT count( p.coupon_purchaseid )FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T') AS pcounts, TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id,coupon_name,deal_url,coupon_description,coupon_startdate,coupon_enddate,coupon_image,coupon_realvalue,coupon_minuserlimit, coupon_maxuserlimit,coupon_shop,coupon_fineprints, coupon_highlights,terms_and_condition,coupon_value,coupon_category,category_name,coupons_category.category_id from coupons_coupons left join coupons_category on coupons_coupons.coupon_category = coupons_category.category_id where ";    
                        
                        if($categoryname)
                        {
			        $categoryQuery .=" (coupons_coupons.coupon_category ='".$category_id."' and coupon_city = '$city_id' AND coupon_status = 'A' and coupon_enddate between now() and '$end_time') or (coupons_coupons.coupon_category ='".$category_id."' and coupon_city = '$city_id' AND coupon_status = 'A' and instant_deal='1' and coupon_enddate >= now())";	                        
                        }
			else
			{
			        $categoryQuery .=" (coupon_city = '$city_id' AND coupon_status = 'A' and coupon_enddate between now() and '$end_time') or (coupon_city = '$city_id' AND coupon_status = 'A' and instant_deal='1' and coupon_enddate >= now())";
        		}             
        		
                        $categoryResult = mysql_query($categoryQuery);

                        if(mysql_num_rows($categoryResult) > 0)
                        { 
                                $count = mysql_num_rows($categoryResult);
                                 if($format == 'xml')
                                {
                                        $xml_content = '<response><category>';
                                }
                                while($category = mysql_fetch_array($categoryResult))
                                {
                                        	$discount = $category['coupon_realvalue'] - $category['coupon_value'];
						$discount_percent = round(($discount/$category['coupon_realvalue'])*100);
                                                //$discount = ($row->coupon_realvalue * ($row->coupon_value/100));
					        //$current_amount = $row->coupon_realvalue - $discount; //current rate of deal
					       if(!empty($category['coupon_image']))
					        {
                                                        if(file_exists(DOCUMENT_ROOT.'/'.$category['coupon_image']))
                                                        {
                                                                $img_url = DOCROOT.$category['coupon_image'];
                                                        }
                                                        else
                                                        {
                                                                $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';    
                                                        }
                                                }
                                                else
                                                {
                                                        $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';    
                                                }
                                                $thumburl = $img_url;
                                        $json_shopid = $category["coupon_shop"];
                                        if($format == 'xml')
                                        {
                                        $xml_addressarray = mysql_query("select * from `coupons_shops`  left join `coupons_cities`  on coupons_cities.cityid=coupons_shops.shop_city where coupons_shops.shopid='".$json_shopid."' and coupons_shops.shop_city='".$city_id."'") or die(mysql_error()); 
                                          
                                                        $xml_addrContent = ''; $x = 1;
                                                        $xml_addrContent = '<merchantLocations>';
				                                while ($addressrow_category = mysql_fetch_object($xml_addressarray))
				                                { 

						                 $xml_addrContent .="<lng>".$addressrow_category->shop_longitude."</lng>                                                  
				                                  <shopname>".$addressrow_category->shopname."</shopname>
				                                  <streetAddress>".$addressrow_category->shop_address."</streetAddress>
				                                  <lat>".$addressrow_category->shop_latitude."</lat>
				                                  <couponid>".$category['coupon_id']."</couponid>";
								 $x++;

				                                }
				                                
                                                        $xml_addrContent .= '</merchantLocations>';                                                    
                                                       
                                                $xml_content .= '
                                         <coupon>
                                                <couponid>'.$category['coupon_id'].'</couponid>
                                               
                        		                     <price>
                                                                <p_amount>'.$category['coupon_value'].'</p_amount>
                                                                <p_currencyCode>'.PAYPAL_CURRENCY_CODE.'</p_currencyCode>
                                                                <p_formattedAmount>'.CURRENCY.$category['coupon_value'].'</p_formattedAmount>
                                                             </price>
                                                        <value>
                                                                <v_amount>'.$category['coupon_realvalue'].'</v_amount>
                                                                <v_currencyCode>'.PAYPAL_CURRENCY_CODE.'</v_currencyCode>
                                                                <v_formattedAmount>'.CURRENCY.$category['coupon_realvalue'].'</v_formattedAmount>
                                                        </value>
                                                        <discount>
                                                                <d_amount>'.$discount.'</d_amount>
                                                                <d_currencyCode>'.PAYPAL_CURRENCY_CODE.'</d_currencyCode>
                                                                <d_formattedAmount>'.CURRENCY.$discount.'</d_formattedAmount>
                                                        </discount>
                                                        
                                                        <discountPercent>'.$discount_percent.'</discountPercent>
                                                         <status>open</status>
                                                                <isSoldOut>false</isSoldOut>
                                                                <soldQuantity>'.$category['pcounts'].'</soldQuantity>
                                                                <timeleft>'.$category['timeleft'].'</timeleft>
                                                <couponimage>'.$thumburl.'</couponimage>
                                                <deal_couponname>'.htmlspecialchars(strip_tags(html_entity_decode($category['coupon_name'], ENT_QUOTES))).'</deal_couponname>
                                                <description>'.htmlspecialchars(strip_tags(html_entity_decode($category['coupon_description'], ENT_QUOTES))).'</description>
                                                <highlights>'.htmlspecialchars(strip_tags(html_entity_decode($category['coupon_highlights'], ENT_QUOTES))).'</highlights>
                                                <fineprints>'.htmlspecialchars(strip_tags(html_entity_decode($category['coupon_fineprints'], ENT_QUOTES))).'</fineprints>
                                                <termsandcondition>'.htmlspecialchars(strip_tags(html_entity_decode($category['terms_and_condition'], ENT_QUOTES))).'</termsandcondition>
                                                <categoryname>'.htmlspecialchars(strip_tags(html_entity_decode($category['category_name'], ENT_QUOTES))).'</categoryname>
                                                <startdate>'.$category['coupon_startdate'].'</startdate>
                                                <enddate>'.$category['coupon_enddate'].'</enddate>
                                                <dealcount>'.$category['pcounts'].'</dealcount>
                                                <dealtype>'.$category['deal_type'].'</dealtype>
                                                <location>'. $xml_addrContent.'</location>
                                                <minmumuserlimit>'.$category['coupon_minuserlimit'].'</minmumuserlimit>
                                                <maximumuserlimit>'.$category['coupon_maxuserlimit'].'</maximumuserlimit>
                                         </coupon>';
                                        }
                                        else
                                        {

                                        $json_addressarray = mysql_query("select * from `coupons_shops`  left join `coupons_cities`  on coupons_cities.cityid=coupons_shops.shop_city where coupons_shops.shopid='".$json_shopid."' and coupons_shops.shop_city='".$city_id."'");
                                                       
                                                        $n = 1;
                                                        $redemptionLocations_json = array();
				                                while ($addressrow_json = mysql_fetch_object($json_addressarray))
				                                {
				                                       
				                                        $redemptionLocations_json[] = array(
				                                                "redemptionLocation" => array(
				                                                        "lng" => $addressrow_json->shop_longitude,
				                                                       
				                                                       
				                                                        "shopname" => $addressrow_json->shopname,
				                                                        "streetAddress" => $addressrow_json->shop_address,
				                                                       "lat" => $addressrow_json->shop_latitude,

				                                                )
				                                        );

/*
				                                        $redemptionLocations_json[] = array(
				                                                "redemptionLocation_$n" => "redemptionLocation_$n",
				                                                        "lng_$n" => $addressrow_json->lan,
				                                                       
				                                                       
				                                                        "shopname_$n" => $addressrow_json->shopname,
				                                                        "streetAddress_$n" => $addressrow_json->address,
				                                                       "lat_$n" => $addressrow_json->lat,


				                                        );
*/
				                                        $n++;
				                                }

				                           
                                                $json_response[] = array
                                                                   ("coupon" => array("couponid" => $category['coupon_id'],
                                                                   "price" => array(
                                                                                        "amount" => $category['coupon_value'],
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$category['coupon_value'],
                                                                                ),
                                                                                "value" => array(
                                                                                        "amount" => $category['coupon_realvalue'],
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$category['coupon_realvalue'],
                                                                                ),
                                                                                "discount" => array(
                                                                                        "amount" => $discount,
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$discount,
                                                                                ),
                                                                    "discountPercent" =>$discount_percent,
                                                                    "status" => open,
                                                                    "isSoldOut" => false,
                                                                    "soldQuantity" => $category['pcounts'],
                                                                    "timeleft" => $category['timeleft'],            
                                                                    "couponimage" => $thumburl,
                                                                    "couponname" => htmlspecialchars(strip_tags(html_entity_decode($category['coupon_name'], ENT_QUOTES))),
                                                                    "description"=> htmlspecialchars(strip_tags(html_entity_decode($category['coupon_description'], ENT_QUOTES))),
                                                                    "highlights"=> htmlspecialchars(strip_tags(html_entity_decode($category['coupon_highlights'], ENT_QUOTES))),
                                                                    "fineprints"=> htmlspecialchars(strip_tags(html_entity_decode($category['coupon_fineprints'], ENT_QUOTES))),
                                                                    "termsandcondition"=> htmlspecialchars(strip_tags(html_entity_decode($category['terms_and_condition'], ENT_QUOTES))),  
                                                                    "categoryname" => htmlspecialchars(strip_tags(html_entity_decode($category['category_name'], ENT_QUOTES))),  
                                                                    "startdate" => $category['coupon_startdate'],
                                                                    "enddate" => $category['coupon_enddate'],
                                                                    "count" => $category['pcounts'],
                                                                    "deal_type" => $category['deal_type'],
                                                                    "location" => $redemptionLocations_json,
                                                                    "minmumuserlimit" => $category['coupon_minuserlimit'],
                                                                    "maximumuserlimit" => $category['coupon_maxuserlimit'],
                                                                    ));
                                                                    
                                                                    
                                                              
                                        }
                                }
                                if($format == 'xml')
                                {
                                        $xml_content .= '</category></response>';
                                        echo $xml_content;
                                }
                                else
                                {
                                        $deals_response["category"] = $json_response;
                                        echo json_encode($deals_response);
                                }
                                exit;  
                        }
                        else
                        {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>No Deals are Available</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":response,"message":"No Deals are Available"}}';
                                }
                                exit;
                        }
                        
                }
                else
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>City Name is required</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":response,"message":"City Name is required"}}';
                        }
                        exit;
                }
        }
        
	//API - Credit card purchase
        else if($file == 'payment') //if the request is for login
        {
            require_once DOCUMENT_ROOT.'/system/modules/gateway/paypal/CallerService.php'; 

			$USERID = $parameters["uid"];
			$COUPON_ID = $parameters["did"];
			$QUANTITY = $parameters["quantity"];
			
			//check deal quantity availability
			require_once(DOCUMENT_ROOT."/system/includes/transaction.php");
			//check_deal_quantity($COUPON_CODE,$_POST["friendname"],$_POST["friendemail"],$QUANTITY);
			$PAYMENTACTION = "Mobile Paypal Payment";
		
			$_SESSION['pay_mod_id'] = 1; //paypal module

		/**
		 * Get required parameters from the web form for the request
		 */
		
		$paymentType =urlencode("Mobile Payment");
		$creditCardType =urlencode($parameters["card_type"]);
		$creditCardNumber = urlencode($parameters["card_no"]);
		$expDateMonth =urlencode($parameters["emonth"]);
		// Month must be padded with leading zero
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$expDateYear =urlencode($parameters["eyear"]);
		$cvv2Number = urlencode($parameters["cvv"]);
		$amount = urlencode($parameters["amount"]);
		
		if($USERID)
		{
			$user_query = "select * from coupons_users left join coupons_cities on coupons_users.city = coupons_cities.cityid left join coupons_country on coupons_users.country = coupons_country.countryid where userid='$USERID'";
			$user_resultset = mysql_query($user_query);
			//checking whether user is exist
			if(mysql_num_rows($user_resultset)>0)
			{
				while($user_row=mysql_fetch_array($user_resultset))
				{
					//user info
					$firstName = urlencode($user_row["firstname"]);
					$lastName = urlencode($user_row["lastname"]);		
					//$address1 = urlencode("vadavalli");
					//$address2 = urlencode("vadavalli");
					$city = urlencode($user_row["cityname"]);
					//$city = urlencode("coimbatore");
					$state = urlencode($user_row["countryname"]);
					//$state = urlencode("tamilnadu");
					//$zip = '641090';
					$zip = '';
					$mail = urlencode($user_row["email"]);
				}
			}
		}
		
		
		$currencyCode=urlencode(PAYPAL_CURRENCY_CODE);
		$countrycode = urlencode("AU");
		//$paymentType = 1; //paypal credit card
		$couponid = urlencode($COUPON_ID);
		$qty = urlencode($QUANTITY);
		$userid = urlencode($USERID);
		$_SESSION['userid'] = $userid;
		
		
		$_SESSION['deal_quantity'] = $QUANTITY;
		
		
		$query = "select * from coupons_coupons where coupon_id='$couponid'";
		$resultset = mysql_query($query);
		while($row=mysql_fetch_array($resultset))
		{
				$DESC = html_entity_decode($row['coupon_name'],ENT_QUOTES);
				$total_payable_amount = $row["coupon_value"]; 

				if(ctype_digit($total_payable_amount)) 
				{ 
					$total_payable_amount = $total_payable_amount;
				} 					  
				else 
				{ 
	
					$total_payable_amount = number_format($total_payable_amount, 2,',','');
					$total_payable_amount = explode(',',$total_payable_amount);
					$total_payable_amount = $total_payable_amount[0].'.'.$total_payable_amount[1];
	
				}                
		}
		
		$amount = (($total_payable_amount * $qty)- $_SESSION['deductable_ref_amt']);
		
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
		   
		   
		$nvpstr="&PAYMENTACTION=Authorization&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
		"&ZIP=$zip&COUNTRYCODE=$countrycode&CURRENCYCODE=$currencyCode&CUSTOM=$couponid&L_AMT0=$total_payable_amount&L_NUMBER0=$userid&QTY=$qty&EMAIL=$mail";
		
//		echo $nvpstr; exit; 
		
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		$resArray=hash_call("doDirectPayment",$nvpstr);		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		$ack = strtoupper($resArray["ACK"]);
		$_SESSION['reshash']=$resArray;
		
			if($ack!="SUCCESS" and $ack!="SUCCESSWITHWARNING")  
			{
				if($format == 'xml') //for xml response -error
				{
						$xml_content = '<response><error><httpCode>400</httpCode><message>Transaction Failed</message></error></response>';
						echo $xml_content;
						exit;
				}
				else //for json response -error
				{
						$resp = '{"error":{"httpCode":400,"message":"Transaction Failed"';
						$resp .= '}}';
						echo $resp;
				}
				exit; 
			}
			elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING")
			{
				$transactionID = $resArray['TRANSACTIONID'];
			
				//print_r($resArray);exit;	 
			
				/* Construct the request string that will be sent to PayPal.
				   The variable $nvpstr contains all the variables and is a
				   name value pair string with & as a delimiter */
				$nvpStr="&TRANSACTIONID=$transactionID";
			
			
			
				/* Make the API call to PayPal, using API signature.
				   The API response is stored in an associative array called $resArray */
				$resArray=hash_call("gettransactionDetails",$nvpStr);
				//$_SESSION['reshash'] = $resArray;
			
				/* Next, collect the API request in the associative array $reqArray
				   as well to display back to the browser.
				   Normally you wouldnt not need to do this, but its shown for testing */
			
				$reqArray=$_SESSION['nvpReqArray'];
			
				/* Display the API response back to the browser.
				   If the response from PayPal was a success, display the response parameters'
				   If the response was an error, display the errors received using APIError.php.
				   */
				//$ack = strtoupper($resArray["ACK"]);
				$PAYERID = $resArray['PAYERID'];
				$PAYERSTATUS = $resArray['PAYERSTATUS'];
				$COUNTRYCODE = $resArray['COUNTRYCODE'];			
				$COUPONID = $resArray['CUSTOM'];
				$TIMESTAMP = $resArray['TIMESTAMP'];
				$CORRELATIONID = $resArray['CORRELATIONID'];
				$ACK = $resArray['ACK'];
				$FIRSTNAME = $resArray['FIRSTNAME'];	
				$LASTNAME = $resArray['LASTNAME'];	
				$TRANSACTIONID = $resArray['TRANSACTIONID'];	
				$RECEIPTID = $resArray['RECEIPTID'];	
				$TRANSACTIONTYPE = $resArray['TRANSACTIONTYPE'];	
				$PAYMENTTYPE = $resArray['PAYMENTTYPE'];	
				$ORDERTIME = $resArray['ORDERTIME'];	
				$AMT = $resArray['AMT'];	
				$CURRENCYCODE = $resArray['CURRENCYCODE'];	
				$PAYMENTSTATUS = $resArray['PAYMENTSTATUS'];	
				$PENDINGREASON = $resArray['PENDINGREASON'];	
				$REASONCODE = $resArray['REASONCODE'];	
				$L_QTY0 = $_SESSION['deal_quantity'];
				$USERID = $_SESSION['userid'];
				$EMAIL = $resArray['EMAIL'];
				$TYPE = $_SESSION['pay_mod_id'];
				$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];
				
				$queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,TIMESTAMP,CORRELATIONID,ACK,FIRSTNAME,LASTNAME,TRANSACTIONID,RECEIPTID,TRANSACTIONTYPE,PAYMENTTYPE,ORDERTIME,AMT,CURRENCYCODE,PAYMENTSTATUS,PENDINGREASON,REASONCODE,L_QTY0,USERID,EMAIL,TYPE,REFERRAL_AMOUNT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$TIMESTAMP','$CORRELATIONID','$ACK','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$RECEIPTID','$TRANSACTIONTYPE','$PAYMENTTYPE','$ORDERTIME','$AMT','$CURRENCYCODE','$PAYMENTSTATUS','$PENDINGREASON','$REASONCODE','$L_QTY0','$USERID','$EMAIL','$TYPE','$REFERRAL_AMOUNT')";
				
				$resultSet = mysql_query($queryString)or die(mysql_error());
			
				$_SESSION['txn_id'] = mysql_insert_id();
				check_deal_status($COUPONID); //check deal status if it reached max limit close the deal
			
				$_SESSION['COUPONID'] = $COUPONID;
				$_SESSION['txn_amt'] = $AMT+$REFERRAL_AMOUNT;
			
				$orderdetails = "<table>";
				foreach($resArray as $key => $value) {
					$orderdetails .="<tr><td> $key:</td><td>$value</td>";
				}
				$orderdetails .= "</table>";
			
				$to      = $EMAIL;
				$subject = APP_NAME.'&nbsp;Order Status';
				$message = $orderdetails;
				$headers = 'From: '.SITE_EMAIL.'' . "\r\n" .
					'Reply-To: '.$EMAIL.'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
			
				@mail($to, $subject, $message, $headers);
			
				//inputs for the transaction method
				$cid=$_SESSION['COUPONID'];
				$txnid=$_SESSION['txn_id'];
				$deal_quantity=$_SESSION['deal_quantity'];
				$txn_amt=$_SESSION['txn_amt'];
				$gift_recipient_id=$_SESSION['gift_recipient_id'];
				$_SESSION["userid"] = 
			
				//calling the transaction method for amount deduction
				include(DOCUMENT_ROOT."/system/includes/process_transaction.php");
			
				if($format == 'xml') //for xml response -error
				{
						$xml_content = '<response>';	
						$xml_content .= '<message>Transaction Success</message>
						<transaction>';
						foreach($resArray as $key => $value) 
						{
						        if($key=='TOKEN' || $key=='TIMESTAMP' || $key=='CORRELATIONID' || $key=='ACK' || $key=='TRANSACTIONID' || $key=='CURRENCYCODE' || $key=='AVSCODE' || $key=='AMT' || $key=='L_LONGMESSAGE0' || $key=='Invoice Number' || $key=='Authorization Code' || $key=='Credit card' || $key=='Billing Address' || $key=='Order Status' || $key=='Invoice Number'){    			
							$xml_content .="<".$key.">".$value."</".$key.">";
							}
						}
						$xml_content .= '</transaction></response>';				
						echo $xml_content;
						exit;
				}
				else //for json response -error
				{
				                $resp = array("message" => "Transaction Success");
				                foreach($resArray as $key => $value) 
						{
				                        if($key=='TOKEN' || $key=='TIMESTAMP' || $key=='CORRELATIONID' || $key=='ACK' || $key=='TRANSACTIONID' || $key=='CURRENCYCODE' || $key=='AVSCODE' || $key=='AMT' || $key=='L_LONGMESSAGE0' || $key=='Invoice Number' || $key=='Authorization Code' || $key=='Credit card' || $key=='Billing Address' || $key=='Order Status' || $key=='Invoice Number'){    			
							        $transaction_details[$key] = $value;
					                }
					        }
				                $resp['transaction'] = $transaction_details;				                
				                $deals_response["response"] = $resp;
                                                echo json_encode($deals_response);
						
				}			
				exit;
			}

        }
        else if($file == 'validate')
        {
                $validity_id = $parameters["validity_id"];
                $userid = $parameters["userid"];
                if(!empty($userid) && !empty($validity_id))
                {
                        $validateQuery = "select * from coupons_purchase cp left join coupons_coupons c on c.coupon_id=cp.couponid where cp.coupon_validityid='$validity_id'";
                        $validateResult = mysql_query($validateQuery);
                        if(mysql_num_rows($validateResult)>0)
		        {
		        
		                while($valid = mysql_fetch_array($validateResult))
		                {
		                        $validate_status = $valid["coupons_userstatus"];
		                }
		                if($validate_status == 'U')
		                {
		                        if($format == 'xml')
                                        {
                                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>Coupon has been validated already</message></error></response>';
                                        }
                                        else
                                        {
                                                echo '{"error":{"httpCode":400,"message":"Coupon has been validated already"}}';
                                        }
                                        exit; 
		                }
			                $queryString1 = "update  coupons_purchase set coupons_userstatus='U',coupons_user_useddate=now(),coupons_acceptedby=".$userid." where coupon_validityid='$validity_id'";
			                $resultset1 = mysql_query($queryString1) or die(mysql_error());

			// send email to the users once close coupon
			
				        $queryString2 = "SELECT  cu.firstname,cu.lastname,c.coupon_name,cp.coupon_validityid,cu.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid  left join coupons_coupons c on c.coupon_id=cp.couponid where cp.coupon_validityid = '$validity_id'";
				        $resultSet2 = mysql_query($queryString2);

				        if(mysql_num_rows($resultSet2)>0)
				        {
					        while($row2=mysql_fetch_array($resultSet2))
					        {
						        $validityId = $row2['coupon_validityid'];
						        $coupon_name = $row2['coupon_name'];								  
						        $to = $row2['email'];
						        $name = ucfirst($row2['firstname']).' '.ucfirst($row2['lastname']);
						        $subject = "Your Coupon .".ucfirst($coupon_name)." offer has been Used";
						        $msg = "Your Coupon .".ucfirst($coupon_name)." offer has been Used for the Validy Id".$validityId.".";

						        $from = SITE_EMAIL;
						        $logo = DOCROOT."site-admin/images/logo.png";

						        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
						        $str = implode("",file($_SERVER['DOCUMENT_ROOT'].'/themes/_base_theme/email/email_all.html'));
		
						        $str = str_replace("SITEURL",$docroot,$str);
						        $str = str_replace("SITELOGO",$logo,$str);
						        $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
						        $str = str_replace("MESSAGE",ucfirst($msg),$str);
						        $str = str_replace("SITENAME",SITE_NAME,$str);        

						        $SMTP_USERNAME = SMTP_USERNAME;
						        $SMTP_PASSWORD = SMTP_PASSWORD;
						        $SMTP_HOST = SMTP_HOST;
						        $SMTP_STATUS = SMTP_STATUS;	

							        $message = $str;

							        if($SMTP_STATUS==1)
							        {
	
								        include($_SERVER['DOCUMENT_ROOT']."/system/modules/SMTP/smtp.php"); //mail send thru smtp
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
						     

					        }
			   //end email

                                        }
                                        if($format == 'xml')
                                        {
                                                echo $xml_content = '<response><validate><message>Coupon validated</message></validate></response>';
                                        }
                                        else
                                        {
                                                echo '{"response":{"message":"Coupon validated"}}';
                                        }
                                        exit; 
                        }
                        else
                        {
                               if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>Invalid coupon validity code</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"Invalid coupon validity code"}}';
                                }
                                exit; 
                        }
                }
                else
                {
                                if($format == 'xml')
                                {
                                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>User id and validity id are required</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"User id and validity id are required"}}';
                                }
                                exit; 
                }		
        }
        else
        {
                if($city)  //get the city id from cityname in url
                {
                        //get the list of cities
                        $city_result = mysql_query("select * from coupons_cities");
                        while($row = mysql_fetch_array($city_result))
                        {
                                $city_list[$row["cityid"]] = $row["city_url"];
                                if($city == $row["city_url"] || $city == $row["cityname"])
                                {
                                        $city_id = $row["cityid"];
                                }
                        }
                }
                else //if city not provided in url
                {

                        $city_id = '';
                        if($format == 'xml')
                        {
                        echo $xml_content = '<response><error><httpCode>400</httpCode><message>City is required as a URL parameter; Example: ?city=city-name</message></error></response>';
                        }
                        else
                        {
                                echo '{"error":{"httpCode":400,"message":"city is required as a URL parameter; Example: ?city=city-name"}}';
                        }
                        exit;
                }



                $result = mysql_query("select * from api_client_details where api_key='$client_id' and status=1");
                
                //check whether client_id is valid
                
                if(mysql_num_rows($result)>0) //valid client id
                {
                        if(!empty($city_id))
                        {
                        	$deal = $_REQUEST['file'];
                        	if($deal == 'deal')
                        	{
                        	        $current_startdate = date("Y-m-d").' 00:00:00';
			                $current_enddate = date("Y-m-d").' 23:59:59';
                        	        $queryString = "select (SELECT count( p.coupon_purchaseid )FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T') AS pcounts,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id, coupon_name, coupon_description, coupon_startdate, coupon_enddate, coupon_minuserlimit, coupon_maxuserlimit, coupon_highlights, coupon_fineprints, coupon_image, coupon_realvalue, coupon_value, cityname, shopname, shop_address, shop_latitude, shop_longitude from coupons_coupons left join coupons_cities on coupons_coupons.coupon_city=coupons_cities.cityid left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid where coupon_city = '$city_id' AND coupon_enddate between '$current_startdate' and '$current_enddate' AND coupon_status = 'A' LIMIT 1";
                        	        $resultSet = mysql_query($queryString);
                        	        if(!mysql_num_rows($resultSet)>0) //if no today deals
                        	        {
                        	                $queryString = "select (SELECT count( p.coupon_purchaseid )FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T') AS pcounts,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id, coupon_name, coupon_description, coupon_startdate, coupon_enddate, coupon_minuserlimit, coupon_maxuserlimit, coupon_highlights, coupon_fineprints, coupon_image, coupon_realvalue, coupon_value, cityname, shopname, shop_address, shop_latitude, shop_longitude from coupons_coupons left join coupons_cities on coupons_coupons.coupon_city=coupons_cities.cityid left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid where coupon_city = '$city_id' AND coupon_status = 'A' and coupon_enddate > now() order by rand() limit 1";
                                                $resultSet = mysql_query($queryString);
                        	        }

                        	}
                        	else
                        	{
                                //get the hot deals from the specified city
                                        $queryString = "select (SELECT count( p.coupon_purchaseid )FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T') AS pcounts,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id, coupon_name, coupon_description, coupon_startdate, coupon_enddate, coupon_minuserlimit, coupon_maxuserlimit, coupon_highlights, coupon_fineprints, coupon_image, coupon_realvalue, coupon_value, cityname, shopname, shop_address, shop_latitude, shop_longitude from coupons_coupons left join coupons_cities on coupons_coupons.coupon_city=coupons_cities.cityid left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid where coupon_city = '$city_id' AND coupon_status = 'A' and coupon_enddate > now() order by coupon_id desc";
                                        $resultSet = mysql_query($queryString);
                                }
                                
                                if($format == 'xml')
                                {
                                        $xml_content = '<response><deals>';
                                }
                                       
                                if(mysql_num_rows($resultSet))
                                {
                                       
                                        while($row = mysql_fetch_object($resultSet))
                                        {
                                        	 $discount = $row->coupon_realvalue - $row->coupon_value;
                                        	 $discount_percent = round(($discount/$row->coupon_realvalue)*100);
						//$discount = ($row->coupon_realvalue * ($row->coupon_value/100));
					        //$current_amount = $row->coupon_realvalue - $discount; //current rate of deal
					        
					        if(!empty($row->coupon_image))
					        {
                                                        if(file_exists(DOCUMENT_ROOT.'/'.$row->coupon_image))
                                                        {
                                                                $img_url = DOCROOT.$row->coupon_image;
                                                        }
                                                        else
                                                        {
                                                                $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';    
                                                        }
                                                }
                                                else
                                                {
                                                        $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';    
                                                }
                                                $thumburl = DOCROOT.'system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image='.$img_url;
                                                //$thumburl = DOCROOT;
                                                if($format == 'xml') //if response format is xml 
                                                {
                                                        $xml_content .= '<deal>
                                                                <id>'.$row->coupon_id.'</id>
                                                                <dealtitle>'.$row->coupon_name.'</dealtitle>
                                                                <city>
                                                                        <name>'.$row->cityname.'</name>
                                                                </city>
                                                                <imgurl>'.$img_url.'</imgurl>
                                                                
                                                                <status>open</status>
                                                                <isSoldOut>false</isSoldOut>
                                                                <soldQuantity>'.$row->pcounts.'</soldQuantity>
                                                                <timeleft>'.$row->timeleft.'</timeleft>
                                                                <dealUrl>'.DOCROOT.'deals/'.$row->deal_url.'_'.$row->coupon_id.'.html'.'</dealUrl>
                                                             
                                                                <options>
                                                                        <option>
                                                                                <id>'.$row->coupon_id.'</id>
                                                                                <dealtitle>'.htmlspecialchars(strip_tags(html_entity_decode($row->coupon_name, ENT_QUOTES))).'</dealtitle>
                                                                                <price>
                                                                                        <p_amount>'.$row->coupon_value.'</p_amount>
                                                                                        <p_currencyCode>'.PAYPAL_CURRENCY_CODE.'</p_currencyCode>
                                                                                        <p_formattedAmount>'.CURRENCY.$row->coupon_value.'</p_formattedAmount>
                                                                                </price>
                                                                                <value>
                                                                                        <v_amount>'.$row->coupon_realvalue.'</v_amount>
                                                                                        <v_currencyCode>'.PAYPAL_CURRENCY_CODE.'</v_currencyCode>
                                                                                        <v_formattedAmount>'.CURRENCY.$row->coupon_realvalue.'</v_formattedAmount>
                                                                                </value>
                                                                                <discount>
                                                                                        <d_amount>'.$discount.'</d_amount>
                                                                                        <d_currencyCode>'.PAYPAL_CURRENCY_CODE.'</d_currencyCode>
                                                                                        <d_formattedAmount>'.CURRENCY.$discount.'</d_formattedAmount>
                                                                                </discount>
                                                                                <discountPercent>'.$discount_percent.'</discountPercent>
                                                                                <isLimitedQuantity>true</isLimitedQuantity>
                                                                                <minimumPurchaseQuantity>'.$row->coupon_minuserlimit.'</minimumPurchaseQuantity>
                                                                                <maximumPurchaseQuantity>'.$row->coupon_maxuserlimit.'</maximumPurchaseQuantity>
                                                                                <expiresAt>'.$row->coupon_enddate.'</expiresAt>
                                                                                <details>
                                                                                        <detail>
                                                                                                <description>'.htmlspecialchars(strip_tags(html_entity_decode($row->coupon_description, ENT_QUOTES))).'</description>
                                                                                        </detail>
                                                                                </details>
                                                                                <highlights>'.htmlspecialchars(strip_tags(html_entity_decode($row->coupon_highlights, ENT_QUOTES))).'</highlights>
                                                                                <fineprints>'.htmlspecialchars(strip_tags(html_entity_decode($row->coupon_fineprints, ENT_QUOTES))).'</fineprints>
                                                                                <redemptionLocations>
                                                                                        <redemptionLocation>
                                                                                                <lng>'.$row->shop_longitude.'</lng>
                                                                                                <city>'.$row->cityname.'</city>
                                                                                                <name>'.$row->shopname.'</name>
                                                                                                <streetAddress>'.$row->shop_address.'</streetAddress>
                                                                                                <lat>'.$row->shop_latitude.'</lat>
                                                                                        </redemptionLocation>
                                                                                </redemptionLocations>
                                                                                <buyUrl>'.DOCROOT.'purchase.html?cid='.$row->coupon_id.'</buyUrl>
                                                                        </option>
                                                                </options>
                                                                <startAt>'.$row->coupon_startdate.'</startAt>
                                                                <endAt>'.$row->coupon_enddate.'</endAt>
                                                        </deal>';  
                                                }
                                                
                                                else//if response format is json 
                                                {
                                                        $json_response[] = array
                                                                ("id" => $row->coupon_id,
                                                                "title" => $row->coupon_name,
                                                                "city" => array(
                                                                        "name" => $row->cityname
                                                                ),
                                                                "imgurl" => $img_url,
                                                                //"sidebarImageUrl" => $thumburl,
                                                                "status" => open,
                                                                "isSoldOut" => false,
                                                                "soldQuantity" => $row->pcounts,
                                                                "timeleft" => $row->timeleft,
                                                                "dealUrl" => DOCROOT.'deals/'.$row->deal_url.'_'.$row->coupon_id.'.html',
                                                               
                                                                "options" => array(
                                                                        "option" => array(
                                                                                "id" => $row->coupon_id,
                                                                                "title" => html_entity_decode($row->coupon_name, ENT_QUOTES),
                                                                                "price" => array(
                                                                                        "amount" => $row->coupon_value,
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$row->coupon_value,
                                                                                ),
                                                                                "value" => array(
                                                                                        "amount" => $row->coupon_realvalue,
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$row->coupon_realvalue,
                                                                                ),
                                                                                "discount" => array(
                                                                                        "amount" => $discount,
                                                                                        "currencyCode" => PAYPAL_CURRENCY_CODE,
                                                                                        "formattedAmount" => CURRENCY.$discount,
                                                                                ),
                                                                                "discountPercent" => $discount_percent,
                                                                                "isLimitedQuantity" => true,
                                                                                "minimumPurchaseQuantity" => $row->coupon_minuserlimit,
                                                                                "maximumPurchaseQuantity" => $row->coupon_maxuserlimit,
                                                                                "expiresAt" => $row->coupon_enddate,
                                                                                "details" => array(
                                                                                        "detail" => array(
                                                                                                "description" => htmlspecialchars(strip_tags(html_entity_decode($row->coupon_description, ENT_QUOTES)))
                                                                                        )
                                                                                ),
                                                                                "highlights" => htmlspecialchars(strip_tags(html_entity_decode($row->coupon_highlights, ENT_QUOTES))),
                                                                                "fineprints" => htmlspecialchars(strip_tags(html_entity_decode($row->coupon_fineprints, ENT_QUOTES))),
                                                                                "redemptionLocations" => array(
                                                                                        "redemptionLocation" => array(
                                                                                                "lng" => $row->shop_longitude,
                                                                                                "city" => $row->cityname,
                                                                                                "name" => $row->shopname,
                                                                                                "streetAddress" => $row->shop_address,
                                                                                                "lat" => $row->shop_latitude,
                                                                                        )
                                                                                ),
                                                                                "buyUrl" => DOCROOT.'purchase.html?cid='.$row->coupon_id,
                                                                        )
                                                                ),
                                                                "startAt" => $row->coupon_startdate,
                                                                "endAt" => $row->coupon_enddate,
                                                                );
                                                                
                                                                //write the deal detail into the json file
                                                                

                                                }     
                                        }
                                }
                        }
                        else
                        {      
                                if($format == 'xml')
                                {
                                echo $xml_content = '<response><error><httpCode>400</httpCode><message>City not found</message></error></response>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"city is not found"}}';
                                }
                                exit;
                        }
                }
                else
                {
                        if($format == 'xml')
                        {
                                echo $xml_content = '<?xml version="1.0" encoding="UTF-8"?><error><httpCode>400</httpCode><message>Invalid client id</message></error></xml>';
                                }
                                else
                                {
                                        echo '{"error":{"httpCode":400,"message":"Invalid client id"}}';
                                }
                                exit;
                                
                        }
                }
        }
        else
        {
                if($format == 'xml')
                {
                        echo $xml_content = '<?xml version="1.0" encoding="UTF-8"?><error><httpCode>400</httpCode><message>Invalid Client ID</message></error></xml>';
                }
                else
                {
                        echo '{"error":{"httpCode":400,"message":"Invalid Client ID"}}';
                }
                exit;
        }
}
else
{
        if($format == 'xml')
        {
                echo $xml_content = '<?xml version="1.0" encoding="UTF-8"?><error><httpCode>400</httpCode><message>client_id is required as a URL parameter; Example: ?client_id=[your API key]</message></error></xml>';
        }
        else
        {
                echo '{"error":{"httpCode":400,"message":"client_id is required as a URL parameter; Example: ?client_id=[your API key]"}}';
        }
        exit;
}
		
		if($format == 'xml')
		{
				$xml_content .= '</deals></response>';
				echo $xml_content;       
		}
		else
		{
				$deals_response["deals"] = $json_response;
				echo json_encode($deals_response);
		}




ob_flush();
?>
