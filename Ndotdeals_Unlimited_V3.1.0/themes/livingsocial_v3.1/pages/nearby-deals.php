<?php 

/******************************************** 
 * @Created on October, 2011 * @Package: Ndotdeals unlimited v3.0

 * @Author: NDOT

 * @URL : http://www.NDOT.in

 ********************************************/

 ?>

<?php session_start(); ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo GMAP_API;?>" type="text/javascript"></script>	  
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/nearbymap/map_easySlider1.7.js"></script>
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/nearbymap/map-style.css" rel="stylesheet" type="text/css" media="screen" /> 
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/nearbymap/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/nearbymap/mappack.js"></script> 
<script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/nearbymap/jquery.googlemap.js"></script>

<!-- map inline style start here-->
<style type="text/css"> 
#mapInfoManual {
	float: left;
	color: #fff;
	font: bold 11px Helvitica, Arial, sans-serif;
	width:930px;
	background-color:#000;
	margin-left:10px;
	
	}
#mapInfoManual a {
	text-decoration:none;
	margin-left:5px;
	line-height:26px;
	color:#fff;
	}
#googMap {
  float:right;
  width:928px;
  height:400px;
  border: solid thin #fff;
  color:#000;
	}
#googMap a {
	color:#0000ff;
	}
	
.arrow{
	float:left;
	width:10px;
	height:10px;
	margin:4px 0px 0px 5px;
}	

.googControls {
  float:left;
  width:100%;
  height:30px;
  background-color:#000;
  margin-bottom:2px;
 
	}

.googPrint {
	float:right;
	text-align:right;
	}
p.infoWindowStreetAddress {
	color:#000; 
	font-size:11px;
	}
.detail-list{width:300px; height:auto; float: left; padding:0 10px;height:85px;}
.detail-list p{font-family:Arial, Helvetica, sans-serif; font-size:12px; color: #000000; line-height:18px;}
.detail-list a:hover{color:#137ee1; text-decoration: underline;}
.detail-list a{color:#137ee1; text-decoration: none; }
.coupon-list-container{width:960px; float:left; margin:12px 0;}
</style>
<!-- map inline style end here-->
<?php 
$_SESSION['coupon_cityid'] = $_SESSION['defaultcityId'];
      //add the city condition
	if($_POST['address'])
	{
		$getcityname = strtolower(trim($_POST['address']));
	}	
	else
	{
		$getcityname = $default_city_id;
	}
      $queryString_cityname = "select * from coupons_cities where status='A' and cityid='$getcityname'";
      $resultSet_cityname = mysql_query($queryString_cityname);
        while($row_cityname = mysql_fetch_array($resultSet_cityname))
	{
		$nearbycity = html_entity_decode($row_cityname['cityname'], ENT_QUOTES);
		$nearbycityid = $row_cityname['cityid'];
	}
?>
<div class="brad_com">
<ul>
<li><a href="<?php echo DOCROOT; ?>nearbymap.html" class="ml10" style="font:bold 14px Tahoma;color:#000;">Deals MAP - <?php echo $nearbycity; ?></a></li>
<li><a href="#" class="arrow"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/nearbymap/for_arow.png" /></a></li>
</ul>
</div>
<div class="google_mapcontent">
<div class="page"> 
	<?php 
	if($_POST)
	{
	
	$post_cityname = strtolower(trim($_POST['address']));
	$_SESSION['coupon_cityid'] = strtolower(trim($_POST['address']));
       	// Select Nearby deals 
	$deal_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where";			
		//add the city condition
		if(!$default_city_id)
		{
			$deal_list_query .= " coupon_city = '$post_cityname' AND ";
		}	
		else
		{
			$deal_list_query .= " coupon_city = '$default_city_id' AND ";
		}

	$deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";

	$result_set = mysql_query($deal_list_query);
	?>
	<?php
	if(mysql_num_rows($result_set) > 0)
	{
		$i = 0;
		?>
		<ul>
		        <?php
		        while($row = mysql_fetch_array($result_set))
		        {
		        //$cityid = html_entity_decode($row['cityname'], ENT_QUOTES);
		                $i++;
		                ?>
		               <li><a href="#" id="address<?php echo $i; ?>"></a></li>
		                <?php
		        }
		        ?>
		</ul>
		<?php
	}
	  	
		$queryString_city = "select * from coupons_cities where status='A'order by cityname asc";
		$resultSet_city = mysql_query($queryString_city);
		// check the conditon 
				$cityname = array();
		                while($select_cityname = mysql_fetch_array($resultSet_city))
                                {
					$cityname[] = strtolower(trim(html_entity_decode($select_cityname['cityid'], ENT_QUOTES)));
				}
				
					if(in_array($post_cityname,$cityname))
					{
						include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/dealload.php"); //include the remaining 
						?>
						<div id="mapInfoManual "></div>
						<?php 
					}
					else
					{
						set_response_mes(-1, $language['no_city_available']); 	
						url_redirect(DOCROOT.'nearbymap.html');	
					}?>
				
                  	
	<?php }
	else
	{
		?>
		<div id="mapInfoManual"></div>
		<?php
		include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/search_address.php"); //include the remaining content
	} 
	?>
	<div id="mapInfoManual"></div> 
</div>	

 <?php
 
	//Select all coupon list
	$coupon_query_list = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where";
			
	//add the city condition
	$coupon_cityname = $_SESSION['coupon_cityid'];
	if($coupon_cityname)
	{

		$coupon_query_list .= " coupon_city = '$coupon_cityname' AND ";
	}
	else
	{
		$coupon_query_list .= " coupon_city = '$default_city_id' AND ";
	}

	$coupon_query_list  .= " coupon_status = 'A' and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";
	$coupon_resultset = mysql_query($coupon_query_list);
 ?>
<div class="coupon-list-container">
<!-- coupon list -->
<div class="coupon_main_cat">
<?php
if(mysql_num_rows($coupon_resultset) > 0)
{
	$i = 0;
?>
    <?php
      while($coupon_value = mysql_fetch_array($coupon_resultset))
      {
       $lon = $coupon_value['shop_longitude'];
       $lat = $coupon_value['shop_latitude'];
	// incriment the i val deal order view the the popup
	$i++;
       ?>
	<div class="detail-list" >
    <div class="coupon_list" style="width:300px; float:left; margin-bottom:18px;" >
   
		<h3 style="font:bold 12px arial;color:#333;">
		 <?php
		  if(strlen($coupon_value['coupon_name']) > 100)
		  {
		  echo substr(nl2br(html_entity_decode($coupon_value['coupon_name'], ENT_QUOTES)),0,100).'...';
		  }
		  else
		  {
		  echo nl2br(html_entity_decode($coupon_value['coupon_name'], ENT_QUOTES));
		  }
		  ?>
		</h3>
		<a href="javascript:void(0);" id="view_address<?php echo $i; ?>" ><?php echo $language['view_on_map']; ?></a>
       
	</div>
 </div>

   <?php             
      }
      ?>
      
          <script type="text/javascript"> 
$(document).ready(function(){
	$('#mapInfoManual').imGoogleMaps({
		data_url: "<?php echo DOCROOT; ?>address.php?coupon_cityid=<?php echo $_SESSION['coupon_cityid']; ?>",
		data_type: 'json',
		map: 'googMap',
		//menu_class: 'googControls',
		//print_class: 'googPrint',
		mode: "manual",
		show_directions_menu: false,
		zoom_level: '5'
		//progress_bar:"http://192.168.1.12:1020/themes/green/images/loadingAnimation.gif"
	});

 
});
</script> 
      <?php
   }
  else
  {
  
  ?>

<div class="fl ml20">	<?php echo $language['no_deals_avail']; ?></div>
<script type="text/javascript"> 

$(document).ready(function(){

	$('#mapInfoManual').imGoogleMaps({
		address: "<?php echo $nearbycity; ?>",
		data_type: 'json',
		map: 'googMap',
		//menu_class: 'googControls',
		//print_class: 'googPrint',
		mode: "manual",
		show_directions_menu: false,
		zoom_level: '5'
		//progress_bar:"http://192.168.1.12:1020/themes/green/images/loadingAnimation.gif"
	});
 
});
</script> 
<?php 
  }
?>
</div>	 
</div>

</div>


