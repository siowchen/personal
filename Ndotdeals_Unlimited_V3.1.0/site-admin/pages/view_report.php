<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>


<script type = "text/javascript">
/* validation */

$(document).ready(function(){$("#coupon_code_validate").validate();});

</script>

        <form name="coupon_code_validate" id="coupon_code_validate" action="" method="post" style="margin-left:10px;">
          <fieldset>
            <legend><span class="fwb"><?php echo $admin_language['validatecoupon']; ?></span></legend>
            
	   		<table border="0" cellpadding="5">
		             <input type="hidden" id="pid" value=""/>
			<tr>
			<td>
		            <input type="text" class="required" title="<?php echo $admin_language['enterthecouponcode']; ?>" name="vid" id="vid" value="" >
			</td>
			</tr>

			<tr>
			<td>
				<input type="submit" name="submit" value="<?php echo $admin_language['submit']; ?>">
				<input type="reset" value="<?php echo $admin_language['reset']; ?>">
			</td>
			</tr>

			</table>
          </fieldset>
        </form>

<?php 
//check the deal info by coupon code
if($_POST["submit"] == $admin_language['submit'])
{   

	if($_SESSION['userid']!="")
	{ 
		$ccode = $_POST['vid'];
	
		$queryString = "select * from coupons_purchase cp left join coupons_coupons c on c.coupon_id=cp.couponid where cp.coupon_validityid='".$ccode."' ";

		$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			while($row = mysql_fetch_array($resultSet))
			{
			
			   //validate in particular shop

				$user_shopid = $_SESSION["user_shopid"];
                                $transaction_id = $row["transaction_details_id"];
				if($row['coupon_shop']!=$user_shopid){

						set_response_mes(-1, $admin_language['couponcodeisinvalid']);
						url_redirect(DOCROOT."admin/couponvalidate");

				}
					 
			?>
			 <fieldset class="ml10 mt10">
            	<legend><span class="fwb"><?php echo $admin_language['dealinformation']; ?></span></legend>

				<table border="0" cellpadding="5">
				<form name="complete_verification" id="complete_verification" method="post">
				<tr>
				<td colspan="3">
				<p class="code_valid">
				<?php 
				if($row["coupons_userstatus"] == "U")
				{
					echo $admin_language['couponcodeisalreadyused'];
				}
				else
				{
					echo $admin_language['couponcodeisvalid'];
				}
				?>
				</p>
				</td>
				</tr>

				<tr>
				<td valign="top">
				<?php 
				if(!empty($row["coupon_image"]))
				{
				        if(file_exists(DOCUMENT_ROOT.'/'.$row["coupon_image"])) 
				        { ?>
					        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=125&height=125&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
            			<?php 
				        }
				        else
				        { ?>
					        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=125&height=125&cropratio=1:1&noimg=100&image=<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/no_image.jpg" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
			            <?php }
			        }
			        else
				        { ?>
					        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=125&height=125&cropratio=1:1&noimg=100&image=<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/no_image.jpg" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
			            <?php }
			        ?>
	
				</td>
				
				<td valign="top" style="width:360px;float:left;">
				<strong style="width:240px;float:left;"><?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?></strong>
				<p><?php echo substr(html_entity_decode($row["coupon_description"], ENT_QUOTES),0,350);?></p> <br />
				<strong class="font16">Coupon Code : <?php echo $row["coupon_validityid"];?></strong> 
				</td> 

				<td valign="top" style="width:100px;">
				<?php 
				        $coupon_value = $row["coupon_value"]; 
				?>		  
				<p><strong><?php echo $admin_language['price']; ?></strong> <?php echo CURRENCY;?><?php 
                                    if(ctype_digit($coupon_value)) { 
                                        echo $coupon_value;
                                    } 
                                    
                                    else { 
        
                                        $coupon_value = number_format($coupon_value, 2,',','');
                                        $coupon_value = explode(',',$coupon_value);
                                        echo $coupon_value[0].'.'.$coupon_value[1];
        
                                    }?></p>
				<p><strong><?php echo $admin_language['value']; ?></strong> <?php echo CURRENCY;?><?php 
                                    if(ctype_digit($row['coupon_realvalue'])) { 
                                        echo $row["coupon_realvalue"];
                                    } 					  
                              
                                        else { 
        
                                        $coupon_realvalue = number_format($row['coupon_realvalue'], 2,',','');
                                        $coupon_realvalue = explode(',',$coupon_realvalue);
                                        echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];
        
                                    }
                                    ?></p>
				<p><strong><?php echo $admin_language['discount']; ?></strong> <?php $discount = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]); echo round($discount); ?>%</p>
				<p><strong><?php echo $admin_language['yousave']; ?></strong> <?php echo CURRENCY;?><?php $value = $row["coupon_realvalue"] - $row["coupon_value"]; 
                              
                                    if(ctype_digit($value)) { 
                                        echo $value;
                                    } 					  
                              
                                        else { 
        
                                        $value = number_format($value, 2,',','');
                                        $value = explode(',',$value);
                                        echo $value[0].'.'.$value[1];
        
                                    }?></p>
				</td>
				</tr>
				<?php
				if($row["coupons_userstatus"] == "UN")
				{
				?>
				<tr><td colspan="3">
				<input type="hidden" name="coupon_code" value="<?php echo $row["coupon_validityid"];?>" />
				<input type="submit" name="complete_verification" value="<?php echo $admin_language['closecoupon']; ?>" class="width_auto">
				</td></tr>
				<?php
				}
				?>
				</form>
				</table>
				</fieldset>
				
			<?php 
			}
		}
		else
		{
			set_response_mes(-1, $admin_language['couponcodeisinvalid']);
			url_redirect(DOCROOT."admin/couponvalidate");
		}
	
	}
	else
	{
				set_response_mes(-1, $admin_language['pleaselogintoaccess']);
				url_redirect(DOCROOT."admin/login/");
	}  
	

}

//complete the verification
if($_POST["complete_verification"] == $admin_language['closecoupon'])
{
		$uid = $_SESSION['userid'];
		$coupon_code = $_POST["coupon_code"];

		if($coupon_code)
		{ 
			$queryString = "update  coupons_purchase set coupons_userstatus='U',coupons_user_useddate=now(),coupons_acceptedby=".$uid." where coupon_validityid='".$coupon_code."'";
			$resultset = mysql_query($queryString) or die(mysql_error());

			// send email to the users once close coupon
			
				$queryString2 = "SELECT  cu.firstname,cu.lastname,c.coupon_name,cp.coupon_validityid,cu.email FROM coupons_purchase cp left join coupons_users cu on cp.coupon_userid = cu.userid  left join coupons_coupons c on c.coupon_id=cp.couponid where cp.coupon_validityid = '$coupon_code'";
				$resultSet2 = mysql_query($queryString2);

				if(mysql_num_rows($resultSet2)>0)
				{
					while($row2=mysql_fetch_array($resultSet2))
					{
						$validityId = $row2['coupon_validityid'];
						$coupon_name = $row2['coupon_name'];								  
						$to = $row2['email'];
						$name = ucfirst($row2['firstname']).' '.ucfirst($row2['lastname']);
						$subject = $email_variables['close_offer_subject'];
						$subject = str_replace("COUPONNAME",ucfirst($coupon_name),$subject);
						$msg = $email_variables['close_offer_description'];
                                                $msg = str_replace("COUPONNAME",ucfirst($coupon_name),$msg);
                                                $msg = str_replace("VALIDITYID",$validityId,$msg);

						$from = SITE_EMAIL;
						$logo = DOCROOT."site-admin/images/logo.png";

						/* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */	
						$str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
		
						$str = str_replace("SITEURL",$docroot,$str);
						$str = str_replace("SITELOGO",$logo,$str);
						$str = str_replace("RECEIVERNAME",ucfirst($name),$str);
						$str = str_replace("MESSAGE",ucfirst($msg),$str);
						$str = str_replace("SITENAME",SITE_NAME,$str);        

						$SMTP_USERNAME = SMTP_USERNAME;
						$SMTP_PASSWORD = SMTP_PASSWORD;
						$SMTP_HOST = SMTP_HOST;
						$SMTP_STATUS = SMTP_STATUS;	

							$message = $str;

							if($SMTP_STATUS==1)
							{
	
								include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
							}
							else
							{
								// To send HTML mail, the Content-type header must be set
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// Additional headers
								$headers .= 'From: '.$from.'' . "\r\n";
								$headers .= 'Bcc: '.$to.'' . "\r\n";
								mail($from,$subject,$message,$headers);	
							}

					}
				}
	 
			   //end email

				
		   }
		 
		 	set_response_mes(1, $admin_language['yourcouponcodeverfcompleted']);
			url_redirect(DOCROOT."admin/couponvalidate");
	}
?>
