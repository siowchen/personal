<?php /*?><ul>
<li><a href="/" title="Home"><?php echo $language['home']; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="Today Deals"><?php echo $language['today_deals']; ?></a></li>    
</ul>

<h1><?php echo $page_title; ?></h1>
<?php */?>
<?php 

//get the hot deals
getcoupons('T','',$default_city_id);

?>
