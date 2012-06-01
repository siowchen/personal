<?php session_start();
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<?php
	$city_name = $_SESSION["defaultcityname"];
	$city_url = $_SESSION["default_city_url"];
        $defaultcityId = $_SESSION["defaultcityId"];
	session_destroy();
	if(!empty($city_name))
	{
	       
	       $_SESSION["defaultcityname"] = $city_name;
	       $_SESSION['default_city_url'] = $city_url;
	       if(!empty($defaultcityId))
	       {
	        	$_SESSION["defaultcityId"] = $defaultcityId;
	       }
	       url_redirect(DOCROOT.$city_url.'/');	

	}
	
	url_redirect(DOCROOT);			
?>
