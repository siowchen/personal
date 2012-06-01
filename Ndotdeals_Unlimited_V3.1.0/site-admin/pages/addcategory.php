<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not. 

if($_POST)
{
	$categoryname = htmlentities($_POST['categoryname'], ENT_QUOTES);
	$category_url = htmlentities($_POST['permalink'], ENT_QUOTES);
	//$category_img = htmlentities($_POST['imglink'], ENT_QUOTES);
	
	$queryString = "select * from coupons_category where category_name = '$categoryname' ";
	$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			set_response_mes(-1, $admin_language['categoryexist']); 		 
			$redirect_url = DOCROOT.'add/category/';
			url_redirect($redirect_url);
		}
		else
		{
			createCategory($categoryname,$category_url,$category_img);			
			set_response_mes(1, $admin_language['categoryadded']); 		 
			$redirect_url = DOCROOT.'add/category/';
			url_redirect($redirect_url);
		}

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_createcategory").validate();});
</script>

<script type="text/javascript">
$(document).ready(function(){ 
$(".toggleul_4").slideToggle(); 
document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
});
</script>


<form name="form_createcategory" id="form_createcategory" method="post" action="" class="coopen_form fl" enctype="multipart/form-data" >
<fieldset style="border:1px solid #e1e1e1;width:720px;">
	<legend style="border:1px solid #e1e1e1;font:bold 12px arial;color:#333;"><?php echo $admin_language['addcategory']; ?></legend>
	<p>
	<label ><?php echo $admin_language['categoryname']; ?></label><br />
	<input type="text" name="categoryname" maxlength="50" value=""  class="required" title="<?php echo $admin_language['enterthecategoryname']; ?>" onchange="generate_permalink(this.value,'deal_permalink');" />
	</p>
    <p>
	<label ><?php echo $admin_language['permalink']; ?></label><br />
	<input type="text" name="permalink" id="deal_permalink" maxlength="50" value=""  class="required" title="<?php echo $admin_language['permalink_required']; ?>" />
     <br />
			  <span class="quite"><?php echo $admin_language['permalink_ex']; ?></span>
	</p>	
	 <p>
		<label ><?php echo $admin_language['categoryimage']; ?></label><br />
		<input type="file" name="imglink" id="imglink1"  class="required" title="<?php echo $admin_language['image_required']; ?>" />
	</p>
	<p>
		<label ><?php echo $admin_language['categoryicon']; ?></label><br />
		<input type="file" name="categoryicon" id="categoryicon"  class="required" title="<?php echo $admin_language['icon_required']; ?>" />
	</p>
	<p class="pmo">
		 <div class="fl clr mt10 width100p">
		    <input type="submit" value="<?php echo $admin_language['submit']; ?>" class=" button_c">
		    <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class=" button_c ml10">
		 </div>
	</p>
            	
</fieldset>
</form>
 
