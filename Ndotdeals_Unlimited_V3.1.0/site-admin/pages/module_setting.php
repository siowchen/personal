<?php
	is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
?>

<script type="text/javascript">
$(document).ready(function(){
$("#morepaymodule").hide();
$(".toggleul_4").slideToggle();
document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});

function showmore(){
	$("#morepaymodule").show();
}

function del(id){
	var conf = confirm("Are you sure want to remove the module permanently and never retrive if already done payment with this gateway!!!");
	if(conf){
		window.location = "<?php echo DOCROOT;?>admin/module/"+id;
	}
}
</script>

<?php
	if($_POST['submit'])
	{ 
		$id = $_POST["id"];
		$featured_deals = $_POST['featured_deals'];
		$newsletter = $_POST['newsletter'];
		$category = $_POST['category'];
		$fanpage = $_POST['fanpage'];
		$smtp = $_POST['smtp'];
		$facebook_connect = $_POST['facebook_connect'];
		$twitter_connect = $_POST['twitter_connect'];
		$tweets_around_city = $_POST['tweets_around_city'];
		$mobile_subscribtion = $_POST['mobile_subscribtion'];
		$newpayname = $_POST['newpayname'];
		$query = "update modules set featured_deals = '$featured_deals',newsletter = '$newsletter',category = '$category',fanpage = '$fanpage',facebook_connect = '$facebook_connect',twitter_connect = '$twitter_connect',tweets_around_city = '$tweets_around_city',mobile_subscribtion = '$mobile_subscribtion',smtp = '$smtp' where id='$id' ";
		mysql_query($query);
		  
		foreach($_POST['payid'] as $id){  
			$default = 0;
			if($id == $_POST['default']){
				$default = '1';
			}
			$update = "update payment_modules set pay_mod_name = '".$_POST['paymodule_'.$id]."', pay_mod_active = '".$_POST['paystatus_'.$id]."', pay_mod_cd = now(), pay_mod_default = '".$default."' where pay_mod_id = '".$id."' ";
			mysql_query($update)or die(mysql_error());
		}
		
		if($newpayname){
			$insert = "insert into payment_modules (pay_mod_name,pay_mod_active,pay_mod_cd,pay_mod_default) values ('$newpayname','$_POST[newpaynamestatus]',now(),'$_POST[default]')";
			mysql_query($insert);
		}
		
		set_response_mes(1,$admin_language['changesmodified']);
		url_redirect(DOCROOT."admin/module/");
	}
	$payid = $_GET['sub1']; 
	if($payid){
		$delete = "delete from payment_modules where pay_mod_id='".$payid."'";
		mysql_query($delete) or die(mysql_error());
		set_response_mes(1,$admin_language['changesmodified']);
		url_redirect(DOCROOT."admin/module/");
	}
	
	//get the general site information
	$query1 = "SELECT * FROM modules LIMIT 0,1";
	$result_set = mysql_query($query1);

	if(mysql_num_rows($result_set))
	{
		$row = mysql_fetch_array($result_set);
	}
?>
  
        <form name="module_settings" id="module_settings" action="" enctype="multipart/form-data" method="post" class="ml10">

                  <input type="hidden" name="id" value="<?php echo $row["id"];?>" />
		 
		 
		  <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['general_module']; ?></legend>
		 <p>
              <label for="dummy0"><?php echo $admin_language['featureddeal']; ?></label><br>
			  <input type="radio" name="featured_deals" value="1" <?php if($row["featured_deals"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="featured_deals" value="0" <?php if($row["featured_deals"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>

		
		 <p>
              <label for="dummy0"><?php echo $admin_language['newsletter']; ?></label><br>
			  <input type="radio" name="newsletter" value="1" <?php if($row["newsletter"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="newsletter" value="0" <?php if($row["newsletter"] == 0) { ?> checked="checked" <?php } ?> /><?php echo $admin_language['no']; ?>
			  


         </p>

			
		 <p>
              <label for="dummy0"><?php echo $admin_language['category']; ?></label><br>
			  <input type="radio" name="category" value="1" <?php if($row["category"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="category" value="0" <?php if($row["category"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>

			
		 <p>
              <label for="dummy0"><?php echo $admin_language['fanpage']; ?></label><br>
			  <input type="radio" name="fanpage" value="1" <?php if($row["fanpage"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="fanpage" value="0" <?php if($row["fanpage"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>



			
		 <p>
              <label for="dummy0"><?php echo $admin_language['smtp']; ?></label><br>
			  <input type="radio" name="smtp" value="1" <?php if($row["smtp"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="smtp" value="0" <?php if($row["smtp"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>


			
		 <p>
              <label for="dummy0"><?php echo $admin_language['facebookconnect']; ?></label><br>
			  <input type="radio" name="facebook_connect" value="1" <?php if($row["facebook_connect"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="facebook_connect" value="0" <?php if($row["facebook_connect"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>

		
		 <p>
              <label for="dummy0"><?php echo $admin_language['twitterconnect']; ?></label><br>
			  <input type="radio" name="twitter_connect" value="1" <?php if($row["twitter_connect"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="twitter_connect" value="0" <?php if($row["twitter_connect"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>

		
		 <p>
              <label for="dummy0"><?php echo $admin_language['tweeteraroundcity']; ?></label><br>
			  <input type="radio" name="tweets_around_city" value="1" <?php if($row["tweets_around_city"] == 1) { ?> checked="checked" <?php } ?> /><?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="tweets_around_city" value="0" <?php if($row["tweets_around_city"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>

		
		 <p>
              <label for="dummy0"><?php echo $admin_language['mobilesubscribtion']; ?></label><br>
			  <input type="radio" name="mobile_subscribtion" value="1" <?php if($row["mobile_subscribtion"] == 1) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['yes']; ?>
			  &nbsp;
			  <input type="radio" name="mobile_subscribtion" value="0" <?php if($row["mobile_subscribtion"] == 0) { ?> checked="checked" <?php } ?> /> <?php echo $admin_language['no']; ?>
			  


         </p>
  </fieldset>


  	<br />
   <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['payment_module_settings']; ?></legend>
		 <p>
               
			   
			  <table width="100%"><tr><td width="15%"><label for="dummy0"><?php echo $admin_language['payment_module_status']; ?></label></td><td><label for="dummy0"><?php echo $admin_language['payment_module_name']; ?></label></td><td><label for="dummy0"><?php echo $admin_language['payment_module_default']; ?></label></td><td>&nbsp;</td></tr>
			  <div align="right"><a href="javascript:;" onclick="javascript: showmore();">Add more</a></div>
			    <?php
				$query2 = "SELECT * FROM payment_modules order by pay_mod_name asc";
				$result = mysql_query($query2);
				while($resultset = mysql_fetch_array($result)){ 
				?>
				<tr>
				<td><input type="checkbox" name="paystatus_<?php echo $resultset['pay_mod_id'];?>" value="1" <?php if($resultset['pay_mod_active']=='1'){ echo 'checked="checked"'; } ?>/></td>
				<td><input type="text" name="paymodule_<?php echo $resultset['pay_mod_id'];?>" value="<?php echo $resultset['pay_mod_name'];?>" maxlength="50" size="50"  /></td>
				<td><input type="radio" name="default" id="default" value="<?php echo $resultset['pay_mod_id'];?>"  <?php if($resultset['pay_mod_default']=='1'){ echo 'checked="checked"'; } ?> /></td>
				<td><a href="javascript:;" onclick="javascript: del('<?php echo $resultset['pay_mod_id'];?>');">Delete</a></td>
				<input type="hidden" name="payid[]" value="<?php echo $resultset['pay_mod_id'];?>"  />
				</tr>
				<?php } ?>
				 
				<tr id="morepaymodule">
				<td><input type="checkbox" name="newpaynamestatus" value="1" checked="checked" /></td>
				<td><input type="text" name="newpayname" value="<?php echo $resultset['pay_mod_name'];?>" maxlength="50" size="50"  /></td>
				<td><input type="radio" name="default" value="1"  /></td>
				<td>&nbsp;</td>
				</tr>
				</table>
				<div id="showmore" style="display:none;">&nbsp;</div>
   				 
         </p>
</fieldset>


<!-- end of all rows -->		 		
	   		<div class="fl clr">
              <input style="margin-left:13px;" type="submit" name="submit" value="<?php echo $admin_language['submit']; ?>" class="button_c">
            </div>

        
        </form>
		


