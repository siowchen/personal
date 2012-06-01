<?php 

/******************************************** 
 * @Created on October, 2011 * @Package: Ndotdeals unlimited v3.0

 * @Author: NDOT

 * @URL : http://www.NDOT.in

 ********************************************/

 ?>

<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/css/slider_screen.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 7]> <link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/css/slider_screenie7.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/nearbymap/map_easySlider1.7.js"></script>
<script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/nearbymap/jquery.googlemap.js"></script>	
<script type="text/javascript">
	$(document).ready(function(){	
		$("#slider").easySlider({		
		});			
	});	

</script>
<script type="text/javascript">
$(document).ready(function() {		
	//if close button is clicked
	$('.window .gmap_close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('.window').hide();

	});		
			
});
</script>
<!-- slide main div start herer -->
<div class="box window" >
	<div class="box_top"></div>
	<div class="box_middle">
	<div class="slider_content">  	
	<div id="slider_container" >
	<a href="#" class="gmap_close">x</a>
		
	      <?php

		//Select the coupons
		$queryString1 = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
			//add the city condition
			/*if($default_city_id)
			{
				$queryString1 .= "coupon_city = '$default_city_id' AND ";
			}*/
		if($post_cityname)
		{
			$queryString1 .= " coupon_city = '$post_cityname' AND ";
		}
		else
		{
			$queryString1 .= " coupon_city = '$default_city_id' AND ";
		}	

		$queryString1 .= " coupon_status = 'A' and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";
		$result1 = mysql_query($queryString1);

		if(mysql_num_rows($result1) > 0)
		{
			$i=0;
			$cnt = mysql_num_rows($result1);
		//slider show
		?>
   
	       <div id="slider" class="fl">
		    <ul id="slider_cont">
			
				<?php
				while($slider_value = mysql_fetch_array($result1))
				{           
				        $i++; 
				?>
		               <li style="background:#fff;">
				   
					<div class="fl">
					<a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($slider_value['deal_url']);?>_<?php echo $slider_value['coupon_id'];?>.html" >
					   <?php
					    if(file_exists($slider_value["coupon_image"]))
					    {
					    ?>
							<img  width="170" height="190" src="<?php echo DOCROOT.$slider_value['coupon_image']; ?>"/>
					    <?php
					    }
					    else
					    {
					    ?>
					       <img  width="170" height="190" src="<?php echo DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'; ?>"/>
					    <?php    
					    }  
					    ?>
					</a>
					</div>
			
						<!--Start Display coupon value -->		
						<div class="slider_middle">
							<a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($slider_value['deal_url']);?>_<?php echo $slider_value['coupon_id'];?>.html" >
							<h2> 
							
							 <?php
							  if(strlen($slider_value['coupon_name']) > 80)
							  {
							  echo substr(nl2br(html_entity_decode($slider_value['coupon_name'], ENT_QUOTES)),0,80).'......';
							  }
							  else
							  {
							  echo nl2br(html_entity_decode($slider_value['coupon_name'], ENT_QUOTES));
							  }
							  ?>

							</h2>
						     </a>
							
						   <div class="coupon_main_value">
					   		   <div class="coupon_content">
							       <div class="coupon_value"><p> <?php echo $language['value']; ?></p></div>
						               <div class="coupon_discount_value"><p><?php echo $language['discount']; ?></p></div>
						               <div class="coupon_save_value"><p><?php echo $language['you_save']; ?></p>
						   
						           </div>
						   </div>
						   <div class="coupon_content">
						 	<div class="coupon_value_val"><p>
								<?php echo CURRENCY;?><?php 

								    if(ctype_digit($slider_value['coupon_realvalue'])) { 
								        echo $slider_value["coupon_realvalue"];
								    } 					  
							      
								        else { 
		
								        $coupon_realvalue = number_format($slider_value['coupon_realvalue'], 2,',','');
								        $coupon_realvalue = explode(',',$coupon_realvalue);
								        echo $coupon_realvalue[0];
		
								    }
								    ?>
							  
								</p>
							</div>
							<div class="coupon_discount_val"><p>                            
							   <?php $discount = get_discount_value($slider_value["coupon_realvalue"],$slider_value["coupon_value"]); echo round($discount); ?>%
							    
							  </p>
							</div>
							<div class="coupon_save_val"><p><?php echo CURRENCY;?><?php $value = $slider_value["coupon_realvalue"] - $slider_value["coupon_value"]; 
							      
								    if(ctype_digit($value)) { 
								        echo $value;
								    } 					  
							      
								        else { 
		
								        $value = number_format($value, 2,',','');
								        $value = explode(',',$value);
								        echo $value[0];
		
								    }?></p>
							 </div>
						      </div>
				         
				   		   </div> 
                           <div class="view_purchase" >
                            <div class="view ml10 mt10">
                            <span class="view_left"></span>
                            <span class="view_mid"><a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($slider_value['deal_url']);?>_<?php echo $slider_value['coupon_id'];?>.html" ><?php echo $language['view_and_purchase']; ?></a></span>
                            <span class="view_right"></span>
                            </div>			    
						    </div>       
						</div>
				
			   
						    
					      	<!-- End Time-->
					           <!-- pass i incriment val -->
						   <span id="getaddress<?php echo $i; ?>" ></span>
								              

					</li>
					<?php
				}
				?>
		     </ul>   	

	   </div>

		     <?php
			}
		    else
			{
				echo $language['no_deals_avail'];
			}
		    ?>
	</div>
   </div>
 </div>
<div class="box_bottom"></div>
</div>

	
				
						
		


