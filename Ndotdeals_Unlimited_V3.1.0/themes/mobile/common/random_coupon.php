<?php //random coopons
$randomCoopon = get_random_coopon($default_city_id); 
?>

<!--great deals--> 
<div class="great_deals mb20 ">
	<div class="great_top">
	<h1><?php echo $language['featured']; ?></h1>
	</div>
	
	<div class="great_center">
		                          
		<?php
		 if(mysql_num_rows($randomCoopon)>0)
		 {
			while($row = mysql_fetch_array($randomCoopon))
			{?>                                  
				<div class="width227 fl clr borderF2F ml10">
				  <div class="right_top">

				  	<div class="image">

					<a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
								         
						<?php if(file_exists($row["coupon_image"])) { ?>
					    <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.$row["coupon_image"]); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
					    <?php }else{ ?>
					    <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
					    <?php }?>
								        
					</a>                                                                         
					</div>
								      
				      <div class="right_text">
					  <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo ucfirst(html_entity_decode($row['coupon_name'], ENT_QUOTES)); ?>">
					  <h2><?php echo ucfirst(html_entity_decode($row['coupon_name'], ENT_QUOTES)); ?></h2>
					  </a>

							<?php 
								$cooponamount = $row["coupon_value"]; 
							?>          
					  <p>
						  <strong class="fontb18 color83AF43">
							<?php 
								if(ctype_digit($cooponamount)) { 
										echo '<strong>'.CURRENCY.$cooponamount.'.00</strong>';							} 
							
								else { 

									$cooponamount = number_format($cooponamount, 2,',','');
									$cooponamount = explode(',',$cooponamount);
									echo '<strong>'.CURRENCY.$cooponamount[0].'.'.$cooponamount[1].'</strong>';

								}							
								?>								  
						  </strong>
						  
							(<?php echo $language["value"];?> 
							<span class="font20 color83AF43">
							<?php echo CURRENCY.$row['coupon_realvalue'];?>
							</span>)
					  </p>
					  
					  <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo $language['view_details']; ?>"><?php echo $language['view_details']; ?></a>
				      </div>
				      
				  </div>
				  </div>
		    <?php        
			}
		}
		else
		{?>
				<div class="no_data1">
				<?php echo $language['no_deals_avail']; ?>
				</div>
		<?php 
		}
		?>                                  
		                  
	</div>
<div class="great_bottom fl clr"></div>

</div>
<!-- end of great deals -->
