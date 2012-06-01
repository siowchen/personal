<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<?php 
  //meta description
  if(empty($meta_description))
  {
  	$meta_description = APP_DESC;
  }
  
  //meta keywords
  if(empty($meta_keywords))
  {
  	$meta_keywords = APP_KEYWORDS;
  }

  //header('Content-type: $php_content_type');  //charset
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="<?php echo $html_content_type; ?>" />
<meta name="description" content="<?php echo $meta_description;?>" />
<meta name="keywords" content="<?php echo $meta_keywords;?>" />
<link rel="shortcut icon" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/favicon.ico" type="image/x-icon" />
<title><?php echo $page_title; ?> | <?php echo APP_NAME;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/css/<?php if($_SESSION["site_language"]){ echo $_SESSION["site_language"];}else{ echo "en";}?>_style.css" />

<!--deals info content page start-->
<link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/subscribe.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/invite.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/tabs.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/slider.css" type="text/css" media="screen" />
<link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<!--deals info content page end-->
<!--deals nearby_deals page start-->
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/nearbymap/map-style.css" rel="stylesheet" type="text/css" media="screen" /> 
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/nearbymap/nearby_deals_map.css" rel="stylesheet" type="text/css" media="screen" /> 
<!--deals nearby_deals page end-->

<!--Deals now start -->
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/dealsnow/map-style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/dealsnow/dealsnow_style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/css/dealsnow/screen.css" rel="stylesheet" type="text/css" media="screen" />
<!--Deals now end -->
<script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/jquery.js" >
</script>
<script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/jquery.validate.js" >
</script>

<style type="text/css">
.text-label {
    color: #cdcdcd !important;
    font-weight: bold;
	font-style:italic;
}
</style>

<?php
 //google analytic code
 echo GOOGLE_ANALYTIC_CODE;
?>
</head>
<body>

<?php 
		/*if(!isset($_COOKIE['defaultcityId']))
		{
		        if($url_arr[1] != 'unsubscribe.html')
		        {
		                require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/pages/steps.php');   
		        }
		}*/
		?>
<div class="header_outer">
  <div class="header_content">
    <div class="header fl clr">
      <?php include("header.php"); // include the header file ?>
    </div>
  </div>
</div>
<div class="continer_outer fl clr">
  <div class="continer_inner clr">
    <div class="select_city_outer">
      <div class="mt10 pb10 citylist_inner" style="display:none;" id="citylist">
        <div class="inner_top1"></div>
        <div class="inner_center1">
          <ul class="country_list">
            <?php 
		 if(mysql_num_rows($resultSet)>0)
		 {

			    while( $row = mysql_fetch_array($resultSet))
			    {
			     ?>
            <li class="fl"><a href="javascript:;" title="<?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); ?>" onclick="javascript:citySelect('<?php echo DOCROOT; ?>','<?php echo CURRENT_THEME; ?>','<?php echo $row['cityid']; ?>','<?php echo html_entity_decode($row['cityname'], ENT_QUOTES); ?>','<?php echo html_entity_decode($row['city_url'], ENT_QUOTES); ?>');" ><?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); ?></a></li>
            <?php 
	
			    }
			    
		}	    
		?>
          </ul>
        </div>
        <div class="inner_bottom1"></div>
      </div>
    </div>
    <div class="continer">
      <?php 
					success_mes(); //success message
					failed_mes();	//failed response message			  
				  	?>
      <div class="content">
        <?php include($view); ?>
      </div>
    </div>
    
  </div>
</div>

<!--close tag for container-->
<?php include("footer.php"); //include the footer ?>

</body>
</html>
