<?php 
session_start();
require_once(DOCUMENT_ROOT.'/system/includes/dboperations.php');
require_once(DOCUMENT_ROOT.'/system/includes/docroot.php');
require_once(DOCUMENT_ROOT.'/system/includes/functions.php');
require_once(DOCUMENT_ROOT.'/system/includes/config.php');

$admin_lang = $_SESSION["site_admin_language"];
if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}

if($_REQUEST['type']=="c")
{
   
if($_SESSION['userid']!="")
{ 
	$ccode=$_REQUEST['couponcode'];
	$uid=$_SESSION['userid'];

	echo $queryString = "select * from coupons_purchase cp left join coupons_coupons c on c.coupon_id=cp.couponid where  cp.coupons_userstatus='UN' and cp.coupon_validityid='".$ccode."' and c.coupon_expirydate >= now()";
	$resultSet = mysql_query($queryString);
exit;
	if(mysql_num_rows($resultSet)>0)
	{
         
		if($noticia=mysql_fetch_array($resultSet))
		{ 
			$queryString = "update  coupons_purchase set coupons_userstatus='U',coupons_user_useddate=now(),coupons_acceptedby=".$uid." where coupon_validityid='".$ccode."'";
			$resultset = mysql_query($queryString) or die(mysql_error());

			// send email to the users once close coupon
			
				$queryString2 = "SELECT  cu.firstname,cu.lastname,c.coupon_name,cp.coupon_validityid,cu.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid  left join coupons_coupons c on c.coupon_id=cp.couponid where cp.coupon_validityid = '$ccode'";
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
						$str = implode("",file('themes/_base_theme/email/email_all.html'));
		
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

					}
				}
	 
		       //end email

			echo $admin_language['successfullyofferpurchased'];
           }
         
       	 }
		 else
		 {
			echo $admin_language['invalidcode'];
		 }

}
else
{
	echo $admin_language['pleaselogintogetoffer'];
}  

}
?>
