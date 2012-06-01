<?php
	is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_4").slideToggle();
document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>

<?php
	if($_POST)
	{
		$id = $_POST["id"];
		$name = htmlentities($_POST["name"], ENT_QUOTES); //site title 
		$site_name = htmlentities($_POST["site_name"], ENT_QUOTES); //site name
		$description = htmlentities($_POST["description"], ENT_QUOTES);
		$keywords = htmlentities($_POST["keywords"], ENT_QUOTES);
		$currency = htmlentities($_POST["currency"], ENT_QUOTES);
		$default_language = htmlentities($_POST["default_language"], ENT_QUOTES);
		$currency_code = htmlentities($_POST["currency_code"], ENT_QUOTES);
		
		$ref_amount = $_POST["ref_amount"];
		$email = $_POST["email"];
		$theme = $_POST["theme"];
		$mobile_theme = $_POST["mobile_theme"];
		$review = $_POST["review_type"];
		$paypal_account_type = $_POST["paypal_account_type"];

		$admin_commission = $_POST["admin_commission"];
		$city_admin_commission = $_POST["city_admin_commission"];
		$paypal_account = htmlentities($_POST["paypal_account"], ENT_QUOTES);
		$min_fund = $_POST["min_fund"];
		$max_fund = $_POST["max_fund"];
		$default_city = $_POST["default_city"];
		$smtp_username = htmlentities($_POST["smtp_username"], ENT_QUOTES);
		$smtp_password = htmlentities($_POST["smtp_password"], ENT_QUOTES);
		$smtp_host = htmlentities($_POST["smtp_host"], ENT_QUOTES);
		$facebook_share = htmlentities($_POST["facebook_share"], ENT_QUOTES);
		$twitter_share = htmlentities($_POST["twitter_share"], ENT_QUOTES);
		$linkedin_share = htmlentities($_POST["linkedin_share"], ENT_QUOTES);
		$fb_fanpage_url = htmlentities($_POST["fb_fanpage_url"], ENT_QUOTES);
		$fb_appid = htmlentities($_POST["fb_appid"], ENT_QUOTES);
		$fb_apikey = htmlentities($_POST["fb_apikey"], ENT_QUOTES);
		$fb_secretkey = htmlentities($_POST["fb_secretkey"], ENT_QUOTES);
		$tw_apikey = htmlentities($_POST["tw_apikey"], ENT_QUOTES);
		$tw_secretkey = htmlentities($_POST["tw_secretkey"], ENT_QUOTES);
		$gmap_apikey = htmlentities($_POST["gmap_apikey"], ENT_QUOTES);

		$paypal_api_password = htmlentities($_POST["paypal_api_password"], ENT_QUOTES);
		$paypal_api_signature = htmlentities($_POST["paypal_api_signature"], ENT_QUOTES);
		$google_analytic = htmlentities(str_replace('&#62;','>',str_replace('&#60;','<',$_POST["google_analytic"])), ENT_QUOTES);		
		$smtp_port = $_POST['smtp_port'];
		$transport_layer_security = htmlentities($_POST['transport_layer_security'], ENT_QUOTES);

		$query = "update general_settings set name = '$name',site_name = '$site_name',description = '$description',keywords = '$keywords',currency = '$currency',currency_code='$currency_code',ref_amount = '$ref_amount',email = '$email',theme = '$theme',mobile_theme = '$mobile_theme', admin_commission = '$admin_commission',city_admin_commission = '$city_admin_commission',paypal_account = '$paypal_account',review_type = '$review',min_fund = '$min_fund',max_fund = '$max_fund',default_language = '$default_language',
smtp_username='$smtp_username',smtp_password='$smtp_password',smtp_host='$smtp_host',facebook_share='$facebook_share',twitter_share='$twitter_share',linkedin_share='$linkedin_share',
fb_fanpage_url='$fb_fanpage_url',fb_apikey='$fb_apikey',fb_secretkey='$fb_secretkey',tw_apikey='$tw_apikey',tw_secretkey='$tw_secretkey',gmap_apikey='$gmap_apikey' 
,default_cityid='$default_city',paypal_api_password='$paypal_api_password',paypal_api_signature='$paypal_api_signature',paypal_account_type='$paypal_account_type', fb_appid='$fb_appid',google_analytic='$google_analytic',smtp_port='$smtp_port',transport_layer_security='$transport_layer_security' where id='$id' ";

		mysql_query($query);
                
                /* Upload logo images into admin and all other themes */                
                		
		if($_FILES)
		{
		        if ($_FILES['site_logo']['type'] == "image/png") //Check for png as type for logo
                        {
                                if(isset($_FILES['site_logo'])) //
                                {
                                        try 
                                        { 
                                                move_uploaded_file($_FILES["site_logo"]["tmp_name"],DOCUMENT_ROOT."/site-admin/images/logo.png");
                                                $source =  DOCUMENT_ROOT."/site-admin/images/logo.png";
				                //$dir = "themes";

						$dir = DOCUMENT_ROOT.'/themes';

				                // Open a known directory, and proceed to read its contents and copy the logo
				                if (is_dir($dir)) {
				
					                if ($dh = opendir($dir)) {
						                while (false !== ($file = readdir($dh))) {
							                if(strlen($file)>2)
							                {
							                         //$newfile = DOCUMENT_ROOT.'/'.$dir.'/'.$file.'/images/logo.png';

$newfile = $dir.'/'.$file.'/images/logo.png';
                     						                 if (!copy($source, $newfile)) {
                                                                                                echo "failed to copy $newfile...\n";
                                                                                 }      
							                }
						                }
						                closedir($dh);
					                }
				                }
				                
                                               
                                        }
                                        catch(Exception $e)
                                        {
                                        }
                                }       
                        }
                        if ($_FILES['footer_logo']['type'] == "image/png")
                        {
                                if(isset($_FILES['footer_logo'])) 
                                {
                                        try 
                                        { 
                                                move_uploaded_file($_FILES["footer_logo"]["tmp_name"],DOCUMENT_ROOT."/site-admin/images/footer_logo.png");
                                                $source =  DOCUMENT_ROOT."/site-admin/images/footer_logo.png";
				                $dir = "themes";
				                // Open a known directory, and proceed to read its contents and copy the footer logo
				                if (is_dir($dir)) {
				
					                if ($dh = opendir($dir)) {
						                while (false !== ($file = readdir($dh))) {
							                if(strlen($file)>2)
							                {
							                         $newfile = DOCUMENT_ROOT.'/'.$dir.'/'.$file.'/images/footer_logo.png';
                     						                 if (!copy($source, $newfile)) {
                                                                                                echo "failed to copy $newfile...\n";
                                                                                 }      
							                }
						                }
						                closedir($dh);
					                }
				                }
				                
                                               
                                        }
                                        catch(Exception $e)
                                        {
                                        }
                                }       
                        }
    
		}
		set_response_mes(1,$admin_language['changesmodified']);
		url_redirect(DOCROOT."admin/general/");
		
		
	}
	
	//get the general site information
	$query = "select * from general_settings limit 1";
	$result_set = mysql_query($query);
	if(mysql_num_rows($result_set))
	{
		$row = mysql_fetch_array($result_set);
	}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#general_settings").validate();});

jQuery.validator.addMethod('compareval', function(value) {
return (parseInt(document.getElementById('max_fund').value)  >  parseInt(document.getElementById('min_fund').value)); }, 'The maximum fund request should not be less than minimum fund request');
</script>

        <form name="general_settings" id="general_settings" action="" enctype="multipart/form-data" method="post" class="ml10">

          
          <input type="hidden" name="id" value="<?php echo $row["id"];?>" />
 <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['general']; ?></legend>
			<p>
              <label for="dummy0"><?php echo $admin_language['applicationtitle']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['enterapplicationtitle']; ?>" name="name" id="name" value="<?php echo html_entity_decode($row["name"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['sitename']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['entersitename']; ?>" name="site_name" id="site_name" value="<?php echo html_entity_decode($row["site_name"], ENT_QUOTES);?>" />
            </p>

	    	<p>
              <label for="dummy3"><?php echo $admin_language['applicationdescription']; ?></label><br>
              <textarea name="description" class="required width400" title="<?php echo $admin_language['enterdesc']; ?>" id="description" rows="5"><?php echo html_entity_decode($row["description"], ENT_QUOTES);?></textarea>
            </p>

	    <p>
              <label for="dummy3"><?php echo $admin_language['applicationkeywords']; ?></label><br>
              <textarea name="keywords" class="required width400" title="<?php echo $admin_language['enterkeywords']; ?>" id="keywords" rows="5"><?php echo html_entity_decode($row["keywords"], ENT_QUOTES);?></textarea><br>
	     <span id="cdescerror" style="color:red"> </span>
		 
        </p>
        <p>
              <label for="dummy0"><?php echo $admin_language['applicationemail']; ?></label><br>
              <input type="text" class="required email" title="<?php echo $admin_language['enteremail']; ?>" name="email" id="email" value="<?php echo $row["email"];?>" />
        </p>

	<p>
              <label for="dummy0"><?php echo $admin_language['theme']; ?></label><br>
			  
			  <select name="theme" id="theme">			  
			   <?php
				$dir = DOCUMENT_ROOT."/themes";
				// Open a known directory, and proceed to read its contents
				if (is_dir($dir)) { 
				
					if ($dh = opendir($dir)) {
						while (false !== ($file = readdir($dh))) {
							if(strlen($file)>2 && $file != 'mobile' && $file != '_base_theme')
							{
     						?>
							<option value="<?php echo $file; ?>" <?php if($row["theme"] == $file) { ?> selected="selected" <?php } ?> ><?php echo $file; ?></option>							
							<?php 
							}
						}
						closedir($dh);
					}
				}
				?>
			  </select>
        </p>
        
        <p>
              <label for="dummy0"><?php echo $admin_language['mobile_theme']; ?></label><br>
			  
			  <select name="mobile_theme" id="mobile_theme">			  
			   <?php
				$dir = DOCUMENT_ROOT."/themes";
				// Open a known directory, and proceed to read its contents
				if (is_dir($dir)) { 
				
					if ($dh = opendir($dir)) {
						while (false !== ($file = readdir($dh))) {
							if(strlen($file)>2 && $file != '_base_theme')
							{
     						?>
								<option value="<?php echo $file; ?>" <?php if($row["mobile_theme"] == $file) { ?> selected="selected" <?php } ?> ><?php echo $file; ?></option>							
							<?php 
							}
						}
						closedir($dh);
					}
				}
				?>
			  </select>
        </p>
       
		<p>
		  <label for="dummy0"><?php echo $admin_language['currency']; ?></label><br>
			   <select name="currency">
				<?php foreach($currency_symbol as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php if(html_entity_decode($row["currency"], ENT_QUOTES)==$key) echo "selected='selected'"; ?>><?php echo $value; ?></option>
				<?php } ?>
	        	    </select>
		</p>
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['defaultlanguage']; ?></label><br>
			   <select name="default_language">
				<?php foreach($lang_list as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php if(html_entity_decode($row["default_language"], ENT_QUOTES)==$key) echo "selected='selected'"; ?>><?php echo $value['lang']; ?></option>
				<?php } ?>
	           </select>
		</p>

		<p>
		  <label for="dummy0"><?php echo $admin_language['defaultcity']; ?></label><br>
			   <select name="default_city">
				<option value="">--<?php echo $admin_language['select']; ?>--</option>
				<?php 
				$queryString = "select * from coupons_cities where status='A' order by cityname asc";
				$resultSet = mysql_query($queryString); 

				 if(mysql_num_rows($resultSet)>0)
				 {
					    while($row2 = mysql_fetch_array($resultSet))
					    {?>

						    <option title="<?php echo ucfirst(html_entity_decode($row2['cityname'], ENT_QUOTES)); ?>" value="<?php echo $row2['cityid']; ?>" <?php if($row2['cityid']==$row['default_cityid']) { ?> selected="selected" <?php } ?>><?php echo ucfirst(html_entity_decode($row2['cityname'], ENT_QUOTES)); ?></option>
	
					   <?php 
	
					    }
				  } ?>

		           </select>
		</p>

			<p>
              <label for="dummy0"><?php echo $admin_language['smtpusername']; ?></label><br>
              <input type="text" class="width400" title="<?php echo $admin_language['enteryoursmtpusername']; ?>" name="smtp_username" value="<?php echo html_entity_decode($row["smtp_username"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['smtppassword']; ?></label><br>
              <input type="text" class="width400" title="<?php echo $admin_language['enteryoursmtppassword']; ?>" name="smtp_password" value="<?php echo html_entity_decode($row["smtp_password"], ENT_QUOTES);?>" />
            </p>

	    <p>
              <label for="dummy0"><?php echo $admin_language['smtphost']; ?></label><br>
              <input type="text" class="width400" title="<?php echo $admin_language['enteryoursmtphost']; ?>" name="smtp_host" value="<?php echo html_entity_decode($row["smtp_host"], ENT_QUOTES);?>" />
            </p>
            <p>
		  <label for="dummy0"><?php echo $admin_language['transport_layer_security']; ?></label><br>
			   <select name="transport_layer_security">
			        <option>select</option>
				<?php foreach($transport_layer as $transport_layer_key => $transport_layer_value) { ?>
				<option value="<?php echo $transport_layer_key; ?>" <?php if(html_entity_decode($row["transport_layer_security"], ENT_QUOTES)==$transport_layer_key) echo "selected='selected'"; ?>><?php echo $transport_layer_value; ?></option>
				<?php } ?>
	        	    </select>

	    </p>
            <p>
              <label for="dummy0"><?php echo $admin_language['smtpport']; ?></label><br>
              <input type="text" class="width400" title="<?php echo $admin_language['enteryoursmtpport']; ?>" name="smtp_port" maxlength="10" value="<?php echo html_entity_decode($row["smtp_port"], ENT_QUOTES);?>" />
            </p>
              
	    <p>
              <label for="dummy0"><?php echo $admin_language['facebookshare']; ?></label><br>
              <input type="text" class="required url width400" title="<?php echo $admin_language['enteryourfacebooksurl']; ?>" name="facebook_share" value="<?php echo html_entity_decode($row["facebook_share"], ENT_QUOTES);?>" />
            </p>

			<p>
              <label for="dummy0"><?php echo $admin_language['twittershare']; ?></label><br>
              <input type="text" class="required url width400" title="<?php echo $admin_language['enteryourtwittershare']; ?>" name="twitter_share" value="<?php echo html_entity_decode($row["twitter_share"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['linkedshare']; ?></label><br>
              <input type="text" class="required url width400" title="<?php echo $admin_language['enteryourlinkedshare']; ?>" name="linkedin_share" value="<?php echo html_entity_decode($row["linkedin_share"], ENT_QUOTES);?>" />
            </p>

			<p>
              <label for="dummy0"><?php echo $admin_language['facebookfanpageurl']; ?></label><br>
              <input type="text" class="required url width400" title="<?php echo $admin_language['enteryourfacebookfanpageurl']; ?>" name="fb_fanpage_url" value="<?php echo html_entity_decode($row["fb_fanpage_url"], ENT_QUOTES);?>" />
            </p>
            <p>
              <label for="dummy0"><?php echo $admin_language['facebookappid']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['enteryourfacebookappid']; ?>" name="fb_appid" value="<?php echo html_entity_decode($row["fb_appid"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['facebookapikey']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['enteryourfacebookaoikey']; ?>" name="fb_apikey" value="<?php echo html_entity_decode($row["fb_apikey"], ENT_QUOTES);?>" />
            </p>

			<p>
              <label for="dummy0"><?php echo $admin_language['facebooksecretkey']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['enteryourfacebooksecret']; ?>" name="fb_secretkey" value="<?php echo html_entity_decode($row["fb_secretkey"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['twitterapikey']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['entertwitterapikey']; ?>" name="tw_apikey" value="<?php echo html_entity_decode($row["tw_apikey"], ENT_QUOTES);?>" />
            </p>

			<p>
              <label for="dummy0"><?php echo $admin_language['twittersecretkey']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['entertwittersecretkey']; ?>" name="tw_secretkey" value="<?php echo html_entity_decode($row["tw_secretkey"], ENT_QUOTES);?>" />
            </p>
			<p>
              <label for="dummy0"><?php echo $admin_language['gmapapikey']; ?></label><br>
              <input type="text" class="required width400" title="<?php echo $admin_language['enteryourgmapapikey']; ?>" name="gmap_apikey" value="<?php echo html_entity_decode($row["gmap_apikey"], ENT_QUOTES);?>" />
            </p>
		
		
</fieldset>


<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['paypalsetting']; ?></legend>

		 <p>
              <label for="dummy0"><?php echo $admin_language['paypal_account_type']; ?></label><br>
			  <input type="radio" name="paypal_account_type" value="1" <?php if($row["paypal_account_type"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['live']; ?>
		</p>
        <p>
			  <input type="radio" name="paypal_account_type" value="0" <?php if($row["paypal_account_type"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['sandbox']; ?>

         </p>

		<p>
		  <label for="dummy0"><?php echo $admin_language['paypalcurrencycode']; ?></label><br>
			   <select name="currency_code">
				<?php foreach($paypal_currency_code as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php if(html_entity_decode($row["currency_code"], ENT_QUOTES)==$key) echo "selected='selected'"; ?>><?php echo $value; ?></option>
				<?php } ?>
	        	    </select>

		</p>

                <p>
		  <label for="dummy0"><?php echo $admin_language['paypalaccount']; ?></label><br>
		  <input type="text" class="required" title="<?php echo $admin_language['enterpaypalaccount']; ?>" name="paypal_account" id="paypal_account" value="<?php echo html_entity_decode($row["paypal_account"], ENT_QUOTES);?>" /> 

		</p>

                <p>
		  <label for="dummy0"><?php echo $admin_language['paypalapipassword']; ?></label><br>
		  <input type="text" class="required" title="<?php echo $admin_language['enterapipassword']; ?>" name="paypal_api_password" id="paypal_api_password" value="<?php echo html_entity_decode($row["paypal_api_password"], ENT_QUOTES);?>" /> 

		</p>

                <p>
		  <label for="dummy0"><?php echo $admin_language['paypalapisignature']; ?></label><br>
		  <input type="text" class="required" title="<?php echo $admin_language['enterapisignature']; ?>" name="paypal_api_signature" id="paypal_api_signature" value="<?php echo html_entity_decode($row["paypal_api_signature"], ENT_QUOTES);?>" /> 

		</p>

		<p>
		  <label for="dummy0"><?php echo $admin_language['referalamount']; ?></label><br>
		  <input type="text" class="required digits" title="<?php echo $admin_language['enterreferralamount']; ?>" maxlength="3" name="ref_amount" id="ref_amount" value="<?php echo $row["ref_amount"];?>" />

		</p>
		</fieldset>
		<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['adminsetting']; ?></legend>
		 
		<p>
              <label for="dummy0"><?php echo $admin_language['reviewtype']; ?></label><br>
			  <input type="radio" name="review_type" value="1" <?php if($row["review_type"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['socialcommentingsystem']; ?>
		</p>
        <p>
			  <input type="radio" name="review_type" value="2" <?php if($row["review_type"] == 2) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['regularcommentingsystem']; ?>
			  
	      </p>		
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['admincommission']; ?></label><br>
		  <input type="text" class="fl required digits" title="<?php echo $admin_language['entershopcommission']; ?>" name="admin_commission" id="admin_commission" maxlength="3" value="<?php echo $row["admin_commission"];?>" /> 
		  <span class="ml10 quite2"><?php echo $admin_language['updateadmincommision']; ?></span>

		</p>
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['cityadmincommission']; ?></label><br>
		  <input type="text" class="fl required digits" title="<?php echo $admin_language['entercityadmincommission']; ?>" name="city_admin_commission" id="city_admin_commission" maxlength="3" value="<?php echo $row["city_admin_commission"];?>" />
		  <span class="ml10 quite2"><?php echo $admin_language['updatecityadmincommission']; ?></span>

		</p>
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['minfundrequest']; ?></label><br>
		  <input type="text" class="fl required digits" title="<?php echo $admin_language['enterminfundrequest']; ?>" name="min_fund" id="min_fund" maxlength="5" value="<?php echo $row["min_fund"];?>" /> 
		  <span class="ml10 quite2"><?php echo $admin_language['updatetheminfundreq']; ?></span>

		</p>
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['maxfund']; ?></label><br>
		  <input type="text" class="compareval fl digits" title="<?php echo $admin_language['entermaxfundreq']; ?>" name="max_fund" id="max_fund" maxlength="10" value="<?php echo $row["max_fund"];?>" />
		  <span class="ml10 quite2"><?php echo $admin_language['updatemaxfundreq']; ?></span>

		</p>
		<p>
		  <label for="dummy0"><?php echo $admin_language['google_analytic']; ?></label><br>
		 <textarea name="google_analytic" id="google_analytic" cols="40" rows="5" class="required" title="<?php echo $language['valid_message']; ?>"><?php echo $row["google_analytic"];?></textarea>

		</p>
		<p>
		  <label for="dummy0"><?php echo $admin_language['sitelogo']; ?></label><br>
		  <input type="file" title="<?php echo $admin_language['selectlogo']; ?>" name="site_logo" id="site_logo"/>
		  <span class="ml10 quite2"><?php echo $admin_language['uploadlogo']; ?></span>
                  
                  <?php
                  if(file_exists(DOCUMENT_ROOT.'/site-admin/images/logo.png'))
                  {
                        ?><p class="borderccc p5"><img src="<?php echo DOCROOT; ?>site-admin/images/logo.png"/></p><?php
                  }
                  ?>
                  </p>
		</p>
		
		<p>
		  <label for="dummy0"><?php echo $admin_language['sitefooterlogo']; ?></label><br>
		  <input type="file" title="<?php echo $admin_language['selectfooerlogo']; ?>" name="footer_logo" id="footer_logo"/>
		  <span class="ml10 quite2"><?php echo $admin_language['uploadlogotype']; ?></span>
                  
                  <?php
                  if(file_exists(DOCUMENT_ROOT.'/site-admin/images/footer_logo.png'))
                  {
                        ?><p class="borderccc p5"><img src="<?php echo DOCROOT; ?>site-admin/images/footer_logo.png"/></p><?php
                  }
                  ?>
                  
		</p>
		
			</fieldset>	
	   		<div class="fl clr">
              <input style="margin-left:13px;" type="submit" onclick="return resplacetags();" value="<?php echo $admin_language['update']; ?>" class=" button_c">
            </div>

        </form>
        <script type="text/javascript">
        function resplacetags()
        {
         var text_val=$("#google_analytic").val();
         text_val=text_val.replace('<','&#60;');
         text_val=text_val.replace('>','&#62;');
         $("#google_analytic").val(text_val);
        }
        
        </script>
        

