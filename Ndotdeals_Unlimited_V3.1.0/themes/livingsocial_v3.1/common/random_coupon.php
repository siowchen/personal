<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.countdown.js" type="text/javascript"></script>
<?php //random coopons
$randomCoopon = get_random_coopon($default_city_id); 
?>

<!--great deals-->

<?php
		 if(mysql_num_rows($randomCoopon)>0)
		 {
			while($row = mysql_fetch_array($randomCoopon))
			{?>
<script type="text/javascript">
$(function () {
	// get coupon enddate
	var enddate = new Date('<?php echo date("D M d Y H:i:s", strtotime($row["coupon_enddate"])); ?>')
	
	//$('#times').countdown({since: startdate});
	$('#random_coupon_times_<?php echo $row["coupon_id"];?>').countdown({until: enddate , serverSync: function() { return new Date('<?php echo date("D M d Y H:i:s"); ?>'); }  ,layout: '{d<}{dn} {dl} {d>}{h<}{hn} {hl} {h>}{m<}{mn} {ml} {m>}{s<}{sn} {sl}{s>}',onExpiry: liftOff  });
	
	function liftOff()
	{

   	 	window.location = "<?php echo DOCROOT; ?>"; 
    		//alert('We have lift off!'); 
	} 

});
</script>
<div class="great_deals ">
		<div class="great_top">
				<h2>
						<?php
				if(strlen(html_entity_decode($row['coupon_name'], ENT_QUOTES)) > 50)
				{
				echo substr(nl2br(html_entity_decode($row["coupon_name"], ENT_QUOTES)),0,50),'....';
				}
				else
				{
				echo nl2br(html_entity_decode($row["coupon_name"], ENT_QUOTES));
				}
				?>
				</h2>
		</div>
		<div class="great_center">
				<div class="width227 fl clr borderF2F ml10">
						<div class="right_top">
								<div class="image">
										<a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
										<?php if(file_exists($row["coupon_image"])) { ?>
										<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=223&amp;height=166&amp;cropratio=1:1&amp;noimg=100&amp;image=<?php echo urlencode(DOCROOT.$row["coupon_image"]); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
										<?php }else{ ?>
										<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=223&amp;height=166&amp;cropratio=1:1&amp;noimg=100&amp;image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
										<?php }?>
										</a>
								</div>
								
						</div>
				</div>
				<div class="side_bot_cont fl clr">
				<div class="side_cont_timer fr">
				<div id="random_coupon_times_<?php echo $row['coupon_id'];?>" class="random_coupon" style="color:#FFFFFF;font: 12px/25px Arial,Helvetica,sans-serif;width:150px;">
				</div>
				</div>

				<div class="side_bot_cont_all fr clr">
				<div class="side_bot_cont_lft fl"></div>
				<div class="side_bot_cont_mid fl"><a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo $language['see_deals']; ?>"><?php echo $language['see_deals']; ?></a></div>
				<div class="side_bot_cont_rgt fl"></div>
				</div>
				</div>
		</div>		
		<div class="great_bottom fl clr"></div>
</div>
<?php        
			}
		}
		else
		{?>
	<div class="great_deals mb20 ">
		<div class="great_center">
				<div class="great_top">
						<h1><?php echo $language['featured']; ?></h1>
				</div>
				<div class="no_data1">
						<?php echo $language['no_deals_avail']; ?>
				</div>
		</div>
		<div class="great_bottom fl clr"></div>
	</div>
<?php 
		}
		?>

<!-- end of great deals -->
