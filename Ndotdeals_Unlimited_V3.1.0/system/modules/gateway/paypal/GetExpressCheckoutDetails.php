<?php session_start();
/********************************************************
GetExpressCheckoutDetails.php

This functionality is called after the buyer returns from
PayPal and has authorized the payment.

Displays the payer details returned by the
GetExpressCheckoutDetails response and calls
DoExpressCheckoutPayment.php to complete the payment
authorization.

Called by ReviewOrder.php.

Calls DoExpressCheckoutPayment.php and APIError.php.

********************************************************/
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(DOCUMENT_ROOT."/system/includes/transaction.php");

/* Collect the necessary information to complete the
   authorization for the PayPal payment
   */

$_SESSION['token']=$_REQUEST['token'];
$_SESSION['payer_id'] = $_REQUEST['PayerID'];

$_SESSION['paymentAmount']=$_REQUEST['paymentAmount'];
$_SESSION['currCodeType']=$_REQUEST['currencyCodeType'];
$_SESSION['paymentType']=$_REQUEST['paymentType'];

$resArray=$_SESSION['reshash'];
$_SESSION['TotalAmount']= $resArray['AMT'] + $resArray['SHIPDISCAMT'];

/* Display the  API response back to the browser .
   If the response from PayPal was a success, display the response parameters
   */
if($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'){
	$location = DOCROOT.'orderdetails.html';
	header("Location: $location"); 
	exit;
}elseif($ack=="SUCCESS" or $ack=="SUCCESSWITHWARNING"){
        $PAYERID = $resArray['PAYERID'];
        $EMAIL = $resArray['EMAIL'];
        $FIRSTNAME = $resArray['FIRSTNAME'];	
        $LASTNAME = $resArray['LASTNAME'];
        $TRANSACTIONID = $resArray['TOKEN'];
        $CORRELATIONID = $resArray['CORRELATIONID'];
        $PAYERSTATUS = $resArray['PAYERSTATUS'];
        $COUNTRYCODE = $resArray['COUNTRYCODE'];			
        $COUPONID = $resArray['CUSTOM'];
        $getvalue = split(",",$COUPONID);	
        $L_QTY0 = $getvalue[1];	
        $COUPONID = $getvalue[0];	
        $USERID = $_SESSION['userid'];
        $TYPE = $_SESSION['pay_mod_id'];
	$_SESSION['COUPONID'] = $COUPONID;
	$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];

        $queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,FIRSTNAME,LASTNAME,TRANSACTIONID,L_QTY0,USERID,EMAIL,TYPE,CORRELATIONID,REFERRAL_AMOUNT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$L_QTY0','$USERID','$EMAIL','$TYPE','$CORRELATIONID','$REFERRAL_AMOUNT')";
        require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
        $resultSet = mysql_query($queryString);
	$_SESSION['txn_id'] = mysql_insert_id();
	$_SESSION['deal_quantity'] = $L_QTY0;

	check_deal_status($COUPONID); //check deal status if it reached max limit close the deal

}
?>



 
<center>
	<font size=2 color=black face=Verdana><b>Processing payment</b></font>
	<br><br></center>
	<form action="DoExpressCheckoutPayment.php" method="POST" id="doexpress" name="doexpress" style="display:none;">
	 <center>
           <table width =270>
             <tr>
		               <td colspan="2" class="header">
		                   Step 3: DoExpressCheckoutPayment
		               </td>
          </tr>
            <tr>
                <td><b>Order Total:</b></td>
                <td>
                  <?php  echo $_REQUEST['currencyCodeType'];   echo $resArray['AMT'] + $resArray['SHIPDISCAMT'] ?></td>
            </tr>
            
 		<?php 
   		 	require_once 'ShowAllResponse.php';
   		 ?>
          
            <tr>
                <td class="thinfield">
                     <input type="submit" value="Pay" />
                </td>
            </tr>
        </table>
    </center>
    </form>

 
<script>
document.forms["doexpress"].submit();

</script>
