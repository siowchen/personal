<?php ob_start(); ?>
<?php
/********************************************
 * @Created on March, 2011
 * @Package: ndotdeals 2.0
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
session_start();
error_reporting(E_ALL ^ E_NOTICE);
#-------------------------------------------------------------------------------
require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
#-------------------------------------------------------------------------------
$admin_lang = $_SESSION["site_admin_language"];

if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}
#-------------------------------------------------------------------------------
$root_dir_path = 'site-admin/pages/';
$theme_name = CURRENT_THEME; //theme name
$file_name = $_REQUEST["file"]; //get the file name
#-------------------------------------------------------------------------------

switch($file_name)
{

	case "profile":
	$page_title = $admin_language["myaccountinform"];
	$current_file = $root_dir_path."profile.php";
	$view = "template_2.php";
	break;

	case "edit":
	$page_title = $admin_language["editprofileinform"];
	$current_file = $root_dir_path."edituser.php";
	$view = "template_2.php";
	break;

	case "changepassword":
	$page_title = $admin_language["changepassword"];
	$current_file = $root_dir_path."changepassword.php";
	$view = "template_2.php";
	break;

	case "couponsupload":
	$page_title = $admin_language["deals_add"];
	$current_file = $root_dir_path."couponsupload.php";
	$view = "template_2.php";
	break;

	case "all":
	$page_title = $admin_language["alldeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;

	case "active":
	$page_title = $admin_language["activedeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;
	
	case "shopadmin":
	$page_title = $admin_language["shopadmindeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;

	case "closed":
	$page_title = $admin_language["closeddeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;
	
	case "rejected":
	$page_title = $admin_language["rejecteddeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;

	case "pending":
	$page_title = $admin_language["pendingdeals"];
	$current_file = $root_dir_path."deal_reports.php";
	$view = "template_2.php";
	break;

	case "viewclosedcoupon":
	$page_title = $admin_language["closedcoupomdetails"];
	$current_file = $root_dir_path."view_closedcoupon.php";
	$view = "template_2.php";
	break;
	
	case "dealreportviews":
	$page_title = $admin_language["dealreportviews"];
	$current_file = $root_dir_path."deal_report_views.php";
	$view = "template_2.php";
	break;

	case "editcoupon":
	$page_title = $admin_language["editcoupondetails"];
	$current_file = $root_dir_path."editcoupon.php";
	$view = "template_2.php";
	break;
				
	case "sa":
	$page_title = $admin_language["storeadminregistration"];
	$current_file = $root_dir_path."registration.php";
	$view = "template_2.php";
	break;

	case "cm":
	$page_title = $admin_language["citymanagerregistration"];
	$current_file = $root_dir_path."registration.php";
	$view = "template_2.php";
	break;

	case "addshop":
	$page_title = $admin_language["addshop"];
	$current_file = $root_dir_path."createshop.php";
	$view = "template_2.php";
	break;

	case "editshop":
	$page_title = $admin_language["editshopdetails"];
	$current_file = $root_dir_path."editshopdetails.php";
	$view = "template_2.php";
	break;

	case "addcountry":
	$page_title = $admin_language["addcountry"];
	$current_file = $root_dir_path."addcountry.php";
	$view = "template_2.php";
	break;

	case "editcountry":
	$page_title = $admin_language["editcountry"];
	$current_file = $root_dir_path."editcountry.php";
	$view = "template_2.php";
	break;

	case "addcity":
	$page_title = $admin_language["addcity"];
	$current_file = $root_dir_path."addcity.php";
	$view = "template_2.php";
	break;

	case "addpage":
	$page_title = $admin_language["addpage"];
	$current_file = $root_dir_path."add_page.php";
	$view = "template_2.php";
	break;

	case "forgot":
	$page_title = $admin_language["forgotpassword"];
	$current_file = $root_dir_path."admin-forgot-password.php";
	$view = "template_1.php";
	break;

	case "edit_page":
	$page_title = $admin_language["editpage"];
	$current_file = $root_dir_path."edit_page.php";
	$view = "template_2.php";
	break;

	case "edit_discussion":
	$page_title = $admin_language["edit_discussion"];
	$current_file = $root_dir_path."edit_discussion.php";
	$view = "template_2.php";
	break;

	case "editcity":
	$page_title = $admin_language["editcity"];
	$current_file = $root_dir_path."editcity.php";
	$view = "template_2.php";
	break;

	case "addcategory":
	$page_title = $admin_language["addcategory"];
	$current_file = $root_dir_path."addcategory.php";
	$view = "template_2.php";
	break;

	case "editcategory":
	$page_title = $admin_language["editcategory"];
	$current_file = $root_dir_path."editcategory.php";
	$view = "template_2.php";
	break;

	case "manage":
	$page_title = "Manage ".ucfirst(str_replace("/","",$_REQUEST['sub1']));
	$current_file = $root_dir_path."manage.php";
	$view = "template_2.php";
	break;
	
	case "sitemap":
	$page_title = $admin_language["general_sitemap"];
	$current_file = $root_dir_path."sitemap.php";
	$view = "template_2.php";
	break;

	case "rss":
	$page_title = $admin_language["rss"];
	$current_file = $root_dir_path."rss.php";
	$view = "template_2.php";
	break;

	case "emailall":
	$page_title = $admin_language["emailtoall"];
	$current_file = $root_dir_path."email_all.php";
	$view = "template_2.php";
	break;

	case "discussion":
	$page_title = $admin_language["discussions"];
	$current_file = $root_dir_path."manage_discussion.php";
	$view = "template_2.php";
	break;

	case "newsletter":
	$page_title = $admin_language["newsletter"];
	$current_file = $root_dir_path."newsletter.php";
	$view = "template_2.php";
	break;
	
	
	case "daily_mails":
	$page_title = $admin_language["newsletter"];
	$current_file = $root_dir_path."daily_mails.php";
	$view = "template_2.php";
	break;

	case "paymentlist":
	$page_title = $admin_language["paymentlist"];
	$current_file = $root_dir_path."payment_list.php";
	$view = "template_2.php";
	break;
	
	case "general":
	$page_title = $admin_language["general_m"];
	$current_file = $root_dir_path."general_setting.php";
	$view = "template_2.php";
	break;

	case "module":
	$page_title = $admin_language["general_module"];
	$current_file = $root_dir_path."module_setting.php";
	$view = "template_2.php";
	break;

	case "sendsms":
	$page_title = $admin_language["sendsms"];
	$current_file = $root_dir_path."send_sms.php";
	$view = "template_2.php";
	break;

	case "fund-request":
	$page_title = $admin_language["transaction_withdraw"];
	$current_file = $root_dir_path."fund-request.php";
	$view = "template_2.php";
	break;
	
	case "fund-request-report":
	$page_title = $admin_language["fundreqreport"];
	$current_file = $root_dir_path."fund-request-list.php";
	$view = "template_2.php";
	break;

	case "manage-fund-request":
	$url_array = explode("/",$_SERVER["REQUEST_URI"]);
	$url_array = explode("?",$url_array[3]);

	$url_array[0] = $url_array[0];

		if($url_array[0]=='all') {
			$page_title = $admin_language["transaction_fr_all"];

		}
		else if($url_array[0]=='approved') {
			$page_title = $admin_language["approvedfundrequest"];

		}
		else if($url_array[0]=='rejected') {
			$page_title = $admin_language["rejectfundreq"];

		}
		else if($url_array[0]=='success') {
			$page_title = $admin_language["successfundreq"];
		}
		else if($url_array[0]=='failed') {
			$page_title = $admin_language["failedfundreq"];

		}







		else if($url_array[0]=='pending') {
			$page_title = $admin_language["pendingfundreq"];

		}

	$current_file = $root_dir_path."manage-fund-request.php";
	$view = "template_2.php";
	break;

	case "manage-api":
	$page_title = $admin_language["manAPI"];
	$current_file = $root_dir_path."manage-api.php";
	$view = "template_2.php";
	break;

	case "submit-ticket":
	$page_title = $admin_language["subticket"];
	$current_file = $root_dir_path."submit_ticket.php";
	$view = "template_2.php";
	break;

	case "daily-deals":
	$page_title = $admin_language["dailydeals"];
	$current_file = $root_dir_path."daily-deals.php";
	$view = "template_2.php";
	break;

	case "transaction":
	$url_array = explode("/",$_SERVER["REQUEST_URI"]);
	$url_array = explode("?",$url_array[3]);

	if($url_array[0]=='all')
		$page_title = $admin_language["transaction_all"];
	else if($url_array[0]=='success')
		$page_title = $admin_language["transaction_success"];
	else if($url_array[0]=='failed')
		$page_title = $admin_language["transaction_failed"];
	else if($url_array[0]=='hold')
		$page_title =  $admin_language["holdtransact"];
			
	$current_file = $root_dir_path."transaction.php";
	$view = "template_2.php";
	break;
	
	case "report":
	$page_title = $admin_language['validatecoupon'];
	$current_file = $root_dir_path."view_report.php";
	$view = "template_2.php";
	break;
        
        case "user_profile":
	$page_title = $admin_language['user_profile'];
	$current_file = $root_dir_path."user_profile.php";
	$view = "template_2.php";
	break;
        
	case "rep":
	$url_array = explode("/",$_SERVER["REQUEST_URI"]);
	$url_array = explode("?",$url_array[3]);

		if($url_array[0]=='fb_users')
			$page_title = $admin_language['userregisteredthroughfacebook'];
		else if($url_array[0]=='tw_users')
			$page_title = $admin_language['usersregisteredthroughtwitter'];
		else if($url_array[0]=='admin')
			$page_title = $admin_language['users_admin'];
		else if($url_array[0]=='all')
			$page_title = $admin_language['allusers'];
		else if($url_array[0]=='shopadmin')
			$page_title = $admin_language['manageshopadmin'];
		else if($url_array[0]=='citymgr')
			$page_title = $admin_language['managecitymanager'];
		else if($url_array[0]=='shops')
			$page_title = $admin_language['manageshop'];
		else if($url_array[0]=='referral')
			$page_title = $admin_language['referraldetail'];
		else
			$page_title = $admin_language['generalusers'];

	if($url_array[0]=='referral') {
		$current_file = $root_dir_path."referral_reports.php"; 
	}
	else{
		$current_file = $root_dir_path."reports.php"; 
	}

	$view = "template_2.php";
	break;

	case "social_media":
	$page_title = $admin_language["social_media_account"];
	$current_file = $root_dir_path."social_media_account.php";
	$view = "template_2.php";
	break;
	
	case "offline":
	$page_title = "Edit_Offline";
	$current_file = $root_dir_path."editoffline.php";
	$view = "template_2.php";
	break; 
			
	default:
	$page_title =$admin_language['adminlogin'];
	$current_file = "site-admin/index.php";
	$view = "template_1.php";
	break;
	
}
#-------------------------------------------------------------------------------
include (DOCUMENT_ROOT.'/site-admin/template.php');
#-------------------------------------------------------------------------------
?>
<?php ob_flush(); ?>
