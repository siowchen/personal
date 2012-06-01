<div class="mobile_content2">
      <div class="content_high">
<?php
                $today_date=date("Y-m-d H:i:s");
                echo '<table cellpadding="5" cellspacing="5" class="fl clr my_coupon" width="100%">';
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td><div class="fl" style="border:1px solid #DDDDDD;padding:1px;">';
                    
                    if(file_exists($noticia["coupon_image"]))
                    {
                    ?>
                        
                        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.$noticia["coupon_image"]; ?>" alt="<?php echo $noticia["coupon_name"];?>" title="<?php echo ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES));?>" />
                    <?php
                    }
                    else
                    {
                    ?>
                        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=70&height=70&cropratio=1:1&noimg=100&image=<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/no_image.jpg" alt="<?php echo $noticia["coupon_name"];?>" title="<?php echo ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES));?>" />
                    <?php
                    }
                    echo '</div></td><td valign="top">';
                    echo ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES));
					echo $language['purchase_date'].':'.date('d/m/Y', strtotime($noticia['coupon_purchaseddate'])).'<br/>';
                    echo $language['expiration_date'].':'.date('d/m/Y', strtotime($noticia['coupon_expirydate'])).'<br/>';
                    echo $language['status'].':'.$noticia['coupons_userstatus'].'';
                    if(!empty($noticia['coupon_validityid']) && ($noticia['CAPTURED'] == 1 ))
                    {
                        echo '<br/>'; 
                        if(empty($noticia['gift_recipient_id']))
                         {   
                             if($noticia['coupon_expirydate']<$today_date)            
                             { 
                                      ?>
                                     <?php echo $language["coupon_has_expired"]; ?></td> 
                                     <?php
                             }
                             else
                             {         
                        
                                 ?><input type="submit" value="" onclick="window.location='<?php echo DOCROOT.'print/'.friendlyurl($noticia['coupon_name']).'_'.$noticia['couponid'].'_'.$noticia['coupon_purchaseid'].'.html'; ?>'" class="print_but" title="<?php echo $language['print_coupon']; ?>"/>
                                <a href="<?php echo DOCROOT; ?>export_pdf.php?vid=<?php echo $noticia['couponid'].'_'.$noticia['coupon_purchaseid']; ?>" title="pdf" class="fl mr5" style="color:#000;width:150px;">Download as PDF</a></td>  
                                <?php                        
                           }
                      }                     
                      else
                      {
                         ?>
                        <?php echo $language["deals_bought_for_friend"]; ?></td>
                        <?php
                      }
                     
                    }
                    else
                    { 
                        echo '<td valign="top">'; 
                        ?></td> <?php
                    }    
                           
                    echo '</tr>';
              }
    
                        echo '</table>';

                if($pages->rspaginateTotal>20) 
			{
                echo '<table border="0" width="100%" class="fl clr	" align="center">';
		echo '<tr><td align="center">';
		echo $pages->display_pages();
		echo '</td></tr>';
		echo '</table>';
                 }
?>


</div>

                    <div class="high_menu2 clr fl">
                    	<ul>
			    <li><a href="<?php echo DOCROOT;?>"><?php echo strtoupper($language["today"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>hot-deals.html"><?php echo strtoupper($language["hot"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>past-deals.html"><?php echo strtoupper($language["past_deals"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>contactus.html"><?php echo strtoupper($language["contact_us"]); ?></a></li>
                        </ul>
                    </div>

</div>
