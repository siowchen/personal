<?php
session_start();
/***********************************************************
DoDirectPaymentReceipt.php

Submits a credit card transaction to PayPal using a
DoDirectPayment request.

The code collects transaction parameters from the form
displayed by DoDirectPayment.php then constructs and sends
the DoDirectPayment request string to the PayPal server.
The paymentType variable becomes the PAYMENTACTION parameter
of the request string.

After the PayPal server returns the response, the code
displays the API request and response in the browser.
If the response from PayPal was a success, it displays the
response parameters. If the response was an error, it
displays the errors.

Called by DoDirectPayment.php.

Calls CallerService.php and APIError.php.

***********************************************************/
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once 'CallerService.php';
require_once(DOCUMENT_ROOT."/system/includes/docroot.php");
require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");

	//check deal quantity availability
	require_once(DOCUMENT_ROOT."/system/includes/transaction.php");
	
	//check whether deal is expired or closed
        is_deal_expired($_POST['couponid']);
	
	check_max_deal_purchase($_POST['couponid'],$_POST["friendname"],$_POST["friendemail"],$_POST['qty'],$_SESSION['userid']);
	check_deal_quantity($_POST['couponid'],$_POST["friendname"],$_POST["friendemail"],$_POST['qty']);
        $USERID = $_SESSION['userid'];
        $_SESSION["defaultuserid"] = $_SESSION['userid'];
        $COUPONID = $_POST['couponid'];
	$PAYMENTACTION = $_POST['PAYMENT_ACTION_NAME'];

	$_SESSION['pay_mod_id'] = $_POST['pay_mod_id'];
	if(! isset($_SESSION['pay_mod_id'])) {
		if($_POST["friendname"]!='' && $_POST["friendemail"]!='')
		{
			url_redirect(DOCROOT."purchase.html?cid=".$COUPONID."&type=gift");
		}
		else
		{
			url_redirect(DOCROOT."purchase.html?cid=".$COUPONID);
		}
	}

	if($_POST['ref_amt2'] > 0 && $PAYMENTACTION=='Creditcardpayment') { 

                $user = "SELECT * FROM coupons_users where userid='$USERID'";
                $userSet = mysql_query($user);
                while($r = mysql_fetch_array($userSet)) 
                {
                        $account_balance = round($r['referral_earned_amount'],2);
                }

			$deductable_ref_amt = round($_POST['ref_amt2'],2); 

			//referral amount validation			
			if($deductable_ref_amt > $account_balance)
			{

				$cid = $_POST['couponid'];

				if($_POST["friendname"]!='' && $_POST["friendemail"]!='')
				{
					set_response_mes(-1, "Insufficient referral amount in your account."); 
					url_redirect(DOCROOT."purchase.html?cid=".$cid."&type=gift");
				}
				else
				{
					set_response_mes(-1, "Insufficient referral amount in your account."); 
					url_redirect(DOCROOT."purchase.html?cid=".$cid);
				}

			}
		
	                $_SESSION['deductable_ref_amt'] = round($_POST['ref_amt2'],2); 
	}
	else { 
		$_SESSION['deductable_ref_amt'] = 0;
	}


	//if payable amount is equal to 0 then process the customer directly
        if($_POST['amount'] == 0  && $PAYMENTACTION=='Creditcardpayment') 
        {
               
                $user = "SELECT * FROM coupons_users where userid='$USERID'";
                $userSet = mysql_query($user);
                while($r = mysql_fetch_array($userSet)) 
                {
                        $FIRSTNAME = html_entity_decode($r['firstname'], ENT_QUOTES);
                        $LASTNAME = html_entity_decode($r['lastname'], ENT_QUOTES);
                        $EMAIL = html_entity_decode($r['email'], ENT_QUOTES);
                }
                $PAYERID = '';
                $TRANSACTIONID = '';
                $CORRELATIONID = '';;
                $PAYERSTATUS = '';
                $COUNTRYCODE = '';			
                $USERID = $uid = $_SESSION['userid'];
                $TYPE = '2';
                $_SESSION['COUPONID'] = $cid = $COUPONID = $_POST['couponid'];
		$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];
		$L_QTY0 = $_POST['qty'];
		//get the coupon value of the coupon and verify the amount
			
			$coupon_details = mysql_query("select * from coupons_coupons where coupon_id='$COUPONID'");	
			if(mysql_num_rows($coupon_details) > 0)
			{
			        while($coupon_info = mysql_fetch_array($coupon_details))
			        {
			                $coupon_value = $coupon_info["coupon_value"];
			        }
			}
			
			$amt =  ($coupon_value * $L_QTY0) - $_SESSION['deductable_ref_amt'];

	       $queryString = "insert into transaction_details(PAYERID, PAYERSTATUS, ACK, COUNTRYCODE, COUPONID, FIRSTNAME, LASTNAME, TRANSACTIONID, L_QTY0, USERID, EMAIL, TYPE, CORRELATIONID,TRANSACTIONTYPE,PAYMENTTYPE,ORDERTIME,CURRENCYCODE,PAYMENTSTATUS,CAPTURED,AMT,REFERRAL_AMOUNT) values ('$PAYERID','$PAYERSTATUS','Success', '$COUNTRYCODE', '$COUPONID', '$FIRSTNAME', '$LASTNAME', '$TRANSACTIONID', '$L_QTY0', '$USERID', '$EMAIL','0','$CORRELATIONID','expresscheckout','Paypal',now(),'','Success','1','0','$REFERRAL_AMOUNT')";
		require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
		$resultSet = mysql_query($queryString);
		$_SESSION['txn_id'] = $txnid = mysql_insert_id();

		$resArray = $_SESSION['reshash'] = array();
                $txn_amt = $_SESSION['txn_amt'] = $_POST['amount']+$REFERRAL_AMOUNT;

		$_SESSION['deal_quantity'] = $deal_quantity = $L_QTY0;
		check_deal_status($COUPONID); //check deal status if it reached max limit close the deal
		$_SESSION['reshash']["ACK"] = 'SUCCESS';

		$cid=$_SESSION['COUPONID'];
		$txnid=$_SESSION['txn_id'];
		$deal_quantity=$_SESSION['deal_quantity'];
		$txn_amt=$_SESSION['txn_amt'];
		$gift_recipient_id=$_SESSION['gift_recipient_id'];

		//calling the transaction method for amount deduction
		include(DOCUMENT_ROOT."/system/includes/process_transaction.php");

		$location = DOCROOT.'orderdetails.html';
		header("Location: $location"); 
		exit;


        }



/**
 * Get required parameters from the web form for the request
 */

$paymentType =urlencode( $_POST['paymentType']);
$firstName =urlencode( $_POST['firstName']);
$lastName =urlencode( $_POST['lastName']);
$creditCardType =urlencode( $_POST['creditCardType']);
$creditCardNumber = urlencode($_POST['creditCardNumber']);
$expDateMonth =urlencode( $_POST['expDateMonth']);

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['expDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);

if($_SESSION['deductable_ref_amt'] > 0){
//	$amount = $amount-$_SESSION['deductable_ref_amt'];
}

$currencyCode=urlencode($_POST['currency']);
$countrycode = urlencode($_POST['countrycode']);
$paymentType = urlencode($_POST['paymentType']);
$couponid=urlencode($_POST['couponid']);
$qty = urlencode($_POST['qty']);
$userid = urlencode($_POST['user']);
$mail = urlencode($_POST['mail']);

$_SESSION['deal_quantity'] = $_POST['qty'];


            $query = "select * from coupons_coupons where coupon_id='$couponid'";
            $resultset = mysql_query($query);
	    while($row=mysql_fetch_array($resultset)){
			$DESC = html_entity_decode($row['coupon_name'],ENT_QUOTES);
		        $total_payable_amount = $row["coupon_value"]; 

			if(ctype_digit($total_payable_amount)) { 
				$total_payable_amount = $total_payable_amount;
			} 					  
			else { 

				$total_payable_amount = number_format($total_payable_amount, 2,',','');
				$total_payable_amount = explode(',',$total_payable_amount);
				$total_payable_amount = $total_payable_amount[0].'.'.$total_payable_amount[1];

			}                
		}
                $amount = (($total_payable_amount * $qty)- $_SESSION['deductable_ref_amt']);
           



/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=$countrycode&CURRENCYCODE=$currencyCode&CUSTOM=$couponid&L_NUMBER0=$userid&QTY=$qty&EMAIL=$mail";

//echo $nvpstr; exit; 

/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("doDirectPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);
$_SESSION['reshash']=$resArray;


if($ack!="SUCCESS" and $ack!="SUCCESSWITHWARNING")  {
        if(empty($_SESSION["userid"]))
        {
                $_SESSION['userid'] = $_SESSION['defaultuserid'];;
        }   
	$location = DOCROOT.'orderdetails.html';
	header("Location: $location"); exit;
     ?>
	<table width="280">
<tr>
		<td colspan="2" class="header">The PayPal API has returned an error!</td>
	</tr>

<?php  //it will print if any URL errors 
	if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			//session_unset();	
?>

   
<tr>
		<td>Error Number:</td>
		<td><?php echo $errorCode; ?></td>
	</tr>
	<tr>
		<td>Error Message:</td>
		<td><?php echo $errorMessage; ?></td>
	</tr>
	
	</center>
	</table>
   <?php }else{

	 foreach($resArray as $key => $value) {
    		echo "<div> $key:&nbsp;$value</div>";
    	 }	
       			 
    }
}elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING"){

      if(empty($_SESSION["userid"]))
        {
                $_SESSION['userid'] = $_SESSION['defaultuserid'];;
        } 
	$transactionID = $resArray['TRANSACTIONID'];

//print_r($resArray);exit;	 

	/* Construct the request string that will be sent to PayPal.
	   The variable $nvpstr contains all the variables and is a
	   name value pair string with & as a delimiter */
	$nvpStr="&TRANSACTIONID=$transactionID";



	/* Make the API call to PayPal, using API signature.
	   The API response is stored in an associative array called $resArray */
	$resArray=hash_call("gettransactionDetails",$nvpStr);
	//$_SESSION['reshash'] = $resArray;

	/* Next, collect the API request in the associative array $reqArray
	   as well to display back to the browser.
	   Normally you wouldnt not need to do this, but its shown for testing */

	$reqArray=$_SESSION['nvpReqArray'];

	/* Display the API response back to the browser.
	   If the response from PayPal was a success, display the response parameters'
	   If the response was an error, display the errors received using APIError.php.
	   */
	//$ack = strtoupper($resArray["ACK"]);
	
	if(empty($_SESSION["userid"]))
        {
                $_SESSION['userid'] = $_SESSION['defaultuserid'];;
        } 
	
	$PAYERID = $resArray['PAYERID'];
	$PAYERSTATUS = $resArray['PAYERSTATUS'];
	$COUNTRYCODE = $resArray['COUNTRYCODE'];			
	$COUPONID = $resArray['CUSTOM'];
	$TIMESTAMP = $resArray['TIMESTAMP'];
	$CORRELATIONID = $resArray['CORRELATIONID'];
	$ACK = $resArray['ACK'];
	$FIRSTNAME = $resArray['FIRSTNAME'];	
	$LASTNAME = $resArray['LASTNAME'];	
	$TRANSACTIONID = $resArray['TRANSACTIONID'];	
	$RECEIPTID = $resArray['RECEIPTID'];	
	$TRANSACTIONTYPE = $resArray['TRANSACTIONTYPE'];	
	$PAYMENTTYPE = $resArray['PAYMENTTYPE'];	
	$ORDERTIME = $resArray['ORDERTIME'];	
	$AMT = $resArray['AMT'];	
	$CURRENCYCODE = $resArray['CURRENCYCODE'];	
	$PAYMENTSTATUS = $resArray['PAYMENTSTATUS'];	
	$PENDINGREASON = $resArray['PENDINGREASON'];	
	$REASONCODE = $resArray['REASONCODE'];	
	$L_QTY0 = $_SESSION['deal_quantity'];
	$USERID = $_SESSION['userid'];
	$EMAIL = $resArray['EMAIL'];
	$TYPE = $_SESSION['pay_mod_id'];
	$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];
	
	$queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,TIMESTAMP,CORRELATIONID,ACK,FIRSTNAME,LASTNAME,TRANSACTIONID,RECEIPTID,TRANSACTIONTYPE,PAYMENTTYPE,ORDERTIME,AMT,CURRENCYCODE,PAYMENTSTATUS,PENDINGREASON,REASONCODE,L_QTY0,USERID,EMAIL,TYPE,REFERRAL_AMOUNT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$TIMESTAMP','$CORRELATIONID','$ACK','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$RECEIPTID','$TRANSACTIONTYPE','$PAYMENTTYPE','$ORDERTIME','$AMT','$CURRENCYCODE','$PAYMENTSTATUS','$PENDINGREASON','$REASONCODE','$L_QTY0','$USERID','$EMAIL','$TYPE','$REFERRAL_AMOUNT')";
	require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
	require_once(DOCUMENT_ROOT."/system/includes/config.php");	
	$resultSet = mysql_query($queryString)or die(mysql_error());

	$_SESSION['txn_id'] = mysql_insert_id();
	check_deal_status($COUPONID); //check deal status if it reached max limit close the deal

	$_SESSION['COUPONID'] = $COUPONID;
	$_SESSION['txn_amt'] = $AMT+$REFERRAL_AMOUNT;

	$orderdetails = "<table>";
	foreach($resArray as $key => $value) {
		$orderdetails .="<tr><td> $key:</td><td>$value</td>";
	}
	$orderdetails .= "</table>";

	$to      = $EMAIL;
	$subject = APP_NAME.'&nbsp;Order Status';
	$message = $orderdetails;
	$headers = 'From: '.SITE_EMAIL.'' . "\r\n" .
	    'Reply-To: '.$EMAIL.'' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	@mail($to, $subject, $message, $headers);

	//inputs for the transaction method
	$cid=$_SESSION['COUPONID'];
	$txnid=$_SESSION['txn_id'];
	$deal_quantity=$_SESSION['deal_quantity'];
	$txn_amt=$_SESSION['txn_amt'];
	$gift_recipient_id=$_SESSION['gift_recipient_id'];

	//calling the transaction method for amount deduction
	include(DOCUMENT_ROOT."/system/includes/process_transaction.php");

	$location = "/orderdetails.html";
	header("Location: $location"); exit;
}
?>

 




