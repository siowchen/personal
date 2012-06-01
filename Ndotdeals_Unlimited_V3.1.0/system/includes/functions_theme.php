<?php ob_start();
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
* @Author: NDOT
* @URL : http://www.ndot.in
********************************************/
?>
<?php
class theme_sql {
var $language;
function theme_sql($lang){
	
	$language = $lang;
}
function deals_info_q($default_city_id='',$deal_id=''){
	$query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
	
	//Feature deal showing admin and shopadmin
	if($_SESSION['userrole']=='3' || $_SESSION['userrole']=='1' || $_SESSION['userrole']=='2')
	{
	        $query .="coupon_id = '$deal_id' AND (coupon_status = 'D' or coupon_status = 'A' or coupon_status = 'C') AND coupon_enddate > now()";
	}
	else
	{
		$query .="coupon_id = '$deal_id' AND coupon_status = 'A' AND coupon_startdate <= now() AND coupon_enddate > now() ";
	}
	
	$result = mysql_query($query);
	return $result;
}  
function home_q ( $default_city_id = '' ){

        //get the main deal and display in home page
        
	$query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
	
	//add the city condition
	
	if($default_city_id)
	{
	        $query .= "coupon_city = '$default_city_id'  AND ";
	}
	
	$query .= "coupon_status = 'A' AND main_deal=1 AND coupon_startdate <= now() AND coupon_enddate > now() order by coupon_id desc limit 1 ";
	//$deal_type = $GLOBALS['language']['main_today'];
	//echo $query;	
	$result = mysql_query($query);
	//if there is no deal set as main deal
	
	if(mysql_num_rows($result)==0) // If Main deal is not checked, then we are Going to check is there any today's deal / hot deal
	{
	        $query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";

		         	
	        //add the city condition
	        if($default_city_id)
	        {
			$query .= "coupon_startdate < now() and coupon_enddate > now() AND coupon_city = '$default_city_id' and ";
		        $query .= "coupon_status = 'A' order by coupon_enddate asc limit 0,1 ";
		        $result = mysql_query($query);

			// Following is so confusing!!
		        /*$current_startdate = date("Y-m-d").' 00:00:00';
		        $current_enddate = date("Y-m-d").' 23:59:59';

		        $query .= "coupon_enddate > now() AND coupon_city = '$default_city_id' AND coupon_enddate between '$current_startdate' and '$current_enddate' and ";
		        $query .= "coupon_status = 'A' order by rand() limit 0,1 ";
		        $result = mysql_query($query);
		       // $deal_type = $language['main_today'];		
		
		        if(mysql_num_rows($result)==0)
		        {
		
			        $query = '';
			        $query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			        $query .= "coupon_city = '$default_city_id' AND coupon_status = 'A' AND coupon_startdate <= now() AND coupon_enddate > now() order by rand() limit 0,1 ";
			        $result = mysql_query($query);
			        //$deal_type = $language['main_hot'];		
			
		        }*/
	
	        }
	        else
	        {
			$query .= "coupon_enddate > now() and ";
		        $query .= "coupon_status = 'A' order by coupon_enddate asc limit 0,1 ";
		        $result = mysql_query($query);
	        }       

	}
	return $result;
}
}
?>
<?php ob_flush(); ?>
