<?php session_start(); 
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
$admin_lang = $_SESSION["site_admin_language"];
if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}
?>

<script type="text/javascript">
$(document).ready(function()
	{ 
		//for create form validation
		$("#news_letter").validate();
	});
	
function load_deallist(val)
{ 
var url = '';
url="<?php echo DOCROOT; ?>site-admin/pages/load_deallist.php?q="+val;
$.get(url,function(feedback){
document.getElementById("main_deal").innerHTML= '';
document.getElementById("main_deal").innerHTML= feedback;
	});
}
</script>

<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_12").slideToggle();
document.getElementById("left_menubutton_12").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>

<?php
if($_POST)
{
	
	$deal_id = $_POST['deal_id'];
	
	 $city = $_POST['city'];
	 if($city)
	 { 
	 	$resultSet = mysql_query("select * from newsletter_subscribers where city_id='$city' and status='A'");
		if(mysql_num_rows($resultSet) >0)
		{
			$email_list='';
			while($row=mysql_fetch_array($resultSet))
			{
				if($row['email']!='')
				{
					$email_list .= $row['email'].',';
				}
			}
		}
	 }
	 
	 $to1 = $email_list;
	 $to = substr($to1,0,strlen($to1)-1);

	 $msg='';	

	if($deal_id!='')
	{

		$query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
	
		$query .="coupon_id = '$deal_id' AND coupon_enddate > now() ";
		$result = mysql_query($query);

		if(mysql_num_rows($result) > 0) 
		{
			while($row = mysql_fetch_array($result))
			{

				if($row["timeleft"] > "00:00:00")
				{

                                //discount value
			        $discount_percent = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]);
			        $current_amount = $row["coupon_realvalue"] - $row["coupon_value"]; //current rate of deal
			        $contact_url = DOCROOT.'contactus.html';
			        $deal_url = DOCROOT.'deals/'.html_entity_decode($row["deal_url"], ENT_QUOTES).'_'.$row['coupon_id'].'.html';
			        $cityname = html_entity_decode($row["cityname"], ENT_QUOTES);
			        
			        if(!empty($row["coupon_image"]) && file_exists(DOCUMENT_ROOT.'/'.$row["coupon_image"]))
			        {
				        $img_url = DOCROOT.$row["coupon_image"];
				}
				else
				{
                                        $img_url = DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg';
				}
                                
                                /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
                                $str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/newsletter.html'));
                                
                                $str = str_replace("SITEURL",$docroot,$str);
                                $str = str_replace("CITYNAME",$cityname,$str);
                                $str = str_replace("DATE",date("l, F j, Y"),$str);
                                $str = str_replace("FACEBOOK_FOLLOW",FACEBOOK_FOLLOW,$str);
                                $str = str_replace("TWITTER_FOLLOW",TWITTER_FOLLOW,$str);
                                $str = str_replace("CURRENT_THEME",CURRENT_THEME,$str);
                                $str = str_replace("COUPONNAME",ucfirst(html_entity_decode($row["coupon_name"], ENT_QUOTES)),$str);
                                $str = str_replace("COUPONIMAGESRC",$img_url,$str);
                                $str = str_replace("CURRENTAMOUNT",CURRENCY.round($row["coupon_value"],2),$str);
                                $str = str_replace("COUPONREALVALUE",CURRENCY.round($row["coupon_realvalue"],2),$str);
                                $str = str_replace("COUPONOFFER",round($discount_percent,2).'%',$str);
                                $str = str_replace("DISCOUNT",CURRENCY.round($current_amount,2),$str);
                                $str = str_replace("SHOPADDRESS",html_entity_decode($row["shop_address"], ENT_QUOTES),$str);
                                $str = str_replace("CITYNAME",$cityname,$str); 
                                $str = str_replace("COUNTRYNAME",html_entity_decode($row["countryname"], ENT_QUOTES),$str); 
                                $str = str_replace("COUPONDESCRIPTION",nl2br(html_entity_decode($row["coupon_description"], ENT_QUOTES)),$str); 
                                $str = str_replace("CONTACTURL",$contact_url,$str); 
                                $str = str_replace("DEALURL",$deal_url,$str); 
                                $str = str_replace("SITENAME",SITE_NAME,$str);
								                                
				//get the purchased coupon's count
				$purchased_count = $row["pcounts"];

				$deal_url = DOCROOT.'deals/'.html_entity_decode($row["deal_url"], ENT_QUOTES).'_'.$row['coupon_id'].'.html';
                                

		 		}
			} 
		}
		
	}	
	
	 $subject=$_POST['subject'];
	 $str = str_replace("MESSAGE",nl2br($_POST['message']),$str); 
	 
	
	 
	if($subject=='' && $description=='')
	{ 
		$redirect_url = DOCROOT."admin/newsletter/";
		set_response_mes(-1, $admin_language['fieldmandatory']); 	
		url_redirect(DOCROOT.'admin/newsletter/');
	}


	$from = SITE_EMAIL;

	$message = $str;

	$message .= '<div style="float:left;width:690px;float:left;padding:10px;font-family:Arial, Helvetica, sans-serif;"><p>'.$email_variables['daily_email'].' <a href="'.DOCROOT.'unsubscribe.html" title="'.$email_variables['unsubscribe_click'].'">'.$email_variables['unsubscribe_click'].' </a>.</p></div>';
		
	$SMTP_STATUS = SMTP_STATUS;	
		
		if($SMTP_STATUS==1)
		{
	
			include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
		}
		else
		{
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			// Additional headers
			$headers .= 'From: '.$from.'' . "\r\n";
			$headers .= 'Bcc: '.$to.'' . "\r\n";
			mail($from,$subject,$message,$headers);	
		}
		
	$redirect_url = DOCROOT."admin/newsletter/";
	set_response_mes(1, $admin_language['mailsend']); 	
	url_redirect($redirect_url);

}

//get the categpry list
$category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");

?>

 <fieldset class="field" style="margin-left:10px;">         
        <legend class="legend"><?php echo $admin_language['information']; ?></legend>
<form name="news_letter" id="news_letter" action="" method="post" enctype="multipart/form-data" >	
<table border="0"  cellpadding="5" align="left" class="p5">
<tr>
<td valign="top" align="right"><label><?php echo $admin_language['from']; ?></label></td>
<td align="top"><input type="text"  name="from" value="<?php echo SITE_EMAIL; ?>"  class="email required width400" title="<?php echo $admin_language['entervalidemail']; ?>" />
</td>

<tr><td align="right"><label><?php echo $admin_language['city']; ?></label></td><td>
<select title="choose the city" name="city" id="city" class="fl m15 required" onchange="load_deallist(this.value);">
<option value="">--<?php echo $admin_language['select']; ?>--</option>
<?php while($city_row = mysql_fetch_array($category_list)) { ?>
<option value="<?php echo $city_row["cityid"];?>"><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES); ?></option>
<?php } ?>
</select>
</td>
</tr>

<tr><td align="right"><label><?php echo $admin_language['dealname']; ?></label></td><td>
<p id="main_deal">
<select title="<?php echo $admin_language['choosethedeal']; ?>" name="deal_id" id="deal_id" class="fl m15">
<option value="">--<?php echo $admin_language['select']; ?>--</option>
</select>
</p>
</td>
</tr>


<tr><td valign="top" align="right"><label><?php echo $admin_language['subject']; ?></label></td><td><input type="text"  name="subject" class="required width400" title="<?php echo $admin_language['enterthesubject']; ?>" /></td></tr>
<tr><td valign="top" align="right"><label><?php echo $admin_language['message']; ?></label></td><td><textarea name="message" rows="7"  class="required width400" title="<?php echo $admin_language['enteryourmessage']; ?>" ></textarea></td></tr>

<tr><td></td><td>
<div class="fl clr">
<input type="submit" value="<?php echo $admin_language['send']; ?>" class="button_c" />
</div>
</td></tr>
</table>
</form>
</fieldset >

