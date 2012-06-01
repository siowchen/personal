<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<?php

if(is_numeric($deal_id))
{
	//select the deal
	$query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
	
	//add the city condition
/*	if($default_city_id)
	{
		$query .= "coupon_city = '$default_city_id' AND ";
	}
	*/
	$query .="coupon_id = '$deal_id'" ;
	$result = mysql_query($query);
        $deal_type = $language['main_hot'];			
	
}
	include($root_dir_path."past-deal-content.php"); //include the remaining content
?>

