<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
require_once($_SERVER['DOCUMENT_ROOT'].'/site-admin/pages/delete.php');
	$cid = $url_arr[3];
	$obj = new EditCouponDetails($cid);
	$obj->editCouponDetails($cid);
	if($_POST)
	{

		$coopen_id = $url_arr[3];
		$couponname = htmlentities($_POST['couponname'], ENT_QUOTES);
		$deal_permalink = htmlentities($_POST['deal_permalink'], ENT_QUOTES);
		$cdesc = htmlentities($_POST['cdesc'], ENT_QUOTES);
		$cfineprints = htmlentities($_POST['cfineprints'], ENT_QUOTES);
		$chighlights = htmlentities($_POST['chighlights'], ENT_QUOTES);
		$terms = htmlentities($_POST['termcondition'], ENT_QUOTES);
		$meta_keywords = htmlentities($_POST['meta_keywords'], ENT_QUOTES);
		$meta_description = htmlentities($_POST['meta_description'], ENT_QUOTES);
		$cenddate = htmlentities($_POST['cenddate'], ENT_QUOTES);
	        $cstartdate = htmlentities($_POST['cstartdate']);
		$cexpdate = htmlentities($_POST['cexpdate'], ENT_QUOTES);
		$minlimit = htmlentities($_POST['minlimit'], ENT_QUOTES);
		$maxlimit = htmlentities($_POST['maxlimit'], ENT_QUOTES);
		$cdiscountvalue = htmlentities($_POST['cdiscountvalue'], ENT_QUOTES);
		$crealvalue = htmlentities($_POST['crealvalue'], ENT_QUOTES);

		//unneccessary input fields are removed		
		$cperson = ''; //htmlentities($_POST['cperson'], ENT_QUOTES);
		$phonenum = ''; //htmlentities($_POST['phonenum'], ENT_QUOTES);
		$address = ''; //htmlentities($_POST['address'], ENT_QUOTES);

		$ctype = $_POST['ctype'];
		$cpicture = $_POST['cpicture'];
		$country = $_POST['country'];
		$city = $_POST['city'];
		$shopid = $_POST['shop'];
		$is_video = $_POST['is_video'];
		$embed_code = htmlentities($_REQUEST['embed_code'], ENT_QUOTES);
		$coupon_status = $_POST['coupon_status'];
		if($_POST['max_dealpurchase'] > 0){
		        $max_dealpurchase = htmlentities($_POST['max_dealpurchase']);
		}else{
		        $max_dealpurchase = 0;
		}


		    if($_POST['sidedeal'])
			    $sidedeal=1;
		    else
	  		    $sidedeal=0;
	  		    
	            if($_POST['maindeal'])
		        $maindeal=1;
	            else
  		        $maindeal=0;
  		        
  		    if($_POST['instant_deal'])
		         $instant_deal=1;
	            else
  		         $instant_deal=0;

		$result = updateCouponDetails($cid,$couponname,$deal_permalink,$cdesc,$cenddate,$minlimit,$maxlimit,$cdiscountvalue,$crealvalue,$ctype,$cpicture,$country,$city,$cperson,$phonenum,$address,$shopid,$cfineprints,$chighlights,$terms,$sidedeal,$meta_keywords,$meta_description,$maindeal,$cexpdate,$cstartdate,$is_video,$embed_code,$max_dealpurchase,$coupon_status,$instant_deal);

		$redirect_url = DOCROOT."admin/view/rep/all";
		if($result=='1'){
			set_response_mes(1, $admin_language['changesmodified']); 	
		}else{
			set_response_mes(-1, $result); 	
		}
		
		url_redirect($redirect_url);

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
       if($("#is_video1:checked").val())
       {
                $("#deal_slider1").hide();
	        $("#deal_slider2").hide();
	        $("#deal_slider3").hide();
	        $("#deal_video").show();        
       }
       if($("#is_video0:checked").val())
       {
                $("#deal_slider1").show();
	        $("#deal_slider2").show();
	        $("#deal_slider3").show();
	        $("#deal_video").hide();        
       }
       $("#is_video1").click(function(){
	        $("#deal_slider1").hide();
	        $("#deal_slider2").hide();
	        $("#deal_slider3").hide();
	        $("#deal_video").show();
	});
	$("#is_video0").click(function(){
	        $("#deal_slider1").show();
	        $("#deal_slider2").show();
	        $("#deal_slider3").show();
	        $("#deal_video").hide();
	});
	
  });

jQuery.validator.addMethod('cmpenddt', function(value) {
var cstartdate=document.getElementById('cstartdate').value; 
var cenddate=document.getElementById('cenddate').value; 
return (cenddate > cstartdate); }, '...');

jQuery.validator.addMethod('cmpexpdt', function(value) {
var cexpdate=document.getElementById('cexpdate').value; 
var enddate = document.getElementById('cenddate').value; 
return (cexpdate > enddate); }, '...');

/* validation */
$(document).ready(function(){$("#edit_coupon_form").validate();});

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


<!--image delete script--->

<script type="text/javascript">
function deletecouponimage(id,refid)
{	
	var sure=confirm("Are you sure want to delete this Coupon?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?couponimage_id='+id+'&refid='+refid;
	}

}

function deletesliderimage(id,refid)
{	

	var sure=confirm("Are you sure want to delete this Coupon?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?deletesliderimage_id='+id+'&refid='+refid;
	}

}
</script>

       <!-- ClEdit fun start here-->
	  
         <script type="text/javascript">
		  $(document).ready(function() {		  
			$("#cdesc").cleditor();
			$("#cfineprints").cleditor();
			$("#chighlights").cleditor();
			$("#termcondition").cleditor();
		  });
         </script>     
         <!-- ClEdit end-->


        <form name="edit_coupon_form" id="edit_coupon_form" action="" enctype="multipart/form-data" method="post" class="coopen_form">
<fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['generaldetail']; ?></legend>
            <p>
              <label for="dummy0"><?php echo $admin_language['name']; ?></label><br/>
              <input type="text" class="required width400" title="<?php echo $admin_language['entercouponname']; ?>" name="couponname" id="couponname" value="<?php echo $obj->getcouponname();?>" onchange="generate_permalink(this.value,'deal_permalink');" >
            </p>
            
             <p>
              <label for="dummy0"><?php echo $admin_language['permalink']; ?></label><br/>
              <?php echo DOCROOT;?>deals/ <input type="text" class="required width200" title="<?php echo $admin_language['permalink_required']; ?>" name="deal_permalink" id="deal_permalink" value="<?php echo $obj->get_permalink();?>" > _<?php echo $cid; ?>.html
            </p>
            
	    <p>
              <label for="dummy3"><?php echo $admin_language['description']; ?></label>
              <textarea name="cdesc" class="width400" title="<?php echo $admin_language['entercoupondesc']; ?>" id="cdesc" rows="7" cols="35"><?php echo $obj->getcoupondesc();?></textarea>
            </p>
            <p>
              <label for="dummy3"><?php echo $admin_language['fineprints']; ?></label>
              <textarea name="cfineprints" class="width400" title="<?php echo $admin_language['entercouponfineprint']; ?>" id="cfineprints" rows="7" cols="35"><?php echo $obj->getcouponfineprints();?></textarea>
            </p>
	   <p>
	    <p>
              <label for="dummy3"><?php echo $admin_language['highlight']; ?></label>
              <textarea name="chighlights" class="width400" title="<?php echo $admin_language['entercouponhighlight']; ?>" id="chighlights" rows="7" cols="35"><?php echo $obj->getcouponhighlights();?></textarea>
            </p>
           <!-- coupon status -->
           <input type="hidden" name="coupon_status" value="<?php echo $obj->get_coupon_status();?>"/>
            <p>
              <label for="dummy3"><?php echo $admin_language['termndcondition']; ?></label>
              <textarea name="termcondition" class="width400" title="<?php echo $admin_language['entertermandcondition']; ?>" id="termcondition" rows="7" cols="35"><?php echo $obj->getterms_and_condition();?></textarea>
            </p>
			
            <p>
              <label for="dummy3"><?php echo $admin_language['metakeyword']; ?></label>
              <textarea name="meta_keywords" class="required width400" title="<?php echo $admin_language['entermetakeyword']; ?>" id="meta_keywords" rows="3" cols="35"><?php echo $obj->get_metakeywords();?></textarea> <br />
			  <span class="quite"><?php echo $admin_language['enterfewkeyword']; ?></span>
            </p>

            <p>
              <label for="dummy3"><?php echo $admin_language['metadescription']; ?></label>
              <textarea name="meta_description" class="required width400" title="<?php echo $admin_language['entermetadesc']; ?>" id="meta_description" rows="3" cols="35"><?php echo $obj->get_metadesc();?></textarea> <br />
			  <span class="quite"><?php echo $admin_language['enterbriefdesc']; ?></span>
            </p>

           
			
            </fieldset>
         <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['timeanduserlimit']; ?></legend>
 	    <p>
              <label for="dummy0"><?php echo $admin_language['startdate']; ?></label></br>
              <input type="text" class="required text" title="<?php echo $admin_language['choosethestartdate']; ?>" name="cstartdate" id="cstartdate" value="<?php echo $obj->getstartdate();?>" ><br/>
            </p>
 	    <p>
              <label for="dummy0"><?php echo $admin_language['enddate']; ?></label></br>
              <input type="text" class="required cmpenddt text" title="<?php echo $admin_language['choosetheenddate']; ?>" name="cenddate" id="cenddate" value="<?php echo $obj->getenddate();?>" ><br/>
		<span id="enddate_validerr" style="color:red;"></span>
            </p>
            <p>
              <label for="dummy0"><?php echo $admin_language['expirydate']; ?></label></br>
              <input type="text" class="required cmpexpdt text" title="<?php echo $admin_language['choosetheexpiry']; ?>" name="cexpdate" id="cexpdate" value="<?php echo $obj->getexpdate();?>" ><br/>
		<span id="enddate_validerr" style="color:red;"></span>
            </p>
	    <p>
              <label for="dummy3"><?php echo $admin_language['minimumuserlimit']; ?></label></br>
               <input type="text" class="required digits text" title="<?php echo $admin_language['enterminuser']; ?>"  name="minlimit" id="minlimit" value="<?php echo $obj->getminuserlimit();?>"  maxlength="5">
            </p>
	    <p>
              <label for="dummy3"><?php echo $admin_language['maxuserlimt']; ?></label></br>
               <input type="text" class="compareval digits text" title="<?php echo $admin_language['coupommaxuser']; ?>" name="maxlimit" id="maxlimit" value="<?php echo $obj->getmaxuserlimit();?>"  maxlength="5">	     
            </p> 

             <p>
              <label for="dummy3"><?php echo $admin_language['maxdealpurchase']; ?></label></br>
              <input type="text" name="max_dealpurchase" class="maxdeal digits text" title="" maxlength="3" id="maxdealpurchase" value="<?php echo $obj->get_max_deal_purchase();?>" />
            </p>
            <p>
              
	      <input type="checkbox" name="sidedeal" title="<?php echo $admin_language['sidedeal']; ?>" class="mt5 p5" value="1" <?php if($obj->getsidedeal()) { echo "checked"; } ?>/>
          <label for="dummy3"><?php echo $admin_language['sidedeal']; ?></label>
          
            </p>
            
            <p>
	      <input type="checkbox" name="maindeal" title="<?php echo $admin_language['maindeal']; ?>" class="mt5 p5" value="1" <?php if($obj->getmaindeal()) { echo "checked"; } ?>/>
           <label for="dummy3"><?php echo $admin_language['maindeal']; ?></label>
            </p>
             <!--Instant deals start-->
             <p>
	      <input type="checkbox" name="instant_deal" title="<?php echo $admin_language['instant_deal']; ?>" class="mt5 p5" value="1" <?php if($obj->get_instant_deal()) { echo "checked"; } ?>/>
           <label for="dummy3"><?php echo $admin_language['instant_deal']; ?></label>
            </p>
             <!--Instant deals end-->

</fieldset >
            <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['commissiondetail']; ?></legend>
            <p>
              <label for="dummy3"><?php echo $admin_language['realvalue']; ?>&nbsp;<?php echo $admin_language['IN']; ?>&nbsp;<?php echo CURRENCY; ?></label></br>
		<input type="text" class="required digits chkamt text" title="<?php echo $admin_language['entercouponrealvalue']; ?>" name="crealvalue" id="crealvalue" value="<?php echo $obj->getrealvalue();?>" maxlength="5" >
            </p>            
            <p>
              <label for="dummy3"><?php echo $admin_language['couponvalue']; ?>&nbsp;<?php echo $admin_language['IN']; ?>&nbsp;<?php echo CURRENCY; ?></label></br>
		<input type="text" class="required chkval text" title="<?php echo $admin_language['entercouponvalue']; ?>"  name="cdiscountvalue" id="cdiscountvalue" value="<?php echo $obj->getcouponvalue();?>" maxlength="5">
            </p>
                </fieldset>
                        <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['personaldetail']; ?></legend>
	  <p>
              <label for="dummy3"><?php echo $admin_language['couponcategory']; ?></label></br>
		<select name="ctype" id="ctype" class="required titlesele" title="<?php echo $admin_language['choosecouponcategory']; ?>">
                    <option value=""> <?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select category_id,category_name from coupons_category where status ='A' order by category_name";
				$resultset = mysql_query($queryString);
				while($type = mysql_fetch_array($resultset)){ ?>
					<option value="<?php echo $type['category_id'];?>" <?php if($obj->getctype() == $type['category_id']) echo 'selected = "selected"';?>><?php echo html_entity_decode($type['category_name'], ENT_QUOTES);?></option>
		<?php		}
			?>		
		</select>
             </p>

<?php /* 
            <p>
              <label for="dummy3"><?php echo $admin_language['contactperson']; ?></label></br>
		<input type="text" class="required onlychars text"  title="<?php echo $admin_language['entercontactperson']; ?>" name="cperson" id="cperson" value="<?php echo $obj->getcperson();?>" ><label for="dummy3"></label>
            </p>
            <p>
              <label for="dummy3"><?php echo $admin_language['contactphoneno']; ?></label></br>
		<input type="text" class="text" title="<?php echo $admin_language['entercontactphoneno']; ?>" name="phonenum" id="phonenum" value="<?php echo $obj->getphoneno();?>" maxlength="20" ><label for="dummy3"></label>
            </p>
            <p>
              <label for="dummy3"><?php echo $admin_language['contactaddress']; ?></label></br>
		<textarea name="address" title="<?php echo $admin_language['entercontactaddress']; ?>" class="required" id="address" rows="7" cols="35"><?php echo $obj->getaddress();?></textarea>
            </p>
*/ ?>
            
<?php if($_SESSION['userrole']=='1') {?>            
            <p>
 	  	<label for="dummy1"><?php echo $admin_language['country']; ?></label></br>
            <select title="<?php echo $admin_language['choosecountry']; ?>" class="required" name="country" id="country" OnChange="ecloadcountry(this.value,'cm');" >
                   <option value="" ><?php echo $admin_language['choose']; ?></option>
			<?php
				
				$queryString = " select countryid,countryname from coupons_country where status ='A'  order by countryname asc ";
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				?>
					<option value="<?php echo $loaction['countryid'];?>" <?php if($obj->getcountry() == $loaction["countryid"]) echo 'selected = "selected"';?>><?php echo html_entity_decode($loaction["countryname"], ENT_QUOTES);?></option>
				<?php
				}
			?>
			</select>
            </p>

<div id="citytag" class="fl clr mt10">
 	  	<label for="dummy1"><?php echo $admin_language['location']; ?></label></br>
	            <select name="city" id="city" title="<?php echo $admin_language['choosecountry']; ?>" class="required" OnChange="load_cooponshopdetails(this.value);" >
                   <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
				
				$queryString = " select cityid,cityname from coupons_cities where status='A' and countryid =".$obj->getcountry();
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				?>
					<option value="<?php echo $loaction['cityid'];?>" <?php if($obj->getcity() == $loaction["cityid"]) echo 'selected = "selected"';?>><?php echo html_entity_decode($loaction["cityname"], ENT_QUOTES);?></option>
				<?php
				}
			?>
		     </select>
               
               <div id="shopnamelist" class="fl clr mt10">
 	  	<label for="dummy1"><?php echo $admin_language['shopname']; ?></label></br>
	            <select name="shop" id="shop" title="<?php echo $admin_language['choosetheshopname']; ?>" class="required" >
                    <option value="" ><?php echo $admin_language['choose']; ?> </option>
			<?php
			if($obj->getshop()=='')
			{
				$queryString = " select shopid,shopname from coupons_shops where shop_status='A' and shop_city =".$obj->getcity();
							
			}
			else
			{			
				$queryString = " select shopid,shopname from coupons_shops where shop_status='A' and shopid =".$obj->getshop();
				}
				$resultset = mysql_query($queryString);
				while($loaction = mysql_fetch_array($resultset)){
				?>
					<option value="<?php echo $loaction['shopid'];?>" <?php if($obj->getshop() == $loaction["shopid"]) echo 'selected = "selected"';?>><?php echo html_entity_decode($loaction["shopname"], ENT_QUOTES);?></option>
				<?php
				}
			?>
			</select>
		 </div>
                                
</div>

<div id="dynamiclocation"></div>   

	   <?php
	   }?>
 	                </fieldset>        
                   
	 <fieldset class="field"> 
	 	     
        <legend class="legend"><?php echo $admin_language['dealimage']; ?></legend>     
        
        <table> 
        <tr>
		<td colspan="2"> 
		<label for="dummy3">
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
		</label>
        	</td>
        </tr>             
         <tr><td colspan="2"> <label for="dummy3"><?php echo $admin_language['picture']; ?></label></td></tr>
         <tr>
		 <td valign="top"><input type="file" class="text" name="cpicture" id="cpicture" value="" ></td>
        
		<?php
		$image_id = $obj->getimage();
		if(!empty($image_id))
		{
		     if(file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$image_id))
		      {				
		      ?>
				 <td valign="top">
		         <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.$obj->getimage();?>" alt="Coupon Image" style="margin-left:10px;"/>  <br />
		         <a href="javascript:;" onclick="deletecouponimage('<?php echo $cid; ?>','<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>')" title="Delete" class="ml10">Delete</a>
                 </td>
		      <?php
		      }
		}
		 ?>
		</tr>
          <tr><td colspan="2"><input type="radio" name="is_video" id="is_video0" value="0" <?php if($obj->getisvideo() == '0') { echo "CHECKED"; }?>>Slider Images<input type="radio" id="is_video1" name="is_video" value="1" <?php if($obj->getisvideo() == '1') { echo "CHECKED"; }?>/>Video</td></tr> 
           
	  <?php
        //slide show starts 

        $slider_result = mysql_query("select * from slider_images where coupon_id='$cid'");
                if(mysql_num_rows($slider_result)>0)
                 {
                      while($slider = mysql_fetch_array($slider_result))
                        {
                           $slider_id = $slider['id'];

                        }	                
                        
                 }                  

        ?>
        <tr id="deal_slider1"><td colspan="2"> <label for="dummy3"><?php echo $admin_language['extraimageforslideshow']; ?></label></td></tr>
        <tr>
        <td valign="top">   
		<input type="file" class="text" name="slide1" id="cpicture" value="" >
        </td>
        <td valign="top">
		<?php 
		if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/slider_images/'.$cid.'_1'.'.jpg'))
		  {
		?>
		<img style="margin-left:10px;" src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.'uploads/slider_images/'.$cid.'_1'.'.jpg';?>" alt="Slider Image"/>
        <br />
		<a href="javascript:;" onclick="deletesliderimage('<?php echo $cid.'_1.jpg'; ?>','<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>')" class="ml10" title="Delete">Delete</a>
		<?php
		}
		?>
        </td>
        </tr>

       <tr id="deal_slider2">
       
       <td valign="top"> <input type="file" class="text" name="slide2" id="cpicture" value="" ></td>
       <td valign="top">
                        <?php 
                        
                        if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/slider_images/'.$cid.'_2'.'.jpg')){
                        ?>
                       <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.'uploads/slider_images/'.$cid.'_2'.'.jpg';?>" alt="Slider Image" style="margin-left:10px;"/>
                       <br />
                       <a href="javascript:;" onclick="deletesliderimage('<?php echo $cid.'_2.jpg'; ?>','<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>')" class="ml10" title="Delete">Delete</a>
                       <?php
                       }
                       ?>
         </td>
         </tr>
         
        <tr id="deal_slider3">
        <td valign="top">
        <input type="file" class="text" name="slide3" id="cpicture" value="" >
        </td>
        <td valign="top">
                         <?php 
                        if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/slider_images/'.$cid.'_3'.'.jpg')){
                        ?>
                        <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.'uploads/slider_images/'.$cid.'_3'.'.jpg';?>" alt="Slider Image" style="margin-left:10px;"/>
                        <br />
                        <a href="javascript:;" onclick="deletesliderimage('<?php echo $cid.'_3.jpg'; ?>','<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>')" class="ml10" title="Delete">Delete</a>
                        <?php
                        }
                        ?>
        </td>
        </tr>
          </table>
          <div id="deal_video">
          <p>
              <label for="dummy3"><?php echo $admin_language['embed_code']; ?></label>
		<textarea name="embed_code" id="embed_code" title="<?php echo $admin_language['embed_code']; ?>" rows="7" cols="35" class="width400"><?php echo $obj->getembed_code(); ?></textarea>
          </p>
          </div>
		  </fieldset>   
             <div class="fl clr width240">
              <input type="submit" value="<?php echo $admin_language['update']; ?>" class=" button_c fl">
              <input type="button" value="Cancel" class="button_c ml10 fl" onclick="window.location='<?php echo DOCROOT;?>admin/view/rep/all';" />
            </div>
        </form>
