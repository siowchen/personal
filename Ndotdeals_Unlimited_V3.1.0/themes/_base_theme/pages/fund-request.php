<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<?php
	$uid = $_SESSION["userid"];
	
	$get_fund_balance = mysql_query("select account_balance from coupons_users where userid ='$uid' ");
	while($res = mysql_fetch_array($get_fund_balance))
	{
		$current_user_balance_amount = $res["account_balance"];
	}

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
	
	
	//get the user request amount
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
				set_response_mes(1,$language['req_sent']);
				url_redirect(DOCROOT."fund-request.html");
			}
			else
			{
				set_response_mes(-1,$language['req_minmiax']);
				url_redirect(DOCROOT."fund-request.html");			

			}
		}
		else
		{
			set_response_mes(-1,$language['req_value']);
			url_redirect(DOCROOT."fund-request.html");			
		}
	}
	
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#fund_request").validate();});
</script>

<?php include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>

<div class="work_bottom">

<p class="fl"><?php echo $language['amt_bal']; ?> : <?php echo CURRENCY; ?><?php echo $current_user_balance_amount; ?></p>

		<div class="fl">
        <form name="fund_request" id="fund_request" action="" enctype="multipart/form-data" method="post" class="ml10">

          <fieldset>
			<p>
              <label for="dummy0"><?php echo $language['amt']; ?></label><br>
              <input type="text" class="required digits" title="<?php echo $language['amt_val']; ?>" name="request_amount" id="request_amount"  /><br>
	     	  <span id="cnameerror" style="color:red"> </span> 
			  <br />
            </p>
			
			<p>
			  <span> * <?php echo $language['min_withdraw_amt']; ?>: <?php echo CURRENCY;?> <?php echo MIN_FUND;?></span><br />
			  <span> * <?php echo $language['max_withdraw_amt']; ?>: <?php echo CURRENCY;?> <?php echo MAX_FUND;?></span>
			</p>
			
	   		<p>
              <input type="submit" value="<?php echo $language['confirm']; ?>" class=" button_c">
            </p>

          </fieldset>
        </form>
		</div>

<div class="fl">
<!-- list of fund -->
<?php 
$query = "select * from request_fund where bid = '$uid' ";

        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

	if(mysql_num_rows($resultSet)>0)
	{
	 ?>
	
			 <table cellpadding="10" cellspacing="0" width="650" >
			 <tr style="border:1px solid #ccc;">
			 <th style="border:1px solid #ccc;"><?php echo $language['req_on']; ?>n</th>
			 <th style="border:1px solid #ccc;"><?php echo $language['amt']; ?>(<?php echo CURRENCY;?>)</th> 
			 <th style="border:1px solid #ccc;"><?php echo $language['status']; ?></th> 			
			 </tr>
	
	<?php 
		while($row = mysql_fetch_array($resultSet))
		{ 
			?>
			<tr style="border:1px solid #ccc;">
			<td style="border:1px solid #ccc;"><?php echo $row["requested_date"];?></td>
			<td style="border:1px solid #ccc;"><?php echo $row["amount"];?></td>
			<td style="border:1px solid #ccc;">
			<?php 
			if($row["status"] == 1) 
			{
				echo "Pending";
			}
			else if($row["status"] == 2)
			{
				echo "Approved";
			}
			else
			{
				echo "Rejected";
			}
			?>
			</td>
			</tr>
			<?php 
		} ?>
		
		</table>
		<?php 
	}
	else
	{
		?>
			<div class="fl no_data">
			<?php echo $language['no_req_avail']; ?>
			</div>
		<?php 
	}
	?>
	
	</div>
	
	
	</div>
