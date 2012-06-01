<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>


<!-- list of fund -->
<?php 
$uid = $_SESSION["userid"];
$query = "select * from request_fund where bid = '$uid' order by requested_id desc";

/*
$pagination = new pagination();
$pagination->createPaging($query,20);
$resultSet = $pagination->resultpage;
*/
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;

?>
<div class="deals_desc1"> 
<?php

	if(mysql_num_rows($resultSet)>0)
	{
	 ?>
	
			 <table cellpadding="0" cellspacing="0" class="coupon_report">
			 <tr class="fwb">
			 <td><?php echo $admin_language['requeston']; ?></td>
			 <td><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</td> 
			 <td><?php echo $admin_language['status']; ?></td>
			 <td><?php echo $admin_language['paymentstatus']; ?></td>			
			 </tr>
	
	<?php 
		while($row = mysql_fetch_array($resultSet))
		{ 
			?>
			<tr>
			<td><?php echo $row["requested_date"];?></td>
			<td><?php echo $row["amount"];?></td>
			<td>
			<?php 
			if($row["status"] == 1) 
			{
				echo $admin_language['pending'];
			}
			else if($row["status"] == 2)
			{
				echo $admin_language['approved'];
			}
			else
			{
				echo $admin_language['rejected'];
			}
			?>
			</td>
			<td>
			<?php 
			if($row["pay_status"] == 1) 
			{
				echo $admin_language['success'];
			}
			else if($row["status"] == 2)
			{
				echo $admin_language['failed'];
			}
			else
			{
			        echo '-';
			}
			?>
			</td>
			</tr>
			<?php 
		} ?>
		
		</table>
		<?php 
			if($pages->rspaginateTotal>20) { 
		echo '<table border="0" width="650" align="center" cellpadding="5">';
					echo '<tr><td align="center"><div class="pagenation">';
				        echo $pages->display_pages();
					echo '</div></td></tr>';
					echo '</table>';
        }
	}
	else
	{
		?>
			<p class="nodata"><?php echo $admin_language['nodata']; ?></p>
		<?php 
	}
	?>
</div>	
