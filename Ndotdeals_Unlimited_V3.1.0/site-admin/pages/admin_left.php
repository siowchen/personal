<?php
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
if($_SESSION['userrole']=='1' || $_SESSION['userrole']=='2' || $_SESSION['userrole']=='3')
{
?>

	<?php
	if($_POST["site_mode"] == $admin_language['submit'])
	{ 
		$id = $_POST["id"];
		$site_in = $_POST['site_in'];
		$query = "update general_settings set site_in='$site_in' where id='$id'";
		mysql_query($query);
		set_response_mes(1,$admin_language['site_mode_change']);
		url_redirect($_SERVER['REQUEST_URI']);
	}
	?>

	<div class="menu_container">
				<!-- user info -->
                <div class="menu_user">
                    <div class="user_detail">
                    	<label><?php echo $admin_language['loginas']; ?></label>
                        <a href="<?php echo DOCROOT.'admin/profile/'; ?>" title="<?php echo ucfirst($_SESSION['username']); ?>" class="user_name"><?php echo ucfirst($_SESSION['username']); ?></a>
						
						
                        <div class="menu_buttons">
                        	<div class="fl"><div class="admi_lft fl"></div><a href="<?php echo DOCROOT.'admin/profile/'; ?>" class="admi_mid fl" title="<?php echo $admin_language['profile']; ?>"><?php echo $admin_language['profile']; ?></a><div class="admi_rgt fl"></div></div>
                            <div class="fl ml10"><div class="admi_lft fl"></div><a href="<?php echo DOCROOT.'admin/logout/'; ?>" class="admi_mid fl" title="<?php echo $admin_language['logout']; ?>"><?php echo $admin_language['logout']; ?></a><div class="admi_rgt fl"></div></div>
                        </div>
						
						<?php 
						$userid = $_SESSION["userid"];
						$get_bal_amount = mysql_query("select account_balance from coupons_users where userid='$userid'");
						if(mysql_num_rows($get_bal_amount)>0)
						{
						while($row = mysql_fetch_array($get_bal_amount))
						{
							$current_user_balance_amount = $row["account_balance"];
							
							if($_SESSION['userrole'] != '1')
							{
						?>
								<div class="fund_request mt10 fl">
								<label><?php echo $admin_language['balance']; ?> <?php echo CURRENCY;?> <?php echo $current_user_balance_amount;?></label>
								</div>
						<?php
							}
						 } 
						}
						?>
						
						
                    </div>
                    
                </div>
				<!-- user info end -->
				
                <ul>
			<?php if($_SESSION['userrole']=='1' || $_SESSION['userrole']=='2') {?>

					<!-- deal management -->
					<li onclick="toggle(104)">
						<div class="menu_lft"></div>
						<a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['deals_m']; ?>">
						<span class="fl deals_menu"><?php echo $admin_language['deals_m']; ?></span><img id="left_menubutton_104" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
						</a>
						
						<ul class="toggleul_104">
						<li>
						<div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/couponsupload/" title="<?php echo $admin_language['deals_add']; ?>"><span class="pl15 fl"><?php echo $admin_language['deals_add']; ?></span></a>
						</li>
	
						<li>
						<div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/all" title="<?php echo $admin_language['deals_all']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['deals_all']; ?></span>
						</a>
						</li>
	
						<li>
						<div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/active" title="<?php echo $admin_language['deals_active']; ?>"><span class="pl15 fl"><?php echo $admin_language['deals_active']; ?></span></a>
						</li>
	
						<li><div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/closed" title="<?php echo $admin_language['deals_closed']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['deals_closed']; ?></span></a></li>
						<li><div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/pending" title="<?php echo $admin_language['deals_pending']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['deals_pending']; ?></span></a></li>
						</ul>
					</li>
					<!-- deal management end -->				


					<!-- shop admin management -->
				    <li onclick="toggle(99)">
					<div class="menu_lft"></div>
					<a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['shopadmin']; ?>">
					<span class="merchant_menu fl"><?php echo $admin_language['merchant_m']; ?></span>
					<img id="left_menubutton_99" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
					</a>
                    
					<ul class="toggleul_99">
					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/reg/sa/" title="<?php echo $admin_language['addmerchacc']; ?>"><span class="pl15 fl"><?php echo $admin_language['addmerchacc']; ?></span></a>
					</li>
					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/shopadmin" title="<?php echo $admin_language['managemeracc']; ?>">	<span class="pl15 fl"><?php echo $admin_language['managemeracc']; ?></span>
					</a>
					</li>

					</ul>
					</li>
					<!-- shop admin management end -->
					
			<?php }
			?>
			
			<?php if($_SESSION['userrole']=='1') { ?>                
					
			<!-- transaction -->
			<li onclick="toggle(1005)">
				<div class="menu_lft"></div><a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['transaction_m']; ?>">
				<span class="trans_menu fl"><?php echo $admin_language['transaction_m']; ?></span>
				<img id="left_menubutton_1005" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" /></a>
			
				<ul class="toggleul_1005" >

					<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/transaction/all" title="<?php echo $admin_language['transaction_all']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['transaction_all']; ?> </span>
						</a></li>
		
						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/transaction/success" title="<?php echo $admin_language['transaction_success']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['transaction_success']; ?></span>
						</a></li>
		
						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/transaction/failed" title="<?php echo $admin_language['transaction_failed']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['transaction_failed']; ?></span>
						</a></li>				
						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/transaction/hold" title="<?php echo $admin_language['holdtransact']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['holdtransact']; ?></span>
						</a></li>
						
				 </ul>
				 
			</li>
			<!-- transaction list sub end -->
				
			<li onclick="toggle(1006)">
				<div class="menu_lft"></div><a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['transaction_withdraw']; ?>">
				<span class="trans_menu_1 fl"><?php echo $admin_language['transaction_withdraw']; ?></span>
				<img id="left_menubutton_1006" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" /></a>
			
				<ul class="toggleul_1006" >
								
						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/all" title="<?php echo $admin_language['transaction_fr_all']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_fr_all']; ?></span></a></li>

						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/approved" title="<?php echo $admin_language['transaction_fr_approved']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_fr_approved']; ?></span></a></li>

						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/rejected" title="<?php echo $admin_language['transaction_fr_rejected']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_fr_rejected']; ?></span></a></li>

						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/success" title="<?php echo $admin_language['transaction_fr_success']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_fr_success']; ?></span></a></li>

						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/failed" title="<?php echo $admin_language['transaction_fr_failed']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_fr_failed']; ?></span></a></li>

						<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-fund-request/pending" title="<?php echo $admin_language['newfundreq']; ?>"><span class="pl15 fl"><?php echo $admin_language['newfundreq']; ?></span></a></li>
				</ul>
				
				</li>
	
			<!-- transaction end -->

			<!-- city admin management -->
			<li onclick="toggle(103)">
				<div class="menu_lft"></div>
				<a class="menu_rgt"  href="javascript:;" title="City Admin">
				<span class="resel_menu fl"><?php echo $admin_language['reseller_m']; ?></span>
				<img id="left_menubutton_103" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
				</a>
			
				<ul class="toggleul_103">
				<li>
				<div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/reg/cm/" title="<?php echo $admin_language['createreseller']; ?>"><span class="pl15 fl"><?php echo $admin_language['createreseller']; ?></span></a>
				</li>
				<li>
				<div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/citymgr" title="<?php echo $admin_language['manageseller']; ?>"><span class="pl15 fl"><?php echo $admin_language['manageseller']; ?></span>
				</a>
				</li>

				</ul>
			</li>
			<!-- city admin management -->

		   <!-- User management -->
		   <li onclick="toggle(101)">
			   <div class="menu_lft"></div><a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['user']; ?>"><span class="users_menu fl"><?php echo $admin_language['user']; ?></span><img id="left_menubutton_101" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" /></a>
				<ul class="toggleul_101">
				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/general" title="<?php echo $admin_language['user']; ?>"><span class="pl15 fl"><?php echo $admin_language['user']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/fb_users" title="<?php echo $admin_language['fb_user']; ?>"><span class="pl15 fl"><?php echo $admin_language['fb_user']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/tw_users" title="<?php echo $admin_language['tw_user']; ?>"><span class="pl15 fl"><?php echo $admin_language['tw_user']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/admin" title="<?php echo $admin_language['users_admin']; ?>"><span class="pl15 fl"><?php echo $admin_language['users_admin']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/rep/all" title="<?php echo $admin_language['all']; ?>"><span class="pl15 fl"><?php echo $admin_language['all']; ?></span></a></li>

				</ul>
		  </li>
			<!-- user management end -->

			<li>
			<div class="menu_lft"></div>
			<a class="menu_rgt" href="<?php echo DOCROOT; ?>admin/rep/referral" title="<?php echo $admin_language['referraldetail']; ?>"><span class="refers_menu fl">
			<?php echo $admin_language['referraldetail']; ?></span></a>			
			</li>

			<!-- general settings -->
			<li onclick="toggle(4)">
				<div class="menu_lft"></div><a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['general']; ?>">
				<span class="general_menu fl"><?php echo $admin_language['general']; ?></span>
				<img id="left_menubutton_4" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
				</a>
				<ul class="toggleul_4">
				
				<li><div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/general/" title="<?php echo $admin_language['general_m']; ?>"><span class="pl15 fl"><?php echo $admin_language['general_m']; ?></span></a></li>

				<li><div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/social-media-account/" title="<?php echo $admin_language['social_media_account']; ?>"><span class="pl15 fl"><?php echo $admin_language['social_media_account']; ?></span></a></li>

				<li><div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/module/" title="<?php echo $admin_language['general_module']; ?>">
				<span class="pl15 fl"><?php echo $admin_language['general_module']; ?></span></a></li>
		
								
				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/sitemap/" title="<?php echo $admin_language['general_sitemap']; ?>"><span class="pl15 fl"><?php echo $admin_language['general_sitemap']; ?></span></a></li>
	
				
				
				<!--<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/database-backup.php" title="<?php echo $admin_language['databasebck']; ?>"><span class="pl15 fl"><?php echo $admin_language['databasebck']; ?></span></a>
				</li>-->
				
				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>add/country/" title="<?php echo $admin_language['country_add']; ?>"><span class="pl15 fl"><?php echo $admin_language['country_add']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/country/" title="<?php echo $admin_language['country_manage']; ?>"><span class="pl15 fl"><?php echo $admin_language['country_manage']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>add/city/" title="<?php echo $admin_language['city_add']; ?>"><span class="pl15 fl"><?php echo $admin_language['city_add']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/city/" title="<?php echo $admin_language['city_manage']; ?>"><span class="pl15 fl"><?php echo $admin_language['city_manage']; ?></span></a></li>
				
				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>add/category/" title="<?php echo $admin_language['addcategory']; ?>"><span class="pl15 fl"><?php echo $admin_language['addcategory']; ?></span></a></li>

				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/category/" title="<?php echo $admin_language['managecategory']; ?>"><span class="pl15 fl"><?php echo $admin_language['managecategory']; ?></span></a></li>				
				
			<li>
			<div class="menu_lft1"></div>
			<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/add-page/" title="<?php echo $admin_language['addpage']; ?>">
			<span class="pl15 fl"><?php echo $admin_language['addpage']; ?></span>
			</a>
			</li>

			<li>
			<div class="menu_lft1"></div>
			<a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/pages" title="<?php echo $admin_language['manpage']; ?>">
			<span class="pl15 fl"><?php echo $admin_language['manpage']; ?></span>
			</a>
			</li>

			<li>
			<div class="menu_lft1"></div>
			<a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/discussions" title="<?php echo $admin_language['mandiscussion']; ?>">
			<span class="pl15 fl"><?php echo $admin_language['mandiscussion']; ?></span>
			</a>
			</li>

			<li>
			<div class="menu_lft1"></div>
			<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/manage-api/" title="<?php echo $admin_language['manAPI']; ?>">
			<span class="pl15 fl"><?php echo $admin_language['manAPI']; ?></span></a>
			</li>

				
			</ul>
			</li>
			<!--  general settings end -->
			
			<!-- submit ticket -->
			<li>
			<div class="menu_lft"></div>
			<a class="menu_rgt" href="<?php echo DOCROOT; ?>admin/submit-ticket/" title="<?php echo $admin_language['subticket']; ?>">
			<span class="subtic_menu fl"><?php echo $admin_language['subticket']; ?></span></a>
			</li>
						
			<?php }?>

			
                        
			<?php
			//for city admin 
			
			if($_SESSION['userrole'] != '1' )
			{
				if($_SESSION['userrole'] == '2' )
				{
				?>
					<li>
					<div class="menu_lft"></div>
					<a class="menu_rgt" href="<?php echo DOCROOT; ?>admin/view/rep/shopadmin/" title="<?php echo $admin_language['shopadmdeal']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['shopadmdeal']; ?></span>
					</a>
					</li>
				<?php
				}
				?>
				
			 		<li onclick="toggle(5)">
					<div class="menu_lft"></div>
					<a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['transaction_fr']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['transaction_fr']; ?></span>
					<img id="left_menubutton_5" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
					</a>
                    
					<ul class="toggleul_5">
					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="/admin/fund-request/" title="<?php echo $admin_language['transaction_withdraw']; ?>"><span class="pl15 fl"><?php echo $admin_language['transaction_withdraw']; ?></span></a>
			                </li>
			                <li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="/admin/fund-request-report" title="<?php echo $admin_language['reqlist']; ?>"><span class="pl15 fl"><?php echo $admin_language['reqlist']; ?></span></a>
					</li>
					</ul>
		          	</li>
			<?php
			}
			
			?>	
			
			<?php 
			//shop admin
			if($_SESSION['userrole']=='3') {?>                                                     

					<li>
					<div class="menu_lft"></div>
					<a class="menu_rgt" href="<?php echo DOCROOT; ?>admin/couponvalidate" title="<?php echo $admin_language['validatecoupon']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['validatecoupon']; ?></span>
					</a>
					</li>	 

                    <li onclick="toggle(6)">
					<div class="menu_lft"></div>
					<a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['deals_m']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['deals_m']; ?></span><img id="left_menubutton_6" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
					</a>
                    
					<ul class="toggleul_6">
					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/couponsupload/" title="<?php echo $admin_language['deals_add']; ?>"><span class="pl15 fl"><?php echo $admin_language['deals_add']; ?></span></a>
					</li>

					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/all" title="<?php echo $admin_language['deals_all']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['deals_all']; ?></span>
					</a>
					</li>

					<li>
					<div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/active" title="<?php echo $admin_language['deals_active']; ?>"><span class="pl15 fl"><?php echo $admin_language['deals_active']; ?></span></a>
					</li>

					<li><div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/closed" title="<?php echo $admin_language['deals_closed']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['deals_closed']; ?></span></a></li>
					
	                </li>        

					<li><div class="menu_lft1"></div>
					<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/view/rep/pending" title="<?php echo $admin_language['deals_pending']; ?>">
					<span class="pl15 fl"><?php echo $admin_language['deals_pending']; ?></span></a></li>
					
	                </li>        
					
	                </li>        

				</ul>
			<?php }
			
			//shop admin end 
			?>
                
			<?php if($_SESSION['userrole']=='1') {
			?> 
                                <!-- Email & SMS marketing -->
                                
                                
                                <li onclick="toggle(12)">
                                        <div class="menu_lft"></div>
                                        <a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['email_sms']; ?>">
                                                <span class="email_menu fl"><?php echo $admin_language['email_sms']; ?></span>
			                        <img id="left_menubutton_12" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
			                </a>
			                <ul class="toggleul_12">
			                <li>
						<div class="menu_lft1"></div>
						<a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/daily-deals/" title="<?php echo $admin_language['dailymail']; ?>">
						<span class="pl15 fl"><?php echo $admin_language['dailymail']; ?></span></a>
					</li>
					<li>
					        <div class="menu_lft1"></div>
					        <a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/sendsms/" title="<?php echo $admin_language['smsuser']; ?>"><span class="pl15 fl"><?php echo $admin_language['smsuser']; ?></span></a>
					</li>
		                        <li>
		                                <div class="menu_lft1"></div>
		                                <a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/emailall/" title="<?php echo $admin_language['emailuser']; ?>"><span class="pl15 fl"><?php echo $admin_language['emailuser']; ?></span></a>
		                        </li>
					<li>
					        <div class="menu_lft1"></div>
					        <a class="menu_rgt1" href="<?php echo DOCROOT; ?>admin/newsletter/" title="<?php echo $admin_language['newsletter']; ?>"><span class="pl15 fl"><?php echo $admin_language['newsletter']; ?></span></a>
					</li>
				
                    
                    <li>
					        <div class="menu_lft1"></div>
					        <a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/subscriber/" title="<?php echo $admin_language['subscriber_list']; ?>"><span class="pl15 fl"><?php echo $admin_language['subscriber_list']; ?></span></a>
					</li>
                    
                     <li>
					        <div class="menu_lft1"></div>
					        <a class="menu_rgt1" href="<?php echo DOCROOT; ?>manage/mobile-subscriber/" title="<?php echo $admin_language['mobile_subscriber_list']; ?>"><span class="pl15 fl"><?php echo $admin_language['mobile_subscriber_list']; ?></span></a>
					</li>
                    
		                        </ul>
		               </li>
		               
                                <!-- Email & SMS marketing END-->			
			               
			
							
			<li onclick="toggle(7)"><div class="menu_lft"></div>
				<a class="menu_rgt"  href="javascript:;" title="<?php echo $admin_language['affiliate_m']; ?>">
				<span class="aff_menu fl"><?php echo $admin_language['affiliate_m']; ?></span>
				<img id="left_menubutton_7" src="<?php echo DOCROOT; ?>site-admin/images/plus_but.png" />
				</a>
                
				<ul class="toggleul_7">
		      	<li><div class="menu_lft1"></div>
				<a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/site-configuration.php" title="<?php echo $admin_language['siteconfig']; ?>"><span class="pl15 fl"><?php echo $admin_language['siteconfig']; ?></span></a></li>

		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/general-settings.php" title="<?php echo $admin_language['general_m']; ?>"><span class="pl15 fl"><?php echo $admin_language['general_m']; ?></span></a></li>

			
		      
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/commission-settings.php" title="<?php echo $admin_language['commissionsetting']; ?>"><span class="pl15 fl"><?php echo $admin_language['commissionsetting']; ?></span></a></li>
		      
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/admin-manager.php" title="<?php echo $admin_language['adminmanager']; ?>"><span class="pl15 fl"><?php echo $admin_language['adminmanager']; ?></span></a></li>
				
				<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/accounts.php" title="<?php echo $admin_language['accountmanager']; ?>"><span class="pl15 fl"><?php echo $admin_language['accountmanager']; ?></span></a></li>

		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/approval-accounts.php" title="<?php echo $admin_language['approveaccount']; ?>"><span class="pl15 fl"><?php echo $admin_language['approveaccount']; ?></span></a>
				</li>
				
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/commissions.php" title="<?php echo $admin_language['approvecommision']; ?>"><span class="pl15 fl"><?php echo $admin_language['approvecommision']; ?></span></a></li>
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/create-commission.php" title="<?php echo $admin_language['createcommision']; ?>"><span class="pl15 fl"><?php echo $admin_language['createcommision']; ?></span></a></li>
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/pay-affiliates.php" title="<?php echo $admin_language['payaffiliate']; ?>"><span class="pl15 fl"><?php echo $admin_language['payaffiliate']; ?></span></a></li>

<?php /*

		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/raising-fund.php" title="<?php echo $admin_language['raisingfund']; ?>"><span class="pl15 fl"><?php echo $admin_language['raisingfund']; ?></span></a></li>

*/ ?>
	
	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/current-commissions.php" title="<?php echo $admin_language['currentcommission']; ?>"><span class="pl15 fl"><?php echo $admin_language['currentcommission']; ?></span></a></li>
	
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/traffic-summary.php" title="<?php echo $admin_language['trafficsummary']; ?>"><span class="pl15 fl"><?php echo $admin_language['trafficsummary']; ?></span></a></li>
		      	
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/traffic-logs.php" title="<?php echo $admin_language['trafficlog']; ?>"><span class="pl15 fl"><?php echo $admin_language['trafficlog']; ?></span></a></li>
		      	
		      	<li><div class="menu_lft1"></div><a class="menu_rgt1" href="<?php echo DOCROOT_A; ?>admin/accounting-history.php" title="<?php echo $admin_language['accounthistory']; ?>"><span class="pl15 fl"><?php echo $admin_language['accounthistory']; ?></span></a>
				</li>                 
				</ul>
			  </li>   

                </ul>
                <?php }?>

<?php if($_SESSION['userrole']=='1') { 

	//get the general site information
	$query = "select * from general_settings limit 1";
	$result_set = mysql_query($query);
	if(mysql_num_rows($result_set))
	{
		$row2 = mysql_fetch_array($result_set);
	}

	?> 

                <div class="menu_user2">
                    <div style="width:220px;">
                    	<label class="fl clr"><?php echo $admin_language['sitemode']; ?></label>
                        <div class="fl clr">

        <form name="site_mode" id="site_mode" action="" enctype="multipart/form-data" method="post" class="fl clr">

		<p>
	          <input type="hidden" name="id" value="<?php echo $row2["id"];?>" />
	              			  <div class="fl clr form_cont">
              <input type="radio" class="fl ml10" name="site_in" value="1" <?php if($row2["site_in"] == 1) { ?> checked="checked" <?php } ?> /> <p class="fl ml10"><?php echo $admin_language['online']; ?></p>
			 
			  <input class="fl ml10" type="radio" name="site_in" value="2" <?php if($row2["site_in"] == 2) { ?> checked="checked" <?php } ?> /> <p class="fl ml10"><?php echo $admin_language['offline']; ?></p>
				</div>
	       </p>		

            <div class="fl clr site_but">
              <div class="go_lft fl"></div><div class="go_mid fl"><input name="site_mode" type="submit" value="<?php echo $admin_language['submit']; ?>" class="fl"></div><div class="go_rgt fl"></div>
            </div>

	</form>

                        </div>
		  </div>

	      </div>


<?php } ?>


            </div>
            
            
	<script type="text/javascript">
	function toggle(ids){
	
		$(".toggleul_"+ids).slideToggle();
		var imgSrc = document.getElementById("left_menubutton_"+ids).src;
		imgSrc = imgSrc.substr(-13, 13);
		if(imgSrc == "minus_but.png"){
			document.getElementById("left_menubutton_"+ids).src = "<?php echo DOCROOT; ?>site-admin/images/plus_but.png"
		}
		else{
			document.getElementById("left_menubutton_"+ids).src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"
		}	
		
	}
	</script>

<?php
}
else
{
	url_redirect(DOCROOT);	
}?>
