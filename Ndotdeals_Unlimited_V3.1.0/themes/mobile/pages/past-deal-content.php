<?php 
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/mobile_tabs.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/mobile_tabs.js" type="text/javascript"></script>

	<script type="text/javascript">
		document.getElementById('hrs').innerHTML='';
		document.getElementById('mins').innerHTML='';	
	</script>

        <div class="mobile_content">
        	<div class="content_inner">

   <?php 
    if(mysql_num_rows($result) == 0) 
    { ?>
              
         <div class="content">



		<?php echo $language['no_deals_avail']; ?>
        </div>
               
        <?php 
    }
    else
	{
		
		while($row = mysql_fetch_array($result))
		{
	
			
	
			//get the purchased coupon's count
			$purchased_count = $row["pcounts"];

	?>
	  
	
	

            	<div class="content_top">
			<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>
                </div>
                <div class="content_value">
                	<div class="content_values">
                        <div class="content_val">
                            <p>Price :</p>
                            <span><?php echo CURRENCY;?><?php $coupon_realvalue = $row['coupon_realvalue'];
										if(ctype_digit($coupon_realvalue)) { 
											echo $coupon_realvalue;
										} 
		
										else { 

											$coupon_realvalue = number_format($coupon_realvalue, 2,',','');
											$coupon_realvalue = explode(',',$coupon_realvalue);
											echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];

										}							
										?></span>
                        </div>
                        <div class="content_val">
                            <p>Discount :</p>
                            <span><?php $discount = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]); echo round($discount); ?>%</span>
                        </div>
                        <div class="content_val">
                            <p>Save :</p>
                            <span><?php echo CURRENCY;?><?php $value = $row["coupon_realvalue"] - $row["coupon_value"]; 
				  
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
                <div class="content_img">

			   <?php
			   if(file_exists($row["coupon_image"]))
			   {
			   ?>
				  <img src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
				  <?php 
			  }
			  else
			  {?>
				  <img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
																											  
			  <?php
			  }?>


                </div>
                <div class="content_share">
		 <?php
		$host = $_SERVER['HTTP_HOST'];
		$share_link = urlencode("http://".$host);
			
		?>
                	<div class="share_left">
                    	
                        <div class="share_icons">
                     

                        </div>
                    </div>
                    <div class="share_right">
               
                    	<p><?php echo CURRENCY;?><?php 	$coupon_value = $row["coupon_value"]; 
										if(ctype_digit($coupon_value)) { 
											echo $coupon_value;
										} 
		
										else { 

											$coupon_value = number_format($coupon_value, 2,',','');
											$coupon_value = explode(',',$coupon_value);
											echo $coupon_value[0].'.'.$coupon_value[1];

										}							
										?></p>
                        
                    </div>
                </div>
                <div class="high_menu">
                    	<ul>
                        <li><div class="tab_mid"><a href="javascript:;" id="dealdetails" class="active" title="Details">Details</a></div></li>
                        <li><div class="tab_mid"><a href="javascript:;" id="fineprints" title="The Fine Print">Fine Print</a></div></li>
                        <li><div class="tab_mid"><a href="javascript:;" id="contactdetails" title="Contact Details">Contacts</a></div></li>
                        <li><div class="tab_mid"><a href="javascript:;" id="reviews" title="Reviews">Map</a></div></li>
                        </ul>
                    </div>
                <div class="content_high dealdetails ">
                	

                    <div class="hich_desc">
		    <ul>

                     <li><?php echo nl2br(html_entity_decode($row["coupon_description"], ENT_QUOTES));?></li>

			<span id="generaldate"></span>
		   </ul>
                    </div>
                </div>
		
		 <div class="content_high fineprints ">
                	

                    <div class="hich_desc">
			<ul>
			<li>
	                     <?php echo nl2br(html_entity_decode($row["coupon_fineprints"], ENT_QUOTES));?>
			</li>
			</ul>		

                    </div>
                </div>

		 <div class="content_high contactdetails ">               	

                    <div class="hich_desc">
			<ul>
			<li>
	                   <h3>Contact Details</h3>
			   <div class="shop_detail fl clr">
		  
				
				  <table width="180" class="fl clr">
				  <?php
				  if(file_exists('uploads/logo_images/'.$row['shopid'].'.jpg')) 
				  {
				  ?>
				  <tr>
						<td colspan="2" align="center" valign="top">
								<img class="p2" src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.'uploads/logo_images/'.$row['shopid'].'.jpg'; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
						</td>
				  </tr>
				  <?php
				  }
				  ?>
				  <tr>
					  <td align="right" width="80" valign="top">
						<label><?php echo $language['shop_name']; ?> :</label>
					  </td>
					  <td align="left" width="120"> 
						<p><?php echo ucfirst(html_entity_decode($row["shopname"], ENT_QUOTES));?></p>
					  </td>
				  </tr>
				  
				  <tr>
					  <td align="right" valign="top" width="80">
						<label><?php echo $language['address']; ?> :</label>
					  </td>
					  <td align="left" width="120"> 
						<p><?php echo ucfirst(html_entity_decode($row["shop_address"], ENT_QUOTES));?></p>
					  </td>
				  </tr>

				  <tr>
					  <td align="right" width="80"> 
						<label><?php echo $language['city']; ?> :</label>
					  </td>
					  <td align="left" width="120">
						<p><?php echo ucfirst(html_entity_decode($row["cityname"], ENT_QUOTES));?></p>
					  </td>
				  </tr>
				  <tr>
					  <td align="right" width="80">
						<label><?php echo $language['country']; ?> :</label>
					  </td>
					  <td width="120"align="left"> 
						<p><?php echo ucfirst(html_entity_decode($row["countryname"], ENT_QUOTES));?></p>
					  </td>
				  </tr>

				  <?php
				  if(!empty($row['shop_url']))
				  {
				  ?>
				  <tr>
					  <td colspan="2">
						<label style="width:200px!important;float:left;"><?php echo $language['api_website']; ?> :</label>
					  </td>
				  </tr>

				  <tr>
					  <td colspan="2"> 
						<p style="width:200px!important;"><a style="width:100%!important;overflow:hidden;" href="<?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?>" target="_blank">
						<?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?></a></p>
					  </td>
				  </tr>
				  <?php
				  }
				  ?>


				  </table>
		         </div>
			</li>
			</ul>		

                    </div>
                </div>

		 <div class="content_high reviews ">
                	
                    <div class="hich_desc">
			<ul>
			<li>

			                    <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo html_entity_decode($row['shop_address'], ENT_QUOTES);?>&zoom=14&size=640x300&maptype=roadmap&markers=color:blue|label:S|<?php echo html_entity_decode($row['shop_latitude'], ENT_QUOTES);?>&lang=<?php echo html_entity_decode($row['hop_longitude'], ENT_QUOTES);?>&sensor=false" /> 
			</li>
			</ul>		

                    </div>
                </div>


	<?php 		

	
	}
}
?>

                <div class="high_menu2">
                    	<ul>
			    <li><a href="<?php echo DOCROOT;?>"><?php echo strtoupper($language["today"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>hot-deals.html"><?php echo strtoupper($language["hot"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>past-deals.html"><?php echo strtoupper($language["past_deals"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>contactus.html"><?php echo strtoupper($language["contact_us"]); ?></a></li>
                        </ul>
                </div>

            </div>
        </div>


