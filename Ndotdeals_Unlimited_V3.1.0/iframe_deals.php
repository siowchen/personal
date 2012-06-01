<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

session_start(); 

include('system/includes/dboperations.php');
include('system/includes/config.php');
?>
<meta http-equiv="Content-Type" content="<?php echo $html_content_type; ?>" />
<?php
$affId = $_GET['id'];
$aCity = $_GET['city'];
$aLimit = $_GET['show'];
//echo $_SESSION['affId'];

//select the deal
$query = "SELECT * FROM coupons_coupons WHERE `coupon_status` = 'A' ";
$query .= " AND `coupon_city` = '{$aCity}'"; 
$query .= " AND coupon_startdate <= now() AND coupon_enddate > now()";
$query .= $aLimit? " LIMIT 0, {$aLimit} " : "";
$result = mysql_query($query);

if(mysql_num_rows($result) >= 1)
{
	while($row = mysql_fetch_array($result))
	{

        //$cname = str_replace(" ","-",strtolower($row['coupon_name']));
	$string = preg_replace("`\[.*\]`U","",html_entity_decode($row['coupon_name'], ENT_QUOTES));
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	$cname = strtolower(trim($string, '-'));

        $page_name = $cname.'_'.$row["coupon_id"];
	$current_amount = $row["coupon_value"] //current rate of deal
	?>	
	<div class="index" style="width:440px;float:left;clear:both;border:1px solid #ccc;padding:10px;">
	
              <p style="font:normal 12px arial;color:#000;width:300px;">
              <div class="img" style="float:left;width:400px;padding-bottom:10px">
                <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/system/modules/affiliate/xp.php?affiliate=<?php echo $affId;?>&city=<?php echo $row[coupon_city]; ?>&page=<?php echo $page_name;?>" target="_blank" sytle="text-decoration:none;">
                         <?php if(file_exists($row["coupon_image"]))
                                   {
                                   ?>
                        <img style="float:left;border:none;width:290px;" src="<?php echo $row[coupon_image];?>" />
                        <?php } 
                        else
                        { ?>
                        <img style="float:left;border:none;width:290px;" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" />
                        <?php } ?> 
                        <img style="float:right;border:none;" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/themes/<?php echo CURRENT_THEME; ?>/images/bg_buy.png" width="100px" height="55px"/>
                </a><br>
               <p style="margin-left:10px;width:100px;float:right;font:normal 15px arial;color:#000;"> <?php echo '<span style="font:bold 14px arial;color:#000;">Price</span> :'.CURRENCY.$current_amount;?></p></p></div>
                <p style="font:normal 14px arial;color:#000;width:400px;"><b><?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?></b></p>
                <p style="font:normal 14px arial;color:#000;width:400px;"> <?php echo html_entity_decode($row["coupon_description"], ENT_QUOTES);?></p>
                <p style="font:normal 14px arial;color:#000;width:400px;"><?php echo '<span style="font:bold 14px arial;color:#000;">Deals Expired Date</span> :'.$row["coupon_enddate"];?></p>
                <p style="font:normal 14px arial;color:#000;width:400px;"><?php echo '<span style="font:bold 14px arial;color:#000;">Minimum User Limit</span> :'.$row["coupon_minuserlimit"];?></p>
                <p style="font:normal 14px arial;color:#000;width:400px;"><?php echo '<span style="font:bold 14px arial;color:#000;">Maximum User Limit</span> :'.$row["coupon_maxuserlimit"];?></p>
                </div>
                
	<?php
	}
}
?> 

