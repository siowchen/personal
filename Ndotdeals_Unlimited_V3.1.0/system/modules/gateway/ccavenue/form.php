<?php
$paymentType = 'ccavenue';
?>
<script type="text/javascript">
function cc_calculate_credit_amt2(count,price)
{
        var ref_amt = document.getElementById("cc_ref_amt3").value;
	var total = Math.round(count * price * 100)/100; //two decimal value
	var balance = Math.round((total - ref_amt)* 100)/100;
        var total_ref = document.getElementById('cc_total_ref2').innerHTML;
        
        
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
		document.getElementById("cc_credit_cc_quantity2").value = '1';
		return;
	}
	
	if(count == 0)
	{
		document.getElementById("cc_credit_cc_quantity2").value = '1';
		return;
	}

	if(ref_amt <= total_ref)
        { 
                if(ref_amt > total)
                {
                        document.getElementById('cc_ref_amt3').value = 0;
                }
        }
        else
        {
                document.getElementById('cc_ref_amt3').value = 0;
        }

		document.getElementById("cc_total_credit_amt2").innerHTML=balance;
		document.getElementById("cc_payable_total_amt3").innerHTML=balance;   
		document.getElementById("cc_amount2").value = balance;
		document.getElementById("cc_qty2").value='';
		document.getElementById("cc_qty2").value=count;

} 
 
function cc_calculate_referral2(ref_amt,price)
{
	ref_amt = parseInt(ref_amt);
        var count = document.getElementById('cc_credit_cc_quantity2').value;
        var purchase_price;
        var total_ref = document.getElementById('cc_total_ref2').innerHTML;
        var total;
        var balance = 0;

	var ref_amt_bal = parseInt(document.getElementById('cc_ref_amt_bal2').value);

	if(ref_amt_bal >= ref_amt && parseFloat(document.getElementById("cc_total_credit_amt2").innerHTML) >= ref_amt ){
		// Condition to check whether entered amount is with in Original balance & total order
		//alert("success");
	}else{
		alert("Enter applicable refferal amount!");
		document.getElementById('cc_ref_amt3').value = 0;
		balance = Math.round(count * price * 100)/100; //two decimal value

		document.getElementById("cc_total_credit_amt2").innerHTML=balance;
		document.getElementById("cc_total_pay_amt2").innerHTML=balance;
		document.getElementById("cc_payable_total_amt3").innerHTML=balance;     
		document.getElementById("cc_amount2").value = balance;

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
		document.getElementById("cc_quantity").value = '1';
		return;
	}
	
	if(count == 0)
	{
		document.getElementById("cc_quantity").value = '1';
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
                       document.getElementById('cc_ref_amt3').value = ref_amt;
                }
        }
        else
        {
                document.getElementById('cc_ref_amt3').value = 0;
        }
       
	document.getElementById("cc_ref_amt3").value=ref_amt;
	document.getElementById("cc_total_credit_amt2").innerHTML=balance;
	document.getElementById("cc_total_pay_amt2").innerHTML=balance;
	document.getElementById("cc_payable_total_amt3").innerHTML=balance;     
	document.getElementById("cc_amount2").value = balance;

}      
</script>
<script type="text/javascript">
/* validation */
$(document).ready(function(){  
        if(document.getElementById("cc_total_credit_amt2").innerHTML!= '0')
        {
                $("#CC_form").validate();
        }
});
</script>
		
<form method="POST" id="CC_form" action="<?php echo DOCROOT; ?>system/modules/gateway/ccavenue/checkout.php" name="DoDirectPaymentForm">

		<?php if($available_amt > 0) { ?>
	               <p style="width:938px;font:bold 12px tahoma;color:#333333" class="fl pl10 pt10 pb10"><strong><?php echo $language["your_ref_bal"]; ?></strong> <span id="cc_total_ref2" class="price_color"><?php echo CURRENCY; ?><?php echo $available_amt; ?></span><strong class="p5">.<?php echo $language["use_int"]; ?></strong></p>
		<?php } else { 
				$available_amt = 0;
		?>
			<span style="display:none;" id="cc_total_ref2"><?php echo $available_amt; ?></span>
		<?php } ?>

		<input type="hidden" value="<?php echo $available_amt; ?>" name="ref_amt_bal" id="cc_ref_amt_bal2" />

		<div class="fl clr pt10 pb10 pay_pal_method">
              <table width="940px" border="0" cellpadding="5" cellspacing="0" class="fl clr">
                <tr style="font-weight:bold;color:#666; ">
                  <th><label><?php echo $language['description']; ?></label></th>
                  <th align="left"><label><?php echo $language['qty']; ?></label></th>
                  <th></th>
                  <th align="left"><label><?php echo $language['price']; ?></label></th>
                  <?php if($available_amt > 0) { ?>
                  <th align="left"><label>Referral Balance</label></th>
                  <?php } ?>
                  <th></th>
                  <th align="left"><label class="price_color"><?php echo $language['total']; ?></label></th>
                </tr>
                <tr>
                <td>
                <label><?php echo $language['payment_for'].' '.ucfirst($couponname); ?></label>
                </td>
                <td>
                <label>
                <input type="text" style="width:48px;background:#fff" name="cc_quantity" id="cc_credit_cc_quantity2" title="Enter cc_quantity in numeric" class="required fl lh25" maxlength="5" value="1" onblur="cc_calculate_credit_amt2(this.value,<?php echo $total_payable_amount; ?>)" />
                </label>
                </td>
                
                <td><label>X</label></td>
                <td><label><?php echo CURRENCY.'</span>'.$total_payable_amount; ?></label></td>
        
                <?php if($available_amt > 0) { ?>
        
                <td><label class="fl lh30"><?php echo CURRENCY; ?></label><input type="text" name="ref_amt2" id="cc_ref_amt3" style="width:48px;background:#fff" class="fl lh25" maxlength="5" value="0" onblur="cc_calculate_referral2(this.value,<?php echo $total_payable_amount; ?>)"></td>
        
                <?php } else { ?>
        
                    <input type="hidden" name="ref_amt2" id="cc_ref_amt3" value="0" />
        
                <?php } ?>
        
                <td><label>=</label></td>
                <td>
                <label class="price_color"><?php echo CURRENCY; ?><span id="cc_total_credit_amt2"><?php echo $total_payable_amount; ?></span>
                </label>
                </td>
                </tr>

                <tr>
                <td colspan="6">
                <label><?php echo $language['total_payable']; ?>:</label>
                <span id="cc_payable_total_amt3" class="price_color"><?php echo CURRENCY; ?><?php echo $total_payable_amount; ?></span>
                </td>
                </tr>

			</table>
      	</div>	      

	<?php
	if($gifttype == 'gift')
	{?>
	    <div class="purchase_gift mt10 fl">
		<table width="400px" border="0" cellpadding="5" cellspacing="5">
		    <tr>
		    <td align="right" width='110px' valign="top"><label style="color:#666; font:bold 12px Arial;"><?php echo $language['friend_name']; ?> :</label></td>
		    <td  width='250px'  valign="top"><input type="text" name="friendname" title="<?php echo $language['enter_friend_fname']; ?>" class="required" /></td>
		    </tr>
		   
		    <tr>
		    <td align="right" valign="top"><label style="color:#666; font:bold 12px Arial;"><?php echo $language['friend_email']; ?> :</label></td>
		    <td  valign="top"><input type="text" name="friendemail" title="<?php echo $language['enter_friend_email']; ?>" class="email required" /></td>
		    </tr>
		</table>
	    </div>         
	<?php
	}?>

	

        <input type="hidden" name="CUSTOM" id="CUSTOM2" value="<?php echo $coupon_id; ?>,1"/>

	<input type="hidden" value="<?php echo $paymentid;?>" name="pay_mod_id" />
	<input type="hidden" name="AMT" id="AMT" value="<?php echo round($total_payable_amount, 2); ?>" >
	<input type="hidden" name="amount" id="cc_amount2" value="<?php echo $total_payable_amount; ?>" /> 
	<input type="hidden" name="PAYMENT_ACTION_NAME" value='Creditcardpayment' > 
	<input type="hidden" name="total_pay_amt" id="cc_total_pay_amt2" value="<?php echo $total_payable_amount; ?>" >
	<input type="hidden" name="paymentType" value="<?php echo $paymentType;?>" />
	<input type="hidden" name="couponid" value="<?php echo $coupon_id;?>" />
	<input type="hidden" name="currency" value="<?php echo PAYPAL_CURRENCY_CODE;?>" />
	<input type="hidden" name="qty" id="cc_qty2" value="1" />
	<!--<input type="hidden" name="user" value="<?php echo $getdetails->userid;?>" />
	<input type="hidden" name="mail" value="<?php echo $getdetails->email;?>" />-->
	<span class="fl submit clr"><input class=" bnone" type="Submit" value="<?php echo $language['pay_now']; ?>" id="c_pay"></span>
    </form>
 
