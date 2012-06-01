<?php 
ob_start();
session_start();
include($_SERVER["DOCUMENT_ROOT"].'/system/includes/library.inc.php');
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

//get the social media account id
$account_id = $_GET["acc_id"];
if($account_id)
{
	$result = mysql_query("delete from social_account where id = '$account_id' "); //delete the account
	
        $_SESSION['oauth_state']= '';
        
        // set responce msg
	$_SESSION["mes"] = "Twitter account has been deleted successfully";
	url_redirect(DOCROOT."admin/social-media-account/");

	
}
?>
<?php 
ob_flush();
?>
