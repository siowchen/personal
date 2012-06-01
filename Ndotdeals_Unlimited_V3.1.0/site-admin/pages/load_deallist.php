<?php
ob_start(); 
session_start();
require($_SERVER["DOCUMENT_ROOT"].'/system/includes/dboperations.php');

$admin_lang = $_SESSION["site_admin_language"];
if($admin_lang)
{
        include($_SERVER["DOCUMENT_ROOT"]."/system/language/admin_".$admin_lang.".php");
}
else
{
        include($_SERVER["DOCUMENT_ROOT"]."/system/language/admin_en.php");
}

$city_id = $_REQUEST['q'];

	//select the deal
	$query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
	
	$query .= "coupon_city = '$city_id' AND ";
	
	$query .="coupon_status = 'A' AND coupon_enddate > now() ";
	
	$result = mysql_query($query);

	if(mysql_num_rows($result) > 0)
	{
		echo '<select title="choose the deal name" name="deal_id" id="deal_id" class="fl m15">';
			while($row = mysql_fetch_array($result)) { 
			
			if(strlen($row["coupon_name"])>30)
			{
				$couponname = html_entity_decode(substr($row["coupon_name"],0,30), ENT_QUOTES)."...";
			}else
			{
				$couponname = html_entity_decode($row["coupon_name"], ENT_QUOTES);
			}
			?>

			<option title="<?php echo html_entity_decode($row['coupon_name'], ENT_QUOTES);?>" value="<?php $row['coupon_id'];?>"><?php echo $couponname; ?></option>

			<?php } 
		echo '</select>';
	}
	else
	{?>
			<select title="<?php echo $admin_language['choosethedeal']; ?>" name="deal_id" id="deal_id" class="fl m15">
			<option value="">--<?php echo $admin_language['select']; ?>--</option>
			</select>	
	<?php
	}
exit;
ob_flush(); 
?>
