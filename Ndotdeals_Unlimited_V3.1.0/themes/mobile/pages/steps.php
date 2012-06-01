<script src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/scripts/multistep.js?vGis9EFL" type="text/javascript"></script>
<link href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/css/steps.css" media="screen" rel="stylesheet" type="text/css" />
<div class="js_container">
<div class="header1">
                	<div class="header_left">
                    	    <a href="<?php echo DOCROOT;?>subscribe.html?ref=home" title="<?php echo SITE_NAME; ?>  ">
                            <img class="fr step_logo" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/logo.png" /></a>
				</div>
</div>
<div class="form_selection">
<div class='main clearfix' >
        <form action="/subscribe.html" class="groupon_form alt" id="new_subscription" method="post" >
                <div class=' step_one form_step' <?php if(isset($_COOKIE['defaultcityId'])){ echo 'style="display:none;"';}?>>
                	<div class="conf_top"></div>
                        <div class="form_inner">
                        <div class='page_content clearfix' >
                               <fieldset>
                                        <div class='input_three_steps'>
                                                <div class='header_three_steps'>
                                                        <h1><?php echo $language['confirm_city']; ?></h1>
                                                </div>
                                                <?php
                                                $reqUrl = $_SERVER["REQUEST_URI"];
                                                //remove first slash from url
                                                $docrootUrl = substr($reqUrl,1);

                                                $queryString = "select * from coupons_cities where status='A' order by cityname asc";
                                                $resultSet = mysql_query($queryString);
                                                ?>
                                                <div class="form_list">
                                                        <select id='subscription_division_id' name='subscription[division_id]' style='width: 170px;'>
                                                        <?php 
		                                         if(mysql_num_rows($resultSet)>0)
		                                         {

			                                            while( $row = mysql_fetch_array($resultSet))
			                                            {
			                                             ?>
				                                            <option value="<?php echo $row['cityid']; ?>" ><?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); ?></option>
	
			                                           <?php 
	
			                                            }
			                                            
		                                        }	    
		                                        ?>
                                                        </select>
                                                </div>
                                        </div>
                        </fieldset>
                <div class="form_bottom">
                <div class='button_container'>
                        <div class='button_sub buttons'>
                                 <a class="button continue js-button js-continue" href="javascript:;" id="step_one"></a>
                        </div>
                </div>
                  <div class="link_bottom">
                                	<ul>
                                	<li>
                                        	<a href="<?php echo DOCROOT;?>subscribe.html?ref=privacy" title="<?php echo $language['privacy']; ?>"><?php echo $language['privacy']; ?></a>
                                        </li>
                                        <li>
                                        	|
                                        </li>
                                        <li>
                                        	<a href="<?php echo DOCROOT;?>subscribe.html?ref=Signin" title="<?php echo $language['sign_in']; ?>"><?php echo $language['sign_in']; ?></a>
                                        </li>
                                        
                                        </ul>
                       </div>
                </div>
                </div>
        </div>
        <div class="conf_bot"></div>
</div>
<div class='step_two form_step' id="step2">
<div class="conf_top"></div>
        <div class="form_inner">
        <div class='page_content'>
                <fieldset>
                        <div class='input_three_steps'>
                               <div class='header_three_steps'>
                                        <h2><?php echo $language['enter_your_email']; ?></h2>
                               </div>
		<div class="form_list">
                                <div class="field subscription_email_address text"><label class="medium" for="subscription_email_address">&nbsp;</label><input class="prompting_field email required input" id="subscription_email_address" name="subscription[email_address]" size="30" title="<?php echo $language['valid_email']; ?>" type="text" /></div>
                  </div>
                        </div>
                </fieldset>
                <div class="form_bottom">
                        <div class='button_container'>
                          <div class='button_sub'>
                            <div class="buttons" label="false">
                            <input class="button see_deal  button" id="subscription_submit" name="commit" type="submit" value="" /></div>
                          </div>
                        </div>
                        
                        <div class="link_bottom">
                                	<ul>
                                	<li>
                                        	<a href="<?php echo DOCROOT;?>subscribe.html?ref=privacy" title="<?php echo $language['privacy']; ?>"><?php echo $language['privacy']; ?></a>
                                        </li>
                                        <li>
                                        	|
                                        </li>
                                    	
                                        <li>
                                        	<a href="<?php echo DOCROOT;?>subscribe.html?ref=Signin" title="<?php echo $language['sign_in']; ?>"><?php echo $language['sign_in']; ?></a>
                                        </li>
                                        <li>
                                        	|
                                        </li>
                                	<li>
                                        	<a href="<?php echo DOCROOT;?>subscribe.html?ref=Skip" title="<?php echo $language['skip']; ?>"><?php echo $language['skip']; ?></a>
                                        </li>
                                        </ul>
                       </div>
               </div>
              </div>
            
            </div>
          
          <div class="conf_bot"></div>
        </div>
        </form>
    </div>
</div>
</div>
<script type='text/javascript'>
      //<![CDATA[
        document.body.className += " js_enabled";
/* validation */

$(document).ready(function(){
$("#new_subscription").validate();
	$("#step_one").click(function(){
		$("#step2").addClass('disply_block');
	});
});

</script>

