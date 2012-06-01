<?php ob_start();
	session_start();
	$delete_api_id = $_GET["del_id"];
	require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
	//get language config file
	$admin_lang = $_SESSION["site_admin_language"];
	
	if($admin_lang)
	{
			include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
	}
	else
	{
			include(DOCUMENT_ROOT."/system/language/admin_en.php");
	}

	if($_REQUEST['countryid']!="" )
	{
		$countryid=$_REQUEST['countryid'];
		$queryString = "delete from coupons_country where countryid='".$countryid."'";
		mysql_query($queryString) or die(mysql_error());
		
		$queryString = "delete from coupons_cities where countryid ='".$countryid."'";
		mysql_query($queryString) or die(mysql_error());
			
		set_response_mes(1, $admin_language['countrydeleted']); 	
		url_redirect(DOCROOT.'manage/country/');
		
	}
	else if($_REQUEST['cityid']!="" )
	{
		$cityid=$_REQUEST['cityid'];
		$queryString = "delete from coupons_cities where cityid ='".$cityid."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['citydeleted']); 	
		url_redirect(DOCROOT.'manage/city/');
	}
	else if($_REQUEST['page_id']!="" )
	{
		$id = $_REQUEST['page_id'];
		$queryString = "delete from pages where id ='".$id."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['pagedeleted']); 	
		url_redirect(DOCROOT.'manage/pages/');
	}
	else if($_REQUEST['subscriber_id']!="" )
	{
		$id = $_REQUEST['subscriber_id'];
		$queryString = "delete from newsletter_subscribers where id ='".$id."'";
		mysql_query($queryString) or die(mysql_error()); 
		set_response_mes(1, $admin_language['subscriber_delete']); 	
		url_redirect(DOCROOT.'manage/subscriber/');
	}
	else if($_REQUEST['mobile_subscriber_id']!="" )
	{
		$id = $_REQUEST['mobile_subscriber_id'];
		$queryString = "delete from mobile_subscribers where Id ='".$id."'";
		mysql_query($queryString) or die(mysql_error()); 
		set_response_mes(1, $admin_language['subscriber_delete']); 	
		url_redirect(DOCROOT.'manage/mobile-subscriber/');
	}

	else if($_REQUEST['categoryid']!="" )
	{
		$categoryid=$_REQUEST['categoryid'];
		$categoryimage = $_REQUEST['categoryimage'];
		$queryString = "delete from coupons_category where category_id='".$categoryid."'";
		mysql_query($queryString) or die(mysql_error());
		 if(file_exists($_SERVER["DOCUMENT_ROOT"]."/uploads/categoryicon/".$categoryid.".jpg"))
                    { 
                         unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/categoryicon/".$categoryid.".jpg");
                    }
		set_response_mes(1, $admin_language['categorydeleted']); 	
		url_redirect(DOCROOT.'manage/category/');
	}
	else if($_REQUEST['userid']!="" )
	{
		$userid = $_REQUEST['userid'];
		$refid = urldecode($_REQUEST['refid']);
		$queryString = "delete from coupons_users where userid='".$userid."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['userdeleted']); 	
		url_redirect($refid);
	}
	else if($_REQUEST['shopid']!="" )
	{
		$shopid = $_REQUEST['shopid'];
		$refid = urldecode($_REQUEST['refid']);
		$queryString = "delete from coupons_shops where shopid='".$shopid."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['shopdeleted']); 	
		url_redirect($refid);
	}
	else if($_REQUEST['couponid']!="" )
	{
		$couponid = $_REQUEST['couponid'];
		$refid = urldecode($_REQUEST['refid']);
		$queryString = "delete from coupons_coupons where coupon_id='".$couponid."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['coupondeleted']); 
		
		if($_SESSION["userrole"]==2)
		{
			url_redirect($refid);	
		}
		else
		{
			url_redirect($refid);
		}	
		
	}
	else if($_GET['req_id']!="" )
	{
		$req_id = $_GET['req_id'];
		$refid=$_GET['refid'];
		$queryString = "delete from request_fund where requested_id='".$req_id."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['requestdeleted']); 	
		url_redirect($refid);	
	}
	
	//coupon image delete
	else if($_REQUEST['couponimage_id']!="" )
	{
	      
	     $cid = $_REQUEST['couponimage_id'];
	     $couponimage_result = mysql_query("select * from coupons_coupons where coupon_id='$cid'");
                   if(mysql_num_rows($couponimage_result)>0)
                   {
                         while($couponimage = mysql_fetch_array($couponimage_result))
                            {
                                $coupinimg_id = $couponimage['coupon_image'];
	                        if(file_exists($_SERVER["DOCUMENT_ROOT"]."/".$coupinimg_id))
	                            {
	         
	                                 unlink($_SERVER["DOCUMENT_ROOT"]."/".$coupinimg_id);
	                            }
	     
	                     }	                
		                
                   } 
	        $id = $_REQUEST['couponimage_id'];
		$queryString = "update coupons_coupons set coupon_image='' where coupon_id ='".$id."'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['pagedeleted']); 	
		url_redirect(DOCROOT.'edit/coupon/'.$id);
	}
	
	// slider image delete
	else if($_REQUEST['deletesliderimage_id']!="" )
	{
	     $id = $_REQUEST['deletesliderimage_id'];	
	     if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/slider_images/'.$id))
	        {
	             
	                unlink($_SERVER["DOCUMENT_ROOT"].'/uploads/slider_images/'.$id);
	        }
	    
	   	$slider_id = explode('_',$_REQUEST['deletesliderimage_id']);
		$queryString = "delete from slider_images where imagename ='".$id."'";		
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, "Image has been deleted"); 	
		url_redirect(DOCROOT.'edit/coupon/'.$slider_id[0].'/');
	    
	}
	
	
	//delete api 
	if($delete_api_id)
	{
		$queryString = "delete from api_client_details where id='$delete_api_id'";
		mysql_query($queryString) or die(mysql_error());
		set_response_mes(1, $admin_language['apideleted']); 	
		url_redirect(DOCROOT."admin/manage-api/");
	
	}
	?>
	<?php ob_flush(); ?>
