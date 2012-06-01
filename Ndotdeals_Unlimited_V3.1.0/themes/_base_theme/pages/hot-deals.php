<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<div class="bread_com">
<div class="bread_top"></div>
<div class="bread_mid">
<ul>
<li><a href="/" title="Home"><?php echo $language['home']; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="Hot Deals"><?php echo $language['hot']; ?></a></li>    
</ul>
</div>
<div class="bread_bottom"></div>
</div>

<?php /*?><h1><?php echo $page_title; ?></h1><?php */?>

<?php
//get the hot deals
getcoupons('H','',$default_city_id);

?>
