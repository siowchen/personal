<?php ob_start(); ?>
<?php

define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
//get language config file
$admin_lang = $_SESSION["site_admin_language"];

if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{

        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}

	require_once(DOCUMENT_ROOT.'/system/includes/library.inc.php');

	//echo $headers .= 'Content-type: ' .$php_content_type. "\r\n"; exit;
	$refid=$_GET['refid'];
	$cid = $COUPONID=$_GET['couponid'];
	$queryString = "select * from coupons_coupons where coupon_id='$COUPONID'";
	$resultSet = mysql_query($queryString);
	        while($row = mysql_fetch_array($resultSet)) 
	        {
        	          $per_deal_cost = $coupon_amt = $row["coupon_value"];
	        }
		
		//get deal min user limit
        $queryString = "select coupon_shop,coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser from coupons_coupons where coupon_id='$COUPONID'";
        $resultSet = mysql_query($queryString);
		while($row = mysql_fetch_object($resultSet)) 
		{
		    $minuserlimit = $row->minuser;
		    $coupon_shop_id = $row->coupon_shop;
		}


	$sql = "select ID,transaction_details.TYPE,payment_modules.pay_mod_name from transaction_details left join payment_modules on payment_modules.pay_mod_id = transaction_details.TYPE where COUPONID = '$COUPONID' and CAPTURED<>1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)){

		while($row = mysql_fetch_array($result))
		{
			$pay_mod_name = strtolower($row['pay_mod_name']);
	
			//calling docapture method
			$url = DOCROOT.'system/modules/gateway/'.$pay_mod_name.'/DoCaptureReceipt.php?invoiceid='.$row['ID'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			//turning off the server and peer verification(TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			//curl_setopt($ch, CURLOPT_POST, 0);
			curl_exec($ch);
			curl_close($ch);
		}

	}
	else{
		//set_response_mes(1, $admin_language['paymentprocessed']);
        	url_redirect($refid);
	}		


		$queryString = "SELECT * FROM coupons_purchase where couponid='$COUPONID'";
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0)
		{
		    
			while($noticia=mysql_fetch_array($resultSet))
			{    


			        $vid = ranval();
					    
				$coupon_purchaseid = $noticia["coupon_purchaseid"];
				$queryString = "update coupons_purchase set coupon_status='C',coupon_validityid_date=now(),coupon_validityid='$vid' where coupon_purchaseid='$coupon_purchaseid'";
				mysql_query($queryString)or die(mysql_error());


			}

   	        }
   	        

				//adding commisions rate funtionality starts here

				$shop_owner_details = mysql_query("select u.userid,u.user_role from coupons_users u where u.userid in (SELECT s.shop_createdby FROM coupons_shops s where s.shopid='$coupon_shop_id')");

				if(mysql_num_rows($shop_owner_details) > 0)
				{
					if($row=mysql_fetch_array($shop_owner_details))
					{

						$shop_owner_role = $row['user_role'];
						$shop_owner_userid = $row['userid'];

						//shop created by admin	add commission to admin account and credit remaining amt to shop admin					
						if($shop_owner_role == 1) 
						{


							$shop_admin_details = mysql_query("select userid from coupons_users where user_shopid='$coupon_shop_id'");
								if(mysql_num_rows($shop_admin_details) > 0)
								{
									while($row1=mysql_fetch_array($shop_admin_details))
									{
										$shop_admin_uid = $row1['userid'];
										$captured_count = 0;
										$capture_result = mysql_query("select count(*) as capture_cnt from coupons_purchase where transaction_details_id in (select ID from transaction_details where transaction_details.CAPTURED=1 and COUPONID='$cid')");
										if($cnt = mysql_fetch_array($capture_result))
										{
                                                                                       $captured_count = $cnt["capture_cnt"];
                                                                                }
                                                                                $admin_amt = ($captured_count * $per_deal_cost * ADMIN_COMMISSION)/100; //payable to admin
							                        $admin_amt = round($admin_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");
                                                                                $past_balance = round(($per_deal_cost * $captured_count),2);
                                                                                $shop_admin_balance = round(($past_balance - $admin_amt),2);
										mysql_query("update coupons_users set account_balance = account_balance+$shop_admin_balance where userid='$shop_admin_uid'");


									}
								}

						}
						else if($shop_owner_role == 2) 
						{

							$shop_admin_details = mysql_query("select userid from coupons_users where user_shopid='$coupon_shop_id'");

								if(mysql_num_rows($shop_admin_details) > 0)
								{
									while($row1=mysql_fetch_array($shop_admin_details))
									{
									
									        $captured_count = 0;
										$shop_admin_uid = $row1['userid'];

										$capture_result = mysql_query("select count(*) as capture_cnt from coupons_purchase where transaction_details_id in (select ID from transaction_details where transaction_details.CAPTURED=1 and COUPONID='$cid')");
										if($cnt = mysql_fetch_array($capture_result))
										{
                                                                                        $captured_count = $cnt["capture_cnt"];
                                                                                }
                                                                                
                                                                                $admin_amt = ($captured_count * $per_deal_cost * ADMIN_COMMISSION)/100; //payable to admin
							                        $admin_amt = round($admin_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");

							                        $citymgr_amt = ($captured_count * $per_deal_cost * CA_COMMISSION)/100; //payable to city manager
							                        $citymgr_amt = round($citymgr_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$citymgr_amt where userid='$shop_owner_userid'");
                                                                                
                                                                                $past_balance = round(($per_deal_cost * $captured_count),2);
                                                                                $shop_admin_balance = round(($past_balance - ($admin_amt+$citymgr_amt)),2);
										mysql_query("update coupons_users set account_balance = account_balance+$shop_admin_balance where userid='$shop_admin_uid'");


									}
								}

						}

					}
				} //adding commisions rate funtionality ends here   	        
   	        
				

		// send email to the general users

				$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email, c.coupon_name, cp.coupon_validityid FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city left join transaction_details td on td.ID=cp.transaction_details_id where cp.couponid='$COUPONID' and cp.gift_recipient_id=0 and td.CAPTURED='1' ";

						$resultSet = mysql_query($queryString);
		
						if(mysql_num_rows($resultSet)>0)
						{
							 while($row=mysql_fetch_array($resultSet))
							 {

								$shopname = html_entity_decode($row['shopname'], ENT_QUOTES);
								$shop_address = html_entity_decode($row['shop_address'], ENT_QUOTES);
								$cityname = html_entity_decode($row['cityname'], ENT_QUOTES);
								$countryname = html_entity_decode($row['countryname'], ENT_QUOTES);
								 $validityid = $row['coupon_validityid'];
								 $coupon_name = html_entity_decode($row['coupon_name'], ENT_QUOTES);
								 $to = $row['email'];
								 $name = ucfirst($row['firstname']).' '.ucfirst($row['lastname']);
								 $coupon_expirydate = $row['coupon_expirydate'];

								//getting subject and description variables
								$subject = $email_variables['transaction_emailsub'];
								$description = 	$email_variables['transaction_emaildesc'];
								$subject = str_replace("COUPONNAME",ucfirst($coupon_name),$subject);
								$description = str_replace("COUPONNAME",ucfirst($coupon_name),$description);

								$description = str_replace("EXPIREDATE",$coupon_expirydate,$description);

								$msg = $description = str_replace("VALIDITYID",$validityid,$description);

								$msg .= "<table style='margin-left:20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; '>
									    <tr>
									      <td align='right'><strong>Shop Name :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$shopname."</td>
									    </tr>	
									    <tr>
									      <td align='right'><strong>Address :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$shop_address."</td>
									    </tr>
									    <tr>
									      <td align='right'><strong>City :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$cityname."</td>
									    </tr>
									    <tr>
									      <td align='right'><strong>Country :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$countryname."</td>
									    </tr>    
									    </table>";
									    
								 $from = SITE_EMAIL;

								/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
								$str = '';	
								$str = implode("",file(DOCROOT.'themes/_base_theme/email/email_all.html'));
								
								$str = str_replace("SITEURL",$docroot,$str);
								$str = str_replace("SITELOGO",$logo,$str);
								$str = str_replace("RECEIVERNAME",ucfirst($name),$str);
								$str = str_replace("MESSAGE",ucfirst($msg),$str);
								$str = str_replace("SITENAME",SITE_NAME,$str);

								$message = $str;
								$SMTP_STATUS = SMTP_STATUS;	
								
								if($SMTP_STATUS==1)
								{
	
									include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
								}
								else
								{

							     		// To send HTML mail, the Content-type header must be set
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: ' .$php_content_type. "\r\n";
									// Additional headers
									$headers .= 'From: '.$from.'' . "\r\n";
									$headers .= 'Cc: '.$from. "\r\n";

									mail($to,$subject,$message,$headers);	
								}

		 		 
							 }
						 }

				// end email function


				// send email to the gift recipient users

				$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email as senderemail, grd.name,c.coupon_name, cp.coupon_validityid,grd.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join gift_recipient_details grd on grd.id=cp.gift_recipient_id left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city  left join transaction_details td on td.ID=cp.transaction_details_id 
				where cp.couponid='$COUPONID' and cp.gift_recipient_id<>0  and td.CAPTURED='1' ";
						$resultSet = mysql_query($queryString);
		
						if(mysql_num_rows($resultSet)>0)
						{
							 while($row=mysql_fetch_array($resultSet))
							 {

								$shopname = html_entity_decode($row['shopname'], ENT_QUOTES);
								$shop_address = html_entity_decode($row['shop_address'], ENT_QUOTES);
								$cityname = html_entity_decode($row['cityname'], ENT_QUOTES);
								$countryname = html_entity_decode($row['countryname'], ENT_QUOTES);
								 $validityid = $row['coupon_validityid'];
								 $coupon_name = html_entity_decode($row['coupon_name'], ENT_QUOTES);
								 $to = $row['email'];
								 $name = ucfirst($row['name']);
								 $coupon_expirydate = $row['coupon_expirydate'];
								 $gift_sendername = ucfirst($row['firstname']).' '.ucfirst($row['lastname']);				 

								 $gift_senderemail = $row['senderemail'];

								//getting subject and description variables
								$subject = $email_variables['transaction_gift_emailsub'];
								$description = 	$email_variables['transaction_gift_emaildesc'];
								$description = str_replace("SENDERNAME",$gift_sendername,$description);
								$description = str_replace("COUPONNAME",ucfirst($coupon_name),$description);

								$description = str_replace("EXPIREDATE",$coupon_expirydate,$description);
								$msg = $description = str_replace("VALIDITYID",$validityid,$description);
 
								$msg .= "<table style='margin-left:20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; '>
									    <tr>
									      <td align='right'><strong>Shop Name :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$shopname."</td>
									    </tr>	
									    <tr>
									      <td align='right'><strong>Address :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$shop_address."</td>
									    </tr>
									    <tr>
									      <td align='right'><strong>City :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$cityname."</td>
									    </tr>
									    <tr>
									      <td align='right'><strong>Country :</strong></td>
									      <td align='left' class='padding-left:10px;'>".$countryname."</td>
									    </tr>    
									    </table>";

								 $from = SITE_EMAIL;

								/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
								$str = '';	                        	
								$str = implode("",file(DOCROOT.'themes/_base_theme/email/email_all.html'));
								
								$str = str_replace("SITEURL",$docroot,$str);
								$str = str_replace("SITELOGO",$logo,$str);
								$str = str_replace("RECEIVERNAME",ucfirst($name),$str);
								$str = str_replace("MESSAGE",ucfirst($msg),$str);
								$str = str_replace("SITENAME",SITE_NAME,$str);
								$message = $str;

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
									$headers .= 'Cc: '.$from. "\r\n";

									mail($to,$subject,$message,$headers);	
								}


		 		 
							 }
						 }

				// end email function
	mysql_query("update coupons_coupons set coupon_status='C',force_coupon_closed='FC' where coupon_id='$COUPONID'") or die(mysql_error());
	set_response_mes(1, $admin_language['paymentprocessed']);
	url_redirect($refid);
?>
<?php ob_flush(); ?>
