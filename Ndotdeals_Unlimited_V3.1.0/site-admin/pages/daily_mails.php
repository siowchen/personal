<?php
/* Select the City Details*/
		$resultSet = mysql_query("select * from coupons_cities where status='A'");
		if(mysql_num_rows($resultSet) >0)
		{
			
			while($row=mysql_fetch_array($resultSet))
			{
				$email_list = '';
				if($row['cityid']!='')
				{
					$cityid = $row['cityid'];
					
					//select the deal
	                                $query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";

	                                //add the city condition
	                                if($cityid)
	                                {
		                              $query .= "coupon_city = '$cityid'  AND ";
	                                }
	                                $query .= "coupon_status = 'A' AND main_deal=1 AND coupon_startdate <= now() AND coupon_enddate > now() order by coupon_id desc limit 1 ";
	                                $result = mysql_query($query);
	                                //if there is no deal set as main deal
	                                if(mysql_num_rows($result)==0) // If Main deal is not checked, then we are Going to check is there any today's deal / hot deal
	                                {
	                                        $query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
		                                         	
	                                        //add the city condition
	                                        if($cityid)
	                                        {
			                                $query .= "coupon_startdate < now() and coupon_enddate > now() AND coupon_city = '$cityid' and ";
		                                        $query .= "coupon_status = 'A' order by coupon_enddate asc limit 0,1 ";
		                                        $result = mysql_query($query);
	                                        }
	                                        else
	                                        {
			                                $query .= "coupon_enddate > now() and ";
		                                        $query .= "coupon_status = 'A' order by coupon_enddate asc limit 0,1 ";
		                                        $result = mysql_query($query);
	                                        }       
						
	                                }
	                                //echo $query; exit;
					
/*					
					/* Deals content display here */
					if(mysql_num_rows($result) >0)
		                        {
		                                
		                                while($row = mysql_fetch_array($result))
	                                        {
		                                                if($row["timeleft"] > "00:00:00")
				                                {			
			                                                                            
			                                                  //discount value
			                                                $discount = $row["coupon_realvalue"]-$row["coupon_value"];
			                                                $coupon_offer = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]);
			                                                $current_amount = $row["coupon_value"]; //current rate of deal
			                                                $contact_url = DOCROOT.'contactus.html';
			                                                $deal_url = DOCROOT.'deals/'.html_entity_decode($row["deal_url"]).'_'.$row['coupon_id'].'.html';
			                                                $cityname = html_entity_decode($row["cityname"], ENT_QUOTES);
			                                                
			                                                if(file_exists(DOCUMENT_ROOT.'/'.$row["coupon_image"]))
			                                                {
				                                                $img_url = DOCROOT.$row["coupon_image"];
				                                        }
				                                        else
				                                        {
                                                                                $img_url = DOCROOT.'themes/'. CURRENT_THEME.'/images/no_image.jpg';
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
                                                                        $str = str_replace("CURRENTAMOUNT",CURRENCY.round($current_amount),$str);
                                                                        $str = str_replace("COUPONREALVALUE",CURRENCY.$row["coupon_realvalue"],$str);
                                                                        $str = str_replace("COUPONOFFER",round($coupon_offer).'%',$str);
                                                                        $str = str_replace("DISCOUNT",CURRENCY.$discount,$str);
                                                                        $str = str_replace("SHOPADDRESS",html_entity_decode($row["shop_address"], ENT_QUOTES),$str);
                                                                        $str = str_replace("CITYNAME",$cityname,$str); 
                                                                        $str = str_replace("COUNTRYNAME",html_entity_decode($row["countryname"], ENT_QUOTES),$str); 
                                                                        $str = str_replace("COUPONDESCRIPTION",nl2br(html_entity_decode($row["coupon_description"], ENT_QUOTES)),$str); 
                                                                        $str = str_replace("CONTACTURL",$contact_url,$str); 
                                                                        $str = str_replace("DEALURL",$deal_url,$str); 

									$str = str_replace("SITENAME",SITE_NAME,$str);
                                                                        
				                                        //get the purchased coupon's count
				                                        $purchased_count = $row["pcounts"];

				                                        $deal_url = DOCROOT.'deals/'.friendlyURL(html_entity_decode($row["coupon_name"], ENT_QUOTES)).'_'.$row['coupon_id'].'.html';                                   

                                        
		                                                }
		                                               
		                                                                         		
					                        /* Select the Email to that purticular city Details*/
					                        //echo "select * from newsletter_subscribers where city_id='$cityid' and status='A'";
					                        $resultSet_Email = mysql_query("select * from newsletter_subscribers where city_id='$cityid' and status='A'");
		                                                if(mysql_num_rows($resultSet_Email) >0)
		                                                {
		                                                       
		                                                        while($row_Email = mysql_fetch_array($resultSet_Email))
									{
										if($row_Email['email']!='')
										{
											$email_list .= $row_Email['email'].',';
										}
									}
									$to1 = $email_list;
									$to = substr($to1,0,strlen($to1)-1);

									$subject="Deals of the Day";
									$from = SITE_EMAIL;
	
									// To send HTML mail, the Content-type header must be set
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									// Additional headers
									$headers .= 'From: '.$from.'' . "\r\n";
									$headers .= 'Bcc: '.$to.'' . "\r\n";

									$message = $str;
	
									$SMTP_USERNAME = SMTP_USERNAME;
									$SMTP_PASSWORD = SMTP_PASSWORD;
									$SMTP_HOST = SMTP_HOST;
									$SMTP_STATUS = SMTP_STATUS;	
	
									if($SMTP_STATUS==1)
									{
										include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
									}
									else
									{
										mail($from,$subject,$message,$headers);	
									}
			                                                
		                                                }
		                                                
		                                                /* Ends Select the Email to that purticular city Details*/
		                                      }
		                           }
					/* End Deals content display here */
					
					
				}
			}
		}
	          
	
	$redirect_url = $_SERVER['HTTP_REFERER'];
	set_response_mes(1, $admin_language['mailsend']); 	
	url_redirect($redirect_url);
?>
