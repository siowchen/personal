<?php 
ob_start();
session_start(); 
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/dboperations.php');
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/docroot.php');
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/config.php');
// Select the coupon
$coupon_city = $_REQUEST['coupon_cityid'];
$deal_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
//add the city condition

if($coupon_city)
{
	$deal_list_query .= " coupon_city = '$coupon_city' AND ";
}
else
{
	$deal_list_query .= " coupon_city = '$default_city_id' AND ";	
}

$deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";
$result_set = mysql_query($deal_list_query);

if(mysql_num_rows($result_set) > 0)
{
        $i = 0;
        //$icon_folder = 'http://google-maps-icons.googlecode.com/files/';
        if(file_exists($row["coupon_image"]))
                    {
                         $src = '/'.$noticia["coupon_image"];
                    }
                    else
                    {
                        $src = "/themes/".CURRENT_THEME."/images/no_image.jpg";
                    }   
        $icon_folder = DOCROOT.'themes/'.CURRENT_THEME.'/images/nearbymap/';
        $json = '[';
        while($row = mysql_fetch_array($result_set))
        {
		
                $i++;
		$text = trim(str_replace("\r\n","",html_entity_decode($row["shop_address"], ENT_QUOTES)));
		$img_url = '<div style=\"float:left;width:350px;\" ><div style=\"float:left;width:50px;\" ><img src=\"'.DOCROOT.$src.'\" width=\"50\" height=\"70\"/></div><div style=\"float:left;width:250px;margin-left:5px;\"><p style=\"float:left;width:240px;\">'.strip_tags(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'</p></div></div>';
		//$couponname = '<div style=\"float:left;\" ></div>'

                $json .= '{"show_id":"'.$i.'", "link_id":"address'.$i.'","address": "'.$text.', '.html_entity_decode($row["cityname"], ENT_QUOTES).'","info" :"'.$img_url.'", "custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "plain.png" . '", "width": "30", "height": "25"}]},';
        }
        $json = substr($json,0,-1).']';
        
}
echo $json;
 ob_flush();
 ?>
 
