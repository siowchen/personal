<?php 
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

if($url_arr[3]=="SA")
{
	include("edit_shopadmin.php");
}
else if($url_arr[3]=="CM")
{
	include("edit_citymanager.php");
}
else if($url_arr[3]=="AD" || $url_arr[3]=="G")
{
	include("edit_admin.php");
}
?>

