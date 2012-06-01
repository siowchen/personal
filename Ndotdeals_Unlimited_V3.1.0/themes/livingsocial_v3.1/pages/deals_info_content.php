<?php
/****************************************** * @Created on December, 2011 * @Package: Ndotdeals unlimited v3.1.0
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/tabs.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/loopedslider.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.countdown.js" type="text/javascript"></script>
<?php 
if(mysql_num_rows($result) == 0) 
{ ?>
    <div class="left1 fl ">
    <div class="content_top fl clr"></div>
        <!--left corner-->
        <div class="con_top_top"></div>
	  <div class="con_top_mid"></div>
        <div class="content_center fl clr">
          <div class="no_data"><?php echo $language['no_deals_avail']; ?></div>
        </div>
    <div class="content_bottom fl clr"></div>

<?php 
}
else
{
	
	while($row = mysql_fetch_array($result))
	{

		if($row["timeleft"] > "00:00:01")
		{
            	$val_timer=$row["timeleft"];
				//get the purchased coupon's count
				$purchased_count = $row["pcounts"];
				if($purchased_count > 0)
				{
						if($row["coupon_minuserlimit"] > 0)
								$progressbar_value = $purchased_count * (100/$row["coupon_minuserlimit"]);
						else
							 $progressbar_value = $purchase_count;         
				}
				else
		    	$progressbar_value = 0;
?>

	<script type="text/javascript">
          $(document).ready(function() {
            $("#progressbar").progressbar({ value: <?php echo $progressbar_value; ?> });
          });
        </script>  
          
       <!--Countdown Timer start here-->      
	<script type="text/javascript">
		$(function () {
		    // get coupon enddate
		    var enddate = new Date('<?php echo date("D M d Y H:i:s", strtotime($row["coupon_enddate"])); ?>')       

		    //$('#times').countdown({since: startdate});
		$('#times').countdown({compact: true,until: enddate , serverSync: function() { return new Date('<?php echo date("D M d Y H:i:s"); ?>'); }  ,onExpiry: liftOff  });        
		
		function liftOff() {        
		    window.location = "<?php echo DOCROOT; ?>"; 
		    //alert('We have lift off!'); 
		}         
		
		});
        </script>
        
        <!--Countdown Timer end-->

<div class="left1 fl ">
  <div class="fl clr" style="width:auto;">
    
    <div class="content_top fl clr">
      <div class="con_top_top"></div>
      <!-- Deal title -->
	  <div class="con_top_mid">
        <h2>
          <?php 			
		echo html_entity_decode($row["coupon_name"], ENT_QUOTES);
	  ?>
        </h2>
		</div>
	  <!-- Deal title end -->
    </div>
        
    	<div class="content_center fl clr"> 
        <span id="generaldate" style="display:none;"></span>
     	<div class="discount_value"> </div>
      	
        <!-- deal slides -->
        <div class="deal_top fl clr" >
        <?php ?>
        <!--cnt_left-->
        <?php
                   //slide show starts 
                   $couponid = $row["coupon_id"];
                   $slider = 0;
                   $slider_result = mysql_query("select * from slider_images where coupon_id='$couponid'");
                   if(mysql_num_rows($slider_result)>0)
                   {
                        $slider = mysql_num_rows($slider_result);
                   }
                   ?>
                    <div class="cnt_left fl">
                      <div class="img_left deal_video">
                        <?php
                                   if($row['is_video'] == 1)
                                   { 
                        
                                        //get the video url
                                        $split_video = make_links(html_entity_decode($row['embed_code'], ENT_QUOTES));
                                        $video_1 = explode("\"",$split_video); //print_r($video_1);
                                        ?>
                           		<!-- video embed code-->                                       
                                        <object width="404" height="315"><param name="movie" value="<?php echo $video_1[0]; ?>?version=3&amp;hl=en_US&amp;rel=0"></param><param name="allowFullScreen" value="true"></param>
			    <param name="allowscriptaccess" value="always" ></param><param name="wmode" value="transparent"> </param> <embed src="<?php echo $video_1[0]; ?>?version=3&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" width="404" height="315" allowscriptaccess="always" allowfullscreen="true"  wmode="transparent"></embed></object>
                                        
                                    <?php
                                    }
                                    else if($slider > 0)
                                    {
                                    ?>
                                        <div id="loopedslider">
                                      <div class="slider-container">
                                        <div class="slides"> 
                                          <?php if(file_exists($row["coupon_image"]))
                                                           {
                                                           ?>
                                          <img width="404" height="386" class=""src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                                          <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                          <img width="404" height="386" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                                          <?php
                                                            }
                                                            for($i = 1;$i <= $slider;$i++)
                                                            {
                                                                    if(file_exists('uploads/slider_images/'.$row['coupon_id'].'_'.$i.'.jpg'))
                                                                    {
                                                                            $slider_url = DOCROOT.'uploads/slider_images/'.$row['coupon_id'].'_'.$i.'.jpg';
                                                                            ?>
                                          <img width="404" height="386" class="" src="<?php echo $slider_url; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                                          <?php   
                                                                    }
                                                            }
                                                            ?>
                                        </div>
                                      </div>
                                      <p class="slide_pagination"> <a href="javascript:;" class="fl previous"></a> <a href="javascript:;" class="fr next"></a> </p>
                                    </div>
                                        <script>
                                            $(function(){
                                                $('#loopedslider').loopedSlider({
                                                    addPagination: true,
                                                    autoStart: 3000,
                                                    pagination : "slider-pagination"
                                                });
                                            });
                                        </script>
                                    <?php
                                      }
                                      else
                                      {
                                            ?>
                                     <?php
                                                   if(file_exists($row["coupon_image"]))
                                                   {
                                                   ?>
                        <img width="404" height="386" class="" src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                        <?php 
                                                  }
                                                  else
                                                  {?>
                <img width="404" height="386" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                <?php
                                                  }
                                                        
                                         }    
                                                                                         
                                         ?>
                      </div>
                      <div class="con_left_image_btm fl clr"></div>
                    </div>
                    
        <div class="right_content">
       
       
          <div class="con_top_right">
        <div class="hot_buy_bg fl clr">
          <div class="top_right_left1">
            <?php 
        	$coupon_value = $row["coupon_value"]; 
        	?>
            <p><span class="dollor"><?php echo CURRENCY; ?></span>
            <span class="fifty">
              <?php 
            if(ctype_digit($coupon_value)) { 
            echo $coupon_value;
            } 
            
            else { 
            
            $coupon_value = number_format($coupon_value, 2,',','');
            $coupon_value = explode(',',$coupon_value);
            echo $coupon_value[0].'.'.$coupon_value[1];
            
            }							
            ?>
            </span>
            </p>
            </div>
			
            <div class="top_right_rgt1">
            
            		<?php
            		//Feature deal showing admin and shopadmin 
            		if($row["coupon_startdate"] < date("Y-m-d H:i:s")) { ?>
			<div class="buy_img_left_bg1"></div>
				<div class="buy_img_mid_bg1">
		    		
		    		<a  href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>" class="buy_img" 
		    title="<?php echo strtoupper($language['buy']);?>"> <?php echo strtoupper($language['buy']); ?></a>
		    		
		    		</div>
          		<div class="buy_img_right_bg1"></div>
           		<?php
            		}
            		?>

            		 
            </div>
			</div>
             </div>
           
          <div class="timetop">
            <div class="value">
              <p><?php echo CURRENCY;?>
                <?php 
                                    if(ctype_digit($row['coupon_realvalue'])) { 
                                        echo $row["coupon_realvalue"];
                                    } 					  
                              
                                        else { 
                    
                                    $coupon_realvalue = number_format($row['coupon_realvalue'], 2,',','');
                                    $coupon_realvalue = explode(',',$coupon_realvalue);
                                     $coupon_realvalue[0].'.'.$coupon_realvalue[1];
                    
                                    }
                                    ?>
              </p>
              <span><?php echo $language['value']; ?></span> </div>
            <div class="Discount">
              <p>
                <?php $discount = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]); echo round($discount); ?>
                %</p>
              <span><?php echo $language['discount']; ?></span> </div>
            <div class="you_save">
              <p><?php echo CURRENCY;?>
                <?php $value = $row["coupon_realvalue"] - $row["coupon_value"]; 
                                      
                                            if(ctype_digit($value)) { 
                                                echo $value;
                                            } 					  
                                      
                                                else { 
                        
                                                $value = number_format($value, 2,',','');
                                                $value = explode(',',$value);
                                                echo $value[0].'.'.$value[1];
                        
                                            }?>
              </p>
              <span><?php echo $language['you_save']; ?></span> </div>
          </div>
          <div class="con_top_right_bottom_bg fl clr mt5"></div>
		  <div class="fl clr timer1">
          <div class="timer_left"></div>  
           <div class="timer_mid">      
           <div class="hasCountdown">
          
		  <div class="times" id="times">
		  </div>
           </div>
           </div>
            <div class="timer_right"></div>
			</div>
		
			
          <div class="con_top_right_mid">
        <div class="bought">
            <?php 
                            $min_user = $row["coupon_minuserlimit"] - $purchased_count;
                            $max_user = $row["coupon_maxuserlimit"] - $purchased_count;
                            
                            if($min_user > 0)
                            { ?>
            <h3><?php echo $purchased_count; ?> <span class="ft20 colorF87B12"> <?php echo $language['bought']; ?> </span> </h3>
            <div class="clr " style="width:246px;">
              <div class="pbar mt5">
                <div id="progressbar" class="mt10" style="margin:0px;"></div>
              </div>
              <div class="pbarval clr ">
			   <span class="fl mt5 color000 fontbold mr5"><?php echo $startvalue = 0; ?></span>
			    <span class="fr mt5 color000 fontbold"><?php echo $row["coupon_minuserlimit"]; ?></span>
				 </div>
            </div>
            <b ><?php echo $min_user; ?></b><p>&nbsp;<?php echo $language['need_to_get']; ?></p>
            <?php
                                }
                                else
                                {
                                ?>
            <h3><?php echo $purchased_count; ?> <?php echo $language['bought']; ?></h3>
            <p style="color:#666;font:normal 12px arial;padding-top:5px;width:190px!important;text-align:center;padding-left:10px;margin:10px 0 0 40px !important;" class="bg_tick"><?php echo $language['lim_quantity']; ?></p>
            <p style="color:#83AF43;font-size:12px;padding:5px 0px;font-weight:bold;width:260px!important;text-align:center"><?php echo $language['deal_on']; ?>!</p>
            <?php
                                }
                                ?>
          </div>
		  
          </div>
        <?php
	//Feature deal showing admin and shopadmin 
	if($row["coupon_startdate"] < date("Y-m-d H:i:s")) { ?>
	
          <div class="gift"> <span class="fontb12"><a href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>&amp;type=gift" title="<?php echo $language['buy_it_for_a_friend'];?>"><?php echo $language["buy_it_for_a_friend"];?></a></span>
           </div>
           
          <?php } ?>
          
        </div>
      </div>
	<!-- deal slides -->
      	
	<!-- deal description -->
	  <div class="fl clr coupon_description_outer" >
		  <div class="coupon_description fl mt5">
          <h1><?php echo $language['description']; ?></h1>
		  <p class="fl"><?php echo nl2br(html_entity_decode($row["coupon_description"], ENT_QUOTES)); ?></p>
		  </div>
	  </div>
        <!-- deal description end -->
        
        <!-- deal terms and condition -->
	  <div class="fl clr coupon_terms">
	    <h2><?php echo $language['terms_and_condition']; ?></h2>
	    <p class="fl clr mt10">
		  <?php echo nl2br(html_entity_decode($row["terms_and_condition"], ENT_QUOTES)); ?>		  
            </p>
	  </div>
        <!-- deal terms and condition end -->
	
      <!-- fine print and terms -->
      <div class="fl clr img_btm">
        <div class="img_left_btm">
          <h2><?php echo $language['fine_print']; ?></h2>
          	<?php echo nl2br(html_entity_decode($row["coupon_fineprints"], ENT_QUOTES)); ?>
        </div>
        
        <div class="img_left_btm">
          <h2><?php echo $language['highlights']; ?></h2>
          <?php echo nl2br(html_entity_decode($row["coupon_highlights"], ENT_QUOTES)); ?>
        </div>
      </div>
      <!-- fine print and terms end -->
	  
	  
    </div>
    
    <!-- share -->
    <div class="content_bottom_light fl clr"><div class="share">
            
            <div id="sfwt_full_1" style="display:none">
              <p>
                <?php		
				echo html_entity_decode($row["coupon_description"], ENT_QUOTES);
				?>
              </p>
              <a class="sfwt" onclick="$('#sfwt_short_1').show(); $('#sfwt_full_1').hide();; return false;" href="#"><?php echo $language['show_less']; ?></a> </div>
            <?php $title = html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>
            <?php $share_link = DOCROOT.'deals/'.html_entity_decode($row["deal_url"], ENT_QUOTES).'_'.$row['coupon_id'].'.html'; ?>
			
            <div class="share_home_left fl"></div>
			<div class="share_home_mid fl">
            <ul>
            <li><span class="share_us"><?php echo $language['shareus'];?>:</span></li>
              <li>
                <?php   $_SESSION['displaynone'] =  $row['coupon_id'];?>
                <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $share_link; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:25px; overflow:hidden; margin-left:10px;margin-top:0px;float:left; " allowTransparency="true"></iframe>
              </li>
              <li> <a href="http://twitter.com/share?url=<?php echo $share_link; ?>&amp;text=<?php echo $title; ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
                <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
              </li>
              <li><a class="bnone" href="mailto:?body=Checkout daily deals and huge discounts on the coolest stuff in your city<?php echo urlencode(DOCROOT.'ref.html?id='.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html');?>&amp;subject=I think you will get best deals" target="_blank"> <img class="fl" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/mail.png" /> </a> </li>
            </ul>
			</div>
			<div class="share_home_right fl"></div>
          </div></div>
    <!-- share end  -->
	</div>
  
  	<!-- Merchant Information with google map -->
 <div class="fl clr" style="width:auto;">
    <div class="content_bottom1 fr clr ">
      <div class="cnt_topborder fl clr"></div>
      <div class="cntbtm_inner fl clr">
        <h2><?php echo $language["map_location"];?></h2>
        <div class="cntbtm_inner_con">
          
          <div class="inner_con_left">
            <div class="shop_detail fl clr">
              <table width="180" class="fl clr" cellpadding="5">
                <?php
		  if(file_exists('uploads/logo_images/'.$row['shopid'].'.jpg')) 
		  {
		  ?>
			<tr>
			<td colspan="2" align="center" valign="top"><img class="p2" src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&amp;height=85&amp;cropratio=1:1&noimg=100&amp;image=<?php echo DOCROOT.'uploads/logo_images/'.$row['shopid'].'.jpg'; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" /> </td>
			</tr>
	<?php
		  }
		  ?>
                <tr>
                  <td align="right" width="80" valign="top"><label><?php echo $language['shop_name']; ?> :</label>
                  </td>
                  <td align="left" width="120"><p><?php echo ucfirst(html_entity_decode($row["shopname"], ENT_QUOTES));?></p></td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="80"><label><?php echo $language['address']; ?> :</label>
                  </td>
                  <td align="left" width="120"><p><?php echo ucfirst(html_entity_decode($row["shop_address"], ENT_QUOTES));?></p></td>
                </tr>
                <tr>
                  <td align="right" width="80"><label><?php echo $language['city']; ?> :</label>
                  </td>
                  <td align="left" width="120"><p><?php echo ucfirst(html_entity_decode($row["cityname"], ENT_QUOTES));?></p></td>
                </tr>
                <tr>
                  <td align="right" width="80"><label><?php echo $language['country']; ?> :</label>
                  </td>
                  <td width="120"align="left"><p><?php echo ucfirst(html_entity_decode($row["countryname"], ENT_QUOTES));?></p></td>
                </tr>
                <?php
		  if(!empty($row['shop_url']))
		  {
		  ?>
                <tr>
                  <td align="right" valign="top"><label style="float:left;"><?php echo $language['api_website']; ?> :</label>
                  </td>
                
                  <td valign="top"><p ><a style="overflow:hidden; word-wrap:break-word; width:114px;" href="<?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?>" target="_blank"> <?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?></a></p></td>
                </tr>
                <?php
		  }
		  ?>
              </table>
            </div>
          </div>
          
          <div class="inner_con_right">
            <div class="map">
              <iframe width="432" height="202" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $docroot; ?>/system/plugins/gmaps.php?address=<?php echo html_entity_decode($row["shop_address"], ENT_QUOTES);?>&amp;city=<?php echo html_entity_decode($row["cityname"], ENT_QUOTES);?>&amp;country=<?php echo html_entity_decode($row["countryname"], ENT_QUOTES);?>&amp;lat=<?php echo html_entity_decode($row["shop_latitude"], ENT_QUOTES);?>&amp;lang=<?php echo html_entity_decode($row["shop_longitude"], ENT_QUOTES);?>&amp;map_api=<?php echo GMAP_API;?>&amp;theme_name=<?php echo CURRENT_THEME;?>"> </iframe>
            </div>
          </div>
        </div>
      </div>
      <div class="cnt_btmborder fl clr"></div>
    </div>
  </div>
  	<!-- Merchant Information with google map End -->
    
	<!-- Facebook connect system -->
    <div class="fl clr" style="width:auto;">
    <div class="content_bottom1 fr clr ">
      <div class="cnt_topborder fl clr"></div>
      <div class="cntbtm_inner fl clr">
	 <script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript"></script>
	 <fb:comments href="<?php echo DOCROOT; ?>deals/<?php echo $row['deal_url'].'_'.$row['coupon_id'];?>.html" num_posts="2" width="650" border="1" style="margin-left:28px;"></fb:comments>
      </div>
      <div class="cnt_btmborder fl clr"></div>
    </div>
    </div>
  	<!-- Facebook connect system End -->
    
  <!-- Near by deals starts here-->
  <div class="fl clr" style="width:auto;">
    <div class="content_bottom1 fr clr ">
      <div class="cnt_topborder fl clr"></div>
      <div class="cntbtm_inner fl clr">
        <h2><?php echo $language['near_by_deal']; ?></h2>
        <div class="cntbtm_inner_con">
          <?php 	 
	 	//Get near by deals function 
	 	$query = "select * from coupons_coupons c left join coupons_cities cty on cty.cityid = c.coupon_city where ";
		//add the city condition
		if($default_city_id)
		{
			$query .= " coupon_city = '$default_city_id' AND ";
		}
		
	  	$query .= " c.coupon_status='A' and c.side_deal='1' and c.coupon_startdate <= now() and c.coupon_enddate > now() order by c.coupon_enddate asc ";
	  
        $near_buy_deals = mysql_query($query);

		if(mysql_num_rows($near_buy_deals)>0)
		{
		?>
		<?php
	   		while($nearbuy_deals = mysql_fetch_array($near_buy_deals))
            { 

		?>
              <div class="near_by_deals" >		  
                <div class="near_img"> 
                <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($nearbuy_deals["deal_url"]);?>_<?php echo $nearbuy_deals["coupon_id"];?>.html" title="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES);?>">
                        <?php 
                        if(file_exists($nearbuy_deals["coupon_image"]))
                        {
                      ?>
                          <img width="202" height="135" class=""src="<?php echo DOCROOT.$nearbuy_deals["coupon_image"]; ?>" alt="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES); ?>" />
                        <?php
                          }
                          else
                          {
                        ?>
                          <img width="202" height="135" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES); ?>" />
                  <?php
                         } 
                ?>
                  </a> 
                </div>
                  
                <div class="near_con">
                  <h3>
                  <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($nearbuy_deals["deal_url"]);?>_<?php echo $nearbuy_deals["coupon_id"];?>.html" title="<?php echo html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES);?>">
                    <?php
                    if(strlen($nearbuy_deals["coupon_name"]) > 100)
                    {
                    echo substr(nl2br(html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES)),0,100),'....';
                    }
                    else
                    {
                    echo nl2br(html_entity_decode($nearbuy_deals["coupon_name"], ENT_QUOTES));
                    }
                    ?>
                    </a>
                    </h3>
                  <!--<span>Three Pole Dancing Classes ducational ....</span>-->
                </div>						 
              </div>
		 
          <?php 
	   }
	   ?>
	  

	   <?php
	   
    }
   	else
    {
    	echo 'no deals available';
    }
 ?>
        </div>
      </div>
      <div class="cnt_btmborder fl clr"></div>
    </div>
  </div>
  <!-- Near by deals starts here End -->
  
  <?php 		}				
			else
			{
			
				url_redirect(DOCROOT);

			}

}
}
?>
</div>

<?php 

//set the city id while pop up get close by users
if(empty($_SESSION["defaultcityId"]))
{ 
if($_POST["menupopup"] == "popvalue")
{       
	$email = $_POST['email'];
	$city = $_POST['city_name'];
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
		set_response_mes(-1,$language['invalid_email']);
		url_redirect($_SERVER['REQUEST_URI']);
	} 
	
	if(!empty($email))
	{
		$val = add_subscriber($email,$city);
		if($val)
		{
		        /* GET THE EMAIL TEMPLATE FROM THE FILE AND REPLACE THE VALUES */
				$to = $email;
				$From = SITE_EMAIL;
				$subject = $email_variables['subscription_subject'];	
				$description = $email_variables['subscription_thankyou'];	
				$str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
				
				$str = str_replace("SITEURL",$docroot,$str);
				$str = str_replace("SITELOGO",$logo,$str);
				$str = str_replace("RECEIVERNAME","Subscriber",$str);
				$str = str_replace("MESSAGE",ucfirst($description),$str);
				$str = str_replace("SITENAME",SITE_NAME,$str);

				$message = $str;
				
				$SMTP_USERNAME = SMTP_USERNAME;
				$SMTP_PASSWORD = SMTP_PASSWORD;
				$SMTP_HOST = SMTP_HOST;
				$SMTP_STATUS = SMTP_STATUS;	
				
				if($SMTP_STATUS==1)
				{
	
					include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
				}
				else
				{
			     		// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					// Additional headers
					$headers .= 'From: '.$From.'' . "\r\n";
					mail($to,$subject,$message,$headers);	
				}
			$queryforset = mysql_query("select * from coupons_cities where cityid ='".$city."'");
			while($fetchrow = mysql_fetch_array($queryforset))
			{
			session_start();
			$_SESSION['defaultcityId'] = $fetchrow['cityid'];
			$_SESSION['defaultcityname'] = $fetchrow['cityname'];
			$_SESSION['default_city_url'] = $fetchrow['city_url'];
			}
			set_response_mes(1,$language['subscribe_success']);
			url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language['email_exist']);
			url_redirect($_SERVER['REQUEST_URI']);			
		}
	}
	else
	{
		set_response_mes(-1,$language['try_again']);
		url_redirect($_SERVER['REQUEST_URI']);

	}
	
	
}

 //get the categpry list
 $category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");
 ?>
    <div id="pop" class='popup_block'>
      <div class="subscription_form">
        <div class="subscription">
          <!--bg top start-->
          <div class="bg_top fl">
                  </div>
          <!--bg top end-->
          <!--bg middle start-->
          <div class="bg_middle fl">
            <!--title start-->
            <div class="title fl">
              <div class="exit fr"> <a href="<?php echo DOCROOT;?>subscribe.html?ref=Skip" title="Exit" class="fl"><img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/exit.png" width="24" height="34" border="0" class="fl" /></a> </div>
              
              <?php
              //Select defaultcity name
              $defcityid = SITE_DEFAULT_CITYID;
              if($defcityid)
              {              
              $selectdefaultcityname = mysql_query("select * from coupons_cities where cityid ='".$defcityid."' and status='A'");
              }
              else
              {
              $selectdefaultcityname = mysql_query("select * from coupons_cities where status='A' order by cityname");
              }
			while($fetchdefaultcityname = mysql_fetch_array($selectdefaultcityname))
			{
			$defcityname = $fetchdefaultcityname['cityname'];
			}
	     	       		
              ?>
              <h1 class="fl"><?php echo $language['get']; ?> <span><?php echo SITE_NAME; ?></span>
                <?php echo $language['deals_in'].$defcityname.$language['deal_offers']; ?></h1>
              <h2 class="fl"><?php echo $language['delivered_directly']; ?></h2>
            </div>
            <!--title end-->
            <!--subscribe content start-->
            <div class="subscribe_content fl">
              <div class="subscribe_content_left fl"></div>
              <div class="subscribe_content_middle fl">
                <div class="subscribe_options ">
                  <form action="" method="post" name="subscribe_updates" id="subscribe_updates">
                    <div class="subscribe_input fl">
                      <input type="text" title="<?php echo $language['valid_email']; ?>" name="email" value="" class="fl email required" />
                    </div>
                    <div class="subscribe_select fl">
                      <select name="city_name" id="city" class="fl m15 city_sel">
                        <?php while($city_row = mysql_fetch_array($category_list)) { ?>
                        <option value="<?php echo $city_row["cityid"];?>" <?php if(SITE_DEFAULT_CITYID == $city_row["cityid"]){ echo "selected";} ?>><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="subscribe_submit fr">
                      <input type="hidden" name="menupopup" value="popvalue">
                      <input type="submit" title="<?php echo $language['subscribe']; ?>" name="subsciberdeal" value="<?php echo $language['subscribe']; ?>" class="fl" />
                    </div>
                  </form>
                </div>
              </div>
              <div class="subscribe_content_right fl"></div>
            </div>
            <!--subscribe content end-->
            <!--privacy policy start-->
            <div class="privacy_policy fl">
              <!--read privacy policy stat-->
              <div class="read_privacy_policy fl">
                <p class="fl"><?php echo $language['share_your_email_address']; ?></p>
		        <a href="<?php echo DOCROOT;?>subscribe.html?ref=privacy" title="Read our privacy policy" class="fl ml5">
		        <?php echo $language['read_our_privacy_policy']; ?></a> 
                </div>
              <!--read privacy policy end-->
              <!--skip start-->
              <div class="skip fr mt2"> <a href="<?php echo DOCROOT;?>subscribe.html?ref=Skip" title="<?php echo $language['skip']; ?>" class="fl"><?php echo $language['skip']; ?></a> </div>
              <!--skip end-->
            </div>
            <!--privacy policy end-->
            <!--deals start-->
            <div class="deals fl">
              <ul class="fl">
                <li class="fl pr5"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/subscribe_deal_img1.jpg" width="167" height="108" border="0" class="fl" />
                  <p class="fl"><?php echo $language['restaurents']; ?></p>
                </li>
                <li class="fl pr5"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/subscribe_deal_img2.jpg" width="167" height="108" border="0" class="fl" />
                  <p class="fl"><?php echo $language['fitness']; ?></p>
                </li>
    
                <li class="fl pr5"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/subscribe_deal_img3.jpg" width="167" height="108" border="0" class="fl" />
                  <p class="fl"><?php echo $language['spa']; ?></p>
                </li>
                <li class="fl"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/subscribe_deal_img4.jpg" width="167" height="108" border="0" class="fl" />
                  <p class="fl"><?php echo $language['events']; ?></p>
                </li>
              </ul>
            </div>
            <!--deals end-->
          </div>
          <!--bg middle end-->
          <!--bg bottom start-->
          <div class="bg_bottom fl">
            
          </div>
          <!--bg bottom end-->
        </div>
      </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){$("#subscribe_updates").validate();});
    $(document).ready(function(){
        //       
                            

        
        //When you click on a link with class of poplight and the href starts with a # 
            var popID = 'pop'; //Get Popup Name
            var popWidth ='900'; //Gets the first query string value
    
            //Fade in the Popup and add close button
            $('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="http://<?php echo $_SERVER["HTTP_HOST"] ;?>/" class="close"></a>');
            
            
            
            //Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
            var popMargTop = ($('#' + popID).height() + 80) / 2;
            var popMargLeft = ($('#' + popID).width() + 80) / 2;
            
            //Apply Margin to Popup
            $('#' + popID).css({ 
                'margin-top' : -popMargTop,
                'margin-left' : -popMargLeft
            });
            
            //Fade in Background
            $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
            $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
            
            return false;
        });
        
        
        //Close Popups and Fade Layer
        $('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
           
        });
    
        
    </script>
    <script type="text/javascript">
    $('input[type="text"]').each(function(){
     
        this.value = $(this).attr('title');
        $(this).addClass('text-label');
     
        $(this).focus(function(){
            if(this.value == $(this).attr('title')) {
                this.value = '';
                $(this).removeClass('text-label');
            }
        });
     
        $(this).blur(function(){
            if(this.value == '') {
                this.value = $(this).attr('title');
                $(this).addClass('text-label');
            }
        });
    });
    </script>
<?php } 

?>

