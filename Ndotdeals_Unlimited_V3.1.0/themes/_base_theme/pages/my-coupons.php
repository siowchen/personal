<?php
is_login(DOCROOT."login.html"); //checking whether user logged in or not. 
include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>


<div class="work_bottom1 fl">
	<?php 
	report("mycoupon");
	?>
</div>
