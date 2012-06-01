<?php 
	require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/dboperations.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/system/plugins/common.php'); 
	require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/docroot.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/config.php');
	
	$default_city = $_SESSION["defaultcityId"]; //get default city id
	
	// start and end date validated
	if($default_city)
	{
		$queryString = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid left join coupons_category on coupons_category.category_id=coupons_coupons.coupon_category where coupon_city = '$default_city' AND coupon_status = 'A' AND coupon_startdate <= now() AND coupon_enddate > now() and coupons_cities.status='A' order by coupon_id desc";
	}
	else
	{
		$queryString = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid left join coupons_category on coupons_category.category_id=coupons_coupons.coupon_category where coupon_status = 'A' AND coupon_startdate <= now() AND coupon_enddate > now() and coupons_cities.status='A' order by coupon_id desc";
		
	}

$xml_content = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"  xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">
<channel>
	<title>'.SITE_NAME.'</title>
	<link>'.DOCROOT.'</link>
	<description>'.SITE_NAME.'</description>
	<copyright>'.DOCROOT.'. All Rights Reserved</copyright>
';


$result = mysql_query($queryString);
while($row = mysql_fetch_array($result))
{
        if(!empty($row["coupon_image"]))
	        $image_url = DOCROOT.$row["coupon_image"];
        else
	        $image_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';

	$xml_content .= "	
	        <item>
                        <title><![CDATA[".html_entity_decode(strip_tags($row['coupon_name']))."]]></title>
						<link><![CDATA[".DOCROOT."deals/".html_entity_decode($row["deal_url"])."_".$row["coupon_id"].".html]]></link>
                        <description>                        
                               <![CDATA[ <p>".html_entity_decode(strip_tags($row['coupon_description']))."</p>"
							."<img src='" . $image_url . "'/>"
							."<p>Value : ".CURRENCY.html_entity_decode(strip_tags($row['coupon_realvalue']))."</p>"
							."<p>Buy now: ".CURRENCY.html_entity_decode(strip_tags(round($row['coupon_value'], 2)))."</p>]]>							
			 </description>			 
			 <CouponRealValue>".CURRENCY.html_entity_decode(strip_tags($row['coupon_realvalue']))."</CouponRealValue>
			 <CouponDiscountValue>".CURRENCY.html_entity_decode(strip_tags(round($row['coupon_value'], 2)))."</CouponDiscountValue>
                        <store><![CDATA[".html_entity_decode(strip_tags($row['shopname']))."]]></store>";
                        
	if($row['side_deal'] == 1)
	{		      
	        $xml_content .= "		        
                        <company_website><![CDATA[".html_entity_decode(strip_tags($row['shop_url']))."]]></company_website>";
        }		

        $xml_content .= "
                        <category><![CDATA[".html_entity_decode(strip_tags($row['category_name']))."]]></category>
                        <dealurl><![CDATA[".DOCROOT."deals/".html_entity_decode($row["deal_url"])."_".$row["coupon_id"].".html]]></dealurl>
                        <address><![CDATA[".html_entity_decode(strip_tags($row['shop_address']))."]]></address>
                        <phone><![CDATA[".html_entity_decode(strip_tags($row['coupon_phoneno']))."]]></phone>
                        <city><![CDATA[".html_entity_decode(strip_tags($row['cityname']))."]]></city>
                        <state><![CDATA[".html_entity_decode(strip_tags($row['countryname']))."]]></state>
                        <imageurl>".$image_url."</imageurl>  
                        <expire_time>".html_entity_decode(strip_tags($row['coupon_enddate']))."</expire_time>";
        if(!empty($row['shop_latitude']) && !empty($row['shop_logitude']))       
        {    
		        $xml_content .= "
                        <latitude>".html_entity_decode(strip_tags($row['shop_latitude']))."</latitude>
                        <longitude>".html_entity_decode(strip_tags($row['shop_logitude']))."</longitude>";
        }
               	  
        $xml_content .= "
                </item>";
}

             $xml_content .="
             
        </channel>
        </rss>";
		
			//header("Content-Type: application/rss+xml");
			 echo trim($xml_content);
?>
