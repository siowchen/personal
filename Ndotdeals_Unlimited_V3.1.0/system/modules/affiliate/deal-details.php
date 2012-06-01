<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$gProtected = TRUE; 

require_once('header.php');
$deal = $gXpDb->getDeal($_GET['id']);

$limit = $gXpDb->getLimit();

$city = $gXpDb->getCity($deal['coupon_city']);
$cityName = $city['cityname'];


$cityID = $_GET['pid'];
$title = 'Deals';
$description = $gXpLang['desc_deal_details'];
$keywords = $gXpLang['keyword_deal_details'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
if(!empty($deal["coupon_image"]))
{
        if(file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$deal["coupon_image"]))
        {
                $deal_image = $deal['coupon_image'];
                $deal["coupon_image"] = DOCROOT.$deal['coupon_image'];
        }
        else
        {
                $deal_image = 'themes/'.CURRENT_THEME.'images/no_image.jpg';
                $deal["coupon_image"] = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';
        }
}
else
{
        $deal_image = 'themes/'.CURRENT_THEME.'/images/no_image.jpg';
        $deal["coupon_image"] = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';
}

$b = getimagesize("{$gXpConfig['incoming_page']}".$deal_image);
$clip = ($b['width'] > 550) ? 'true' : 'false';

$cname = str_replace(" ","-",strtolower($deal['coupon_name']));
//$limit = 5;

if($cityID)
{
        $CityID = $cityID;
}
else
{
        $CityID = $deal['coupon_city'];
}
$code = "<IFRAME SRC=\"{$gXpConfig['incoming_page']}iframe_deals.php?id={$aff['id']}&show={$limit[value]}&city={$CityID}\" WIDTH=500 HEIGHT=600></IFRAME>";

//$code = "<a href=\"{$gXpConfig['xpurl']}xp.php?id=".$aff['id']."&pid=".$deal['coupon_id']."&cname=".$cname."\"><img src=\"http://192.168.1.82:1013/".$deal['coupon_image']."\" border=\"0\"></a>";

$gXpSmarty->assign_by_ref('code', $code);
$gXpSmarty->assign_by_ref('city', $cityName);
$gXpSmarty->assign_by_ref('deal', $deal);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('clip', $clip);

$gXpSmarty->display("deal-details.tpl");

?>
