<div class="user_profile">
<?php
//$user_id = $_REQUEST['sub1'];
$user_id = $url_arr[3];

$userDetails = mysql_query("SELECT * FROM coupons_users left join coupons_cities on coupons_users.city = coupons_cities.cityid left join coupons_country on coupons_country.countryid=coupons_users.country where coupons_users.userid='$user_id'");

if(mysql_num_rows($userDetails) > 0)
{
        while($row = mysql_fetch_array($userDetails))
        {
                ?>
                <fieldset class="field2">
                                <legend class="legend2"><?php echo $admin_language['user_details']; ?></legend>
                                <table cellpadding="0" cellspacing="0" class="user_table" >
                                <tr><td><?php echo $admin_language['username']; ?></td><td><?php echo html_entity_decode($row['username'], ENT_QUOTES);?></td></tr>
	                        <tr><td><?php echo $admin_language['firstname']; ?></td><td><?php echo html_entity_decode($row['firstname'], ENT_QUOTES);?></td></tr>
                             
	                        <tr><td><?php echo $admin_language['lastname']; ?></td><td><?php echo html_entity_decode($row['lastname'], ENT_QUOTES);?></td></tr>
                              
                                <tr><td><?php echo $admin_language['email']; ?></td><td><?php echo $row['email'];?></td></tr>
	                    
	                        <tr><td><?php echo $admin_language['mobile']; ?></td><td><?php echo $row['mobile'];?></td></tr>
                            
                                <tr><td><label for="dummy2"><?php echo $admin_language['address']; ?></td><td><?php echo html_entity_decode($row['address'], ENT_QUOTES);?></td></tr> 

				<?php if($row['user_role']!='4') { ?>   
                         
                                <tr><td><label for="dummy3"><?php echo $admin_language['paypalaccount']; ?></td><td><?php echo html_entity_decode($row['pay_account'], ENT_QUOTES); ?></td></tr>
           
                                <tr><td><?php echo $admin_language['countryname']; ?></td><td><?php echo html_entity_decode($row['countryname'], ENT_QUOTES);?></td></tr>

                                <tr><td><?php echo $admin_language['cityname']; ?></td><td><?php echo html_entity_decode($row["cityname"], ENT_QUOTES);?></td></tr>
				<?php } ?>

                                <tr><td><?php echo $admin_language['referalamount']; ?></td><td><?php echo CURRENCY.html_entity_decode($row["referral_earned_amount"], ENT_QUOTES); ?></td></tr>
                                <tr><td><?php echo $admin_language['user_status']; ?></td><td><?php echo $row["user_status"]; ?></td></tr>
                                <tr><td><?php echo $admin_language['referral_id']; ?></td><td><?php echo $row["referral_id"]; ?></td></tr>

				<?php if($row['user_role']!='4') { ?>                            

                                <tr><td><?php echo $admin_language['account_balance']; ?></td><td><?php echo CURRENCY.$row["account_balance"]; ?></td></tr>

				<?php } ?>

                                </table>

                </fieldset>
                <?php
                if($row['user_role'] == 3) //for shop admin
                {
                        $shopresultSet = mysql_query("SELECT * FROM coupons_users u left join coupons_shops s on s.shopid=u.user_shopid where userid='$user_id'");

		        if(mysql_num_rows($shopresultSet))
		        {
			        $shoprow=mysql_fetch_array($shopresultSet);
			        ?>
                                <fieldset class="field2">  
                                        <legend class="legend2"><?php echo $admin_language['shopdetails']; ?></legend>
                                        <table cellpadding="0" cellspacing="0" class="user_table">
	                                <tr>
	                                        <td>
	                                        <?php echo $admin_language['shopname']; ?></td><td>
	                                        <?php echo html_entity_decode($shoprow['shopname'], ENT_QUOTES);?>
	                                        </td>
	                                </tr>

	                                <tr>
	                                        <td>
	                                        <?php echo $admin_language['shopaddress']; ?>
	                                        </td>
	                                        <td>
	                                        <?php echo html_entity_decode($shoprow['shop_address'], ENT_QUOTES);?>
	                                        </td>
	                                </tr>

	                                <tr>
	                                        <td>
	                                        <?php echo $admin_language['googlemaplati']; ?>
	                                        </td>
	                                        <td>
	                                        <?php echo html_entity_decode($shoprow['shop_latitude'], ENT_QUOTES);?>
	                                        </td>
	                                </tr>
                                    
	                                <tr>
	                                        <td>
	                                        <?php echo $admin_language['googlemaplong']; ?>
	                                        </td>
	                                        <td>
	                                        <?php echo html_entity_decode($shoprow['shop_longitude'], ENT_QUOTES);?>
	                                        </td>
	                                </tr>

	                                <tr>
	                                <td>
	                                        <?php echo $admin_language['shopurl']; ?>
	                                        </td>
	                                        <td>
	                                        <?php echo html_entity_decode($shoprow['shop_url'], ENT_QUOTES);?>
	                                        </td>
	                                </tr>
	                                </table>
                                </fieldset>
                                <?php
		        }
                }
        }
}
else
{
 echo '<p class="nodata">No Data Available</p>';
}
?>
</div>
