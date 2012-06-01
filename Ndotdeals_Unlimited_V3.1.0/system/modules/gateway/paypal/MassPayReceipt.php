<?php
ob_start();
session_start();

/******************************************************
MassPayReceipt.php

Sends a MassPay NVP API request to PayPal.

The code retrieves the receiveremails, if receiveremail is 
not null then only the item is added to 
NVP API request string, to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by MassPay.html.

Calls CallerService.php and APIError.php.

******************************************************/
require_once 'CallerService.php';
require_once(DOCUMENT_ROOT."/system/includes/library.inc.php");	

	//email information
	$currency_code = CURRENCY_CODE;
	$mail_subject = SUB;
	$note = NOTE;
	$transaction_type = $_GET["type"];

	if($transaction_type == "fund_request")
	{
		
		if($_POST)
		{
			//pending list form
			if($_POST["form_type"] == "pending")
			{
				$request_list = $_POST["pending_req_list"];
				$request_action = $_POST["request_action"];

				if($request_action == 1)
				{
					//approve (pay to user)
					foreach($request_list as $index=>$val)
					{
						if($val)
						{
							//get the request user ui
							$get_request_info = mysql_query("select * from request_fund where requested_id='$val'");
							while($row = mysql_fetch_array($get_request_info))
							{
								$bid = $row["bid"];
								$amount = $row["amount"];
								//get requested user info
								$get_receiver_info = mysql_query("select * from coupons_users where userid='$bid'");
								while($res = mysql_fetch_array($get_receiver_info))
								{

									$pay_ack = masspay_request($mail_subject,$res["email"],$currency_code,$res["pay_account"],$amount,$val,$note); //call payment function
								}
							}
						}
	
						//set status in DB
						if($pay_ack["ACK"] == "Failure")
						{
							mysql_query("update request_fund set status='2',pay_status='2' where requested_id='$val' ");
							//set the response and redirect it....
					                //set_response_mes(-1,"Request is approved but the payment failed.");
					                //url_redirect(DOCROOT."admin/manage-fund-request/pending/");		
						}
						else
						{
							mysql_query("update coupons_users set account_balance=account_balance-'$amount' where userid = '$bid' ");					
							mysql_query("update request_fund set status='2',pay_status='1' where requested_id='$val' ");					
							//set the response and redirect it....
					                //set_response_mes(1,"Request Approved and the payment has been successful.");
					                //url_redirect(DOCROOT."admin/manage-fund-request/pending/");		
						}
					}
					
					//set the response and redirect it....
				        set_response_mes(1,"Request has been processed Successfully.");
				        url_redirect(DOCROOT."admin/manage-fund-request/pending/");		
					
				}
				else
				{

					//reject request
					foreach($request_list as $index=>$val)
					{
						mysql_query("update request_fund set status='3' where requested_id='$val' ");
						//set_response_mes(-1,"Request has been rejected");
						//url_redirect(DOCROOT."admin/manage-fund-request/pending/");
					}

					set_response_mes(-1,"Request has been rejected");
					url_redirect(DOCROOT."admin/manage-fund-request/pending/");

				}
			}
			else if($_POST["form_type"] == "failed")
			{
				$request_list = $_POST["failed_list"];
				$request_action = $_POST["request_action"];
				if($request_action == 1)
				{
					//approve (pay to user)
					foreach($request_list as $val)
					{
						if($val)
						{
							//get the request user ui
							$get_request_info = mysql_query("select * from request_fund where requested_id='$val'");
							while($row = mysql_fetch_array($get_request_info))
							{
								$bid = $row["bid"];
								$amount = $row["amount"];
								
								//get requested user info
								$get_receiver_info = mysql_query("select * from coupons_users where userid='$bid'");
								while($res = mysql_fetch_array($get_receiver_info))
								{
									$pay_ack = masspay_request($mail_subject,$res["email"],$currency_code,$res["pay_account"],$amount,$val,$note); //call payment function
								}
							}
						}
	
						//set status in DB
						if($pay_ack["ACK"] == "Failure")
						{
							mysql_query("update request_fund set status='2',pay_status='2' where requested_id='$val' ");
							//set the response and redirect it....
					                //set_response_mes(-1,"Request is approved but the payment failed.");
					                //url_redirect(DOCROOT."admin/manage-fund-request/pending/");	
						}
						else
						{
							mysql_query("update coupons_users set account_balance=account_balance-'$amount' where userid = '$bid' ");		
							mysql_query("update request_fund set status='2',pay_status='1' where requested_id='$val' ");			
							//set the response and redirect it....
					                //set_response_mes(1,"Request Approved and the payment has been successful.");
					                //url_redirect(DOCROOT."admin/manage-fund-request/pending/");			
						}
					}
					
					//set the response and redirect it....
				        set_response_mes(1,"Request has been processed Successfully.");
				        url_redirect(DOCROOT."admin/manage-fund-request/pending/");		
	
					
				}
				else
				{
					//reject request
					foreach($request_list as $val)
					{
						mysql_query("update request_fund set status='1',pay_status='0' where requested_id='$val' ");
					}

					set_response_mes(-1,"Request has been rejected");
					url_redirect(DOCROOT."admin/manage-fund-request/pending/");			
	
				}
			}
			//loop end
		}
		
	}
	else if($transaction_type == "affiliates")
	{
		//approve (pay to user)
		$uid = $_GET["uid"];		
		
		$get_receiver_info = mysql_query("select * from aff_affiliates where id='$uid'");
		
		$amount = $_GET["amt"];
		$sales = $_GET["sales"];
		
		$r_min = 000000001;
	        $r_max = 999999999;
	        $aid = mt_rand($r_min, $r_max);
	        $ip=$_SERVER['REMOTE_ADDR'];

		
		//get requested user info
		while($res = mysql_fetch_array($get_receiver_info))
		{
			$pay_ack = masspay_request($mail_subject,$res["email"],$currency_code,$res["paypal_email"],$amount,$res["id"],$note); //call payment function
		}
				
		//set status in DB

			if($pay_ack["ACK"] == "Failure")
			{
                                set_response_mes(-1,"Request Unapproved");
		                url_redirect(DOCROOT."system/modules/affiliate/admin/raising-fund.php");
			}
			else
			{
				//failure operation
				$transaction_id = $pay_ack['TRANSACTIONID'];
				mysql_query("insert into aff_payments(aff_id,date,time,sales,commission,uid) values('$uid',NOW(),NOW(),'$sales','$amount','$aid') ");	 //Insert the payment details to db
				
				mysql_query("update aff_fund_raising set status=2 where aff_id='$uid'"); //update the status on the fund
				
				mysql_query("insert into aff_archived_sales(aff_id,uid,date,time,payment,payout,ip,order_number,merchant) values('$uid','$aid',NOW(),NOW(),'$sales','$amount','$ip','$transaction_id','paypal')");	//insert payout sales details
				
				//mysql_query("delete from aff_sales where aff_id=$uid and `approved` = '2' LIMIT 1"); // delete the sales details after payout the amount

				mysql_query("delete from aff_sales where aff_id=$uid and `approved` = '2' "); // delete the sales details after payout the amount

				set_response_mes(1,"Request Approved");
		                url_redirect(DOCROOT."system/modules/affiliate/admin/raising-fund.php");
			
			}
		
		//set the response and redirect it....
					

				
	}
	
	
	//affiliates transaction
	
	
	else if($transaction_type == "pay_affiliates")
	{
		//approve (pay to user)
		$uid = $_GET["uid"];		
		
		$get_receiver_info = mysql_query("select * from aff_affiliates where id='$uid'");
		
		$amount = $_GET["amt"];
		$sales = $_GET["sales"];
		
		
		$r_min = 000000001;
	        $r_max = 999999999;
	        $aid = mt_rand($r_min, $r_max);
	        $ip=$_SERVER['REMOTE_ADDR'];
		
		//get requested user info
		while($res = mysql_fetch_array($get_receiver_info))
		{
			$pay_ack = masspay_request($mail_subject,$res["email"],$currency_code,$res["paypal_email"],$amount,$res["id"],$note); //call payment function
		}
		//set status in DB
	
			if($pay_ack["ACK"] == "Failure")
			{
			
			        //failure operation
				set_response_mes(-1,"Request Unapproved");
		                url_redirect(DOCROOT."system/modules/affiliate/admin/pay-affiliates.php");		

			}
			else
			{
				$transaction_id = $pay_ack['TRANSACTIONID'];
				mysql_query("insert into aff_payments(aff_id,date,time,sales,commission,uid) values('$uid',NOW(),NOW(),'$sales','$amount','$aid') ");	 //Insert the payment details to db
				
				mysql_query("insert into aff_archived_sales(aff_id,uid,date,time,payment,payout,ip,order_number,merchant) values('$uid','$aid',NOW(),NOW(),'$sales','$amount','$ip','$transaction_id','paypal')");	//insert payout sales details
				
				//mysql_query("delete from aff_sales where aff_id=$uid and `approved` = '2' LIMIT 1"); // delete the sales details after payout the amount

				// here send full amt to the aff user, so delete all the records from aff_sales

				mysql_query("delete from aff_sales where aff_id='$uid' and `approved` = '2' and  fund_requested='1' "); // delete the sales details after payout the amount

				set_response_mes(1,"Request Approved");
		                url_redirect(DOCROOT."system/modules/affiliate/admin/pay-affiliates.php");		
			
			}
		
		//set the response and redirect it....
			


				
	}

function masspay_request($subject='',$receiver_mail = '',$currency_code='',$payer_id='',$amount='',$unique_id='',$note='')
{  

	/**
	 * Get required parameters from the web form for the request
	 */
	$emailSubject = urlencode($subject);
	$receiverType = urlencode($receiver_mail);
	$currency = urlencode($currency_code);
	$nvpstr = '';
	
	//$count= count($_POST['receiveremail']);
	$receiverEmail = urlencode($payer_id);
	$amount = urlencode($amount);
	$uniqueID = urlencode($unique_id);
	$note = urlencode($note);
	$nvpstr.="&L_EMAIL0=$receiverEmail&L_Amt0=$amount&L_UNIQUEID0=$uniqueID&L_NOTE0=$note";

	/* Construct the request string that will be sent to PayPal.
	   The variable $nvpstr contains all the variables and is a
	   name value pair string with & as a delimiter */
	   
	$nvpstr.="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency" ;
	 
	/* Make the API call to PayPal, using API signature.
	   The API response is stored in an associative array called $resArray */
	
	$resArray = hash_call("MassPay",$nvpstr);

	//print_r($resArray); exit;
	 
	/* Display the API response back to the browser.
	   If the response from PayPal was a success, display the response parameters'
	   If the response was an error, display the errors received using APIError.php.
	   */
	
	$ack = strtoupper($resArray["ACK"]);
	
	if($ack!="SUCCESS" and $ack!="SUCCESSWITHWARNING")
	{
			return $resArray;
	}
	elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING")
	{
			
			$orderdetails = "<table>";
			foreach($resArray as $key => $value) {
					$orderdetails .="<tr><td> $key:</td><td>$value</td>";
			}
			//send mail to receipient.. 
			$orderdetails .= "</table>";   
			$to      = $receiver_mail;
			$subject = $subject ;
			$message = $orderdetails;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			// Additional headers
			$headers .= 'From: '.SITE_EMAIL.'' . "\r\n";
			@mail($to, $subject, $message, $headers);
			
			return $resArray;
	}

}

//require_once 'ShowAllResponse.php';
ob_flush();
?>


