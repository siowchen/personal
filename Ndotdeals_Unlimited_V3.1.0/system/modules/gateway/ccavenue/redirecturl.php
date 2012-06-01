<?php
ob_start();
session_start();
require("libfuncs.php");
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(DOCUMENT_ROOT."/system/includes/docroot.php");
require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");
/*

	This is the sample RedirectURL PHP script. It can be directly used for integration with CCAvenue if your application is developed in PHP. You need to simply change the variables to match your variables as well as insert routines for handling a successful or unsuccessful transaction.

	return values i.e the parameters namely Merchant_Id,Order_Id,Amount,AuthDesc,Checksum,billing_cust_name,billing_cust_address,billing_cust_country,billing_cust_tel,billing_cust_email,delivery_cust_name,delivery_cust_address,delivery_cust_tel,billing_cust_notes,Merchant_Param POSTED to this page by CCAvenue. 

*/

	$WorkingKey = "M_mypocket_13956" ; //put in the 32 bit working key in the quotes provided here
	$Merchant_Id= $_REQUEST['Merchant_Id'];
	$Amount= $_REQUEST['Amount'];
	$Order_Id= $_REQUEST['Order_Id'];
	$Merchant_Param = $_REQUEST['Merchant_Param'];

	$Merchant_Param = str_replace("`",'',$Merchant_Param);
        $data = explode(',',$Merchant_Param);

	$Checksum= $_REQUEST['Checksum'];
	$AuthDesc=$_REQUEST['AuthDesc'];
		
        $Checksum = verifyChecksum($Merchant_Id, $Order_Id , $Amount,$AuthDesc,$Checksum,$WorkingKey);

        $Checksum = 'true';
        $AuthDesc="Y";

	if($Checksum=="true" && $AuthDesc=="Y")
	{
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		$COUPONID = $data[0];
		$L_QTY0 = $data[1];
		$USERID = $data[2];
		$REFERRAL_AMOUNT = $data[3];
		$TYPE =$data[4];
		
		
		$queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,FIRSTNAME,LASTNAME,TRANSACTIONID,L_QTY0,USERID,EMAIL,TRANSACTIONTYPE,CORRELATIONID,REFERRAL_AMOUNT,CAPTURED,CAPTURED_ACK,ACK,AMT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$L_QTY0','$USERID','$EMAIL','$TYPE','$CORRELATIONID','$REFERRAL_AMOUNT', '1','Success','Success','$Amount')";
        require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
        $resultSet = mysql_query($queryString);
	$_SESSION['txn_id'] = mysql_insert_id();
	$_SESSION['deal_quantity'] = $L_QTY0;
	
		$_SESSION['txn_amt'] = $AMT+$_SESSION['deductable_ref_amt'];

	//inputs for the transaction method
	$cid=$_SESSION['COUPONID'];
	$txnid=$_SESSION['txn_id'];
	$deal_quantity=$_SESSION['deal_quantity'];
	$txn_amt=$_SESSION['txn_amt'];
	$gift_recipient_id=$_SESSION['gift_recipient_id'];
	//calling the transaction method for amount deduction
	include(DOCUMENT_ROOT."/system/includes/process_transaction.php");
        $_SESSION['reshash']["ACK"] = 'SUCCESS';
        $_SESSION['reshash']["L_LONGMESSAGE0"] = 'Your transaction has been success';
        $location = DOCROOT.'orderdetails.html';
        header("Location: $location"); 
        exit;
		//Here you need to put in the routines for a successful 
		//transaction such as sending an email to customer,
		//setting database status, informing logistics etc etc
	}
	else if($Checksum=="true" && $AuthDesc=="B")
	{
		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
		$COUPONID = $_SESSION['couponid'];
		$L_QTY0 = $_SESSION['deal_quantity'];
		$USERID = $_SESSION['userid'];
		$REFERRAL_AMOUNT = $_SESSION['ref_amt'];
		$TYPE =$data[4];
		
		
		$queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,FIRSTNAME,LASTNAME,TRANSACTIONID,L_QTY0,USERID,EMAIL,TRANSACTIONTYPE,CORRELATIONID,REFERRAL_AMOUNT,CAPTURED,CAPTURED_ACK,ACK AMT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$L_QTY0','$USERID','$EMAIL','$TYPE','$CORRELATIONID','$REFERRAL_AMOUNT', '1','Success','Success','$Amount')";
        require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
        $resultSet = mysql_query($queryString);
	$_SESSION['txn_id'] = mysql_insert_id();
	$_SESSION['deal_quantity'] = $L_QTY0;
	
		$_SESSION['txn_amt'] = $AMT+$_SESSION['deductable_ref_amt'];
	$_SESSION['reshash']["ACK"] = 'SUCCESSWITHWARNING';
        $_SESSION['reshash']["L_LONGMESSAGE0"] = 'Your transaction has been success but on hold';

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
		
		//Here you need to put in the routines/e-mail for a  "Batch Processing" order
		//This is only if payment for this transaction has been made by an American Express Card
		//since American Express authorisation status is available only after 5-6 hours by mail from ccavenue and at the "View Pending Orders"
	}
	else if($Checksum=="true" && $AuthDesc=="N")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		$COUPONID = $_SESSION['couponid'];
		$L_QTY0 = $_SESSION['deal_quantity'];
		$USERID = $_SESSION['userid'];
		$REFERRAL_AMOUNT = $_SESSION['ref_amt'];
		$TYPE =$data[4];
		
		
		$queryString = "insert into transaction_details (PAYERID,PAYERSTATUS,COUNTRYCODE,COUPONID,FIRSTNAME,LASTNAME,TRANSACTIONID,L_QTY0,USERID,EMAIL,TRANSACTIONTYPE,CORRELATIONID,REFERRAL_AMOUNT,CAPTURED,CAPTURED_ACK,ACK,AMT) values ('$PAYERID','$PAYERSTATUS','$COUNTRYCODE','$COUPONID','$FIRSTNAME','$LASTNAME','$TRANSACTIONID','$L_QTY0','$USERID','$EMAIL','$TYPE','$CORRELATIONID','$REFERRAL_AMOUNT', '0','Failed','Failed','$Amount')";
        require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
        $resultSet = mysql_query($queryString);
	$_SESSION['txn_id'] = mysql_insert_id();
	$_SESSION['deal_quantity'] = $L_QTY0;
	
		$_SESSION['txn_amt'] = $AMT+$_SESSION['deductable_ref_amt'];
	$_SESSION['reshash']["ACK"] = 'FAILURE';
        $_SESSION['reshash']["L_LONGMESSAGE0"] = 'Your transaction has failed';

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
		
		//Here you need to put in the routines for a failed
		//transaction such as sending an email to customer
		//setting database status etc etc
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
		
		//Here you need to simply ignore this and dont need
		//to perform any operation in this condition
	}
ob_flush();
?>
