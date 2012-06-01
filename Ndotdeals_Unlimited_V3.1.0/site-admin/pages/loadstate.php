<?php 
ob_start(); 
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/system/includes/dboperations.php');
require($_SERVER['DOCUMENT_ROOT'].'/system/plugins/common.php');
	
	if($_REQUEST["countrycode"])
	{
        
		if($_SESSION['userrole']==1){
		$queryString = "select * from coupons_cities where status='A' and countryid = ".$_REQUEST["countrycode"];
		}else{
		$queryString = "select * from coupons_cities where status='A' and cityid = ".$_SESSION["cityid"];
		}
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			if($_REQUEST["type"]==n)
			echo ' <label for="dummy1" class="mt10" >Location</label><br> <select class="required" name="city" id="city" title="Choose the location"><option value=""> - Choose - </option>';
                        else
                        echo ' <label for="dummy1">Location</label><br> <select class="required" title="Choose the location" name="city" id="city" onchange="loadcityshop(this.value)"><option value=""> - Choose - </option>';
			while($noticia=mysql_fetch_array($resultSet)){
				echo '<option value="'.$noticia["cityid"].'">'.html_entity_decode($noticia["cityname"], ENT_QUOTES).'</option>';
			}
                        if($_REQUEST["type"]==n)
			echo '</select></p>';
                        else
                        echo '</select><br><span id="cityshopdetails"> </span> </p>';
		}
	}

	elseif($_REQUEST["eccountrycode"])
	{
        
		$queryString = "select * from coupons_cities where status='A' and countryid = ".$_REQUEST["eccountrycode"];
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			if($_REQUEST["type"]==n)
			echo ' <label for="dummy1">Location</label><br> <select name="city" id="city"><option value=""> - Choose - </option>';
                        else
                        echo ' <label for="dummy1" class="mt10">Location</label><br> <select class="required" title="Choose the location" name="city" id="city" onchange="ecloadcityshop(this.value)"><option value=""> - Choose - </option>';
			while($noticia=mysql_fetch_array($resultSet)){
				echo '<option value="'.$noticia["cityid"].'">'.html_entity_decode($noticia["cityname"], ENT_QUOTES).'</option>';
			}
                        if($_REQUEST["type"]==n)
			echo '</select><font style="float:left; color:#ff9f00; font-size:11px;">(Optional)</font><br></span> </p>';
                        else
                        echo '</select><br><span id="cityshopdetails"> </span> </p>';
		}
	}
	
        else if($_REQUEST["shopcode"])
        {

             $queryString = "select shopid,shopname,l.cityname from coupons_shops,coupons_cities l where coupons_shops.shop_status='A' and shop_city=l.cityid and shopid = ".$_REQUEST["shopcode"];
             
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			
			echo '<label for="dummy1">Shop Name</label><br><select name="shop" id="shop""><option value="-2"> - Choose - </option>';
			while($noticia=mysql_fetch_array($resultSet)){
			echo '<option value="'.$noticia["shopid"].'">'.html_entity_decode($noticia["shopname"], ENT_QUOTES).'</option>';
			}
			echo '</select>';

		}
        }


        else if($_REQUEST["shopcodedetails"])
        {

             $queryString = "select shopname,l.cityname from coupons_shops,coupons_cities l where coupons_shops.shop_status='A' and shop_city=l.cityid and shopid = ".$_REQUEST["shopcodedetails"];
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			
			echo ' <p style="padding: 3px 3px 3px 3px ;border:2px solid #CCCCCC"><span style="color:#666;font-weight:bold;">Shop Details </span><br>';
			while($noticia=mysql_fetch_array($resultSet)){
				echo 'Shop Name     : '.html_entity_decode($noticia["shopname"], ENT_QUOTES);
                                echo '&nbsp;&nbsp;Shop Location : '.html_entity_decode($noticia["cityname"], ENT_QUOTES);
			}
			
			echo '</p>';
		}
        }


        else if($_REQUEST["citycode"])
        {

        $queryString = "select shopid,shopname,l.cityname,shop_address from coupons_shops,coupons_cities l where coupons_shops.shop_status='A' and shop_city=l.cityid and shop_city = ".$_REQUEST["citycode"];
		$resultSet = mysql_query($queryString);

			echo '<label for="dummy1" class="fl mt10">Shop Name</label><br><select title="Choose the shop name" name="shop" id="shop""><option value=""> - Choose - </option>';
			
			if(mysql_num_rows($resultSet)>0){
			
			while($noticia=mysql_fetch_array($resultSet)){
			echo '<option value="'.$noticia["shopid"].'">'.html_entity_decode($noticia["shopname"], ENT_QUOTES).'</option>';
									      }
								}

			echo '</select>';
			
        }

        else if($_REQUEST["eccitycode"])
        {

        $queryString = "select shopid,shopname,l.cityname,shop_address from coupons_shops,coupons_cities l where coupons_shops.shop_status='A' and shop_city=l.cityid and shop_city = ".$_REQUEST["eccitycode"];
		$resultSet = mysql_query($queryString);

			echo '<label for="dummy1" class="fl mt10">Shop Name</label><br><select class="required" title="Choose the shop name" name="shop" id="shop""><option value=""> - Choose - </option>';
			
			if(mysql_num_rows($resultSet)>0){
			
			while($noticia=mysql_fetch_array($resultSet)){
			echo '<option value="'.$noticia["shopid"].'">'.html_entity_decode($noticia["shopname"], ENT_QUOTES).'</option>';
									      }
								}

			echo '</select>';
			
        }

	else if($_REQUEST["shopcountrycode"])
	{
	$queryString = "select * from coupons_cities where status='A' and countryid = ".$_REQUEST["shopcountrycode"];
		$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet) > 0){
	
			echo '<label for="dummy1" class="mt10 fl clr" >Location</label><br> <select class="required" name="city" id="city" title="Choose the location"><option value=""> - Choose - </option>';
			while($noticia = mysql_fetch_array($resultSet)){
			
				echo '<option value="'.$noticia["cityid"].'">'.html_entity_decode($noticia["cityname"], ENT_QUOTES).'</option>';
			
			}
			echo '</select>';
		          echo '</select><br> <span id="cityshopdetails"> </span> </p>';
		}
	}	

	else if($_REQUEST["loadcooponcountry"])
	{
		if($_SESSION['userrole']=='2') {
		 $queryString = "select * from coupons_cities where status='A' and countryid = ".$_SESSION['countryid']." and cityid = ".$_SESSION['cityid']." ";
		 $resultSet = mysql_query($queryString);
		}

		if($_SESSION['userrole']=='3') {
		$queryString= "select * from coupons_users where userid = ".$_SESSION["userid"];
		$resultSet = mysql_query($queryString);
		if($noticia=mysql_fetch_array($resultSet))
		{
		$user_shopid = $noticia['user_shopid'];
		}

		$queryString= "SELECT c.cityid,c.cityname FROM coupons_shops s, coupons_cities c where s.shop_status='A' and c.status='A' and s.shop_city=c.cityid and s.shopid = ".$user_shopid;
		
		$resultSet = mysql_query($queryString);

		}		
		
		if(mysql_num_rows($resultSet)>0){ 
			if($_REQUEST["type"]==n)
			
                        echo ' <label for="dummy1" class="clr fl mt10">Location</label><br> <select title="Choose the location" class="required"  name="city" id="city" onchange="loadcooponcityshop(this.value)"><option value=""> - Choose - </option>';
                        else
                        echo ' <label for="dummy1" class="clr fl mt10">Location</label><br> <select title="Choose the location" class="required" name="city" id="city" onchange="loadcooponcityshop(this.value)"><option value=""> - Choose - </option>';
                        
                        if($_SESSION['userrole']=='2') { 
			while($noticia=mysql_fetch_array($resultSet)){
			?>
				<option value="<?php echo $noticia['cityid'];?>" ><?php echo html_entity_decode($noticia["cityname"], ENT_QUOTES);?></option>
			<?php
			}
			}?>

<?php                        if($_SESSION['userrole']=='3') { 
			while($noticia=mysql_fetch_array($resultSet)){
			?>
				<option value="<?php echo $noticia['cityid'];?>" ><?php echo html_entity_decode($noticia["cityname"], ENT_QUOTES);?></option>
			<?php
			}
			}?>
			
			<?php
                        if($_REQUEST["type"]==n)
						echo '</select> <font style="color:#ff9f00; font-size:11px;"></font> </p>';
                        else
				                    echo '</select><br> <span id="cityshopdetails"> </span> </p>';
		}
	}
	

        else if($_REQUEST["cooponcitycode"])
        {

		if($_SESSION['userrole']=='2')
		{
			   $queryString = "select shopid,shopname,l.cityname,shop_address from coupons_shops,coupons_cities l where coupons_shops.shop_status='A' and shop_city=l.cityid and shop_city = ".$_REQUEST["cooponcitycode"];
			   }
		if($_SESSION['userrole']=='3')             
		{
			   $queryString = "select shopid,shopname from coupons_shops where coupons_shops.shop_status='A' and shopid = ".$_SESSION["user_shopid"];
		}
		
		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			
			echo '<label for="dummy1" class="fl mt10">Shop Name</label><br><select class="required" title="Choose the shop name" name="shop" id="shop""><option value=""> - Choose - </option>';
			while($noticia=mysql_fetch_array($resultSet)){
			echo '<option value="'.$noticia["shopid"].'">'.html_entity_decode($noticia["shopname"], ENT_QUOTES).'</option>';
			}
			echo '</select>';
		}
		
        }
        

	else if($_REQUEST["eusrcountrycode"])
	{

		if($_SESSION['userrole']==1)
		{

				$queryString = "select * from coupons_cities where status='A' and countryid = ".$_REQUEST['eusrcountrycode'];
		}
		else
		{

				$queryString = "select * from coupons_cities where status='A' and countryid = ".$_REQUEST['eusrcountrycode']." and cityid = ".$_SESSION['cityid'];
		}		

		$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet)>0){
			if($_REQUEST["type"]==n)
			echo ' <label for="dummy1">Location</label><br> <select name="city" id="city"><option value="-2"> - Choose - </option>';
                        else
                        echo ' <label for="dummy1">Location</label><br> <select name="city" id="city" onchange="loadcityshop(this.value)"><option value="-2"> - Choose - </option>';
			while($noticia=mysql_fetch_array($resultSet)){
				echo '<option value="'.$noticia["cityid"].'">'.html_entity_decode($noticia["cityname"], ENT_QUOTES).'</option>';
			}
                        if($_REQUEST["type"]==n)
			echo '</select> <font style="float:left; color:#ff9f00; font-size:11px;">(Optional)</font></p>';
                        else
                        echo '</select><br> <span id="cityshopdetails"> </span> </p>';
		}
	}
	else if($_REQUEST["permalink"])
	{
		echo friendlyURL($_REQUEST["permalink"]);
	}
ob_flush(); 
?>
