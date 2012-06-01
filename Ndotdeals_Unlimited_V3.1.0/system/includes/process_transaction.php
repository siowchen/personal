<?php ob_start();
session_start();

$logo = DOCROOT."site-admin/images/logo.png";

//get deal id
if(empty($cid))
{
        $coupon_details = mysql_query("select * from transaction_details where ID = '$txnid'");
        if(mysql_num_rows($coupon_details)>0)
        {
                $coupon_info = mysql_fetch_array($coupon_details);
                $cid = $coupon_info["COUPONID"];
        }
}

/* affilate */
//commission setting multiple times from affiliate login issue fixed by validating affiliate user Id 
if(!empty($_COOKIE['xp']) && isset($_SESSION['affId'])){
 	
	 include(DOCUMENT_ROOT.'/system/modules/affiliate/classes/Xp.php');

	//get deal amt
        $queryString = "select coupon_value from coupons_coupons where coupon_id='$cid'";
        $resultSet = mysql_query($queryString);
		while($row = mysql_fetch_object($resultSet)) 
		{
		    $per_deal_cost = $row->coupon_value;
		}

	        $sum = $per_deal_cost * $deal_quantity;
		$productId = $cid;
		$uid = $_COOKIE['xp']; // affilate user id
		if(!empty($resArray['TRANSACTIONID']))
		{
		        $tid = $resArray['TRANSACTIONID']; // transaction id
		}
		$aff['aff_id'] = $_SESSION['affId'];
		//$aff = $gXpDb->checkByUIDNEW($uid);
		if(!empty($aff['aff_id']))
		{
		        if($productId)
		        {
			        $sale = $gXpDb->addSale($aff['aff_id'], $sum, $uid, $tid, 'PayPal');
			        $affSale = $gXpDb->addAffiliateSale($aff['aff_id']);     
	                }
	        }

	setcookie("xp", "", 1); // clear affilate user id from cookie
	unset($_SESSION['affId']);
}

/* affiliate ends */

	require_once(DOCUMENT_ROOT."/system/includes/library.inc.php");

	$userid = $_SESSION['userid'];
	//get the deal purchased count 
        $queryString = "select sum(L_QTY0) as total from transaction_details where COUPONID = '$cid'";
        $result = mysql_query($queryString);
		if(mysql_num_rows($result))
		{
			$result = mysql_fetch_array($result);
		}
	$purchased_ccount = $result['total'];

	//get deal min user limit
        $queryString = "select coupon_value,coupon_shop,coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser from coupons_coupons where coupon_id='$cid'";
        $resultSet = mysql_query($queryString);
		while($row = mysql_fetch_object($resultSet)) 
		{
		    $minuserlimit = $row->minuser;
		    $coupon_shop_id = $row->coupon_shop;
		    $per_deal_cost = $row->coupon_value;
		}

		$coupon_min_quantity = $minuserlimit;

		//paypal payment processing
		if($coupon_min_quantity < $purchased_ccount)
		{
			$coupons_purchase_id = array();
			//process payment directly and deduct the amout 
			for($i=0;$i<$deal_quantity;$i++)
			{
				$queryString = "insert into coupons_purchase(transaction_details_id,couponid,coupon_userid) 
				values('$txnid','$cid','$userid')"; 
				mysql_query($queryString) or die(mysql_error());
				$coupons_purchase_id[] = mysql_insert_id();
			}

			if($gift_recipient_id)
			{ 

				  $count = count($coupons_purchase_id); 
				  $value ='';
				  for($i=0;$i<$count;$i++)
				  {
				     $val = $coupons_purchase_id[$i];
				     $value.= $val.',';
				  }
				  $value = substr($value,0,strlen($value)-1);

				mysql_query("update coupons_purchase set gift_recipient_id='$gift_recipient_id' where coupon_purchaseid in ($value) ") or die(mysql_error());


			}


			$pay_capture_status = mysql_query("select pay_capture_status from coupons_coupons where coupon_id='$cid'");
			if(mysql_num_rows($pay_capture_status))
			{
				$pay_capture_status = mysql_fetch_array($pay_capture_status);
			}


				$send_mail = 1;
				$pay_capture_status = $pay_capture_status['pay_capture_status'];

			if($pay_capture_status)
			{
				//pay_capture_status already updated
				$direct_payment_capture = 1;

				//call docapture fn for direct payment for an user
				$invoiceid = $txnid;

				$sql = "select transaction_details.TYPE,payment_modules.pay_mod_name from transaction_details left join payment_modules on payment_modules.pay_mod_id = transaction_details.TYPE where ID = '$invoiceid'";
				$result1 = mysql_query($sql);

				if(mysql_num_rows($result1)){

					$val = mysql_fetch_array($result1);
					$pay_mod_name = strtolower($val['pay_mod_name']);
					$url = DOCROOT.'system/modules/gateway/'.$pay_mod_name.'/DoCaptureReceipt.php?invoiceid='.$invoiceid;

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					//turning off the server and peer verification(TrustManager Concept).
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					//curl_setopt($ch, CURLOPT_POST, 0);
					$response = curl_exec($ch);
					curl_close($ch);


				}

                                //check capture status for the current buyer transaction
                                $result = mysql_query("select * from transaction_details where CAPTURED=1 and COUPONID='$cid'");

                                if(mysql_num_rows($result)>0)
                                {
                                        $shop_owner_details = mysql_query("select u.userid,u.user_role from coupons_users u where u.userid in (SELECT s.shop_createdby FROM coupons_shops s where s.shopid='$coupon_shop_id')");

				if(mysql_num_rows($shop_owner_details) > 0)
				{
					if($row1=mysql_fetch_array($shop_owner_details))
					{

						$shop_owner_role = $row1['user_role'];
						$shop_owner_userid = $row1['userid'];

				     
				
					        //add purchased amount to the shop admin account
					        $shop_admin_details = mysql_query("select userid from coupons_users where user_shopid='$coupon_shop_id'");

						        if(mysql_num_rows($shop_admin_details) > 0)
						        {
							        while($row=mysql_fetch_array($shop_admin_details))
							        {
                                                                                                
						                        //shop created by admin	add commission to admin account and credit remaining amt to shop admin					
						                        if($shop_owner_role == 1) 
						                        {
						                                $admin_amt = $deal_quantity * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
							                        $admin_amt = round($admin_amt, 2);
                                                                                mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");   
                                                                                $shop_admin_uid = $row['userid'];
                                                                                $past_balance = ($deal_quantity*$per_deal_cost) - $admin_amt;
								                $shop_admin_balance = round(($past_balance),2);
								                mysql_query("update coupons_users set account_balance = account_balance+$shop_admin_balance where userid='$shop_admin_uid'");
						                        }
						                        else if($shop_owner_role == 2) 
						                        {
            						                        $admin_amt = $deal_quantity * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
							                        $admin_amt = round($admin_amt, 2);
                                                                                mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");   
						                                $citymgr_amt = $deal_quantity * (($per_deal_cost * CA_COMMISSION)/100); //payable to city manager
							                        $citymgr_amt = round($citymgr_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$citymgr_amt where userid='$shop_owner_userid'");       
			                                                        $shop_admin_uid = $row['userid'];
										$past_balance = ($deal_quantity*$per_deal_cost) - ($admin_amt+$citymgr_amt);
										$shop_admin_balance = round(($past_balance),2);
										mysql_query("update coupons_users set account_balance = account_balance+$shop_admin_balance where userid='$shop_admin_uid'");
						                        }

							        }
						        }
						        
				                }
				        }
						
                                }						


			}
			else
			{
				mysql_query("update coupons_coupons set pay_capture_status = '1' where coupon_id='$cid'");
				//call docapture fn

				$queryString = "select * from transaction_details where COUPONID = '$cid'";
				$result = mysql_query($queryString);
					if(mysql_num_rows($result))
					{
						while($row=mysql_fetch_array($result))
						{
							$invoiceid = $row['ID'];

							$sql = "select transaction_details.TYPE,payment_modules.pay_mod_name from transaction_details left join payment_modules on payment_modules.pay_mod_id = transaction_details.TYPE where ID = '$invoiceid'";
							$result1 = mysql_query($sql);

							if(mysql_num_rows($result1)){

								$val = mysql_fetch_array($result1);
								$pay_mod_name = strtolower($val['pay_mod_name']);
								$url = DOCROOT.'system/modules/gateway/'.$pay_mod_name.'/DoCaptureReceipt.php?invoiceid='.$invoiceid;
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL,$url);
								curl_setopt($ch, CURLOPT_VERBOSE, 1);
								//turning off the server and peer verification(TrustManager Concept).
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
								//curl_setopt($ch, CURLOPT_POST, 0);
								$response = curl_exec($ch);
								curl_close($ch);

							}

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
                                                                                //COMMISSION FOR ADMIN
                                                                                $admin_amt = $captured_count * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
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
                                                                                
                                                                                //COMMISSION FOR ADMIN AND CITY ADMIN
                                                                                
                                                                                $admin_amt = $captured_count * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
							                        $admin_amt = round($admin_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");

							                        $citymgr_amt = $captured_count * (($per_deal_cost * CA_COMMISSION)/100); //payable to city manager
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

			} 

		}
		else
		{

			if($coupon_min_quantity == $purchased_ccount)
			{ 
				$coupons_purchase_id = array();
				for($i=0;$i<$deal_quantity;$i++)
				{
					$queryString = "insert into coupons_purchase(transaction_details_id,couponid,coupon_userid) 
					values('$txnid','$cid','$userid')"; 
					mysql_query($queryString) or die(mysql_error());
					$coupons_purchase_id[] = mysql_insert_id();
				}

				if($gift_recipient_id)
				{ 

					  $count = count($coupons_purchase_id); 
					  $value ='';
						  for($i=0;$i<$count;$i++)
						  {
						     $val = $coupons_purchase_id[$i];
						     $value.= $val.',';
						  }
					  $value = substr($value,0,strlen($value)-1);

					mysql_query("update coupons_purchase set gift_recipient_id='$gift_recipient_id' where coupon_purchaseid in ($value) ") or die(mysql_error());

				}

				mysql_query("update coupons_coupons set pay_capture_status = '1' where coupon_id='$cid'");

				//release all payments from amount holded cards
				//call docapture fn
				//get list of invoice ids from transaction_details

				$queryString = "select * from transaction_details where COUPONID = '$cid'";
				$result = mysql_query($queryString);
					if(mysql_num_rows($result))
					{
						while($row=mysql_fetch_array($result))
						{
							$invoiceid = $row['ID'];

							$sql = "select transaction_details.TYPE,payment_modules.pay_mod_name from transaction_details left join payment_modules on payment_modules.pay_mod_id = transaction_details.TYPE where ID = '$invoiceid'";
							$result1 = mysql_query($sql);

							if(mysql_num_rows($result1)){

								$val = mysql_fetch_array($result1);
								$pay_mod_name = strtolower($val['pay_mod_name']);
								$url = DOCROOT.'system/modules/gateway/'.$pay_mod_name.'/DoCaptureReceipt.php?invoiceid='.$invoiceid;
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL,$url);
								curl_setopt($ch, CURLOPT_VERBOSE, 1);
								//turning off the server and peer verification(TrustManager Concept).
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
								//curl_setopt($ch, CURLOPT_POST, 0);
								$response = curl_exec($ch);
								curl_close($ch);

							}

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
                                                                                $captured_count = 0; 
										$shop_admin_uid = $row1['userid'];

										$capture_result = mysql_query("select count(*) as capture_cnt from coupons_purchase where transaction_details_id in (select ID from transaction_details where transaction_details.CAPTURED=1 and COUPONID='$cid')");
										if($cnt = mysql_fetch_array($capture_result))
										{
                                                                                        $captured_count = $cnt["capture_cnt"];
                                                                                }
                                                                                
                                                                                //CALCULATE ADMIN COMMISSION
                                                                                
                                                                                $admin_amt = $captured_count * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
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
                                                                                //CALCULATE ADMIN AND CITY ADMIN (RESELLER)COMMISSION
                                                                                $admin_amt = $captured_count * (($per_deal_cost * ADMIN_COMMISSION)/100); //payable to admin
							                        $admin_amt = round($admin_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$admin_amt where user_role='1'");

							                        $citymgr_amt = $captured_count * (($per_deal_cost * CA_COMMISSION)/100); //payable to city manager
							                        $citymgr_amt = round($citymgr_amt, 2);
							                        mysql_query("update coupons_users set account_balance = account_balance+$citymgr_amt where userid='$shop_owner_userid'");
                                                                                                        
                                                                                $past_balance = round(($per_deal_cost * $captured_count),2);
                                                                                $shop_admin_balance = round(($past_balance - ($admin_amt+$citymgr_amt)),2);
										mysql_query("update coupons_users set account_balance = account_balance+'$shop_admin_balance' where userid='$shop_admin_uid'");


									}
								}

						}

					}
				} //adding commisions rate funtionality ends here


				$send_mail = 1;

			} //end of if statement
			else
			{
				$coupons_purchase_id = array();
				//on holding the payments
				for($i=0;$i<$deal_quantity;$i++)
				{
					$queryString = "insert into coupons_purchase(transaction_details_id,couponid,coupon_userid) 
					values('$txnid','$cid','$userid')"; 
					mysql_query($queryString) or die(mysql_error());
					$coupons_purchase_id[] = mysql_insert_id();
				}
				if($gift_recipient_id)
				{ 

					  $count = count($coupons_purchase_id); 
					  $value ='';
						  for($i=0;$i<$count;$i++)
						  {
						     $val = $coupons_purchase_id[$i];
						     $value.= $val.',';
						  }
					  $value = substr($value,0,strlen($value)-1);

					mysql_query("update coupons_purchase set gift_recipient_id='$gift_recipient_id' where coupon_purchaseid in ($value) ") or die(mysql_error());

				}

				//send mail to users, to intimate payment is in onhold
				$res = mysql_query("select u.email,u.firstname from transaction_details t left join coupons_users u on u.userid=t.USERID where t.COUPONID='$cid' and t.USERID='$userid'");
					if(mysql_num_rows($res) > 0)
					{ 
	  				        $from = SITE_EMAIL;

						$subject = $email_variables['transaction_onhold_subject'];
						$description = $msg = $email_variables['transaction_onhold_description'];

						while($row=mysql_fetch_array($res))
						{ 

							$to = $row["email"];
							$name = $row["firstname"];

							/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
							$str = '';	
						        $str = implode("",file(DOCROOT.'themes/_base_theme/email/email_all.html'));
						        
						        $str = str_replace("SITEURL",$docroot,$str);
						        $str = str_replace("SITELOGO",$logo,$str);
						        $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
						        $str = str_replace("MESSAGE",ucfirst($description),$str);
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

			}

		}

//common functionality for sending mail starts here

if($send_mail == 1)
{
				//generate coupon code and send it to buyers

				if($direct_payment_capture==1)
				{
						
					  $count = count($coupons_purchase_id); 
					  $value ='';
						  for($i=0;$i<$count;$i++)
						  {
						     $val = $coupons_purchase_id[$i];
						     $value.= $val.',';
						  }
					  $value = substr($value,0,strlen($value)-1);
					  $queryString = "SELECT * FROM coupons_purchase where coupon_purchaseid in (".$value.")";

				}
				else{
					$queryString = "SELECT * FROM coupons_purchase where couponid='$cid'";
				}

				$resultSet = mysql_query($queryString);
				if(mysql_num_rows($resultSet)>0)
				{
				    $name = $row["firstname"];
					while($noticia=mysql_fetch_array($resultSet))
					{    
		
					    
					    $vid = ranval();

						$coupon_purchaseid = $noticia["coupon_purchaseid"];
						$queryString = "update coupons_purchase set coupon_status='C',coupon_validityid_date=now(),coupon_validityid='$vid' where coupon_purchaseid='$coupon_purchaseid'";
						mysql_query($queryString)or die(mysql_error());


					}

		   	        }

				// send email to the general users

				if($direct_payment_capture==1)
				{
					$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email, c.coupon_name, cp.coupon_validityid FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city left join transaction_details td on td.ID=cp.transaction_details_id
					where cp.couponid='$cid' and cp.gift_recipient_id=0 and td.CAPTURED='1' and cp.coupon_purchaseid in (".$value.")";
				}
				else
				{
					$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email, c.coupon_name, cp.coupon_validityid FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city left join transaction_details td on td.ID=cp.transaction_details_id
					where cp.couponid='$cid' and cp.gift_recipient_id=0 and td.CAPTURED='1'";
				}
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
								 $coupon_expirydate = $row['coupon_expirydate'];
								 $coupon_name = html_entity_decode($row['coupon_name'], ENT_QUOTES);
								 $to = $row['email'];
								 $name = ucfirst($row['firstname']).' '.ucfirst($row['lastname']);

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
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: '.$from.'' . "\r\n";
									$headers .= 'Cc: '.$from. "\r\n";
									mail($to,$subject,$message,$headers);	

								}

		 		 
							 }
						 }

				// end email function

				// send email to the gift recipient users
				if($direct_payment_capture==1)
				{
					$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email as senderemail, grd.name,c.coupon_name, cp.coupon_validityid,grd.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join gift_recipient_details grd on grd.id=cp.gift_recipient_id left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city  left join transaction_details td on td.ID=cp.transaction_details_id 
					where cp.couponid='$cid' and cp.gift_recipient_id<>0  and td.CAPTURED='1' and cp.coupon_purchaseid in (".$value.")";
				}
				else
				{
					$queryString = "SELECT c.coupon_expirydate,coupons_cities.cityname, coupons_country.countryname, cs.shopname,cs.shop_address,cu.firstname,cu.lastname,cu.email as senderemail, grd.name,c.coupon_name, cp.coupon_validityid,grd.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid left join coupons_coupons c on c.coupon_id=cp.couponid left join gift_recipient_details grd on grd.id=cp.gift_recipient_id left join coupons_shops cs on cs.shopid = c.coupon_shop left join coupons_country on coupons_country.countryid=cs.shop_country left join coupons_cities on coupons_cities.cityid=cs.shop_city  left join transaction_details td on td.ID=cp.transaction_details_id 
					where cp.couponid='$cid' and cp.gift_recipient_id<>0 and td.CAPTURED='1'";
				}
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
								 $coupon_expirydate = $row['coupon_expirydate'];
								 $coupon_name = html_entity_decode($row['coupon_name'], ENT_QUOTES);
								 $to = $row['email'];
								 $name = ucfirst($row['name']);
								 
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
									$headers .= 'From: '.$from.'' . "\r\n";
									$headers .= 'Cc: '.$from. "\r\n";
									mail($to,$subject,$message,$headers);	

								}


		 		 
							 }
						 }

				// end email function
}
        //common functionality for sending mail ends here

	//adding purchase count and referral earning amount details

	$coupon_info = get_coupon_code($cid);
	if(mysql_num_rows($coupon_info)>0)
	{
		while($row = mysql_fetch_array($coupon_info))
		{

			$offer_amount = $row["coupon_realvalue"] - $row["coupon_value"];

		}
	}

	//update saved amt during deal purchase
	$tot_cquantity = $deal_quantity;
	$tot_savedamt = $offer_amount * $tot_cquantity;
	$tot_savedamt = round($tot_savedamt);

	mysql_query("update coupons_purchase_status set coupons_purchased_count=coupons_purchased_count+$tot_cquantity, coupons_amtsaved=coupons_amtsaved+$tot_savedamt where id='1' ") or die(mysql_error());

	//update saved amt during deal purchase in current session
	$_SESSION["savedamt"] = $_SESSION["savedamt"] + $tot_savedamt;

	$userid = $_SESSION["userid"];
	$resultSet = mysql_query("select * from referral_list where reg_person_userid='$userid' ") or die(mysql_error());

	if(mysql_num_rows($resultSet)>0)
	{
		while($row = mysql_fetch_array($resultSet))
		{
			$deal_bought_count = $row["deal_bought_count"];
			$referred_person_userid = $row["referred_person_userid"];
		}

		if($deal_bought_count==0)
		{

			mysql_query("insert into referral_earning_details(earner_userid,coupon_purchaser_userid) values('$referred_person_userid','$userid') ") or die(mysql_error());
			mysql_query("update referral_list set deal_bought_count='$tot_cquantity' where reg_person_userid='$userid' ") or die(mysql_error());	

			$ref_amount = REF_AMOUNT;

			$referral_update = mysql_query("update coupons_users set referral_earned_amount=referral_earned_amount+$ref_amount where userid='$referred_person_userid' ") or die(mysql_error());
			
			if($referral_update)
			{
			        $referral_result = mysql_query("select * from coupons_users where userid='$referred_person_userid'");
			
			        if(mysql_num_rows($referral_result))
			        {
			                while($referral = mysql_fetch_array($referral_result))
			                {
			        
			
			                        $to = $referral["email"];
			                        $name = $referral["firstname"];
			                        $subject = $email_variables['referral_amount_subject'];
                                                $description = $email_variables['referral_amount_credited'];
                                                $description = str_replace("REFERRAL_AMOUNT",REF_AMOUNT,$description);
                                                $description = str_replace("REFERED",$_SESSION["username"],$description);
			                 	/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
							$str = '';	
						        $str = implode("",file(DOCROOT.'themes/_base_theme/email/email_all.html'));
						        
						        $str = str_replace("SITEURL",$docroot,$str);
						        $str = str_replace("SITELOGO",$logo,$str);
						        $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
						        $str = str_replace("MESSAGE",ucfirst($description),$str);
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
			}


		}
		else if($deal_bought_count>0)
		{
			mysql_query("update referral_list set deal_bought_count=deal_bought_count+$tot_cquantity where reg_person_userid='$userid' ") or die(mysql_error());
		}

	}
	//end of purchase count and referral earning amount details

	//deduct referral amount
	$deductable_ref_amt = $_SESSION['deductable_ref_amt'];
	if($deductable_ref_amt > 0) {

		$USERID = $_SESSION["userid"];
                $queryUpdate = mysql_query("update coupons_users set referral_earned_amount = referral_earned_amount-$deductable_ref_amt where userid = '$USERID'");

	}


//clear the session variables
$_SESSION['COUPONID']='';
$_SESSION['txn_id']='';
$_SESSION['deal_quantity']='';
$_SESSION['txn_amt']='';
$_SESSION['gift_recipient_id']='';
$_SESSION['deductable_ref_amt']='';
ob_flush();    
?>
