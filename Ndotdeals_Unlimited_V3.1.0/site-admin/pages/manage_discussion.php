<?php session_start(); 
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
if($url_arr[2]=='discussion')
{?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_6").slideToggle();
	document.getElementById("left_menubutton_6").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>
<?php
}

$list_comment = mysql_query("select discussion_id,deal_id,discussion_text,firstname,lastname,cdate,user_id from discussion left join coupons_users on discussion.user_id = coupons_users.userid order by discussion_id desc ");
		
		$total_result = mysql_num_rows($list_comment);
?>

		<script type="text/javascript">
		function delete_discussion(did,r_url)
		{
			var aa = confirm("Are you sure want to delete it?");
			if(aa)
			{
				window.location = '<?php echo DOCROOT; ?>system/plugins/del_discuss.php?id='+did+'&rurl='+r_url+'';
			}
		}
		</script>



			 <?php if($total_result>0) 
			 { 
				  while($d_row = mysql_fetch_array($list_comment))
				  {
				  ?>
				  <p class="ml10">
				  <?php echo ucfirst(nl2br(html_entity_decode($d_row["discussion_text"], ENT_QUOTES)));?>
				  <br />
				  <span class="span login_area"> - <?php echo ucfirst($d_row["firstname"]); ?> <?php echo ucfirst($d_row["lastname"]); ?>, <?php echo change_time($d_row["cdate"]); ?>
				  
				  <a href="javascript:delete_discussion('<?php echo $d_row["discussion_id"]; ?>','<?php echo DOCROOT.substr($_SERVER['REQUEST_URI'],1); ?>')" title="Delete">Delete</a>
				  </span>

				  </p>
				  <?php }
		  } else { ?>
		  
		  <div class="nodata"><?php echo $admin_language['nodiscussion']; ?> </div>
		  <?php 
		  }
		  ?>
