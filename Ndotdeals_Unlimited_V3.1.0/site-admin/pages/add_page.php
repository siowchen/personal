<script type="text/javascript" src="<?php echo DOCROOT; ?>/site-admin/scripts/jquery-ui-1.8.11.custom/js/jquery-1.5.1.min.js"></script>
<script src="<?php echo DOCROOT; ?>/site-admin/scripts/datetimepicker/jquery13/jquery.validate.pack.js" type="text/javascript"></script>
<script src="<?php echo DOCROOT; ?>site-admin/scripts/jquery.cleditor.js" type="text/javascript"></script>
	
<?php
	session_start();
	is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
	
	if($_POST)
	{
		$title = htmlentities($_POST['title'], ENT_QUOTES);
		$description = htmlentities($_POST['description'], ENT_QUOTES);
		$meta_keywords = htmlentities($_POST['meta_keywords'], ENT_QUOTES);
		$meta_description = htmlentities($_POST['meta_description'], ENT_QUOTES);
		
		$queryString = "select * from pages where title = '$title' ";
		$resultSet = mysql_query($queryString);
	
			if(mysql_num_rows($resultSet)>0)
			{
				set_response_mes(-1, $admin_language['pageexist']); 		 
				$redirect_url = DOCROOT.'admin/add-page/';
				url_redirect($redirect_url);
			}
			else
			{
				$title_url = friendlyURL($title);
				mysql_query("insert into pages(title,title_url,description,meta_keywords,meta_description) values ('$title','$title_url','$description','$meta_keywords','$meta_description')");
				set_response_mes(1, $admin_language['pagecreate']); 		 
				$redirect_url = DOCROOT.'admin/add-page/';
				url_redirect($redirect_url);
			}
	
	}
	?>

	<script type="text/javascript">
	/* validation */
	$(document).ready(function(){ $("#add_page").validate();});
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){ 
	$(".toggleul_4").slideToggle(); 
	document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
	});
	</script>	
	

	<fieldset class="field" style="margin-left:10px;">         
	<form name="add_page" id="add_page" action="" method="post" enctype="multipart/form-data" >	
	<table border="0"  cellpadding="5" align="left" class="p5">
	
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['title']; ?></label></td>
	<td align="top"><input type="text"  name="title" class="required width400" title="<?php echo $admin_language['entertitle']; ?>" />
	</td>
	</tr>
	
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['description']; ?></label></td>
	<td><textarea id="description" name="description" rows="7"  class="required width400" title="<?php echo $admin_language['enterdesc']; ?>"></textarea>
	</td></tr>
	
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['metakeyword']; ?></label></td>
	<td><textarea name="meta_keywords" rows="5"  class="required width400" title="<?php echo $admin_language['entermetakeyword']; ?>"></textarea>
	</td></tr>
	
	<tr>
	<td valign="top" align="right"><label><?php echo $admin_language['metadescription']; ?></label></td>
	<td><textarea name="meta_description" rows="5"  class="required width400" title="<?php echo $admin_language['entermetadesc']; ?>"></textarea>
	</td></tr>
	
	<tr><td>&nbsp;</td><td><input type="submit" value="<?php echo $admin_language['post']; ?>" class="button_c" /></td></tr>
	</table>
	</form>
	 </fieldset >
	  <!-- ClEdit fun start here-->		  
         <script type="text/javascript">
		  $(document).ready(function() {

			$("#description").cleditor();
			
		  });
         </script>     
         <!-- ClEdit end-->
