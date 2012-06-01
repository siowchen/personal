<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$categoryid = $url_arr[3];
if($_POST)
{
	$categoryname = htmlentities($_POST['categoryname'], ENT_QUOTES);
	$category_url = htmlentities($_POST['permalink'], ENT_QUOTES);
	$category_img = htmlentities($_POST['imglink'], ENT_QUOTES);
	$categoryicon = htmlentities($_POST['imglink'], ENT_QUOTES);
	$categoryid = $url_arr[3];

	$queryString = "select * from coupons_category where category_name = '$categoryname' and category_id<>'$categoryid'";
	$resultSet = mysql_query($queryString);

		if(mysql_num_rows($resultSet)>0)
		{
			set_response_mes(-1, $admin_language['categorynameexist']); 		 
			$redirect_url = DOCROOT.'edit/category/'.$categoryid.'/';
			url_redirect($redirect_url);
		}
		else
		{
			updateCategory($categoryname,$category_url,$categoryid,$category_img,$categoryicon);
			set_response_mes(1, $admin_language['changesmodified']); 		 
			$redirect_url = DOCROOT.'manage/category/';
			url_redirect($redirect_url);
		}

}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#form_editcategory").validate();});
</script>

<?php
$queryString = "select * from coupons_category where category_id='".$categoryid."'";
$resultSet = mysql_query($queryString);
	if(mysql_num_rows($resultSet)>0){
	while($category = mysql_fetch_array($resultSet)){
								?>

<div class="form">
<div class="form_top"></div>
      <div class="form_cent">  
<form name="form_editcategory" id="form_editcategory" method="post" action="" class="coopen_form fl" enctype="multipart/form-data">
<fieldset class="border_no">
	<p>
	<label for=""><?php echo $admin_language['categoryname']; ?></label><br />
	<input type="text" name="categoryname" maxlength="50" value="<?php echo html_entity_decode($category['category_name'], ENT_QUOTES); ?>"  class="required" title="<?php echo $admin_language['enterthecategoryname']; ?>" onchange="generate_permalink(this.value,'deal_permalink');" />
	</p>

 <p>
	<label ><?php echo $admin_language['permalink']; ?></label><br />
	<input type="text" name="permalink" id="deal_permalink" maxlength="50" value="<?php echo html_entity_decode($category['category_url'], ENT_QUOTES); ?>"  class="required" title="<?php echo $admin_language['permalink_required']; ?>" />
     <br />
			  <span class="quite"><?php echo $admin_language['permalink_ex']; ?></span>
	</p>
	
	 <p>
		<label ><?php echo $admin_language['categoryimage']; ?></label><br />
		<input type="file" name="imglink" id="imglink1"  />
     	</p>
     	<p>
		<?php            
		$category_img_id = html_entity_decode($category['category_image'], ENT_QUOTES);  
		if(file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$category_img_id)){
		?>
	       <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=75&height=85&cropratio=1:1&noimg=100&image=<?php echo DOCROOT.$category_img_id;?>" alt="No category Image" style="margin-left:10px;" title="<?php echo html_entity_decode($category['category_name'], ENT_QUOTES); ?>"/>
	       <?php
	       }       
	       ?>
     	</p>
     	
        <p>
		<label ><?php echo $admin_language['categoryicon']; ?></label><br />
		<input type="file" name="categoryicon" id="categoryicon"/>
	</p>
	
	<div class="fl clr mt10 width100p">
	    <input type="submit" value="<?php echo $admin_language['submit']; ?>" class=" button_c">
	    <input type="Reset" value="<?php echo $admin_language['reset']; ?>" class=" button_c ml10">
	</div>
            	
</fieldset>
</form>
     </div>
<div class="form_bot"></div>
</div>

								<?php
								}
								}?>
