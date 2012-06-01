<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<title>{$title}</title>
	<meta http-equiv="Content-Type" content="text/html;charset={$config.charset}" />
<link rel="stylesheet" href="{php} echo DOCROOT;{/php}themes/{php} echo CURRENT_THEME;{/php}/css/{php} if($_SESSION["site_language"]){ echo $_SESSION["site_language"];}else{ echo 'en';}{/php}_style.css"  type="text/css" />
	<meta name="description" content="{$description}" />
	 <link rel="shortcut icon" href="{php} echo DOCROOT;{/php}themes/{php} echo CURRENT_THEME;{/php}/images/favicon.jpg" type="image/x-icon" />
	<meta name="keywords" content="{$keywords}" />
         <script type="text/javascript" src="{php} echo DOCROOT;{/php}themes/{php} echo CURRENT_THEME;{/php}/scripts/jquery.js" ></script>
         <script type="text/javascript" src="{php} echo DOCROOT;{/php}site-admin/scripts/jquery.validate.js" ></script>
</head>

<body>
	
       {php}
   if(CURRENT_THEME=='cristal' || CURRENT_THEME=='livingsocial' || CURRENT_THEME=='nightcity') 
   { 
   {/php}

  <div id="bg"><img src="{php} echo DOCROOT;{/php}themes/{php} echo CURRENT_THEME;{/php}/images/bg_home.jpg" /></div>

  {php} 
   }
  {/php} 
  {php}
  $city_list = array("merun","merun-light");
  if(in_array(CURRENT_THEME,$city_list)) 
     { 
	$queryString = "select * from coupons_cities where status='A' order by cityname asc";
	$resultSet = mysql_query($queryString);
    {/php}
   <div class="city_outer">
  <div class="pb10 citylist_inner" style="display:none;" id="citylist">
 <div class="inner_top1"></div>
    <div class="inner_center1">
	
		<ul class="country_list">

		{php}
		 if(mysql_num_rows($resultSet)>0)
		 {

			    while( $row = mysql_fetch_array($resultSet))
			    {
			     {/php}
				    <li class="fl"><a href="javascript:;" title="{php}echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}" onclick="javascript:citySelect('{php}echo DOCROOT; {/php}','{php}echo CURRENT_THEME; {/php}','{php}echo $row['cityid']; {/php}','{php}echo html_entity_decode($row['cityname'], ENT_QUOTES); {/php}','{php}echo html_entity_decode($row['city_url'], ENT_QUOTES); {/php}');" >{php}echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}</a></li>
	
			   {php}
	
			    }
			    
		}	    
		{/php}

		</ul>
	
	</div>
     <div class="inner_bottom1"></div>
						
</div>
</div>
 {php}
   }
 {/php}     	
   {php}
   if(CURRENT_THEME =='water') 
   {
   $queryString = "select * from coupons_cities where status='A' order by cityname asc";
	$resultSet = mysql_query($queryString);
   {/php}
   <div class="citylist_inner" style="display:none;" id="citylist">
    <div class="inner_center1">	
		<ul class="country_list">

		{php}
		 if(mysql_num_rows($resultSet)>0)
		 {

			    while( $row = mysql_fetch_array($resultSet))
			    {
			    {/php}
				    <li class="fl"><a href="javascript:;" title="{php}echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));{/php}" onclick="javascript:citySelect('{php}echo DOCROOT;{/php}','{php}echo CURRENT_THEME;{/php}','{php}echo $row['cityid'];{/php}','{php}echo html_entity_decode($row['cityname'], ENT_QUOTES);{/php}','{php}echo html_entity_decode($row['city_url'], ENT_QUOTES);{/php}');" >{php}echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));{/php}</a></li>
	
			   {php}
	
			    }			    
		}	    
		{/php}

		</ul>	
	</div>						
</div>
   {php}
   }
   {/php}
  {php}
  $theme_name_list = array("livingsocial","cristal","merun","nightcity","merun-light"); 
    
  if(in_array(CURRENT_THEME,$theme_name_list)) 
   { 
   		$theme_list = array("merun","merun-light");
	 	if(!in_array(CURRENT_THEME,$theme_list)) 
	 	 {
		{/php}
		 <div class="header_outer">  
		   <div class="header_content">
    			<div class="header fl clr">
		{php}	
		 }	 	         
				include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/header.php"); 	
				
	        if(!in_array(CURRENT_THEME,$theme_list))
	 	 {
				                            
		{/php}
	          </div>
	          </div>
		</div>
	   	{php}
        }
   }
   {/php}
  
   {php}	
   if(CURRENT_THEME) 
   { 
   {/php}			 
	 <div class="continer_outer fl clr ">
      		<div class="continer_inner clr"> 
      		{php}

			  if(CURRENT_THEME == 'cristal') 
			     { 
				$queryString = "select * from coupons_cities where status='A' order by cityname asc";
				$resultSet = mysql_query($queryString);
			    {/php}
			      	<div class="select_city_outer">
			   <div class="mt10 pb10 citylist_inner" style="display:none;" id="citylist">

				<div class="inner_top1"></div>
			    <div class="inner_center1">
	
					<ul class="country_list">

					{php} 
					 if(mysql_num_rows($resultSet)>0)
					 {

						    while( $row = mysql_fetch_array($resultSet))
						    {
						     {/php}
							    <li class="fl"><a href="javascript:;" title="{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}" onclick="javascript:citySelect('{php} echo DOCROOT; {/php}','{php} echo CURRENT_THEME; {/php}','{php} echo $row['cityid']; {/php}','{php} echo html_entity_decode($row['cityname'], ENT_QUOTES); {/php}','{php} echo html_entity_decode($row['city_url'], ENT_QUOTES); {/php}');" >{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}</a></li>
	
						   {php} 
	
						    }
						    
					}	    
					{/php}

					</ul>
	
				</div>
				<div class="inner_bottom1"></div>
						
			</div>
			 {php}
			   }
			 {/php}
		      	   {php}
		      	   if(CURRENT_THEME =='livingsocial_v3.1' || CURRENT_THEME =='livingsocial' || CURRENT_THEME=='nightcity') 
			     { 
			     $queryString = "select * from coupons_cities where status='A' order by cityname asc";
			     $resultSet = mysql_query($queryString);
			    {/php}
			       <div class="select_city_outer">
				     <div class="mt10 pb10 citylist_inner" style="display:none;" id="citylist">
				       <div class="inner_top1"></div>
					<div class="inner_center1">
					  <ul class="country_list">
				   {php} 
					 if(mysql_num_rows($resultSet)>0)
					 {

						    while( $row = mysql_fetch_array($resultSet))
						    {
						     {/php}
				    <li class="fl"><a href="javascript:;" title="{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}" onclick="javascript:citySelect('{php} echo DOCROOT; {/php}','{php} echo CURRENT_THEME; {/php}','{php} echo $row['cityid']; {/php}','{php} echo html_entity_decode($row['cityname'], ENT_QUOTES); {/php}','{php} echo html_entity_decode($row['city_url'], ENT_QUOTES); {/php}');" >{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}</a></li>
				   {php} 
	
						    }
						    
					}	    
					{/php}
				  </ul>
				</div>
				<div class="inner_bottom1"></div>
			      </div>
			    </div>
			 {php}
			   }
			 {/php}     	   
          		<div class="continer">
          		
   {php} 
   } 
   {/php}
     
    {php}
   if(!in_array(CURRENT_THEME,$theme_name_list)) 
   { {/php}
         <div class="header_outer">  
          	<div class="header_content">
                               {php}
   
                                include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/header.php");
                                                                 
                                {/php}
                              
                </div>
        </div>
        {php}
		      	 if(CURRENT_THEME =='groupon_v3.1') 
			     { 
			     $queryString = "select * from coupons_cities where status='A' order by cityname asc";
			     $resultSet = mysql_query($queryString);
			    {/php}
			       <div class="mt10  citylist_inner" style="display:none;" id="citylist">
                                <div class="inner_top1"></div>
                                <div class="inner_center1">

	                                <ul class="country_list">

	                                {php} 
	                                 if(mysql_num_rows($resultSet)>0)
	                                 {

		                                    while( $row = mysql_fetch_array($resultSet))
		                                    {
		                                     {/php}
			                                    <li class="fl"><a href="javascript:;" title="{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}" onclick="javascript:citySelect('{php} echo DOCROOT; {/php}','{php} echo CURRENT_THEME; {/php}','{php} echo $row['cityid']; {/php}','{php} echo html_entity_decode($row['cityname'], ENT_QUOTES); {/php}','{php} echo html_entity_decode($row['city_url'], ENT_QUOTES); {/php}');" >{php} echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); {/php}</a></li>

		                                   {php} 

		                                    }
		                                    
	                                }	    
	                                {/php}

	                                </ul>

                                </div>
                                <div class="inner_bottom1"></div>
					
                                </div>

			 {php}
			   }
			 {/php}  
   {php}
   }   
   {/php}
   
                                 <div class="content mt10">
                                 {php} //include($view); {/php}
                                        
			        <!--MAIN MENU STARTS-->
			        <!--{include file="main-menu.tpl"}-->
			        <!--MAIN MENU ENDS-->
			        <div class="content_left">
			            {php}
		                            if(CURRENT_THEME == "livingsocial_v3.1")
		                            {
		                            {/php}
		                            <div class="affliate_header">  </div>
                                    <div class="affliates_content_center" style="padding:0;">                                    
		                            {php}                                    
		                            }
		                            else
		                            {
                                    {/php}
                                             <div class="content_top">
                                       <div class="content_top_left_image fl"></div>
                                    </div>
                                    <div class="content_center">                                     
		                             {php}
		                               }
		                     {/php}
                           <div class="con_center">                

			 {php}if($_COOKIE['aff_id']){include("affiliate_submenu.php");}{/php}
