<?php ob_start(); ?>
<?php
session_start();
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

	$status=$_REQUEST['status'];
	$countryid=$_REQUEST['countryid'];
	$queryString = "update coupons_country set status='".$status."' where countryid='".$_REQUEST['countryid']."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
				set_response_mes(1, $admin_language['countryblocked']); 	
              }
              else
              {
				set_response_mes(1, $admin_language['countryunblocked']); 	
              }

	url_redirect(DOCROOT.'manage/country/');
	
}
else if($_REQUEST['cityid']!="" )
{

	$status=$_REQUEST['status'];
	$cityid=$_REQUEST['cityid'];
	$queryString = "update coupons_cities set status='".$status."' where cityid='".$_REQUEST['cityid']."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
		set_response_mes(1, $admin_language['cityblocked']); 	
              }
              else
              {
		set_response_mes(1, $admin_language['cityunblocked']); 	
              }

	url_redirect(DOCROOT.'manage/city/');
		
}

else if($_REQUEST['discussionid']!="" )
{

	$status=$_REQUEST['status'];
	$discussionid=$_REQUEST['discussionid'];
	$refid = urldecode($_REQUEST['refid']);
	$queryString = "update discussion set status='".$status."' where discussion_id='".$_REQUEST['discussionid']."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
		set_response_mes(1, $admin_language['discblocked']); 	
              }
              else
              {
		set_response_mes(1, $admin_language['discunblocked']); 	
              }

	url_redirect($refid);
		
}

else if($_REQUEST['categoryid']!="" )
{

	$status=$_REQUEST['status'];
	$categoryid=$_REQUEST['categoryid'];
	$queryString = "update coupons_category set status='".$status."' where category_id ='".$_REQUEST['categoryid']."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
		set_response_mes(1, $admin_language['categoryblocked']); 	
              }
              else
              {
		set_response_mes(1, $admin_language['categoryunblocked']); 	
              }

	url_redirect(DOCROOT.'manage/category/');	
	
}

else if($_REQUEST['userid']!="" )
{

	$status = $_REQUEST['status'];
	$userid = $_REQUEST['userid'];
	$refid = urldecode($_REQUEST['refid']);
	$queryString = "update coupons_users set user_status='".$status."' where userid='".$_REQUEST['userid']."'";
	mysql_query($queryString) or die(mysql_error());
        $queryString_shop = "select * from coupons_users where userid='$userid'";
       	$resultSet = mysql_query($queryString_shop) or die(mysql_error());
       	while($get_shopid=mysql_fetch_array($resultSet))
        { 
        $user_shopid = $get_shopid['user_shopid'];
        }
        $queryString = "update coupons_shops set shop_status='".$status."' where shopid='$user_shopid'";
	mysql_query($queryString) or die(mysql_error());     	

              if($status=="D")
              {
		set_response_mes(1, $admin_language['userblocked']); 	
              }
              else
              {
		set_response_mes(1, $admin_language['userunblocked']); 	
              }

	url_redirect($refid);	
	
}
else if($_REQUEST['shopid']!="" )
{

	$status = $_REQUEST['status'];
	$shopid = $_REQUEST['shopid'];
	$refid = urldecode($_REQUEST['refid']);
	$queryString = "update coupons_shops set shop_status='".$status."' where shopid='".$shopid."'";
	mysql_query($queryString) or die(mysql_error());
	$queryString = "update coupons_users set user_status='".$status."' where user_shopid='".$shopid."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
		set_response_mes(1, $admin_language['shopblocked']); 	
              }
              else
              {
		set_response_mes(1, $admin_language['shopunblocked']); 	
              }

	url_redirect($refid);	
	
}
else if($_REQUEST['couponid']!="" )
{

	$status = $_REQUEST['status'];
	$refid = urldecode($_REQUEST['refid']);
	$queryString = "update coupons_coupons set coupon_status='".$status."' where coupon_id='".$_REQUEST['couponid']."'";
	mysql_query($queryString) or die(mysql_error());

              if($status=="D")
              {
					set_response_mes(1, $admin_language['couponblocked']); 	
              }
              else
              {
					set_response_mes(1, $admin_language['couponunblocked']); 	
              }

			if($_SESSION["userrole"]==2)
			{
				url_redirect($refid);
			}
			else
			{
				url_redirect($refid);
			}

}

//update for API
$api_id = $_GET["api_id"];
$api_status = $_GET["api_status"];

if($api_id)
{
	$queryString = "update api_client_details set status='".$api_status."' where id='".$api_id."'";
	mysql_query($queryString) or die(mysql_error());
	set_response_mes(1, $admin_language['changesupdated']); 	
	url_redirect(DOCROOT."admin/manage-api/");
}

?>
<?php ob_flush(); ?>
