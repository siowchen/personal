<div class="header">

	<div class="header_in">
	
		<div class="fl">
		<a href="<?php echo DOCROOT; ?>" target="_blank" title="<?php echo SITE_NAME;?>" class="logo">
		<img src="<?php echo DOCROOT; ?>site-admin/images/logo.png" alt="<?php echo SITE_NAME;?>" /></a>
		</div>
		
		<?php if($_SESSION["userid"]) { ?>
		<div class="fr live_link">
			<div class="go_lft fl"></div>
            <a href="<?php echo DOCROOT; ?>" target="_blank" title="<?php echo SITE_NAME;?>" class="fl">
		<?php echo $admin_language['gotolive']; ?>
		</a>
        <div class="go_rgt fl"></div>
		</div>   
			
			<!-- coupon code valdate -->
			<?php if($_SESSION["userrole"] == 3) { ?>
			<div class="fr live_link mr-10">
				<div class="go_lft fl"></div>
				<a href="<?php echo DOCROOT; ?>admin/couponvalidate"  title="<?php echo $admin_language['validate_coupon_code']; ?>" class="fl">
			<?php echo $admin_language['validate_coupon_code']; ?>
			</a>
			<div class="go_rgt fl"></div>
			</div> 
			<?php } ?>  
		
		<?php } ?>
	
	</div> 
	
</div>
