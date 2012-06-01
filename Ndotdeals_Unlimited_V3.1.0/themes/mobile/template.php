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
  <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="<?php echo $html_content_type; ?>" />
  <meta name="description" content="<?php echo $meta_description;?>" />
  <meta name="keywords" content="<?php echo $meta_keywords;?>" />

  <link rel="shortcut icon" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/images/favicon.jpg" type="image/x-icon" />
  <title><?php echo $page_title; ?> | <?php echo APP_NAME;?> </title>
  <link rel="stylesheet" type="text/css" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/css/mobile_style.css" />

  <script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/jquery.js" /></script>
  <script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/scripts/jquery.validate.js" /></script>
  <link href="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
  <script src="<?php echo $docroot; ?>themes/<?php echo CURRENT_THEME; ?>/scripts/jquery.countdown.js" type="text/javascript"></script>
   <?php
 	//google analytic code
 	echo GOOGLE_ANALYTIC_CODE;
   ?>
  </head>
  <body>
  			
        
    <div class="mobile_container">
	  <div class="mobile_inner">          
   	<?php include("header.php"); // include the header file ?>  
	  <div class="state">
	<?php 
        success_mes(); //success message
        failed_mes();	//failed response message			  
        ?>
    	</div>
      <?php include($view); ?>
	</div>
    </div>

  	<!--close tag for container-->
    <?php //include("footer.php"); //include the footer ?>
      
  </body>
  </html>
