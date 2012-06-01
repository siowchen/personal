<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

if($url_arr[2]=='couponsupload' && $_SESSION["userrole"] == 3)
{?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_6").slideToggle();
	document.getElementById("left_menubutton_6").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	$("#is_video1").click(function(){
	        $("#deal_slider").hide();
	        $("#deal_video").show();
	});
	$("#is_video0").click(function(){
	        $("#deal_slider").show();
	        $("#deal_video").hide();
	});
	});
	</script>
<?php
}

if($url_arr[2]=='couponsupload' && $_SESSION["userrole"] != 3)
{?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_104").slideToggle();
	document.getElementById("left_menubutton_104").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	$("#is_video1").click(function(){
	        $("#deal_slider").hide();
	        $("#deal_video").show();
	});
	$("#is_video0").click(function(){
	        $("#deal_slider").show();
	        $("#deal_video").hide();
	});
	});
	</script>
<?php
}


	if($_POST)
	{

		$cname = htmlentities($_POST['couponname'], ENT_QUOTES);
		$city = $_POST['city'];
		$terms = htmlentities($_POST['termscondition'], ENT_QUOTES);
		$queryString = "select * from coupons_coupons where coupon_name = '$cname' and coupon_city = '$city'";
		$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			$redirect_url = DOCROOT."admin/couponsupload/";
			set_response_mes(-1, $admin_language['couponnameexist']); 		
			url_redirect($redirect_url);		
		}
		else
		{
			$value = couponUpload();
			$redirect_url = DOCROOT."admin/couponsupload/";
			set_response_mes(1,$admin_language['couponcreated']); 	
			url_redirect($redirect_url);
    
		}
    
}
?>


		<link type="text/css" href="<?php echo DOCROOT; ?>/site-admin/scripts/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo DOCROOT; ?>/site-admin/scripts/jquery-ui-1.8.11.custom/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo DOCROOT; ?>/site-admin/scripts/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
		<script src="<?php echo DOCROOT; ?>/site-admin/scripts/datetimepicker/jquery13/jquery.validate.pack.js" type="text/javascript"></script>
		<script src="<?php echo DOCROOT; ?>/site-admin/scripts/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
		<script src="<?php echo DOCROOT; ?>/site-admin/scripts/jquery.cleditor.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#cstartdate").datetimepicker( {
	showSecond: true,
	timeFormat: 'hh:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 1,
	stepMinute: 1,
	stepSecond: 1
	} );

    $("#cenddate").datetimepicker( {
	showSecond: true,
	timeFormat: 'hh:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 1,
	stepMinute: 1,
	stepSecond: 1
	} );
	
    $("#cexpdate").datetimepicker( {
	showSecond: true,
	timeFormat: 'hh:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 1,
	stepMinute: 1,
	stepSecond: 1
	} );
  });
  
  

/* validation */
$(document).ready(function(){ $("#coupon_upload_form").validate();});

jQuery.validator.addMethod('cmpstartdt', function(value) {
var cstartdate=document.getElementById('cstartdate').value; 
var currentdate = '<?php echo date("Y-m-d H:i:s"); ?>';
return (cstartdate >= currentdate); }, '...');

jQuery.validator.addMethod('cmpenddt', function(value) {
var cstartdate=document.getElementById('cstartdate').value; 
var cenddate=document.getElementById('cenddate').value; 
return (cenddate > cstartdate); }, '...');

jQuery.validator.addMethod('cmpexpdt', function(value) {
var cexpdate=document.getElementById('cexpdate').value; 
var enddate = document.getElementById('cenddate').value; 
return (cexpdate > enddate); }, '...');

jQuery.validator.addMethod('phone', function(value) {
var numbers = value.split(/\d/).length - 1;
return (9 <= numbers && numbers <= 20 && value.match(/^(\+){0,1}(\d|\s|\(|\)|\-){9,20}$/)); }, 'Please enter a valid phone number');

jQuery.validator.addMethod('compareval', function(value) {
return (parseInt(document.getElementById('maxlimit').value)  >=  parseInt(document.getElementById('minlimit').value)); }, 'The coupon maximum user limit should not be less than minimum user limit');

jQuery.validator.addMethod('maxdeal', function(value) {
var limit = parseInt(document.getElementById('maxdealpurchase').value);
if(isNaN(limit)){ 
	limit = 0;
}
return ( (parseInt(document.getElementById('maxlimit').value)  >= limit ) ); }, 'The maximum deal Purchase limit per user should not be greater than maximum user limit');

jQuery.validator.addMethod('chkval', function(value) { 
return (parseInt(document.getElementById('crealvalue').value)  >= document.getElementById('cdiscountvalue').value); }, '...');

jQuery.validator.addMethod('chkamt', function(value) {
return (parseInt(document.getElementById('crealvalue').value)  > 0); }, '...');
</script>
        <!-- ClEdit fun start here-->
	  
         <script type="text/javascript">
		  $(document).ready(function() {
		  
			$("#cdesc").cleditor();
			$("#cfineprints").cleditor();
			$("#chighlights").cleditor();
			$("#termscondition").cleditor();
		  });
         </script>     
         <!-- ClEdit end-->
      
    
        <form name="coupon_upload_form" id="coupon_upload_form" action="" enctype="multipart/form-data" method="post">
      <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['generaldetail']; ?></legend>
            <p>
              <label for="dummy0"><?php echo $admin_language['name']; ?></label><br/>
              <input type="text" class="required width400" title="<?php echo $admin_language['entercouponname']; ?>" name="couponname" id="couponname" value="" onchange="generate_permalink(this.value,'deal_permalink');" />
            </p>
            <p>
              <label for="dummy0"><?php echo $admin_language['permalink']; ?></label><br/>
              <input type="text" class="required width400" title="<?php echo $admin_language['permalink_required']; ?>" name="deal_permalink" id="deal_permalink" value="" />
              <br />
			  <span class="quite"><?php echo $admin_language['permalink_ex']; ?></span>
            </p>

	   		<p>
              <label for="dummy3"><?php echo $admin_language['description']; ?></label>
              <textarea name="cdesc" class="required width400" title="<?php echo $admin_language['entercoupondesc']; ?>" id="cdesc" rows="7" cols="35"></textarea>
               <label class="error" for="cdesc"  style="display:none" generated="true"><?php echo $admin_language['entercoupondesc']; ?></label>            
            </p>
            
	 
	    	<p>
              <label for="dummy3"><?php echo $admin_language['fineprints']; ?></label>
              <textarea name="cfineprints" class="width400" title="<?php echo $admin_language['entercouponfineprint']; ?>" id="cfineprints" rows="7" cols="35"></textarea>
            </p>
	   
	   		<p>
              <label for="dummy3"><?php echo $admin_language['highlight']; ?></label>
              <textarea name="chighlights" class="width400" title="<?php echo $admin_language['entercouponhighlight']; ?>" id="chighlights" rows="7" cols="35"></textarea>
            </p>
			
            <p>
              <label for="dummy3"><?php echo $admin_language['termndcondition']; ?></label>
              <textarea name="termscondition" class="width400" title="<?php echo $admin_language['entertermandcondition']; ?>" id="termscondition" rows="7" cols="35"></textarea>
            </p>

            <p>
              <label for="dummy3"><?php echo $admin_language['metakeyword']; ?></label>
              <textarea name="meta_keywords" class="required width400" title="<?php echo $admin_language['entermetakeyword']; ?>" id="meta_keywords" rows="3" cols="35"></textarea> <br />
			  <span class="quite"><?php echo $admin_language['enterfewkeyword']; ?></span>
            </p>

            <p>
              <label for="dummy3"><?php echo $admin_language['metadescription']; ?></label>
              <textarea name="meta_description" class="required width400" title="<?php echo $admin_language['entermetadesc']; ?>" id="meta_description" rows="3" cols="35"></textarea> <br />
			  <span class="quite"><?php echo $admin_language['enterbriefdesc']; ?></span>
            </p>
            <p>
	      <span class="fl clr w100p"><input type="checkbox" name="sidedeal" title="<?php echo $admin_language['sidedeal']; ?>" class="mt5 p5" value="1" /> <?php echo $admin_language['sidedeal']; ?></span> <span class="quite"><?php echo $admin_language['sidedeallldisplay']; ?></span>
            </p>
                        
            <p>
	      <span class="fl clr w100p"><input type="checkbox" name="maindeal" title="<?php echo $admin_language['maindeal']; ?>" class="mt5 p5" value="1" /> <?php echo $admin_language['maindeal']; ?></span><span class="quite"><?php echo $admin_language['maildeallldisplay']; ?></span>
            </p>
            
             <p>             
	      <span class="fl clr w100p"><input type="checkbox" name="instant_deal" title="<?php echo $admin_language['instant_deal']; ?>" class="mt5 p5" value="1" /> <?php echo $admin_language['instant_deal']; ?></span> <span class="quite"><?php echo $admin_language['instant_deal']; ?></span>
            </p>

          </fieldset>
          
         <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['timeanduserlimit']; ?></legend>
 	    <p>
              <label for="dummy0"><?php echo $admin_language['startdate']; ?></label><br />
              <input type="text" class="required cmpstartdt text" title="<?php echo $admin_language['choosethestartdate']; ?>" name="cstartdate" id="cstartdate" value="<?php echo date("Y-m-d H:i:s");?>" ><br/>
            </p>
 	    <p>
              <label for="dummy0"><?php echo $admin_language['enddate']; ?></label><br />
              <input type="text" class="required cmpenddt text" title="<?php echo $admin_language['choosetheenddate']; ?>" name="cenddate" id="cenddate" value="<?php echo getCouponEndDate();?>" ><br/>
            </p>

        <p>
              <label for="dummy0"><?php echo $admin_language['expirydate']; ?></label><br />
              <input type="text" class="required cmpexpdt text" title="<?php echo $admin_language['choosetheexpiry']; ?>" name="cexpdate" id="cexpdate" value="<?php echo getCouponExpDate();?>" ><br/>
            </p>
            
	    <p>
              <label for="dummy3"><?php echo $admin_language['minimumuserlimit']; ?></label><br />
               <input type="text" class="required digits text" title="<?php echo $admin_language['enterminuser']; ?>" name="minlimit" id="minlimit" value="" maxlength="5" />
            </p>
	    <p>
              <label for="dummy3"><?php echo $admin_language['maxuserlimt']; ?></label><br />
               <input type="text" class="compareval digits text" title="<?php echo $admin_language['coupommaxuser']; ?>" name="maxlimit" id="maxlimit" value="" maxlength="5" />  
            </p>

<?php //added max user limit to purchase field
?> 
         <p>
              <label for="dummy3"><?php echo $admin_language['maxdealpurchase']; ?></label><br />
              <input type="text" name="max_dealpurchase" class="maxdeal digits text" maxlength="3" id="maxdealpurchase" title="" />
            </p>           

      </fieldset >
            <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['commissiondetail']; ?></legend>
            <p>
              <label for="dummy3"><?php echo $admin_language['realvalue']; ?>&nbsp;<?php echo $admin_language['IN']; ?>&nbsp;<?php echo CURRENCY; ?></label><br/>
		<input type="text" class="required chkamt digits text" title="<?php echo $admin_language['entercouponrealvalue']; ?>" name="crealvalue" id="crealvalue" value="" maxlength="5" />
            </p>            
            <p>
              <label for="dummy3"><?php echo $admin_language['couponvalue']; ?>&nbsp;<?php echo $admin_language['IN']; ?>&nbsp;<?php echo CURRENCY; ?></label><br/>
		<input type="text" class="required chkval text" title="<?php echo $admin_language['entercouponvalue']; ?>" name="cdiscountvalue" id="cdiscountvalue" value="" maxlength="5"/>
            </p>
                  </fieldset>
                        <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['personaldetail']; ?></legend>
            <p>
              <label for="dummy3"><?php echo $admin_language['couponcategory']; ?></label><br />
		<select name="ctype" id="ctype" class="required titlesele" title="<?php echo $admin_language['choosecouponcategory']; ?>">
                    <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				$queryString = "select * from coupons_category where status='A' order by category_name";
				$resultset = mysql_query($queryString);
				while($type = mysql_fetch_array($resultset)){ ?>
					<option value="<?php echo $type['category_id'];?>">
					<?php echo html_entity_decode($type['category_name'], ENT_QUOTES);?>
					</option>
			<?php		}
			?>		
		</select>
            </p>

<?php /*
            <p>
              <label for="dummy3"><?php echo $admin_language['contactperson']; ?></label><br>
		<input type="text" class="required onlychars text"  title="<?php echo $admin_language['entercontactperson']; ?>" name="cperson" id="cperson" value="" ><label for="dummy3"></label>
            </p>
            <p>
              <label for="dummy3"><?php echo $admin_language['contactphoneno']; ?></label><br>
		<input type="text" class="text" title="<?php echo $admin_language['entercontactphoneno']; ?>" name="phonenum" id="phonenum" value="" maxlength="20" /><label for="dummy3"></label>
            </p>
            <p>
              <label for="dummy3"><?php echo $admin_language['contactaddress']; ?></label><br>
		<textarea name="address" id="address" title="<?php echo $admin_language['entercontactaddress']; ?>" rows="7" cols="35" class="required"></textarea>
            </p>
	*/ ?>

<?php if($_SESSION['userrole']=='1') {?>            
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label><br />
            <select class="required" name="country" title="<?php echo $admin_language['choosecountry']; ?>" id="country" OnChange="ecloadcountry(this.value,'cm');" >
                   <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
					echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
			?>
			</select>
            </p>
	<div id="dynamiclocation"></div> 
	   <?php
	   }?>

<?php if($_SESSION['userrole']=='2') {?>            
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label><br />
            <select class="required" name="country" title="<?php echo $admin_language['choosecountry']; ?>" id="country" OnChange="loadcooponcountry(this.value,'cm');" >
                   <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  and countryid=".$_SESSION["countryid"]." order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
			?>
			</select>
            </p>
	<div id="cdynamiclocation"></div> 
	   <?php
	   }?>
	   
<?php 
if($_SESSION['userrole']=='3') {?>            
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label><br />
            <select class="required" name="country" title="<?php echo $admin_language['choosecountry']; ?>" id="country" OnChange="loadcooponcountry(this.value,'cm');" >
                   <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A' and countryid=".$_SESSION["countryid"]." order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
					echo '<option value="'.$loaction["countryid"].'">'.html_entity_decode($loaction["countryname"], ENT_QUOTES).'</option>';
				}
			?>
			</select>
            </p>
	<div id="cdynamiclocation"></div> 
	   <?php

	   }?>	   
	</fieldset>        
	
	<fieldset class="field">
	<span class="quite mt5 fl">
	<?php 
	//show the image size to upload the deal
	
	$val = $ImageSize[DEFAULT_CURRENT_THEME];

	if($val)
	{
		$width_val = $val['width'];
		$height_val = $val['hight'];
	}
	else
	{
		$width_val=420;
		$height_val=285;
	}
	echo $admin_language['images_size_should_be']." ".$width_val."*".$height_val;
	
	?>
	</span>
	    
        <legend class="legend"><?php echo $admin_language['dealimage']; ?></legend>                     
             <p>
              <label for="dummy3"><?php echo $admin_language['picture']; ?></label><br />
		<input type="file" class="text" name="cpicture" id="cpicture" value="" >
            </p>
        <p><input type="radio" name="is_video" id="is_video0" value="0" CHECKED>Slider Images<input type="radio" id="is_video1" name="is_video" value="1"/>Video</p>     
        <div id="deal_slider">
                 
        <p>
                <label for="dummy3"><?php echo $admin_language['extraimageforslideshow']; ?></label><br/>
		<input type="file" class="text" name="slide1" id="cpicture" value="" >
        </p>
        <p>	
                <input type="file" class="text" name="slide2" id="cpicture" value="" >
        </p>
        <p>	
                <input type="file" class="text" name="slide3" id="cpicture" value="" >
        </p>
        </div>
        <div id="deal_video" style="display:none;">
        <p>
              <label for="dummy3"><?php echo $admin_language['embed_code']; ?></label>
		<textarea name="embed_code" id="embed_code" title="<?php echo $admin_language['embed_code']; ?>" rows="7" cols="35" class="width400"></textarea>
        </p>
        </div>  
        </fieldset>                      
        <div class="fl clr  mt10 width100p" >
              <input type="submit" value="<?php echo $admin_language['submit']; ?>" class="button_c fl">
              <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class="ml10 button_c fl">
        </div>

        </form>
 
