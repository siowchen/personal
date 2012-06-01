<?php 
session_start();
ob_start();
?>
<HTML>
<HEAD>
<TITLE>Sub-merchant checkout page</TITLE>
</HEAD>
<BODY>
<center><h2>Please wait, your order is being processed and you will be redirected to payment website soon...</h2></center>

<?php
require("libfuncs.php");
if($_POST)
{

define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(DOCUMENT_ROOT."/system/includes/docroot.php");
require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");

	//check deal quantity availability
	require_once(DOCUMENT_ROOT."/system/includes/transaction.php");
	check_deal_quantity($_POST['couponid'],$_POST["friendname"],$_POST["friendemail"],$_POST['qty']);
        $USERID = $userid = $_SESSION['userid'];
	if($_POST['ref_amt2'] > 0) { 

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
	}else { 
		$_SESSION['deductable_ref_amt'] = 0;
	}



	// authorize
	$qty = $_POST['qty'];	
	$couponid = $_POST['couponid'];
	$sale->cust_id = $_POST['user'];
        $amount = $_POST['amount'];
        //if payable amount is equal to zero then process the customer directly
	if($_POST['amount'] == 0) 
        {
               //check deal quantity availability
			require_once(DOCUMENT_ROOT."/system/includes/transaction.php");
			$L_QTY0 = $qty;	
			$COUPONID = $couponid;	
			check_deal_quantity($COUPONID,$_POST["friendname"],$_POST["friendemail"],$L_QTY0);
                        $USERID = $_SESSION['userid'];

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
                        $TYPE = $_POST['pay_mod_id'];
                        $_SESSION['COUPONID'] = $cid = $COUPONID;
			$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];
					//get the coupon value of the coupon and verify the amount
			
			$coupon_details = mysql_query("select * from coupons_coupons where coupon_id='$COUPONID'");	
			if(mysql_num_rows($coupon_details) > 0)
			{
			        while($coupon_info = mysql_fetch_array($coupon_details))
			        {
			                $coupon_value = $coupon_info["coupon_value"];
			        }
			}
			
			$amount =  ($coupon_value * $L_QTY0) - $_SESSION['deductable_ref_amt'];
			
			
			
		       $queryString = "insert into transaction_details(PAYERID, PAYERSTATUS, ACK, COUNTRYCODE, COUPONID, FIRSTNAME, LASTNAME, TRANSACTIONID, L_QTY0, USERID, EMAIL, TYPE, CORRELATIONID,TRANSACTIONTYPE,PAYMENTTYPE,ORDERTIME,CURRENCYCODE,PAYMENTSTATUS,CAPTURED,AMT,REFERRAL_AMOUNT) values ('$PAYERID','$PAYERSTATUS','Success', '$COUNTRYCODE', '$COUPONID', '$FIRSTNAME', '$LASTNAME', '$TRANSACTIONID', '$L_QTY0', '$USERID', '$EMAIL','0','$CORRELATIONID','auth_only','cc',now(),'','Success','1','0','$REFERRAL_AMOUNT')";
			require_once(DOCUMENT_ROOT."/system/includes/dboperations.php");	
			$resultSet = mysql_query($queryString);
			$_SESSION['txn_id'] = $txnid = mysql_insert_id();

			$resArray = $_SESSION['reshash'] = array();
                        $txn_amt = $_SESSION['txn_amt'] = $_POST['AMT']+$REFERRAL_AMOUNT;

			$_SESSION['deal_quantity'] = $deal_quantity = $L_QTY0;
			check_deal_status($COUPONID); //check deal status if it reached max limit close the deal
			$_SESSION['reshash']["ACK"] = 'SUCCESS';
                        $tot_cquantity = $L_QTY0;
			$cid=$_SESSION['COUPONID'];
			$txnid=$_SESSION['txn_id'];
			$deal_quantity=$_SESSION['deal_quantity'];
			$txn_amt=$_SESSION['txn_amt'];
			$gift_recipient_id=$_SESSION['gift_recipient_id'];
			$resArray["AMT"] = $txn_amt;
	                $resArray["TRANSACTIONID"] = $txnid;
			//calling the transaction method for amount deduction
			include(DOCUMENT_ROOT."/system/includes/process_transaction.php");
                
			$location = DOCROOT.'orderdetails.html';
			header("Location: $location"); 
			exit;
			
        }
	if($_SESSION['deductable_ref_amt'] > 0){
		//$amount = $amount-$_SESSION['deductable_ref_amt'];
	}
	
        $sale->amount = $amount;
        $sale->card_num = $_POST['creditCardNumber'];
	$sale->card_code = $_POST['cvv2Number'];
        $sale->exp_date = $_POST['expDateMonth'].'/'.$_POST['expDateYear'];
	$sale->first_name = $_POST['firstName'];
	$sale->last_name = $_POST['lastName'];
	
	$sale->address = $_POST['address1'];
        $sale->city = $_POST['city'];
        $sale->state = $_POST['state'];
	$sale->zip = $_POST['zip'];
	$sale->country = $_POST['country'];
	$sale->email = $_POST['mail'];
	$sale->invoice_num = substr(time(), 0, 6);
	$sale->description = $_POST['description'];
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
            $amount = (($total_payable_amount * $L_QTY0) - $_SESSION['deductable_ref_amt']);
            
	
        
	$Merchant_Id = "M_mypocket_13956" ;//This id(also User Id)  available at "Generate Working Key" of "Settings & Options" 
	//$Amount = $_POST['AMT'] ;//your script should substitute the amount in the quotes provided here
	$Amount = (($total_payable_amount * $qty)- $_SESSION['deductable_ref_amt']);
	
	$getvalue = split(",",$_POST['CUSTOM']);	
	$L_QTY0 = $getvalue[1];	
        $COUPONID = $getvalue[0];
        
	$Order_Id = $_SESSION['userid'].'-'.date('Ymdhis') ;//your script should substitute the order description in the quotes provided here
	
	$Redirect_Url = DOCROOT."/system/modules/gateway/ccavenue/redirecturl.php" ;//your redirect URL where your customer will be redirected after authorisation from CCAvenue

	$WorkingKey = "c0aemnfjcifqimarvd"  ;//put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key ,login to your CCAvenue merchant account and visit the "Generate Working Key" section at the "Settings & Options" page. 
	$Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);
	$billing_cust_name = $_SESSION["username"];
	$billing_cust_address = $_POST["address1"];
	$billing_cust_state = $_POST["state"];
	$billing_cust_country = $_POST["countrycode"];
	$billing_cust_tel="34252354";
	$billing_cust_email = $_SESSION["emailid"];
	$delivery_cust_name = $_SESSION["username"];
	$delivery_cust_address= $_POST["address1"];
	$delivery_cust_state = $_POST["state"];
	$delivery_cust_country = $_POST["country"];
	$delivery_cust_tel ="422345432";
	$delivery_cust_notes="SUB-MERCHANT TEST";
	$pay_mod_id = $_POST["pay_mod_id"];
	$paymentType = $_POST["paymentType"];
	$REFERRAL_AMOUNT = $_SESSION['deductable_ref_amt'];
        $Merchant_Param = '';	
        $Merchant_Param = "'$couponid','$qty','$USERID','$REFERRAL_AMOUNT','$pay_mod_id','$paymentType'";
	$billing_city = $_POST["city"];
	$billing_zip = $_POST["zip"];
	$delivery_city = $_POST["city"];
	$delivery_zip = $_POST["zip"];
	
	$lastName = $_POST["lastName"];

?>
	<form method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp" id="ccform">
	<input type=hidden name=Merchant_Id value="<?php echo $Merchant_Id; ?>">
	<input type=hidden name=Amount value="<?php echo $Amount; ?>">
	<input type=hidden name=Order_Id value="<?php echo $Order_Id; ?>">
	<input type=hidden name=Redirect_Url value="<?php echo $Redirect_Url; ?>">
	<input type=hidden name=Checksum value="<?php echo $Checksum; ?>">
	<input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> 
	<input type="hidden" name="billing_cust_address" value="<?php echo $billing_cust_address; ?>"> 
	<input type="hidden" name="billing_cust_country" value="<?php echo $billing_cust_country; ?>"> 
	<input type="hidden" name="billing_cust_state" value="<?php echo $billing_cust_state; ?>"> 
	<input type="hidden" name="billing_zip" value="<?php echo $billing_zip; ?>"> 
	<input type="hidden" name="billing_cust_tel" value="<?php echo $billing_cust_tel; ?>"> 
	<input type="hidden" name="billing_cust_email" value="<?php echo $billing_cust_email; ?>"> 
	<input type="hidden" name="delivery_cust_name" value="<?php echo $delivery_cust_name; ?>"> 
	<input type="hidden" name="delivery_cust_address" value="<?php echo $delivery_cust_address; ?>"> 
	<input type="hidden" name="delivery_cust_country" value="<?php echo $delivery_cust_country; ?>"> 
	<input type="hidden" name="delivery_cust_state" value="<?php echo $delivery_cust_state; ?>"> 
	<input type="hidden" name="delivery_cust_tel" value="<?php echo $delivery_cust_tel; ?>"> 
	<input type="hidden" name="delivery_cust_notes" value="<?php echo $delivery_cust_notes; ?>"> 
	<input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>"> 
	<input type="hidden" name="billing_cust_city" value="<?php echo $billing_city; ?>"> 
	<input type="hidden" name="billing_zip_code" value="<?php echo $billing_zip; ?>"> 
	<input type="hidden" name="delivery_cust_city" value="<?php echo $delivery_city; ?>"> 
	<input type="hidden" name="delivery_zip_code" value="<?php echo $delivery_zip; ?>"> 
	<!--<INPUT TYPE="submit" value="submit">-->
	</form>
	<?php
	}
	?>
</BODY>
</HTML>
<script>
document.forms["ccform"].submit();

</script>
<?php
ob_flush();
?>
