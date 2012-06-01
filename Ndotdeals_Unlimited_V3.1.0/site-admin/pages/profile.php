<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$userid = $_SESSION['userid'];
$queryString = "SELECT * FROM coupons_users left join coupons_shops on coupons_shops.shopid=coupons_users.user_shopid left join coupons_cities on coupons_users.city=coupons_cities.cityid 
left join coupons_country on coupons_users.country=coupons_country.countryid 
where userid='$userid'";
$resultSet = mysql_query($queryString);

	while($row = mysql_fetch_array($resultSet))
	{
		$userid=$row['userid'];
		$username=html_entity_decode($row['username'], ENT_QUOTES);
		$firstname=html_entity_decode($row['firstname'], ENT_QUOTES);
		$lastname=html_entity_decode($row['lastname'], ENT_QUOTES);
		$email=html_entity_decode($row['email'], ENT_QUOTES);
		$mobile=html_entity_decode($row['mobile'], ENT_QUOTES);
		$user_role=$row['user_role'];
		$user_shopid=$row['user_shopid'];
		$address=ucfirst(nl2br(html_entity_decode($row['address'], ENT_QUOTES)));
		$city=$row['cityname'];
		$state=$row['state'];
		$country=$row['countryname'];
		$created_by=$row['created_by'];
		$created_date=$row['created_date'];
	}
?>

		<div class="ml50 fwb clr fr" style="padding-bottom:10px;">
		<a  href="<?php echo $docroot; ?>admin/edit/<?php echo getRoleNameUsrInfo($_SESSION['userrole']);?>/<?php echo $_SESSION['userid'];?>/" title="<?php echo $admin_language['dashboard_edit']; ?>"><?php echo $admin_language['dashboard_edit']; ?></a>&nbsp;&nbsp;
		<a   href="<?php echo $docroot; ?>admin/changepassword/<?php echo getRoleNameUsrInfo($_SESSION['userrole']);?>/<?php echo $_SESSION['userid'];?>/" title="<?php echo $admin_language['dashboard_change_pass']; ?>"><?php echo $admin_language['dashboard_change_pass']; ?></a>&nbsp;&nbsp; 

		</div>  

<!-- Dashboard -->
<?php
if($_SESSION['userrole'] == '1')
{
        //users
        $query1 = "select * from coupons_users where user_role = 4";
        $result1 = mysql_query($query1);
        
        //shops
        $query2 = "select s.shopname, s.shop_address, u.login_type, u.userid, u.username, u.firstname, u.lastname, u.email, u.mobile, u.user_role, r.role_name, u.created_by, u.user_status from coupons_users u, coupons_roles r, coupons_shops s where r.roleid=u.user_role and u.user_status in ('A','D') and user_role=3 and s.shopid=u.user_shopid";
        $result2 = mysql_query($query2);
        
        //city admin
        $query3 = "select * from coupons_users where user_role = 2";
        $result3 = mysql_query($query3);
        
        //API
        $query4 = "select * from api_client_details";
        $result4 = mysql_query($query4);
        
        //Affiliates
        $query5 = "select * from aff_affiliates";
        $result5 = mysql_query($query5);
        
        //Deals - active
        $query6 = "select * from coupons_coupons where coupon_status='A' and coupon_enddate >= now()";
        $result6 = mysql_query($query6);
        
        //Deals - closed
        $query7 = "select * from coupons_coupons where coupon_status='C' or coupon_enddate < now()";
        $result7 = mysql_query($query7);

        //Deals - pending
        $query8 = "select * from coupons_coupons where coupon_startdate > now() or (coupon_status='D' and coupon_enddate >= now())";
        $result8 = mysql_query($query8);
        
        //Deals - fund request
        $query9 = "select * from request_fund";
        $result9 = mysql_query($query9);
        
        //Deals - fund request
        $query10 = "select * from transaction_details";
        $result10 = mysql_query($query10);
        
        
        //Admin - Total savings and deals purchased
        $query11 = "select * from coupons_purchase_status";
        $result11 = mysql_query($query11);
        while($admin_saving = mysql_fetch_array($result11))
        {
                $coupons_purchased_count  = $admin_saving['coupons_purchased_count'];
                $coupons_amtsaved = $admin_saving['coupons_amtsaved'];
        }
        
        //Admin - savings
        $query11 = "select account_balance from coupons_users where userid='$userid'";
        $result11 = mysql_query($query11);
        while($admin_saving = mysql_fetch_array($result11))
        {
                $account_balance  = $admin_saving['account_balance'];
        } 
        
        //FUNDS TRANSFERRED
        
        //TO CITY ADMIN
        
        $query12 = "select sum(amount) as paid from request_fund where bid in (select userid from coupons_users where user_role='2') and pay_status=1";
        $result12 = mysql_query($query12);
        if(mysql_num_rows($result12) > 0)
        {
                while($CA_paid = mysql_fetch_array($result12))
                {
                        $CApaid  = $CA_paid['paid'];
                }
        }
        if(empty($CApaid))
        {
                $CApaid = 0;
        }
        
        
        //TO SHOP ADMIN
        
        $query12 = "select sum(amount) as paid from request_fund where bid in (select userid from coupons_users where user_role='3') and pay_status=1";
        $result12 = mysql_query($query12);
        if(mysql_num_rows($result12) > 0)
        {
                while($SA_paid = mysql_fetch_array($result12))
                {
                        $SApaid  = $SA_paid['paid'];
                }
        }
        if(empty($SApaid))
        {
                $SApaid = 0;
        }
        
        
        //TO AFFILIATE USERS
                
        $query13 = "select sum(commission) as paid from aff_payments";
        $result13 = mysql_query($query13);
        if(mysql_num_rows($result13) > 0)
        {
                while($GN_paid = mysql_fetch_array($result13))
                {
                        $GNpaid  = $GN_paid['paid'];
                }
        }
        if(empty($GNpaid))
        {
                $GNpaid = 0;
        }
         
        ?>       
        <fieldset class="field" style="margin-left:10px;">         
                <legend class="legend"><?php echo $admin_language['dashboard_title']; ?></legend>
                <div class="fl width240">
                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <?php echo $admin_language['dashboard_users']; ?>
	                </p>
                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/rep/general/" title="<?php echo $admin_language['dashboard_gusers']; ?>"><?php echo $admin_language['dashboard_gusers']; ?>(<?php if(mysql_num_rows($result1)>0){ echo mysql_num_rows($result1);}else{ echo '0';} ?>)</a>
		
	                </p>
                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
	                        <a  href="<?php echo DOCROOT; ?>admin/rep/shopadmin/" title="<?php echo $admin_language['shop']; ?>"><?php echo $admin_language['shop']; ?> (<?php if(mysql_num_rows($result2)>0){ echo mysql_num_rows($result2);}else{ echo '0';} ?>)</a>
	                </p>
	                
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/rep/citymgr/" title="<?php echo $admin_language['cityadmin']; ?>"><?php echo $admin_language['cityadmin']; ?> (<?php if(mysql_num_rows($result3)>0){ echo mysql_num_rows($result3);}else{ echo '0';} ?>)</a>
	                </p>
	                
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/manage-api/" title="<?php echo $admin_language['apiuser']; ?>"><?php echo $admin_language['apiuser']; ?>(<?php if(mysql_num_rows($result4)>0){ echo mysql_num_rows($result4);}else{ echo '0';} ?>)</a>
	                </p>
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>system/affiliate/admin/accounts.php" title="<?php echo $admin_language['affiliates']; ?>"><?php echo $admin_language['affiliates']; ?>(<?php if(mysql_num_rows($result5)>0){ echo mysql_num_rows($result5);}else{ echo '0';} ?>)</a>
	                </p>
	        </div>
                <div class="fl width240" >
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <?php echo $admin_language["deals_m"]; ?>
	                </p>
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/view/rep/active/" title="<?php echo $admin_language['active']; ?>"><?php echo $admin_language['active']; ?> (<?php if(mysql_num_rows($result6)>0){ echo mysql_num_rows($result6);}else{ echo '0';} ?>)</a>
	                </p>
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/view/rep/closed/" title="<?php echo $admin_language['deals_closed']; ?>"><?php echo $admin_language['deals_closed']; ?> (<?php if(mysql_num_rows($result7)>0){ echo mysql_num_rows($result7);}else{ echo '0';} ?>)</a>
	                </p>
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/view/rep/pending/" title="<?php echo $admin_language['pending']; ?>"><?php echo $admin_language['pending']; ?> (<?php if(mysql_num_rows($result8)>0){ echo mysql_num_rows($result8);}else{ echo '0';} ?>)</a>
	                </p>
	        </div>
	        <div class="fl width240">
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		               <?php echo $admin_language['transact']; ?>
	                </p>
	                 <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/manage-fund-request/all" title="<?php echo $admin_language['fundreq']; ?>"><?php echo $admin_language['fundreq']; ?> (<?php if(mysql_num_rows($result9)>0){ echo mysql_num_rows($result9);}else{ echo '0';} ?>)</a>
	                </p>
	                <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                <a  href="<?php echo DOCROOT; ?>admin/transaction/all/" title="<?php echo $admin_language['transact']; ?>"><?php echo $admin_language['transact']; ?> (<?php if(mysql_num_rows($result10)>0){ echo mysql_num_rows($result10);}else{ echo '0';} ?>)</a>
	                </p>
	        </div>
	        <div class="clr">
	                <div class="fl width240">
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                        <?php echo $admin_language['dashboard_transaction_summary']; ?>
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                        <?php echo $admin_language['myaccountbalance']; ?> <?php echo CURRENCY.$account_balance; ?>
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                        <?php echo $admin_language['totalcouponpurcharsed']; ?> <?php echo $coupons_purchased_count; ?>
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                        <?php echo $admin_language['totalamountsaved']; ?><?php echo CURRENCY.$coupons_amtsaved; ?>
	                        </p>
	                </div>
	                <div class="fl width240">
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                      <?php echo $admin_language['fundtransfer']; ?>  
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                       <?php echo $admin_language['cityadmin']; ?> :  <?php echo CURRENCY.$CApaid; ?>
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                        <?php echo $admin_language['shopadmin']; ?> : <?php echo CURRENCY.$SApaid; ?>
	                        </p>
	                        <p class="ml50 fwb width170" style="padding-bottom:10px;" >
		                       <?php echo $admin_language['affiliates']; ?> : <?php echo CURRENCY.$GNpaid; ?>
	                        </p>
	                </div>
	        </div>
        </fieldset>

        <?php
}

else if($_SESSION['userrole'] == '2')
{
        //my deals
        $query1 = "select * from coupons_coupons where coupon_createdby = '$userid'";
        $result1 = mysql_query($query1);
        
        //my shop admin
        $query2 = "select * from coupons_users where created_by = '$userid' and user_role = 3";
        $result2 = mysql_query($query2);
        
        //my shop admin deals
        $query3 = "select * from coupons_coupons where coupon_createdby in (select userid from coupons_users where created_by = '$userid' and user_role = 3)";
        $result3 = mysql_query($query3);
        
        //city admin - savings
        $query4 = "select account_balance from coupons_users where userid='$userid'";
        $result4 = mysql_query($query4);
        
        while($city_saving = mysql_fetch_array($result4))
        {
                $city_balance  = $city_saving['account_balance'];
        }
        
        //city admin - savings
        $query5 = "select sum(amount) as received from request_fund where bid='$userid' and pay_status=1";
        $result5 = mysql_query($query5);
        if(mysql_num_rows($result5)>0)
        {
                while($city_paid = mysql_fetch_array($result5))
                {
                        $city_received  = $city_paid['received'];
                }
        }
        if(empty($city_received))
        {
                $city_received = 0;
        }
        ?>
	         
        <fieldset class="field" style="margin-left:10px;">         
                <legend class="legend"><?php echo $admin_language['dashboard_title']; ?></legend>
                <p class="ml50 fwb" style="padding-bottom:10px;" >
		        <a  href="<?php echo DOCROOT; ?>admin/view/rep/all" title="<?php echo $admin_language['deals_m']; ?>"><?php echo $admin_language['deals_m']; ?> (<?php if(mysql_num_rows($result1)>0){ echo mysql_num_rows($result1);}else{ echo '0';} ?>)</a>
		
	        </p>
                <p class="ml50 fwb" style="padding-bottom:10px;" >
	                <a  href="<?php echo DOCROOT; ?>admin/rep/shopadmin/" title="<?php echo $admin_language['shopadmin']; ?>"><?php echo $admin_language['shopadmin']; ?> (<?php if(mysql_num_rows($result2)>0){ echo mysql_num_rows($result2);}else{ echo '0';} ?>)</a>
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		        <a  href="<?php echo DOCROOT; ?>admin/view/rep/shopadmin/" title="<?php echo $admin_language['shopadmindeals']; ?>"><?php echo $admin_language['shopadmindeals']; ?> (<?php if(mysql_num_rows($result3)>0){ echo mysql_num_rows($result3);}else{ echo '0';} ?>)</a>
		
	        </p>
	        
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		        <?php echo $admin_language['dashboard_account_information']; ?>
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		       <?php echo $admin_language['dashboard_fundsrecieved']; ?>  <?php echo CURRENCY.$city_received; ?>
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		       <?php echo $admin_language['dashboard_accountbalance']; ?>  <?php echo CURRENCY.$city_balance; ?>
	        </p>
        </fieldset>

        <?php
}
else if($_SESSION['userrole'] == '3')
{
        //my deals
        $query1 = "select * from coupons_coupons where coupon_createdby = '$userid'";
        $result1 = mysql_query($query1);
        
        //shop admin - savings
        $query2 = "select account_balance from coupons_users where userid='$userid'";
        $result2 = mysql_query($query2);
        
        while($shop_saving = mysql_fetch_array($result2))
        {
                $shop_balance  = $shop_saving['account_balance'];
        }


        
        //shop admin - savings
        $query3 = "select sum(amount) as received from request_fund where bid='$userid' and pay_status=1";
        $result3 = mysql_query($query3);
        if(mysql_num_rows($result3)>0)
        {
                while($shop_paid = mysql_fetch_array($result3))
                {
                        $shop_received  = $shop_paid['received'];
                }
        }
        if(empty($shop_received))
        {
                $shop_received = 0;
        }
        ?>
        
	         
        <fieldset class="field" style="margin-left:10px;">         
                <legend class="legend"><?php echo $admin_language['dashboard_title']; ?></legend>
                <p class="ml50 fwb" style="padding-bottom:10px;" >
		        <a  href="<?php echo DOCROOT; ?>admin/view/rep/all" title="<?php echo $admin_language['deals_m']; ?>"><?php echo $admin_language['deals_m']; ?>(<?php if(mysql_num_rows($result1)>0){ echo mysql_num_rows($result1);}else{ echo '0';} ?>)</a>
		
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		       <?php echo $admin_language['dashboard_account_information']; ?> 
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		       <?php echo $admin_language['dashboard_fundsrecieved']; ?> <?php echo CURRENCY.$shop_received; ?>
	        </p>
	        <p class="ml50 fwb" style="padding-bottom:10px;" >
		       <?php echo $admin_language['dashboard_accountbalance']; ?> <?php echo CURRENCY.$shop_balance; ?>
	        </p>
        </fieldset>

        <?php
}

?>
		
 <fieldset class="field" style="margin-left:10px;">         
        <legend class="legend"><?php echo $admin_language['dashboard_account_information']; ?></legend>
	<table border="0" cellpadding="5" align="left" class="padd form_table">

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_firstname']; ?></label></td>
	    <td><?php echo ucfirst($firstname);?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_lastname']; ?></label></td>
	    <td><?php echo ucfirst($lastname);?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_email']; ?></label></td>
	    <td><?php if($email!='') echo $email;  else echo '-'; ?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_mobile']; ?></label></td>
	    <td><?php if($mobile!='') echo $mobile;  else echo '-'; ?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_address']; ?></label></td>
	    <td><?php if($address!='') echo $address;  else echo '-'; ?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_city']; ?></label></td>
	    <td><?php if($city!='') echo $city;  else echo '-'; ?></td>
	  </tr>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_country']; ?></label></td>
	    <td><?php if($country!='') echo $country;  else echo '-'; ?></td>
	  </tr>

		<?php 
		if($_SESSION['userrole']!=1)
		{
		?>
			   <tr>
			    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_createdby']; ?></label></td>
			    <td><?php echo ucfirst(getUserName($created_by));?></td>
			  </tr>
		<?php
		} 
		?>

	   <tr>
	    <td valign="top" align="right" class="fwb"><label><?php echo $admin_language['dashboard_createddate']; ?></label></td>
	    <td><?php echo $created_date;?></td>
	  </tr>
	      
	</table>
  </fieldset>
  <?php
if($_SESSION['userrole'] == '2' || $_SESSION['userrole'] == '3')
{
        $queryString = "SELECT coupon_purchaseid,coupons_users.userid,coupons_shops.shopid FROM `coupons_purchase` left join coupons_coupons on coupons_coupons.coupon_id= coupons_purchase.couponid left join coupons_users on coupons_purchase.coupon_userid=coupons_users.userid left join coupons_shops on coupons_shops.shopid=coupons_coupons.coupon_shop where coupons_shops.shopid='".$_SESSION["userid"]."'";
$result = mysql_query($queryString);
$users_purchase_count = 0;
if(mysql_num_rows($result))
{

        while($row = mysql_fetch_array($result))
        {
                        $users_purchase_count = $row["coupon_purchaseid"];                
        }
}
}
else
{
        $queryString = "SELECT coupon_purchaseid,coupons_users.userid,coupons_shops.shopid FROM `coupons_purchase` left join coupons_coupons on coupons_coupons.coupon_id= coupons_purchase.couponid left join coupons_users on coupons_purchase.coupon_userid=coupons_users.userid left join coupons_shops on coupons_shops.shopid=coupons_coupons.coupon_shop";
$result = mysql_query($queryString);

$users_purchase_count = 0;
if(mysql_num_rows($result))
{
        while($row = mysql_fetch_array($result))
        {
             
                        $users_purchase_count = $row["coupon_purchaseid"];
        }
}

}
require_once("gChart.php");
?>
<div class="fl clr" style="width:710px;margin-left:35px;">
        <?php
        /*
        ?>
        <div class="fl" style="width:350px;">
       <?php
        $piChart = new gPieChart();
        $piChart->addDataSet(array($users_purchase_count));
        $piChart->setLegend(array("Users purchase count(".$users_purchase_count.")"));
        //$piChart->setLabels(array("Male", "Female"));
        //$piChart->setColors(array("DD127B", "FFF500"));
        //$piChart->setColors(array("DD127B"));
        ?>
        <img src="<?php print $piChart->getUrl();  ?>" /> 
        </div>
        <?php
        */
        ?>
        <?php
        if($_SESSION['userrole'] == '1')
        {
                ?>
                <div class="fl" style="width:350px;">
                        <?php
                        $shop_purchase = mysql_query("select coupons_shops.shopname,count(coupon_purchaseid) as pcount from  coupons_shops  left join coupons_coupons on  coupons_coupons.coupon_shop=coupons_shops.shopid left join coupons_purchase on coupons_purchase.couponid = coupons_coupons.coupon_id group by coupons_shops.shopname order by pcount desc") or die(mysql_error());
                        //$piChart = new gPieChart();
                        if(mysql_num_rows($shop_purchase))
                        {
                                while($row = mysql_fetch_array($shop_purchase))
                                {
						
                                        if(!empty($row["shopname"]))
                                        {
                                                $shop[] = $row["shopname"].' ('.$row["pcount"].')';
                                                if(!empty($row["pcount"]))
                                                $count[] = $row["pcount"];
                                                else
                                                $count[] = 0;
                                        }
                                        
                                }
                        }
                        $piChart2 = new gPieChart();
                        $piChart2->addDataSet($count);
                        $piChart2->setLegend($shop);
                        //$piChart->setLabels(array("Male", "Female"));
                        //$piChart->setColors(array("DD127B", "FFF500"));
                        ?>
                        <img src="<?php print $piChart2->getUrl();  ?>" /> 
                        <div class="fl" style="width:300px;text-align:center;margin-bottom:5px;"> <?php echo $admin_language['shop_sales']; ?></div>
                </div>
                <div class="fl" style="width:350px;">
                        <?php
                        $total_purchase = mysql_query("select * from transaction_details") or die(mysql_error());
                        //$piChart = new gPieChart();
                        $hold = $success = $failed = 0;
                        if(mysql_num_rows($total_purchase))
                        {
                                
                                while($row = mysql_fetch_array($total_purchase))
                                {
                               
                                        if(!empty($row["ID"]))
                                        {
                                                if($row['CAPTURED'] == 0 && $row['CAPTURED_ACK'] == '')
                                                {
                                                        $hold++;
                                                }
                                                else if($row['CAPTURED'] == 1)
                                                {
                                                        $success++;
                                                }
                                                else if($row['CAPTURED'] == 0 && $row['CAPTURED_ACK'] == 'Failed')
                                                {
                                                        $failed++;
                                                }
                                        }
                                        
                                }
                        }
                        $piChart3 = new gPieChart();
                        $piChart3->addDataSet(array($success, $hold, $failed));
                        $piChart3->setLegend(array($admin_language['success'].'('.$success.')', $admin_language['hold'].'('.$hold.')', $admin_language['failed'].'('.$failed.')'));
                        ?>
                        <img src="<?php print $piChart3->getUrl();  ?>" /> 
                        <div class="fl" style="width:300px;text-align:center;margin-bottom:5px;"> <?php echo $admin_language['transaction_status']; ?></div>
                </div>
                <?php
                
                
        }
        ?>
        
</div>
<div class="fl clr " style="width:771px;background:#CCC;">
        <div class="fl clr " style="width:280px;">
        <p style="font-size:14px;font-weight:bold;padding:10px;"><?php echo $admin_language['status'];?></p>
        </div>
        <div class="fl" style="width:280px;">
        <p style="font-size:14px;font-weight:bold;padding:10px;"><?php echo $admin_language['sales'];?></p>
        </div>
</div>
<div class="fl clr " style="width:750px;">
        <div class="fl clr " style="width:240px;">
                <?php
                        // Select total save amount
                        $total_savings = "select * from coupons_purchase_status";
			$total_savings_result = mysql_query($total_savings);
			while($total_saving_amt = mysql_fetch_array($total_savings_result))
			{
				$deals_sold = $total_saving_amt['coupons_purchased_count'];
				$coupons_total_amtsaved = $total_saving_amt['coupons_amtsaved'];
			}
                        
                        //Select coupon sold
                        $dealssoldquery = "select count(coupon_purchaseid) as deals_sold from coupons_purchase left join coupons_coupons on coupons_purchase.couponid=coupons_coupons.coupon_id";
                        if($_SESSION["userrole"] == '3')
                        {
                        $dealssoldquery .= " left join coupons_users on coupons_coupons.coupon_shop=coupons_users.user_shopid where coupons_users.userid = '".$_SESSION['userid']."'";
                        }
                        elseif($_SESSION["userrole"] == '2')
                        {
                        $dealssoldquery .= " left join coupons_users on coupons_coupons.coupon_shop=coupons_users.user_shopid LEFT JOIN coupons_shops ON coupons_shops.shopid = coupons_coupons.coupon_shop where coupons_shops.shop_createdby = '".$_SESSION['userid']."'";
                        }
                        $dealssoldresult = mysql_query($dealssoldquery) or die(mysql_error());
                        $dealssoldres = mysql_fetch_array($dealssoldresult);
                        $shop_deals_sold = $dealssoldres['deals_sold'];
                        
                         $payoutquery = "select account_balance, SUM(request_fund.amount) as payout from coupons_users left join request_fund on coupons_users.userid=request_fund.bid where coupons_users.userid = '".$_SESSION['userid']."'";
                         
                        $payoutresult = mysql_query($payoutquery) or die(mysql_error());
                        $payoutres = mysql_fetch_array($payoutresult);
                        $payout = round($payoutres['payout'],2);
                        $commission = round($payoutres['account_balance'],2);
                                    
                        $today = date('Y-m-d');
                        
                        $dealstodayquery = "select count(coupon_purchaseid) as deals_sold from coupons_purchase left join coupons_coupons on coupons_purchase.couponid=coupons_coupons.coupon_id  left join coupons_users on coupons_coupons.coupon_shop=coupons_users.user_shopid LEFT JOIN coupons_shops ON coupons_shops.shopid = coupons_coupons.coupon_shop where DATE(coupon_purchaseddate) = '$today'";
                        if($_SESSION["userrole"] == '3')
                        {
                         $dealstodayquery .= " and coupons_users.userid = '".$_SESSION['userid']."'";
                        }
                        elseif($_SESSION["userrole"] == '2')
                        {
                         $dealstodayquery .= " and coupons_shops.shop_createdby = '".$_SESSION['userid']."'";
                        }
                        $dealstodayresult = mysql_query($dealstodayquery) or die(mysql_error());
                        $dealstodayres = mysql_fetch_array($dealstodayresult);
                        $deals_sold_today= $dealstodayres['deals_sold'];
                        
                        //Admin - Total savings and deals purchased
			$total_saving_amount = "select SUM(AMT) as today_earning from transaction_details where DATE(TIMESTAMP) = '$today'";
			$total_saving_amount_res = mysql_query($total_saving_amount);
			$total_saving = mysql_fetch_array($total_saving_amount_res);
			$coupons_amtsaved = $total_saving['today_earning'];
			
				
                        if($_SESSION['userrole'] != '1')
                        {
                        ?>
                        <p><?php echo $admin_language['amount_from_payout'];?>: <?php echo $payout.CURRENCY; ?></p>
                        <?php
                        }
                        ?>
                        <p><?php echo $admin_language['balance'];?> : <?php echo $commission.CURRENCY; ?></p>
                        <p><?php 
                        if($_SESSION['userrole'] == '1')
                        {
                        echo $admin_language['totalamountsaved']; ?> <?php echo round($coupons_total_amtsaved,2).CURRENCY; 
                        }
                        ?></p>
                        <p><?php echo $admin_language['total_coupons_sold'];?> : 
                        <?php
		                if($_SESSION['userrole'] == '1')
		                { 
		                	echo $deals_sold; 
		                }
		                else
		                {
		                	echo $shop_deals_sold;
		                }
                        ?></p>
                        <p><?php echo $admin_language['coupons_sold_today']; ?> : <?php echo $deals_sold_today; ?></p>
                        <?php
                        if($_SESSION['userrole'] == '1')
                        {
                                ?><p><?php echo $admin_language['total_savings_today']; ?> : <?php echo round($coupons_amtsaved,2).CURRENCY; ?></p><?php
                        }
                        ?>
        </div>
        <div class="fl mt10" style="width:470px;"> 
        <div class="bar_graph fl" style="margin-bottom:5px;width:50px;"> <?php echo $admin_language['sales'];?></div>             
                <?php
               // $monthresult = mysql_query("SELECT COUNT(coupon_purchaseid) AS daycount, DATE(coupon_purchaseddate) as dat FROM coupons_purchase GROUP BY DATE(coupon_purchaseddate)");
               $dates = mysql_query("SELECT  DATE_FORMAT(NOW() ,'%Y-%m-01') as first_date,LAST_DAY(CURDATE()) as last_date") or die(mysql_error());
               while($date = mysql_fetch_array($dates))
               {
                        $firstdate = $date["first_date"];
                        $lastdate = $date["last_date"];
               }
                if($_SESSION['userrole'] == '3')
                {
                $monthresult = mysql_query("SELECT COUNT( coupon_purchaseid ) AS daycount, EXTRACT( 
DAY FROM coupon_purchaseddate ) AS dat
FROM coupons_purchase
LEFT JOIN coupons_coupons ON coupons_coupons.coupon_id = coupons_purchase.couponid
LEFT JOIN coupons_shops ON coupons_shops.shopid = coupons_coupons.coupon_shop
LEFT JOIN coupons_users ON coupons_users.user_shopid =  coupons_coupons.coupon_shop where coupons_users.userid='".$_SESSION['userid']."' and DATE(coupon_purchaseddate) between '$firstdate' and '$lastdate' and coupons_users.userid='".$_SESSION["userid"]."' GROUP BY DATE(coupon_purchaseddate) ") or die(mysql_error());
                }
                elseif($_SESSION['userrole'] == '2')
                {

                $monthresult = mysql_query("SELECT COUNT( coupon_purchaseid ) AS daycount, EXTRACT( 
DAY FROM coupon_purchaseddate ) AS dat
FROM coupons_purchase
LEFT JOIN coupons_coupons ON coupons_coupons.coupon_id = coupons_purchase.couponid
LEFT JOIN coupons_shops ON coupons_shops.shopid = coupons_coupons.coupon_shop
LEFT JOIN coupons_users ON coupons_users.user_shopid =  coupons_coupons.coupon_shop where coupons_shops.shop_createdby='".$_SESSION["userid"]."' and DATE(coupon_purchaseddate) between '$firstdate' and '$lastdate'  GROUP BY DATE(coupon_purchaseddate) ") or die(mysql_error());
                }
                else
                {
                
                    $monthresult = mysql_query("SELECT COUNT(coupon_purchaseid) AS daycount, EXTRACT(DAY FROM coupon_purchaseddate) as dat FROM coupons_purchase where DATE(coupon_purchaseddate) between '$firstdate' and '$lastdate' GROUP BY DATE(coupon_purchaseddate) ") or die(mysql_error());
                }
             
                $arr = array();
                if(mysql_num_rows($monthresult))
                {
                        while($res = mysql_fetch_array($monthresult))
                        {
                              $resultarray[$res["dat"]] = $res["daycount"];
                        }
                }
                $cnt = mysql_query("select EXTRACT(DAY from '$lastdate') as day");
                $rr = mysql_fetch_array($cnt);
                $cnt = $rr["day"];
                for($i = 1; $i <= $cnt; $i++)
                {
                        if(!empty($resultarray[$i]))
                                $arr[] = $resultarray[$i];
                        else
                                $arr[] = 0;
                }
                $barChart = new gBarChart(500,270);
                //$barChart-> addAxisRange(0, 0, 100);
		//$barChart-> addAxisRange(1, 0, 100);
                $barChart->addDataSet($arr);
                $barChart->setColors(array("3E832A"));
                $barChart->setVisibleAxes(array('y'));
                $barChart->setBarWidth(7,1);
                //$barChart->setAutoBarWidth();
                ?>
        
                <img src="<?php print $barChart->getUrl();  ?>" />
                <div class="clr fl bar_graph">
                <ul>
                <?php
                for($c = 1; $c <= $cnt; $c++)
                {
                        ?><li><?php echo $c; ?></li><?php
                }
                ?>
                </ul>   
                <p><?php 
                $mon = date("m");
                echo $mname = date( 'F', mktime(0, 0, 0, $mon) );?>-Daily</p>          
                </div>
        </div>
</div>



