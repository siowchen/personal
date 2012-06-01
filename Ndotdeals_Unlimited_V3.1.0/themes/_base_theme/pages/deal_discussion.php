<?php
$lang = $_SESSION["site_language"];
if($lang)
{
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
        include(DOCUMENT_ROOT."/system/language/en.php");
}
?>

		<script type="text/javascript">
		function delete_discussion(did,r_url)
		{
			var aa = confirm("<?php echo $language['you_sure_want_to_delete']; ?>");
			if(aa)
			{
				window.location = '/system/plugins/del_discuss.php?id='+did+'&rurl='+r_url+'';
			}
		}
		</script>
		
		<div class="review_new fl clr">

		  <h3><?php echo $language["discussion"]; ?> (<?php echo $total_result; ?>)</h3>
		  <?php if($total_result>0) { 
				  while($d_row = mysql_fetch_array($list_comment))
				  {
				  ?>

				  <div class="fl cmd_content ml10">
					  <div class="fl">
					 <?php
					      $filename = 'uploads/profile_images/'.$d_row['user_id'].'.jpg'; 
		                               if (file_exists($filename)) 
		                               {?>
		                                             <img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=50&amp;height=50&amp;cropratio=1:1&amp;noimg=100&amp;image=<?php echo DOCROOT.$filename;?>" alt="<?php echo ucfirst($firstname); ?>" title="<?php echo ucfirst($firstname); ?>"/> 
		                               <?php
		                               }
		                               else{
		                               ?>
				                             <img src="http://www.gravatar.com/avatar/<?php echo md5($d_row["email"]);?>?d=identicon&amp;s=50" alt="<?php echo $d_row["firstname"]; ?>" title="<?php echo $d_row["firstname"]; ?>" />
		                                <?php
		                                }?>
					  </div>
					  
					  <div class="cmd_post fl">
					  	<p class="fl clr"><?php echo nl2br(html_entity_decode($d_row["discussion_text"], ENT_QUOTES));?></p>
					  <br />
					  <span class="span fl clr"> - <?php echo $d_row["firstname"]; ?>, <?php echo change_time($d_row["cdate"]); ?>
					  
					  <?php 
					  if($d_row["user_id"] == $_SESSION["userid"]) { ?>
					  <a href="javascript:delete_discussion('<?php echo $d_row["discussion_id"]; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')" title="Delete">Delete</a>
					  <?php } ?>
					  
					  </span>
					  </div>
				  </div>

				  <?php }
		  } else { ?>
		  
		  <div class="no_data1"><?php echo $language["no_discussion_avail"]; ?></div>
		  <?php 
		  }
		  ?>

		
        </div>
		
		<?php 
		
		if($_POST["submit_comment"] == $language['post'])
		{
			
			$message = $_POST["comment_text"];
			$message = htmlentities(strip_tags($message), ENT_QUOTES);
			$deal_id = htmlentities(strip_tags($_POST["deal_id"]), ENT_QUOTES);
			$userid = $_SESSION["userid"];
			
			if($message)
			{
				$insert_query = mysql_query("insert into discussion(user_id,deal_id,discussion_text) values('$userid','$deal_id','$message')");
			}
				
			$get_deal_name = mysql_query("select coupon_id,coupon_name from coupons_coupons where coupon_id = '$deal_id' ");
			
			while($d_val = mysql_fetch_array($get_deal_name))
			{
				if($insert_query)
				{ 
					set_response_mes(1,$language['discussion_posted']);
					url_redirect(DOCROOT."deals/".friendlyURL($d_val["coupon_name"])."_".$d_val["coupon_id"].".html");
				}
				else
				{
					set_response_mes(-1,$language['enter_discussion_message']);
					url_redirect(DOCROOT."deals/".friendlyURL($d_val["coupon_name"])."_".$d_val["coupon_id"].".html");
				}
			
			}
		}
		
		?>
		
		<!-- Write a Review  -->
		<?php 
		$cur_url = explode('/',$_SERVER['REQUEST_URI']);
		if($cur_url[2]!='past') { ?>

		<div class="reviews_box" style="margin-left:5px;">
		<?php 
		if($_SESSION["userid"])
		{
		?>
			<form name="comment_form" id="comment_form" method="post">
			<input type="hidden" name="deal_id" value="<?php echo $deal_id; ?>" />
			<table border="0" cellpadding="5" cellspacing="5">
			<tr>
			<td><textarea name="comment_text" id="comment_text" rows="5" class="required width400" title="Enter the Review Text"></textarea></td>
			</tr>
			<tr><td align="right">
		
			<span class="submit"><input type="submit" name="submit_comment" id="submit_comment" class="bnone" value="<?php echo $language['post'];?>" /></span></td></tr>
			</table>
			</form>
		<?php }else{ 
		
			$_SESSION["ref"] = DOCROOT.substr($_SERVER['REQUEST_URI'],1); 
		
		?>
			<span class="login_discussion">
			<a href="<?php echo DOCROOT; ?>login.html" title="<?php echo $language["login"]; ?>"><?php echo $language["login"]; ?></a> <?php echo $language["post_discussion"]; ?>
			</span>
		<?php } ?>
		
		</div>
		<?php } ?>
