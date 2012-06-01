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
$url_arr = explode('/',$_SERVER['REQUEST_URI']);
if($url_arr[1] == 'today-deals.html')
{
        $today_deals = 'active';
}
else if($url_arr[1] == 'hot-deals.html')
{
        $hot_deals = 'active';
}
else if($url_arr[1] == 'past-deals.html' || $url_arr[2] == 'past')
{
        $past_deals = 'active';
}
else if($url_arr[1] == 'how-it-works.html')
{
        $how_it_works = 'active';
}
else if($url_arr[1] == 'contactus.html')
{
        $contactus = 'active';
}
else
{
        $home = 'active';
}
?>


        <div class="mobile_content">
        	<div class="content_high">

<?php

	//pagination
	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

	if(mysql_num_rows($resultSet)>0)
	{	
		while($row = mysql_fetch_array($resultSet))     
		{
				if($type=="P" || $row["timeleft"] > "00:01:00")
				{
					$coupon_value = $row["coupon_value"]; 
					
				?>
                
                <!-- loop starts -->
                <!-- list content starts -->
                <div class="content_value">
                	<div class="content_values">
                        <div class="content_val">
                            <p>Price :</p>
                            <span><?php echo CURRENCY;?><?php $coupon_realvalue = $row['coupon_realvalue'];
										if(ctype_digit($coupon_realvalue)) { 
											echo $coupon_realvalue;
										} 
		
										else { 

											$coupon_realvalue = number_format($coupon_realvalue, 2,',','');
											$coupon_realvalue = explode(',',$coupon_realvalue);
											echo $coupon_realvalue[0].'.'.$coupon_realvalue[1];

										}							
										?></span>

                        </div>
                        <div class="content_val">
                            <p>Discount :</p>
                            <span><?php $discount = get_discount_value($row["coupon_realvalue"],$row["coupon_value"]); echo round($discount); ?>%</span>
                        </div>
                        <div class="content_val">
                            <p>Save :</p>
                            <span><?php echo CURRENCY;?><?php $value = $row["coupon_realvalue"] - $row["coupon_value"]; 
					  
							if(ctype_digit($value)) { 
								echo $value;
							} 					  
					  
						        else { 

								$value = number_format($value, 2,',','');
								$value = explode(',',$value);
								echo $value[0].'.'.$value[1];

							}?></span>
                        </div>
                    </div>
                </div>
                <div class="content_img2">
                	<div class="content_list">


			    <?php
			    if($type != 'P')
			    {
			    ?>			
			    <a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
			    <?php
			    }
			    else
			    {
			    ?>
			    <a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($row["deal_url"]);?>_<?php echo $row["coupon_id"];?>.html" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>">
			    <?php
			    }
		       
			    ?>

				<?php if(file_exists($row["coupon_image"])) { ?>
				<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=140&height=70&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.$row["coupon_image"]); ?>" alt="<?php echo $row["coupon_name"];?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
				<?php }else{ ?>
				<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=140&height=70&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" title="<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES);?>" />
				<?php }?>

			     </a>

			<?php echo html_entity_decode($row["coupon_name"], ENT_QUOTES); ?>

		</div>

                </div>
		
                <div class="content_share">
		<?php
		$host = $_SERVER['HTTP_HOST'];
		$share_link = urlencode("http://".$host);
		if($type != 'P') 
		{ 
		
		?>
                	<div class="share_left">
                    	<p>Share this deal :</p>
                        <div class="share_icons">
                            <a href="http://www.facebook.com/sharer.php?u=<?php echo $share_link.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html',$row['coupon_name'];?>" target="_blank">
				<img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/fb_ico.gif" /></a>
                            <a href="http://twitter.com/home?status=<?php echo $share_link.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html',$row['coupon_name'];?>" target="_blank">
				<img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/twit_ico.gif" /></a>
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html',$row['coupon_name'];?>" target="_blank">
				<img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/in_ico.gif" /></a>
                            <a href="mailto:?body=Checkout daily deals and huge discounts on the coolest stuff in your city<?php echo urlencode(DOCROOT.'ref.html?id='.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html',$row['coupon_name']);?>&subject=I think you will get best deals" target="_blank">
				<img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/mail_ico.gif" /></a>
                        </div>
                    </div>
		<?php
		}
		?>
			
                    <div class="share_right">

		<?php if($type != 'P') { ?>
                    <a href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/buy_but.gif" /></a>
		<?php } 
		else
		{ ?>
		<img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/sold.png" />
		<?php } ?>
		
		

                    	<p><?php echo CURRENCY;?><?php 
										if(ctype_digit($coupon_value)) { 
											echo $coupon_value;
										} 
		
										else { 

											$coupon_value = number_format($coupon_value, 2,',','');
											$coupon_value = explode(',',$coupon_value);
											echo $coupon_value[0].'.'.$coupon_value[1];

										}							
										?></p>
                        
                    </div>
                </div>
                
                <!-- list content ends -->
                <!-- loop ends -->



				<?php 
				} //end of if 

		}

	if($pages->rspaginateTotal>20) 
	{
		echo '<table border="0" width="100%" align="center" class="clr">';
		echo '<tr><td align="center">';
		echo $pages->display_pages();
		echo '</td></tr>';
		echo '</table>';
	}	  
	}
	else
	{?>
	   <div class="no_data"><?php echo $language['no_deals_avail']; ?></div>
	<?php 
	}
	?>


                    <div class="high_menu2">
                    	<ul>
			    <li><a href="<?php echo DOCROOT;?>" class="<?php echo $today_deals; ?>"><?php echo strtoupper($language["today"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>hot-deals.html"  class="<?php echo $hot_deals; ?>"><?php echo strtoupper($language["hot"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>past-deals.html"  class="<?php echo $past_deals; ?>"><?php echo strtoupper($language["past_deals"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>contactus.html"  class="<?php echo $contactus; ?>"><?php echo strtoupper($language["contact_us"]); ?></a></li>
                        </ul>
                    </div>


            </div>
        </div>


