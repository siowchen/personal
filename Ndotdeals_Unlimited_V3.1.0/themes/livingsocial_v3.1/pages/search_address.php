<?php 

/******************************************** 
 * @Created on October, 2011 * @Package: Ndotdeals unlimited v3.0

 * @Author: NDOT

 * @URL : http://www.NDOT.in

 ********************************************/

 ?>

<link href="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME;?>/css/slider_screen.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME;?>/css/map_popbox.css" type="text/css" >
<script src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/scripts/multistep.js?vGis9EFL" type="text/javascript"></script>
<link href="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/css/nearbymap/steps.css" media="screen" rel="stylesheet" type="text/css" />

<?php 
//get the cityname list
$category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");
?>
<script type="text/javascript">
$(document).ready(function() {		
		$('.window .gmap_close').click(function (e) {	
    	      alert('window');
		e.preventDefault();
		
		$('.window').hide();

	});		
			
});
</script>
<div id="pop" class="popup_block" style="width:440px; margin:auto;">
  <div class="pop-up-left"></div>
   <div class="pop-content">
	<div class="close-header" style="float:left;"> 
	  <a id="close-button" title="Close Login Window" class="close" href="http://<?php echo $_SERVER["HTTP_HOST"] ;?>/">
	  	<img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/nearbymap/clse.png" alt="Close" title="Close" />
	  </a> 
	</div>
	
	 <h2><?php echo $language['enter_your_location'];?></h2>
	 <div class="work_bottom2" ></div>
              <p><?php echo $language["find_out_more"];?></p>

              <div class="head_rgt_bottom">
		       <form action="<?php echo DOCROOT; ?>nearbymap.html" method="post" id="new_subscription" name="new_subscription">

				<select name="address" type="text" id="search"  class="t_box1 required" />
				<?php while($city_row = mysql_fetch_array($category_list)) { ?>
            <option value="<?php echo $city_row['cityid'];?>" <?php if($_COOKIE['defaultcityId'] == $city_row["cityid"]){ echo "selected";} ?>><?php echo ucfirst(html_entity_decode($city_row["cityname"], ENT_QUOTES));?></option>
            <?php } ?>
		                </select>
		                  <input type="hidden" name="getcityname" id="getcityname" value="<?php echo html_entity_decode($city_row['cityname'], ENT_QUOTES);?>" >
		                 <div class="search_add"> 
		                <div class="let_get mt10">
		                   <input class="let_sub" type="submit" value="<?php echo $language['let_get_coupon']; ?>" role="button" aria-disabled="false">
		                </div> 
		                </div>

		       </form>
               </div>   
   </div>
 <div class="pop-up-rght"></div>
    
</div>

<script type='text/javascript'>
      //<![CDATA[
        document.body.className += " js_enabled";

</script>
<script type="text/javascript">
$(document).ready(function(){
					   		   
	//When you click on a link with class of poplight and the href starts with a # 
		var popID = 'pop'; //Get Popup Name
		var popWidth ='650'; //Gets the first query string value
		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="http://<?php echo $_SERVER["HTTP_HOST"] ;?>/" class="close"></a>');
		
		
		
		//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		
		//Apply Margin to Popup
		$('#' + popID).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		//Fade in Background
		$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
		
		return false;
	});
	
	
	//Close Popups and Fade Layer
	$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
	  	$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();
			
	}); //fade them both out
		
		return false;
	});

	
</script>


