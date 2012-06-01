<?php ob_start();
session_start();


define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(DOCUMENT_ROOT.'/system/includes/library.inc.php');
require_once(DOCUMENT_ROOT.'/system/includes/dboperations.php');
require_once(DOCUMENT_ROOT.'/system/includes/docroot.php');
require_once(DOCUMENT_ROOT.'/system/includes/functions.php');


$lang = $_SESSION["site_language"];
if($lang)
{
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/en.php");
}
  
if($_REQUEST['type']=="" && $_REQUEST['mail']=="")
{ 
              
              if($_POST["username"]==$language['valid_username'] || $_POST["password"]==$language['valid_password'] || $_POST["firstname"]==$language['valid_firstname'] || $_POST["lastname"]==$language['valid_lastname'] || $_POST["email"]==$language['valid_email']){

				set_response_mes(-1,$language["fieldmandatory"]);
				url_redirect(DOCROOT."registration.html");

		}
		
                $username = htmlentities($_POST["username"], ENT_QUOTES);
		$password = md5($_POST["password"]);
		$firstname = htmlentities($_POST["firstname"], ENT_QUOTES);
		$lastname = htmlentities($_POST["lastname"], ENT_QUOTES);
		$email = $_POST["email"];
		$mobile = htmlentities($_POST["mobile"], ENT_QUOTES);
		if($mobile==$language['valid_mobile'])
		{		
		        //set_response_mes(-1, $language['valid_mobile']);
			//url_redirect(DOCROOT."registration.html");
			$mobile="";
		}

                  //$user = htmlentities($_POST['username'], ENT_QUOTES);
	          //$address = htmlentities($_POST['address'], ENT_QUOTES);
	          //$mobile = htmlentities($_POST['mobile'], ENT_QUOTES);
                 //$email = $_POST['email'];
	 
		//check user availability 
		$resultSet = mysql_query("select * from coupons_users where username='$username'");
		
		        if(mysql_num_rows($resultSet) > 0)
		        {
		                     if(!empty($_SESSION['referral_id']))
			            {
			            
			              // echo "if"; print_r($_REQUEST);exit;	
			             set_response_mes(-1, $language['userexist']);
			             url_redirect(DOCROOT."ref.html?id=".$_SESSION['referral_id']);	
			            }
			            else
			            {
			               //echo "else"; print_r($_REQUEST);exit;
			             set_response_mes(-1, $language['userexist']);
			             url_redirect(DOCROOT."registration.html");
			            }	
			            
			        //set_response_mes(-1, $admin_language['usernameexisttry']);
			        //$role = $_POST['role'];
			        //url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");
			        // url_redirect(DOCROOT."registration.html");
		        }
		        
		        	//check email address already exist
		        $resultSet2 = mysql_query("select * from coupons_users where email='$email'");
		        if(mysql_num_rows($resultSet2) > 0)
		        {			
			        set_response_mes(-1, $language['emailexisttry']);
			        //$role = $_POST['role'];
			        //url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");
			         url_redirect(DOCROOT."registration.html");
		        }
		
		
		if(mysql_num_rows($resultSet) == 0)
		{		       
		        $ranval = referral_ranval();
			$query = "insert into coupons_users(username,password,firstname,lastname,email,mobile,user_role,user_status,referral_id) values('$username','$password','$firstname','$lastname','$email','$mobile','4','A','$ranval')";
			$res = mysql_query($query) or die(mysql_error());
			$last_insert_id = mysql_insert_id();
			
				
	        	if(!empty($_SESSION['referral_id']))
			{
				$referral_id = $_SESSION['referral_id'];
				$resultSet = mysql_query("select * from coupons_users where referral_id='$referral_id'");
				
				if(mysql_num_rows($resultSet) > 0)
				{
				
					while($row = mysql_fetch_array($resultSet))
					{
						$userid = $row['userid'];
					}

					mysql_query("insert into referral_list (reg_person_userid,referred_person_userid,deal_bought_count) values ('$last_insert_id','$userid','0')");

					$_SESSION['referral_id']='';	
											
				}				

			}			
			
			if($last_insert_id)
			{			
			        $logo = DOCROOT."site-admin/images/logo.png";
				// Send mail to user regarding successfull registration
				$from = SITE_EMAIL;
				$to = $_POST["email"];
				$name = $_POST["firstname"];

				//getting subject and description variables
				$subject = $email_variables['registration_subject'];
				$description = $email_variables['registration_description'];
                                $description = str_replace("USERNAME",$_POST["username"],$description);
                                $description = str_replace("PASSWORD",$_POST["password"],$description);
	  
	                        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	                        	
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
			
				set_response_mes(1,$language['registration_success']);
				url_redirect(DOCROOT."login.html");
			}
			
	

               }

}
else if($_REQUEST['mail']!="")
{
                $queryString = "select userid from coupons_users where email ='".$_REQUEST["mail"]."'";
		$resultSet = mysql_query($queryString);
	        if(mysql_num_rows($resultSet)>0)
                  {
	                    echo $language['emailexist'];
                  }
                  else
                  {
	                    echo  "<span style='clear:both;float:left;color:green!important'>". $language['enjoyemail']."</span>"; 
                  }
}
else
{ 	
                   $queryString = "select userid from coupons_users where username ='".$_REQUEST["type"]."'";
		   $resultSet = mysql_query($queryString);
	            if(mysql_num_rows($resultSet)>0)
                   {
	                    echo $language['userexist'];
                   }
		   else
		   {
		          echo  "<span style='clear:both;float:left;color:green!important'>". $language['enjoyuser']."</span>";
		   }
	
}
ob_flush();
?>
