<?php 
is_login(DOCROOT."login.html"); //checking whether user logged in or not. 
?>	 

<?php include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>

<div class="work_bottom ">

<?php
	$userid = $_SESSION['userid'];

	$queryString = "SELECT r.cdate,u.firstname,u.lastname FROM referral_earning_details r left join coupons_users u on r.coupon_purchaser_userid = u.userid where r.earner_userid='$userid' and u.userid!=''";
//	echo $queryString; exit; 
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

if(mysql_num_rows($resultSet) > 0)
{
	$i = 1;
?>

		<table border="0" cellpadding="5" cellspacing="5">
		<tr style="font-weight:bold;">
		<td><?php  echo $language["s_no"]; ?></td>
		<td><?php  echo $language["purchaser_name"]; ?></td>		
		<td><?php  echo $language["purchased_date"]; ?></td>
		</tr>

		<?php
			while($row = mysql_fetch_array($resultSet))
			{
				$cdate = $row['cdate'];
				$firstname = html_entity_decode($row['firstname'], ENT_QUOTES);
				$lastname = html_entity_decode($row['lastname'], ENT_QUOTES);
		?>


				<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo ucfirst($firstname).' '.ucfirst($lastname); ?></td>
				<td><?php echo $cdate; ?></td>				
				</tr>

		
		<?php 
				$i++;
			}
		?>
		</table>     	
<?php
                        if($pages->rspaginateTotal>20) {
			echo '<table border="0" width="400" align="center">';
			echo '<tr><td align="center">';
			echo $pages->display_pages();
			echo '</td></tr>';
			echo '</table>';
                         }

}
else
{
?>
	<div class="no_data"><?php echo $language['no_referral']; ?></div>
<?php
}?>
     
</div>
