<?php 
/******************************************** * @Created on December, 2011 * @Package: Ndotdeals unlimited v3.1.0
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
	//find current language
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

    <div class="footer_outer fl clr">
      <div class="footer_top_outer fl clr">
        <div class="footer_container">
          <div class="footer1">
            <div class="ndot_mobile"> 
            <a href="<?php echo DOCROOT;?>access/mobile" target="_blank">
                <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/mobile.png" class="fl ml50" /></a>
              <h2><?php echo SITE_NAME;?> <?php echo $language['mobile']; ?></h2>
              <p><?php echo $language['mobile_content']; ?></p>
            </div>
            <div class="ndot_mobile ml10">
              <a href="<?php echo DOCROOT;?>business.html"> 
              <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/bag.png" class="fl ml50"/></a>
                <h2><?php echo $language['suggest_business']; ?></h2>
                <p><?php echo $language['suggest_business_content']; ?></p>
            </div>
            <div class="ndot_mobile ml10">
              <a href="<?php echo DOCROOT;?>referral.html">
               <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/round.png" class="fl ml50"/></a>
                <h2><?php echo $language['refer_friend']; ?></h2>
                <p><?php echo $language['refer_friends_content']; ?></p>
            </div>
            <div class="about_ndot">
              <h2><?php echo SITE_NAME; ?></h2>
              <p><?php echo $language['about_content']; ?></p>
            </div>
          </div>
          <div class="footer_top fl clr">
            <div class="footer_menu  fl pl10 ">
              <h3><?php echo $language["help"]; ?></h3>
              <ul>
                <li><a href="<?php echo DOCROOT;?>how-it-works.html" title="<?php echo $language['how_it_works']; ?>" ><?php echo$language["how_it_works"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>pages/about-us.html" title="<?php echo $language["about_us"]; ?>" ><?php echo $language["about_us"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>pages/faq.html" title="<?php echo $language["faq"]; ?>" ><?php echo $language["faq"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>contactus.html" title="<?php echo $language["contact_us"]; ?>" ><?php echo $language["contact_us"]; ?></a></li>
                               
              </ul>
            </div>
            <div class="footer_menu  fl">
              <h3><?php echo $language["Info"]; ?></h3>
              <ul>
                <li><a href="<?php echo DOCROOT;?>api.html" title="<?php echo $language["api"]; ?>" ><?php echo $language["api"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>system/affiliate/" title="<?php echo $language["affiliates"]; ?>" ><?php echo $language["affiliates"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>rss.php" title="<?php echo $language['rss']; ?>" ><?php echo $language["rss"]; ?></a></li>            
              </ul>
            </div>
            <div class="footer_menu  fl">
              <h3><?php echo $language["company"]; ?> </h3>
              <ul>
                <li><a href="<?php echo DOCROOT;?>pages/about-ndot-deals.html" title="<?php echo $language["About_Ndot"]; ?>" ><?php echo $language["About_Ndot"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>pages/terms-of-service.html" title="<?php echo $language["Terms_service"]; ?>" ><?php echo $language["Terms_service"]; ?></a></li>
                <li><a href="<?php echo DOCROOT;?>pages/privacy-policy.html" title="<?php echo $language["privacy"]; ?>" ><?php echo $language["privacy"]; ?></a></li>
              </ul>
            </div>
            <div class="footer_menu  fl bnone">
              <h3><?php echo $language["follow"]; ?> </h3>
              <ul>
                <li> 
            <a href="<?php echo FACEBOOK_FOLLOW; ?>" title="<?php echo $language['facebook']; ?>" target="_blank" > <?php echo $language['facebook']; ?></a> 
            </li>
                <li> 
            <a href="<?php echo TWITTER_FOLLOW; ?>" title="<?php echo $language['twitter']; ?>" target="_blank" > <?php echo $language['twitter']; ?></a>
           </li>
                
              </ul>
            </div>
            <div class="footer_menu4 fl pl10 mt10">
              <div class="follow">
                <p><?php echo $language['follow']; ?>:</p>
                <ul>
                  <li> <a href="<?php echo TWITTER_FOLLOW; ?>" title="Twitter" target="_blank"> <img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/twitter.png" /> </a> </li>
                  <li> <a href="<?php echo LINKEDIN_FOLLOW; ?>" title="Linked_in" target="_blank"> <img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/linked_in.png" /> </a> </li>
                  <li> <a href="<?php echo DOCROOT;?>rss.php" title="Social" target="_blank"> <img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/social.png" /> </a> </li>
                  <li> <a href="<?php echo FACEBOOK_FOLLOW; ?>" title="Facebook" target="_blank"> <img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/images/facebook.png" /> </a> </li>
                </ul>
              </div>
              <div class="ndot">
                <div class="address fl">
                  <h4><?php echo SITE_NAME;?> <span style="font:normal 12px arial;"><?php echo $language['network']; ?></span></h4>
                  <p>
                    <?php 
                    #-------------------------------------------------------------------------------
                    //GET purchase count and saved amount
                    $site_bus = get_saved_money();
                    while($ro = mysql_fetch_array($site_bus))
                    {
                        $purchased_deals = $ro["coupons_purchased_count"];
                        $saved_amount = $ro["coupons_amtsaved"];
                    }
                    #-------------------------------------------------------------------------------
                ?>
                
                  <?php echo $language['total_dollars_saved']; ?> 
                  <span style="font:bold 16px arial;color:#019FE2;"><?php echo CURRENCY;?><?php echo $saved_amount;?></span>
                  </p>
                  <p><?php echo $language['total_items_sold']; ?> <span style="font:bold 16px arial;color:#019FE2;"><?php echo $purchased_deals; ?></span></p>
                </div>
              </div>
            </div>
            <!-- copy rights -->
            <div class="footer_menu_bottom">
              <div class="footer_menu_bottom_left">
                <p><?php echo SITE_NAME;?><?php echo date("Y"); ?>. <?php echo $language['all_rights_reserved']; ?> </p>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>

	<script type="text/javascript">
$('input[type="text"]').each(function(){
   /*  var c =this.attr("class");
     alert(c);*/
    var v =this.id;
    var form = this.form;
   // var form_name=$(form).attr('name');
     var form_name=form.id;
     
     var tex_name=this.name; 
     var ref_tex_name=this.name; 
     var address_name=this.name;
    //alert(form_name);
    if((v!='share_link') && (tex_name !='quantity')  && (ref_tex_name !='ref_amt2') && (ref_tex_name !='ref_amt') && (form_name !='edit_profile' && form_name !='edit_register') && address_name !='address' && form_name !='CC_form' ){ 
    this.value = $(this).attr('title');
    $(this).addClass('text-label');
     }

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
