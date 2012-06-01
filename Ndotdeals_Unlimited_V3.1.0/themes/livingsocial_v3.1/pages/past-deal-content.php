<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/tabs.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/loopedslider.js" type="text/javascript"></script>
<?php 
if(mysql_num_rows($result) == 0) 
{ ?>
<div class="left1 fl ">
  <div class="content_top fl clr" style="border:1px solid red;" ></div>
  <!--left corner-->
  <div class="content_center fl clr">
    <div class="no_data"><?php echo $language['no_deals_avail']; ?></div>
  </div>
  <div class="content_bottom fl clr"></div>
</div>
<?php 
}
else
{
	
	while($row = mysql_fetch_array($result))
	{

		

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

<div class="left1 fl">
  <div class="fl clr" style="width:auto;">
    <div class="content_top fl clr">
 
	    <div class="con_top_top"></div>
	  <div class="con_top_mid">
        <h2>
          <?php 
		echo html_entity_decode($row["coupon_name"], ENT_QUOTES);
	  ?>
        </h2>
        <!--<p>Wheatgrass Love</p>-->
      </div>
    </div>
    <div class="content_center fl clr"> <span id="generaldate" style="display:none;"></span>
      <div class="discount_value"> </div>
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
            <div class="sold_out"></div>
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
            <div id="loopedslider ">
              <div class="slider-container ">
                <div class="slides">
                  <?php if(file_exists($row["coupon_image"]))
                                   {
                                   ?>
                  <img width="397" height="382" class=""src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                  <?php
                                    }
                                    else
                                    {
                                    ?>
                  <img width="397" height="382" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                  <?php
                                    }
                                    for($i = 1;$i <= $slider;$i++)
                                    {
echo 'xbv';
                                            if(file_exists('uploads/slider_images/'.$row['coupon_id'].'_'.$i.'.jpg'))
                                            {
                                                    $slider_url = DOCROOT.'uploads/slider_images/'.$row['coupon_id'].'_'.$i.'.jpg';
                                                    ?>
                  <img width="397" height="382" class="" src="<?php echo $slider_url; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
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
            <img width="397" height="382" class="" src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
            <?php 
                                              }
                                              else
                                              {?>
            <img width="397" height="382" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
            <?php
                                              }
                                            
                                           }                  
                                           ?>
          </div>
		    <div class="con_left_image_btm fl clr"></div>
        </div>
        <div class="right_content">
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
            
             </div>                    
          <!--<span class="shell">Shellac Manicure and Pedicure</span>-->           
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
          
        </div>
      </div>
      <!-- deal description -->
	  <div class="fl clr coupon_description_outer" >
		  <div class="coupon_description fl mt5">
          <h1><?php echo $language['description']; ?></h1>
		  <?php echo nl2br(html_entity_decode($row["coupon_description"], ENT_QUOTES)); ?>
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
        
      <div class="fl clr img_btm">
        <div class="img_left_btm">
          <h2><?php echo $language['fine_print']; ?></h2>
          <ul>
            <li><?php echo nl2br(html_entity_decode($row["coupon_fineprints"], ENT_QUOTES)); ?> </li>
          </ul>
        </div>
        <div class="img_left_btm">
          <h2><?php echo $language['highlights']; ?></h2>
          <ul>
            <li><?php echo nl2br(html_entity_decode($row["coupon_highlights"], ENT_QUOTES)); ?></li>
          </ul>
        </div>
      </div>
      <!--end of cnt_left-->
    </div>
    <div class="content_bottom_light fl clr"></div>
  </div>
  <div class="fl clr" style="width:auto;">
    <div class="content_bottom1 fr clr ">
      <div class="cnt_topborder fl clr"></div>
      <div class="cntbtm_inner fl clr">
        <h2><?php echo $language["map_location"];?></h2>
        <div class="cntbtm_inner_con">
          <div class="inner_con_left">
            <div class="shop_detail fl clr">
              <table width="180" class="fl clr">
                <?php
						  if(file_exists('uploads/logo_images/'.$row['shopid'].'.jpg')) 
						  {
						  ?>
                <tr>
                  <td colspan="2" align="center" valign="top"><img class="p2" src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.'uploads/logo_images/'.$row['shopid'].'.jpg'; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" /> </td>
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
                  <td colspan="2"><label style="width:200px!important;float:left;"><?php echo $language['api_website']; ?> :</label>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><p style="width:200px!important;"><a style="width:100%!important;overflow:hidden;" href="<?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?>" target="_blank"> <?php echo html_entity_decode($row["shop_url"], ENT_QUOTES);?></a></p></td>
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
  
  <!--content left bottom-->
  <?php 		

}
}
?>
</div>
