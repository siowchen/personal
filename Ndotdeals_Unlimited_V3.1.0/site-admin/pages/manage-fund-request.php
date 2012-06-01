<?php 
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$url_array = explode("/",$_SERVER["REQUEST_URI"]);
$url_array = explode("?",$url_array[3]);
$url_array[3] = $url_array[0];

?>

	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_1006").slideToggle();
	document.getElementById("left_menubutton_1006").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>

<?php
	$uid = $_SESSION["userid"];
	if($_POST)
	{
		//pending list form
		if($_POST["form_type"] == "pending")
		{
			$request_list = $_POST["pending_req_list"];
			$request_action = $_POST["request_action"];
			if($request_action == 1)
			{
				//approve (pay to user)
				foreach($request_list as $index=>$val)
				{
					mysql_query("update request_fund set status='2',pay_status='1' where requested_id='$val' ");
				}
				set_response_mes(1,$admin_language['requestapprovedpayment']);
				url_redirect(DOCROOT."admin/manage-fund-request/pending/");
				
			}
			else
			{
				//reject request
				foreach($request_list as $index=>$val)
				{
					mysql_query("update request_fund set status='3' where requested_id='$val' ");
				}
				set_response_mes(1,$admin_language['requestrejected']);
				url_redirect(DOCROOT."admin/manage-fund-request/pending/");

			}
		}
		else if($_POST["form_type"] == "failed")
		{
			$request_list = $_POST["failed_list"];
			$request_action = $_POST["request_action"];
			if($request_action == 1)
			{
				//approve (pay to user)
				foreach($request_list as $index=>$val)
				{
					mysql_query("update request_fund set status='2',pay_status='1' where requested_id='$val' ");
				}
		                set_response_mes(1,$admin_language['requestapprovedpayment']);
			        url_redirect(DOCROOT."admin/manage-fund-request/failed/");			
			}
			else
			{
				//reject request
				foreach($request_list as $index=>$val)
				{ 
					mysql_query("update request_fund set status='1',pay_status='0' where requested_id='$val' ");
				}
                                set_response_mes(1,$admin_language['requestrejected']);
				url_redirect(DOCROOT."admin/manage-fund-request/failed/");
			}
		}
		//loop end
	}
?>
	<!-- delete request function -->
	<script type="text/javascript">
	function delete_req(id,refid)
	{
		var aa = confirm("Are you sure want to delete it?");
		if(aa)
		{
			window.location = '/site-admin/pages/delete.php?req_id='+id+'&refid='+refid;
		}
	}
	</script>

	<div id="menu_container">
		
		<?php if($url_array[3]=='pending') { ?>
			<!-- pending requests -->
			<div class="menu_content desc">
			<?php 
			$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name from request_fund left join coupons_users on request_fund.bid = coupons_users.userid left join coupons_roles on coupons_users.user_role=coupons_roles.roleid where type='1' AND request_fund.status = '1' order by requested_id desc ";
			/*
			$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
					 <form name="pending_request" id="pending_request" action="<?php echo DOCROOT;?>system/modules/gateway/paypal/MassPayReceipt.php?type=fund_request" method="post">
					 <input type="hidden" name="form_type" value="pending" />
					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th>&nbsp;</th>
					 <th><?php echo $admin_language['delete']; ?></th>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>  			
					 </tr>
				
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td>
						<input type="checkbox"  name="pending_req_list[]" value="<?php echo $row["requested_id"];?>" />
						</td>
						<td>
						<a href="javascript:delete_req(<?php echo $row["requested_id"];?>,'<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>');"><?php echo $admin_language['delete']; ?></a>
						</td>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
						</tr>
						<?php 
					} ?>
					
					</table>
					
					<p>
					
					
					
					<input type="checkbox" value="0" name='checkall' onclick="checkUncheckAll(this);" /><label class="ml-10"> All/ None</label>
					
					<!--<select name="request_action">
					<option value="">-More Action-</option>
					<option value="1" onclick="javascript:approve('pending');">Approve (Pay to user)</option>
					<option value="2" onclick="javascript:reject('pending');">Reject</option>
					</select>-->
					
					<select name="request_action" onchange="if
(this.options[this.selectedIndex].value=='1') { approve('pending'); } else if(this.options[this.selectedIndex].value=='2'){ reject('pending'); }">
					<option value="">-<?php echo $admin_language['moreaction']; ?>-</option>
					<option value="1" ><?php echo $admin_language['approve']; ?></option>
					<option value="2" ><?php echo $admin_language['reject']; ?></option>
					</select>					

					</form>
					
					
					<?php 
				}
				else
				{
					?>
						<div class="fl no_data">
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>
			</div>
			<!-- pending requests end -->

		<?php }
		 else if($url_array[3]=='approved') { ?>			
			<!-- Approved requests starts -->
			<div class="menu_content news">
						
			<?php 
			$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name from request_fund left join coupons_users on request_fund.bid = coupons_users.userid left join coupons_roles on coupons_users.user_role=coupons_roles.roleid where type='1' AND request_fund.status = '2' order by requested_id desc ";
			
			/*$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/
    
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
				
					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>  			
					 </tr>
				
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
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
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>

			</div>
			<!-- approved requests end -->

		<?php }
		 else if($url_array[3]=='rejected') { ?>
			
			<!-- Rejected requests starts -->
			<div class="menu_content links">
			<?php 
			$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name from request_fund left join coupons_users on request_fund.bid = coupons_users.userid  left join coupons_roles on coupons_users.user_role=coupons_roles.roleid where type='1' AND request_fund.status = '3' order by requested_id desc ";
			
			/*$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/
      
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
				
					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th><?php echo $admin_language['delete']; ?></th>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>  			
					 </tr>
				
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td><a href="javascript:delete_req(<?php echo $row["requested_id"];?>,'<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>');"><?php echo $admin_language['delete']; ?></a></td>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
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
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>
				
			</div>
			<!-- Rejected requests end -->

		<?php }
		 else if($url_array[3]=='success') { ?>
			
			<!-- success start -->
			<div class="menu_content doc">
			<?php 
			$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name from request_fund left join coupons_users on request_fund.bid = coupons_users.userid  left join coupons_roles on coupons_users.user_role=coupons_roles.roleid where  type='1' AND pay_status = '1' order by requested_id desc ";
			
			/*$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/

         $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
				
					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th><?php echo $admin_language['delete']; ?></th>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>  			
					 </tr>
				
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td><a href="javascript:delete_req(<?php echo $row["requested_id"];?>,'<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>');"><?php echo $admin_language['delete']; ?></a></td>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
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
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>
			</div>
			<!-- success end -->

		<?php }
		 else if($url_array[3]=='failed') { ?>
			
			<!-- failed start -->
			<div class="menu_content request_failed">
						<?php 
			$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name from request_fund left join coupons_users on request_fund.bid = coupons_users.userid left join coupons_roles on coupons_users.user_role=coupons_roles.roleid where  type='1' AND pay_status = '2' order by requested_id desc ";
			
			/*$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/
 
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
	 				<form name="failed_transaction" id="failed_transaction" action="<?php echo DOCROOT;?>system/modules/gateway/paypal/MassPayReceipt.php?type=fund_request" method="post">
					<input type="hidden" name="form_type" value="failed" />

					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th><?php echo $admin_language['select']; ?></th>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>  			
					 </tr>
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td valign="middle">
						<a href="javascript:delete_req(<?php echo $row["requested_id"];?>,'<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>');" class="fl"><?php echo $admin_language['delete']; ?></a>
						
						<input type="checkbox"  name="failed_list[]" value="<?php echo $row["requested_id"];?>" style="margin:0" />
						</td>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
						</tr>
						<?php 
					} ?>
					
									
					</table>
				<div class="fl clr mt10">
                	<input type="checkbox" value="0" name='checkall' onclick="checkUncheckAll(this);" />
					<label class="ml-10"> All/ None</label>
				</div>
				<!--<select name="request_action">
				<option value="">-More Action-</option>
				<option value="1" onclick="javascript:approve('failed');">Approve (Pay to user)</option>
				<option value="2" onclick="javascript:reject('failed');">Pending</option>
				</select>-->
				
				<select name="request_action" onchange="if
(this.options[this.selectedIndex].value=='1') { approve('failed'); } else if(this.options[this.selectedIndex].value=='2'){ reject('failed'); }">
				<option value="">-<?php echo $admin_language['moreaction']; ?>-</option>
				<option value="1"><?php echo $admin_language['approve']; ?></option>
				<option value="2"><?php echo $admin_language['pending']; ?></option>
				</select>				

				</form>

					<?php 

				}
				else
				{
					?>
						<div class="fl no_data">
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>
			</div>
			<!-- failed end -->

		<?php }
		 else if($url_array[3]=='all') { ?>

			<!-- All requests starts -->
			<div class="menu_content all">	
			<?php 
						$query = "select username,requested_id,bid,amount,DATE_FORMAT(requested_date, '%b %d %Y %H:%i:%s') as requested_date,role_name,request_fund.status,request_fund.pay_status from request_fund left join coupons_users on request_fund.bid = coupons_users.userid left join coupons_roles on coupons_users.user_role=coupons_roles.roleid order by requested_id desc ";

			
			/*$pagination = new pagination();
			$pagination->createPaging($query,20);
			$resultSet = $pagination->resultpage;
			*/
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

			
				if(mysql_num_rows($resultSet)>0)
				{
				 ?>
				
					 <table cellpadding="10" cellspacing="0" width="650" border="1">
					 <tr>
					 <th><?php echo $admin_language['requeston']; ?></th>
					 <th><?php echo $admin_language['user']; ?></th>
					 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th> 
					 <th><?php echo $admin_language['status']; ?></th> 			
					 <th><?php echo $admin_language['transact']; ?></th>
					 </tr>
				
				<?php 
					while($row = mysql_fetch_array($resultSet))
					{ 
						?>
						<tr>
						<td><?php echo $row["requested_date"];?></td>
						<td><?php echo $row["username"];?> (<?php echo $row["role_name"];?>)</td>
						<td><?php echo round($row["amount"], 2);?></td>
						<td><?php 
						if($row["status"] == 1)
						{
							echo $admin_language['pending'];
						}
						else if($row["status"] == 2)
						{
							echo $admin_language['approved'];
						}
						else if($row["status"] == 3)
						{
							echo $admin_language['rejected'];	
						}
						?>
						</td>
						
						<td>
						<?php
						if($row["pay_status"] == 0) 
						{
						        if($row["status"] == 3)
                                                                echo $admin_language['rejected'];
						        else
							        echo $admin_language['awaitingforapproval'];
						}
						
						//Checked condition for payment status failed 						
						else if($row["status"] =='2' && $row['pay_status']=='2')
						{
							echo $admin_language['failed'];
						}
																								
						else
						{
							echo $admin_language['success'];
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
						<?php echo $admin_language['norequestavailable']; ?>
						</div>
					<?php 
				}
				?>

			</div>
			<!-- all requests end -->

		<?php }
		?>		


		<?php 
		$result = mysql_query($query);
			if($pages->rspaginateTotal>20) { ?>

			<table border="0" width="650" align="center" style="padding:5px;" class="mt5" cellpadding="5">
				<tr>
				<td align="center">
                <div class="pagenation">
				<?php echo $pages->display_pages(); ?>
                </div>
				</td>
				</tr>
			</table>

		<?php } ?>

	</div>
	

		<script type="text/javascript">
		function checkUncheckAll(theElement) 
		{
			 var theForm = theElement.form, z = 0;
			 for(z=0; z<theForm.length;z++)
			 {
				  if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
				  {
					theForm[z].checked = theElement.checked;
				  }
			 }
		}

		//approve
		function approve(rtype)
		{
			if(rtype == "pending")
			{
				var chks = document.getElementsByName('pending_req_list[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert("Please select at least one record!");
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm("Are you sure want to Pay?");				
				if(booSubmit == true)
				{
					document.pending_request.submit();
				}

			}
			else if(rtype == "failed")
			{
				var chks = document.getElementsByName('failed_list[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert("Please select at least one record!");
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm("Are you sure want to Pay?");				
				if(booSubmit == true)
				{
					document.failed_transaction.submit();
				}

			}
		}
	
		
		//approve request					
		function reject(rtype)
		{
			if(rtype == "pending")
			{
				var chks = document.getElementsByName('pending_req_list[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert("Please select at least one record!");
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm("Are you sure want to Reject?");				
				if(booSubmit == true)
				{
					document.pending_request.submit();
				}

			}
			else if(rtype == "failed")
			{
				var chks = document.getElementsByName('failed_list[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert("Please select at least one record!");
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm("Are you sure want to Reject?");				
				if(booSubmit == true)
				{
					document.failed_transaction.submit();
				}

			}
		}

		</script>

