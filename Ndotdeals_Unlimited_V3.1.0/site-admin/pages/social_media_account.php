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
	
    <!-- Open the facebook popup -->
	<script type="text/javascript">
	var win2;
	function fbconnect(docroot)
	{
	  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
	  checkChild();  	
	}
	
	function checkChild() 
	{
		  if (win2.closed) {
			window.location.reload(true);
		  } else setTimeout("checkChild()",1);
	}
	</script>
    
    <!-- Facebook Profile -->
    <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['facebook_account']; ?></legend>
        <?php 
		//get the facebook profile
		$facebook_profile = mysql_query("select * from social_account where type = '1' limit 0,1");
		if(mysql_num_rows($facebook_profile)>0)
		{
			while($row = mysql_fetch_array($facebook_profile))
			{
				?>
                	<table cellpadding="5" cellspacing="5">
                    <tr>
                    <td>
                    <img src="<?php echo $row["image_url"];?>" alt="<?php echo $row["first_name"];?>" title="<?php echo $row["first_name"];?>"/>
                    </td>
                    <td>
                    	<p><?php echo $row["first_name"];?></p>
                        <p><?php echo $row["email_id"];?> </p>
                        <p><?php echo $admin_language['updated_on']; ?><?php echo $row["cdate"];?></p>
                        <p><a href="<?php echo DOCROOT;?>system/modules/facebook/delete_account.php?acc_id=<?php echo $row['id'];?>" title="<?php echo $admin_language['remove_facebook_account']; ?>"><?php echo $admin_language['remove_facebook_account']; ?></a></p>
                    </td>
                    </tr>
                    </table>
                <?php 
			}
		}
		else
		{
		?>
	            <a href="javascript:;" onclick="fbconnect('<?php echo DOCROOT; ?>');" title="<?php echo $admin_language['add_facebook_account']; ?>"><?php echo $admin_language['add_facebook_account']; ?></a>
        <?php } ?>
	</fieldset>

	<!-- twitter account -->
    <fieldset class="field">         
        <legend class="legend"><?php echo $admin_language['twitter_account']; ?></legend> 
        <?php 
		//get the twitter profile
		$twitter_profile = mysql_query("select * from social_account where type = '2' limit 0,1");
		if(mysql_num_rows($twitter_profile)>0)
		{
			while($row = mysql_fetch_array($twitter_profile))
			{
				?>
                	<table cellpadding="5" cellspacing="5">
                    <tr>
                    <td>
                    <img src="<?php echo $row["image_url"];?>" alt="<?php echo $row["first_name"];?>" title="<?php echo $row["first_name"];?>"/>
                    </td>
                    <td>
                    	<p><?php echo $row["first_name"];?></p>
                        <p><?php echo $admin_language['updated_on']; ?><?php echo $row["cdate"];?></p>
                        <p><a href="<?php echo DOCROOT;?>system/modules/twitter/delete_account.php?acc_id=<?php echo $row['id'];?>" title="<?php echo $admin_language['remove_twitter_account']; ?>"><?php echo $admin_language['remove_twitter_account']; ?></a></p>
                    </td>
                    </tr>
                    </table>
                <?php 
			}
		}
		else
		{
		?>
		   <a href="<?php echo DOCROOT; ?>system/modules/twitter/index.php" title="<?php echo $admin_language['add_twitter_account']; ?>"><?php echo $admin_language['add_twitter_account']; ?></a>
        <?php } ?>
    
    </fieldset>
