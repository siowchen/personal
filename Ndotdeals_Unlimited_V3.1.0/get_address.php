<?php
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
$default_city_id = $_REQUEST['city'];
$category_id = $_REQUEST['category'];
// Current time 
$today = date('Y-m-d');
$end_time = $today.' 23:59:59';
$deal_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
//add the city condition
if($default_city_id)
{
	$deal_list_query .= " city_url = '$default_city_id' and ";
}
if(!empty($category_id))
{
        $deal_list_query .= " coupon_category = '$category_id' AND ";
}
$deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now())) order by coupon_id desc";
$result_set = mysql_query($deal_list_query);
if(mysql_num_rows($result_set) > 0)
{
        $i = 0;

        $icon_folder = DOCROOT.'themes/'.CURRENT_THEME.'/images/dealsnow/';
        $json = '[';
        while($row = mysql_fetch_array($result_set))
        {
                $i++;
                $text = trim(str_replace("\r\n","",html_entity_decode($row["shop_address"], ENT_QUOTES)));
                if(!empty($row["coupon_image"]))
	        $image_tag = '<img src=\"'.DOCROOT.'system/plugins/imaging.php?width=125&height=135&cropratio=1:1&noimg=100&image='.DOCROOT.$row["coupon_image"].'\" alt=\"'.$row["coupon_name"].'\"/>';
                else
	        $image_tag = '<img src=\"'.DOCROOT.'system/plugins/imaging.php?width=125&height=135&cropratio=1:1&noimg=100&image='.DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg\" alt=\"'.$row["coupon_name"].'\"/>';
                
                
                $json .= '{"deal_id": '.$row["coupon_id"].',"link_id":"address'.$i.'","address": "'.$text.'","info" :"'.$image_tag.html_entity_decode($row['coupon_name'], ENT_QUOTES).'", "custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "stamp_03.png" . '", "width": "23", "height": "26"}]},';
        }
        $json = substr($json,0,-1).']';
        
}
echo $json;
