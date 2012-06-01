<script type="text/javascript">
function forceclosecoupon(id,refid)
{	
	var sure=confirm("Are you sure want to close this Coupon?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/force_coupon_close.php?couponid='+id+'&refid='+refid;
	}

}
</script>
<?php
$current_url = explode('?',$_SERVER["REQUEST_URI"]);
if(isset($current_url[1]))
{
        $type = explode('=',$current_url[1]);
        if($type[0] == 'type' && !empty($type[1]))
        {
                $select = $type[1];
        }
}
$dealid = $_REQUEST['sub1'];
$user_role = $_SESSION['userrole'];

$queryString = "SELECT (
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.coupon_expirydate,c.coupon_enddate,c.coupon_description,cc.category_name as couponstype, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, space(5), u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,c.is_video,c.embed_code FROM coupons_coupons c left join coupons_category cc on cc.category_id=c.coupon_category left join coupons_users u on u.userid=c.coupon_createdby where c.coupon_id='$dealid'";
				
		//echo $queryString;
		$resultSet = mysql_query($queryString)or die(mysql_error());
		
            if(mysql_num_rows($resultSet)>0)
            {     
              $i=0;
              
                if($cdetails=mysql_fetch_array($resultSet))
                { 
		    
		    echo '<h1 class="inner_title fwb" style="padding:5px;">'.ucfirst(html_entity_decode($cdetails["coupon_name"], ENT_QUOTES)).'!</h1>'; 
		    echo '<div  class=" full_page_content">';
		    echo '<div  class="vclosed_coopen mt10">';
		    
		    echo '<div class="fontbold mb10" style="margin-left:5px;" >';
		    echo '<i class="fwb color666">';
		    echo "Category --- ".ucfirst(html_entity_decode($cdetails["couponstype"],ENT_QUOTES));
		    echo '</i>';
		    echo '</div>';  
	
	?>
	
    <div class="mt10 fl width780">

	<div class="fl clr" style='width:500px;'>
		<?php
                       if($cdetails['is_video'] == 1)
                       { 

				//get the video url
				$split_video = make_links(html_entity_decode($cdetails['embed_code'], ENT_QUOTES));
				$video_1 = explode("\"",$split_video); //print_r($video_1);
				?>
				<object width="420" height="285">
				<embed>					
				<iframe width="420" height="285" src="<?php echo $video_1[0]; ?>" frameborder="0" allowfullscreen>
				</iframe>
				</embed>
				</object>

			<?php
			} ?>

	</div>

		<div class="width430 fl"> <!-- left -->
			<?php 
			if($cdetails["coupon_image"]!='' && file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$cdetails["coupon_image"]))
			{
			
				echo '<img class="clr  borderE3E3E3" src="/'.$cdetails["coupon_image"].'" width="400"/>';
			}
			else
			{
				echo '<img src="'.$docroot.'themes/'.CURRENT_THEME.'/images/no_image.jpg" width="400" style="margin-top:20px;" />';
			}
			?>
	   </div> <!-- left -->
	  
	  <!-- right -->
	  <div class="width340 fl">
	  
		

					  <div class="discount_value mt-10 fl">
					  <span class="color333 font12 ml25 mt-10 fl"><?php echo $admin_language['couponvalue']; ?></span><br /><span class="color344F86 font18 ml25 fl clr"><?php echo CURRENCY;?><?php $coupon_value = $cdetails["coupon_value"]; 
							if(ctype_digit($coupon_value)) { 
								echo $coupon_value;
							} 
							
							else { 

								$coupon_value = number_format($coupon_value, 2,',','');
								$coupon_value = explode(',',$coupon_value);
								echo $coupon_value[0].'.'.$coupon_value[1];

							}							
							?></span>
					  </div>		
		
			  <div class="discount_value mt-10 fl">
			  <div class="timetop">
				  <div class="value">
				  <span class="color333 font12"><?php echo $admin_language['value']; ?></span><br /><span class="color344F86 font18"><?php echo CURRENCY;?><?php 
							if(ctype_digit($cdetails['coupon_realvalue'])) { 
								echo $cdetails["coupon_realvalue"];
							} 					  
					  
						        else { 

								$coupon_realvalue = number_format($cdetails['coupon_realvalue'], 2,',','');
								$coupon_realvalue = explode(',',$coupon_realvalue);
								echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];

							}
							?></span>
				  </div>
				  
				  <div class="Discount">
				  <span class="color333 font12"><?php echo $admin_language['discount']; ?></span><br /><span class="color344F86 font18"><?php $discount = get_discount_value($cdetails["coupon_realvalue"],$cdetails["coupon_value"]); echo round($discount); ?>%</span>
				  </div>
				  
				  <div class="Save">
				  <span class="color333 font12"><?php echo $admin_language['yousave']; ?></span><br /><span class="color344F86 font18"><?php echo CURRENCY;?><?php $value = $cdetails["coupon_realvalue"] - $cdetails["coupon_value"]; 
					  
							if(ctype_digit($value)) { 
								echo $value;
							} 					  
					  
						        else { 

								$value = number_format($value, 2,',','');
								$value = explode(',',$value);
								echo $value[0].'.'.$value[1];

							}?></span>
				  </div>
			  </div>
	   </div>

           <!-- Coupon Status-->
	   <p class="fl clr fwb">
	   <?php
	   echo $admin_language['status']; 
	   if($cdetails['coupon_enddate'] < date("Y-m-d H:i:s"))
	        echo ': CLOSED';
	   else if($cdetails["coupon_status"] == 'C')
	        echo ': CLOSED';
	   else if($cdetails["coupon_status"] == 'A' )
	        echo ': Active';     
	   else
	        echo ': PENDING';
	   ?>
	   </p>

<?php if(($cdetails['pcounts'] >0 && ($cdetails['pcounts'] < $cdetails["minuserlimit"])) && $cdetails['coupon_status']=='A' && $_SESSION['userrole']=='1') { ?>
	   
	   <!-- Force close-->
	   <p class="fl clr fwb">
	   <a href="javascript:;" title="<?php echo $admin_language['force_close']; ?>" onclick="forceclosecoupon('<?php echo $cdetails['coupon_id']; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')"><?php echo $admin_language['force_close']; ?></a>
	   </p>

<?php } ?>
	   
	  </div> <!-- right end -->
	  		
	</div>  	
	        

		   
 
    </div >
	</div>
  
    <p>
	<?php echo $admin_language['createdby']; ?>
	<?php  
	if(!empty($cdetails["name"]))
	{ 
		echo ucfirst(html_entity_decode($cdetails["name"], ENT_QUOTES));
	}
	else
	{ 
		echo ucfirst(html_entity_decode($cdetails["username"], ENT_QUOTES));
	}
	?>
    </p>
    <p><?php echo $admin_language['quantity']; ?>&nbsp;<?php echo $admin_language['target']; ?>&nbsp;:&nbsp;<?php  echo $cdetails["minuserlimit"]; ?></p>
    <p><?php echo $admin_language['quantity']; ?>&nbsp;<?php echo $admin_language['achieved']; ?>&nbsp;:&nbsp;<?php  echo $cdetails["pcounts"]; ?></p>
    <p><?php echo $admin_language['amount']; ?>&nbsp;<?php echo $admin_language['target']; ?>&nbsp;:&nbsp;<?php  echo $cdetails["minuserlimit"]*$cdetails["coupon_value"]; ?></p>
    <p><?php echo $admin_language['amount']; ?>&nbsp;<?php echo $admin_language['achieved']; ?>&nbsp;:&nbsp;<?php  echo $cdetails["pcounts"]*$cdetails["coupon_value"]; ?></p>
    
    <?php	
                }
             }
             else
             {
                        set_response_mes(-1,"Invalid coupon information");
                        url_redirect(DOCROOT."admin/view/rep/all");
             }
	?>

	 <div class="mt10 fl width780">

	 <h1 class="font18"><?php echo $admin_language['transactionlist']; ?></h1>
	<?php 
	
	//transaction list
	$query = "select ID,TIMESTAMP,CAPTURED_ACK, coupons_userstatus,REFERRAL_AMOUNT, coupon_validityid, coupons_users.userid, transaction_details.COUPONID, AMT, username, coupon_name, CAPTURED,L_QTY0 from transaction_details left join coupons_coupons on transaction_details.COUPONID = coupons_coupons.coupon_id left join coupons_users on transaction_details.USERID = coupons_users.userid left join coupons_purchase on coupons_purchase.transaction_details_id=transaction_details.ID where transaction_details.COUPONID = '$dealid' ";
	
	if($select == 'success')
	{
	        $query .= "and CAPTURED=1 ";
	}
	else if($select == 'hold')
	{
	        $query .= "and CAPTURED=0 and CAPTURED_ACK='' ";
	}
	else if($select == 'failed')
	{
	        $query .= "and CAPTURED=0 and CAPTURED_ACK='Failed' ";
	}
	$query .= "order by TIMESTAMP desc";
	
	
	/* GET TOTAL AMOUNT OF SUCCESS TRANSACTION */
	$success_query = "SELECT SUM(AMT) FROM transaction_details where transaction_details.COUPONID = '$dealid' and CAPTURED=1";
	$success_result = mysql_query($success_query);
	$success_amount = CURRENCY.round(mysql_result($success_result,0,0), 2);
	
	/* GET TOTAL AMOUNT OF HOLD TRANSACTION */
	$hold_query = "SELECT SUM(AMT) FROM transaction_details where transaction_details.COUPONID = '$dealid' and CAPTURED=0 and CAPTURED_ACK=''";
	$hold_result = mysql_query($hold_query);
	$hold_amount = CURRENCY.round(mysql_result($hold_result,0,0), 2);
	
	/* GET TOTAL AMOUNT OF FAILED TRANSACTION */
	$failed_query = "SELECT SUM(AMT) FROM transaction_details where transaction_details.COUPONID = '$dealid' and CAPTURED=0 and CAPTURED_ACK='Failed'";
	$failed_result = mysql_query($failed_query);
	$failed_amount = CURRENCY.round(mysql_result($failed_result,0,0), 2);
	
	/*$pagination = new pagination();
	$pagination->createPaging($query,20);
	$resultSet = $pagination->resultpage;*/
         
       	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($query);
	$resultSet = $pages->rspaginate;


	if(mysql_num_rows($resultSet)>0)
	{
	 ?>

	 <div class=" clr fr p5 mr-8">
			 <?php echo $admin_language['export']; ?> : <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=deals_transaction&deal_id=<?php echo $dealid; ?>" title="<?php echo $admin_language['all']; ?>"><?php echo $admin_language['all']; ?></a>, <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=deals_transaction&deal_id=<?php echo $dealid; ?>&status=success" title="<?php echo $admin_language['success']; ?>"><?php echo $admin_language['success']; ?></a>, <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=deals_transaction&deal_id=<?php echo $dealid; ?>&status=failed" title="<?php echo $admin_language['failed']; ?>"><?php echo $admin_language['failed']; ?></a>, <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=deals_transaction&deal_id=<?php echo $dealid; ?>&status=hold" title="<?php echo $admin_language['hold']; ?>"><?php echo $admin_language['hold']; ?></a>
	</div>

<?php

echo '<p class="clr" style="width:770px;color:#666;text-align:center;" class="fwb">'.$admin_language['note'].': UN - '.$admin_language['user_yet_to_use'].' <br/> U - '.$admin_language['user_used'].'</p>';

?>




			 <table cellpadding="10" width="97%" cellspacing="0" class="clr fl" style="border:1px; margin:0 5px;padding:5px 0;">
			 <tr>
			 <th width="100"><?php echo $admin_language['date']; ?></th>
			 <th><?php echo $admin_language['username']; ?></th>
			 <th><?php echo $admin_language['description']; ?></th>
			 <th><?php echo $admin_language['quantity']; ?></th>
			 <th><?php echo $admin_language['amount']; ?>(<?php echo CURRENCY;?>)</th>
			 <th><?php echo $admin_language['status']; ?></th>
			 <th>Coupon Code</th>
			 <th>Coupon Status</th>
                         <th>Referral AMT</th>
			 </tr>
	
	<?php 
		while($row = mysql_fetch_array($resultSet))
		{ 
			?>
			<tr>
			<td align="center" width="100"><?php echo $row["TIMESTAMP"];?></td>
			<td align="center"><?php echo $row["username"];?></td>
			<td align="left"><?php echo ucfirst(html_entity_decode($row["coupon_name"], ENT_QUOTES));?></td>
			<td align="center">1</td>
			<td align="center"><?php $amount = $row["AMT"]; if ($amount>0) { echo round($row["AMT"]/$row["L_QTY0"], 2);} else {echo $row["AMT"];}?></td>
			<td align="center"><?php 
			if($row["CAPTURED"] == 1)
			{
				?><a href="<?php echo DOCROOT; ?>admin/deal_report_view/<?php echo $dealid; ?>?type=success"><?php echo "Success"; ?></a><?php
			}
			else
			{
			        if($row["CAPTURED_ACK"] == 'Failed')
			        {
				        ?><a href="<?php echo DOCROOT; ?>admin/deal_report_view/<?php echo $dealid; ?>?type=failed"><?php echo "Failed"; ?></a><?php
				}
				else
				{
                                        ?><a href="<?php echo DOCROOT; ?>admin/deal_report_view/<?php echo $dealid; ?>?type=hold"><?php echo "Hold"; ?></a><?php
                                 }
			}	
				?></td>
		        <td align="center">
		        <?php
		        if(!empty($row["coupon_validityid"]))
		        {
		                echo $row["coupon_validityid"];
		        }
		        else
		        {
		                echo '-';
		        }
		        ?>
		        </td>
		        <td align="center"><?php echo $row["coupons_userstatus"];?></td>
			
                         
		        <td align="center"><?php echo $row["REFERRAL_AMOUNT"];?></td>
			</tr>
			<?php 
		} 
		 
		if(empty($select) || $select == 'success')
		{
		        ?>
		        <tr>
		        <td colspan="4" align="right"><?php echo $admin_language['successtransactionamount']; ?></td>
		        <td align="left">
		        <?php echo $success_amount; ?>
		        </td>
		        </tr>
		        <?php
		}
		if(empty($select) || $select == 'hold')
		{
		        ?>
		        <tr>
		        <td colspan="4" align="right"><?php echo $admin_language['holdtransactionamount']; ?></td>
		        <td align="left">
		        <?php echo $hold_amount; ?>
		        </td>
		        </tr>
		        <?php
		}
		if(empty($select) || $select == 'failed')
		{
		        ?>
		        <tr>
		        <td colspan="4" align="right"><?php echo $admin_language['failedtransactionamount']; ?></td>
		        <td align="left">
		        <?php echo $failed_amount; ?>
		        </td>
		        </tr>
		        <?php
		}
		if(empty($select))
		{
		        $sum = mysql_query("select SUM(AMT) as total_amount from transaction_details left join coupons_coupons on transaction_details.COUPONID = coupons_coupons.coupon_id left join coupons_users on transaction_details.USERID = coupons_users.userid where COUPONID = '$dealid'");
		        ?>
		        <tr>
		        <td colspan="4" align="right"><?php echo $admin_language['totaltransactionamount']; ?></td>
		        <td align="left"><?php 
		        while($row = mysql_fetch_array($sum)) { 
			        echo CURRENCY.round($row["total_amount"], 2);
		        } ?>
		        </td>
		        </tr>
		        <?php
		}
		?>
		</table>
                <?php
		if($pages->rspaginateTotal>20){ ?>

		<table border="0" width="650" align="center" cellpadding="5">
			<tr>
			<td align="center">
            	<div class="pagenation">
				<?php echo $pages->display_pages(); ?>
                </div>
			</td>
			</tr>
		</table>
		
		<?php }
	}
	else
	{
		?>
			<div class="no_data">
			<?php echo $admin_language['notransactionavailable']; ?>
			</div>
		<?php 
	}
	?>
	</div>
