<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<?php
	$result = $theme_q->home_q($default_city_id);
	$deal_type = $language['main_today'];		
	include($root_dir_path."deals_info_content.php"); //include the remaining content
?>
