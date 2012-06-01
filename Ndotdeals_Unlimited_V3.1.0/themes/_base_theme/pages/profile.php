<?php 

is_login(DOCROOT."login.html"); //checking whether user logged in or not. 

$userid = $_SESSION['userid'];

$queryString = "SELECT * FROM coupons_users where userid='$userid'";
$resultSet = mysql_query($queryString);
while($row = mysql_fetch_array($resultSet))
{
	$userid=$row['userid'];
	$username = html_entity_decode($row['username'], ENT_QUOTES);
	$firstname = html_entity_decode($row['firstname'], ENT_QUOTES);
	$lastname = html_entity_decode($row['lastname'], ENT_QUOTES);
	$email = $row['email'];
	$mobile = html_entity_decode($row['mobile'], ENT_QUOTES);
	$address = html_entity_decode($row['address'], ENT_QUOTES);
	$referral_id = $row['referral_id'];
	$referral_earned_amount = $row['referral_earned_amount'];			
}
?>	 

<?php include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>


<div class="work_bottom1 fl">
		
		<div class="pro">
		<table border="0" cellpadding="5" cellspacing="5" class="fl clr" width="500">

		<tr>
		<td align="right"><label><?php echo $language['username']; ?> :</label></td>
		<td><?php echo $username; ?></td>
		</tr>

		<tr>
		<td align="right"><label><?php echo $language['first_name']; ?> :</label></td>
		<td><?php echo ucfirst($firstname); ?></td>
		</tr>

		<tr>
		<td align="right"><label><?php echo $language['last_name']; ?> :</label></td>
		<td><?php echo ucfirst($lastname); ?></td>
		</tr>

		<tr>
		<td align="right"><label><?php echo $language['email']; ?> :</label></td>
		<td><?php echo $email; ?></td>
		</tr>
		
		<tr>
		<td align="right"><label><?php echo $language['mobile']; ?> :</label></td>
		<td><?php echo $mobile; ?></td>
		</tr>
		
		<tr>
		<td align="right" valign="top"><label><?php echo $language['address']; ?> :</label></td>
		<td><?php echo nl2br($address); ?></td>
		</tr>
		
		<tr>
		<td align="right" valign="top"><label><?php echo $language['referral_earned_amount']; ?> :</label></td>
		<td><?php if($referral_earned_amount>0) { echo CURRENCY.round($referral_earned_amount, 2); } else { echo '-'; } ?></td>
		</tr>
		
		<tr>
		<td align="right" valign="top"><label><?php echo $language['referral_link']; ?> :</label></td>
		<td><?php echo DOCROOT.'ref.html?id='.$referral_id; ?></td>
		</tr>
		
		</table>  
		  </div>    
		<div class="photo fl">
               <?php
               
               $filename='uploads/profile_images/'.$userid.'.jpg'; 
		       
		if (file_exists($filename)) 
		{?>
			     <img src="<?php echo $filename;?>" alt="<?php echo ucfirst($firstname); ?>" title="<?php echo ucfirst($firstname); ?>" width="75" height="75"  /> 
		<?php
		}
		else{
		?>
			     <img src="uploads/profile_images/photo_navailable.jpg" alt="" title="" width="75" height="75"  />  
		<?php
		}?>
		</div>
       
		</div>
