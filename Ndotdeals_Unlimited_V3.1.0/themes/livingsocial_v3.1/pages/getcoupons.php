<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/loopedslider.js" type="text/javascript"></script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.countdown.js" type="text/javascript"></script>
<?php 
$lang = $_SESSION["site_language"];
if($lang)
{
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/en.php");
}
?>
<?php 
	//pagination
	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	
if($type!="P")
{
	
	if(mysql_num_rows($resultSet)>0)
	{	
		while($row = mysql_fetch_array($resultSet))     
		{
		

				if($type=="P" || $row["timeleft"] > "00:01:00")
				{
					$coupon_value = $row["coupon_value"]; 
					$purchased_count = $row["pcounts"];
					
					if($purchased_count > 0)
					{
					if($row["coupon_minuserlimit"] > 0)
					$progressbar_value = $purchased_count * (100/$row["coupon_minuserlimit"]);
					else
					$progressbar_value = $purchased_count;         
					}
					else
					$progressbar_value = 0;
				?>
<script type="text/javascript">
	$(document).ready(function() {
	$("#progressbar_<?php echo $row['coupon_id']; ?>").progressbar({ value: <?php echo $progressbar_value; ?> });
	});
</script>
<script type="text/javascript">
$(function () {
	// get coupon enddate
	var enddate = new Date('<?php echo date("D M d Y H:i:s", strtotime($row["coupon_enddate"])); ?>')

	//$('#times').countdown({since: austDay});
	//$('#times').countdown({since: startdate , until: enddate});

	//$('#times').countdown({since: startdate});
$('#times_<?php echo $row["coupon_id"];?>').countdown({compact: true,until: enddate , serverSync: function() { return new Date('<?php echo date("D M d Y H:i:s"); ?>'); }  ,onExpiry: liftOff  });


function liftOff() {

    window.location = "<?php echo DOCROOT; ?>"; 
    //alert('We have lift off!'); 
} 

//var timeoff = new Date("#{time_format(auction.end_time)}");
//$("#myDivId .timerContent").countdown({until : timeoff, onExpiry:applySold, compact : true, layout : '', serverSync: serverTime });
	//$('#year').text(austDay.getFullYear());
});
</script>
<!--Countdown Timer end-->

<div class="fl clr" style="width:auto; ">
  <div class="content_top fl clr">
    <div class="con_top_top"></div>
	  <div class="con_top_mid">
      <h2>
        <?php 
	if(strlen($row["coupon_name"])>105)
	{
		echo html_entity_decode(substr($row["coupon_name"],0,105), ENT_QUOTES)."...";
	}else
	{
		echo html_entity_decode($row["coupon_name"], ENT_QUOTES);
	}
	?>
      </h2>
      <!--<p>Wheatgrass Love</p>-->
   </div>

  </div>
  <div class="content_center fl clr"> <span id="generaldate" style="display:none;"></span>
    <div class="discount_value"> </div>
    <div class="deal_top fl clr" >
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
			
		        else
		         {
                         ?>
                                   <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
          <?php
                                       if(file_exists($row["coupon_image"]))
                                       {
                                       ?>
          <img width="404" height="386" class="" src="<?php echo DOCROOT.$row["coupon_image"]; ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
          <?php 
                                        }
                                       else
                                         {
                                         ?>
          <img width="404" height="386" class="" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>" />
                        <?php
                                        }
                                            
                           }                  
                           ?>
                                    </a>
          </div>
      <div class="con_left_image_btm fl clr"></div>

      </div>
      <div class="right_content1">
        
        <!--<span class="shell">Shellac Manicure and Pedicure</span>-->
           <div class="con_top_right ">
		   <div class="hot_buy_bg fl clr">
          <div class="top_right_left1">
            <?php 
        $coupon_value = $row["coupon_value"]; 
        ?>
            <p><span class="dollor1"><?php echo CURRENCY; ?></span>
            <span class="fifty1">
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
			<div class="buy_img_left_bg1"></div>
			<div class="buy_img_mid_bg1">
            <a  href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>" class="buy_img" title="<?php echo strtoupper($language['buy']);?>"> <?php echo strtoupper($language['buy']); ?></a></div>
           <div class="buy_img_right_bg1"></div>
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
	 <div class="timer_left"></div><div class="timer_mid"><div class="times" id="times_<?php echo $row['coupon_id'];?>">        
	 </div>                             
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
                                    <div id="progressbar_<?php echo $row['coupon_id']; ?>" class="mt10" style="margin:0px;"></div>
                                  </div>
                                  <div class="pbarval clr "> 
                                  <span class="fl mt5 color000 fontbold mr5"><?php echo $startvalue = 0; ?></span>
                                  <span class="fr mt5 color000 fontbold"><?php echo $row["coupon_minuserlimit"]; ?></span> </div>
                                </div>
                                  <b ><?php echo $min_user; ?></b><p>&nbsp;<?php echo $language['need_to_get']; ?></p>
                            
                                <?php
                                }
                                else
                                {
                                ?>
            <h3><?php echo $purchased_count; ?> <?php echo $language['bought']; ?></h3>
            <p style="color:#666;font:normal 12px arial;padding-top:5px;width:190px!important;text-align:center;padding-left:10px;margin:0px 0 0 40px !important;" class="bg_tick"><?php echo $language['lim_quantity']; ?></p>
            <p style="color:#83AF43;font-size:12px;padding:5px 0px;font-weight:bold;width:260px!important;text-align:center"><?php echo $language['deal_on']; ?>!</p>
            <?php
                                }
                                ?>
          </div>
          
          </div>
		  <div class="gift"> <span class="fontb12"><a href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>&amp;type=gift" title="<?php echo $language['buy_it_for_a_friend'];?>"><?php echo $language["buy_it_for_a_friend"];?></a></span>
          </div>
       
      </div>
	  
    </div>
	
    <!--end of cnt_left-->
  </div>
  <div class="content_bottom fl clr mb15"></div>
</div>
 
        <?php 
	   } //end of if 

	} // End while loop
	if($pages->rspaginateTotal>20) 
	{
	echo '<table border="0" width="650" align="center" class="clr" cellpadding="10">';
	echo '<tr><td align="center"><div class="pagenation">';
	echo $pages->display_pages();
	echo '</div></td></tr>';
	echo '</table>';
	}	  
	}
	else
	{		
	?> 
	      <div class="con_top_top"></div>
	       <div class="con_top_mid"></div>
		<div class="content_center fl clr">
		  <div class="no_data"><?php echo $language['no_deals_avail']; ?></div>
		</div>
	     <div class="content_bottom fl clr mb15"></div>	
	
	<?php 	       
           } 

	 }
	else // past deal
	{ 
	
	if(mysql_num_rows($resultSet)>0)
	{	
		while($row = mysql_fetch_array($resultSet))     
		{
		$purchased_count = $row["pcounts"];
		?>
<div class="today_content" >
  <!-- thumb image start -->
  <div class="today_image">
   
    <a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
    
    <?php if(file_exists($row["coupon_image"])) { ?>
    <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=125&amp;height=135&amp;cropratio=1:1&amp;noimg=100&amp;image=<?php echo urlencode(DOCROOT.$row["coupon_image"]); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
    <?php }else{ ?>
    <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=125&amp;height=135&amp;cropratio=1:1&amp;noimg=100&amp;image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
    <?php }?>
    </a> <div class="past_left_image_btm fl clr"></div></div>
	
  <!-- thumb image end -->
  <div class="today_post">
    <h1> <a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
      <?php 
						if(strlen($row["coupon_name"])>100)
						{
						echo html_entity_decode(substr($row["coupon_name"],0,100), ENT_QUOTES)."...";
						}else
						{
						echo html_entity_decode($row["coupon_name"], ENT_QUOTES);
						}
						?>
      </a> </h1>
    <!--<span class="spa">Shellac Manicure and Pedicure</span>-->
     <div class="past_timer">
      <div class="time_left">
        <div class="timetop1">
          <div class="value1">
            <div class="left"></div>
            <div class="middle"> <span class="color333 fontb12 val"><?php echo $language['value']; ?></span><br />
              <span class="color333 fb15"><?php echo CURRENCY;?>
              <?php 
                                    if(ctype_digit($row['coupon_realvalue'])) { 
                                        echo $row["coupon_realvalue"];
                                    } 					  
                              
                                        else { 
        
                                        $coupon_realvalue = number_format($row['coupon_realvalue'], 2,',','');
                                        $coupon_realvalue = explode(',',$coupon_realvalue);
                                        echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];
        
                                    }
                                    ?>
              </span> </div>
            <div class="right"></div>
          </div>
          <div class="Discount1">
            <div class="left"></div>
            <div class="middle1"> <span class="color333 fontb12 val_1"><?php echo $language['discount']; ?></span><br />
              <?php ?>
              <span class="color333 fb15">
              <?php $discount = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]); echo round($discount); ?>
              %</span>
              <?php ?>
            </div>
            <div class="right"></div>
          </div>
          <div class="Save1">
            <div class="left"></div>
            <div class="middle2"> <span class="color333 fontb12 val_2"><?php echo $language['you_save']; ?></span><br />
              <span class="color333 fb15"><?php echo CURRENCY;?>
              <?php $value = $row["coupon_realvalue"] - $row["coupon_value"]; 
                              
                                    if(ctype_digit($value))
                                    { 
                                        echo $value;
                                    } 					  
                              
                                        else { 
        
                                        $value = number_format($value, 2,',','');
                                        $value = explode(',',$value);
                                        echo $value[0].'.'.$value[1];
        
                                    }?>
              </span> </div>
            <div class="right"></div>
          </div>
        </div>
      </div>
      <div class="time_right">
        <p><?php echo $language['sold']; ?></p>
        <h2><?php echo $purchased_count; ?></h2>
      </div>
    </div>
  </div>
</div>
<?php 
    } 
		//pagination
		if($pages->rspaginateTotal>20) 
		{
			echo '<table border="0" width="650" align="center" class="clr" cellpadding="10">';
			echo '<tr><td align="center"><div class="pagenation">';
			echo $pages->display_pages();
			echo '</div></td></tr>';
			echo '</table>';
		}	  
   }
  else
  { 
  ?>
	<div class="content_top fl clr mt10"></div>
		<div class="content_center fl clr">
		  <div class="no_data"><?php echo $language['no_deals_avail']; ?></div>
		</div>	
	
<?php
 }
}

?>
