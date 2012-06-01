<?php

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
session_unset();

require_once 'CallerService.php';

session_start();


require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");
$invoiceid = $_GET['invoiceid'];

if($invoiceid){
	$sql = "select TRANSACTIONID, AMT, CURRENCYCODE, ID from transaction_details where ID = '$invoiceid'";
	$result = mysql_query($sql);

	if(mysql_num_rows($result)!=0){
/*
		$authorizationID= mysql_result($result,0);
		$completeCodeType= 'Complete';
		$amount= mysql_result($result,1);
		$currency= mysql_result($result,2);
		$invoiceID=mysql_result($result,3);
		$note='';
*/
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
/*
$authorizationID=urlencode($_REQUEST['authorization_id']);
$completeCodeType=urlencode($_REQUEST['CompleteCodeType']);
$amount=urlencode($_REQUEST['amount']);
$invoiceID=urlencode($_REQUEST['invoice_id']);
$currency=urlencode($_REQUEST['currency']);
$note=urlencode($_REQUEST['note']);
*/


/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpStr="&AUTHORIZATIONID=$authorizationID&AMT=$amount&COMPLETETYPE=$completeCodeType&CURRENCYCODE=$currency&NOTE=$note";



/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("DOCapture",$nvpStr);
print_r($resArray);exit;
/* Next, collect the API request in the associative array $reqArray
   as well to display back to the browser.
   Normally you wouldnt not need to do this, but its shown for testing */

$reqArray=$_SESSION['nvpReqArray'];

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
    $ack = strtoupper($resArray["ACK"]);

return $ack;
exit;
    if($ack!="SUCCESS"){
			$_SESSION['reshash']=$resArray;
			$location = "APIError.php";
				 header("Location: $location");
    }

?>



<html >
<head>
    <title>PayPal PHP SDK - DoCapture API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<center>
	<font size=2 color=black face=Verdana><b>Do Capture</b></font>
	<br><br>

	<b>Authorization captured!</b><br><br>

    <table width=400>

        <?php 
   		 	require_once 'ShowAllResponse.php';
   		 ?>
    </table>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
