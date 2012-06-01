<?php session_start();
/**********************************************************
DoExpressCheckoutPayment.php

This functionality is called to complete the payment with
PayPal and display the result to the buyer.

The code constructs and sends the DoExpressCheckoutPayment
request string to the PayPal server.

Called by GetExpressCheckoutDetails.php.

Calls CallerService.php and APIError.php.

**********************************************************/
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once 'CallerService.php';
require_once(DOCUMENT_ROOT."/system/includes/docroot.php");

ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);

/* Gather the information to make the final call to
   finalize the PayPal payment.  The variable nvpstr
   holds the name value pairs
   */
$token =urlencode( $_SESSION['token']);
$paymentAmount =urlencode ($_SESSION['TotalAmount']);
$paymentType = urlencode($_SESSION['paymentType']);
$currCodeType = urlencode($_SESSION['currCodeType']);
$payerID = urlencode($_SESSION['payer_id']);
$serverName = urlencode($_SERVER['SERVER_NAME']);

$nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;
 


 /* Make the call to PayPal to finalize payment
    If an error occured, show the resulting errors
    */
$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);
$_SESSION['reshash']=$resArray;

if($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'){
	$location = DOCROOT."orderdetails.html";
	header("Location: $location"); exit;
}elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING"){
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
        $TOKEN = $resArray['TOKEN'];	
        $RECEIPTID = '';	
        $TRANSACTIONTYPE = $resArray['TRANSACTIONTYPE'];	
        $PAYMENTTYPE = 'Paypal';	
        $ORDERTIME = $resArray['ORDERTIME'];	
        $AMT = $resArray['AMT'];	
        $CURRENCYCODE = $resArray['CURRENCYCODE'];	
        $PAYMENTSTATUS = $resArray['PAYMENTSTATUS'];	
        $PENDINGREASON = $resArray['PENDINGREASON'];	
        $REASONCODE = $resArray['REASONCODE'];
        $getvalue = split(",",$COUPONID);	
        $L_QTY0 = $getvalue[1];	
        $COUPONID = $getvalue[0];	
        $USERID = $_SESSION['userid'];
        $EMAIL = $resArray['EMAIL'];
         
        $queryString = "update transaction_details set TIMESTAMP='$TIMESTAMP', CORRELATIONID='$CORRELATIONID', ACK='$ACK', TRANSACTIONID='$TRANSACTIONID', TRANSACTIONTYPE='$TRANSACTIONTYPE', PAYMENTTYPE='$PAYMENTTYPE', ORDERTIME='$ORDERTIME', AMT='$AMT', CURRENCYCODE='$CURRENCYCODE', PAYMENTSTATUS='$PAYMENTSTATUS', PENDINGREASON='$PENDINGREASON', REASONCODE='$REASONCODE'  where TRANSACTIONID='$TOKEN' ";
        require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
        require_once(DOCUMENT_ROOT."/system/includes/config.php");	
        $resultSet = mysql_query($queryString)or die(mysql_error());

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
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        @mail($to, $subject, $message, $headers);

	$_SESSION['txn_amt'] = $AMT+$_SESSION['deductable_ref_amt'];

	//inputs for the transaction method
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

?>


 
