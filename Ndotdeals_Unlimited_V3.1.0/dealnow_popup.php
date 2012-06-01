<?php
// Include the library.inc files. 
include($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
$lang = $_SESSION["site_language"];
	if($lang)
	{
			include(DOCUMENT_ROOT."/system/language/".$lang.".php");
	}
	else
	{
			include(DOCUMENT_ROOT."/system/language/en.php");
	}
// get couponid
$id =  $_REQUEST['id'];

$querystring = "select * from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop=coupons_shops.shopid left join coupons_cities on coupons_cities.cityid=coupons_coupons.coupon_city where coupon_id=".$id;
$result = mysql_query($querystring);
$row = mysql_fetch_array($result);

$url = urlencode(DOCROOT.'deals/'.html_entity_decode($row['deal_url'],ENT_QUOTES).'_'.$row['coupon_id'].'.html');
$title = urlencode(ucfirst(html_entity_decode($row['coupon_name'],ENT_QUOTES)));

?>
<div style="float:left;margin-right:-20px;">
<!-- Popup box start here-->
<div style="float:left;width:100%;">
<div id="" class="tabs">
        <div class="tabs_header">
                <div id="tab0" class="tab active_tab"><p class="contents"><?php echo $language['overview']; ?></p></div>
                <div id="tab1" class="tab"><p class="contents"><?php echo $language['map_fine_print']; ?></p></div>
                <!--<div id="tab2" class="tab"><p class="contents">Description</p></div>
                <div id="tab3" class="tab"><p class="contents">Fineprints</p></div>-->
        </div>

        <div class="tab_contents">
                <!-- coupon image start here --> 
                <div id="tab0_content">
                        <div class="tab_2 mt10">
                                <div class="tab_top"></div>
                                        <div class="tab_left_img">

                                                <?php if(file_exists($row["coupon_image"])) { ?>
                                                <img src="<?php echo DOCROOT.$row['coupon_image']; ?>" alt="<?php echo $row['coupon_name'];?>" title="<?php echo html_entity_decode($row['coupon_name'], ENT_QUOTES);?>" width="135" height="85" />
                                                <?php }else{ ?>
                                                <img src="<?php echo DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'; ?>" alt="<?php echo $row['coupon_name'];?>" title="<?php echo html_entity_decode($row['coupon_name'], ENT_QUOTES);?>" width="135" height="85" />
                                                <?php }?>

                                        </div>
                                        <div class="tab_right_con">
                                                <h3><?php
                                                 if(strlen(html_entity_decode($row["coupon_name"], ENT_QUOTES))>100)
                                                 {
                                                        echo ucfirst(substr(html_entity_decode($row["coupon_name"], ENT_QUOTES),0,100)).'...';
                                                 }
                                                 else
                                                 {
                                                        echo ucfirst(html_entity_decode($row["coupon_name"], ENT_QUOTES));
                                                 }
                                                 ?>
                                                </h3>
                                                
                                                <ul class="mt10">
                                                <li><a class="bnone" href="mailto:?body=Checkout daily deals and huge discounts on the coolest stuff in your city<?php echo urlencode(DOCROOT.'ref.html?id='.'deals/'.friendlyURL(html_entity_decode($row['coupon_name'], ENT_QUOTES)).'_'.$row['coupon_id'].'.html');?>&subject=I think you will get best deals" target="_blank"><img  src="<?php echo DOCROOT.'themes/'.CURRENT_THEME.'/images/dealsnow/message.png'; ?>" width="17" height="19" /></a></li>
                                                <li> <a href="http://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo $title; ?>" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
                                                
                                                </ul>
                                        </div>
                                      
                        </div>
            <div class="btm_con">  
		<div class="button_left"></div>
			<div class="button_middle"><a href="<?php echo DOCROOT;?>purchase.html?cid=<?php echo $row['coupon_id'];?>"><?php echo $language['buy']; ?></a></div>
			<div class="button_right"></div>
			<div class="button2_middle">
			<h1><?php echo $language['redeemed_between']; ?></h1>
			<h2>
				<?php 
				$start_time = getdate(date(strtotime($row['coupon_startdate'])));
				echo $start_time['mday'].date('S M', strtotime($row['coupon_startdate'])).'&nbsp;';
				echo ($start_time['hours']%12).strftime('%P', strtotime($row['coupon_startdate']));

				?>

				-<?php
				$end_time = getdate(date(strtotime($row['coupon_enddate'])));
				echo $end_time['mday'].date('S M', strtotime($row['coupon_enddate'])).'&nbsp;';
				echo ($end_time['hours']%12).strftime('%P', strtotime($row['coupon_enddate']));
				?>
                	</h2>
			<!--<p>or we`ll automatically refund you</p>-->
			</div>
               <div class="button2_right"></div>
                
           </div>
     </div>
                <!-- coupon image End--> 
                
                <!-- coupon fineprint start here --> 
                <div id="tab1_content">
                        <div class="tab_2">
                                <div class="tab_top"></div>
                                <p style="width:400px;">
                                 <?php echo substr(strip_tags(html_entity_decode($row['coupon_fineprints'], ENT_QUOTES)),0,700);?>
                                </p>
                      </div> 
               </div>
       <!-- coupon fineprint End--> 
</div>
</div>
</div>
<!-- Popup box End-->
