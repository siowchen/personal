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

<h1 class="page_tit"><?php echo $page_title; ?></h1>


<div class="mobile_content">
      <div class="content_high">

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
          

		<table border="0" cellpadding="5" cellspacing="5" class="forms">

		<tr>
		<td align="left"><label><?php echo $language['username']; ?> :</label></td></tr><tr>
		<td><?php echo $username; ?></td>
		</tr>

		<tr>
		<td align="left"><label><?php echo $language['first_name']; ?> :</label></td></tr><tr>
		<td><?php echo ucfirst($firstname); ?></td>
		</tr>

		<tr>
		<td align="left"><label><?php echo $language['last_name']; ?> :</label></td></tr><tr>
		<td><?php echo ucfirst($lastname); ?></td>
		</tr>

		<tr>
		<td align="left"><label><?php echo $language['email']; ?> :</label></td></tr><tr>
		<td><?php echo $email; ?></td>
		</tr>
		
		<tr>
		<td align="left"><label><?php echo $language['mobile']; ?> :</label></td></tr><tr>
		<td><?php echo $mobile; ?></td>
		</tr>
		
		<tr>
		<td align="left" valign="top"><label><?php echo $language['address']; ?> :</label></td></tr><tr>
		<td><?php echo nl2br($address); ?></td>
		</tr>
		
		<tr>
		<td align="left" valign="top"><label><?php echo $language['referral_earned_amount']; ?> :</label></td></tr><tr>
		<td><?php if($referral_earned_amount>0) { echo CURRENCY.round($referral_earned_amount, 2); } else { echo '-'; } ?></td>
		</tr>
		
		
		
		<tr>
		<td align="left" valign="top"><label><?php echo $language['referral_link']; ?> :</label></td></tr><tr>
		<td><?php echo DOCROOT.'ref.html?id='.$referral_id; ?></td>
		</tr>
		
		</table>  



       
	</div>

                    <div class="high_menu2">
                    	<ul>
			    <li><a href="<?php echo DOCROOT;?>"><?php echo strtoupper($language["today"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>hot-deals.html"><?php echo strtoupper($language["hot"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>past-deals.html"><?php echo strtoupper($language["past_deals"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>contactus.html"><?php echo strtoupper($language["contact_us"]); ?></a></li>
                        </ul>
                    </div>

</div>
