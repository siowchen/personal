<script language="JavaScript">
	function generateCC(){
		var cc_number = new Array(16);
		var cc_len = 16;
		var start = 0;
		var rand_number = Math.random();

	switch(document.DoDirectPaymentForm.creditCardType.value)
        {
			case "Visa":
				cc_number[start++] = 4;
				break;
			case "Discover":
				cc_number[start++] = 6;
				cc_number[start++] = 0;
				cc_number[start++] = 1;
				cc_number[start++] = 1;
				break;
			case "MasterCard":
				cc_number[start++] = 5;
				cc_number[start++] = Math.floor(Math.random() * 5) + 1;
				break;
			case "Amex":
				cc_number[start++] = 3;
				cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
				cc_len = 15;
				break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
			cc_number[i] = Math.floor(Math.random() * 10);
        }

		var sum = 0;
		for (var j = 0; j < (cc_len - 1); j++) {
			var digit = cc_number[j];
			if ((j & 1) == (cc_len & 1)) digit *= 2;
			if (digit > 9) digit -= 9;
			sum += digit;
		}

		var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		cc_number[cc_len - 1] = check_digit[sum % 10];

		document.DoDirectPaymentForm.creditCardNumber.value = "";
		for (var k = 0; k < cc_len; k++) {
			document.DoDirectPaymentForm.creditCardNumber.value += cc_number[k];
		}
	}
</script>

<script type="text/javascript">
function calculate_credit_amt2(count,price)
{

        var ref_amt = document.getElementById("ref_amt3").value;
	var total = Math.round(count * price * 100)/100; //two decimal value
	var balance = Math.round((total - ref_amt)* 100)/100;
        var total_ref = document.getElementById('total_ref2').innerHTML;

	ref_amt = parseInt(ref_amt);

        if(isNaN(ref_amt))
        { 
                ref_amt = 0;  
                balance = Math.round(total * 100)/100;   
        }
        else
        { 
	        balance = Math.round((total - ref_amt)* 100)/100;
	}
	if(balance < 0)
	{
	        balance = 0;
	}
	
	if(isNaN(count))
	{
		document.getElementById("credit_quantity2").value = '1';
		return;
	}
	
	if(count == 0)
	{
		document.getElementById("credit_quantity2").value = '1';
		return;
	}

	if(ref_amt <= total_ref)
        { 
                if(ref_amt > total)
                {
                
                        document.getElementById('ref_amt3').value = 0;
                        balance = total;
                        
                }
        }
        else
        {
                document.getElementById('ref_amt3').value = 0;
        }

		document.getElementById("total_credit_amt2").innerHTML=balance;
		document.getElementById("payable_total_amt3").innerHTML=balance;   
		document.getElementById("amount2").value = balance;
		document.getElementById("qty2").value='';
		document.getElementById("qty2").value=count;

} 
 
function calculate_referral2(ref_amt,price)
{

	ref_amt = parseInt(ref_amt);
        var count = document.getElementById('credit_quantity2').value;
        var purchase_price;
        var total_ref = document.getElementById('total_ref2').innerHTML;
        var total;
        var balance = 0;

	var ref_amt_bal = parseInt(document.getElementById('ref_amt_bal2').value);

	if((ref_amt_bal >= ref_amt ) && ((count*price)>=ref_amt)){
		// Condition to check whether entered amount is with in Original balance & total order
		//alert("success");
	}
	else
	 {
	        alert("Enter applicable refferal amount!"); 
		document.getElementById('ref_amt3').value = 0;
		balance = Math.round(count * price * 100)/100; //two decimal value

		document.getElementById("total_credit_amt2").innerHTML=balance;
		document.getElementById("total_pay_amt2").innerHTML=balance;
		document.getElementById("payable_total_amt3").innerHTML=balance;     
		document.getElementById("amount2").value = balance;

		var data = document.getElementById("CUSTOM2").value;
		var cid = data.split(",",1);
		if(count=='') count = 1;
		var cumm = cid+","+count
		document.getElementById("CUSTOM2").value='';
		document.getElementById("CUSTOM2").value=cumm;

		return;
	}

       
	if(isNaN(count))
	{
		document.getElementById("quantity").value = '1';
		return;
	}
	
	if(count == 0)
	{
		document.getElementById("quantity").value = '1';
		return;
	}
        total = Math.round(count * price * 100)/100; //two decimal value
        if(isNaN(ref_amt))
        {
                ref_amt = 0;      
                balance = Math.round(total* 100)/100;
        }
        else
        {
	        balance = Math.round((total - ref_amt)* 100)/100;
	}
	if(balance < 0)
	{
	        balance = 0;
	}
	
        if(ref_amt <= total)
        { 
        
                if(ref_amt > total_ref)
                {
                       document.getElementById('ref_amt3').value = ref_amt;
                       
                }
        }
        else
        {
                document.getElementById('ref_amt3').value = 0;
        }
       
	document.getElementById("ref_amt3").value=ref_amt;
	document.getElementById("total_credit_amt2").innerHTML=balance;
	document.getElementById("total_pay_amt2").innerHTML=balance;
	document.getElementById("payable_total_amt3").innerHTML=balance;     
	document.getElementById("amount2").value = balance;

}      
</script>
<br>

<script type="text/javascript">
/* validation */
$(document).ready(function(){  
        if(document.getElementById("total_credit_amt2").innerHTML!= '0')
        {
                $("#authorize_form").validate();
        }
});
</script>

<!-- Not allowing the specialchars in Quantity field--> 
 <script type="text/javascript">  
	/* validation */
	$(document).ready(function(){  

	//For Special character Restriction
	//==================================
        $("#credit_quantity2").numeric({allow:""});
        $("#ref_amt3").numeric({allow:"."});
   });
   
</script>

		
<form method="POST" id="authorize_form" action="<?php echo DOCROOT; ?>system/modules/gateway/authorize.net/validate.php" name="DoDirectPaymentForm">
<div style="float:left;clear:both;width:600px; margin-left:14px;">
		<?php if($available_amt > 0) { ?>
	                <p><strong style="color:#666;" class="p5"><?php echo $language["your_ref_bal"]; ?></strong> <?php echo CURRENCY; ?><span id="total_ref2"><?php echo $available_amt; ?></span><strong style="color:#666;" class="p5">.<?php echo $language["use_int"]; ?></strong></p>
		<?php } else { 
				$available_amt = 0;
		?>
			<span style="display:none;" id="total_ref2"><?php echo $available_amt; ?></span>
		<?php } ?>

		<input type="hidden" value="<?php echo $available_amt; ?>" name="ref_amt_bal" id="ref_amt_bal2" /></div>

		<table cellpadding="5" cellspacing="5" align="left" class="fl width930 clr paypal_form" border="0">
		
		<tr style="font-weight:bold;color:#666;">
		<td style="font:bold 12px arial!important;color:#666!important;width:600px;" id="face"><label><?php echo $language['description']; ?></label></td>
		<td><label><?php echo $language['qty']; ?></label></td>
		<td></td>
		<td><label><?php echo $language['price']; ?></label></td>

		<?php if($available_amt > 0) { ?>
		<td><label>Referral Balance</label></td>
		<?php } ?>

		<td></td>
		<td><label><?php echo $language['total']; ?></label></td>
		</tr>
		
		<tr>
		<td style="font:normal 12px arial!important;color:#666!important;width:600px;float:left; clear:both;" id="face">
		<h5 style="font:normal 12px arial!important;color:#666!important;width:600px;float:left; clear:both;" id="face"><?php echo $language['payment_for'].' '.ucfirst($couponname); ?></h5>
		</td>
		<td>
		<input type="text" style="width:48px;" name="quantity" id="credit_quantity2" title="Enter quantity in numeric" class="required fl lh25" maxlength="5" value="1" onblur="calculate_credit_amt2(this.value,<?php echo $total_payable_amount; ?>)" />
		</td>
		
		<td><h5 style="font:normal 12px arial!important;color:#666;">X</h5></td>
		<td><h5 style="font:normal 12px arial!important;color:#666;"><?php echo CURRENCY.'</span>'.$total_payable_amount; ?></h5></td>

		<?php if($available_amt > 0) { ?>

		<td><label class="fl lh30"><?php echo CURRENCY; ?></label><input type="text" class="fl lh25" name="ref_amt2" id="ref_amt3" style="width:48px;" maxlength="5" value="0" onblur="calculate_referral2(this.value,<?php echo $total_payable_amount; ?>)"></td>

		<?php } else { ?>

			<input type="hidden" name="ref_amt2" id="ref_amt3" value="0" />

		<?php } ?>

		<td><h5 style="font:normal 12px arial!important;color:#666;!important">=</h5></td>
		<td>
		<h5><?php echo CURRENCY; ?><span id="total_credit_amt2"><?php echo $total_payable_amount; ?></h5>
		
		</td>
		</tr>

		<tr>
		<td colspan="6" style="border-bottom:1px dotted #C7C7C7;padding-bottom:15px;">
		<label><?php echo $language['total_payable']; ?>:</label>
		<span><?php echo CURRENCY; ?></span><span id="payable_total_amt3" style="font-weight:bold;color:#000;"><?php echo $total_payable_amount; ?></span>
		</td>
		</tr>

		</table>

	<?php
	if($gifttype == 'gift')
	{?>
	    <div class="purchase_gift mt10 fl">
		<table width="600px" border="0" cellpadding="5" cellspacing="5">
		    <tr>
		    <td align="right"  valign="top"><label style="color:#666; font:bold 12px Arial;"><?php echo $language['friend_name']; ?> :</label></td>
		    <td valign="top"><input type="text" name="friendname" title="<?php echo $language['enter_friend_fname']; ?>" class="required" /></td>
		    </tr>
		   
		    <tr>
		    <td align="right" valign="top"><label style="color:#666; font:bold 12px Arial;"><?php echo $language['friend_email']; ?> :</label></td>
		    <td  valign="top"><input type="text" name="friendemail" title="<?php echo $language['enter_friend_email']; ?>" class="email required" /></td>
		    </tr>
		</table>
	    </div>         
	<?php
	}?>

	<table  border="0" cellpadding="3" class="fl clr width930 mt20 paypal_form" id="credit_table">
	<tr>
	<th align="left"><h2><?php echo $language['billing_info']; ?></h2></th><th align="left"><h2><?php echo $language['billing_add']; ?></h2></th></tr>
	<tr>
	<td><?php echo $language['fname']; ?>:</td>
	<td><?php echo $language['address']; ?> 1:</td>
	</tr>
	
	<tr>
	<td align=left>
	<input type="text" size="30" maxlength="32" name="firstName" class="required" title="<?php echo $language['fname']; ?>" value="">
	</td>
	<td>
	<input type="text" size="25" maxlength="100" name="address1" class="required" title="<?php echo $language['address']; ?>" value="">
	</td>
	</tr>
	
	<tr>
		<td><?php echo $language['lname']; ?>:</td>
		<td><?php echo $language['address']; ?> 2:</td>
	</tr>	
	
	<tr>
		<td>
		<input type="text" size="30" maxlength="32" name="lastName" class="required" title="<?php echo $language['lname_req']; ?>" value="">
		</td>
		<td><input type="text"  size="25" class="req_option" maxlength="100" name="address2">
		<br />
		<span style="width:200px;font:italic 12px arial;clear:both;">(<?php echo $language['optional']; ?>)</span></td>
		
	</tr>
	
	<tr>
		<td><?php echo $language['card_type']; ?>:</td>
		<td><?php echo $language['city']; ?>:</td>
	</tr>	
	
	<tr>
	<td>
	<select name="creditCardType" class="credit_card">
		<option value="Visa" selected>Visa</option>
		<option value="MasterCard">MasterCard</option>
		<option value="Discover">Discover</option>
		<option value="Amex">American Express</option>
	</select>
	</td>
	<td>
	<input type="text" size="25" maxlength="40" name="city" class="required" title="<?php echo $language['city_req']; ?>" value="<?php echo $getdetails->cityname;?>">
	</td>
	</tr>
	
	<tr>
		<td><?php echo $language['card_no']; ?>:</td>
		<td><?php echo $language['state']; ?>:</td>
	</tr>
	
	<tr>	
		<td><input type="text" size="19" maxlength="19" name="creditCardNumber" class="required" title="<?php echo $language['card_no_req']; ?>"></td>
		<td><input type="text" size="2" maxlength="2" name="state" value="" class="required" title="<?php echo $language['enter_your_state'];?>" /></td>
	</tr>
	
	<tr>
		<td><?php echo $language['expiration_date']; ?>:</td>
		<td><?php echo $language['zip_code']; ?>:</td>
	</tr>
	
	<tr>
		<td>
			<select name="expDateMonth" class="credit_card">
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select>
			<select name="expDateYear" class="credit_card">
				<option value=2011 >2011</option>
				<option value=2012 selected>2012</option>
				<option value=2013>2013</option>
				<option value=2014>2014</option>
				<option value=2015>2015</option>
				<option value=2016>2016</option>
				<option value=2017>2017</option>
				<option value=2018>2018</option>
				<option value=2019>2019</option>
				<option value=2020>2020</option>
			</select>
		</td>
		
		<td>
		<input type="text" size="10" maxlength="10" minvalue="5" name="zip" class="required" title="<?php echo $language['enter_zip_code']; ?>" value="">
		<br />
		<span style="width:200px;font:italic 12px arial;clear:both;">(5 or 9 <?php echo $language['digits']; ?>)</span>
		</td>
	</tr>
	
	<tr>
		<td><?php echo $language['card_verification_no']; ?>:</td>
		<td><?php echo $language['country']; ?>:</td>
	</tr>
	
	<tr>
		<td>
		<input type="text" size="3" maxlength="4" name="cvv2Number" value="" class="required" title="<?php echo $language['card_vno_req']; ?>">
		</td>
		<td><input type="text" size="2" class="required" maxlength="2" name="countrycode" value="<?php //echo $getdetails->countrycode;?>" title="<?php echo $language['enter_your_country'];?>">
				<br />
		<span style="width:200px;font:italic 12px arial;clear:both;">(2 <?php echo $language['characters']; ?>)</span></td>
	</tr>

	</table>

        <input type="hidden" id="CUSTOM2"/>

	<input type="hidden" value="<?php echo $paymentid;?>" name="pay_mod_id" />
	<input type="hidden" name="amount" id="amount2" value="<?php echo $total_payable_amount; ?>" /> 
	<input type="hidden" name="PAYMENT_ACTION_NAME" value='Creditcardpayment' > 
	<input type="hidden" name="total_pay_amt" id="total_pay_amt2" value="<?php echo $total_amount; ?>" >
	<input type="hidden" name="paymentType" value="<?php echo $paymentType;?>" />
	<input type="hidden" name="couponid" value="<?php echo $coupon_id;?>" />
	<input type="hidden" name="currency" value="<?php echo PAYPAL_CURRENCY_CODE;?>" />
	<input type="hidden" name="qty" id="qty2" value="1" />
	<input type="hidden" name="user" value="<?php echo $getdetails->userid;?>" />
	<input type="hidden" name="mail" value="<?php echo $getdetails->email;?>" />
	<span class="submit fl clr ml15"><input class="bnone " type="Submit" value="<?php echo $language['pay_now']; ?>" id=""></span>

</form>
 
