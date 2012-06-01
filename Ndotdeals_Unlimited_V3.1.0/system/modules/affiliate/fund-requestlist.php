<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>
<div class="fl">
<!-- list of fund -->
<?php 
$query = "select * from request_fund where bid = '$uid' ";

$pagination = new pagination();
$pagination->createPaging($query,20);
$resultSet = $pagination->resultpage;


	if(mysql_num_rows($resultSet)>0)
	{
	 ?>
	
			 <table cellpadding="10" cellspacing="0" width="650" border="1">
			 <tr>
			 <th>Requested On</th>
			 <th>Amount(<?php echo CURRENCY;?>)</th> 
			 <th>Status</th> 			
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
			No request Available
			</div>
		<?php 
	}
	?>
	
	</div>
