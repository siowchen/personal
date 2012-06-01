<?php 
session_start();?>
<script type="text/javascript">
function calculate_amt(count,price)
{
	var ref_amt = document.getElementById("ref_amt").value;
        var total_ref = document.getElementById('total_ref').innerHTML;
        var total = parseFloat(Math.round(count * price * 100)/100); //two decimal value
        var balance = 0;
	ref_amt = parseFloat(ref_amt);

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
		document.getElementById("quantity").value = '1';
		return;
	}
	
	if(count == 0)
	{
		document.getElementById("quantity").value = '1';
		return;
	}

	if(ref_amt <= total_ref)
        { 
                if(ref_amt > total)
                {
                        document.getElementById('ref_amt').value = 0;
                }
        }
        else
        {
                document.getElementById('ref_amt').value = 0;
        }

	document.getElementById("total_amt1").innerHTML=balance;
	document.getElementById("payable_total_amt").innerHTML=balance;     
	document.getElementById("AMT").value = balance;

        var data = document.getElementById("CUSTOM").value;
        var cid = data.split(",",1);
        if(count=='') count = 1;
        var cumm = cid+","+count
        document.getElementById("CUSTOM").value='';
	document.getElementById("CUSTOM").value=cumm;
}      

function calculate_referral(ref_amt,price)
{
	ref_amt = parseFloat(ref_amt);
        var count = document.getElementById('quantity').value;
        var purchase_price;
        var total_ref = document.getElementById('total_ref').innerHTML;
        var total;
        var balance = 0;
	var ref_amt_bal = parseFloat(document.getElementById('ref_amt_bal').value);

	if(ref_amt_bal >= ref_amt && parseFloat(document.getElementById("total_amt1").innerHTML) >= ref_amt ){
		// Condition to check whether entered amount is with in Original balance & total order
		// alert("success");
	}else{

		alert("Enter applicable refferal amount!"); 
		document.getElementById('ref_amt').value = 0;
		balance = Math.round(count * price * 100)/100; //two decimal value
		document.getElementById("total_amt1").innerHTML=balance;
		document.getElementById("payable_total_amt").innerHTML=balance;     
		document.getElementById("AMT").value = balance;
		var data = document.getElementById("CUSTOM").value;
		var cid = data.split(",",1);
		if(count=='') count = 1;
		var cumm = cid+","+count
		document.getElementById("CUSTOM").value='';
		document.getElementById("CUSTOM").value=cumm;
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
		document.getElementById('ref_amt').value = 0;
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
                       document.getElementById('ref_amt').value = ref_amt;
                }
        }
        else
        {
                document.getElementById('ref_amt').value = 0;
        }
	
	document.getElementById("total_amt1").innerHTML=balance;
	document.getElementById("payable_total_amt").innerHTML=balance;     
	document.getElementById("AMT").value = balance;

        var data = document.getElementById("CUSTOM").value;
        var cid = data.split(",",1);
        if(count=='') count = 1;
        var cumm = cid+","+count
        document.getElementById("CUSTOM").value='';
	document.getElementById("CUSTOM").value=cumm;
	
}         
</script>
<?php is_login(DOCROOT."login.html"); ?>

<h1 class="page_tit"><?php echo $page_title; ?></h1>
<?php
	$userid = $_SESSION['userid'];
	
	$get_fund_balance = mysql_query("select referral_earned_amount from coupons_users where userid ='$userid' ");
	while($res = mysql_fetch_array($get_fund_balance))
	{
		$current_user_balance_amount = $res["referral_earned_amount"];
	}

	$available_amt = $current_user_balance_amount;  
	if(empty($available_amt))
	{
	        $available_amt = 0;
	}
?>
<?php
//get the coupon amount and code
$uri = $_SERVER['REQUEST_URI'];
$coupon_url = explode('=',$uri);

if(is_numeric($coupon_url[1]))
{
	$coupon_id = $coupon_url[1]; 
	$gifttype='';
}
else
{
	$coupon_url = explode('&',$coupon_url[1]);
	$coupon_id = $coupon_url[0];
	$gifttype='gift';
}

$coupon_info = get_coupon_code($coupon_id);
if(mysql_num_rows($coupon_info)>0)
{
        while($row = mysql_fetch_array($coupon_info))
        {
		$coupon_code = $row["coupon_id"];
                $total_payable_amount = $row["coupon_value"]; 

		if(ctype_digit($total_payable_amount)) { 
			$total_payable_amount = $total_payable_amount;
		} 					  
	        else { 

			$total_payable_amount = number_format($total_payable_amount, 2,',','');
			$total_payable_amount = explode(',',$total_payable_amount);
			$total_payable_amount = $total_payable_amount[0].'.'.$total_payable_amount[1];

		}                
                 
                $couponname = html_entity_decode($row["coupon_name"], ENT_QUOTES);
	      	$coupondesc = html_entity_decode($row["coupon_description"], ENT_QUOTES);
        }
}
?>
 <div class="mobile_content">
   <div class="content_high fl">
  <script type="text/javascript">
		function showmodules(val){
			var currentmodule = document.getElementById('moduleopen').value;
			//alert(currentmodule);
			$('#pay_form_'+currentmodule).hide('fast');
			$('#pay_form_'+val).show('slow');  
			document.getElementById('moduleopen').value = val;	
		}
		</script>
  <?php
		function removepaypal($val){
			if($val['name']=='paypal'){
			 	
			}else{
				return $val['name'];
			}
		}
		
		function checkpaypal($val){
			if($val['name']=='paypal'){ 
			 	return $val;
			}else{
				
			}
		}
		
		function filter_by_value ($array, $index, $value){
			if(is_array($array) && count($array)>0) 
			{
			    foreach(array_keys($array) as $key){
				$temp[$key] = $array[$key][$index];
				
				if ($temp[$key] == $value){
				    $newarray[$key] = $array[$key];
				}
			    }
			  }
	    		return $newarray;
		} 
		
		$sql = "select * from payment_modules where pay_mod_active = 1 order by (pay_mod_default or pay_mod_name) desc";
		$result = mysql_query($sql) or die(mysql_error());
		$paymentgateway = array();
		$paymenttype = '';
		$i = 0;
		while($fetch = mysql_fetch_array($result)){
			$paymentgateway[$i]['name'] = strtolower($fetch['pay_mod_name']);
			$paymentgateway[$i]['default'] = strtolower($fetch['pay_mod_default']);
			$paymentgateway[$i]['mod_id'] = strtolower($fetch['pay_mod_id']);
			$i++;
		}  
		$paypal = array_filter($paymentgateway,"checkpaypal"); //print_r($paypal); 
		list($modid) = array_values($paypal); //print_r($modid);
		$paypal_default = filter_by_value($paypal,'default','1'); //print_r($paypal_default);
		$othermodules = array_filter($paymentgateway,"removepaypal"); 
		//print_r($othermodules); 
		?>
  <table class="pay_type fl clr">
    <tr>
      <td><?php echo $language['payment_type']; ?></td>
    </tr>
    <tr>
      <?php if($paypal){?>
      <td>
      <div class="radio_con"><input name="payment_type" type="radio" id="payment1" value="1" <?php if($paypal_default) echo 'checked="checked"'; ?> onclick="javascript: showmodules('2');" />
        <label>Paypal</label></div>
       
        <div class="radio_con"><input name="payment_type" type="radio" id="payment2"  value="2" onclick="javascript: showmodules('1');"/>
        <label>Credit card using Paypal</label>
        </div>
      </td>
    </tr>
    <tr>
      <?php } 
	  	$l = 3;
		$j = '';
		foreach($othermodules as $module){ ?>
      <td><div class="radio_con"><input name="payment_type" type="radio" id="payment<?php echo $l;?>" value="<?php echo $l;?>"  onclick="javascript: showmodules('<?php echo $l;?>');"  <?php if($module['default']=='1') { echo 'checked="checked"'; echo $j = $l; }?>/>
        <label><?php echo ucfirst($module['name']);?></label></div>
        <?php $l++;
		} ?>
        <input type="hidden" name="moduleopen" id="moduleopen" value="<?php if($paypal_default) echo '2'; else echo $j;?>" />
    </tr>
  </table>
  <?php 
			//credit card and paypal system
			//$userinfo = new UserInfomation();
			//$getdetails = $userinfo->getuserinfomation($_SESSION['userid']);  
			$dir = DOCUMENT_ROOT."/system/modules/gateway/";
		?>
  <!-- credit card with paypal gateway -->
  <?php if($paypal){ 
  	$paymentid = $modid['mod_id']; //print_r($paymentid);
	?>
  <div id='pay_form_1' style="display:none;" class='pay fl clr'>
    <?php require_once($dir."paypal/mobile_form.php"); ?>
  </div>
  <!-- end of credit card with paypal gateway -->
  <!-- paypal gateway -->
  <?php if($paypal_default) $type = 'block'; else $type = 'none';  ?>
  <?php $paymentid = $modid['mod_id']; //print_r($paymentid); ?>
  <div id="pay_form_2" style="display:<?php echo $type;?>">
    <form action="/system/modules/gateway/paypal/ReviewOrder.php" method="POST" name="paypal_form" id="paypal_form">
      <?php if($available_amt > 0) { ?>
      <p><strong style="color:#666;" class="p5">Your referral balance is</strong> <span class="color_ora"><?php echo CURRENCY; ?><span id="total_ref"><?php echo $available_amt; ?></span></span></p>
      <?php } else { 
				$available_amt = 0;
		?>
      <span style="display:none;" id="total_ref"><?php echo $available_amt; ?></span>
      <?php } ?>
      <input type="hidden" value="<?php echo $available_amt; ?>" name="ref_amt_bal" id="ref_amt_bal" />
      <?php
		if($gifttype=='gift')
		{?>
      <div class="purchase_gift mt10 fl clr">
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
      <!-- standard paypal form-->
      <table cellpadding="5" align="left" class="fl payment_table" style="width:100%;" border="0">
        <tr style="font-weight:bold;color:#666; ">
          <td><label><?php echo $language['description']; ?></label></td>
        </tr>
        <tr>
          <td><label><?php echo 'Payment for '.ucfirst($couponname); ?></label></td>
        </tr>
        <tr>
          <td><label><?php echo $language['qty']; ?> X <?php echo $language['price']; ?></label></td>
        </tr>
        <tr>
          <td><input type="text" style="width:48px;" name="quantity" id="quantity" title="Enter quantity in numeric." class="digits required" maxlength="5" value="1" onblur="calculate_amt(this.value,<?php echo round($total_payable_amount,2); ?>)" />
            X <?php echo CURRENCY; ?><span id="price_val"><?php echo $total_payable_amount; ?></span> </td>
        </tr>
        <tr>
          <?php if($available_amt > 0) { ?>
          <td><label>Referral Balance</label></td>
          <?php } ?>
        </tr>
        <tr>
          <td><input type="text" name="ref_amt" id="ref_amt" style="width:48px;" maxlength="5" value="0" onblur="calculate_referral(this.value,<?php echo round($total_payable_amount,2); ?>)"></td>
        </tr>
        <tr>
          <td><label><?php echo $language['total']; ?></label></td>
        </tr>
        <tr>
          <td><?php echo CURRENCY; ?><span id="total_amt1"><?php echo round($total_payable_amount, 2); ?></span></td>
        </tr>
        
        <tr>
        <td><label><?php echo $language['total_payable']; ?>:</label>
          <span><?php echo CURRENCY; ?></span> <span id="payable_total_amt" style="font-weight:bold;color:#000;"> <?php echo round($total_payable_amount, 2); ?></span> </td>
      </tr>
      <tr>
        <td><input type="hidden" name="referral_balance" id="referral_balance" value="<?php echo $available_amt; ?>" >
          <input type="hidden" value="<?php echo $paymentid;?>" name="pay_mod_id" />
          <input type="hidden" name=PAYMENTACTION value='Authorization' >
          <input type="hidden" name="AMT" id="AMT" value='<?php echo round($total_payable_amount, 2); ?>' >
          <input type="hidden" name="CUSTOM" id="CUSTOM" value='<?php echo $coupon_id; ?>,1' >
          <input type="hidden" name="CURRENCYCODE" value='<?php echo PAYPAL_CURRENCY_CODE;?>' >
          <input type="image" name="submit"  src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
        </td>
      </tr>
      </table>
    </form>
  </div>
  <?php }  
		
		$dir = $_SERVER['DOCUMENT_ROOT']."/system/modules/gateway/";
		$m=3;
		foreach($othermodules as $module){
				$type = 'none';
				if($module['default']=='1') $type='block';
				echo "<div id='pay_form_$m' style='display:$type;' class='pay fl clr'>";
				$paymentid = $module['mod_id'];
				require_once($dir.$module['name']."/mobile_form.php"); 
				echo "</div>";
				$m++;
				}

?>
  <!-- end of paypal gateway -->
</div>
</div>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#paypal_form").validate();});
</script>
