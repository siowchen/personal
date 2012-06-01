<?php /* Smarty version 2.6.14, created on 2012-01-03 13:20:54
         compiled from header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<title><?php echo $this->_tpl_vars['title']; ?>
</title>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_tpl_vars['config']['charset']; ?>
" />
<link rel="stylesheet" href="<?php  echo DOCROOT; ?>themes/<?php  echo CURRENT_THEME; ?>/css/<?php  if($_SESSION["site_language"]){ echo $_SESSION["site_language"];}else{ echo 'en';} ?>_style.css"  type="text/css" />
	<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
	 <link rel="shortcut icon" href="<?php  echo DOCROOT; ?>themes/<?php  echo CURRENT_THEME; ?>/images/favicon.jpg" type="image/x-icon" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
         <script type="text/javascript" src="<?php  echo DOCROOT; ?>themes/<?php  echo CURRENT_THEME; ?>/scripts/jquery.js" ></script>
         <script type="text/javascript" src="<?php  echo DOCROOT; ?>site-admin/scripts/jquery.validate.js" ></script>
</head>

<body>
	
       <?php 
   if(CURRENT_THEME=='cristal' || CURRENT_THEME=='livingsocial' || CURRENT_THEME=='nightcity') 
   { 
    ?>

  <div id="bg"><img src="<?php  echo DOCROOT; ?>themes/<?php  echo CURRENT_THEME; ?>/images/bg_home.jpg" /></div>

  <?php  
   }
   ?> 
  <?php 
  $city_list = array("merun","merun-light");
  if(in_array(CURRENT_THEME,$city_list)) 
     { 
	$queryString = "select * from coupons_cities where status='A' order by cityname asc";
	$resultSet = mysql_query($queryString);
     ?>
   <div class="city_outer">
  <div class="pb10 citylist_inner" style="display:none;" id="citylist">
 <div class="inner_top1"></div>
    <div class="inner_center1">
	
		<ul class="country_list">

		<?php 
		 if(mysql_num_rows($resultSet)>0)
		 {

			    while( $row = mysql_fetch_array($resultSet))
			    {
			      ?>
				    <li class="fl"><a href="javascript:;" title="<?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?>" onclick="javascript:citySelect('<?php echo DOCROOT;  ?>','<?php echo CURRENT_THEME;  ?>','<?php echo $row['cityid'];  ?>','<?php echo html_entity_decode($row['cityname'], ENT_QUOTES);  ?>','<?php echo html_entity_decode($row['city_url'], ENT_QUOTES);  ?>');" ><?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?></a></li>
	
			   <?php 
	
			    }
			    
		}	    
		 ?>

		</ul>
	
	</div>
     <div class="inner_bottom1"></div>
						
</div>
</div>
 <?php 
   }
  ?>     	
   <?php 
   if(CURRENT_THEME =='water') 
   {
   $queryString = "select * from coupons_cities where status='A' order by cityname asc";
	$resultSet = mysql_query($queryString);
    ?>
   <div class="citylist_inner" style="display:none;" id="citylist">
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
</div>
   <?php 
   }
    ?>
  <?php 
  $theme_name_list = array("livingsocial","cristal","merun","nightcity","merun-light"); 
    
  if(in_array(CURRENT_THEME,$theme_name_list)) 
   { 
   		$theme_list = array("merun","merun-light");
	 	if(!in_array(CURRENT_THEME,$theme_list)) 
	 	 {
		 ?>
		 <div class="header_outer">  
		   <div class="header_content">
    			<div class="header fl clr">
		<?php 	
		 }	 	         
				include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/header.php"); 	
				
	        if(!in_array(CURRENT_THEME,$theme_list))
	 	 {
				                            
		 ?>
	          </div>
	          </div>
		</div>
	   	<?php 
        }
   }
    ?>
  
   <?php 	
   if(CURRENT_THEME) 
   { 
    ?>			 
	 <div class="continer_outer fl clr ">
      		<div class="continer_inner clr"> 
      		<?php 

			  if(CURRENT_THEME == 'cristal') 
			     { 
				$queryString = "select * from coupons_cities where status='A' order by cityname asc";
				$resultSet = mysql_query($queryString);
			     ?>
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
							    <li class="fl"><a href="javascript:;" title="<?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?>" onclick="javascript:citySelect('<?php  echo DOCROOT;  ?>','<?php  echo CURRENT_THEME;  ?>','<?php  echo $row['cityid'];  ?>','<?php  echo html_entity_decode($row['cityname'], ENT_QUOTES);  ?>','<?php  echo html_entity_decode($row['city_url'], ENT_QUOTES);  ?>');" ><?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?></a></li>
	
						   <?php  
	
						    }
						    
					}	    
					 ?>

					</ul>
	
				</div>
				<div class="inner_bottom1"></div>
						
			</div>
			 <?php 
			   }
			  ?>
		      	   <?php 
		      	   if(CURRENT_THEME =='livingsocial_v3.1' || CURRENT_THEME =='livingsocial' || CURRENT_THEME=='nightcity') 
			     { 
			     $queryString = "select * from coupons_cities where status='A' order by cityname asc";
			     $resultSet = mysql_query($queryString);
			     ?>
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
				    <li class="fl"><a href="javascript:;" title="<?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?>" onclick="javascript:citySelect('<?php  echo DOCROOT;  ?>','<?php  echo CURRENT_THEME;  ?>','<?php  echo $row['cityid'];  ?>','<?php  echo html_entity_decode($row['cityname'], ENT_QUOTES);  ?>','<?php  echo html_entity_decode($row['city_url'], ENT_QUOTES);  ?>');" ><?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?></a></li>
				   <?php  
	
						    }
						    
					}	    
					 ?>
				  </ul>
				</div>
				<div class="inner_bottom1"></div>
			      </div>
			    </div>
			 <?php 
			   }
			  ?>     	   
          		<div class="continer">
          		
   <?php  
   } 
    ?>
     
    <?php 
   if(!in_array(CURRENT_THEME,$theme_name_list)) 
   {  ?>
         <div class="header_outer">  
          	<div class="header_content">
                               <?php 
   
                                include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/header.php");
                                                                 
                                 ?>
                              
                </div>
        </div>
        <?php 
		      	 if(CURRENT_THEME =='groupon_v3.1') 
			     { 
			     $queryString = "select * from coupons_cities where status='A' order by cityname asc";
			     $resultSet = mysql_query($queryString);
			     ?>
			       <div class="mt10  citylist_inner" style="display:none;" id="citylist">
                                <div class="inner_top1"></div>
                                <div class="inner_center1">

	                                <ul class="country_list">

	                                <?php  
	                                 if(mysql_num_rows($resultSet)>0)
	                                 {

		                                    while( $row = mysql_fetch_array($resultSet))
		                                    {
		                                      ?>
			                                    <li class="fl"><a href="javascript:;" title="<?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?>" onclick="javascript:citySelect('<?php  echo DOCROOT;  ?>','<?php  echo CURRENT_THEME;  ?>','<?php  echo $row['cityid'];  ?>','<?php  echo html_entity_decode($row['cityname'], ENT_QUOTES);  ?>','<?php  echo html_entity_decode($row['city_url'], ENT_QUOTES);  ?>');" ><?php  echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));  ?></a></li>

		                                   <?php  

		                                    }
		                                    
	                                }	    
	                                 ?>

	                                </ul>

                                </div>
                                <div class="inner_bottom1"></div>
					
                                </div>

			 <?php 
			   }
			  ?>  
   <?php 
   }   
    ?>
   
                                 <div class="content mt10">
                                 <?php  //include($view);  ?>
                                        
			        <!--MAIN MENU STARTS-->
			        <!--<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->
			        <!--MAIN MENU ENDS-->
			        <div class="content_left">
			            <?php 
		                            if(CURRENT_THEME == "livingsocial_v3.1")
		                            {
		                             ?>
		                            <div class="affliate_header">  </div>
                                    <div class="affliates_content_center" style="padding:0;">                                    
		                            <?php                                     
		                            }
		                            else
		                            {
                                     ?>
                                             <div class="content_top">
                                       <div class="content_top_left_image fl"></div>
                                    </div>
                                    <div class="content_center">                                     
		                             <?php 
		                               }
		                      ?>
                           <div class="con_center">                

			 <?php if($_COOKIE['aff_id']){include("affiliate_submenu.php");} ?>