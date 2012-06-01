<?php
	session_start();
	//get city info from session 
	$city_name = $_SESSION["defaultcityname"];
	$city_url = $_SESSION["default_city_url"];
        $defaultcityId = $_SESSION["defaultcityId"];

	require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/docroot.php');
	$_SESSION["userid"] = "";
	$_SESSION["username"] = "";
	$_SESSION["email"] = "";
	$_SESSION["mobile"] = "";
	$_SESSION["userrole"] = "";
	$_SESSION["userstatus"] = ""; 
	$_SESSION["savedamt"] = "";
	$_SESSION["response"] = "";	
	session_destroy();
	
	if(!empty($city_name))
	{
	       session_start();
	       $_SESSION["defaultcityname"] = $city_name;
	       $_SESSION["default_city_url"] = $city_url;
	       if(!empty($defaultcityId))
	       {
	        	$_SESSION["defaultcityId"] = $defaultcityId;
	       }
	      
	}
	
	$docroot = DOCROOT.'admin/login/';
	header("location: $docroot");			
?>
