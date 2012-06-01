<?php
session_start();
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
/******************************************************
DoCaptureReceipt.php

Sends a DoCapture NVP API request to PayPal.

The code retrieves the authorization ID,amount and constructs
the NVP API request string to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by DoCapture.html.

Calls CallerService.php and APIError.php.

******************************************************/
// clearing the session before starting new API Call
//session_unset();

require_once 'CallerService.php';
require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");
$invoiceid = $_GET['invoiceid'];

if($invoiceid){
	$sql = "select TRANSACTIONID, AMT, CURRENCYCODE, ID from transaction_details where ID = '$invoiceid' and CAPTURED<>1";
	$result = mysql_query($sql);

	if(mysql_num_rows($result)!=0){

		while($row=mysql_fetch_array($result))
		{
			$authorizationID= urlencode($row['TRANSACTIONID']);
			$completeCodeType= urlencode('Complete');
			$amount= urlencode($row['AMT']);
			$currency= urlencode($row['CURRENCYCODE']);
			$invoiceID= urlencode($row['ID']);
			$note='';
		}

	}else{
		return "Invalid invoice id";
	} 
}else{
	return "Invoice id required";
}


/* $authorizationID=urlencode($_POST['authorization_id']);
$completeCodeType=urlencode($_POST['CompleteCodeType']);
$amount=urlencode($_POST['amount']);
$invoiceID='';//urlencode($_REQUEST['invoice_id']);
$currency=urlencode($_POST['currency']);
$note='';//urlencode($_REQUEST['note']); */


/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpStr="&AUTHORIZATIONID=$authorizationID&AMT=$amount&COMPLETETYPE=$completeCodeType&CURRENCYCODE=$currency&NOTE=$note";
//echo $nvpStr;

/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("DOCapture",$nvpStr);
//print_r($resArray); exit;
/* Next, collect the API request in the associative array $reqArray
   as well to display back to the browser.
   Normally you wouldnt not need to do this, but its shown for testing */

$reqArray=$_SESSION['nvpReqArray'];
//print_r($resArray); exit;
/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
    $ack = strtoupper($resArray["ACK"]);

    if($ack!="SUCCESS" && $ack != 'SUCCESSWITHWARNING'){
		mysql_query("update transaction_details set CAPTURED_ACK='Failed' where ID = '$invoiceid'") or die(mysql_error());
		return false;
    }elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING"){
                
        $TIMESTAMP = $resArray['TIMESTAMP'];
        $CORRELATIONID = $resArray['CORRELATIONID'];
        $ACK = $resArray['ACK'];
        $AUTHORIZATIONID = $resArray['AUTHORIZATIONID'];
        $TRANSACTIONID = $resArray['TRANSACTIONID'];
        $ORDERTIME = $resArray['ORDERTIME'];	
        $AMT = $resArray['AMT'];	
        $PAYMENTSTATUS = $resArray['PAYMENTSTATUS'];	
        $PENDINGREASON = $resArray['PENDINGREASON'];	
        $REASONCODE = $resArray['REASONCODE'];
         
        $queryString = "update transaction_details set CAPTURED_TIMESTAMP='$TIMESTAMP', CAPTURED_CORRELATIONID='$CORRELATIONID', CAPTURED_ACK='$ACK', CAPTURED_TRANSACTION_ID='$TRANSACTIONID', CAPTURED_TIMESTAMP='$ORDERTIME', AMT='$AMT', PAYMENTSTATUS='$PAYMENTSTATUS', PENDINGREASON='$PENDINGREASON', REASONCODE='$REASONCODE',CAPTURED='1' where TRANSACTIONID='$AUTHORIZATIONID'";
        	
        require_once(DOCUMENT_ROOT."/system/includes/config.php");	
        $resultSet = mysql_query($queryString) or die(mysql_error());

        $orderdetails = $email_variables['order_statusdesc'];

	$sql = "select u.firstname,c.coupon_name from transaction_details td left join coupons_users u on td.USERID=u.userid left join coupons_coupons c on c.coupon_id=td.COUPONID where td.TRANSACTIONID='$AUTHORIZATIONID'";
	$result = mysql_query($sql);

	if(mysql_num_rows($result)!=0){

		while($row=mysql_fetch_array($result))
		{
			$name = html_entity_decode($row['firstname'], ENT_QUOTES);
			$couponname = html_entity_decode($row['coupon_name'], ENT_QUOTES);
		}

	}

        $orderdetails = str_replace("COUPONNAME",$couponname,$orderdetails);
        $orderdetails .= "<table class='margin-top:10px;'>";
        foreach($resArray as $key => $value) {
                $orderdetails .="<tr><td> $key:</td><td>$value</td>";
        }
        $orderdetails .= "</table>";   
        $to      = $EMAIL;
        $subject = $email_variables['order_status'];

	/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
	$logo = DOCROOT."site-admin/images/logo.png";
	$str = '';	
        $str = implode("",file(DOCROOT.'themes/_base_theme/email/email_all.html'));
        $str = str_replace("SITEURL",$docroot,$str);
        $str = str_replace("SITELOGO",$logo,$str);
        $str = str_replace("RECEIVERNAME",ucfirst($name),$str);
        $str = str_replace("MESSAGE",ucfirst($orderdetails),$str);
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
		$headers .= 'Content-type: text/html; ' .$html_content_type. "\r\n";
		$headers .= 'From: '.$from.'' . "\r\n";
		$headers .= 'Cc: '.$from. "\r\n";
		mail($to,$subject,$message,$headers);	
	}

        return array($TIMESTAMP,$CORRELATIONID,$ACK,$AUTHORIZATIONID,$TRANSACTIONID,$ORDERTIME,$AMT,$PAYMENTSTATUS,$PENDINGREASON,$REASONCODE);
      }

?>




