<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<?php /*?><h1><?php echo $page_title; ?></h1><?php */ ?>

<?php
//get the hot deals
getcoupons('H','',$_SESSION['defaultcityId']);

?>
