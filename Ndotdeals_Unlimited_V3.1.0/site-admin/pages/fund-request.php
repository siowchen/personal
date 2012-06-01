<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<?php
	$uid = $_SESSION["userid"];
	
	//fund request fund calculation
	$pending_request = mysql_query("select sum(amount) as total_amt from request_fund where bid='$uid' AND status=1");
	if(mysql_num_rows($pending_request)>0)
	{
		while($row = mysql_fetch_array($pending_request))
		{
			$total_pending_request = $row["total_amt"];
		}
	}
	else
	{
			$total_pending_request = 0;
	}
	
	$available_amt = $current_user_balance_amount - $total_pending_request; 
	
	//handle post form
	if($_POST)
	{
		$type = 1;
		$status = 1;
		$request_amount = $_POST['request_amount'];
		
		if($request_amount)
		{
			if($request_amount>=MIN_FUND && $request_amount<=MAX_FUND && $current_user_balance_amount>=$request_amount && $available_amt >= $request_amount)
			{
				$query = "insert into request_fund (type,bid,amount,status)values('$type','$uid','$request_amount','$status')";
				mysql_query($query);
				set_response_mes(1,$admin_language['yourrequestsent']);
				url_redirect(DOCROOT."admin/fund-request/");
			}
			else
			{
				set_response_mes(-1,$admin_language['yourrequestmaxndmin']);
				url_redirect(DOCROOT."admin/fund-request/");			

			}
		}
		else
		{
			set_response_mes(-1,$admin_language['pleaseentervalue']);
			url_redirect(DOCROOT."admin/fund-request/");			
		}
	}
	
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#fund_request").validate();});
</script>

<div class="form">
<div class="form_top"></div>
      <div class="form_cent">    
        <form name="fund_request" id="fund_request" action="" enctype="multipart/form-data" method="post" class="ml10">

          <fieldset>
			<p>
              <label for="dummy0"><?php echo $admin_language['amount']; ?></label><br>
              <input type="text" class="required digits" title="<?php echo $admin_language['entertheamountvalue']; ?>" name="request_amount" id="request_amount"  /><br>
	     	  <span id="cnameerror" style="color:red"> </span> 
			  <br />
            </p>
			
			<p>
			  <span> * Minimum withdraw amount: <?php echo CURRENCY;?> <?php echo MIN_FUND;?></span><br />
			  <span> * Maximum withdraw amount: <?php echo CURRENCY;?> <?php echo MAX_FUND;?></span>
			</p>
			
	   		<div class="fl clr">
              <input type="submit" value="<?php echo $admin_language['confirm']; ?>" class="">
            </div>

          </fieldset>
        </form>
     </div>
<div class="form_bot"></div>
</div>

