<?php
session_start();
require_once 'AuthorizeNet.php'; 
    define("AUTHORIZENET_API_LOGIN_ID", "86jrDx8naX49");
    define("AUTHORIZENET_TRANSACTION_KEY", "8x88td44D8PFgeS5");
    define("AUTHORIZENET_SANDBOX", true);
    $capture = new AuthorizeNetAIM;
	
	//authorize
	require_once($_SERVER['DOCUMENT_ROOT']."/system/includes/dboperations.php"); 
	$invoiceID = $_REQUEST['invoiceid'];
	
	$query = "select id,TRANSACTIONID,AMT from transaction_details where id='$invoiceID' and CAPTURED<>1 limit 0,1";
        $resultset = mysql_query($query);
 
	if(mysql_num_rows($resultset)>0)
	{ 
		while($row = mysql_fetch_array($resultset))
			{ 
				$capture->amount = $row['AMT'];
				$capture->trans_id = $row['TRANSACTIONID'];
				$response = $capture->priorAuthCapture(); 

				if ($response->approved) {
					$update = "update transaction_details set CAPTURED=1, CAPTURED_TIMESTAMP=now(),CAPTURED_ACK='$response->response_reason_text' where TRANSACTIONID='$response->transaction_id' and CORRELATIONID='$response->authorization_code'";
					$result = mysql_query($update) or die(mysql_error());
					if(mysql_affected_rows()){
						return true;
					}else{
						return false;
					}		
				}
				else{ 
					mysql_query("update transaction_details set CAPTURED_ACK='Failed' where id='$invoiceID'") or die(mysql_error());
				}

	
			}
				 
	}

?>
