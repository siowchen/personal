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
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="<?php echo $html_content_type; ?>" />
  <meta name="description" content="<?php echo $meta_description;?>" />
  <meta name="keywords" content="<?php echo $meta_keywords;?>" />
  <title><?php echo $page_title; ?> | <?php echo APP_NAME;?></title>
	<?php 
	if($admin_lang)
	{ ?>
			  <link rel="stylesheet" type="text/css" href="<?php echo DOCROOT; ?>site-admin/css/admin_<?php echo $admin_lang;?>_style.css" />
	<?php 
	}
	else
	{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo DOCROOT; ?>site-admin/css/admin_en_style.css" />
  <?php } ?>
  <link rel="shortcut icon" href="<?php echo DOCROOT;?>site-admin/images/favicon.jpg" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="<?php echo DOCROOT; ?>site-admin/css/jquery.cleditor.css" />  
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/jquery.js" /></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/jquery.validate.js" /></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/common.js" /></script>
  
    
  </head>
  <body>

	<div class="container_outer ">
		    <?php include("header.php"); // include the header file ?>

	    <div class="container ">
		<?php
			success_mes(); //display success message
			failed_mes();  //display failure message
		?>		    
	        <div class="container_inn ">              
		        <?php include($view); ?>              
		              <?php include("footer.php"); //include the footer ?>
	        </div>
	    </div>             
	     
	</div>
      
  </body>
  </html>
