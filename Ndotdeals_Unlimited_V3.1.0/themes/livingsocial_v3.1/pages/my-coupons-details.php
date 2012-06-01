<?php
	       $today_date=date("Y-m-d H:i:s");
               echo '<p style="width:680px;color:#666;text-align:center;padding-bottom:10px;" class="mb20">'.$language['note'].': UN -'.$language['user_yet_to_use'].' <br/> U - '.$language['user_used'].'<br/> '.$language['validityid'].' - '.$language['validityid_generated'].' <br/>'.$language['validated_date'].' - '.$language['coupon_validated_date'].'</p>';

                echo '<table cellpadding="5" cellspacing="5" class="fl clr borderr" style="width:690px; border:1px solid #C7C7C7;">';
                echo '<tr class="fwb bb" ><th class="bb">'.$language['coupon_name'].'</th><th class="bb">'.$language['purchase_date'].'</th><th class="bb">'.$language['expiration_date'].'</th><th class="bb">'.$language['status'].'</th><th class="bb">&nbsp;</th><th class="bb">&nbsp;</th></tr>';
                        
                while($noticia=mysql_fetch_array($resultSet))
                { 
             //   print_r($noticia);
                    echo '<tr><td style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 3px;"><div style="width:250px;float:left;"><div class="fl" style="border:1px solid #DDDDDD;padding:2px;width:70px;">';
                    
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
                    echo '</div><div class="fl ml5" style="width:165px;">'.ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)).'</div></td><td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;">';
                    echo date('d/m/Y', strtotime($noticia['coupon_purchaseddate'])).'</td><td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;">';
                    echo date('d/m/Y', strtotime($noticia['coupon_expirydate'])).'</td><td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;">';
                    echo $noticia['coupons_userstatus'].'</td>';
                    if(!empty($noticia['coupon_validityid']) && ($noticia['CAPTURED'] == 1 ))
                    {
                    echo '<td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;">';
                     if(empty($noticia['gift_recipient_id']))
                     {   
                           if($noticia['coupon_expirydate']<$today_date)            
                             {
                                  ?>
                                  </td>
                                  <td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;"><?php echo $language["coupon_has_expired"]; ?></td>
                                <?php
                             }
                             else
                             {             
                                 ?>
                                 <a href="<?php echo DOCROOT.'print/'.friendlyurl($noticia['coupon_name']).'_'.$noticia['couponid'].'_'.$noticia['coupon_purchaseid'].'.html'; ?>" target="_blank" title="Print coupon"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/printer2.png"/></a>
                                </td>
                                 <td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;"><a href="<?php echo DOCROOT; ?>export_pdf.php?vid=<?php echo $noticia['couponid'].'_'.$noticia['coupon_purchaseid']; ?>" title="pdf" class="fl mr5" style="color:#000;width:120px;"><?php echo $language["down_pdf"]; ?></a>
                                 </td>
                                 <?php
                            }
                     }                     
                     else
                     {
                           ?>
                        
                          </td>
                          <td valign="top" style="border-bottom:1px solid #C7C7C7;padding:10px 0px 10px 0px;"><?php echo $language["deals_bought_for_friend"]; ?></td>

                        <?php
                     }
                    }
                    echo '</tr>';
                            }
    
                        echo '</table>';

                if($pages->rspaginateTotal>20) 
			{ 
                echo '<table border="0" width="650" class="fl clr" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';
                }
?>
