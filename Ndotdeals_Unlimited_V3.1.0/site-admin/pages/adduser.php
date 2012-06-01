<?php ob_start();
session_start();
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(DOCUMENT_ROOT.'/system/includes/dboperations.php');
require_once(DOCUMENT_ROOT.'/system/includes/docroot.php');
require_once(DOCUMENT_ROOT.'/system/includes/functions.php');

$admin_lang = $_SESSION["site_admin_language"];
if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}
  
if($_REQUEST['type']=="" && $_REQUEST['mail']=="")
{ 

	$user = htmlentities($_POST['username'], ENT_QUOTES);
	$address = htmlentities($_POST['address'], ENT_QUOTES);
	$mobile = htmlentities($_POST['mobile'], ENT_QUOTES);
	$email = $_POST['email'];
	 
		//check user availability 
		$resultSet = mysql_query("select * from coupons_users where username='$user'");
		if(mysql_num_rows($resultSet) > 0)
		{
			set_response_mes(-1, $admin_language['usernameexisttry']);
			$role = $_POST['role'];
			url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");
		}
		
		//check email address already exist
		$resultSet2 = mysql_query("select * from coupons_users where email='$email'");
		if(mysql_num_rows($resultSet2) > 0)
		{			
			set_response_mes(-1, $admin_language['emailexisttry']);
			$role = $_POST['role'];
			url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");
		}
	
	$firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
	$lastname = htmlentities($_POST['lastname'], ENT_QUOTES);
	$enpassword = md5($_POST['password']);
	$password = $_POST['password'];
	$pay_account = $_POST['pay_account'];
	$role = $_POST['role'];
	$ctype = $_POST['ctype'];
	$country = $_POST['country'];
	$city = $_POST['city'];

	if(empty($firstname) || empty($lastname) || empty($password) || empty($email) || empty($user) || empty($address))
	{
		set_response_mes(-1, $admin_language['fieldmandatory']);
		$role = $_POST['role'];
		url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");	
	}

	if(empty($city) || empty($country))
	{
		set_response_mes(-1, $admin_language['condcitymand']);
		$role = $_POST['role'];
		url_redirect(DOCROOT."admin/reg/".strtolower($role)."/");	
	}

	$roleid=getRoleId($role);

	if(strtolower($role)=='sa')
	{
		$shopname = htmlentities($_POST['shopname'], ENT_QUOTES);
		$shopaddress = htmlentities($_POST['shopaddress'], ENT_QUOTES);
		$lat = htmlentities($_POST['lat'], ENT_QUOTES);
		$lang = htmlentities($_POST['lang'], ENT_QUOTES);
		$shopurl = htmlentities($_POST['shopurl'], ENT_QUOTES);

		$queryString = "select * from coupons_shops where shopname = '$shopname' and shop_city = '$city'";
		$resultSet = mysql_query($queryString);

			if(mysql_num_rows($resultSet)>0)
			{

				set_response_mes(-1, $admin_language['shopnameexist']); 		 
				$redirect_url = DOCROOT.'admin/reg/sa/';
				url_redirect($redirect_url);

			}
			else
			{
				$shopcreatedby = $_SESSION["userid"];
				$queryString = "insert into coupons_shops (shopname,shop_address,shop_city,shop_country,shop_status,shop_latitude,shop_longitude,shop_createdby,shop_createddate,shop_url) values ('$shopname','$shopaddress','$city','$country','A','$lat','$lang','$shopcreatedby',now(),'$shopurl')";
				$resultSet = mysql_query($queryString) or die(mysql_error());
				$created_shop_id = mysql_insert_id();


	                        if(isset($_FILES["logo"]))
	                        {
	                                $logo_id = $created_shop_id.'.jpg';
                               
	                               if($_FILES["logo"]["error"] > 0)
	                                {

	                                }
	                                
	                                else if($_FILES['logo']['type']== "image/jpg" || $_FILES['logo']['type']== "image/jpeg" || $_FILES['logo']['type']== "image/png" || $_FILES['logo']['type']== "image/gif")
	                                {
                                                if(is_uploaded_file($_FILES['logo']['tmp_name']))
		                                {

                                                        $targetFile = DOCUMENT_ROOT.'/uploads/logo_images/'.$logo_id;
		                                        move_uploaded_file($_FILES['logo']['tmp_name'],$targetFile); 

		                                }
                                        }
	                        }



			}

	}
	else
	{
		$created_shop_id='';
	}


	//$uid=maxUserId()+1;
	$uid=$_SESSION["userid"];
	$ranval = referral_ranval();

	$queryString = "insert into coupons_users(username,password,pay_account,address,country,city,mobile,email,user_role,created_by,created_date,user_status,firstname,lastname,user_shopid,referral_id) values ('$user','$enpassword','$pay_account','$address','$country','$city','$mobile','$email','$roleid','$uid',now(),'A','$firstname','$lastname','$created_shop_id','$ranval')";
	
	$resultSet = mysql_query($queryString) or die(mysql_error());

	if(mysql_affected_rows() > 0)
	{
		set_response_mes(1, $admin_language['registrationcomplete']); 		 
		$redirect_url = DOCROOT.'admin/profile/';
		url_redirect($redirect_url);
	}
	else
	{
		set_response_mes(2, $admin_language['erroroccured']); 		 
		$redirect_url = DOCROOT.'admin/profile/';
		url_redirect($redirect_url);
	}

}

else if($_REQUEST['mail']!="" && $_REQUEST['mail']!="empty")
{ 
  $queryString = "select userid from coupons_users where email ='".$_REQUEST["mail"]."'";
  
		$resultSet = mysql_query($queryString);
	        if(mysql_num_rows($resultSet)>0)
                  {
                  
	                    echo $admin_language['emailexist'];
                  }
                  else
                  {
	                    echo $admin_language['enjoyemail']; 
                  }
}

else
{ 	
  $queryString = "select userid from coupons_users where username ='".$_REQUEST["type"]."'";
		$resultSet = mysql_query($queryString);
	         if(mysql_num_rows($resultSet)>0)
                   {
                           if(($_REQUEST['mail']!="empty") && ($_REQUEST['type']!="empty"))
	                    echo $admin_language['userexist'];
                   }
		else
		{ 
		          if(($_REQUEST['mail']!="empty") && ($_REQUEST['type']!="empty"))  
		          echo $admin_language['enjoyuser']; 
		}
	
}
ob_flush();
?>
