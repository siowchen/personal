<?php 

/********************************************

 * @Created on December, 2011 * @Package: Ndotdeals unlimited v3.1

 * @Author: NDOT

 * @URL : http://www.NDOT.in

 ********************************************/

 ?>

<div class="con_top_top1"></div>
<div class="con_top_mid1"></div>
<div class="dealsnow_inner_center bottom_ndot_mid1">
  <?php
	$livedeal_url = $_SERVER['REQUEST_URI'];
	$split_url = explode('?', $livedeal_url);
	$category_values  = explode('&', $split_url[1]);
	foreach($category_values as $key=>$value)
	{
		$vals = explode('=',$value);
		$var = $vals[0];
		$$var=$vals[1];
	}
	// CurrentTime 
	$today = date('Y-m-d');
        $end_time = $today.' 23:59:59';
	?>
  <?php
/*******************/
if(!empty($_SESSION['defaultcityId']))
{
        $query_c = "select * from coupons_cities where cityid='".$_SESSION['defaultcityId']."'";
        $res = mysql_query($query_c);
        if(mysql_num_rows($res) > 0)
        {
                while($cr = mysql_fetch_array($res))
                {
                        $_SESSION['defaultcityname'] = $cr["cityname"];
			$_SESSION['default_city_url'] = $cr["city_url"];
                }
        }
}
/*******************/
?>
  <script src=" http://maps.google.com/?file=api&amp;v=2.x&amp;key=<?php echo GMAP_API;?>" type="text/javascript"></script>
  <script src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/dealsnow/extinfowindow.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/dealsnow/mappack.js"></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/dealsnow/jquery.googlemap.js"></script>
  <link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/dealsnow/screen.css" rel="stylesheet" type="text/css" media="screen" />
  <script type="text/javascript" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/dealsnow/easySlider1.7.js"></script>
  <script type="text/javascript"> 
initials("<?php echo DOCROOT; ?>","<?php echo CURRENT_THEME; ?>");//call the function in the  script file  jquery.googlemap.js on current theme
</script>
  <?php

/*******  step three *********/

if(!empty($category))
{
        $show_category = $category;
        
        if(empty($city_selected))
        {
                $city_selected = urldecode($address);
        }
        
        $category_query = "select * from coupons_category where status= 'A' and category_url='$show_category'";
        $category_result = mysql_query($category_query) or die(mysql_error());
        if(mysql_num_rows($category_result) > 0)
        {
                while($r = mysql_fetch_array($category_result))
                {
                        $category_id = $r['category_id'];
                        $category_name = $r['category_name'];
                        $category_url_info = $r['category_url'];
                }
        }
        else
        {
                 $category_id = '';
                 $category_name = '';
                 set_response_mes(-1, $language['no_categories_available']);
                 url_redirect(DOCROOT.'dealsnow.html?address='.$address);
        }
        $category_query = "select * from coupons_category where status= 'A'";
        $category_result = mysql_query($category_query) or die(mysql_error());
        
        
        $deal_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
        //add the city condition
        if($city_selected)
        {
	        $deal_list_query .= " ( city_url = '$city_selected' or shop_address like '%$city_selected%' ) AND ";
        }
        if(!empty($category_id))
        {
                $deal_list_query .= " coupon_category = '$category_id' AND ";
        }
        $deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now())) order by coupon_id desc";
        $result_set = mysql_query($deal_list_query) or die(mysql_error());
        if(mysql_num_rows($result_set) > 0)
        {
        
        
        ?>
      <script type="text/javascript"> 

        $(document).ready(function(){
	        $('#mapInfoManual').imGoogleMaps({
		        data_url: "<?php echo DOCROOT; ?>get_address.php?city=<?php echo $city_selected; ?>&category=<?php echo $category_id; ?>",
		       
		        data_type: 'json',
		        map: 'googMap2',
		        //menu_class: 'googControls',
		        //print_class: 'googPrint',
		        mode: "manual",
		        show_directions_menu: false,
		        zoom_level: '5'
		        //progress_bar:"http://192.168.1.7:1011/themes/livingsocial/images/loadingAnimation.gif"
	        });
         
        });
        
        </script>
  <?php
        }
        else
        {
        ?>
     <script type="text/javascript"> 

        $(document).ready(function(){

	        $('#mapInfoManual').imGoogleMaps({
	                address: '<?php if(!empty($default_city_id)){ echo urldecode($default_city_id); } else{echo $_SESSION["defaultcityname"];}?>',
		        map: 'googMap3',
		        //menu_class: 'googControls',
		        //print_class: 'googPrint',
		        mode: "manual",
		        show_directions_menu: false,
		        zoom_level: '5'
		        //progress_bar:"http://192.168.1.7:1011/themes/livingsocial/images/loadingAnimation.gif"
	        });
	        
         
        });
        </script>
  <?php
        }
        ?>
	<script type="text/javascript">         
		function load_category_deals(category_url)
		{
			window.location = '<?php echo DOCROOT; ?>dealsnow.html?category='+category_url;
		}
	</script>
<style type="text/css"> 
#mapInfoManual {
	float: left;
	color: #fff;
	font: bold 11px Helvitica, Arial, sans-serif;
	width:515px;
	height:700px;
	background-color:#000;
	margin:0px !important;
}
#mapInfoManual a {
	text-decoration:none;
	margin-left:5px;
	line-height:26px;
	color:#fff;
}
#googMap2 {
  float:right;
  width:515px;
  height:700px;
  border: solid thin #fff;
  color:#000;
}
#googMap2 a {
	color:#0000ff;
}
#googMap3 {
  float:right;
  width:515px;
  height:700px;
  border: solid thin #fff;
  color:#000;
}
#googMap3 a {
	color:#0000ff;
}
.googControls {
  float:left;
  width:100%;
  height:30px;
  background-color:#000;
  margin-bottom:2px;
  border: solid thin #fff;
}
.googControls ul {
	margin: 3px 0 0 3px;
	padding-left:0;
	float:left;
	display:block;
	width:200px;
	list-style:none;
}
.googControls li {
	display:inline;
	margin: 0 10px 0 0;
}
.googPrint {
	float:right;
	text-align:right;
}
p.infoWindowStreetAddress {
	color:#000; 
	width:300px;
	font:15px bold !important;
}
#extInfoWindow_coolBlues_contents{
background-color: #099;
color: #FFF;
}


</style>

<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#select_form").validate();});
</script>

  <div class="content">
    <div class="content_inner">
      <div class="inner_center">
        <div class="-work_bottom" style="padding-left:5px !important;">
          <div id="body">
            <div class="page">
              <div id="allmap"></div>
            </div>
          </div>
          <div class="live_deal_top">
            <form action="" method="get" id="select_form" name="select_form">
              <table cellpadding="0" cellspacing="0" width="900" class="fl">
                <tr>
                  <td width="200"><label><?php echo $language['select_category']; ?></label></td>
                  <td width="200"><label><?php echo $language['enter_location']; ?></label></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><?php
        // Get deal count 
        $cat_query = "select *,(select count(coupons_coupons.coupon_id) from coupons_coupons left join coupons_cities on coupons_cities.cityid=coupons_coupons.coupon_city where coupons_category.category_id=coupons_coupons.coupon_category and cityname='$city_selected' and coupon_status='A' AND coupon_startdate <= now() AND coupon_enddate > now() AND ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now()))) as ccount from coupons_category where coupons_category.status='A'";
        $result_set = mysql_query($cat_query);
         
        ?>
                    <span class="category fl"style="border-bottom:0px;" >
                    <select class="opt fl" name="category" -onchange="load_category_deals(this.value)" style="background:#FFF;">
                      <option value="">-Select-</option>
                      <?php
			if(mysql_num_rows($result_set) > 0)
			{
				while($row = mysql_fetch_array($result_set))
				{
				        ?>
				      <option value="<?php echo html_entity_decode($row['category_url'], ENT_QUOTES); ?>" <?php if($show_category == $row['category_url']){ echo 'SELECTED';}?>><?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?> (<?php echo $row['ccount']; ?> deals)</option>
				      <?php
				}
			}
			?>
                    </select>
                    </span> </td>
                  <td><span class="near fl">
                     <select class="opt3 required" name="address" id="address" title="<?php echo $language['select_the_city']; ?>">
			<option value=''>-select-</option>
			<?php
			$queryString_city = "select * from coupons_cities where status='A' order by cityname asc";
			$resultSet_city = mysql_query($queryString_city);
			if(mysql_num_rows($resultSet_city) > 0)
			{
				while($city_info = mysql_fetch_array($resultSet_city))
				{
				        ?><option value="<?php echo html_entity_decode($city_info['city_url'], ENT_QUOTES); ?>" <?php if($city_info['city_url'] == $city_selected || html_entity_decode($city_info["cityname"], ENT_QUOTES) == $city_selected){ echo 'SELECTED'; } ?>><?php echo ucfirst(html_entity_decode($city_info["cityname"], ENT_QUOTES)); ?></option><?php
				}
			}
			?>
			</select>
                    <!--<input type="text" class="live_text" name="address" value="<?php if(!empty($city_selected)){ echo $city_selected; } else{echo $_SESSION['defaultcityname'];}?>" style="width:291px;height:30px;"/>-->
                    </span> </td>
                  <td>
                  <div class="find">
                  	<div class="f_left"></div>
                    <div class="f_mid">
                     <input type="submit" value="<?php echo $language['find_deals']; ?>" class="bnone"/>
                     </div>
                     <div class="f_right"></div>
                     </div>
                  </td>
                </tr>
              </table>
            </form>
          </div>
          <div id="body">
            <div class="page">
              <div class="live_left">
         <?php                
        $deal_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where";
			
        //add the city condition
        if(!empty($city_selected))
        {
                $deal_list_query .= "( city_url = '$city_selected' or shop_address like '%$city_selected%') AND ";
        }
        else if($default_city_id)
        {
	        $deal_list_query .= " city_url = '$default_city_id' AND ";
        }
        if(!empty($show_category))
        {
                $deal_list_query .= " coupon_category = '$category_id' AND ";
        }
        //$deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";
        $deal_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now())) order by coupon_id desc";
        

        $result_set = mysql_query($deal_list_query);
        
        if(mysql_num_rows($result_set) > 0)
        {
                $i = 0;
                while($coupon = mysql_fetch_array($result_set))

                {
                $i++;
                ?>
                <div class="live_bor"  id="address<?php echo $i; ?>">
                  <div class="live_img">
                    <div class="img">
                      <?php
                                    	if(file_exists($coupon["coupon_image"]))
                                    	{
                       ?>
                      <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=100&height=90&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.$coupon["coupon_image"]); ?>" alt="<?php echo $coupon["coupon_name"];?>" title="<?php echo html_entity_decode($coupon["coupon_name"], ENT_QUOTES);?>" />
                      <?php
					}
					else
					{
			?>
                      <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=100&height=90&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo html_entity_decode($coupon["coupon_name"], ENT_QUOTES);?>" title="<?php echo html_entity_decode($coupon["coupon_name"], ENT_QUOTES);?>" />
                      <?php
					}
			?>
         <div class="stamp">
            <p>
              <script>document.write(String.fromCharCode("A".charCodeAt(0) + parseInt('<?php echo $i-1; ?>')));</script>
            </p>
          </div>
                    </div>
                  </div>
                  <div class="live_con">
                    <h2>
                         <?php
                         if(strlen($coupon['coupon_name']) > 75)
                          {
                          echo substr(nl2br(html_entity_decode($coupon['coupon_name'], ENT_QUOTES)),0,75).'...';
                          }
                          else
                          {
                          echo nl2br(html_entity_decode($coupon['coupon_name'], ENT_QUOTES));
                          }
                          ?>
                    </h2>
                    <div class="tdiscount mt10">
                      <div class="tabtimetop">
                        <div class="valuetab"> <span class="color000 fontb12"><?php echo $language['value']; ?></span><br />
                          <span class="color000 fontb12"><?php echo CURRENCY;?>
				<?php 
				if(ctype_digit($coupon['coupon_realvalue'])) 
				{ 
					echo $coupon["coupon_realvalue"];
				}   
				else 
				{ 
					$coupon_realvalue = number_format($coupon['coupon_realvalue'], 2,',','');
					$coupon_realvalue = explode(',',$coupon_realvalue);
					echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];
				}
				?>
                          </span> </div>
                        <div class="Discounttab"> <span class="color000 fontb12"><?php echo $language['discount']; ?></span><br />
                          <span class="color000 fontb12">
                          <?php $discount = get_discount_value($coupon["coupon_realvalue"],$coupon["coupon_value"]); echo round($discount); ?>
                          %</span> </div>
                        <div class="Savetab"> <span class="color000 fontb12"><?php echo $language['you_save']; ?></span><br />
                          <span class="color000 fontb12"><?php echo CURRENCY;?>

			<?php 
			$value = $coupon["coupon_realvalue"] - $coupon["coupon_value"]; 							          
				if(ctype_digit($value)) 
				{ 
				echo $value;
				} 
				else 
				{ 
				$value = number_format($value, 2,',','');
				$value = explode(',',$value);
				echo $value[0].'.'.$value[1];
				}
			?>
                          </span> </div>
                        <p>
				<?php 
				$start_time = getdate(date(strtotime($coupon['coupon_startdate'])));
				echo $start_time['mday'].date('S M', strtotime($coupon['coupon_startdate'])).'&nbsp;';
				echo ($start_time['hours']%12).strftime('%P', strtotime($coupon['coupon_startdate']));

				?>
		                  -
				<?php
				$end_time = getdate(date(strtotime($coupon['coupon_enddate'])));
				echo $end_time['mday'].date('S M', strtotime($coupon['coupon_enddate'])).'&nbsp;';
				echo ($end_time['hours']%12).strftime('%P', strtotime($coupon['coupon_enddate']));
				?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
        }
        else
        {
                ?>
                <div class="fl ml10" style="overflow:hidden;">
                  <h2><?php echo $language['no_deals_avail']; ?></h2>
                </div>
                <?php
        }
        ?>
              </div>
              <div class="live_right">
                <div id="mapInfoManual"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Step three end-->
<?php
}

else
{
?>
<?php
if(!empty($address))
{
?>
<style type="text/css"> 
	#mapInfoManual {
		float: left;
		color: #fff;
		font: bold 11px Helvitica, Arial, sans-serif;
		width:689px;
		background-color:#000;
	}
	#mapInfoManual a {
		text-decoration:none;
		margin-left:5px;
		line-height:26px;
		color:#fff;
	}
	#googMap {
	  float:left;
	  width:952px;
	 
	  height:700px;
	  border: solid thin #fff;
	  color:#000;
	}
	#googMap a {
		color:#0000ff;
	}
	/*.googControls {
	  float:left;
	  width:100%;
	  height:30px;
	  background-color:#000;
	  margin-bottom:2px;
	  border: solid thin #fff;
	}
	.googControls ul {display:none;
		margin: 3px 0 0 3px;
		padding-left:0;
		float:left;
		display:block;
		width:200px;
		list-style:none;
	}
	.googControls li {display:none;
		display:inline;
		margin: 0 10px 0 0;
	}
	.googPrint {display:none;
		float:right;
		text-align:right;
		display:none;
	}*/
	p.infoWindowStreetAddress {
		color:#000; 
		font-size:11px;
		width:300px;
	}
</style>
<script type="text/javascript"> 

$(document).ready(function(){
        $("#slider").easySlider({
		/*auto: true, 
		continuous: true,
		numeric: true*/
	});
	$('#mapInfoManual').imGoogleMaps({
	        address : "<?php echo $address;?>",
		map: 'googMap',
		mode: "manual",
		show_directions_menu: false,
		zoom_level: '7'
	});
	
	
	
});	
function load_category_deals(category_url)
{
        window.location = '<?php echo DOCROOT; ?>dealsnow.html?category='+category_url;
}
</script>
<!-- Step Two-->
<div id="live">
  <div class="live_top fl"> </div>
  <div class="live_middle">
    <div class="live_mid_top1">
      <form action="" method="get">
        <div class="search_1" >
         <select class="opt1" name="address">
        <option value=''>-select-</option>
        <?php
        $show_address = urldecode($address);
        $queryString_city = "select * from coupons_cities where status='A' order by cityname asc";
        $resultSet_city = mysql_query($queryString_city);
        if(mysql_num_rows($resultSet_city) > 0)
        {
                while($city_info = mysql_fetch_array($resultSet_city))
                {
                        ?><option value="<?php echo html_entity_decode($city_info['city_url'], ENT_QUOTES); ?>" <?php 
                        if($city_info['cityname'] == $_SESSION['defaultcityname'] || html_entity_decode($city_info["city_url"], ENT_QUOTES) == $address_name[1]){ echo 'SELECTED'; } ?>><?php  echo ucfirst(html_entity_decode($city_info["cityname"], ENT_QUOTES)); ?></option><?php
                }
        }
        ?>
        </select>
          <!--<input type="text" value="<?php echo urldecode($address); ?>" name="address" class="" style="border:none !important;background:none!important;"/>-->
        </div>
        <div class="find fl">
         	<div class="f_left"></div>
            <div class="f_mid">
             <input type="submit" value="<?php echo $language['find_deals']; ?>" class="bnone"/>
             </div>
             <div class="f_right"></div>
        </div>
      </form>
    </div>
    <div -id="body">
      <div -class="page">
        <div id="mapInfoManual"></div>
        <div id="list_img">
          <div class="list_top">
            <div class="list_top_lft fl"></div>
            <div class="list_top_mid1 fl"></div>
            <div class="list_top_rgt fl"></div>
          </div>
          <div class="list_mid">
            <h3><?php echo $language['i_would']; ?></h3>
		<?php
		$category_query = "SELECT * , (SELECT COUNT( coupon_id ) FROM coupons_coupons left join coupons_cities on coupons_coupons.coupon_city=coupons_cities.cityid left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid WHERE coupons_coupons.coupon_category = coupons_category.category_id and coupons_cities.city_url='".$address."' and coupon_status='A' and coupon_startdate <= now() and coupon_enddate > now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now()))) as deal_count FROM coupons_category WHERE STATUS = 'A'";
		$category_result = mysql_query($category_query) or die(mysql_error());
		if(mysql_num_rows($category_result) > 0)
		{
		?>
            <div class="loop">
              <div class="slider_content">
                <div id="slider_container">
                  <div id="slider" class="fl">
                    <ul id="slider_cont">
			<?php
			$i = 0;
			while($category = mysql_fetch_array($category_result))
			{

				if($i % 8 == 0)
				{
			?>
			<li id="<?php echo $i;?>">
			<?php
				}
			?>
                        <div class="image1">
                          <div class="img_top"></div>
                          <div class="img_mid">
				<?php
				       
				    	if(file_exists($category['category_image']))
				    	{
				?>
                            <a href="<?php echo DOCROOT; ?>dealsnow.html?category=<?php echo html_entity_decode($category['category_url'], ENT_QUOTES);?>&address=<?php echo $address; ?>"><img src="<?php echo DOCROOT; ?><?php echo html_entity_decode($category['category_image'], ENT_QUOTES);?>" width="142" height="112"/></a>
                               <?php
                                        }
                                        else
                                        {
                                ?>
                            <a href="<?php echo DOCROOT; ?>dealsnow.html?category=<?php echo html_entity_decode($category['category_url'], ENT_QUOTES);?>&address=<?php echo $address; ?>"><img src="<?php echo DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'; ?>" width="142" height="112"/></a>
                               <?php
                                        }   
                               ?>
                            <div class="bt_con"> <a href="<?php echo DOCROOT; ?>dealsnow.html?category=<?php echo html_entity_decode($category['category_url'], ENT_QUOTES);?>&address=<?php echo $address; ?>">
                              <h3><?php echo html_entity_decode($category['category_name'], ENT_QUOTES)?></h3>
                              </a> <a href="#"><?php echo $category['deal_count']; ?> Deals</a> </div>
                          </div>
                          <div class="img_bot"></div>
                        </div>
                 <?php
	                if($i % 8 == 7)
	                {
                 ?>
                      </li>
                 <?php
                                }
                        $i++;
                  }
                  ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
<?php
  }
?>
          </div>
          <div class="list_bot">
            <div class="list_bot_lft fl"></div>
            <div class="list_bot_mid1 fl"></div>
            <div class="list_bot_rgt fl"></div>
          </div>
          <div class="down1"></div>
        </div>
      </div>
    </div>
    <div class="live_bottom"></div>
  </div>
</div>
<!-- Step two end-->
<?php
}
else
{

?>
<style type="text/css"> 
	#mapInfoManual1 {
		float: left;
		color: #fff;
		font: bold 11px Helvitica, Arial, sans-serif;
		width:900px;
		background-color:#000;
		width:953px;
	    height:500px;
		margin-left:3px;
	}
	#mapInfoManual1 a {
		text-decoration:none;
		margin-left:5px;
		line-height:26px;
		color:#fff;
	}
	#googMap1 {
	  float:left;
	  margin-left:0px;
	  width:951px;
	  height:500px;
	  border: solid thin #fff;
	  color:#000;
	}
	#googMap1 a {
		color:#0000ff;
	}
	p.infoWindowStreetAddress {
		color:#000; 
		font-size:11px;
		width:300px;
	}
	#list_img{
	margin:-389px 0px 0px 80px;
	}
	
	#extInfoWindow_coolBlues{
  width: 233px;
}



</style>
<script type="text/javascript"> 

$(document).ready(function(){
	$('#mapInfoManual1').imGoogleMaps({
	    address : "<?php echo $_SESSION['defaultcityname'];?>",
		map: 'googMap1',
		mode: "manual",
		show_directions_menu: false
	});
	
	
 
});
function load_category_deals(category_url)
{
        window.location = '<?php echo DOCROOT; ?>dealsnow.html?category='+category_url;
}
</script>
<!-- Step one-->
<div id="live">
  <div class="live_top"></div>
  <div class="live_middle">
    <div class="live_mid_top"></div>
    <div -id="body">
      <div -class="page">
        <div id="mapInfoManual1"></div>
        <div id="list_img1">
          <div class="list_top1 1fl">
            <div class="list_top_lft fl"></div>
            <div class="list_top_mid fl"></div>
            <div class="list_top_rgt fl"></div>
          </div>
          <div class="list_mid1">
            <h2><?php echo SITE_NAME.$language['deals_here']; ?></h2>
            <h3><?php echo $language['find_great_local_deal']; ?></h3>
            <div class="live_mid_top">
              <form action="" method="get" name="find_deals_one">
                <div class="search_1">
                 <!-- <input type="text" value="<?php echo $_SESSION['defaultcityname'];?>" name="address" class="txt"  style="border: medium none !important;background:none;"/>-->
                 <select class="opt1" name="address" value="<?php echo $_SESSION['defaultcityname'];?>">
			<option value=''>-select-</option>
			<?php
			$queryString_city = "select * from coupons_cities where status='A' order by cityname asc";
			$resultSet_city = mysql_query($queryString_city);
			if(mysql_num_rows($resultSet_city) > 0)
			{
				while($city_info = mysql_fetch_array($resultSet_city))
				{
				        ?><option value="<?php echo html_entity_decode($city_info['city_url'], ENT_QUOTES); ?>" <?php if($city_info['city_url'] == $city_selected || html_entity_decode($city_info["cityname"], ENT_QUOTES) == $_SESSION['defaultcityname']){ echo 'SELECTED'; } ?>><?php echo ucfirst(html_entity_decode($city_info["cityname"], ENT_QUOTES)); ?></option><?php
				}
			}
			?>
			</select>
                </div>
                <div class="find_stepone fl clr">
               	<div class="f_left"></div>
                <div class="f_mid">
                 <input type="submit" value="<?php echo $language['find_deals']; ?>" class="bnone"/>
                 </div>
                 <div class="f_right"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="list_bot1 fl">
            <div class="list_bot_lft fl"></div>
            <div class="list_bot_mid fl"> </div>
            <div class="list_bot_rgt fl"></div>
          </div>
          <div class="down"></div>
        </div>
      </div>
    </div>
    <div class="live_bottom"></div>
  </div>
</div>
<?php
	        // get couponcount 
		$getcoupon_list_query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where";
			
		if($default_city_id)
		{
			$getcoupon_list_query .= " coupon_city = '$default_city_id' AND ";
		}
		$getcoupon_list_query  .= " coupon_status = 'A' and coupon_startdate <= now() and ((coupon_enddate between now() and '$end_time') or (instant_deal='1' and coupon_enddate >= now())) order by coupon_id desc";
		$getcoupon_count = mysql_query($getcoupon_list_query);
		$coupon_count = mysql_num_rows($getcoupon_count);

	?>
<div class="bottom_ndot_text fl"><b> <?php echo $coupon_count; ?> <?php echo $language['active_deals_right']; ?> <?php echo $_SESSION['defaultcityname']; ?></b></div>
<!-- Step one end-->
<?php

}

}
?>
</div>
<div class="inner_bottom3"></div>
<!-- Static page start here --->
<!--KAMATCHIKUMAR 13-10-2011-->
<div class="bottom_ndot fl clr">
 <div class="bottom_top_deals_now fl clr"></div>
  <div class="bottom_ndot_mid fl clr">
    <div class="bottom_content_ndot fl clr">
      <div class="bottom_content_ndot_left">
        <h2><?php echo $language['how_it_works']; ?></h2>
        <ul>
          <li> <a href="#">1</a>
            <p><?php echo $language['enter_your_location_and_choose']; ?></p>
          </li>
          <li> <a href="#">2</a>
            <p><?php echo $language['buy_the_deal_that_right']; ?></p>
          </li>
          <li> <a href="#">3</a>
            <p><?php echo $language['the_merchant_within']; ?></p>
          </li>
        </ul>
        <div class="blue">
          <div class="blue_left"></div>
          <div class="blue_middle">
             <a href="#"><?php echo $language['watch_video']; ?></a>
          </div>
          <div class="blue_right"></div>
          </div>
      </div>
      <div class="bottom_content_ndot_middle">
        <h2><?php echo $language['great_deals_on']; ?></h2>
        <p><?php echo $language['find_great_local']; ?> <span style="color:#0185c6"><?php echo $language['our_mobile_app']; ?></span> <?php echo $language['for_iphone and android']; ?></p>
        <div class="bottom_content_ndot_middle_1 fl clr"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/dealsnow/image_8.png" width="101" height="38" class="fl" /> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/dealsnow/andriod12.png" width="101" height="38" class="fl clr" /></div>
        <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/dealsnow/image_2.png" width="120" height="166" /> </div>
      <div class="bottom_content_ndot_right">
        <h2><?php echo $language['are_you_merchant']; ?></h2><p><?php echo SITE_NAME; ?><?php echo $language['deals_now_can_bring']; ?><br /><?php echo $language['want_hem_the_most']; ?><br /><br /><?php echo $language['get_started_for_free']; ?> <br /><?php echo $language['schedule your first deal']; ?> <br /><?php echo $language['now']; ?></p>
        <div class="bottom_content_ndot_right_1"> 
          <div class="bottom_content_ndot_right_1_left"></div>
          <div class="bottom_content_ndot_right_1_middle">
           <a href="<?php echo DOCROOT; ?>business.html"><?php echo $language['learn_more']; ?></a>
          </div>
          <div class="bottom_content_ndot_right_1_right"></div>
          </div>
          <div class="bot_img">
        <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/dealsnow/image_3.png" width="125" height="151" class="fl"/> 
        </div>
        </div>
    </div>
  </div>
  <div class="inner_bottom3"></div>
</div>
