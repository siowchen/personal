<ul>
<li><a href="/" title="Home"><?php echo $language['home']; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="Search"><?php echo $language['search']; ?></a></li>    
</ul>

<?php 
$uri = $_SERVER['REQUEST_URI'];
$key = end(explode('=',$uri));

if($key)
{
	$key = str_replace("+"," ",$key);
?>
<h1>Deals in <?php echo $key; ?></h1>

<?php 
//get the deals by search
getcoupons('S',$key,$default_city_id);
}
else
{
	?>
    <div class="no_data">
    <?php echo $language['no_deals']; ?>
    </div>
    <?php 
}

?>
