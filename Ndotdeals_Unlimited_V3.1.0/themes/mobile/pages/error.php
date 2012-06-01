<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<?php

$current_url = explode('/',$_SERVER["REQUEST_URI"]);

//check whether cityname is in url
$queryString = "select * from coupons_cities where status='A' order by cityname asc";
$resultSet = mysql_query($queryString);
if(mysql_num_rows($resultSet)>0)
{
        while( $row = mysql_fetch_array($resultSet))
        {
                if($current_url[1] == $row["city_url"])
                {
                        $_SESSION["defaultcityId"] = $row["cityid"];
                        $_SESSION["default_city_url"] = $row["city_url"];
                        $_SESSION["defaultcityname"] = $row["cityname"];
                        $month = 2592000 + time();
                        setcookie("defaultcityId", "");	
                        setcookie("defaultcityId",$row["cityid"], $month);
                        url_redirect(DOCROOT.$row["city_url"].'/');
                }       
        }       
}
?>
<h1><?php echo $page_title; ?></h1>
<div class="work_bottom con_center">
<h1><?php echo $language['error_head']; ?> <?php echo $sub1; ?></h1>
<p><?php echo $language['erro_mes']; ?></p>
<p><a href="<?php echo DOCROOT; ?>" title="<?php echo $language['back_to_home']; ?>"><?php echo $language['back_to_home']; ?></a></p>
</div>
