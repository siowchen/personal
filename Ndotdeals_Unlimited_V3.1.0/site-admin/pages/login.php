<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#login").validate();});
</script>

<?php



if($_POST)
{
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$adminlanguage = $_POST["admin_language"];
	$result = loginCheck($username,$password,$adminlanguage);
	
	// Include language file
        $admin_lang = $_SESSION["site_admin_language"];
		if($admin_lang)
		{
		include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
		}
		else
		{
		include(DOCUMENT_ROOT."/system/language/admin_en.php");
		}
		
	if($result == "Success")
	{

		set_response_mes(1,$admin_language['successfullylogged']);
		url_redirect(DOCROOT."admin/profile/");
	}
	else if($result == "Blocked")
	{
		set_response_mes(1,$admin_language['loginblocked']);
		url_redirect(DOCROOT."admin/login/");
	}	
	else
	{
		set_response_mes(-1,$admin_language['usernameorpasswordincorrect']);
		url_redirect(DOCROOT."admin/login/");	
	}
}
?>

<div class="form_out">
<div class="form">
<div class="form_top1"></div>

<div class="form_cent">
	  
<form action="" name="login" id="login" method="post">
<h1 class="font18" style="text-align:center;"><?php echo $admin_language['adminlogin']; ?></h1>
<table width="500" border="0" cellpadding="8" cellspacing="5" class="clr" align="center">

<tr>
<td align="right" valign="top" width="100"><label><?php echo $admin_language['login_username']; ?></label></td>
<td width="350"><input name="username" type="text" class="required" title="<?php echo $admin_language['enterusername']; ?>" />
</td>
</tr>
<tr>
<td align="right" valign="top"><label><?php echo $admin_language['password']; ?></label></td>
<td><input name="password" type="password" class="required" title="<?php echo $admin_language['enterpassword']; ?>" />
</td>
</tr>
<tr><td>&nbsp;</td>
<td>
<select name="admin_language" id="admin_language" class="language_select">
<?php foreach($admin_lang_list as $key => $value) { ?>
<option value="<?php echo $key;?>" <?php if($_SESSION["site_language"] == $key){ echo "selected";}?>><?php echo $value['lang'];?></option>
<?php } ?>
</select>
</td>
</tr>
<tr><td>&nbsp;</td>
<td><input type="submit" value="<?php echo $admin_language['login']; ?>" name="submit" /> &nbsp;
<input type="reset" value="<?php echo $admin_language['clear']; ?>" name="submit" />
</td>
</tr>
<tr><td colspan="2" align="center"><a href="<?php echo DOCROOT;?>admin/forgot" title="<?php echo $admin_language['forgotpassword']; ?>" class="color000 font12"><?php echo $admin_language['forgotpassword']; ?></a></td></tr>
</table>
</form>
     </div>
<div class="form_bot1"></div>
</div>
</div>
