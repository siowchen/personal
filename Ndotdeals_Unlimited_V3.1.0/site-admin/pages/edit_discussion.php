<?php 
	session_start();
	is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_4").slideToggle();
	document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>

<?php	
	if($_POST)
	{
		$id = $_POST['id'];
		$discussion_text = htmlentities($_POST['discussion_text'], ENT_QUOTES);
		mysql_query("update discussion set discussion_text = '$discussion_text' where discussion_id='$id' ");
		set_response_mes(1, $admin_language['changesmodified']); 		 
		$redirect_url = DOCROOT.'manage/discussions/';
		url_redirect($redirect_url);
	}
	?>
	
	<script type="text/javascript">
	/* validation */
	$(document).ready(function(){ $("#discussion_page").validate();});
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){ 
	$(".toggleul_159").slideToggle(); 
	document.getElementById("left_menubutton_159").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
	});
	</script>


<?php
	$discussion_id = $url_arr[3];
	$queryString = "select d.discussion_text,d.discussion_id,c.coupon_name from discussion d left join coupons_coupons c on c.coupon_id=d.deal_id where d.discussion_id=".$discussion_id." ";
	$resultSet = mysql_query($queryString);

	if(mysql_num_rows($resultSet)>0)
	{
		while($row = mysql_fetch_array($resultSet))
		{
			?>

	<fieldset class="field" style="margin-left:10px;">         
	<form name="discussion_page" id="discussion_page" action="" method="post" enctype="multipart/form-data" >	
	<input type="hidden" name="id"  value="<?php echo $row["discussion_id"];?>" />
	
	<table border="0"  cellpadding="5" align="left" class="p5">
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['dealname']; ?></label></td>
	<td align="top"><label style='font-weight:bold;'><?php echo ucfirst(html_entity_decode($row["coupon_name"], ENT_QUOTES)); ?></label>
	</td>
	</tr>
	
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['comment']; ?></label></td>
	<td><textarea name="discussion_text" rows="7"  class="required width400" title="<?php echo $admin_language['entercomment']; ?>"><?php echo html_entity_decode($row["discussion_text"], ENT_QUOTES);?></textarea>
	</td>
	</tr>

	<tr><td>&nbsp;</td><td><input type="submit" value="<?php echo $admin_language['update']; ?>" class="button_c" /></td></tr>
	</table>
	</form>
	</fieldset >
	 
<?php }
}?>
